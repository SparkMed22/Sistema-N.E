<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use App\Core\Router;


$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// ? Crear un usuario de prueba (solo para desarrollo)

use App\Models\User;
$userModel = new User();
////$userModel->crearUsuarioModel('Francisco David', 'Medina Lourenzo', '5483874', 'admin');
////$userModel->crearUsuarioModel('Jose', 'Martinez', '123456', 'internacion');
////$userModel->crearUsuarioModel('Enrrique', 'Mereles', '1234567', 'nutricionista');
//// $usuarios = $userModel->obteberUsuarios();
////$login = $userModel->loginModel('554454','554454');
////$userModel->restartPasswordModel('12349');



$router = new Router();

// ! Ruta de prueba
$router->get('/test','RouterController@test');


// ! Rutas sin Autenticacion
$router->get('/', 'LoginController@index');                
$router->get('/login', 'LoginController@index');           
$router->post('/user-login','UserController@loginController');

// ! Rutas de API (Autenticadas con ->protect())

// ? Rutas Gets 
$router->get('users','UserController@allController')->protect();


// ? Rutas Post
$router->post('/users/update-password','UserController@updaetePasswordController')->protect();
$router->post('/users/update-password','UserController@updaetePasswordController')->protect();
$router->post('logout','LoginController@logout')->protect();


$router->post('/users', 'UserController@createUsuarioController')->protect();    


//! Rutas para el Front (Autenticadas con ->protect())
$router->get('/start/dashboard', 'RouterController@dashboard')->protect();
$router->get('/start/dashboard/patients', 'RouterController@patients')->protect();
$router->get('/start/dashboard/users', 'RouterController@users')->protect();
$router->get('/start/dashboard/stock', 'RouterController@stock')->protect();




////$router->post('/pacientes/antecedentesSalud', 'PacienteController@guardarAntecedenteSalud')->protect();
////$router->get('/pacientes/{id}/historial-antecedentesSalud', 'PacienteController@obtenerUltimoAntecedenteSalud')->protect();
////$router->get('/test', 'RouterController@test')->protect();
$router->direct();
