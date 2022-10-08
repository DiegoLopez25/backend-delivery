<?php

namespace App\Models;

use CodeIgniter\Model;

class RolModel extends Model{
    protected $table            = "rol";
    protected $primaryKey       = "id";
    
    protected $returnType       = "array";
    protected $allowedFields    = ["nombre"];

    protected $useTimestamps    =false;

    protected $validationRules   =[];
    protected $validationMessages = [];
    protected $skipValidation = true;
}