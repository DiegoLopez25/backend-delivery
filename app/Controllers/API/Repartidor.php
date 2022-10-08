<?php

namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;
use App\Models\RepartidorModel;
use Exception;

class Repartidor extends ResourceController
{
    public function __construct()
    {
        helper("secure_password");
        helper("access_rol");
        $this->model = $this->setModel(new RepartidorModel());
    }

    public function index()
    {
        try{
            if(!validarAcceso(array('Administrador'), $this->request->getServer('HTTP_AUTHORIZATION'))){
                return $this->failServerError("No tienes permisos para acceder a este recurso");
            }
            $repartidor = $this->model->listaRepartidores();
            if($repartidor == null){
                return $this->respondNoContent("No hay registros de usuarios");
            }
            return $this->respond($repartidor);
            
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

            $repartidor = $this->request->getJSON(); 
            $pass = hashPassword($repartidor->password);
            $repartidor->password = $pass;
            if($this->model->insert($repartidor)):
                $repartidor->id = $this->model->insertID();
                return $this->respondCreated($repartidor);
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
            
            $repartidor = $this->model->find($id);
            if($repartidor == null){
                return $this->failNotFound("No se ha enconrtrado el repartidor con el id: ".$id);
            }
            return $this->respond ($repartidor);
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
            
            $repartidor = $this->model->find($id);
            if($repartidor == null){
                return $this->failNotFound("No se ha enconrtrado el repartidor con el id: ".$id);
            }

            $repartidor = $this->request->getJSON();
            $pass = hashPassword($repartidor->password);
            $repartidor->password = $pass;
            if($this->model->update($id,$repartidor)):
            $repartidor->id = $id;
                return $this->respondUpdated($repartidor);
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
            
            $repartidorVerificado = $this->model->find($id);
            if($repartidorVerificado == null){
                return $this->failNotFound("No se ha enconrtrado el usuario con el id: ".$id);
            }

            if($this->model->delete($id)):
                return $this->respondDeleted($repartidorVerificado);
            else:
                return $this->failServerError("No se ha podido eliminar el registro"); 
            endif;
        }catch(Exception $e){
            return $this->failServerError("Ha ocurrido un error en el servidor");
        }
    }
}
