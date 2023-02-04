<?php

namespace Controllers;

use Model\Dia;
use MVC\Router;
use Model\Horas;
use Model\Evento;
use Model\Regalo;
use Model\Paquete;
use Model\Ponente;
use Model\Usuario;
use Model\Registro;
use Model\Categoria;
use Model\EventosRegistros;

use function PHPSTORM_META\type;

class RegistroController {

    public static function crear(Router $router){

        if(!is_auth()){
            header('Location: /');
            return;

        }

        //Verificar si el usuario ya completó su registro
        $registro = Registro::where('usuario_id', $_SESSION['id']);
        

        if(isset($registro) && ($registro->paquete_id === '3' || $registro->paquete_id === '2' )){
            
            header('Location: /boleto?id=' . urlencode($registro->token));
            return;

        }

        if( isset($registro) && ($registro->pago_id !== '')){
            header('Location: /finalizar-registro/conferencias');
            return;

        }

        $router->render('registro/crear', [
            'titulo' => 'Finalizar registro'
        ]);

    }

    public static function gratis(Router $router){
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!is_auth()){
                header('Location: /login');
                return;

            }

            //Verificar si el usuario ya completó su registro
            $registro = Registro::where('usuario_id', $_SESSION['id']);

            if(isset($registro) && $registro->paquete_id === '3'){
                header('Location: /boleto?id=' . urlencode($registro->token));
                return;

            }

            $token = substr(md5(uniqid(rand(), true)), 0, 8);

            //Crear Registro
            $datos = [
                'paquete_id' => 3,
                'pago_id' => '',
                'token' => $token,
                'usuario_id' => $_SESSION['id']
            ];

            $registro = new Registro($datos);
            $resultado = $registro->guardar();

            if($resultado){
                header('Location: /boleto?id=' . urlencode($registro->token));
                return;

            }

        }

    }

    public static function boleto(Router $router){
        //Validar la URL
        $id = $_GET['id'];
        
        if(!$id || (!strlen($id) === 8)){
            header('Location: /');
            return;

        }

        $registro = Registro::where('token', $id);
        if(!$registro){
            header('Location: /');
            return;

        }

        //Llenar las tablas referenciadas
        $registro->usuario = Usuario::find($registro->usuario_id);
        $registro->paquete = Paquete::find($registro->paquete_id);

        $router->render('registro/boleto', [
            'titulo' => 'Asistencia a DevWebCamp',
            'registro' => $registro
        ]);

    }

    public static function pagar(Router $router){
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!is_auth()){
                header('Location: /login');
                return;

            }

            //validar que POST no esté vacío
            if(empty($_POST)){
                echo json_encode([]);
                return;
            }

            $token = substr(md5(uniqid(rand(), true)), 0, 8);

            //Crear Registro
            $datos = $_POST;
            $datos['token'] = $token;
            $datos['usuario_id'] = $_SESSION['id'];

            
            
            try {
                $registro = new Registro($datos);
                $resultado = $registro->guardar();
                //debuguear($registro);
                echo json_encode($resultado);

            } catch (\Throwable $th) {
                echo json_encode([
                    'resultado' => 'error'
                ]);
            }


        }

    }

    public static function conferencias(Router $router){
        if(!is_auth()){
            header('Location: /login');
            return;

        }

        //Validar que se haya hecho el pago para presencial
        $usuario_id = $_SESSION['id'];
        $registro = Registro::where('usuario_id', $usuario_id);

        if(isset($registro) && $registro->paquete_id !== '1'){
            header('Location: /boleto?id='. urlencode($registro->token));
            return;

        }

        //Redireccionar al usuario si ya finalizó el registro 
        if(isset($registro) && ($registro->regalo_id !== '10')){
            header('Location: /boleto?id='. urlencode($registro->token));
            return;

        }

        $eventos = Evento::ordenar('hora_id', 'ASC');

        $eventos_formateados = [];

        foreach($eventos as $evento){
            $evento->categoria = Categoria::find($evento->categoria_id);
            $evento->dia = Dia::find($evento->dia_id);
            $evento->hora = Horas::find($evento->hora_id);
            $evento->ponente = Ponente::find($evento->ponente_id);
            
            if($evento->dia_id === '1' && $evento->categoria_id === '1'){
                $eventos_formateados['conferencias_v'][] = $evento;
            }

            if($evento->dia_id === '2' && $evento->categoria_id === '1'){
                $eventos_formateados['conferencias_s'][] = $evento;
            }
 
            if($evento->dia_id === '1' && $evento->categoria_id === '2'){
                $eventos_formateados['workshops_v'][] = $evento;
            }

            if($evento->dia_id === '2' && $evento->categoria_id === '2'){
                $eventos_formateados['workshops_s'][] = $evento;
            }

        }

        $regalos = Regalo::all();


        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!is_auth()){
                header('Location: /login');
                return;
    
            }

            $eventos = explode(',', $_POST['eventos']);
            if(empty($eventos)){
                echo json_encode(['resultado' => false]);
                return;
    
            }

            //Obtener el registro del usuario en sesión
            $registro = Registro::where('usuario_id', $_SESSION['id']);
            if(!isset($registro) || $registro->paquete_id !== "1"){
                echo json_encode(['resultado' => false]);
                return;

            }

            //Arreglo para validar que haya lugares en los eventos seleccionados por el usuario
            $eventos_array = [];

            //Validar la disponibilidad del evento
            foreach($eventos as $evento_id){
                $evento = Evento::find($evento_id);
                //Comprobar que el evento exista
                if(!isset($evento) || $evento->disponibles === '0'){
                    echo json_encode(['resultado' => false]);
                    return;

                } 
                $eventos_array[]= $evento;
                
            }

            foreach($eventos_array as $evento){

                $evento->disponibles -= 1;
                $evento->guardar();

                //Almacenar el registro de cada evento
                $datos = [
                    'evento_id' => (int) $evento->id,
                    'registro_id' => (int) $registro->id
                ];
                
                $registro_usuario = new EventosRegistros($datos);
                $registro_usuario->guardar();
                
                }
                
                //Almacenar el regalo
                $registro->sincronizar(['regalo_id' => $_POST['regalo_id']]);
                $resultado = $registro->guardar();
                

                if($resultado){
                    echo json_encode([
                        'resultado' => $resultado, 
                        'token' => $registro->token   
                         
                ]);
                return; 
                
                } else {
                    echo json_encode(['resultado' => false]);
                    return;

                }
                   

            }


        $router->render('registro/conferencias', [
            'titulo' => 'Conferencias y Workshops DevWebCamp',
            'eventos' => $eventos_formateados,
            'regalos' => $regalos

        ]);

    }

}

?>