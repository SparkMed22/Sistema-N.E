<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use App\Core\Router;


$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// ? Crear un usuario de prueba (solo para desarrollo)

use App\Models\User;
$userModel = new User();

////$userModel->crearUsuarioModel('Francisco David ','Medina Lourenzo','5483874','admin');
////$userModel->crearUsuarioModel('Evelin ','Caballero','6174947','admin');
////$userModel->crearUsuarioModel('Ana ','Beatriz Sosa','4113268','admin');
////$userModel->crearUsuarioModel('Milagros Aracely ','Aguilera Rios','6015286','admin');
////$userModel->crearUsuarioModel('Javier Moreira','6317350','admin');
////$userModel->crearUsuarioModel('Lilian',' Ramirez Veron','4242619','nutricionista');
////$userModel->crearUsuarioModel('Nathalia ','Vazquez','2999174','internacion');
////$userModel->crearUsuarioModel('Maria del Carmen','Palacios','1631967','internacion');
////$userModel->crearUsuarioModel('Vanessa Elizabeth ',' Surnyak Hatschbach','3873742','internacion');
////$userModel->crearUsuarioModel('Samantha Anglica ',' Villordo Van Nevel','3188244','internacion');
////$userModel->crearUsuarioModel('Camila Alicia Ester ',' Lezcano Molinas','3813193','internacion');
////$userModel->crearUsuarioModel('Rosala Irene','Velzquez Acua','4840690','internacion');
////$userModel->crearUsuarioModel('Patricia Nathalia','Kung Huther','2642937','nutricionista');
////$userModel->crearUsuarioModel('Deolinda Concepcin',' Bordn Rodriguez','3001678','internacion');
////$userModel->crearUsuarioModel('Celia Elizabeth ','Snchez Martinez','3518681','internacion');
////$userModel->crearUsuarioModel('Adriana Gisselle','Maldonado Amatte','4273013','internacion');
////$userModel->crearUsuarioModel('Gricelda Noemi ','Britez Arevalos','3502800','internacion');
////$userModel->crearUsuarioModel('Carina Elizabeth ','Vargas Atencio','3197255','internacion');



$router = new Router();

// ! Ruta de prueba
$router->get('/test','RouterController@test');


// ! Rutas sin Autenticacion
$router->get('/', 'LoginController@index');                
$router->get('/login', 'LoginController@index');           
$router->post('/user-login','UserController@loginController');

// ! Rutas de API (Autenticadas con ->protect())

// ? Rutas Gets 
$router->get('/api/users','UserController@allController')->protect();



// ? Rutas Post
$router->post('/users/update-password','UserController@updatePasswordController')->protect();
$router->post('logout','LoginController@logout')->protect();
$router->post('/api/users', 'UserController@createUsuarioController')->protect();   
$router->post('/api/users/update-data', 'UserController@updateUserController')->protect();   
$router->post('/api/users/update-password','UserController@restartPasswordController')->protect();

//! Rutas para el Front (Autenticadas con ->protect())
$router->get('/start/dashboard', 'RouterController@dashboard')->protect();
$router->get('/start/dashboard/patients', 'RouterController@patients')->protect();
$router->get('/start/dashboard/users', 'RouterController@users')->protect();
$router->get('/start/dashboard/stock', 'RouterController@stock')->protect();




////$router->post('/pacientes/antecedentesSalud', 'PacienteController@guardarAntecedenteSalud')->protect();
////$router->get('/pacientes/{id}/historial-antecedentesSalud', 'PacienteController@obtenerUltimoAntecedenteSalud')->protect();
////$router->get('/test', 'RouterController@test')->protect();
$router->direct();
