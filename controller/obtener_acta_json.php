<?php
require_once __DIR__ . '/../models/ActaMatrimonioModel.php';

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $modelo = new ActaMatrimonioModel();
    $datos = $modelo->obtenerActaPorId($_GET['id']);
    
    if ($datos) {
        echo json_encode(['success' => true, 'data' => $datos]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Acta no encontrada.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID no proporcionado.']);
}
?>
