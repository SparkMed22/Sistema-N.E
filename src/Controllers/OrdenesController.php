<?php

namespace App\Controllers;

use App\Validators\OrdenesValidator;
use App\Models\Ordenes;
use App\Models\Stock;
use Throwable;

/**
 * Clase UserController encargargado de validacion 
 * 
 * Maneja las peticiones HTTP.
 * 
 * @author Francisco David Medina Lourenzo <sparkmed0224@gmail.com>
 * @version 1.0.0
 * @package App\Moodels
 */


class OrdenesController extends BaseController
{
    private OrdenesValidator $validator;
    private Ordenes $model;

    public function __construct()
    {
        $this->validator = new OrdenesValidator();
        $this->model = new Ordenes();
    }

    public function procesarOrdenController(): void
    {

        try {
            $data = $this->getPostJson();

            if (!$this->validator->validarGestionarOrden($data)) {
                error_log('Datos inválidos para generar la orden: ' . json_encode($data, JSON_UNESCAPED_UNICODE));
                $this->error('Los datos enviados no cumplen con el formato requerido.', 400);
                return;
            }

            
            error_log('Datos validos para generar la orden: ' . json_encode($data, JSON_UNESCAPED_UNICODE));
                

            $this->model->procesarOrderModel($data);

            $this->success(
                [
                    'orden_id'  => 2,
                    'receta_id' => $data['receta_id'],
                    'productos' => $data['productos']
                ],
                'Orden procesada correctamente.'
            );
        } catch (\Throwable $e) {
            error_log('Error al procesar orden: ' . $e->getMessage());
            $this->error($e->getMessage(), 500);
        }
    }
}
