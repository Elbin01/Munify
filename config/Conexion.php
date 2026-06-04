<?php
class Conexion {
    private $host = '127.0.0.1'; 
    private $port = '3308'; // Tu puerto actual
    private $db_name = 'bdd_munify';
    private $username = 'root';
    private $password = '';
    public $conn;

    public function conectar() {
        $this->conn = null;
        try {
            // Intentamos la conexión usando host y puerto por separado
            $dsn = "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name . ";charset=utf8";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            // Error silencioso en producción, pero útil para depurar
            error_log("Error de conexión: " . $exception->getMessage());
            $this->conn = null;
        }
        return $this->conn;
    }
}
?>