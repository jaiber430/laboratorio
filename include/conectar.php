<?php
function conectar() 
{
    // Configuración desde variables de entorno (recomendado para producción)
    $servidor = $_ENV['DB_HOST'] ?? 'localhost';
    $usuario = $_ENV['DB_USER'] ?? 'root';
    $clave = $_ENV['DB_PASS'] ?? '';
    $bd = $_ENV['DB_NAME'] ?? 'laboratorio';
    $puerto = $_ENV['DB_PORT'] ?? 3306;
    
    // Establecer la conexión
    $link = mysqli_connect($servidor, $usuario, $clave, $bd, $puerto);
    
    if (mysqli_connect_error()) {
        // Log seguro sin exponer información sensible
        error_log("Error de conexión a la base de datos");
        return false;
    }
    
    // Configurar charset y modo SQL seguro
    mysqli_set_charset($link, "utf8mb4");
    mysqli_query($link, "SET sql_mode = 'STRICT_ALL_TABLES'");
    
    return $link;
}
?>