<?php
require 'config/Conexion.php';
$db = (new Conexion())->conectar();
$res = $db->query("SELECT id_acta FROM acta_matrimonio ORDER BY id_acta DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
print_r($res);
