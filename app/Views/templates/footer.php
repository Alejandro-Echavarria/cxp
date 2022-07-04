    <footer>

    </footer>
    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <!-- <script src="<?php echo base_url(); ?>/plugins/jquery-ui/jquery-ui.min.js"></script> -->
    <!-- Bootstrap 5.2 -->
    <script src="<?= base_url(); ?>/plugins/bootstrap-5.2/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables  & Plugins -->
	<script src="<?= base_url(); ?>/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="<?= base_url(); ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="<?= base_url(); ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
	<script src="<?= base_url(); ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <!-- Sweetalert2 -->
    <script src="<?= base_url(); ?>/plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <!-- scripts select picker -->
    <script src="<?php echo base_url(); ?>/plugins/bootstrap-select-1.13.14/dist/js/bootstrap-select.min.js"></script>
    <!-- Script para validar los campos en los formularios -->
    <script type="text/javascript" src="<?= media(); ?>/js/functions_admin.js"></script>
    <!-- La manera de pasar mi ruta raiz a mis archivos de JS-->
    <script> 
        var base_url = "<?= base_url(); ?>";
        <?php if (!isset($controlador)) { ?> <?php } else { ?>
            var controlador = "<?= $controlador ?>";
        <?php } ?>
    </script> 
    <!-- This is a javascript file that will be included in the HTML file. -->
    <?php if (!isset($page_functions_js)) { ?><?php } else { ?>
    <script src="<?= base_url(); ?>/dist/js/<?php echo $page_functions_js ?>">
        <?php } ?>
    </script>
</body>

</html>