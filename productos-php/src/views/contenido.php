<?php


use controllers\SessionController;

require_once __DIR__ . '/../controllers/SessionController.php';

$session = SessionController::getInstance();

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