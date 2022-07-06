<?php
    namespace App\Controllers;
    use App\Models\DocumentosModel;
    use App\Models\ProveedoresModel;

    class Documento extends BaseController{

        protected $titlePage;
        protected $controlador;

        public function __construct(){
            
            $this->titlePage = 'Documentos';
            $this->titulo  = 'Documentos';
            $this->controlador  = 'Documento';
            $this->javaScript = 'functions_'.$this->controlador.'.js';
            $this->documentos = new DocumentosModel();
            $this->proveedores = new ProveedoresModel();
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
            echo view('documentos/documentos');
            echo view('templates/footer');
        }

        public function getRecordSet() {

            $arrData = $this->documentos->select('d.id,
                                                  d.monto,
                                                  p.nombre,
                                                  d.factura_id,
                                                  d.fecha_registro,
                                                  d.estado
                                                ')
                                        ->from('documentos d')
                                        ->join('proveedores p', 'd.proveedor_id = p.id')
                                        ->where("d.estado != 0")
                                        ->groupBy('d.id')
                                        ->orderBy("d.id","desc")
                                        ->findAll();
            
            for ($i = 0; $i < count($arrData); $i++) {
                
                // Variables para los botones
                $btnEdit = '';
                $btnDelete = '';

                //Mediante este if le indicamos que si el array en el que estamos, en su 'status' es igual a 1, entonces,
                // Que cambie ese valor por el que le indicamos del badget, de lo contrario, que use el otro
                if ($arrData[$i]['estado'] == '1') {
                    
                    $arrData[$i]['estado'] = '<span class="badge colorYellow">Pendiente</span>';
                } else {
                    $arrData[$i]['estado'] = '<span class="badge colorGrey">Pagado</span>';
                }
                        
                $btnEdit = '<button type="button" class="btn btn-sm colorGray-boton border-0" title="Editar" onClick="fntEdit('. $arrData[$i]['id'] .')" ><i class="fas fa-pencil-alt" data-toggle="tooltip"></i></button>';

                $btnDelete = '<button type="button" class="btn btn-sm colorRed-boton" title="Eliminar" onClick="fntDelete('. $arrData[$i]['id'] .')" ><i class="fas fa-trash-alt" data-toggle="tooltip"></i></button>';

                $arrData[$i]['options'] = '<div clas="text-center">' . $btnEdit . ' ' . $btnDelete . '</div>';
            };

            header('Content-Type: application/json');
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            die();
        }

        public function store(){

            if ($this->request->getMethod() == "post") {
                
                $id = intval(strClean($this->request->getPost('id')));
                $intMonto = intval(strClean($this->request->getPost('monto')));
                $intFactura = intval(strClean($this->request->getPost('factura')));
                $intProveedor = intval(strClean($this->request->getPost('proveedor')));
                $requestData = 0;

                if (empty($intMonto) || empty($intFactura) || empty($intProveedor)) {
                    
                    $arrResponse = array("status" => false, "msg" => 'Datos incorrectos', 'validations' => '');
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                    die();
                }else{
                    if ($id == 0) {
                        
                        $validarProveedor = $this->proveedores->where('id', $intProveedor)->whereNotIn('estado', [0,2])->first();
                        
                        if ($validarProveedor) {
                            
                            $option = 1;
                            $requestData = $this->documentos->save(['monto' => $intMonto,
                                                                    'factura_id' => $intFactura,
                                                                    'proveedor_id' => $intProveedor]);
                            
                            $montoTotal = $validarProveedor['balance'] + $intMonto;
                            $updateMonto = $this->proveedores->save(['id' => $intProveedor, 'balance' => $montoTotal]);
                        }else{
                            $arrResponse = array("status" => false, "msg" => 'El proveedor no existe', 'validations' => '');
                            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                            die();
                        }

                    }else{
                        $validarProveedor = $this->proveedores->where('id', $intProveedor)->whereNotIn('estado', [0,2])->first();
                        if ($validarProveedor) {
                            
                            $option = 2;

                            // $requestData = $this->documento->save(['id' => $id,'descripcion' => $strDescripcion, 'estado' => $intEstado]);
                        }
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
    
                $arrData = $this->documentos->find($id);
                $obtenerDeuda = $this->proveedores->where('id',"{$arrData['proveedor_id']}")->first();
                $newArrData = array_merge($arrData, ['deuda' => "{$obtenerDeuda['balance']}"]);
                if (empty($arrData)) {
                    
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
                }else{
                    $arrResponse = array('status' => true, 'data' => $newArrData);
                }
                
                header('Content-Type: application/json');
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }

    }
?>