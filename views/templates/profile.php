<div class="background__shadow background__blur" id="background-login"></div>

<div class="profile-modal">
    <button class="modal__close" id="profile-close">
        <svg class="close-icon" width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M29.5762 0.547733C28.9254 -0.103151 27.87 -0.103151 27.2192 0.547733L15.0619 12.705L2.90463 0.547733C2.25376 -0.103151 1.19848 -0.103151 0.547611 0.547733C-0.103273 1.1986 -0.103273 2.25388 0.547611 2.90475L12.7049 15.062L0.547644 27.2192C-0.103239 27.8702 -0.103239 28.9254 0.547644 29.5764C1.19851 30.2272 2.25379 30.2272 2.90466 29.5764L15.0619 17.419L27.2192 29.5764C27.87 30.2272 28.9254 30.2272 29.5762 29.5764C30.227 28.9254 30.227 27.8702 29.5762 27.2194L17.4189 15.062L29.5762 2.90475C30.227 2.25388 30.227 1.1986 29.5762 0.547733Z" fill="black"/>
        </svg>
    </button>

    <h2 class="profile-modal__title">Opciones de Perfil</h2>

    <div class="profile-modal__pfp-container">
        <img src="/assets/img/pfpcoffee.png" alt="Profile" class="profile-modal__pfp">
    </div>

    <strong class="profile-modal__user"><?php echo $_SESSION['usuario']?></strong>

    <div class="profile-modal__buttons-container">
        <div class="profile-modal__button-container">
            <svg class="info-icon" width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M21.3442 3.66659C16.4657 -1.21795 8.55121 -1.2228 3.66661 3.65568C-1.21793 8.53428 -1.22285 16.4488 3.65575 21.3334C8.53424 26.218 16.4488 26.2228 21.3334 21.3443C26.2179 16.4658 26.2228 8.55113 21.3442 3.66659ZM14.2453 20.4318C14.2453 20.6247 14.089 20.7809 13.8963 20.7809H11.1038C10.911 20.7809 10.7547 20.6247 10.7547 20.4318V10.0655C10.7547 9.87266 10.911 9.71648 11.1038 9.71648H13.8963C14.089 9.71648 14.2453 9.8726 14.2453 10.0655V20.4318ZM12.5 8.26784C11.3838 8.26784 10.4756 7.35976 10.4756 6.24346C10.4756 5.12728 11.3837 4.21902 12.5 4.21902C13.6163 4.21902 14.5245 5.12722 14.5245 6.24346C14.5245 7.35976 13.6162 8.26784 12.5 8.26784Z" fill="#333333"/>
            </svg>
            <a style="width: 100%;" href="/informacion"><button type="button" class="profile-modal__button profile-modal__button--extra">Información</button></a>
        </div>
        <div class="profile-modal__button-container">
            <svg class="config-icon" width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_80_7938)">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12.5002 17.8569C15.4589 17.8569 17.8574 15.4584 17.8574 12.4997C17.8574 9.54106 15.4589 7.14258 12.5002 7.14258C9.54155 7.14258 7.14307 9.54106 7.14307 12.4997C7.14307 15.4584 9.54155 17.8569 12.5002 17.8569ZM16.0716 12.4997C16.0716 14.4721 14.4726 16.0711 12.5002 16.0711C10.5278 16.0711 8.92878 14.4721 8.92878 12.4997C8.92878 10.5273 10.5278 8.92829 12.5002 8.92829C14.4726 8.92829 16.0716 10.5273 16.0716 12.4997Z" fill="#333333"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 11.6068V13.3925C0 14.7748 1.04697 15.9125 2.39115 16.0559C2.50525 16.3803 2.63448 16.6974 2.77797 17.0065C1.89718 18.0589 1.95121 19.6286 2.9401 20.6175L4.20279 21.8802C5.16916 22.8465 6.69022 22.9202 7.7411 22.101C8.12893 22.2936 8.53021 22.4634 8.94312 22.6087C9.08652 23.9529 10.2242 25 11.6065 25H13.3922C14.7742 25 15.9117 23.9535 16.0554 22.6096C16.4307 22.4777 16.7963 22.3255 17.151 22.1544C18.1985 22.9164 19.6736 22.825 20.6184 21.8802L21.8811 20.6175C22.8259 19.6727 22.9173 18.1976 22.1554 17.1501C22.3262 16.7958 22.4783 16.4306 22.6102 16.0557C23.9538 15.9117 25 14.7743 25 13.3925V11.6068C25 10.225 23.9538 9.08768 22.6102 8.94366C22.4647 8.53013 22.2947 8.12834 22.1019 7.74003C22.9204 6.68919 22.8466 5.16864 21.8804 4.20251L20.6178 2.93981C19.6291 1.95117 18.0599 1.89692 17.0076 2.77705C16.6979 2.63335 16.3803 2.50394 16.0554 2.38971C15.9113 1.04622 14.7739 0 13.3922 0H11.6065C10.2245 0 9.08687 1.04671 8.94321 2.39062C8.57838 2.51902 8.22264 2.66654 7.87724 2.83197C6.82539 1.8951 5.21218 1.93104 4.20341 2.93981L2.94071 4.2025C1.93194 5.21129 1.896 6.82451 2.8329 7.87636C2.66729 8.22212 2.51963 8.57824 2.39115 8.94348C1.04697 9.08687 0 10.2246 0 11.6068ZM14.2851 2.67857C14.2851 2.18546 13.8854 1.78571 13.3922 1.78571H11.6065C11.1134 1.78571 10.7137 2.18546 10.7137 2.67857V3.02026C10.7137 3.44485 10.413 3.80604 10.0053 3.92448C9.37196 4.10846 8.76762 4.36072 8.20085 4.67275C7.82889 4.87752 7.36094 4.83465 7.06071 4.53442L6.72879 4.20251C6.38011 3.85382 5.81479 3.85382 5.4661 4.2025L4.20341 5.4652C3.85472 5.81387 3.85472 6.37921 4.20341 6.72788L4.53534 7.05981C4.83557 7.36004 4.87844 7.828 4.67367 8.19996C4.36147 8.76705 4.10911 9.3717 3.9251 10.0054C3.8067 10.4133 3.44548 10.7139 3.02084 10.7139H2.67857C2.18546 10.7139 1.78571 11.1138 1.78571 11.6068V13.3925C1.78571 13.8856 2.18546 14.2854 2.67857 14.2854H3.02084C3.44548 14.2854 3.80669 14.5861 3.9251 14.9938C4.0978 15.5887 4.33073 16.1579 4.61683 16.6946C4.8143 17.0649 4.76871 17.5262 4.47192 17.8229L4.20279 18.0921C3.85411 18.4408 3.85411 19.0061 4.20279 19.3548L5.46548 20.6175C5.81416 20.9662 6.37949 20.9662 6.72817 20.6175L6.94542 20.4003C7.2491 20.0965 7.72371 20.0565 8.09713 20.2686C8.69371 20.6075 9.33313 20.8796 10.0053 21.0749C10.413 21.1933 10.7137 21.5546 10.7137 21.9791V22.3214C10.7137 22.8146 11.1134 23.2143 11.6065 23.2143H13.3922C13.8854 23.2143 14.2851 22.8146 14.2851 22.3214V21.9798C14.2851 21.5552 14.5858 21.1939 14.9937 21.0755C15.6279 20.8915 16.2329 20.639 16.8004 20.3266C17.1723 20.1219 17.6403 20.1647 17.9405 20.465L18.093 20.6175C18.4417 20.9662 19.0071 20.9662 19.3557 20.6175L20.6184 19.3548C20.9671 19.0061 20.9671 18.4408 20.6184 18.0921L20.4659 17.9396C20.1656 17.6394 20.1228 17.1714 20.3276 16.7995C20.6398 16.2323 20.8921 15.6277 21.0762 14.9938C21.1946 14.5861 21.5558 14.2854 21.9804 14.2854H22.3214C22.8146 14.2854 23.2143 13.8856 23.2143 13.3925V11.6068C23.2143 11.1138 22.8146 10.7139 22.3214 10.7139H21.9804C21.5558 10.7139 21.1946 10.4133 21.0762 10.0054C20.8809 9.33295 20.6087 8.6931 20.2696 8.09619C20.0574 7.72276 20.0975 7.24815 20.4012 6.94447L20.6178 6.72788C20.9664 6.37921 20.9664 5.81387 20.6178 5.4652L19.3551 4.2025C19.0064 3.85382 18.4411 3.85382 18.0924 4.2025L17.8239 4.47096C17.5271 4.76775 17.0658 4.81336 16.6954 4.61588C16.1586 4.3296 15.5889 4.09656 14.9937 3.92381C14.5858 3.80545 14.2851 3.44421 14.2851 3.01953V2.67857Z" fill="#333333"/>
                </g>
                <defs>
                <clipPath id="clip0_80_7938">
                <rect width="25" height="25" fill="white"/>
                </clipPath>
                </defs>
            </svg>
            <a style="width: 100%;" href="/configuracion"><button type="button" class="profile-modal__button profile-modal__button--extra" id="configuration-profile">Configuración</button></a>
        </div>
        <?php if (isAdmin()) : ?>
            <div class="profile-modal__button-container">
            <a style="width: 100%;" href="/admin"><button type="button" class="profile-modal__button profile-modal__button--extra" id="configuration-profile">Administrador</button></a>
        </div>
        <?php endif; ?>
        <div class="profile-modal__button-container">
            <svg class="exit-icon" width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <rect width="25" height="25" fill="url(#pattern0_80_7933)"/>
                <defs>
                <pattern id="pattern0_80_7933" patternContentUnits="objectBoundingBox" width="1" height="1">
                <use xlink:href="#image0_80_7933" transform="scale(0.01)"/>
                </pattern>
                <image id="image0_80_7933" width="100" height="100" preserveAspectRatio="none" xlink:href="data:image/png;base64,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"/>
                </defs>
            </svg>
            <button type="button" class="profile-modal__button profile-modal__button--logout" id="logout-profile">Cerrar Sesión </button>
        </div>
        </div>
</div>
<script type="module" src="/assets/js/configuration.js"></script>

<div class="background__shadow background__blur" id="background-login"></div>

<div class="login-modal" id="logout-modal-nfc" style="display: none;">
    <button class="modal__close" id="nfc-logout-close">
        <svg class="close-icon" width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M29.5762 0.547733C28.9254 -0.103151 27.87 -0.103151 27.2192 0.547733L15.0619 12.705L2.90463 0.547733C2.25376 -0.103151 1.19848 -0.103151 0.547611 0.547733C-0.103273 1.1986 -0.103273 2.25388 0.547611 2.90475L12.7049 15.062L0.547644 27.2192C-0.103239 27.8702 -0.103239 28.9254 0.547644 29.5764C1.19851 30.2272 2.25379 30.2272 2.90466 29.5764L15.0619 17.419L27.2192 29.5764C27.87 30.2272 28.9254 30.2272 29.5762 29.5764C30.227 28.9254 30.227 27.8702 29.5762 27.2194L17.4189 15.062L29.5762 2.90475C30.227 2.25388 30.227 1.1986 29.5762 0.547733Z" fill="black"/>
        </svg>
    </button>
    <h2 class="login-modal__title">Nos vemos</h2>

    <form class="login-modal__form" id="nfc-login-form" method="POST" action="/api/user/login">
        <div class="login-modal__input-container">
            <label for="login-username" class="login-modal__label">Por favor, acerca tu tarjeta NFC al lector para registrar la salida</label>
        </div>

        <div class="nfc-modal__logo-container">
            <img src="/assets/img/NFC.png" alt="" class="nfc-modal__logo">
        </div>
    </form>

    <div class="login-modal__button-container">
            <button type="submit" class="login-modal__button login-modal__button--login" id="nfc-modal-logout-button">Registrar Salida</button>
    </div>
</div>
<script type="module" src="/assets/js/configuration.js"></script> 