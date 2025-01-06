
-- 3. Obtener el stock disponible de un producto
DELIMITER //
CREATE FUNCTION ObtenerStockDisponible(
    p_id_producto INT -- ID del producto a consultar
) RETURNS INT -- Tipo de retorno: cantidad de stock
BEGIN
    DECLARE stock INT; -- Variable para almacenar el stock del producto

    -- Obtener el stock del producto especificado
    SELECT stock INTO stock
    FROM productos
    WHERE id_producto = p_id_producto; -- Filtrar por ID del producto

    RETURN stock; -- Devolver la cantidad de stock disponible
END //
DELIMITER ;

CREATE DEFINER=`root`@`localhost` FUNCTION `ObtenerFechaRegistro` (`p_id_cliente` INT) RETURNS DATE  BEGIN
    DECLARE fecha_registro DATE; -- Variable para almacenar la fecha de registro

    -- Obtener la fecha de registro del cliente especificado
    SELECT fecha_registro INTO fecha_registro
    FROM clientes
    WHERE id_cliente = p_id_cliente; -- Filtrar por ID del cliente

    RETURN fecha_registro; -- Devolver la fecha de registro del cliente
END$$

