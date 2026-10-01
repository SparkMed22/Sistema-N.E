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

class Informes
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function stockPorProductoModel(string $fechaDesde, string $fechaHasta): array
    {
        // Aseguramos el formato completo de fecha/hora si solo vienen en AAAA-MM-DD
        $desde = $fechaDesde . (strlen($fechaDesde) === 10 ? ' 00:00:00' : '');
        $hasta = $fechaHasta . (strlen($fechaHasta) === 10 ? ' 23:59:59' : '');

        $sql = "SELECT 
                p.nombre AS producto,

                -- 1. Stock Inicial a la fecha desde
                (
                    p.cantidad 
                    - COALESCE((
                        SELECT SUM(sm_post.cantidad) 
                        FROM stock_movimientos sm_post 
                        WHERE sm_post.producto_id = p.id 
                          AND sm_post.tipo = 'ENTRADA' 
                          AND sm_post.fecha >= :fecha_desde_sub
                    ), 0)
                    + COALESCE((
                        SELECT SUM(sm_post.cantidad) 
                        FROM stock_movimientos sm_post 
                        WHERE sm_post.producto_id = p.id 
                          AND sm_post.tipo = 'SALIDA' 
                          AND sm_post.fecha >= :fecha_desde_sub2
                    ), 0)
                ) AS stock_inicial,

                -- 2. Cantidad de Entradas en el rango
                COALESCE(SUM(CASE WHEN sm.tipo = 'ENTRADA' THEN sm.cantidad ELSE 0 END), 0) AS cantidad_entradas,

                -- 3. Cantidad de Salidas en el rango
                COALESCE(SUM(CASE WHEN sm.tipo = 'SALIDA' THEN sm.cantidad ELSE 0 END), 0) AS cantidad_salidas,

                -- 4. Cantidad Actual en tiempo real
                p.cantidad AS cantidad_actual

            FROM productos p
            LEFT JOIN stock_movimientos sm 
                ON p.id = sm.producto_id 
                AND sm.fecha >= :fecha_desde
                AND sm.fecha <= :fecha_hasta

            GROUP BY 
                p.id, 
                p.nombre, 
                p.cantidad
            ORDER BY 
                p.nombre ASC";

        // Si utilizas una propiedad PDO de clase ($this->db, $this->conexion, etc.)
        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':fecha_desde_sub'  => $desde,
            ':fecha_desde_sub2' => $desde,
            ':fecha_desde'      => $desde,
            ':fecha_hasta'      => $hasta
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function pedidosCerradosModel(?string $fechaDesde = null, ?string $fechaHasta = null): array
    {
        $params = [];

        $sql = "SELECT
                    p.id AS paciente_id,
                    CONCAT(p.nombre, ' ', p.apellido) AS paciente,
                    p.cedula,

                    c.bloque,
                    c.sala,
                    c.cama,

                    s.nombre AS servicio,

                    -- RECETA
                    r.id AS receta_id,
                    r.indicacion_nutricional,
                    r.medida_porcion,
                    r.aporte_liquido,
                    r.volumen_total,
                    r.estado_aprobacion,
                    r.fecha_revision,

                    -- PEDIDO
                    pe.id AS pedido_id,
                    pe.estado AS estado_pedido,
                    pe.fecha_creacion AS fecha_pedido,
                    pe.fecha_cierre,

                    -- USUARIO
                    CONCAT(ug.nombre, ' ', ug.apellido) AS gestionado_por,

                    -- COMPONENTES
                    COUNT(pc.id) AS total_componentes,

                    GROUP_CONCAT(
                        CONCAT(
                            pr.nombre,
                            ' x ',
                            pc.cantidad
                        )
                        ORDER BY pr.nombre
                        SEPARATOR ' | '
                    ) AS componentes

                FROM pedidos pe

                INNER JOIN recetas r
                    ON r.id = pe.receta_id

                INNER JOIN consultas c
                    ON c.id = r.consulta_id

                INNER JOIN pacientes p
                    ON p.id = c.paciente_id

                INNER JOIN servicios s
                    ON s.id = c.servicio_id

                INNER JOIN usuarios ug
                    ON ug.id = pe.gestionado_usuario_id

                LEFT JOIN pedido_componentes pc
                    ON pc.pedido_id = pe.id

                LEFT JOIN productos pr
                    ON pr.id = pc.producto_id

                WHERE 1=1";

        // Filtro dinámico por fecha de creación del pedido
        if (!empty($fechaDesde)) {
            $sql .= " AND pe.fecha_creacion >= :fecha_desde";
            $params[':fecha_desde'] = (strlen($fechaDesde) === 10) ? $fechaDesde . ' 00:00:00' : $fechaDesde;
        }

        if (!empty($fechaHasta)) {
            $sql .= " AND pe.fecha_creacion <= :fecha_hasta";
            $params[':fecha_hasta'] = (strlen($fechaHasta) === 10) ? $fechaHasta . ' 23:59:59' : $fechaHasta;
        }

        $sql .= " GROUP BY
                    p.id,
                    p.nombre,
                    p.apellido,
                    p.cedula,
                    c.bloque,
                    c.sala,
                    c.cama,
                    s.id,
                    s.nombre,
                    r.id,
                    r.indicacion_nutricional,
                    r.medida_porcion,
                    r.aporte_liquido,
                    r.volumen_total,
                    r.estado_aprobacion,
                    r.fecha_revision,
                    pe.id,
                    pe.estado,
                    pe.fecha_creacion,
                    pe.fecha_cierre,
                    ug.id,
                    ug.nombre,
                    ug.apellido

                ORDER BY
                    p.apellido ASC,
                    p.nombre ASC,
                    pe.fecha_creacion ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
