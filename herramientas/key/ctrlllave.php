<?php
header('Content-Type: application/json');
header('Content-Type: text/html; charset=utf-8');
header('Cache-Control: no-cache, must-revalidate');
include '../../include/send_email.php';
include '../../herramientas/key/llave.php'; // Este archivo debe definir $email_remitente y $password
include('../../include/conectar.php');

$link = conectar();
if (isset($_POST['correo'])) {
    $email_destinatario = $_POST['correo'];
    $jTableResult = array();

    if (filter_var($email_destinatario, FILTER_VALIDATE_EMAIL)) {
        $sql = "SELECT personal.correo FROM personal 
        WHERE correo = '$email_destinatario'";
        $result = mysqli_query($link, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);

                $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $longitud_caracteres = strlen($caracteres);
                $clave = '';
                for ($i = 0; $i < 8; $i++) {
                    $clave .= $caracteres[rand(0, $longitud_caracteres - 1)];
                }
            // echo "Nueva clave ".$clave;
            // echo "Correo  ".$email_destinatario; exit();  

            $resul = enviarCorreo($email_remitente, $email_destinatario, $clave, $password);

            if($resul == true){
                $jTableResult['rspst'] = 1;
                $jTableResult['msjValidez'] = "Correo enviado correctamente";
                // $clavecifrada = password_hash($clave, PASSWORD_DEFAULT);
                $sqlupdate = "UPDATE personal SET clave = '$clave' WHERE personal.correo = '$email_destinatario';";
                $resultupdate = mysqli_query($link, $sqlupdate);
            }else{
                $jTableResult['rspst'] = 3;
                $jTableResult['msjValidez'] = "Error al enviar el correo ";
            }
        } else {
            $jTableResult['rspst'] = 2;
            $jTableResult['msjValidez'] = "El correo no esta registrado en la base de datos ";
        }
    } else {
        $jTableResult['rspst'] = "0";
        $jTableResult['msjValidez'] = "Correo inválido";
    }

    echo json_encode($jTableResult);
    exit;
}
