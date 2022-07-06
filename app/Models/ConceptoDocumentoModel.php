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
                                    'documento_id'];

        protected $useTimestamps = false;
        protected $createdField  = '';
        protected $updatedField  = '';
        protected $deletedField  = '';
        
    }
?>