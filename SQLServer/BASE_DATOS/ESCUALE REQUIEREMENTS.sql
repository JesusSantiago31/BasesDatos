-- Crear una base de datos mediante c�digo

CREATE DATABASE ESCUELA
ON (
	NAME = ESCUELA, -- Nombre de la base de datos
	FILENAME = 'C:\BASE_SQL\ESCUELA.mdf',-- Nombre del archivo .mdf
	SIZE = 10MB, -- Tama�o inicial de la BD
	MAXSIZE = 100MB, -- Tama�o maximo de la BD
	FILEGROWTH = 5MB
)

LOG ON(
	NAME = ESCUELA_log, 
	FILENAME = 'C:\BASE_SQL\ESCUELA_LOG.ldf',
	SIZE = 5MB,
	MAXSIZE = 50MB,
	FILEGROWTH = 1MB
);
