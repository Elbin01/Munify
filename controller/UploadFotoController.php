<?php
session_start();
require_once '../models/Usuario.php';

header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['foto'])) {
    $file = $_FILES['foto'];
    
    // Validar tipo de archivo
    $allowed = ['image/jpeg', 'image/png', 'image/jpg'];
    if (!in_array($file['type'], $allowed)) {
        echo json_encode(['success' => false, 'message' => 'Formato de imagen no válido']);
        exit;
    }
    
    // Crear directorio si no existe
    $uploadDir = '../assets/Img/profiles/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    // Generar nombre único
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = 'user_' . $_SESSION['usuario_id'] . '_' . time() . '.' . $ext;
    $targetPath = $uploadDir . $filename;
    
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        // Actualizar base de datos
        $usuarioModel = new Usuario();
        $usuarioModel->actualizarFoto($_SESSION['usuario_id'], $filename);
        
        // Actualizar sesión si es necesario
        $_SESSION['foto_perfil'] = $filename;
        
        echo json_encode(['success' => true, 'filename' => $filename, 'message' => 'Foto actualizada correctamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al guardar la imagen']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Petición inválida']);
}
?>
