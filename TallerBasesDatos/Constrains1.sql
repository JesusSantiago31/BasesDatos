CREATE TABLE Empleados(
id_cliente INT PRIMARY KEY AUTO_INCREMENT,
nombre VARCHAR(100) NOT NULL,
apellido VARCHAR(100) NOT NULL,
apellido2 VARCHAR(100) NOT NULL,
email VARCHAR(100),
sueldo INT CHECK(sueldo > 3000 & sueldo < 50000)

);


