<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Laboratorio - Buscar Muestras</title>
    <link rel="icon" href="../../estilos/img/logolabo.png" type="image/png">
    
    <!-- Security header básico -->
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- jQuery ACTUALIZADO (solo cambio crítico) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="../modelo/main.js"></script>
</head>

<body>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <!-- Sidebar -->
            <?php include('navbar/navbarlateral.php'); ?>

            <!-- Contenido principal -->
            <div class="col py-3">
                <!-- Navbar móvil -->
                <?php include('navbar/navbarmovil.php'); ?>

                <!-- Contenido -->
                <div class="container mt-4">
                    <input type="text" id="vermuestras" name="vermuestras" class="form-control mb-2" placeholder="Consultar Muestras" required>
                    <button type="button" id="buscarmuestra" name="buscarmuestra" class="btn btn-primary" style="cursor:pointer;">
                        Buscar Muestra
                    </button>
                    <div id="mostrarmuestra" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>

    <?php include('modales/modal.php'); ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>