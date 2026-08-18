<?php

namespace App\Controllers;

use App\Models\Servicios;
use Exception;


/**
 * Clase UserController encargargado de validacion 
 * 
 * Maneja las peticiones HTTP.
 * 
 * @author Francisco David Medina Lourenzo <sparkmed0224@gmail.com>
 * @version 1.0.0
 * @package App\Moodels
 */


class ServiciosController extends BaseController
{
    private Servicios $serviciosModel;

    public function __construct()
    {
        $this->serviciosModel = new Servicios();
    }

    public function allServiciosController(): void
    {
        try {
            $usuarios = $this->serviciosModel->allServiciosModel();
            $this->success($usuarios, 'Lista de servicios recuperada correctamente');
        } catch (Exception $e) {
            $this->error('Error al recuperar los servicios: ' . $e->getMessage(), 500);
        }
    }
}
