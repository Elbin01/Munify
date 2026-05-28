<?php
require_once 'config/Conexion.php';
$conexion = new Conexion();
$db = $conexion->conectar();
$stmt = $db->query("SHOW TABLES");
$tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
print_r($tables);
