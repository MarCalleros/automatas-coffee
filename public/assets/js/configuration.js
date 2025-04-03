let username = getCookie('logged');

function setUserCookie(name, value, days) {
    let username = getCookie('logged') || "defaultUser";
    let cookieName = name + "_" + username;
    let date = new Date();
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
    let expires = "expires=" + date.toUTCString();
    document.cookie = cookieName + "=" + value + ";" + expires + ";path=/";
}

function getUserCookie(name) {
    let username = getCookie('logged') || "defaultUser";
    let cookieName = name + "_" + username;
    let cookies = document.cookie.split("; ");
    for (let i = 0; i < cookies.length; i++) {
        let cookie = cookies[i].split("=");
        if (cookie[0] === cookieName) {
            return decodeURIComponent(cookie[1]); 
        }
    }
    return "";
}

function setCookie(name, value, days) {
    let date = new Date();
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
    let expires = "expires=" + date.toUTCString();
    document.cookie = name + "=" + encodeURIComponent(value) + ";" + expires + ";path=/";
}

function getCookie(name) {
    let cookies = document.cookie.split("; ");
    for (let i = 0; i < cookies.length; i++) {
        let cookie = cookies[i].split("=");
        if (cookie[0] === name) {
            return decodeURIComponent(cookie[1]);
        }
    }
    return "";
}

function applyTheme(theme) {
    let styleTag = document.getElementById("dynamic-style");

    if (!styleTag) {
        styleTag = document.createElement("style");
        styleTag.id = "dynamic-style";
        document.head.appendChild(styleTag);
    }

    if (theme === "CLARO") {
        styleTag.innerHTML = `:root { 

        --white-background-color: #F4F3F2; 
        --color-conteiner: #FAFAFA;
        --color-navbar: #2C2C2C;
        --color-text: #333333;
        --color-text-black: #222222;

        
        }`;
    } else if (theme === "OSCURO") {
        styleTag.innerHTML = `:root { 

        --white-background-color: #1c1c1c;   
        --color-conteiner: #2c2c2c;
        --color-navbar: #2c2c2c;
        --color-text: #fafafa;
        --color-text-black: #fafafa;

        `;
    }else if (theme === "NOCTURNO") {
        styleTag.innerHTML = `:root { 

        --white-background-color: #15202b; 
        --color-conteiner: #1e2d3f;
        --color-navbar: #101820;
        --color-text: #fafafa;
        --color-text-black: #fafafa;
        }`;
    } 
}

document.addEventListener("DOMContentLoaded", function () {
    let temas = document.querySelectorAll(".temas");
    temas.forEach(tema => {
        tema.addEventListener("click", function () {
            let selectedTheme = this.querySelector("h3").textContent;
            setUserCookie("tema", selectedTheme, 30);
            applyTheme(selectedTheme);
            createNotification('success', 'Elegiste el tema :'+ selectedTheme);
            alert("Tema guardado para " + (getCookie('logged') || "Usuario desconocido") + ": " + selectedTheme);
        });
    });

    let savedTheme = getUserCookie("tema");
    if (savedTheme) {
        applyTheme(savedTheme);
    }
});
