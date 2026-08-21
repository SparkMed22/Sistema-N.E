<?php

namespace App\Validators;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\ValidationException;

/**
 * Clase StockController encargargado de validacion para StockController
 * 
 * @author Francisco David Medina Lourenzo <sparkmed0224@gmail.com>
 * @version 1.0.0
 * @package App\Moodels
 */

class StockValidator
{
    // Funciona ✅
    public function validarProducto(array $data): bool
    {
        $validator = v::key('nombre', v::stringType()->notEmpty()->length(1, 100))
            ->key('cantidad_inicial', v::intVal()->min(0))
            ->key('cantidad_minima', v::intVal()->positive());
        return $validator->validate($data);
    }


    // Funciona ✅
    public function validarIngresoProducto(array $data): bool
    {
        $validator = v::key('productoId', v::intVal()->positive())
            ->key('usuarioId', v::intVal()->positive())
            ->key('cantidad', v::intVal()->positive())
            ->key('motivo', v::stringType()->notEmpty()->length(1, 1000));
        return $validator->validate($data);
    }

    // Funciona ✅
    public function validarRetiroProducto(array $data): void
    {
        $validator = v::keySet(
            v::key('productoId', v::intVal()->positive()),
            v::key('usuarioId', v::intVal()->positive()),
            v::key('cantidad', v::intVal()->positive()),
            v::key('motivo', v::stringType()->notEmpty()->length(1, 1000)),
            v::key('pedidoId',v::nullable(v::intVal()->positive()),false)
        );
        try {
            $validator->assert($data);
        } catch (ValidationException $e) {
            error_log('ERROR VALIDACION: ' . $e);
            throw $e;
        }
    }
}
