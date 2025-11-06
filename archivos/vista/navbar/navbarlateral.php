<div class="col-md-3 col-lg-2 bg-success d-none d-md-block min-vh-100 text-white p-0">
    <div class="p-3">
        <h4 class="text-white mb-4"><a href="inicio.php" style="color:white;">Menú</a></h4>
        <ul class="nav nav-pills flex-column min-vh-100">
            <li class="nav-item">
                <a href="#homeCollapse" class="nav-link text-white d-flex justify-content-between align-items-center" data-bs-toggle="collapse" aria-expanded="false" aria-controls="homeCollapse">
                    <span><i class="bi bi-house me-2"></i> Inicio</span>
                    <i class="bi bi-chevron-down"></i>
                </a>
                <div class="collapse" id="homeCollapse">
                    <ul class="nav flex-column ps-4">
                        <li class="nav-item">
                            <!-- Cambié button por a para consistencia -->
                            <a href="#" class="nav-link text-white" data-bs-toggle="modal" data-bs-target="#modal-register" role="button" type="button">
                                Registrar Rol
                            </a>
                        </li>
                        <li class="nav-item"><a href="buscarmuestras.php" class="nav-link text-white">Buscar muestras</a></li>
                        <li class="nav-item"><a href="agregarmuestras.php" class="nav-link text-white">Agregar Muestras</a></li>
                        <li class="nav-item"><a href="agregarlote.php" class="nav-link text-white">Agregar lotes</a></li>
                        <li class="nav-item"><a href="buscarlote.php" class="nav-link text-white">Buscar lote</a></li>
                        <li class="nav-item"><a href="controlcalidad.php" class="nav-link text-white">Control Calidad</a></li>
                        <li class="nav-item"><a href="usuario.php" class="nav-link text-white">Usuarios</a></li> <!-- corregido -->
                    </ul>
                </div>
            </li>
            <li class="nav-item"><a href="#" class="nav-link text-white">Páginas</a></li>
            <li class="nav-item"><a href="#" class="nav-link text-white">Portafolio</a></li>
            <li class="nav-item"><a href="#" class="nav-link text-white">Contacto</a></li>
            <li class="nav-item">
                <button id="cerrar" class="btn btn-danger w-100 mt-4" type="button">Cerrar sesión</button>
            </li>
        </ul>
    </div>
</div>