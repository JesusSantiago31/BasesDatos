
-SELECT AVG (LENGTH(first_name)) FROM actor;

-- Seleccionar actores con longitud de 'first_name' mayor al promedio

SELECT  * FROM actor WHERE LENGTH(first_name) > (SELECT AVG(LENGTH(first_name)) FROM actor);

-- Enceuntra los actores que han participado en películas de la categoría comedy
	-- Hechos por separado
SELECT category_id FROM category WHERE name = "Comedy";
SELECT film_id FROM film_category WHERE category_id = 5;
	
	-- Uniendo ambas QUERY
SELECT film_id FROM film_category WHERE category_id = (SELECT category_id FROM category WHERE name = "Comedy");	

	-- Para listas hacemos uso del IN y del NOT IN 
SELECT  actor_id FROM film_actor WHERE film_id IN (7,28,99);

	-- Uniendo QUERY
SELECT  actor_id FROM film_actor WHERE film_id IN (SELECT film_id FROM film_category WHERE category_id = (SELECT category_id FROM category WHERE name = "Comedy"));

	-- Haciendo el último SELECT
	SELECT first_name, last_name FROM actor WHERE actor_id IN (SELECT  actor_id FROM film_actor WHERE film_id IN (SELECT film_id FROM film_category WHERE category_id = (SELECT category_id FROM category WHERE name = "Comedy")));

