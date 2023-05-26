<?php

namespace Model;

class Proyecto extends ActiveRecord
{

    protected static $tabla = "proyectos";
    protected static $columnasDB = ["id", "nombre", "url", "propietarioId"];

    //Constructor
    public function __construct($args = [])
    {
        $this->id = $args["id"] ?? null;
        $this->nombre = $args["nombre"] ?? "";
        $this->url = $args["url"] ?? "";
        $this->propietarioId = $args["propietarioId"] ?? "";
    }

    //Validar el proyecto
    public function validarProyecto()
    {
        if (!$this->nombre) {
            self::$alertas["error"][] = "El nombre del proyecto es obligatorio";
        }

        return self::$alertas;
    }


}
