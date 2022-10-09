<?php
use App\Models\RolModel;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;

function validarAcceso($roles,$authHeader){
    if(!is_array($roles)){
        return false;
    }
    $key = Services::getSecretKey();
    $arr = explode(" ",$authHeader);
    $jwt = $arr[1];
    $jwt = JWT::decode($jwt,new Key($key,"HS256"));
    
    $rolModel = new RolModel();
    $rol = $rolModel->find($jwt->data->role_id);
    
    if($rol ==null){
        return false;
    }

    foreach ($roles as $key => $value) {
        if($value != $rol["nombre"])
            return false;
    }
    return true;
}

function regenerarJWT($jwt){
    
    try {
        $key = Services::getSecretKey();
        date_default_timezone_set("America/El_Salvador");
        $time = time();
        $arr = explode(" ",$jwt);
        $jwt = $arr[1];
        $jwtUsuario = JWT::decode($jwt,new Key($key,"HS256"));

        $payload =[
            'aud'   => base_url(),
            'iat'   => $time,//tiempo del token
            'exp'   => $time+10,//tiempo cuando expira el token en segundos
            'data'  => [
                'nombre' => $jwtUsuario->data->nombre,
                'apellido'=> $jwtUsuario->data->apellido,
                'id_rol'=> $jwtUsuario->data->id_rol,
                'usuario'=> $jwtUsuario->data->usuario,
            ]
        ];
        $newJWT = JWT::encode($payload,$key,'HS256');
        return $newJWT;
        
    } catch (ExpiredException $ee) {
        return "su jwt ha expirado inicie sesion nuevamente";
    }
}