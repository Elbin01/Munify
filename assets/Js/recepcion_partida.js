$(document).ready(function() {
    // Cargar últimas partidas al iniciar
    cargarUltimasPartidas();

    function cargarUltimasPartidas() {
        $.ajax({
            url: '../controller/partidas_recientes_controller.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                const tbody = $('#tbodyUltimasPartidas');
                tbody.empty();
                
                if (data && data.length > 0) {
                    data.forEach(partida => {
                        const solicitante = partida.nombres + ' ' + partida.apellidos;
                        const dui = partida.DUI || 'N/A';
                        // Como no hay hora_emision en BD, podemos poner "Hoy" o la fecha de emision.
                        const hora = "Hoy"; 
                        const tomoFolio = `T:${partida.libro || '-'} / F:${partida.folio || '-'}`;
                        
                        const fila = `
                            <tr>
                                <td>${hora}</td>
                                <td>${dui}</td>
                                <td>${solicitante}</td>
                                <td>${tomoFolio}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-secondary" title="Ver Detalle" onclick="window.open('../reportes/partida_nacimiento.php?id=${partida.id_partida}', '_blank')">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                        tbody.append(fila);
                    });
                } else {
                    tbody.append('<tr><td colspan="5" class="text-center text-muted">No hay partidas generadas recientemente.</td></tr>');
                }
            },
            error: function() {
                $('#tbodyUltimasPartidas').html('<tr><td colspan="5" class="text-center text-danger">Error al cargar las partidas recientes.</td></tr>');
            }
        });
    }

    $('#searchForm').on('submit', function(e) {
        e.preventDefault(); 
        
        const query = $('#searchInput').val().trim();
        if(query === '') return;

        // Ocultar resultados previos
        $('#resultContainer').removeClass('d-none');
        $('#cardSuccess').addClass('d-none');
        $('#cardMultipleResults').addClass('d-none');
        $('#cardError').addClass('d-none');

        // Petición AJAX al servidor
        $.ajax({
            url: '../controller/buscar_ciudadano_controller.php',
            type: 'GET',
            data: { q: query },
            dataType: 'json',
            success: function(data) {
                if (data && data.length > 0) {
                    window.ciudadanosBusqueda = data; // Guardamos globalmente
                    
                    if (data.length === 1) {
                        // Solo 1 resultado, mostrar tarjeta éxito directamente
                        seleccionarCiudadano(0);
                    } else {
                        // Múltiples resultados
                        const tbody = $('#tbodyMultipleResults');
                        tbody.empty();
                        
                        data.forEach((ciudadano, index) => {
                            const nombreCompleto = ciudadano.nombres + ' ' + ciudadano.apellidos;
                            const fila = `
                                <tr>
                                    <td><strong>${nombreCompleto}</strong></td>
                                    <td>${ciudadano.DUI || '<span class="text-muted">N/A</span>'}</td>
                                    <td>${ciudadano.fecha_nacimiento || '<span class="text-muted">N/A</span>'}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="seleccionarCiudadano(${index})">
                                            Seleccionar
                                        </button>
                                    </td>
                                </tr>
                            `;
                            tbody.append(fila);
                        });
                        
                        $('#cardMultipleResults').removeClass('d-none');
                    }
                } else {
                    // NO ENCONTRADO
                    $('#formCiudadano')[0].reset(); // Limpiar el formulario del modal
                    
                    // Si el query contiene solo números y guiones, asumimos que es un DUI. 
                    // Si contiene letras, asumimos que es un nombre.
                    if (/^[\d-]+$/.test(query)) {
                        $('#modalRegDui').val(query); 
                    } else {
                        $('#regNombres').val(query);
                    }
                    
                    $('#cardError').removeClass('d-none');
                }
            },
            error: function() {
                alert("Hubo un error al conectar con la base de datos.");
            }
        });
    });

    // Guardar nuevo ciudadano
    $('#btnGuardarCiudadano').on('click', function() {
        const data = {
            nombres: $('#regNombres').val().trim(),
            apellidos: $('#regApellidos').val().trim(),
            sexo: $('#regSexo').val(),
            fecha_nacimiento: $('#regFechaNac').val(),
            hora_nacimiento: $('#regHoraNac').val(),
            dui: $('#modalRegDui').val().trim(),
            lugar_nacimiento: $('#regLugarNac').val().trim(),
            hospital: $('#regHospital').val().trim(),
            nombre_padre: $('#regNombrePadre').val().trim(),
            nombre_madre: $('#regNombreMadre').val().trim()
        };

        if (data.nombres === '' || data.apellidos === '') {
            alert('Los campos Nombres y Apellidos son obligatorios.');
            return;
        }

        $.ajax({
            url: '../controller/guardar_ciudadano_controller.php',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    $('#modalCiudadano').modal('hide');
                    $('#formCiudadano')[0].reset();
                    // Opcional: buscar automáticamente el ciudadano recién creado
                    $('#searchInput').val(data.dui || data.nombres);
                    $('#searchForm').submit();
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function() {
                alert('Hubo un error al procesar la solicitud.');
            }
        });
    });

    // Máscara para DUI (00000000-0)
    $('.dui-mask').on('input', function() {
        let val = $(this).val().replace(/\D/g, ''); // Solo números
        if (val.length > 9) val = val.slice(0, 9); // Máximo 9 dígitos
        
        if (val.length > 8) {
            val = val.slice(0, 8) + '-' + val.slice(8);
        }
        $(this).val(val);
    });

    // Generar e imprimir partida
    $('#btnImprimirPartida').on('click', function() {
        if (!window.selectedCiudadanoId) {
            alert('Error: No se ha seleccionado un ciudadano.');
            return;
        }

        const data = {
            id_ciudadano: window.selectedCiudadanoId,
            numero_partida: $('#partidaNum').val().trim(),
            libro: $('#partidaLibro').val().trim(),
            folio: $('#partidaFolio').val().trim()
        };

        if (data.numero_partida === '') {
            alert('El número de partida es obligatorio.');
            return;
        }

        $.ajax({
            url: '../controller/guardar_partida_controller.php',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#modalPartida').modal('hide');
                    $('#formGenerarPartida')[0].reset();
                    // Abrir el reporte en una nueva pestaña
                    window.open(`../reportes/partida_nacimiento.php?id=${response.id_partida}`, '_blank');
                    // Recargar la tabla de últimas partidas
                    cargarUltimasPartidas();
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function() {
                alert('Hubo un error al procesar la solicitud.');
            }
        });
    });
});

// Función global para seleccionar un ciudadano de la lista de resultados
window.seleccionarCiudadano = function(index) {
    if (!window.ciudadanosBusqueda || !window.ciudadanosBusqueda[index]) return;
    
    const ciudadano = window.ciudadanosBusqueda[index];
    const nombreCompleto = ciudadano.nombres + ' ' + ciudadano.apellidos;
    
    // LLENAR TARJETA ÉXITO
    $('#resNombre').text(nombreCompleto);
    $('#resDui').text(ciudadano.DUI || 'N/A');
    $('#resNac').text(ciudadano.fecha_nacimiento || 'N/A');
    
    // LLENAR MODAL PARTIDA (Precargando datos)
    $('#lblNombre').text(nombreCompleto);
    $('#lblFechaNac').text(ciudadano.fecha_nacimiento || 'N/A');
    $('#lblPadre').text(ciudadano.nombre_padre || 'No registrado');
    $('#lblMadre').text(ciudadano.nombre_madre || 'No registrada');

    // VALIDACIÓN: ¿Ya tiene partida?
    const btnAccion = $('#btnAccionPartida');
    if (ciudadano.id_partida) {
        // Ya tiene partida -> Cambiar a modo Imprimir
        btnAccion.html('<i class="bi bi-printer-fill me-2"></i> Imprimir Partida');
        btnAccion.addClass('btn-action-primary'); // Asegurar que tenga la clase de estilo
        btnAccion.removeAttr('data-bs-toggle').removeAttr('data-bs-target');
        
        // Acción de imprimir directamente
        btnAccion.off('click').on('click', function() {
            window.open(`../reportes/partida_nacimiento.php?id=${ciudadano.id_partida}`, '_blank');
        });
    } else {
        // No tiene partida -> Modo Generar (abrir modal)
        btnAccion.html('<i class="bi bi-printer-fill me-2"></i> Generar Partida');
        btnAccion.addClass('btn-action-primary');
        btnAccion.attr('data-bs-toggle', 'modal').attr('data-bs-target', '#modalPartida');
        btnAccion.off('click'); // Dejar que Bootstrap maneje el modal
    }

    // Ocultar tabla de múltiples y mostrar tarjeta de éxito
    $('#cardMultipleResults').addClass('d-none');
    $('#cardSuccess').removeClass('d-none');

    // Guardar el ID del ciudadano seleccionado para la generación de la partida
    window.selectedCiudadanoId = ciudadano.id_ciudadano;
};
