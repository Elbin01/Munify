<?php
require_once __DIR__ . '/../config/Conexion.php';

header('Content-Type: application/json');

if (isset($_GET['q'])) {
    $conexion = new Conexion();
    $db = $conexion->conectar();
    
    $query = "%" . trim($_GET['q']) . "%";
    
    $sql = "SELECT 
                id_testamento, 
                nombre_testador AS nombres, 
                '' AS apellidos, 
                dui_testador AS DUI, 
                domicilio_testador AS domicilio, 
                nombre_heredero 
            FROM testamentos 
            WHERE nombre_testador LIKE :q OR dui_testador LIKE :q";
            
    try {
        $stmt = $db->prepare($sql);
        $stmt->execute([':q' => $query]);
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultados);
    } catch (Exception $e) {
        echo json_encode([]);
    }
} else {
    echo json_encode([]);
}
?>
