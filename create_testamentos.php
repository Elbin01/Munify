<?php
require_once 'config/Conexion.php';
$conexion = new Conexion();
$db = $conexion->conectar();

$sql = "CREATE TABLE IF NOT EXISTS testamentos (
    id_testamento INT AUTO_INCREMENT PRIMARY KEY,
    nombre_testador VARCHAR(255) NOT NULL,
    dui_testador VARCHAR(15) NOT NULL,
    edad_testador INT,
    estado_civil_testador VARCHAR(50),
    domicilio_testador TEXT,
    nombre_heredero VARCHAR(255) NOT NULL,
    parentesco_heredero VARCHAR(100),
    bienes_declarados TEXT NOT NULL,
    declaracion_voluntad TEXT NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

try {
    $db->exec($sql);
    echo "Tabla 'testamentos' creada correctamente.";
} catch (PDOException $e) {
    echo "Error al crear la tabla: " . $e->getMessage();
}
