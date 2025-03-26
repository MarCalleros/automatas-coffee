(function() {
    const viewButton = document.querySelector('.view__button');
    const productList = document.querySelector('.product-list');
    const product = document.querySelectorAll('.product');
    const productImageContainer = document.querySelectorAll('.product__image-container');
    const productImage = document.querySelectorAll('.product__image');
    const productFooter = document.querySelectorAll('.product__footer');

    viewButton.addEventListener('click', function() {
        viewButton.classList.toggle('view__button--grid');
        productList.classList.toggle('product-list--grid');

        product.forEach(function(product) {
            product.classList.toggle('product--grid');
        });

        productImageContainer.forEach(function(container) {
            container.classList.toggle('product__image-container--grid');
        });

        productImage.forEach(function(image) {
            image.classList.toggle('product__image--grid');
        });

        productFooter.forEach(function(footer) {
            footer.classList.toggle('product__footer--grid');
        });
        changeSVG();
    });
})();

function changeSVG() {
    const viewButton = document.querySelector('.view__button');
    const viewIcon = document.querySelector('.view-icon');
    let newSVG = '';

    if (viewButton.classList.contains('view__button--grid')) {
        newSVG = 
        `<svg class="view-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
            <g id="SVGRepo_iconCarrier">
                <path d="M19.9 13.5H4.1C2.6 13.5 2 14.14 2 15.73V19.77C2 21.36 2.6 22 4.1 22H19.9C21.4 22 22 21.36 22 19.77V15.73C22 14.14 21.4 13.5 19.9 13.5Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M19.9 2H4.1C2.6 2 2 2.64 2 4.23V8.27C2 9.86 2.6 10.5 4.1 10.5H19.9C21.4 10.5 22 9.86 22 8.27V4.23C22 2.64 21.4 2 19.9 2Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
            </g>
        </svg>`;
    } else {
        newSVG = 
        `<svg class="view-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
            <g id="SVGRepo_iconCarrier"> 
                <path d="M22 8.52V3.98C22 2.57 21.36 2 19.77 2H15.73C14.14 2 13.5 2.57 13.5 3.98V8.51C13.5 9.93 14.14 10.49 15.73 10.49H19.77C21.36 10.5 22 9.93 22 8.52Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> 
                <path d="M22 19.77V15.73C22 14.14 21.36 13.5 19.77 13.5H15.73C14.14 13.5 13.5 14.14 13.5 15.73V19.77C13.5 21.36 14.14 22 15.73 22H19.77C21.36 22 22 21.36 22 19.77Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> 
                <path d="M10.5 8.52V3.98C10.5 2.57 9.86 2 8.27 2H4.23C2.64 2 2 2.57 2 3.98V8.51C2 9.93 2.64 10.49 4.23 10.49H8.27C9.86 10.5 10.5 9.93 10.5 8.52Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> 
                <path d="M10.5 19.77V15.73C10.5 14.14 9.86 13.5 8.27 13.5H4.23C2.64 13.5 2 14.14 2 15.73V19.77C2 21.36 2.64 22 4.23 22H8.27C9.86 22 10.5 21.36 10.5 19.77Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> 
            </g>
        </svg>`;
    }

    viewIcon.innerHTML = newSVG;
}