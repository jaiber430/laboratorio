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

    case 'obtenermuestra':
        $respuesta = ["respuesta" => "0", "mensaje" => "ID no válido"];

        if (!empty($_POST['id']) && is_numeric($_POST['id'])) {
            $id = intval($_POST['id']);

            // Consulta preparada para prevenir SQL injection
            $sql = "SELECT idmuestra, codigomuestra, tipomuestra, idlote FROM muestras WHERE idmuestra = ? AND estado = 1";
            $stmt = mysqli_prepare($link, $sql);
            
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "i", $id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if ($row = mysqli_fetch_assoc($result)) {
                    $respuesta = [
                        "respuesta" => "1",
                        "idmuestra" => $row['idmuestra'],
                        "codigomuestra" => $row['codigomuestra'],
                        "tipomuestra" => $row['tipomuestra'],
                        "idlote" => $row['idlote']
                    ];
                } else {
                    $respuesta["mensaje"] = "No se encontró la muestra";
                }
                mysqli_stmt_close($stmt);
            } else {
                $respuesta["mensaje"] = "Error en la consulta";
            }
        }

        echo json_encode($respuesta);
        break;

    case 'actualizarmuestra':
        $respuesta = ["respuesta" => "0", "mensaje" => "Datos incompletos"];

        $campos_requeridos = ['idmuestra', 'codigomuestra', 'tipomuestra', 'idlote'];
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

        $id = intval($_POST['idmuestra']);
        $codigo = mysqli_real_escape_string($link, trim($_POST['codigomuestra']));
        $tipo = mysqli_real_escape_string($link, trim($_POST['tipomuestra']));
        $lote = intval($_POST['idlote']);

        // Verificar que el lote exista
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

        // Verificar si el código de muestra ya existe en otra muestra
        $sql_verificar_duplicado = "SELECT idmuestra FROM muestras WHERE codigomuestra = ? AND idmuestra != ?";
        $stmt_duplicado = mysqli_prepare($link, $sql_verificar_duplicado);
        mysqli_stmt_bind_param($stmt_duplicado, "si", $codigo, $id);
        mysqli_stmt_execute($stmt_duplicado);
        $result_duplicado = mysqli_stmt_get_result($stmt_duplicado);
        
        if (mysqli_num_rows($result_duplicado) > 0) {
            $respuesta["mensaje"] = "El código de muestra ya existe en otra muestra";
            echo json_encode($respuesta);
            mysqli_stmt_close($stmt_duplicado);
            break;
        }
        mysqli_stmt_close($stmt_duplicado);

        // Actualizar con consulta preparada
        $sql = "UPDATE muestras 
                SET codigomuestra = ?, tipomuestra = ?, idlote = ?, fecha_actualizacion = NOW()
                WHERE idmuestra = ?";
        $stmt = mysqli_prepare($link, $sql);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssii", $codigo, $tipo, $lote, $id);
            
            if (mysqli_stmt_execute($stmt)) {
                if (mysqli_stmt_affected_rows($stmt) > 0) {
                    $respuesta["respuesta"] = "1";
                    $respuesta["mensaje"] = "Muestra actualizada con éxito";
                } else {
                    $respuesta["mensaje"] = "No se realizaron cambios en la muestra";
                }
            } else {
                $respuesta["mensaje"] = "Error al actualizar la muestra";
                error_log("Error BD actualizar muestra: " . mysqli_error($link));
            }
            mysqli_stmt_close($stmt);
        } else {
            $respuesta["mensaje"] = "Error en la consulta";
            error_log("Error preparando consulta actualizar muestra: " . mysqli_error($link));
        }

        echo json_encode($respuesta);
        break;

    case 'eliminarmuestra':
        $respuesta = ["respuesta" => "0", "mensaje" => "ID no válido"];

        if (!empty($_POST['idmuestra']) && is_numeric($_POST['idmuestra'])) {
            $id = intval($_POST['idmuestra']);

            // Soft delete en lugar de eliminación física
            $sql = "UPDATE muestras SET estado = 0, fecha_eliminacion = NOW() WHERE idmuestra = ?";
            $stmt = mysqli_prepare($link, $sql);
            
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "i", $id);
                
                if (mysqli_stmt_execute($stmt)) {
                    if (mysqli_stmt_affected_rows($stmt) > 0) {
                        $respuesta["respuesta"] = "1";
                        $respuesta["mensaje"] = "Muestra eliminada con éxito";
                    } else {
                        $respuesta["mensaje"] = "No se encontró la muestra para eliminar";
                    }
                } else {
                    $respuesta["mensaje"] = "Error al eliminar la muestra";
                    error_log("Error BD eliminar muestra: " . mysqli_error($link));
                }
                mysqli_stmt_close($stmt);
            } else {
                $respuesta["mensaje"] = "Error en la consulta";
            }
        }

        echo json_encode($respuesta);
        break;
        
    case 'obtenerlote':
        $respuesta = ["respuesta" => "0", "mensaje" => "Lote no encontrado"];

        if (!empty($_POST['id']) && is_numeric($_POST['id'])) {
            $id = intval($_POST['id']);

            $sql = "SELECT idlote, codigolote, nombre, fecharecepcion, descripcion 
                    FROM lotes 
                    WHERE idlote = ? AND estado = 1";
            $stmt = mysqli_prepare($link, $sql);
            
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "i", $id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if ($result && mysqli_num_rows($result) > 0) {
                    $lote = mysqli_fetch_assoc($result);
                    $respuesta = [
                        "respuesta" => "1",
                        "idlote" => $lote['idlote'],
                        "codigolote" => $lote['codigolote'],
                        "nombre" => $lote['nombre'],
                        "fecharecepcion" => $lote['fecharecepcion'],
                        "descripcion" => $lote['descripcion']
                    ];
                } else {
                    $respuesta["mensaje"] = "No se encontró el lote";
                }
                mysqli_stmt_close($stmt);
            } else {
                $respuesta["mensaje"] = "Error en la consulta";
            }
        }

        echo json_encode($respuesta);
        break;

    case 'actualizarlote':
        $respuesta = ["respuesta" => "0", "mensaje" => "Datos inválidos"];

        $campos_requeridos = ['idlote', 'codigolote', 'nombre', 'fecharecepcion'];
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

        $idlote = intval($_POST['idlote']);
        $codigolote = mysqli_real_escape_string($link, trim($_POST['codigolote']));
        $nombre = mysqli_real_escape_string($link, trim($_POST['nombre']));
        $fecharecepcion = mysqli_real_escape_string($link, trim($_POST['fecharecepcion']));
        $descripcion = mysqli_real_escape_string($link, trim($_POST['descripcion'] ?? ''));

        // Validar formato de fecha
        if (!DateTime::createFromFormat('Y-m-d', $fecharecepcion)) {
            $respuesta["mensaje"] = "Formato de fecha inválido. Use YYYY-MM-DD";
            echo json_encode($respuesta);
            break;
        }

        // Verificar si el código de lote ya existe en otro lote
        $sql_verificar_duplicado = "SELECT idlote FROM lotes WHERE codigolote = ? AND idlote != ?";
        $stmt_duplicado = mysqli_prepare($link, $sql_verificar_duplicado);
        mysqli_stmt_bind_param($stmt_duplicado, "si", $codigolote, $idlote);
        mysqli_stmt_execute($stmt_duplicado);
        $result_duplicado = mysqli_stmt_get_result($stmt_duplicado);
        
        if (mysqli_num_rows($result_duplicado) > 0) {
            $respuesta["mensaje"] = "El código de lote ya existe en otro lote";
            echo json_encode($respuesta);
            mysqli_stmt_close($stmt_duplicado);
            break;
        }
        mysqli_stmt_close($stmt_duplicado);

        // Actualizar con consulta preparada
        $sql = "UPDATE lotes SET 
                codigolote = ?, 
                nombre = ?, 
                fecharecepcion = ?, 
                descripcion = ?,
                fecha_actualizacion = NOW()
            WHERE idlote = ?";
        $stmt = mysqli_prepare($link, $sql);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssssi", $codigolote, $nombre, $fecharecepcion, $descripcion, $idlote);
            
            if (mysqli_stmt_execute($stmt)) {
                if (mysqli_stmt_affected_rows($stmt) > 0) {
                    $respuesta = ["respuesta" => "1", "mensaje" => "Lote actualizado correctamente"];
                } else {
                    $respuesta["mensaje"] = "No se realizaron cambios en el lote";
                }
            } else {
                $respuesta["mensaje"] = "Error al actualizar lote";
                error_log("Error BD actualizar lote: " . mysqli_error($link));
            }
            mysqli_stmt_close($stmt);
        } else {
            $respuesta["mensaje"] = "Error en la consulta";
            error_log("Error preparando consulta actualizar lote: " . mysqli_error($link));
        }

        echo json_encode($respuesta);
        break;

    case 'eliminarlote':
        $respuesta = ["respuesta" => "0", "mensaje" => "ID no válido"];

        if (!empty($_POST['idlote']) && is_numeric($_POST['idlote'])) {
            $idlote = intval($_POST['idlote']);

            // Verificar si el lote tiene muestras asociadas
            $sql_verificar_muestras = "SELECT COUNT(*) as total FROM muestras WHERE idlote = ? AND estado = 1";
            $stmt_verificar = mysqli_prepare($link, $sql_verificar_muestras);
            mysqli_stmt_bind_param($stmt_verificar, "i", $idlote);
            mysqli_stmt_execute($stmt_verificar);
            $result_verificar = mysqli_stmt_get_result($stmt_verificar);
            $row = mysqli_fetch_assoc($result_verificar);
            
            if ($row['total'] > 0) {
                $respuesta["mensaje"] = "No se puede eliminar el lote porque tiene muestras asociadas";
                echo json_encode($respuesta);
                mysqli_stmt_close($stmt_verificar);
                break;
            }
            mysqli_stmt_close($stmt_verificar);

            // Soft delete del lote
            $sql = "UPDATE lotes SET estado = 0, fecha_eliminacion = NOW() WHERE idlote = ?";
            $stmt = mysqli_prepare($link, $sql);
            
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "i", $idlote);
                
                if (mysqli_stmt_execute($stmt)) {
                    if (mysqli_stmt_affected_rows($stmt) > 0) {
                        $respuesta = ["respuesta" => "1", "mensaje" => "Lote eliminado con éxito"];
                    } else {
                        $respuesta["mensaje"] = "No se encontró el lote para eliminar";
                    }
                } else {
                    $respuesta["mensaje"] = "Error al eliminar lote";
                    error_log("Error BD eliminar lote: " . mysqli_error($link));
                }
                mysqli_stmt_close($stmt);
            } else {
                $respuesta["mensaje"] = "Error en la consulta";
            }
        }

        echo json_encode($respuesta);
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