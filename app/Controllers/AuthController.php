<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\API\ResponseTrait;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class AuthController extends BaseController
{
    use ResponseTrait;

    public function __construct()
    {
        helper('secure_password');
        helper('cookie');
    }

    public function login()
    {
        try {
            //para obtener en datos en formato JSON
            /*$username = $this->request->getJSON()->username;
            $password = $this->request->getJSON()->password;*/
            //Para obtener datos en formato data-form (formulario)
            $username = $this->request->getPost("username");
            $password = $this->request->getPost("password");

            $usuarioModel = new UsuarioModel();
            
            $validarUsuario = $usuarioModel->where('usuario',$username)->first();

            if($validarUsuario == null){
                return $this->respond(["Error"=>"Error usuario","msg"=>"Usuario no encontrado"],200);
            }
            if(verificarPassword($password, $validarUsuario['password'])){
                $key = Services::getSecretKey();
                $jwt = $this->generarJWT($validarUsuario);
                $jwt2 = JWT::decode($jwt,new Key($key,"HS256"));
                return $this->respond(['nombre'=>$jwt2->data->nombre,
                                       'apellido'=>$jwt2->data->apellido,
                                       'rol'=>$jwt2->data->id_rol,
                                       'usuario'=>$jwt2->data->usuario,
                                       'Token' => $jwt]
                                       ,201);
            }else{
                return $this->failValidationError('Contraseña Invalida');   
            }            
        } catch (\Exception $e) {
            return $this->failServerError("Ha ocurrido un error en el servidor");
        }
    }

    protected function generarJWT($usuario){
        $key = Services::getSecretKey();
        date_default_timezone_set("America/El_Salvador");
        $time = time();
        $payload =[
            'aud'   => base_url(),
            'iat'   => $time,//tiempo del token
            'exp'   => $time+600,//tiempo cuando expira el token en segundos
            'data'  => [
                'nombre' => $usuario['nombre'],
                'apellido'=> $usuario['apellido'],
                'id_rol'=> $usuario['id_rol'],
                'usuario'=> $usuario['usuario'],
            ]
        ];
        $jwt = JWT::encode($payload,$key,'HS256');
        return $jwt;
    }

}
