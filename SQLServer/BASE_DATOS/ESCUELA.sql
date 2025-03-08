 
CREATE TABLE Maestros( -- Se crea la tabla maestros
	MaestroID INT PRIMARY KEY IDENTITY(1,1), -- Se les asigna una ID incrementable en 1 empezando del valor 1
	Nombre NVARCHAR(100) NOT NULL, -- Se crea un campo Nombre con espacio de 100 caracteres y no puede estar vacio
	Asignatura NVARCHAR(100) NOT NULL -- Se crea un campo Asignatura con espacio de 100 caracteres y no puede estar vacio
);
GO

CREATE TABLE Alumnos( -- Se crea la tabla Alumnos
	AlumnoID INT PRIMARY KEY IDENTITY(1,1), -- Se les asigna una ID incrementable en 1 empezando del valor 1
	Nombre NVARCHAR(100) NOT NULL -- Se crea un campo Nombre con espacio de 100 caracteres y no puede estar vacio
);

CREATE TABLE Calificaciones(
	CalificacionID INT PRIMARY KEY IDENTITY(1,1), -- Se les asigna una ID incrementable en 1 empezando del valor 1
	AlumnoID INT, -- Se coloca la Primaty Key de la tabla alumnos para referenciarla mas adelante
	MaestroID INT, -- Se coloca la Primaty Key de la tabla maestros para referenciarla mas adelante
	Nota DECIMAL (5,2), -- Se crea el campo Nota con formato decimal que acepta 5 numeros enteros y dos numeros despues del punto
	FOREIGN KEY (AlumnoID) REFERENCES Alumnos (AlumnoID), -- Se referencia el campo AlumnoID de esta tabla con el campo de la tabla Alumnos
	FOREIGN KEY (MaestroID) REFERENCES Maestros (MaestroID), -- Se referencia el campo MaestrID de esta tabla con el campo de la tabla Maestros

);

GO
--Crear la tabla intermediaria para la relación muchos a muchos
CREATE TABLE MaestroAlumno(
	MaestroID INT, -- Se coloca la Primaty Key de la tabla alumnos para referenciarla mas adelante
	AlumnoID INT, -- Se coloca la Primaty Key de la tabla alumnos para referenciarla mas adelante
	PRIMARY KEY (MaestroID, AlumnoID), --Se asigna como PRIMARY KEY a MaestroID y AlumnoID de las tablas Mestro y Alumno
	FOREIGN KEY (MaestroID) REFERENCES Maestros(MaestroID), -- Se referencia MaestrosID con la tabla de Maestros
	FOREIGN KEY (AlumnoID) REFERENCES Alumnos(AlumnoID) -- Se referencia el campo AlumnosID con AlumnosID de la tabla Alumnos
);