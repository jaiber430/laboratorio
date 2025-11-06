<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>laboratorio - inicio</title>
    <link rel="icon" href="../../estilos/img/logolabo.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
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

                <!-- Contenido -->
                <div class="container mt-4">
                    <h1>Acomodar esto</h1>
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