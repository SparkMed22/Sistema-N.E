-- Active: 1786211203686@@127.0.0.1@3306@Sistema_N_E
-- Agregas Servicios
INSERT INTO servicios (nombre) VALUES 
('Polivalente'),
('Clínica Médica'),
('Cirugía y Traumatología'),
('Ginecología'),
('Pediatría'),
('UTI Adultos'),
('Urgencia Clínica Médica'),
('Urgencia Cirugía y Traumatología'),
('Urgencia Ginecología'),
('Urgencia Pediatría'),
('Oncología')
('Centro de Lactancia');


-- En caso de necesitar actualizar los nombres de los servicios
UPDATE servicios SET nombre = 'Polivalente' WHERE id = 1;
UPDATE servicios SET nombre = 'Clínica Médica' WHERE id = 2;
UPDATE servicios SET nombre = 'Cirugía y Traumatología' WHERE id = 3;
UPDATE servicios SET nombre = 'Ginecología' WHERE id = 4;
UPDATE servicios SET nombre = 'Pediatría' WHERE id = 5;
UPDATE servicios SET nombre = 'UTI Adultos' WHERE id = 6;
UPDATE servicios SET nombre = 'Urgencia Clínica Médica' WHERE id = 7;
UPDATE servicios SET nombre = 'Urgencia Cirugía y Traumatología' WHERE id = 8;
UPDATE servicios SET nombre = 'Urgencia Ginecología' WHERE id = 9;
UPDATE servicios SET nombre = 'Urgencia Pediatría' WHERE id = 10;
UPDATE servicios SET nombre = 'Oncología' WHERE id = 11;
UPDATE servicios SET nombre = 'Centro de Lactancia' WHERE id = 12;