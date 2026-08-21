<?php

namespace App\Controllers;

use App\Models\Recetas;
use App\Validators\RecetasValidator;
use Exception;

/**
 * Clase RecetasController encargada de gestionar las recetas.
 * 
 * Maneja las peticiones HTTP relacionadas con recetas clínicas/nutricionales.
 * 
 * @author Francisco David Medina Lourenzo <sparkmed0224@gmail.com>
 * @version 1.0.0
 * @package App\Controllers
 */
class RecetasController extends BaseController
{
    private Recetas $recetaModel;
    private RecetasValidator $recetasValidator;

    public function __construct()
    {
        $this->recetaModel = new Recetas();
        $this->recetasValidator = new RecetasValidator();
    }

    // Funciona ✅
    public function crearRecetaController(): void
    {
        try {
            $data = $this->getPostJson();

            $valido = $this->recetasValidator->validarReceta($data);
            if (!$valido) {
                $this->error('Los datos enviados no son válidos o no cumplen con los requisitos.');
                return;
            }

            error_log('Datos recuperados para crear una nueva receta: ' . json_encode($data));

            $recetaId = $this->recetaModel->crearRecetaModel($data);

            $this->success(['id' => $recetaId], 'Receta creada correctamente.');
        } catch (Exception $e) {
            $this->error('Error interno del servidor al crear la receta: ' . $e->getMessage(), 500);
        }
    }

    // Funciona ✅
    public function ultimasRecetasAprobadas(int $paciente_id): void
    {
        try {

            $valido = $this->recetasValidator->validargetRecetasPaciente(['paciente_id' => $paciente_id]);
            if (!$valido) {
                $this->error('Los datos enviados no son válidos o no cumplen con los requisitos.');
                return;
            }

            $recetas = $this->recetaModel->ultimasRecetasAprobadasModel($paciente_id);
            $this->success($recetas, 'Lista de recetas recuperada correctamente.');
        } catch (Exception $e) {
            $this->error('Error al recuperar recetas: ' . $e->getMessage(), 500);
        }
    }

    // Funciona ✅
    public function allRecetasController(): void
    {
        try {
            $usuarios = $this->recetaModel->allRecetasModel();
            $this->success($usuarios, 'Lista de Recetas recuperada correctamente');
        } catch (Exception $e) {
            $this->error('Error al recuperar recetas: ' . $e->getMessage(), 500);
        }
    }


    public function cancelarRecetaController(): void{
        try{
            $data = $this->getPostJson();

            $valido = $this->recetasValidator->validarCancelarReceta($data);
            if (!$valido) {
                $this->error('Los datos enviados no son válidos o no cumplen con los requisitos.');
                return;
            }
            error_log('Datos recuperados para crear una nueva receta: ' . json_encode($data));
            $recetaId = $this->recetaModel->cancelarRecetaModel($data['receta_id'],$data['motivo_rechazo'],$data['usuario_id']);
            $this->success(['id' => $recetaId], 'Receta cancelada correctamente.');
            //$this->success(null, 'Receta cancelada correctamente.');
        }catch(Exception $e){
             $this->error('Error al cancelar la receta: ' . $e->getMessage(), 500);   
        }
    }
}
