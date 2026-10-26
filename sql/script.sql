-- Autor: Francisco David Medina Lourenzo | Fecha: 2026-08-14 


-- ===========================
-- ?        VISTAS 
-- ===========================

CREATE OR REPLACE VIEW vw_pacientes AS
    SELECT  
        id AS ID, 
        CONCAT( nombre,' ' ,apellido) AS 'NOMBRE COMPLETO',
        cedula AS 'CEDULA',
        fecha_nacimiento AS 'FECHA DE NACIMIENTO', 
        TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) AS 'EDAD'
    FROM pacientes ;
SELECT  from vw_pacientes;


CREATE OR REPLACE VIEW wv_usuarios AS
    SELECT 
        u.id AS 'ID',
        CONCAT(u.nombre,' ',u.apellido) AS 'USUARIO',
        u.cedula AS 'CEDULA',
        s.nombre AS 'SERVICIO',
        u.rol AS 'ROL',
        CASE u.estado
            WHEN 1 THEN 'ACTIVO'
            ELSE 'INACTIVO'
        END AS 'ESTADO'
    FROM usuarios u
    INNER JOIN servicios s ON u.id_servicio = s.id; 

SELECT * FROM wv_usuarios;


-- ================================
-- ?        MODIFICACIONES 
-- ================================

ALTER TABLE usuarios 
MODIFY COLUMN rol ENUM('admin', 'internacion', 'nutricionista', 'franquero') NOT NULL;

DESCRIBE usuarios;
