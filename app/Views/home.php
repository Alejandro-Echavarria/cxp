<div class="container-fluid">
	<div class="row">
		<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
			<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
				<h1 class="h2 fw-bold">Proveedores</h1>
			</div>
			<div class="border-0">
				<div class="color-primario personal-border">
					<div class="p-3 rounded">
						<div class="d-flex flex-row justify-content-around align-items-center">
							<div class="flex-grow-1">
								<input type="text" class="form-control text-gray personal-border border-0" placeholder="Buscar..." id="txtBuscar" name="txtBuscar">
							</div>
							<div class="form-inline px-2">
								<select class="form-control personal-border custom-select selectpicker text-gray border-0" id="selectEntries">
									<option value="10" class="text-gray">10</option>
									<option value="25" class="text-gray">25</option>
									<option value="50" class="text-gray">50</option>
									<option value="100" class="text-gray">100</option>
								</select>
							</div>
							<button type="button" class="btn border-0 fw-bold color-secundario personal-border" onclick="openModal()">
								<i class="fas fa-plus"></i> <span class="hidden-letters"> Agregar</span>
							</button>
						</div>
					</div>
				</div>
				<div class="table-responsive color-fondo my-4">
					<table style="width: 100%;" class="display nowrap no-footer table table-hover table-borderless" cellspacing="0" id="tabla_<?= $controlador ?>">
						<thead>
							<tr class="text-bold">
								<th style="width: 10%;">#</th>
								<th style="width: 25%;">Nombre</th>
								<th style="width: 30%;">Descripci&oacute;n</th>
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
				<div class="pt-3 border-top text-sm color-fondo d-flex justify-content-between">
					<div class="mt-2">
						<p class="text-muted" id="numbers_numbers"></p>
					</div>
					<div class="mt-2">
						<p class="text-muted" id="pagination_pagination"></p>
					</div>
				</div>
			</div>
		</main>
	</div>
</div>