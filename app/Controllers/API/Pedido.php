<?php

namespace App\Controllers;

use App\Models\PedidoModel;

use CodeIgniter\RESTful\ResourceController;
use Exception;

class PedidoController extends ResourceController
{

    public function __construct()
    {
        helper("secure_password");
        helper("access_rol");
        $this->model = new PedidoModel();
    }

    public function list()
    {
        try{
           /* if(!validarAcceso(array('Administrador'), $this->request->getServer('HTTP_AUTHORIZATION'))){
                return $this->failServerError("No tienes permisos para acceder a este recurso");
            }*/
            $empleado = $this->model->findAll();
            if($empleado == null){
                return $this->respondNoContent("No hay registros de pedidos");
            }
            return $this->respond(['code'=>200,'msg'=>'Lista de pedidos','data' => $empleado ]);//$this->respond($empleado);
            
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

            

            $pedido = $this->request->getJSON(); 
            if($this->model->insert($pedido)):
                /*si recibes un json los valores se asignan asi: $pedido->id */
                /*si recibes un postArray los valores se asignan asi: $pedido['id'] */
                $pedido->id = $this->model->insertID();
                return $this->respondCreated(['code'=>$this->response->getStatusCode(),'msg'=>'El pedido ha sido guardado!!!','data'=>$pedido]);
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
            
            $pedido = $this->model->find($id);
            if($pedido == null){
                return $this->respond(['code'=>$this->response->getStatusCode(),'msg'=>'pedido','data' => "No se ha encontrado el pedido con el id: ".$id ]);
            }
            return $this->respond(['code'=>$this->response->getStatusCode(),'msg'=>'datos del pedido','data'=>$pedido]);
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
            
            $pedido = $this->model->find($id);
            if($pedido == null){
                return $this->respond(['code'=>$this->response->getStatusCode(),'msg'=>'pedido','data' => "No se ha encontrado el pedido con el id: ".$id ]);
            }
            $pedido= $this->request->getJSON();
            if($this->model->update($id,$pedido)):
            $pedido->id = $id;
                return $this->respondUpdated(['code'=>$this->response->getStatusCode(),'msg'=>'El pedido ha sido actualizado!!!','data'=>$pedido]);
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
            
            $pedidoVerificado = $this->model->find($id);
            if($pedidoVerificado == null){
                return $this->respond(['code'=>$this->response->getStatusCode(),'msg'=>'pedido','data' => "No se ha encontrado el pedido con el id: ".$id ]);
            }

            if($this->model->delete($id)):
                return $this->respondDeleted(['code'=>$this->response->getStatusCode(),'msg'=>'El pedido ha sido eliminado!!!','data'=>$pedidoVerificado]);
            else:
                return $this->respond(['code'=>$this->response->getStatusCode(),'msg'=>'No se ha podido eliminar el registro del pedido']);
            endif;
        }catch(Exception $e){
            return $this->respond(['code'=>$this->response->getStatusCode(),'msg'=>'Ha ocurrido un error en el servidor']);
        }
    }
}
