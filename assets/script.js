
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('ventanaConfiguracion');
    const Abrir = document.getElementById('configuracion');
    const Cancelar = document.getElementById('Cancelar');
    const Guardar = document.getElementById('Guardar');

    if (Abrir) {
        Abrir.addEventListener('click', (evento) => {
            evento.preventDefault(); 
            modal.showModal();
        });
    }

    if (Cancelar) {
        Cancelar.addEventListener('click', () => {
            modal.close();
        });
    }

    if (Guardar) {
        Guardar.addEventListener('click', () => {
            modal.close();
        });
    }
});