$(document).ready(function() {
    // Inicializar DataTable
    const table = $('#tablaCitas').DataTable({
        "ajax": {
            "url": "../controller/obtener_citas_controller.php",
            "dataSrc": ""
        },
        "columns": [
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
                "render": function(data, type, row) {
                    return `
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-outline-primary" onclick="verDetalle(${row.id_cita})" title="Ver Detalles">
                                <i class="bi bi-eye-fill"></i> Revisar
                            </button>
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
        "order": [[3, "asc"], [4, "asc"]],
        "dom": '<"row mb-3"<"col-md-6"l><"col-md-6"f>>rt<"row mt-3"<"col-md-6"i><"col-md-6"p>>',
        "initComplete": function(settings, json) {
            $('.dataTables_filter input').addClass('form-control shadow-none border-secondary-subtle');
            $('.dataTables_filter input').attr('placeholder', 'Buscar en toda la tabla...');
            $('.dataTables_length select').addClass('form-select shadow-none border-secondary-subtle');
        }
    });

    table.column(5).search($('#filterEstado').val()).draw();

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
        table.column(2).search(this.value).draw();
    });

    $('#filterEstado').on('change', function() {
        table.column(5).search(this.value).draw();
    });

    $('#btnLimpiarFiltros').on('click', function() {
        $('#filterTramite').val('');
        $('#filterEstado').val('pendiente');
        table.column(2).search('').column(5).search('pendiente').draw();
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
