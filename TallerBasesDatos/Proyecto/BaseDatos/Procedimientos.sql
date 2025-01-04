
CREATE PROCEDURE RegistrarVentaCompleta(
    IN p_id_cliente INT, -- ID del cliente que realiza la compra
    IN p_fecha DATE, -- Fecha de la venta
    IN p_total DECIMAL(10,2), -- Total de la venta
    IN p_detalles JSON, -- Detalles de los productos en formato JSON
    OUT nueva_venta_id INT -- ID de la nueva venta generada
)
BEGIN
    -- Manejar excepciones SQL, se ejecuta si ocurre un error
    DECLARE EXIT HANDLER FOR SQLEXCEPTION 
    BEGIN
        ROLLBACK; -- Revertir cambios en caso de error
        SIGNAL SQLSTATE '45000' -- Generar un error personalizado
        SET MESSAGE_TEXT = 'Error al registrar la venta completa.';
    END;

    START TRANSACTION; -- Iniciar la transacción

    -- Insertar la venta en la tabla 'ventas'
    INSERT INTO ventas (id_cliente, fecha_venta, total)
    VALUES (p_id_cliente, p_fecha, p_total);
    SET nueva_venta_id = LAST_INSERT_ID(); -- Obtener el ID de la nueva venta

    -- Procesar los detalles de la venta
    DECLARE done INT DEFAULT FALSE; -- Variable de control para el bucle
    DECLARE producto_id INT; -- Variable para almacenar el ID del producto
    DECLARE cantidad INT; -- Variable para almacenar la cantidad del producto
    DECLARE precio DECIMAL(10,2); -- Variable para almacenar el precio del producto
    -- Cursor para recorrer los detalles del JSON
    DECLARE cur CURSOR FOR SELECT * FROM JSON_TABLE(
        p_detalles, '$[*]' -- Seleccionar cada elemento del JSON
        COLUMNS(
            id_producto INT PATH '$.id_producto', -- Obtener ID del producto
            cantidad INT PATH '$.cantidad', -- Obtener cantidad del producto
            precio DECIMAL(10,2) PATH '$.precio' -- Obtener precio del producto
        )
    );
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE; -- Manejar fin del cursor

    OPEN cur; -- Abrir el cursor
    detalles_loop: LOOP -- Iniciar bucle para procesar detalles
        FETCH cur INTO producto_id, cantidad, precio; -- Obtener datos del cursor
        IF done THEN -- Verificar si no hay más datos
            LEAVE detalles_loop; -- Salir del bucle
        END IF;

        -- Insertar el detalle de la venta en la tabla 'detalle_ventas'
        INSERT INTO detalle_ventas (id_venta, id_producto, cantidad, subtotal)
        VALUES (nueva_venta_id, producto_id, cantidad, precio * cantidad);

        -- Actualizar el stock del producto
        UPDATE productos
        SET stock = stock - cantidad
        WHERE id_producto = producto_id; -- Restar la cantidad del stock
    END LOOP;
    CLOSE cur; -- Cerrar el cursor

    COMMIT; -- Confirmar la transacción
END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE ActualizarPrecioProducto(
    IN p_id_producto INT, -- ID del producto a actualizar
    IN p_nuevo_precio DECIMAL(10,2) -- Nuevo precio del producto
)
BEGIN
    -- Manejar excepciones SQL
    DECLARE EXIT HANDLER FOR SQLEXCEPTION 
    BEGIN
        SIGNAL SQLSTATE '45000' -- Generar un error personalizado
        SET MESSAGE_TEXT = 'Error al actualizar el precio del producto.';
    END;

    -- Actualizar el precio del producto en la tabla 'productos'
    UPDATE productos
    SET precio = p_nuevo_precio
    WHERE id_producto = p_id_producto; -- Filtrar por ID del producto
END //
DELIMITER ;


-- 3. Consultar inventario bajo mínimos
DELIMITER //
CREATE PROCEDURE ConsultarInventarioBajo(
    IN p_min_stock INT -- Cantidad mínima de stock para consultar
)
BEGIN
    -- Manejar excepciones SQL
    DECLARE EXIT HANDLER FOR SQLEXCEPTION 
    BEGIN
        SIGNAL SQLSTATE '45000' -- Generar un error personalizado
        SET MESSAGE_TEXT = 'Error al consultar el inventario bajo.';
    END;

    -- Consultar productos con stock igual o inferior al mínimo
    SELECT id_producto, nombre_producto, stock
    FROM productos
    WHERE stock <= p_min_stock; -- Filtrar productos por stock
END //
DELIMITER ;
