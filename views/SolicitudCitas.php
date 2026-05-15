<?php 
session_start(); 
require_once '../models/TramiteModel.php';
$tramiteModel = new TramiteModel();
$tipos = $tramiteModel->obtenerTiposTramite();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud de Trámites - Munify</title>
    <!-- Fonts -->
    <?php include 'layouts/fonts.php'; ?>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <style>
        :root {
            --munify-blue: #1C3166;
        }

        body { 
            width: 100%; 
            min-height: 100vh; 
            background: linear-gradient(rgba(244, 247, 250, 0.75), rgba(244, 247, 250, 0.75)), 
                        url('https://plus.unsplash.com/premium_photo-1683309563514-aff14da6c40d?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            padding: 1rem;
            overflow: hidden;
            font-family: 'Poppins', sans-serif;
        }

        .modal-style-card {
            background: white;
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 40px rgba(28, 49, 102, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 800px;
            margin-bottom: 2rem;
        }

        .modal-style-header {
            background-color: var(--munify-blue);
            padding: 1.8rem 2rem;
            color: white;
            display: flex;
            align-items: center;
            gap: 1.2rem;
        }

        .back-link {
            color: var(--munify-blue);
            text-decoration: none;
            font-weight: 700;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s;
            height: fit-content;
            margin-top: 2rem;
            opacity: 0.8;
        }

        .back-link:hover {
            transform: translateX(-5px);
            opacity: 1;
            color: var(--munify-blue);
        }

        .modal-style-header h5 {
            margin: 0;
            font-weight: 700;
            font-size: 1.3rem;
            letter-spacing: 0.5px;
        }

        .form-section-divider {
            border-bottom: 2px solid #eef2f7;
            padding-bottom: 0.6rem;
            margin-bottom: 1.8rem;
            color: var(--munify-blue);
            font-weight: 800;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .form-label {
            font-weight: 700;
            font-size: 0.85rem;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }

        .form-control, .form-select {
            padding: 0.8rem 1.1rem;
            border-radius: 10px;
            border: 1.5px solid #e2e8f0;
            font-size: 0.95rem;
            color: #334155;
            transition: all 0.3s;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--munify-blue);
            box-shadow: 0 0 0 4px rgba(28, 49, 102, 0.1);
            outline: none;
        }

        .btn-modal-action {
            background-color: var(--munify-blue);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 10px;
            font-weight: 700;
            font-size: 1.05rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            width: 100%;
            margin-top: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.8rem;
        }

        .btn-modal-action:hover {
            background-color: #15254d;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(28, 49, 102, 0.25);
            color: white;
        }

        .dynamic-fields {
            display: none;
        }
        
        .dynamic-fields.active {
            display: block;
            animation: fadeIn 0.4s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .back-link {
            color: var(--munify-blue);
            text-decoration: none;
            font-weight: 700;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s;
            height: fit-content;
            margin-top: 1.5rem;
            opacity: 0.8;
        }

        .back-link:hover {
            transform: translateX(-5px);
            opacity: 1;
            color: var(--munify-blue);
        }


    </style>
</head>
<body>

    <div class="d-flex align-items-start justify-content-center gap-4 w-100 flex-wrap flex-md-nowrap px-3 mt-3">
        <a href="../index.php" class="back-link">
            <i class="bi bi-arrow-left"></i> VOLVER
        </a>

        <div class="modal-style-card">
            <div class="modal-style-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <i class="bi bi-file-earmark-plus fs-3"></i>
                    <h5>SOLICITUD DE TRÁMITE INSTITUCIONAL</h5>
                </div>
                <button type="button" class="btn btn-light rounded-circle p-0 d-flex align-items-center justify-content-center shadow-sm" data-bs-toggle="modal" data-bs-target="#modalAyudaHorarios" style="width: 32px; height: 32px; background-color: rgba(255,255,255,0.9); border: none;">
                    <i class="bi bi-info-lg" style="color: var(--munify-blue); font-size: 1.1rem;"></i>
                </button>
            </div>

        <div class="p-4 p-md-5">
            <form id="formCita" action="../controller/GuardarTramite.php" method="POST" enctype="multipart/form-data">
                
                <!-- Sección 1: Selección Global y Fecha -->
                <div class="mb-4">
                    <h6 class="form-section-divider"><i class="bi bi-gear-fill"></i> Configuración del Trámite</h6>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">¿Qué tipo de trámite desea realizar?</label>
                            <select name="tipo_tramite" id="tipoTramite" class="form-select bg-light" required>
                                <option value="" disabled selected>Seleccione una opción oficial...</option>
                                <?php foreach ($tipos as $t): ?>
                                    <?php 
                                        $val = '';
                                        if (stripos($t['nombre'], 'partida') !== false) $val = 'partida';
                                        elseif (stripos($t['nombre'], 'defuncion') !== false) $val = 'defuncion';
                                        elseif (stripos($t['nombre'], 'minoridad') !== false) $val = 'minoridad';
                                    ?>
                                    <option value="<?= $val ?>"><?= $t['nombre'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Fecha de Cita</label>
                            <input type="date" name="fecha_cita" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Hora de Cita</label>
                            <input type="time" name="hora_cita" class="form-control" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Nombre Completo del Solicitante</label>
                            <input type="text" name="nombre_solicitante" class="form-control" placeholder="Ej: Juan Pérez" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Correo Electrónico</label>
                            <input type="email" name="correo" class="form-control" placeholder="usuario@correo.com" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Teléfono de Contacto</label>
                            <input type="tel" name="telefono" class="form-control" placeholder="0000-0000" required>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn-modal-action">
                        <i class="bi bi-send-check-fill"></i> ENVIAR SOLICITUD A REVISIÓN
                    </button>
                    <p class="text-center text-muted small mt-3">
                        <i class="bi bi-info-circle me-1"></i> Al enviar, sus datos serán procesados por la Alcaldía Municipal de acuerdo a la Ley de Protección de Datos.
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>

    <!-- Modal de Ayuda de Horarios -->
    <div class="modal fade" id="modalAyudaHorarios" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0" style="border-radius: 20px;">
                <div class="modal-header border-0 pb-0 justify-content-center pt-4">
                    <i class="bi bi-clock-history" style="color: var(--munify-blue); font-size: 3rem;"></i>
                </div>
                <div class="modal-body text-center p-4">
                    <h5 class="fw-bold mb-3" style="color: var(--munify-blue);">Horarios de Atención</h5>
                    <p class="text-muted">Para garantizar su atención, por favor tome en cuenta los siguientes horarios oficiales:</p>
                    
                    <div class="bg-light p-3 rounded-3 mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="fw-bold">Días:</span>
                            <span>Lunes a Viernes</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold">Horario:</span>
                            <span>08:00 AM - 04:00 PM</span>
                        </div>
                    </div>
                    
                    <p class="small text-muted">
                        <i class="bi bi-info-circle me-1"></i> No se procesan solicitudes los fines de semana o fuera de la jornada laboral.
                    </p>
                    
                    <button type="button" class="btn btn-primary w-100 fw-bold mt-3 py-2" data-bs-dismiss="modal" style="background-color: var(--munify-blue); border-radius: 12px;">
                        ENTENDIDO
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- JS Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('formCita');
            const telefono = document.querySelector('input[name="telefono"]');
            const fechaCita = document.querySelector('input[name="fecha_cita"]');
            const horaCita = document.querySelector('input[name="hora_cita"]');

            // Establecer fecha mínima como hoy
            const today = new Date().toISOString().split('T')[0];
            fechaCita.setAttribute('min', today);

            // Máscara para teléfono (0000-0000)
            telefono.addEventListener('input', function(e) {
                let x = e.target.value.replace(/\D/g, '').match(/(\d{0,4})(\d{0,4})/);
                e.target.value = !x[2] ? x[1] : x[1] + '-' + x[2];
            });

            form.addEventListener('submit', function(e) {
                const dateVal = new Date(fechaCita.value + 'T00:00:00');
                const day = dateVal.getUTCDay(); // 0=Dom, 1=Lun, ..., 6=Sab
                const timeVal = horaCita.value;
                const phoneVal = telefono.value;

                // Validar Teléfono
                if (!/^\d{4}-\d{4}$/.test(phoneVal)) {
                    alert('Por favor, ingrese un número de teléfono válido (0000-0000).');
                    e.preventDefault();
                    return;
                }

                // Validar Días (Lunes a Viernes)
                if (day === 0 || day === 6) {
                    alert('Las citas solo están disponibles de Lunes a Viernes.');
                    e.preventDefault();
                    return;
                }

                // Validar Horas (08:00 - 16:00)
                if (timeVal < "08:00" || timeVal > "16:00") {
                    alert('El horario de atención es de 8:00 AM a 4:00 PM.');
                    e.preventDefault();
                    return;
                }
            });
        });
    </script>
</body>
</html>