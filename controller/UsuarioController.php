<?php
session_start();
require_once '../models/Usuario.php';

$usuarioModel = new Usuario();
$action = $_GET['action'] ?? '';

header('Content-Type: application/json');

try {
    switch ($action) {
        case 'listar':
            $usuarios = $usuarioModel->listarTodos();
            echo json_encode($usuarios);
            break;

        case 'guardar':
            $id = $_POST['id_usuario'] ?? null;
            $nombre = $_POST['nombre'] ?? '';
            $correo = $_POST['correo'] ?? '';
            $password = $_POST['password'] ?? null;
            
            if ($id) {
                $resultado = $usuarioModel->actualizar($id, $nombre, $correo, $password);
                echo json_encode(['success' => $resultado, 'message' => 'Usuario actualizado correctamente']);
            } else {
                $resultado = $usuarioModel->crear($nombre, $correo, $password);
                echo json_encode(['success' => $resultado, 'message' => 'Usuario creado correctamente']);
            }
            break;

        case 'eliminar':
            $id = $_GET['id'] ?? null;
            if ($id) {
                $resultado = $usuarioModel->eliminar($id);
                echo json_encode(['success' => $resultado]);
            }
            break;

        case 'buscar_docs':
            $termino = $_GET['termino'] ?? '';
            if ($termino) {
                $docs = $usuarioModel->buscarDocumentos($termino);
                echo json_encode($docs);
            } else {
                echo json_encode([]);
            }
            break;

        default:
            echo json_encode(['error' => 'Acción no válida']);
            break;
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
