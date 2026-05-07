<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Munify - Solicitar Trámite</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,700;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --color-1: #1C3166;
            --color-2: #550000;
            --color-3: #FFFFFF;
            --color-4: #333333;
            --color-5: #F4F7F6;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            font-family: 'Poppins', sans-serif; 
            background: var(--color-5); 
            color: var(--color-4);
            display: flex; 
            justify-content: center; 
            align-items: center;   
            min-height: 100vh;     
            padding: 2rem 1rem;
        }

        .container { 
            width: 100%; 
            max-width: 700px; 
            background: var(--color-3); 
            border-radius: 12px; 
            overflow: hidden; 
            box-shadow: 0 15px 35px rgba(0,0,0,0.1); 
            border-top: 5px solid var(--color-2);
        }

        .header { 
            background: var(--color-1); 
            color: var(--color-3); 
            padding: 2rem; 
            text-align: center; 
            position: relative;
        }
        
        .header-logo {
            width: 60px;
            height: 60px;
            background: var(--color-3);
            border-radius: 50%;
            margin: 0 auto 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 2px solid var(--color-3);
        }
        
        .header-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .header h1 { 
            margin: 0; 
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem; 
            font-weight: 700;
            letter-spacing: 1px; 
        }
        
        .header p {
            font-size: 0.85rem;
            opacity: 0.9;
            margin-top: 0.5rem;
        }

        form { 
            padding: 2rem; 
        }

        .form-section {
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #eee;
        }
        
        .form-section-title {
            color: var(--color-1);
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .input-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        
        .full-width {
            grid-column: 1 / -1;
        }

        .input-box { 
            margin-bottom: 1rem; 
        }

        label { 
            display: block; 
            margin-bottom: 0.4rem; 
            font-weight: 600; 
            color: var(--color-1); 
            font-size: 0.85rem; 
        }

        select, input, textarea { 
            width: 100%; 
            padding: 0.8rem 1rem; 
            border: 1px solid #ddd; 
            border-radius: 6px; 
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            transition: all 0.3s ease; 
            background: #fff;
        }

        select:focus, input:focus, textarea:focus { 
            border-color: var(--color-1); 
            outline: none; 
            box-shadow: 0 0 0 3px rgba(28, 49, 102, 0.1);
        }

        .status-info { 
            background: rgba(28, 49, 102, 0.05); 
            padding: 1rem; 
            border-left: 4px solid var(--color-1); 
            margin-bottom: 1.5rem; 
            font-size: 0.85rem; 
            color: var(--color-4);
            border-radius: 0 6px 6px 0;
        }

        .btn-submit { 
            background: var(--color-1); 
            color: var(--color-3); 
            border: none; 
            width: 100%; 
            padding: 1rem; 
            border-radius: 6px; 
            font-family: 'Poppins', sans-serif;
            font-size: 1rem; 
            font-weight: 600; 
            cursor: pointer; 
            transition: all 0.3s;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-submit:hover { 
            background: var(--color-2); 
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(85, 0, 0, 0.2);
        }

        .dynamic-fields {
            display: none;
            animation: fadeIn 0.4s ease;
        }
        
        .dynamic-fields.active {
            display: block;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .modal-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.5); backdrop-filter: blur(5px);
            display: none; justify-content: center; align-items: center; z-index: 1000;
        }
        .modal-overlay.show { display: flex; }
        
        .modal-content {
            background: #fff; padding: 2.5rem; border-radius: 12px;
            text-align: center; max-width: 400px; width: 90%;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            animation: bounceIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        @keyframes bounceIn {
            0% { transform: scale(0.8); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
        .success-icon { font-size: 3rem; color: #10B981; margin-bottom: 1rem; }

        @media (max-width: 600px) { 
            .input-grid { grid-template-columns: 1fr; }
            .header { padding: 1.5rem; }
            form { padding: 1.5rem; }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <div class="header-logo">
            <img src="../assets/Img/MUNIFY.jpeg" alt="Logo Alcaldía" onerror="this.style.display='none';">
        </div>
        <h1>Solicitud de Trámites</h1>
        <p>Registro Civil de la Alcaldía Municipal</p>
    </div>
    
    <form id="formCita">
        <div class="status-info">
            <i class="fas fa-info-circle" style="color: var(--color-1);"></i> 
            Seleccione el tipo de trámite que desea realizar y complete los datos requeridos para generar su solicitud.
        </div>

        <div class="form-section">
            <h2 class="form-section-title"><i class="fas fa-file-signature"></i> Trámite y Contacto</h2>
            <div class="input-grid">
                <div class="input-box full-width">
                    <label>Tipo de Trámite</label>
                    <select name="tipo_tramite" id="tipoTramite" required>
                        <option value="" disabled selected>Seleccione un trámite...</option>
                        <option value="partida">Partida de Nacimiento</option>
                        <option value="defuncion">Carta de Defunción</option>
                        <option value="minoridad">Carnet de Minoridad</option>
                    </select>
                </div>

                <div class="input-box">
                    <label>Correo Electrónico (Para confirmación)</label>
                    <input type="email" name="correo" required placeholder="ejemplo@correo.com">
                </div>

                <div class="input-box">
                    <label>Teléfono de Contacto</label>
                    <input type="tel" name="telefono" required placeholder="0000-0000">
                </div>
            </div>
        </div>

        <div id="fieldsPartida" class="dynamic-fields form-section">
            <h2 class="form-section-title"><i class="fas fa-baby"></i> Datos de la Partida</h2>
            <div class="input-grid">
                <div class="input-box full-width">
                    <label>Nombre del Inscrito (Como aparece en partida)</label>
                    <input type="text" name="p_nombre_inscrito">
                </div>
                <div class="input-box">
                    <label>Lugar de Nacimiento (Ej. Hospital Nacional)</label>
                    <input type="text" name="p_lugar_nac">
                </div>
                <div class="input-box">
                    <label>Fecha de Nacimiento</label>
                    <input type="date" name="p_fecha_nac">
                </div>
                <div class="input-box">
                    <label>Hora de Nacimiento</label>
                    <input type="time" name="p_hora_nac">
                </div>
                <div class="input-box">
                    <label>Sexo</label>
                    <select name="p_sexo">
                        <option value="Femenino">Femenino</option>
                        <option value="Masculino">Masculino</option>
                    </select>
                </div>
                
                <!-- Datos del Padre -->
                <div class="input-box full-width" style="margin-top:1rem; padding-top:1rem; border-top:1px dashed #ccc;">
                    <label style="color:#550000; font-size:1rem;"><i class="fas fa-male"></i> Datos del Padre</label>
                </div>
                <div class="input-box full-width">
                    <label>Nombre del Padre</label>
                    <input type="text" name="p_nombre_padre">
                </div>
                <div class="input-box">
                    <label>Edad del Padre</label>
                    <input type="number" name="p_edad_padre" min="15" max="99">
                </div>
                <div class="input-box">
                    <label>Profesión u Oficio</label>
                    <input type="text" name="p_profesion_padre">
                </div>
                
                <!-- Datos de la Madre -->
                <div class="input-box full-width" style="margin-top:1rem; padding-top:1rem; border-top:1px dashed #ccc;">
                    <label style="color:#550000; font-size:1rem;"><i class="fas fa-female"></i> Datos de la Madre</label>
                </div>
                <div class="input-box full-width">
                    <label>Nombre de la Madre</label>
                    <input type="text" name="p_nombre_madre">
                </div>
                <div class="input-box">
                    <label>Edad de la Madre</label>
                    <input type="number" name="p_edad_madre" min="15" max="99">
                </div>
                <div class="input-box">
                    <label>Profesión u Oficio</label>
                    <input type="text" name="p_profesion_madre">
                </div>
            </div>
        </div>

        <div id="fieldsDefuncion" class="dynamic-fields form-section">
            <h2 class="form-section-title"><i class="fas fa-book-dead"></i> Datos del Fallecido</h2>
            <div class="input-grid">
                <div class="input-box full-width">
                    <label>Nombre Completo del Fallecido</label>
                    <input type="text" name="d_nombre_fallecido">
                </div>
                <div class="input-box">
                    <label>DUI del Fallecido</label>
                    <input type="text" name="d_dui">
                </div>
                <div class="input-box">
                    <label>Fecha de Defunción</label>
                    <input type="date" name="d_fecha_defuncion">
                </div>
                <div class="input-box full-width">
                    <label>Nombre del Declarante o Solicitante</label>
                    <input type="text" name="d_nombre_declarante">
                </div>
            </div>
        </div>

        <div id="fieldsMinoridad" class="dynamic-fields form-section">
            <h2 class="form-section-title"><i class="fas fa-id-card"></i> Datos del Menor</h2>
            <div class="input-grid">
                <div class="input-box">
                    <label>Nombres</label>
                    <input type="text" name="m_nombres">
                </div>
                <div class="input-box">
                    <label>Apellidos</label>
                    <input type="text" name="m_apellidos">
                </div>
                <div class="input-box">
                    <label>Fecha de Nacimiento</label>
                    <input type="date" name="m_fecha_nac">
                </div>
                <div class="input-box">
                    <label>Lugar de Nacimiento</label>
                    <input type="text" name="m_lugar_nac" placeholder="Ej. Hospital Nacional">
                </div>
                <div class="input-box full-width">
                    <label>Dirección Completa</label>
                    <textarea name="m_direccion" rows="2"></textarea>
                </div>
                <div class="input-box full-width">
                    <label>Centro de Estudios</label>
                    <input type="text" name="m_centro_estudios">
                </div>
                
                <!-- Datos de los Padres -->
                <div class="input-box full-width" style="margin-top:1rem; padding-top:1rem; border-top:1px dashed #ccc;">
                    <label style="color:#550000; font-size:1rem;"><i class="fas fa-users"></i> Datos de los Padres</label>
                </div>
                <div class="input-box">
                    <label>Nombre de la Madre</label>
                    <input type="text" name="m_nombre_madre">
                </div>
                <div class="input-box">
                    <label>Nombre del Padre</label>
                    <input type="text" name="m_nombre_padre">
                </div>

                <!-- Rasgos Físicos -->
                <div class="input-box full-width" style="margin-top:1rem; padding-top:1rem; border-top:1px dashed #ccc;">
                    <label style="color:#550000; font-size:1rem;"><i class="fas fa-user-tag"></i> Rasgos Físicos</label>
                </div>
                <div class="input-box">
                    <label>Color de Piel</label>
                    <input type="text" name="m_color_piel" placeholder="Ej. Moreno, Blanco...">
                </div>
                <div class="input-box">
                    <label>Color de Ojos</label>
                    <input type="text" name="m_color_ojos" placeholder="Ej. Café, Negro...">
                </div>
                <div class="input-box">
                    <label>Color de Cabello</label>
                    <input type="text" name="m_color_cabello" placeholder="Ej. Negro, Castaño...">
                </div>
                <div class="input-box">
                    <label>Señas Especiales</label>
                    <input type="text" name="m_senales_especiales" value="Ninguna">
                </div>

                <!-- Fotografía -->
                <div class="input-box full-width" style="margin-top:1rem; padding-top:1rem; border-top:1px dashed #ccc;">
                    <label style="color:#550000; font-size:1rem;"><i class="fas fa-camera"></i> Fotografía del Menor</label>
                </div>
                <div class="input-box full-width">
                    <label>Subir foto (Formato JPG o PNG)</label>
                    <input type="file" name="m_foto" accept="image/*">
                </div>
            </div>
        </div>

        <button type="submit" class="btn-submit" id="btnSubmit">
            <i class="fas fa-paper-plane"></i> Enviar Solicitud
        </button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const selectTramite = document.getElementById('tipoTramite');
        const sections = {
            partida: document.getElementById('fieldsPartida'),
            defuncion: document.getElementById('fieldsDefuncion'),
            minoridad: document.getElementById('fieldsMinoridad')
        };
        const form = document.getElementById('formCita');

        // IMPORTANTE para poder enviar archivos:
        form.enctype = "multipart/form-data";

        selectTramite.addEventListener('change', (e) => {
            Object.values(sections).forEach(sec => sec.classList.remove('active'));
            const selected = e.target.value;
            if (sections[selected]) {
                sections[selected].classList.add('active');
            }
            
            // Ahora todo se envía a GuardarTramite.php para guardarse en BD
            form.action = '../controller/GuardarTramite.php';
        });
        
        form.method = 'POST';
        form.target = '_blank';
    });
</script>

</body>
</html>