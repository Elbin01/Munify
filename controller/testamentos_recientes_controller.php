<?php
// controller/testamentos_recientes_controller.php

header('Content-Type: application/json; charset=utf-8');

// TODO: Descomenta y ajusta las rutas de tus conexiones según tu proyecto
//require_once '../config/conexion.php'; 
//require_once '../models/Testamento_model.php';

try {
    require_once '../models/TestamentoModel.php';
    $model = new TestamentoModel();
    $data = $model->obtenerRecientes(5);

    echo json_encode($data, JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Error en el servidor: " . $e->getMessage()
    ]);
}