<?php
    $decorador = '<div class="bg-primary personal-border position-absolute position-absolute top-50 start-0 translate-middle detail-color" style="width: 5px; height: 20px;"><span>&nbsp;</span></div>';
?>

<div class="container-fluid">
    <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column mx-2">
                    <li class="nav-item">
                        <div class="position-relative">
                            <?= strtolower(uri_string()) == "/" ? $decorador : ""  ?>
                            <a class="nav-link text-break <?= strtolower(uri_string()) == "/" ? "active" : "" ?> fw-bold" aria-current="page" href="<?= base_url() ?>">
                                <i class="fa-solid fa-address-book"></i>
                                Proveedores
                            </a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="position-relative">
                            <?= strtolower(uri_string()) == "documento" ? $decorador : ""  ?>
                            <a class="nav-link text-break <?= strtolower(uri_string()) == "documento" ? "active" : "" ?> fw-bold" href="<?= base_url() ?>/documento">
                                <i class="fa-solid fa-file-lines"></i>
                                Documentos
                            </a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="position-relative">
                            <?= strtolower(uri_string()) == "concepto" ? $decorador : ""  ?>

                            <a class="nav-link text-break <?= strtolower(uri_string()) == "concepto" ? "active" : "" ?> fw-bold" href="<?= base_url() ?>/concepto">
                                <i class="fa-solid fa-sign-hanging"></i>
                                Conceptos
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>