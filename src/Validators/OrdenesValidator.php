<?php

namespace App\Validators;

use Respect\Validation\Validator as v;

/**
 * Clase OrdenesValidator encargargado de validacion para OrdenesController
 * 
 * @author Francisco David Medina Lourenzo <sparkmed0224@gmail.com>
 * @version 1.0.0
 * @package App\Moodels
 */

class OrdenesValidator
{
    public function validarGestionarOrden(array $data): bool
    {
        $productoValidator = v::key('id_producto', v::intVal()->positive())
                              ->key('cantidad', v::numericVal()->positive());

        $validator = v::key('receta_id', v::intVal()->positive())
            ->key('gestionado_usuario_id', v::intVal()->positive())
            ->key('productos', v::arrayVal()->notEmpty()->each($productoValidator));

        return $validator->validate($data);
    }
}