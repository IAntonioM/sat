// Actualización para usuariosJS.js
document.addEventListener('DOMContentLoaded', function () {
    // Inicializar componentes Select2 si existen
    if ($.fn.select2) {
        $('[data-control="select2"]').select2();
    }

    // Listener para el filtro de estado - USANDO EVENTOS SELECT2
    const estadoSelect = $('#estado_select');
    const buscarInput = $('#buscar_usuario');

    if (estadoSelect.length) {
        console.log('Selector encontrado, registrando eventos Select2...');

        // Usar el evento select2:select para detectar cambios
        estadoSelect.on('select2:select', function (e) {
            console.log('Estado seleccionado:', e.params.data.id);
            aplicarFiltros();
        });

        // También manejar el evento de cambio directo por si acaso
        estadoSelect.on('change', function() {
            console.log('Evento change en estado:', this.value);
            aplicarFiltros();
        });
    } else {
        console.error('No se encontró el selector Select2 para estado');
    }

    // También filtrar cuando se busca
    if (buscarInput.length) {
        buscarInput.on('keyup', function(e) {
            // Esperar a que el usuario termine de escribir
            if (e.keyCode === 13) { // Enter key
                aplicarFiltros();
            }
        });
    }
});
