CREATE TABLE Paciente(
id_paciente INT PRIMARY KEY AUTO_INCREMENT,
nombre_paciente VARCHAR(255) NOT NULL,
apellido1 VARCHAR(255) NOT NULL,
apellido2 VARCHAR(255) NOT NULL,
sexo VARCHAR(255) NOT NULL,
fecha_nacimiento DATE,
telefono INT NOT NULL
);

CREATE TABLE Medico(
id_medico INT PRIMARY KEY AUTO_INCREMENT,
nombre_medico VARCHAR(255) NOT NULL,
apellido1 VARCHAR(255) NOT NULL,
apellido2 VARCHAR(255) NOT NULL
);

CREATE TABLE Especialidad(
id_especialidad INT PRIMARY KEY AUTO_INCREMENT,
nombre VARCHAR(255) NOT NULL
);

CREATE TABLE Medico_especialidad(
id_medico INT,
id_especialidad INT,
PRIMARY KEY (id_medico, id_especialidad),
FOREIGN KEY (id_medico) REFERENCES medico(id_medico)ON UPDATE CASCADE ON DELETE RESTRICT,
FOREIGN KEY (id_especialidad) REFERENCES especialidad(id_especialidad)ON UPDATE CASCADE ON DELETE RESTRICT
);

CREATE TABLE Sucursal(
id_sucursal INT PRIMARY KEY AUTO_INCREMENT,
nombre VARCHAR(255) NOT NULL,
calle VARCHAR(255) NOT NULL,
colonia VARCHAR(255) NOT NULL,
municipio VARCHAR(255) NOT NULL,
ciudad VARCHAR(255) NOT NULL,
CP INT NOT NULL
);

CREATE TABLE Cita(
id_cita INT PRIMARY KEY AUTO_INCREMENT,
id_sucursal INT NOT NULL,
FOREIGN KEY (id_sucursal) REFERENCES sucursal(id_sucursal)ON UPDATE CASCADE ON DELETE RESTRICT,
id_paciente INT NOT NULL,
FOREIGN KEY (id_paciente) REFERENCES paciente(id_paciente)ON UPDATE CASCADE ON DELETE RESTRICT,
id_medico INT NOT NULL,
FOREIGN KEY (id_medico) REFERENCES medico(id_medico)ON UPDATE CASCADE ON DELETE RESTRICT,
fecha_cita DATE NOT NULL,
hora_cita TIME
);



