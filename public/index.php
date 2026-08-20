<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use App\Core\Router;


$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// ? Crear un usuario de prueba (solo para desarrollo)

use App\Models\User;
$userModel = new User();
////$userModel->crearUsuarioModel('Celia Elizabeth ','Snchez Martinez','3518681','internacion');
////$userModel->crearUsuarioModel('Adriana Gisselle','Maldonado Amatte','4273013','internacion');
////$userModel->crearUsuarioModel('Gricelda Noemi ','Britez Arevalos','3502800','internacion');
////$userModel->crearUsuarioModel('Carina Elizabeth ','Vargas Atencio','3197255','internacion');
// ! Nuevos datos

//// ? Administracion
//$userModel->crearUsuarioModel('Francisco David ','Medina Lourenzo','5483874','admin',1);
//$userModel->crearUsuarioModel('Ana Beatriz','Sosa','4113268','admin',1);
//$userModel->crearUsuarioModel('Evelin Diana','Caballero','6174947','admin',1);

//// ? Nutricionistas e Internacion
//$userModel->crearUsuarioModel('Patricia Nathalia','Küng Hüther','2642937','nutricionista',1);
//$userModel->crearUsuarioModel('Lilian Elizabeth',' Ramirez Veron','4242619','nutricionista',1);
//$userModel->crearUsuarioModel('Luis','Simon','3873856','internacion',11); 
//$userModel->crearUsuarioModel('Vanessa','Surnyak','3873742','internacion',2); 
//$userModel->crearUsuarioModel('Maria del Carmen','Palacios','1631967','internacion',6);
//$userModel->crearUsuarioModel('Sandra','Martínez Corvalán ','3171037','internacion',12);
//$userModel->crearUsuarioModel('Nathalia ','Vazquez','2999174','internacion',3);
//$userModel->crearUsuarioModel('Camila Alicia Ester','Lezcano Molinas','3813193','internacion',2);
//$userModel->crearUsuarioModel('Deolinda  Concepción','Bordón Rodriguez ','3001678','internacion',4);

//// ! Diagnóstico que se escriba solo al ingresar al paciente y no cada vez que se tenga que pedir una formula. (Listo) 
//$userModel->crearUsuarioModel('Samantha','Villordo','3188244','internacion',6); 

//// ! Información nutricional de formula y reconstitución para 1 toma
//$userModel->crearUsuarioModel('Rosala Irene','Velzquez','4840690','internacion',4);


// * ME QUEDE EN EL  10 DEL FOMRULARIO


use App\Models\Patients;
use App\Models\Consultations;
use App\Models\Recetas;

$pacientesModel = new Patients();
$consultasModel = new Consultations();
$recetasModel = new Recetas();

//$consultasModel->altaConsultaModel(1,21);
//$pacientesModel->crearPacienteModel("Carlos","Benítez","4567890","1992-05-14","M");
//var_dump( $pacientesModel->buscarPorCedula("45678900"));

//$consultasModel->reasignarConsulta(7,15);

//var_dump($consultasModel->allConsultasActivasUsuarioModel(4,'internacion'));

//var_dump($recetasModel->ultimasRecetasAprobadas(1));


// ! Rutas del S.N.E

$router = new Router();

// ! Ruta de prueba
$router->get('/test','RouterController@test');


// ! Rutas sin Autenticacion
$router->get('/', 'LoginController@index');                
$router->get('/login', 'LoginController@index');           
$router->post('/api/users/login','UserController@loginController');
$router->get('/api/servicios','ServiciosController@allServiciosController');

// ! Rutas de API (Autenticadas con ->protect())

// ? Rutas Gets 
$router->get('/api/users','UserController@allController')->protect();
$router->get('/api/users/activos','UserController@allDataUseController')->protect();
$router->get('/api/patients','PatientsController@allPatientsController')->protect();
$router->get('/api/consultation','ConsultationsController@allConsultationsController')->protect();
$router->get('/api/{rol}/consultation/{servicio_id}/activas','ConsultationsController@allConsultasActivasServicioController')->protect();

$router->get('/api/stock/productos','StockController@allProductosController')->protect();


// ? Rutas Post
$router->post('/users/update-password','UserController@updatePasswordController')->protect();
$router->post('logout','LoginController@logout')->protect();
$router->post('/api/users', 'UserController@createUsuarioController')->protect();   
$router->post('/api/users/update-data', 'UserController@updateUserController')->protect();   
$router->post('/api/users/update-password','UserController@restartPasswordController')->protect();
$router->post('/api/consultation','ConsultationsController@createConsultaController')->protect();
$router->post('/api/consultation/reasignar','ConsultationsController@reasignarConsultaController')->protect();
$router->post('/api/consultation/alta','ConsultationsController@altaConsultaController')->protect();
$router->post('/api/consultation/editar','ConsultationsController@editarPacienteConsultaController')->protect();


$router->post('/api/stock/productos','StockController@crearProductoController')->protect();

// TODO: Corregir
$router->post('/api/recetas','RecetasController@crearRecetaController')->protect();


//! Rutas para el Front (Autenticadas con ->protect())
$router->get('/start/dashboard', 'RouterController@dashboard')->protect();
$router->get('/start/dashboard/patients', 'RouterController@patients')->protect();
$router->get('/start/dashboard/users', 'RouterController@users')->protect();
$router->get('/start/dashboard/stock', 'RouterController@stock')->protect();
$router->get('/start/dashboard/orders', 'RouterController@orders')->protect();

$router->direct();
