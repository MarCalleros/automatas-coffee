import { createNotification } from "./notification.js"
;(() => {
  let productsArray = []
  const productList = document.querySelector(".product-list")
  const pagination = document.querySelector(".pagination")

  let isLoading = false

  // Cuando recien cargue la pagina, se cargan los productos por defecto
  document.addEventListener("DOMContentLoaded", async () => {
    const currentURL = window.location.href
    if (currentURL.includes("productos")) {
      //const res = await fetch("/api/list");
      //const list = await res.json();
      //productsArray = chunkArrayInGroups(list, 10);
      const url = new URL(window.location.href)
      const params = url.searchParams
      const page = params.get("page") || 1 // Obtener el número de página actual o 1 si no existe

      if (params.get("page")) {
        params.delete("page")
      }

      const endpoint = params.toString() === "" ? "/api/list" : `/api/filter?${params.toString()}`
      const res = await fetch(endpoint)
      const list = await res.json()

      productsArray = chunkArrayInGroups(list, 10)

      if (!productsArray || productsArray.length === 0) {
        updateHTML(productList, [], true)
        updatePagination(pagination, 0, 1, true)
      } else {
        if (page > productsArray.length) {
          page = productsArray.length // Asegurarse de que la página no exceda el número total de páginas
        }
        const pageIndex = page - 1 // Ajustar el índice de la página para acceder al array

        updateHTML(productList, productsArray[pageIndex]) // Actualizar el HTML con los productos de la página actual
        updatePagination(pagination, productsArray.length, page)
      }
    }
  })

  if (pagination) {
    pagination.addEventListener("click", (e) => {
      if (e.target.closest(".pagination__button")) {
        if (isLoading) return
        isLoading = true

        const buttonClicked = e.target.closest(".pagination__button")
        const paginationButtons = document.querySelectorAll(".pagination__button")

        const url = new URL(window.location.href)
        const params = url.searchParams
        params.delete("page") // Limpiar el parámetro de página antes de agregar uno nuevo

        const currentButton = document.querySelector(".pagination__button--selected")
        if (currentButton === buttonClicked) {
          isLoading = false
          return // Evitar recargar si el botón ya está seleccionado
        }

        let page = buttonClicked.getAttribute("data-page")

        if (page === "first") {
          const firstButton = document.querySelector('.pagination__button[data-page="1"]')

          if (currentButton === firstButton) {
            isLoading = false
            return
          }

          firstButton.classList.add("pagination__button--selected")
          page = 1
          paginationButtons.forEach((btn) => {
            if (btn !== firstButton) {
              btn.classList.remove("pagination__button--selected")
            }
          })
        } else if (page === "prev") {
          const firstButton = document.querySelector('.pagination__button[data-page="1"]')

          if (currentButton === firstButton) {
            isLoading = false
            return
          }

          const currentPage = Number.parseInt(
            document.querySelector(".pagination__button--selected").getAttribute("data-page"),
          )
          page = currentPage - 1
          if (page < 1) page = 1
          const prevButton = document.querySelector(`.pagination__button[data-page="${page}"]`)
          prevButton.classList.add("pagination__button--selected")
          paginationButtons.forEach((btn) => {
            if (btn !== prevButton) {
              btn.classList.remove("pagination__button--selected")
            }
          })
        } else if (page === "next") {
          const pageButtons = document.querySelectorAll(".pagination__button--number")
          const lastButton = pageButtons[pageButtons.length - 1]

          if (currentButton === lastButton) {
            isLoading = false
            return
          }

          const currentPage = Number.parseInt(
            document.querySelector(".pagination__button--selected").getAttribute("data-page"),
          )
          page = currentPage + 1
          if (page > pageButtons.length) page = pageButtons.length
          const nextButton = document.querySelector(`.pagination__button[data-page="${page}"]`)
          nextButton.classList.add("pagination__button--selected")
          paginationButtons.forEach((btn) => {
            if (btn !== nextButton) {
              btn.classList.remove("pagination__button--selected")
            }
          })
        } else if (page === "last") {
          const pageButtons = document.querySelectorAll(".pagination__button--number")
          const lastButton = pageButtons[pageButtons.length - 1]

          if (currentButton === lastButton) {
            isLoading = false
            return
          }

          lastButton.classList.add("pagination__button--selected")
          page = lastButton.getAttribute("data-page")
          paginationButtons.forEach((btn) => {
            if (btn !== lastButton) {
              btn.classList.remove("pagination__button--selected")
            }
          })
        } else {
          buttonClicked.classList.add("pagination__button--selected")
          paginationButtons.forEach((btn) => {
            if (btn !== buttonClicked) {
              btn.classList.remove("pagination__button--selected")
            }
          })
        }

        const productsPage = productsArray[page - 1]

        updateHTML(productList, productsPage) // Actualizar el HTML con los productos de la página actual

        params.append("page", page) // Agregar el parámetro de página a la URL
        const newUrl = `${window.location.pathname}?${params.toString()}`
        window.history.pushState({}, "", newUrl) // Cambiar la URL sin recargar
        isLoading = false // Marcar como no cargando
      }
    })
  }

  const searchInput = document.querySelector(".search__input")
  let searchValue = document.querySelector(".search__value")
  let searchTimeout

  async function search(input) {
    if (searchValue === input.value) return // Evitar recargar si el valor no ha cambiado
    searchValue = input.value

    const url = new URL(window.location.href)
    const params = url.searchParams

    params.delete("search")
    params.append("search", input.value)

    if (params.get("page")) {
      params.delete("page")
    }

    const newUrl = `${window.location.pathname}?${params.toString()}`
    window.history.pushState({}, "", newUrl)

    const endpoint = params.toString() === "" ? "/api/list" : `/api/filter?${params.toString()}`
    const res = await fetch(endpoint)
    const list = await res.json()

    productsArray = chunkArrayInGroups(list, 10)
    const pagination = document.querySelector(".pagination")

    if (!productsArray || productsArray.length === 0) {
      updateHTML(productList, [], true)
      updatePagination(pagination, 0, 1, true)
    } else {
      updateHTML(productList, productsArray[0])
      updatePagination(pagination, productsArray.length, 1)
    }
  }

  // Evento input con delay (debounce)
  if (searchInput) {
    searchInput.addEventListener("input", function () {
      clearTimeout(searchTimeout)
      searchTimeout = setTimeout(() => {
        search(this)
      }, 800)
    })

    // Evento Enter sin delay
    searchInput.addEventListener("keypress", function (e) {
      if (e.key === "Enter") {
        clearTimeout(searchTimeout) // Cancelar debounce si ya va a buscar
        search(this)
      }
    })
  }

  const filterPrice1 = document.querySelector("#filter-price-1")
  const filterPrice2 = document.querySelector("#filter-price-2")

  if (filterPrice1) {
    filterPrice1.addEventListener("click", function () {
      if (this.checked) {
        filterPrice2.checked = false // Desmarcar el otro checkbox
      }
    })
  }
  if (filterPrice2) {
    filterPrice2.addEventListener("click", function () {
      if (this.checked) {
        filterPrice1.checked = false // Desmarcar el otro checkbox
      }
    })
  }
  const filterApplyButton = document.querySelector("#filter-apply")
  const filterResetButton = document.querySelector("#filter-reset")

  if (filterApplyButton) {
    filterApplyButton.addEventListener("click", async () => {
      const currentUrl = new URL(window.location.href)
      const currentParams = currentUrl.searchParams

      const params = new URLSearchParams()

      if (currentParams.has("page")) {
        params.delete("page")
      }

      if (currentParams.has("search")) {
        params.append("search", currentParams.get("search"))
      }

      const filterLike = document.querySelector("#filter-like").checked
      if (filterLike) {
        params.append("liked", true) // Aquí podría ir el ID del usuario si lo necesitas
      }

      const filtersCategory = document.querySelectorAll(".filter__input--category")
      filtersCategory.forEach((filter) => {
        if (filter.checked) {
          const category = filter.getAttribute("data-filter")
          params.append("category[]", category)
        }
      })

      const filtersSize = document.querySelectorAll(".filter__input--size")
      filtersSize.forEach((filter) => {
        if (filter.checked) {
          const size = filter.getAttribute("data-filter")
          params.append("size[]", size)
        }
      })

      const filterPrice1 = document.querySelector("#filter-price-1").checked
      const filterPrice2 = document.querySelector("#filter-price-2").checked

      if (filterPrice1) {
        params.append("price", 1)
      } else if (filterPrice2) {
        params.append("price", 2)
      }

      // Actualizar la URL sin recargar
      const newUrl = `${window.location.pathname}?${params.toString()}`
      window.history.pushState({}, "", newUrl)

      // Si no hay filtros o es page, listar los productos por defecto
      // Fetch según si hay filtros o no
      const query = params.toString()
      const res = await fetch(query === "" ? "/api/list" : `/api/filter?${query}`)
      const list = await res.json()

      productsArray = chunkArrayInGroups(list, 10)
      const pagination = document.querySelector(".pagination")

      if (productsArray === undefined || productsArray.length === 0) {
        updateHTML(productList, [], true) // Mostrar mensaje de no encontrado
        updatePagination(pagination, 0, 1, true) // Actualizar la paginación
      } else {
        updateHTML(productList, productsArray[0]) // Actualizar el HTML con los productos filtrados
        updatePagination(pagination, productsArray.length, 1) // Actualizar la paginación
      }
    })
  }
  if (filterResetButton) {
    filterResetButton.addEventListener("click", async () => {
      const filtersCategory = document.querySelectorAll(".filter__input--category")
      filtersCategory.forEach((filter) => {
        filter.checked = false
      })

      const filtersSize = document.querySelectorAll(".filter__input--size")
      filtersSize.forEach((filter) => {
        filter.checked = false
      })

      const filterPrice1 = document.querySelector("#filter-price-1")
      const filterPrice2 = document.querySelector("#filter-price-2")
      filterPrice1.checked = false
      filterPrice2.checked = false

      const filterLike = document.querySelector("#filter-like")
      filterLike.checked = false

      // Una vez se reiniciaron los filtros, quitarlos de la URL (menos page si existe y search)
      const currentUrl = new URL(window.location.href)
      const currentParams = currentUrl.searchParams

      const params = new URLSearchParams()
      if (currentParams.has("page")) {
        params.delete("page")
      }

      if (currentParams.has("search")) {
        params.append("search", currentParams.get("search"))
      }

      // Actualizar la URL sin recargar
      const newUrl = `${window.location.pathname}?${params.toString()}`
      window.history.pushState({}, "", newUrl)

      // Fetch según si hay filtros o no
      const query = params.toString()
      const res = await fetch(query === "" ? "/api/list" : `/api/filter?${query}`)
      const list = await res.json()

      productsArray = chunkArrayInGroups(list, 10)
      const pagination = document.querySelector(".pagination")

      if (productsArray === undefined || productsArray.length === 0) {
        updateHTML(productList, [], true) // Mostrar mensaje de no encontrado
        updatePagination(pagination, 0, 1, true) // Actualizar la paginación
      } else {
        updateHTML(productList, productsArray[0]) // Actualizar el HTML con los productos filtrados
        updatePagination(pagination, productsArray.length, 1) // Actualizar la paginación
      }
    })
  }
  if (productList) {
    productList.addEventListener("click", (e) => {
      // Like
      if (e.target.closest(".product__footer-like")) {
        const heart = e.target.closest(".product__footer-like")
        const productContainer = heart.closest(".product")
        const id = productContainer.getAttribute("data-id")

        if (heart.classList.contains("product__footer-like--liked")) {
          fetch("/api/product/unfavorite", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({
              id: id,
            }),
          })
            .then((response) => response.json())
            .then((data) => {
              if (data.status === "success") {
                heart.classList.remove("product__footer-like--liked")
                createNotification("success", data.message)
              } else {
                createNotification("error", data.message)
              }
            })
        } else {
          fetch("/api/product/favorite", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({
              id: id,
            }),
          })
            .then((response) => response.json())
            .then((data) => {
              if (data.status === "success") {
                heart.classList.add("product__footer-like--liked")
                createNotification("success", data.message)
              } else {
                createNotification("error", data.message)
              }
            })
        }
      }

      // Cambio de tamaño
      if (e.target.classList.contains("product__footer-size-option")) {
        const selectedOption = e.target
        const sizeContainer = selectedOption.closest(".product__footer-size")
        const options = sizeContainer.querySelectorAll(".product__footer-size-option")

        // Cambiar la selección visual
        options.forEach((opt) => opt.classList.remove("product__footer-size-option--selected"))
        selectedOption.classList.add("product__footer-size-option--selected")

        // Mostrar el precio correspondiente
        const productContainer = selectedOption.closest(".product")
        const prices = productContainer.querySelectorAll(".product__price")
        const selectedSizeValue = selectedOption.getAttribute("value")

        prices.forEach((price) => {
          if (price.getAttribute("value") === selectedSizeValue) {
            price.classList.remove("product__price--hidden")
          } else {
            price.classList.add("product__price--hidden")
          }
        })
      }
    })
  }
})()
function chunkArrayInGroups(array, size) {
  const newArray = []
  for (let i = 0; i < array.length; i += size) {
    newArray.push(array.slice(i, i + size))
  }
  return newArray
}

function updateHTML(container, products, notFound = false) {
  container.innerHTML = "" // Limpiar la lista de productos
  let productHTML = ""

  if (notFound) {
    productHTML = `
            <div class="product__empty">
                <h3 class="product__empty-title">¡Lo sentimos! No hay productos disponibles</h3>
                <p class="product__empty-description">Intente de nuevo mas tarde</p>
            </div>
        `

    container.insertAdjacentHTML("beforeend", productHTML)
  } else {
    const viewButton = document.querySelector(".view__button")
    let productGrid = ""
    let productImageContainerGrid = ""
    let productImageGrid = ""
    let productFooterGrid = ""

    if (viewButton.classList.contains("view__button--grid")) {
      productGrid = "product--grid"
      productImageContainerGrid = "product__image-container--grid"
      productImageGrid = "product__image--grid"
      productFooterGrid = "product__footer--grid"
    }

    products.forEach((product) => {
      const sizes = ["chico", "mediano", "grande"]
      let firstSizeSet = false
      let priceHTML = ""
      let sizeHTML = ""

      sizes.forEach((size) => {
        if (product[size] != null) {
          if (!firstSizeSet) {
            // Primer tamaño disponible: visible y seleccionado
            priceHTML += `<p value="${size}" class="product__price">$${product[size]}</p>`
            sizeHTML += `<div value="${size}" class="product__footer-size-option product__footer-size-option--${size} product__footer-size-option--selected">${size.charAt(0).toUpperCase()}</div>`
            firstSizeSet = true
          } else {
            // Otros tamaños disponibles: ocultos o no seleccionados
            priceHTML += `<p value="${size}" class="product__price product__price--hidden">$${product[size]}</p>`
            sizeHTML += `<div value="${size}" class="product__footer-size-option product__footer-size-option--${size}">${size.charAt(0).toUpperCase()}</div>`
          }
        }
      })

      const productHTML = `
              <div class="product ${productGrid}" data-id="${product.id}">
                <div class="product__image-container ${productImageContainerGrid}">
                  <img class="product__image ${productImageGrid}" src="/assets/img/product/${product.ruta}.jpg" alt="${product.nombre}">
                </div>
                <div class="product__content">
                  <div class="product__information">
                    <h3 class="product__title">${product.nombre}</h3>
                    ${priceHTML}
                    <p class="product__description">${product.descripcion}</p>
                  </div>
                </div>
                <div class="product__footer ${productFooterGrid}">
                  <button class="product__footer-button add-to-cart-btn" data-id-producto="${product.id}"> Agregar al carrito
                </button>
                  <div class="product__footer-size">
                    ${sizeHTML}
                  </div>
                  <div class="product__footer-like ${product.favorito ? "product__footer-like--liked" : ""}">
                    <svg class="heart-icon" viewBox="0 0 24 24" width="26" height="26">
                      <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                    </svg>
                  </div>
                </div>
              </div>
            `

      container.insertAdjacentHTML("beforeend", productHTML)

      const nuevoBoton = container.querySelector(`.add-to-cart-btn[data-id-producto="${product.id}"]`)
      nuevoBoton.addEventListener("click", function () {
        const idProducto = this.dataset.idProducto
        const cantidad = 1
        let idTamaño = 1
        const ProducSelect = this.closest(".product")
        const selectedSize = ProducSelect.querySelector(".product__footer-size-option--selected").getAttribute("value")
        if (selectedSize === "chico") {
          idTamaño = 1
        } else if (selectedSize === "mediano") {
          idTamaño = 2
        } else if (selectedSize === "grande") {
          idTamaño = 3
        }
        agregarAlCarrito(idProducto, idTamaño, cantidad)
      })
    })
  }
}

function agregarAlCarrito(idProducto, idTamaño, cantidad) {
  fetch("/api/carrito/agregar", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      id_producto: idProducto,
      id_tamaño: idTamaño,
      cantidad: cantidad,
    }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "success") {
        createNotification("success", "Producto agregado al carrito")
        actualizarContadorCarrito()
      } else {
        createNotification("error", data.message || "Error al agregar al carrito")
      }
    })
    .catch((error) => {
      console.error("Error:", error)
      createNotification("error", "Error de conexión")
    })
}

function actualizarContadorCarrito(count) {
  const contadorElements = document.querySelectorAll(".cart-indicator, .cart-count")
  if (contadorElements.length === 0) return

  if (count !== undefined) {
    contadorElements.forEach((element) => {
      element.textContent = count
      element.style.display = count > 0 ? "flex" : "none"
    })
    return
  }

  fetch("/api/carrito/obtener")
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "success") {
        const totalItems = data.items.reduce((total, item) => total + Number.parseInt(item.cantidad), 0)
        contadorElements.forEach((element) => {
            element.textContent = totalItems
            element.style.display = totalItems > 0 ? "flex" : "none"
        })
        }
    })
    .catch((error) => {
        console.error("Error:", error)
    })
}

function updatePagination(container, totalPages, actualPage = 1, notFound = false) {
  container.innerHTML = "" // Limpiar la paginación
    let paginationHTML = ""

    if (notFound) {
    container.insertAdjacentHTML("beforeend", paginationHTML)
    return // No mostrar paginación si no hay productos
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
