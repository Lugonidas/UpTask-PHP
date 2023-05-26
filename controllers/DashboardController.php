<?php

namespace Controller;

use Model\Proyecto;
use Model\Usuario;
use MVC\Router;

class DashboardController
{
    public static function perfil(Router $router)
    {
        session_start();
        isAuth();
        $alertas = [];

        $usuario = Usuario::find($_SESSION['id']);

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $usuario->sincronizar($_POST);

            $alertas = $usuario->validarPerfil();
            if (empty($alertas)) {

                $existeUsuario = Usuario::where("email", $usuario->email);

                if ($existeUsuario && $existeUsuario->id !== $usuario->id) {
                    //Mostrar mensaje de error
                    Usuario::setAlerta("error", "Email no válido, cuenta ya registrada");
                    $alertas = Usuario::getAlertas();
                } else {
                    //Guardar al usuario
                    $usuario->guardar();

                    Usuario::setAlerta("exito", "Guardado Correctamente");
                    $alertas = Usuario::getAlertas();

                    //Asignar el nuevo nombre
                    $_SESSION["nombre"] = $usuario->nombre;
                }
            }
        }



        $router->render("dashboard/perfil", [
            "titulo" => "Perfil",
            "alertas" => $alertas,
            "usuario" => $usuario
        ]);
    }

    public static function cambiarPassword(Router $router)
    {
        session_start();
        isAuth();

        $alertas = [];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $usuario = Usuario::find($_SESSION['id']);

            //Sincronizar datos del usuario
            $usuario->sincronizar($_POST);

            $alertas = $usuario->nuevoPassword();

            if (empty($alertas)) {
                $resultado = $usuario->comprobarPassword();

                if ($resultado) {
                    //Asignar el nuevo password
                    $usuario->password = $usuario->passwordNuevo;
                    unset($usuario->passwordActual);
                    unset($usuario->passwordNuevo);

                    //Hashear el nuevo password
                    $usuario->hashPassword();

                    //Actualizar usuario
                    $resultado = $usuario->guardar();

                    if ($resultado) {
                        Usuario::setAlerta("exito", "Contraseña actualizada correctamente");
                        $alertas = Usuario::getAlertas();
                    }
                } else {
                    Usuario::setAlerta("error", "Contraseña incorrecta");
                    $alertas = Usuario::getAlertas();
                }
            }
        }


        $router->render("dashboard/cambiar-password", [
            "titulo" => "Cambiar Passsword",
            "alertas" => $alertas
        ]);
    }

    public static function notFound(Router $router){

        session_start();
        isAuth();
        
        $router->render("/dashboard/not-found", [

        ]);
    }
    
}
