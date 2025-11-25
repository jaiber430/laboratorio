<!DOCTYPE html>
<html lang="es" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistema de Gestión de Laboratorio - Panel de administración">
    <meta name="author" content="Laboratorio">
    <meta name="robots" content="noindex, nofollow">
    
    <!-- Security Headers -->
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' https://cdn.jsdelivr.net https://code.jquery.com; style-src 'self' https://cdn.jsdelivr.net 'unsafe-inline'; img-src 'self' data: https:; font-src 'self' https://cdn.jsdelivr.net;">
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta http-equiv="X-Frame-Options" content="DENY">
    <meta http-equiv="Referrer-Policy" content="strict-origin-when-cross-origin">
    
    <title>Sistema Laboratorio - Panel Principal</title>
    
    <!-- Favicon -->
    <link rel="icon" href="../../estilos/img/logolabo.png" type="image/png" sizes="32x32">
    <link rel="apple-touch-icon" href="../../estilos/img/logolabo.png">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" 
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" 
            integrity="sha384-1H217gwQuyK7Zv4c0MfCgGzGh42GSqPhkIMC7V4yZBhI6TqlI4F5/hC5h5JhRSPA" 
            crossorigin="anonymous"></script>
    
    <!-- Estilos personalizados -->
    <style>
        /* Variables CSS para consistencia */
        :root {
            --sidebar-width: 250px;
            --header-height: 56px;
            --transition-speed: 0.3s;
        }
        
        /* Mejoras de accesibilidad */
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }
        
        /* Transiciones suaves */
        .transition-all {
            transition: all var(--transition-speed) ease;
        }
        
        /* Mejoras de enfoque para accesibilidad */
        .btn:focus,
        .form-control:focus,
        .form-select:focus {
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
            border-color: #86b7fe;
        }
        
        /* Scroll personalizado */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
        
        /* Responsive improvements */
        @media (max-width: 767.98px) {
            .container-fluid {
                padding-left: 0;
                padding-right: 0;
            }
        }
        
        /* Loading states */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }
        
        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }
    </style>
</head>

<body class="bg-light">
    <!-- Contenedor de alertas del sistema -->
    <div id="alerts-container" class="position-fixed top-0 end-0 p-3" style="z-index: 9999;"></div>
    
    <!-- Contenedor de carga -->
    <div id="loading-overlay" class="position-fixed top-0 start-0 w-100 h-100 bg-white bg-opacity-75 d-flex justify-content-center align-items-center" style="z-index: 9998; display: none !important;">
        <div class="text-center">
            <div class="spinner-border text-primary mb-3" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <p class="text-muted">Cargando sistema...</p>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row flex-nowrap">
            <!-- Sidebar - Versión desktop -->
            <?php 
            // Verificar autenticación antes de incluir componentes
            if (!isset($_SESSION['usuarioLogueado']) || !isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
                header('Location: ../../index.php');
                exit;
            }
            include('navbar/navbarlateral.php'); 
            ?>

            <!-- Contenido principal -->
            <div class="col-md-9 col-lg-10 py-3">
                <!-- Navbar para móvil -->
                <?php include('navbar/navbarmovil.php'); ?>

                <!-- Header del contenido -->
                <header class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h3 mb-1 text-primary">
                            <i class="bi bi-speedometer2 me-2"></i>Panel Principal
                        </h1>
                        <p class="text-muted mb-0">Bienvenido, <?php echo htmlspecialchars($_SESSION['usuarioLogueado'] ?? 'Usuario'); ?></p>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-success me-3">
                            <i class="bi bi-person-circle me-1"></i>
                            <?php echo htmlspecialchars($_SESSION['cargo'] ?? 'Rol no asignado'); ?>
                        </span>
                        <button class="btn btn-outline-secondary btn-sm" id="btnThemeToggle" title="Cambiar tema">
                            <i class="bi bi-moon"></i>
                        </button>
                    </div>
                </header>

                <!-- Contenido principal -->
                <main>
                    <!-- Tarjetas de resumen -->
                    <div class="row mb-4">
                        <div class="col-md-3 mb-3">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="card-title text-muted mb-2">Total Muestras</h6>
                                            <h3 class="text-primary mb-0" id="totalMuestras">--</h3>
                                        </div>
                                        <div class="bg-primary bg-opacity-10 p-2 rounded">
                                            <i class="bi bi-vial text-primary fs-4"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="card-title text-muted mb-2">Total Lotes</h6>
                                            <h3 class="text-success mb-0" id="totalLotes">--</h3>
                                        </div>
                                        <div class="bg-success bg-opacity-10 p-2 rounded">
                                            <i class="bi bi-archive text-success fs-4"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="card-title text-muted mb-2">Usuarios Activos</h6>
                                            <h3 class="text-info mb-0" id="totalUsuarios">--</h3>
                                        </div>
                                        <div class="bg-info bg-opacity-10 p-2 rounded">
                                            <i class="bi bi-people text-info fs-4"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="card-title text-muted mb-2">Pendientes</h6>
                                            <h3 class="text-warning mb-0" id="totalPendientes">--</h3>
                                        </div>
                                        <div class="bg-warning bg-opacity-10 p-2 rounded">
                                            <i class="bi bi-clock text-warning fs-4"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Búsqueda de usuarios -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-search me-2"></i>Búsqueda de Usuarios
                            </h5>
                        </div>
                        <div class="card-body">
                            <form id="formBusquedaUsuarios" novalidate>
                                <div class="row g-3 align-items-end">
                                    <div class="col-md-8">
                                        <label for="datos" class="form-label fw-medium">
                                            Término de búsqueda
                                            <span class="text-muted small">(nombre, apellido, correo o identificación)</span>
                                        </label>
                                        <input type="text" 
                                               id="datos" 
                                               name="datos" 
                                               class="form-control" 
                                               placeholder="Ingrese nombre, apellido, correo o identificación..." 
                                               required
                                               minlength="2"
                                               maxlength="100"
                                               pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ0-9@.\s\-]+"
                                               title="Solo se permiten letras, números, @, punto y guiones">
                                        <div class="invalid-feedback">
                                            Por favor ingrese un término de búsqueda válido (mínimo 2 caracteres).
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" 
                                                id="buscar" 
                                                name="buscar" 
                                                class="btn btn-primary w-100 d-flex align-items-center justify-content-center"
                                                aria-label="Buscar usuarios">
                                            <i class="bi bi-search me-2"></i>
                                            <span>Buscar</span>
                                            <span class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true"></span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            
                            <!-- Resultados de búsqueda -->
                            <div id="usuario" class="mt-4" aria-live="polite" aria-atomic="true">
                                <div class="alert alert-info mb-0 text-center">
                                    <i class="bi bi-info-circle me-2"></i>
                                    Ingrese un término de búsqueda para mostrar resultados.
                                </div>
                            </div>
                        </div>
                    </div>
                </main>

                <!-- Footer -->
                <footer class="mt-5 pt-4 border-top">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="text-muted small">
                                &copy; <?php echo date('Y'); ?> Sistema de Laboratorio. 
                                <span class="d-block d-md-inline">Todos los derechos reservados.</span>
                            </p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <p class="text-muted small">
                                Versión 2.1.0 | 
                                <span id="currentDateTime" class="fw-medium"></span>
                            </p>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    <!-- Modales -->
    <?php include('modales/modal.php'); ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" 
            crossorigin="anonymous"></script>
    
    <!-- Script principal -->
    <script type="text/javascript" src="../modelo/main.js"></script>
    
    <!-- Inicialización -->
    <script>
        // Inicialización cuando el DOM está listo
        $(document).ready(function() {
            // Mostrar overlay de carga
            $('#loading-overlay').fadeIn(200);
            
            // Inicializar fecha y hora
            function updateDateTime() {
                const now = new Date();
                const options = { 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric',
                    hour: '2-digit', 
                    minute: '2-digit',
                    second: '2-digit'
                };
                $('#currentDateTime').text(now.toLocaleDateString('es-ES', options));
            }
            
            // Actualizar cada segundo
            updateDateTime();
            setInterval(updateDateTime, 1000);
            
            // Toggle de tema
            $('#btnThemeToggle').on('click', function() {
                const currentTheme = $('html').attr('data-bs-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                $('html').attr('data-bs-theme', newTheme);
                
                // Actualizar ícono
                const icon = $(this).find('i');
                icon.toggleClass('bi-moon bi-sun');
                
                // Guardar preferencia
                localStorage.setItem('theme', newTheme);
            });
            
            // Cargar tema guardado
            const savedTheme = localStorage.getItem('theme') || 'light';
            $('html').attr('data-bs-theme', savedTheme);
            $('#btnThemeToggle i').toggleClass('bi-moon bi-sun', savedTheme === 'dark');
            
            // Ocultar overlay cuando todo esté listo
            setTimeout(() => {
                $('#loading-overlay').fadeOut(300);
            }, 500);
            
            // Prevenir envío de formulario con Enter en campos de búsqueda
            $('#datos').on('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    $('#buscar').click();
                }
            });
        });
    </script>
</body>

</html>