<div class="register-modal">
    <button class="modal__close" id="register-close">
        <svg class="close-icon" width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M29.5762 0.547733C28.9254 -0.103151 27.87 -0.103151 27.2192 0.547733L15.0619 12.705L2.90463 0.547733C2.25376 -0.103151 1.19848 -0.103151 0.547611 0.547733C-0.103273 1.1986 -0.103273 2.25388 0.547611 2.90475L12.7049 15.062L0.547644 27.2192C-0.103239 27.8702 -0.103239 28.9254 0.547644 29.5764C1.19851 30.2272 2.25379 30.2272 2.90466 29.5764L15.0619 17.419L27.2192 29.5764C27.87 30.2272 28.9254 30.2272 29.5762 29.5764C30.227 28.9254 30.227 27.8702 29.5762 27.2194L17.4189 15.062L29.5762 2.90475C30.227 2.25388 30.227 1.1986 29.5762 0.547733Z" fill="black"/>
        </svg>
    </button>

    <div class="register-modal__logo-container">
        <img src="assets/img/logo_black.png" alt="Automatas Coffee Logo" class="register-modal__logo">
    </div>

    <h2 class="register-modal__title">Registro de Usuarios</h2>

    <form class="register-modal__form" action="">
        <div class="register-modal__input-container">
            <label for="name" class="register-modal__label">Nombre</label>
            <input type="text" name="name" class="register-modal__input">
            <div class="underline"></div>
            <span class="error-message"></span>
        </div>

        <div class="register-modal__input-container">
            <label for="age" class="register-modal__label">Edad</label>
            <input type="text" name="age" class="register-modal__input">
            <div class="underline"></div>
            <span class="error-message"></span>
        </div>
        
        <div class="register-modal__input-container">
            <label for="email" class="register-modal__label">Correo</label>
            <input type="text" name="email" class="register-modal__input">
            <div class="underline"></div>
            <span class="error-message"></span>
        </div>

        <div class="register-modal__input-container">
            <label for="user" class="register-modal__label">Usuario</label>
            <input type="text" name="user" class="register-modal__input">
            <div class="underline"></div>
            <span class="error-message"></span>
        </div>

        <div class="register-modal__input-container">
            <label for="password" class="register-modal__label">Contraseña</label>
            <input type="password" name="password" class="register-modal__input">
            <div class="underline"></div>
            <span class="error-message"></span>
        </div>

        <div class="register-modal__input-container">
            <label for="confirm" class="register-modal__label">Confirmar Contraseña</label>
            <input type="password" name="confirm" class="register-modal__input">
            <div class="underline"></div>
            <span class="error-message"></span>
        </div>

        <div class="register-modal__button-container">
            <button class="register-modal__button register-modal__button--register">Registrarse</button>
            <button class="register-modal__button register-modal__button--reset">Resetear Campos</button>
        </div>
    </form>

    <div class="register-modal__footer">
        <div class="register-modal__register">
            <span class="register-modal__text">¿Ya tienes una cuenta?</span>
            <p class="register-modal__link register-modal__link--italic" id="register-login">Iniciar Sesion</p>
        </div>
    </div>
</div>