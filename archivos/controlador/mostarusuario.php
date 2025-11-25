<?php
header('Cache-Control: no-cache, must-revalidate');
header('Content-Type: application/json; charset=utf-8');
date_default_timezone_set('America/Bogota');

include('../../include/conectar.php');

// Validar método de petición
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'error' => 'Método no permitido'
    ]);
    exit;
}

$conn = conectar();
if (!$conn) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Error de conexión a la base de datos'
    ]);
    exit;
}

// Validar que la acción esté definida
if (!isset($_REQUEST['action'])) {
    http_response_code(400);
    echo json_encode([
        'error' => 'Acción no especificada'
    ]);
    exit;
}

// Validar que el dato de búsqueda esté presente
if (!isset($_POST['dato'])) {
    http_response_code(400);
    echo json_encode([
        'error' => 'Término de búsqueda no proporcionado'
    ]);
    exit;
}

$dato = trim($_POST['dato']);

// Validar longitud del término de búsqueda
if (strlen($dato) > 100) {
    http_response_code(400);
    echo json_encode([
        'error' => 'Término de búsqueda demasiado largo'
    ]);
    exit;
}

switch ($_REQUEST['action']) {

    case 'buscarusuario':
        $jTableResult = array();
        $jTableResult['listausuarios'] = "";
        $jTableResult['total'] = 0;

        // Consulta preparada para prevenir SQL injection
        $query = "SELECT idpersonal, nombre, apellido, correo, identificacion 
                  FROM personal 
                  WHERE (nombre LIKE ? OR apellido LIKE ? OR correo LIKE ? OR identificacion LIKE ?) 
                  AND estado = 1 
                  ORDER BY nombre ASC 
                  LIMIT 50"; // Limitar resultados por seguridad

        $stmt = mysqli_prepare($conn, $query);
        if ($stmt) {
            $param = "%" . $dato . "%";
            mysqli_stmt_bind_param($stmt, "ssss", $param, $param, $param, $param);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            $jTableResult['listausuarios'] = "
                <table class='table table-striped table-hover'>
                    <thead class='thead-dark'>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Correo</th>
                            <th>Identificación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>";

            $contador = 1;
            while ($registro = mysqli_fetch_array($result)) {
                $jTableResult['listausuarios'] .= "
                <tr>
                    <td>" . htmlspecialchars($contador, ENT_QUOTES, 'UTF-8') . "</td>
                    <td>" . htmlspecialchars($registro['nombre'], ENT_QUOTES, 'UTF-8') . "</td>
                    <td>" . htmlspecialchars($registro['apellido'], ENT_QUOTES, 'UTF-8') . "</td>
                    <td>" . htmlspecialchars($registro['correo'], ENT_QUOTES, 'UTF-8') . "</td>
                    <td>" . htmlspecialchars($registro['identificacion'], ENT_QUOTES, 'UTF-8') . "</td>
                    <td>
                        <button class='btn btn-sm btn-primary btn-editar-usuario' 
                                data-id='" . htmlspecialchars($registro['idpersonal'], ENT_QUOTES, 'UTF-8') . "'>
                            Editar
                        </button>
                    </td>
                </tr>";
                $contador++;
            }

            if ($contador === 1) {
                $jTableResult['listausuarios'] .= "
                <tr>
                    <td colspan='6' class='text-center text-muted'>
                        No se encontraron usuarios con el término: " . htmlspecialchars($dato, ENT_QUOTES, 'UTF-8') . "
                    </td>
                </tr>";
            }

            $jTableResult['listausuarios'] .= "</tbody></table>";
            $jTableResult['total'] = $contador - 1;
            mysqli_stmt_close($stmt);
        } else {
            $jTableResult['listausuarios'] = "<div class='alert alert-danger'>Error en la consulta</div>";
        }
        echo json_encode($jTableResult);
        break;

    case 'vermuestra':
        $jTableResult = array();
        $jTableResult['listamuestra'] = "";
        $jTableResult['total'] = 0;

        $query = "SELECT m.idmuestra, m.persona, m.codigomuestra, m.tipomuestra, l.nombre as nombre_lote 
                  FROM muestras m 
                  LEFT JOIN lotes l ON m.idlote = l.idlote 
                  WHERE (m.persona LIKE ? OR m.codigomuestra LIKE ? OR m.tipomuestra LIKE ? OR l.nombre LIKE ?) 
                  AND m.estado = 1 
                  ORDER BY m.persona ASC 
                  LIMIT 50";

        $stmt = mysqli_prepare($conn, $query);
        if ($stmt) {
            $param = "%" . $dato . "%";
            mysqli_stmt_bind_param($stmt, "ssss", $param, $param, $param, $param);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            $jTableResult['listamuestra'] = "
                <table class='table table-striped table-hover'>
                    <thead class='thead-dark'>
                        <tr>
                            <th>#</th>
                            <th>Persona</th>
                            <th>Código Muestra</th>
                            <th>Tipo Muestra</th>
                            <th>Lote</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>";

            $contador = 1;
            while ($registro = mysqli_fetch_array($result)) {
                $jTableResult['listamuestra'] .= "
                <tr>
                    <td>" . htmlspecialchars($contador, ENT_QUOTES, 'UTF-8') . "</td>
                    <td>" . htmlspecialchars($registro['persona'], ENT_QUOTES, 'UTF-8') . "</td>
                    <td>" . htmlspecialchars($registro['codigomuestra'], ENT_QUOTES, 'UTF-8') . "</td>
                    <td>" . htmlspecialchars($registro['tipomuestra'], ENT_QUOTES, 'UTF-8') . "</td>
                    <td>" . htmlspecialchars($registro['nombre_lote'] ?? 'N/A', ENT_QUOTES, 'UTF-8') . "</td>
                    <td>
                        <button class='btn btn-sm btn-warning btn-editar-muestra' 
                                data-id='" . htmlspecialchars($registro['idmuestra'], ENT_QUOTES, 'UTF-8') . "'>
                            Editar
                        </button>
                        <button class='btn btn-sm btn-danger btn-eliminar-muestra' 
                                data-id='" . htmlspecialchars($registro['idmuestra'], ENT_QUOTES, 'UTF-8') . "'
                                data-codigo='" . htmlspecialchars($registro['codigomuestra'], ENT_QUOTES, 'UTF-8') . "'>
                            Borrar
                        </button>
                    </td>
                </tr>";
                $contador++;
            }

            if ($contador === 1) {
                $jTableResult['listamuestra'] .= "
                <tr>
                    <td colspan='6' class='text-center text-muted'>
                        No se encontraron muestras con el término: " . htmlspecialchars($dato, ENT_QUOTES, 'UTF-8') . "
                    </td>
                </tr>";
            }

            $jTableResult['listamuestra'] .= "</tbody></table>";
            $jTableResult['total'] = $contador - 1;
            mysqli_stmt_close($stmt);
        } else {
            $jTableResult['listamuestra'] = "<div class='alert alert-danger'>Error en la consulta</div>";
        }
        echo json_encode($jTableResult);
        break;

    case 'verlote':
        $jTableResult = array();
        $jTableResult['listalote'] = "";
        $jTableResult['total'] = 0;

        $query = "SELECT idlote, codigolote, nombre, fecharecepcion, descripcion 
                  FROM lotes 
                  WHERE (codigolote LIKE ? OR nombre LIKE ? OR descripcion LIKE ?) 
                  AND estado = 1 
                  ORDER BY fecharecepcion DESC 
                  LIMIT 50";

        $stmt = mysqli_prepare($conn, $query);
        if ($stmt) {
            $param = "%" . $dato . "%";
            mysqli_stmt_bind_param($stmt, "sss", $param, $param, $param);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            $jTableResult['listalote'] = "
                <table class='table table-striped table-hover'>
                    <thead class='thead-dark'>
                        <tr>
                            <th>#</th>
                            <th>Código Lote</th>
                            <th>Nombre</th>
                            <th>Fecha Recepción</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>";

            $contador = 1;
            while ($registro = mysqli_fetch_array($result)) {
                $jTableResult['listalote'] .= "
                <tr>
                    <td>" . htmlspecialchars($contador, ENT_QUOTES, 'UTF-8') . "</td>
                    <td>" . htmlspecialchars($registro['codigolote'], ENT_QUOTES, 'UTF-8') . "</td>
                    <td>" . htmlspecialchars($registro['nombre'], ENT_QUOTES, 'UTF-8') . "</td>
                    <td>" . htmlspecialchars($registro['fecharecepcion'], ENT_QUOTES, 'UTF-8') . "</td>
                    <td>" . htmlspecialchars($registro['descripcion'], ENT_QUOTES, 'UTF-8') . "</td>
                    <td>
                        <button class='btn btn-sm btn-warning btn-editar-lote' 
                                data-id='" . htmlspecialchars($registro['idlote'], ENT_QUOTES, 'UTF-8') . "'>
                            Editar
                        </button>
                        <button class='btn btn-sm btn-danger btn-eliminar-lote' 
                                data-id='" . htmlspecialchars($registro['idlote'], ENT_QUOTES, 'UTF-8') . "'
                                data-nombre='" . htmlspecialchars($registro['nombre'], ENT_QUOTES, 'UTF-8') . "'>
                            Borrar
                        </button>
                    </td>
                </tr>";
                $contador++;
            }

            if ($contador === 1) {
                $jTableResult['listalote'] .= "
                <tr>
                    <td colspan='6' class='text-center text-muted'>
                        No se encontraron lotes con el término: " . htmlspecialchars($dato, ENT_QUOTES, 'UTF-8') . "
                    </td>
                </tr>";
            }

            $jTableResult['listalote'] .= "</tbody></table>";
            $jTableResult['total'] = $contador - 1;
            mysqli_stmt_close($stmt);
        } else {
            $jTableResult['listalote'] = "<div class='alert alert-danger'>Error en la consulta</div>";
        }
        echo json_encode($jTableResult);
        break;

    default:
        http_response_code(400);
        echo json_encode([
            'error' => 'Acción no válida'
        ]);
        break;
}

mysqli_close($conn);
?>