<?php

namespace App\Models;

use CodeIgniter\Model;

class RepartidorModel extends Model{
    protected $table            = "repartidor";
    protected $primaryKey       = "id";
    
    protected $returnType       = "array";
    protected $allowedFields    = ["nombre","apellido","telefono","email","numTarjeta","usuario","password","id_estado"];

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

    public function listaRepartidores (){
        $builder = $this->db->table($this->table);
        $builder->select('R.id, 
                          R.nombre, 
                          R.apellido, 
                          R.telefono, 
                          R.email,
                          R.numTarjeta, 
                          R.usuario, 
                          R.`password`, 
                          E.nombre AS estado');
        $builder->from("repartidor AS R");
        $builder->join('estado AS E','R.id_estado = E.id');


        $query = $builder->get();
        return $query->getResult();
    } 
}