// Archivo: public/js/deudas.js

document.addEventListener('DOMContentLoaded', function () {
    // Inicializar componentes Select2 si existen
    if ($.fn.select2) {
        $('[data-control="select2"]').select2();
    }

    // Inicializar el contador de deuda
    if ($.fn.countTo) {
        $('[data-kt-countup="true"]').each(function () {
            const el = this;
            const value = parseFloat(el.getAttribute('data-kt-countup-value'));
            const prefix = el.getAttribute('data-kt-countup-prefix') || '';

            $(el).countTo({
                from: 0,
                to: value,
                decimals: 2,
                duration: 1500,
                formatter: function (value, options) {
                    return prefix + value.toFixed(options.decimals).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            });
        });
    }

    // Listener para los filtros de año y tipo de tributo
    const anioSelect = document.getElementById('anio_select');
    const tipoTributoSelect = document.getElementById('tipo_tributo_select');

    if (anioSelect && tipoTributoSelect) {
        // Aplicar filtros cuando cambian los selectores
        anioSelect.addEventListener('change', aplicarFiltros);
        tipoTributoSelect.addEventListener('change', aplicarFiltros);
    }

    // Checkbox "Seleccionar todos"
    const checkAll = document.getElementById('check_all');
    if (checkAll) {
        checkAll.addEventListener('change', function () {
            const checkboxes = document.querySelectorAll('.check_deuda');
            checkboxes.forEach(checkbox => {
                checkbox.checked = checkAll.checked;
            });
        });
    }

    // Botón de pago
    const btnPagar = document.getElementById('btnPagar');
    if (btnPagar) {
        btnPagar.addEventListener('click', function (e) {
            e.preventDefault();

            const checkboxes = document.querySelectorAll('.check_deuda:checked');
            if (checkboxes.length === 0) {
                Swal.fire({
                    title: 'Atención',
                    text: 'Debe seleccionar al menos una deuda para pagar',
                    icon: 'warning',
                    confirmButtonText: 'Aceptar'
                });
                return;
            }

            // Calcular el total a pagar
            let total = 0;
            checkboxes.forEach(checkbox => {
                total += parseFloat(checkbox.getAttribute('data-monto'));
            });

            Swal.fire({
                title: 'Confirmar pago',
                text: `¿Desea pagar S/. ${total.toFixed(2)}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, pagar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('formPago').submit();
                }
            });
        });
    }
});

/**
 * Aplica los filtros de año y tipo de tributo
 */
function aplicarFiltros() {
    const anio = document.getElementById('anio_select').value;
    const tipoTributo = document.getElementById('tipo_tributo_select').value;
    const tablaDeudas = document.getElementById('tabla_deudas');
    const formFiltro = document.getElementById('filtroForm');

    // Mostrar cargando
    tablaDeudas.innerHTML = '<tr><td colspan="8" class="text-center">Cargando...</td></tr>';

    // Enviar solicitud AJAX para filtrar
    const formData = new FormData(formFiltro);

    fetch(formFiltro.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                actualizarTabla(data.deudas);
            } else {
                Swal.fire({
                    title: 'Error',
                    text: data.message || 'Ocurrió un error al filtrar las deudas',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error',
                text: 'Ocurrió un error al filtrar las deudas',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        });
}

/**
 * Actualiza la tabla con los datos filtrados
 * @param {Object} deudas - Datos de deudas agrupadas por año
 */
function actualizarTabla(deudas) {
    const tablaDeudas = document.getElementById('tabla_deudas');
    let html = '';
    let totalGeneral = 0;

    // Si no hay deudas
    if (Object.keys(deudas).length === 0) {
        html = '<tr><td colspan="8" class="text-center">No se encontraron deudas con los filtros seleccionados</td></tr>';
        tablaDeudas.innerHTML = html;
        return;
    }

    // Iterar por cada año
    for (const [anio, deudasAnio] of Object.entries(deudas)) {
        html += `
            <tr>
                <td colspan="8" style="background-color: #f1faff;color:#009ef7">
                    <i class="fa-solid fa-calendar-days" style="color:#009ef7"></i> <b>${anio}</b>
                </td>
            </tr>
        `;

        // Iterar por las deudas del año
        deudasAnio.forEach(deuda => {
            const tipoClase = deuda.tipo.includes('02.') ? 'badge-light-success' : 'badge-light-danger';
            totalGeneral += parseFloat(deuda.total);

            html += `
                <tr style="text-align: center; font-size:12px">
                    <td>
                        <div class="badge ${tipoClase}" style="font-size:12px">
                            ${deuda.mtipo1}
                        </div>
                    </td>
                    <td>${deuda.ano}-${deuda.periodo}</td>
                    <td>${parseFloat(deuda.imp_insol).toFixed(2)}</td>
                    <td>${parseFloat(deuda.imp_reaj).toFixed(2)}</td>
                    <td>${parseFloat(deuda.mora).toFixed(2)}</td>
                    <td>${parseFloat(deuda.costo_emis).toFixed(2)}</td>
                    <td>${parseFloat(deuda.total).toFixed(2)}</td>
                    <td class="text-end">
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            <input class="form-check-input check_deuda" name="id_recibos[]" type="checkbox"
                                value="${deuda.idrecibo}" data-monto="${deuda.total}" />
                        </div>
                    </td>
                </tr>
            `;
        });
    }

    // Agregar fila de total general si hay deudas
    if (totalGeneral > 0) {
        html += `
            <tr style="text-align: center; font-size:12px">
                <td style="background-color:#f1f1f2"></td>
                <td style="background-color:#f1f1f2"></td>
                <td style="background-color:#f1f1f2"></td>
                <td style="background-color:#f1f1f2"></td>
                <td style="background-color:#f1f1f2"></td>
                <td style="background-color:#f1f1f2;"><b>TOTAL</b></td>
                <td style="font-size: 16px;"><b>${totalGeneral.toFixed(2)}</b></td>
                <td style="background-color:#f1f1f2;"></td>
            </tr>
        `;
    }

    tablaDeudas.innerHTML = html;
}
