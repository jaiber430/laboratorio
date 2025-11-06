<?php
require_once('config.php');
header('Content-Type: text/html; charset=' . $charset);
header('Cache-Control: no-cache, must-revalidate');
include('conectar.php');
session_name($session_name);
session_start();
$link = conectar();
// ECHO "Clave : ".$_POST['claveUsu']."<br>";
// ECHO "Usuario: ".$_POST['idUsu']; exit();
switch ($_REQUEST['action']) {

	case 'selectTD':
		$jTableResult = array();
		$jTableResult['msj'] = "";
		$jTableResult['respuesta'] = "";
		$jTableResult['optionTD'] = "";
		$query = "SELECT idtipodocumento, tipodocumento FROM tipodocumento";
		$reg = mysqli_query($link, $query);
		while ($registro = mysqli_fetch_array($reg)) {
			$jTableResult['optionTD'] .= "<option value='" . $registro['idtipodocumento'] . "'>" . $registro['tipodocumento'] . "</option>";
		}
		print json_encode($jTableResult);
		break;

	case 'inicio':
		$jTableResult = array();
		$jTableResult['msj'] = "";
		$jTableResult['respuesta'] = "0";
		$jTableResult['mensaje'] = "CREDENCIALES INCORRECTAS";

		if (!empty($_POST['correo']) && !empty($_POST['clave']) && !empty($_POST['cargo'])) {
			$correo = mysqli_real_escape_string($link, $_POST['correo']);
			$clave = mysqli_real_escape_string($link, $_POST['clave']);
			$cargo = mysqli_real_escape_string($link, $_POST['cargo']);

			$sql = " SELECT personal.idpersonal, personal.idcargo, personal.nombre, personal.apellido, personal.idtipodocumento, personal.identificacion, 
				personal.telefono, personal.direccion, personal.correo, personal.clave, personal.fecha, cargos.cargo 
				FROM personal INNER JOIN cargos ON personal.idcargo = cargos.idcargo WHERE personal.correo = '$correo' AND personal.clave = '$clave' AND personal.idcargo = $cargo";
			// echo $query; exit();  
			$result = mysqli_query($link, $sql);

			if ($result && mysqli_num_rows($result) > 0) {
				$row = mysqli_fetch_array($result);
				$jTableResult['respuesta'] = "1";
				$_SESSION['idpersonal'] = $row['idpersonal'];
				$_SESSION['identificacion'] = $row['identificacion'];
				$_SESSION['correo'] = $row['correo'];
				$_SESSION['usuarioLogueado'] = $row['nombre'] . " " . $row['apellido'];
				$_SESSION['idcargo'] = $row['idcargo'];
				$_SESSION['cargo'] = $row['cargo'];
			}
		}
		print json_encode($jTableResult);
		break;

	case 'registro':
		$jTableResult = array();
		$jTableResult['msj'] = "";
		$jTableResult['respuesta'] = "0";
		$jTableResult['mensaje'] = "Error al registrar el usuario";

		if (!empty($_POST['correo']) && !empty($_POST['clave']) && !empty($_POST['cargo'])) {
			$cargo = mysqli_real_escape_string($link, $_POST['cargo']);
			$nombre = mysqli_real_escape_string($link, $_POST['nombre']);
			$apellido = mysqli_real_escape_string($link, $_POST['apellido']);
			$tipodoc = mysqli_real_escape_string($link, $_POST['tipodoc']);
			$identificacion = mysqli_real_escape_string($link, $_POST['identificacion']);
			$telefono = mysqli_real_escape_string($link, $_POST['telefono']);
			$direccion = mysqli_real_escape_string($link, $_POST['direccion']);
			$correo = mysqli_real_escape_string($link, $_POST['correo']);
			$clave = mysqli_real_escape_string($link, $_POST['clave']);
			// $clavecifrada = password_hash($clave, PASSWORD_DEFAULT);
			$fecha = date("Y-m-d");

			// Verificar si el correo ya existe
			$query = "SELECT idpersonal FROM personal WHERE correo = '$correo'";
			$result = mysqli_query($link, $query);

			if (mysqli_num_rows($result) > 0) {
				$jTableResult['mensaje'] = "El correo ya está registrado";
			} else {
				// include ('../herramientas/key/llaveregistro.php');
				$query = "INSERT INTO personal (idcargo, nombre, apellido, idtipodocumento, identificacion, telefono, direccion, correo, clave, fecha) VALUES ('$cargo', '$nombre', '$apellido', '$tipodoc', '$identificacion', '$telefono', '$direccion', '$correo', '$clave', '$fecha')";
				if (mysqli_query($link, $query)) {
					$jTableResult['respuesta'] = "1";
					$jTableResult['mensaje'] = "Usuario registrado con éxito";
				}
			}
		}

		print json_encode($jTableResult);
		break;

	case 'salir':
		$jTableResult = array();
		$jTableResult['rspst'] = "";
		unset($_SESSION['idpersonal']);
		unset($_SESSION['identificacion']);
		unset($_SESSION['usuarioLogueado']);
		unset($_SESSION['correo']);
		unset($_SESSION['cargo']);
		unset($_SESSION['idcargo']);
		session_destroy();
		$jTableResult['rspst'] = "1";
		print json_encode($jTableResult);
		break;
}
mysqli_close($link);
?>