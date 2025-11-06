<?php
header('Cache-Control: no-cache, must-revalidate');
date_default_timezone_set('America/Bogota');
header('Content-Type: application/json');
include('../../include/conectar.php');
$conn = conectar();
$fecha = date("Y-m-d");

switch ($_REQUEST['action']) {

    case 'buscarusuario':
        $jTableResult = array();
        $jTableResult['listausuarios'] = "";

        $query = "SELECT idpersonal, nombre, apellido, correo, identificacion FROM personal WHERE nombre LIKE '%" . $_POST['dato'] . "%' OR apellido LIKE '%" . $_POST['dato'] . "%' OR correo LIKE '%" . $_POST['dato'] . "%' OR identificacion LIKE '%" . $_POST['dato'] . "%' ORDER BY nombre ASC";
        $jTableResult['listausuarios'] = "
            <table class='table table-striped'>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Correo</th>
                        <th>Identificación</th>
                        <th>Editar</th>
                    </tr>
                </thead>
                <tbody>";
        if ($result = mysqli_query($conn, $query)) {
            $contador = 1;
            while ($registro = mysqli_fetch_array($result)) {
                $jTableResult['listausuarios'] .= "
                <tr>
                    <td>$contador</td>
                    <td>{$registro['nombre']}</td>
                    <td>{$registro['apellido']}</td>
                    <td>{$registro['correo']}</td>
                    <td>{$registro['identificacion']}</td>
                    <td><button><a href='Editar.php'>Editar<a></button></td>
                </tr>";
                $contador++;
            }
        }
        echo json_encode($jTableResult);
        break;

    case 'vermuestra':
        $jTableResult = array();
        $jTableResult['listamuestra'] = "";

        $query = "SELECT idmuestra, persona, codigomuestra, tipomuestra, idlote FROM muestras WHERE persona LIKE '%" . $_POST['dato'] . "%' OR codigomuestra LIKE '%" . $_POST['dato'] . "%' OR tipomuestra LIKE '%" . $_POST['dato'] . "%' OR idlote LIKE '%" . $_POST['dato'] . "%' ORDER BY persona ASC";
        $jTableResult['listamuestra'] = "
            <table class='table table-striped'>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Persona</th>
                        <th>Codigo muestra</th>
                        <th>Tipo muestra</th>
                        <th>Lote</th>
                        <th>Editar</th>
                        <th>Borrar</th>
                    </tr>
                </thead>
                <tbody>";
        if ($result = mysqli_query($conn, $query)) {
            $contador = 1;
            while ($registro = mysqli_fetch_array($result)) {
                $jTableResult['listamuestra'] .= "
                <tr>
                    <td>$contador</td>
                    <td>{$registro['persona']}</td>
                    <td>{$registro['codigomuestra']}</td>
                    <td>{$registro['tipomuestra']}</td>
                    <td>{$registro['idlote']}</td>
                    <td><button class='btn btn-sm btn-warning btn-editar' data-id='{$registro['idmuestra']}'>Editar</button></td>
                    <td>
                        <button class='btn btn-sm btn-danger btn-eliminar' data-id='{$registro['idmuestra']}'>Borrar</button>
                    </td>
                </tr>";
                $contador++;
            }
        }
        echo json_encode($jTableResult);
        break;
    case 'verlote':
        $jTableResult = array();
        $jTableResult['listalote'] = "";

        $query = "SELECT idlote, codigolote, nombre, fecharecepcion, descripcion 
              FROM lotes 
              WHERE codigolote LIKE '%" . $_POST['dato'] . "%' 
                 OR nombre LIKE '%" . $_POST['dato'] . "%' 
                 OR descripcion LIKE '%" . $_POST['dato'] . "%' 
              ORDER BY fecharecepcion DESC";

        $jTableResult['listalote'] = "
        <table class='table table-striped'>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Código Lote</th>
                    <th>Nombre</th>
                    <th>Fecha Recepción</th>
                    <th>Descripción</th>
                    <th>Editar</th>
                    <th>Borrar</th>
                </tr>
            </thead>
            <tbody>";

        if ($result = mysqli_query($conn, $query)) {
            $contador = 1;
            while ($registro = mysqli_fetch_array($result)) {
                $jTableResult['listalote'] .= "
            <tr>
                <td>$contador</td>
                <td>{$registro['codigolote']}</td>
                <td>{$registro['nombre']}</td>
                <td>{$registro['fecharecepcion']}</td>
                <td>{$registro['descripcion']}</td>
                <td><button class='btn btn-sm btn-warning btn-editarlote' data-id='{$registro['idlote']}'>Editar</button></td>
                <td><button class='btn btn-sm btn-danger btn-eliminarlote' data-id='{$registro['idlote']}'>Borrar</button></td>
            </tr>";
                $contador++;
            }
        }
        $jTableResult['listalote'] .= "</tbody></table>";

        echo json_encode($jTableResult);
        break;
}

mysqli_close($conn);
?>