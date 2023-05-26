<?php

namespace Controller;

use MVC\Router;

class UptaskController{

    public static function index(Router $router){
        

        //Render a la vista
        $router->render("inicio/index", [
            
        ]);
    }
}