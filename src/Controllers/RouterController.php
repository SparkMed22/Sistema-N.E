<?php

namespace App\Controllers;

use App\Core\Auth;
use Exception;

/**
 * Clase RouterController encargargado de redireccionar 
 * 
 * @author Francisco David Medina Lourenzo <sparkmed0224@gmail.com>
 * @version 1.0.0
 * @package App\Moodels
 */

class  RouterController
{
    
    
    public function test(): void
    {
        require __DIR__ . '/../views/secciones/test.php';
    }

    public function dashboard():void{
        require __DIR__ . '/../views/dash/dashboard.php';
    }


    public function users():void{
        require __DIR__ . '/../views/secciones/users.php';
    }

    public function patients():void{
        require __DIR__ . '/../views/secciones/patients.php';
    }

    public function stock():void{
        require __DIR__ . '/../views/secciones/stock.php';
    }
}
