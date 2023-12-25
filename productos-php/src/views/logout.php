<?php

use controllers\SessionController;

require_once __DIR__ . '/../controllers/SessionController.php';

$session = SessionController::getInstance();
$session->logout();
header('Location: ../index.php');