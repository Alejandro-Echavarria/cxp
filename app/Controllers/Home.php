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
            $this->validation = \Config\Services::validation();

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

            $arrData = $this->proveedores->orderBy("id","desc")->where("estado != 0")->findAll();
            
            for ($i = 0; $i < count($arrData); $i++) {
                
                $arrData[$i]["fecha_registro"] = date("d-m-Y - h:i:s a", strtotime($arrData[$i]["fecha_registro"]));
                // Variables para los botones
                $btnView = '';
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

        public function getSelectProveedores() {

            $htmlOptions = "";
            $arrData = $this->proveedores->orderBy("id","desc")->where("estado != 0")->findAll();
            if (count($arrData) > 0) {
                
                for ($i=0; $i < count($arrData); $i++) { 
                    if ($arrData[$i]['estado'] == 1) {

                        $htmlOptions .= '<option class="wrap-list border-bottom" value="'.$arrData[$i]['id'].'">'.$arrData[$i]['nombre'].'</option>';
                    }
                }
            }
            echo $htmlOptions;
            die();
        }

        public function store(){

            if ($this->request->getMethod() == "post" && $this->validate('cedula')) {
                
                $id = intval(strClean($this->request->getPost('id')));
                $intCedula = intval(strClean($this->request->getPost('cedula')));
                $strNombre = strClean($this->request->getPost('nombre'));
                $strTipo = strClean($this->request->getPost('tipo'));
                $intEstado = intval($this->request->getPost('estado'));
                $requestData = 0;

                if (empty($intCedula) || empty($strNombre) || empty($strTipo) ||
                    empty($intEstado)) {
                    
                    $arrResponse = array("status" => false, "msg" => 'Datos incorrectos', 'validations' => "");
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                    die();
                }else{

                    if ($id == 0) {
                        
                        $option = 1;
                        $requestData = $this->proveedores->save(['cedula' => $intCedula,
                                                           'nombre' => $strNombre,
                                                           'tipo' => $strTipo,
                                                           'estado' => $intEstado
                                                         ]);
                    }else{
                        $option = 2;
                        $requestData = $this->proveedores->save(['id' => $id,
                                                                 'cedula' => $intCedula,
                                                                 'nombre' => $strNombre,
                                                                 'tipo' => $strTipo,
                                                                 'estado' => $intEstado
                                                            ]);
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
    
                $arrData = $this->proveedores->find($id);
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

                        $requestDelete = $this->proveedores->find($id,'id');
                        
                        if ($requestDelete['balance'] == 0) {

                            // modificamso el status a 0, el sistema con esto entiende que está eliminado
                            $requestData = $this->proveedores->update($id, ['estado'=>intval(0)]);
                            $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la categoría para los artículos');
                        }else{
                            $arrResponse = array('status' => false, 'msg' => 'No se puede borrar un proveedor con monto mayor a cero');
                        }
                        // $arrResponse = array('status' => false, 'msg' => 'Error al eliminar un proveedor');
                    }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
    }
?>