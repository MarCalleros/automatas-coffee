document.addEventListener("DOMContentLoaded", () => {
  // Variables globales
  let isLoading = false
  let currentTab = document.querySelector(".tab.active").getAttribute("href").split("/")[3] || "productos"
  let currentPeriodo = "dia"
  let charts = {};

  //Función para actualizar la paginación
  function updatePagination(container, totalPages, actualPage = 1, notFound = false) {
    container.innerHTML = "" // Limpiar la paginación
    let paginationHTML = ""

    if (notFound) {
      container.insertAdjacentHTML("beforeend", paginationHTML)
      return //No se muestra la paginación si no hay datos
    }

    paginationHTML = `
            <button class="pagination__button pagination__button--first" data-page="first">
                <svg class="pagination-icon" viewBox="-2 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier"> 
                        <g id="Free-Icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"> 
                            <g class="pagination-icon-edit" transform="translate(-1267.000000, -748.000000)" id="Group" stroke="#333333" stroke-width="3">
                                <g transform="translate(1263.000000, 746.000000)" id="Shape">
                                    <path d="M19,21 L9.5,12 L19,3 M5,3 L5,21"> </path>
                                </g>
                            </g>
                        </g>
                    </g>
                </svg>
            </button>

            <button class="pagination__button pagination__button--prev" data-page="prev">
                <svg class="pagination-icon" viewBox="-4 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <g id="Free-Icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"> 
                            <g class="pagination-icon-edit" transform="translate(-825.000000, -674.000000)" id="Group" stroke="#333333" stroke-width="3"> 
                                <g transform="translate(819.000000, 672.000000)" id="Shape"> 
                                    <polyline points="17.0011615 3 7 12.0021033 17.0011615 21.0042067"> </polyline> 
                                </g> 
                            </g> 
                        </g> 
                    </g>
                </svg>
            </button>
        `

    container.insertAdjacentHTML("beforeend", paginationHTML)

    for (let i = 1; i <= totalPages; i++) {
      const activeClass = i == actualPage ? "pagination__button--selected" : ""

      paginationHTML = `
                <button class="pagination__button pagination__button--number ${activeClass}" data-page="${i}">${i}</button>
            `

      container.insertAdjacentHTML("beforeend", paginationHTML)
    }

    paginationHTML = `
            <button class="pagination__button pagination__button--next" data-page="next">
                <svg class="pagination-icon" viewBox="-4 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">  
                        <g id="Free-Icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"> 
                            <g class="pagination-icon-edit" transform="translate(-751.000000, -674.000000)" id="Group" stroke="#333333" stroke-width="3"> 
                                <g transform="translate(745.000000, 672.000000)" id="Shape"> 
                                    <polyline points="7 3 17.0011615 12.0021033 7 21.0042067"> </polyline> 
                                </g> 
                            </g> 
                        </g> 
                    </g>
                </svg>
            </button>

            <button class="pagination__button pagination__button--last" data-page="last">
                <svg class="pagination-icon" viewBox="-1.5 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier"> 
                        <g id="Free-Icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"> 
                            <g class="pagination-icon-edit" transform="translate(-1192.000000, -748.000000)" id="Group" stroke="#333333" stroke-width="3"> 
                                <g transform="translate(1189.000000, 746.000000)" id="Shape"> 
                                    <path d="M19,21 L9.5,12 L19,3 M5,3 L5,21" transform="translate(11.750000, 12.000000) scale(-1, 1) translate(-11.750000, -12.000000) "></path> 
                                </g> 
                            </g> 
                        </g> 
                    </g>
                </svg>
            </button>
        `

    container.insertAdjacentHTML("beforeend", paginationHTML)
  }

  // Función para cargar datos de la tabla
  async function cargarDatos(tab, pagina = 1, periodo = "dia", params = {}) {
    if (isLoading) return
    isLoading = true

    let url = ""
    let targetContainer = ""
    let paginationContainer = ""

    switch (tab) {
      case "productos":
        url = `/api/estadisticas/productos_cantidad?pagina=${pagina}`
        targetContainer = "tablaProductosVendidos"
        paginationContainer = "paginacionProductosVendidos"
        break
      case "ingresos":
        url = `/api/estadisticas/productos_ingresos?pagina=${pagina}`
        targetContainer = "tablaProductosIngresos"
        paginationContainer = "paginacionProductosIngresos"
        break
      case "compras":
        url = `/api/estadisticas/clientes_compras?pagina=${pagina}`
        targetContainer = "tablaClientesCompras"
        paginationContainer = "paginacionClientesCompras"
        break
      case "clientes":
        url = `/api/estadisticas/clientes_ingresos?pagina=${pagina}`
        targetContainer = "tablaClientesIngresos"
        paginationContainer = "paginacionClientesIngresos"
        break
      case "ventas":
        url = `/api/estadisticas/ventas_periodo?pagina=${pagina}&periodo=${periodo}`
        targetContainer = "tablaVentasPeriodo"
        paginationContainer = "paginacionVentasPeriodo"
        if (periodo === 'personalizado' && params.fecha_inicio && params.fecha_fin) {
        url += `&fecha_inicio=${params.fecha_inicio}&fecha_fin=${params.fecha_fin}`;
        }
        targetContainer = "tablaVentasPeriodo";
        paginationContainer = "paginacionVentasPeriodo";
        break;
    }

    try {
      // Mostrar indicador de carga
      const container = document.getElementById(targetContainer)
      if (container) {
        container.innerHTML = '<tr class="admin-table__row admin-table__row--data"><td colspan="4" class="text-center">Cargando datos...</td></tr>'
      }

      const response = await fetch(url)

      // Verificar si la respuesta es exitosa
      if (!response.ok) {
        throw new Error(`Error HTTP: ${response.status}`)
      }

      // Verificar el tipo de contenido
      const contentType = response.headers.get("content-type")
      if (!contentType || !contentType.includes("application/json")) {
        // Si no es JSON, obtener el texto y mostrarlo para depuración
        const text = await response.text()
        console.error("Respuesta no es JSON:", text)
        throw new Error("La respuesta del servidor no es JSON válido")
      }

      const data = await response.json()

      // Verificar si hay un error en la respuesta
      if (data.error) {
        throw new Error(data.error)
      }

      //Actualizar la URL sin recargar la página
      const newUrl = `/admin/estadisticas/${tab}${tab === "ventas" ? `?periodo=${periodo}&pagina=${pagina}` : `?pagina=${pagina}`}`
      window.history.pushState({}, '', newUrl)

      //Actualizar la tabla con los datos
      actualizarTabla(targetContainer, data.items, tab)

      //Actualizar la paginación
      const paginationElement = document.getElementById(paginationContainer)
      if (paginationElement) {
        updatePagination(paginationElement, data.total_paginas, pagina, data.items.length === 0)
      }

      isLoading = false
    } catch (error) {
      console.error("Error al cargar datos:", error)

      // Mostrar mensaje de error en la tabla
      const container = document.getElementById(targetContainer)
      if (container) {
        container.innerHTML = `<tr class="admin-table__row admin-table__row--data"><td colspan="4" class="text-center text-danger">Error al cargar datos: ${error.message}</td></tr>`
      }

      // Limpiar paginación en caso de error
      const paginationElement = document.getElementById(paginationContainer)
      if (paginationElement) {
        paginationElement.innerHTML = ""
      }

      isLoading = false
    }
  }

  function resetCanvases() {
    document.querySelectorAll("canvas").forEach(canvas => {
      const newCanvas = document.createElement("canvas");
      newCanvas.id = canvas.id;
      canvas.parentNode.replaceChild(newCanvas, canvas);
    });
  }

  //Función para cargar  los datos de las gráficas
  async function cargarGraficas() {
    try {
      eliminarGraficas();
      await new Promise(resolve => setTimeout(resolve, 50));
      const response = await fetch("/api/estadisticas/graficas")

      // Verificar si la respuesta es exitosa
      if (!response.ok) {
        throw new Error(`Error HTTP: ${response.status}`)
      }

      // Verificar el tipo de contenido
      const contentType = response.headers.get("content-type")
      if (!contentType || !contentType.includes("application/json")) {
        // Si no es JSON, obtener el texto y mostrarlo para depuración
        const text = await response.text()
        console.error("Respuesta no es JSON:", text)
        throw new Error("La respuesta del servidor no es JSON válido")
      }

      const data = await response.json()

      // Verificar si hay un error en la respuesta
      if (data.error) {
        throw new Error(data.error)
      }

      // Inicializar gráficas con los datos recibidos
      inicializarGraficas(data)
    } catch (error) {
      console.error("Error al cargar datos para gráficas:", error)

      // Mostrar mensaje de error en los contenedores de gráficas
      const chartContainers = [
        "chartMasVendidos",
        "chartMenosVendidos",
        "chartMasIngresos",
        "chartMenosIngresos",
        "chartClientesCompras",
        "chartClientesIngresos",
      ]

      chartContainers.forEach((containerId) => {
        const container = document.getElementById(containerId)
        if (container) {
          const parent = container.parentElement
          if (parent) {
            const errorMsg = document.createElement("div")
            errorMsg.className = "chart-error"
            errorMsg.textContent = `Error al cargar datos: ${error.message}`
            parent.appendChild(errorMsg)
          }
        }
      })
    }
  }

  function eliminarGraficas() {
      resetCanvases();
      Object.keys(charts).forEach(chartKey => {
        if (charts[chartKey]) {
          // Solo destruir la instancia de Chart, no eliminar el canvas
          charts[chartKey].destroy();
          delete charts[chartKey];
        }
      });
      charts = {};
    }

    // Función para actualizar la tabla según el tipo de datos
    function actualizarTabla(containerId, items, tab) {
      const container = document.getElementById(containerId)
      if (!container) return

      container.innerHTML = ""

      if (items.length === 0) {
        container.innerHTML = '<tr class="admin-table__row admin-table__row--data"><td colspan="4" class="text-center">No hay datos disponibles</td></tr>'
        return
      }

      switch (tab) {
        case "productos":
          items.forEach((item, index) => {
            const row = document.createElement("tr")
            row.className = "admin-table__row admin-table__row--data"
            row.innerHTML = `
                          <td class="admin-table__data">${index + 1}</td>
                          <td class="admin-table__data">${item.nombre}</td>
                          <td class="admin-table__data">${item.cantidad_vendida}</td>
                          <td class="admin-table__data">$${item.precio_promedio}</td>
                      `
            container.appendChild(row)
          })
          break
        case "ingresos":
          items.forEach((item, index) => {
            const row = document.createElement("tr")
            row.className = "admin-table__row admin-table__row--data"
            row.innerHTML = `
                          <td class="admin-table__data">${index + 1}</td>
                          <td class="admin-table__data">${item.nombre}</td>
                          <td class="admin-table__data">$${item.ingresos}</td>
                          <td class="admin-table__data">${item.cantidad_vendida}</td>
                      `
            container.appendChild(row)
          })
          break
        case "compras":
          items.forEach((item, index) => {
            const row = document.createElement("tr")
            row.className = "admin-table__row admin-table__row--data"
            row.innerHTML = `
                          <td class="admin-table__data">${index + 1}</td>
                          <td class="admin-table__data">${item.nombre}</td>
                          <td class="admin-table__data">${item.total_compras}</td>
                          <td class="admin-table__data">${item.ultima_compra}</td>
                      `
            container.appendChild(row)
          })
          break
        case "clientes":
          items.forEach((item, index) => {
            const row = document.createElement("tr")
            row.className = "admin-table__row admin-table__row--data"
            row.innerHTML = `
                          <td class="admin-table__data">${index + 1}</td>
                          <td class="admin-table__data">${item.nombre}</td>
                          <td class="admin-table__data">$${item.total_ingresos}</td>
                          <td class="admin-table__data">${item.compras_realizadas}</td>
                      `
            container.appendChild(row)
          })
          break
        case "ventas":
          items.forEach((item) => {
            const row = document.createElement("tr")
            row.className = "admin-table__row admin-table__row--data"
            row.innerHTML = `
                          <td class="admin-table__data">${item.periodo}</td>
                          <td class="admin-table__data">${item.total_ventas}</td>
                          <td class="admin-table__data">$${item.total_ingresos}</td>
                          <td class="admin-table__data">$${(item.total_ingresos / item.total_ventas).toFixed(2)}</td>
                      `
            container.appendChild(row)
          })
          break
      }
    }

    function mostrarTabActiva(tabName) {
    // Ocultar todas las pestañas
    document.querySelectorAll(".tab-content").forEach(tab => {
      tab.classList.remove("active");
    });
    // Mostrar la pestaña seleccionada
    const tabActiva = document.getElementById(tabName);
    if (tabActiva) tabActiva.classList.add("active");
  }

    // Función para inicializar las gráficas
  function inicializarGraficas(data) {
      // Asegurarse de que las gráficas anteriores se hayan eliminado
      eliminarGraficas();
      
      // Gráfica de productos más vendidos
      const ctxMasVendidos = document.getElementById("chartMasVendidos");
      if (ctxMasVendidos) {
        charts.masVendidos = new Chart(ctxMasVendidos, {
          type: "bar",
          data: {
            labels: data.productosMasVendidos.map((item) => item.nombre),
            datasets: [
              {
                data: data.productosMasVendidos.map((item) => item.cantidad_vendida),
                backgroundColor: "#ff5100",
                borderColor: "#ff5100",
                borderWidth: 1,
              },
            ],
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                display: false 
              }
            },
            scales: {
              y: {
                beginAtZero: true,
                suggestedMax: function() {
                  const values = data.productosMasVendidos.map(item => item.cantidad_vendida);
                  return Math.max(...values) * 1.2;
                }
              }
            },
          },
        });
      }

      // Gráfica de productos menos vendidos
      const ctxMenosVendidos = document.getElementById("chartMenosVendidos");
      if (ctxMenosVendidos) {
        charts.menosVendidos = new Chart(ctxMenosVendidos, {
          type: "bar",
          data: {
            labels: data.productosMenosVendidos.map((item) => item.nombre),
            datasets: [
              {
                data: data.productosMenosVendidos.map((item) => item.cantidad_vendida),
                backgroundColor: "#ff5100",
                borderColor: "#ff5100",
                borderWidth: 1,
              },
            ],
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                display: false
              }
            },
            scales: {
              y: {
                beginAtZero: true,
                suggestedMax: function() {
                  const values = data.productosMenosVendidos.map(item => item.cantidad_vendida);
                  return Math.max(...values) * 1.2;
                }
              }
            },
          },
        });
      }

      // Gráfica de productos con más ingresos
      const ctxMasIngresos = document.getElementById("chartMasIngresos");
      if (ctxMasIngresos) {
        charts.masIngresos = new Chart(ctxMasIngresos, {
          type: "bar",
          data: {
            labels: data.productosMasIngresos.map((item) => item.nombre),
            datasets: [
              {
                data: data.productosMasIngresos.map((item) => item.ingresos),
                backgroundColor: "#ff5100",
                borderColor: "#ff5100",
                borderWidth: 1,
              },
            ],
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                display: false
              }
            },
            scales: {
              y: {
                beginAtZero: true,
                suggestedMax: function() {
                  const values = data.productosMasIngresos.map(item => item.ingresos);
                  return Math.max(...values) * 1.2;
                }
              }
            },
          },
        });
      }

      // Gráfica de productos con menos ingresos
      const ctxMenosIngresos = document.getElementById("chartMenosIngresos");
      if (ctxMenosIngresos) {
        charts.menosIngresos = new Chart(ctxMenosIngresos, {
          type: "bar",
          data: {
            labels: data.productosMenosIngresos.map((item) => item.nombre),
            datasets: [
              {
                data: data.productosMenosIngresos.map((item) => item.ingresos),
                backgroundColor: "#ff5100",
                borderColor: "#ff5100",
                borderWidth: 1,
              },
            ],
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                display: false
              }
            },
            scales: {
              y: {
                beginAtZero: true,
                suggestedMax: function() {
                  const values = data.productosMenosIngresos.map(item => item.ingresos);
                  return Math.max(...values) * 1.2;
                }
              }
            },
          },
        });
      }

      // Gráfica de clientes con más compras
      const ctxClientesCompras = document.getElementById("chartClientesCompras");
      if (ctxClientesCompras) {
        charts.clientesCompras = new Chart(ctxClientesCompras, {
          type: "bar",
          data: {
            labels: data.clientesMasCompras.map((item) => item.nombre),
            datasets: [
              {
                data: data.clientesMasCompras.map((item) => item.total_compras),
                backgroundColor: "#ff5100",
                borderColor: "#ff5100",
                borderWidth: 1,
              },
            ],
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                display: false
              }
            },
            scales: {
              y: {
                beginAtZero: true,
                suggestedMax: function() {
                  const values = data.clientesMasCompras.map(item => item.total_compras);
                  return Math.max(...values) * 1.2;
                }
              }
            },
          },
        });
      }

      // Gráfica de clientes con más ingresos
      const ctxClientesIngresos = document.getElementById("chartClientesIngresos");
      if (ctxClientesIngresos) {
        charts.clientesIngresos = new Chart(ctxClientesIngresos, {
          type: "bar",
          data: {
            labels: data.clientesMasIngresos.map((item) => item.nombre),
            datasets: [
              {
                data: data.clientesMasIngresos.map((item) => item.total_ingresos),
                backgroundColor: "#ff5100",
                borderColor: "#ff5100",
                borderWidth: 1,
              },
            ],
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                display: false
              }
            },
            scales: {
              y: {
                beginAtZero: true,
                suggestedMax: function() {
                  const values = data.clientesMasIngresos.map(item => item.total_ingresos);
                  return Math.max(...values) * 1.2;
                }
              }
            },
          },
        });
      }
    }

    function toggleFechaPersonalizada(mostrar) {
    const fechaPersonalizada = document.getElementById('fecha-personalizada');
    if (fechaPersonalizada) {
      fechaPersonalizada.style.display = mostrar ? 'flex' : 'none';
    }
  }

  // Función para aplicar el filtro de fechas personalizadas
  function aplicarFechasPersonalizadas() {
    const fechaInicio = document.getElementById('fecha_inicio').value;
    const fechaFin = document.getElementById('fecha_fin').value;
    
    if (!fechaInicio || !fechaFin) {
      alert('Por favor seleccione ambas fechas');
      return;
    }
    
    if (new Date(fechaInicio) > new Date(fechaFin)) {
      alert('La fecha de inicio no puede ser posterior a la fecha final');
      return;
    }
    
    // Actualizar la URL sin recargar la página
    const url = new URL(window.location.href);
    url.searchParams.set('periodo', 'personalizado');
    url.searchParams.set('fecha_inicio', fechaInicio);
    url.searchParams.set('fecha_fin', fechaFin);
    window.history.pushState({}, '', url);
    
    // Actualizar variable global
    currentPeriodo = 'personalizado';
    
    // Cargar datos con el nuevo período personalizado
    cargarDatos('ventas', 1, 'personalizado', { fecha_inicio: fechaInicio, fecha_fin: fechaFin });
    
    // Actualizar el título de la tabla
    const tituloVentas = document.querySelector("#ventas h1");
    if (tituloVentas) {
      const fechaInicioFormateada = new Date(fechaInicio).toLocaleDateString();
      const fechaFinFormateada = new Date(fechaFin).toLocaleDateString();
      tituloVentas.textContent = `Ventas del ${fechaInicioFormateada} al ${fechaFinFormateada}`;
    }
  }

  function cambiarPeriodo(periodo) {
    // Si ya estamos en este período, no hacer nada, menos para personalizado
    if (currentPeriodo === periodo && periodo !== 'personalizado') return;
    
    console.log("Cambiando a período:", periodo);
    
    // Actualizar clases de los botones de período
    document.querySelectorAll(".period-btn").forEach(btn => {
      btn.classList.remove("active");
    });
    
    // Activar el botón del período actual
    document.querySelectorAll(".period-btn").forEach(btn => {
      if (btn.getAttribute("data-periodo") === periodo) {
        btn.classList.add("active");
      }
    });
    
    // Mostrar/ocultar selector de fechas personalizadas
    toggleFechaPersonalizada(periodo === 'personalizado');
    if (periodo === 'personalizado') {
      currentPeriodo = periodo;
      
      // Actualizar la URL sin recargar la página
      const url = new URL(window.location.href);
      url.searchParams.set('periodo', periodo);
      window.history.pushState({}, '', url);
      
      return;
    }
    
    // Actualizar el título de la tabla
    const tituloVentas = document.querySelector("#ventas h1");
    if (tituloVentas) {
      if (periodo === 'personalizado') {
        const fechaInicio = document.getElementById('fecha_inicio').value;
        const fechaFin = document.getElementById('fecha_fin').value;
        tituloVentas.textContent = `Ventas del ${fechaInicio} al ${fechaFin}`;
      } else {
        tituloVentas.textContent = `Ventas por ${periodo.charAt(0).toUpperCase() + periodo.slice(1)}`;
      }
    }
    
    // Actualizar la URL sin recargar la página
    const url = new URL(window.location.href);
    url.searchParams.set('periodo', periodo);
    url.searchParams.delete('fecha_inicio');
    url.searchParams.delete('fecha_fin');
    window.history.pushState({}, '', url);
    
    // Actualizar variable global
    currentPeriodo = periodo;
    
    // Cargar datos para el nuevo período
    cargarDatos("ventas", 1, periodo);
  }

    // Manejar eventos de paginación
    document.querySelectorAll(".pagination").forEach((pagination) => {
      pagination.addEventListener("click", function (e) {
        if (e.target.closest(".pagination__button")) {
          if (isLoading) return

          const buttonClicked = e.target.closest(".pagination__button")
          const paginationButtons = this.querySelectorAll(".pagination__button")

          const currentButton = this.querySelector(".pagination__button--selected")
          if (currentButton === buttonClicked) {
            return // Evitar recargar si el botón ya está seleccionado
          }

          let page = buttonClicked.getAttribute("data-page")
          const actualPage = Number.parseInt(currentButton ? currentButton.getAttribute("data-page") : 1)

          if (page === "first") {
            page = 1
          } else if (page === "prev") {
            page = Math.max(actualPage - 1, 1)
          } else if (page === "next") {
            const pageButtons = this.querySelectorAll(".pagination__button--number")
            const lastPage = Number.parseInt(pageButtons[pageButtons.length - 1].getAttribute("data-page"))
            page = Math.min(actualPage + 1, lastPage)
          } else if (page === "last") {
            const pageButtons = this.querySelectorAll(".pagination__button--number")
            page = Number.parseInt(pageButtons[pageButtons.length - 1].getAttribute("data-page"))
          }

          // Cargar datos con la nueva página
          cargarDatos(currentTab, page, currentPeriodo)
        }
      })
    })

    // Manejar cambios de pestaña
    document.querySelectorAll(".tab").forEach((tab) => {
      tab.addEventListener("click", function (e) {
        e.preventDefault()
        const periodo = this.dataset.periodo || "dia";
        const tabName = this.dataset.tab; 
        eliminarGraficas();

        mostrarTabActiva(tabName);

        // Actualizar pestaña activa
        document.querySelectorAll(".tab").forEach((t) => t.classList.remove("active"))
        this.classList.add("active")

        currentTab = tabName

        // Cargar datos de la nueva pestaña
        cargarDatos(tabName, 1, currentPeriodo)

        // Si cambiamos a una pestaña con gráficas, cargarlas
        if (["productos", "ingresos", "compras", "clientes"].includes(tabName)) {
          cargarGraficas()
        }
      })
    })

    // Manejar cambios de período (para ventas por período)
    document.querySelectorAll(".period-btn").forEach((btn) => {
      btn.addEventListener("click", function (e) {
        e.preventDefault();
        const periodo = this.getAttribute("data-periodo");
        cambiarPeriodo(periodo);
      });
    });

      const btnAplicarFechas = document.getElementById('aplicar-fechas');
    if (btnAplicarFechas) {
      btnAplicarFechas.addEventListener('click', aplicarFechasPersonalizadas);
    }

    // Cargar datos iniciales
    const url = new URL(window.location.href)
    const params = url.searchParams

    const pagina = params.get("pagina") || 1
    currentPeriodo = params.get("periodo") || "dia"

    // Cargar datos de la tabla
    cargarDatos(currentTab, pagina, currentPeriodo)

    // Cargar datos para las gráficas si estamos en una pestaña que las usa
    if (["productos", "ingresos", "compras", "clientes"].includes(currentTab)) {
      cargarGraficas()
    }
})