import { createNotification } from './notification.js';

(function() {
    const buttons = [
        { button: document.querySelector('#information-messages'), options: document.querySelector('#information-messages-options') },
        { button: document.querySelector('#information-purchases'), options: document.querySelector('#information-purchases-options') },
        { button: document.querySelector('#information-account'), options: document.querySelector('#information-account-options') }
    ];

    const accountButtons = [
        { button: document.querySelector('#information-account-data')},
        { button: document.querySelector('#information-account-password')},
        { button: document.querySelector('#information-account-desactivate')}
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

    accountButtons.forEach(item => {
        item.button.addEventListener('click', function() {
            item.button.classList.add('information-menu__option--selected');

            for (let i = 0; i < accountButtons.length; i++) {
                if (accountButtons[i].button !== item.button) {
                    accountButtons[i].button.classList.remove('information-menu__option--selected');
                }
            }

            const container = document.querySelector('.information-section--content');
            if (item.button == accountButtons[0].button) {
                accountConfirmPassword(container);
            }
        });
    });
})();

function accountConfirmPassword(container) {
    container.innerHTML = '';

    const html = `
        <h2 class="information-section__title">Información de mi Cuenta</h2>

        <form class="information-form">
                <div class="information-form__input-container">
                <label for="login-password" class="information-form__label">Ingrese su contraseña para acceder a sus datos personales</label>
                <input type="password" class="information-form__input" name="login-password" id="information-password">
            </div>

            <div class="information-form__button-container" id="information-button-login">
                <button type="button" class="information-form__button information-form__button--orange">Continuar</button>
            </div>
        </form>
    `;
    container.innerHTML = html;

    const button = document.querySelector('#information-button-login');
    button.addEventListener('click', function() {
        const password = document.querySelector('#information-password').value;
        if (password) {
            fetch('/api/user/check-password', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        password: password,
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status == "success") {
                        accountData(container);
                    } else {
                        createNotification("error", data.message);
                    }
                });
        } else {
            createNotification("error", "Por favor, ingrese su contraseña");
        }
    });
}

function accountData(container) {
    fetch('/api/user/get-logged-data', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.status == "success") {
            container.innerHTML = '';

            const html = `
                <h2 class="information-section__title">Información de mi Cuenta</h2>

                <form class="information-form">
                    <div class="information-form__input-container">
                        <label for="information-name" class="information-form__label">Nombre</label>
                        <input type="text" class="information-form__input" name="information-name" id="information-name" value="${data.data.nombre}">
                        <span class="information-form__error">Solo letras y espacios</span>
                    </div>

                    <div class="information-form__input-container">
                        <label for="information-age" class="information-form__label">Edad</label>
                        <input type="text" class="information-form__input" name="information-age" id="information-age" value="${data.data.edad}">
                        <span class="information-form__error">Solo números entre 1 y 99</span>
                    </div>

                    <div class="information-form__input-container">
                        <label for="information-email" class="information-form__label">Correo</label>
                        <input type="email" class="information-form__input" name="information-email" id="information-email" value="${data.data.correo}">
                        <span class="information-form__error">Formato inválido (ejemplo@dominio.com)</span>
                    </div>

                    <div class="information-form__input-container">
                        <label for="information-username" class="information-form__label">Usuario</label>
                        <input type="text" class="information-form__input" name="information-username" id="information-username" value="${data.data.usuario}">
                        <span class="information-form__error">Solo letras y números, mínimo 5 caracteres, sin espacios</span>
                    </div>

                    <div class="information-form__button-container" id="information-button-edit">
                        <button type="button" class="information-form__button information-form__button--orange" id="information-edit">Editar mi Información</button>
                        <button type="button" class="information-form__button information-form__button--white" id="information-reset">Restaurar mi Información</button>
                    </div>    
                </form>
            `;
            container.innerHTML = html;

            const editButton = document.querySelector('#information-edit');
            const resetButton = document.querySelector('#information-reset');

            const nameInput = document.querySelector('#information-name');
            const ageInput = document.querySelector('#information-age');
            const emailInput = document.querySelector('#information-email');
            const usernameInput = document.querySelector('#information-username');

            inputsError([nameInput, ageInput, emailInput, usernameInput]);

            editButton.addEventListener('click', function() {
                if (validateInputs()) {
                    fetch('/api/user/update', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            name: nameInput.value,
                            age: ageInput.value,
                            email: emailInput.value,
                            username: usernameInput.value,
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status == "success") {
                            createNotification("success", data.message);
                        } else {
                            createNotification("error", data.message);
                        }
                    });
                }
            });

            resetButton.addEventListener('click', function() {
                nameInput.value = data.data.nombre;
                ageInput.value = data.data.edad;
                emailInput.value = data.data.correo;
                usernameInput.value = data.data.usuario;
            });
        } else {
            createNotification("error", data.message);
        }
    });    
}

function validateInputs() {
    let errors = false

    const nameInput = document.querySelector('#information-name');
    const ageInput = document.querySelector('#information-age');
    const emailInput = document.querySelector('#information-email');
    const usernameInput = document.querySelector('#information-username');
    const passwordInput = document.querySelector('#information-password');
    const confirmInput = document.querySelector('#information-confirm-password');

    const regexName = /^[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+$/
    const regexAge = /^[1-9][0-9]?$/
    const regexEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/
    const regexUsername = /^[a-zA-Z0-9]{5,}$/
    const regexPassword = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&_\-#])[A-Za-z\d@$!%*?&_\-#]{8,}$/

    //Validar el nombre
    if (!regexName.test(nameInput.value)) {
      showError(nameInput);
      errors = true;
    } else {
      quitError(nameInput);
    }

    //Validar la edad
    if (!regexAge.test(ageInput.value)) {
      showError(ageInput);
      errors = true;
    } else {
      quitError(ageInput);
    }

    //Validar correo
    if (!regexEmail.test(emailInput.value)) {
      showError(emailInput);
      errors = true;
    } else {
      quitError(emailInput);
    }

    //Validar usuario
    if (!regexUsername.test(usernameInput.value)) {
      showError(usernameInput);
      errors = true;
    } else {
      quitError(usernameInput);
    }

    //Validar contraseña
    if (passwordInput && confirmInput) {
        if (!regexPassword.test(passwordInput.value)) {
            showError(passwordInput);
            errors = true;
        } else {
            quitError(passwordInput);
        }
      
        //Validar la confirmacion de contraseña
        if (passwordInput.value !== confirmInput.value) {
            showError(confirmInput);
            errors = true;
        } else {
            quitError(confirmInput);
        }
    }

    return !errors;
}

function showError(input) {
    const formGroup = input.closest(".information-form__input-container");
    const errorMessage = formGroup.querySelector(".information-form__error");
    errorMessage.classList.add("information-form__error--active");
}

function quitError(input) {
    const formGroup = input.closest(".information-form__input-container");
    const errorMessage = formGroup.querySelector(".information-form__error");
    errorMessage.classList.remove("information-form__error--active");
}

function inputsError(inputs) {
    const regexName = /^[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+$/
    const regexAge = /^[1-9][0-9]?$/
    const regexEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/
    const regexUsername = /^[a-zA-Z0-9]{5,}$/
    const regexPassword = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&_\-#])[A-Za-z\d@$!%*?&_\-#]{8,}$/

    inputs.forEach((input, index) => {
        input.addEventListener("input", () => {
            //Solo quitaran los errores si el campo ahora es valido
            if (index === 0 && regexName.test(input.value)) {
                quitError(input)
            } else if (index === 1 && regexAge.test(input.value)) {
                quitError(input)
            } else if (index === 2 && regexEmail.test(input.value)) {
                quitError(input)
            } else if (index === 3 && regexUsername.test(input.value)) {
                quitError(input)
            }
        })
    })
}