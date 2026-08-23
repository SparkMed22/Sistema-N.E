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
            ->key('creado_por_usuario_id', v::intVal()->positive())
            ->key('indicacion_nutricional', v::stringType()->notEmpty()->length(1, 1000))
            ->key('medida_porcion', v::optional(v::stringType()->length(1, 100)), false)
            ->key('aporte_liquido', v::optional(v::stringType()->length(1, 100)), false)
            ->key('volumen_total', v::optional(v::stringType()->length(1, 100)), false);

        return $validator->validate($data);
    }

    // Funciona ✅
    public function validargetRecetasPaciente(array $data): bool
    {
        $validator = v::key('paciente_id', v::intVal()->positive());
        return $validator->validate($data);
    }

    public function validarCancelarReceta(array $data): bool
    {
        $validator = v::key('receta_id', v::intVal()->positive())
            ->key('usuario_id', v::intVal()->positive())
            ->key('motivo_rechazo', v::stringType()->notEmpty()->length(1, 1000));
        return $validator->validate($data);
    }
}
