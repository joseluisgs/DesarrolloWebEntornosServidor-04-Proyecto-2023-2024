<?php

use services\SessionService;

require_once __DIR__ . '/services/SessionService.php';
$session = SessionService::getInstance();
$username = $session->isLoggedIn() ? $session->getUserName() : 'Invitado';
?>

<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">
            <img alt="Logo" class="d-inline-block align-text-top" height="30" src="/images/favicon.png" width="30">
            Mis productos CRUD 2º DAW
        </a>
        <button aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler"
                data-target="#navbarNav" data-toggle="collapse" type="button">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link"
                    <?php
                    if ($session->isLoggedIn()) {
                        echo 'href="logout.php">Logout';
                    } else {
                        echo 'href="login.php">Login';
                    }
                    ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Productos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="create.php">Nuevo Producto</a>
                </li>
                <!-- Otras opciones de menú -->
            </ul>
            <ul class="navbar-nav ml-auto"> <!-- Agregamos esta línea -->
                <li class="nav-item">
                    <span class="navbar-text">
                        <?php echo htmlspecialchars($username); ?>
                    </span>
                </li>
            </ul>
        </div>
    </nav>
</header>

