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

    public function findAllWithCategoryName()
    {
        $stmt = $this->pdo->prepare("
            SELECT p.*, c.nombre AS categoria_nombre
            FROM productos p
            LEFT JOIN categorias c ON p.categoria_id = c.id
            oRDER BY p.id ASC
        ");
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
}
