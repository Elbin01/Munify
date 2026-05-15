<?php
require_once '../models/CitaModel.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $estado = $_POST['estado'] ?? null;

    if ($id && $estado) {
        $model = new CitaModel();
        if ($model->actualizarEstado($id, $estado)) {
            
            // Si el estado es confirmada, enviar correo
            if ($estado === 'confirmada') {
                require_once '../helpers/EmailHelper.php';
                $cita = $model->obtenerCitaConContacto($id);
                if ($cita && !empty($cita['correo_contacto'])) {
                    EmailHelper::enviarConfirmacionCita(
                        $cita['correo_contacto'], 
                        $cita['nombre_contacto'], 
                        [
                            'tramite' => $cita['tramite_nombre'],
                            'fecha' => $cita['fecha_cita'],
                            'hora' => $cita['hora_cita']
                        ]
                    );
                }
            }

            echo json_encode(['success' => true, 'message' => 'Estado actualizado correctamente.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar en la base de datos.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Parámetros incompletos.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
}
?>
