<?php

use controllers\SessionController;

require_once __DIR__ . '/../controllers/SessionController.php';
$session = SessionController::getInstance();
?>

<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="/">
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
                        echo 'href="/views/logout.php">Logout';
                    } else {
                        echo 'href="/views/login.php">Login';
                    }
                    ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../index.php">Productos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/views/create.php">Nuevo Producto</a>
                </li>
                <!-- Otras opciones de menú -->
            </ul>
        </div>
    </nav>
</header>