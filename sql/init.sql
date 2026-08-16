-- Active: 1786211203686@@127.0.0.1@3306@Sistema_N_E

-- Tabla de usuarios del sistema
-- Creada para almacenar información de personal y roles
-- Autor: Francisco David Medina Lourenzo | Fecha: 2026-08-09 

CREATE TABLE usuarios(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    cedula VARCHAR(30) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    rol ENUM ('admin','internacion','nutricionista') NOT NULL,
    estado BOOLEAN NOT NULL DEFAULT TRUE,
    primer_ingreso BOOLEAN NOT NULL DEFAULT TRUE
);


-- Tabla de pacientes del sistema
-- Creada para almacenar información basica de los pacientes
-- Autor: Francisco David Medina Lourenzo | Fecha: 2026-08-14 

CREATE TABLE pacientes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    cedula VARCHAR(20) NOT NULL UNIQUE,
    fecha_nacimiento DATE NOT NULL,
    sexo ENUM('M', 'F', 'INDEFINIDO') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla de servicios del sistema
-- Creada para almacenar los servicios del Hospital 
-- Autor: Francisco David Medina Lourenzo | Fecha: 2026-08-14 
-- TODO: CORREGIR TILDES 
CREATE TABLE servicios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;


-- Tabla de consultas del sistema
-- Creada para almacenar las consultas de cada paciente en el H.G.I
-- Autor: Francisco David Medina Lourenzo | Fecha: 2026-08-15

CREATE TABLE consultas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    paciente_id INT NOT NULL,
    servicio_id INT NOT NULL,
    usuario_ingreso_id INT NOT NULL,  
    usuario_tratante_id INT NULL,         
    usuario_egreso_id INT NULL,           
    fecha_ingreso DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
    CONSTRAINT fk_consulta_usuario_tratante FOREIGN KEY (usuario_tratante_id) REFERENCES usuarios(id),
    CONSTRAINT fk_consulta_usuario_egreso FOREIGN KEY (usuario_egreso_id) REFERENCES usuarios(id)
);