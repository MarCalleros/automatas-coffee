(function() {
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
                let prices = productContainer.querySelectorAll('.product__price');
                let selectedSizeValue = this.getAttribute('value');

                prices.forEach(price => {
                    let sizeValue = price.getAttribute('value');
                    
                    if (sizeValue === selectedSizeValue) {
                        price.classList.remove('product__price--hidden');
                    } else {
                        price.classList.add('product__price--hidden');
                    }
                });
            });
        });
    });
})();