<?php

namespace Model;

class Usuario extends ActiveRecord
{

    protected static $tabla = "usuarios";
    protected static $columnasDB = ["id", "nombre", "email", "password", "token", "confirmado"];

    //Constructor
    public function __construct($args = [])
    {
        $this->id = $args["id"] ?? null;
        $this->nombre = $args["nombre"] ?? "";
        $this->email = $args["email"] ?? "";
        $this->password = $args["password"] ?? "";
        $this->password2 = $args["password2"] ?? "";
        $this->passwordActual = $args["passwordActual"] ?? "";
        $this->passwordNuevo = $args["passwordNuevo"] ?? "";
        $this->token = $args["token"] ?? "";
        $this->confirmado = $args["confirmado"] ?? 0;
    }

    //Validar el login
    public function validarLogin(): array
    {
        if (!$this->email) {
            self::$alertas["error"][] = "El email es obligatorio";
        }
        //Verifica que sea un email
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas["error"][] = "El email no es válido";
        }
        if (!$this->password) {
            self::$alertas["error"][] = "La contraseña es obligatoria";
        }

        return self::$alertas;
    }

    //Valida un email
    public function validarEmail(): array
    {
        if (!$this->email) {
            self::$alertas["error"][] = "El email es obligatorio";
        }
        //Verifica que sea un email
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas["error"][] = "El email no es válido";
        }

        return self::$alertas;
    }

    //Valida el password
    public function validarPassword(): array
    {
        if (strlen($this->password) < 6) {
            self::$alertas["error"][] = "La contraseña debe contener al menos 6 carácteres";
        }
        if ($this->password !== $this->password2) {
            self::$alertas["error"][] = "Las contraseñas no coinciden";
        }
        return self::$alertas;
    }

    //Validar cuentas nuevas
    public function validarNuevaCuenta(): array
    {
        if (!$this->nombre) {
            self::$alertas["error"][] = "El nombre es obligatorio";
        }
        if (!$this->email) {
            self::$alertas["error"][] = "El email es obligatorio";
        }
        if (!$this->password) {
            self::$alertas["error"][] = "La contraseña es obligatoria";
        }
        if (strlen($this->password) < 6) {
            self::$alertas["error"][] = "La contraseña debe contener al menos 6 carácteres";
        }
        if ($this->password !== $this->password2) {
            self::$alertas["error"][] = "Las contraseñas no coinciden";
        }

        return self::$alertas;
    }

    //Comprobar el password
    public function comprobarPassword(): bool
    {
        return password_verify($this->passwordActual, $this->password);
    }

    //Hashea el password
    public function hashPassword(): void
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    //Crea un tokén
    public function crearToken(): void
    {
        //Genera un codigo de 15 caracteres
        $this->token = uniqid();
    }

    //Validar Perfil
    public function validarPerfil(): array
    {
        if (!$this->nombre) {
            self::$alertas["error"][] = "El nombre es obligatorio";
        }
        if (!$this->email) {
            self::$alertas["error"][] = "El email es obligatorio";
        }

        return self::$alertas;
    }

    //Nuevo Password
    public function nuevoPassword(): array
    {
        if (!$this->passwordActual) {
            self::$alertas["error"][] = "La contraseña actual es obligatoria";
        }
        if (!$this->passwordNuevo) {
            self::$alertas["error"][] = "La contraseña nueva es obligatoria";
        }
        if (strlen($this->passwordNuevo) < 6) {
            self::$alertas["error"][] = "La nueva contraseña debe contener al menos 6 carácteres";
        }

        return self::$alertas;
    }
}
