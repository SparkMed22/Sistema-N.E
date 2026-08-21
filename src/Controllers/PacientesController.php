<?php

namespace App\Controllers;

use App\Models\Patients;
use App\Validators\PacientesValidator;
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


class PacientesController extends BaseController
{
    private Patients $patientModel;
    private PacientesValidator $validator;

    public function __construct()
    {
        $this->patientModel = new Patients();
        $this->validator = new PacientesValidator();
    }

    // Funciona ✅
    public function allPacientesController(): void
    {
        try {
            $usuarios = $this->patientModel->allPacientesModel();
            $this->success($usuarios, 'Lista de usuarios recuperada correctamente');
        } catch (Exception $e) {
            $this->error('Error al recuperar usuarios: ' . $e->getMessage(), 500);
        }
    }

    // Funciona ✅
    public function editarPacienteController(){
        try {
            $data = $this->getPostJson();
            if (!$this->validator->validarEditPaciente($data)) {
                error_log('Datos inválidos para la edicion del paciente: ' . json_encode($data));
                $this->error('Los datos enviados no cumplen con el formato requerido.');
                return;
            }
            $respuesta = $this->patientModel->editarPacienteModel(
                $data['editar_id'],
                $data['editar_nombre'],
                $data['editar_apellido'],
                $data['editar_sexo'],
                $data['editar_fecha_nacimiento'],
                $data['editar_telefono'],
            );
            $this->success($respuesta, 'Edicion Exitosa.');
        } catch (\Exception $e) {
            error_log('Error en editarPacienteConsultaController: ' . $e->getMessage());
            $this->error('Error interno del servidor en Alta medica.', 500);
        }
    }
}
