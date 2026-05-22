<?php
$es_secretaria_notificaciones = isset($_SESSION['rol']) && (int) $_SESSION['rol'] === 1;
$solicitudes_pendientes_notificaciones = 0;
$solicitudes_pendientes_lista = [];

if ($es_secretaria_notificaciones) {
    require_once __DIR__ . '/../../models/CitaModel.php';
    $citaModelNotificaciones = new CitaModel();
    $solicitudes_pendientes_notificaciones = (int) $citaModelNotificaciones->contarPendientes();
    $solicitudes_pendientes_lista = $citaModelNotificaciones->obtenerCitasSolicitadas(5);
}
?>

<?php if ($es_secretaria_notificaciones): ?>
<link rel="stylesheet" href="../assets/css/secretary_notifications.css?v=<?= time() ?>">

<div class="secretary-notification-widget">
    <button type="button" class="secretary-notification-bubble" aria-label="<?= $solicitudes_pendientes_notificaciones ?> solicitudes pendientes">
        <span class="secretary-notification-icon">
            <i class="bi bi-bell-fill"></i>
            <?php if ($solicitudes_pendientes_notificaciones > 0): ?>
                <span class="secretary-notification-count"><?= $solicitudes_pendientes_notificaciones > 99 ? '99+' : $solicitudes_pendientes_notificaciones ?></span>
            <?php endif; ?>
        </span>
    </button>

    <div class="secretary-notification-tooltip" role="tooltip">
        <div class="secretary-notification-header">
            <div>
                <span class="secretary-notification-kicker">Solicitudes</span>
                <h6 class="secretary-notification-title">Citas pendientes</h6>
            </div>
            <span class="secretary-notification-total"><?= $solicitudes_pendientes_notificaciones ?></span>
        </div>

        <?php if (!empty($solicitudes_pendientes_lista)): ?>
            <div class="secretary-notification-list">
                <?php foreach ($solicitudes_pendientes_lista as $solicitud): ?>
                    <?php
                        $nombreSolicitante = htmlspecialchars($solicitud['usuario_nombre'] ?? 'Solicitante', ENT_QUOTES, 'UTF-8');
                        $tramiteSolicitud = htmlspecialchars($solicitud['tramite_nombre'] ?? 'Trámite', ENT_QUOTES, 'UTF-8');
                        $fechaSolicitud = !empty($solicitud['fecha_cita']) ? date('d/m/Y', strtotime($solicitud['fecha_cita'])) : 'Sin fecha';
                        $horaSolicitud = !empty($solicitud['hora_cita']) ? date('h:i A', strtotime($solicitud['hora_cita'])) : 'Sin hora';
                    ?>
                    <a href="recepcion_citas.php" class="secretary-notification-item text-decoration-none">
                        <span class="secretary-notification-item-icon">
                            <i class="bi bi-calendar-event"></i>
                        </span>
                        <span class="secretary-notification-item-body">
                            <strong><?= $nombreSolicitante ?></strong>
                            <small><?= $tramiteSolicitud ?></small>
                            <em><?= $fechaSolicitud ?> · <?= $horaSolicitud ?></em>
                        </span>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="secretary-notification-empty">
                <i class="bi bi-check2-circle"></i>
                <span>No hay solicitudes pendientes.</span>
            </div>
        <?php endif; ?>

        <a href="recepcion_citas.php" class="secretary-notification-action text-decoration-none">
            Ver todas las solicitudes
            <i class="bi bi-arrow-right-short"></i>
        </a>
    </div>
</div>
<?php endif; ?>
