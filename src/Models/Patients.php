<?php

namespace App\Models;

use App\Core\Database;
use PDO;

/**
 * Clase modelo encargargado de ejecutar SQL 
 * 
 * @author Francisco David Medina Lourenzo <sparkmed0224@gmail.com>
 * @version 1.0.0
 * @package App\Moodels
 */

class Patients
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    // Funciona ✅
    public function existePaciente(string $cedula): ?int
    {
        $stmt = $this->db->prepare(    "SELECT id FROM pacientes WHERE cedula = :cedula LIMIT 1");
        $stmt->execute(['cedula' => $cedula]);
        $id = $stmt->fetchColumn();
        return $id !== false ? (int)$id : null;
    }

    
    // Funciona ✅
    public function crearPacienteModel(string $nombre, string $apellido, string $cedula, string $fechaNacimiento, string $sexo): int
    {
        $stmt = $this->db->prepare("INSERT INTO pacientes (nombre, apellido, cedula, fecha_nacimiento, sexo) 
            VALUES (:nombre, :apellido, :cedula, :fecha_nacimiento, :sexo)");

        try {
            $stmt->execute([
                'nombre'           => $nombre,
                'apellido'         => $apellido,
                'cedula'           => $cedula,
                'fecha_nacimiento' => $fechaNacimiento,
                'sexo'             => $sexo
            ]);

            return (int)$this->db->lastInsertId();
        } catch (\PDOException $e) {
            if ($e->getCode() === '23000') {
                throw new \RuntimeException('La cédula de este paciente ya está registrada.');
            }
            error_log("Error al crear paciente: " . $e->getMessage());
            throw new \RuntimeException('Error al crear el registro del paciente.');
        }
    }

    // Funciona ✅
    public function allPacientesModel(): array
    {
        $stmt = $this->db->query("SELECT id ,nombre, apellido, cedula, fecha_nacimiento,sexo FROM pacientes;");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // TODO: ACTUALIZAR Paciente
    // UPDATE pacientes  SET nombre = 'Maria Fatima', apellido = 'Medina l', sexo = 'F'  WHERE id = 32;
}
