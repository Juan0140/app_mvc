<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email
{
    public $name;
    public $email;
    public $token;


    public function __construct($name, $email, $token)
    {
        $this->name = $name;
        $this->email = $email;
        $this->token = $token;
    }

    public function sendConfirmation()
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
        $mail->SMTPSecure = 'tls';
        $mail->Port = $_ENV['EMAIL_PORT'];


        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'Appsalon');
        $mail->Subject = 'Confirma tu cuenta';

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $contain = "<html>";
        $contain .= "<p><strong>Hola " . $this->name . ".</strong> Has creado tu cuenta en appsalon, solo debes
        confirmarla dando click en el siguiente enlace</p>";
        $contain .= "<p>Da click aqui: <a href='" . $_ENV['APP_URL'] ."/confirm-account?token=" . $this->token . "'>Confirmar cuenta</a></p>";
        $contain .= "Si no solicitaste esta cuenta ignora este correo";
        $contain .= "</html>";
        $mail->Body = $contain;

        $mail->send();
    }

    public function sendInstructions()
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
        $mail->SMTPSecure = 'tls';
        $mail->Port = $_ENV['EMAIL_PORT'];


        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'Appsalon');
        $mail->Subject = 'Restablece tu password';

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $contain = "<html>";
        $contain .= "<p><strong>Hola " . $this->name . ".</strong> Has solicitado restablecer tu password, sigue el siguiente 
        enlace</p>";
        $contain .= "<p>Da click aqui: <a href='" . $_ENV['APP_URL'] ."/recover?token=" . $this->token . "'>Restablecer password</a></p>";
        $contain .= "Si no solicitaste esta cuenta ignora este correo";
        $contain .= "</html>";
        $mail->Body = $contain;

        $mail->send();
    }
}
