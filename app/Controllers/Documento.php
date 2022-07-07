<?php
    namespace App\Controllers;

    use App\Models\ConceptoDocumentoModel;
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
            $this->conceptoDocumento = new ConceptoDocumentoModel();
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
                $btnView = '';
                $btnEdit = '';
                $btnDelete = '';

                $btnView = '<button type="button" class="btn btn-sm colorBlue-boton border-0" title="Ver" onClick="fntView('. $arrData[$i]['id'] .')" ><i class="fa-solid fa-eye" data-toggle="tooltip"></i></button>';

                //Mediante este if le indicamos que si el array en el que estamos, en su 'status' es igual a 1, entonces,
                // Que cambie ese valor por el que le indicamos del badget, de lo contrario, que use el otro
                if ($arrData[$i]['estado'] == '1') {
                    
                    $arrData[$i]['estado'] = '<span class="badge colorYellow">Pendiente</span>';
                    $btnEdit = '<button type="button" class="btn btn-sm colorGray-boton border-0" title="Editar" onClick="fntEdit('. $arrData[$i]['id'] .')" ><i class="fas fa-pencil-alt" data-toggle="tooltip"></i></button>';
                } else {
                    $arrData[$i]['estado'] = '<span class="badge colorGray">Pagado</span>';
                }

                $arrData[$i]['options'] = '<div clas="text-center">'. $btnView .' ' . $btnEdit . ' ' . $btnDelete . '</div>';
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

        public function editbalance() {

            if ($this->request->getMethod() == "post") {

                $id = intval(strClean($this->request->getPost('idEdit')));
                $intMonto = intval(strClean($this->request->getPost('monto-pagar')));
                $intConcepto = intval(strClean($this->request->getPost('conceptos')));

                if (empty($intMonto) || empty($id) || empty($intConcepto)) {
                    
                    $arrResponse = array("status" => false, "msg" => 'Datos incorrectos', 'validations' => '');
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                    die();
                }else{
                    if ($intMonto <= 0) {

                        $arrResponse = array("status" => false, "msg" => 'El monto debe ser mayor a cero', 'validations' => '');
                        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                        die();
                    }

                    if (empty($id)) {

                        $arrResponse = array("status" => false, "msg" => 'Error al momento de identificar el documento', 'validations' => '');
                        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                        die();
                    }

                    $requestMonto = $this->documentos->where('id', $id)->first();
                    $requestProveedores = $this->proveedores->where('id', $requestMonto['proveedor_id'])->first();

                    $montoActualizarProveedor = intval($requestProveedores['balance'] - $intMonto);
                    $montoActualizado = intval($requestMonto['monto']) - $intMonto;

                    if ($montoActualizado < 0) {
                        $arrResponse = array("status" => false, "msg" => 'Error, el monto supera al balance endeudado', 'validations' => '');
                        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                        die();

                    }else{
                        $requestData = $this->documentos->save(['id' => $id, 'monto' => $montoActualizado]);
                        $actualizarBalanceProveedor = $this->proveedores->save(['id' => $requestProveedores['id'], 'balance' => $montoActualizarProveedor]);
                        $insertarRecord = $this->conceptoDocumento->save(['concepto_id' => $intConcepto, 'proveedor_id' => $requestProveedores['id'], 
                                                                          'documento_id' => $id, 'monto' => $intMonto]);
                        
                        if ($montoActualizado == 0) {
                            
                            $actualizarEstado = $this->documentos->save(['id' => $id, 'estado' => 2]);
                        }

                        if ($requestData > 0) {
       
                            $arrResponse = array("status" => true, "msg" => 'Datos guardados correctamente');
                        }else{
                            $arrResponse = array("status" => false, "msg" => 'Error al momento de pagar un documento');
                        }
                    }
                    
                }
            }else{
                $arrResponse = array("status" => false, "msg" => 'Error', 'validations' => $this->validation->getErrors() ? $this->validation->getErrors() : ""); 
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function conceptosDocumentos() {


            $id = intval(strClean($this->request->getVar('idshow')));
            if ($id > 0) {
    
                $arrData = $this->conceptoDocumento->select('c.descripcion,
                                                             p.nombre,
                                                             cd.documento_id,
                                                             cd.monto')
                                                   ->from('concepto_documento cd')
                                                   ->join('proveedores p', 'cd.proveedor_id = p.id')
                                                   ->join('conceptos c', 'cd.concepto_id = c.id')
                                                   ->groupBy('cd.id')
                                                   ->where('cd.documento_id', $id)
                                                   ->findAll();
            }
            // header('Content-Type: application/json');
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            die();
        }
    }
?>