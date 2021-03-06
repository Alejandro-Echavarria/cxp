<!-- Modal -->
<div class="modal fade" id="<?= ucfirst(uri_string()) ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content modal-style rounded-3 border-0">
            <div class="modal-header color-primario">
                <h5 id="titleModal" class="modal-title fw-bold">Modal title</h5>
                <button type="button" class="btn-close details-color" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form<?= ucfirst(uri_string()) ?>" name="form<?= ucfirst(uri_string()) ?>" class="form-horizontal">
                    <input type="hidden" id="id" name="id" value="">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="descripcion" class="form-label fw-bold">Descripci&oacute;n <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion">
                        </div>
                        <div class="col-md-12">
                            <label for="estado" class="form-label fw-bold">Estado <span class="text-danger">*</span></label>
                            <select class="form-control selectpicker" id="estado" name="estado" >
                                <option value="1">Activo</option>
                                <option value="2">Inactivo</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnActionForm" class="btn colorBlue-boton fw-bold" type="submit" form="form<?= ucfirst(uri_string()) ?>">
                    <i class="fa fa-fw fa-check-circle">&nbsp;</i><span id="btnText">Guardar</span>
                </button>&nbsp;&nbsp;&nbsp;
                <button class="btn colorDark-boton fw-bold" type="button" data-bs-dismiss="modal">
                    <i class="fa fa-fw fa-times-circle"> </i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>