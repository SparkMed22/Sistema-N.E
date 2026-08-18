-- Autor: Francisco David Medina Lourenzo | Fecha: 2026-08-14 

SELECT 
    id,
    nombre,
    apellido,
    fecha_nacimiento,
    TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) as edad
FROM pacientes;

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


SELECT 
    r.id AS receta_id,
    r.diagnostico_medico,
    r.indicacion_nutricional,
    r.medida_porcion,
    r.aporte_liquido,
    r.volumen_total,
    r.estado AS estado_receta,
    r.estado_aprobacion,
    r.fecha_revision,
    r.fecha_creacion AS fecha_receta,
    p.id AS paciente_id,
    CONCAT(p.nombre, ' ', p.apellido) AS paciente_nombre_completo,
    p.cedula AS paciente_cedula,
    c.id AS consulta_id,
    s.nombre AS servicio,
    c.bloque,
    c.sala,
    c.cama,
    CONCAT(u_creador.nombre, ' ', u_creador.apellido) AS profesional_prescriptor,
    u_creador.rol AS profesional_rol,
    CONCAT(u_revisador.nombre, ' ', u_revisador.apellido) AS profesional_aprobador
    FROM recetas r
    INNER JOIN consultas c ON r.consulta_id = c.id
    INNER JOIN pacientes p ON c.paciente_id = p.id
    INNER JOIN servicios s ON c.servicio_id = s.id
    INNER JOIN usuarios u_creador ON r.usuario_id = u_creador.id
    LEFT JOIN usuarios u_revisador ON r.revisado_por_usuario_id = u_revisador.id
    WHERE p.id = 1 
      AND r.estado_aprobacion = 'APROBADA'
      AND r.estado = 'ACTIVA'
    ORDER BY r.fecha_creacion DESC
    LIMIT 5





SELECT 
  p.nombre AS paciente_nombre,
  p.cedula AS paciente_cedula,

  r.indicacion_nutricional,
  r.medida_porcion,
  r.aporte_liquido,
  r.volumen_total,
  r.fecha_creacion,

  u.nombre AS profecional_nombre,
  s.nombre AS profecional_servicio

  FROM recetas r 
  INNER JOIN consultas c  ON r.consulta_id = c.id
  INNER JOIN usuarios u ON u.id = r.usuario_id
  INNER JOIN servicios s ON u.id_servicio = s.id
  LEFT JOIN pacientes p ON c.paciente_id = p.id
  WHERE  p.id = 9
  ORDER BY r.fecha_creacion DESC
  LIMIT 5;
  
