<?php

namespace services;


use Exception;
use models\User;
use PDO;

require_once __DIR__ . '/../models/User.php';

class UsersService
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }


    public function authenticate($username, $password): User
    {
        // Aquí iría la lógica para verificar el nombre de usuario y la contraseña
        // Por ejemplo, buscar en la base de datos y comparar la contraseña con Bcrypt
        // Supongamos que ya tienes una función que verifica las contraseñas bcrypt

        // Ejemplo de búsqueda de usuario y verificación de contraseña
        $user = $this->findUserByUsername($username);
        if ($user && password_verify($password, $user->password)) {
            return $user;
        }
        // lanza una excepción si no se encuentra el usuario o la contraseña no es válida
        throw new Exception('Usuario o contraseña no válidos');
    }

    public function findUserByUsername($username)
    {
        // Buscar el usuario por username
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $userRow = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$userRow) {
            return null; // o manejar como prefieras el caso de usuario no encontrado
        }

        // Buscar los roles del usuario
        $stmtRoles = $this->db->prepare("SELECT roles FROM user_roles WHERE user_id = :user_id");
        $stmtRoles->bindParam(':user_id', $userRow['id']);
        $stmtRoles->execute();
        $roles = $stmtRoles->fetchAll(PDO::FETCH_COLUMN);

        // Crear y devolver el objeto User
        return new User(
            $userRow['id'],
            $userRow['username'],
            $userRow['password'],
            $userRow['nombre'],
            $userRow['apellidos'],
            $userRow['email'],
            $userRow['created_at'],
            $userRow['updated_at'],
            $userRow['is_deleted'],
            $roles
        );
    }
}
