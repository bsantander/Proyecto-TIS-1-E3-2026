
function filtrarEquipos() {
    const input = document.getElementById('inputBusquedaEquipo').value.toLowerCase();
    const filtroTipo = document.getElementById('filtroTipo').value.toLowerCase();
    const filas = document.querySelectorAll('#tablaEquipos tr');

    filas.forEach(fila => {
        const textoFila = fila.textContent.toLowerCase();
        const tipoFila = fila.getElementsByTagName('td')[0].textContent.toLowerCase();
        const coincideBusqueda = textoFila.includes(input);
        const coincideTipo = (filtroTipo === "" || tipoFila.includes(filtroTipo));
        fila.style.display = (coincideBusqueda && coincideTipo) ? "" : "none";
    });
}

function filtrarProveedores() {
    const input = document.getElementById('inputBusquedaproveedor').value.toLowerCase();
    const filas = document.querySelectorAll('#tablaProveedores tr');
    filas.forEach(fila => {
        const textoFila = fila.textContent.toLowerCase();
        fila.style.display = textoFila.includes(input) ? "" : "none";
    });
}