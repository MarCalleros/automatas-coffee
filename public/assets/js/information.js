(function() {
    const buttonMessage = document.querySelector('#information-messages');
    const buttonPruchases = document.querySelector('#information-purchases');
    const buttonAccount = document.querySelector('#information-account');

    const optionsMessage = document.querySelector('#information-messages-options');
    const optionsPurchases = document.querySelector('#information-purchases-options');
    const optionsAccount = document.querySelector('#information-account-options');

    buttonMessage.addEventListener('click', function() {
        console.log('Messages button clicked');
        optionsMessage.classList.toggle('information-menu__options--active');
    });

    buttonPruchases.addEventListener('click', function() {
        console.log('Purchases button clicked');
    });

    buttonAccount.addEventListener('click', function() {
        console.log('Account button clicked');
    });
})();