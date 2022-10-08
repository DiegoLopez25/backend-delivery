<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductoModel extends Model{
    protected $table            = "producto";
    protected $primaryKey       = "id";
    
    protected $returnType       = "array";
    protected $allowedFields    = ["titulo","descripcion","precio","id_estado","id_tienda","id_catergoria"];

    protected $useTimestamps    =true;

    protected $createdFields    = "created_at";
    protected $updatedFiedls    ="updated_at";

    protected $validationRules   =[];
    protected $validationMessages = [];
    protected $skipValidation = true;
}