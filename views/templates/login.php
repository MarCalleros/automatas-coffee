<div class="background__shadow background__blur" id="background-login"></div>
<div class="login-modal">
    <button class="modal__close" id="login-close">
        <svg class="close-icon" width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M29.5762 0.547733C28.9254 -0.103151 27.87 -0.103151 27.2192 0.547733L15.0619 12.705L2.90463 0.547733C2.25376 -0.103151 1.19848 -0.103151 0.547611 0.547733C-0.103273 1.1986 -0.103273 2.25388 0.547611 2.90475L12.7049 15.062L0.547644 27.2192C-0.103239 27.8702 -0.103239 28.9254 0.547644 29.5764C1.19851 30.2272 2.25379 30.2272 2.90466 29.5764L15.0619 17.419L27.2192 29.5764C27.87 30.2272 28.9254 30.2272 29.5762 29.5764C30.227 28.9254 30.227 27.8702 29.5762 27.2194L17.4189 15.062L29.5762 2.90475C30.227 2.25388 30.227 1.1986 29.5762 0.547733Z" fill="black"/>
        </svg>
    </button>

<script src="https://cdn.socket.io/4.7.2/socket.io.min.js"></script>
    <div class="login-modal__logo-container">
        <img src="/assets/img/logo_black.png" alt="Automatas Coffee Logo" class="login-modal__logo">
    </div>

    <h2 class="login-modal__title">Inicio de Sesion</h2>

    <form class="login-modal__form" id="login-form" method="POST" action="/api/user/login">
        <div class="login-modal__input-container">
            <label for="login-username" class="login-modal__label">Usuario</label>
            <input class="login-modal__input" id="login-username" name="login-username">
        </div>

        <div class="login-modal__input-container">
            <label for="login-password" class="login-modal__label">Contraseña</label>
            <div class="register-modal__password-container">
                <input type="password" class="login-modal__input" id="login-password" name="login-password">
                <div class="register-modal__eye-container" id="login-eye-container-password">
                    <svg class="eye-icon" id="login-eye-password" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path clip-rule="evenodd" d="M17.7469 15.4149C17.9855 14.8742 18.1188 14.2724 18.1188 14.0016C18.1188 11.6544 16.2952 9.7513 14.046 9.7513C11.7969 9.7513 9.97332 11.6544 9.97332 14.0016C9.97332 16.3487 12.0097 17.8886 14.046 17.8886C15.3486 17.8886 16.508 17.2515 17.2517 16.2595C17.4466 16.0001 17.6137 15.7168 17.7469 15.4149ZM14.046 15.7635C14.5551 15.7635 15.0205 15.5684 15.3784 15.2457C15.81 14.8566 16 14.2807 16 14.0016C16 12.828 15.1716 11.8764 14.046 11.8764C12.9205 11.8764 12 12.8264 12 14C12 14.8104 12.9205 15.7635 14.046 15.7635Z" fill="#333333" fill-rule="evenodd"></path>
                            <path clip-rule="evenodd" d="M1.09212 14.2724C1.07621 14.2527 1.10803 14.2931 1.09212 14.2724C0.96764 14.1021 0.970773 13.8996 1.09268 13.7273C1.10161 13.7147 1.11071 13.7016 1.11993 13.6882C4.781 8.34319 9.32105 5.5 14.0142 5.5C18.7025 5.5 23.2385 8.33554 26.8956 13.6698C26.965 13.771 27 13.875 27 13.9995C27 14.1301 26.9593 14.2399 26.8863 14.3461C23.2302 19.6702 18.6982 22.5 14.0142 22.5C9.30912 22.5 4.75717 19.6433 1.09212 14.2724ZM3.93909 13.3525C3.6381 13.7267 3.6381 14.2722 3.93908 14.6465C7.07417 18.5443 10.6042 20.3749 14.0142 20.3749C17.4243 20.3749 20.9543 18.5443 24.0894 14.6465C24.3904 14.2722 24.3904 13.7267 24.0894 13.3525C20.9543 9.45475 17.4243 7.62513 14.0142 7.62513C10.6042 7.62513 7.07417 9.45475 3.93909 13.3525Z" fill="#333333" fill-rule="evenodd"></path>
                        </g>
                    </svg>

                    <svg class="eye-icon-slash" id="login-slash-password" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path clip-rule="evenodd" d="M22.6928 1.55018C22.3102 1.32626 21.8209 1.45915 21.6 1.84698L19.1533 6.14375C17.4864 5.36351 15.7609 4.96457 14.0142 4.96457C9.32104 4.96457 4.781 7.84644 1.11993 13.2641L1.10541 13.2854L1.09271 13.3038C0.970762 13.4784 0.967649 13.6837 1.0921 13.8563C3.79364 17.8691 6.97705 20.4972 10.3484 21.6018L8.39935 25.0222C8.1784 25.4101 8.30951 25.906 8.69214 26.1299L9.03857 26.3326C9.4212 26.5565 9.91046 26.4237 10.1314 26.0358L23.332 2.86058C23.553 2.47275 23.4219 1.97684 23.0392 1.75291L22.6928 1.55018ZM18.092 8.00705C16.7353 7.40974 15.3654 7.1186 14.0142 7.1186C10.6042 7.1186 7.07416 8.97311 3.93908 12.9239C3.63812 13.3032 3.63812 13.8561 3.93908 14.2354C6.28912 17.197 8.86102 18.9811 11.438 19.689L12.7855 17.3232C11.2462 16.8322 9.97333 15.4627 9.97333 13.5818C9.97333 11.2026 11.7969 9.27368 14.046 9.27368C15.0842 9.27368 16.0317 9.68468 16.7511 10.3612L18.092 8.00705ZM15.639 12.3137C15.2926 11.7767 14.7231 11.4277 14.046 11.4277C12.9205 11.4277 12 12.3906 12 13.5802C12 14.3664 12.8432 15.2851 13.9024 15.3624L15.639 12.3137Z" fill="#333333" fill-rule="evenodd"></path>
                            <path d="M14.6873 22.1761C19.1311 21.9148 23.4056 19.0687 26.8864 13.931C26.9593 13.8234 27 13.7121 27 13.5797C27 13.4535 26.965 13.3481 26.8956 13.2455C25.5579 11.2677 24.1025 9.62885 22.5652 8.34557L21.506 10.2052C22.3887 10.9653 23.2531 11.87 24.0894 12.9239C24.3904 13.3032 24.3904 13.8561 24.0894 14.2354C21.5676 17.4135 18.7903 19.2357 16.0254 19.827L14.6873 22.1761Z" fill="#333333"></path>
                        </g>
                    </svg>
                </div>
            </div>
        </div>

        <div class="login-modal__button-container">
            <button type="submit" class="login-modal__button login-modal__button--login" id="modal-login-button">Iniciar Sesion</button>
            <button type="button" class="login-modal__button login-modal__button--reset" id="modal-login-reset">Resetear Campos</button>
            <button type="button" class="login-modal__button login-modal__button--NFC" id="modal-login-NFC" > NFC
                <img src="/assets/img/NFC.png" alt="NFC	">
            </button>
        </div>
    </form>

    <div class="login-modal__footer">
        <a class="login-modal__link" href="#">¿Olvidaste tu contraseña?</a>

        <div class="login-modal__register">
            <span class="login-modal__text">¿No estras registrado?</span>
            <p class="login-modal__link login-modal__link--italic" id="modal-login-register">Registrarse</p>
        </div>
    </div>
</div>
<script type="module" src="/assets/js/configuration.js"></script>

<div class="background__shadow background__blur" id="background-login"></div>

<div class="login-modal" id="login-modal-nfc" style="display: none;">
    <button class="modal__close" id="nfc-login-close">
        <svg class="close-icon" width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M29.5762 0.547733C28.9254 -0.103151 27.87 -0.103151 27.2192 0.547733L15.0619 12.705L2.90463 0.547733C2.25376 -0.103151 1.19848 -0.103151 0.547611 0.547733C-0.103273 1.1986 -0.103273 2.25388 0.547611 2.90475L12.7049 15.062L0.547644 27.2192C-0.103239 27.8702 -0.103239 28.9254 0.547644 29.5764C1.19851 30.2272 2.25379 30.2272 2.90466 29.5764L15.0619 17.419L27.2192 29.5764C27.87 30.2272 28.9254 30.2272 29.5762 29.5764C30.227 28.9254 30.227 27.8702 29.5762 27.2194L17.4189 15.062L29.5762 2.90475C30.227 2.25388 30.227 1.1986 29.5762 0.547733Z" fill="black"/>
        </svg>
    </button>
    <h2 class="login-modal__title">Bienvenido</h2>

    <form class="login-modal__form" id="nfc-login-form" method="POST" action="/api/user/login">
        <div class="login-modal__input-container">
            <label for="login-username" class="login-modal__label">Por favor, acerca tu tarjeta NFC al lector para registrar la tarjeta</label>
        </div>

        <img src="/assets/img/NFC.png" alt="NFC	">

    </form>

    <div class="login-modal__button-container">
            <button type="submit" class="login-modal__button login-modal__button--login" id="nfc-modal-login-button">Registrar Entrada</button>
    </div>
</div>
<script type="module" src="/assets/js/configuration.js"></script>