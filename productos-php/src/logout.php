<?php

use services\SessionService;

require_once __DIR__ . '/services/SessionService.php';

$session = SessionService::getInstance();
$session->logout();
header('Location: index.php');