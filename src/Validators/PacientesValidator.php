<?php

namespace App\Validators;

use Respect\Validation\Validator as v;

/**
 * Clase PatientsValidator encargargado de validacion para ConsultaController
 * 
 * @author Francisco David Medina Lourenzo <sparkmed0224@gmail.com>
 * @version 1.0.0
 * @package App\Moodels
 */

class PacientesValidator
{
    // Funciona ✅
    public function validarCrecionPaciente(array $data): bool
    {
        $validator = v::key('nombre', v::stringType()->notEmpty()->length(1, 100))
            ->key('apellido', v::stringType()->notEmpty()->length(1, 100))
            ->key('cedula', v::stringType()->notEmpty()->alnum()->length(7, 15))
            ->key('numero_telefono', v::stringType()->notEmpty()->alnum()->length(7, 15))
            ->key('fechaNacimiento', v::stringType()->notEmpty()->date('Y-m-d'))
            ->key('sexo', v::stringType()->notEmpty()->in(['M', 'F', 'INDEFINIDO']));
        return $validator->validate($data);
    }


    // Funciona ✅
    public function validarEditPaciente(array $data): bool
    {
        $nombreApellidoRule = v::stringType()
            ->notEmpty()
            ->length(1, 100)
            ->callback(function (string $value): bool {
                $limpio = mb_strtolower(trim($value));
                return $limpio !== 'desconocido';
            });

        $validator = v::key('editar_id', v::intVal()->positive())
            ->key('editar_nombre', $nombreApellidoRule)
            ->key('editar_apellido', $nombreApellidoRule)
            ->key('editar_telefono', v::stringType()->notEmpty()->alnum()->length(7, 15))
            ->key('editar_sexo', v::stringType()->notEmpty()->in(['M', 'F']))
            ->key('editar_fecha_nacimiento', v::stringType()->notEmpty()->date('Y-m-d'));
        return $validator->validate($data);
    }
}
