// recepcion_defuncion.js - Placeholder
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
            $('#resDui').text('00000000-0');
            $('#resNac').text('12/05/2026');
            
            // Llenar etiquetas del modal
            $('#lblNombre').text(query.toUpperCase());
            $('#lblFechaDef').text('12/05/2026');
            $('#lblDeclarante').text('JUAN PEREZ');
        } else {
            $('#resultContainer').removeClass('d-none');
            $('#cardSuccess').addClass('d-none');
            $('#cardError').removeClass('d-none');
        }
    });

    $('#btnImprimirDefuncion').on('click', function() {
        window.open('CartaDefuncion.php', '_blank');
    });
});
