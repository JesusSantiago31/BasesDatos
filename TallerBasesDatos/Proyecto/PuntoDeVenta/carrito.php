<?php
session_start();

// Verificar si el carrito no está vacío
if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) {
    $productos_en_carrito = $_SESSION['carrito'];
    $total = 0;
    foreach ($productos_en_carrito as &$item) {
        if (isset($item['producto'])) {  // Verificar que el producto existe
            $producto = $item['producto'];
            $cantidad = $item['cantidad'];
            $subtotal = $producto['precio'] * $cantidad;
            $item['subtotal'] = $subtotal;
            $total += $subtotal;
        }
    }
} else {
    echo "Tu carrito está vacío.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="css/style_carrito.css">
</head>
<body>
    <header>
        <nav>
            <ul class="menu">
                <li><a href="#">Novedades</a></li>
                <li><a href="#">Colección</a></li>
                <li><a href="#">Rebajas</a></li>
                <li><a href="#">Stories</a></li>
                <li><a href="productos.php">Volver a la tienda</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h1>Tu Carrito</h1>
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos_en_carrito as $item): ?>
                    <tr>
                        <?php if (isset($item['producto'])): ?>
                            <td><?php echo htmlspecialchars($item['producto']['nombre_producto']); ?></td>
                            <td><?php echo $item['cantidad']; ?></td>
                            <td>$<?php echo number_format($item['producto']['precio'], 2); ?></td>
                            <td>$<?php echo number_format($item['subtotal'], 2); ?></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3>Total: $<?php echo number_format($total, 2); ?></h3>

        <!-- Formulario para finalizar la compra -->
        <form action="finalizar_compra.php" method="POST">
            <button type="submit">Finalizar Compra</button>
        </form>

        <!-- Botón para seguir comprando -->
        <a href="perfil_cliente.php"><button>Seguir Comprando</button></a>
    </div>
</body>
</html>
