-- Autor: Francisco David Medina Lourenzo | Fecha: 2026-08-14 


-- Agregas Pacientes TESTEO
INSERT INTO pacientes (nombre, apellido, cedula, fecha_nacimiento, sexo) VALUES
('Juan', 'Pérez', '1001234567', '1985-03-15', 'M'    ),
('María', 'González', '1002345678', '1992-07-22', 'F'),
('Carlos', 'Ruiz', '1003456789', '1978-11-05', 'M'   ),
('Ana', 'Martínez', '1004567890', '2000-01-10', 'F'  ),
('Luis', 'Fernández', '1005678901', '1995-06-30', 'M'),
('Sofía', 'López', '1006789012', '1988-09-18', 'F'   ),
('Roberto', 'Díaz', '1007890123', '1965-12-25', 'M'  ),
('Elena', 'Torres', '1008901234', '1998-04-02', 'F'  ),
('Miguel', 'Sánchez', '1009012345', '1970-08-14', 'M'),
('Carla', 'Vásquez', '1010123456', '2005-02-28', 'F' );


-- Agregas Servicios
INSERT INTO servicios (nombre) VALUES 
('Clínica Médica'),
('Cirugía y Traumatología'),
('Ginecología'),
('Pediatría'),
('UTI Adultos'),
('Urgencia Clínica Médica'),
('Urgencia Cirugía y Traumatología'),
('Urgencia Ginecología'),
('Urgencia Pediatría');

-- En caso de necesitar actualizar los nombres de los servicios
UPDATE servicios SET nombre = 'Clínica Médica' WHERE id = 1;
UPDATE servicios SET nombre = 'Cirugía y Traumatología' WHERE id = 2;
UPDATE servicios SET nombre = 'Ginecología' WHERE id = 3;
UPDATE servicios SET nombre = 'Pediatría' WHERE id = 4;
UPDATE servicios SET nombre = 'UTI Adultos' WHERE id = 5;
UPDATE servicios SET nombre = 'Urgencia Clínica Médica' WHERE id = 6;
UPDATE servicios SET nombre = 'Urgencia Cirugía y Traumatología' WHERE id = 7;
UPDATE servicios SET nombre = 'Urgencia Ginecología' WHERE id = 8;
UPDATE servicios SET nombre = 'Urgencia Pediatría' WHERE id = 9;