<?php
    namespace App\Controllers;
    use App\Models\ProveedoresModel;

    class Home extends BaseController{

        protected $titlePage;
        protected $controlador;

        public function __construct(){
            
            $this->titlePage = 'Proveedores';
            $this->titulo  = 'Proveedores';
            $this->controlador  = 'Home';
            $this->javaScript = 'functions_'.$this->controlador.'.js';
            $this->proveedores = new ProveedoresModel();
        }
        /**
         * This function is the main function that is called when the user goes to the home page
         */
        public function index() {

            $data = ['titulo' => $this->titulo,
                     'titlePage' => $this->titlePage, 
                     'controlador'=> $this->controlador,
                     'page_functions_js' => $this->javaScript
            ];

            echo view('templates/header',$data);
            echo view('templates/sidebar');
            echo view('home');
            echo view('templates/footer');
        }

        public function getRecordSet() {

            $arrData = $this->proveedores->findAll();

            for ($i = 0; $i < count($arrData); $i++) {
                
                // Variables para los botones
                $btnView = '';
                $btnEdit = '';


                //Mediante este if le indicamos que si el array en el que estamos, en su 'status' es igual a 1, entonces,
                // Que cambie ese valor por el que le indicamos del badget, de lo contrario, que use el otro
                if ($arrData[$i]['estado'] == '1') {
                    
                    $arrData[$i]['status_transaccion'] = '<span class="badge colorGreen">Activo</span>';
                } else {
                    $arrData[$i]['status_transaccion'] = '<span class="badge colorRed">Inactivo</span>';
                }

                $arrData[$i]['options'] = '<div clas="text-center">'. $btnView . ' ' . $btnEdit . '</div>';
            };

            header('Content-Type: application/json');
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            die();
        }
    }
?>