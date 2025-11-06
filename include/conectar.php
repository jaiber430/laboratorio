<?php
    function conectar() // function => palabra reservada pra la funcion
    {
    //Especificar a que base se conecta
    $servidor="localhost";
    $usuario="root";
    $clave="";
    $bd ="laboratorio";
    $link = mysqli_connect($servidor, $usuario, $clave, $bd); //orden establecer la conexion (mysqli_connect)
    if (mysqli_connect_error()) {
        echo "Fallo al conectar a MySQL: " . mysqli_connect_error();
    }else{
        // echo "conexion exitosa";
    // }
        return $link; // Devueleve el enlace
    }
}
?>