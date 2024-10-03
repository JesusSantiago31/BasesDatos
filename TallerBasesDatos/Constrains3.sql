CREATE TABLE Productos (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) UNIQUE NOT NULL,
    codigo_barras VARCHAR(255) NOT NULL,
    precio DECIMAL(10, 2) CHECK (precio > 0) NOT NULL,
    stock INT DEFAULT 100 NOT NULL
); 

