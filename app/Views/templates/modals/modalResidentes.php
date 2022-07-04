<?php
    // A way to get the name of the controller that is calling the modal.
    $Url = $_SERVER['REQUEST_URI'];
    $urlSinParametros = explode('?', $Url, 2);
    $nombreControlador = ucfirst(substr(strrchr($urlSinParametros[0], "/"), 1));
?>

<!-- Modal -->
<div class="modal fade" id="<?= $nombreControlador ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content modal-style">
            <div class="modal-header header-modal">
                <h5 class="modal-title font-weight-bold" id="titleModal"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form<?= $nombreControlador ?>" name="form<?= $nombreControlador ?>" class="form-horizontal">
                    <input type="hidden" id="idResidente" name="idResidente" value="">
                    <dic class="form-row">
                        <div class="form-group col-md-6">
                            <label class="control-label font-weight-bold">Nombres <span class="text-danger">*</span></label>
                            <input class="form-control" id="txtNombres" name="txtNombres" type="text" placeholder="Nombres" required="">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label font-weight-bold">Apellidos <span class="text-danger">*</span></label>
                            <input class="form-control" id="txtApellidos" name="txtApellidos" type="text" placeholder="Apellidos" required="">
                        </div>
                    </dic>
                    <dic class="form-row">
                        <div class="form-group col-md-4">
                            <label class="control-label font-weight-bold">Edad <span class="text-danger">*</span></label>
                            <input class="form-control valid validNumber" id="intEdad" name="intEdad" type="text" placeholder="Edad" required="" onkeypress="return controlTag(event);">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label font-weight-bold">Tel&eacute;fono <span class="text-danger">*</span></label>
                            <input class="form-control valid validNumber" id="intTelefono" name="intTelefono" type="text" placeholder="Tel&eacute;fono" required="" onkeypress="return controlTag(event);">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label font-weight-bold">Correo <span class="text-danger">*</span></label>
                            <input class="form-control valid validEmail" id="txtCorreo" name="txtCorreo" type="email" placeholder="Correo" required="" >
                        </div>
                    </dic>
                    <dic class="form-row">
                        <div class="form-group col-md-6">
                            <label class="control-label font-weight-bold">Direcci&oacute;n </label>
                            <textarea class="form-control" id="txtDireccion" name="txtDireccion" rows="3"></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label font-weight-bold">Observaci&oacute;n </label>
                            <textarea class="form-control" id="txtObservacion" name="txtObservacion" rows="3"></textarea>
                        </div>
                    </dic>
                    <div id="status" class="form-group">
                        <label for="listStatus" class="font-weight-bold">Estado <span class="text-danger">*</span></label>
                        <select class="form-control selectpicker" id="listStatus" name="listStatus" data-style="colorBlue" required="">
                            <option value="1">Entregado</option>
                            <option value="0">Sin entregar</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnActionForm" class="btn color-primario" type="submit" form="form<?= $nombreControlador ?>">
                    <i class="fa fa-fw  fa-check-circle">&nbsp;</i><span id="btnText">Guardar</span>
                </button>&nbsp;&nbsp;&nbsp;
                <button class="btn btn-danger" type="button" data-dismiss="modal">
                    <i class="fa fa-fw  fa-times-circle"> </i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal View residente data -->
<div class="modal fade" id="<?= $nombreControlador ?>View" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content modal-style">
            <div class="modal-header header-modal">
                <h5 class="modal-title font-weight-bold" id="titleModalView"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form<?= $nombreControlador ?>View" name="form<?= $nombreControlador ?>View" class="form-horizontal">
                    <input type="hidden" id="idResidenteView" name="idResidenteView" value="">
                    <dic class="form-row">
                        <div class="form-group col-md-6">
                            <label class="control-label font-weight-bold">Nombres <span class="text-danger">*</span></label>
                            <input class="form-control bg-transparent" id="txtNombresView" name="txtNombresView" type="text" placeholder="Nombres" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label font-weight-bold">Apellidos <span class="text-danger">*</span></label>
                            <input class="form-control bg-transparent" id="txtApellidosView" name="txtApellidosView" type="text" placeholder="Apellidos" readonly>
                        </div>
                    </dic>
                    <dic class="form-row">
                        <div class="form-group col-md-4">
                            <label class="control-label font-weight-bold">Edad <span class="text-danger">*</span></label>
                            <input class="form-control bg-transparent" id="intEdadView" name="intEdadView" type="text" placeholder="Edad" readonly onkeypress="return controlTag(event);">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label font-weight-bold">Tel&eacute;fono <span class="text-danger">*</span></label>
                            <input class="form-control bg-transparent" id="intTelefonoView" name="intTelefonoView" type="text" placeholder="Tel&eacute;fono" readonly onkeypress="return controlTag(event);">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label font-weight-bold">Correo <span class="text-danger">*</span></label>
                            <input class="form-control bg-transparent" id="txtCorreoView" name="txtCorreoView" type="email" placeholder="Correo" readonly >
                        </div>
                    </dic>
                    <dic class="form-row">
                        <div class="form-group col-md-6">
                            <label class="control-label font-weight-bold">Direcci&oacute;n </label>
                            <textarea class="form-control bg-transparent" id="txtDireccionView" name="txtDireccionView" rows="3" readonly></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label font-weight-bold">Observaci&oacute;n </label>
                            <textarea class="form-control bg-transparent" id="txtObservacionView" name="txtObservacionView" rows="3" readonly></textarea>
                        </div>
                    </dic>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-dark" type="button" data-dismiss="modal">
                    <i class="fa fa-fw  fa-times-circle"> </i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>