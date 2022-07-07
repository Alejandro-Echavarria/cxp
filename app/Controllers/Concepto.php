<?php
    namespace App\Controllers;
    use App\Models\ConceptosModel;

    class Concepto extends BaseController{

        protected $titlePage;
        protected $controlador;

        public function __construct(){
            
            $this->titlePage = 'Conceptos';
            $this->titulo  = 'Conceptos';
            $this->controlador  = 'Concepto';
            $this->javaScript = 'functions_'.$this->controlador.'.js';
            $this->conceptos = new ConceptosModel();
            $this->validation = \Config\Services::validation();
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

        public function getRecordSet() {

            $arrData = $this->conceptos->orderBy("id","desc")->where("estado != 0")->findAll();
            
            for ($i = 0; $i < count($arrData); $i++) {
                
                // Variables para los botones
                $btnEdit = '';
                $btnDelete = '';

                //Mediante este if le indicamos que si el array en el que estamos, en su 'status' es igual a 1, entonces,
                // Que cambie ese valor por el que le indicamos del badget, de lo contrario, que use el otro
                if ($arrData[$i]['estado'] == '1') {
                    
                    $arrData[$i]['estado'] = '<span class="badge colorGreen">Activo</span>';
                } else {
                    $arrData[$i]['estado'] = '<span class="badge colorRed">Inactivo</span>';
                }
                        
                $btnEdit = '<button type="button" class="btn btn-sm colorGray-boton border-0" title="Editar" onClick="fntEdit('. $arrData[$i]['id'] .')" ><i class="fas fa-pencil-alt" data-toggle="tooltip"></i></button>';

                $btnDelete = '<button type="button" class="btn btn-sm colorRed-boton" title="Eliminar" onClick="fntDelete('. $arrData[$i]['id'] .')" ><i class="fas fa-trash-alt" data-toggle="tooltip"></i></button>';

                $arrData[$i]['options'] = '<div clas="text-center">' . $btnEdit . ' ' . $btnDelete . '</div>';
            };

            header('Content-Type: application/json');
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            die();
        }

        public function getSelectConceptos() {

            $htmlOptions = "";
            $arrData = $this->conceptos->orderBy("id","desc")->where("estado != 0")->findAll();
            if (count($arrData) > 0) {
                
                for ($i=0; $i < count($arrData); $i++) { 
                    if ($arrData[$i]['estado'] == 1) {

                        $htmlOptions .= '<option class="wrap-list border-bottom" value="'.$arrData[$i]['id'].'">'.$arrData[$i]['descripcion'].'</option>';
                    }
                }
            }
            echo $htmlOptions;
            die();
        }

        public function store(){

            if ($this->request->getMethod() == "post" && $this->validate('descripcion_coneptos')) {
                
                $id = intval(strClean($this->request->getPost('id')));
                $strDescripcion = strClean($this->request->getPost('descripcion'));
                $intEstado = intval($this->request->getPost('estado'));
                $requestData = 0;

                if (empty($strDescripcion) || empty($intEstado)) {
                    
                    $arrResponse = array("status" => false, "msg" => 'Datos incorrectos', 'validations' => '');
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                    die();
                }else{
                    if ($id == 0) {
                        
                        $option = 1;
                        $requestData = $this->conceptos->save(['descripcion' => $strDescripcion, 'estado' => $intEstado]);
                    }else{
                        $option = 2;
                        $requestData = $this->conceptos->save(['id' => $id,'descripcion' => $strDescripcion, 'estado' => $intEstado]);
                    }
                }

                if ($requestData > 0) {
     
                    if ($option == 1 ) {
                        
                        $arrResponse = array("status" => true, "msg" => 'Datos guardados correctamente');
                    }else{
                        $arrResponse = array("status" => true, "msg" => 'Datos actualizados correctamente');                        
                    }
                }
            }else{
                $arrResponse = array("status" => false, "msg" => 'Error', 'validations' => $this->validation->getErrors() ? $this->validation->getErrors() : ""); 
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function show() {
            
            $id = intval(strClean($this->request->getVar('id')));
            if ($id > 0) {
    
                $arrData = $this->conceptos->find($id);
                if (empty($arrData)) {
                    
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
                }else{
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
                
                header('Content-Type: application/json');
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }

        public function delete(){

            if ($this->request->getMethod() == "post") {

                $id = intval(strClean($this->request->getPost('id')));

                    if (empty($id)) {
                        
                        $arrResponse = array("status" => false, "msg" => 'Datos incorrectos');
                    }else{
                        
                        // modificamso el status a 0, el sistema con esto entiende que está eliminado
                        $requestData = $this->conceptos->update($id, ['estado'=>intval(0)]);
                        $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el concepto');
                        
                    }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
    }
?>