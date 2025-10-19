# Uso de JOINS

En SQL, un JOIN es una cláusula que se utiliza para combinar filas de dos o más tablas en una sola consulta, relacionándolas a través de una columna en común (por ejemplo, una clave primaria y una clave foránea).

# Tipos de JOIN en SQL

### INNER JOIN (Unión Interna)

La UNIÓN INTERNA combina filas de dos tablas basándose en un atributo común y devuelve solo las filas coincidentes en ambas tablas . Es la operación de UNIÓN más utilizada, ya que garantiza que solo los datos relacionados de ambas tablas se incluyan en el conjunto de resultados

#### SQL sintaxis
```sql
SELECT columns_from_both_tables
FROM table1
INNER JOIN table2
ON table1.column1 = table2.column2
```

#### Ejemplo
```sql
SELECT f.title, c.name AS category_name
  FROM film AS f
  INNER JOIN film_category AS fc
  ON f.film_id = fc.film_id
  INNER JOIN category AS c
  ON fc.category_id = c.category_id
  WHERE c.name = "Comedy";
```

### FULL OUTTER JOIN (Union Externa Completa )

La UNIÓN EXTERNA COMPLETA combina filas de ambas tablas y devuelve todos los registros cuando hay una coincidencia en cualquiera de ellas. Incluye filas con valores coincidentes y filas no coincidentes de ambas tablas, lo que garantiza que no se pierdan datos por la ausencia de un atributo común.

#### SQL Sintaxis
```sql
SELECT columns
FROM table1
FULL OUTER JOIN table2
ON table1.column1 = table2.column2;
```

#### Ejemplo
```sql
SELECT Customers.customer_id, Customers.name, Orders.order_id, Orders.spend
FROM Customers
FULL OUTER JOIN Orders
ON Customers.customer_id = Orders.customer_id;
```

### LEFT JOIN
LEFT JOIN devuelve todas las filas de la tabla izquierda y las filas coincidentes de la tabla derecha . Si no existen coincidencias, el resultado es NULL de la tabla derecha. Esto garantiza que se incluyan todos los datos de la tabla izquierda, independientemente de las coincidencias.

#### SQL Sintaxis
```sql
SELECT columns_from_both_tables
FROM table1
LEFT JOIN table2
ON table1.column1 = table2.column2
```

#### Ejemplo
```sql
SELECT Customers.customer_id, Customers.name, Orders.order_id, Orders.spend
FROM Customers
LEFT JOIN Orders
ON Customers.customer_id = Orders.customer_id;
```