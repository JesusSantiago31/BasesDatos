# Operaciones CRUD en MySQL

Las operaciones *CRUD* son un conjunto de 4 operaciones fundamentales, en el manejo de bases de datos y aplicaciones web. CRUD es un acrónimo que representa las siguiente operaciones:
- **C**REATE    (Crear)
- **R**EAD      (Leer)
- **U**pdate    (Actualizar)
- **D**elete    (Eliminar)

**Primero creamos una tabla:** 
```sql

CREATE TABLE Usuarios(
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(100) UNIQUE NOT NULL CHECK(email "%_@_%._%"),
    password VARCHAR(15) NOT NULL CHECK(LENGTH(password) >=8 )
)

```

## Create 
La operacion *crear* es responsable de crear nueos datos en la base de datos en lenguaje SQL, esto se realiza con la sentencia `INSERT INTO` y en el caso de MySQL `INSERT` también funciona. El propósito de la operación es añadir el nuevo resgistro a una tabla 
```sql 

-- Ejemplo de una insersión valida usando todos los campos 
INSERT INTO Usuarios VALUES (1, "ejemplo@mail.com", "12345678");

-- Ejemplo de una insersión valida usando el comando DEFAULT
INSERT INTO Usuarios VALUES (DEFAULT, "ejemplo2@gmail.com", "abcdefgh");

-- Ejemplo de una insersión sin incluir un ** id_usuario **
INSERT Usuario(email, password) VALUES ("email3@hotmail.com", "12345678");
```

### Ejercicios 
- Identifica los tipos de errores que pueden salir en esta tabla

- Inserta 4 registros nuevos en un solo INSERT

## Read 
La operacion *leer* es utilizada para consultar o recuperar datos de la base de datos. Esto no modifica los datos, simplemente los extrae. En MySQL est operación se realiza con la sentencia select

```sql

-- Ejmeplo de una consulta para todos lo datos de una tabla
SELECT * FROM Usuarios;
 
 -- Ejemplo de consulta para un registro en especifico a través del id_usuario
SELECT * FROM Usuarios WHERE id_usuario=1;

-- Ejemplo de consulta para un rgeistro con un email en específico
SELECT * FROM Usuarios WHERE email="ejemplo@mail.com";

-- Ejemplo de consulta con solo los campos email y password
SELECT email,password FROM Usuarios;

-- Ejemplo de consulta con un condicional lógico
SELECT * FROM Usuarios WHERE LENGTH(password)>9;

```
### Ejercicio
- Realiza una consulta que solo muestre el id, pero que coincida con una constraseña de mas de 8 caracteres y otra que realice una consulta a los id´s pares 

## Update
La operación *actualizar* se utiliza para modificar registros existentes en la base de datos. Esto se hace con la sentencia `UPDATE`
```sql
-- Ejmeplo para actualizar la contraseña por su id
UPDATE Usuario SET password = "a1b2c3d4" WHERE id_usuario = 1;

-- Ejemplo para actualizar el email y password de un usaurio en específico
UPDATE Usuario SET password = "a1b2c3d4", email = "luciohdz3012@gmail.com" WHERE id_usuario = 1;
```
### Ejercicio 
- Intenta actualizar registros con valores que violen las restricciones (minimo 3)

## Delete
La operacón *elimianr* se usa para borrar registros de la base de datos. Esto se realiza con la sentEncia `DELETE`.  **Debemos ser muy cuidadosos con esta operación, ya que una vez que los datos son eliminados, NO pueden ser RECUPERADOS**

```sql
-- Eliminar el usuario por el id
DELETE FROM Usuarios WHERE id_usuario = 4;
-- Eliminar los usuarios con el email específico 
DELETE FROM Usuarios WHERE email="luciohdz3012@gmail.com" ;
```
### Eercicios 
- Eliminar usuarios cuyo email contenga 1 o mas "5"
- Eliminar usuarios que tengan una contraseña que contengan letras mayusculas usando expresiones regulares (REGEX)
- Elminar usuarios con contraseña que contengan solo numeros 
- Eliminar usuarios con correos que no contengan el dominio "gmail"