<?php


use config\Config;
use services\ProductosService;
use services\SessionService;

require_once 'vendor/autoload.php';

require_once __DIR__ . '/services/SessionService.php';
require_once __DIR__ . '/config/Config.php';
require_once __DIR__ . '/services/ProductosService.php';
require_once __DIR__ . '/models/Producto.php';

// Solo se puede modificar si en la sesión el usuario es admin
$session = SessionService::getInstance();
if (!$session->isAdmin()) {
    // No enviar ninguna salida antes de este bloque de código
    echo "<script type='text/javascript'>
            alert('No tienes permisos para modificar un producto');
            window.location.href = 'index.php';
          </script>";
    exit;
}


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
    $producto = $productosService->findById($id);
    if ($producto === null) {
        echo "<script type='text/javascript'>
                alert('No existe el producto');
                window.location.href = 'index.php';
                </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Producto</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
          integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link href="/images/favicon.png" rel="icon" type="image/png">
</head>
<body>
<div class="container">
    <?php require_once 'header.php'; ?>

    <h1>Actualizar Imagen Producto</h1>

    <dl class="row">
        <dt class="col-sm-2">ID:</dt>
        <dd class="col-sm-10"><?php echo htmlspecialchars($producto->id); ?></dd>
        <dt class="col-sm-2">Marca:</dt>
        <dd class="col-sm-10"><?php echo htmlspecialchars($producto->marca); ?></dd>
        <dt class="col-sm-2">Modelo:</dt>
        <dd class="col-sm-10"><?php echo htmlspecialchars($producto->modelo); ?></dd>
        <dt class="col-sm-2">Imagen:</dt>
        <dd class="col-sm-10"><img alt="Producto Image" class="img-fluid"
                                   src="<?php echo htmlspecialchars($producto->imagen); ?>"></dd>
    </dl>

    <form action="update_image_file.php" enctype="multipart/form-data" method="post">
        <div class="form-group">
            <label for="imagen">Imagen:</label>
            <input accept="image/*" class="form-control-file" id="imagen" name="imagen" required type="file">
            <small class="text-danger"></small>
            <input name="id" value="<?php echo $id; ?>" type="hidden">
        </div>

        <button class="btn btn-primary" type="submit">Actualizar</button>
        <a class="btn btn-secondary mx-2" href="index.php">Volver</a>
    </form>

</div>

<?php require_once 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
        crossorigin="anonymous"></script>
</body>
</html>