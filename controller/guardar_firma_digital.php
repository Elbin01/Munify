<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['imagen'])) {
    echo json_encode(['success' => false, 'message' => 'No se recibió ninguna imagen.']);
    exit;
}

// Extraer el base64
$image_parts = explode(";base64,", $data['imagen']);
if (count($image_parts) !== 2) {
    echo json_encode(['success' => false, 'message' => 'Formato de imagen inválido.']);
    exit;
}

$image_type_aux = explode("image/", $image_parts[0]);
$image_type = $image_type_aux[1];
$image_base64 = base64_decode($image_parts[1]);

// Directorio de destino
$dir = __DIR__ . '/../assets/uploads/firmas/';
if (!file_exists($dir)) {
    mkdir($dir, 0777, true);
}

// Nombre del archivo (fijo para sobrescribir)
$file_name = 'firma1.png';
$file_path = $dir . $file_name;

if (file_put_contents($file_path, $image_base64)) {
    echo json_encode(['success' => true, 'message' => 'Firma guardada correctamente.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al guardar la firma en el servidor.']);
}
