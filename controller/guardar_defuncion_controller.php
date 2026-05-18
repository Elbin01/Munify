<?php
require_once __DIR__ . '/../models/DefuncionModel.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_ciudadano = $_POST['id_ciudadano'] ?? null;
    $fecha_defuncion = $_POST['fecha_defuncion'] ?? '';
    $lugar_defuncion = $_POST['lugar_defuncion'] ?? '';
    $causa = $_POST['causa'] ?? 'No especificada';
    $nombre_declarante = $_POST['nombre_declarante'] ?? '';
    $parentesco_declarante = $_POST['parentesco_declarante'] ?? 'Informante';

    if (!$id_ciudadano || empty($fecha_defuncion)) {
        echo json_encode(['success' => false, 'message' => 'El ID del ciudadano y la fecha de defunción son obligatorios.']);
        exit;
    }

    $modelo = new DefuncionModel();
    $id_carta = $modelo->insertar($id_ciudadano, $fecha_defuncion, $lugar_defuncion, $causa, $nombre_declarante, $parentesco_declarante);

    if ($id_carta) {
        echo json_encode(['success' => true, 'id_carta' => $id_carta, 'message' => 'Acta de defunción guardada exitosamente.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al guardar el acta en la base de datos.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
}
?>
