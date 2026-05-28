<?php
require_once __DIR__ . '/../config/conexion.php';

class CiudadanoModel {
    private $conn;

    public function __construct() {
        $database = new Conexion();
        $this->conn = $database->conectar();
    }

    public function obtenerTodos() {
        $sql = "SELECT * FROM Ciudadano";
        try {
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return array();
        }
    }
    
    public function buscar($query) {
        $queryParam = "%" . $query . "%";
        $sql = "SELECT c.*, p.id_partida, d.id_carta, m.id_carnet, d.fecha_defuncion, d.nombre_declarante, t.id_testamento, t.nombre_heredero
                FROM ciudadano c 
                LEFT JOIN partida_nacimiento p ON c.id_ciudadano = p.id_ciudadano 
                LEFT JOIN carta_defuncion d ON c.id_ciudadano = d.id_ciudadano
                LEFT JOIN carnet_menoridad m ON c.id_ciudadano = m.id_ciudadano
                LEFT JOIN testamentos t ON (c.DUI = t.dui_testador AND c.DUI != '') OR (CONCAT(c.nombres, ' ', c.apellidos) = t.nombre_testador)
                
                WHERE c.nombres LIKE :query OR c.apellidos LIKE :query OR c.DUI LIKE :query
                GROUP BY c.id_ciudadano";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':query', $queryParam);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return array();
        }
    }
    
    public function obtenerPorId($id) {
        $sql = "SELECT * FROM Ciudadano WHERE id_ciudadano = :id";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }
    
    public function insertar($nombres, $apellidos, $sexo, $fecha_nacimiento, $dui, $hospital, $lugar_nacimiento, $hora_nacimiento, $nombre_padre, $nombre_madre) {
        $sql = "INSERT INTO Ciudadano (nombres, apellidos, sexo, fecha_nacimiento, DUI, hospital, lugar_nacimiento, hora_nacimiento, nombre_padre, nombre_madre) 
                VALUES (:nombres, :apellidos, :sexo, :fecha_nacimiento, :dui, :hospital, :lugar_nacimiento, :hora_nacimiento, :nombre_padre, :nombre_madre)";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':nombres', $nombres);
            $stmt->bindParam(':apellidos', $apellidos);
            $stmt->bindParam(':sexo', $sexo);
            $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
            $stmt->bindParam(':dui', $dui);
            $stmt->bindParam(':hospital', $hospital);
            $stmt->bindParam(':lugar_nacimiento', $lugar_nacimiento);
            $stmt->bindParam(':hora_nacimiento', $hora_nacimiento);
            $stmt->bindParam(':nombre_padre', $nombre_padre);
            $stmt->bindParam(':nombre_madre', $nombre_madre);
            
            if ($stmt->execute()) {
                return $this->conn->lastInsertId();
            }
        } catch (PDOException $e) {
            return false;
        }
        return false;
    }

    public function contarCiudadanos() {
        $sql = "SELECT COUNT(*) as total FROM Ciudadano";
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

