<?php 
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Redirigir si es Ciudadano, ya que ellos usan el modal
if (isset($_SESSION['rol']) && $_SESSION['rol'] == 2) {
    header("Location: ../index.php");
    exit();
}

require_once __DIR__ . '/../models/Usuario.php';
$usuarioModel = new Usuario();
$userData = null;

if (isset($_SESSION['usuario_id'])) {
    $userData = $usuarioModel->obtenerPorId($_SESSION['usuario_id']);
}

$nombre_usuario = $userData['nombre'] ?? $_SESSION['usuario'] ?? 'Usuario';
$rol = $userData['rol_nombre'] ?? 'Administrador';
$email = $userData['correo'] ?? $_SESSION['correo'] ?? 'usuario@munify.gob.sv';
$inicial = strtoupper(substr($nombre_usuario, 0, 1));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - Munify</title>
    <!-- Fonts -->
    <?php if(file_exists('layouts/fonts.php')) include 'layouts/fonts.php'; ?>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/Css/index.css?v=<?= time() ?>">
    <link rel="stylesheet" href="../assets/Css/sidebar.css?v=<?= time() ?>">
    <link rel="stylesheet" href="../assets/Css/footer.css?v=<?= time() ?>">
    <link rel="stylesheet" href="../assets/Css/dashboard.css?v=<?= time() ?>">
    <style>
        .profile-header {
            background: linear-gradient(135deg, var(--color-1) 0%, #2A488E 100%);
            color: white;
            border-radius: 15px;
            padding: 3rem 2rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(28, 49, 102, 0.2);
        }
        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: #ffffff;
            color: var(--color-1);
            font-size: 3rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 4px solid rgba(255, 255, 255, 0.3);
            margin: 0 auto 1.5rem;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }
        .profile-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
        }
        .info-label {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #6c757d;
            margin-bottom: 0.2rem;
            font-weight: 600;
        }
        .info-value {
            font-size: 1.1rem;
            color: var(--color-1);
            font-weight: 500;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == 1) include 'layouts/sidebar.php'; ?>

        <!-- Main Content -->
        <main class="main-content" <?php if (!isset($_SESSION['rol']) || $_SESSION['rol'] == 2) echo 'style="margin-left: 0; width: 100%;"'; ?>>
            <div class="container-fluid py-4 px-4">
                
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="fw-bold mb-1" style="color: var(--color-3);">Mi Perfil</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="dashboard.php" class="text-decoration-none text-muted">Dashboard</a></li>
                                <li class="breadcrumb-item active fw-semibold small" style="color: var(--color-3);">Perfil</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-12 col-lg-8">
                        <div class="profile-header text-center mb-4">
                            <div class="profile-avatar position-relative mx-auto mb-3" style="width: 120px; height: 120px; cursor: pointer; border-radius: 50%;" onclick="document.getElementById('fotoInput').click()" title="Cambiar foto de perfil">
                                <?php if(!empty($userData['foto_perfil'])): ?>
                                    <img src="../assets/Img/profiles/<?= $userData['foto_perfil'] ?>" alt="Perfil" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                                <?php else: ?>
                                    <div class="d-flex align-items-center justify-content-center w-100 h-100 fs-1">
                                        <?= $inicial ?>
                                    </div>
                                <?php endif; ?>
                                <div class="position-absolute bottom-0 end-0 bg-light text-primary rounded-circle p-2" style="width: 35px; height: 35px; display:flex; align-items:center; justify-content:center; transform: translate(10%, 10%); box-shadow: 0 2px 5px rgba(0,0,0,0.3); z-index: 10;">
                                    <i class="bi bi-camera-fill fs-6"></i>
                                </div>
                            </div>
                            <form id="fotoForm" style="display: none;">
                                <input type="file" id="fotoInput" name="foto" accept="image/png, image/jpeg, image/jpg" onchange="uploadFoto()">
                            </form>
                            <h2 class="fw-bold mb-1"><?= htmlspecialchars($nombre_usuario) ?></h2>
                            <p class="mb-0 opacity-75"><i class="bi bi-shield-check me-2"></i><?= htmlspecialchars($rol) ?></p>
                        </div>

                        <div class="card profile-card">
                            <div class="card-body p-4 p-md-5">
                                <h4 class="fw-bold mb-4" style="color: var(--color-1);">Información Personal</h4>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info-label">Nombre de Usuario</div>
                                        <div class="info-value"><i class="bi bi-person me-2 text-muted"></i><?= htmlspecialchars($nombre_usuario) ?></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-label">Rol del Sistema</div>
                                        <div class="info-value"><i class="bi bi-award me-2 text-muted"></i><?= htmlspecialchars($rol) ?></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-label">Correo Electrónico</div>
                                        <div class="info-value"><i class="bi bi-envelope me-2 text-muted"></i><?= htmlspecialchars($email) ?></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-label">Estado de la Cuenta</div>
                                        <div class="info-value text-success"><i class="bi bi-check-circle-fill me-2"></i>Activa</div>
                                    </div>
                                </div>
                                
                                <div class="mt-4 pt-3 text-center border-top">
                                    <a href="dashboard.php" class="btn btn-secondary px-4 py-2 me-2">
                                        <i class="bi bi-house me-2"></i>Página Principal
                                    </a>
                                    <a href="login.php" class="btn btn-danger px-4 py-2">
                                        <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include 'layouts/footer.php'; ?>
        </main>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    async function uploadFoto() {
        const input = document.getElementById('fotoInput');
        if (input.files.length === 0) return;
        
        const formData = new FormData();
        formData.append('foto', input.files[0]);
        
        try {
            const resp = await fetch('../controller/UploadFotoController.php', {
                method: 'POST',
                body: formData
            });
            const data = await resp.json();
            if (data.success) {
                location.reload(); // Recargar para ver la nueva foto
            } else {
                alert(data.message || 'Error al subir la imagen');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error de conexión');
        }
    }
    </script>
</body>
</html>
