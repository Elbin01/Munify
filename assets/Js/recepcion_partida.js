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
                window.showToast("Hubo un error al conectar con la base de datos.");
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
            window.showToast('Los campos Nombres y Apellidos son obligatorios.');
            return;
        }

        Swal.fire({
            title: '¿Guardar ciudadano?',
            text: "Verifique que los datos ingresados sean correctos.",
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
                    data: data,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            window.showToast(response.message);
                            $('#modalCiudadano').modal('hide');
                            $('#formCiudadano')[0].reset();
                            $('#searchInput').val(data.dui || data.nombres);
                            $('#searchForm').submit();
                        } else {
                            window.showToast('Error: ' + response.message);
                        }
                    },
                    error: function() {
                        window.showToast('Hubo un error al procesar la solicitud.');
                    }
                });
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

    // Validar mayoría de edad para habilitar/deshabilitar DUI
    $('#regFechaNac').on('change', function() {
        const fechaVal = $(this).val();
        if (!fechaVal) {
            $('#modalRegDui').prop('disabled', false);
            return;
        }

        const fechaNac = new Date(fechaVal);
        const hoy = new Date();
        let edad = hoy.getFullYear() - fechaNac.getFullYear();
        const m = hoy.getMonth() - fechaNac.getMonth();
        
        if (m < 0 || (m === 0 && hoy.getDate() < fechaNac.getDate())) {
            edad--;
        }

        if (edad >= 18) {
            $('#modalRegDui').prop('disabled', false);
        } else {
            $('#modalRegDui').prop('disabled', true).val(''); // Deshabilitar y limpiar campo
        }
    });

    // Buscar Padre por DUI
    $('#btnBuscarPadre').on('click', function() {
        const dui = $('#duiPadre').val().trim();
        if (dui.length < 10) return window.showToast('DUI inválido');
        
        $.ajax({
            url: '../controller/buscar_ciudadano_controller.php',
            type: 'GET',
            data: { q: dui },
            dataType: 'json',
            success: function(data) {
                if (data && data.length > 0) {
                    $('#regNombrePadre').val(data[0].nombres + ' ' + data[0].apellidos);
                } else {
                    window.showToast('Padre no encontrado');
                }
            }
        });
    });

    // Buscar Madre por DUI
    $('#btnBuscarMadre').on('click', function() {
        const dui = $('#duiMadre').val().trim();
        if (dui.length < 10) return window.showToast('DUI inválido');
        
        $.ajax({
            url: '../controller/buscar_ciudadano_controller.php',
            type: 'GET',
            data: { q: dui },
            dataType: 'json',
            success: function(data) {
                if (data && data.length > 0) {
                    $('#regNombreMadre').val(data[0].nombres + ' ' + data[0].apellidos);
                } else {
                    window.showToast('Madre no encontrada');
                }
            }
        });
    });

    // Generar e imprimir partida
    $('#btnImprimirPartida').on('click', function() {
        if (!window.selectedCiudadanoId) {
            window.showToast('Error: No se ha seleccionado un ciudadano.');
            return;
        }

        const data = {
            id_ciudadano: window.selectedCiudadanoId,
            numero_partida: $('#partidaNum').val().trim(),
            libro: $('#partidaLibro').val().trim(),
            folio: $('#partidaFolio').val().trim()
        };

        if (data.numero_partida === '') {
            window.showToast('El número de partida es obligatorio.');
            return;
        }

        Swal.fire({
            title: '¿Generar Partida?',
            text: "Se registrará oficialmente en el tomo y folio indicados.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1C3166',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, generar e imprimir',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../controller/guardar_partida_controller.php',
                    type: 'POST',
                    data: data,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('#modalPartida').modal('hide');
                            $('#formGenerarPartida')[0].reset();
                            cargarUltimasPartidas();
                            
                            Swal.fire({
                                icon: 'success',
                                title: '¡Partida Generada!',
                                text: 'El documento ha sido registrado y está listo para imprimir.',
                                confirmButtonColor: '#1C3166',
                                confirmButtonText: '<i class="bi bi-printer-fill"></i> Abrir Documento'
                            }).then(() => {
                                window.open(`../reportes/partida_nacimiento.php?id=${response.id_partida}`, '_blank');
                            });
                        } else {
                            window.showToast('Error: ' + response.message);
                        }
                    },
                    error: function() {
                        window.showToast('Hubo un error al procesar la solicitud.');
                    }
                });
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
            Swal.fire({
                icon: 'info',
                title: 'Documento Existente',
                text: 'La Partida de Nacimiento ya está generada en el sistema.',
                confirmButtonColor: '#1C3166',
                confirmButtonText: '<i class="bi bi-printer-fill"></i> Imprimir Documento'
            }).then(() => {
                window.open(`../reportes/partida_nacimiento.php?id=${ciudadano.id_partida}`, '_blank');
            });
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
