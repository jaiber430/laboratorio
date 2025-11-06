<nav class="navbar navbar-expand-md bg-success d-md-none">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mobileNavbar" aria-controls="mobileNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mobileNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">

                <!-- Menú principal con dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Opciones
                    </a>

                    <ul class="dropdown-menu">
                        <!-- Rol: abre modal -->
                        <li>
                            <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-register">Roles</a>
                        </li>
                        <!-- Otros enlaces -->
                        <li><a class="dropdown-item" href="#">Personas</a></li>
                        <li><a class="dropdown-item" href="#">Programas</a></li>
                        <li><a class="dropdown-item" href="usuario.php">Usuarios</a></li>
                        <li><a class="dropdown-item" href="buscarmuestras.php">Buscar muestras</a></li>
                        <li><a class="dropdown-item" href="agregarmuestras.php">Agregar Muestras</a></li>
                        <li><a href="agregarlote.php" class="dropdown-item">Agregar lotes</a></li>
                        <li><a href="buscarlote.php" class="dropdown-item">Buscar lote</a></li>
                    </ul>
                </li>

            </ul>

            <!-- Botón de cerrar sesión: fuera del UL para mejor semántica -->
            <button id="cerrarmovil" class="btn btn-danger w-100 mt-3 mt-md-0">Cerrar sesión</button>
        </div>
    </div>
</nav>