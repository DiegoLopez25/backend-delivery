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
            $categories = $this->model->findAll();

            return $this->respond(['categories' => $categories]);

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

            $rules = [
                'nombre' => ['rules' => 'required'],
            ];

            if (!$this->validate($rules)) {
                return $this->fail($this->validator->getErrors(), 422);
            }

            $nombre = $this->request->getVar("nombre");

            if ($this->model->insert(["nombre" => $nombre])){
                return $this->respondCreated(["message" => "Categoría de Tienda registrada éxitosamente"]);
            }

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

            $category = $this->model->find($id);

            if ($category == null) {
                return $this->failNotFound("No se ha encontrado la categoria de la tienda con el id: " . $id);
            }
            return $this->respond(['category' => $category]);

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

            $rules = [
                'nombre' => ['rules' => 'required'],
            ];

            if ($id == null) {
                return $this->failServerError("Ha ocurrido un error en el servidor");
            }

            if (!$this->validate($rules)) {
                return $this->fail($this->validator->getErrors(), 422);
            }

            $nombre = $this->request->getVar("nombre");

            $data = [
                "nombre" => $nombre
            ];

            $categoriaTienda = $this->model->find($id);

            if ($categoriaTienda == null) {
                return $this->failNotFound("No se ha encontrado la categoria de la tienda con el id: " . $id);
            }

            if ($this->model->update($id, $data)){
                return $this->respond(["message" => "Categoría de Tienda actualizada éxitosamente"], 202);
            }

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
                return $this->respond("", 204);
            else:
                return $this->failServerError("No se ha podido eliminar el registro");
            endif;
        } catch (Exception $e) {
            return $this->failServerError("Ha ocurrido un error en el servidor");
        }
    }
}
