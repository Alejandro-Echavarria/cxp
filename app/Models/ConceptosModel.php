<?php 
    namespace App\Models;
    use CodeIgniter\Model;

    class ConceptosModel extends Model {

        protected $table      = 'conceptos';
        protected $primaryKey = 'id';
        protected $useAutoIncrement = true;

        protected $returnType     = 'array';
        protected $useSoftDeletes = false;

        protected $allowedFields = ['descripcion',  
                                    'estado'];

        protected $useTimestamps = false;
        protected $createdField  = '';
        protected $updatedField  = '';
        protected $deletedField  = '';
        
    }
?>