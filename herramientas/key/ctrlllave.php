<?php
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-cache, must-revalidate');
include '../../include/send_email.php';
include '../../herramientas/key/llave.php';
include('../../include/conectar.php');

// Validar que sea una petición POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'rspst' => 0,
        'msjValidez' => 'Método no permitido'
    ]);
    exit;
}

$link = conectar();
if (!$link) {
    http_response_code(500);
    echo json_encode([
        'rspst' => 0,
        'msjValidez' => 'Error de conexión a la base de datos'
    ]);
    exit;
}

if (isset($_POST['correo'])) {
    $email_destinatario = trim($_POST['correo']);
    $jTableResult = array();

    // Validar email
    if (filter_var($email_destinatario, FILTER_VALIDATE_EMAIL)) {
        // Usar consulta preparada para prevenir SQL injection
        $sql = "SELECT idpersonal, correo, nombre, apellido FROM personal WHERE correo = ? AND estado = 1";
        $stmt = mysqli_prepare($link, $sql);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $email_destinatario);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                
                // Generar clave segura
                $clave = generarClaveSegura(12);
                
                // Enviar correo
                $resul = enviarCorreo($email_remitente, $email_destinatario, $clave, $password);

                if ($resul === true) {
                    // Hash seguro de la contraseña
                    $clave_hash = password_hash($clave, PASSWORD_DEFAULT);
                    
                    // Actualizar con consulta preparada
                    $sqlupdate = "UPDATE personal SET clave = ? WHERE correo = ?";
                    $stmt_update = mysqli_prepare($link, $sqlupdate);
                    
                    if ($stmt_update) {
                        mysqli_stmt_bind_param($stmt_update, "ss", $clave_hash, $email_destinatario);
                        
                        if (mysqli_stmt_execute($stmt_update)) {
                            $jTableResult['rspst'] = 1;
                            $jTableResult['msjValidez'] = "Correo enviado correctamente. Su nueva contraseña ha sido enviada a su email.";
                            
                            // Limpiar datos sensibles de memoria
                            $clave = str_repeat('x', strlen($clave));
                            $clave_hash = '';
                        } else {
                            $jTableResult['rspst'] = 3;
                            $jTableResult['msjValidez'] = "Error al actualizar la contraseña";
                        }
                        mysqli_stmt_close($stmt_update);
                    } else {
                        $jTableResult['rspst'] = 3;
                        $jTableResult['msjValidez'] = "Error en la base de datos";
                    }
                } else {
                    $jTableResult['rspst'] = 3;
                    $jTableResult['msjValidez'] = "Error al enviar el correo. Por favor, intente más tarde.";
                }
            } else {
                // No revelar si el email existe o no (seguridad)
                $jTableResult['rspst'] = 1;
                $jTableResult['msjValidez'] = "Si el email está registrado, recibirá instrucciones para recuperar su contraseña.";
            }
            mysqli_stmt_close($stmt);
        } else {
            $jTableResult['rspst'] = 0;
            $jTableResult['msjValidez'] = "Error en el sistema";
        }
    } else {
        $jTableResult['rspst'] = 0;
        $jTableResult['msjValidez'] = "Correo electrónico inválido";
    }

    mysqli_close($link);
    echo json_encode($jTableResult);
    exit;
} else {
    http_response_code(400);
    echo json_encode([
        'rspst' => 0,
        'msjValidez' => 'Correo no proporcionado'
    ]);
    exit;
}

/**
 * Genera una contraseña segura
 */
function generarClaveSegura($longitud = 12) {
    $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%&*';
    $longitud_caracteres = strlen($caracteres);
    $clave = '';
    
    // Asegurar que tenga al menos un número, una mayúscula y un carácter especial
    $clave .= $caracteres[rand(10, 35)]; // letra minúscula
    $clave .= $caracteres[rand(36, 61)]; // letra mayúscula  
    $clave .= $caracteres[rand(0, 9)];   // número
    $clave .= $caracteres[rand(62, strlen($caracteres) - 1)]; // carácter especial
    
    // Completar el resto de la longitud
    for ($i = 4; $i < $longitud; $i++) {
        $clave .= $caracteres[rand(0, $longitud_caracteres - 1)];
    }
    
    // Mezclar los caracteres
    return str_shuffle($clave);
}
?>