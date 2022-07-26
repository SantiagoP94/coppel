<?php

namespace Controllers;

use Model\Crias;
use Model\Datos;

class DatosController {
    public static function index() {        
        $criaId = $_GET['id'];


        if(!$criaId) header('Location: /dashboard');

        $cria = Crias::where('url', $criaId);

        session_start();

        if(!$cria || $cria->propietarioId !== $_SESSION['id']) header('Location: /404');

        $crias = Datos::belongsTo('criaId', $cria->id);

        echo json_encode(['datos' => $crias]);
    }

    public static function crear() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            session_start();

            $criaId = $_POST['criaId'];
            

            $cria = Crias::where('url', $criaId);

            if(!$cria || $cria->propietarioId !== $_SESSION['id']) {
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un Error al agregar los datos'
                ];
                echo json_encode($respuesta);
                return;
            }
            
            // Todo bien, instanciar y crear la tarea
            $datos = new Datos($_POST);
            $datos->criaId = $cria->id;
            $resultado = $datos->guardar();
            $respuesta = [
                'tipo' => 'exito',
                'id' => $resultado['id'],
                'mensaje' => 'Datos Registrados Correctamente',
                'criaId' => $cria->id
            ];
            echo json_encode($respuesta);
        }
    }

    public static function actualizar() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar que el proyecto exista
            $proyecto = Crias::where('url', $_POST['proyectoId']);

            session_start();

            if(!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) {
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un Error al actualizar la tarea'
                ];
                echo json_encode($respuesta);
                return;
            } 

            $tarea = new Datos($_POST);
            $tarea->proyectoId = $proyecto->id;

            $resultado = $tarea->guardar();
            if($resultado) {
                $respuesta = [
                    'tipo' => 'exito',
                    'id' => $tarea->id,
                    'proyectoId' => $proyecto->id,
                    'mensaje' => 'Actualizado correctamente'
                ];
                echo json_encode(['respuesta' => $respuesta]);
            }

        }
    }

    public static function eliminar() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Validar que el proyecto exista
            $proyecto = Crias::where('url', $_POST['proyectoId']);

            session_start();

            if(!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) {
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un Error al actualizar la tarea'
                ];
                echo json_encode($respuesta);
                return;
            } 

            $tarea = new Datos($_POST);
            $resultado = $tarea->eliminar();


            $resultado = [
                'resultado' => $resultado,
                'mensaje' => 'Eliminado Correctamente',
                'tipo' => 'exito'
            ];
            
            echo json_encode($resultado);
        }
    }
}