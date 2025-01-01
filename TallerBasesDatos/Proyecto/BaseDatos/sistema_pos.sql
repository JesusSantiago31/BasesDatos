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
