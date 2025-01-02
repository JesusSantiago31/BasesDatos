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

-- Tabla de Ventas
CREATE TABLE ventas (
    id_venta INT AUTO_INCREMENT PRIMARY KEY,        -- Identificador único
    id_cliente INT,                                 -- Identificador enlazado al cliente
    fecha_venta DATE NOT NULL,                      -- Fecha obligatoria, con valor por defecto actual
    total DECIMAL(10,2) NOT NULL,                   -- Total de la venta obligatoria
    descuento DECIMAL(10,2) DEFAULT '0.00',			-- Descuento inicializado en 0
    
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente) ON UPDATE CASCADE 
    ON DELETE RESTRICT,
    
    -- Restricciones adicionales
    CONSTRAINT chk_total CHECK (total >= 0)         -- Total de ventas no negativo
    
);

-- Tabla de Tarjeta de Puntos
CREATE TABLE tarjeta_puntos (
    id_tarjeta INT AUTO_INCREMENT PRIMARY KEY,      -- Identificador unico
    id_cliente INT UNIQUE,                                 -- Identificador enlazado al cliente
    puntos_acumulados INT DEFAULT 0 NOT NULL,       -- Puntos acumulados inicializados en 0
    fecha_ultima_actualizacion DATE,                -- Fecha de actualizacion de puntos
    
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente) ON UPDATE CASCADE 
    ON DELETE RESTRICT,
    
    -- Restricciones
    CONSTRAINT chk_puntos_acumulados CHECK (puntos_acumulados >= 0) -- Verifica que los puntos sean mayor a 0
);