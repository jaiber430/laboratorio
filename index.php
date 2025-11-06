<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modelo 3</title>
    <link rel="website icon" href="estilos/img/logolabo.png" type="image">
    <link rel="stylesheet" href="estilos/style.css" />
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
 
            document.addEventListener('contextmenu', function(e) {
                e.preventDefault();
                return false;
            }, false);

            $("#correo").val("");
            $("#clave").val("");

            function cargarSelectTD() {
                $.post("include/ctrlindex.php", {
                    action: 'selectTD'
                }, function(data) {
                    $("#tipodoc").html(data.optionTD);
                }, 'json');
            };

            // Iniciar sesión
            $("#btningresar").click(function() {
                const correo = $("#correo").val();
                const clave = $("#clave").val();
                const cargo = $("#cargo").val();

                $.post("include/ctrlindex.php", {
                    action: "inicio",
                    correo: correo,
                    clave: clave,
                    cargo: cargo
                }, function(data) {
                    if (data.respuesta == "1") {
                        window.location.href = "archivos/vista/inicio.php";
                    } else {
                        $("#mensaje").html(data.mensaje || "Error al autenticar");
                    }
                }, 'json').fail(function() {
                    $("#mensaje").html("Error al intentar conectar con el servidor");
                });
            });

            // Registro de usuario
            $("#nuevousuario").click(function() {
                const cargo = $("#cargoregistro").val();
                const nombre = $("#nombre").val();
                const apellido = $("#apellido").val();
                const tipodoc = $("#tipodoc").val();
                const identificacion = $("#identificacion").val();
                const telefono = $("#telefono").val();
                const direccion = $("#direccion").val();
                const correo = $("#correoregistro").val();
                const clave = $("#claveregistro").val();
                const fecha = $("#fecha").val();

                $.post("include/ctrlindex.php", {
                    action: "registro",
                    cargo: cargo,
                    nombre: nombre,
                    apellido: apellido,
                    tipodoc: tipodoc,
                    identificacion: identificacion,
                    telefono: telefono,
                    direccion: direccion,
                    correo: correo,
                    clave: clave
                }, function(data) {
                    if (data.respuesta == "1") {
                        // alert("Usuario registrado con éxito");
                        $("#mensaje").html(data.msjValidez);
                        if (correo) {
                            $.post("herramientas/key/llaveregistro.php", {
                                correo: correo
                            }, function(data) {
                                $("#mensaje").html(data.msjValidez);
                                $("#correo").focus();
                            }, 'json');
                        } else {
                            alert("Porfavor llene los campos");
                            $("#correo").focus();
                        }
                    } else {
                        $("#mensaje").html(data.mensaje || "Error al registrar usuario");
                    }
                }, 'json');
            });
            $("#correo").on("click", function() {
                // alert("HOLA");
                $("#mensaje").html("");

            });

            // Recuperar clave
            $("#btnrecuperar").on("click", function() {
                // alert("Recuperando ando");
                let email = $("#correo").val();

                if (email) {
                    $.post("herramientas/key/ctrlllave.php", {
                        correo: email
                    }, function(data) {
                        $("#mensaje").html(data.msjValidez);
                        $("#correo").focus();
                    }, 'json');
                } else {
                    alert("Porfavor llene los campos");
                    $("#correo").focus();
                }
            });
            cargarSelectTD();
        });
    </script>

</head>

<body>
    <div class="login-container">
        <div class="logo">
            <img src="estilos/img/microscopio.jpeg" alt="Logo" width="80">
        </div>

        <h1>Personal laboratorio</h1>

        <div class="input-group">
            <input type="text" id="correo" name="correo" placeholder="Correo" required>
        </div>

        <div class="input-group">
            <input type="password" id="clave" name="clave" placeholder="Contraseña" required>
        </div>

        <div class="input-group">
            <select name="cargo" id="cargo">
                <option value="">Tipo de cargo</option>
                <option value="1">Jefe laboratorio</option>
                <option value="2">Flebotomista</option>
                <option value="3">Tecnico laboratorio</option>
                <option value="4">Paciente</option>
            </select>
        </div>

        <div class="btn-container">
            <a id="btningresar" class="btn btn-primary">Ingresar</a>
            <a href="#modal-register" class="btn btn-secondary">Registrar</a>
        </div>

        <div class="links">
            <button type="button" id="btnrecuperar">¿Olvidaste tu contraseña?</button>
        </div>
        <div id="mensaje" class="mensaje-error"></div>
    </div>
    while($registro = mysqli_fetch_array($resultado))
{
    echo "<input id='idMenu' value='".$registro['idMenu']."'>".$registro['nombreMenu'].">";
}

    <!-- Modal de Registro -->
    <div id="modal-register" class="modal">
        <div class="modal-content">
            <a href="#" class="close-btn">&times;</a>
            <div style="text-align:center">
                <h2>Registro de Usuario</h2>
            </div>

            <div class="input-group">
                <select name="cargoregistro" id="cargoregistro">
                    <option value="">Tipo de cargo</option>
                    <option value="1">Jefe laboratorio</option>
                    <option value="2">Flebotomista</option>
                    <option value="3">Tecnico laboratorio</option>
                    <option value="4">Paciente</option>
                </select>
            </div>

            <div class="input-group">
                <input type="text" id="nombre" name="nombre" placeholder="Nombre">
            </div>

            <div class="input-group">
                <input type="text" id="apellido" name="apellido" placeholder="Apellido">
            </div>

            <div class="input-group">
                <p>Tipos documento</p>
                <select id="tipodoc" name="tipodoc" required></select>
            </div>

            <div class="input-group">
                <input type="text" id="identificacion" name="identificacion" placeholder="Identificación">
            </div>

            <div class="input-group">
                <input type="text" id="telefono" name="telefono" placeholder="Telefono">
            </div>

            <div class="input-group">
                <input type="text" id="direccion" name="direccion" placeholder="Direccion">
            </div>
            <div class="input-group">
                <input type="email" id="correoregistro" name="correoregistro" placeholder="Correo">
            </div>

            <div class="input-group">
                <input type="password" id="claveregistro" name="claveregistro" placeholder="Contraseña">
            </div>

            <div class="btn-container">
                <a id="nuevousuario" class="btn btn-primary">Registrarse</a>
            </div>
        </div>
    </div>
</body>

</html>