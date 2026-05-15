<?php
session_start();
require_once '../config/Conexion.php';
require_once '../helpers/EmailHelper.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conexion = new Conexion();
    $conn = $conexion->conectar();
    
    if (!$conn) {
        die("Error de conexión a la base de datos.");
    }

    // Captura de datos
    $tipo_string = $_POST['tipo_tramite'] ?? '';
    $nombre_solicitante = $_POST['nombre_solicitante'] ?? '';
    $fecha = $_POST['fecha_cita'] ?? '';
    $hora = $_POST['hora_cita'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $id_usuario = $_SESSION['usuario_id'] ?? 1; 

    // Mapeo de tipo (String a ID de Base de Datos)
    $id_tipo = 1; // Default
    if ($tipo_string === 'defuncion') $id_tipo = 2;
    if ($tipo_string === 'minoridad') $id_tipo = 3;

    try {
        // Validaciones de Servidor
        if (!preg_match('/^\d{4}-\d{4}$/', $telefono)) {
            die("Error: El formato de teléfono debe ser 0000-0000.");
        }

        $dia_semana = date('N', strtotime($fecha));
        if ($dia_semana > 5) {
            die("Error: Solo se pueden programar citas de lunes a viernes.");
        }

        if ($hora < '08:00' || $hora > '16:00') {
            die("Error: El horario de atención es de 8:00 AM a 4:00 PM.");
        }

        $conn->beginTransaction();

        // Insertar solo la Cita
        $sql = "INSERT INTO cita (id_usuario, id_tipo, fecha_cita, hora_cita, nombre_contacto, correo_contacto, estado) 
                VALUES (?, ?, ?, ?, ?, ?, 'pendiente')";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id_usuario, $id_tipo, $fecha, $hora, $nombre_solicitante, $correo]);

        $conn->commit();

        // Enviar correo de notificación de recibido
        $nombre_tramite = "Trámite de " . ucfirst($tipo_string);
        EmailHelper::enviarNotificacionRecibido($correo, $nombre_tramite, [
            'fecha' => $fecha,
            'hora' => $hora
        ]);

        // Redirigir al index con éxito
        header("Location: ../index.php?status=success&msg=Solicitud enviada correctamente");
        exit();

    } catch (Exception $e) {
        if ($conn->inTransaction()) {
            $conn->rollBack();
        }
        die("Error al guardar la cita: " . $e->getMessage());
    }

} else {
    die("Acceso denegado.");
}
?>