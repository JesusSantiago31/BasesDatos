-- Crear una base de datos mediante código

CREATE DATABASE ESCUELA
ON (
	NAME = ESCUELA, -- Nombre de la base de datos
	FILENAME = 'C:\BASE_SQL\ESCUELA.mdf',-- Nombre del archivo .mdf
	SIZE = 10MB, -- Tamaño inicial de la BD
	MAXSIZE = 100MB, -- Tamaño maximo de la BD
	FILEGROWTH = 5MB
)

LOG ON(
	NAME = ESCUELA_log, 
	FILENAME = 'C:\BASE_SQL\ESCUELA_LOG.ldf',
	SIZE = 5MB,
	MAXSIZE = 50MB,
	FILEGROWTH = 1MB
);
