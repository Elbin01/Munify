<?php
require_once __DIR__ . '/../config/conexion.php';

class TramiteModel {
    private $conn;

    public function __construct() {
        $database = new Conexion();
        $this->conn = $database->conectar();
    }

    public function obtenerTiposTramite() {
        $sql = "SELECT * FROM Tipo_Tramite";
        try {
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
}
?>
