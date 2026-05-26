<?php
require_once 'config/Conexion.php';
$conexion = new Conexion();
$db = $conexion->conectar();
$stmt = $db->query("SELECT * FROM testamentos");
$testamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
print_r($testamentos);
