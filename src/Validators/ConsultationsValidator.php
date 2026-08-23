<?php

namespace App\Validators;

use Respect\Validation\Validator as v;

/**
 * Clase ConsultationsValidator encargargado de validacion para ConsultaController
 * 
 * @author Francisco David Medina Lourenzo <sparkmed0224@gmail.com>
 * @version 1.0.0
 * @package App\Moodels
 */

class ConsultationsValidator
{


    // Funciona ✅
    public function validarIngresoConsulta(array $data): bool
    {
        $cedulaRule = v::stringType()
            ->notEmpty()
            ->regex('/^[A-Za-z0-9_]{7,20}$/');

        $validator = v::key('cedula', $cedulaRule)
            ->key('servicio_id',v::intVal()->positive())
            ->key('usuario_ingreso_id',v::intVal()->positive())
            ->key('usuario_egreso_id',v::optional(v::nullable(v::intVal()->positive())))
            ->key('diagnostico_medico', v::stringType()->notEmpty())
            ->key('observaciones_ingreso',v::optional(v::nullable(v::stringType()->length(1, 1000))))
            ->key('bloque',v::optional(v::nullable(v::stringType()->length(1, 10))))
            ->key('sala',v::optional(v::nullable(v::stringType()->length(1, 10))))
            ->key('cama', v::optional(v::nullable(v::stringType()->length(1, 10))));
        return $validator->validate($data);
    }



    // Funciona ✅
    public function validarPedidioConsultas(array $data): bool
    {
        $validator = v::key('id_servicio', v::intVal()->positive())
            ->key('rol', v::stringType()->notEmpty()->in(['admin', 'internacion', 'nutricionista']));

        return $validator->validate($data);
    }

    // Funciona ✅
    public function validarUsuarioID_ConsultaID(array $data): bool
    {
        $validator = v::key('id_servicio',    v::intVal()->positive())
            ->key('id_consulta',    v::intVal()->positive());
        return $validator->validate($data);
    }

    // Funciona ✅
    public function validarAlta(array $data): bool
    {
        $validator = v::key('id_usuario',    v::intVal()->positive())
            ->key('id_consulta',    v::intVal()->positive());
        return $validator->validate($data);
    }


    public function validarEdicionConsulta(array $data): bool
    {
        $validator = v::key('edit_consulta', v::intVal()->positive())
            ->key('editar_bloque', v::stringType()->notEmpty()->length(1, 50))
            ->key('editar_sala', v::stringType()->notEmpty()->length(1, 20))
            ->key('editar_cama', v::stringType()->notEmpty()->length(1, 20));

        return $validator->validate($data);
    }
}
