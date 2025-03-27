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
    let cookies = document.cookie.split("; ");
    for (let cookie of cookies) {
        let [key, value] = cookie.split("=");
        if (key === name) {
            return decodeURIComponent(value);
        }
    }
    return null;
}

function deleteCookie(name) {
    document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
}

function deleteAllCookies() {
    // Eliminar todas las cookies excepto la de login (logged)
    document.cookie.split(';').forEach(cookie => {
        if (!(cookie.trim().startsWith('logged'))) {
            const eqPos = cookie.indexOf('=');
            const name = eqPos > -1 ? cookie.substring(0, eqPos) : cookie;
            document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
        }
    });
}

/* COOKIE DE LOGIN */
setCookie('logged', 'false', 365); // Se crea una cookie para saber si el usuario esta loggeado o no

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

const loginButton = document.querySelector('#login-button');
const loginResetButton = document.querySelector('#login-reset');

const registerButton = document.querySelector('#register-button');
const registerResetButton = document.querySelector('#register-reset');

loginButton.addEventListener('click', function(event) {
    event.preventDefault();

    if (getCookie('logged') !== 'false') {
        alert('Ya has iniciado sesión anteriormente con el usuario de ' + getCookie('logged'));
        return
    }

    let username = document.querySelector("#login-username").value;
    let password = document.querySelector("#login-password").value;

    if (getCookie(username) === password) {
        alert('Login exitoso');
        setCookie('logged', username, 365);
    } else {
        alert('Usuario o contraseña incorrectos');
    }
});

loginResetButton.addEventListener('click', function(event) {
    event.preventDefault();
    loginForm.reset();
});

registerButton.addEventListener('click', async function(event) {
    event.preventDefault();

    let username = document.querySelector("#register-username").value;
    let password = document.querySelector("#register-password").value;

    if (validateInputs()) {
        const encrpytedPassword = await encryptPassword(password);
        
        getCookie(username) === null ? setCookie(username, password, 365) : alert('El usuario ya existe');
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

async function encryptPassword(password) {
    const encoder = new TextEncoder();
    const data = encoder.encode(password);
    const hashBuffer = await crypto.subtle.digest("SHA-256", data);
    const hashArray = Array.from(new Uint8Array(hashBuffer));
    const hashHex = hashArray.map(byte => byte.toString(16).padStart(2, '0')).join('');
    return hashHex;
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

/* Eliminar posteriormente */
const deleteButton = document.querySelector('#register-delete');
const showButton = document.querySelector('#register-show');

deleteButton.addEventListener('click', function(event) {
    event.preventDefault();
    deleteAllCookies();
});

showButton.addEventListener('click', function(event) {
    event.preventDefault();
    alert(document.cookie);
});
/* Eliminar posteriormente */