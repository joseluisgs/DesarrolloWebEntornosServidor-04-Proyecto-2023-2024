<?php


use config\Config;
use services\SessionService;
use services\UsersService;


require_once 'vendor/autoload.php';

require_once __DIR__ . '/services/SessionService.php';
require_once __DIR__ . '/services/UsersService.php';
require_once __DIR__ . '/config/Config.php';

$session = SessionService::getInstance();
$config = Config::getInstance();

$error = '';
$usersService = new UsersService($config->db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar y limpiar la entrada
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    // Verificar que la entrada no esté vacía después de la limpieza
    if (!$username || !$password) {
        $error = 'Usuario/a o contraseña inválidos.';
    } else {
        try {
            $user = $usersService->authenticate($username, $password);
            if ($user) {
                $isAdmin = in_array('ADMIN', $user->roles);
                $session->login($user->username, $isAdmin);
                header('Location: index.php');
                exit;
            } else {
                // Si la autenticación falla, establecer un mensaje de error genérico
                $error = 'Usuario/a o contraseña inválidos.';
            }
        } catch (Exception $e) {
            // Manejar la excepción sin revelar detalles sensibles
            $error = 'Error en el sistema. Por favor intente más tarde.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
          integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link href="/images/favicon.png" rel="icon" type="image/png">
</head>
<body>
<div class="container" style="width: 50%; margin-left: auto; margin-right: auto;">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="/">
            <img alt="Logo" class="d-inline-block align-text-top" height="30" src="/images/favicon.png" width="30">
            Mis productos CRUD 2º DAW
        </a>
    </nav>
    <h1>Login</h1>
    <form action="login.php" method="post">
        <div class="form-group">
            <label for="username">Username:</label>
            <input class="form-control" id="username" name="username" required type="username">
            <label for="password">Password:</label>
            <input class="form-control" id="password" name="password" required type="password">
        </div>
        <?php if ($error): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <button class="btn btn-primary" type="submit">Login</button>
    </form>
</div>

<!-- Incluir el fragmento del footer -->
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