<?php

namespace App\Models;

use CodeIgniter\Model;

class TiendaModel extends Model{
    protected $table            = "tienda";
    protected $primaryKey       = "id";
    
    protected $returnType       = "array";
    protected $allowedFields    = ["nombre","nit","ncr","giro","Banco","numCuenta","usuario","password","id_estado","id_categoria","direccion","telefono","id_municipio"];

    protected $useTimestamps    =true;

    protected $createdFields    = "created_at";
    protected $updatedFiedls    ="updated_at";
    

    protected $validationRules   =[
        'nombre' => 'required|alpha_space|min_length[3]|max_length[75]',
    ];
    protected $validationMessages = [

    ];
    protected $skipValidation = false;

    public function listaTiendas (){
        $builder = $this->db->table($this->table);
        $builder->select("T.id, 
                          T.nombre, 
                          T.nit, 
                          T.nrc, 
                          T.giro, 
                          T.banco, 
                          T.numCuenta,
                          T.usuario,
                          T.`password`, 
                          CONCAT(D.nombre,', ',M.nombre,', ',T.direccion) AS 'direccion',
                          T.telefono,
                          C.nombre AS categoria,
                          E.nombre AS estado");
        $builder->from("tienda AS T");
        $builder->join('estado AS E','T.id_estado = E.id');
        $builder->join('categoria_tienda AS C','T.id_categoria = C.id');
        $builder->join('municipio AS M','T.id_municipio = M.id');
        $builder->join('departamento AS D','M.id_departamento = D.id');

        $query = $builder->get();
        return $query->getResult();
    } 
}

/*select T.id, 
                          T.nombre, 
                          T.nit, 
                          T.nrc, 
                          T.giro, 
                          T.banco, 
                          T.numCuenta,
                          T.usuario,  
                          T.`password`, 
                          T.direccion,
                          T.telefono,
                          E.nombre AS estado,
                          M.nombre AS municipio,
                         C.nombre AS categoria,
												 D.nombre AS departamento
from tienda AS T
 INNER JOIN       estado AS E on T.id_estado = E.id
 INNER JOIN    municipio AS M on T.id_municipio = M.id
  INNER JOIN    categoria_tienda AS C on T.id_categoria = C.id
	  INNER JOIN    departamento AS D on M.id_departamento = D.id */