<?php
include('../../include/conectar.php');
// session_name($session_name);
// session_start();
$link = conectar();

switch ($_REQUEST['action']) {

    case 'selectlotes':
        $jTableResult = array();
        $jTableResult['msj'] = "";
        $jTableResult['respuesta'] = "";
        $jTableResult['optionTD'] = "";
        $query = "SELECT idlote, nombre FROM lotes";
        $reg = mysqli_query($link, $query);
        while ($registro = mysqli_fetch_array($reg)) {
            $jTableResult['optionTD'] .= "<option value='" . $registro['idlote'] . "'>" . $registro['nombre'] . "</option>";
        }
        print json_encode($jTableResult);
        break;

    case 'agregarmuestra':
        $respuesta = array("respuesta" => "0", "mensaje" => "Datos inválidos");

        if (!empty($_POST['persona']) && !empty($_POST['codigomuestra']) && !empty($_POST['tipomuestra']) && !empty($_POST['verlotes'])) {
            $persona = mysqli_real_escape_string($link, $_POST['persona']);
            $codigomuestra = mysqli_real_escape_string($link, $_POST['codigomuestra']);
            $tipomuestra = mysqli_real_escape_string($link, $_POST['tipomuestra']);
            $lote = intval($_POST['verlotes']);

            $sql = "INSERT INTO laboratorio.muestras (persona, codigomuestra, tipomuestra, idlote) 
                VALUES ('$persona', '$codigomuestra', '$tipomuestra', '$lote')";

            if (mysqli_query($link, $sql)) {
                $respuesta["respuesta"] = "1";
                $respuesta["mensaje"] = "Muestra registrada correctamente";
            } else {
                $respuesta["mensaje"] = "Error al registrar la muestra: " . mysqli_error($link);
            }
        }

        echo json_encode($respuesta);
        break;

    case 'agregarlote':
        $respuesta = array("respuesta" => "0", "mensaje" => "Datos inválidos");

        if (!empty($_POST['codigolote']) && !empty($_POST['nombre']) && !empty($_POST['fecharecepcion']) && !empty($_POST['descripcion'])) {
            // include_once('../config/conexion.php'); // Asegúrate de que la conexión esté aquí
            $codigolote = mysqli_real_escape_string($link, $_POST['codigolote']);
            $nombre = mysqli_real_escape_string($link, $_POST['nombre']);
            $fecharecepcion = mysqli_real_escape_string($link, $_POST['fecharecepcion']);
            $descripcion = mysqli_real_escape_string($link, $_POST['descripcion']);

            $sql = "INSERT INTO lotes (codigolote, nombre, fecharecepcion, descripcion)
                VALUES ('$codigolote', '$nombre', '$fecharecepcion', '$descripcion')";

            if (mysqli_query($link, $sql)) {
                $respuesta["respuesta"] = "1";
                $respuesta["mensaje"] = "Lote registrado correctamente";
            } else {
                $respuesta["mensaje"] = "Error al registrar el lote: " . mysqli_error($link);
            }
        }

        echo json_encode($respuesta);
        break;



    case 'selectlote':
        $jTableResult = array();
        $jTableResult['msj'] = "";
        $jTableResult['respuesta'] = "";
        $jTableResult['optionlotes'] = "";

        $query = "SELECT idlote, nombre FROM lotes";
        $reg = mysqli_query($link, $query);

        if ($reg && mysqli_num_rows($reg) > 0) {
            while ($registro = mysqli_fetch_array($reg)) {
                $jTableResult['optionlotes'] .= "<option value='" . $registro['idlote'] . "'>" . $registro['nombre'] . "</option>";
            }
        } else {
            $jTableResult['optionlotes'] = "<option value=''>No hay lotes</option>";
        }

        echo json_encode($jTableResult);
        break;
}

mysqli_close($link);
