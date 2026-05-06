<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Munify - Solicitar Cita</title>
    <style>
        :root { 
            --azul: #002855; 
            --negro: #1a1a1a; 
            --blanco: #ffffff; 
            --gris: #f4f7f6; 
        }

        * { 
            box-sizing: border-box; 
        }

        /* Centrado absoluto del contenedor */
        body { 
            font-family: 'Segoe UI', Arial, sans-serif; 
            background: var(--gris); 
            margin: 0; 
            display: flex; 
            justify-content: center; /* Centrado horizontal */
            align-items: center;     /* Centrado vertical */
            min-height: 100vh;       /* Altura total de la pantalla */
            padding: 20px;
        }

        .container { 
            width: 100%; 
            max-width: 500px; /* Un poco más estrecho para verse mejor centrado */
            background: var(--blanco); 
            border-radius: 12px; 
            overflow: hidden; 
            box-shadow: 0 15px 35px rgba(0,0,0,0.15); 
        }

        .header { 
            background: var(--azul); 
            color: var(--blanco); 
            padding: 25px; 
            text-align: center; 
            border-bottom: 4px solid var(--negro);
        }

        .header h1 { 
            margin: 0; 
            font-size: 20px; 
            text-transform: uppercase; 
            letter-spacing: 1.5px; 
        }

        form { 
            padding: 30px; 
        }

        .input-box { 
            margin-bottom: 20px; 
        }

        label { 
            display: block; 
            margin-bottom: 8px; 
            font-weight: bold; 
            color: var(--azul); 
            font-size: 13px; 
            text-transform: uppercase;
        }

        select, input { 
            width: 100%; 
            padding: 12px; 
            border: 2px solid #ddd; 
            border-radius: 6px; 
            font-size: 15px;
            transition: 0.3s; 
        }

        select:focus, input:focus { 
            border-color: var(--azul); 
            outline: none; 
            box-shadow: 0 0 8px rgba(0,40,85,0.1);
        }

        .status-info { 
            background: #f8f9fa; 
            padding: 12px; 
            border-left: 5px solid var(--negro); 
            margin-bottom: 25px; 
            font-size: 13px; 
            color: #555;
            line-height: 1.4;
        }

        .btn-submit { 
            background: var(--azul); 
            color: white; 
            border: none; 
            width: 100%; 
            padding: 15px; 
            border-radius: 6px; 
            font-size: 16px; 
            font-weight: bold; 
            cursor: pointer; 
            text-transform: uppercase; 
            transition: background 0.3s;
        }

        .btn-submit:hover { 
            background: var(--negro); 
        }

        /* Ajuste para pantallas pequeñas */
        @media (max-width: 480px) { 
            body { padding: 10px; }
            .container { border-radius: 8px; }
            form { padding: 20px; }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>Nueva Cita Municipal</h1>
    </div>
    
    <form action="#" method="POST">
        <div class="status-info">
            <strong>Nota:</strong> Al solicitar su cita, el estado inicial será <span style="color:var(--azul)">"pendiente"</span>. Recibirá una confirmación en su correo.
        </div>

        <div class="input-box">
            <label>Tipo de Trámite</label>
            <select name="id_tipo" required>
                <option value="" disabled selected>Seleccione un trámite...</option>
                <option value="1">Partida de nacimiento</option>
                <option value="2">Carta de defunción</option>
                <option value="3">Carnet de menoridad</option>
            </select>
        </div>

        <div class="input-box">
            <label>Fecha Deseada</label>
            <input type="date" name="fecha_cita" required min="<?php echo date('Y-m-d'); ?>">
        </div>

        <div class="input-box">
            <label>Hora Sugerida</label>
            <input type="time" name="hora_cita" required>
        </div>

        <!-- Campos ocultos basados en tu BD -->
        <input type="hidden" name="estado" value="pendiente">
        <!-- El id_usuario debería venir de la sesión de PHP -->

        <button type="submit" class="btn-submit">Enviar Solicitud</button>
    </form>
</div>

</body>
</html>