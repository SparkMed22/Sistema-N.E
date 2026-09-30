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
            $informe = $this->userInformes->stockPorProductoModel($fechaDesde,$fechaHasta);
            $this->success($informe,'Informe de stock generado correctamente.');
        } catch (\Throwable $e) {
            error_log('Error al generar informe de stock: ' . $e->getMessage());
            $this->error($e->getMessage(),500);
        }
    }
}
