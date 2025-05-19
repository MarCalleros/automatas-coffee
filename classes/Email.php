<?php

namespace Class;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Email {
    public $correo;
    public $nombre;
    public $token;
    public $rutaLogo = __DIR__ . '/../public/assets/img/logo_white.png';

    public function __construct($args = []) {
        $this->correo = $args['correo'] ?? '';
        $this->nombre = $args['nombre'] ?? '';
        $this->token = $args['token'] ?? '';
    }

    public function sendConfirmationEmail() {
        try {
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'smtp-relay.brevo.com';
            $mail->SMTPAuth = true;
            $mail->Port = 587;
            $mail->Username = 'alejandrocalleros86@gmail.com';
            $mail->Password = 'xsmtpsib-3006b336805cfcfd8f3948b12d3a0194c985a442fd9ac997fefa461a93c0da3a-C7XIpK5VvqFO3a0B';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

            $mail->setFrom('automatascoffee@contacto.com', 'Soporte Automatas Coffee');
            $mail->addAddress($this->correo);

            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'Confirme su cuenta en Automatas Coffee';

            $mail->addEmbeddedImage($this->rutaLogo, 'Automatas-Coffee-Logo');

            $contenido = '
                <html>
                <head>
                    <style>
                        .container {
                            width: 100%;
                            max-width: 500px;
                            margin: auto;
                            padding: 30px;
                            font-family: Arial, sans-serif;
                            background-color: #2C2C2C;
                            border-radius: 10px;
                            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
                            color: #FAFAFA;
                        }
                        .logo {
                            text-align: center;
                            margin-bottom: 20px;
                        }
                        .logo img {
                            width: 400px;
                        }
                        .btn {
                            display: inline-block;
                            padding: 12px 25px;
                            margin: 20px 0;
                            background-color: #FF5100;
                            color: #FAFAFA !important;
                            text-decoration: none;
                            border-radius: 5px;
                        }
                        .footer {
                            margin-top: 40px;
                            font-size: 12px;
                            color: #8A8A8A;
                            text-align: center;
                        }
                    </style>
                </head>
                <body>
                    <div class="container">
                        <div class="logo">
                            <img src="cid:Automatas-Coffee-Logo" alt="Automatas Coffee Logo">
                        </div>
                        <h2 style="text-align: center;">¡Hola ' . htmlspecialchars($this->nombre) . '!</h2>
                        <p>Gracias por crear tu cuenta en <strong>Automatas Coffee</strong>. Solo debes confirmarla haciendo clic en el siguiente botón:</p>
                        <p style="text-align: center;">
                            <a class="btn" href="http://localhost:3000/confirmacion?token=' . urlencode($this->token) . '">Confirmar cuenta</a>
                        </p>
                        <p>Si tú no solicitaste esta cuenta, puedes ignorar este mensaje.</p>
                        <div class="footer">
                            © ' . date('Y') . ' Automatas Software. Todos los Derechos Reservados.
                        </div>
                    </div>
                </body>
                </html>
            ';

            $mail->Body = $contenido;
    
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
?>