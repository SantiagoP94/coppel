<?php

namespace Controllers;

use MVC\Router;
use Model\Usuario;
use Model\Crias;


class DashboardController {
    public static function index(Router $router) {

        session_start();
        isAuth();
        $id = $_SESSION['id'];
        $crias = Crias::belongsTo('propietarioId', $id);

        $router->render('dashboard/index', [
            'titulo' => 'Crias',
            'crias' => $crias
        ]);
    }

    public static function crear_crias(Router $router) {
        session_start();
        isAuth();
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cria = new Crias($_POST);

            // validación
            $alertas = $cria->validarProyecto();

            if(empty($alertas)) {
                // Generar una URL única 
                $hash = md5(uniqid());
                $cria->url = $hash;

                // Almacenar el creador del proyecto
                $cria->propietarioId = $_SESSION['id'];

                // Guardar el Proyecto
                $cria->guardar();

                // Redireccionar
                header('Location: /crias?id=' . $cria->url);

            }
        }

        $router->render('dashboard/crear-crias', [
            'alertas' => $alertas,
            'titulo' => 'Crear Cria'
        ]);
    }

    public static function crias(Router $router) {
        session_start();
        isAuth();

        $token = $_GET['id'];
        if(!$token) header('Location: /dashboard');
        // Revisar que la persona que visita el proyecto, es quien lo creo
        $cria = Crias::where('url', $token);
        if($cria->propietarioId !== $_SESSION['id']) {
            header('Location: /dashboard');
        }

        $router->render('dashboard/crias', [
            'titulo' => $cria->nombre
        ]);
    }

    public static function perfil(Router $router) {
        session_start();
        isAuth();
        $alertas = [];

        $usuario = Usuario::find($_SESSION['id']);

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $usuario->sincronizar($_POST);

            $alertas = $usuario->validar_perfil();

            if(empty($alertas)) {

                $existeUsuario = Usuario::where('email', $usuario->email);

                if($existeUsuario && $existeUsuario->id !== $usuario->id ) {
                    // Mensaje de error
                    Usuario::setAlerta('error', 'Email no válido, ya pertenece a otra cuenta');
                    $alertas = $usuario->getAlertas();
                } else {
                    // Guardar el registro
                    $usuario->guardar();

                    Usuario::setAlerta('exito', 'Guardado Correctamente');
                    $alertas = $usuario->getAlertas();

                    // Asignar el nombre nuevo a la barra
                    $_SESSION['nombre'] = $usuario->nombre;
                }
            }
        }
        
        $router->render('dashboard/perfil', [
            'titulo' => 'Perfil',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function cambiar_password(Router $router) {
        session_start();
        isAuth();

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = Usuario::find($_SESSION['id']);

            // Sincronizar con los datos del usuario
            $usuario->sincronizar($_POST);

            $alertas = $usuario->nuevo_password();

            if(empty($alertas)) {
                $resultado = $usuario->comprobar_password();

                if($resultado) {
                    $usuario->password = $usuario->password_nuevo;

                    // Eliminar propiedades No necesarias
                    unset($usuario->password_actual);
                    unset($usuario->password_nuevo);

                    // Hashear el nuevo password
                    $usuario->hashPassword();

                    // Actualizar
                    $resultado = $usuario->guardar();

                    if($resultado) {
                        Usuario::setAlerta('exito', 'Password Guardado Correctamente');
                        $alertas = $usuario->getAlertas();
                    }
                } else {
                    Usuario::setAlerta('error', 'Password Incorrecto');
                    $alertas = $usuario->getAlertas();
                }
            }
        }

        $router->render('dashboard/cambiar-password', [
            'titulo' => 'Cambiar Password',
            'alertas' => $alertas
         ]);
    }
}