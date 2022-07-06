<div class="container-fluid">
    <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column mx-2">
                    <li class="nav-item">
                        <a class="nav-link text-break <?= strtolower(uri_string()) == "/" ? "active" : "" ?> fw-bold" aria-current="page" href="<?= base_url() ?>">
                            <i class="fa-solid fa-address-book"></i>
                            Proveedores
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-break <?= strtolower(uri_string()) == "documento" ? "active" : "" ?> fw-bold" href="<?= base_url() ?>/documento">
                            <i class="fa-solid fa-file-lines"></i>
                            Documentos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-break <?= strtolower(uri_string()) == "concepto" ? "active" : "" ?> fw-bold" href="<?= base_url() ?>/concepto">
                            <i class="fa-solid fa-sign-hanging"></i>
                            Conceptos
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>