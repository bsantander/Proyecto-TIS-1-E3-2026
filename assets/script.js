
function filtrarEquipos() {
    const inputBusqueda = document.getElementById('inputBusquedaEquipo').value.toLowerCase();
    const filtroTipo = document.getElementById('filtroTipo').value.toLowerCase();
    const filas = document.querySelectorAll('#tablaEquiposBody tr');

    filas.forEach(fila => {
        const textoFila = fila.textContent.toLowerCase();
        const coincideBusqueda = textoFila.includes(inputBusqueda);
        const coincideTipo = (filtroTipo === "" || textoFila.includes(filtroTipo));
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