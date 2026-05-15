<?php
require_once '../models/CitaModel.php';

header('Content-Type: application/json');

$model = new CitaModel();
$citas = $model->obtenerTodasLasCitas();

echo json_encode($citas);
?>
