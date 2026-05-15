<?php
require_once __DIR__ . '/../models/CiudadanoModel.php';

class CiudadanoController {
    private $model;

    public function __construct() {
        $this->model = new CiudadanoModel();
    }

    public function listar() {
        return $this->model->obtenerTodos();
    }
}
?>
