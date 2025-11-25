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

switch ($_REQUEST['action']) {

    case 'presentarRoles':
        $jTableResult = array();
        $jTableResult['listaRoles'] = "";
        $jTableResult['success'] = false;

        $query = "SELECT idcargo, cargo FROM cargos WHERE estado = 1 ORDER BY cargo ASC";
        $stmt = mysqli_prepare($conn, $query);
        
        if ($stmt && mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            
            $jTableResult['listaRoles'] = "
                <div class='table-responsive'>
                    <table class='table table-striped table-hover'>
                        <thead class='table-dark'>
                            <tr>
                                <th>Nombre del Rol</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>";

            $hasRecords = false;
            while ($registro = mysqli_fetch_array($result)) {
                $hasRecords = true;
                $jTableResult['listaRoles'] .= "
                <tr>
                    <td>" . htmlspecialchars($registro['cargo'], ENT_QUOTES, 'UTF-8') . "</td>
                    <td>
                        <button 
                            type='button'
                            class='btn btn-primary btn-sm btn-ver-permisos'
                            data-idrol='" . htmlspecialchars($registro['idcargo'], ENT_QUOTES, 'UTF-8') . "'
                            data-nombrerol='" . htmlspecialchars($registro['cargo'], ENT_QUOTES, 'UTF-8') . "'>
                            <i class='fas fa-eye'></i> Ver permisos de " . htmlspecialchars($registro['cargo'], ENT_QUOTES, 'UTF-8') . "
                        </button>
                    </td>
                </tr>";
            }

            if (!$hasRecords) {
                $jTableResult['listaRoles'] .= "
                <tr>
                    <td colspan='2' class='text-center text-muted'>
                        No hay roles disponibles
                    </td>
                </tr>";
            }

            $jTableResult['listaRoles'] .= "</tbody></table></div>";
            $jTableResult['success'] = true;
            mysqli_stmt_close($stmt);
        } else {
            $jTableResult['listaRoles'] = "<div class='alert alert-danger'>Error al cargar los roles</div>";
            error_log("Error en presentarRoles: " . mysqli_error($conn));
        }

        echo json_encode($jTableResult);
        break;

    case 'presentarmenu':
        $jTableResult = array();
        $jTableResult['listaMenu'] = "";
        $jTableResult['success'] = false;

        // Consulta preparada para obtener menús
        $queryMenu = "SELECT idmenu, menu, descripcion FROM menu WHERE estado = 1 ORDER BY ordenmenu ASC";
        $stmtMenu = mysqli_prepare($conn, $queryMenu);
        
        if ($stmtMenu && mysqli_stmt_execute($stmtMenu)) {
            $resultMenu = mysqli_stmt_get_result($stmtMenu);
            $indexMenu = 0;

            // Consulta preparada para obtener cargos
            $queryCargos = "SELECT idcargo, cargo FROM cargos WHERE estado = 1 AND idcargo != 1 ORDER BY cargo ASC";
            $stmtCargos = mysqli_prepare($conn, $queryCargos);
            
            if ($stmtCargos && mysqli_stmt_execute($stmtCargos)) {
                $resultCargos = mysqli_stmt_get_result($stmtCargos);
                $cargos = [];
                while ($cargo = mysqli_fetch_assoc($resultCargos)) {
                    $cargos[] = $cargo;
                }
                mysqli_stmt_close($stmtCargos);

                // Consulta para verificar permisos existentes
                $queryPermisos = "SELECT idmenu, idcargo FROM permisos WHERE estado = 1";
                $stmtPermisos = mysqli_prepare($conn, $queryPermisos);
                $permisos = [];
                
                if ($stmtPermisos && mysqli_stmt_execute($stmtPermisos)) {
                    $resultPermisos = mysqli_stmt_get_result($stmtPermisos);
                    while ($permiso = mysqli_fetch_assoc($resultPermisos)) {
                        $permisos[$permiso['idmenu'] . '_' . $permiso['idcargo']] = true;
                    }
                    mysqli_stmt_close($stmtPermisos);
                }

                $jTableResult['listaMenu'] = "<div class='accordion' id='accordionMenu'>";
                
                while ($menu = mysqli_fetch_array($resultMenu)) {
                    $idMenu = $menu['idmenu'];
                    $nombreMenu = htmlspecialchars($menu['menu'], ENT_QUOTES, 'UTF-8');
                    $descripcionMenu = htmlspecialchars($menu['descripcion'] ?? '', ENT_QUOTES, 'UTF-8');

                    $jTableResult['listaMenu'] .= "
                        <div class='accordion-item'>
                            <h2 class='accordion-header' id='headingMenu{$indexMenu}'>
                                <button class='accordion-button collapsed' type='button' 
                                        data-bs-toggle='collapse' 
                                        data-bs-target='#collapseMenu{$indexMenu}' 
                                        aria-expanded='false' 
                                        aria-controls='collapseMenu{$indexMenu}'>
                                    <strong>{$nombreMenu}</strong>
                                    " . ($descripcionMenu ? "<small class='text-muted ms-2'>{$descripcionMenu}</small>" : "") . "
                                </button>
                            </h2>
                            <div id='collapseMenu{$indexMenu}' class='accordion-collapse collapse' 
                                 aria-labelledby='headingMenu{$indexMenu}' 
                                 data-bs-parent='#accordionMenu'>
                                <div class='accordion-body'>
                                    <div class='table-responsive'>
                                        <table class='table table-sm table-hover'>
                                            <thead>
                                                <tr>
                                                    <th>Rol</th>
                                                    <th class='text-center'>Permiso</th>
                                                    <th class='text-center'>Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody>";

                    foreach ($cargos as $cargo) {
                        $idCargo = $cargo['idcargo'];
                        $nombreCargo = htmlspecialchars($cargo['cargo'], ENT_QUOTES, 'UTF-8');
                        $checked = isset($permisos[$idMenu . '_' . $idCargo]) ? 'checked' : '';
                        $statusClass = $checked ? 'text-success' : 'text-muted';
                        $statusText = $checked ? 'Con acceso' : 'Sin acceso';

                        $jTableResult['listaMenu'] .= "
                                <tr>
                                    <td>{$nombreCargo}</td>
                                    <td class='text-center'>
                                        <div class='form-check form-switch d-inline-block'>
                                            <input type='checkbox' 
                                                   class='form-check-input permiso-checkbox' 
                                                   data-idmenu='{$idMenu}' 
                                                   data-idcargo='{$idCargo}'
                                                   id='permiso_{$idMenu}_{$idCargo}'
                                                   {$checked}>
                                            <label class='form-check-label' for='permiso_{$idMenu}_{$idCargo}'></label>
                                        </div>
                                    </td>
                                    <td class='text-center {$statusClass}'>
                                        <small>{$statusText}</small>
                                    </td>
                                </tr>";
                    }

                    $jTableResult['listaMenu'] .= "
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>";
                    $indexMenu++;
                }

                if ($indexMenu === 0) {
                    $jTableResult['listaMenu'] = "<div class='alert alert-info'>No hay menús configurados</div>";
                } else {
                    $jTableResult['listaMenu'] .= "</div>"; // Cierre del accordion
                }
                
                $jTableResult['success'] = true;
            } else {
                $jTableResult['listaMenu'] = "<div class='alert alert-danger'>Error al cargar los cargos</div>";
                error_log("Error cargando cargos: " . mysqli_error($conn));
            }
            mysqli_stmt_close($stmtMenu);
        } else {
            $jTableResult['listaMenu'] = "<div class='alert alert-danger'>Error al cargar los menús</div>";
            error_log("Error cargando menús: " . mysqli_error($conn));
        }

        echo json_encode($jTableResult);
        break;

    default:
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => 'Acción no válida'
        ]);
        break;
}

mysqli_close($conn);
?>