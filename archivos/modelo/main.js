$(document).ready(function () {
    // Cargar los roles y mostrarlos en #listaRoles
    $.post("../controlador/permisoctrl.php", {
        action: 'presentarRoles'
    }, function (data) {
        $('#listaRoles').html(data.listaRoles);
    }, 'json');

    // Cargar menú para asignar permisos
    $.post("../controlador/permisoctrl.php", {
        action: 'presentarmenu'
    }, function (data) {
        $('#listaAsignarPermisos').html(data.listaMenu);
    }, 'json');

    // Cargar submenús
    $.post("../controlador/permisoctrl.php", {
        action: 'submenuver'
    }, function (data) {
        $('#listasubmenu').html(data.listasubmenu);
    }, 'json');

    // Abrir modal para asignar permisos al rol
    $(document).on("click", "#idBtnRol", function () {
        var idrol = $(this).data('idrol');
        var nombrerol = $(this).data('nombrerol');
        $('#idrol').val(idrol);
        $('#nombrerol').val(nombrerol);
        $('#asignarpermisos').modal('show');
    });

    // Abrir modal para editar submenú
    $(document).on("click", "#menu", function () {
        var idsubmenu = $(this).data('idsubmenu');
        var submenu = $(this).data('submenu');
        $('#idsubmenu').val(idsubmenu);
        $('#submenu').val(submenu);
        $('#submenumodal').modal('show');
    });

    // Checkbox change (opcional, ejemplo alerta)
    $(document).on("change", "#opcionSelectMenu", function () {
        if ($(this).is(":checked")) {
            alert('Permitido');
        } else {
            alert('Denegado');
        }
    });

    // Cerrar sesión
    $("#cerrar").click(function () {
        $.post("../../include/ctrlindex.php", {
            action: 'salir'
        }, function () {
            location.href = "../../index.php";
        }, 'json');
    });

    // Cerrar sesión Movil
    $("#cerrarmovil").click(function () {
        $.post("../../include/ctrlindex.php", {
            action: 'salir'
        }, function () {
            location.href = "../../index.php";
        }, 'json');
    });

    $("#cerrar").click(function () {
        //alert('Probando...');
        $.post("../../include/ctrlindex.php", {
            action: 'salir'
        }, function (data) {
            location.href = "../../index.php";
        }, 'json');
    });

    $("#buscar").click(function () {
        var dato = $("#datos").val();
        if (dato == "") {
            alert("Por favor, ingrese un dato para buscar.");
            return;
        }
        $.post("../controlador/mostarusuario.php", {
            action: 'buscarusuario',
            dato: dato
        }, function (data) {
            $('#usuario').html(data.listausuarios);
        }, 'json');
    });

    $("#buscarmuestra").click(function () {
        var dato = $("#vermuestras").val();
        if (dato == "") {
            alert("Por favor, ingrese un dato para buscar.");
            return;
        }
        $.post("../controlador/mostarusuario.php", {
            action: 'vermuestra',
            dato: dato
        }, function (data) {
            $('#mostrarmuestra').html(data.listamuestra);
        }, 'json');
    });

    function cargarlotes() {
        $.post("../controlador/agregar.php", {
            action: 'selectlotes'
        }, function (data) {
            $("#verlotes").html(data.optionTD);
        }, 'json');
    };

    $("#btn-agregar-muestra").click(function () {
        const persona = $("#persona").val();
        const codigomuestra = $("#codigomuestra").val();
        const tipomuestra = $("#tipomuestra").val();
        const verlotes = $("#verlotes").val();

        $.post("../controlador/agregar.php", {
            action: "agregarmuestra",
            persona: persona,
            codigomuestra: codigomuestra,
            tipomuestra: tipomuestra,
            verlotes: verlotes
        }, function (data) {
            if (data.respuesta == "1") {
                alert('Muestra agregada con exito');
                window.location.href = "agregarmuestras.php";
            } else {
                $("#mensaje").html(data.mensaje || "Error al agregar muestra");
            }
        }, 'json').fail(function () {
            $("#mensaje").html("Error al intentar conectar con el servidor");
        });
    });

    // Delegación de eventos por si los botones se generan dinámicamente
    $(document).on('click', '.btn-editar', function () {
        const idmuestra = $(this).data('id');

        $.post('../controlador/editar_eliminar.php', {
            action: 'obtenermuestra',
            id: idmuestra
        }, function (data) {
            if (data.respuesta === '1') {
                $('#edit-idmuestra').val(data.idmuestra);
                $('#edit-codigomuestra').val(data.codigomuestra);
                $('#edit-tipomuestra').val(data.tipomuestra);
                $('#edit-idlote').val(data.idlote);

                // Mostrar modal
                const modal = new bootstrap.Modal(document.getElementById('modalEditarMuestra'));
                modal.show();
            } else {
                alert(data.mensaje || 'Error al obtener datos de la muestra');
            }
        }, 'json').fail(function () {
            alert('Error de conexión con el servidor');
        });
    });

    $("#btnGuardarCambios").click(function () {
        const idmuestra = $("#edit-idmuestra").val();
        const codigomuestra = $("#edit-codigomuestra").val();
        const tipomuestra = $("#edit-tipomuestra").val();
        const idlote = $("#edit-idlote").val();

        $.post("../controlador/editar_eliminar.php", {
            action: "actualizarmuestra",
            idmuestra: idmuestra,
            codigomuestra: codigomuestra,
            tipomuestra: tipomuestra,
            idlote: idlote
        }, function (data) {
            if (data.respuesta === "1") {
                alert("Muestra actualizada correctamente.");
                // Opcional: recargar tabla o los datos actualizados
                location.reload();
            } else {
                alert(data.mensaje || "Error al actualizar la muestra.");
            }
        }, "json").fail(function () {
            alert("Error al conectar con el servidor.");
        });
    });

    $(document).on('click', '.btn-eliminar', function () {
        const idmuestra = $(this).data('id');

        if (confirm("¿Estás seguro de que deseas eliminar esta muestra?")) {
            $.post("../controlador/editar_eliminar.php", {
                action: "eliminarmuestra",
                idmuestra: idmuestra
            }, function (data) {
                if (data.respuesta === "1") {
                    alert("Muestra eliminada correctamente.");
                    location.reload(); // Opcional: podrías eliminar la fila directamente
                } else {
                    alert(data.mensaje || "Error al eliminar la muestra.");
                }
            }, "json").fail(function () {
                alert("Error al conectar con el servidor.");
            });
        }
    });

    $("#btn-agregar-lote").click(function () {
        const codigolote = $("#codigolote").val();
        const nombre = $("#nombrelote").val();
        const fecharecepcion = $("#fecharecepcion").val();
        const descripcion = $("#descripcion").val();

        $.post("../controlador/agregar.php", {
            action: "agregarlote",
            codigolote: codigolote,
            nombre: nombre,
            fecharecepcion: fecharecepcion,
            descripcion: descripcion
        }, function (data) {
            if (data.respuesta === "1") {
                alert("Lote agregado con éxito");
                // Limpiar el formulario en lugar de redirigir
                $("#codigolote").val("");
                $("#nombrelote").val("");
                $("#fecharecepcion").val("");
                $("#descripcion").val("");
                // $("#mensaje").html(""); // Limpiar mensajes de error
            } else {
                $("#mensaje").html(data.mensaje || "Error al agregar lote");
            }
        }, 'json').fail(function () {
            $("#mensaje").html("Error al conectar con el servidor");
        });
    });

    $("#buscarlote").click(function () {
        var dato = $("#verlotes").val();
        if (dato == "") {
            alert("Por favor, ingrese un dato para buscar.");
            return;
        }
        $.post("../controlador/mostarusuario.php", {
            action: 'verlote',
            dato: dato
        }, function (data) {
            $('#mostrarlote').html(data.listalote);
        }, 'json').fail(function () {
            alert("Error al conectar con el servidor");
        });
    });

    // EDITAR LOTE
    $(document).on('click', '.btn-editarlote', function () {
        const idlote = $(this).data('id');

        $.post('../controlador/editar_eliminar.php', {
            action: 'obtenerlote',
            id: idlote
        }, function (data) {
            if (data.respuesta === '1') {
                $('#edit-idlote').val(data.idlote);
                $('#edit-codigolote').val(data.codigolote);
                $('#edit-nombre').val(data.nombre);
                $('#edit-fecharecepcion').val(data.fecharecepcion);
                $('#edit-descripcion').val(data.descripcion);

                // Mostrar modal
                const modal = new bootstrap.Modal(document.getElementById('modalEditarLote'));
                modal.show();
            } else {
                alert(data.mensaje || 'Error al obtener datos del lote');
            }
        }, 'json').fail(function () {
            alert('Error de conexión con el servidor');
        });
    });

    // GUARDAR CAMBIOS LOTE
    $("#btnGuardarCambioslotes").click(function () {
        const idlote = $("#edit-idlote").val();
        const codigolote = $("#edit-codigolote").val();
        const nombre = $("#edit-nombre").val();
        const fecharecepcion = $("#edit-fecharecepcion").val();
        const descripcion = $("#edit-descripcion").val();

        $.post("../controlador/editar_eliminar.php", {
            action: "actualizarlote",
            idlote: idlote,
            codigolote: codigolote,
            nombre: nombre,
            fecharecepcion: fecharecepcion,
            descripcion: descripcion
        }, function (data) {
            if (data.respuesta === "1") {
                alert("Lote actualizado correctamente.");
                location.reload();
            } else {
                alert(data.mensaje || "Error al actualizar el lote.");
            }
        }, "json").fail(function () {
            alert("Error al conectar con el servidor.");
        });
    });

    // ELIMINAR LOTE
    $(document).on('click', '.btn-eliminarlote', function () {
        const idlote = $(this).data('id');

        if (confirm("¿Estás seguro de que deseas eliminar este lote?")) {
            $.post("../controlador/editar_eliminar.php", {
                action: "eliminarlote",
                idlote: idlote
            }, function (data) {
                if (data.respuesta === "1") {
                    alert("Lote eliminado correctamente.");
                    location.reload();
                } else {
                    alert(data.mensaje || "Error al eliminar el lote.");
                }
            }, "json").fail(function () {
                alert("Error al conectar con el servidor.");
            });
        }
    });

    cargarlotes();

});

