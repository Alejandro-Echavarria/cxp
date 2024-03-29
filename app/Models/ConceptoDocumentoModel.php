<?php 
    namespace App\Models;
    use CodeIgniter\Model;

    class ConceptoDocumentoModel extends Model {

        protected $table      = 'concepto_documento';
        protected $primaryKey = 'id';
        protected $useAutoIncrement = true;

        protected $returnType     = 'array';
        protected $useSoftDeletes = false;

        protected $allowedFields = ['concepto_id',
                                    'proveedor_id', 
                                    'documento_id',
                                    'monto',
                                    'asiento_id',
                                    'estado'];

        protected $useTimestamps = false;
        protected $createdField  = '';
        protected $updatedField  = '';
        protected $deletedField  = '';
        
    }
?>