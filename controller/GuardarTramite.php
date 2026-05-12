<?php
session_start();
require_once '../config/Conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conexion = new Conexion();
    $conn = $conexion->conectar();
    
    if (!$conn) {
        die("Error de conexión a la base de datos.");
    }

    $tipo = $_POST['tipo_tramite'] ?? '';
    $id_usuario = $_SESSION['usuario_id'] ?? 1; 
    
    try {
        $conn->beginTransaction();

        if ($tipo === 'partida') {
            $stmt = $conn->prepare("INSERT INTO ciudadano (nombres, apellidos, sexo, fecha_nacimiento, lugar_nacimiento, hora_nacimiento, nombre_padre, nombre_madre) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $nombres_completos = explode(" ", $_POST['p_nombre_inscrito']);
            $nombres = $nombres_completos[0] ?? '';
            $apellidos = isset($nombres_completos[1]) ? implode(" ", array_slice($nombres_completos, 1)) : '';
            
            $stmt->execute([
                $nombres,
                $apellidos,
                ($_POST['p_sexo'] == 'Masculino') ? 'M' : 'F',
                $_POST['p_fecha_nac'],
                $_POST['p_lugar_nac'],
                $_POST['p_hora_nac'],
                $_POST['p_nombre_padre'],
                $_POST['p_nombre_madre']
            ]);
            $id_ciudadano = $conn->lastInsertId();

            $stmt = $conn->prepare("INSERT INTO partida_nacimiento (id_ciudadano, numero_partida, libro, folio) VALUES (?, ?, ?, ?)");
            $stmt->execute([$id_ciudadano, rand(1000, 9999), rand(1, 100), rand(1, 500)]);

            $stmt = $conn->prepare("INSERT INTO cita (id_usuario, id_tipo, fecha_cita, hora_cita, estado) VALUES (?, 1, CURDATE(), CURTIME(), 'confirmada')");
            $stmt->execute([$id_usuario]);

            $conn->commit();
            include '../views/Partida nacimiento.PHP';
            exit();

        } elseif ($tipo === 'defuncion') {
            $stmt = $conn->prepare("INSERT INTO ciudadano (nombres, apellidos, DUI) VALUES (?, ?, ?)");
            $nombres_completos = explode(" ", $_POST['d_nombre_fallecido']);
            $nombres = $nombres_completos[0] ?? '';
            $apellidos = isset($nombres_completos[1]) ? implode(" ", array_slice($nombres_completos, 1)) : '';
            $stmt->execute([$nombres, $apellidos, $_POST['d_dui']]);
            $id_ciudadano = $conn->lastInsertId();

            $stmt = $conn->prepare("INSERT INTO carta_defuncion (id_ciudadano, fecha_defuncion, causa, nombre_declarante) VALUES (?, ?, ?, ?)");
            $stmt->execute([
                $id_ciudadano,
                $_POST['d_fecha_defuncion'],
                'Causas Naturales', 
                $_POST['d_nombre_declarante']
            ]);

            $stmt = $conn->prepare("INSERT INTO cita (id_usuario, id_tipo, fecha_cita, hora_cita, estado) VALUES (?, 2, CURDATE(), CURTIME(), 'confirmada')");
            $stmt->execute([$id_usuario]);

            $conn->commit();
            include '../views/CartaDefuncion.php';
            exit();

        } elseif ($tipo === 'minoridad') {
            $fotoPath = '';
            if (isset($_FILES['m_foto']) && $_FILES['m_foto']['error'] == 0) {
                $uploadDir = '../assets/uploads/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $fileName = time() . '_' . basename($_FILES['m_foto']['name']);
                $targetFilePath = $uploadDir . $fileName;
                if (move_uploaded_file($_FILES['m_foto']['tmp_name'], $targetFilePath)) {
                    $fotoPath = $targetFilePath;
                    $_POST['m_foto_path'] = $fotoPath; 
                }
            }

            $stmt = $conn->prepare("INSERT INTO ciudadano (nombres, apellidos, fecha_nacimiento, lugar_nacimiento, nombre_padre, nombre_madre) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $_POST['m_nombres'],
                $_POST['m_apellidos'],
                $_POST['m_fecha_nac'],
                $_POST['m_lugar_nac'],
                $_POST['m_nombre_padre'],
                $_POST['m_nombre_madre']
            ]);
            $id_ciudadano = $conn->lastInsertId();

            $stmt = $conn->prepare("INSERT INTO carnet_menoridad (id_ciudadano, numero_carnet, fecha_vencimiento, lugar_estudio, color_piel, color_ojos, color_cabello, senales_especiales) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $numero_carnet = '0601-' . rand(100000, 999999);
            $fecha_vencimiento = date('Y-m-d', strtotime('+3 years'));
            $stmt->execute([
                $id_ciudadano,
                $numero_carnet,
                $fecha_vencimiento,
                $_POST['m_centro_estudios'],
                $_POST['m_color_piel'],
                $_POST['m_color_ojos'],
                $_POST['m_color_cabello'],
                $_POST['m_senales_especiales']
            ]);

            $stmt = $conn->prepare("INSERT INTO cita (id_usuario, id_tipo, fecha_cita, hora_cita, estado) VALUES (?, 3, CURDATE(), CURTIME(), 'confirmada')");
            $stmt->execute([$id_usuario]);

            $conn->commit();
            include '../views/Carnet minoridad.php';
            exit();
        }
        
    } catch (Exception $e) {
        $conn->rollBack();
        die("Error al guardar en base de datos: " . $e->getMessage());
    }

} else {
    die("Acceso denegado.");
}
?>