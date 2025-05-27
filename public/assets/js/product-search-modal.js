class ProductSearchModal {
  constructor() {
    this.modal = document.getElementById("product-search-modal")
    this.searchInput = document.getElementById("product-search-input")
    this.searchResults = document.getElementById("search-results")
    this.productsList = document.getElementById("products-list")
    this.emptyState = document.getElementById("empty-state")
    this.noResults = document.getElementById("no-results")
    this.resultsCount = document.getElementById("results-count")
    this.loadingSpinner = document.getElementById("search-loading")
    this.analyzeBtn = document.getElementById("analyze-selected")

    this.selectedProduct = null
    this.searchTimeout = null
    this.products = []

    this.init()
  }

  init() {
    this.bindEvents()
    this.bindAnalysisEvents()
  }

  bindEvents() {
    // Abrir modal
    document.getElementById("open-product-search").addEventListener("click", () => {
      this.openModal()
    })

    // Cerrar modal
    document.getElementById("close-modal").addEventListener("click", () => {
      this.closeModal()
    })

    document.getElementById("cancel-search").addEventListener("click", () => {
      this.closeModal()
    })

    // Cerrar con ESC o click fuera
    this.modal.addEventListener("click", (e) => {
      if (e.target === this.modal) {
        this.closeModal()
      }
    })

    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape" && this.modal.classList.contains("active")) {
        this.closeModal()
      }
    })

    // Búsqueda en tiempo real
    this.searchInput.addEventListener("input", (e) => {
      this.handleSearch(e.target.value)
    })

    // Limpiar búsqueda
    document.getElementById("clear-search").addEventListener("click", () => {
      this.clearSearch()
    })

    // Analizar producto seleccionado
    this.analyzeBtn.addEventListener("click", () => {
      this.analyzeProduct()
    })
  }

  openModal() {
    this.modal.classList.add("active")
    document.body.style.overflow = "hidden"

    // Focus en el input después de la animación
    setTimeout(() => {
      this.searchInput.focus()
    }, 300)
  }

  closeModal() {
    this.modal.classList.remove("active")
    document.body.style.overflow = ""
    this.resetModal()
  }

  resetModal() {
    this.searchInput.value = ""
    this.selectedProduct = null
    this.products = []
    this.searchResults.style.display = "none"
    this.emptyState.style.display = "block"
    this.noResults.style.display = "none"
    this.analyzeBtn.disabled = true
    this.productsList.innerHTML = ""
  }
  

  handleSearch(query) {

    if (this.searchTimeout) {
      clearTimeout(this.searchTimeout)
    }

    // Si la query está vacía, mostrar estado inicial
    if (!query.trim()) {
      this.showEmptyState()
      return
    }
    this.showLoading(true)

    this.searchTimeout = setTimeout(() => {
      this.searchProducts(query)
    }, 300)
    
  }

  async searchProducts(query) {
    try {
      const response = await fetch(`/api/estadisticas/buscarProductos?q=${encodeURIComponent(query)}`)

      if (!response.ok) {
        throw new Error("Error en la búsqueda")
      }

      const data = await response.json()
      this.products = data.productos || []

      this.showLoading(false)
      this.displayResults()
    } catch (error) {
      console.error("Error al buscar productos:", error)
      this.showLoading(false)
      this.showNoResults()
    }
  }

  displayResults() {
    if (this.products.length === 0) {
      this.showNoResults()
      return
    }

    this.emptyState.style.display = "none"
    this.noResults.style.display = "none"
    this.searchResults.style.display = "block"

    this.resultsCount.textContent = `${this.products.length} producto${this.products.length !== 1 ? "s" : ""} encontrado${this.products.length !== 1 ? "s" : ""}`

    this.productsList.innerHTML = this.products.map((product) => this.createProductItem(product)).join("")

    this.productsList.querySelectorAll(".product-item").forEach((item, index) => {
      item.addEventListener("click", () => {
        this.selectProduct(index)
      })
    })
  }

  createProductItem(product) {
    return `
            <div class="product-item" data-product-id="${product.id}">
                <div class="product-info">
                    <div class="product-name">${product.nombre}</div>
                    <div class="product-details">
                        <span>Categoría: ${product.categoria || "Sin categoría"}</span>
                    </div>
                </div>
                <div class="product-stats">
                    <div class="stat-value">${product.total_vendido || 0}</div>
                    <div class="stat-label">Vendidos</div>
                </div>
            </div>
        `
  }

  selectProduct(index) {
    this.productsList.querySelectorAll(".product-item").forEach((item) => {
      item.classList.remove("selected")
    })

    const selectedItem = this.productsList.children[index]
    selectedItem.classList.add("selected")

    this.selectedProduct = this.products[index]
    this.analyzeBtn.disabled = false
  }

  showEmptyState() {
    this.searchResults.style.display = "none"
    this.noResults.style.display = "none"
    this.emptyState.style.display = "block"
  }

  showNoResults() {
    this.searchResults.style.display = "none"
    this.emptyState.style.display = "none"
    this.noResults.style.display = "block"
  }

  showLoading(show) {
    const searchIcon = this.modal.querySelector(".search-icon")

    if (show) {
      this.loadingSpinner.style.display = "block"
    } else {
      this.loadingSpinner.style.display = "none"
    }
  }

    clearSearch() {
    this.searchInput.value = ""
    this.resetModal()
    this.searchInput.focus()
  }

  analyzeProduct() {
    if (!this.selectedProduct) return

    this.searchResults.style.display = 'none';
    this.emptyState.style.display = 'none';
    this.noResults.style.display = 'none';
    document.getElementById('product-analysis').style.display = 'block';

        this.loadProductAnalysis(this.selectedProduct.id);
    }

    async loadProductAnalysis(productId) {
    try {
        const response = await fetch(`/api/estadisticas/producto/${productId}`);
        const data = await response.json();

        document.getElementById('product-title').textContent = data.nombre;
        document.getElementById('total-sales').textContent = data.total_vendido.toLocaleString();
        document.getElementById('total-revenue').textContent = 
            `$${data.total_ingresos.toLocaleString('es-MX', { 
                minimumFractionDigits: 2,
                maximumFractionDigits: 2 
            })}`;
        document.getElementById('stock-available').textContent = data.stock_total.toLocaleString();
        document.getElementById('unit-price').textContent = data.precio_unitario.toLocaleString('es-MX', {
            style: 'currency',
            currency: 'MXN',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

    } catch (error) {
        console.error('Error cargando análisis:', error);
        alert('Error al cargar los datos del producto');
    }
}

    bindAnalysisEvents() {
        document.getElementById('back-to-results').addEventListener('click', () => {
            document.getElementById('product-analysis').style.display = 'none';
            this.searchResults.style.display = 'block';
        });
    }
}

// Inicializar cuando el DOM esté listo
document.addEventListener("DOMContentLoaded", () => {
    new ProductSearchModal()
})
