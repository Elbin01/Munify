<?php
require_once __DIR__ . '/../models/CiudadanoModel.php';

header('Content-Type: application/json');

if (isset($_GET['q'])) {
    $model = new CiudadanoModel();
    $resultados = $model->buscar($_GET['q']);
    echo json_encode($resultados);
} else {
    echo json_encode([]);
}
?>
