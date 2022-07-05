<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="theme-color" content="#212529f8">
	<meta name="author" content="Manuel Echavarria">
	<title><?= $titulo ?> - CxP</title>
	<link rel="shortcut icon" type="image/x-icon" href="<?= base_url(); ?>/dist/img/favicon.ico">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?= base_url(); ?>/plugins/fontawesome-free/css/all.css">
	<link rel="stylesheet" href="<?= base_url(); ?>/plugins/fontawesome-free/css/solid.css">
	<!-- Boostrap -->
	<link rel="stylesheet" href="<?= base_url(); ?>/plugins/bootstrap-5.2/css/bootstrap.min.css">
	<!-- DataTables -->
	<link rel="stylesheet" href="<?= base_url(); ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="<?= base_url(); ?>/dist/css/styleDataTableBoostrapResponsive.css">
	<!-- Select picker -->
	<link rel="stylesheet" href="<?= base_url(); ?>/plugins/bootstrap-select-1.14.0-beta2/dist/css/bootstrap-select.min.css">
	<!-- My custom css -->
	<link rel="stylesheet" href="<?= base_url() ?>/dist/css/style.css">
	<!-- Dashboard css -->
	<link rel="stylesheet" href="<?= base_url() ?>/dist/css/dashboard.css">
</head>

<body>
	<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
		<a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fw-bold" href="<?= base_url() ?>/">CxP</a>
		<button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
	</header>