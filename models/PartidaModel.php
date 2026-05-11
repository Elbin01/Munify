<?php
require_once __DIR__ . '/../config/conexion.php';

class PartidaModel {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function obtenerTodas() {
        $sql = "SELECT p.*, c.nombres, c.apellidos 
                FROM Partida_Nacimiento p 
                INNER JOIN Ciudadano c ON p.id_ciudadano = c.id_ciudadano";
        $result = $this->conn->query($sql);
        $partidas = array();
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $partidas[] = $row;
            }
        }
        return $partidas;
    }
    
    public function obtenerRecientesHoy() {
        $sql = "SELECT p.*, c.nombres, c.apellidos, c.DUI 
                FROM Partida_Nacimiento p 
                INNER JOIN Ciudadano c ON p.id_ciudadano = c.id_ciudadano 
                WHERE p.fecha_emision = CURRENT_DATE() 
                ORDER BY p.id_partida DESC LIMIT 10";
        $result = $this->conn->query($sql);
        $partidas = array();
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $partidas[] = $row;
            }
        }
        return $partidas;
    }

    public function obtenerPorId($id) {
        $sql = "SELECT p.*, c.* 
                FROM Partida_Nacimiento p 
                INNER JOIN Ciudadano c ON p.id_ciudadano = c.id_ciudadano 
                WHERE p.id_partida = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                return $row;
            }
        }
        return null;
    }

    public function insertar($id_ciudadano, $numero_partida, $libro, $folio) {
        $sql = "INSERT INTO Partida_Nacimiento (id_ciudadano, numero_partida, libro, folio) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("isss", $id_ciudadano, $numero_partida, $libro, $folio);
            if ($stmt->execute()) {
                return $this->conn->insert_id;
            }
        }
        return false;
    }
    public function contarPartidas() {
        $sql = "SELECT COUNT(*) as total FROM Partida_Nacimiento";
        $result = $this->conn->query($sql);
        if ($result && $row = $result->fetch_assoc()) {
            return $row['total'];
        }
        return 0;
    }
}
?>
