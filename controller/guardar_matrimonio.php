<?php
require_once __DIR__ . '/../models/ActaMatrimonioModel.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $modelo = new ActaMatrimonioModel();

    $datos = [
        'numero_acta' => trim($_POST['numero_acta'] ?? ''),
        'libro' => trim($_POST['libro'] ?? ''),
        'folio' => trim($_POST['folio'] ?? ''),
        
        'novio_nombre_completo' => trim($_POST['novio_nombre_completo'] ?? ''),
        'novio_edad' => (int)($_POST['novio_edad'] ?? 0),
        'novio_profesion' => trim($_POST['novio_profesion'] ?? ''),
        'novio_nacionalidad' => trim($_POST['novio_nacionalidad'] ?? ''),
        'novio_dui' => trim($_POST['novio_dui'] ?? ''),
        'novio_domicilio' => trim($_POST['novio_domicilio'] ?? ''),
        
        'novia_nombre_completo' => trim($_POST['novia_nombre_completo'] ?? ''),
        'novia_edad' => (int)($_POST['novia_edad'] ?? 0),
        'novia_profesion' => trim($_POST['novia_profesion'] ?? ''),
        'novia_nacionalidad' => trim($_POST['novia_nacionalidad'] ?? ''),
        'novia_dui' => trim($_POST['novia_dui'] ?? ''),
        'novia_domicilio' => trim($_POST['novia_domicilio'] ?? ''),
        
        'regimen_patrimonial' => trim($_POST['regimen_patrimonial'] ?? ''),
        'fecha_matrimonio' => trim($_POST['fecha_matrimonio'] ?? ''),
        'hora_matrimonio' => trim($_POST['hora_matrimonio'] ?? ''),
        
        'nombre_oficial' => trim($_POST['nombre_oficial'] ?? ''),
        'cargo_oficial' => trim($_POST['cargo_oficial'] ?? ''),
        'testigo1_nombre' => trim($_POST['testigo1_nombre'] ?? ''),
        'testigo2_nombre' => trim($_POST['testigo2_nombre'] ?? '')
    ];

    // Basic validation
    if (empty($datos['novio_nombre_completo']) || empty($datos['novia_nombre_completo']) || empty($datos['fecha_matrimonio'])) {
        echo json_encode(['success' => false, 'message' => 'Los nombres de los contrayentes y la fecha son obligatorios.']);
        exit;
    }

    $id_acta = $modelo->registrarActa($datos);

    if ($id_acta) {
        echo json_encode([
            'success' => true, 
            'message' => 'Acta de matrimonio registrada exitosamente.',
            'id_acta' => $id_acta
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Hubo un error al registrar el acta de matrimonio.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
}
?>
