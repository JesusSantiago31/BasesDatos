CREATE TABLE administrator(
  id_administrator INT PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(30) NOT NULL,
  password VARCHAR(30) NOT NULL
);
CREATE TABLE store(
  id_store INT PRIMARY KEY AUTO_INCREMENT,
  id_administrator INT,
  name varchar(100) NOT NULL,
  status varchar(30) NOT NULL,
  FOREIGN KEY(id_administrator) REFERENCES administrator(id_administrator) ON UPDATE CASCADE ON DELETE RESTRICT
);
CREATE TABLE user(
  id_user INT PRIMARY KEY AUTO_INCREMENT,
  id_store INT,
  username VARCHAR(100) NOT NULL,
  password VARCHAR(30) NOT NULL,
  status int NOT NULL,
  FOREIGN KEY(id_store) REFERENCES store(id_store) ON UPDATE CASCADE ON DELETE RESTRICT
);
CREATE TABLE client(
  id_client INT PRIMARY KEY AUTO_INCREMENT,
  phone VARCHAR(30) NOT NULL,
  password VARCHAR(30) NOT NULL,
  status int NOT NULL
);

CREATE TABLE card_points(
  id_card INT PRIMARY KEY AUTO_INCREMENT,
  id_client INT,
  id_store INT,
  points DOUBLE NOT NULL,
  last_update DATE NOT NULL,
  status int NOT NULL,
  FOREIGN KEY(id_client) REFERENCES client(id_client) ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY(id_store) REFERENCES store(id_store) ON UPDATE CASCADE ON DELETE RESTRICT
);
CREATE TABLE transaction(
  id_transaction INT PRIMARY KEY AUTO_INCREMENT,
  id_card INT,
  amount DOUBLE(12,2) NOT NULL,
  points DOUBLE(12,2) NOT NULL,
  date DATE NOT NULL,
  FOREIGN KEY(id_card) REFERENCES card_points(id_card) ON UPDATE CASCADE ON DELETE RESTRICT
);
-- Mostrar el nombre y el status de las tiendas.
CREATE VIEW nombre_vista AS 
SELECT
name, status 
FROM store;

SELECT * FROM nombre_vista;
-- -----------------------------------------------------------
-- Mostrar el username del administrador, el nombre de la tienda, el estatus de la tienda 
CREATE VIEW admin_store_info AS
SELECT 
a.username AS user_name,
s.name AS name,
s.status AS store_status
FROM administrator AS a 
JOIN store AS s ON  s.id_administrator = a.id_administrator;

SELECT * FROM admin_store_info
-- ----------------------------------------------------------- 
-- Crear una viste que muestre el id_cliente, su telefono, nombre de la tienda y cantos puentos tiene ese cliente en la tienda 

CREATE VIEW vista_cliente AS
SELECT    
c.id_client,
c.phone,
s.name,
ca.points
FROM 
client AS c 
JOIN 
card_points AS ca ON c.id_client = ca.id_client
JOIN
store AS s ON s.id_store = s.id_store;
SELECT * FROM vista_cliente;

-- Crea que miestre los nombres de las tiendas y la cantidad de clientes que tiene cada una.
CREATE VIEW numero_clientes AS
SELECT s.name AS store_name, COUNT(DISTINCT cp.id_client) AS client_count
FROM store s
LEFT JOIN card_points cp ON s.id_store = cp.id_store
GROUP BY s.name;
SELECT * FROM numero_clientes;
    
  
-- Crea una vista que muestr e el nombre de cada tienda y el monto total de ventas generadas en ella

CREATE VIEW vista_tienda_ventas AS
SELECT
s.name AS nombre_tienda,
SUM(t.amount) AS monto_total_ventas
FROM store AS s 
JOIN card_points AS cp ON s.id_store = cp.id_store
JOIN transaction  t ON cp.id_card = t.id_card
WHERE t.amount > 0
GROUP BY s.name;
SELECT * FROM vista_tienda_ventas;