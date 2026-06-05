<?php
require_once 'config/Conexion.php';
$conexion = new Conexion();
$db = $conexion->conectar();

$sql = "CREATE TABLE IF NOT EXISTS `acta_matrimonio` (
  `id_acta` int(11) NOT NULL AUTO_INCREMENT,
  `numero_acta` varchar(50) NOT NULL,
  `libro` varchar(50) NOT NULL,
  `folio` varchar(50) NOT NULL,
  
  `novio_nombre_completo` varchar(150) NOT NULL,
  `novio_edad` int(3) NOT NULL,
  `novio_profesion` varchar(100) NOT NULL,
  `novio_nacionalidad` varchar(100) NOT NULL,
  `novio_dui` varchar(20) NOT NULL,
  `novio_domicilio` varchar(255) NOT NULL,
  
  `novia_nombre_completo` varchar(150) NOT NULL,
  `novia_edad` int(3) NOT NULL,
  `novia_profesion` varchar(100) NOT NULL,
  `novia_nacionalidad` varchar(100) NOT NULL,
  `novia_dui` varchar(20) NOT NULL,
  `novia_domicilio` varchar(255) NOT NULL,
  
  `regimen_patrimonial` varchar(100) NOT NULL,
  `fecha_matrimonio` date NOT NULL,
  `hora_matrimonio` time NOT NULL,
  
  `nombre_oficial` varchar(150) NOT NULL,
  `cargo_oficial` varchar(150) NOT NULL,
  `testigo1_nombre` varchar(150) NOT NULL,
  `testigo2_nombre` varchar(150) NOT NULL,
  
  `fecha_registro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  
  PRIMARY KEY (`id_acta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;";

try {
    $db->exec($sql);
    echo "Tabla acta_matrimonio creada exitosamente.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
