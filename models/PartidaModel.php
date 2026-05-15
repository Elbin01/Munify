<?php
require_once __DIR__ . '/../config/conexion.php';

class PartidaModel {
    private $conn;

    public function __construct() {
        $database = new Conexion();
        $this->conn = $database->conectar();
    }

    public function obtenerTodas() {
        $sql = "SELECT p.*, c.nombres, c.apellidos 
                FROM Partida_Nacimiento p 
                INNER JOIN Ciudadano c ON p.id_ciudadano = c.id_ciudadano";
        try {
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return array();
        }
    }
    
    public function obtenerRecientesHoy() {
        $sql = "SELECT p.*, c.nombres, c.apellidos, c.DUI 
                FROM Partida_Nacimiento p 
                INNER JOIN Ciudadano c ON p.id_ciudadano = c.id_ciudadano 
                WHERE p.fecha_emision = CURRENT_DATE() 
                ORDER BY p.id_partida DESC LIMIT 10";
        try {
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return array();
        }
    }

    public function obtenerPorId($id) {
        $sql = "SELECT p.*, c.* 
                FROM Partida_Nacimiento p 
                INNER JOIN Ciudadano c ON p.id_ciudadano = c.id_ciudadano 
                WHERE p.id_partida = :id";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    public function insertar($id_ciudadano, $numero_partida, $libro, $folio) {
        $sql = "INSERT INTO Partida_Nacimiento (id_ciudadano, numero_partida, libro, folio) VALUES (:id_ciudadano, :numero_partida, :libro, :folio)";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_ciudadano', $id_ciudadano, PDO::PARAM_INT);
            $stmt->bindParam(':numero_partida', $numero_partida);
            $stmt->bindParam(':libro', $libro);
            $stmt->bindParam(':folio', $folio);
            
            if ($stmt->execute()) {
                return $this->conn->lastInsertId();
            }
        } catch (PDOException $e) {
            return false;
        }
        return false;
    }

    public function contarPartidas() {
        $sql = "SELECT COUNT(*) as total FROM Partida_Nacimiento";
        try {
            $stmt = $this->conn->query($sql);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total'] ?? 0;
        } catch (PDOException $e) {
            return 0;
        }
    }
}
?>

