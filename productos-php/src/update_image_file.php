<?php

use config\Config;
use services\ProductosService;

require_once 'vendor/autoload.php';

require_once __DIR__ . '/config/Config.php';
require_once __DIR__ . '/services/ProductosService.php';
require_once __DIR__ . '/models/Producto.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $config = Config::getInstance();

        $id = $_POST['id']; // Asegúrate de validar y limpiar esta entrada
        $uploadDir = $config->uploadPath;

        $archivo = $_FILES['imagen'];

        $nombre = $archivo['name'];
        $tipo = $archivo['type'];
        $tmpPath = $archivo['tmp_name'];
        $error = $archivo['error'];

        // Verificar el tipo y la extensión del archivo
        $allowedTypes = ['image/jpeg', 'image/png'];
        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $detectedType = finfo_file($fileInfo, $tmpPath);
        $extension = strtolower(pathinfo($nombre, PATHINFO_EXTENSION));

        if (in_array($detectedType, $allowedTypes) && in_array($extension, $allowedExtensions)) {
            // Buscamos el producto por id

            $productosService = new ProductosService($config->db);
            $producto = $productosService->findById($id);
            if ($producto === null) {
                header('Location: index.php');
                exit;
            }

            // Creamos el nuevo nombre de la imagen
            $newName = $producto->uuid . '.' . $extension;

            // Movemos el archivo a la carpeta de destino
            move_uploaded_file($tmpPath, $uploadDir . $newName);

            // Actualizamos la imagen del producto
            $producto->imagen = $config->uploadUrl . $newName;

            // Actualizamos el producto
            $productosService->update($producto);


            // Redirigir a la página de detalles del producto
            header('Location: update-image.php?id=' . $id);
            exit;
        }
        header('Location: index.php');
        exit;
    }
} else {
    header('Location: index.php');
    exit;
}
