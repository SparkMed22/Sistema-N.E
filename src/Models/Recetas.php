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

    
    // TODO: Corregir
    public function ultimasRecetasAprobadas(int $paciente_id, int $limite = 5): array
    {
        $sql = "
            SELECT 
                -- Información de la Receta
                r.id AS receta_id,
                r.indicacion_nutricional,
                r.medida_porcion,
                r.aporte_liquido,
                r.volumen_total,
                r.estado AS estado_receta,
                r.estado_aprobacion,
                r.fecha_revision,
                r.fecha_creacion AS fecha_receta,

                -- Información del Paciente
                p.id AS paciente_id,
                CONCAT(p.nombre, ' ', p.apellido) AS paciente_nombre_completo,
                p.cedula AS paciente_cedula,

                -- Información de la Consulta y Ubicación
                c.id AS consulta_id,
                s.nombre AS servicio,
                c.bloque,
                c.sala,
                c.cama,

                -- Profesional que creó la receta
                CONCAT(u_creador.nombre, ' ', u_creador.apellido) AS profesional_prescriptor,
                u_creador.rol AS profesional_rol,

                -- Profesional que aprobó la receta
                CONCAT(u_revisador.nombre, ' ', u_revisador.apellido) AS profesional_aprobador

            FROM recetas r
            INNER JOIN consultas c ON r.consulta_id = c.id
            INNER JOIN pacientes p ON c.paciente_id = p.id
            INNER JOIN servicios s ON c.servicio_id = s.id
            INNER JOIN usuarios u_creador ON r.usuario_id = u_creador.id
            LEFT JOIN usuarios u_revisador ON r.revisado_por_usuario_id = u_revisador.id

            WHERE p.id = :paciente_id 
              AND r.estado_aprobacion = 'APROBADA'
              AND r.estado = 'ACTIVA'

            ORDER BY r.fecha_creacion DESC
            LIMIT :limite
        ";

        $stmt = $this->db->prepare($sql);
        
        // Asignación explícita con tipos PDO para evitar problemas con LIMIT
        $stmt->bindValue(':paciente_id', $paciente_id, \PDO::PARAM_INT);
        $stmt->bindValue(':limite', $limite, \PDO::PARAM_INT);
        
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];
    }


 
}
