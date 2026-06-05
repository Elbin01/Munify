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
    public function getCitasPorMes($inicio = null, $fin = null) {
        $where = "YEAR(fecha_cita) = YEAR(CURRENT_DATE())";
        if ($inicio && $fin) {
            $where = "DATE(fecha_cita) BETWEEN :inicio AND :fin";
        }
        $sql = "SELECT MONTH(fecha_cita) as mes_num, MONTHNAME(fecha_cita) as mes_nombre, COUNT(*) as total 
                FROM Cita 
                WHERE $where
                GROUP BY MONTH(fecha_cita)
                ORDER BY MONTH(fecha_cita) ASC";
        try {
            $stmt = $this->conn->prepare($sql);
            if ($inicio && $fin) {
                $stmt->bindParam(':inicio', $inicio);
                $stmt->bindParam(':fin', $fin);
            }
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return array();
        }
    }

    /**
     * Obtiene la distribución de trámites por tipo
     */
    public function getDistribucionTramites($inicio = null, $fin = null) {
        $condPartida = "";
        $condDefuncion = "";
        $condMenoridad = "";
        
        if ($inicio && $fin) {
            $condPartida = " WHERE DATE(fecha_emision) BETWEEN :inicio AND :fin";
            $condDefuncion = " WHERE DATE(fecha_emision) BETWEEN :inicio AND :fin";
            $condMenoridad = " WHERE DATE(fecha_emision) BETWEEN :inicio AND :fin";
            $condMatrimonio = " WHERE DATE(fecha_registro) BETWEEN :inicio AND :fin";
        } else {
            $condMatrimonio = "";
        }

        $sql = "SELECT 
                    t.nombre AS tramite,
                    CASE 
                        WHEN t.id_tipo = 1 THEN (SELECT COUNT(*) FROM Partida_Nacimiento $condPartida)
                        WHEN t.id_tipo = 2 THEN (SELECT COUNT(*) FROM Carta_Defuncion $condDefuncion)
                        WHEN t.id_tipo = 3 THEN (SELECT COUNT(*) FROM Carnet_Menoridad $condMenoridad)
                        WHEN t.id_tipo = 5 THEN (SELECT COUNT(*) FROM acta_matrimonio $condMatrimonio)
                        ELSE 0
                    END AS total
                FROM Tipo_Tramite t";
        try {
            $stmt = $this->conn->prepare($sql);
            if ($inicio && $fin) {
                $stmt->bindParam(':inicio', $inicio);
                $stmt->bindParam(':fin', $fin);
            }
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return array();
        }
    }

    /**
     * Obtiene la demanda de citas por día de la semana y hora para un Heatmap
     */
    public function getDemandaHeatmap($inicio = null, $fin = null) {
        $where = "";
        if ($inicio && $fin) {
            $where = "WHERE DATE(fecha_cita) BETWEEN :inicio AND :fin";
        }
        $sql = "SELECT DAYNAME(fecha_cita) as dia, HOUR(hora_cita) as hora, COUNT(*) as total 
                FROM Cita 
                $where
                GROUP BY DAYNAME(fecha_cita), HOUR(hora_cita)
                ORDER BY FIELD(dia, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'), hora ASC";
        try {
            $stmt = $this->conn->prepare($sql);
            if ($inicio && $fin) {
                $stmt->bindParam(':inicio', $inicio);
                $stmt->bindParam(':fin', $fin);
            }
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return array();
        }
    }

    /**
     * Obtiene comparativa de trámites emitidos (Partidas) por mes
     */
    public function getPartidasPorMes($inicio = null, $fin = null) {
        $where = "YEAR(fecha_emision) = YEAR(CURRENT_DATE())";
        if ($inicio && $fin) {
            $where = "DATE(fecha_emision) BETWEEN :inicio AND :fin";
        }
        $sql = "SELECT MONTH(fecha_emision) as mes_num, COUNT(*) as total 
                FROM Partida_Nacimiento 
                WHERE $where
                GROUP BY MONTH(fecha_emision)
                ORDER BY MONTH(fecha_emision) ASC";
        try {
            $stmt = $this->conn->prepare($sql);
            if ($inicio && $fin) {
                $stmt->bindParam(':inicio', $inicio);
                $stmt->bindParam(':fin', $fin);
            }
            $stmt->execute();
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