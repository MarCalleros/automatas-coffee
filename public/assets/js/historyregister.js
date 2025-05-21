document.addEventListener("DOMContentLoaded", () => {
  // Cargar datos iniciales
  cargarRegistros()

  // Configurar eventos de filtros
  document.getElementById("desde").addEventListener("change", cargarRegistros)
  document.getElementById("hasta").addEventListener("change", cargarRegistros)

  // Configurar evento del botón borrar
  document.getElementById("borrarRegistro").addEventListener("click", () => {
    // Aquí iría la lógica para borrar un registro
    alert("Funcionalidad de borrar registro pendiente de implementar")
  })
})

// Función para cargar los registros desde el servidor
function cargarRegistros() {
  const desde = document.getElementById("desde").value
  const hasta = document.getElementById("hasta").value

  // Aquí se haría una petición AJAX al servidor
  // Por ahora, simularemos datos para mostrar

  // Simulación de datos
  const registrosSimulados = []

  // Mostrar mensaje si no hay registros
  const tablaBody = document.getElementById("tablaRegistrosNFC")

  if (registrosSimulados.length === 0) {
    tablaBody.innerHTML = `
            <tr>
                <td colspan="4" style="text-align: center; padding: 20px;">
                    No hay registros disponibles
                </td>
            </tr>
        `
  } else {
    // Aquí se mostrarían los registros reales cuando implemente la lógica
    let html = ""
    registrosSimulados.forEach((registro) => {
      html += `
                <tr>
                    <td>${registro.empleado}</td>
                    <td>${registro.fecha}</td>
                    <td>${registro.horaEntrada}</td>
                    <td>${registro.horaSalida}</td>
                </tr>
            `
    })
    tablaBody.innerHTML = html
  }

  // Generar paginación
  generarPaginacion(1, 5) // Página actual, total de páginas
}

// Función para generar la paginación
function generarPaginacion(paginaActual, totalPaginas) {
  const paginacion = document.getElementById("paginacionRegistros")
  let html = ""

  // Botón anterior
  html += `<button ${paginaActual === 1 ? "disabled" : ""}>«</button>`

  // Números de página
  for (let i = 1; i <= totalPaginas; i++) {
    html += `<button class="${i === paginaActual ? "active" : ""}">${i}</button>`
  }

  // Botón siguiente
  html += `<button ${paginaActual === totalPaginas ? "disabled" : ""}>»</button>`

  paginacion.innerHTML = html

  // Agregar eventos a los botones de paginación
  const botones = paginacion.querySelectorAll("button")
  botones.forEach((boton) => {
    boton.addEventListener("click", () => {
      // Aquí ira la lógica para cambiar de página
      // Por ahora solo recargamos los registros
      cargarRegistros()
    })
  })
}
