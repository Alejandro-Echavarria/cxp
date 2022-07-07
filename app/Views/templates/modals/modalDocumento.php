<!-- Modal -->
<div class="modal fade" id="<?= ucfirst(uri_string()) ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content modal-style rounded-3 border-0" style="overflow: visible;">
            <div class="modal-header color-primario">
                <h5 id="titleModal" class="modal-title fw-bold">Modal title</h5>
                <button type="button" class="btn-close details-color" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="overflow: visible;">
                <form id="form<?= ucfirst(uri_string()) ?>" name="form<?= ucfirst(uri_string()) ?>" class="form-horizontal">
                    <input type="hidden" id="id" name="id" value="">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="monto" class="form-label fw-bold">Monto <span class="text-danger">*</span></label>
                            <input type="text" class="form-control validNumber" id="monto" name="monto" onkeypress="return controlTag(event);">
                        </div>
                        <div class="col-md-6">
                            <label for="factura" class="form-label fw-bold">Factura <span class="text-danger">*</span></label>
                            <input type="text" class="form-control validNumber" id="factura" name="factura" onkeypress="return controlTag(event);">
                        </div>
                        <div class="col-md-12">
                            <label for="proveedor" class="form-label fw-bold">Proveedor <span class="text-danger">*</span></label>
                            <select class="form-control selectpicker" id="proveedor" name="proveedor" data-size="4" data-live-search="true">
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

<!-- Modal editar documentos / balances proveedores -->
<div class="modal fade" id="<?= ucfirst(uri_string()) ?>edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content modal-style rounded-3 border-0" style="overflow: visible;">
            <div class="modal-header color-primario">
                <h5 id="titleModalEdit" class="modal-title fw-bold">Modal title</h5>
                <button type="button" class="btn-close details-color" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="overflow: visible;">
                <form id="form<?= ucfirst(uri_string()) ?>edit" name="form<?= ucfirst(uri_string()) ?>edit" class="form-horizontal">
                    <input type="hidden" id="idEdit" name="idEdit" value="">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="monto_deuda" class="form-label fw-bold">Deuda </label>
                            <input type="text" class="form-control bg-transparent" id="monto_deuda" name="monto_deuda" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="monto-pagar" class="form-label fw-bold">Monto <span class="text-danger">*</span></label>
                            <input type="text" class="form-control validNumber" id="monto-pagar" name="monto-pagar" placeholder="Dígita el monto a pagar" onkeypress="return controlTag(event);">
                        </div>
                        <div class="col-md-12">
                            <label for="conceptos" class="form-label fw-bold">Concepto del pago <span class="text-danger">*</span></label>
                            <select class="form-control selectpicker" id="conceptos" name="conceptos" data-size="4" data-live-search="true">
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnActionForm" class="btn colorBlue-boton fw-bold" type="submit" form="form<?= ucfirst(uri_string()) ?>edit">
                    <i class="fa fa-fw fa-check-circle">&nbsp;</i><span id="btnText">Guardar</span>
                </button>&nbsp;&nbsp;&nbsp;
                <button class="btn colorDark-boton fw-bold" type="button" data-bs-dismiss="modal">
                    <i class="fa fa-fw fa-times-circle"> </i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para mostrar el historial de transacciones hechas sobre un documento -->
<div class="modal fade" id="<?= ucfirst(uri_string()) ?>show" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content modal-style rounded-3 border-0" style="overflow: visible;">
            <div class="modal-header color-primario">
                <h5 id="titleModalShow" class="modal-title fw-bold">Modal title</h5>
                <button type="button" class="btn-close details-color" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="overflow: visible;">
                <form id="form<?= ucfirst(uri_string()) ?>show" name="form<?= ucfirst(uri_string()) ?>show" class="form-horizontal">
                    <input type="hidden" id="idShow" name="idShow" value="">
                    <div class="row g-3">
                        <div id="show-history" class="col-md-12">
                            <ul id="listHistory" class="list-group list-group-flush">
                                
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn colorDark-boton fw-bold" type="button" data-bs-dismiss="modal">
                    <i class="fa fa-fw fa-times-circle"> </i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>