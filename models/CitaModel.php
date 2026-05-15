<?php
require_once __DIR__ . '/../config/conexion.php';

class CitaModel {
    private $conn;

    public function __construct() {
        $database = new Conexion();
        $this->conn = $database->conectar();
    }

    /**
     * Cuenta todas las citas con estado 'pendiente'
     */
    public function contarPendientes() {
        $sql = "SELECT COUNT(*) as total FROM Cita WHERE estado = 'pendiente'";
        try {
            $stmt = $this->conn->query($sql);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total'] ?? 0;
        } catch (PDOException $e) {
            return 0;
        }
    }

    /**
     * Obtiene las citas próximas (solicitadas) con el nombre del usuario y tipo de trámite
     */
    public function obtenerCitasSolicitadas($limite = 3) {
        $sql = "SELECT c.*, u.nombre as usuario_nombre, t.nombre as tramite_nombre 
                FROM Cita c 
                JOIN Usuario u ON c.id_usuario = u.id_usuario 
                JOIN Tipo_Tramite t ON c.id_tipo = t.id_tipo 
                WHERE c.estado = 'pendiente' 
                ORDER BY c.fecha_cita ASC, c.hora_cita ASC 
                LIMIT :limite";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return array();
        }
    }
    /**
     * Crea una nueva cita en estado pendiente
     */
    public function crearCita($id_usuario, $id_tipo, $fecha_cita, $hora_cita, $correo) {
        $sql = "INSERT INTO Cita (id_usuario, id_tipo, fecha_cita, hora_cita, correo_contacto, estado) 
                VALUES (:id_usuario, :id_tipo, :fecha_cita, :hora_cita, :correo, 'pendiente')";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->bindParam(':id_tipo', $id_tipo, PDO::PARAM_INT);
            $stmt->bindParam(':fecha_cita', $fecha_cita);
            $stmt->bindParam(':hora_cita', $hora_cita);
            $stmt->bindParam(':correo', $correo);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
    /**
     * Obtiene todas las citas con información de usuario y trámite
     */
    public function obtenerTodasLasCitas() {
        $sql = "SELECT c.*, u.nombre as usuario_nombre, t.nombre as tramite_nombre 
                FROM Cita c 
                JOIN Usuario u ON c.id_usuario = u.id_usuario 
                JOIN Tipo_Tramite t ON c.id_tipo = t.id_tipo 
                ORDER BY c.fecha_cita DESC, c.hora_cita DESC";
        try {
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return array();
        }
    }
    /**
     * Actualiza el estado de una cita
     */
    public function actualizarEstado($id_cita, $estado) {
        $sql = "UPDATE Cita SET estado = :estado WHERE id_cita = :id_cita";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':estado', $estado);
            $stmt->bindParam(':id_cita', $id_cita, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
    /**
     * Obtiene los detalles de una cita específica incluyendo el contacto
     */
    public function obtenerCitaConContacto($id_cita) {
        $sql = "SELECT c.*, u.nombre as usuario_nombre, t.nombre as tramite_nombre
                FROM Cita c 
                LEFT JOIN Usuario u ON c.id_usuario = u.id_usuario 
                JOIN Tipo_Tramite t ON c.id_tipo = t.id_tipo 
                WHERE c.id_cita = :id_cita";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_cita', $id_cita, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }
}
?>
