<?php
require_once '../config/Conexion.php';

class Usuario {
    private $conn;

    public function __construct() {
        $conexion = new Conexion();
        $this->conn = $conexion->conectar();
    }

    public function login($usuario, $password) {
        $sql = "SELECT * FROM Usuario WHERE nombre = :usuario OR correo = :usuario";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($user) {
            if($password === $user['password'] || $password === $user['clave'] || $password === $user['contrasena']) {
                return $user;
            }
        }
        
        return false;
    }

    public function listarTodos() {
        $sql = "SELECT u.*, r.nombre as rol FROM usuario u LEFT JOIN rol r ON u.id_rol = r.id_rol";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM Usuario WHERE id_usuario = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($nombre, $correo, $password, $id_rol = 2) {
        $sql = "INSERT INTO Usuario (nombre, correo, password, id_rol) VALUES (:nombre, :correo, :password, :id_rol)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':nombre' => $nombre,
            ':correo' => $correo,
            ':password' => $password,
            ':id_rol' => $id_rol
        ]);
    }

    public function actualizar($id, $nombre, $correo, $password = null) {
        if ($password) {
            $sql = "UPDATE Usuario SET nombre = :nombre, correo = :correo, password = :password WHERE id_usuario = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([':nombre' => $nombre, ':correo' => $correo, ':password' => $password, ':id' => $id]);
        } else {
            $sql = "UPDATE Usuario SET nombre = :nombre, correo = :correo WHERE id_usuario = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([':nombre' => $nombre, ':correo' => $correo, ':id' => $id]);
        }
    }

    public function eliminar($id) {
        $sql = "DELETE FROM Usuario WHERE id_usuario = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function buscarDocumentos($termino) {
        $resultados = [];
        $termino = "%$termino%";

        // Buscar Partidas de Nacimiento
        $sql = "SELECT 'Partida de Nacimiento' as tipo, p.numero_partida as id_doc, c.nombres, c.apellidos, p.fecha_emision 
                FROM partida_nacimiento p 
                JOIN ciudadano c ON p.id_ciudadano = c.id_ciudadano 
                WHERE c.nombres LIKE :t OR c.apellidos LIKE :t OR p.numero_partida LIKE :t";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':t' => $termino]);
        $resultados = array_merge($resultados, $stmt->fetchAll(PDO::FETCH_ASSOC));

        // Buscar Cartas de Defunción
        $sql = "SELECT 'Carta de Defunción' as tipo, d.id_carta as id_doc, c.nombres, c.apellidos, d.fecha_emision 
                FROM carta_defuncion d 
                JOIN ciudadano c ON d.id_ciudadano = c.id_ciudadano 
                WHERE c.nombres LIKE :t OR c.apellidos LIKE :t OR c.DUI LIKE :t";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':t' => $termino]);
        $resultados = array_merge($resultados, $stmt->fetchAll(PDO::FETCH_ASSOC));

        // Buscar Carnets de Minoridad
        $sql = "SELECT 'Carnet de Minoridad' as tipo, m.numero_carnet as id_doc, c.nombres, c.apellidos, m.fecha_emision 
                FROM carnet_menoridad m 
                JOIN ciudadano c ON m.id_ciudadano = c.id_ciudadano 
                WHERE c.nombres LIKE :t OR c.apellidos LIKE :t OR m.numero_carnet LIKE :t";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':t' => $termino]);
        $resultados = array_merge($resultados, $stmt->fetchAll(PDO::FETCH_ASSOC));

        return $resultados;
    }
}
?>
