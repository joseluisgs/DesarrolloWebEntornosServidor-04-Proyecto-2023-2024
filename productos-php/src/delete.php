<?php

use config\Config;
use models\Producto;
use services\ProductosService;

require_once 'vendor/autoload.php';

require_once __DIR__ . '/config/Config.php';
require_once __DIR__ . '/services/ProductosService.php';
require_once __DIR__ . '/models/Producto.php';


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
        //$productosService->deleteById($id);
        if ($producto->imagen !== Producto::$IMAGEN_DEFAULT) {
            // Obtenemos la ruta de la imagen
            $rutaImagen = $config->uploadPath . $producto->imagen;
            // Borramos la imagen
            unlink($rutaImagen);
        }
        // borramos el producto
        $productosService->deleteById($id);
        header('Location: index.php');
    }
}
