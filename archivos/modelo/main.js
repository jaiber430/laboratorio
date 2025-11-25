$(document).ready(function () {
    // Constantes y configuración
    const BASE_URL = "../controlador/";
    const INCLUDE_URL = "../../include/";
    const MESSAGES = {
        connectionError: "Error al conectar con el servidor",
        confirmDelete: "¿Estás seguro de que deseas eliminar este elemento?",
        requiredField: "Por favor, complete este campo",
        searchRequired: "Por favor, ingrese un dato para buscar."
    };

    // Función para hacer peticiones AJAX seguras
    function safeAjaxPost(url, data, successCallback, errorCallback) {
        return $.post({
            url: url,
            data: data,
            dataType: 'json',
            success: successCallback,
            error: function(xhr, status, error) {
                console.error('Error AJAX:', error);
                if (typeof errorCallback === 'function') {
                    errorCallback();
                } else {
                    showAlert(MESSAGES.connectionError, 'error');
                }
            }
        });
    }

    // Función para mostrar alertas (reemplaza alert() nativo)
    function showAlert(message, type = 'info') {
        const alertClass = {
            'success': 'alert-success',
            'error': 'alert-danger',
            'warning': 'alert-warning',
            'info': 'alert-info'
        }[type] || 'alert-info';

        // Si existe un sistema de notificaciones, usarlo, sino usar alert
        if (typeof Toast !== 'undefined') {
            Toast.fire({
                icon: type,
                title: message
            });
        } else {
            // Crear alerta Bootstrap si está disponible
            const alertDiv = $(`<div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>`);
            $('#alerts-container').append(alertDiv);
            setTimeout(() => alertDiv.alert('close'), 5000);
        }
    }

    // Función para validar formularios
    function validateForm(fields) {
        for (const field of fields) {
            if (!field.value.trim()) {
                showAlert(`${field.name} ${MESSAGES.requiredField}`, 'warning');
                field.focus();
                return false;
            }
        }
        return true;
    }

    // Cargar los roles y mostrarlos en #listaRoles
    function cargarRoles() {
        safeAjaxPost(
            BASE_URL + "permisoctrl.php",
            { action: 'presentarRoles' },
            function (data) {
                if (data.success) {
                    $('#listaRoles').html(data.listaRoles);
                } else {
                    $('#listaRoles').html('<div class="alert alert-danger">Error al cargar roles</div>');
                }
            }
        );
    }

    // Cargar menú para asignar permisos
    function cargarMenuPermisos() {
        safeAjaxPost(
            BASE_URL + "permisoctrl.php",
            { action: 'presentarmenu' },
            function (data) {
                if (data.success) {
                    $('#listaAsignarPermisos').html(data.listaMenu);
                } else {
                    $('#listaAsignarPermisos').html('<div class="alert alert-danger">Error al cargar menús</div>');
                }
            }
        );
    }

    // Cargar lotes para selects
    function cargarLotes() {
        safeAjaxPost(
            BASE_URL + "agregar.php",
            { action: 'selectlotes' },
            function (data) {
                if (data.optionTD) {
                    $("#verlotes").html(data.optionTD);
                }
            }
        );
    }

    // Inicialización
    function inicializar() {
        cargarRoles();
        cargarMenuPermisos();
        cargarLotes();
    }

    // Event Handlers

    // Abrir modal para asignar permisos al rol
    $(document).on("click", ".btn-ver-permisos", function () {
        const idrol = $(this).data('idrol');
        const nombrerol = $(this).data('nombrerol');
        $('#idrol').val(idrol);
        $('#nombrerol').val(nombrerol);
        
        // Usar Bootstrap 5 modal
        const modal = new bootstrap.Modal(document.getElementById('asignarpermisos'));
        modal.show();
    });

    // Gestión de checkboxes de permisos
    $(document).on("change", ".permiso-checkbox", function () {
        const idmenu = $(this).data('idmenu');
        const idcargo = $(this).data('idcargo');
        const permitido = $(this).is(":checked");

        safeAjaxPost(
            BASE_URL + "permisoctrl.php",
            {
                action: 'actualizarPermiso',
                idmenu: idmenu,
                idcargo: idcargo,
                permitido: permitido ? 1 : 0
            },
            function (data) {
                if (data.success) {
                    showAlert(`Permiso ${permitido ? 'concedido' : 'revocado'} correctamente`, 'success');
                } else {
                    showAlert(data.mensaje || "Error al actualizar permiso", 'error');
                    // Revertir el cambio visual
                    $(this).prop('checked', !permitido);
                }
            }.bind(this)
        );
    });

    // Búsqueda de usuarios
    $("#buscar").click(function () {
        const dato = $("#datos").val().trim();
        if (!dato) {
            showAlert(MESSAGES.searchRequired, 'warning');
            return;
        }

        safeAjaxPost(
            BASE_URL + "mostarusuario.php",
            {
                action: 'buscarusuario',
                dato: dato
            },
            function (data) {
                $('#usuario').html(data.listausuarios || '<div class="alert alert-info">No se encontraron resultados</div>');
            }
        );
    });

    // Búsqueda de muestras
    $("#buscarmuestra").click(function () {
        const dato = $("#vermuestras").val().trim();
        if (!dato) {
            showAlert(MESSAGES.searchRequired, 'warning');
            return;
        }

        safeAjaxPost(
            BASE_URL + "mostarusuario.php",
            {
                action: 'vermuestra',
                dato: dato
            },
            function (data) {
                $('#mostrarmuestra').html(data.listamuestra || '<div class="alert alert-info">No se encontraron resultados</div>');
            }
        );
    });

    // Búsqueda de lotes
    $("#buscarlote").click(function () {
        const dato = $("#verlotes").val().trim();
        if (!dato) {
            showAlert(MESSAGES.searchRequired, 'warning');
            return;
        }

        safeAjaxPost(
            BASE_URL + "mostarusuario.php",
            {
                action: 'verlote',
                dato: dato
            },
            function (data) {
                $('#mostrarlote').html(data.listalote || '<div class="alert alert-info">No se encontraron resultados</div>');
            }
        );
    });

    // Agregar muestra
    $("#btn-agregar-muestra").click(function () {
        const fields = [
            { value: $("#persona").val(), name: "Persona" },
            { value: $("#codigomuestra").val(), name: "Código de muestra" },
            { value: $("#tipomuestra").val(), name: "Tipo de muestra" },
            { value: $("#verlotes").val(), name: "Lote" }
        ];

        if (!validateForm(fields)) return;

        safeAjaxPost(
            BASE_URL + "agregar.php",
            {
                action: "agregarmuestra",
                persona: fields[0].value,
                codigomuestra: fields[1].value,
                tipomuestra: fields[2].value,
                verlotes: fields[3].value
            },
            function (data) {
                if (data.respuesta == "1") {
                    showAlert('Muestra agregada con éxito', 'success');
                    // Limpiar formulario
                    $("#persona, #codigomuestra, #tipomuestra").val('');
                    $("#verlotes").val('');
                } else {
                    showAlert(data.mensaje || "Error al agregar muestra", 'error');
                }
            }
        );
    });

    // Agregar lote
    $("#btn-agregar-lote").click(function () {
        const fields = [
            { value: $("#codigolote").val(), name: "Código de lote" },
            { value: $("#nombrelote").val(), name: "Nombre" },
            { value: $("#fecharecepcion").val(), name: "Fecha de recepción" }
        ];

        if (!validateForm(fields)) return;

        safeAjaxPost(
            BASE_URL + "agregar.php",
            {
                action: "agregarlote",
                codigolote: fields[0].value,
                nombre: fields[1].value,
                fecharecepcion: fields[2].value,
                descripcion: $("#descripcion").val() || ''
            },
            function (data) {
                if (data.respuesta === "1") {
                    showAlert("Lote agregado con éxito", 'success');
                    // Limpiar formulario
                    $("#codigolote, #nombrelote, #fecharecepcion, #descripcion").val("");
                    // Recargar lista de lotes
                    cargarLotes();
                } else {
                    showAlert(data.mensaje || "Error al agregar lote", 'error');
                }
            }
        );
    });

    // Editar muestra
    $(document).on('click', '.btn-editar-muestra', function () {
        const idmuestra = $(this).data('id');

        safeAjaxPost(
            BASE_URL + 'editar_eliminar.php',
            {
                action: 'obtenermuestra',
                id: idmuestra
            },
            function (data) {
                if (data.respuesta === '1') {
                    $('#edit-idmuestra').val(data.idmuestra);
                    $('#edit-codigomuestra').val(data.codigomuestra);
                    $('#edit-tipomuestra').val(data.tipomuestra);
                    $('#edit-idlote').val(data.idlote);

                    const modal = new bootstrap.Modal(document.getElementById('modalEditarMuestra'));
                    modal.show();
                } else {
                    showAlert(data.mensaje || 'Error al obtener datos de la muestra', 'error');
                }
            }
        );
    });

    // Guardar cambios de muestra
    $("#btnGuardarCambios").click(function () {
        const fields = [
            { value: $("#edit-codigomuestra").val(), name: "Código de muestra" },
            { value: $("#edit-tipomuestra").val(), name: "Tipo de muestra" },
            { value: $("#edit-idlote").val(), name: "Lote" }
        ];

        if (!validateForm(fields)) return;

        safeAjaxPost(
            BASE_URL + "editar_eliminar.php",
            {
                action: "actualizarmuestra",
                idmuestra: $("#edit-idmuestra").val(),
                codigomuestra: fields[0].value,
                tipomuestra: fields[1].value,
                idlote: fields[2].value
            },
            function (data) {
                if (data.respuesta === "1") {
                    showAlert("Muestra actualizada correctamente", 'success');
                    const modal = bootstrap.Modal.getInstance(document.getElementById('modalEditarMuestra'));
                    modal.hide();
                    // Recargar datos si es necesario
                    location.reload();
                } else {
                    showAlert(data.mensaje || "Error al actualizar la muestra", 'error');
                }
            }
        );
    });

    // Eliminar muestra
    $(document).on('click', '.btn-eliminar-muestra', function () {
        const idmuestra = $(this).data('id');
        const codigoMuestra = $(this).data('codigo');

        if (confirm(`¿Estás seguro de que deseas eliminar la muestra "${codigoMuestra}"?`)) {
            safeAjaxPost(
                BASE_URL + "editar_eliminar.php",
                {
                    action: "eliminarmuestra",
                    idmuestra: idmuestra
                },
                function (data) {
                    if (data.respuesta === "1") {
                        showAlert("Muestra eliminada correctamente", 'success');
                        // Eliminar la fila directamente sin recargar
                        $(this).closest('tr').fadeOut(400, function() {
                            $(this).remove();
                        });
                    } else {
                        showAlert(data.mensaje || "Error al eliminar la muestra", 'error');
                    }
                }.bind(this)
            );
        }
    });

    // Editar lote
    $(document).on('click', '.btn-editar-lote', function () {
        const idlote = $(this).data('id');

        safeAjaxPost(
            BASE_URL + 'editar_eliminar.php',
            {
                action: 'obtenerlote',
                id: idlote
            },
            function (data) {
                if (data.respuesta === '1') {
                    $('#edit-idlote').val(data.idlote);
                    $('#edit-codigolote').val(data.codigolote);
                    $('#edit-nombre').val(data.nombre);
                    $('#edit-fecharecepcion').val(data.fecharecepcion);
                    $('#edit-descripcion').val(data.descripcion);

                    const modal = new bootstrap.Modal(document.getElementById('modalEditarLote'));
                    modal.show();
                } else {
                    showAlert(data.mensaje || 'Error al obtener datos del lote', 'error');
                }
            }
        );
    });

    // Guardar cambios lote
    $("#btnGuardarCambioslotes").click(function () {
        const fields = [
            { value: $("#edit-codigolote").val(), name: "Código de lote" },
            { value: $("#edit-nombre").val(), name: "Nombre" },
            { value: $("#edit-fecharecepcion").val(), name: "Fecha de recepción" }
        ];

        if (!validateForm(fields)) return;

        safeAjaxPost(
            BASE_URL + "editar_eliminar.php",
            {
                action: "actualizarlote",
                idlote: $("#edit-idlote").val(),
                codigolote: fields[0].value,
                nombre: fields[1].value,
                fecharecepcion: fields[2].value,
                descripcion: $("#edit-descripcion").val() || ''
            },
            function (data) {
                if (data.respuesta === "1") {
                    showAlert("Lote actualizado correctamente", 'success');
                    const modal = bootstrap.Modal.getInstance(document.getElementById('modalEditarLote'));
                    modal.hide();
                    location.reload();
                } else {
                    showAlert(data.mensaje || "Error al actualizar el lote", 'error');
                }
            }
        );
    });

    // Eliminar lote
    $(document).on('click', '.btn-eliminar-lote', function () {
        const idlote = $(this).data('id');
        const nombreLote = $(this).data('nombre');

        if (confirm(`¿Estás seguro de que deseas eliminar el lote "${nombreLote}"?`)) {
            safeAjaxPost(
                BASE_URL + "editar_eliminar.php",
                {
                    action: "eliminarlote",
                    idlote: idlote
                },
                function (data) {
                    if (data.respuesta === "1") {
                        showAlert("Lote eliminado correctamente", 'success');
                        $(this).closest('tr').fadeOut(400, function() {
                            $(this).remove();
                        });
                    } else {
                        showAlert(data.mensaje || "Error al eliminar el lote", 'error');
                    }
                }.bind(this)
            );
        }
    });

    // Cerrar sesión (función reutilizable)
    function cerrarSesion() {
        safeAjaxPost(
            INCLUDE_URL + "ctrlindex.php",
            { action: 'salir' },
            function () {
                window.location.href = "../../index.php";
            }
        );
    }

    // Eventos de cierre de sesión
    $("#cerrar, #cerrarmovil").click(function (e) {
        e.preventDefault();
        cerrarSesion();
    });

    // Inicializar la aplicación
    inicializar();
});