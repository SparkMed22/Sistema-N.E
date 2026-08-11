-- Active: 1786211203686@@127.0.0.1@3306@Sistema_N_E

-- Tabla de usuarios del sistema
-- Creada para almacenar información de personal y roles
-- Autor: Francisco David Medina Lourenzo | Fecha: 2026-08-09 

CREATE TABLE usuarios(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    cedula VARCHAR(20) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    rol ENUM ('admin','internacion','nutricionista') NOT NULL,
    estado BOOLEAN NOT NULL DEFAULT TRUE,
    primer_ingreso BOOLEAN NOT NULL DEFAULT TRUE
);