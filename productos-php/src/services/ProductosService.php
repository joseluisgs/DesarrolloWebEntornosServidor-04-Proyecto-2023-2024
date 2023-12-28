<?php

namespace services;

use models\Producto;
use PDO;


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
}
