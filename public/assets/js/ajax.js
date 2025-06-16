// Función para cargar los registros desde el servidor
function cargarRegistrosDesdeServidor() {
  const desde = document.getElementById("desde").value
  const hasta = document.getElementById("hasta").value
  const pagina = 1 // Por defecto, primera página

  // Construir URL con parámetros
  let url = "obtener_registros.php?pagina=" + pagina
  if (desde) url += "&desde=" + desde
  if (hasta) url += "&hasta=" + hasta

  // Mostrar indicador de carga
  const tablaBody = document.getElementById("tablaRegistrosNFC")
  tablaBody.innerHTML = '<tr><td colspan="4" style="text-align: center; padding: 20px;">Cargando...</td></tr>'

  // Realizar petición AJAX
  fetch(url)
    .then((response) => {
      if (!response.ok) {
        throw new Error("Error en la respuesta del servidor")
      }
      return response.json()
    })
    .then((data) => {
      // Procesar datos recibidos
      mostrarRegistros(data.registros)
      actualizarPaginacion(data.paginacion)
    })
    .catch((error) => {
      console.error("Error:", error)
      tablaBody.innerHTML = `
                <tr>
                    <td colspan="4" style="text-align: center; padding: 20px; color: red;">
                        Error al cargar los registros: ${error.message}
                    </td>
                </tr>
            `
    })
}

// Función para mostrar los registros en la tabla
function mostrarRegistros(registros) {
  const tablaBody = document.getElementById("tablaRegistrosNFC")

  if (registros.length === 0) {
    tablaBody.innerHTML = `
            <tr>
                <td colspan="4" style="text-align: center; padding: 20px;">
                    No hay registros disponibles
                </td>
            </tr>
        `
  } else {
    let html = ""
    registros.forEach((registro) => {
      html += `
                <tr data-id="${registro.id}">
                    <td>${registro.empleado}</td>
                    <td>${registro.fecha}</td>
                    <td>${registro.hora_entrada || "-"}</td>
                    <td>${registro.hora_salida || "-"}</td>
                </tr>
            `
    })
    tablaBody.innerHTML = html

    // Agregar evento de selección a las filas
    const filas = tablaBody.querySelectorAll("tr")
    filas.forEach((fila) => {
      fila.addEventListener("click", function () {
        // Quitar selección de otras filas
        filas.forEach((f) => f.classList.remove("selected"))
        // Seleccionar esta fila
        this.classList.add("selected")
      })
    })
  }
}

// Función para actualizar la paginación
function actualizarPaginacion(paginacion) {
  const paginacionElement = document.getElementById("paginacionRegistros")
  const { pagina_actual, total_paginas } = paginacion

  if (total_paginas <= 1) {
    paginacionElement.innerHTML = ""
    return
  }

  let html = ""

  // Botón anterior
  html += `<button ${pagina_actual === 1 ? "disabled" : ""} data-page="${pagina_actual - 1}">«</button>`

  // Números de página
  for (let i = 1; i <= total_paginas; i++) {
    html += `<button class="${i === pagina_actual ? "active" : ""}" data-page="${i}">${i}</button>`
  }

  // Botón siguiente
  html += `<button ${pagina_actual === total_paginas ? "disabled" : ""} data-page="${pagina_actual + 1}">»</button>`

  paginacionElement.innerHTML = html

  // Agregar eventos a los botones de paginación
  const botones = paginacionElement.querySelectorAll("button")
  botones.forEach((boton) => {
    boton.addEventListener("click", function () {
      if (!this.hasAttribute("disabled")) {
        const pagina = this.getAttribute("data-page")
        cargarPagina(pagina)
      }
    })
  })
}

// Función para cargar una página específica
function cargarPagina(pagina) {
  const desde = document.getElementById("desde").value
  const hasta = document.getElementById("hasta").value

  // Construir URL con parámetros
  let url = "obtener_registros.php?pagina=" + pagina
  if (desde) url += "&desde=" + desde
  if (hasta) url += "&hasta=" + hasta

  // Realizar petición AJAX
  fetch(url)
    .then((response) => response.json())
    .then((data) => {
      mostrarRegistros(data.registros)
      actualizarPaginacion(data.paginacion)
    })
    .catch((error) => {
      console.error("Error:", error)
    })
}

// Función para borrar un registro seleccionado
function borrarRegistroSeleccionado() {
  const filaSeleccionada = document.querySelector("#tablaRegistrosNFC tr.selected")

  if (!filaSeleccionada) {
    alert("Por favor, seleccione un registro para borrar")
    return
  }

  const registroId = filaSeleccionada.getAttribute("data-id")

  if (confirm("¿Está seguro de que desea borrar este registro?")) {
    // Datos para enviar
    const datos = {
      registro_id: registroId,
    }

    // Realizar petición AJAX
    fetch("borrar_registro.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(datos),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.mensaje) {
          alert(data.mensaje)
          // Recargar registros
          cargarRegistrosDesdeServidor()
        } else if (data.error) {
          alert("Error: " + data.error)
        }
      })
      .catch((error) => {
        console.error("Error:", error)
        alert("Error al procesar la solicitud")
      })
  }
}

// Inicializar cuando el DOM esté listo
document.addEventListener("DOMContentLoaded", () => {
  // Cargar registros iniciales
  cargarRegistrosDesdeServidor()

  // Configurar eventos de filtros
  document.getElementById("desde").addEventListener("change", cargarRegistrosDesdeServidor)
  document.getElementById("hasta").addEventListener("change", cargarRegistrosDesdeServidor)

  // Configurar evento del botón borrar
  document.getElementById("borrarRegistro").addEventListener("click", borrarRegistroSeleccionado)
})
