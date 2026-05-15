// recepcion_minoridad.js - Placeholder
$(document).ready(function() {
    $('#searchForm').on('submit', function(e) {
        e.preventDefault();
        const query = $('#searchInput').val();
        if(query.length > 3) {
            // Simular búsqueda
            $('#resultContainer').removeClass('d-none');
            $('#cardError').addClass('d-none');
            $('#cardSuccess').removeClass('d-none');
            $('#resNombre').text(query.toUpperCase());
            $('#resNac').text('01/01/2015');
            
            // Llenar etiquetas del modal
            $('#lblNombre').text(query.toUpperCase());
        } else {
            $('#resultContainer').removeClass('d-none');
            $('#cardSuccess').addClass('d-none');
            $('#cardError').removeClass('d-none');
        }
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

    $('#btnImprimirCarnet').on('click', function() {
        window.open('Carnet minoridad.php', '_blank');
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
});
