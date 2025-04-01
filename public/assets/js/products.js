let text = `{
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
}`;

(function() {
    const data = JSON.parse(text);
    const hearts = document.querySelectorAll('.product__footer-like');
    const sizes = document.querySelectorAll('.product__footer-size');

    hearts.forEach(heart => {
        heart.addEventListener('click', function() {
            this.classList.toggle('product__footer-like--liked');
        });
    });

    sizes.forEach(size => {
        let options = size.querySelectorAll('.product__footer-size-option'); 

        options.forEach(option => {
            option.addEventListener('click', function() {
                options.forEach(opt => {
                    opt.classList.remove('product__footer-size-option--selected');
                });

                this.classList.add('product__footer-size-option--selected');

                let productContainer = size.closest('.product');
                let price = productContainer.querySelector('.product__price');
                let name = productContainer.querySelector('.product__title').textContent;
                let selectedSize = this.getAttribute('value');

                let product = data.products.find(product => product.name === name);
                let selectedPrice = product[selectedSize];
                price.textContent = `$${selectedPrice}`;
            });
        });
    });
})();