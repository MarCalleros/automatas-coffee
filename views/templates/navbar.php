<nav class="navbar">
    <div class="navbar__header">
        <svg class="hamburguer-menu-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
            <g id="SVGRepo_iconCarrier"> 
                <path d="M4 18L20 18" stroke="#ffffff" stroke-width="2.4" stroke-linecap="round">
                </path> <path d="M4 12L20 12" stroke="#ffffff" stroke-width="2.4" stroke-linecap="round">
                </path> <path d="M4 6L20 6" stroke="#ffffff" stroke-width="2.4" stroke-linecap="round"></path> 
            </g>
        </svg>

        <a href="/">
            <img src="/assets/img/logo_white.png" alt="Automatas Coffee Logo" class="navbar__logo">
            <div class="navbar__brand">
            </div>
        </a>
    </div>
            
    <div class="navbar__links">
        <a class="navbar__link" href="/products">Productos</a>
        <a class="navbar__link" href="">Sobre Nosotros</a>
        <a class="navbar__link" href="">Contactanos</a>
        <a class="navbar__link navbar__link--disabled" href="">Mi Carrito</a>
        <button class="navbar__button">Iniciar Sesión</button>
        <a class="navbar__link" href="/sobre-nosotros">Sobre Nosotros</a>
        <a class="navbar__link" href="/encuentranos">Encuentranos</a>        
        <button id="login-button" class="navbar__button" style="display: none;">Iniciar Sesión</button>
        
        <div id="user-logged-icons" class="navbar__user-icons">
            <a href="/views/pages/carrito" class="navbar__icon-link">
                <svg width="30" height="30" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg" class="cart-icon">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4.16634 2.08331C3.01576 2.08331 2.08301 3.01606 2.08301 4.16665C2.08301 5.31723 3.01576 6.24998 4.16634 6.24998H6.70638L14.1319 35.9519C11.9429 36.9242 10.4163 39.1171 10.4163 41.6666C10.4163 45.1185 13.2146 47.9166 16.6663 47.9166C20.1181 47.9166 22.9163 45.1185 22.9163 41.6666C22.9163 40.9362 22.7909 40.235 22.5607 39.5833H31.6053C31.3751 40.235 31.2497 40.9362 31.2497 41.6666C31.2497 45.1185 34.0478 47.9166 37.4997 47.9166C40.9516 47.9166 43.7497 45.1185 43.7497 41.6666C43.7497 38.2148 40.9516 35.4166 37.4997 35.4166H18.293L17.2513 31.25H37.4997C41.8001 31.25 44.3786 28.5331 45.8095 25.5331C47.2078 22.6014 47.6945 19.0977 47.8643 16.5493C48.1005 13.0003 45.167 10.4166 41.9186 10.4166H12.043L10.7487 5.23942C10.2849 3.38454 8.61834 2.08331 6.70638 2.08331H4.16634ZM37.4997 27.0833H16.2096L13.0846 14.5833H41.9186C43.0709 14.5833 43.7628 15.4307 43.7068 16.2724C43.5484 18.6504 43.1051 21.5246 42.0488 23.7394C41.0251 25.8856 39.6249 27.0833 37.4997 27.0833ZM37.4997 43.7371C36.3561 43.7371 35.4293 42.8102 35.4293 41.6666C35.4293 40.5231 36.3561 39.5962 37.4997 39.5962C38.6432 39.5962 39.5701 40.5231 39.5701 41.6666C39.5701 42.8102 38.6432 43.7371 37.4997 43.7371ZM14.5959 41.6666C14.5959 42.8102 15.5228 43.7371 16.6663 43.7371C17.8098 43.7371 18.7368 42.8102 18.7368 41.6666C18.7368 40.5231 17.8098 39.5962 16.6663 39.5962C15.5228 39.5962 14.5959 40.5231 14.5959 41.6666Z" fill="white"/>
                </svg>
            </a>
            
            <a href="/perfil" class="navbar__icon-link profile-link">
                <svg width="24" height="26" viewBox="0 0 36 40" fill="none" xmlns="http://www.w3.org/2000/svg" class="profile-icon">
                    <path d="M34 38V34C34 31.8783 33.1571 29.8434 31.6569 28.3431C30.1566 26.8429 28.1217 26 26 26H10C7.87827 26 5.84344 26.8429 4.34315 28.3431C2.84285 29.8434 2 31.8783 2 34V38M26 10C26 14.4183 22.4183 18 18 18C13.5817 18 10 14.4183 10 10C10 5.58172 13.5817 2 18 2C22.4183 2 26 5.58172 26 10Z" stroke="#F3F3F3" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </div>
    </div>
</nav>

<?php include_once __DIR__ . "/login.php"; ?>
<?php include_once __DIR__ . "/register.php"; ?>
<script src="/assets/js/login-modal.js"></script>