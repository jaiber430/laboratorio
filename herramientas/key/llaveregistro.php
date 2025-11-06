<?php
header('Content-Type: application/json');
header('Content-Type: text/html; charset=utf-8');
header('Cache-Control: no-cache, must-revalidate');
include '../../include/send_registro.php';
include '../../herramientas/key/llave.php'; // Este archivo debe definir $email_remitente y $password
// include '../../include/conectar.php';

if (isset($_POST['correo'])) {
    $email_destinatario = $_POST['correo'];
    $jTableResult = array();

    if (filter_var($email_destinatario, FILTER_VALIDATE_EMAIL)) {

            $resul = enviarCorreoregistro($email_remitente, $email_destinatario, $password);

            if($resul == true){
                $jTableResult['rspst'] = 1;
                $jTableResult['msjValidez'] = "Correo enviado ";
            }else{
                $jTableResult['rspst'] = 2;
                $jTableResult['msjValidez'] = "Error al enviar el correo ";
            }
    } else {
        $jTableResult['rspst'] = "0";
        $jTableResult['msjValidez'] = "Correo inválido";
    }

    echo json_encode($jTableResult);
    exit;
}
