
//Nombre de la cookie donde se guardara el carrito: pachalenko
const COOKIE_NAME = "carritoAutomatas"

//Duración de la cookie en días
const COOKIE_DURATION = 365

/**
 * Guarda el carrito en una cookie
 * @param {Array} carrito 
 */
function guardarCarritoEnCookies(carrito) {
  try {
    const carritoJSON = JSON.stringify(carrito)
    const fechaExpiracion = new Date()
    fechaExpiracion.setTime(fechaExpiracion.getTime() + COOKIE_DURATION * 24 * 60 * 60 * 1000)

    document.cookie = `${COOKIE_NAME}=${encodeURIComponent(carritoJSON)};expires=${fechaExpiracion.toUTCString()};path=/`
    return true
  } catch (error) {
    console.error("Error al guardar el carrito en cookies:", error)
    return false
  }
}

/**
 * Carga el carrito desde las cookies
 * @returns {Array} - Array de objetos con los productos del carrito o array vacío si no hay cookie
 */
function cargarCarritoDesdeCoookies() {
  try {
    const cookies = document.cookie.split(";")

    for (const cookie of cookies) {
      const [nombre, valor] = cookie.trim().split("=")

      if (nombre === COOKIE_NAME && valor) {
        return JSON.parse(decodeURIComponent(valor))
      }
    }

    return [] 
  } catch (error) {
    console.error("Error al cargar el carrito desde cookies:", error)
    return []
  }
}

/**
 * Elimina la cookie del carrito
 * @returns {boolean} 
 */
function eliminarCookieCarrito() {
  try {
    document.cookie = `${COOKIE_NAME}=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/`
    return true
  } catch (error) {
    console.error("Error al eliminar la cookie del carrito:", error)
    return false
  }
}

/**
 * Verifica si existe la cookie del carrito
 * @returns {boolean} 
 */
function existeCookieCarrito() {
  const cookies = document.cookie.split(";")

  for (const cookie of cookies) {
    const [nombre] = cookie.trim().split("=")

    if (nombre === COOKIE_NAME) {
      return true
    }
  }

  return false
}

/**
 * Obtiene el total de items en el carrito
 * @returns {number} - Número total de items en el carrito
 */
function obtenerTotalItemsCarrito() {
  const carrito = cargarCarritoDesdeCoookies()

  return carrito.reduce((total, item) => {
    return total + (item.cantidad || 1)
  }, 0)
}

/**
 * Agrega un producto al carrito en las cookies
 * @param {Object} producto - Objeto con la información del producto
 * @returns {boolean} - true si se agregó correctamente, false en caso contrario
 */
function agregarProductoACookies(producto) {
  try {
    const carrito = cargarCarritoDesdeCoookies()

    //Se busca si el producto ya esta en el carrito
    const index = carrito.findIndex((item) => item.nombre === producto.nombre && item.tamaño === producto.tamaño)

    if (index !== -1) {
      //Incrementar cantidad si ya existe
      carrito[index].cantidad = (carrito[index].cantidad || 1) + (producto.cantidad || 1)
    } else {
      //El producto tiene que tener una cantidad
      if (!producto.cantidad) {
        producto.cantidad = 1
      }

      //Agregar nuevo item si no existe
      carrito.push(producto)
    }

    //Se Guarda en cookies
    return guardarCarritoEnCookies(carrito)
  } catch (error) {
    console.error("Error al agregar producto a cookies:", error)
    return false
  }
}

/**
 * Elimina un producto del carrito en las cookies
 * @param {string} nombre 
 * @param {string} tamaño
 * @returns {boolean} 
 */
function eliminarProductoDeCookies(nombre, tamaño) {
  try {
    let carrito = cargarCarritoDesdeCoookies()

    //Filtrar el carrito para eliminar el item
    carrito = carrito.filter((item) => !(item.nombre === nombre && item.tamaño === tamaño))

    //Guardar en cookies
    return guardarCarritoEnCookies(carrito)
  } catch (error) {
    console.error("Error al eliminar producto de cookies:", error)
    return false
  }
}

/**
 * Actualiza la cantidad de un producto en el carrito
 * @param {string} nombre 
 * @param {string} tamaño 
 * @param {number} cantidad 
 * @returns {boolean} 
 */
function actualizarCantidadEnCookies(nombre, tamaño, cantidad) {
  try {
    const carrito = cargarCarritoDesdeCoookies()

    //Buscar el producto en el carrito
    const index = carrito.findIndex((item) => item.nombre === nombre && item.tamaño === tamaño)

    if (index !== -1) {
      //Actualizar cantidad
      carrito[index].cantidad = cantidad

      //Guardar en cookies
      return guardarCarritoEnCookies(carrito)
    }

    //No se encontró el producto
    return false 
  } catch (error) {
    console.error("Error al actualizar cantidad en cookies:", error)
    return false
  }
}
/**
 * Vacía completamente el carrito
 * @returns {boolean} o
 */
function vaciarCarritoEnCookies() {
  return guardarCarritoEnCookies([])
}

/**
 * Calcula el total del carrito
 * @returns {number} - Total del carrito
 */
function calcularTotalCarritoEnCookies() {
  const carrito = cargarCarritoDesdeCoookies()

  return carrito.reduce((total, item) => {
    return total + item.precio * (item.cantidad || 1)
  }, 0)
}

//Exportar todas las funciones para que puedan ser utilizadas por otros archivos
window.CarritoCookies = {
    guardar: guardarCarritoEnCookies,
    cargar: cargarCarritoDesdeCoookies,
    eliminarCookie: eliminarCookieCarrito,
    existe: existeCookieCarrito,
    totalItems: obtenerTotalItemsCarrito,
    agregarProducto: agregarProductoACookies,
    eliminarProducto: eliminarProductoDeCookies,
    actualizarCantidad: actualizarCantidadEnCookies,
    vaciar: vaciarCarritoEnCookies,
    calcularTotal: calcularTotalCarritoEnCookies,
}