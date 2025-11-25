<!-- Menú Móvil -->
<nav class="navbar navbar-expand-md bg-dark navbar-dark d-md-none fixed-top shadow">
    <div class="container-fluid">
        <!-- Brand/Logo -->
        <a class="navbar-brand d-flex align-items-center" href="inicio.php">
            <i class="bi bi-laboratory me-2"></i>
            <span class="fw-bold">LabSystem</span>
        </a>

        <!-- Toggler con ícono mejorado -->
        <button class="navbar-toggler border-0" 
                type="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#mobileNavbar" 
                aria-controls="mobileNavbar" 
                aria-expanded="false" 
                aria-label="Alternar menú de navegación">
            <span class="navbar-toggler-icon"></span>
            <span class="visually-hidden">Menú</span>
        </button>

        <!-- Contenido colapsable -->
        <div class="collapse navbar-collapse bg-dark mt-2 rounded" id="mobileNavbar">
            <!-- Navegación principal -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 w-100">
                
                <!-- Gestión de Muestras -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex justify-content-between align-items-center py-3 border-bottom border-secondary" 
                       href="#" 
                       role="button" 
                       data-bs-toggle="dropdown" 
                       aria-expanded="false"
                       aria-haspopup="true">
                        <span>
                            <i class="bi bi-vial me-2"></i>
                            Gestión Muestras
                        </span>
                        <i class="bi bi-chevron-down ms-2 small"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark w-100 rounded-0 border-0" aria-labelledby="muestrasDropdown">
                        <li>
                            <a class="dropdown-item py-2 d-flex align-items-center" 
                               href="buscarmuestras.php">
                                <i class="bi bi-search me-2"></i>
                                Buscar Muestras
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-2 d-flex align-items-center" 
                               href="agregarmuestras.php">
                                <i class="bi bi-plus-circle me-2"></i>
                                Agregar Muestras
                            </a>
                        </li>
                        <li><hr class="dropdown-divider bg-secondary"></li>
                        <li>
                            <a class="dropdown-item py-2 d-flex align-items-center" 
                               href="controlcalidad.php">
                                <i class="bi bi-clipboard-check me-2"></i>
                                Control Calidad
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Gestión de Lotes -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex justify-content-between align-items-center py-3 border-bottom border-secondary" 
                       href="#" 
                       role="button" 
                       data-bs-toggle="dropdown" 
                       aria-expanded="false"
                       aria-haspopup="true">
                        <span>
                            <i class="bi bi-archive me-2"></i>
                            Gestión Lotes
                        </span>
                        <i class="bi bi-chevron-down ms-2 small"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark w-100 rounded-0 border-0" aria-labelledby="lotesDropdown">
                        <li>
                            <a class="dropdown-item py-2 d-flex align-items-center" 
                               href="agregarlote.php">
                                <i class="bi bi-plus-circle me-2"></i>
                                Agregar Lotes
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-2 d-flex align-items-center" 
                               href="buscarlote.php">
                                <i class="bi bi-search me-2"></i>
                                Buscar Lote
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Gestión de Usuarios y Roles -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex justify-content-between align-items-center py-3 border-bottom border-secondary" 
                       href="#" 
                       role="button" 
                       data-bs-toggle="dropdown" 
                       aria-expanded="false"
                       aria-haspopup="true">
                        <span>
                            <i class="bi bi-people me-2"></i>
                            Usuarios & Roles
                        </span>
                        <i class="bi bi-chevron-down ms-2 small"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark w-100 rounded-0 border-0" aria-labelledby="usuariosDropdown">
                        <li>
                            <a class="dropdown-item py-2 d-flex align-items-center" 
                               href="usuario.php">
                                <i class="bi bi-person me-2"></i>
                                Gestión Usuarios
                            </a>
                        </li>
                        <li>
                            <button class="dropdown-item py-2 d-flex align-items-center border-0 bg-transparent text-white w-100" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modal-register"
                                    type="button">
                                <i class="bi bi-person-badge me-2"></i>
                                Gestionar Roles
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item py-2 d-flex align-items-center border-0 bg-transparent text-white w-100" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#asignarpermisos"
                                    type="button">
                                <i class="bi bi-key me-2"></i>
                                Asignar Permisos
                            </button>
                        </li>
                    </ul>
                </li>

                <!-- Reportes -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex justify-content-between align-items-center py-3 border-bottom border-secondary" 
                       href="#" 
                       role="button" 
                       data-bs-toggle="dropdown" 
                       aria-expanded="false"
                       aria-haspopup="true">
                        <span>
                            <i class="bi bi-graph-up me-2"></i>
                            Reportes
                        </span>
                        <i class="bi bi-chevron-down ms-2 small"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark w-100 rounded-0 border-0" aria-labelledby="reportesDropdown">
                        <li>
                            <a class="dropdown-item py-2 d-flex align-items-center" 
                               href="reportes-muestras.php">
                                <i class="bi bi-bar-chart me-2"></i>
                                Reportes Muestras
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-2 d-flex align-items-center" 
                               href="reportes-lotes.php">
                                <i class="bi bi-pie-chart me-2"></i>
                                Reportes Lotes
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Enlaces directos -->
                <li class="nav-item">
                    <a class="nav-link py-3 border-bottom border-secondary d-flex align-items-center" 
                       href="configuracion.php">
                        <i class="bi bi-gear me-2"></i>
                        Configuración
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link py-3 border-bottom border-secondary d-flex align-items-center" 
                       href="ayuda.php">
                        <i class="bi bi-question-circle me-2"></i>
                        Ayuda
                    </a>
                </li>

            </ul>

            <!-- Botón de cerrar sesión -->
            <div class="border-top border-secondary pt-3 mt-2">
                <button id="cerrarmovil" 
                        class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center py-2" 
                        type="button"
                        aria-label="Cerrar sesión del sistema">
                    <i class="bi bi-box-arrow-right me-2"></i>
                    Cerrar Sesión
                </button>
            </div>

            <!-- Información de usuario (opcional) -->
            <div class="text-center text-muted small mt-3 border-top border-secondary pt-3">
                <div class="mb-1">Sistema Laboratorio</div>
                <div class="text-white-50">v2.1.0</div>
            </div>
        </div>
    </div>
</nav>

<!-- Espacio para compensar navbar fixed -->
<div class="d-md-none" style="height: 56px;"></div>