import { createNotification } from './notification.js';

function setCookie(name, value, days) {
    let expires = "";
    if (days) {
        let date = new Date();
        date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + encodeURIComponent(value) + expires + "; path=/";
}

function getCookie(name) {
    const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
    return match ? decodeURIComponent(match[2]) : null;
}

function deleteAllCookies() {
    // Eliminar todas las cookies excepto la de login (logged)
    document.cookie.split(';').forEach(cookie => {
        if ((!(cookie.trim().startsWith('logged')))) {
            const eqPos = cookie.indexOf('=');
            const name = eqPos > -1 ? cookie.substring(0, eqPos) : cookie;
            document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
        }
    });
}

function addUserToUserCookie(username, password, encrpytedPassword) {
    const users = JSON.parse(getCookie('users')) || [];
    const user = { username, password, encrpytedPassword };
    users.push(user);
    setCookie('users', JSON.stringify(users), 365);
}

const userIcons = document.querySelector('.navbar__user-icons');
const navbarLoginButtin = document.querySelector('.navbar__button');

if (getCookie('users') === null) {
    setCookie('users', JSON.stringify([]), 365);
}

const loginForm = document.querySelector("#login-form");
const registerForm = document.querySelector("#register-form");

let nameInput = document.querySelector("#register-name");
let ageInput = document.querySelector("#register-age");
let emailInput = document.querySelector("#register-email");
let usernameInput = document.querySelector("#register-username");
let passwordInput = document.querySelector("#register-password");
let confirmInput = document.querySelector("#register-confirm");

const regexName = /^[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+$/
const regexAge = /^[1-9][0-9]?$/
const regexEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/
const regexUsername = /^[a-zA-Z0-9]{5,}$/
const regexPassword = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&_\-#])[A-Za-z\d@$!%*?&_\-#]{8,}$/

const loginButton = document.querySelector('#modal-login-button');
const loginResetButton = document.querySelector('#modal-login-reset');

const registerButton = document.querySelector('#register-button');
const registerResetButton = document.querySelector('#register-reset');

const logoutButton = document.querySelector('#logout-profile');
const ConfigurationButton = document.querySelector('#configuration-profile');
const profileButton = document.querySelector('#profile-button');
const profileUsername = document.querySelector('.profile-modal__user');

loginButton.addEventListener('click', function(event) {
    event.preventDefault();

    let username = document.querySelector("#login-username").value;
    let password = document.querySelector("#login-password").value;

    fetch('/api/user/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            username: username,
            password: password,
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status == "success") {
            createNotification("success", data.message);

            // Cookies (Eliminar despues)
            //setCookie('logged', username, 365);

            setTimeout(() => {
                const loginModal = document.querySelector('.login-modal');
                const backgroundShadow = document.querySelector('#background-login');
                
                if (loginModal) loginModal.classList.remove('login-modal--active');
                if (backgroundShadow) {
                    backgroundShadow.classList.remove('background__shadow--active');
                    backgroundShadow.classList.remove('background__blur--active');
                }
                
                document.body.style.position = '';
                document.body.style.top = '';
                window.location.reload(); // Recargar la página para reflejar el cambio de estado de inicio de sesión
            }, 1000);
        } else {
            createNotification("error", data.message);
        }
    });
});

loginResetButton.addEventListener('click', function(event) {
    event.preventDefault();
    loginForm.reset();
});

logoutButton.addEventListener('click', function(event) {
    event.preventDefault();

    fetch('/api/user/logout', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status == "success") {
            createNotification("success", data.message);

            setTimeout(() => {
                const profileModal = document.querySelector('.profile-modal');
                const backgroundShadow = document.querySelector('#background-login');
        
                if (profileModal) profileModal.classList.remove('profile-modal--active');
                if (backgroundShadow) {
                    backgroundShadow.classList.remove('background__shadow--active');
                    backgroundShadow.classList.remove('background__blur--active');
                }
        
                document.body.style.position = '';
                document.body.style.top = '';
                window.location.href = '/'; // Redirigir a la página de inicio
            }, 1000);
        } else {
            createNotification("error", data.message);
        }
    });
});

registerButton.addEventListener('click', async function(event) {
    event.preventDefault();

    let name = document.querySelector("#register-name").value;
    let age = document.querySelector("#register-age").value;
    let email = document.querySelector("#register-email").value;
    let username = document.querySelector("#register-username").value;
    let password = document.querySelector("#register-password").value;

    if (validateInputs()) {
        fetch('/api/user/create', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                name: name,
                age: age,
                email: email,
                username: username,
                password: password,
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status == "success") {
                createNotification("success", data.message);

                // Cookies (Eliminar despues)
                setCookie(username, password, 365);
                addUserToUserCookie(username, password, password);
            } else {
                createNotification("error", data.message);
            }
        });
    }
});

registerResetButton.addEventListener('click', function(event) {
    event.preventDefault();
    registerForm.reset();

    const errorMessages = document.querySelectorAll(".register-modal__error");
    errorMessages.forEach((errorMessage) => {
        errorMessage.classList.remove("register-modal__error--active");
    });
});

function validateInputs() {
    let errors = false

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

    return !errors;
}

function showError(input) {
    const formGroup = input.closest(".register-modal__input-container");
    const errorMessage = formGroup.querySelector(".register-modal__error");
    errorMessage.classList.add("register-modal__error--active");
}

function quitError(input) {
    const formGroup = input.closest(".register-modal__input-container");
    const errorMessage = formGroup.querySelector(".register-modal__error");
    errorMessage.classList.remove("register-modal__error--active");
}

const inputs = [nameInput, ageInput, emailInput, usernameInput, passwordInput, confirmInput]
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
        } else if (index === 4 && regexPassword.test(input.value)) {
            quitError(input)

            //Si la contraseña es valida despues se verifica tambien la confirmación
            if (input.value === confirmInput.value) {
                quitError(confirmInput)
            }

        } else if (index === 5 && input.value === passwordInput.value) {
            quitError(input)
        }
    })
})