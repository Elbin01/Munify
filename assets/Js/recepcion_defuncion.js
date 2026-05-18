$(document).ready(function() {
    // Cargar últimas defunciones al iniciar
    cargarUltimasDefunciones();

    function cargarUltimasDefunciones() {
        $.ajax({
            url: '../controller/defunciones_recientes_controller.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                const tbody = $('#tbodyUltimasDefunciones');
                if (tbody.length === 0) return; // Si no existe el elemento en el view
                tbody.empty();
                
                if (data && data.length > 0) {
                    data.forEach(item => {
                        const nombre = item.nombres + ' ' + item.apellidos;
                        const dui = item.DUI || 'N/A';
                        const fila = `
                            <tr>
                                <td>${item.fecha_emision}</td>
                                <td>${dui}</td>
                                <td>${nombre}</td>
                                <td>${item.causa || 'Natural'}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-secondary" title="Ver Detalle" onclick="window.open('../reportes/carta_defuncion.php?id=${item.id_carta}', '_blank')">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                        tbody.append(fila);
                    });
                } else {
                    tbody.append('<tr><td colspan="5" class="text-center text-muted">No hay actas generadas recientemente.</td></tr>');
                }
            }
        });
    }

    // Máscara para DUI (00000000-0)
    $('.dui-mask').on('input', function() {
        let val = $(this).val().replace(/\D/g, ''); // Solo números
        if (val.length > 9) val = val.slice(0, 9); // Máximo 9 dígitos
        
        if (val.length > 8) {
            val = val.slice(0, 8) + '-' + val.slice(8);
        }
        $(this).val(val);
    });

    // Buscar Declarante por DUI en Modal
    $('#btnBuscarDeclarante').on('click', function() {
        const dui = $('#duiDeclarante').val().trim();
        if (dui.length < 10) {
            window.showToast('Por favor ingrese un DUI válido (00000000-0)');
            return;
        }

        $.ajax({
            url: '../controller/buscar_ciudadano_controller.php',
            type: 'GET',
            data: { q: dui },
            dataType: 'json',
            success: function(data) {
                if (data && data.length > 0) {
                    const c = data[0];
                    $('#regNombreDeclarante').val(c.nombres + ' ' + c.apellidos);
                } else {
                    window.showToast('No se encontró ningún ciudadano con ese DUI.');
                }
            }
        });
    });

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
                        seleccionarCiudadano(0);
                    } else {
                        const tbody = $('#tbodyMultipleResults');
                        tbody.empty();
                        
                        data.forEach((ciudadano, index) => {
                            const nombreCompleto = ciudadano.nombres + ' ' + ciudadano.apellidos;
                            const fila = `
                                <tr>
                                    <td><strong>${nombreCompleto}</strong></td>
                                    <td>${ciudadano.DUI || '<span class="text-muted">N/A</span>'}</td>
                                    <td>${ciudadano.fecha_defuncion || '<span class="text-muted">Vivo</span>'}</td>
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
                    $('#formDefuncion')[0].reset(); 
                    if (/^[\d-]+$/.test(query)) {
                        $('#modalRegDui').val(query); 
                    } else {
                        $('#regNombres').val(query);
                    }
                    $('#cardError').removeClass('d-none');
                }
            },
            error: function() {
                window.showToast("Hubo un error al conectar con la base de datos.");
            }
        });
    });

    // Guardar registro de defunción (Ciudadano + Carta)
    $('#btnGuardarDefuncion').on('click', function() {
        const citizenData = {
            nombres: $('#regNombres').val().trim(),
            apellidos: $('#regApellidos').val().trim(),
            dui: $('#modalRegDui').val().trim()
        };

        const defuncionData = {
            fecha_defuncion: $('#regFechaDef').val(),
            hora_defuncion: $('#regHoraDef').val(),
            lugar_defuncion: $('#regLugarDef').val().trim(),
            nombre_declarante: $('#regNombreDeclarante').val().trim(),
            dui_declarante: $('#duiDeclarante').val().trim()
        };

        if (citizenData.nombres === '' || citizenData.apellidos === '' || defuncionData.fecha_defuncion === '') {
            window.showToast('Los campos Nombres, Apellidos y Fecha de Defunción son obligatorios.');
            return;
        }

        Swal.fire({
            title: '¿Guardar Acta de Defunción?',
            text: "Verifique que todos los datos ingresados sean correctos.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1C3166',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../controller/guardar_ciudadano_controller.php',
                    type: 'POST',
                    data: citizenData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            const id_ciudadano = response.id_ciudadano;
                            guardarCartaDefuncion(id_ciudadano, defuncionData);
                        } else {
                            window.showToast('Error al registrar ciudadano: ' + response.message);
                        }
                    },
                    error: function() {
                        window.showToast('Hubo un error al procesar el registro del ciudadano.');
                    }
                });
            }
        });
    });

    function guardarCartaDefuncion(id_ciudadano, data) {
        $.ajax({
            url: '../controller/guardar_defuncion_controller.php',
            type: 'POST',
            data: {
                id_ciudadano: id_ciudadano,
                fecha_defuncion: data.fecha_defuncion,
                lugar_defuncion: data.lugar_defuncion,
                causa: 'Muerte natural / Pendiente', // Se podría agregar campo en el modal
                nombre_declarante: data.nombre_declarante,
                parentesco_declarante: 'Familiar' // Se podría agregar campo en el modal
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#modalDefuncion').modal('hide');
                    $('#formDefuncion')[0].reset();
                    const nombreBusqueda = $('#resNombre').text() || ($('#regNombres').val() + ' ' + $('#regApellidos').val());
                    $('#searchInput').val(nombreBusqueda.trim());
                    $('#searchForm').submit();
                    
                    Swal.fire({
                        icon: 'success',
                        title: '¡Acta Generada!',
                        text: 'El Acta de Defunción ha sido registrada y está lista para imprimir.',
                        confirmButtonColor: '#1C3166',
                        confirmButtonText: '<i class="bi bi-printer-fill"></i> Abrir Acta'
                    }).then(() => {
                        window.open(`../reportes/carta_defuncion.php?id=${response.id_carta}`, '_blank');
                    });
                } else {
                    window.showToast('Error: ' + response.message);
                }
            },
            error: function() {
                window.showToast('Hubo un error al procesar la solicitud del acta.');
            }
        });
    }

    // Generar e imprimir carta
    $('#btnImprimirDefuncion').on('click', function() {
        if (!window.selectedCiudadanoId) {
            window.showToast('Error: No se ha seleccionado un ciudadano.');
            return;
        }

        const data = {
            id_ciudadano: window.selectedCiudadanoId,
            fecha_defuncion: $('#lblFechaDef').text(), // Ya cargado al seleccionar
            lugar_defuncion: '---', // Opcional si se quiere pedir en el modal
            nombre_declarante: $('#lblDeclarante').text()
        };

        Swal.fire({
            title: '¿Imprimir Carta?',
            text: "Se generará el acta de defunción oficial.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1C3166',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, imprimir',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                if (window.selectedDefuncionId) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Imprimiendo',
                        text: 'Abriendo el acta en una nueva pestaña...',
                        confirmButtonColor: '#1C3166',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.open(`../reportes/carta_defuncion.php?id=${window.selectedDefuncionId}`, '_blank');
                    });
                } else {
                    const defData = {
                        id_ciudadano: window.selectedCiudadanoId,
                        fecha_defuncion: $('#regFechaDef_modal').val() || new Date().toISOString().split('T')[0],
                        lugar_defuncion: $('#partidaLibro').val(),
                        causa: 'Muerte natural',
                        nombre_declarante: $('#lblDeclarante').text()
                    };

                    $.ajax({
                        url: '../controller/guardar_defuncion_controller.php',
                        type: 'POST',
                        data: defData,
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                $('#modalPartida').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Acta Generada!',
                                    text: 'El Acta de Defunción ha sido registrada y está lista para imprimir.',
                                    confirmButtonColor: '#1C3166',
                                    confirmButtonText: '<i class="bi bi-printer-fill"></i> Abrir Acta'
                                }).then(() => {
                                    window.open(`../reportes/carta_defuncion.php?id=${response.id_carta}`, '_blank');
                                });
                            } else {
                                window.showToast('Error: ' + response.message);
                            }
                        }
                    });
                }
            }
        });
    });
});

window.seleccionarCiudadano = function(index) {
    if (!window.ciudadanosBusqueda || !window.ciudadanosBusqueda[index]) return;
    
    const ciudadano = window.ciudadanosBusqueda[index];
    const nombreCompleto = ciudadano.nombres + ' ' + ciudadano.apellidos;
    
    $('#resNombre').text(nombreCompleto);
    $('#resDui').text(ciudadano.DUI || 'N/A');
    $('#resNac').text(ciudadano.fecha_defuncion || 'N/A');
    
    $('#lblNombre').text(nombreCompleto);
    $('#lblFechaDef').text(ciudadano.fecha_defuncion || 'N/A');
    $('#lblDeclarante').text(ciudadano.nombre_declarante || 'No registrado');

    const btnAccion = $('#btnAccionPartida');
    if (ciudadano.id_carta) {
        window.selectedDefuncionId = ciudadano.id_carta;
        btnAccion.html('<i class="bi bi-printer-fill me-2"></i> Imprimir Carta');
        btnAccion.removeAttr('data-bs-toggle').removeAttr('data-bs-target');
        btnAccion.off('click').on('click', function() {
            Swal.fire({
                icon: 'info',
                title: 'Documento Existente',
                text: 'El Acta de Defunción ya está generada en el sistema.',
                confirmButtonColor: '#1C3166',
                confirmButtonText: '<i class="bi bi-printer-fill"></i> Imprimir Acta'
            }).then(() => {
                window.open(`../reportes/carta_defuncion.php?id=${ciudadano.id_carta}`, '_blank');
            });
        });
    } else {
        window.selectedDefuncionId = null;
        btnAccion.html('<i class="bi bi-file-earmark-plus-fill me-2"></i> Generar Carta');
        btnAccion.attr('data-bs-toggle', 'modal').attr('data-bs-target', '#modalPartida');
        btnAccion.off('click');
    }

    $('#cardMultipleResults').addClass('d-none');
    $('#cardSuccess').removeClass('d-none');
    window.selectedCiudadanoId = ciudadano.id_ciudadano;
};
