<?php
require_once __DIR__ . '/../config/conexion.php';

class MinoridadModel {
    private $conn;

    public function __construct() {
        $database = new Conexion();
        $this->conn = $database->conectar();
    }

    public function obtenerRecientesHoy() {
        $sql = "SELECT m.*, c.nombres, c.apellidos, c.DUI 
                FROM carnet_menoridad m 
                INNER JOIN ciudadano c ON m.id_ciudadano = c.id_ciudadano 
                WHERE m.fecha_emision = CURRENT_DATE() 
                ORDER BY m.id_carnet DESC LIMIT 10";
        try {
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return array();
        }
    }

    public function obtenerPorId($id) {
        $sql = "SELECT m.*, c.* 
                FROM carnet_menoridad m 
                INNER JOIN ciudadano c ON m.id_ciudadano = c.id_ciudadano 
                WHERE m.id_carnet = :id";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    public function insertar($id_ciudadano, $numero_carnet, $lugar_estudio, $color_piel, $color_ojos, $color_cabello, $senales_especiales) {
        $fecha_emision = date('Y-m-d');
        $fecha_vencimiento = date('Y-m-d', strtotime('+5 years'));

        $sql = "INSERT INTO carnet_menoridad (id_ciudadano, numero_carnet, fecha_emision, fecha_vencimiento, lugar_estudio, color_piel, color_ojos, color_cabello, senales_especiales) 
                VALUES (:id_ciudadano, :numero_carnet, :fecha_emision, :fecha_vencimiento, :lugar_estudio, :color_piel, :color_ojos, :color_cabello, :senales_especiales)";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_ciudadano', $id_ciudadano, PDO::PARAM_INT);
            $stmt->bindParam(':numero_carnet', $numero_carnet);
            $stmt->bindParam(':fecha_emision', $fecha_emision);
            $stmt->bindParam(':fecha_vencimiento', $fecha_vencimiento);
            $stmt->bindParam(':lugar_estudio', $lugar_estudio);
            $stmt->bindParam(':color_piel', $color_piel);
            $stmt->bindParam(':color_ojos', $color_ojos);
            $stmt->bindParam(':color_cabello', $color_cabello);
            $stmt->bindParam(':senales_especiales', $senales_especiales);
            
            if ($stmt->execute()) {
                return $this->conn->lastInsertId();
            }
        } catch (PDOException $e) {
            return false;
        }
        return false;
    }
}
?>
