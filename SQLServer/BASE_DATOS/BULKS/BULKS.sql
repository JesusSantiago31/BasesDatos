-- Pasar tablas de Archios de Excel a una Base de Datos 
CREATE TABLE autos(
	Marca VARCHAR(20),
	Modelo VARCHAR(20),
	Tipo VARCHAR(20),
	Color VARCHAR(20)
);

-- Crear el bulk
BULK INSERT autos -- tabla destino
FROM 'C:\Carros3.txt' -- Ruta de la ubicacion de archivo 
WITH (FIRSTROW=2); -- Inicie en la segunda línea excluyendo el encabezado

SELECT * FROM autos;