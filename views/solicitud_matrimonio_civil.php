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
    <title>Solicitud de Matrimonio Civil</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Text:wght@400;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Open Sans', sans-serif;
            background: #f5f5f5;
            padding: 20px;
            -webkit-text-size-adjust: 100%;
        }
        
        .documento {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        /* ════════ HEADER ════════ */
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 3px double #1C3166;
        }
        
       .escudo {
    width: 80px;
    height: 80px;
    border: 2px solid #1C3166;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    flex-shrink: 0;
    background: white;
}

.escudo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 4px;
}
        
        .titulo-central {
            text-align: center;
            flex: 1;
            padding: 0 20px;
        }
        
        .titulo-central h1 {
            font-family: 'Crimson Text', serif;
            font-size: 1.1rem;
            font-weight: 700;
            letter-spacing: 2px;
            color: #1a1a1a;
            margin-bottom: 4px;
        }
        
        .titulo-central h2 {
            font-family: 'Crimson Text', serif;
            font-size: 0.85rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }
        
        .titulo-central .registro {
            font-family: 'Crimson Text', serif;
            font-size: 0.75rem;
            font-style: italic;
            color: #1C3166;
            display: block;
            margin-bottom: 10px;
        }
        
        .titulo-central h3 {
            font-family: 'Crimson Text', serif;
            font-size: 1.4rem;
            font-weight: 700;
            letter-spacing: 3px;
            color: #1a1a1a;
            text-transform: uppercase;
        }
        
        /* ════════ BOTONES ACCIÓN ════════ */
        .acciones-header {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            justify-content: flex-end;
        }
        
        .btn {
            padding: 10px 20px;
            border-radius: 4px;
            font-family: 'Open Sans', sans-serif;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-primary {
            background: #1C3166;
            color: white;
        }
        
        .btn-primary:hover {
            background: #15254d;
        }
        
        .btn-secondary {
            background: white;
            color: #1C3166;
            border: 2px solid #1C3166;
        }
        
        .btn-secondary:hover {
            background: #1C3166;
            color: white;
        }
        
        .btn-success {
            background: #10b981;
            color: white;
        }
        
        .btn-success:hover {
            background: #059669;
        }
        
        /* ════════ SECCIONES ════════ */
        .seccion {
            margin-bottom: 15px;
            border: 1px solid #ddd;
        }
        
        .seccion-header {
            background: #1C3166;
            color: white;
            padding: 10px 15px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .seccion-header i {
            font-size: 0.7rem;
        }
        
        .seccion-body {
            padding: 20px;
            background: #fafbfc;
        }
        
        /* ════════ FORMULARIO ════════ */
        .fila {
            display: flex;
            gap: 20px;
            margin-bottom: 15px;
        }
        
        .fila:last-child {
            margin-bottom: 0;
        }
        
        .campo {
            flex: 1;
            min-width: 0;
        }
        
        .campo.full-width {
            flex: 100%;
        }
        
        .campo label {
            display: block;
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #1C3166;
            margin-bottom: 6px;
        }
        
        .campo input,
        .campo select,
        .campo textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-family: 'Open Sans', sans-serif;
            font-size: 0.9rem;
            color: #1a1a1a;
            background: white;
            transition: all 0.3s;
        }
        
        .campo input:focus,
        .campo select:focus,
        .campo textarea:focus {
            outline: none;
            border-color: #1C3166;
            box-shadow: 0 0 0 3px rgba(28, 49, 102, 0.1);
        }
        
        .campo small {
            display: block;
            font-size: 0.7rem;
            color: #888;
            margin-top: 4px;
        }
        
        /* ════════ DOS COLUMNAS ════════ */
        .dos-columnas {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        
        .columna {
            border: 1px solid #ddd;
        }
        
        .columna .seccion-header {
            background: #1C3166;
        }
        
        .columna .seccion-body {
            padding: 15px;
        }
        
        /* ════════ NAVEGACIÓN ════════ */
       /* ════════ NAVEGACIÓN (BOTONES PEQUEÑOS) ════════ */
.nav-documentos {
    display: flex;
    gap: 8px;
    margin-top: 20px;
    padding-top: 15px;
    border-top: 1px solid #ddd;
}

.nav-item {
    flex: 1;
    padding: 10px 8px;
    background: white;
    border: 1px solid #ccc;
    border-radius: 6px;
    text-align: center;
    text-decoration: none;
    color: inherit;
    transition: all 0.2s;
}

.nav-item:hover {
    border-color: #1C3166;
    transform: translateY(-2px);
}

.nav-item.active {
    background: #1C3166;
    border-color: #1C3166;
    color: white;
}

.nav-num {
    font-family: 'Crimson Text', serif;
    font-size: 1.1rem;
    font-weight: 600;
    display: block;
    margin-bottom: 2px;
    line-height: 1;
}

.nav-title {
    font-size: 0.65rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 500;
}

/* Responsive */
@media screen and (max-width: 768px) {
    .nav-documentos {
        gap: 6px;
        margin-top: 15px;
    }
    
    .nav-item {
        padding: 8px 5px;
        border-radius: 4px;
    }
    
    .nav-num {
        font-size: 1rem;
    }
    
    .nav-title {
        font-size: 0.6rem;
    }
}

        /* ═══════════════════════════════════════════════════════════
           RESPONSIVE
           ═══════════════════════════════════════════════════════════ */
        @media screen and (max-width: 1024px) {
            body { padding: 10px; }
            .documento { padding: 25px; }
            .titulo-central h1 { font-size: 1rem; }
            .titulo-central h3 { font-size: 1.2rem; }
            .escudo { width: 60px; height: 60px; font-size: 1.5rem; }
        }

        @media screen and (max-width: 768px) {
            body { padding: 0; background: white; }
            .documento { padding: 20px; box-shadow: none; }
            
            .header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            
            .escudo { width: 50px; height: 50px; font-size: 1.2rem; }
            .titulo-central h1 { font-size: 0.9rem; }
            .titulo-central h3 { font-size: 1.1rem; }
            
            .acciones-header {
                flex-direction: column;
                align-items: stretch;
            }
            
            .dos-columnas { grid-template-columns: 1fr; }
            .fila { flex-direction: column; gap: 12px; }
            .seccion-body { padding: 15px; }
            
            .nav-documentos { flex-direction: column; }
        }

        @media screen and (max-width: 480px) {
            .documento { padding: 15px; }
            .campo input, .campo select { font-size: 16px; } /* Prevenir zoom en iOS */
        }
    </style>
</head>
<body>

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
            
            <div style="width: 80px;"></div>
        </div>

        <!-- ACCIONES -->
        <div class="acciones-header">
            <a href="dashboard.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Cancelar
            </a>
            <button type="submit" form="formSolicitud" class="btn btn-primary">
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
                            <input type="text" name="lugar" placeholder="Oficina del Registro del Estado Familiar">
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
                                <input type="text" name="novio_nombres" placeholder="Ej: Juan Carlos" required>
                            </div>
                            <div class="campo">
                                <label>Apellidos</label>
                                <input type="text" name="novio_apellidos" placeholder="Ej: Pérez García" required>
                            </div>
                        </div>
                        <div class="fila">
                            <div class="campo">
                                <label>DUI</label>
                                <input type="text" name="novio_dui" placeholder="00000000-0" pattern="\d{8}-\d" required>
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
                                <input type="text" name="novio_nacionalidad" value="Salvadoreño" required>
                            </div>
                            <div class="campo">
                                <label>Profesión u Oficio</label>
                                <input type="text" name="novio_profesion" placeholder="Ej: Ingeniero">
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
                                <input type="text" name="novia_nombres" placeholder="Ej: María Elena" required>
                            </div>
                            <div class="campo">
                                <label>Apellidos</label>
                                <input type="text" name="novia_apellidos" placeholder="Ej: López Hernández" required>
                            </div>
                        </div>
                        <div class="fila">
                            <div class="campo">
                                <label>DUI</label>
                                <input type="text" name="novia_dui" placeholder="00000000-0" pattern="\d{8}-\d" required>
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
                                <input type="text" name="novia_nacionalidad" value="Salvadoreña" required>
                            </div>
                            <div class="campo">
                                <label>Profesión u Oficio</label>
                                <input type="text" name="novia_profesion" placeholder="Ej: Médico">
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
                            <input type="text" name="testigo1_nombre">
                        </div>
                        <div class="campo">
                            <label>DUI del Testigo 1</label>
                            <input type="text" name="testigo1_dui" placeholder="00000000-0">
                        </div>
                    </div>
                    <div class="fila">
                        <div class="campo">
                            <label>Nombre del Testigo 2</label>
                            <input type="text" name="testigo2_nombre">
                        </div>
                        <div class="campo">
                            <label>DUI del Testigo 2</label>
                            <input type="text" name="testigo2_dui" placeholder="00000000-0">
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
                            <input type="text" name="oficial_nombre" placeholder="Ej: Lic. Roberto Martínez">
                        </div>
                        <div class="campo">
                            <label>Cargo</label>
                            <input type="text" name="oficial_cargo" value="Encargado del Registro del Estado Familiar">
                        </div>
                    </div>
                </div>
            </div>

        </form>

        <!-- NAVEGACIÓN -->
        <div class="nav-documentos">
            <a href="#" class="nav-item active" onclick="return false;">
                <span class="nav-num">I</span>
                <span class="nav-title">Solicitud</span>
            </a>
            <a href="acta_de_matrimonio.php?id=NUEVO_ID" class="nav-item">
                <span class="nav-num">II</span>
                <span class="nav-title">Acta</span>
            </a>
            <a href="certificación_partida_matrimonio.php?id=NUEVO_ID" class="nav-item">
                <span class="nav-num">III</span>
                <span class="nav-title">Certificación</span>
            </a>
        </div>

    </div>

</body>
</html>