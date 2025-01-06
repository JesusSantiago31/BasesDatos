
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
