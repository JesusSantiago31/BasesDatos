<?php
include 'db.php';

// Obtener todas las ventas
$stmt = $pdo->query("SELECT v.id_venta, v.fecha_venta, v.total, c.nombre FROM ventas v
                     JOIN clientes c ON v.id_cliente = c.id_cliente");
$ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Contar el número total de ventas
$totalVentas = count($ventas);

// Obtener el mensaje desde la URL
$mensaje = isset($_GET['mensaje']) ? $_GET['mensaje'] : '';
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Ventas</title>
    <link rel="stylesheet" href="css/style_ventas.css"> <!-- Enlazamos el archivo CSS -->
</head>
<body>
    <div class="container">
        <h1>Lista de Ventas</h1>

        <!-- Mostrar el mensaje si existe -->
        <?php if ($mensaje): ?>
            <div class="mensaje">
                <?php echo htmlspecialchars($mensaje); ?>
            </div>
        <?php endif; ?>

        <div class="tabla-contenedor">
            <table>
                <thead>
                    <tr>
                        <th>ID Venta</th>
                        <th>Cliente</th>
                        <th>Fecha Venta</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $counter = 0;  // Contador para limitar a 10 registros
                    foreach ($ventas as $venta): 
                        if ($counter < 10): // Mostrar solo los primeros 10 registros
                            $counter++; // Incrementar el contador
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($venta['id_venta']); ?></td>
                            <td><?php echo htmlspecialchars($venta['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($venta['fecha_venta']); ?></td>
                            <td><?php echo htmlspecialchars($venta['total']); ?></td>
                            <td>
                                <a href="editar_venta.php?id=<?php echo $venta['id_venta']; ?>">Editar</a> |
                                <a href="eliminar_venta.php?id=<?php echo $venta['id_venta']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar esta venta?');">Eliminar</a>
                            </td>
                        </tr>
                    <?php 
                    endif;
                    endforeach; 
                    ?>
                </tbody>
            </table>
        </div>



        <div class="acciones">
            <a href="agregar_venta.php">
                <button class="btn-agregar">Agregar Nueva Venta</button>
            </a>
            <a href="dasboard.php">
                <button class="btn-regresar">Regresar</button>
            </a>
        </div>
    </div>
</body>
</html>