<?php 
    namespace App\Models;
    use CodeIgniter\Model;

    class ProveedoresModel extends Model{

        protected $table      = 'proveedores';
        protected $primaryKey = 'id';
        protected $useAutoIncrement = true;

        protected $returnType     = 'array';
        protected $useSoftDeletes = false;

        protected $allowedFields = ['cedula',  
                                    'nombre',
                                    'tipo',
                                    'balance',
                                    'estado',
                                    'fecha_registro'];

        protected $useTimestamps = false;
        protected $createdField  = '';
        protected $updatedField  = '';
        protected $deletedField  = '';
        
    }
?>