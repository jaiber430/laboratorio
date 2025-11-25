<?php
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-cache, must-revalidate');

include('../../include/conectar.php');

// Validar método de petición
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'respuesta' => '0',
        'mensaje' => 'Método no permitido'
    ]);
    exit;
}

$link = conectar();
if (!$link) {
    http_response_code(500);
    echo json_encode([
        'respuesta' => '0',
        'mensaje' => 'Error de conexión a la base de datos'
    ]);
    exit;
}

// Validar que la acción esté definida
if (!isset($_REQUEST['action'])) {
    http_response_code(400);
    echo json_encode([
        'respuesta' => '0',
        'mensaje' => 'Acción no especificada'
    ]);
    exit;
}

switch ($_REQUEST['action']) {

    case 'selectlotes':
        $jTableResult = array(
            'msj' => "",
            'respuesta' => "1",
            'optionTD' => ""
        );
        
        $query = "SELECT idlote, nombre FROM lotes WHERE estado = 1";
        $reg = mysqli_query($link, $query);
        
        if (!$reg) {
            $jTableResult['respuesta'] = "0";
            $jTableResult['msj'] = "Error al cargar lotes";
        } else {
            while ($registro = mysqli_fetch_array($reg)) {
                $jTableResult['optionTD'] .= "<option value='" . 
                    htmlspecialchars($registro['idlote'], ENT_QUOTES, 'UTF-8') . "'>" . 
                    htmlspecialchars($registro['nombre'], ENT_QUOTES, 'UTF-8') . "</option>";
            }
        }
        echo json_encode($jTableResult);
        break;

    case 'agregarmuestra':
        $respuesta = array("respuesta" => "0", "mensaje" => "Datos inválidos");

        // Validar campos obligatorios
        $campos_requeridos = ['persona', 'codigomuestra', 'tipomuestra', 'verlotes'];
        $campos_faltantes = [];
        
        foreach ($campos_requeridos as $campo) {
            if (empty($_POST[$campo])) {
                $campos_faltantes[] = $campo;
            }
        }
        
        if (!empty($campos_faltantes)) {
            $respuesta["mensaje"] = "Faltan campos obligatorios: " . implode(', ', $campos_faltantes);
            echo json_encode($respuesta);
            break;
        }

        $persona = mysqli_real_escape_string($link, trim($_POST['persona']));
        $codigomuestra = mysqli_real_escape_string($link, trim($_POST['codigomuestra']));
        $tipomuestra = mysqli_real_escape_string($link, trim($_POST['tipomuestra']));
        $lote = intval($_POST['verlotes']);

        // Validar que el lote exista
        $sql_verificar_lote = "SELECT idlote FROM lotes WHERE idlote = ? AND estado = 1";
        $stmt_verificar = mysqli_prepare($link, $sql_verificar_lote);
        mysqli_stmt_bind_param($stmt_verificar, "i", $lote);
        mysqli_stmt_execute($stmt_verificar);
        $result_verificar = mysqli_stmt_get_result($stmt_verificar);
        
        if (mysqli_num_rows($result_verificar) === 0) {
            $respuesta["mensaje"] = "El lote seleccionado no existe";
            echo json_encode($respuesta);
            mysqli_stmt_close($stmt_verificar);
            break;
        }
        mysqli_stmt_close($stmt_verificar);

        // Verificar si el código de muestra ya existe
        $sql_verificar_muestra = "SELECT idmuestra FROM muestras WHERE codigomuestra = ?";
        $stmt_verificar_muestra = mysqli_prepare($link, $sql_verificar_muestra);
        mysqli_stmt_bind_param($stmt_verificar_muestra, "s", $codigomuestra);
        mysqli_stmt_execute($stmt_verificar_muestra);
        $result_muestra = mysqli_stmt_get_result($stmt_verificar_muestra);
        
        if (mysqli_num_rows($result_muestra) > 0) {
            $respuesta["mensaje"] = "El código de muestra ya existe";
            echo json_encode($respuesta);
            mysqli_stmt_close($stmt_verificar_muestra);
            break;
        }
        mysqli_stmt_close($stmt_verificar_muestra);

        // Insertar con consulta preparada
        $sql = "INSERT INTO laboratorio.muestras (persona, codigomuestra, tipomuestra, idlote, fecha_creacion) 
                VALUES (?, ?, ?, ?, NOW())";
        $stmt = mysqli_prepare($link, $sql);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssi", $persona, $codigomuestra, $tipomuestra, $lote);
            
            if (mysqli_stmt_execute($stmt)) {
                $respuesta["respuesta"] = "1";
                $respuesta["mensaje"] = "Muestra registrada correctamente";
                $respuesta["id_insertado"] = mysqli_insert_id($link);
            } else {
                $respuesta["mensaje"] = "Error al registrar la muestra";
                error_log("Error BD al agregar muestra: " . mysqli_error($link));
            }
            mysqli_stmt_close($stmt);
        } else {
            $respuesta["mensaje"] = "Error en la consulta";
            error_log("Error preparando consulta agregar muestra: " . mysqli_error($link));
        }
        echo json_encode($respuesta);
        break;

    case 'agregarlote':
        $respuesta = array("respuesta" => "0", "mensaje" => "Datos inválidos");

        $campos_requeridos = ['codigolote', 'nombre', 'fecharecepcion', 'descripcion'];
        $campos_faltantes = [];
        
        foreach ($campos_requeridos as $campo) {
            if (empty($_POST[$campo])) {
                $campos_faltantes[] = $campo;
            }
        }
        
        if (!empty($campos_faltantes)) {
            $respuesta["mensaje"] = "Faltan campos obligatorios: " . implode(', ', $campos_faltantes);
            echo json_encode($respuesta);
            break;
        }

        $codigolote = mysqli_real_escape_string($link, trim($_POST['codigolote']));
        $nombre = mysqli_real_escape_string($link, trim($_POST['nombre']));
        $fecharecepcion = mysqli_real_escape_string($link, trim($_POST['fecharecepcion']));
        $descripcion = mysqli_real_escape_string($link, trim($_POST['descripcion']));

        // Validar formato de fecha
        if (!DateTime::createFromFormat('Y-m-d', $fecharecepcion)) {
            $respuesta["mensaje"] = "Formato de fecha inválido. Use YYYY-MM-DD";
            echo json_encode($respuesta);
            break;
        }

        // Verificar si el código de lote ya existe
        $sql_verificar_lote = "SELECT idlote FROM lotes WHERE codigolote = ?";
        $stmt_verificar = mysqli_prepare($link, $sql_verificar_lote);
        mysqli_stmt_bind_param($stmt_verificar, "s", $codigolote);
        mysqli_stmt_execute($stmt_verificar);
        $result_verificar = mysqli_stmt_get_result($stmt_verificar);
        
        if (mysqli_num_rows($result_verificar) > 0) {
            $respuesta["mensaje"] = "El código de lote ya existe";
            echo json_encode($respuesta);
            mysqli_stmt_close($stmt_verificar);
            break;
        }
        mysqli_stmt_close($stmt_verificar);

        // Insertar con consulta preparada
        $sql = "INSERT INTO lotes (codigolote, nombre, fecharecepcion, descripcion, fecha_creacion, estado)
                VALUES (?, ?, ?, ?, NOW(), 1)";
        $stmt = mysqli_prepare($link, $sql);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssss", $codigolote, $nombre, $fecharecepcion, $descripcion);
            
            if (mysqli_stmt_execute($stmt)) {
                $respuesta["respuesta"] = "1";
                $respuesta["mensaje"] = "Lote registrado correctamente";
                $respuesta["id_insertado"] = mysqli_insert_id($link);
            } else {
                $respuesta["mensaje"] = "Error al registrar el lote";
                error_log("Error BD al agregar lote: " . mysqli_error($link));
            }
            mysqli_stmt_close($stmt);
        } else {
            $respuesta["mensaje"] = "Error en la consulta";
            error_log("Error preparando consulta agregar lote: " . mysqli_error($link));
        }
        echo json_encode($respuesta);
        break;

    case 'selectlote':
        $jTableResult = array(
            'msj' => "",
            'respuesta' => "1",
            'optionlotes' => ""
        );

        $query = "SELECT idlote, nombre FROM lotes WHERE estado = 1";
        $reg = mysqli_query($link, $query);

        if (!$reg) {
            $jTableResult['respuesta'] = "0";
            $jTableResult['msj'] = "Error al cargar lotes";
            $jTableResult['optionlotes'] = "<option value=''>Error al cargar</option>";
        } else if (mysqli_num_rows($reg) > 0) {
            while ($registro = mysqli_fetch_array($reg)) {
                $jTableResult['optionlotes'] .= "<option value='" . 
                    htmlspecialchars($registro['idlote'], ENT_QUOTES, 'UTF-8') . "'>" . 
                    htmlspecialchars($registro['nombre'], ENT_QUOTES, 'UTF-8') . "</option>";
            }
        } else {
            $jTableResult['optionlotes'] = "<option value=''>No hay lotes disponibles</option>";
        }

        echo json_encode($jTableResult);
        break;

    default:
        http_response_code(400);
        echo json_encode([
            'respuesta' => '0',
            'mensaje' => 'Acción no válida'
        ]);
        break;
}

mysqli_close($link);
?>