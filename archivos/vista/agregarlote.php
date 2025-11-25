<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Laboratorio - Agregar Lote</title>
    <link rel="icon" href="../../estilos/img/logolabo.png" type="image/png">
    
    <!-- Security header básico -->
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    
    <link rel="stylesheet" href="../../estilos/forms.css" />
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
                    <div class="lab-form">
                        <h1>Agregar Lote</h1>

                        <div class="input-group">
                            <input type="text" id="codigolote" name="codigolote" placeholder="Código de lote" required>
                        </div>

                        <div class="input-group">
                            <input type="text" id="nombrelote" name="nombrelote" placeholder="Nombre del lote" required>
                        </div>

                        <div class="input-group">
                            <input type="date" id="fecharecepcion" name="fecharecepcion" required>
                        </div>

                        <div class="input-group">
                            <textarea id="descripcion" name="descripcion" placeholder="Descripción" rows="3"></textarea>
                        </div>

                        <div class="btn-container">
                            <button id="btn-agregar-lote" class="btn">Agregar Lote</button>
                        </div>

                        <div id="mensaje" class="mensaje-error"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('modales/modal.php'); ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>