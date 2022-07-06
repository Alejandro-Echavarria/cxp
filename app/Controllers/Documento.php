<?php
    namespace App\Controllers;

    class Documento extends BaseController{

        protected $titlePage;
        protected $controlador;

        public function __construct(){
            
            $this->titlePage = 'Documentos';
            $this->titulo  = 'Documentos';
            $this->controlador  = 'Documento';
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
            echo view('documentos/documentos');
            echo view('templates/footer');
        }
    }
?>