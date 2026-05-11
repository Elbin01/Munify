<?php
$host = "127.0.0.1";
$port = "3308";
$user = "root";
$password = "";
$dbname = "Munify";

$conn = new mysqli($host, $user, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
$conn->set_charset("utf8");
?>
