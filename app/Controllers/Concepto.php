<?php
    namespace App\Controllers;

    class Concepto extends BaseController{

        protected $titlePage;
        protected $controlador;

        public function __construct(){
            
            $this->titlePage = 'Conceptos';
            $this->titulo  = 'Conceptos';
            $this->controlador  = 'Concepto';
            $this->javaScript = 'functions_'.$this->controlador.'.js';
        }

        public function index(){

            $data = ['titulo' => $this->titulo,
                     'titlePage' => $this->titlePage, 
                     'controlador'=> $this->controlador,
                     'page_functions_js' => $this->javaScript
            ];

            echo view('templates/header',$data);
            echo view('templates/sidebar');
            echo view('conceptos/conceptos');
            echo view('templates/footer');
        }
    }
?>