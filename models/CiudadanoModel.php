<?php
require_once __DIR__ . '/../config/conexion.php';

class CiudadanoModel {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function obtenerTodos() {
        $sql = "SELECT * FROM Ciudadano";
        $result = $this->conn->query($sql);
        $ciudadanos = array();
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $ciudadanos[] = $row;
            }
        }
        return $ciudadanos;
    }
    
    public function buscar($query) {
        $queryParam = "%" . $query . "%";
        $sql = "SELECT c.*, p.id_partida 
                FROM Ciudadano c 
                LEFT JOIN Partida_Nacimiento p ON c.id_ciudadano = p.id_ciudadano 
                WHERE c.nombres LIKE ? OR c.apellidos LIKE ? OR c.DUI LIKE ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("sss", $queryParam, $queryParam, $queryParam);
            $stmt->execute();
            $result = $stmt->get_result();
            $ciudadanos = array();
            while($row = $result->fetch_assoc()) {
                $ciudadanos[] = $row;
            }
            return $ciudadanos;
        }
        return array();
    }
    
    public function obtenerPorId($id) {
        $sql = "SELECT * FROM Ciudadano WHERE id_ciudadano = ?";
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
    
    public function insertar($nombres, $apellidos, $sexo, $fecha_nacimiento, $dui, $hospital, $lugar_nacimiento, $hora_nacimiento, $nombre_padre, $nombre_madre) {
        $sql = "INSERT INTO Ciudadano (nombres, apellidos, sexo, fecha_nacimiento, DUI, hospital, lugar_nacimiento, hora_nacimiento, nombre_padre, nombre_madre) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ssssssssss", $nombres, $apellidos, $sexo, $fecha_nacimiento, $dui, $hospital, $lugar_nacimiento, $hora_nacimiento, $nombre_padre, $nombre_madre);
            if ($stmt->execute()) {
                return $this->conn->insert_id;
            }
        }
        return false;
    }

    public function contarCiudadanos() {
        $sql = "SELECT COUNT(*) as total FROM Ciudadano";
        $result = $this->conn->query($sql);
        if ($result && $row = $result->fetch_assoc()) {
            return $row['total'];
        }
        return 0;
    }
}
?>
