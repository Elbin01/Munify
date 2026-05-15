$(document).ready(function() {
    // Inicializar DataTable
    // Inicializar DataTable
    const table = $('#tablaCitas').DataTable({
        "ajax": {
            "url": "../controller/obtener_citas_controller.php",
            "dataSrc": ""
        },
        "columns": [
            {
                "data": null,
                "orderable": false,
                "render": function(data, type, row) {
                    if (row.estado === 'pendiente') {
                        return `<input type="checkbox" class="form-check-input row-checkbox" value="${row.id_cita}">`;
                    }
                    return '';
                }
            },
            { "data": "id_cita" },
            { 
                "data": "usuario_nombre",
                "render": function(data, type, row) {
                    return `<div><strong>${data}</strong><br><small class="text-muted">${row.usuario_correo}</small></div>`;
                }
            },
            { "data": "tramite_nombre" },
            { "data": "fecha_cita" },
            { "data": "hora_cita" },
            { 
                "data": "estado",
                "render": function(data) {
                    let badgeClass = 'bg-pendiente';
                    if (data === 'confirmada') badgeClass = 'bg-confirmada';
                    if (data === 'denegada') badgeClass = 'bg-denegada';
                    return `<span class="status-badge ${badgeClass}">${data.charAt(0).toUpperCase() + data.slice(1)}</span>`;
                }
            },
            {
                "data": null,
                "orderable": false,
                "className": 'text-end',
                "render": function(data, type, row) {
                    return `
                        <div class="d-flex gap-1 justify-content-end">
                            <button class="btn btn-sm btn-outline-primary" onclick="verDetalle(${row.id_cita})" title="Ver Detalles">
                                <i class="bi bi-eye"></i>
                            </button>
                            ${row.estado === 'pendiente' ? `
                            <button class="btn btn-sm btn-outline-success" onclick="cambiarEstado(${row.id_cita}, 'confirmada')" title="Aceptar">
                                <i class="bi bi-check-lg"></i>
                            </button>
                            ` : ''}
                        </div>
                    `;
                }
            }
        ],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
        },
        "search": {
            "search": "Pendiente"
        },
        "order": [[4, "asc"], [5, "asc"]],
        "dom": '<"row mb-3"<"col-md-6"l><"col-md-6"f>>rt<"row mt-3"<"col-md-6"i><"col-md-6"p>>',
        "initComplete": function(settings, json) {
            $('.dataTables_filter input').addClass('form-control form-control-sm shadow-none border-secondary-subtle');
            $('.dataTables_filter input').attr('placeholder', 'Buscar...');
            $('.dataTables_length select').addClass('form-select form-select-sm shadow-none border-secondary-subtle');
        }
    });

    // Seleccionar todos
    $('#selectAll').on('change', function() {
        $('.row-checkbox').prop('checked', this.checked);
    });

    // Aceptar Seleccionadas
    $('#btnAceptarSeleccionadas').on('click', function() {
        const selected = $('.row-checkbox:checked').map(function() {
            return $(this).val();
        }).get();

        if (selected.length === 0) {
            alert('Por favor, seleccione al menos una cita pendiente.');
            return;
        }

        if (confirm(`¿Está seguro de que desea aceptar las ${selected.length} citas seleccionadas?`)) {
            procesarBatch(selected, 'confirmada');
        }
    });

    // Aceptar Todas (las que están en la vista actual / filtradas)
    $('#btnAceptarTodas').on('click', function() {
        const allIds = table.rows({ filter: 'applied' }).data().toArray()
            .filter(row => row.estado === 'pendiente')
            .map(row => row.id_cita);

        if (allIds.length === 0) {
            alert('No hay citas pendientes para aceptar en la vista actual.');
            return;
        }

        if (confirm(`¿Está seguro de que desea aceptar TODAS las citas pendientes (${allIds.length})?`)) {
            procesarBatch(allIds, 'confirmada');
        }
    });

    // Función para procesar en lote
    function procesarBatch(ids, nuevoEstado) {
        // En un entorno real, enviaríamos un solo request con el array de IDs.
        // Aquí lo haremos uno por uno por simplicidad si el backend no soporta arrays,
        // pero lo ideal es un endpoint bulk.
        
        let promesas = ids.map(id => {
            return $.ajax({
                url: '../controller/actualizar_estado_cita.php',
                type: 'POST',
                data: { id: id, estado: nuevoEstado },
                dataType: 'json'
            });
        });

        Promise.all(promesas).then(() => {
            alert('Proceso completado exitosamente.');
            table.ajax.reload();
            $('#selectAll').prop('checked', false);
        }).catch(() => {
            alert('Hubo un error al procesar algunas solicitudes.');
            table.ajax.reload();
        });
    }

    table.column(6).search($('#filterEstado').val()).draw();

    // Función para ver detalle en modal
    window.verDetalle = function(id) {
        $('#citaIdActual').val(id);
        $('#modalDetalleCita').modal('show');
        $('#detalleContenido').html('<div class="text-center p-5"><div class="spinner-border text-primary"></div><p>Cargando...</p></div>');

        $.ajax({
            url: '../controller/obtener_detalle_cita_controller.php',
            type: 'GET',
            data: { id: id },
            dataType: 'json',
            success: function(data) {
                if (data.error) {
                    $('#detalleContenido').html(`<div class="alert alert-danger">${data.error}</div>`);
                    return;
                }

                const html = `
                    <div class="row g-4">
                        <div class="col-md-6">
                            <h6 class="text-uppercase text-muted small fw-bold mb-3">Información del Trámite</h6>
                            <p class="mb-1"><strong>Tipo:</strong> ${data.tramite_nombre}</p>
                            <p class="mb-1"><strong>Fecha Solicitada:</strong> ${data.fecha_cita}</p>
                            <p class="mb-1"><strong>Hora:</strong> ${data.hora_cita}</p>
                            <p class="mb-1"><strong>Estado Actual:</strong> <span class="badge ${data.estado === 'pendiente' ? 'bg-warning text-dark' : 'bg-info'}">${data.estado}</span></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-uppercase text-muted small fw-bold mb-3">Contacto Ciudadano</h6>
                            <p class="mb-1"><strong>Solicitante:</strong> ${data.nombre_contacto}</p>
                            <p class="mb-1"><strong>Correo de contacto:</strong> <a href="mailto:${data.correo_contacto}">${data.correo_contacto}</a></p>
                        </div>
                    </div>
                `;
                $('#detalleContenido').html(html);
            }
        });
    };

    // Procesar desde el modal
    window.procesarDesdeModal = function(nuevoEstado) {
        const id = $('#citaIdActual').val();
        cambiarEstado(id, nuevoEstado);
        $('#modalDetalleCita').modal('hide');
    };

    // Filtros personalizados
    $('#filterTramite').on('change', function() {
        table.column(3).search(this.value).draw();
    });

    $('#filterEstado').on('change', function() {
        table.column(6).search(this.value).draw();
    });

    $('#btnLimpiarFiltros').on('click', function() {
        $('#filterTramite').val('');
        $('#filterEstado').val('pendiente');
        table.column(3).search('').column(6).search('pendiente').draw();
    });

    // Función para cambiar estado
    window.cambiarEstado = function(id, nuevoEstado) {
        const mensaje = nuevoEstado === 'confirmada' ? 'aceptar y notificar por correo' : 'denegar';
        if(confirm(`¿Está seguro de que desea ${mensaje} esta solicitud?`)) {
            $.ajax({
                url: '../controller/actualizar_estado_cita.php',
                type: 'POST',
                data: { id: id, estado: nuevoEstado },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        table.ajax.reload();
                    } else {
                        alert('Error al actualizar el estado: ' + response.message);
                    }
                },
                error: function() {
                    alert('Error en la comunicación con el servidor.');
                }
            });
        }
    };
});
