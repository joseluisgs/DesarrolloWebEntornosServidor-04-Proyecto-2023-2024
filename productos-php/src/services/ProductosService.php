<?php

namespace services;

use models\Producto;
use PDO;
use Ramsey\Uuid\Uuid;


require_once __DIR__ . '/../models/Producto.php';

class ProductosService
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAllWithCategoryName($searchTerm = null)
    {
        $sql = "SELECT p.*, c.nombre AS categoria_nombre
        FROM productos p
        LEFT JOIN categorias c ON p.categoria_id = c.id";


        if ($searchTerm) {
            $searchTerm = '%' . strtolower($searchTerm) . '%'; // Convertir el término de búsqueda a minúsculas
            $sql .= " WHERE LOWER(p.marca) LIKE :searchTerm OR LOWER(p.modelo) LIKE :searchTerm";
        }

        $sql .= " ORDER BY p.id ASC";

        $stmt = $this->pdo->prepare($sql);

        if ($searchTerm) {
            // Vincula el mismo término de búsqueda a los dos parámetros de búsqueda
            $stmt->bindValue(':searchTerm', $searchTerm, PDO::PARAM_STR);
        }

        $stmt->execute();

        $productos = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $producto = new Producto(
                $row['id'],
                $row['uuid'],
                $row['descripcion'],
                $row['imagen'],
                $row['marca'],
                $row['modelo'],
                $row['precio'],
                $row['stock'],
                $row['created_at'],
                $row['updated_at'],
                $row['categoria_id'],
                $row['categoria_nombre'], // Pasamos el nombre de la categoría
                $row['is_deleted']
            );
            $productos[] = $producto;
        }
        return $productos;
    }

    public function findById($id)
    {
        $sql = "SELECT p.*, c.nombre AS categoria_nombre
            FROM productos p
            LEFT JOIN categorias c ON p.categoria_id = c.id
            WHERE p.id = :id"; // Filtrar por ID

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT); // Vincular el ID como un entero
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null; // Si no se encuentra el producto, devolver null
        }

        // Crear y devolver un objeto Producto con los datos obtenidos
        $producto = new Producto(
            $row['id'],
            $row['uuid'],
            $row['descripcion'],
            $row['imagen'],
            $row['marca'],
            $row['modelo'],
            $row['precio'],
            $row['stock'],
            $row['created_at'],
            $row['updated_at'],
            $row['categoria_id'],
            $row['categoria_nombre'], // Pasamos el nombre de la categoría
            $row['is_deleted']
        );

        return $producto;
    }

    public function deleteById($id)
    {
        $sql = "DELETE FROM productos WHERE id = :id"; // Consulta SQL para eliminar

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT); // Vincular el ID como un entero

        return $stmt->execute(); // Ejecutar la consulta y devolver el resultado
    }

    public function update(Producto $producto)
    {
        $sql = "UPDATE productos SET
            descripcion = :descripcion,
            imagen = :imagen,
            marca = :marca,
            modelo = :modelo,
            precio = :precio,
            stock = :stock,
            categoria_id = :categoria_id,
            updated_at = :updated_at
            WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':descripcion', $producto->descripcion, PDO::PARAM_STR);
        $stmt->bindValue(':imagen', $producto->imagen, PDO::PARAM_STR);
        $stmt->bindValue(':marca', $producto->marca, PDO::PARAM_STR);
        $stmt->bindValue(':modelo', $producto->modelo, PDO::PARAM_STR);
        $stmt->bindValue(':precio', $producto->precio, PDO::PARAM_STR);
        $stmt->bindValue(':stock', $producto->stock, PDO::PARAM_INT);
        $stmt->bindValue(':categoria_id', $producto->categoriaId, PDO::PARAM_INT);
        $producto->updatedAt = date('Y-m-d H:i:s');
        $stmt->bindValue(':updated_at', $producto->updatedAt, PDO::PARAM_STR);
        $stmt->bindValue(':id', $producto->id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function save(Producto $producto)
    {
        $sql = "INSERT INTO productos (uuid, descripcion, imagen, marca, modelo, precio, stock, categoria_id, created_at, updated_at)
            VALUES (:uuid, :descripcion, :imagen, :marca, :modelo, :precio, :stock, :categoria_id, :created_at, :updated_at)";

        $stmt = $this->pdo->prepare($sql);

        $producto->uuid = Uuid::uuid4()->toString(); //uniqid(); // Generar un ID único
        $stmt->bindValue(':uuid', $producto->uuid, PDO::PARAM_STR);
        $stmt->bindValue(':descripcion', $producto->descripcion, PDO::PARAM_STR);
        $producto->imagen = Producto::$IMAGEN_DEFAULT;
        $stmt->bindValue(':imagen', $producto->imagen, PDO::PARAM_STR);
        $stmt->bindValue(':marca', $producto->marca, PDO::PARAM_STR);
        $stmt->bindValue(':modelo', $producto->modelo, PDO::PARAM_STR);
        $stmt->bindValue(':precio', $producto->precio, PDO::PARAM_STR);
        $stmt->bindValue(':stock', $producto->stock, PDO::PARAM_INT);
        $stmt->bindValue(':categoria_id', $producto->categoriaId, PDO::PARAM_INT);
        $producto->createdAt = date('Y-m-d H:i:s');
        $stmt->bindValue(':created_at', $producto->createdAt, PDO::PARAM_STR);
        $producto->updatedAt = date('Y-m-d H:i:s');
        $stmt->bindValue(':updated_at', $producto->updatedAt, PDO::PARAM_STR);

        return $stmt->execute();
    }
}
