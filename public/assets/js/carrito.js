import { createNotification } from "./notification.js"

document.addEventListener("DOMContentLoaded", () => {
  let productData = null
  try {
    const text = `{
            "products": [
                { "name": "Café Helado", "small": "30.00", "medium": "35.00", "large": "38.00" },
                { "name": "Capuccino", "small": "33.00", "medium": "38.00", "large": "40.00" },
                { "name": "Espresso", "small": "27.00", "medium": "32.00", "large": "35.00" },
                { "name": "Chocolate Helado", "small": "42.00", "medium": "47.00", "large": "50.00" },
                { "name": "Machiato", "small": "43.00", "medium": "48.00", "large": "50.00" },
                { "name": "Latte Helado", "small": "45.00", "medium": "50.00", "large": "53.00" },
                { "name": "Café Salentina", "small": "32.00", "medium": "37.00", "large": "40.00" },
                { "name": "Latte Macchiato", "small": "36.00", "medium": "41.00", "large": "44.00" },
                { "name": "Latte Mango", "small": "40.00", "medium": "45.00", "large": "48.00" },
                { "name": "Mocha", "small": "62.00", "medium": "67.00", "large": "70.00" },
                { "name": "Mocca Latte", "small": "58.00", "medium": "63.00", "large": "66.00" }
            ]
        }`
    productData = JSON.parse(text)
  } catch (error) {
    console.error("Error al cargar datos de productos:", error)
    productData = { products: [] }
  }
  const sizeMap = {
    small: "Chico",
    medium: "Mediano",
    large: "Grande",
  }

  const sizeMapInverse = {
    Chico: "small",
    Mediano: "medium",
    Grande: "large",
  }

  let carrito = []
  cargarCarritoDesdeCoookies()
  if (document.querySelector(".cart-items")) {
    inicializarEventosCarrito()
    actualizarTotalCompra()
  }
  inicializarEventosProductos()

  /**
   * Obtiene el usuario actual desde la cookie
   * @returns {string|null} - Nombre de usuario o null si no está logueado
   */
  function obtenerUsuarioActual() {
    const loggedCookie = getCookie("logged")
    //Si la cookie no existe o es 'false', el usuario no está logueado
    if (loggedCookie === null || loggedCookie === "false") {
      return null
    }
    //Si la cookie tiene otro valor, ese es el nombre de usuario
    return loggedCookie
  }

  /**
   * Verifica si el usuario está logueado
   * @returns {boolean} - true si está logueado, false en caso contrario
   */
  function estaLogueado() {
    return obtenerUsuarioActual() !== null
  }

  /**
   * Obtiene el nombre de la cookie del carrito específica para el usuario actual
   * @returns {string} - Nombre de la cookie del carrito
   */
  function obtenerNombreCookieCarrito() {
    const usuario = obtenerUsuarioActual()
    if (!usuario) {
      return "carritoAutomatas" 
    }
    return `carritoAutomatas_${usuario}`
  }

  /**
   * Obtiene una cookie por su nombre
   * @param {string} name - Nombre de la cookie
   * @returns {string|null} - Valor de la cookie o null si no existe
   */
  function getCookie(name) {
    const match = document.cookie.match(new RegExp("(^| )" + name + "=([^;]+)"))
    return match ? decodeURIComponent(match[2]) : null
  }

  function mostrarMensajeInicioSesion() {
    createNotification("error", "Debes iniciar sesión para agregar productos al carrito")
  }

  //Redirige al usuario a la página de inicio de sesión
  function redirigirAInicioSesion() {
    //Abrir el modal de login
    const loginButton = document.querySelector(".navbar__button")
    if (loginButton) {
      loginButton.click()
    } else {
      window.location.href = "/login.html"
    }
  }

  function inicializarEventosCarrito() {
    //Verificacion para ver si el usuario está logueado
    if (!estaLogueado()) {
      const cartItemsContainer = document.querySelector(".cart-items")
      if (cartItemsContainer) {
        cartItemsContainer.innerHTML = '<div class="empty-cart">Debes iniciar sesión para ver tu carrito</div>'
      }

      const totalElement = document.querySelector(".total-price")
      if (totalElement) {
        totalElement.textContent = "$0.00"
      }

      //Deshabilitar el botón de comprar
      const buyBtn = document.querySelector(".buy-btn")
      if (buyBtn) {
        buyBtn.disabled = true
        buyBtn.style.opacity = "0.5"
        buyBtn.style.cursor = "not-allowed"
        buyBtn.addEventListener("click", (e) => {
          e.preventDefault()
          mostrarMensajeInicioSesion()
        })
      }

      return
    }

    //Primero, eliminar todos los event listeners existentes
    document.querySelectorAll(".quantity-btn.plus").forEach((btn) => {
      const newBtn = btn.cloneNode(true)
      btn.parentNode.replaceChild(newBtn, btn)
    })

    document.querySelectorAll(".quantity-btn.minus").forEach((btn) => {
      const newBtn = btn.cloneNode(true)
      btn.parentNode.replaceChild(newBtn, btn)
    })

    document.querySelectorAll(".delete-btn").forEach((btn) => {
      const newBtn = btn.cloneNode(true)
      btn.parentNode.replaceChild(newBtn, btn)
    })

    //Ahora agregar los nuevos event listeners
    document.querySelectorAll(".quantity-btn.plus").forEach((btn) => {
      btn.addEventListener("click", function () {
        const cartItem = this.closest(".cart-item")
        const quantityElement = cartItem.querySelector(".quantity")
        let cantidad = Number.parseInt(quantityElement.textContent)
        cantidad++
        quantityElement.textContent = cantidad
        // Actualizar el carrito
        actualizarItemEnCarrito(cartItem, cantidad)
      })
    })

    //Botones de disminuir cantidad
    document.querySelectorAll(".quantity-btn.minus").forEach((btn) => {
      btn.addEventListener("click", function () {
        const cartItem = this.closest(".cart-item")
        const quantityElement = cartItem.querySelector(".quantity")
        let cantidad = Number.parseInt(quantityElement.textContent)

        if (cantidad > 1) {
          cantidad--
          quantityElement.textContent = cantidad
          // Actualizar carrito
          actualizarItemEnCarrito(cartItem, cantidad)
        }
      })
    })

    //Boton para eliminar el producto del carrito
    document.querySelectorAll(".delete-btn").forEach((btn) => {
      btn.addEventListener("click", function () {
        const cartItem = this.closest(".cart-item")
        eliminarItemDelCarrito(cartItem)
        cartItem.remove()
        actualizarTotalCompra()
      })
    })

    // Boton de comprar para simular la compra
    const buyBtn = document.querySelector(".buy-btn")
    if (buyBtn) {
      //Eliminar eventos existentes
      const newBuyBtn = buyBtn.cloneNode(true)
      buyBtn.parentNode.replaceChild(newBuyBtn, buyBtn)

      //Agregar nuevo evento
      newBuyBtn.addEventListener("click", () => {
        //Verificar si el usuario está logueado
        if (!estaLogueado()) {
          mostrarMensajeInicioSesion()
          return
        }

        if (carrito.length > 0) {
          createNotification(
            "success",
            `Gracias por comprar en Automatas Coffee! Total: $${calcularTotal().toFixed(2)}`,
          )
          vaciarCarrito()
        } else {
          createNotification("success", "Tu carrito está vacío")
        }
      })
    }
  }

  //Inicializa eventos en la página de productos
  function inicializarEventosProductos() {
    //Botones de agregar al carrito
    const botonesAgregar = document.querySelectorAll("button")

    botonesAgregar.forEach((btn) => {
      if (btn.textContent.trim() === "Agregar al carrito") {
        btn.addEventListener("click", function () {
          //Verificar si el usuario está logueado
          if (!estaLogueado()) {
            mostrarMensajeInicioSesion()
            return
          }
          const productCard = this.closest(".product")
          if (!productCard) {
            console.log("No se encontró el contenedor del producto con la clase .product")
            return
          }

          //Obtener el nombre del producto
          const nombreElement =
            productCard.querySelector(".product__title") ||
            productCard.querySelector("h3") ||
            productCard.querySelector("h2")
          if (!nombreElement) {
            console.log("No se encontró el elemento con el nombre del producto")
            return
          }
          const nombre = nombreElement.textContent.trim()
          //Obtener el tamaño seleccionado usando las clases correctas
          let sizeValue = "medium" //mediano sera el valor por defecto
          const sizeOptions = productCard.querySelectorAll(".product__footer-size-option")

          if (sizeOptions.length > 0) {
            //Buscar la opción seleccionada
            const selectedOption = productCard.querySelector(".product__footer-size-option--selected")
            if (selectedOption) {
              sizeValue = selectedOption.getAttribute("value") || "medium"
            } else {
              // Si no hay opción seleccionada, usar la primera
              sizeValue = sizeOptions[0].getAttribute("value") || "medium"
            }
          }

          //Convertir el valor del tamaño a nombre mostrado
          const tamaño = sizeMap[sizeValue] || "Mediano"

          //Obtener el precio actual mostrado
          const precioElement = productCard.querySelector(".product__price") || productCard.querySelector("p")
          if (!precioElement) {
            console.log("No se encontró el elemento con el precio del producto")
            return
          }
          const precioText = precioElement.textContent
          const precio = Number.parseFloat(precioText.replace("$", ""))

          //Obtener la descripción
          let descripcion = ""
          const descripcionElement = productCard.querySelector(".product__description")
          if (descripcionElement) {
            descripcion = descripcionElement.textContent.trim()
          }

          //Obtener la imagen 
          let imagenSrc = "/assets/img/product/default.jpg" 
          const imagenElement = productCard.querySelector(".product__image img") || productCard.querySelector("img")
          if (imagenElement) {
            imagenSrc = imagenElement.getAttribute("src")
          }

          console.log("Agregando al carrito:", {
            nombre,
            tamaño,
            precio,
            descripcion,
            imagenSrc,
          })

          //Agregar al carrito
          agregarAlCarrito(nombre, tamaño, precio, descripcion, imagenSrc)
        })
      }
    })
  }
  function actualizarItemEnCarrito(cartItem, cantidad) {
    //Verificar si el usuario está logueado
    if (!estaLogueado()) {
      mostrarMensajeInicioSesion()
      return
    }

    const nombre = cartItem.querySelector(".item-title h3").textContent
    const tamaño = cartItem.querySelector(".item-size").textContent
    const precioUnitario = obtenerPrecioProducto(nombre, tamaño)
    const descripcion = cartItem.querySelector(".item-description").textContent.trim()
    const imagenSrc = cartItem.querySelector(".item-image img").getAttribute("src")

    //Buscar si el producto ya está en el carrito
    const index = carrito.findIndex((item) => item.nombre === nombre && item.tamaño === tamaño)

    if (index !== -1) {
      //Se actualiza la cantidad si ya existe
      carrito[index].cantidad = cantidad
    } else {
      //Agregar nuevo item si no existe
      carrito.push({
        nombre,
        tamaño,
        precio: precioUnitario,
        descripcion,
        imagenSrc,
        cantidad,
      })
    }
    cartItem.querySelector(".item-price").textContent = "$" + (precioUnitario * cantidad).toFixed(2)
    actualizarTotalCompra()
    guardarCarritoEnCookies()
  }

  function eliminarItemDelCarrito(cartItem) {
    //Verificar si el usuario está logueado
    if (!estaLogueado()) {
      mostrarMensajeInicioSesion()
      return
    }

    const nombre = cartItem.querySelector(".item-title h3").textContent
    const tamaño = cartItem.querySelector(".item-size").textContent

    carrito = carrito.filter((item) => !(item.nombre === nombre && item.tamaño === tamaño))

    guardarCarritoEnCookies()

    if (carrito.length === 0) {
      mostrarCarritoVacio()
    }
  }
  //Funcion para calcular total
  function calcularTotal() {
    return carrito.reduce((total, item) => {
      return total + Number.parseFloat(item.precio) * Number.parseInt(item.cantidad)
    }, 0)
  }


  //Actualiza el total mostrado en la página
  function actualizarTotalCompra() {
    const totalElement = document.querySelector(".total-price")
    if (totalElement) {
      totalElement.textContent = "$" + calcularTotal().toFixed(2)
    }
  }
  //Obtiene el precio de un producto según su nombre y tamaño
  function obtenerPrecioProducto(nombre, tamaño) {
    const sizeKey = sizeMapInverse[tamaño] || "medium" //Por defecto medium

    const producto = productData.products.find((p) => p.name === nombre)
    if (producto && producto[sizeKey]) {
      return Number.parseFloat(producto[sizeKey])
    }

    //Si no se encuentra en los datos, buscar en el DOM
    const cartItems = document.querySelectorAll(".cart-item")
    for (const item of cartItems) {
      const itemNombre = item.querySelector(".item-title h3").textContent
      const itemTamaño = item.querySelector(".item-size").textContent

      if (itemNombre === nombre && itemTamaño === tamaño) {
        const precioText = item.querySelector(".item-price").textContent
        const cantidad = Number.parseInt(item.querySelector(".quantity").textContent)
        return Number.parseFloat(precioText.replace("$", "")) / cantidad
      }
    }
    return 0
  }

  //Guarda el carrito en cookies
  function guardarCarritoEnCookies() {
    //Verificar si el usuario está logueado antes de guardar cookies
    if (!estaLogueado()) {
      console.log("No se guardaron cookies del carrito porque el usuario no está logueado")
      return
    }

    const carritoJSON = JSON.stringify(carrito)
    const fechaExpiracion = new Date()
    fechaExpiracion.setTime(fechaExpiracion.getTime() + 7 * 24 * 60 * 60 * 1000) // 7 días
    const nombreCookie = obtenerNombreCookieCarrito()
    document.cookie = `${nombreCookie}=${encodeURIComponent(carritoJSON)};expires=${fechaExpiracion.toUTCString()};path=/`

    console.log(`Carrito guardado en cookie: ${nombreCookie}`)

    //Actualizar contador del carrito en el navbar si existe
    actualizarContadorCarrito()
  }

  function cargarCarritoDesdeCoookies() {
    if (!estaLogueado()) {
      console.log("No se cargaron cookies del carrito porque el usuario no está logueado")
      carrito = []
      return
    }

    const cookies = document.cookie.split(";")
    let carritoEncontrado = false
    const nombreCookie = obtenerNombreCookieCarrito()
    for (const cookie of cookies) {
      const [nombre, valor] = cookie.trim().split("=")

      if (nombre === nombreCookie) {
        try {
          carrito = JSON.parse(decodeURIComponent(valor))
          carritoEncontrado = true

          console.log(`Carrito cargado desde cookie: ${nombreCookie}`)

          //Si estamos en la página del carrito, actualizar la interfaz
          if (document.querySelector(".cart-items")) {
            actualizarInterfazDesdeCarrito()
          }
        } catch (error) {
          console.error("Error al cargar el carrito desde cookies:", error)
          carrito = []
        }
        break
      }
    }
    if (
      !carritoEncontrado &&
      document.querySelector(".cart-items") &&
      document.querySelectorAll(".cart-item").length > 0
    ) {
      inicializarCarritoDesdeDOM()
    }

    //Actualizar contador del carrito en el navbar
    actualizarContadorCarrito()
  }

  function inicializarCarritoDesdeDOM() {
    if (!estaLogueado()) {
      console.log("No se inicializó el carrito desde el DOM porque el usuario no está logueado")
      return
    }
    const cartItems = document.querySelectorAll(".cart-item")

    cartItems.forEach((item) => {
      const nombre = item.querySelector(".item-title h3").textContent
      const tamaño = item.querySelector(".item-size").textContent
      const precioText = item.querySelector(".item-price").textContent
      const cantidad = Number.parseInt(item.querySelector(".quantity").textContent)
      const precioUnitario = Number.parseFloat(precioText.replace("$", "")) / cantidad
      const descripcion = item.querySelector(".item-description").textContent.trim()
      const imagenSrc = item.querySelector(".item-image img").getAttribute("src")

      carrito.push({
        nombre,
        tamaño,
        precio: precioUnitario,
        descripcion,
        imagenSrc,
        cantidad,
      })
    })
    guardarCarritoEnCookies()
  }
  function actualizarInterfazDesdeCarrito() {
    const cartItemsContainer = document.querySelector(".cart-items")
    if (!cartItemsContainer) return
    cartItemsContainer.innerHTML = ""

    if (carrito.length === 0) {
      mostrarCarritoVacio()
      return
    }
    carrito.forEach((item) => {
      const cartItemHTML = `
                <div class="cart-item">
                    <div class="item-image">
                        <img src="${item.imagenSrc}" alt="${item.nombre}">
                    </div>
                    <div class="item-details">
                        <div class="item-header">
                            <div class="item-title">
                                <h3>${item.nombre}</h3>
                                <p class="item-size">${item.tamaño}</p>
                            </div>
                            <p class="item-price">$${(Number.parseFloat(item.precio) * Number.parseInt(item.cantidad)).toFixed(2)}</p>
                        </div>
                        <p class="item-description">
                            ${item.descripcion}
                        </p>
                        <div class="item-actions">
                            <div class="quantity-control">
                                <button class="quantity-btn minus">
                                    <svg width="14" height="2" viewBox="0 0 14 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1H13" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                                <span class="quantity">${item.cantidad}</span>
                                <button class="quantity-btn plus">
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7 1V13" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M1 7H13" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                            </div>
                            <button class="delete-btn">Eliminar</button>
                        </div>
                    </div>
                </div>
            `
      cartItemsContainer.insertAdjacentHTML("beforeend", cartItemHTML)
    })
    //Reinicializar eventos
    inicializarEventosCarrito()
    actualizarTotalCompra()
  }

  function mostrarCarritoVacio() {
    const cartItemsContainer = document.querySelector(".cart-items")
    if (cartItemsContainer) {
      cartItemsContainer.innerHTML = '<div class="empty-cart">Tu carrito está vacío</div>'
    }
    const totalElement = document.querySelector(".total-price")
    if (totalElement) {
      totalElement.textContent = "$0.00"
    }
  }

  function vaciarCarrito() {
    if (!estaLogueado()) {
      mostrarMensajeInicioSesion()
      return
    }
    carrito = []
    guardarCarritoEnCookies()
    mostrarCarritoVacio()
  }

  /**
   * Agrega un producto al carrito
   */
  function agregarAlCarrito(nombre, tamaño, precio, descripcion, imagenSrc) {
    if (!estaLogueado()) {
      mostrarMensajeInicioSesion()
      return
    }
    const index = carrito.findIndex((item) => item.nombre === nombre && item.tamaño === tamaño)

    if (index !== -1) {
      carrito[index].cantidad++
    } else {
      carrito.push({
        nombre,
        tamaño,
        precio,
        descripcion,
        imagenSrc,
        cantidad: 1,
      })
    }
    guardarCarritoEnCookies()

    createNotification("success", `${nombre} (${tamaño}) agregado al carrito`)
  }
  
  function actualizarContadorCarrito() {
    const contadorElement = document.querySelector(".cart-count")
    if (contadorElement) {
      const totalItems = carrito.reduce((total, item) => total + Number.parseInt(item.cantidad), 0)
      contadorElement.textContent = totalItems
      contadorElement.style.display = totalItems > 0 ? "block" : "none"
    }
  }
  window.agregarAlCarrito = agregarAlCarrito
})