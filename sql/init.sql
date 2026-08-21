-- Active: 1786211203686@@127.0.0.1@3306@Sistema_N_E

-- Tabla de servicios del sistema
-- Creada para almacenar los servicios del Hospital 
-- Autor: Francisco David Medina Lourenzo | Fecha: 2026-08-14 
-- TODO: CORREGIR TILDES 
CREATE TABLE servicios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;


-- Tabla de usuarios del sistema
-- Creada para almacenar información de personal y roles
-- Autor: Francisco David Medina Lourenzo | Fecha: 2026-08-09 

CREATE TABLE usuarios(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    cedula VARCHAR(30) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    id_servicio INT NOT NULL,
    rol ENUM ('admin','internacion','nutricionista') NOT NULL,
    estado BOOLEAN NOT NULL DEFAULT TRUE,
    primer_ingreso BOOLEAN NOT NULL DEFAULT TRUE,
    CONSTRAINT fk_servicios FOREIGN KEY (id_servicio) REFERENCES servicios(id)
);


-- Tabla de pacientes del sistema
-- Creada para almacenar información basica de los pacientes
-- Autor: Francisco David Medina Lourenzo | Fecha: 2026-08-14 

CREATE TABLE pacientes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    cedula VARCHAR(20) NOT NULL UNIQUE,
    telefono VARCHAR(20) NULL,
    fecha_nacimiento DATE NOT NULL,
    sexo ENUM('M', 'F', 'INDEFINIDO') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


-- Tabla de consultas del sistema
-- Creada para almacenar las consultas de cada paciente en el H.G.I
-- Autor: Francisco David Medina Lourenzo | Fecha: 2026-08-15

CREATE TABLE consultas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    paciente_id INT NOT NULL,
    servicio_id INT NOT NULL,
    usuario_ingreso_id INT NOT NULL,          
    usuario_egreso_id INT NULL,           
    fecha_ingreso DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    diagnostico_medico TEXT NOT NULL,
    observaciones_ingreso TEXT NULL,
    fecha_egreso DATETIME NULL,
    observaciones_egreso TEXT NULL,
    bloque VARCHAR(10) NULL,
    sala VARCHAR(10) NULL,
    cama VARCHAR(10) NULL,
    activo BOOLEAN DEFAULT TRUE,
    CONSTRAINT fk_consulta_paciente FOREIGN KEY (paciente_id) REFERENCES pacientes(id),
    CONSTRAINT fk_consulta_servicio FOREIGN KEY (servicio_id) REFERENCES servicios(id),
    CONSTRAINT fk_consulta_usuario_ingreso FOREIGN KEY (usuario_ingreso_id) REFERENCES usuarios(id),
    CONSTRAINT fk_consulta_usuario_egreso FOREIGN KEY (usuario_egreso_id) REFERENCES usuarios(id)
);
-- usuario_tratante_id INT NULL, -- En base a las recetas 
--CONSTRAINT fk_consulta_usuario_tratante FOREIGN KEY (usuario_tratante_id) REFERENCES usuarios(id),



-- Tabla de Recetas del sistema
-- Creada para almacenar las Recetas de cada paciente en el H.G.I
-- Autor: Francisco David Medina Lourenzo | Fecha: 2026-08-17

CREATE TABLE recetas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    consulta_id INT NOT NULL,
    creado_por_usuario_id INT NOT NULL,
    indicacion_nutricional TEXT NOT NULL,
    fecha_creacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    
    medida_porcion VARCHAR(100) NULL,
    aporte_liquido VARCHAR(100) NULL,
    volumen_total VARCHAR(100) NULL,
    
    estado ENUM('ACTIVA', 'INACTIVA') NOT NULL DEFAULT 'ACTIVA',
    estado_aprobacion ENUM('PENDIENTE', 'APROBADA', 'RECHAZADA') NOT NULL DEFAULT 'PENDIENTE',
    
    revisado_por_usuario_id INT NULL,
    motivo_rechazo TEXT NULL,
    fecha_revision DATETIME NULL,
    fecha_desactivacion DATETIME NULL,
    CONSTRAINT fk_recetas_consulta FOREIGN KEY (consulta_id) REFERENCES consultas(id),
    CONSTRAINT fk_recetas_creado_por_usuario FOREIGN KEY (creado_por_usuario_id) REFERENCES usuarios(id),
    CONSTRAINT fk_recetas_revisado_por_usuario FOREIGN KEY (revisado_por_usuario_id) REFERENCES usuarios(id)
);

-- Tabla productos 
-- Creada para almacenar los prodcutos disponibles en el H.G.I
-- Autor: Francisco David Medina Lourenzo | Fecha: 2026-08-18
CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    cantidad INT NOT NULL DEFAULT 0,
    stock_minimo INT DEFAULT 0
);

-- Tabla stock_movimientos
-- Creada para Auditoria
-- Autor: Francisco David Medina Lourenzo | Fecha: 2026-08-18
CREATE TABLE stock_movimientos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    producto_id INT NOT NULL,
    pedido_id INT NULL,
    usuario_id INT NOT NULL,
    tipo ENUM('ENTRADA', 'SALIDA') NOT NULL,
    cantidad INT NOT NULL,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    motivo VARCHAR(255) NOT NULL,
    FOREIGN KEY (producto_id) REFERENCES productos (id) ON DELETE CASCADE,
    FOREIGN KEY (pedido_id) REFERENCES pedidos (id) ON DELETE SET NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios (id)
);


-- Tabla de Recetas del sistema
-- Creada para almacenar los Pedidos de cada receta en el H.G.I relacion 1=1
-- Autor: Francisco David Medina Lourenzo | Fecha: 2026-08-18

CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    receta_id INT NOT NULL UNIQUE,
    gestionado_usuario_id INT NOT NULL,
    estado ENUM('CREADO', 'PREPARANDO', 'CERRADO') NOT NULL DEFAULT 'CREADO',
    fecha_creacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    fecha_cierre DATETIME NULL,
    CONSTRAINT fk_pedidos_receta FOREIGN KEY (receta_id) REFERENCES recetas(id),
    CONSTRAINT fk_gestionado_usuario_id FOREIGN KEY (gestionado_usuario_id) REFERENCES usuarios(id)
);



CREATE TABLE pedido_componentes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL,
    
    CONSTRAINT uk_pedido_producto UNIQUE (pedido_id, producto_id),

    CONSTRAINT fk_pedido_componentes_pedido
        FOREIGN KEY (pedido_id) REFERENCES pedidos(id)
        ON DELETE CASCADE ON UPDATE CASCADE,

    CONSTRAINT fk_pedido_componentes_producto
        FOREIGN KEY (producto_id) REFERENCES productos(id)
        ON DELETE RESTRICT ON UPDATE CASCADE
);