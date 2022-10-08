<?php

namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;
use App\Models\TiendaModel;
use Exception;

class Tienda extends ResourceController
{
    public function __construct()
    {
        helper("access_rol");
        helper("secure_password");
        $this->model = $this->setModel(new TiendaModel());
    }

    public function index()
    {
        try{
            if(!validarAcceso(array('Administrador'), $this->request->getServer('HTTP_AUTHORIZATION'))){
                return $this->failServerError("No tienes permisos para acceder a este recurso");
            }
            $tienda = $this->model->listaTiendas();
            if($tienda == null){
                return $this->respondNoContent("No hay registros de tiendas");
            }
            return $this->respond($tienda);
            
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

            $tienda = $this->request->getJSON(); 
            $pass = hashPassword($tienda->password);
            $tienda->password = $pass;
            if($this->model->insert($tienda)):
                $tienda->id = $this->model->insertID();
                return $this->respondCreated($tienda);
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
            
            $tienda = $this->model->find($id);
            if($tienda == null){
                return $this->failNotFound("No se ha enconrtrado la tienda con el id: ".$id);
            }
            return $this->respond ($tienda);
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
            
            $tienda = $this->model->find($id);
            if($tienda == null){
                return $this->failNotFound("No se ha enconrtrado el usuario con el id: ".$id);
            }

            $tienda = $this->request->getJSON();
            $pass = hashPassword($tienda->password);
            $tienda->password = $pass;
            if($this->model->update($id,$tienda)):
            $tienda->id = $id;
                return $this->respondUpdated($tienda);
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
            
            $tiendaVerificada = $this->model->find($id);
            if($tiendaVerificada == null){
                return $this->failNotFound("No se ha enconrtrado el usuario con el id: ".$id);
            }

            if($this->model->delete($id)):
                return $this->respondDeleted($tiendaVerificada);
            else:
                return $this->failServerError("No se ha podido eliminar el registro"); 
            endif;
        }catch(Exception $e){
            return $this->failServerError("Ha ocurrido un error en el servidor");
        }
    }
}
