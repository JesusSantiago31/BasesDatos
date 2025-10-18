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