import { createNotification } from "./notification.js"

document.addEventListener("DOMContentLoaded", () => {
  cargarProductosCarrito()

  function cargarProductosCarrito() {
    const cartContainer = document.querySelector(".cart-items")
    if (!cartContainer) {
      console.error("No se encontró el contenedor del carrito.")
      return
    }

    fetch("/api/carrito/obtener")
      .then((response) => response.json())
      .then((data) => {
        if (data.status == "success" && data.items.length === 0) {
          cartContainer.innerHTML = '<div class="empty-cart">Tu carrito está vacío</div>'
          document.querySelector(".buy-btn").disabled = true
          document.querySelector(".total-price").textContent = "$0.00"
          return
        }

        cartContainer.innerHTML = ""

        data.items.forEach((product) => {
          const productHTML = `
            <div class="cart-item" data-id="${product.id_producto}" data-idcarrito="${product.id}">
              <div class="cart-item__image">
                <img src="/assets/img/product/${product.ruta_imagen}.jpg" alt="${product.nombre_producto}">
              </div>
              <div class="item-details">
                <div class="item-header"> 
                    <div class= "item-title">
                      <h3 class = "item-title">${product.nombre_producto}</h3>
                      <p class="item-size">${product.nombre_tamaño}</p>
                    </div>
                    <p class="item-price">$${(product.precio * product.cantidad).toFixed(2)}</p>
                </div>
                <p class="item-description">${product.descripcion}</p>
                <div class="item-actions"> 
                  <div class="quantity-control">
                    <button class="quantity-btn minus">
                      <svg width="14" height="2" viewBox="0 0 14 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 1H13" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                      </svg>
                    </button>
                    <span class="quantity">${product.cantidad}</span>
                    <button class="quantity-btn plus">
                      <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7 1V13" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M1 7H13" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                      </svg>
                    </button>
                  </div>
                  <button class="delete-btn">Eliminar</button>
                </div>
              </div>
            </div>
          `
          cartContainer.innerHTML += productHTML
        })

        inicializarEventosCarrito()
        document.querySelector(".total-price").textContent = `$${data.total.toFixed(2)}`
      })
      .catch((error) => {
        console.error("Error al cargar el carrito:", error)
      })
  }

  function inicializarEventosCarrito() {
    if (!document.querySelector(".cart-items")) {
      return
    }

    // Botones de aumentar cantidad
    document.querySelectorAll(".quantity-btn.plus").forEach((btn) => {
      btn.addEventListener("click", function () {
        if (this.disabled) return

        const cartItem = this.closest(".cart-item")
        const id = cartItem.getAttribute("data-idcarrito")
        const quantityElement = cartItem.querySelector(".quantity")
        let cantidad = Number.parseInt(quantityElement.textContent)
        cantidad++

        actualizarCantidadEnServidor(id, cantidad, (response) => {
          if (response.status === "success") {
            quantityElement.textContent = cantidad

            // Actualizar precio del item
            const precioUnitario = obtenerPrecioUnitario(cartItem)
            cartItem.querySelector(".item-price").textContent = "$" + (precioUnitario * cantidad).toFixed(2)
            // Actualizar total
            if (typeof response.total === "number") {
              document.querySelector(".total-price").textContent = "$" + response.total.toFixed(2)
            }
            // Verificar si se alcanzó el stock máximo
            const stockDisponible = obtenerStockDisponible(cartItem)
            if (cantidad >= stockDisponible) {
              this.disabled = true
            }

            // Habilitar el botón de disminuir
            cartItem.querySelector(".quantity-btn.minus").disabled = false

            // Actualizar contador del carrito
            actualizarContadorCarrito(response.total_items)
          } else {
            createNotification("error", response.message)
          }
        })
      })
    })

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

    // Botones de disminuir cantidad
    document.querySelectorAll(".quantity-btn.minus").forEach((btn) => {
      btn.addEventListener("click", function () {
        if (this.disabled) return

        const cartItem = this.closest(".cart-item")
        const id = cartItem.dataset.idcarrito
        const quantityElement = cartItem.querySelector(".quantity")
        let cantidad = Number.parseInt(quantityElement.textContent)

        if (cantidad > 1) {
          cantidad--

          actualizarCantidadEnServidor(id, cantidad, (response) => {
            if (response.status === "success") {
              quantityElement.textContent = cantidad

              // Actualizar precio del item
              const precioUnitario = obtenerPrecioUnitario(cartItem)
              cartItem.querySelector(".item-price").textContent = "$" + (precioUnitario * cantidad).toFixed(2)

              // Actualizar total
              document.querySelector(".total-price").textContent = "$" + response.total.toFixed(2)

              // Verificar si se alcanzó el mínimo
              if (cantidad <= 1) {
                this.disabled = true
              }

              // Habilitar el botón de aumentar
              cartItem.querySelector(".quantity-btn.plus").disabled = false

              // Actualizar contador del carrito
              actualizarContadorCarrito(response.total_items)
            } else {
              createNotification("error", response.message)
            }
          })
        }
      })
    })

    // Botones de eliminar
    document.querySelectorAll(".delete-btn").forEach((btn) => {
      btn.addEventListener("click", function () {
        console.log("Eliminando producto del carrito")
        const cartItem = this.closest(".cart-item")
        const id = cartItem.getAttribute("data-idcarrito")

        eliminarDelServidor(id, (response) => {
          if (response.status === "success") {
            cartItem.remove()

            // Actualizar total
            document.querySelector(".total-price").textContent = "$" + response.total.toFixed(2)

            // Verificar si el carrito quedó vacío
            if (response.total === 0) {
              document.querySelector(".cart-items").innerHTML = '<div class="empty-cart">Tu carrito está vacío</div>'
              document.querySelector(".buy-btn").disabled = true
            }

            // Actualizar contador del carrito
            actualizarContadorCarrito(response.total_items)

            createNotification("success", response.message)
          } else {
            createNotification("error", response.message)
          }
        })
      })
    })

    //Botón de comprar
    const buyBtn = document.querySelector(".buy-btn")
    if (buyBtn && !buyBtn.disabled) {
      buyBtn.addEventListener("click", function () {
        realizarCompra((response) => {
          if (response.status === "success") {
            document.querySelector(".cart-items").innerHTML = '<div class="empty-cart">Tu carrito está vacío</div>'
            document.querySelector(".total-price").textContent = "$0.00"
            this.disabled = true

            //Actualizar el contador del carrito
            actualizarContadorCarrito(0)

            createNotification("success", response.message)
          } else {
            createNotification("error", response.message)
          }
        })
      })
    }
  }

  function actualizarCantidadEnServidor(id, cantidad, callback) {
    fetch("/api/carrito/actualizar", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ id, cantidad }),
    })
      .then((response) => response.json())
      .then((data) => {
        callback(data)
      })
      .catch((error) => {
        console.log("Error:", error)
        callback({ status: "error", message: "Error de conexión" })
      })
  }

  function eliminarDelServidor(id, callback) {
    fetch("/api/carrito/eliminar", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ id }),
    })
      .then((response) => response.json())
      .then((data) => {
        callback(data)
      })
      .catch((error) => {
        console.error("Error:", error)
        callback({ status: "error", message: "Error de conexión" })
      })
  }

  function realizarCompra(callback) {
    fetch("/api/carrito/comprar", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
    })
      .then((response) => response.json())
      .then((data) => {
        callback(data)
      })
      .catch((error) => {
        console.error("Error:", error)
        callback({ status: "error", message: "Error de conexión" })
      })
  }

  function obtenerPrecioUnitario(cartItem) {
    const precioText = cartItem.querySelector(".item-price").textContent
    const cantidad = Number.parseInt(cartItem.querySelector(".quantity").textContent)
    return Number.parseFloat(precioText.replace("$", "")) / cantidad
  }

  function obtenerStockDisponible(cartItem) {
    const stockWarning = cartItem.querySelector(".stock-warning")
    if (stockWarning) {
      return Number.parseInt(stockWarning.textContent.replace("Stock disponible: ", ""))
    }
    return 999
  }
})