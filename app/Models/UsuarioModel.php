<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model{
    protected $table            = "usuario";
    protected $primaryKey       = "id";
    
    protected $returnType       = "array";
    protected $allowedFields    = ["nombre","apellido","telefono","email","usuario","password","id_estado","id_rol"];

    protected $useTimestamps    =true;

    protected $createdFields    = "created_at";
    protected $updatedFiedls    ="updated_at";
    

    protected $validationRules   =[
        'nombre' => 'required|alpha_space|min_length[3]|max_length[75]',
        'apellido' => 'required|alpha_space|min_length[3]|max_length[75]',
        'telefono' => 'required|min_length[3]|max_length[9]',
        'email' => 'required|valid_email|max_length[100]',
    ];
    protected $validationMessages = [
        "email" => [
            "valid_email" => "Porfavor ingrese un correo valido"
        ] 
    ];
    protected $skipValidation = false;

    public function listaUsuarios (){
        $builder = $this->db->table($this->table);
        $builder->select('U.id, 
                          U.nombre, 
                          U.apellido, 
                          U.telefono, 
                          U.email, 
                          U.usuario, 
                          U.`password`, 
                          E.nombre AS estado,
                          R.nombre AS rol,');
        $builder->from("usuario AS U");
        $builder->join('estado AS E','U.id_estado = E.id');
        $builder->join('rol AS R','U.id_rol = R.id');

        $query = $builder->get();
        return $query->getResult();
    } 
}