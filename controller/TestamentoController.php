<?php

require_once __DIR__ . '/../models/TestamentoModel.php';

class TestamentoController {

    private $modelo;

    public function __construct() {
        $this->modelo = new TestamentoModel();
    }

    /**
     * Guardar un nuevo testamento
     */
    public function guardar($datos) {
        return $this->modelo->guardar($datos);
    }

    /**
     * Obtener un testamento por ID
     */
    public function obtenerReporte($id) {
        return $this->modelo->buscarPorId($id);
    }

    /**
     * Obtener últimos testamentos
     */
    public function obtenerRecientes($limite = 10) {
        return $this->modelo->obtenerRecientes($limite);
    }

    /**
     * Buscar por DUI
     */
    public function buscarPorDui($dui) {
        return $this->modelo->buscarPorDui($dui);
    }
}