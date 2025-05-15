$(document).ready(function() {
    // Manejar selección de todos los checkboxes
    $('input[data-kt-check="true"]').change(function() {
        let isChecked = $(this).is(':checked');
        $('.checkbox-recibo').prop('checked', isChecked);
        updateTotalSeleccionado();
    });

    // Manejar selección individual de checkboxes
    $('.checkbox-recibo').change(function() {
        updateTotalSeleccionado();

        // Verificar si todos están seleccionados
        const allChecked = $('.checkbox-recibo:checked').length === $('.checkbox-recibo').length;
        $('input[data-kt-check="true"]').prop('checked', allChecked);
    });

    // Actualizar el total seleccionado
    function updateTotalSeleccionado() {
        let total = 0;
        $('.checkbox-recibo:checked').each(function() {
            total += parseFloat($(this).data('total') || 0);
        });

        // Mostrar el total en algún elemento (puedes añadir un elemento para mostrar esto)
        if ($('#totalSeleccionado').length === 0) {
            $('.card-toolbar').prepend('<div id="totalSeleccionado" class="me-3 fw-bold text-primary">Total Seleccionado: S/. <span>0.00</span></div>');
        }
        $('#totalSeleccionado span').text(total.toFixed(2));
    }

    // Manejar el botón de pago
    $('#btnPagar').click(function() {
        const selectedItems = [];

        // Verificar si hay items seleccionados
        if ($('.checkbox-recibo:checked').length === 0) {
            Swal.fire({
                title: 'Advertencia',
                text: 'Debe seleccionar al menos una deuda para pagar',
                icon: 'warning',
                confirmButtonText: 'Aceptar'
            });
            return;
        }

        // Recopilar los items seleccionados
        $('.checkbox-recibo:checked').each(function() {
            selectedItems.push($(this).val());
        });

        // Confirmar antes de proceder
        Swal.fire({
            title: '¿Está seguro?',
            text: `Va a proceder con el pago de ${selectedItems.length} deuda(s) por un total de S/. ${$('#totalSeleccionado span').text()}`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, proceder',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Proceder con el pago
                procesarPago(selectedItems);
            }
        });
    });

    // Función para procesar el pago
    function procesarPago(items) {
        // Mostrar loader
        Swal.fire({
            title: 'Procesando',
            text: 'Por favor espere mientras procesamos su pago...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Enviar solicitud AJAX
        $.ajax({
            url: route('consolidado.pagar'),
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                items: items
            },
            dataType: 'json',
            success: function(response) {
                Swal.close();

                if (response.status === 'success') {
                    Swal.fire({
                        title: 'Éxito',
                        text: 'El pago se ha procesado correctamente',
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        // Recargar la página para actualizar el listado
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: response.message || 'Ocurrió un error al procesar el pago',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.close();

                let errorMessage = 'Ocurrió un error al procesar el pago';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                Swal.fire({
                    title: 'Error',
                    text: errorMessage,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        });
    }
});
