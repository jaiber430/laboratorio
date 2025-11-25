<?php
// Headers de seguridad adicionales
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-cache, must-revalidate');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');

include '../../include/send_registro.php';
include '../../herramientas/key/llave.php';

// Rate limiting básico
session_start();
if (!isset($_SESSION['intentos_correo'])) {
    $_SESSION['intentos_correo'] = 0;
    $_SESSION['ultimo_intento'] = time();
}

// Limitar a 5 intentos por minuto
if ($_SESSION['intentos_correo'] >= 5 && (time() - $_SESSION['ultimo_intento']) < 60) {
    http_response_code(429);
    echo json_encode([
        'rspst' => 0,
        'msjValidez' => 'Demasiados intentos. Espere 1 minuto.'
    ]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'rspst' => 0,
        'msjValidez' => 'Método no permitido'
    ]);
    exit;
}

// Validar configuración
if (!isset($email_remitente, $password) || empty($email_remitente) || empty($password)) {
    error_log("Configuración de correo incompleta en llaveregistro.php");
    http_response_code(500);
    echo json_encode([
        'rspst' => 0,
        'msjValidez' => 'Error de configuración del sistema'
    ]);
    exit;
}

if (isset($_POST['correo'])) {
    $email_destinatario = trim($_POST['correo']);
    $jTableResult = array();

    // Validación exhaustiva del email
    if (filter_var($email_destinatario, FILTER_VALIDATE_EMAIL)) {
        // Validar longitud
        if (strlen($email_destinatario) > 254) {
            $jTableResult['rspst'] = 0;
            $jTableResult['msjValidez'] = "El correo electrónico es demasiado largo";
        } else {
            // Validar dominio
            $dominio = explode('@', $email_destinatario)[1] ?? '';
            if (!checkdnsrr($dominio, 'MX')) {
                $jTableResult['rspst'] = 0;
                $jTableResult['msjValidez'] = "El dominio del correo no es válido";
            } else {
                try {
                    // Actualizar contador de intentos
                    $_SESSION['intentos_correo']++;
                    $_SESSION['ultimo_intento'] = time();

                    $resul = enviarCorreoregistro($email_remitente, $email_destinatario, $password);

                    if ($resul === true) {
                        $jTableResult['rspst'] = 1;
                        $jTableResult['msjValidez'] = "Correo de registro enviado correctamente";
                        
                        // Log seguro
                        error_log("Correo registro enviado: " . substr($email_destinatario, 0, 3) . "***@" . $dominio);
                    } else {
                        $jTableResult['rspst'] = 2;
                        $jTableResult['msjValidez'] = "Error al enviar el correo. Por favor, intente más tarde.";
                        error_log("Falló envío correo registro a: " . substr($email_destinatario, 0, 3) . "***");
                    }
                } catch (Exception $e) {
                    $jTableResult['rspst'] = 2;
                    $jTableResult['msjValidez'] = "Error temporal en el servicio de correo";
                    error_log("Error enviando correo registro: " . $e->getMessage());
                }
            }
        }
    } else {
        $jTableResult['rspst'] = 0;
        $jTableResult['msjValidez'] = "Formato de correo electrónico inválido";
    }

    echo json_encode($jTableResult, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT);
    exit;
} else {
    http_response_code(400);
    echo json_encode([
        'rspst' => 0,
        'msjValidez' => 'Correo electrónico no proporcionado'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}
?>