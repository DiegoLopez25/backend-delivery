<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoriaProductoModel extends Model{
    protected $table            = "categoria_producto";
    protected $primaryKey       = "id";
    
    protected $returnType       = "array";
    protected $allowedFields    = ["nombre"];

    protected $useTimestamps    =true;

    protected $createdFields    = "created_at";
    protected $updatedFiedls    ="updated_at";

    protected $validationRules   =[];
    protected $validationMessages = [];
    protected $skipValidation = true;
}