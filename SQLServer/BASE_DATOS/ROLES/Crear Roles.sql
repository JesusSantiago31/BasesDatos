-- Crear usuarios en SQL SERVER

-- Crear los inicios de sesión 
CREATE LOGIN Log_abril WITH PASSWORD = '123456'
CREATE LOGIN Log_fabiola WITH PASSWORD = '123456'
CREATE LOGIN Log_vanessa WITH PASSWORD = '123456'

-- Cambia 'NombreDeLaBaseDeDatos' al nombre de la base de datos
-- USE ESCUELA;

-- Crear los usuarios en la base de datose
CREATE USER Uabril FOR LOGIN Log_abril;
CREATE USER Ufabiola FOR LOGIN Log_fabiola;
CREATE USER Uvanessa FOR LOGIN Log_vanessa;

-- Asignar permisos 
-- Usuario con permiso de lectura
ALTER ROLE db_datareader ADD MEMBER Uabril;

-- Usuario con permiso de escritura
ALTER ROLE db_datawriter ADD MEMBER Ufabiola;

-- Usuario con todos los permisos
ALTER ROLE db_owner ADD MEMBER Uvanessa;