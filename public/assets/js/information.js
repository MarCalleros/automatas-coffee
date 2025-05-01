(function() {
    const buttons = [
        { button: document.querySelector('#information-messages'), options: document.querySelector('#information-messages-options') },
        { button: document.querySelector('#information-purchases'), options: document.querySelector('#information-purchases-options') },
        { button: document.querySelector('#information-account'), options: document.querySelector('#information-account-options') }
    ];

    buttons.forEach(item => {
        item.button.addEventListener('click', function() {
            item.options.classList.toggle('information-menu__options--active');
            
            const arrow = this.querySelector('.information-menu__arrow svg');
            if (item.options.classList.contains('information-menu__options--active')) {
                arrow.style.transform = 'rotate(180deg)';
            } else {
                arrow.style.transform = 'rotate(0deg)';
            }
        });
    });
})();