<?php

namespace Controller;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController
{

    public static function login(Router $router)
    {
        //Arreglo de alertas
        $alertas = [];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $usuario = new Usuario($_POST);

            $alertas = $usuario->validarLogin();

            if (empty($alertas)) {
                //Verificar que el usuario exista
                $usuario = Usuario::where("email", $usuario->email);
                if (!$usuario || !$usuario->confirmado) {
                    Usuario::setAlerta("error", "El usuario no existe o no esta confirmado");
                } else {
                    //Verificar que el password sea correcto
                    if (password_verify($_POST["password"], $usuario->password)) {

                        //Inicar la sesión del usuario
                        session_start();

                        //Llenar el arreglo de $_SESSION[]
                        $_SESSION["id"] = $usuario->id;
                        $_SESSION["nombre"] = $usuario->nombre;
                        $_SESSION["email"] = $usuario->email;
                        $_SESSION["login"] = true;

                        //Redireccionar
                        header("Location: /proyectos");
                    } else {
                        Usuario::setAlerta("error", "La contraseña es incorrecta");
                    }
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render("auth/login", [
            "titulo" => "Iniciar Sesión",
            "alertas" => $alertas
        ]);
    }

    public static function logout()
    {
        session_start();
        $_SESSION = [];
        header("Location: /");
    }

    public static function crear(Router $router)
    {
        $alertas = [];
        $usuario = new Usuario;

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            if (empty($alertas)) {
                //Verifica si el usuario ya esta registrado a través de su email
                $existeUsuario = Usuario::where("email", $usuario->email);

                //Verifica el resultado de $existeUsuario
                if ($existeUsuario) {
                    Usuario::setAlerta("error", "El Usuario ya está registrado");
                    $alertas = Usuario::getAlertas();
                } else {
                    //Hashea el password
                    $usuario->hashPassword();

                    //Elimina el password2 del modelo de usuario
                    unset($usuario->password2);

                    //Crea el tokén
                    $usuario->crearToken();

                    //Guardar el nuevo usuario
                    $resultado = $usuario->guardar();

                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();

                    if ($resultado) {


                        //Envia el email al usuario

                        //Redirige al usuario
                        header("Location: /mensaje");
                    }
                }
            }
        }

        $router->render("auth/crear", [
            "titulo" => "Crea tu cuenta en UpTask",
            "usuario" => $usuario,
            "alertas" => $alertas
        ]);
    }
    public static function olvide(Router $router)
    {

        $alertas = [];
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarEmail();

            if (empty($alertas)) {
                //Buscar al usuario
                $usuario = Usuario::where("email", $usuario->email);

                if ($usuario && $usuario->confirmado) {
                    //Generar nuevo tokén
                    $usuario->crearToken();

                    //Eliminar la variable password2
                    unset($usuario->password2);

                    //Actualizar al usuario
                    $usuario->guardar();

                    //Enviar el email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->reestablecerPassword();

                    //Imprimir alerta
                    Usuario::setAlerta("exito", "Hemos enviado las instrucciones a tu email");
                } else {
                    //No encuentra al usuario
                    Usuario::setAlerta("error", "El usuario no existe o no está confirmado");
                }
            }
        }
        $alertas = Usuario::getAlertas();

        $router->render("auth/olvide", [
            "titulo" => "Recupera tu contraseña",
            "alertas" => $alertas
        ]);
    }
    public static function reestablecer(Router $router)
    {

        $mostrar = true;
        $alertas = [];
        $token = s($_GET["token"]);

        if (!$token) header("Location: /");

        //Identificar al usuario con el tokén
        $usuario = Usuario::where("token", $token);

        if (empty($usuario)) {
            Usuario::setAlerta("error", "Tokén no válido");
            $mostrar = false;
        }
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            //Añadir el nuevo password
            $usuario->sincronizar($_POST);

            //Validar el password
            $alertas = $usuario->validarPassword();

            if (empty($alertas)) {
                //Hashea el password
                $usuario->hashPassword();

                //Eliminar la variable password2
                unset($usuario->password2);

                //Eliminar tokén
                $usuario->token = "";

                //Guardar en la DB
                $resultado = $usuario->guardar();

                //Redireccionar al usuario
                if ($resultado) {
                    header("Location: /login");
                }
            }
        }

        //Obetner todas las alertas
        $alertas = Usuario::getAlertas();

        //Muestra la vista
        $router->render("auth/reestablecer", [
            "titulo" => "Reestablece tu contraseña",
            "alertas" => $alertas,
            "mostrar" => $mostrar
        ]);
    }

    public static function mensaje(Router $router)
    {
        $router->render("auth/mensaje", [
            "titulo" => "Cuenta creada exitosamente"
        ]);
    }

    public static function confirmar(Router $router)
    {

        $token = s($_GET["token"]);

        if (!$token) header("Location: /");

        $usuario = Usuario::where("token", $token);

        if (empty($usuario)) {
            //No se encontro un usuario con ese tokén
            Usuario::setAlerta("error", "Tokén no válido");
        } else {
            //Confirmar la cuenta
            $usuario->confirmado = 1;
            unset($usuario->password2);
            $usuario->token = "";

            //Guardar en la DB
            $usuario->guardar();

            Usuario::setAlerta("exito", "Cuenta Confirmada Correctamente");
        }

        $alertas = Usuario::getAlertas();

        $router->render("auth/confirmar", [
            "titulo" => "Cuenta Confirmada",
            "alertas" => $alertas
        ]);
    }
}
