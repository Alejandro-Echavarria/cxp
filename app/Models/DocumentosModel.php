<?php 
    namespace App\Models;
    use CodeIgniter\Model;

    class DocumentosModel extends Model {

        protected $table      = 'documentos';
        protected $primaryKey = 'id';
        protected $useAutoIncrement = true;

        protected $returnType     = 'array';
        protected $useSoftDeletes = false;

        protected $allowedFields = ['monto',
                                    'proveedor_id',
                                    'factura_id',  
                                    'estado'];

        protected $useTimestamps = false;
        protected $createdField  = '';
        protected $updatedField  = '';
        protected $deletedField  = '';
        
    }
?>