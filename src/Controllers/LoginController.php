<?php

namespace App\Controllers;

use App\Models\User;
use App\Core\Auth;
use Exception;

/**
 * Clase LoginController encargargado de redireccionar 
 * 
 * @author Francisco David Medina Lourenzo <sparkmed0224@gmail.com>
 * @version 1.0.0
 * @package App\Moodels
 */


class LoginController extends BaseController
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    // FUNCIONA ✅
    public function index(): void
    {
        require __DIR__ . '/../index.php';
    }


    // Funciona ✅
    public function logout(): void
    {
        Auth::logout();
        header('Location: /');
        exit;
    }
}