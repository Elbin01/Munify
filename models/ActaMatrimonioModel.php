<?php
require_once __DIR__ . '/../config/conexion.php';

class ActaMatrimonioModel {
    private $conn;

    public function __construct() {
        $database = new Conexion();
        $this->conn = $database->conectar();
    }

    public function registrarActa($datos) {
        $sql = "INSERT INTO acta_matrimonio (
                    numero_acta, libro, folio,
                    novio_nombre_completo, novio_edad, novio_profesion, novio_nacionalidad, novio_dui, novio_domicilio,
                    novia_nombre_completo, novia_edad, novia_profesion, novia_nacionalidad, novia_dui, novia_domicilio,
                    regimen_patrimonial, fecha_matrimonio, hora_matrimonio,
                    nombre_oficial, cargo_oficial, testigo1_nombre, testigo2_nombre
                ) VALUES (
                    :numero_acta, :libro, :folio,
                    :novio_nombre_completo, :novio_edad, :novio_profesion, :novio_nacionalidad, :novio_dui, :novio_domicilio,
                    :novia_nombre_completo, :novia_edad, :novia_profesion, :novia_nacionalidad, :novia_dui, :novia_domicilio,
                    :regimen_patrimonial, :fecha_matrimonio, :hora_matrimonio,
                    :nombre_oficial, :cargo_oficial, :testigo1_nombre, :testigo2_nombre
                )";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':numero_acta' => $datos['numero_acta'],
                ':libro' => $datos['libro'],
                ':folio' => $datos['folio'],
                ':novio_nombre_completo' => $datos['novio_nombre_completo'],
                ':novio_edad' => $datos['novio_edad'],
                ':novio_profesion' => $datos['novio_profesion'],
                ':novio_nacionalidad' => $datos['novio_nacionalidad'],
                ':novio_dui' => $datos['novio_dui'],
                ':novio_domicilio' => $datos['novio_domicilio'],
                ':novia_nombre_completo' => $datos['novia_nombre_completo'],
                ':novia_edad' => $datos['novia_edad'],
                ':novia_profesion' => $datos['novia_profesion'],
                ':novia_nacionalidad' => $datos['novia_nacionalidad'],
                ':novia_dui' => $datos['novia_dui'],
                ':novia_domicilio' => $datos['novia_domicilio'],
                ':regimen_patrimonial' => $datos['regimen_patrimonial'],
                ':fecha_matrimonio' => $datos['fecha_matrimonio'],
                ':hora_matrimonio' => $datos['hora_matrimonio'],
                ':nombre_oficial' => $datos['nombre_oficial'],
                ':cargo_oficial' => $datos['cargo_oficial'],
                ':testigo1_nombre' => $datos['testigo1_nombre'],
                ':testigo2_nombre' => $datos['testigo2_nombre']
            ]);
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function obtenerActaPorId($id) {
        $sql = "SELECT * FROM acta_matrimonio WHERE id_acta = :id";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function obtenerTodas() {
        $sql = "SELECT id_acta, numero_acta, fecha_matrimonio, 
                       novio_nombre_completo, novio_dui,
                       novia_nombre_completo, novia_dui,
                       fecha_registro 
                FROM acta_matrimonio 
                ORDER BY fecha_registro DESC";
        try {
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
}
?>
