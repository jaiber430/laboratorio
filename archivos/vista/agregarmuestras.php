<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>laboratorio - inicio</title>
    <link rel="website icon" href="../../estilos/img/logolabo.png" type="image" />
    <link rel="stylesheet" href="../../estilos/forms.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script type="text/javascript" src="../modelo/main.js"></script>
</head>

<body>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <!-- Sidebar - Versión desktop -->
            <?php
            include('navbar/navbarlateral.php')
            ?>
            <!-- Contenido principal -->
            <div class="col py-3">
                <!-- Navbar para móvil -->
                <?php
                include('navbar/navbarmovil.php')
                ?>

                <!-- Contenido -->
                <div class="container mt-4">
                    <div class="lab-form">

                        <h1>Agregar Muestra</h1>

                        <div class="input-group">
                            <input type="text" id="persona" name="persona" placeholder="Persona" required />
                        </div>

                        <div class="input-group">
                            <input type="text" id="codigomuestra" name="codigomuestra" placeholder="Codigo muestra" required />
                        </div>

                        <div class="input-group">
                            <input type="text" id="tipomuestra" name="tipomuestra" placeholder="Tipo muestra" required />
                        </div>

                        <div class="input-group">
                            <select name="verlotes" id="verlotes"></select>
                        </div>

                        <div class="btn-container">
                            <button id="btn-agregar-muestra" class="btn">Agregar Muestra</button>
                        </div>
                        <div id="mensaje" class="mensaje-error"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('modales/modal.php') ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>