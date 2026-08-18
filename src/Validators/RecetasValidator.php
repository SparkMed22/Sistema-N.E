<?php

namespace App\Validators;

use Respect\Validation\Validator as v;

/**
 * Clase PatientsValidator encargargado de validacion para ResetasController
 * 
 * @author Francisco David Medina Lourenzo <sparkmed0224@gmail.com>
 * @version 1.0.0
 * @package App\Moodels
 */

class RecetasValidator
{
    // Funciona ✅
    public function validarReceta(array $data): bool
    {
        $validator = v::key('consulta_id', v::intVal()->positive())
            ->key('usuarios_id', v::intVal()->positive())
            ->key('indicacion_nutricional', v::stringType()->notEmpty()->length(1, 1000))
            ->key('medida_porcion', v::optional(v::stringType()->length(1, 100)), false)
            ->key('aporte_liquido', v::optional(v::stringType()->length(1, 100)), false)
            ->key('volumen_total', v::optional(v::stringType()->length(1, 100)), false);

        return $validator->validate($data);
    }
}
