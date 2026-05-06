<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Acta de Defunción - Sistema Registro</title>
    <style>
        :root {
            --blanco: #ffffff;
            --azul-oscuro: #002855; /* Azul institucional */
            --negro: #121212;
            --gris-fondo: #f0f2f5;
            --borde: #d1d9e6;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--gris-fondo);
            color: var(--negro);
            margin: 0;
            padding: 10px; /* Espacio para móviles */
        }

        .container {
            max-width: 900px;
            background-color: var(--blanco);
            margin: 20px auto;
            padding: 30px;
            border-top: 10px solid var(--azul-oscuro);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border-radius: 4px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid var(--azul-oscuro);
            padding-bottom: 15px;
            margin-bottom: 30px;
        }

        .header h1 {
            color: var(--azul-oscuro);
            text-transform: uppercase;
            margin: 0;
            font-size: clamp(1.2rem, 5vw, 1.8rem); /* Texto fluido */
        }

        /* Layout Grid Responsive */
        .form-section {
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* 2 columnas por defecto */
            gap: 20px;
            margin-bottom: 40px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .full-width {
            grid-column: span 2;
        }

        label {
            font-weight: 700;
            font-size: 0.8rem;
            text-transform: uppercase;
            color: var(--azul-oscuro);
            margin-bottom: 8px;
        }

        input, select, textarea {
            padding: 12px;
            border: 1.5px solid var(--borde);
            border-radius: 5px;
            font-size: 1rem;
            width: 100%;
            transition: border-color 0.3s;
        }

        input:focus {
            outline: none;
            border-color: var(--azul-oscuro);
        }

        h3 {
            grid-column: span 2;
            color: var(--azul-oscuro);
            font-size: 1.1rem;
            border-bottom: 1px solid var(--borde);
            padding-bottom: 10px;
            margin-top: 0;
        }

        .footer-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            border-top: 1px solid var(--borde);
            padding-top: 25px;
        }

        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.9rem;
            width: auto;
        }

        .btn-primary {
            background-color: var(--azul-oscuro);
            color: var(--blanco);
        }

        .btn-secondary {
            background-color: var(--negro);
            color: var(--blanco);
        }

        /* --- MEDIA QUERIES PARA RESPONSIVE --- */

        @media (max-width: 600px) {
            .form-section {
                grid-template-columns: 1fr; /* Una sola columna en móviles */
            }
            
            .full-width, h3 {
                grid-column: span 1;
            }

            .container {
                padding: 15px;
                margin: 10px auto;
            }

            .footer-actions {
                flex-direction: column; /* Botones uno sobre otro en móviles */
            }

            .btn {
                width: 100%;
            }
        }

        /* Estilos de Impresión */
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background-color: white;
                padding: 0;
            }
            .container {
                box-shadow: none;
                border: none;
                width: 100%;
                max-width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>Acta de Defunción</h1>
        <p style="letter-spacing: 2px; font-weight: 300;">SISTEMA DE REGISTRO CIVIL</p>
    </div>

    <form action="guardar_acta.php" method="POST">
        <div class="form-section">
            <h3>Información del Fallecido</h3>
            
            <div class="form-group full-width">
                <label for="nombre">Nombre Completo</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>

            <div class="form-group">
                <label for="identidad">Número de Documento (DUI)</label>
                <input type="text" id="identidad" name="identidad">
            </div>

            <div class="form-group">
                <label for="fecha">Fecha de Defunción</label>
                <input type="date" id="fecha" name="fecha" required>
            </div>

            <div class="form-group">
                <label for="hora">Hora aproximada</label>
                <input type="time" id="hora" name="hora">
            </div>

            <div class="form-group">
                <label for="nacionalidad">Nacionalidad</label>
                <input type="text" id="nacionalidad" name="nacionalidad" value="Salvadoreña">
            </div>

            <div class="form-group full-width">
                <label for="causa">Causa del Fallecimiento</label>
                <textarea id="causa" name="causa" rows="3"></textarea>
            </div>

            <h3>Datos del Declarante</h3>

            <div class="form-group">
                <label for="declarante">Nombre del Declarante</label>
                <input type="text" id="declarante" name="declarante">
            </div>

            <div class="form-group">
                <label for="parentesco">Parentesco</label>
                <input type="text" id="parentesco" name="parentesco">
            </div>
        </div>

        <div class="footer-actions no-print">
            <button type="button" class="btn btn-secondary" onclick="window.print()">Imprimir Borrador</button>
            <button type="submit" class="btn btn-primary">Registrar Acta</button>
        </div>
    </form>
</div>

</body>
</html>