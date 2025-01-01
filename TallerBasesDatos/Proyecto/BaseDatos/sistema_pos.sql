-- 1.- Creacion y uso de la base de datos
CREATE DATABASE IF NOT EXISTS sistema_pos;
USE sistema_pos;

-- TABLAS PRINCIPALES
-- Tabla de Clientes
CREATE TABLE clientes (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY, 
    nombre VARCHAR(100) NOT NULL, 
    correo VARCHAR(100) UNIQUE, 
    fecha_registro DATE 
);

-- Tabla de Productos
CREATE TABLE productos (
    id_producto INT AUTO_INCREMENT PRIMARY KEY, 
    nombre_producto VARCHAR(100) NOT NULL,
    precio DECIMAL(10,2) NOT NULL, 
    stock INT DEFAULT 0 
);

-- Tabla de Ventas
CREATE TABLE ventas (
    id_venta INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT,
    fecha_venta DATE, 
    total DECIMAL(10,2), 
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente)
);

-- Tabla de Tarjeta de Puntos
CREATE TABLE tarjeta_puntos (
    id_tarjeta INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT,
    puntos_acumulados INT DEFAULT 0, 
    fecha_ultima_actualizacion DATE,
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente)
);

-- Tabla de Historial de Cambios
CREATE TABLE historial_cambios (
    id_cambio INT AUTO_INCREMENT PRIMARY KEY, 
    id_cliente INT, 
    columna_modificada VARCHAR(50), 
    valor_anterior VARCHAR(100), 
    valor_nuevo VARCHAR(100),
    fecha_cambio DATE,
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente)
);

drop table historial_cambios;
