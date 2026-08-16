<?php

namespace App\Controllers;

use App\Models\User;
use App\Core\Auth;
use App\Validators\UserValidator;
use Exception;
use RuntimeException;


/**
 * Clase UserController encargargado de validacion 
 * 
 * Maneja las peticiones HTTP.
 * 
 * @author Francisco David Medina Lourenzo <sparkmed0224@gmail.com>
 * @version 1.0.0
 * @package App\Moodels
 */


class UserController extends BaseController
{
    private User $userModel;
    private UserValidator $userValidator;

    public function __construct()
    {
        $this->userModel = new User();
        $this->userValidator = new UserValidator();
    }

    // Funciona ✅
    public function loginController(): void
    {
        try {
            $data = $this->getPostJson();
            $valido = $this->userValidator->validarLogin($data);

            if (!$valido) {
                $this->error('Cédula y contraseña son requeridos y deben tener formato válido.', 400);
                return;
            }

            $usuarioLogin = $this->userModel->loginModel($data['cedula'], $data['password']);

            if (!$usuarioLogin) {
                $this->error('Credenciales inválidas.', 401);
                return;
            }

            $usuarioSeguro = [
                'id' => $usuarioLogin->id,
                'nombre' => $usuarioLogin->nombre,
                'apellido' => $usuarioLogin->apellido,
                'cedula' => $usuarioLogin->cedula,
                'rol' => $usuarioLogin->rol,
                'estado' => $usuarioLogin->estado,
                'primer_ingreso' => $usuarioLogin->primer_ingreso
            ];

            Auth::login($usuarioLogin->id, $usuarioLogin->rol, $usuarioSeguro);

            error_log('Usuario logueado correctamente: ' . $usuarioLogin->cedula);

            $this->success($usuarioSeguro, 'Login exitoso.');
        } catch (Exception $e) {
            $this->error('Error interno del servidor: ' . $e->getMessage(), 500);
        }
    }


    //Funciona ✅
    public function updatePasswordController(): void
    {
        try {
            $data = $this->getPostJson();
            $valido = $this->userValidator->validarPassword($data);

            if (!$valido) {
                $this->error('Información no válida para el cambio de contraseña.', 400);
                return;
            }

            $resultado = $this->userModel->updatePasswordModel($data['cedula'], $data['password_new']);

            if (!$resultado) {
                $this->error('No se pudo restablecer la contraseña. Usuario no encontrado o error en BD.', 400);
                return;
            }

            $this->success(null, 'Contraseña restablecida correctamente.');
        } catch (Exception $e) {
            error_log('Error en updatePasswordController: ' . $e->getMessage());
            $this->error('Error interno del servidor: ' . $e->getMessage(), 500);
        }
    }

    public function restartPasswordController(): void
    {
        try {
            $data = $this->getPostJson();
            $valido = $this->userValidator->validarPassword($data);

            if (!$valido) {
                $this->error('Información no válida para el cambio de contraseña.', 400);
                return;
            }
            $resultado = $this->userModel->restartPasswordModel($data['cedula']);
            if (!$resultado) {
                $this->error('No se pudo restablecer la contraseña. Usuario no encontrado o error en BD.', 400);
                return;
            }
            $this->success(null, 'Contraseña restablecida correctamente.');
        } catch (Exception $e) {
            error_log('Error en updatePasswordController: ' . $e->getMessage());
            $this->error('Error interno del servidor: ' . $e->getMessage(), 500);
        }
    }

    //Funciona ✅
    public function updateUserController(): void
    {
        try {
            $data = $this->getPostJson();
            $valido = $this->userValidator->validarActualizacion($data);

            if (!$valido) {
                $this->error('Informacion no valida.', 400);
                return;
            }

            $usuarioEdit = $this->userModel->updateUserModel($data['id'], $data['rol'], $data['estado']);

            if (!$usuarioEdit) {
                $this->error('Error al Actualizar Usuario.', 401);
                return;
            }
            ////error_log('Datos recuperados: ' . json_encode($usuarioEdit));
            $this->success($usuarioEdit, 'Login exitoso.');
        } catch (Exception $e) {
            $this->error('Error interno del servidor: ' . $e->getMessage(), 500);
        }
    }

    // Funciona ✅
    public function createUsuarioController(): void
    {
        try {
            $data = $this->getPostJson();
            $valido = $this->userValidator->validarRegistro($data);
            if (!$valido) {
                $this->error('Los datos enviados no son válidos o no cumplen con los requisitos.');
                return;
            }

            $usuarioLogin = $this->userModel->crearUsuarioModel(
                $data['nombre'],
                $data['apellido'],
                $data['cedula'],
                $data['rol']
            );

            ////error_log('Datos recuperados para crear un usuario nuevo: ' . json_encode($data));

            $this->success([
                'id' => $usuarioLogin,
                'message' => 'Usuario creado correctamente.'
            ]);
        } catch (Exception $e) {
            $this->error('Error interno del servidor al crear el nuevo usuario:' . $e->getMessage(), 500);
        }
    }

    // Funciona ✅
    public function allController(): void
    {
        try {
            $usuarios = $this->userModel->allModel();
            $this->success($usuarios, 'Lista de usuarios recuperada correctamente');
        } catch (Exception $e) {
            $this->error('Error al recuperar usuarios: ' . $e->getMessage(), 500);
        }
    }

    // Funciona ✅
    public function allDataUseController(): void
    {
        try {
            $usuarios = $this->userModel->allDataUserModel();
            $this->success($usuarios, 'Lista de usuarios recuperada correctamente');
        } catch (Exception $e) {
            $this->error('Error al recuperar usuarios: ' . $e->getMessage(), 500);
        }
    }
}
