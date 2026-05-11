<?php
require_once __DIR__ . '/../models/PartidaModel.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_ciudadano = $_POST['id_ciudadano'] ?? null;
    $numero_partida = $_POST['numero_partida'] ?? '';
    $libro = $_POST['libro'] ?? '';
    $folio = $_POST['folio'] ?? '';

    if (!$id_ciudadano || empty($numero_partida)) {
        echo json_encode(['success' => false, 'message' => 'El ID del ciudadano y el número de partida son obligatorios.']);
        exit;
    }

    $modelo = new PartidaModel();
    $id_partida = $modelo->insertar($id_ciudadano, $numero_partida, $libro, $folio);

    if ($id_partida) {
        echo json_encode(['success' => true, 'id_partida' => $id_partida, 'message' => 'Partida guardada exitosamente.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al guardar la partida en la base de datos.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
}
?>
