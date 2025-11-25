<?php
require_once('config.php');
header('Content-Type: application/json; charset=' . $charset);
header('Cache-Control: no-cache, must-revalidate');
include('conectar.php');
session_name($session_name);
session_start();

$link = conectar();
if (!$link) {
    $jTableResult = array(
        'respuesta' => "0",
        'mensaje' => "Error de conexión a la base de datos"
    );
    echo json_encode($jTableResult);
    exit();
}

// Verificar que la acción esté definida
if (!isset($_REQUEST['action'])) {
    $jTableResult = array(
        'respuesta' => "0",
        'mensaje' => "Acción no especificada"
    );
    echo json_encode($jTableResult);
    exit();
}

switch ($_REQUEST['action']) {

    case 'selectTD':
        $jTableResult = array();
        $jTableResult['msj'] = "";
        $jTableResult['respuesta'] = "1";
        $jTableResult['optionTD'] = "";
        
        $query = "SELECT idtipodocumento, tipodocumento FROM tipodocumento WHERE estado = 1";
        $reg = mysqli_query($link, $query);
        
        if (!$reg) {
            $jTableResult['respuesta'] = "0";
            $jTableResult['msj'] = "Error al cargar tipos de documento";
        } else {
            while ($registro = mysqli_fetch_array($reg)) {
                $jTableResult['optionTD'] .= "<option value='" . htmlspecialchars($registro['idtipodocumento']) . "'>" . htmlspecialchars($registro['tipodocumento']) . "</option>";
            }
        }
        echo json_encode($jTableResult);
        break;

    case 'inicio':
        $jTableResult = array();
        $jTableResult['respuesta'] = "0";
        $jTableResult['mensaje'] = "CREDENCIALES INCORRECTAS";

        if (!empty($_POST['correo']) && !empty($_POST['clave']) && !empty($_POST['cargo'])) {
            $correo = mysqli_real_escape_string($link, $_POST['correo']);
            $clave = mysqli_real_escape_string($link, $_POST['clave']);
            $cargo = intval($_POST['cargo']); // Validar como entero

            $sql = "SELECT personal.idpersonal, personal.idcargo, personal.nombre, personal.apellido, 
                           personal.idtipodocumento, personal.identificacion, personal.telefono, 
                           personal.direccion, personal.correo, personal.clave, personal.fecha, 
                           personal.estado, cargos.cargo 
                    FROM personal 
                    INNER JOIN cargos ON personal.idcargo = cargos.idcargo 
                    WHERE personal.correo = '$correo' 
                    AND personal.clave = '$clave' 
                    AND personal.idcargo = $cargo 
                    AND personal.estado = 1";

            $result = mysqli_query($link, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_array($result);
                
                // Verificar si el usuario está activo
                if ($row['estado'] == 1) {
                    $jTableResult['respuesta'] = "1";
                    $jTableResult['mensaje'] = "Inicio de sesión exitoso";
                    
                    $_SESSION['idpersonal'] = $row['idpersonal'];
                    $_SESSION['identificacion'] = $row['identificacion'];
                    $_SESSION['correo'] = $row['correo'];
                    $_SESSION['usuarioLogueado'] = $row['nombre'] . " " . $row['apellido'];
                    $_SESSION['idcargo'] = $row['idcargo'];
                    $_SESSION['cargo'] = $row['cargo'];
                    $_SESSION['loggedin'] = true;
                } else {
                    $jTableResult['mensaje'] = "Usuario inactivo";
                }
            } else {
                $jTableResult['mensaje'] = "Correo, contraseña o cargo incorrectos";
            }
        } else {
            $jTableResult['mensaje'] = "Todos los campos son obligatorios";
        }
        echo json_encode($jTableResult);
        break;

    case 'registro':
        $jTableResult = array();
        $jTableResult['respuesta'] = "0";
        $jTableResult['mensaje'] = "Error al registrar el usuario";
        $jTableResult['msjValidez'] = "";

        // Validar campos obligatorios
        $campos_requeridos = ['correo', 'clave', 'cargo', 'nombre', 'apellido', 'tipodoc', 'identificacion', 'telefono', 'direccion'];
        $campos_faltantes = [];
        
        foreach ($campos_requeridos as $campo) {
            if (empty($_POST[$campo])) {
                $campos_faltantes[] = $campo;
            }
        }
        
        if (!empty($campos_faltantes)) {
            $jTableResult['mensaje'] = "Faltan campos obligatorios: " . implode(', ', $campos_faltantes);
            echo json_encode($jTableResult);
            break;
        }

        // Sanitizar datos
        $cargo = intval($_POST['cargo']);
        $nombre = mysqli_real_escape_string($link, trim($_POST['nombre']));
        $apellido = mysqli_real_escape_string($link, trim($_POST['apellido']));
        $tipodoc = intval($_POST['tipodoc']);
        $identificacion = mysqli_real_escape_string($link, trim($_POST['identificacion']));
        $telefono = mysqli_real_escape_string($link, trim($_POST['telefono']));
        $direccion = mysqli_real_escape_string($link, trim($_POST['direccion']));
        $correo = mysqli_real_escape_string($link, trim($_POST['correo']));
        $clave = mysqli_real_escape_string($link, $_POST['clave']);
        $fecha = date("Y-m-d");

        // Validar formato de correo
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $jTableResult['mensaje'] = "El formato del correo no es válido";
            echo json_encode($jTableResult);
            break;
        }

        // Verificar si el correo ya existe
        $query = "SELECT idpersonal FROM personal WHERE correo = '$correo'";
        $result = mysqli_query($link, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $jTableResult['mensaje'] = "El correo ya está registrado";
        } else {
            // Verificar si la identificación ya existe
            $query_identificacion = "SELECT idpersonal FROM personal WHERE identificacion = '$identificacion'";
            $result_identificacion = mysqli_query($link, $query_identificacion);
            
            if ($result_identificacion && mysqli_num_rows($result_identificacion) > 0) {
                $jTableResult['mensaje'] = "La identificación ya está registrada";
                echo json_encode($jTableResult);
                break;
            }

            // Insertar nuevo usuario
            $query = "INSERT INTO personal (idcargo, nombre, apellido, idtipodocumento, identificacion, 
                                           telefono, direccion, correo, clave, fecha, estado) 
                      VALUES ('$cargo', '$nombre', '$apellido', '$tipodoc', '$identificacion', 
                              '$telefono', '$direccion', '$correo', '$clave', '$fecha', 1)";
            
            if (mysqli_query($link, $query)) {
                $jTableResult['respuesta'] = "1";
                $jTableResult['mensaje'] = "Usuario registrado con éxito";
                $jTableResult['msjValidez'] = "Usuario registrado con éxito";
            } else {
                $jTableResult['mensaje'] = "Error en la base de datos: " . mysqli_error($link);
            }
        }
        echo json_encode($jTableResult);
        break;

    case 'salir':
        $jTableResult = array();
        
        // Limpiar todas las variables de sesión
        $_SESSION = array();
        
        // Destruir la cookie de sesión
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        // Destruir la sesión
        session_destroy();
        
        $jTableResult['rspst'] = "1";
        $jTableResult['mensaje'] = "Sesión cerrada correctamente";
        echo json_encode($jTableResult);
        break;

    default:
        $jTableResult = array(
            'respuesta' => "0",
            'mensaje' => "Acción no válida"
        );
        echo json_encode($jTableResult);
        break;
}

mysqli_close($link);
?>