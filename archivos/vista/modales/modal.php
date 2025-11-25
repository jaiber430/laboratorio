<!-- Contenedor para alertas del sistema -->
<div id="alerts-container" class="position-fixed top-0 end-0 p-3" style="z-index: 9999;"></div>

<!-- Modal de Roles -->
<div class="modal fade" id="modal-register" tabindex="-1" aria-labelledby="modalRegisterLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h2 class="modal-title w-100 text-center h5 mb-0" id="modalRegisterLabel">
                    <i class="fas fa-users me-2"></i>Gestión de Roles
                </h2>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar modal de roles"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info mb-3">
                    <i class="fas fa-info-circle me-2"></i>
                    Seleccione un rol para gestionar sus permisos de acceso.
                </div>
                <div id="listaRoles"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para asignar permisos -->
<div class="modal fade" id="asignarpermisos" tabindex="-1" aria-labelledby="asignarPermisosLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h2 class="modal-title h5 mb-0" id="asignarPermisosLabel">
                    <i class="fas fa-key me-2"></i>Gestión de Permisos
                </h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar modal de permisos"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="nombrerol" class="form-label fw-bold">Rol Seleccionado</label>
                        <input type="text" id="nombrerol" name="nombrerol" class="form-control bg-light" readonly>
                        <input type="hidden" id="idrol" name="idrol">
                    </div>
                    <div class="col-md-6">
                        <div class="alert alert-warning mb-0">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Los cambios se guardan automáticamente al marcar/desmarcar las casillas.
                        </div>
                    </div>
                </div>
                
                <div class="accordion" id="accordionPermisos">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingPermisos">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapsePermisos" aria-expanded="true" 
                                aria-controls="collapsePermisos">
                                <i class="fas fa-list-alt me-2"></i>
                                Menús y Permisos Disponibles
                            </button>
                        </h2>
                        <div id="collapsePermisos" class="accordion-collapse collapse show" 
                             aria-labelledby="headingPermisos" data-bs-parent="#accordionPermisos">
                            <div class="accordion-body p-0">
                                <div id="listaAsignarPermisos"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btnGuardarPermisos">
                    <i class="fas fa-save me-1"></i>Guardar Cambios
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para submenú -->
<div class="modal fade" id="submenumodal" tabindex="-1" aria-labelledby="submenuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h2 class="modal-title h5 mb-0" id="submenuModalLabel">
                    <i class="fas fa-sitemap me-2"></i>Gestión de Submenús
                </h2>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar modal de submenús"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="submenu" class="form-label fw-bold">Nombre del Submenú</label>
                        <input type="text" id="submenu" name="submenu" class="form-control" 
                               placeholder="Nombre del submenú" readonly>
                        <input type="hidden" id="idsubmenu" name="idsubmenu">
                    </div>
                    <div class="col-md-6">
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            Asigne permisos a los diferentes roles para este submenú.
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header bg-light">
                        <h3 class="card-title h6 mb-0">
                            <i class="fas fa-user-shield me-2"></i>Permisos por Rol
                        </h3>
                    </div>
                    <div class="card-body">
                        <div id="listasubmenu"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnSubmenuSubmit">
                    <i class="fas fa-check me-1"></i>Confirmar Cambios
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancelar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar muestra -->
<div class="modal fade" id="modalEditarMuestra" tabindex="-1" aria-labelledby="modalEditarMuestraLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h2 class="modal-title h5 mb-0" id="modalEditarMuestraLabel">
                    <i class="fas fa-edit me-2"></i>Editar Muestra
                </h2>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar modal de edición de muestra"></button>
            </div>
            <div class="modal-body">
                <form id="formEditarMuestra" novalidate>
                    <input type="hidden" id="edit-idmuestra" name="idmuestra">
                    
                    <div class="mb-3">
                        <label for="edit-codigomuestra" class="form-label required">
                            <i class="fas fa-barcode me-1"></i>Código de Muestra
                        </label>
                        <input type="text" class="form-control" id="edit-codigomuestra" name="codigomuestra" 
                               required maxlength="50" pattern="[A-Za-z0-9\-_]+"
                               title="Solo se permiten letras, números, guiones y guiones bajos">
                        <div class="invalid-feedback">Por favor ingrese un código de muestra válido.</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit-tipomuestra" class="form-label required">
                            <i class="fas fa-vial me-1"></i>Tipo de Muestra
                        </label>
                        <select class="form-select" id="edit-tipomuestra" name="tipomuestra" required>
                            <option value="">Seleccione un tipo</option>
                            <option value="sangre">Sangre</option>
                            <option value="orina">Orina</option>
                            <option value="tejido">Tejido</option>
                            <option value="saliva">Saliva</option>
                            <option value="otros">Otros</option>
                        </select>
                        <div class="invalid-feedback">Por favor seleccione un tipo de muestra.</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit-idlote" class="form-label required">
                            <i class="fas fa-boxes me-1"></i>Lote Asociado
                        </label>
                        <select class="form-select" id="edit-idlote" name="idlote" required>
                            <option value="">Seleccione un lote</option>
                            <!-- Las opciones se cargan dinámicamente -->
                        </select>
                        <div class="invalid-feedback">Por favor seleccione un lote.</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancelar
                </button>
                <button type="button" class="btn btn-primary" id="btnGuardarCambios">
                    <i class="fas fa-save me-1"></i>Guardar Cambios
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar lote -->
<div class="modal fade" id="modalEditarLote" tabindex="-1" aria-labelledby="modalEditarLoteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h2 class="modal-title h5 mb-0" id="modalEditarLoteLabel">
                    <i class="fas fa-edit me-2"></i>Editar Lote
                </h2>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar modal de edición de lote"></button>
            </div>
            <div class="modal-body">
                <form id="formEditarLote" novalidate>
                    <input type="hidden" id="edit-idlote" name="idlote">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit-codigolote" class="form-label required">
                                <i class="fas fa-barcode me-1"></i>Código del Lote
                            </label>
                            <input type="text" class="form-control" id="edit-codigolote" name="codigolote" 
                                   required maxlength="20" pattern="[A-Za-z0-9\-_]+"
                                   title="Solo se permiten letras, números, guiones y guiones bajos">
                            <div class="invalid-feedback">Por favor ingrese un código de lote válido.</div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="edit-fecharecepcion" class="form-label required">
                                <i class="fas fa-calendar-alt me-1"></i>Fecha de Recepción
                            </label>
                            <input type="date" class="form-control" id="edit-fecharecepcion" name="fecharecepcion" 
                                   required max="<?php echo date('Y-m-d'); ?>">
                            <div class="invalid-feedback">Por favor seleccione una fecha válida.</div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit-nombre" class="form-label required">
                            <i class="fas fa-tag me-1"></i>Nombre del Lote
                        </label>
                        <input type="text" class="form-control" id="edit-nombre" name="nombre" 
                               required maxlength="100">
                        <div class="invalid-feedback">Por favor ingrese un nombre para el lote.</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit-descripcion" class="form-label">
                            <i class="fas fa-file-alt me-1"></i>Descripción
                        </label>
                        <textarea class="form-control" id="edit-descripcion" name="descripcion" 
                                  rows="3" maxlength="255" 
                                  placeholder="Descripción opcional del lote..."></textarea>
                        <div class="form-text">Máximo 255 caracteres.</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancelar
                </button>
                <button type="button" class="btn btn-success" id="btnGuardarCambioslotes">
                    <i class="fas fa-save me-1"></i>Guardar Cambios
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación genérico -->
<div class="modal fade" id="modalConfirmacion" tabindex="-1" aria-labelledby="modalConfirmacionLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h2 class="modal-title h6 mb-0 text-dark" id="modalConfirmacionLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Confirmación
                </h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-question-circle fa-3x text-warning mb-3"></i>
                <p id="confirmacionMensaje" class="mb-0">¿Está seguro de realizar esta acción?</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancelar
                </button>
                <button type="button" class="btn btn-warning" id="btnConfirmarAccion">
                    <i class="fas fa-check me-1"></i>Confirmar
                </button>
            </div>
        </div>
    </div>
</div>