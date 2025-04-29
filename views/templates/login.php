<div class="background__shadow background__blur" id="background-login"></div>

<div class="login-modal">
    <button class="modal__close" id="login-close">
        <svg class="close-icon" width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M29.5762 0.547733C28.9254 -0.103151 27.87 -0.103151 27.2192 0.547733L15.0619 12.705L2.90463 0.547733C2.25376 -0.103151 1.19848 -0.103151 0.547611 0.547733C-0.103273 1.1986 -0.103273 2.25388 0.547611 2.90475L12.7049 15.062L0.547644 27.2192C-0.103239 27.8702 -0.103239 28.9254 0.547644 29.5764C1.19851 30.2272 2.25379 30.2272 2.90466 29.5764L15.0619 17.419L27.2192 29.5764C27.87 30.2272 28.9254 30.2272 29.5762 29.5764C30.227 28.9254 30.227 27.8702 29.5762 27.2194L17.4189 15.062L29.5762 2.90475C30.227 2.25388 30.227 1.1986 29.5762 0.547733Z" fill="black"/>
        </svg>
    </button>

    <div class="login-modal__logo-container">
        <img src="/assets/img/logo_black.png" alt="Automatas Coffee Logo" class="login-modal__logo">
    </div>

    <h2 class="login-modal__title">Inicio de Sesion</h2>

    <form class="login-modal__form" id="login-form">
        <div class="login-modal__input-container">
            <label for="login-username" class="login-modal__label">Usuario</label>
            <input class="login-modal__input" id="login-username" name="login-username">
        </div>

        <div class="login-modal__input-container">
            <label for="login-password" class="login-modal__label">Contraseña</label>
            <input type="password" class="login-modal__input" id="login-password" name="login-password">
        </div>

        <div class="login-modal__button-container">
            <button type="button" class="login-modal__button login-modal__button--login" id="modal-login-button">Iniciar Sesion</button>
            <button type="button" class="login-modal__button login-modal__button--reset" id="modal-login-reset">Resetear Campos</button>
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