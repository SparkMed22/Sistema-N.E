-- Autor: Francisco David Medina Lourenzo | Fecha: 2026-08-14 

SELECT  id, nombre, apellido, fecha_nacimiento, TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) as edad
FROM pacientes where cedula=5394596;


