<?php

namespace App\Controllers;

use App\Models\Patients;
use App\Models\Consultations;

use App\Validators\PatientsValidator;
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


class ConsultationsController extends BaseController
{
    private Patients $patientModel;
    private Consultations $consultationModel;
    private PatientsValidator $validator;

    public function __construct()
    {
        $this->patientModel = new Patients();
        $this->consultationModel = new Consultations();
        $this->validator = new PatientsValidator();
    }

    // Funciona ✅
    public function createConsultaController(): void
    {
        try {
            $data = $this->getPostJson();

            error_log('Datos enviados para consulta: ' . json_encode($data));

            if (!$this->validator->validarIngresoConsulta($data)) {
                error_log('Datos inválidos para consulta: ' . json_encode($data));
                $this->error('Los datos enviados no cumplen con el formato requerido.');
                return;
            }

            $pacienteId = $this->patientModel->existePaciente($data['cedula']);

            $pacienteTemporal = false;

            if ($pacienteId === null) {
                $pacienteId = $this->patientModel->crearPacienteModel(nombre: 'Desconocido', apellido: 'Desconocido', cedula: $data['cedula'],    fechaNacimiento: date('Y') .'-01-01', sexo: 'INDEFINIDO');
                $pacienteTemporal = true;
                error_log('Paciente temporal creado. ID: ' . $pacienteId . ' | CI: ' . $data['cedula']);
            }

            if ($this->consultationModel->tieneConsultaActiva($pacienteId)) {
                $this->error('El paciente ya cuenta con un ingreso o consulta activa en el sistema.', 409);
                return;
            }

            $consultaId = $this->consultationModel->crearConsulta(
                pacienteId: $pacienteId,
                servicioId: (int) $data['servicio_id'],
                usuarioIngresoId: (int) $data['usuario_ingreso_id'],
                diagnostico_medico: $data['diagnostico_medico'],
                observacionesIngreso: $data['observaciones_ingreso'] ?? null,
                bloque: $data['bloque'] ?? null,
                sala: isset($data['sala']) ? (int) $data['sala'] : null,
                cama: isset($data['cama']) ? (int) $data['cama'] : null
            );

            error_log('Consulta creada correctamente. ID: ' . $consultaId . ' | Paciente ID: ' . $pacienteId);

            $this->success([
                'message' => 'Consulta e ingreso registrado correctamente.',
                'consulta_id' => $consultaId,
                'paciente_id' => $pacienteId,
                'paciente_temporal' => $pacienteTemporal
            ]);
        } catch (\RuntimeException $e) {
            error_log('Error controlado en createConsultaController: ' . $e->getMessage());
            $this->error($e->getMessage(), 400);
        } catch (\Exception $e) {
            error_log('Error en createConsultaController: ' . $e->getMessage());
            $this->error('Error interno del servidor al registrar la consulta.', 500);
        }
    }



    // Funciona ✅
    public function allConsultasActivasServicioController(string $rol, int $id_servicio): void
    {
        try {
            $data = ['rol' => $rol, 'id_servicio' => $id_servicio];

            if (!$this->validator->validarPedidioConsultas($data)) {
                error_log('Datos inválidos para solicitar consultas');
                $this->error('Los datos enviados no cumplen con el formato requerido.');
                return;
            }

            error_log('Datos válidos para solicitar consultas');

            $conusultas = $this->consultationModel->allConsultasActivasServicioModel($id_servicio);
            $this->success($conusultas, 'Consultas obtenidas correctamente.');
        } catch (\Exception $e) {
            error_log('Error en allConsultasActivasUsuarioController: ' .  $e->getMessage());
            $this->error('Error interno del servidor al obtener las consultas.', 500);
        }
    }


    // Funciona ✅
    public function allConsultationsController(): void
    {
        try {
            $usuarios = $this->consultationModel->allConsultaModel();
            $this->success($usuarios, 'Lista de usuarios recuperada correctamente');
        } catch (Exception $e) {
            $this->error('Error al recuperar usuarios: ' . $e->getMessage(), 500);
        }
    }


    // Funciona ✅
    public function reasignarConsultaController(): void
    {
        try {
            $data = $this->getPostJson();

            if (!$this->validator->validarUsuarioID_ConsultaID($data)) {
                error_log('Datos inválidos para la reasignacion: ' . json_encode($data));
                $this->error('Los datos enviados no cumplen con el formato requerido.');
                return;
            }

            $respuesta = $this->consultationModel->reasignarConsultaModel($data['id_servicio'], $data['id_consulta']);


            $this->success($respuesta, 'Consulta e ingreso registrado correctamente.');
        } catch (\RuntimeException $e) {
            error_log('Error controlado en createConsultaController: ' . $e->getMessage());
            $this->error($e->getMessage(), 400);
        } catch (\Exception $e) {
            error_log('Error en createConsultaController: ' . $e->getMessage());
            $this->error('Error interno del servidor al registrar la consulta.', 500);
        }
    }

    // Funciona ✅
    public function altaConsultaController(): void
    {
        try {
            $data = $this->getPostJson();

            if (!$this->validator->validarAlta($data)) {
                error_log('Datos inválidos para la alta del paciente: ' . json_encode($data));
                $this->error('Los datos enviados no cumplen con el formato requerido.');
                return;
            }

            $respuesta = $this->consultationModel->altaConsultaModel(
                $data['id_usuario'],
                $data['id_consulta']
            );

            $this->success($respuesta, 'Alta medica con exito.');
        } catch (\RuntimeException $e) {
            error_log('Error controlado en altaConsultaController: ' . $e->getMessage());
            $this->error($e->getMessage(), 400);
        } catch (\Exception $e) {
            error_log('Error en altaConsultaController: ' . $e->getMessage());
            $this->error('Error interno del servidor en Alta medica.', 500);
        }
    }

    public function editarPacienteConsultaController(): void
    {
        try {
            $data = $this->getPostJson();
            if (!$this->validator->validarEdicionPaciente($data)) {
                error_log('Datos inválidos para la edicion del paciente: ' . json_encode($data));
                $this->error('Los datos enviados no cumplen con el formato requerido.');
                return;
            }
            $respuesta = $this->consultationModel->editarConsultaGeneral(
                $data['editar_id'],$data['editar_nombre'],$data['editar_apellido'],$data['editar_sexo'],$data['editar_fecha_nacimiento'],
                $data['edit_consulta'],$data['editar_bloque'],$data['editar_sala'],$data['editar_cama']
            );
            $this->success($respuesta, 'Edicion Exitosa.');
        } catch (\Exception $e) {
            error_log('Error en editarPacienteConsultaController: ' . $e->getMessage());
            $this->error('Error interno del servidor en Alta medica.', 500);
        }
    }
}
