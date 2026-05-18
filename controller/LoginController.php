<?php
session_start();
require_once '../models/Usuario.php';

// Asegurarse de que se devuelva JSON
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos JSON enviados por fetch
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (isset($data['usuario']) && isset($data['password'])) {
        $usuarioModel = new Usuario();
        $user = $usuarioModel->login($data['usuario'], $data['password']);
        
        if ($user) {
            // Guardar datos en sesión
            // Ajusta 'id' o 'id_usuario' según tu base de datos
            $_SESSION['usuario_id'] = $user['id'] ?? $user['id_usuario'] ?? null; 
            $_SESSION['usuario'] = $user['nombre'] ?? '';
            $_SESSION['rol'] = $user['rol'] ?? $user['id_rol'] ?? null;
            
            echo json_encode(['success' => true, 'mensaje' => 'Login exitoso', 'usuario' => $user['nombre'] ?? '', 'rol' => $_SESSION['rol']]);
        } else {
            echo json_encode(['success' => false, 'mensaje' => 'Credenciales inválidas']);
        }
    } else {
        echo json_encode(['success' => false, 'mensaje' => 'Datos incompletos']);
    }
} else {
    echo json_encode(['success' => false, 'mensaje' => 'Método no permitido']);
}
?>
