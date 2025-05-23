let information = {
    receive: {
        address: '',
        },
    pay: {
        method: '',
        },
    amount: {
        total: '120.00',
        },
    };

(function() {
    const deliveryReceiveButtons = document.querySelectorAll('.delivery-receive__container--receive');
    const cardAddress = document.querySelector('.delivery-receive__card--address');
    const cardSubsidiary = document.querySelector('.delivery-receive__card--subsidiary');
    const receiveCards = document.querySelectorAll('.delivery-receive__info-container');

    const deliveryMethodButtons = document.querySelectorAll('.delivery-receive__container--method');
    const cardCard = document.querySelector('.delivery-receive__card--card');
    const methodCards = document.querySelectorAll('.delivery-method__card-container');
    const methodInputs = document.querySelectorAll('.delivery-method__input');
    const methodNumberInputs = document.querySelectorAll('.delivery-method__input--short');

    deliveryReceiveButtons.forEach(button => {
        button.addEventListener('click', function() {
            deliveryReceiveButtons.forEach(btn => {
                btn.classList.remove('delivery-receive__container--selected');
            });
            button.classList.add('delivery-receive__container--selected');

            const option = button.getAttribute('data-option');
            if (option === 'subsidiary') {
                cardAddress.classList.remove('delivery-receive__card--active');
                cardSubsidiary.classList.add('delivery-receive__card--active');
            } else {
                cardSubsidiary.classList.remove('delivery-receive__card--active');
                cardAddress.classList.add('delivery-receive__card--active');
            }
        });
    });
    
    receiveCards.forEach(card => {
        card.addEventListener('click', function() {
            receiveCards.forEach(c => {
                c.classList.remove('delivery-receive__info-container--selected');
            });
            card.classList.add('delivery-receive__info-container--selected');

            if (information.receive.address === '') {
                const separators = document.querySelectorAll('.step__separator');
                const numbers = document.querySelectorAll('.number-path');
                const method = document.querySelector('.delivery__content--method');
                separators[0].classList.add('step__separator--active');
                numbers[2].classList.add('number-path--active');
                numbers[3].classList.add('number-path--active');
                method.classList.add('delivery__content--active');
            }

            information.receive.address = "address";
        });
    });

    deliveryMethodButtons.forEach(button => {
        button.addEventListener('click', function() {
            deliveryMethodButtons.forEach(btn => {
                btn.classList.remove('delivery-receive__container--selected');
            });
            button.classList.add('delivery-receive__container--selected');

            const option = button.getAttribute('data-option');
            if (option === 'card') {
                const method = document.querySelector('.delivery__content--method');
                method.classList.add('delivery__content--full');
                cardCard.classList.add('delivery-receive__card--full');
            } else {
                methodCards.forEach(c => {
                    c.classList.remove('delivery-method__card-container--selected');
                });
                cardCard.classList.remove('delivery-receive__card--full');

                if (information.pay.method === '') {
                    const separators = document.querySelectorAll('.step__separator');
                    const numbers = document.querySelectorAll('.number-path');
                    const delivery = document.querySelector('.delivery__content--delivery');
                    separators[1].classList.add('step__separator--active');
                    numbers[4].classList.add('number-path--active');
                    numbers[5].classList.add('number-path--active');
                    delivery.classList.add('delivery__content--active');
                }

                information.pay.method = "money";
                putInformation();
            }
        });
    });

    methodCards.forEach(card => {
        card.addEventListener('click', function() {
            methodCards.forEach(c => {
                c.classList.remove('delivery-method__card-container--selected');
            });
            card.classList.add('delivery-method__card-container--selected');

            if (information.pay.method === '') {
                const separators = document.querySelectorAll('.step__separator');
                const numbers = document.querySelectorAll('.number-path');
                const delivery = document.querySelector('.delivery__content--delivery');
                separators[1].classList.add('step__separator--active');
                numbers[4].classList.add('number-path--active');
                numbers[5].classList.add('number-path--active');
                delivery.classList.add('delivery__content--active');
            }

            information.pay.method = "card";
            putInformation();
        });
    });

    methodInputs.forEach(input => {
        input.addEventListener('click', function() {
            methodCards.forEach(c => {
                c.classList.remove('delivery-method__card-container--selected');
            });
        });
    });

    methodNumberInputs.forEach(input => {
        input.addEventListener('input', function() {
            if (input.getAttribute('data-number') == 1) {
                if (input.value.length > 4) {
                    input.value = input.value.slice(0, 4);
                } else if (input.value.length == 4) {
                    const nextInput = document.querySelector('.delivery-method__input--short[data-number="2"]');
                    nextInput.focus();
                }
            } else if (input.getAttribute('data-number') == 2) {
                if (input.value.length > 4) {
                    input.value = input.value.slice(0, 4);
                } else if (input.value.length == 4) {
                    const nextInput = document.querySelector('.delivery-method__input--short[data-number="3"]');
                    nextInput.focus();
                }
            } else if (input.getAttribute('data-number') == 3) {
                if (input.value.length > 4) {
                    input.value = input.value.slice(0, 4);
                } else if (input.value.length == 4) {
                    const nextInput = document.querySelector('.delivery-method__input--short[data-number="4"]');
                    nextInput.focus();
                }
            } else if (input.getAttribute('data-number') == 4) {
                if (input.value.length > 4) {
                    input.value = input.value.slice(0, 4);
                } else if (input.value.length == 4) {
                    const nextInput = document.querySelector('.delivery-method__input--short[data-number="5"]');
                    nextInput.focus();
                }
            } else if (input.getAttribute('data-number') == 5) {
                if (input.value.length > 2) {
                    input.value = input.value.slice(0, 2);
                } else if (input.value.length == 2) {
                    const nextInput = document.querySelector('.delivery-method__input--short[data-number="6"]');
                    nextInput.focus();
                }
            } else if (input.getAttribute('data-number') == 6) {
                if (input.value.length > 2) {
                    input.value = input.value.slice(0, 2);
                } else if (input.value.length == 2) {
                    const nextInput = document.querySelector('.delivery-method__input--short[data-number="7"]');
                    nextInput.focus();
                }
            } else if (input.getAttribute('data-number') == 7) {
                if (input.value.length > 3) {
                    input.value = input.value.slice(0, 3);
                }
            }
        });
    });
})();

function putInformation() {
    const text = document.querySelectorAll('.delivery-delivery__text');
    text[0].innerHTML = `<strong>Pago: </strong>${information.pay.method}`;
    text[1].innerHTML = `<strong>Dirección: </strong>${information.receive.address}`;
    text[2].innerHTML = `<strong>Total a pagar: </strong>$${information.amount.total}`;
}
