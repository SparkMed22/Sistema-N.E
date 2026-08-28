-- Active: 1786211203686@@127.0.0.1@3306@Sistema_N_E
-- 1. Desactivar temporalmente el chequeo de claves foráneas
SET FOREIGN_KEY_CHECKS = 0;

-- 2. Vaciar (truncar) todas las tablas
TRUNCATE TABLE pedido_componentes;
--TRUNCATE TABLE stock_movimientos;
TRUNCATE TABLE pedidos;
TRUNCATE TABLE recetas;
TRUNCATE TABLE consultas;
--TRUNCATE TABLE productos;
TRUNCATE TABLE pacientes;
--TRUNCATE TABLE servicios;
--TRUNCATE TABLE usuarios;

-- 3. Volver a activar el chequeo de claves foráneas
SET FOREIGN_KEY_CHECKS = 1;