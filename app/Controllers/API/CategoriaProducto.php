<?php

namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;
use App\Models\CategoriaProductoModel;
use Exception;

class CategoriaProducto extends ResourceController
{
    public function __construct()
    {
        helper("access_rol");
        $this->model = $this->setModel(new CategoriaProductoModel());
    }

    public function index()
    {
        try{
            if(!validarAcceso(array('Administrador'), $this->request->getServer('HTTP_AUTHORIZATION'))){
                return $this->failServerError("No tienes permisos para acceder a este recurso");
            }
            $categoriaProducto = $this->model->findAll();
            if($categoriaProducto == null){
                return $this->respondNoContent("No hay registros de categorias");
            }
            return $this->respond($categoriaProducto);
            
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

            $categoriaProducto = $this->request->getJSON(); 
            if($this->model->insert($categoriaProducto)):
                $categoriaProducto->id = $this->model->insertID();
                return $this->respondCreated($categoriaProducto);
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
            
            $categoriaProducto = $this->model->find($id);
            if($categoriaProducto == null){
                return $this->failNotFound("No se ha encontrado la categoria del producto con el id: ".$id);
            }
            return $this->respond ($categoriaProducto);
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
            
            $categoriaProducto = $this->model->find($id);
            if($categoriaProducto == null){
                return $this->failNotFound("No se ha encontrado la categoria del producto con el id: ".$id);
            }

            $categoriaProducto = $this->request->getJSON();
            if($this->model->update($id,$categoriaProducto)):
            $categoriaProducto->id = $id;
                return $this->respondUpdated($categoriaProducto);
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
            
            $categoriaProductoVerificado = $this->model->find($id);
            if($categoriaProductoVerificado == null){
                return $this->failNotFound("No se ha enconrtrado la categoria del producto con el id: ".$id);
            }

            if($this->model->delete($id)):
                return $this->respondDeleted($categoriaProductoVerificado);
            else:
                return $this->failServerError("No se ha podido eliminar el registro"); 
            endif;
        }catch(Exception $e){
            return $this->failServerError("Ha ocurrido un error en el servidor");
        }
    }
}
