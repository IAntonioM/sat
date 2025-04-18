// Agregar este script al final de tu vista o en un archivo JS separado
document.addEventListener('DOMContentLoaded', function() {
    // Manejar el checkbox principal (seleccionar todos)
    const checkboxPrincipal = document.querySelector('[data-kt-check="true"]');

    if (checkboxPrincipal) {
        checkboxPrincipal.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.checkbox-recibo');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            actualizarRecibosSeleccionados();
        });
    }

    // Manejar los checkboxes individuales
    const checkboxesIndividuales = document.querySelectorAll('.checkbox-recibo');
    checkboxesIndividuales.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            actualizarRecibosSeleccionados();
        });
    });

    // Manejar el envío del formulario de filtro
    const selectAnio = document.querySelector('select[name="anio"]');
    const selectTipoTributo = document.querySelector('select[name="tipo_tributo"]');

    if (selectAnio) {
        selectAnio.addEventListener('change', function() {
            aplicarFiltros();
        });
    }

    if (selectTipoTributo) {
        selectTipoTributo.addEventListener('change', function() {
            aplicarFiltros();
        });
    }

    // Función para aplicar filtros
    function aplicarFiltros() {
        const anio = selectAnio ? selectAnio.value : '%';
        const tipoTributo = selectTipoTributo ? selectTipoTributo.value : '%';

        // Redireccionar con los parámetros
        window.location.href = `{{ route('deudas.consolidadas') }}?anio=${anio}&tipo_tributo=${tipoTributo}`;
    }

    // Función para actualizar los recibos seleccionados
    function actualizarRecibosSeleccionados() {
        const checkboxesSeleccionados = document.querySelectorAll('.checkbox-recibo:checked');
        const contenedor = document.getElementById('recibos-seleccionados-container');

        // Limpiar contenedor
        contenedor.innerHTML = '';

        // Añadir inputs ocultos para cada recibo seleccionado
        checkboxesSeleccionados.forEach(checkbox => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'recibos_seleccionados[]';
            input.value = checkbox.getAttribute('data-id');
            contenedor.appendChild(input);
        });
    }
});
