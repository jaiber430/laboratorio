<?php
include('../../include/conectar.php');
$link = conectar();

switch ($_REQUEST['action']) {

    case 'obtenermuestra':
        $respuesta = ["respuesta" => "0", "mensaje" => "ID no válido"];

        if (!empty($_POST['id']) && is_numeric($_POST['id'])) {
            $id = intval($_POST['id']);

            $sql = "SELECT * FROM muestras WHERE idmuestra = $id";
            $result = mysqli_query($link, $sql);

            if ($row = mysqli_fetch_assoc($result)) {
                $respuesta = [
                    "respuesta" => "1",
                    "idmuestra" => $row['idmuestra'],
                    "codigomuestra" => $row['codigomuestra'],
                    "tipomuestra" => $row['tipomuestra'],
                    "idlote" => $row['idlote']
                ];
            } else {
                $respuesta["mensaje"] = "No se encontró la muestra con ID: $id";
            }
        }

        echo json_encode($respuesta);
        break;

    case 'actualizarmuestra':
        $respuesta = ["respuesta" => "0", "mensaje" => "Datos incompletos"];

        if (
            !empty($_POST['idmuestra']) &&
            !empty($_POST['codigomuestra']) &&
            !empty($_POST['tipomuestra']) &&
            !empty($_POST['idlote'])
        ) {
            $id = intval($_POST['idmuestra']);
            $codigo = mysqli_real_escape_string($link, $_POST['codigomuestra']);
            $tipo = mysqli_real_escape_string($link, $_POST['tipomuestra']);
            $lote = intval($_POST['idlote']);

            $sql = "UPDATE muestras 
                SET codigomuestra = '$codigo', tipomuestra = '$tipo', idlote = $lote 
                WHERE idmuestra = $id";

            if (mysqli_query($link, $sql)) {
                $respuesta["respuesta"] = "1";
                $respuesta["mensaje"] = "Muestra actualizada con éxito";
            } else {
                $respuesta["mensaje"] = "Error al actualizar: " . mysqli_error($link);
            }
        }

        echo json_encode($respuesta);
        break;

    case 'eliminarmuestra':
        $respuesta = ["respuesta" => "0", "mensaje" => "ID no válido"];

        if (!empty($_POST['idmuestra']) && is_numeric($_POST['idmuestra'])) {
            $id = intval($_POST['idmuestra']);

            $sql = "DELETE FROM muestras WHERE idmuestra = $id";

            if (mysqli_query($link, $sql)) {
                $respuesta["respuesta"] = "1";
                $respuesta["mensaje"] = "Muestra eliminada con éxito";
            } else {
                $respuesta["mensaje"] = "Error al eliminar: " . mysqli_error($link);
            }
        }

        header('Content-Type: application/json');
        echo json_encode($respuesta);
        break;
        
    case 'obtenerlote':
        $respuesta = array("respuesta" => "0", "mensaje" => "Lote no encontrado");

        if (!empty($_POST['id'])) {
            $id = intval($_POST['id']);
            $sql = "SELECT * FROM lotes WHERE idlote = $id";
            $result = mysqli_query($link, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                $lote = mysqli_fetch_assoc($result);
                $respuesta = array(
                    "respuesta" => "1",
                    "idlote" => $lote['idlote'],
                    "codigolote" => $lote['codigolote'],
                    "nombre" => $lote['nombre'],
                    "fecharecepcion" => $lote['fecharecepcion'],
                    "descripcion" => $lote['descripcion']
                );
            } else {
                $respuesta["mensaje"] = "No se encontró el lote.";
            }
        }

        echo json_encode($respuesta);
        break;

    case 'actualizarlote':
        $respuesta = array("respuesta" => "0", "mensaje" => "Datos inválidos");

        if (!empty($_POST['idlote']) && !empty($_POST['codigolote']) && !empty($_POST['nombre']) && !empty($_POST['fecharecepcion'])) {
            $idlote = intval($_POST['idlote']);
            $codigolote = mysqli_real_escape_string($link, $_POST['codigolote']);
            $nombre = mysqli_real_escape_string($link, $_POST['nombre']);
            $fecharecepcion = mysqli_real_escape_string($link, $_POST['fecharecepcion']);
            $descripcion = mysqli_real_escape_string($link, $_POST['descripcion'] ?? '');

            $sql = "UPDATE lotes SET 
                    codigolote = '$codigolote',
                    nombre = '$nombre',
                    fecharecepcion = '$fecharecepcion',
                    descripcion = '$descripcion'
                WHERE idlote = $idlote";

            if (mysqli_query($link, $sql)) {
                $respuesta = array("respuesta" => "1", "mensaje" => "Lote actualizado correctamente");
            } else {
                $respuesta["mensaje"] = "Error al actualizar lote: " . mysqli_error($link);
            }
        }

        echo json_encode($respuesta);
        break;

    case 'eliminarlote':
        $respuesta = array("respuesta" => "0", "mensaje" => "ID no válido");

        if (!empty($_POST['idlote'])) {
            $idlote = intval($_POST['idlote']);
            $sql = "DELETE FROM lotes WHERE idlote = $idlote";

            if (mysqli_query($link, $sql)) {
                $respuesta = array("respuesta" => "1", "mensaje" => "Lote eliminado con éxito");
            } else {
                $respuesta["mensaje"] = "Error al eliminar lote: " . mysqli_error($link);
            }
        }

        echo json_encode($respuesta);
        break;
}

mysqli_close($link);
?>