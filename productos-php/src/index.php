<?php

// Para las sesiones
use config\Config;
use services\SessionService;

require_once __DIR__ . '/services/SessionService.php';

$session = SessionService::getInstance();

// Para las configuraciones


require_once __DIR__ . '/config/Config.php';

$config = Config::getInstance();

echo $config->getPostgresDb();
echo $config->getPostgresUser();
echo $config->getPostgresPassword();
echo $config->getPostgresHost();
echo $config->getPostgresPort();


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

    // Comprobar si el usuario está logueado
    if ($session->isLoggedIn()) {
        echo "El usuario está logueado.";
    } else {
        echo "El usuario no está logueado.";
    }

    // Comprobar si el usuario es administrador
    if ($session->isAdmin()) {
        echo "El usuario es administrador.";
    } else {
        echo "El usuario no es administrador.";
    }

    // Obtener el número de visitas
    $visitCount = $session->getVisitCount();
    echo "Número de visitas: " . $visitCount;

    // Borrar la sesión
    $session->clear();
    ?>

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