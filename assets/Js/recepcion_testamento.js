$(document).ready(function () {

    /* =========================================================
       MÁSCARA DE DUI  (00000000-0)
    ========================================================= */
    $('.dui-mask').on('input', function () {
        let val = $(this).val().replace(/\D/g, '');
        if (val.length > 9) val = val.slice(0, 9);
        if (val.length > 8) val = val.slice(0, 8) + '-' + val.slice(8);
        $(this).val(val);
    });

    /* =========================================================
       CARGA DE ÚLTIMOS TESTAMENTOS AL INICIAR
    ========================================================= */
    cargarUltimosTestamentos();

    function cargarUltimosTestamentos() {
        const tbody = $('#tbodyUltimosTestamentos');
        if (tbody.length === 0) return;

        $.ajax({
            url: '../controller/testamentos_recientes_controller.php',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                tbody.empty();
                if (data && data.length > 0) {
                    data.forEach(function (item) {
                        tbody.append(`
                            <tr>
                                <td>${item.fecha_registro}</td>
                                <td><span class="badge bg-secondary">${item.dui_testador || 'N/A'}</span></td>
                                <td><strong>${item.nombre_testador}</strong></td>
                                <td>${item.nombre_heredero} (${item.parentesco_heredero})</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary" title="Imprimir"
                                        onclick="window.open('../reportes/testamento.php?id=${item.id_testamento}', '_blank')">
                                        <i class="bi bi-printer-fill"></i>
                                    </button>
                                </td>
                            </tr>
                        `);
                    });
                } else {
                    tbody.append('<tr><td colspan="5" class="text-center text-muted">No hay testamentos generados recientemente.</td></tr>');
                }
            }
        });
    }

    /* =========================================================
       BÚSQUEDA DE CIUDADANO / TESTADOR
    ========================================================= */
    $('#searchForm').on('submit', function (e) {
        e.preventDefault();

        const query = $('#searchInput').val().trim();
        if (query === '') return;

        // Limpiar resultados previos
        $('#resultContainer').removeClass('d-none');
        $('#cardSuccess, #cardMultipleResults, #cardError').addClass('d-none');

        $.ajax({
            url: '../controller/buscar_ciudadano_controller.php',
            type: 'GET',
            data: { q: query },
            dataType: 'json',
            success: function (data) {
                if (data && data.length > 0) {
                    window.ciudadanosBusqueda = data;

                    if (data.length === 1) {
                        seleccionarCiudadano(0);
                    } else {
                        const tbody = $('#tbodyMultipleResults');
                        tbody.empty();
                        data.forEach(function (ciudadano, index) {
                            const nombre = ciudadano.nombres + ' ' + ciudadano.apellidos;
                            tbody.append(`
                                <tr>
                                    <td><strong>${nombre}</strong></td>
                                    <td>${ciudadano.DUI || '<span class="text-muted">N/A</span>'}</td>
                                    <td>${ciudadano.domicilio || '<span class="text-muted">No especificado</span>'}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                            onclick="seleccionarCiudadano(${index})">
                                            Seleccionar
                                        </button>
                                    </td>
                                </tr>
                            `);
                        });
                        $('#cardMultipleResults').removeClass('d-none');
                    }
                } else {
                    // No encontrado — pre-llenar el formulario con lo que se escribió
                    if ($('#formTestamento').length) $('#formTestamento')[0].reset();

                    if (/^[\d-]+$/.test(query)) {
                        $('#regDui').val(query);
                    } else {
                        $('#regNombreTestador').val(query);
                    }
                    $('#cardError').removeClass('d-none');
                }
            },
            error: function () {
                window.showToast('Hubo un error al conectar con el servidor.');
            }
        });
    });

    /* =========================================================
       GUARDAR TESTAMENTO  (un solo handler, sin duplicados)
    ========================================================= */
    $('#btnGuardarTestamento').on('click', function (e) {
        e.preventDefault();

        // Captura de datos desde el formulario real del modal
        const testamentoData = {
            nombre_testador: ($('#regNombreTestador').val() || '').trim(),
            dui:             ($('#regDui').val()            || '').trim(),
            edad:            $('#regEdad').val()            || '',
            estado_civil:    $('#regEstadoCivil').val()     || '',
            domicilio:       ($('#regDomicilio').val()      || '').trim(),
            heredero:        ($('#regHeredero').val()       || '').trim(),
            parentesco:      ($('#regParentesco').val()     || '').trim(),
            bienes:          ($('#regBienes').val()         || '').trim(),
            declaracion:     ($('#regDeclaracion').val()    || '').trim()
        };

        // Validación de campos obligatorios
        if (!testamentoData.nombre_testador || !testamentoData.dui ||
            !testamentoData.bienes         || !testamentoData.declaracion) {
            window.showToast('Debe completar: Nombre del Testador, DUI, Bienes y Declaración.');
            return;
        }

        Swal.fire({
            title: '¿Registrar Acto de Testamento?',
            text: 'Verifique que la información ingresada sea correcta antes de guardar.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1C3166',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar'
        }).then(function (result) {

            if (!result.isConfirmed) return;

            // Cerrar modal y limpiar backdrop antes del AJAX
            $('#modalTestamento').modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();

            $.ajax({
                // ✅ Ruta correcta que coincide con el controlador PHP real
                url: '../controller/guardarTestamento.php',
                type: 'POST',
                data: testamentoData,
                dataType: 'json',

                success: function (response) {
                    if (response.success) {
                        if ($('#formTestamento').length) $('#formTestamento')[0].reset();

                        cargarUltimosTestamentos();

                        Swal.fire({
                            icon: 'success',
                            title: '¡Testamento Registrado!',
                            text: 'El documento ha sido guardado en Munify.',
                            confirmButtonColor: '#1C3166',
                            confirmButtonText: '<i class="bi bi-printer-fill"></i> Abrir para Imprimir'
                        }).then(function () {
                            // Abrir reporte en nueva pestaña
                            window.open('../reportes/testamento.php?id=' + response.id_testamento, '_blank');

                            // ✅ Actualizar búsqueda para que el registro aparezca inmediatamente
                            $('#searchInput').val(testamentoData.nombre_testador);
                            $('#searchForm').trigger('submit');
                        });

                    } else {
                        // Restaurar modal si el servidor reporta error
                        $('#modalTestamento').modal('show');
                        window.showToast('Error: ' + (response.message || 'No se pudo guardar.'));
                    }
                },

                error: function (xhr) {
                    console.error('AJAX ERROR:', xhr.responseText);
                    $('#modalTestamento').modal('show');
                    Swal.fire({
                        icon: 'error',
                        title: 'Error del servidor',
                        text: 'Revise la consola (F12) para más detalles.'
                    });
                }
            });
        });
    });

}); // fin document.ready


/* =========================================================
   SELECCIONAR CIUDADANO DESDE LA TABLA DE MÚLTIPLES RESULTADOS
========================================================= */
window.seleccionarCiudadano = function (index) {
    if (!window.ciudadanosBusqueda || !window.ciudadanosBusqueda[index]) return;

    const ciudadano = window.ciudadanosBusqueda[index];
    const nombreCompleto = ciudadano.nombres + ' ' + ciudadano.apellidos;

    // Llenar tarjeta de resultado
    $('#resNombre').text(nombreCompleto);
    $('#resDui').text(ciudadano.DUI || 'N/A');
    $('#resHeredero').text('—');           // Se llenará si ya existe testamento

    // Llenar modal de vista previa
    $('#lblNombre').text(nombreCompleto);
    $('#lblDui').text(ciudadano.DUI || 'N/A');
    $('#lblHeredero').text('—');

    const btnAccion = $('#btnGenerarFicha');

    if (ciudadano.id_testamento) {
        // ── Ya tiene testamento registrado ──────────────────────
        btnAccion.html('<i class="bi bi-printer-fill me-2"></i> Imprimir Testamento');
        btnAccion.removeAttr('data-bs-toggle data-bs-target');

        btnAccion.off('click').on('click', function () {
            Swal.fire({
                icon: 'info',
                title: 'Documento Existente',
                text: 'Este ciudadano ya tiene un testamento registrado.',
                confirmButtonColor: '#1C3166',
                confirmButtonText: 'Abrir Documento'
            }).then(function () {
                window.open('../reportes/testamento.php?id=' + ciudadano.id_testamento, '_blank');
            });
        });

    } else {
        // ── Sin testamento: habilitar creación ──────────────────
        btnAccion.html('<i class="bi bi-file-earmark-plus-fill me-2"></i> Generar Testamento');
        btnAccion.attr('data-bs-toggle', 'modal');
        btnAccion.attr('data-bs-target', '#modalTestamento');
        btnAccion.off('click');

        // Pre-cargar datos del ciudadano en el formulario
        $('#regNombreTestador').val(nombreCompleto);
        $('#regDui').val(ciudadano.DUI || '');
        $('#regDomicilio').val(ciudadano.domicilio || '');
    }

    $('#cardMultipleResults').addClass('d-none');
    $('#cardSuccess').removeClass('d-none');

    window.selectedCiudadanoId = ciudadano.id_ciudadano;
};