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
}
?>
