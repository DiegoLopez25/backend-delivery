<?php

namespace App\Controllers;

use App\Models\ProductoModel;

use CodeIgniter\RESTful\ResourceController;
use Exception;

class ProductoController extends ResourceController
{

    public function __construct()
    {
        helper("secure_password");
        helper("access_rol");
        $this->model = new ProductoModel();
    }

    public function list()
    {
        try{
           /* if(!validarAcceso(array('Administrador'), $this->request->getServer('HTTP_AUTHORIZATION'))){
                return $this->failServerError("No tienes permisos para acceder a este recurso");
            }*/
            $empleado = $this->model->findAll();
            if($empleado == null){
                return $this->respondNoContent("No hay registros de productos");
            }
            return $this->respond(['code'=>200,'msg'=>'Lista de Productos','data' => $empleado ]);//$this->respond($empleado);
            
        }catch(Exception $e){
            return $this->respond(['code'=>$this->response->getStatusCode(),'msg'=>'Ha ocurrido un error en el servidor']);
        }
    } 

    public function create()
    {
        try {
            /*if(!validarAcceso(array('Administrador'), $this->request->getServer('HTTP_AUTHORIZATION'))){
                return $this->failServerError("No tienes permisos para acceder a este recurso");
            }*/

            

            $producto = $this->request->getJSON(); 
            if($this->model->insert($producto)):
                /*si recibes un json los valores se asignan asi: $producto->id */
                /*si recibes un postArray los valores se asignan asi: $producto['id'] */
                $producto->id = $this->model->insertID();
                return $this->respondCreated(['code'=>$this->response->getStatusCode(),'msg'=>'El producto ha sido guardado!!!','data'=>$producto]);
            else:
                return $this->respond(['code'=>$this->response->getStatusCode(),'msg'=>'Tiene algunos errores de validacion','errors'=>$this->model->validation->getErrors()])->setStatusCode(400,'validation errors');
            endif;
        } catch (Exception $e) {
            return $this->respond(['code'=>$this->response->getStatusCode(),'msg'=>'Ha ocurrido un error en el servidor']);
        }
    }

    public function edit($id = null){
        try {
           /* if(!validarAcceso(array('Administrador'), $this->request->getServer('HTTP_AUTHORIZATION'))){
                return $this->failServerError("No tienes permisos para acceder a este recurso");
            }*/
            if($id == null){
                return $this->respond(['code'=>$this->response->getStatusCode(),'msg'=>'Ha ocurrido un error en el server']);
            }
            
            $producto = $this->model->find($id);
            if($producto == null){
                return $this->respond(['code'=>$this->response->getStatusCode(),'msg'=>'producto','data' => "No se ha encontrado el producto con el id: ".$id ]);
            }
            return $this->respond(['code'=>$this->response->getStatusCode(),'msg'=>'datos del producto','data'=>$producto]);
        }catch(Exception $e){
            return $this->respond(['code'=>$this->response->getStatusCode(),'msg'=>'Ha ocurrido un error en el servidor']);
        }
    }
    
    public function update($id = null){
        try {
            /*if(!validarAcceso(array('Administrador'), $this->request->getServer('HTTP_AUTHORIZATION'))){
                return $this->failServerError("No tienes permisos para acceder a este recurso");
            }*/
            

            if($id == null){
                return $this->respond(['code'=>$this->response->getStatusCode(),'msg'=>'No se ha recibido un id valido']);
            }
            
            $producto = $this->model->find($id);
            if($producto == null){
                return $this->respond(['code'=>$this->response->getStatusCode(),'msg'=>'producto','data' => "No se ha encontrado el producto con el id: ".$id ]);
            }
            $producto= $this->request->getJSON();
            if($this->model->update($id,$producto)):
            $producto->id = $id;
                return $this->respondUpdated(['code'=>$this->response->getStatusCode(),'msg'=>'El producto ha sido actualizado!!!','data'=>$producto]);
            else:
                return $this->failValidationErrors($this->model->getErrors());
            endif;
        }catch(Exception $e){
            return $this->respond(['code'=>$this->response->getStatusCode(),'msg'=>'Ha ocurrido un error en el servidor']);
        }
    }
    
    public function delete($id = null)
    {
        try {
            /*if(!validarAcceso(array('Administrador'), $this->request->getServer('HTTP_AUTHORIZATION'))){
                return $this->failServerError("No tienes permisos para acceder a este recurso");
            }*/
            if($id == null){
                return $this->respond(['code'=>$this->response->getStatusCode(),'msg'=>'No se ha recibido un id valido']);
            }
            
            $productoVerificado = $this->model->find($id);
            if($productoVerificado == null){
                return $this->respond(['code'=>$this->response->getStatusCode(),'msg'=>'producto','data' => "No se ha encontrado el producto con el id: ".$id ]);
            }

            if($this->model->delete($id)):
                return $this->respondDeleted(['code'=>$this->response->getStatusCode(),'msg'=>'El producto ha sido eliminado!!!','data'=>$productoVerificado]);
            else:
                return $this->respond(['code'=>$this->response->getStatusCode(),'msg'=>'No se ha podido eliminar el registro del producto']);
            endif;
        }catch(Exception $e){
            return $this->respond(['code'=>$this->response->getStatusCode(),'msg'=>'Ha ocurrido un error en el servidor']);
        }
    }
}
