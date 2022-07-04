<div class="container-fluid">
	<div class="row">
		<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
			<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
				<h1 class="h2 fw-bold">Proveedores</h1>
			</div>
			<div class="card">

				<div class="card-header color-primario">
					<div class="d-flex flex-row justify-content-around align-items-center">
						<div class="flex-grow-1">
							<input type="text" class="form-control text-gray" placeholder="Buscar..." id="txtBuscar" name="txtBuscar">
						</div>
						<div class="form-inline me-2">
							<select class="form-control custom-select mx-1 text-gray" id="selectEntries">
								<option value="10" class="text-gray">10</option>
								<option value="25" class="text-gray">25</option>
								<option value="50" class="text-gray">50</option>
								<option value="100" class="text-gray">100</option>
							</select>
						</div>
						<button type="button" class="btn color-secundario" onclick="openModal()">
							<i class="fas fa-plus"></i> <span class="hidden-letters"> Agregar</span>
						</button>
					</div>
				</div>
				<div class="table-responsive">
					<table style="width: 100%;" class="display nowrap no-footer table table-sm table-hover" cellspacing="0" id="tabla_<?= $controlador ?>">
						<thead>
							<tr class="color-primario text-bold">
								<th style="width: 10%;">ID</th>
								<th style="width: 25%;">Nombre</th>
								<th style="width: 30%;">Descripci&oacute;n</th>
								<th style="width: 14%;">Estado</th>
								<th style="width: 14%;">Estado</th>
								<th style="width: 14%;">Estado</th>
								<th style="width: 14%;">Estado</th>
								<th style="width: 14%;">Estado</th>
								<th style="width: 11%;">Opciones</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
				<!-- <div class="m-3 border-top text-sm">
                    <div class="float-left mt-2">
                        <p class="text-muted" id="numbers_numbers"></p>
                    </div>
                    <div class="float-right mt-2">
                        <p class="text-muted" id="pagination_pagination"></p>
                    </div>
                </div> -->
			</div>
		</main>
	</div>
</div>