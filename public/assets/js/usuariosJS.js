document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.editar-usuario').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const nombres = this.getAttribute('data-nombres');
            const apellidos = this.getAttribute('data-apellidos');
            const fecha = this.getAttribute('data-fecha');
            const usuario = this.getAttribute('data-usuario');
            const tipo = this.getAttribute('data-tipo');
            const estado = this.getAttribute('data-estado');
            console.log('User ID seleccionado:', id);


            document.getElementById('edit_user_id').value = id;
            document.getElementById('delete_user_id').value = id;
            document.getElementById('edit_nombres').value = nombres;
            document.getElementById('edit_apellidos').value = apellidos;
            document.getElementById('edit_usuario').value = usuario;
            document.getElementById('edit_fechaRegistro').value = fecha;
            document.getElementById('edit_estado').value = estado;

            document.getElementById('edit_tipoAdministrador_0').checked = tipo == '003';
            document.getElementById('edit_tipoAdministrador_1').checked = tipo == '002';
        });
    });
});

