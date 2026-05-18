<?php
session_start();
require_once '../models/Usuario.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (isset($data['nombre']) && isset($data['correo']) && isset($data['password'])) {
        $usuarioModel = new Usuario();
        
        // Verificar si el correo ya existe
        $existe = $usuarioModel->obtenerPorCorreo($data['correo']);
        if ($existe) {
            echo json_encode(['success' => false, 'mensaje' => 'El correo electrónico ya está registrado en el sistema']);
            exit;
        }

        // Crear el usuario con rol de ciudadano (id_rol = 2)
        $creado = $usuarioModel->crear($data['nombre'], $data['correo'], $data['password'], 2);
        
        if ($creado) {
            echo json_encode(['success' => true, 'mensaje' => 'Registro exitoso. Ahora puede iniciar sesión.']);
        } else {
            echo json_encode(['success' => false, 'mensaje' => 'Ocurrió un error al intentar crear la cuenta']);
        }
    } else {
        echo json_encode(['success' => false, 'mensaje' => 'Faltan datos obligatorios para el registro']);
    }
} else {
    echo json_encode(['success' => false, 'mensaje' => 'Método no permitido']);
}
?>
