<?php

namespace App\Models;

use App\Core\Database;
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

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    // Funciona ✅
    public function tieneConsultaActiva(int $pacienteId): bool
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM consultas WHERE paciente_id = :paciente_id AND activo = TRUE");
        $stmt->execute(['paciente_id' => $pacienteId]);
        return ((int)$stmt->fetchColumn()) > 0;
    }

    // Funciona ✅
    public function crearConsulta(int $pacienteId, int $servicioId, int $usuarioIngresoId, ?int $usuarioTratanteId = null, ?string $observacionesIngreso = null, ?string $bloque = null, ?string $sala = null, ?string $cama = null): int|false
    {
        try {

            $sql = "INSERT INTO consultas (paciente_id, servicio_id, usuario_ingreso_id, usuario_tratante_id, observaciones_ingreso, bloque, sala, cama) 
            VALUES (:paciente_id, :servicio_id, :usuario_ingreso_id, :usuario_tratante_id, :observaciones_ingreso, :bloque, :sala, :cama)";

            $stmt = $this->db->prepare($sql);

            $stmt->bindValue(':paciente_id', $pacienteId, PDO::PARAM_INT);
            $stmt->bindValue(':servicio_id', $servicioId, PDO::PARAM_INT);
            $stmt->bindValue(':usuario_ingreso_id', $usuarioIngresoId, PDO::PARAM_INT);

            $stmt->bindValue(':usuario_tratante_id', $usuarioTratanteId, $usuarioTratanteId === null ? PDO::PARAM_NULL : PDO::PARAM_INT);
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
    public function allConsultasActivasUsuarioModel(int $usuarioId, string $rolUsuario): array
    {
        $sql = "SELECT 
                c.id AS consulta_id,
                c.fecha_ingreso,
                c.bloque,
                c.sala,
                c.cama,
                c.observaciones_ingreso,
                c.fecha_ingreso,
                p.id AS paciente_id,
                p.sexo AS paciente_sexo,
                p.nombre AS paciente_nombre,
                p.apellido AS paciente_apellido,
                p.cedula AS paciente_cedula,
                s.nombre AS servicio_nombre,
                CONCAT(u_tratante.nombre, ' ', u_tratante.apellido) AS profesional_tratante
            FROM consultas c
            INNER JOIN pacientes p ON c.paciente_id = p.id
            INNER JOIN servicios s ON c.servicio_id = s.id
            LEFT JOIN usuarios u_tratante ON c.usuario_tratante_id = u_tratante.id
            WHERE c.activo = TRUE";

        $params = [];

        if ($rolUsuario !== 'admin') {
            $sql .= " AND c.usuario_tratante_id = :usuario_id";
            $params['usuario_id'] = $usuarioId;
        }

        $sql .= " ORDER BY c.fecha_ingreso DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Funciona ✅
    public function reasignarConsultaModel(int $usuario_id, int $consulta_id): bool
    {
        $sql = "UPDATE consultas SET usuario_tratante_id = :usuario_tratante_id    WHERE id = :consulta_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['usuario_tratante_id' => $usuario_id,    'consulta_id' => $consulta_id]);
        return $stmt->rowCount() > 0;
    }

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
}
