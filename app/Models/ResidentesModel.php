<?php 
    namespace App\Models;
    use CodeIgniter\Model;

    class ResidentesModel extends Model{

        protected $table      = 'residente';
        protected $primaryKey = 'id_residente';
        protected $useAutoIncrement = true;

        protected $returnType     = 'array';
        protected $useSoftDeletes = false;

        protected $allowedFields = ['nombres_residente',  
                                    'apellidos_residente',
                                    'telefono_residente',
                                    'correo_residente',
                                    'edad_residente',
                                    'direccion_residente',
                                    'comida_entregada_residente',
                                    'observacion_residente'];

        protected $useTimestamps = false;
        protected $createdField  = '';
        protected $updatedField  = '';
        protected $deletedField  = '';

        /**
         * It returns the data of the resident.
         * 
         * @param id The id of the resident to be retrieved. If it is not specified, all the residents will be
         * retrieved.
         * 
         * @return The query result.
         */
        public function obtener($id='TODOS') {
            
            $this->select('residente.*');
            if ($id == 'TODOS') {
                $response = $this->findAll(); 
            } else {
                // Si se consulta un registro en concreto
                $this->where('residente.id_residente', $id);
                $response = $this->first();
            }                
            return $response;
        }
   
        /**
         * This function validates if a resident exists in the database
         * 
         * @param id The id of the resident you want to check against.
         * @param email The email of the residente.
         * 
         * @return An array of objects.
         */
        public function validarExistencia($id=0, $email='correo'){

            if ($id == 0) {
                
                $this->select('residente.*')->where('correo_residente', $email);
                $response = $this->findAll(); 
            }else{
                $this->select('residente.*')->where('correo_residente', $email)->where('id_residente !=', $id);
                $response = $this->findAll(); 
            }
            return $response;
        }
    }
?>