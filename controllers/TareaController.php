<?php

namespace Controller;

use Model\Proyecto;
use Model\Tarea;
use MVC\Router;

class TareaController
{
    public static function index(Router $router)
    {

        $proyectoId = $_GET["id"];

        if (!$proyectoId) header("Location: /dashboard");

        $proyecto = Proyecto::where("url", $proyectoId);
        session_start();

        if (!$proyecto || $proyecto->propietarioId !== $_SESSION["id"]) header("location: /404");

        $tareas = Tarea::belongsTo("proyectoId", $proyecto->id);
        echo json_encode(["tareas" => $tareas]);
    }

    public static function crear()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            session_start();

            $proyectoId = $_POST["proyectoId"];


            $proyecto = Proyecto::where("url", $proyectoId);

            if (!$proyecto || $proyecto->propietarioId !== $_SESSION["id"]) {
                $respuesta = [
                    "tipo" => "error",
                    "mensaje" => "Hubo un error al agregar la tarea"
                ];

                echo json_encode($respuesta);
                return;
            }

            //Instanciar y crear la tarea
            $tarea = new Tarea($_POST);
            $tarea->proyectoId = $proyecto->id;
            $resultado = $tarea->guardar();

            $respuesta = [
                "tipo" => "exito",
                "id" => $resultado["id"],
                "mensaje" => "Tarea creada correctamente",
                "proyectoId" => $proyecto->id
            ];
            echo json_encode($respuesta);
        }
    }

    public static function actualizar(Router $router)
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

            $tarea = new Tarea($_POST);
            $tarea->proyectoId = $proyecto->id;

            $resultado = $tarea->guardar();
            if ($resultado) {
                $respuesta = [
                    "tipo" => "exito",
                    "id" => $tarea->id,
                    "proyectoId" => $proyecto->id,
                    "mensaje" => "Tarea Actualizada Correctamente"
                ];

                echo json_encode(["respuesta" => $respuesta]);
            }
        }
    }
    public static function eliminar()
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

            $tarea = new Tarea($_POST);
            $tarea->proyectoId = $proyecto->id;

            $resultado = $tarea->guardar();
            if ($resultado) {
                $respuesta = [
                    "tipo" => "exito",
                    "id" => $tarea->id,
                    "proyectoId" => $proyecto->id,
                    "mensaje" => "Tarea Actualizada Correctamente"
                ];

                $tarea = new Tarea($_POST);
                $resultado = $tarea->eliminar();

                $resultado = [
                    "resultado" => $resultado,
                    "mensaje" => "Eliminado Correctamente",
                    "tipo" => "exito"
                ];

                echo json_encode($resultado);
            }
        }
    }
}
