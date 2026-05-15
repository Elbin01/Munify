<?php
require_once __DIR__ . '/../models/MinoridadModel.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_ciudadano = $_POST['id_ciudadano'] ?? null;
    $numero_carnet = $_POST['numero_carnet'] ?? ('MIN-' . date('YmdHis'));
    $lugar_estudio = $_POST['lugar_estudio'] ?? '';
    $color_piel = $_POST['color_piel'] ?? '';
    $color_ojos = $_POST['color_ojos'] ?? '';
    $color_cabello = $_POST['color_cabello'] ?? '';
    $senales_especiales = $_POST['senales_especiales'] ?? '';

    if (!$id_ciudadano) {
        echo json_encode(['success' => false, 'message' => 'El ID del ciudadano es obligatorio.']);
        exit;
    }

    $modelo = new MinoridadModel();
    $id_carnet = $modelo->insertar($id_ciudadano, $numero_carnet, $lugar_estudio, $color_piel, $color_ojos, $color_cabello, $senales_especiales);

    if ($id_carnet) {
        echo json_encode(['success' => true, 'id_carnet' => $id_carnet, 'message' => 'Carnet de minoridad guardado exitosamente.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al guardar el carnet en la base de datos.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
}
?>
