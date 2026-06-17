
function filtrarTabla() {
    const input = document.getElementById('inputBusqueda').value.toLowerCase();
    const filtroTipo = document.getElementById('filtroTipo').value.toLowerCase();
    const filas = document.querySelectorAll('#tablaEquiposBody tr');

    filas.forEach(fila => {
        const textoFila = fila.textContent.toLowerCase();
        const tipoFila = fila.getElementsByTagName('td')[0].textContent.toLowerCase();
        const coincideBusqueda = textoFila.includes(input);
        const coincideTipo = (filtroTipo === "" || tipoFila.includes(filtroTipo));

        fila.style.display = (coincideBusqueda && coincideTipo) ? "" : "none";
    });
}