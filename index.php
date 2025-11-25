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
            // Deshabilitar clic derecho
            document.addEventListener('contextmenu', function(e) {
                e.preventDefault();
                return false;
            }, false);

            // Limpiar campos al cargar
            $("#correo").val("");
            $("#clave").val("");

            // Cargar tipos de documento
            function cargarSelectTD() {
                $.post("include/ctrlindex.php", {
                    action: 'selectTD'
                }, function(data) {
                    $("#tipodoc").html(data.optionTD);
                }, 'json');
            }

            // Iniciar sesión
            $("#btningresar").click(function() {
                const correo = $("#correo").val();
                const clave = $("#clave").val();
                const cargo = $("#cargo").val();

                // Validación básica
                if (!correo || !clave || !cargo) {
                    $("#mensaje").html("Por favor, complete todos los campos");
                    return;
                }

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

                // Validación básica
                if (!cargo || !nombre || !apellido || !tipodoc || !identificacion || 
                    !telefono || !direccion || !correo || !clave) {
                    $("#mensaje").html("Por favor, complete todos los campos");
                    return;
                }

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
                        $("#mensaje").html(data.msjValidez || "Usuario registrado con éxito");
                        
                        // Enviar correo de confirmación
                        if (correo) {
                            $.post("herramientas/key/llaveregistro.php", {
                                correo: correo
                            }, function(data) {
                                $("#mensaje").html(data.msjValidez || "Correo de confirmación enviado");
                                $("#correo").focus();
                            }, 'json');
                        }
                    } else {
                        $("#mensaje").html(data.mensaje || "Error al registrar usuario");
                    }
                }, 'json').fail(function() {
                    $("#mensaje").html("Error al intentar conectar con el servidor");
                });
            });

            // Limpiar mensaje al hacer clic en correo
            $("#correo").on("click", function() {
                $("#mensaje").html("");
            });

            // Recuperar clave
            $("#btnrecuperar").on("click", function() {
                let email = $("#correo").val();

                if (email) {
                    $.post("herramientas/key/ctrlllave.php", {
                        correo: email
                    }, function(data) {
                        $("#mensaje").html(data.msjValidez || "Instrucciones enviadas a su correo");
                        $("#correo").focus();
                    }, 'json').fail(function() {
                        $("#mensaje").html("Error al intentar conectar con el servidor");
                    });
                } else {
                    $("#mensaje").html("Por favor, ingrese su correo electrónico");
                    $("#correo").focus();
                }
            });

            // Cerrar modal
            $(".close-btn").on("click", function(e) {
                e.preventDefault();
                $("#modal-register").hide();
            });

            // Abrir modal
            $('a[href="#modal-register"]').on("click", function(e) {
                e.preventDefault();
                $("#modal-register").show();
            });

            // Cargar tipos de documento al inicio
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
            <select name="cargo" id="cargo" required>
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

    <!-- Modal de Registro -->
    <div id="modal-register" class="modal" style="display:none;">
        <div class="modal-content">
            <a href="#" class="close-btn">&times;</a>
            <div style="text-align:center">
                <h2>Registro de Usuario</h2>
            </div>

            <div class="input-group">
                <select name="cargoregistro" id="cargoregistro" required>
                    <option value="">Tipo de cargo</option>
                    <option value="1">Jefe laboratorio</option>
                    <option value="2">Flebotomista</option>
                    <option value="3">Tecnico laboratorio</option>
                    <option value="4">Paciente</option>
                </select>
            </div>

            <div class="input-group">
                <input type="text" id="nombre" name="nombre" placeholder="Nombre" required>
            </div>

            <div class="input-group">
                <input type="text" id="apellido" name="apellido" placeholder="Apellido" required>
            </div>

            <div class="input-group">
                <p>Tipos documento</p>
                <select id="tipodoc" name="tipodoc" required></select>
            </div>

            <div class="input-group">
                <input type="text" id="identificacion" name="identificacion" placeholder="Identificación" required>
            </div>

            <div class="input-group">
                <input type="text" id="telefono" name="telefono" placeholder="Telefono" required>
            </div>

            <div class="input-group">
                <input type="text" id="direccion" name="direccion" placeholder="Direccion" required>
            </div>
            
            <div class="input-group">
                <input type="email" id="correoregistro" name="correoregistro" placeholder="Correo" required>
            </div>

            <div class="input-group">
                <input type="password" id="claveregistro" name="claveregistro" placeholder="Contraseña" required>
            </div>

            <div class="btn-container">
                <a id="nuevousuario" class="btn btn-primary">Registrarse</a>
            </div>
        </div>
    </div>
</body>

</html>