<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (isset($data['tipo_tramite']) && isset($data['correo'])) {
        
        echo json_encode([
            'success' => true, 
            'mensaje' => 'Solicitud recibida correctamente',
            'datos' => $data
        ]);
        
    } else {
        echo json_encode(['success' => false, 'mensaje' => 'Faltan datos requeridos (trámite o correo)']);
    }
} else {
    echo json_encode(['success' => false, 'mensaje' => 'Método no permitido']);
}
?>
