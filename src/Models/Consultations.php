<?php

namespace App\Models;

use App\Core\Database;
use App\Models\Patients;
use PDO;
use RuntimeException;
use PDOException;

/**
 * Clase modelo encargargado de ejecutar SQL 
 * 
 * @author Francisco David Medina Lourenzo <sparkmed0224@gmail.com>
 * @version 1.0.0
 * @package App\Moodels
 */

class Consultations
{
    private PDO $db;
    private Patients $patientModel;

    public function __construct()
    {
        $this->db = Database::getConnection();
        $this->patientModel = new Patients();
    }

    // Funciona ✅
    public function tieneConsultaActiva(int $pacienteId): bool
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM consultas WHERE paciente_id = :paciente_id AND activo = TRUE");
        $stmt->execute(['paciente_id' => $pacienteId]);
        return ((int)$stmt->fetchColumn()) > 0;
    }

    // Funciona ✅
    public function crearConsulta(int $pacienteId, int $servicioId, int $usuarioIngresoId, ?string $diagnostico_medico, ?string $observacionesIngreso = null, ?string $bloque = null, ?string $sala = null, ?string $cama = null): int|false
    {
        try {

            $sql = "INSERT INTO consultas (paciente_id, servicio_id, usuario_ingreso_id,diagnostico_medico,observaciones_ingreso, bloque, sala, cama) 
            VALUES (:paciente_id, :servicio_id, :usuario_ingreso_id,:diagnostico_medico, :observaciones_ingreso, :bloque, :sala, :cama)";

            $stmt = $this->db->prepare($sql);

            $stmt->bindValue(':paciente_id', $pacienteId, PDO::PARAM_INT);
            $stmt->bindValue(':servicio_id', $servicioId, PDO::PARAM_INT);
            $stmt->bindValue(':usuario_ingreso_id', $usuarioIngresoId, PDO::PARAM_INT);
            $stmt->bindValue(':diagnostico_medico', $diagnostico_medico, $diagnostico_medico === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
            $stmt->bindValue(':observaciones_ingreso', $observacionesIngreso, $observacionesIngreso === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
            $stmt->bindValue(':bloque', $bloque, $bloque === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
            $stmt->bindValue(':sala', $sala, $sala === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
            $stmt->bindValue(':cama', $cama, $cama === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
            if ($stmt->execute()) {
                return (int) $this->db->lastInsertId();
            }
            return false;
        } catch (PDOException $e) {
            error_log("Error al crear consulta: " . $e->getMessage());
            return false;
        }
    }


    // Funciona ✅
    public function allConsultaModel(): array
    {
        $stmt = $this->db->query("SELECT * FROM consultas WHERE activo=1;");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }


    // Funciona ✅
    public function allConsultasActivasServicioModel(?int $id_servicio = null): array
    {
        $sql = "SELECT 
                c.id AS consulta_id,
                c.fecha_ingreso,
                c.bloque,
                c.sala,
                c.cama,
                c.observaciones_ingreso,
                c.diagnostico_medico,
                p.id AS paciente_id,
                p.sexo AS paciente_sexo,
                p.nombre AS paciente_nombre,
                p.apellido AS paciente_apellido,
                p.cedula AS paciente_cedula,
                p.fecha_nacimiento AS paciente_fecha_nacimiento,
                s.nombre AS servicio_nombre
            FROM consultas c
            INNER JOIN pacientes p ON c.paciente_id = p.id
            INNER JOIN servicios s ON c.servicio_id = s.id
            WHERE c.activo = TRUE";

        $params = [];

        if ($id_servicio !== 1) {
            $sql .= " AND c.servicio_id = :id_servicio";
            $params[':id_servicio'] = $id_servicio;
        }

        try {
            $stmt = $this->db->prepare($sql);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
            }
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error al obtener consultas: " . $e->getMessage());
            return [];
        }
    }


    // Funciona ✅
    public function reasignarConsultaModel(int $id_servicio, int $consulta_id): bool
    {

        $sql = "UPDATE consultas SET servicio_id = :servicio_id WHERE id = :consulta_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['servicio_id' => $id_servicio, 'consulta_id' => $consulta_id]);
        return $stmt->rowCount() > 0;
    }

    // Funciona ✅
    public function altaConsultaModel(int $usuarioId, int $consulta_id): bool
    {
        $sql = "UPDATE consultas SET activo = 0, fecha_egreso = NOW(), usuario_egreso_id = :usuario_id WHERE id = :consulta_id";
        $stmt = $this->db->prepare($sql);
        $resultado = $stmt->execute([
            ':usuario_id' => $usuarioId,
            ':consulta_id' => $consulta_id
        ]);
        return $resultado && $stmt->rowCount() > 0;
    }

    public function editarConsultaModel(int $edit_consulta, string $editar_bloque, string $editar_sala, string $editar_cama)
    {
        $sql = "UPDATE consultas SET bloque = :bloque, sala = :sala, cama = :cama WHERE id = :consulta_id";
        $stmt = $this->db->prepare($sql);
        $resultado = $stmt->execute([':consulta_id' => $edit_consulta, ':bloque' => $editar_bloque, ':sala' => $editar_sala, ':cama' => $editar_cama]);
        return $resultado && $stmt->rowCount() > 0;
    }

    public function editarConsultaGeneral(
        int $editar_id,string $editar_nombre,string $editar_apellido,string $editar_sexo,string $fecha_nacimiento,
        int $edit_consulta,string $editar_bloque,string $editar_sala,string $editar_cama
    ): bool {
        $edit_consulta = $this->editarConsultaModel($edit_consulta,$editar_bloque,$editar_sala,$editar_cama);
        $edit_paciente = $this->patientModel->editarPacienteModel($editar_id,$editar_nombre,$editar_apellido,$editar_sexo,$fecha_nacimiento);
        return $edit_consulta && $edit_paciente;
    }
}
