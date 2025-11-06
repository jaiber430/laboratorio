<?php
// include 'conectar.php';
include_once('config.php');
// include('herramientas/PHPMailer.php');

header('Content-Type: text/html; charset='.$charset);
header('Cache-Control: no-cache, must-revalidate');

session_start();

require '../../herramientas/PHPMailer/src/Exception.php';
require '../../herramientas/PHPMailer/src/PHPMailer.php';
require '../../herramientas/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function enviarCorreoregistro($email_remitente, $email_destinatario, $password) {
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Servidor SMTP de Gmail
        $mail->SMTPAuth = true;
        $mail->Username = $email_remitente; // Tu dirección de correo de Gmail
        $mail->Password = $password; // Tu contraseña de Gmail
        $mail->SMTPSecure = 'tls'; // Activa la encriptación TLS
        $mail->Port = 587; // Puerto TCP para TLS

        // Remitente y destinatario
        $mail->setFrom($email_remitente);
        $mail->addAddress($email_destinatario);

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Registro a la base de datos';
        $mail->Body    = 'Fuiste registrado en la base de datos laboratorio exitosamente';  

        // Enviar el correo
        $mail->send();
        return true;
    } catch (Exception $e) {
        echo " {$mail->ErrorInfo}";
        return false;
    }
}
