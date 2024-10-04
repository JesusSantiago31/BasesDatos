

CREATE TABLE Empleados (
    id_empleado INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL
);

CREATE TABLE Productos (
    id_productos INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL CHECK (precio > 0)
);

CREATE TABLE Ventas (
    id_venta INT AUTO_INCREMENT PRIMARY KEY,
    id_empleado INT,
    id_productos INT,
    cantidad INT NOT NULL CHECK (cantidad > 0),
    fecha DATE NOT NULL CHECK (fecha <= CURRENT_DATE), 
		 
    FOREIGN KEY (id_empleado) REFERENCES 
		empleados(id_empleado) ON UPDATE
		CASCADE ON DELETE RESTRICT,
		
    FOREIGN KEY (id_productos) REFERENCES
		 productos(id_productos) ON UPDATE
		 CASCADE ON DELETE RESTRICT
);
