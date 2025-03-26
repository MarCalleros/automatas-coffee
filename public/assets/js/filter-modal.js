(function() {
    const filterButton = document.querySelector('.filter__button');
    const filterModal = document.querySelector('.filter-modal');
    const closeModalButton = document.querySelector('#filter-close');
    const backgroundShadow = document.querySelector('#background-filter');
    let scrollY = 0;

    filterButton.addEventListener('click', function() {
        scrollY = window.scrollY;
        filterModal.classList.add('filter-modal--active');
        backgroundShadow.classList.add('background__shadow--active');

        document.body.style.position = 'fixed';
        document.body.style.top = `-${scrollY}px`;
        document.body.style.width = '100%';
    });

    closeModalButton.addEventListener('click', function() {
        filterModal.classList.remove('filter-modal--active');
        backgroundShadow.classList.remove('background__shadow--active');

        document.body.style.position = '';
        document.body.style.top = '';
        window.scrollTo(0, scrollY);
    });
})();
