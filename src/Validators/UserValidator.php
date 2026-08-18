<?php

namespace App\Validators;

use Respect\Validation\Validator as v;

/**
 * Clase UserValidator encargargado de validacion para UserController
 * 
 * @author Francisco David Medina Lourenzo <sparkmed0224@gmail.com>
 * @version 1.0.0
 * @package App\Moodels
 */

class UserValidator
{

    // Funciona ✅
    public function validarRegistro(array $data): bool
    {
        $usuarioValidator = v::key('nombre', v::stringType()->notEmpty()->length(1, 50))
            ->key('apellido', v::stringType()->notEmpty()->length(1, 50))
            ->key('cedula', v::stringType()->notEmpty()->alnum())
            ->key('rol', v::in(['admin', 'internacion', 'nutricionista']))
            ->key('id_servicio',v::intVal()->positive());

        return $usuarioValidator->validate($data);
    }

    // Funciona ✅
    public function validarLogin(array $data): bool
    {
        $usuarioValidator = v::key('cedula', v::stringType()->notEmpty()->length(1, 50)->alnum())
            ->key('password', v::stringType()->notEmpty()->length(1, 255));
        return $usuarioValidator->validate($data);
    }

    public function validarPassword(array $data): bool
    {
        $passwordValidator = v::key('password_new', v::stringType()->notEmpty()->length(6, null))
            ->key('confirm_password', v::stringType()->notEmpty())
            ->key('cedula', v::stringType()->notEmpty()->alnum())
            ->keyValue('confirm_password', 'equals', 'password_new');

        return $passwordValidator->validate($data);
    }

    public function validarActualizacion(array $data): bool
    {
        $actualizarValidator = v::key('id', v::intVal()->positive())
            ->key('rol', v::in(['admin', 'internacion', 'nutricionista']))
            ->key('estado', v::boolVal())
            ->key('id_servicio',v::intVal()->positive());
        return $actualizarValidator->validate($data);
    }
}
