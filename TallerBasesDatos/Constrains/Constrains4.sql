CREATE TABLE Pedidos (
    id_pedido INT AUTO_INCREMENT PRIMARY KEY,
    cantidad_productos INT NOT NULL CHECK (cantidad_productos >= 1),
    total DECIMAL(10, 2) NOT NULL,
    CHECK (total >= cantidad_productos * 10)
);
