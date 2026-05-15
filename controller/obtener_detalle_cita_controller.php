<?php
require_once '../models/CitaModel.php';

header('Content-Type: application/json');

$id = $_GET['id'] ?? null;

if ($id) {
    $model = new CitaModel();
    $cita = $model->obtenerCitaConContacto($id);
    if ($cita) {
        echo json_encode($cita);
    } else {
        echo json_encode(['error' => 'Cita no encontrada']);
    }
} else {
    echo json_encode(['error' => 'ID no proporcionado']);
}
?>
