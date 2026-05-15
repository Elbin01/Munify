$(document).ready(function() {
    // Cargar últimas minoridades al iniciar
    cargarUltimasMinoridades();

    function cargarUltimasMinoridades() {
        $.ajax({
            url: '../controller/minoridad_recientes_controller.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                const tbody = $('#tbodyUltimasMinoridades');
                if (tbody.length === 0) return;
                tbody.empty();
                
                if (data && data.length > 0) {
                    data.forEach(item => {
                        const nombre = item.nombres + ' ' + item.apellidos;
                        const fila = `
                            <tr>
                                <td>${item.fecha_emision}</td>
                                <td>${item.numero_carnet}</td>
                                <td>${nombre}</td>
                                <td>${item.fecha_vencimiento}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-secondary" title="Ver Detalle" onclick="window.open('../reportes/carnet_minoridad.php?id=${item.id_carnet}', '_blank')">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                        tbody.append(fila);
                    });
                } else {
                    tbody.append('<tr><td colspan="5" class="text-center text-muted">No hay carnets generados recientemente.</td></tr>');
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

    // Buscar Responsable por DUI
    $('#btnBuscarResponsable').on('click', function() {
        const dui = $('#duiResponsable').val().trim();
        if (dui.length < 10) return alert('DUI inválido');
        
        $.ajax({
            url: '../controller/buscar_ciudadano_controller.php',
            type: 'GET',
            data: { q: dui },
            dataType: 'json',
            success: function(data) {
                if (data && data.length > 0) {
                    $('#regNombreResponsable').val(data[0].nombres + ' ' + data[0].apellidos);
                } else {
                    alert('Responsable no encontrado');
                }
            }
        });
    });

    // Vista previa de imagen
    $('#regFoto').on('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#photoImg').attr('src', e.target.result).show();
                $('#photoIcon').hide();
            }
            reader.readAsDataURL(file);
        }
    });

    $('#searchForm').on('submit', function(e) {
        e.preventDefault(); 
        const query = $('#searchInput').val().trim();
        if(query === '') return;

        $('#resultContainer').removeClass('d-none');
        $('#cardSuccess').addClass('d-none');
        $('#cardMultipleResults').addClass('d-none');
        $('#cardError').addClass('d-none');

        $.ajax({
            url: '../controller/buscar_ciudadano_controller.php',
            type: 'GET',
            data: { q: query },
            dataType: 'json',
            success: function(data) {
                if (data && data.length > 0) {
                    window.ciudadanosBusqueda = data;
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
                    $('#formMinoridad')[0].reset(); 
                    $('#regNombres').val(query);
                    $('#cardError').removeClass('d-none');
                }
            },
            error: function() {
                alert("Hubo un error al conectar con la base de datos.");
            }
        });
    });

    // Guardar registro de minoridad
    $('#btnGuardarMinoridad').on('click', function() {
        const citizenData = {
            nombres: $('#regNombres').val().trim(),
            apellidos: $('#regApellidos').val().trim(),
            fecha_nacimiento: $('#regFechaNac').val(),
            sexo: $('#regSexo').val()
        };

        if (citizenData.nombres === '' || citizenData.apellidos === '' || citizenData.fecha_nacimiento === '') {
            alert('Los campos Nombres, Apellidos y Fecha de Nacimiento son obligatorios.');
            return;
        }

        $.ajax({
            url: '../controller/guardar_ciudadano_controller.php',
            type: 'POST',
            data: citizenData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const id_ciudadano = response.id_ciudadano;
                    guardarExpedienteMinoridad(id_ciudadano);
                } else {
                    alert('Error al registrar menor: ' + response.message);
                }
            },
            error: function() {
                alert('Hubo un error al procesar el registro del menor.');
            }
        });
    });

    function guardarExpedienteMinoridad(id_ciudadano) {
        const data = {
            id_ciudadano: id_ciudadano,
            numero_carnet: 'CM-' + Math.floor(Math.random() * 1000000),
            lugar_estudio: $('#regDireccion').val().trim(), // Usando dirección como placeholder o lugar estudio
            color_piel: 'Trigueño', // Opciones fijas o añadir al modal
            color_ojos: 'Café',
            color_cabello: 'Negro',
            senales_especiales: 'Ninguna'
        };

        $.ajax({
            url: '../controller/guardar_minoridad_controller.php',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert('Expediente de minoridad guardado correctamente.');
                    $('#modalMinoridad').modal('hide');
                    $('#formMinoridad')[0].reset();
                    $('#searchInput').val(id_ciudadano);
                    $('#searchForm').submit();
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function() {
                alert('Hubo un error al procesar la solicitud del expediente.');
            }
        });
    }

    // Imprimir carnet
    $('#btnImprimirCarnet').on('click', function() {
        if (!window.selectedCiudadanoId) {
            alert('Error: No se ha seleccionado un menor.');
            return;
        }

        if (window.selectedCarnetId) {
            window.open(`../reportes/carnet_minoridad.php?id=${window.selectedCarnetId}`, '_blank');
        } else {
            // Generar uno nuevo si no existe
            guardarExpedienteMinoridad(window.selectedCiudadanoId);
        }
    });
});

window.seleccionarCiudadano = function(index) {
    if (!window.ciudadanosBusqueda || !window.ciudadanosBusqueda[index]) return;
    
    const ciudadano = window.ciudadanosBusqueda[index];
    const nombreCompleto = ciudadano.nombres + ' ' + ciudadano.apellidos;
    
    $('#resNombre').text(nombreCompleto);
    $('#resNac').text(ciudadano.fecha_nacimiento || 'N/A');
    
    $('#lblNombre').text(nombreCompleto);

    const btnAccion = $('#btnAccionPartida');
    if (ciudadano.id_carnet) {
        window.selectedCarnetId = ciudadano.id_carnet;
        btnAccion.html('<i class="bi bi-printer-fill me-2"></i> Imprimir Carnet');
        btnAccion.removeAttr('data-bs-toggle').removeAttr('data-bs-target');
        btnAccion.off('click').on('click', function() {
            window.open(`../reportes/carnet_minoridad.php?id=${ciudadano.id_carnet}`, '_blank');
        });
    } else {
        window.selectedCarnetId = null;
        btnAccion.html('<i class="bi bi-file-earmark-plus-fill me-2"></i> Generar Carnet');
        btnAccion.attr('data-bs-toggle', 'modal').attr('data-bs-target', '#modalPartida');
        btnAccion.off('click');
    }

    $('#cardMultipleResults').addClass('d-none');
    $('#cardSuccess').removeClass('d-none');
    window.selectedCiudadanoId = ciudadano.id_ciudadano;
};
