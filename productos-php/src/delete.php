<?php

use config\Config;
use models\Producto;
use services\ProductosService;
use services\SessionService;

require_once 'vendor/autoload.php';

require_once __DIR__ . '/config/Config.php';
require_once __DIR__ . '/services/ProductosService.php';
require_once __DIR__ . '/models/Producto.php';
require_once __DIR__ . '/services/SessionService.php';

// Solo se puede borrar si en la sesión el usuario es admin
$session = SessionService::getInstance();
if (!$session->isAdmin()) {
    // No enviar ninguna salida antes de este bloque de código
    echo "<script type='text/javascript'>
            alert('No tienes permisos para eliminar un producto');
            window.location.href = 'index.php';
          </script>";
    exit;
}


$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$producto = null;

if ($id === false) {
    header('Location: index.php');
    exit;
} else {
    // El valor de "id" es un número entero válido
    // Puedes utilizarlo en tu lógica de aplicación
    $config = Config::getInstance();
    $productosService = new ProductosService($config->db);
    // Debemos borrar la imagen si existe antes de borrar el producto
    $producto = $productosService->findById($id);
    if ($producto) {
        if ($producto->imagen !== Producto::$IMAGEN_DEFAULT) {
            $imageUrl = $producto->imagen; // http://localhost:8080/uploads/imagen.jpg
            $basePath = $config->uploadPath; // /var/www/html/public/uploads/
            $imagePathInUrl = parse_url($imageUrl, PHP_URL_PATH); // /uploads/imagen.jpg
            $imageFile = basename($imagePathInUrl); // imagen.jpg
            $imageFilePath = $basePath . $imageFile; // /var/www/html/public/uploads/imagen.jpg
            // Borramos la imagen
            // Verificar si el archivo existe y luego borrarlo
            if (file_exists($imageFilePath)) {
                unlink($imageFilePath);
            }
        }
        $productosService->deleteById($id);
        echo "<script type='text/javascript'>
                alert('Producto eliminado correctamente');
                window.location.href = 'index.php';
                </script>";
    }
}
