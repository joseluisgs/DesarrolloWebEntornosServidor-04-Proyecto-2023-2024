<?php

use config\Config;
use services\CategoriasService;
use services\ProductosService;
use services\SessionService;

// Para cargar las clases automáticamente
require_once 'vendor/autoload.php';

// Para las sesiones y configuración
require_once __DIR__ . '/services/SessionService.php';
require_once __DIR__ . '/services/CategoriasService.php';
require_once __DIR__ . '/config/Config.php';
require_once __DIR__ . '/models/Categoria.php';
require_once __DIR__ . '/services/ProductosService.php';
require_once __DIR__ . '/models/Producto.php';
$session = $sessionService = SessionService::getInstance();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Productos CRUD</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
          integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link href="/images/favicon.png" rel="icon" type="image/png">
</head>
<body>
<div class="container">
    <?php require_once 'header.php'; ?>

    <?php
    echo "<h1>{$session->getWelcomeMessage()}</h1>";
    $config = Config::getInstance();
    $categoriasService = new CategoriasService($config->db);
    $categorias = $categoriasService->findAll();

    // Hacer algo con la lista de objetos Categoria
    foreach ($categorias as $categoria) {
        echo $categoria->nombre . PHP_EOL;
    }

    echo "<br>";

    $productosService = new ProductosService($config->db);
    $productos = $productosService->findAllWithCategoryName();
    // Hacer algo con la lista de objetos Producto
    foreach ($productos as $producto) {
        echo $producto->marca . PHP_EOL;
    }

    ?>

    <p class="mt-4 text-center" style="font-size: smaller;">
        <span>Nº de visitas: <?php echo $session->getVisitCount(); ?></span>
        <?php
        if ($session->isLoggedIn()) {
            echo "<span>, desde el último login en: {$session->getLastLoginDate()}</span>";
        }
        ?>
    </p>


</div>

<?php
require_once 'footer.php';
?>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
        crossorigin="anonymous"></script>
</body>
</html>