<?php
// controller/testamentos_recientes_controller.php

header('Content-Type: application/json; charset=utf-8');

// TODO: Descomenta y ajusta las rutas de tus conexiones según tu proyecto
//require_once '../config/conexion.php'; 
//require_once '../models/Testamento_model.php';

try {
    // Ejemplo de conexión nativa PDO por si no usas modelo aún:
    /*
    $pdo = new PDO("mysql:host=localhost;dbname=MUNIFY;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Consulta para traer los últimos 5 testamentos registrados
    $sql = "SELECT id_testamento, nombre_testador, dui_testador, nombre_heredero, parentesco_heredero, fecha_registro 
            FROM testamentos 
            ORDER BY id_testamento DESC 
            LIMIT 5";
            
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    */

    // --- MOCK DE PRUEBA TEMPORAL ---
    // Borra este array simulado cuando actives la consulta a la base de datos:
    $data = [
        [
            "id_testamento" => 1,
            "fecha_registro" => date('Y-m-d'),
            "dui_testador" => "01234567-8",
            "nombre_testador" => "Juan Pérez Alvarenga",
            "nombre_heredero" => "María Pérez",
            "parentesco_heredero" => "Hijo/a"
        ]
    ];
    // ---------------------------------

    echo json_encode($data, JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Error en el servidor: " . $e->getMessage()
    ]);
}