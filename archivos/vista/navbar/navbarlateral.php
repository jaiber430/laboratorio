<!-- Menú Lateral -->
<div class="col-md-3 col-lg-2 bg-dark d-none d-md-block min-vh-100 text-white p-0">
    <div class="sidebar-sticky position-sticky top-0">
        <div class="p-3 border-bottom border-secondary">
            <h4 class="text-white mb-0">
                <a href="inicio.php" class="text-white text-decoration-none d-flex align-items-center">
                    <i class="bi bi-laboratory me-2"></i>
                    <span class="fw-bold">Sistema Lab</span>
                </a>
            </h4>
            <small class="text-muted">Panel de Control</small>
        </div>
        
        <nav class="nav flex-column p-3" aria-label="Menú principal">
            <!-- Inicio con submenú -->
            <div class="nav-item mb-2">
                <a href="#homeCollapse" 
                   class="nav-link text-white d-flex justify-content-between align-items-center rounded" 
                   data-bs-toggle="collapse" 
                   aria-expanded="false" 
                   aria-controls="homeCollapse"
                   role="button">
                    <span>
                        <i class="bi bi-house-door me-2"></i> 
                        <span class="fw-medium">Inicio</span>
                    </span>
                    <i class="bi bi-chevron-down transition-all"></i>
                </a>
                <div class="collapse mt-1" id="homeCollapse">
                    <div class="ps-3 border-start border-secondary">
                        <a href="buscarmuestras.php" 
                           class="nav-link text-white py-2 px-3 rounded mb-1 d-flex align-items-center">
                            <i class="bi bi-search me-2 small"></i>
                            Buscar Muestras
                        </a>
                        <a href="agregarmuestras.php" 
                           class="nav-link text-white py-2 px-3 rounded mb-1 d-flex align-items-center">
                            <i class="bi bi-plus-circle me-2 small"></i>
                            Agregar Muestras
                        </a>
                        <a href="agregarlote.php" 
                           class="nav-link text-white py-2 px-3 rounded mb-1 d-flex align-items-center">
                            <i class="bi bi-archive me-2 small"></i>
                            Agregar Lotes
                        </a>
                        <a href="buscarlote.php" 
                           class="nav-link text-white py-2 px-3 rounded mb-1 d-flex align-items-center">
                            <i class="bi bi-search me-2 small"></i>
                            Buscar Lote
                        </a>
                        <a href="controlcalidad.php" 
                           class="nav-link text-white py-2 px-3 rounded mb-1 d-flex align-items-center">
                            <i class="bi bi-clipboard-check me-2 small"></i>
                            Control Calidad
                        </a>
                        <a href="usuario.php" 
                           class="nav-link text-white py-2 px-3 rounded mb-1 d-flex align-items-center">
                            <i class="bi bi-people me-2 small"></i>
                            Gestión Usuarios
                        </a>
                        <button class="nav-link text-white py-2 px-3 rounded mb-1 d-flex align-items-center w-100 border-0 bg-transparent" 
                                data-bs-toggle="modal" 
                                data-bs-target="#modal-register"
                                type="button">
                            <i class="bi bi-person-badge me-2 small"></i>
                            Gestionar Roles
                        </button>
                    </div>
                </div>
            </div>

            <!-- Gestión de Permisos -->
            <div class="nav-item mb-2">
                <a href="#permisosCollapse" 
                   class="nav-link text-white d-flex justify-content-between align-items-center rounded" 
                   data-bs-toggle="collapse" 
                   aria-expanded="false" 
                   aria-controls="permisosCollapse"
                   role="button">
                    <span>
                        <i class="bi bi-shield-lock me-2"></i> 
                        <span class="fw-medium">Permisos</span>
                    </span>
                    <i class="bi bi-chevron-down transition-all"></i>
                </a>
                <div class="collapse mt-1" id="permisosCollapse">
                    <div class="ps-3 border-start border-secondary">
                        <button class="nav-link text-white py-2 px-3 rounded mb-1 d-flex align-items-center w-100 border-0 bg-transparent" 
                                data-bs-toggle="modal" 
                                data-bs-target="#asignarpermisos"
                                type="button">
                            <i class="bi bi-key me-2 small"></i>
                            Asignar Permisos
                        </button>
                        <button class="nav-link text-white py-2 px-3 rounded mb-1 d-flex align-items-center w-100 border-0 bg-transparent" 
                                data-bs-toggle="modal" 
                                data-bs-target="#submenumodal"
                                type="button">
                            <i class="bi bi-list-nested me-2 small"></i>
                            Gestionar Submenús
                        </button>
                    </div>
                </div>
            </div>

            <!-- Reportes -->
            <div class="nav-item mb-2">
                <a href="#reportesCollapse" 
                   class="nav-link text-white d-flex justify-content-between align-items-center rounded" 
                   data-bs-toggle="collapse" 
                   aria-expanded="false" 
                   aria-controls="reportesCollapse"
                   role="button">
                    <span>
                        <i class="bi bi-graph-up me-2"></i> 
                        <span class="fw-medium">Reportes</span>
                    </span>
                    <i class="bi bi-chevron-down transition-all"></i>
                </a>
                <div class="collapse mt-1" id="reportesCollapse">
                    <div class="ps-3 border-start border-secondary">
                        <a href="reportes-muestras.php" 
                           class="nav-link text-white py-2 px-3 rounded mb-1 d-flex align-items-center">
                            <i class="bi bi-bar-chart me-2 small"></i>
                            Reportes Muestras
                        </a>
                        <a href="reportes-lotes.php" 
                           class="nav-link text-white py-2 px-3 rounded mb-1 d-flex align-items-center">
                            <i class="bi bi-pie-chart me-2 small"></i>
                            Reportes Lotes
                        </a>
                    </div>
                </div>
            </div>

            <!-- Enlaces directos -->
            <div class="nav-item mb-2">
                <a href="configuracion.php" 
                   class="nav-link text-white rounded d-flex align-items-center">
                    <i class="bi bi-gear me-2"></i>
                    <span class="fw-medium">Configuración</span>
                </a>
            </div>

            <div class="nav-item mb-2">
                <a href="ayuda.php" 
                   class="nav-link text-white rounded d-flex align-items-center">
                    <i class="bi bi-question-circle me-2"></i>
                    <span class="fw-medium">Ayuda</span>
                </a>
            </div>

            <!-- Separador -->
            <hr class="border-secondary my-3">

            <!-- Cerrar Sesión -->
            <div class="nav-item">
                <button id="cerrar" 
                        class="btn btn-outline-light w-100 d-flex align-items-center justify-content-center" 
                        type="button"
                        aria-label="Cerrar sesión">
                    <i class="bi bi-box-arrow-right me-2"></i>
                    Cerrar Sesión
                </button>
            </div>
        </nav>
    </div>
</div>