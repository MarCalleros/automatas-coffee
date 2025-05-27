import { createNotification } from './notification.js';

let information = {
    receive: {
        id: '',
        lat: '',
        lng: '',
        address: '',
        text: '',
        },
    pay: {
        id: '',
        method: '',
        text: '',
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

    const buyBtn = document.querySelector("#buy-btn")

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
            if (card.getAttribute('data-address') == 'gps') {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        function(position) {
                            information.receive.lat = position.coords.latitude;
                            information.receive.lng = position.coords.longitude;
                            console.log("Latitud:", information.receive.lat, "Longitud:", information.receive.lng);
                            createNotification("success", "Ubicación obtenida correctamente");
                        },
                        function(error) {
                            console.error("Error al obtener ubicación:", error);
                            createNotification("error", "No se pudo obtener la ubicación actual");
                            return;
                        }
                    );
                } else {
                    createNotification("error", "La geolocalización no es compatible con este navegador");
                    return;
                }
            }

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

            information.receive.address = card.getAttribute('data-address');
            if (information.receive.address == 'gps') {
                information.receive.id = '';
                information.receive.text = "Entregar a mi ubicación actual";
            } else if (information.receive.address == 'home') {
                information.receive.id = card.getAttribute('data-id');
                information.receive.text = "Entregar al domicilio " + card.querySelectorAll('.delivery-receive__text')[1].textContent;
            } else if (information.receive.address == 'subsidiary') {
                information.receive.id = card.getAttribute('data-id');
                information.receive.text = "Recibir en la sucursal " + card.querySelectorAll('.delivery-receive__text')[1].textContent;
            }
            putInformation();
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
                information.pay.id = '';
                information.pay.text = "Pago con efectivo";
                putInformation();
                buyBtn.classList.remove("delivery__button--return")
                buyBtn.classList.add("delivery__button--confirm")
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

            information.pay.method = card.getAttribute('data-card');
            information.pay.id = card.getAttribute('data-id');
            information.pay.text = "Pago con tarjeta con terminación " + card.getAttribute('data-number');
            putInformation();
            buyBtn.classList.remove("delivery__button--return")
            buyBtn.classList.add("delivery__button--confirm")
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

    //Botón de comprar
    buyBtn.addEventListener("click", function () {
        if (buyBtn.classList.contains("delivery__button--confirm")) {
            realizarCompra((response) => {
            if (response.status === "success") {
                //Actualizar el contador del carrito
                actualizarContadorCarrito(0)
                buyBtn.classList.remove("delivery__button--confirm")
                buyBtn.classList.add("delivery__button--return")
                createNotification("success", "Compra realizada con éxito, puedes ver tu pedido en tu historial de pedidos")

                // Eliminar todos los eventos de click
            } else {
                createNotification("error", response.message)
            }
            })
        }
    })
})();

function putInformation() {
    const text = document.querySelectorAll('.delivery-delivery__text');
    text[0].innerHTML = `${information.pay.text}`;
    text[1].innerHTML = `${information.receive.text}`;
}

function realizarCompra(callback) {
    fetch("/api/carrito/comprar", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            addressId: information.receive.id,
            lat: information.receive.lat,
            lng: information.receive.lng,
            address: information.receive.address,
            cardId: information.pay.id,
            method: information.pay.method
        })
    })
        .then((response) => response.json())
        .then((data) => {
            console.log("respuesta de compra", data)
            callback(data)
    })
        .catch((error) => {
            console.error("Error:", error)
            callback({ status: "error", message: "Error de conexión" })
    })
}

function actualizarContadorCarrito(count) {
      const contadorElements = document.querySelectorAll(".cart-indicator, .cart-count")
      if (contadorElements.length === 0) return

      if (count !== undefined) {
        contadorElements.forEach((element) => {
          element.textContent = count
          element.style.display = count > 0 ? "flex" : "none"
        })
        return
      }

      fetch("/api/carrito/obtener")
        .then((response) => response.json())
        .then((data) => {
          if (data.status === "success") {
            const totalItems = data.items.reduce((total, item) => total + Number.parseInt(item.cantidad), 0)
            contadorElements.forEach((element) => {
              element.textContent = totalItems
              element.style.display = totalItems > 0 ? "flex" : "none"
            })
          }
        })
        .catch((error) => {
          console.error("Error:", error)
        })
}