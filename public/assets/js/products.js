(function() {
    document.addEventListener('DOMContentLoaded', function() {
        const paginationButtons = document.querySelectorAll('.pagination__button');
        const productList = document.querySelector('.product-list');
        let isLoading = false;

        paginationButtons.forEach(button => {
            button.addEventListener('click', async function() {
                if (isLoading) return; // Evitar múltiples clics mientras se carga

                const currentButton = document.querySelector('.pagination__button--selected');
                if (currentButton === this) return; // Evitar recargar si el botón ya está seleccionado{

                isLoading = true; // Marcar como cargando

                let page = this.getAttribute('data-page');

                if (page === "first") {
                    // Buscar el primer boton y si no se encuentra ponerlo como null
                    const firstButton = document.querySelector('.pagination__button[data-page="10"]') || null;

                    if (currentButton === firstButton) return; // Evitar recargar si el botón ya está seleccionado

                    firstButton.classList.add('pagination__button--selected');
                    page = 1;
                    paginationButtons.forEach(btn => {
                        if (btn !== firstButton) {
                            btn.classList.remove('pagination__button--selected');
                        }
                    });
                } else if (page === "prev") {
                    const currentPage = parseInt(document.querySelector('.pagination__button--selected').getAttribute('data-page'));
                    page = currentPage - 1;
                    if (page < 1) page = 1;
                    const prevButton = document.querySelector(`.pagination__button[data-page="${page}"]`);
                    prevButton.classList.add('pagination__button--selected');
                    paginationButtons.forEach(btn => {
                        if (btn !== prevButton) {
                            btn.classList.remove('pagination__button--selected');
                        }
                    });
                } else if (page === "next") {
                    const currentPage = parseInt(document.querySelector('.pagination__button--selected').getAttribute('data-page'));
                    page = currentPage + 1;
                    if (page > 4) page = 4; // Cambia 4 por el número total de páginas que tengas
                    const nextButton = document.querySelector(`.pagination__button[data-page="${page}"]`);
                    nextButton.classList.add('pagination__button--selected');
                    paginationButtons.forEach(btn => {
                        if (btn !== nextButton) {
                            btn.classList.remove('pagination__button--selected');
                        }
                    });
                } else if (page === "last") {
                    const lastButton = document.querySelector('.pagination__button[data-page="4"]'); // Cambia 4 por el número total de páginas que tengas
                    lastButton.classList.add('pagination__button--selected');
                    page = 4; // Cambia 4 por el número total de páginas que tengas
                    paginationButtons.forEach(btn => {
                        if (btn !== lastButton) {
                            btn.classList.remove('pagination__button--selected');
                        }
                    });
                } else {
                    this.classList.add('pagination__button--selected');
                    paginationButtons.forEach(btn => {
                        if (btn !== this) {
                            btn.classList.remove('pagination__button--selected');
                        }
                    });
                }

                const response = await fetch(`/api/productos?page=${page}`);
                const products = await response.json();

                productList.innerHTML = ''; // Limpiar la lista de productos

                products.forEach(product => {
                    const productHTML = `
                      <div class="product">
                        <div class="product__image-container">
                          <img class="product__image" src="/assets/img/product/${product.ruta}.jpg" alt="${product.nombre}">
                        </div>
                        <div class="product__content">
                          <div class="product__information">
                            <h3 class="product__title">${product.nombre}</h3>
                            <p value="chico" class="product__price">$${product.chico}</p>
                            <p value="mediano" class="product__price product__price--hidden">$${product.mediano}</p>
                            <p value="grande" class="product__price product__price--hidden">$${product.grande}</p>
                            <p class="product__description">${product.descripcion}</p>
                          </div>
                        </div>
                        <div class="product__footer">
                          <button class="product__footer-button">Agregar al carrito</button>
                          <div class="product__footer-size">
                            <div value="chico" class="product__footer-size-option product__footer-size-option--small product__footer-size-option--selected">C</div>
                            <div value="mediano" class="product__footer-size-option product__footer-size-option--medium">M</div>
                            <div value="grande" class="product__footer-size-option product__footer-size-option--large">G</div>
                          </div>
                          <div class="product__footer-like">
                            <svg class="heart-icon" viewBox="0 0 24 24" width="26" height="26">
                              <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                            </svg>
                          </div>
                        </div>
                      </div>
                    `;
            
                    productList.insertAdjacentHTML('beforeend', productHTML);
                });

                isLoading = false; // Marcar como no cargando
                window.history.pushState({ page: page }, '', `?page=${page}`); // Cambiar la URL pero sin recargar colocando page={page} en la URL
            });
        });
    });

    const productList = document.querySelector('.product-list');

    productList.addEventListener('click', function (e) {
        // Like
        if (e.target.closest('.product__footer-like')) {
            const heart = e.target.closest('.product__footer-like');
            heart.classList.toggle('product__footer-like--liked');
        }

        // Cambio de tamaño
        if (e.target.classList.contains('product__footer-size-option')) {
            const selectedOption = e.target;
            const sizeContainer = selectedOption.closest('.product__footer-size');
            const options = sizeContainer.querySelectorAll('.product__footer-size-option');

            // Cambiar la selección visual
            options.forEach(opt => opt.classList.remove('product__footer-size-option--selected'));
            selectedOption.classList.add('product__footer-size-option--selected');

            // Mostrar el precio correspondiente
            const productContainer = selectedOption.closest('.product');
            const prices = productContainer.querySelectorAll('.product__price');
            const selectedSizeValue = selectedOption.getAttribute('value');

            prices.forEach(price => {
                if (price.getAttribute('value') === selectedSizeValue) {
                    price.classList.remove('product__price--hidden');
                } else {
                    price.classList.add('product__price--hidden');
                }
            });
        }
    });
})();