
 /*										TIPO DE DATO (Fecha y Hora)
 |-------------------------------------------------------------------------------------------------------------------|
 | 				   |		  Rango Inicial			|		   Rango Final				|	Bytes de Almacenamiento  |
 |-------------------------------------------------------------------------------------------------------------------|
 |      datetime   |    01 de enero de 1753         |     31 de diciembre de 9999		|			8 bytes			 |
 |-------------------------------------------------------------------------------------------------------------------|
 |   smalldatetime |    01 de enero de 1900         |      06 de junio de 2079		    |           4 bytes          |
 |-------------------------------------------------------------------------------------------------------------------|
 
 * separadores:        /      -       .

 * Establecer el orden:   set dateformat

 * set dateformat mdy 
 */

if object_id('empleados') is not null 
	drop table empleados;

create table empleados( 
	nombre varchar(20), 
	documento char(8),
	fechaingreso datetime);

go
-- Seteamos el formato de la fecha para que guarde día, mes y año:
set dateformat dmy;

insert into empleados values('Ana Gomez','22222222','12-01-1980');
insert into empleados values('Bernardo Huerta','23333333','15-03-81');
insert into empleados values('Carla Juarez','24444444','20/05/1983');
insert into empleados values('Daniel Lopez','25555555','2.5.1990');
insert into empleados values('Daniel Lopez','25555555','12.15.1990');

-- Note que el formato de visualización es "y-m-d".
select * from empleados;

-- Mostramos los datos de los empleados cuya fecha de ingreso es anterior a '01-01-1985':
select * from empleados where fechaingreso<'01-01-1985';
-- Actualizamos el nombre a "Maria Carla Juarez' 
-- del empleado cuya fecha de ingreso es igual a '20/05/1983':
update empleados set nombre='Maria Carla Juarez' where fechaingreso='20.5.83';
select * from empleados;
-- Borramos los empleados cuya fecha de ingreso es distinta a '20.5.83':
delete from empleados where fechaingreso<>'20/05/1983';
select * from empleados;