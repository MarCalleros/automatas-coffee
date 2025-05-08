import { createNotification } from './notification.js';

(function() {
    const buttons = [
        { button: document.querySelector('#information-messages'), options: document.querySelector('#information-messages-options') },
        { button: document.querySelector('#information-purchases'), options: document.querySelector('#information-purchases-options') },
        { button: document.querySelector('#information-account'), options: document.querySelector('#information-account-options') }
    ];

    const messageButtons = [
        { button: document.querySelector('#information-messages-sent') },
        { button: document.querySelector('#information-messages-received') }
    ];

    const purchaseButtons = [
        { button: document.querySelector('#information-purchases-history') }
    ];

    const accountButtons = [
        { button: document.querySelector('#information-account-data') },
        { button: document.querySelector('#information-account-password') },
        { button: document.querySelector('#information-account-desactivate') }
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

    messageButtons.forEach(item => {
        item.button.addEventListener('click', function() {
            messageButtons.forEach(button => {
                button.button.classList.remove('information-menu__option--selected');
            });

            purchaseButtons.forEach(button => {
                button.button.classList.remove('information-menu__option--selected');
            });

            accountButtons.forEach(button => {
                button.button.classList.remove('information-menu__option--selected');
            });

            item.button.classList.add('information-menu__option--selected');

            const container = document.querySelector('.information-section--content');

            if (item.button == messageButtons[0].button) {
                window.history.pushState({}, '', '/informacion/mensajes');
                messageSent(container);
            }

            if (item.button == messageButtons[1].button) {
                // Call the function to show received messages
            }
        });
    });

    purchaseButtons.forEach(item => {
        item.button.addEventListener('click', function() {
            messageButtons.forEach(button => {
                button.button.classList.remove('information-menu__option--selected');
            });

            purchaseButtons.forEach(button => {
                button.button.classList.remove('information-menu__option--selected');
            });

            accountButtons.forEach(button => {
                button.button.classList.remove('information-menu__option--selected');
            });

            item.button.classList.add('information-menu__option--selected');

            const container = document.querySelector('.information-section--content');

            if (item.button == purchaseButtons[0].button) {
                window.history.pushState({}, '', '/informacion/pedidos');
                //funcion
            }
        });
    });

    accountButtons.forEach(item => {
        item.button.addEventListener('click', function() {
            messageButtons.forEach(button => {
                button.button.classList.remove('information-menu__option--selected');
            });

            purchaseButtons.forEach(button => {
                button.button.classList.remove('information-menu__option--selected');
            });

            accountButtons.forEach(button => {
                button.button.classList.remove('information-menu__option--selected');
            });

            item.button.classList.add('information-menu__option--selected');

            const container = document.querySelector('.information-section--content');

            if (item.button == accountButtons[0].button) {
                window.history.pushState({}, '', '/informacion/cuenta');
                accountConfirmPassword(container, accountData);
            }

            if (item.button == accountButtons[1].button) {
                window.history.pushState({}, '', '/informacion/contrasena');
                accountConfirmPassword(container, accountPassword);
            }

            if (item.button == accountButtons[2].button) {
                window.history.pushState({}, '', '/informacion/desactivar');
            }
        });
    });

    // Mirar si en el link hay otro enlace como /informacion/mensajes o /informacion/cuenta
    const path = window.location.pathname.split('/')[2];

    switch (path) {
        case 'mensajes':
            buttons[0].options.classList.add('information-menu__options--active');
            buttons[0].button.querySelector('.information-menu__arrow svg').style.transform = 'rotate(180deg)';
            buttons[0].options.querySelectorAll('.information-menu__option')[0].classList.add('information-menu__option--selected');

            // Si hay un tercer enlace como identificador, entonces mostrar el mensaje
            const identifier = window.location.pathname.split('/')[3];
            if (identifier) {
                messageDetails(document.querySelector('.information-section--content'), identifier);
            } else {
                messageSent(document.querySelector('.information-section--content'));
            }
            break;
        case 'pedidos':
            buttons[1].options.classList.add('information-menu__options--active');
            buttons[1].button.querySelector('.information-menu__arrow svg').style.transform = 'rotate(180deg)';
            buttons[1].options.querySelectorAll('.information-menu__option')[0].classList.add('information-menu__option--selected');
            //funcion
            break;
        case 'cuenta':
            buttons[2].options.classList.add('information-menu__options--active');
            buttons[2].button.querySelector('.information-menu__arrow svg').style.transform = 'rotate(180deg)';
            buttons[2].options.querySelectorAll('.information-menu__option')[0].classList.add('information-menu__option--selected');
            accountConfirmPassword(document.querySelector('.information-section--content'), accountData);
            break;
        case 'contrasena':
            buttons[2].options.classList.add('information-menu__options--active');
            buttons[2].button.querySelector('.information-menu__arrow svg').style.transform = 'rotate(180deg)';
            buttons[2].options.querySelectorAll('.information-menu__option')[1].classList.add('information-menu__option--selected');
            accountConfirmPassword(document.querySelector('.information-section--content'), accountPassword);
            break;
        case 'desactivar':
            buttons[2].options.classList.add('information-menu__options--active');
            buttons[2].button.querySelector('.information-menu__arrow svg').style.transform = 'rotate(180deg)';
            buttons[2].options.querySelectorAll('.information-menu__option')[2].classList.add('information-menu__option--selected');
            console.log('Desactivar cuenta');
            break;
        default:
            break;
    }
})();

function messageSent(container) {
    container.innerHTML = '';
    let html = `
        <div class="information-section__header">
            <h2 class="information-section__title information-section__title--no-margin">Mensajes Enviados</h2>
        </div>
    `;

    fetch('/api/message/sended', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.status == "success") {
            data.messages.forEach(message => {
                let answerDiv = '';

                if (message.respondido == 0) {
                    answerDiv = `<div class="information-message__status information-message__status--green">Enviado</div>`;
                } else {
                    answerDiv = `<div class="information-message__status information-message__status--orange">Respondido</div>`;
                }

                html += `
                    <div class="information-section__content information-section__content--hover">
                        <div class="information-message">
                            <p class="information-message__text"><strong>Nombre: </strong>${data.user.nombre}</p>
                            <p class="information-message__text"><strong>Correo: </strong>${data.user.correo}</p>
                            <p class="information-message__text"><strong>Numero de mensaje: </strong>${message.identificador}</p>
                            <p class="information-message__text"><strong>Mensaje enviado el: </strong>${message.fecha}</p>
                            <p class="information-message__text"><strong>Contenido: </strong>${message.contenido}</p>
                        </div>

                        ${answerDiv}
                    </div>
                `;
            });

            container.innerHTML = html;

            const messages = document.querySelectorAll('.information-section__content--hover');
            messages.forEach(message => {
                message.addEventListener('click', function() {
                    const identifier = this.querySelectorAll('.information-message__text')[2].innerText.split(': ')[1];
                    window.history.pushState({}, '', '/informacion/mensajes/' + identifier);
                    messageDetails(container, identifier);
                });
            });
        } else {
            html += `
                <div class="information-section__content">
                    <p class="information-message__title">No has enviado ningun mensaje aun</p>
                </div>
            `;

            container.innerHTML = html;
        }
    });
}

function messageDetails(container, identifier) {
    container.innerHTML = '';
    let html = `
        <div class="information-section__header">
            <h2 class="information-section__title information-section__title--no-margin">Mensajes Enviados</h2>
        </div>
    `;

    fetch(`/api/message/detail?identifier=${identifier}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.status == "success") {
            let answerDiv = '';

            if (data.messages[0].respondido == 0) {
                answerDiv = `<div class="information-message__status information-message__status--green">Enviado</div>`;
            } else {
                answerDiv = `<div class="information-message__status information-message__status--orange">Respondido</div>`;
            }

            html += `
                <div class="information-section__content">
                    <div class="information-message">
                        <p class="information-message__text"><strong>Nombre: </strong>${data.user.nombre}</p>
                        <p class="information-message__text"><strong>Correo: </strong>${data.user.correo}</p>
                        <p class="information-message__text"><strong>Numero de mensaje: </strong>${data.messages[0].identificador}</p>
                        <p class="information-message__text"><strong>Mensaje enviado el: </strong>${data.messages[0].fecha}</p>
                        <p class="information-message__text information-message__text--unlimited"><strong>Contenido: </strong>${data.messages[0].contenido}</p>
                    </div>

                    ${answerDiv}
                </div>
            `;
        } else {
            html += `
                <div class="information-section__content">
                    <p class="information-message__title">Este mensaje no existe</p>
                </div>
            `;
        }

        container.innerHTML = html;
    });
}

function accountConfirmPassword(container, functionName) {
    container.innerHTML = '';

    const html = `
        <div class="information-section__header">
            <h2 class="information-section__title information-section__title--no-margin">Ingrese su Contraseña</h2>
        </div>

        <div class="information-section__content">
            <form class="information-form">
                    <div class="information-form__input-container">
                    <label for="login-password" class="information-form__label">Ingrese su contraseña para acceder a sus datos personales</label>
                    <input type="password" class="information-form__input" name="login-password" id="information-password">
                </div>

                <div class="information-form__button-container" id="information-button-login">
                    <button type="button" class="information-form__button information-form__button--orange">Continuar</button>
                </div>
            </form>
        </div>
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
                        if (functionName) {
                            functionName(container);
                        }
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
                <div class="information-section__header">
                    <h2 class="information-section__title information-section__title--no-margin">Información de mi Cuenta</h2>
                </div>

                <div class="information-section__content">
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
                </div>
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

function accountPassword(container) {
    container.innerHTML = '';

    const html = `
        <div class="information-section__header">
            <h2 class="information-section__title">Cambiar mi Contraseña</h2>
        </div>
            
        <div class="information-section__content">
            <form class="information-form">
                <div class="information-form__input-container">
                    <label for="information-password" class="information-form__label">Nueva contraseña</label>
                    <div class="register-modal__password-container">
                        <input type="password" class="information-form__input" name="information-password" id="information-password">
                        <div class="register-modal__eye-container" id="information-eye-container-password">
                            <svg class="eye-icon" id="information-eye-password" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path class="information-fill-icon" clip-rule="evenodd" d="M17.7469 15.4149C17.9855 14.8742 18.1188 14.2724 18.1188 14.0016C18.1188 11.6544 16.2952 9.7513 14.046 9.7513C11.7969 9.7513 9.97332 11.6544 9.97332 14.0016C9.97332 16.3487 12.0097 17.8886 14.046 17.8886C15.3486 17.8886 16.508 17.2515 17.2517 16.2595C17.4466 16.0001 17.6137 15.7168 17.7469 15.4149ZM14.046 15.7635C14.5551 15.7635 15.0205 15.5684 15.3784 15.2457C15.81 14.8566 16 14.2807 16 14.0016C16 12.828 15.1716 11.8764 14.046 11.8764C12.9205 11.8764 12 12.8264 12 14C12 14.8104 12.9205 15.7635 14.046 15.7635Z" fill="#333333" fill-rule="evenodd"></path>
                                    <path class="information-fill-icon" clip-rule="evenodd" d="M1.09212 14.2724C1.07621 14.2527 1.10803 14.2931 1.09212 14.2724C0.96764 14.1021 0.970773 13.8996 1.09268 13.7273C1.10161 13.7147 1.11071 13.7016 1.11993 13.6882C4.781 8.34319 9.32105 5.5 14.0142 5.5C18.7025 5.5 23.2385 8.33554 26.8956 13.6698C26.965 13.771 27 13.875 27 13.9995C27 14.1301 26.9593 14.2399 26.8863 14.3461C23.2302 19.6702 18.6982 22.5 14.0142 22.5C9.30912 22.5 4.75717 19.6433 1.09212 14.2724ZM3.93909 13.3525C3.6381 13.7267 3.6381 14.2722 3.93908 14.6465C7.07417 18.5443 10.6042 20.3749 14.0142 20.3749C17.4243 20.3749 20.9543 18.5443 24.0894 14.6465C24.3904 14.2722 24.3904 13.7267 24.0894 13.3525C20.9543 9.45475 17.4243 7.62513 14.0142 7.62513C10.6042 7.62513 7.07417 9.45475 3.93909 13.3525Z" fill="#333333" fill-rule="evenodd"></path>
                                </g>
                            </svg>

                            <svg class="eye-icon-slash" id="information-slash-password" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path class="information-fill-icon" clip-rule="evenodd" d="M22.6928 1.55018C22.3102 1.32626 21.8209 1.45915 21.6 1.84698L19.1533 6.14375C17.4864 5.36351 15.7609 4.96457 14.0142 4.96457C9.32104 4.96457 4.781 7.84644 1.11993 13.2641L1.10541 13.2854L1.09271 13.3038C0.970762 13.4784 0.967649 13.6837 1.0921 13.8563C3.79364 17.8691 6.97705 20.4972 10.3484 21.6018L8.39935 25.0222C8.1784 25.4101 8.30951 25.906 8.69214 26.1299L9.03857 26.3326C9.4212 26.5565 9.91046 26.4237 10.1314 26.0358L23.332 2.86058C23.553 2.47275 23.4219 1.97684 23.0392 1.75291L22.6928 1.55018ZM18.092 8.00705C16.7353 7.40974 15.3654 7.1186 14.0142 7.1186C10.6042 7.1186 7.07416 8.97311 3.93908 12.9239C3.63812 13.3032 3.63812 13.8561 3.93908 14.2354C6.28912 17.197 8.86102 18.9811 11.438 19.689L12.7855 17.3232C11.2462 16.8322 9.97333 15.4627 9.97333 13.5818C9.97333 11.2026 11.7969 9.27368 14.046 9.27368C15.0842 9.27368 16.0317 9.68468 16.7511 10.3612L18.092 8.00705ZM15.639 12.3137C15.2926 11.7767 14.7231 11.4277 14.046 11.4277C12.9205 11.4277 12 12.3906 12 13.5802C12 14.3664 12.8432 15.2851 13.9024 15.3624L15.639 12.3137Z" fill="#333333" fill-rule="evenodd"></path>
                                    <path class="information-fill-icon" d="M14.6873 22.1761C19.1311 21.9148 23.4056 19.0687 26.8864 13.931C26.9593 13.8234 27 13.7121 27 13.5797C27 13.4535 26.965 13.3481 26.8956 13.2455C25.5579 11.2677 24.1025 9.62885 22.5652 8.34557L21.506 10.2052C22.3887 10.9653 23.2531 11.87 24.0894 12.9239C24.3904 13.3032 24.3904 13.8561 24.0894 14.2354C21.5676 17.4135 18.7903 19.2357 16.0254 19.827L14.6873 22.1761Z" fill="#333333"></path>
                                </g>
                            </svg>
                        </div>
                    </div>
                    <span class="information-form__error">Mínimo 8 caracteres, al menos una letra, un número y un símbolo especial</span>
                </div>

                <div class="information-form__input-container">
                    <label for="information-confirm" class="information-form__label">Confirmar nueva contraseña</label>
                    <div class="register-modal__password-container">
                        <input type="password" class="information-form__input" name="information-confirm" id="information-confirm">
                        <div class="register-modal__eye-container" id="information-eye-container-confirm">
                            <svg class="eye-icon" id="information-eye-confirm" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path class="information-fill-icon" clip-rule="evenodd" d="M17.7469 15.4149C17.9855 14.8742 18.1188 14.2724 18.1188 14.0016C18.1188 11.6544 16.2952 9.7513 14.046 9.7513C11.7969 9.7513 9.97332 11.6544 9.97332 14.0016C9.97332 16.3487 12.0097 17.8886 14.046 17.8886C15.3486 17.8886 16.508 17.2515 17.2517 16.2595C17.4466 16.0001 17.6137 15.7168 17.7469 15.4149ZM14.046 15.7635C14.5551 15.7635 15.0205 15.5684 15.3784 15.2457C15.81 14.8566 16 14.2807 16 14.0016C16 12.828 15.1716 11.8764 14.046 11.8764C12.9205 11.8764 12 12.8264 12 14C12 14.8104 12.9205 15.7635 14.046 15.7635Z" fill="#333333" fill-rule="evenodd"></path>
                                    <path class="information-fill-icon" clip-rule="evenodd" d="M1.09212 14.2724C1.07621 14.2527 1.10803 14.2931 1.09212 14.2724C0.96764 14.1021 0.970773 13.8996 1.09268 13.7273C1.10161 13.7147 1.11071 13.7016 1.11993 13.6882C4.781 8.34319 9.32105 5.5 14.0142 5.5C18.7025 5.5 23.2385 8.33554 26.8956 13.6698C26.965 13.771 27 13.875 27 13.9995C27 14.1301 26.9593 14.2399 26.8863 14.3461C23.2302 19.6702 18.6982 22.5 14.0142 22.5C9.30912 22.5 4.75717 19.6433 1.09212 14.2724ZM3.93909 13.3525C3.6381 13.7267 3.6381 14.2722 3.93908 14.6465C7.07417 18.5443 10.6042 20.3749 14.0142 20.3749C17.4243 20.3749 20.9543 18.5443 24.0894 14.6465C24.3904 14.2722 24.3904 13.7267 24.0894 13.3525C20.9543 9.45475 17.4243 7.62513 14.0142 7.62513C10.6042 7.62513 7.07417 9.45475 3.93909 13.3525Z" fill="#333333" fill-rule="evenodd"></path>
                                </g>
                            </svg>

                            <svg class="eye-icon-slash" id="information-slash-confirm" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path class="information-fill-icon" clip-rule="evenodd" d="M22.6928 1.55018C22.3102 1.32626 21.8209 1.45915 21.6 1.84698L19.1533 6.14375C17.4864 5.36351 15.7609 4.96457 14.0142 4.96457C9.32104 4.96457 4.781 7.84644 1.11993 13.2641L1.10541 13.2854L1.09271 13.3038C0.970762 13.4784 0.967649 13.6837 1.0921 13.8563C3.79364 17.8691 6.97705 20.4972 10.3484 21.6018L8.39935 25.0222C8.1784 25.4101 8.30951 25.906 8.69214 26.1299L9.03857 26.3326C9.4212 26.5565 9.91046 26.4237 10.1314 26.0358L23.332 2.86058C23.553 2.47275 23.4219 1.97684 23.0392 1.75291L22.6928 1.55018ZM18.092 8.00705C16.7353 7.40974 15.3654 7.1186 14.0142 7.1186C10.6042 7.1186 7.07416 8.97311 3.93908 12.9239C3.63812 13.3032 3.63812 13.8561 3.93908 14.2354C6.28912 17.197 8.86102 18.9811 11.438 19.689L12.7855 17.3232C11.2462 16.8322 9.97333 15.4627 9.97333 13.5818C9.97333 11.2026 11.7969 9.27368 14.046 9.27368C15.0842 9.27368 16.0317 9.68468 16.7511 10.3612L18.092 8.00705ZM15.639 12.3137C15.2926 11.7767 14.7231 11.4277 14.046 11.4277C12.9205 11.4277 12 12.3906 12 13.5802C12 14.3664 12.8432 15.2851 13.9024 15.3624L15.639 12.3137Z" fill="#333333" fill-rule="evenodd"></path>
                                    <path class="information-fill-icon" d="M14.6873 22.1761C19.1311 21.9148 23.4056 19.0687 26.8864 13.931C26.9593 13.8234 27 13.7121 27 13.5797C27 13.4535 26.965 13.3481 26.8956 13.2455C25.5579 11.2677 24.1025 9.62885 22.5652 8.34557L21.506 10.2052C22.3887 10.9653 23.2531 11.87 24.0894 12.9239C24.3904 13.3032 24.3904 13.8561 24.0894 14.2354C21.5676 17.4135 18.7903 19.2357 16.0254 19.827L14.6873 22.1761Z" fill="#333333"></path>
                                </g>
                            </svg>
                        </div>
                    </div>
                    <span class="information-form__error">Las contraseñas deben coincidir</span>
                </div>

                <div class="information-form__button-container" id="information-button-login">
                    <button type="button" class="information-form__button information-form__button--orange" id="information-edit">Confirmar</button>
                </div>
            </form>
        </div>
    `;
    container.innerHTML = html;

    const eyeContainerPassword = document.querySelector('#information-eye-container-password');
    const eyeIconPassword = document.querySelector('#information-eye-password');
    const slashIconPassword = document.querySelector('#information-slash-password');

    const eyeContainerConfirm = document.querySelector('#information-eye-container-confirm');
    const eyeIconConfirm = document.querySelector('#information-eye-confirm');
    const slashIconConfirm = document.querySelector('#information-slash-confirm');

    eyeContainerPassword.addEventListener('click', function() {
        const passwordInput = document.querySelector('#information-password');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIconPassword.style.display = 'none';
            slashIconPassword.style.display = 'block';
        } else {
            passwordInput.type = 'password';
            eyeIconPassword.style.display = 'block';
            slashIconPassword.style.display = 'none';
        }
    });

    eyeContainerConfirm.addEventListener('click', function() {
        const confirmInput = document.querySelector('#information-confirm');

        if (confirmInput.type === 'password') {
            confirmInput.type = 'text';
            eyeIconConfirm.style.display = 'none';
            slashIconConfirm.style.display = 'block';
        } else {
            confirmInput.type = 'password';
            eyeIconConfirm.style.display = 'block';
            slashIconConfirm.style.display = 'none';
        }
    });

    const passwordInput = document.querySelector('#information-password');
    const confirmInput = document.querySelector('#information-confirm');

    inputsErrorPassword([passwordInput, confirmInput]);

    const editButton = document.querySelector('#information-edit');
    editButton.addEventListener('click', function() {
        if (validateInputs()) {
            const passwordInput = document.querySelector('#information-password');

            fetch('/api/user/update-password', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    password: passwordInput.value,
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status == "success") {
                    createNotification("success", data.message);
                    passwordInput.value = '';
                    confirmInput.value = '';
                } else {
                    createNotification("error", data.message);
                }
            });
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
    const confirmInput = document.querySelector('#information-confirm');

    const regexName = /^[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+$/
    const regexAge = /^[1-9][0-9]?$/
    const regexEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/
    const regexUsername = /^[a-zA-Z0-9]{5,}$/
    const regexPassword = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&_\-#])[A-Za-z\d@$!%*?&_\-#]{8,}$/

    if (nameInput && ageInput && emailInput && usernameInput) {
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

function inputsErrorPassword(inputs) {
    const regexPassword = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&_\-#])[A-Za-z\d@$!%*?&_\-#]{8,}$/

    inputs.forEach((input, index) => {
        input.addEventListener("input", () => {
            //Solo quitaran los errores si el campo ahora es valido
            if (index === 0 && regexPassword.test(input.value)) {
                quitError(input)
            }

            if (index === 1 && input.value === document.querySelector('#information-password').value) {
                quitError(input)
            }
        })
    })
}