$(document).ready(function() {
    // Cargar últimas minoridades al iniciar
    cargarUltimasMinoridades();

    // Restringir el calendario de fecha de nacimiento a menores de 18 años
    const hoy = new Date();
    const fechaLimite = new Date();
    fechaLimite.setFullYear(fechaLimite.getFullYear() - 18);
    fechaLimite.setDate(fechaLimite.getDate() + 1); // Estrictamente menor de 18
    
    const minAnio = fechaLimite.getFullYear();
    const minMes = String(fechaLimite.getMonth() + 1).padStart(2, '0');
    const minDia = String(fechaLimite.getDate()).padStart(2, '0');
    const minFechaAttr = `${minAnio}-${minMes}-${minDia}`;
    
    const maxAnio = hoy.getFullYear();
    const maxMes = String(hoy.getMonth() + 1).padStart(2, '0');
    const maxDia = String(hoy.getDate()).padStart(2, '0');
    const maxFechaAttr = `${maxAnio}-${maxMes}-${maxDia}`;

    $('#regFechaNac').attr('min', minFechaAttr);
    $('#regFechaNac').attr('max', maxFechaAttr);

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
                                    <button class="btn btn-sm btn-outline-secondary" title="Ver Detalle" onclick="window.open('../reportes/ver_carnet_3d.php?id=${item.id_carnet}', '_blank')">
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
        if (dui.length < 10) return window.showToast('DUI inválido');
        
        $.ajax({
            url: '../controller/buscar_ciudadano_controller.php',
            type: 'GET',
            data: { q: dui },
            dataType: 'json',
            success: function(data) {
                if (data && data.length > 0) {
                    $('#regNombreResponsable').val(data[0].nombres + ' ' + data[0].apellidos);
                } else {
                    window.showToast('Responsable no encontrado');
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
                // Filtrar solo menores de 18 años
                if (data && data.length > 0) {
                    data = data.filter(ciudadano => {
                        if (!ciudadano.fecha_nacimiento) return false;
                        
                        const partes = ciudadano.fecha_nacimiento.split('-');
                        if (partes.length !== 3) return false;
                        
                        const birthYear = parseInt(partes[0], 10);
                        const birthMonth = parseInt(partes[1], 10) - 1;
                        const birthDay = parseInt(partes[2], 10);
                        
                        const birthDate = new Date(birthYear, birthMonth, birthDay);
                        const today = new Date();
                        
                        let age = today.getFullYear() - birthDate.getFullYear();
                        const monthDiff = today.getMonth() - birthDate.getMonth();
                        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                            age--;
                        }
                        
                        return age < 18;
                    });
                }

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
                window.showToast("Hubo un error al conectar con la base de datos.");
            }
        });
    });

    // Guardar registro de minoridad
    $('#btnGuardarMinoridad').on('click', function() {
        const citizenData = {
            nombres: $('#regNombres').val().trim(),
            apellidos: $('#regApellidos').val().trim(),
            fecha_nacimiento: $('#regFechaNac').val(),
            sexo: $('#regSexo').val(),
            lugar_nacimiento: $('#regLugarNac').val().trim(),
            nombre_padre: $('#regNombrePadre').val().trim(),
            nombre_madre: $('#regNombreMadre').val().trim()
        };

        if (citizenData.nombres === '' || citizenData.apellidos === '' || citizenData.fecha_nacimiento === '') {
            window.showToast('Los campos Nombres, Apellidos y Fecha de Nacimiento son obligatorios.');
            return;
        }

        // Validar que sea menor de 18 años antes de guardar
        const partes = citizenData.fecha_nacimiento.split('-');
        const birthYear = parseInt(partes[0], 10);
        const birthMonth = parseInt(partes[1], 10) - 1;
        const birthDay = parseInt(partes[2], 10);
        const birthDate = new Date(birthYear, birthMonth, birthDay);
        const today = new Date();
        
        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        
        if (age >= 18) {
            window.showToast('Error: El ciudadano registrado debe ser menor de 18 años para emitir un carnet de minoridad.');
            return;
        }

        Swal.fire({
            title: '¿Guardar y generar carnet?',
            text: "Verifique que los datos del menor sean correctos.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1C3166',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, generar',
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
                            guardarExpedienteMinoridad(id_ciudadano);
                        } else {
                            window.showToast('Error al registrar menor: ' + response.message);
                        }
                    },
                    error: function() {
                        window.showToast('Hubo un error al procesar el registro del menor.');
                    }
                });
            }
        });
    });

    function guardarExpedienteMinoridad(id_ciudadano) {
        const data = {
            id_ciudadano: id_ciudadano,
            numero_carnet: 'CM-' + Math.floor(Math.random() * 1000000),
            lugar_estudio: $('#regLugarEstudio').val().trim(),
            color_piel: $('#regColorPiel').val().trim() || 'No especificado',
            color_ojos: $('#regColorOjos').val().trim() || 'No especificado',
            color_cabello: $('#regColorCabello').val().trim() || 'No especificado',
            senales_especiales: $('#regSenales').val().trim() || 'Ninguna'
        };

        $.ajax({
            url: '../controller/guardar_minoridad_controller.php',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#modalMinoridad').modal('hide');
                    $('#formMinoridad')[0].reset();
                    const nombreBusqueda = $('#resNombre').text() || ($('#regNombres').val() + ' ' + $('#regApellidos').val());
                    $('#searchInput').val(nombreBusqueda.trim());
                    $('#searchForm').submit();
                    
                    Swal.fire({
                        icon: 'success',
                        title: '¡Carnet Generado!',
                        text: 'El Carnet de Minoridad ha sido registrado y está listo para imprimir.',
                        confirmButtonColor: '#1C3166',
                        confirmButtonText: '<i class="bi bi-printer-fill"></i> Abrir Carnet'
                    }).then(() => {
                        window.open(`../reportes/carnet_minoridad.php?id=${response.id_carnet}`, '_blank');
                    });
                } else {
                    window.showToast('Error: ' + response.message);
                }
            },
            error: function() {
                window.showToast('Hubo un error al procesar la solicitud del expediente.');
            }
        });
    }

    // Imprimir carnet
    $('#btnImprimirCarnet').on('click', function() {
        if (!window.selectedCiudadanoId) {
            window.showToast('Error: No se ha seleccionado un menor.');
            return;
        }

        Swal.fire({
            title: '¿Imprimir Carnet?',
            text: "Se generará el carnet de minoridad.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1C3166',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, imprimir',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                if (window.selectedCarnetId) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Imprimiendo',
                        text: 'Abriendo el carnet en una nueva pestaña...',
                        confirmButtonColor: '#1C3166',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.open(`../reportes/carnet_minoridad.php?id=${window.selectedCarnetId}`, '_blank');
                    });
                } else {
                    // Generar uno nuevo si no existe
                    guardarExpedienteMinoridad(window.selectedCiudadanoId);
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
    $('#resNac').text(ciudadano.fecha_nacimiento || 'N/A');
    
    $('#lblNombre').text(nombreCompleto);

    const btnAccion = $('#btnAccionPartida');
    if (ciudadano.id_carnet) {
        window.selectedCarnetId = ciudadano.id_carnet;
        btnAccion.html('<i class="bi bi-printer-fill me-2"></i> Imprimir Carnet');
        btnAccion.removeAttr('data-bs-toggle').removeAttr('data-bs-target');
        btnAccion.off('click').on('click', function() {
            Swal.fire({
                icon: 'info',
                title: 'Documento Existente',
                text: 'El Carnet de Minoridad ya está generado en el sistema.',
                confirmButtonColor: '#1C3166',
                confirmButtonText: '<i class="bi bi-printer-fill"></i> Imprimir Carnet'
            }).then(() => {
                window.open(`../reportes/carnet_minoridad.php?id=${ciudadano.id_carnet}`, '_blank');
            });
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
