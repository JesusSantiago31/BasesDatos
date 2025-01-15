<?php
include 'db.php';

// Verificar si se pasa un ID de venta
if (!isset($_GET['id'])) {
    echo "ID de venta no especificado.";
    exit;
}

// Obtener los datos de la venta
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM ventas WHERE id_venta = ?");
$stmt->execute([$id]);
$venta = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$venta) {
    echo "Venta no encontrada.";
    exit;
}

// Obtener los clientes para el formulario
$stmt = $pdo->query("SELECT id_cliente, nombre FROM clientes");
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Si el formulario es enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_cliente = $_POST['id_cliente'];
    $fecha_venta = $_POST['fecha_venta'];
    $total = $_POST['total'];

    // Actualizar la venta
    $stmt = $pdo->prepare("UPDATE ventas SET id_cliente = ?, fecha_venta = ?, total = ? WHERE id_venta = ?");
    $stmt->execute([$id_cliente, $fecha_venta, $total, $id]);

    header("Location: ventas.php?success=Venta actualizada correctamente");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Venta</title>
    <link rel="stylesheet" href="css/style_ventas.css"> <!-- Enlazamos el archivo CSS -->
</head>
<body>
    <div class="container">
        <h1>Editar Venta</h1>
        <form method="POST" action="editar_venta.php?id=<?php echo $venta['id_venta']; ?>">
            <label for="id_cliente">Cliente:</label>
            <select name="id_cliente" required>
                <?php foreach ($clientes as $cliente): ?>
                    <option value="<?php echo $cliente['id_cliente']; ?>" <?php echo $cliente['id_cliente'] == $venta['id_cliente'] ? 'selected' : ''; ?>><?php echo $cliente['nombre']; ?></option>
                <?php endforeach; ?>
            </select><br>

            <label for="fecha_venta">Fecha de Venta:</label>
            <input type="date" name="fecha_venta" value="<?php echo $venta['fecha_venta']; ?>" required><br>

            <label for="total">Total:</label>
            <input type="number" step="0.01" name="total" value="<?php echo $venta['total']; ?>" required><br>

            <button type="submit">Actualizar Venta</button>
        </form>

        <a href="ventas.php"><button>Volver a la lista de ventas</button></a>
    </div>
</body>
</html>
