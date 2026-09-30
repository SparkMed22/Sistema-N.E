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
}
