let username = getCookie('logged') || "defaultUser";

function setUserCookie(name, value, days) {
    let cookieName = name + "_" + username;
    let date = new Date();
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
    document.cookie = cookieName + "=" + encodeURIComponent(value) + ";expires=" + date.toUTCString() + ";path=/";
}

function getUserCookie(name) {
    let cookieName = name + "_" + username;
    let cookies = document.cookie.split("; ");
    for (let cookie of cookies) {
        let [key, value] = cookie.split("=");
        if (key === cookieName) return decodeURIComponent(value);
    }
    return "";
}

function getCookie(name) {
    let cookies = document.cookie.split("; ");
    for (let cookie of cookies) {
        let [key, value] = cookie.split("=");
        if (key === name) return decodeURIComponent(value);
    }
    return "";
}

function applyTheme(theme) {
    let styleTag = document.getElementById("dynamic-style") || document.createElement("style");
    styleTag.id = "dynamic-style";
    document.head.appendChild(styleTag);

    const themes = {
        "CLARO": `:root { --white-background-color: #F4F3F2; --color-conteiner: #FAFAFA; --color-navbar: #2C2C2C; --color-text: #333; --color-text-black: #222; }`,
        "OSCURO": `:root { --white-background-color: #1c1c1c; --color-conteiner: #2c2c2c; --color-navbar: #2c2c2c; --color-text: #fafafa; --color-text-black: #fafafa; }`,
        "NOCTURNO": `:root { --white-background-color: #15202b; --color-conteiner: #1e2d3f; --color-navbar: #101820; --color-text: #fafafa; --color-text-black: #fafafa; }`
    };

    styleTag.innerHTML = themes[theme] || "";
}

function applyImage(image) {
    let styleTag = document.getElementById("dynamic-image-style") || document.createElement("style");
    styleTag.id = "dynamic-image-style";
    document.head.appendChild(styleTag);

    const images = {
        "CHICO": `:root { .product__image,.card__image{ transform: scale(0.8); } }`,
        "MEDIANO": `:root { .product__image,.card__image{ transform: scale(1.0); } }`,
        "GRANDE": `:root { .product__image,.card__image{ transform: scale(1.05); } }`
    };

    styleTag.innerHTML = images[image] || "";
}

function applyTextStyle(option) {
    let styleTag = document.getElementById("text-style") || document.createElement("style");
    styleTag.id = "text-style";
    document.head.appendChild(styleTag);

    const textStyles = {
        "GRANDE": `:root { --title: 4rem; --subtitle: 3.2rem; --text: 3.5rem; --text-small: 3.1rem; }`,
        "MEDIANO": `:root { --title: 3.2rem; --subtitle: 2.4rem; --text: 2rem; --text-small: 1.6rem; }`,
        "CHICO": `:root { --title: 1.5rem; --subtitle: 1.2rem; --text: 1rem; --text-small: 0.8rem; }`
    };

    styleTag.innerHTML = textStyles[option] || "";
}

function resetConfig() {
    document.cookie = "tema_" + username + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    document.cookie = "texto_" + username + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    document.cookie = "imagen_" + username + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";

    applyTheme("CLARO");
    applyTextStyle("MEDIANO");
    applyImage("MEDIANO");

    alert("La configuración ha sido restablecida a los valores predeterminados.");
}

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".temas").forEach(tema => {
        tema.addEventListener("click", function () {
            let selectedTheme = this.querySelector("h3").textContent.trim().toUpperCase();
            setUserCookie("tema", selectedTheme, 30);
            applyTheme(selectedTheme);
        });
    });

    document.querySelectorAll(".texto").forEach(opcion => {
        opcion.addEventListener("click", function () {
            let selectedTextStyle = this.querySelector("h3").textContent.trim().toUpperCase();
            setUserCookie("texto", selectedTextStyle, 30);
            applyTextStyle(selectedTextStyle);
        });
    });

    document.querySelectorAll(".imagen").forEach(imgOption => {
        imgOption.addEventListener("click", function () {
            let selectedImage = this.querySelector("h3").textContent.trim().toUpperCase();
            setUserCookie("imagen", selectedImage, 30);
            applyImage(selectedImage);
            alert("Imagen de fondo seleccionada: " + selectedImage);
        });
    });

    let resetButton = document.querySelector(".botonreseteo");
    if (resetButton) {
        resetButton.addEventListener("click", resetConfig);
    }

    applyImage(getUserCookie("imagen"));
    applyTheme(getUserCookie("tema"));
    applyTextStyle(getUserCookie("texto"));
});
