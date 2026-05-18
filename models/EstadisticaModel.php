<?php
require_once __DIR__ . '/../config/conexion.php';

class EstadisticaModel {
    private $conn;

    public function __construct() {
        $database = new Conexion();
        $this->conn = $database->conectar();
    }

    /**
     * Obtiene el total de citas agrupadas por mes para el año actual
     */
    public function getCitasPorMes() {
        $sql = "SELECT MONTH(fecha_cita) as mes_num, MONTHNAME(fecha_cita) as mes_nombre, COUNT(*) as total 
                FROM Cita 
                WHERE YEAR(fecha_cita) = YEAR(CURRENT_DATE())
                GROUP BY MONTH(fecha_cita)
                ORDER BY MONTH(fecha_cita) ASC";
        try {
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return array();
        }
    }

    /**
     * Obtiene la distribución de trámites por tipo
     */
    public function getDistribucionTramites() {
        $sql = "SELECT 
                    t.nombre AS tramite,
                    CASE 
                        WHEN t.id_tipo = 1 THEN (SELECT COUNT(*) FROM Partida_Nacimiento)
                        WHEN t.id_tipo = 2 THEN (SELECT COUNT(*) FROM Carta_Defuncion)
                        WHEN t.id_tipo = 3 THEN (SELECT COUNT(*) FROM Carnet_Menoridad)
                        ELSE 0
                    END AS total
                FROM Tipo_Tramite t";
        try {
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return array();
        }
    }

    /**
     * Obtiene la demanda de citas por día de la semana y hora para un Heatmap
     */
    public function getDemandaHeatmap() {
        $sql = "SELECT DAYNAME(fecha_cita) as dia, HOUR(hora_cita) as hora, COUNT(*) as total 
                FROM Cita 
                GROUP BY DAYNAME(fecha_cita), HOUR(hora_cita)
                ORDER BY FIELD(dia, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'), hora ASC";
        try {
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return array();
        }
    }

    /**
     * Obtiene comparativa de trámites emitidos (Partidas) por mes
     */
    public function getPartidasPorMes() {
        $sql = "SELECT MONTH(fecha_emision) as mes_num, COUNT(*) as total 
                FROM Partida_Nacimiento 
                WHERE YEAR(fecha_emision) = YEAR(CURRENT_DATE())
                GROUP BY MONTH(fecha_emision)
                ORDER BY MONTH(fecha_emision) ASC";
        try {
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return array();
        }
    }
    /**
     * Obtiene demografía de ciudadanos (Adultos vs Menores)
     */
    public function getDemografiaCiudadanos() {
        $sql = "SELECT 
                    SUM(CASE WHEN TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) >= 18 THEN 1 ELSE 0 END) AS adultos,
                    SUM(CASE WHEN TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) < 18 THEN 1 ELSE 0 END) AS menores
                FROM Ciudadano
                WHERE fecha_nacimiento IS NOT NULL";
        try {
            $stmt = $this->conn->query($sql);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return [
                'Adultos' => (int)($result['adultos'] ?? 0),
                'Menores' => (int)($result['menores'] ?? 0)
            ];
        } catch (PDOException $e) {
            return ['Adultos' => 0, 'Menores' => 0];
        }
    }
}
?>