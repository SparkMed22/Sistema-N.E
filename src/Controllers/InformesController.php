<?php

namespace App\Controllers;

use App\Models\Informes;
use App\Core\Auth;

/**
 * Clase LoginController encargargado de redireccionar 
 * 
 * @author Francisco David Medina Lourenzo <sparkmed0224@gmail.com>
 * @version 1.0.0
 * @package App\Moodels
 */


class InformesController extends BaseController
{
    private Informes $userInformes;

    public function __construct()
    {
        $this->userInformes = new Informes();
    }

    public function stockPorProductoController(): void
    {
        try {
            $data = $this->getPostJson();
            $fechaDesde = $data['fecha_desde'] ?? null;
            $fechaHasta = $data['fecha_hasta'] ?? null;
            error_log('Generando informe de stock: ' . json_encode($data, JSON_UNESCAPED_UNICODE));
            $informe = $this->userInformes->stockPorProductoModel($fechaDesde, $fechaHasta);
            $this->success($informe, 'Informe de stock generado correctamente.');
        } catch (\Throwable $e) {
            error_log('Error al generar informe de stock: ' . $e->getMessage());
            $this->error($e->getMessage(), 500);
        }
    }

    public function pedidosCerradosController(): void
    {
        try {
            $data = $this->getPostJson();

            // Sanitización y extracción de parámetros
            $fechaDesde = !empty($data['fecha_desde']) ? trim($data['fecha_desde']) : null;
            $fechaHasta = !empty($data['fecha_hasta']) ? trim($data['fecha_hasta']) : null;

            // Validación simple de formato Y-m-d o Y-m-d H:i:s
            if ($fechaDesde && !strtotime($fechaDesde)) {
                $this->error('El formato de la fecha inicial es inválido.', 400);
                return;
            }

            if ($fechaHasta && !strtotime($fechaHasta)) {
                $this->error('El formato de la fecha final es inválido.', 400);
                return;
            }

            error_log('Generando informe de pedidos cerrados: ' . json_encode($data, JSON_UNESCAPED_UNICODE));

            // Consulta al modelo
            $informe = $this->userInformes->pedidosCerradosModel($fechaDesde, $fechaHasta);

            // Respuesta estructurada
            $this->success([
                'total_registros' => count($informe),
                'rango_fechas'    => [
                    'desde' => $fechaDesde,
                    'hasta' => $fechaHasta
                ],
                'pedidos'         => $informe
            ], 'Informe de pedidos cerrados generado correctamente.');
        } catch (\Throwable $e) {
            error_log('Error al generar informe de pedidos cerrados: ' . $e->getMessage() . ' en ' . $e->getFile() . ':' . $e->getLine());
            $this->error('Ocurrió un error al procesar el informe de pedidos.', 500);
        }
    }
}
