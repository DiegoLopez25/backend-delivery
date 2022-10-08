<?php

namespace App\Models;

use CodeIgniter\Model;

class PedidoModel extends Model{
    protected $table            = "Pedido";
    protected $primaryKey       = "id";
    
    protected $returnType       = "array";
    protected $allowedFields    = ["id_usuario","fecha_hora","id_repartidor","id_direccion","id_tienda","id_estado_pedido"];

    protected $useTimestamps    =true;

    protected $createdFields    = "created_at";
    protected $updatedFiedls    ="updated_at";

    protected $validationRules   =[];
    protected $validationMessages = [];
    protected $skipValidation = true;
}