<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email
{
    protected $email;
    protected $nombre;
    protected $token;


    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    //Envia mensaje de confirmación
    public function enviarConfirmacion()
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'faa1f04e818f42';
        $mail->Password = '5e90afd14b128b';

        $mail->setFrom("cuentas@uptask.com");
        $mail->addAddress("cuentas@uptask.com", "uptask.com");
        $mail->Subject = "Confirma tu cuenta";

        $mail->isHTML(true);
        $mail->CharSet = "UTF-8";

        $contenido = "<HTML>";
        $contenido .= "<P>
                        <STRONG> Hola " . $this->nombre . "</STRONG> 
                        has creado tu cuenta en Uptask, solo debes confirmarla en el siguiente enlace
                       </P>";
        $contenido .= "<P>Presiona aquí: <A href='http://localhost:3000/confirmar?token=" . $this->token .  "'>Confirmar Cuenta</A></P> ";
        $contenido .= "</P>Si tu no creaste esta cuenta puedes ignorar este mensaje</P>";
        $contenido .= "</HTML>";

        //Agrega el contenido al cuerpo del mail
        $mail->Body = $contenido;

        //Enviar el email
        $mail->send();
    }

    //Envia mensaje para recuperar contraseña
    public function reestablecerPassword()
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'faa1f04e818f42';
        $mail->Password = '5e90afd14b128b';

        $mail->setFrom("cuentas@uptask.com");
        $mail->addAddress("cuentas@uptask.com", "uptask.com");
        $mail->Subject = "Reestablece tu contraseña";

        $mail->isHTML(true);
        $mail->CharSet = "UTF-8";

        $contenido = "<HTML>";
        $contenido .= "<P>
                        <STRONG> Hola " . $this->nombre . "</STRONG> 
                        has solicitado un cambio de constraseña, solo debes seguir el siguiente enlace
                       </P>";
        $contenido .= "<P>Presiona aquí: <A href='http://localhost:3000/reestablecer?token=" . $this->token .  "'>Reestablecer contraseña</A></P> ";
        $contenido .= "</P>Si tu no creaste esta cuenta puedes ignorar este mensaje</P>";
        $contenido .= "</HTML>";

        //Agrega el contenido al cuerpo del mail
        $mail->Body = $contenido;

        //Enviar el email
        $mail->send();
    }
}
