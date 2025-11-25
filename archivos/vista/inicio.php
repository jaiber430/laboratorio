<?php
include("../../include/conectar.php");
include("../../herramientas/key/llave.php");
include("../../include/config.php");

$link = conectar();
session_name($session_name);
session_start();

// Validación básica de sesión
if (!isset($_SESSION['idcargo']) || empty($_SESSION['idcargo'])) {
    header('location: ../../index.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sistema Laboratorio - Inicio</title>
    <link rel="icon" href="../../estilos/img/logolabo.png" type="image/png" />
    
    <!-- Security headers mínimos -->
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    
    <link rel="stylesheet" href="../../estilos/stylemodal.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    
    <!-- jQuery ACTUALIZADO (solo cambio crítico) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="../modelo/main.js"></script>
</head>

<body>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <!-- Sidebar - Versión desktop -->
            <?php include('navbar/navbarlateral.php'); ?>

            <!-- Contenido principal -->
            <div class="col py-3">
                <!-- Navbar para móvil -->
                <?php include('navbar/navbarmovil.php'); ?>

                <!-- Contenido principal -->
                <div class="container mt-4">
                    <h1>Inicio</h1>

                    <!-- Modales -->
                    <?php include('modales/modal.php'); ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>