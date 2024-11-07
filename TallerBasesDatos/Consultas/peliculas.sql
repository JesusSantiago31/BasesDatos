-- Encuentra los títulos de las películas que nunca han sido alquiladas 
-- Averiguar que ID estan en la tabla
SELECT rental_id FROM rental WHERE rental_id ;

-- Inventario
SELECT film_id FROM inventory WHERE inventory_id IN ( SELECT inventory_id FROM rental WHERE rental_id );

-- FILM

SELECT title FROM film WHERE film_id NOT IN (SELECT film_id FROM inventory WHERE inventory_id IN ( SELECT inventory_id FROM rental WHERE rental_id ));