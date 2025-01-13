<?php
include 'db.php'; // Incluir archivo de conexión a la base de datos

// Iniciar la sesión para poder almacenar el carrito
session_start();

// Si el carrito no está inicializado, lo inicializamos
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Obtener los productos desde la base de datos
$stmt = $pdo->query("SELECT id_producto, nombre_producto, categoria_producto, precio, stock, imagen FROM productos");
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Función para agregar al carrito
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['producto'])) {
    $producto = $_POST['producto'];
    // Verificar si el producto ya está en el carrito
    $existe = false;
    foreach ($_SESSION['carrito'] as &$item) {
        if ($item['id_producto'] == $producto['id_producto']) {
            $item['cantidad'] += $producto['cantidad'];
            $existe = true;
            break;
        }
    }
    // Si el producto no está en el carrito, lo agregamos
    if (!$existe) {
        $producto['cantidad'] = $_POST['cantidad'];
        $_SESSION['carrito'][] = $producto;
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tienda - Productos</title>
    <link rel="stylesheet" href="css/style_vendida.css">
</head>
<body>
    <header>
        <nav>
            <ul class="menu">
                <li><a href="#">Novedades</a></li>
                <li><a href="#">Colección</a></li>
                <li><a href="#">Rebajas</a></li>
                <li><a href="#">Stories</a></li>
                <li><a href="carrito.php">Ver Carrito</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <aside class="sidebar">
            <h3>Filtrar</h3>
            <form>
                <h4>Tipología</h4>
                <label><input type="radio" name="tipo" value="todos" checked> Todos</label><br>
                <label><input type="radio" name="tipo" value="especiales"> Precios especiales</label><br>
            </form>
        </aside>

        <main class="products">
            <?php foreach ($productos as $producto): ?>
                <div class="product">
                    <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre_producto']); ?>">
                    <h4><?php echo htmlspecialchars($producto['nombre_producto']); ?></h4>
                    <p>Precio: $<?php echo number_format($producto['precio'], 2); ?></p>
                    <p>Stock: <?php echo $producto['stock']; ?> unidades</p>

                    <form action="agregar_producto.php" method="POST">
                        <input type="hidden" name="producto[id_producto]" value="<?php echo $producto['id_producto']; ?>">
                        <input type="hidden" name="producto[nombre_producto]" value="<?php echo $producto['nombre_producto']; ?>">
                        <input type="hidden" name="producto[precio]" value="<?php echo $producto['precio']; ?>">
                        <input type="hidden" name="producto[imagen]" value="<?php echo $producto['imagen']; ?>">

                        <label for="cantidad">Cantidad:</label>
                        <input type="number" name="cantidad" value="1" min="1" required>
                        <button type="submit">Añadir al carrito</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </main>
    </div>
</body>
</html>
