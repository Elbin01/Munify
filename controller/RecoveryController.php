<?php
session_start();
require_once '../models/Usuario.php';
require_once '../helpers/EmailHelper.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (isset($data['correo'])) {
        $usuarioModel = new Usuario();
        $user = $usuarioModel->obtenerPorCorreo($data['correo']);
        
        if ($user) {
            // Generar una contraseña temporal
            $nuevaContrasena = bin2hex(random_bytes(4)); // Ej: a1b2c3d4
            
            // Actualizar la contraseña en la base de datos
            // En el modelo actualizar(id, nombre, correo, password)
            $id_usuario = $user['id_usuario'] ?? $user['id'] ?? null;
            $nombre = $user['nombre'];
            
            if ($id_usuario) {
                $actualizado = $usuarioModel->actualizar($id_usuario, $nombre, $data['correo'], $nuevaContrasena);
                
                if ($actualizado) {
                    // Enviar correo
                    $enviado = EmailHelper::enviarRecuperacionPassword($data['correo'], $nombre, $nuevaContrasena);
                    
                    if ($enviado) {
                        echo json_encode(['success' => true, 'mensaje' => 'Se han enviado las instrucciones de recuperación a su correo electrónico.']);
                    } else {
                        // Revertir o informar del error de correo
                        echo json_encode(['success' => false, 'mensaje' => 'No se pudo enviar el correo de recuperación. Revise la configuración SMTP.']);
                    }
                } else {
                    echo json_encode(['success' => false, 'mensaje' => 'No se pudo actualizar la contraseña en el servidor']);
                }
            } else {
                echo json_encode(['success' => false, 'mensaje' => 'No se pudo obtener el identificador del usuario']);
            }
        } else {
            // Por seguridad, se puede responder lo mismo aunque no exista para no revelar cuentas,
            // pero es útil para el usuario saber si puso bien el correo.
            echo json_encode(['success' => false, 'mensaje' => 'El correo no se encuentra registrado en el sistema']);
        }
    } else {
        echo json_encode(['success' => false, 'mensaje' => 'Debe ingresar un correo electrónico']);
    }
} else {
    echo json_encode(['success' => false, 'mensaje' => 'Método no permitido']);
}
?>
