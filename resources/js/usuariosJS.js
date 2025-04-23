// Archivo: public/js/usuariosJS.js

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

/**
 * Aplica los filtros de estado y búsqueda
 */
function aplicarFiltros() {
    console.log('Aplicando filtros...');

    const estado = document.getElementById('estado_select').value;
    const busqueda = document.getElementById('buscar_usuario').value;
    const tablaUsuarios = document.getElementById('tabla_usuarios');
    const formFiltro = document.getElementById('filtroForm');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    console.log('Filtros a aplicar:', { estado, busqueda });

    // Mostrar cargando
    tablaUsuarios.innerHTML = '<tr><td colspan="6" class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div></td></tr>';

    // Preparar los datos del formulario
    const formData = new FormData();
    formData.append('_token', csrfToken);
    formData.append('estado', estado);
    formData.append('buscar', busqueda);

    console.log('Enviando solicitud a:', formFiltro.action);

    // Enviar solicitud AJAX para filtrar
    fetch(formFiltro.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        console.log('Respuesta recibida:', response.status);
        if (!response.ok) {
            throw new Error('Error en la respuesta del servidor: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        console.log('Datos recibidos:', data);
        if (data.status === 'success') {
            actualizarTabla(data.usuarios);
        } else {
            Swal.fire({
                title: 'Error',
                text: data.message || 'Ocurrió un error al filtrar los usuarios',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        }
    })
    .catch(error => {
        console.error('Error en la solicitud:', error);
        tablaUsuarios.innerHTML = '<tr><td colspan="6" class="text-center text-danger">Error al cargar los datos. Por favor, intente nuevamente.</td></tr>';

        Swal.fire({
            title: 'Error',
            text: 'Ocurrió un error al filtrar los usuarios: ' + error.message,
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
    });
}

/**
 * Actualiza la tabla con los datos filtrados
 * @param {Array} usuarios - Datos de usuarios
 */
function actualizarTabla(usuarios) {
    console.log('Actualizando tabla con datos:', usuarios);

    const tablaUsuarios = document.getElementById('tabla_usuarios');
    let html = '';

    // Si no hay usuarios
    if (usuarios.length === 0) {
        html = '<tr><td colspan="6" class="text-center">No se encontraron usuarios con los filtros seleccionados</td></tr>';
        tablaUsuarios.innerHTML = html;
        return;
    }

    // Iterar por cada usuario
    usuarios.forEach(usuario => {
        const estadoClase = usuario.vestado_cuenta == 1 ? 'badge-light-success' : 'badge-light-danger';
        const estadoTexto = usuario.vestado_cuenta == 1 ? 'Activo' : 'Desactivado';

        // Formatear fecha
        const fecha = new Date(usuario.fechaRegistro);
        const fechaFormateada = fecha.toLocaleDateString('es-ES', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });

        html += `
            <tr style="text-align: center; font-size:12px">
                <td>${usuario.cidusu || ''}</td>
                <td>${usuario.nombreCompleto || ''}</td>
                <td>${fechaFormateada || ''}</td>
                <td>${usuario.tipoAdministrador || ''}</td>
                <td>
                    <div class="badge ${estadoClase}" style="font-size:12px">
                        ${estadoTexto}
                    </div>
                </td>
                <td>
                    <a href="#" class="btn btn-active-color-primary btn-sm me-1" style="padding: 0rem;">
                        <i class="fa-solid fa-pen-to-square fs-2"></i>
                    </a>
                    <a href="#" class="btn btn-active-color-danger btn-sm me-1" style="padding: 0rem;">
                        <i class="fa-solid fa-trash fs-2"></i>
                    </a>
                </td>
            </tr>
        `;
    });

    tablaUsuarios.innerHTML = html;
    console.log('Tabla actualizada con éxito');
}
