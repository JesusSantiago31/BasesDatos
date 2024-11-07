-- EXAMEN UNIDAD 1
-- TALLER DE BASE DE DATOS
-- Jesus Silvestre Santiago Cruz
-- FECHA: 24/09/24

-- Se crea la base de datos examen_ddl_produtos
CREATE DATABASE examen_ddl_productos;
-- Hcemos uso de la base de datos
USE examen_ddl_productos;

-- Creacion de la tabla Productos 
CREATE TABLE Productos (
-- Se agregan los correspondientes atributos 
id_producto INT PRIMARY KEY  AUTO_INCREMENT,
nombre_producto VARCHAR(100) NOT NULL UNIQUE,
precio DECIMAL(10,2) NOT NULL CHECK(precio > 0),
stock INT NOT NULL

);

-- Se crea la tabla Ventas
CREATE TABLE Ventas (
-- Se agregan los atributos
id_venta INT PRIMARY KEY  AUTO_INCREMENT,
id_producto INT,
cantidad INT CHECK(cantidad > 0 ),
fecha_venta DATE DEFAULT(NOW()),

FOREIGN KEY (id_producto) REFERENCES
Productos (id_producto) ON UPDATE
CASCADE ON DELETE RESTRICT

);

-- 1.- Agregar la columna " descripcion " en la tabla Productos
ALTER TABLE Productos ADD COLUMN descripcion VARCHAR(100);

-- 2.- Eliminar la columna "stock" de la tabla Productos
ALTER TABLE Productos DROP COLUMN stock;

-- 3.- Eliminar la tabla Ventas
DROP TABLE Ventas;


