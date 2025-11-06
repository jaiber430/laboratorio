<?php
header('Cache-Control: no-cache, must-revalidate');
date_default_timezone_set('America/Bogota');
header('Content-Type: application/json');
include('../../include/conectar.php');
$conn = conectar();
$fecha = date("Y-m-d");

switch ($_REQUEST['action']) {

    case 'presentarRoles':
        $jTableResult = array();
        $jTableResult['listaRoles'] = "";

        $query = "SELECT idcargo, cargo FROM cargos ORDER BY cargo ASC";
        $jTableResult['listaRoles'] = "
            <table class='table table-striped'>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody>";

        if ($result = mysqli_query($conn, $query)) {
            while ($registro = mysqli_fetch_array($result)) {
                $jTableResult['listaRoles'] .= "
                <tr>
                    <td>{$registro['cargo']}</td>
                    <td>
                        <button 
                            type='button'
                            id='idBtnRol'
                            data-idrol='{$registro['idcargo']}'
                            data-nombrerol='{$registro['cargo']}'
                            class='btn btn-danger btn-sm'>
                            ver menu del rol {$registro['cargo']}
                        </button>
                    </td>
                </tr>";
            }
            $jTableResult['listaRoles'] .= "</tbody></table>";
        }

        print json_encode($jTableResult);
        break;


case 'presentarmenu':
    $jTableResult = array();
    $jTableResult['listaMenu'] = "";

    $queryMenu = "SELECT idmenu, menu FROM menu ORDER BY ordenmenu ASC";

    if ($resultMenu = mysqli_query($conn, $queryMenu)) {
        $indexMenu = 0;

        while ($menu = mysqli_fetch_array($resultMenu)) {
            $idMenu = $menu['idmenu'];
            $nombreMenu = $menu['menu'];

            $jTableResult['listaMenu'] .= "
                <div class='accordion-item'>
                    <h2 class='accordion-header' id='headingMenu{$indexMenu}'>
                        <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#collapseMenu{$indexMenu}' aria-expanded='false' aria-controls='collapseMenu{$indexMenu}'>
                            {$nombreMenu}
                        </button>
                    </h2>
                    <div id='collapseMenu{$indexMenu}' class='accordion-collapse collapse' aria-labelledby='headingMenu{$indexMenu}' data-bs-parent='#accordionsubmenu'>
                        <div class='accordion-body'>
                            <table class='table table-striped'>
                                <thead>
                                    <tr>
                                        <th>Rol</th>
                                        <th>Dar permiso</th>
                                    </tr>
                                </thead>
                                <tbody>";

            // Consulta de cargos
            $queryCargos = "SELECT idcargo, cargo FROM cargos WHERE cargos.idcargo != 1 ORDER BY cargo ASC";
            if ($resultCargos = mysqli_query($conn, $queryCargos)) {
                while ($cargo = mysqli_fetch_array($resultCargos)) {
                    $jTableResult['listaMenu'] .= "
                        <tr>
                            <td>{$cargo['cargo']}</td>
                            <td>
                                <input type='checkbox' class='form-check-input' id  ='opcionSelectMenu' 
                                    data-idmenu='{$idMenu}' 
                                    data-idcargo='{$cargo['idcargo']}' 
                                    id='permiso_{$idMenu}_{$cargo['idcargo']}'>
                            </td>
                        </tr>";
                }
            }

            $jTableResult['listaMenu'] .= "
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>";

            $indexMenu++;
        }
    }

    print json_encode($jTableResult);
    break;

    // case 'presentarmenu':
    //     $jTableResult = array();
    //     $jTableResult['listaMenu'] = "";

    //     $query = "SELECT idmenu, menu, ordenmenu FROM menu ORDER BY ordenmenu ASC";
    //     $jTableResult['listaMenu'] = "
    //         <table class='table table-striped'>
    //             <thead><tr><th>Opciones de menú</th></tr></thead>
    //             <tbody>";

    //     if ($result = mysqli_query($conn, $query)) {
    //         while ($registro = mysqli_fetch_array($result)) {
    //             $jTableResult['listaMenu'] .= "
    //             <tr>
    //                 <td>
    //                     <button  
    //                         type='button'
    //                         id='menu'
    //                         data-idsubmenu='{$registro['idmenu']}'
    //                         data-submenu='{$registro['menu']}'
    //                         class='btn btn-warning btn-sm'>
    //                         {$registro['menu']}
    //                     </button>
    //                 </td>
    //             </tr>";
    //         }
    //         $jTableResult['listaMenu'] .= "</tbody></table>";
    //     }

    //     print json_encode($jTableResult);
    //     break;

    // case 'presentarmenu':
    //     $jTableResult = array();
    //     $jTableResult['listaMenu'] = "";

    //     $query = "SELECT menu.idmenu, cargos.idcargo, submenu.idsubmenu, submenu.submenu, submenu.ordensubmenu 
    //               FROM submenu, permisos, cargos, menu
    //               WHERE submenu.idsubmenu = permisos.idsubmenu 
    //               AND submenu.idsubmenu = menu.idmenu
    //               AND permisos.idcargo = cargos.idcargo = 1 
    //               AND permisos.idmenu = menu.idmenu = 1 
    //               ORDER BY ordensubmenu ASC";
    //     $jTableResult['listaMenu'] = "
    //         <table class='table table-striped'>
    //             <thead><tr><th>Opciones del submenu</th></tr></thead>
    //             <tbody>";

    //     if ($result = mysqli_query($conn, $query)) {
    //         while ($registro = mysqli_fetch_array($result)) {
    //             $jTableResult['listaMenu'] .= "
    //             <tr>
    //                 <td>
    //                     <button  
    //                         type='button'
    //                         id='menu'
    //                         data-submenu='{$registro['submenu']}'
    //                         class='btn btn-warning btn-sm'>
    //                         {$registro['submenu']}
    //                     </button>
    //                 </td>
    //             </tr>";
    //         }
    //         $jTableResult['listaMenu'] .= "</tbody></table>";
    //     }

    //     print json_encode($jTableResult);
    //     break;

    // case 'submenuver':
    //     $jTableResult = array();
    //     $jTableResult['listasubmenu'] = "";

    //     $query = "SELECT idsubmenu, submenu, ordensubmenu 
    //               FROM submenu 
    //               ORDER BY ordensubmenu ASC";

    //     $jTableResult['listasubmenu'] = "
    //         <table class='table table-bordered'>
    //             <thead>
    //                 <tr>
    //                     <th>Submenú</th>
    //                     <th>Seleccionar</th>
    //                 </tr>
    //             </thead>
    //             <tbody>";

    //     if ($result = mysqli_query($conn, $query)) {
    //         while ($registro = mysqli_fetch_array($result)) {
    //             $jTableResult['listasubmenu'] .= "
    //             <tr>
    //                 <td>{$registro['submenu']}</td>
    //                 <td>
    //                     <input type='checkbox' id=opcionSelectMenu form-check-input' data-idmenu='{$registro['idsubmenu']}'>
    //                 </td>
    //             </tr>";
    //         }
    //         $jTableResult['listasubmenu'] .= "</tbody></table>";
    //     }

    //     print json_encode($jTableResult);
    //     break;

    // case 'submenuver':
    //     $jTableResult = array();
    //     $jTableResult['listasubmenu'] = "";

    //     $query = "SELECT idcargo, cargo
    //               FROM cargos
    //               WHERE cargos.idcargo 
    //               ORDER BY idcargo ASC";

    //     $jTableResult['listasubmenu'] = "
    //         <table class='table table-bordered'>
    //             <thead>
    //                 <tr>
    //                     <th>Rol</th>
    //                     <th>Dar permisos</th>
    //                 </tr>
    //             </thead>
    //             <tbody>";

    //     if ($result = mysqli_query($conn, $query)) {
    //         while ($registro = mysqli_fetch_array($result)) {
    //             $jTableResult['listasubmenu'] .= "
    //             <tr>
    //                 <td>{$registro['cargo']}</td>
    //                 <td>
    //                     <input type='checkbox' id=opcionSelectMenu form-check-input' data-idmenu='{$registro['idcargo']}'>
    //                 </td>
    //             </tr>";
    //         }
    //         $jTableResult['listasubmenu'] .= "</tbody></table>";
    //     }

    //     print json_encode($jTableResult);
    //     break;
}

mysqli_close($conn);
