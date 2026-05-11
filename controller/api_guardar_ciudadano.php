<?php
require_once __DIR__ . '/../models/CiudadanoModel.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombres = $_POST['nombres'] ?? '';
    $apellidos = $_POST['apellidos'] ?? '';
    $sexo = $_POST['sexo'] ?? '';
    $fecha_nacimiento = !empty($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : null;
    $dui = $_POST['dui'] ?? null;
    $hospital = $_POST['hospital'] ?? '';
    $lugar_nacimiento = $_POST['lugar_nacimiento'] ?? '';
    $hora_nacimiento = !empty($_POST['hora_nacimiento']) ? $_POST['hora_nacimiento'] : null;
    $nombre_padre = $_POST['nombre_padre'] ?? '';
    $nombre_madre = $_POST['nombre_madre'] ?? '';

    if ($dui === '') {
        $dui = null;
    }
    
    // El sexo en la BDD es CHAR(1) (ej: 'M', 'F')
    if (strtolower($sexo) === 'masculino' || $sexo === 'M') {
        $sexo_char = 'M';
    } elseif (strtolower($sexo) === 'femenino' || $sexo === 'F') {
        $sexo_char = 'F';
    } else {
        $sexo_char = null;
    }

    if (empty($nombres) || empty($apellidos)) {
        echo json_encode(['success' => false, 'message' => 'Nombres y Apellidos son obligatorios.']);
        exit;
    }

    $modelo = new CiudadanoModel();
    $id = $modelo->insertar($nombres, $apellidos, $sexo_char, $fecha_nacimiento, $dui, $hospital, $lugar_nacimiento, $hora_nacimiento, $nombre_padre, $nombre_madre);

    if ($id) {
        echo json_encode(['success' => true, 'id_ciudadano' => $id, 'message' => 'Ciudadano guardado exitosamente.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al guardar en la base de datos o el DUI ya existe.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
}
?>
