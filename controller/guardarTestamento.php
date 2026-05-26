<?php
// controllers/crear_testamento_api.php (o tu ruta de APIs)
require_once __DIR__ . '/../models/TestamentoModel.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura de datos sanitizados desde el $_POST
    $nombre_testador   = $_POST['nombre_testador'] ?? '';
    $dui_testador      = $_POST['dui'] ?? ''; // Tu input de interfaz se llama 'dui'
    $edad_testador     = $_POST['edad'] ?? null;
    $estado_civil      = $_POST['estado_civil'] ?? '';
    $domicilio         = $_POST['domicilio'] ?? '';
    $nombre_heredero   = $_POST['heredero'] ?? '';
    $parentesco        = $_POST['parentesco'] ?? '';
    $bienes            = $_POST['bienes'] ?? '';
    $declaracion       = $_POST['declaracion'] ?? '';
    
    
    // Validación estricta de campos obligatorios para el documento legal
    if (empty($nombre_testador) || empty($dui_testador) || empty($bienes) || empty($declaracion)) {
        echo json_encode([
            'success' => false, 
            'message' => 'El nombre del testador, DUI, bienes y declaración de voluntad son obligatorios.'
        ]);
        exit;
    }

    // Estructuramos el array tal como lo espera el TestamentoModel
    session_start();
    $datos = [
        
        'nombre_testador' => $nombre_testador,
        'dui'             => $dui_testador,
        'edad'            => $edad_testador,
        'estado_civil'    => $estado_civil,
        'domicilio'       => $domicilio,
        'heredero'        => $nombre_heredero,
        'parentesco'      => $parentesco,
        'bienes'          => $bienes,
        'declaracion'     => $declaracion
        
    ];

    $modelo = new TestamentoModel();
    $id_testamento = $modelo->guardar($datos);

    if ($id_testamento) {
        echo json_encode([
            'success' => true, 
            'id_testamento' => $id_testamento, 
            'message' => 'Testamento registrado exitosamente en el sistema Munify.'
        ]);
    } else {
        echo json_encode([
            'success' => false, 
            'message' => 'Error al guardar el registro del testamento en la base de datos.'
        ]);
    }
} else {
    echo json_encode([
        'success' => false, 
        'message' => 'Método no permitido.'
    ]);
}
?>