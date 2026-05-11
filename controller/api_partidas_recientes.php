<?php
require_once __DIR__ . '/../models/PartidaModel.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $modelo = new PartidaModel();
    $partidas = $modelo->obtenerRecientesHoy();
    echo json_encode($partidas);
} else {
    echo json_encode(['error' => 'Método no permitido']);
}
?>
