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

class PatientsValidator
{
    // Funciona ✅
    public function validarPaciente(array $data): bool
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
    public function validarIngresoConsulta(array $data): bool
    {
        $cedulaRule = v::stringType()
            ->notEmpty()
            ->regex('/^[A-Za-z0-9_]{7,20}$/');

        $validator = v::key('cedula', $cedulaRule)
            ->key('servicio_id', v::intVal()->positive())
            ->key('usuario_ingreso_id', v::intVal()->positive())
            ->key('usuario_egreso_id', v::optional(v::nullable(v::intVal()->positive())))
            ->key('diagnostico_medico', v::stringType(), false)
            ->key('observaciones_ingreso', v::optional(v::nullable(v::stringType())), false)
            ->key('bloque', v::optional(v::nullable(v::stringType()->length(1, 10))), false)
            ->key('sala', v::optional(v::nullable(v::stringType()->length(1, 10))), false)
            ->key('cama', v::optional(v::nullable(v::stringType()->length(1, 10))), false);

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

    // Funciona ✅
    public function validarEdicionPaciente(array $data): bool
    {
        $nombreApellidoRule = v::stringType()
            ->notEmpty()
            ->length(1, 100)
            ->callback(function (string $value): bool {
                $limpio = mb_strtolower(trim($value));
                return $limpio !== 'desconocido';
            });

        $validator = v::key('editar_id', v::intVal()->positive())
            ->key('edit_consulta', v::intVal()->positive())
            ->key('editar_nombre', $nombreApellidoRule)
            ->key('editar_apellido', $nombreApellidoRule)
            ->key('editar_telefono', v::stringType()->notEmpty()->alnum()->length(7, 15))
            ->key('editar_sexo', v::stringType()->notEmpty()->in(['M', 'F']))
            ->key('editar_bloque', v::stringType()->notEmpty()->length(1, 50))
            ->key('editar_sala', v::stringType()->notEmpty()->length(1, 20))
            ->key('editar_cama', v::stringType()->notEmpty()->length(1, 20))
            ->key('editar_fecha_nacimiento', v::stringType()->notEmpty()->date('Y-m-d')) ;

        return $validator->validate($data);
    }
}
