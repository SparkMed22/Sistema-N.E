<?php

namespace App\Validators;

use Respect\Validation\Validator as v;

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
    public function validarProducto(array $data): bool{
        $validator = v::key('nombre',v::stringType()->notEmpty()->length(1, 100))
            ->key('cantidad_inicial',v::intVal()->positive())
            ->key('cantidad_minima',v::intVal()->positive()); 
        return $validator->validate($data);
    }












    
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
    public function validarPaciente(array $data): bool
    {
        $validator = v::key('nombre', v::stringType()->notEmpty()->length(1, 100))
            ->key('apellido', v::stringType()->notEmpty()->length(1, 100))
            ->key('cedula', v::stringType()->notEmpty()->alnum()->length(7, 15))
            ->key('fechaNacimiento', v::stringType()->notEmpty()->date('Y-m-d'))
            ->key('sexo', v::stringType()->notEmpty()->in(['M', 'F', 'INDEFINIDO']));

        return $validator->validate($data);
    }
}
