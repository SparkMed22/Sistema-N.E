-- Autor: Francisco David Medina Lourenzo | Fecha: 2026-08-14 

SELECT 
    id,
    nombre,
    apellido,
    fecha_nacimiento,
    TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) as edad
FROM pacientes;



INSERT INTO productos (id, nombre, cantidad, stock_minimo) VALUES
(1, 'NOVARIX CON FIBRAS 1000 GR', 0, 6),
(2, 'NOVARIX SIN FIBRAS 1000 GR', 0, 5),
(3, 'NOVARIX DIABETICOS 1000 GR', 0, 5),
(4, 'CN PLUS', 0, 5),
(5, 'CN PREMO RENAL', 0, 5),
(6, 'PENTASURE DLS 400 GR', 10, 5),
(7, 'PENTASURE DM 400 GR', 0, 5),
(8, 'PENTASURE INMUNO MAX 244 GR', 15, 5),
(9, 'RENO DIET LP 400 GR', 90, 37),
(10, 'ENTEREX KARBS 450 GR', 1, 5),
(11, 'NUTRILON PEPTI JUNIOR 400 GR', 191, 5),
(12, 'NUTRILON PREMIUM 1 1000 GR', 4, 5),
(13, 'GLUTAPAK 15 GR', 702, 5),
(14, 'FRESUBIN FIBRE 1000 ML', 0, 5),
(15, 'EXPERTO 131 GR', 17, 5),
(16, 'ENSURE POLVO 800 GR', 0, 5),
(17, 'GLUCERNA 237 ML', 316, 5),
(18, 'ENSURE PLUS 220 ML', 0, 5),
(19, 'JEVITY 1000 ML', 0, 5),
(20, 'ENTEREX DBT 237 ML', 366, 5),
(21, 'ENTEREX PLUS 237 ML', 0, 5),
(22, 'NOVARIX CON FIBRAS 500 GR', 0, 5),
(23, 'NOVARIX SIN FIBRAS 500 GR', 10, 28),
(24, 'NOVARIX DIABETICO 500 GR', 0, 48),
(25, 'WHEY PROTEIN 50 GR', 0, 5),
(26, 'CN MODULO CALORICO 500 GR', 1, 5),
(27, 'NOVARIX RENAL EN DIALISIS 325 GR', 13, 5),
(28, 'NOVARIX PRE RENAL 325 GR', 0, 5),
(29, 'NAN OPTI PRO 900 GR', 0, 5),
(30, 'NOVARIX MOD PROTEICO 50 GR', 349, 5),
(31, 'ISOSOURCE 400 GR', 4, 5),
(32, 'ENTEREX PLUS 220 ML', 36, 5),
(33, 'ENTEREX DBT', 9, 5),
(34, 'NOVASOURCE 1000 ML', 0, 5),
(35, 'MALTODEX UP 250 GR', 360, 60)
ON DUPLICATE KEY UPDATE 
    cantidad = VALUES(cantidad),
    stock_minimo = VALUES(stock_minimo);













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
  
