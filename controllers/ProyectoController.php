<?php


namespace Controller;

use MVC\Router;
use Model\Proyecto;

class ProyectoController
{

    public static function index(Router $router)
    {
        session_start();
        isAuth();

        //Obtener el id del usuario
        $id = $_SESSION["id"];
        $proyectos = Proyecto::belongsTo("propietarioId", $id);

        $router->render("proyecto/index", [
            "titulo" => "Proyectos",
            "proyectos" => $proyectos
        ]);
    }

    public static function crearProyecto(Router $router)
    {
        session_start();

        isAuth();

        $alertas = [];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $proyecto = new Proyecto($_POST);

            //Validación
            $alertas = $proyecto->validarProyecto();

            if (empty($alertas)) {
                //Generar una ul única
                $proyecto->url = md5(uniqid());

                //Almacenar el creador del proyecto
                $proyecto->propietarioId = $_SESSION["id"];

                //Guardar el proyecto
                $proyecto->guardar();

                //Redireccionar
                header("Location: /proyecto?id=" . $proyecto->url);
            }
        }

        $router->render("proyecto/crear-proyecto", [
            "titulo" => "Crear Proyecto",
            "alertas" => $alertas
        ]);
    }

    public static function actualizarProyecto(Router $router)
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            //Validar que el proyecto exista
            $proyecto = Proyecto::where("url", $_POST["proyectoId"]);
            session_start();

            if (!$proyecto || $proyecto->propietarioId !== $_SESSION["id"]) {
                $respuesta = [
                    "tipo" => "error",
                    "mensaje" => "Hubo un error al actualizar la tarea"
                ];

                echo json_encode($respuesta);
                return;
            }
        }
    }

    public static function eliminar(Router $router)
    {
    }

    public static function proyecto(Router $router)
    {

        session_start();

        isAuth();

        $alertas = [];

        $token = $_GET["id"];

        if (!$token) header("Location: /proyectos");

        //Verficar que la persona que crea el proyecto, es quien lo creo
        $proyecto = Proyecto::where("url", $token);

        if ($proyecto->propietarioId !== $_SESSION["id"]) {
            header("Location: /proyectos");
        }

        $router->render("proyecto/proyecto", [
            "titulo" => $proyecto->nombre,
            "alertas" => $alertas

        ]);
    }
}
