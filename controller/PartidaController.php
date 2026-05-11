<?php
require_once __DIR__ . '/../models/PartidaModel.php';

class PartidaController {
    private $model;

    public function __construct() {
        $this->model = new PartidaModel();
    }

    public function listar() {
        return $this->model->obtenerTodas();
    }
}
?>
