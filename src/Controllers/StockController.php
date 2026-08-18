<?php

namespace App\Controllers;

use App\Validators\StockValidator;
use App\Models\Stock;
use Exception;


/**
 * Clase StockController encargargado de validacion 
 * 
 * Maneja las peticiones HTTP.
 * 
 * @author Francisco David Medina Lourenzo <sparkmed0224@gmail.com>
 * @version 1.0.0
 * @package App\Moodels
 */


class StockController extends BaseController
{
    private Stock $stockModel;
    private StockValidator $validator;


    public function __construct()
    {
        $this->stockModel = new Stock();
        $this->validator = new StockValidator();
    }

    // Funciona ✅
    public function crearProductoController(): void
    {
        try {
            $data = $this->getPostJson();

            if (!$this->validator->validarProducto($data)) {
                error_log('Datos inválidos para consulta: ' . json_encode($data));
                $this->error('Los datos enviados no cumplen con el formato requerido.');
                return;
            }
            $producto = $this->stockModel->crearProductoModel($data);

            $this->success([ 'id'=>$producto], 'Agregado con Exito');
        
            } catch (\RuntimeException $e) {
            error_log('Error controlado en crearProductoController: ' . $e->getMessage());
            $this->error($e->getMessage(), 400);
        } catch (\Exception $e) {
            error_log('Error en crearProductoController: ' . $e->getMessage());
            $this->error('Error interno del servidor al registrar la consulta.', 500);
        }
    }


    // Funciona ✅
    public function allProductosController(): void
    {
        try {
            $usuarios = $this->stockModel->allProductosModel();
            $this->success($usuarios, 'Lista de servicios recuperada correctamente');
        } catch (Exception $e) {
            $this->error('Error al recuperar los servicios: ' . $e->getMessage(), 500);
        }
    }
}
