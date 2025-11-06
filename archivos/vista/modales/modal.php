          <!-- Modal de Registro (Roles) -->
          <div class="modal fade" id="modal-register" tabindex="-1" aria-labelledby="modalRegisterLabel"
              aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content">

                      <div class="modal-header">
                          <h5 class="modal-title w-100 text-center" id="modalRegisterLabel">Roles</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                      </div>

                      <div class="modal-body">
                          <div id="listaRoles" class="mt-3"></div>
                      </div>

                  </div>
              </div>
          </div>

          </div>
          </div>
          </div>
          </div>

          <!-- Modal para asignar permisos -->
          <div class="modal fade" id="asignarpermisos" tabindex="-1" aria-labelledby="languageModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title">Menu</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                      </div>
                      <div class="modal-body">
                          <input type="text" id="nombrerol" name="nombrerol" title="Nombre del rol" class="form-control" readonly>
                          <div class="accordion mt-4" id="accordionPermisos">
                              <div class="accordion-item">
                                  <h2 class="accordion-header" id="headingPermisos">
                                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                          data-bs-target="#collapsePermisos" aria-expanded="false" aria-controls="collapsePermisos">
                                          Menu
                                      </button>
                                  </h2>
                                  <div id="collapsePermisos" class="accordion-collapse collapse" aria-labelledby="headingPermisos"
                                      data-bs-parent="#accordionPermisos">
                                      <div class="accordion-body">
                                          <div id="listaAsignarPermisos" class="mt-3"></div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-primary" id="btnLanguageSubmit">Enviar</button>
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                      </div>
                  </div>
              </div>
          </div>

          <!-- Modal para submenú -->
          <div class="modal fade" id="submenumodal" tabindex="-1" aria-labelledby="languageModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title">Submenú</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                      </div>
                      <div class="modal-body">
                          <input type="hidden" id="idsubmenu" name="idsubmenu" class="form-control mb-2">
                          <input type="text" id="submenu" name="submenu" title="Nombre del submenú" class="form-control mb-3" readonly>
                          <div id="listasubmenu" class="mt-3"></div>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-primary" id="btnSubmenuSubmit">Enviar</button>
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                      </div>
                  </div>
              </div>
          </div>

          <!-- Modal -->
          <div class="modal fade" id="modalEditarMuestra" tabindex="-1" role="dialog" aria-labelledby="modalEditarLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title">Editar Muestra</h5>
                          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Cerrar">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
                          <form id="formEditarMuestra">
                              <input type="hidden" id="edit-idmuestra">

                              <div class="form-group mb-2">
                                  <label for="edit-codigomuestra">Código Muestra</label>
                                  <input type="text" class="form-control" id="edit-codigomuestra" required>
                              </div>
                              <div class="form-group mb-2">
                                  <label for="edit-tipomuestra">Tipo Muestra</label>
                                  <input type="text" class="form-control" id="edit-tipomuestra" required>
                              </div>
                              <div class="form-group mb-2">
                                  <label for="edit-idlote">ID Lote</label>
                                  <input type="text" class="form-control" id="edit-idlote" required>
                              </div>
                          </form>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                          <button type="button" class="btn btn-primary" id="btnGuardarCambios">Guardar Cambios</button>
                      </div>
                  </div>
              </div>
          </div>

          <div class="modal fade" id="modalEditarLote" tabindex="-1" aria-labelledby="modalEditarLoteLabel" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title">Editar Lote</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                      </div>
                      <div class="modal-body">
                          <form id="formEditarLote">
                              <input type="hidden" id="edit-idlote">
                              <div class="mb-3">
                                  <label for="edit-codigolote" class="form-label">Código Lote</label>
                                  <input type="text" class="form-control" id="edit-codigolote" required>
                              </div>
                              <div class="mb-3">
                                  <label for="edit-nombre" class="form-label">Nombre</label>
                                  <input type="text" class="form-control" id="edit-nombre" required>
                              </div>
                              <div class="mb-3">
                                  <label for="edit-fecharecepcion" class="form-label">Fecha Recepción</label>
                                  <input type="date" class="form-control" id="edit-fecharecepcion" required>
                              </div>
                              <div class="mb-3">
                                  <label for="edit-descripcion" class="form-label">Descripción</label>
                                  <textarea class="form-control" id="edit-descripcion" rows="3"></textarea>
                              </div>
                          </form>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                          <button type="button" class="btn btn-primary" id="btnGuardarCambioslotes">Guardar Cambios</button>
                      </div>
                  </div>
              </div>
          </div>