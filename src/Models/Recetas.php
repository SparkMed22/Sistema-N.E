<?php

namespace App\Models;

use App\Core\Database;
use PDO;
use RuntimeException;
use InvalidArgumentException;

/**
 * Clase modelo encargargado de ejecutar SQL 
 * 
 * @author Francisco David Medina Lourenzo <sparkmed0224@gmail.com>
 * @version 1.0.0
 * @package App\Moodels
 */

class Recetas
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }


    // Funciona ✅
    public function crearRecetaModel(array $data): int
    {
        $sql = "INSERT INTO recetas (
                consulta_id, usuario_id, indicacion_nutricional, 
                medida_porcion, aporte_liquido, volumen_total,estado,
                estado_aprobacion,fecha_creacion
            ) VALUES (
                :consulta_id, :usuario_id, :indicacion_nutricional, 
                :medida_porcion, :aporte_liquido, :volumen_total,'ACTIVA',
                'PENDIENTE',NOW()
            )";

        $stmt = $this->db->prepare($sql);

        try {
            $stmt->execute([
                ':consulta_id'        => (int)$data['consulta_id'],
                ':usuario_id'         => (int)$data['usuarios_id'],
                ':indicacion_nutricional' => $data['indicacion_nutricional'],
                ':medida_porcion'     => !empty($data['medida_porcion']) ? $data['medida_porcion'] : null,
                ':aporte_liquido'     => !empty($data['aporte_liquido']) ? $data['aporte_liquido'] : null,
                ':volumen_total'      => !empty($data['volumen_total']) ? $data['volumen_total'] : null,
            ]);

            return (int)$this->db->lastInsertId();
        } catch (\PDOException $e) {
            if ($e->getCode() === '23000') {
                throw new RuntimeException("Error de integridad: La consulta o el usuario seleccionado no existen.");
            }
            error_log("Error al crear receta: " . $e->getMessage());
            throw new RuntimeException("Error al crear la receta. Intente nuevamente.");
        }
    }

    // Funciona ✅
    public function ultimasRecetasAprobadasModel(int $paciente_id): array
    {
        $sql = "SELECT 
                CONCAT(p.nombre, ' ', p.apellido) AS paciente_nombre_completo, 
                p.cedula AS paciente_cedula,
                r.indicacion_nutricional, 
                r.medida_porcion, 
                r.aporte_liquido, 
                r.volumen_total, 
                r.fecha_creacion,
                CONCAT(u.nombre, ' ', u.apellido) AS profesional_nombre,
                s.nombre AS profesional_servicio
            FROM recetas r 
            INNER JOIN consultas c ON r.consulta_id = c.id
            INNER JOIN usuarios u ON u.id = r.usuario_id
            INNER JOIN servicios s ON u.id_servicio = s.id
            LEFT JOIN pacientes p ON c.paciente_id = p.id
            WHERE 
                p.id = :paciente_id 
                AND r.estado_aprobacion != 'RECHAZADA'
            ORDER BY r.fecha_creacion DESC
            LIMIT 5";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':paciente_id', $paciente_id, \PDO::PARAM_INT);

        try {
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error en ultimasRecetasAprobadas: " . $e->getMessage());
            return [];
        }
    }

    // Funciona ✅
    public function allRecetasModel(): array
    {
        $sql = "SELECT 
                r.id AS id_receta,
                r.consulta_id AS id_consulta,
                r.usuario_id AS id_usuario,
                r.indicacion_nutricional,
                r.fecha_creacion,
                r.medida_porcion,
                r.aporte_liquido,
                r.volumen_total,

                c.diagnostico_medico,
                c.observaciones_ingreso,
                c.observaciones_egreso,
                c.bloque,
                c.sala,
                c.cama,

                CONCAT(p.nombre, ' ', p.apellido) AS paciente_nombre,
                CONCAT(u.nombre, ' ', u.apellido) AS usuario_nombre,
                
                s.nombre AS 'servicio',
                s.id AS 'servicio_id'

            FROM recetas r 
            INNER JOIN consultas c ON c.id = r.consulta_id
            INNER JOIN usuarios u ON u.id = r.usuario_id
            LEFT JOIN servicios s ON s.id = u.id_servicio
            INNER JOIN pacientes p ON p.id = c.paciente_id
            WHERE r.estado_aprobacion = 'PENDIENTE' 
              AND c.activo = 1
            ORDER BY r.fecha_creacion DESC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_OBJ) ?: [];
    }

    
    public function cancelarRecetaModel(int $id_receta, string $motivo, int $usuario_id): bool
    {
        $sql = "UPDATE recetas 
            SET 
                estado = 'INACTIVA',
                estado_aprobacion = 'RECHAZADA',
                motivo_rechazo = :motivo,
                revisado_por_usuario_id = :usuario_id,
                fecha_revision = NOW(),
                fecha_desactivacion = NOW()
            WHERE id = :id_receta";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':motivo', $motivo, \PDO::PARAM_STR);
        $stmt->bindValue(':usuario_id', $usuario_id, \PDO::PARAM_INT);
        $stmt->bindValue(':id_receta', $id_receta, \PDO::PARAM_INT);

        try {
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error en cancelarRecetaModel: " . $e->getMessage());
            return false;
        }
    }
}
