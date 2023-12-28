<?php
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id === false) {
    echo "El ID del producto no es válido";
} else {
    // El valor de "id" es un número entero válido
    // Puedes utilizarlo en tu lógica de aplicación
    echo "El ID del producto es: " . $id;
}
