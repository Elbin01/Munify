<?php
require_once 'config/Conexion.php';
$conexion = new Conexion();
$db = $conexion->conectar();
$stmt = $db->query("SELECT id_ciudadano, nombres, apellidos, DUI FROM ciudadano WHERE nombres LIKE '%Emerson%'");
$ciudadanos = $stmt->fetchAll(PDO::FETCH_ASSOC);
print_r($ciudadanos);
