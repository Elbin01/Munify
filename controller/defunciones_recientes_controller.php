<?php
require_once __DIR__ . '/../models/DefuncionModel.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $modelo = new DefuncionModel();
    $datos = $modelo->obtenerRecientesHoy();
    echo json_encode($datos);
} else {
    echo json_encode(['error' => 'Método no permitido']);
}
?>
