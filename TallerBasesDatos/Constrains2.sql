CREATE TABLE Empleados (
numero_de_empleado INT PRIMARY KEY AUTO_INCREMENT,
nombre VARCHAR(255),
FOREIGN KEY (nombre) REFERENCES departamentos(nombre)
);

CREATE TABLE Departamentos (
id_departamento INT PRIMARY KEY AUTO_INCREMENT,
nombre VARCHAR(255) UNIQUE NOT NULL
);
