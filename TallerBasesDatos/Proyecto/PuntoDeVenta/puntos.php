<?php
include 'db.php'; // Conexión a la base de datos

// Inicializar variables para mensajes
$mensaje = '';
$tipo_mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['agregar_tarjeta'])) {
        $id_cliente = $_POST['id_cliente'];

        // Validar que el ID no sea negativo
        if ($id_cliente < 0) {
            $mensaje = "El ID del cliente no puede ser un valor negativo.";
            $tipo_mensaje = 'error';
        } else {
            // Verificar si el cliente existe en la base de datos
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM clientes WHERE id_cliente = ?");
            $stmt->execute([$id_cliente]);
            $cliente_existe = $stmt->fetchColumn();

            if ($cliente_existe == 0) {
                // El cliente no existe
                $mensaje = "El cliente con ID $id_cliente no existe en la base de datos.";
                $tipo_mensaje = 'error';
            } else {
                // Intentar agregar la tarjeta
                try {
                    $stmt = $pdo->prepare("INSERT INTO tarjeta_puntos (id_cliente, puntos_acumulados, fecha_ultima_actualizacion) 
                                           VALUES (?, 0, NOW())");
                    $stmt->execute([$id_cliente]);

                    // Redirigir con mensaje de éxito
                    header("Location: puntos.php?mensaje=" . urlencode("Tarjeta de puntos agregada correctamente") . "&tipo_mensaje=exito");
                    exit;
                } catch (PDOException $e) {
                    if ($e->getCode() === '45000') {
                        $mensaje = "El cliente ya tiene una tarjeta de puntos.";
                        $tipo_mensaje = 'error';
                    } else {
                        $mensaje = "Error al agregar la tarjeta de puntos: " . htmlspecialchars($e->getMessage());
                        $tipo_mensaje = 'error';
                    }
                }
            }
        }
    }
}

// Obtener todas las tarjetas de puntos
$stmt = $pdo->query("SELECT t.id_tarjeta, t.id_cliente, t.puntos_acumulados, t.fecha_ultima_actualizacion, c.nombre 
                     FROM tarjeta_puntos t
                     JOIN clientes c ON t.id_cliente = c.id_cliente");
$tarjetas_puntos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Tarjetas de Puntos</title>
    <link rel="stylesheet" href="css/style_puntos.css">
</head>
<body>
    <div class="container">
        <h1>Tarjetas de Puntos</h1>

        <!-- Mostrar el mensaje si existe -->
        <?php if ($mensaje): ?>
            <div class="mensaje <?php echo "mensaje-" . htmlspecialchars($tipo_mensaje); ?>">
                <?php echo htmlspecialchars($mensaje); ?>
            </div>
        <?php endif; ?>

        <!-- Formulario para agregar una nueva tarjeta -->
        <h2>Agregar Nueva Tarjeta de Puntos</h2>
        <form action="puntos.php" method="POST">
            <label for="id_cliente">ID Cliente:</label>
            <input type="number" name="id_cliente" required>
            <button type="submit" name="agregar_tarjeta">Agregar Tarjeta</button>
        </form>

        <br>

        <!-- Mostrar las tarjetas de puntos -->
        <table>
            <thead>
                <tr>
                    <th>ID Tarjeta</th>
                    <th>Cliente</th>
                    <th>Puntos Acumulados</th>
                    <th>Fecha de Última Actualización</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tarjetas_puntos as $tarjeta): ?>
                <tr>
                    <td><?php echo htmlspecialchars($tarjeta['id_tarjeta']); ?></td>
                    <td><?php echo htmlspecialchars($tarjeta['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($tarjeta['puntos_acumulados']); ?></td>
                    <td><?php echo htmlspecialchars($tarjeta['fecha_ultima_actualizacion']); ?></td>
                    <td>
                        <form action="puntos.php" method="POST">
                            <input type="hidden" name="id_tarjeta" value="<?php echo $tarjeta['id_tarjeta']; ?>">
                            <input type="number" name="nuevos_puntos" value="<?php echo $tarjeta['puntos_acumulados']; ?>" min="0" required>
                            <button type="submit" name="actualizar_puntos">Actualizar</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="dashboard.php">
            <button>Regresar</button>
        </a>
    </div>
</body>
</html>
