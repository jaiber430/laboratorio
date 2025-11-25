<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Laboratorio - Inicio</title>
    <link rel="icon" href="../../estilos/img/logolabo.png" type="image/png">
    
    <!-- Security Headers (MÍNIMO ESENCIAL) -->
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta http-equiv="X-Frame-Options" content="DENY">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- jQuery ACTUALIZADO (solo esto era crítico) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="../modelo/main.js"></script>
</head>

<body>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <!-- Sidebar -->
            <?php 
            // VALIDACIÓN DE SESIÓN (añadir esto en navbarlateral.php)
            include('navbar/navbarlateral.php'); 
            ?>

            <!-- Contenido principal -->
            <div class="col py-3">
                <!-- Navbar móvil -->
                <?php include('navbar/navbarmovil.php'); ?>

                <!-- Contenido -->
                <div class="container mt-4">
                    <h1>Panel Principal</h1>
                    <p>Bienvenido al sistema de laboratorio.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modales -->
    <?php include('modales/modal.php'); ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>