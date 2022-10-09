<?php

namespace App\Controllers\API;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;
use Exception;

class CategoriaTienda extends ResourceController
{
    protected $format = 'json';
    protected $modelName = 'App\Models\CategoriaTiendaModel';

    public function __construct()
    {
        helper("access_rol");
    }

    public function index()
    {

        try {

            if (!validarAcceso(array('Administrador'), $this->request->getServer('HTTP_AUTHORIZATION'))) {
                return $this->failServerError("No tienes permisos para acceder a este recurso");
            }
            $categoriaTienda = $this->model->findAll();
            if ($categoriaTienda == null) {
                return $this->respondNoContent("No hay registros de categorias");
            }
            return $this->respond($categoriaTienda);

        } catch (Exception $e) {
            return $this->failServerError("Ha ocurrido un error en el servidor");
        }
    }

    public function create()
    {
        try {
            if (!validarAcceso(array('Administrador'), $this->request->getServer('HTTP_AUTHORIZATION'))) {
                return $this->failServerError("No tienes permisos para acceder a este recurso");
            }

            $categoriaTienda = $this->request->getJSON();
            if ($this->model->insert($categoriaTienda)):
                $categoriaTienda->id = $this->model->insertID();
                return $this->respondCreated($categoriaTienda);
            else:
                return $this->failValidationErrors($this->model->validation->listErrors());
            endif;
        } catch (Exception $e) {
            return $this->failServerError("Ha ocurrido un error en el servidor");
        }
    }

    public function edit($id = null)
    {
        try {
            if (!validarAcceso(array('Administrador'), $this->request->getServer('HTTP_AUTHORIZATION'))) {
                return $this->failServerError("No tienes permisos para acceder a este recurso");
            }
            if ($id == null) {
                return $this->failServerError("Ha ocurrido un error en el servidor");
            }

            $categoriaTienda = $this->model->find($id);
            if ($categoriaTienda == null) {
                return $this->failNotFound("No se ha encontrado la categoria dela tienda con el id: " . $id);
            }
            return $this->respond($categoriaTienda);
        } catch (Exception $e) {
            return $this->failServerError("Ha ocurrido un error en el servidor");
        }
    }

    public function update($id = null)
    {
        try {
            if (!validarAcceso(array('Administrador'), $this->request->getServer('HTTP_AUTHORIZATION'))) {
                return $this->failServerError("No tienes permisos para acceder a este recurso");
            }
            if ($id == null) {
                return $this->failServerError("Ha ocurrido un error en el servidor");
            }

            $categoriaTienda = $this->model->find($id);
            if ($categoriaTienda == null) {
                return $this->failNotFound("No se ha encontrado la categoria de la tienda con el id: " . $id);
            }

            $categoriaTienda = $this->request->getJSON();
            if ($this->model->update($id, $categoriaTienda)):
                $categoriaTienda->id = $id;
                return $this->respondUpdated($categoriaTienda);
            else:
                return $this->failValidationErrors($this->model->validation->listErrors());
            endif;
        } catch (Exception $e) {
            return $this->failServerError("Ha ocurrido un error en el servidor");
        }
    }

    public function delete($id = null)
    {
        try {
            if (!validarAcceso(array('Administrador'), $this->request->getServer('HTTP_AUTHORIZATION'))) {
                return $this->failServerError("No tienes permisos para acceder a este recurso");
            }
            if ($id == null) {
                return $this->failValidationErrors("No se ha recibido un Id valido");
            }

            $categoriaTiendaVerificado = $this->model->find($id);
            if ($categoriaTiendaVerificado == null) {
                return $this->failNotFound("No se ha enconrtrado la categoria de la tienda con el id: " . $id);
            }

            if ($this->model->delete($id)):
                return $this->respondDeleted($categoriaTiendaVerificado);
            else:
                return $this->failServerError("No se ha podido eliminar el registro");
            endif;
        } catch (Exception $e) {
            return $this->failServerError("Ha ocurrido un error en el servidor");
        }
    }
}
