<?php

namespace App\Controllers;

use App\Models\RolModel;
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

            $rules = [
                'username' => ['rules' => 'required'],
                'password' => ['rules' => 'required']
            ];

            if (!$this->validate($rules)) {
                return $this->fail($this->validator->getErrors(), 422);
            }

            $username = $this->request->getVar("username");
            $password = $this->request->getVar("password");

            $userModel = new UsuarioModel();
            $rolModel = new RolModel();

            $user = $userModel->where('usuario', $username)->first();

            if ($user == null) {
                return $this->fail(['username' => 'Estas credenciales no coinciden en nuestros registros'], 422);
            }

            if (verificarPassword($password, $user['password'])) {

                //cargando el rol
                $rol = $rolModel->where('id',$user['id_rol'])->first();

                $userPayload = [
                    'nombre' => $user["nombre"],
                    'apellido' => $user["apellido"],
                    'role' => $rol["nombre"],
                    'role_id' => $user['id_rol']
                ];

                $jwt = $this->generarJWT($userPayload);

                $responseData = [
                    'token' => $jwt,
                    'user' => $userPayload
                ];

                return $this->respond($responseData, 201);
            } else {
                return $this->fail(['username' => 'Usuario o contraseña incorrecta'], 422);
            }
        } catch (\Exception $e) {
            return $this->failServerError("Ha ocurrido un error en el servidor");
        }
    }

    public function getUserData()
    {
        $key = Services::getSecretKey();
        $authHeader = $this->request->getHeader("Authorization");
        $authHeader = $authHeader->getValue();
        $token = explode(" ",$authHeader);

        try {
            $decoded = JWT::decode($token[1], new Key($key,"HS256"));

            if ($decoded) {
                $response = [
                    'user' => $decoded->data
                ];
                return $this->respond($response,200);
            }
        } catch (\Exception $ex) {
            return $this->fail('Unauthorized', 401);
        }

    }

    protected function generarJWT($userPayload)
    {
        $key = Services::getSecretKey();
        date_default_timezone_set("America/El_Salvador");
        $time = time();
        $payload = [
            'aud' => base_url(),
            'iat' => $time,//tiempo del token
            'exp' => $time + 18000,//tiempo cuando expira el token en segundos
            'data' => $userPayload
        ];
        $jwt = JWT::encode($payload, $key, 'HS256');
        return $jwt;
    }

}
