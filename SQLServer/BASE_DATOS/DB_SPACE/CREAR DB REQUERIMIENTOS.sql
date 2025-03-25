-- Crear una base de datos mediante código

CREATE DATABASE TESJI2
ON (
	NAME = TESJI2, -- Nombre de la base de datos
	FILENAME = 'C:\BASE_SQL\TESJI2.mdf',-- Nombre del archivo .mdf
	SIZE = 10MB, -- Tamaño inicial de la BD
	MAXSIZE = 100MB, -- Tamaño maximo de la BD
	FILEGROWTH = 5MB
)

LOG ON(
	NAME = TESJI2_log, 
	FILENAME = 'C:\BASE_SQL\TESJI2_LOG.ldf',
	SIZE = 5MB,
	MAXSIZE = 50MB,
	FILEGROWTH = 1MB
);
