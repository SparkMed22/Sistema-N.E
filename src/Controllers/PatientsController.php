<?php

namespace App\Controllers;
use App\Models\Patients;
use Exception;


/**
 * Clase ConsultationsController encargargado de validacion 
 * 
 * Maneja las peticiones HTTP.
 * 
 * @author Francisco David Medina Lourenzo <sparkmed0224@gmail.com>
 * @version 1.0.0
 * @package App\Moodels
 */


class PatientsController extends BaseController
{
    private Patients $patientModel;

    public function __construct()
    {
        $this->patientModel = new Patients();
    }

    public function allPatientsController(): void
    {
        try {
            $usuarios = $this->patientModel->allPacientesModel();
            $this->success($usuarios, 'Lista de usuarios recuperada correctamente');
        } catch (Exception $e) {
            $this->error('Error al recuperar usuarios: ' . $e->getMessage(), 500);
        }
    }
}
