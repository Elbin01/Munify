<?php
require_once __DIR__ . '/../models/MinoridadModel.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $modelo = new MinoridadModel();
    $datos = $modelo->obtenerRecientesHoy();
    echo json_encode($datos);
} else {
    echo json_encode(['error' => 'Método no permitido']);
}
?>
