<?php

namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;
use App\Models\UsuarioModel;
use Exception;

class Usuario extends ResourceController
{
    public function __construct()
    {
        helper("secure_password");
        helper("access_rol");
        $this->model = $this->setModel(new UsuarioModel());
    }

    public function index()
    {
        try{
            if(!validarAcceso(array('Administrador'), $this->request->getServer('HTTP_AUTHORIZATION'))){
                return $this->failServerError("No tienes permisos para acceder a este recurso");
            }
            $usuario = $this->model->listaUsuarios();
            if($usuario == null){
                return $this->respondNoContent("No hay registros de usuarios");
            }
            return $this->respond($usuario);
            
        }catch(Exception $e){
            return $this->failServerError("Ha ocurrido un error en el servidor");
        }
    } 

    public function create()
    {
        try {
            if(!validarAcceso(array('Administrador'), $this->request->getServer('HTTP_AUTHORIZATION'))){
                return $this->failServerError("No tienes permisos para acceder a este recurso");
            }

            $usuario = $this->request->getJSON(); 
            $pass = hashPassword($usuario->password);
            $usuario->password = $pass;
            if($this->model->insert($usuario)):
                $usuario->id = $this->model->insertID();
                return $this->respondCreated($usuario);
            else:
                return $this->failValidationErrors($this->model->validation->listErrors());
            endif;
        } catch (Exception $e) {
            return $this->failServerError("Ha ocurrido un error en el servidor");
        }
    }

    public function edit($id = null){
        try {
            if(!validarAcceso(array('Administrador'), $this->request->getServer('HTTP_AUTHORIZATION'))){
                return $this->failServerError("No tienes permisos para acceder a este recurso");
            }
            if($id == null){
                return $this->failServerError("Ha ocurrido un error en el servidor");
            }
            
            $usuario = $this->model->find($id);
            if($usuario == null){
                return $this->failNotFound("No se ha enconrtrado el usuario con el id: ".$id);
            }
            return $this->respond ($usuario);
        }catch(Exception $e){
            return $this->failServerError("Ha ocurrido un error en el servidor");
        }
    }

    public function update($id = null){
        try {
            if(!validarAcceso(array('Administrador'), $this->request->getServer('HTTP_AUTHORIZATION'))){
                return $this->failServerError("No tienes permisos para acceder a este recurso");
            }
            if($id == null){
                return $this->failServerError("Ha ocurrido un error en el servidor");
            }
            
            $usuario = $this->model->find($id);
            if($usuario == null){
                return $this->failNotFound("No se ha enconrtrado el usuario con el id: ".$id);
            }

            $usuario = $this->request->getJSON();
            $pass = hashPassword($usuario->password);
            $usuario->password = $pass;
            if($this->model->update($id,$usuario)):
            $usuario->id = $id;
                return $this->respondUpdated($usuario);
            else:
                return $this->failValidationErrors($this->model->validation->listErrors());
            endif;
        }catch(Exception $e){
            return $this->failServerError("Ha ocurrido un error en el servidor");
        }
    }

    public function delete($id = null)
    {
        try {
            if(!validarAcceso(array('Administrador'), $this->request->getServer('HTTP_AUTHORIZATION'))){
                return $this->failServerError("No tienes permisos para acceder a este recurso");
            }
            if($id == null){
                return $this->failValidationErrors("No se ha recibido un Id valido");
            }
            
            $usuarioVerificado = $this->model->find($id);
            if($usuarioVerificado == null){
                return $this->failNotFound("No se ha enconrtrado el usuario con el id: ".$id);
            }

            if($this->model->delete($id)):
                return $this->respondDeleted($usuarioVerificado);
            else:
                return $this->failServerError("No se ha podido eliminar el registro"); 
            endif;
        }catch(Exception $e){
            return $this->failServerError("Ha ocurrido un error en el servidor");
        }
    }
}
