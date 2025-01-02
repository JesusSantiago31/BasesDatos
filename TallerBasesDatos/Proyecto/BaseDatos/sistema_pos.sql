-- 1.- Creacion y uso de la base de datos
CREATE DATABASE IF NOT EXISTS sistema_pos;
-- 2.- usar l base de datos creada 
USE sistema_pos;

-- Tabla de Clientes
CREATE TABLE clientes (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,  -- Identificador uico
    nombre VARCHAR(100) NOT NULL,               -- Nombre del cliente 
    correo VARCHAR(100) UNIQUE,                 -- Correo Unico para cada cliente
    fecha_registro DATE NOT NULL,                        -- Fecha de registro del cliente 
    numero_compras INT DEFAULT 0 NOT NULL,      -- Numero de compras inicializada en 0
    
    CONSTRAINT chk_correo CHECK (correo LIKE '%_@__%.__%'), -- Constrain para verificar el formato de e-mail
    CONSTRAINT chk_nombre CHECK (CHAR_LENGTH(nombre) >= 3)  -- Constrain para la longitud del nombre
 
);

-- Tabla de Productos
CREATE TABLE productos (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,     -- Identificador unico
    nombre_producto VARCHAR(100) NOT NULL UNIQUE,   -- Nombre del producto
    categoria_producto varchar(50) NOT NULL,
    precio DECIMAL(10,2) NOT NULL,                  -- Precio del producto
    stock INT NOT NULL DEFAULT 0,                   -- Stock del producto
    imagen VARCHAR(255) NOT NULL,					-- Imagen del producto
         
    CONSTRAINT chk_precio CHECK (precio > 0),       -- Costrain para verificar que el recio del producto sea mayor a 0
    CONSTRAINT chk_stock CHECK (stock >= 0)         -- Constrain para verificar que el stock del producto sea mayor a 0
);