<?php
require_once __DIR__ . '/../config/conexion.php';

class DefuncionModel {
    private $conn;

    public function __construct() {
        $database = new Conexion();
        $this->conn = $database->conectar();
    }

    public function obtenerRecientesHoy() {
        $sql = "SELECT d.*, c.nombres, c.apellidos, c.DUI 
                FROM carta_defuncion d 
                INNER JOIN ciudadano c ON d.id_ciudadano = c.id_ciudadano 
                WHERE d.fecha_emision = CURRENT_DATE() 
                ORDER BY d.id_carta DESC LIMIT 10";
        try {
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return array();
        }
    }

    public function obtenerPorId($id) {
        $sql = "SELECT d.*, c.* 
                FROM carta_defuncion d 
                INNER JOIN ciudadano c ON d.id_ciudadano = c.id_ciudadano 
                WHERE d.id_carta = :id";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    public function insertar($id_ciudadano, $fecha_defuncion, $lugar_defuncion, $causa, $nombre_declarante, $parentesco_declarante) {
        $sql = "INSERT INTO carta_defuncion (id_ciudadano, fecha_defuncion, lugar_defuncion, causa, nombre_declarante, parentesco_declarante, fecha_emision) 
                VALUES (:id_ciudadano, :fecha_defuncion, :lugar_defuncion, :causa, :nombre_declarante, :parentesco_declarante, CURRENT_DATE())";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_ciudadano', $id_ciudadano, PDO::PARAM_INT);
            $stmt->bindParam(':fecha_defuncion', $fecha_defuncion);
            $stmt->bindParam(':lugar_defuncion', $lugar_defuncion);
            $stmt->bindParam(':causa', $causa);
            $stmt->bindParam(':nombre_declarante', $nombre_declarante);
            $stmt->bindParam(':parentesco_declarante', $parentesco_declarante);
            
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
