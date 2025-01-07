
-- 1. Trigger para actualizar la tarjeta de puntos al registrar una venta

DELIMITER //
CREATE TRIGGER ActualizarTarjetaPuntos
AFTER INSERT ON detalle_ventas -- Se activa después de insertar un detalle de venta
FOR EACH ROW
BEGIN
    DECLARE puntos INT; -- Variable para almacenar los puntos a actualizar

    -- Calcular puntos ganados por la venta
    SET puntos = FLOOR(NEW.subtotal / 10); -- 1 punto por cada 10 del subtotal

    -- Actualizar los puntos acumulados en la tarjeta del cliente
    UPDATE tarjeta_puntos
    SET puntos_acumulados = puntos_acumulados + puntos, -- Incrementar puntos
        fecha_ultima_actualizacion = CURRENT_DATE -- Actualizar fecha de última modificación
    WHERE id_cliente = (SELECT id_cliente FROM ventas WHERE id_venta = NEW.id_venta); -- Filtrar por cliente de la venta
END //
DELIMITER ;


-- 2. Trigger para restablecer puntos acumulados a cero al aplicar descuento
DELIMITER //
CREATE TRIGGER RestablecerPuntosTrasDescuento
BEFORE UPDATE ON tarjeta_puntos -- Se activa antes de actualizar la tarjeta de puntos
FOR EACH ROW
BEGIN
    -- Verificar si se están usando puntos para aplicar descuento
    IF NEW.puntos_acumulados = 0 AND OLD.puntos_acumulados > 0 THEN
        SET NEW.puntos_acumulados = 0; -- Restablecer puntos a cero
    END IF;
END //
DELIMITER ;

DELIMITER //
CREATE TRIGGER VerificarTarjetaPuntosAntesDeInsertar
BEFORE INSERT ON tarjeta_puntos -- Se activa antes de insertar en la tabla tarjeta_puntos
FOR EACH ROW
BEGIN
    DECLARE existe INT; -- Variable para verificar la existencia

    -- Verificar si ya existe una tarjeta de puntos para el cliente
    SELECT COUNT(*) INTO existe
    FROM tarjeta_puntos
    WHERE id_cliente = NEW.id_cliente; -- Filtrar por ID del cliente de la nueva tarjeta

    -- Si existe, generar un error y evitar la inserción
    IF existe > 0 THEN
        SIGNAL SQLSTATE '45000' -- Generar un error personalizado
        SET MESSAGE_TEXT = 'El cliente ya tiene una tarjeta de puntos.';
    END IF;
END //

DELIMITER ;