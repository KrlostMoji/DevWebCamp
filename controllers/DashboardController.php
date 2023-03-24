<?php

namespace Controllers;

use Model\Evento;
use MVC\Router;
use Model\Paquete;
use Model\Usuario;
use Model\Registro;

class DashboardController {

    public static function index(Router $router){
        if(!is_auth()){
            header('Location: /login');
        }

        if(!is_admin()){
            header('Location: /login');
        }

        //Obtener los últimos 5 registros
        $registros = Registro::get(5);
        foreach($registros as $registro){
            $registro->usuario = Usuario::find($registro->usuario_id);
            $registro->paquete = Paquete::find($registro->paquete_id);
        }

        //Calcular los ingresos por pases de paga.
        $virtual_totales = Registro::total('paquete_id', 2);
        $presencial_totales = Registro::total('paquete_id', 1);

        $ingreso_total = ($virtual_totales*53.89) + ($presencial_totales*219.92);


        //Obtener eventos de acuerdo al top alto y bajo de lugares disponibles
        $mayor_disponibilidad = Evento::ordenarLimite('disponibles', 'ASC', 5);
        $menor_disponibilidad = Evento::ordenarLimite('disponibles', 'DESC', 5);  

        $router->render('admin/dashboard/index', [
            'titulo' => 'Panel de Administración',
            'registros' => $registros,
            'ingresos' => $ingreso_total,
            'mayor_disponibilidad' => $mayor_disponibilidad,
            'menor_disponibilidad' => $menor_disponibilidad

        ]);
    }

}