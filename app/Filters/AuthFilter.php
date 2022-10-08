<?php

namespace App\Filters;

use App\Models\RolModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;

class AuthFilter implements FilterInterface{
    use ResponseTrait;
    public function before(RequestInterface $request, $arguments = null){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: X-API-KEY, Origin,X-Requested-With, Content-Type, Accept, Access-Control-Requested-Method, Authorization");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PATCH, PUT, DELETE");

        try {
            $key = Services::getSecretKey();
            $authHeader = $request->getServer('HTTP_AUTHORIZATION');
            if($authHeader == null){
                return Services::response()->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED,"No se ha enviado el JWT requerido");
            }
            $arr = explode(" ",$authHeader);
            $jwt = $arr[1];

            $jwt = JWT::decode($jwt,new Key($key,"HS256"));

            $rolModel = new RolModel();
            $rol = $rolModel->find($jwt->data->id_rol);
            
            if($rol == null){
                return Services::response()->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED,"El rol del jwt es invalido");
            }

            return true;
        }catch(ExpiredException $ee){
            return Services::response()->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED,"Su token jwt ha expirado");
        }catch (\Exception $e) {
            return Services::response()->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR,"Ocurrio un error en el servidor al validar el token");
        }
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null){
        
    }
}