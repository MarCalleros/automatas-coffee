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

function checkCookie() {
    let username = getCookie("username");
    if (username != "") {
     alert("Welcome again " + username);
    } else {
      username = prompt("Please enter your name:", "");
      if (username != "" && username != null) {
        setCookie("username", username, 365);
      }
    }
}


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

const registerButton = document.querySelector('#register-button');

registerButton.addEventListener('click', async function(event) {
    event.preventDefault();

    let username = document.querySelector("#register-username").value;
    let password = document.querySelector("#register-password").value;

    if (validateInputs()) {
        const encrpytedPassword = await encryptPassword(password);
        
        getCookie(username) === null ? setCookie(username, password, 365) : alert('El usuario ya existe');
    }
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