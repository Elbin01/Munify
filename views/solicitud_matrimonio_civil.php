<?php session_start(); ?>
<?php
// =============================================
//  DATOS DEL MUNICIPIO - Ajusta según tu entorno
// =============================================
$datos_municipio = [
    'alcaldia'      => $_POST['alcaldia'] ?? 'Alcaldía Municipal',
    'departamento'  => $_POST['departamento'] ?? '',
    'pais'          => 'El Salvador',
    'escudo_nacion' => '../assets/Img/escudo.jpeg',
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Solicitud de Matrimonio Civil - Munify</title>
    
    <!-- Fonts -->
    <?php include 'layouts/fonts.php'; ?>
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Text:wght@400;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/Css/index.css?v=<?= time() ?>">
    <link rel="stylesheet" href="../assets/Css/sidebar.css?v=<?= time() ?>">
    <link rel="stylesheet" href="../assets/Css/footer.css?v=<?= time() ?>">
    <link rel="stylesheet" href="../assets/Css/solicitud_matrimonio.css?v=<?= time() ?>">
</head>
<body>

    <div class="dashboard-container">
        <!-- Sidebar -->
        <?php include 'layouts/sidebar.php'; ?>

        <!-- Main Content -->
        <main class="main-content">
            <div class="container-fluid py-4 px-4">
                <div class="documento">
                    
                    <!-- HEADER -->
                    <div class="header">
                        <div class="escudo">
                            <?php if (!empty($datos_municipio['escudo_nacion'])): ?>
                                <img src="<?= htmlspecialchars($datos_municipio['escudo_nacion']) ?>" 
                                     alt="Escudo" 
                                     style="width:100%; height:100%; object-fit:contain;">
                            <?php else: ?>
                                <i class="fas fa-landmark"></i>
                            <?php endif; ?>
                        </div>

                        <div class="titulo-central">
                            <h1>ALCALDÍA MUNICIPAL DE ILOBASCO</h1>
                            <h2>DEPARTAMENTO DE CABAÑAS — EL SALVADOR</h2>
                            <span class="registro">Registro del Estado Familiar</span>
                            <h3>SOLICITUD DE MATRIMONIO CIVIL</h3>
                        </div>

                        <div style="width: 80px;"></div>
                    </div>

                    <!-- ACCIONES -->
                    <div class="acciones-header">
                        <a href="dashboard.php" class="btn-custom btn-custom-secondary">
                            <i class="fas fa-arrow-left"></i> Cancelar
                        </a>
                        <button type="submit" form="formSolicitud" class="btn-custom btn-custom-primary">
                            <i class="fas fa-save"></i> Guardar Solicitud
                        </button>
                    </div>

        <form id="formSolicitud" method="POST" action="guardar_solicitud.php">
            
            <!-- DATOS DEL MATRIMONIO -->
            <div class="seccion">
                <div class="seccion-header">
                    <i class="fas fa-ring"></i>
                    Datos del Acto Matrimonial
                </div>
                <div class="seccion-body">
                    <div class="fila">
                        <div class="campo">
                            <label>Fecha de Celebración</label>
                            <input type="date" name="fecha_matrimonio" required>
                        </div>
                        <div class="campo">
                            <label>Hora</label>
                            <input type="time" name="hora_matrimonio" value="10:00" required>
                        </div>
                        <div class="campo">
                            <label>Lugar</label>
                            <input type="text" name="lugar" placeholder="Oficina del Registro del Estado Familiar" class="letras-only">
                        </div>
                    </div>
                    <div class="fila">
                        <div class="campo full-width">
                            <label>Régimen Patrimonial</label>
                            <select name="regimen" required>
                                <option value="Sociedad Conyugal">Sociedad Conyugal</option>
                                <option value="Separación Absoluta de Bienes">Separación Absoluta de Bienes</option>
                                <option value="Separación de Bienes con Cláusula de Comunidad de Bienes Gananciales">Separación con Cláusula de Comunidad</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CONTRAYENTES -->
            <div class="dos-columnas">
                
                <!-- CONTRAYENTE HOMBRE -->
                <div class="columna">
                    <div class="seccion-header">
                        <i class="fas fa-male"></i>
                        Datos del Contrayente
                    </div>
                    <div class="seccion-body">
                        <div class="fila">
                            <div class="campo">
                                <label>Nombres</label>
                                <input type="text" name="novio_nombres" placeholder="Ej: Juan Carlos" class="letras-only" required>
                            </div>
                            <div class="campo">
                                <label>Apellidos</label>
                                <input type="text" name="novio_apellidos" placeholder="Ej: Pérez García" class="letras-only" required>
                            </div>
                        </div>
                        <div class="fila">
                            <div class="campo">
                                <label>DUI</label>
                                <input type="text" name="novio_dui" placeholder="00000000-0" pattern="\d{8}-\d" class="dui-mask" required>
                                <small>Formato: 01234567-8</small>
                            </div>
                            <div class="campo">
                                <label>Fecha de Nacimiento</label>
                                <input type="date" name="novio_fecha_nac" required>
                            </div>
                        </div>
                        <div class="fila">
                            <div class="campo">
                                <label>Nacionalidad</label>
                                <input type="text" name="novio_nacionalidad" value="Salvadoreño" class="letras-only" required>
                            </div>
                            <div class="campo">
                                <label>Profesión u Oficio</label>
                                <input type="text" name="novio_profesion" placeholder="Ej: Ingeniero" class="letras-only">
                            </div>
                        </div>
                        <div class="fila">
                            <div class="campo full-width">
                                <label>Domicilio</label>
                                <textarea name="novio_domicilio" rows="2" placeholder="Dirección completa"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CONTRAYENTE MUJER -->
                <div class="columna">
                    <div class="seccion-header">
                        <i class="fas fa-female"></i>
                        Datos de la Contrayente
                    </div>
                    <div class="seccion-body">
                        <div class="fila">
                            <div class="campo">
                                <label>Nombres</label>
                                <input type="text" name="novia_nombres" placeholder="Ej: María Elena" class="letras-only" required>
                            </div>
                            <div class="campo">
                                <label>Apellidos</label>
                                <input type="text" name="novia_apellidos" placeholder="Ej: López Hernández" class="letras-only" required>
                            </div>
                        </div>
                        <div class="fila">
                            <div class="campo">
                                <label>DUI</label>
                                <input type="text" name="novia_dui" placeholder="00000000-0" pattern="\d{8}-\d" class="dui-mask" required>
                                <small>Formato: 01234567-8</small>
                            </div>
                            <div class="campo">
                                <label>Fecha de Nacimiento</label>
                                <input type="date" name="novia_fecha_nac" required>
                            </div>
                        </div>
                        <div class="fila">
                            <div class="campo">
                                <label>Nacionalidad</label>
                                <input type="text" name="novia_nacionalidad" value="Salvadoreña" class="letras-only" required>
                            </div>
                            <div class="campo">
                                <label>Profesión u Oficio</label>
                                <input type="text" name="novia_profesion" placeholder="Ej: Médico" class="letras-only">
                            </div>
                        </div>
                        <div class="fila">
                            <div class="campo full-width">
                                <label>Domicilio</label>
                                <textarea name="novia_domicilio" rows="2" placeholder="Dirección completa"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TESTIGOS -->
            <div class="seccion" style="margin-top: 15px;">
                <div class="seccion-header">
                    <i class="fas fa-users"></i>
                    Datos de los Testigos
                </div>
                <div class="seccion-body">
                    <div class="fila">
                        <div class="campo">
                            <label>Nombre del Testigo 1</label>
                            <input type="text" name="testigo1_nombre" class="letras-only">
                        </div>
                        <div class="campo">
                            <label>DUI del Testigo 1</label>
                            <input type="text" name="testigo1_dui" placeholder="00000000-0" class="dui-mask">
                        </div>
                    </div>
                    <div class="fila">
                        <div class="campo">
                            <label>Nombre del Testigo 2</label>
                            <input type="text" name="testigo2_nombre" class="letras-only">
                        </div>
                        <div class="campo">
                            <label>DUI del Testigo 2</label>
                            <input type="text" name="testigo2_dui" placeholder="00000000-0" class="dui-mask">
                        </div>
                    </div>
                </div>
            </div>

            <!-- OFICIAL -->
            <div class="seccion">
                <div class="seccion-header">
                    <i class="fas fa-user-tie"></i>
                    Datos del Oficial
                </div>
                <div class="seccion-body">
                    <div class="fila">
                        <div class="campo">
                            <label>Nombre Completo</label>
                            <input type="text" name="oficial_nombre" placeholder="Ej: Lic. Roberto Martínez" class="letras-only">
                        </div>
                        <div class="campo">
                            <label>Cargo</label>
                            <input type="text" name="oficial_cargo" value="Encargado del Registro del Estado Familiar" class="letras-only">
                        </div>
                    </div>
                </div>
            </div>

        </form>

                    <!-- NAVEGACIÓN -->
                    <div class="doc-nav">
                        <a href="#" class="doc-nav-item active" onclick="return false;">
                            <span class="doc-nav-num">I</span>
                            <span class="doc-nav-title">Solicitud</span>
                        </a>
                        <a href="acta_de_matrimonio.php?id=NUEVO_ID" class="doc-nav-item">
                            <span class="doc-nav-num">II</span>
                            <span class="doc-nav-title">Acta</span>
                        </a>
                        <a href="certificación_partida_matrimonio.php?id=NUEVO_ID" class="doc-nav-item">
                            <span class="doc-nav-num">III</span>
                            <span class="doc-nav-title">Certificación</span>
                        </a>
                    </div>

                </div>
            </div>
            
            <!-- Footer -->
            <?php include 'layouts/footer.php'; ?>
        </main>
    </div>

<<<<<<< HEAD
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
=======
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    window.showToast = function(message, type = 'auto') {
        if (!message) return;
        
        let swalIcon = 'info';
        let swalTitle = 'Información';
        
        if (type === 'success') {
            swalIcon = 'success';
            swalTitle = 'Éxito';
        } else if (type === 'danger' || type === 'error') {
            swalIcon = 'error';
            swalTitle = 'Error';
        } else if (type === 'warning') {
            swalIcon = 'warning';
            swalTitle = 'Advertencia';
        }

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: swalIcon,
                title: swalTitle,
                text: message,
                confirmButtonColor: '#1C3166',
                confirmButtonText: 'Aceptar'
            });
        }
    };
    window.alert = function(message) { window.showToast(message, 'warning'); };
    </script>
    <script src="../assets/Js/validaciones.js?v=<?php echo time(); ?>"></script>
>>>>>>> Hz-backend_1
</body>
</html>