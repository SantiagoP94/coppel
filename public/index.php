<?php 

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\DatosController;
use Controllers\LoginController;
use Controllers\DashboardController;

$router = new Router();

// Login
$router->get('/', [LoginController::class, 'login']);
$router->post('/', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);
// Crear Cuenta
$router->get('/crear', [LoginController::class, 'crear']);
$router->post('/crear', [LoginController::class, 'crear']);
// Formulario de olvide mi password
$router->get('/olvide', [LoginController::class, 'olvide']);
$router->post('/olvide', [LoginController::class, 'olvide']);
// Colocar el nuevo password
$router->get('/reestablecer', [LoginController::class, 'reestablecer']);
$router->post('/reestablecer', [LoginController::class, 'reestablecer']);
// Confirmación de Cuenta
$router->get('/mensaje', [LoginController::class, 'mensaje']);
$router->get('/confirmar', [LoginController::class, 'confirmar']);
// ZONA DE PROYECTOS
$router->get('/dashboard', [DashboardController::class, 'index']);
$router->get('/crear-crias', [DashboardController::class, 'crear_crias']);
$router->post('/crear-crias', [DashboardController::class, 'crear_crias']);
$router->get('/crias', [DashboardController::class, 'crias']);
$router->get('/perfil', [DashboardController::class, 'perfil']);
$router->post('/perfil', [DashboardController::class, 'perfil']);
$router->get('/cambiar-password', [DashboardController::class, 'cambiar_password']);
$router->post('/cambiar-password', [DashboardController::class, 'cambiar_password']);
// API para las tareas
$router->get('/api/tareas', [DatosController::class, 'index']);
$router->post('/api/tarea', [DatosController::class, 'crear']);
$router->post('/api/tarea/actualizar', [DatosController::class, 'actualizar']);
$router->post('/api/tarea/eliminar', [DatosController::class, 'eliminar']);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();