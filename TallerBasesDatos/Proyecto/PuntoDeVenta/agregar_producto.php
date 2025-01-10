<?php
session_start();

// Verifica si la variable 'producto' está presente en la solicitud
if (isset($_POST['producto'])) {
    $producto = $_POST['producto'];  // Producto enviado desde el formulario
    $cantidad = isset($_POST['cantidad']) ? (int)$_POST['cantidad'] : 1;

    // Si el carrito no existe en la sesión, creamos un carrito vacío
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    // Comprobar si el producto ya está en el carrito
    $producto_existe = false;
    foreach ($_SESSION['carrito'] as &$item) {
        if ($item['producto']['id_producto'] == $producto['id_producto']) {
            $item['cantidad'] += $cantidad;  // Si el producto existe, aumentamos la cantidad
            $producto_existe = true;
            break;
        }
    }

    // Si el producto no existe, lo agregamos al carrito
    if (!$producto_existe) {
        $_SESSION['carrito'][] = [
            'producto' => $producto,
            'cantidad' => $cantidad
        ];
    }

    // Redirigir al carrito para mostrar los productos agregados
    header('Location: carrito.php');
    exit;
}
?>
