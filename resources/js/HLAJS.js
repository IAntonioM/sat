"use strict";

// Class definition
var KTHlaPage = function () {
    // Private variables
    var _yearSelect;
    var _printButton;

    // Private functions
    var _initYearSelect = function() {
        if (!_yearSelect) {
            return;
        }

        // Handle year select change
        _yearSelect.addEventListener('change', function(e) {
            e.preventDefault();

            // Show loading indicator
            KTApp.showPageLoading();

            // Fetch data for the selected year
            $.ajax({
                url: route('hla.data'),
                type: 'GET',
                data: {
                    year: _yearSelect.value
                },
                success: function(response) {
                    // Update the page content with new data
                    _updateHlaDetails(response.hlaDetails);
                    _updateHlaSummary(response.hlaSummary);

                    // Hide loading indicator
                    KTApp.hidePageLoading();
                },
                error: function(xhr) {
                    // Handle error
                    Swal.fire({
                        text: "Ha ocurrido un error al cargar los datos.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });

                    // Hide loading indicator
                    KTApp.hidePageLoading();
                }
            });
        });
    }

    var _initPrintButton = function() {
        if (!_printButton) {
            return;
        }

        _printButton.addEventListener('click', function(e) {
            e.preventDefault();

            // Redirect to export PDF route with current year
            const year = _yearSelect ? _yearSelect.value : new Date().getFullYear();
            window.location.href = route('hla.export-pdf', { year: year });
        });
    }

    var _updateHlaDetails = function(details) {
        // Loop through details and update the table rows
        if (!details || details.length === 0) {
            // Handle empty data case
            return;
        }

        // Clear existing rows
        const detailsContainer = document.querySelector('.hla-details-container');
        if (detailsContainer) {
            // Keep the header row and remove the rest
            const rows = detailsContainer.querySelectorAll('tr:not(.header-row)');
            rows.forEach(row => row.remove());

            // Add new rows
            details.forEach(detail => {
                const row = document.createElement('tr');

                // Populate row cells with data
                row.innerHTML = `
                    <td>${detail.id_anexo || ''}</td>
                    <td>${detail.direccion1 || ''}</td>
                    <td>${detail.frontis || ''}</td>
                    <td>${detail.zona || ''}</td>
                    <td>${detail.uso || ''}</td>
                    <td>${detail.porcen || ''}</td>
                    <td>${detail.resiso || '0.00'}</td>
                    <td>${detail.limpub || '0.00'}</td>
                    <td>${detail.parjar || '0.00'}</td>
                    <td>${detail.serena || '0.00'}</td>
                    <td>${detail.total || '0.00'}</td>
                `;

                detailsContainer.appendChild(row);
            });
        }
    }

    var _updateHlaSummary = function(summary) {
        // Update summary values
        if (!summary) {
            return;
        }

        // Update each summary field
        document.querySelector('.sum-resiso').textContent = summary.sum_resiso || '0.00';
        document.querySelector('.sum-limpub').textContent = summary.sum_limpub || '0.00';
        document.querySelector('.sum-parjar').textContent = summary.sum_parjar || '0.00';
        document.querySelector('.sum-serena').textContent = summary.sum_serena || '0.00';
        document.querySelector('.sum-total').textContent = summary.total || '0.00';
    }

    // Public methods
    return {
        init: function () {
            // Initialize elements
            _yearSelect = document.querySelector('#kt_hla_year_select');
            _printButton = document.querySelector('#kt_hla_print_btn');

            // Initialize handlers
            _initYearSelect();
            _initPrintButton();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTHlaPage.init();
});
