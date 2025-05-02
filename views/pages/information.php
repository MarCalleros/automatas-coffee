<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/variables.css">
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="shortcut icon" href="/assets/img/logo-coffee.png">
    <title>Informacion</title>
</head>
<body class="page--full-height">
    <?php include_once __DIR__ . "/../templates/navbar.php"; ?>

    <main class="information-container main--full-height">
        <section class="information-section information-section--menu">
            <h2 class="information-section__title">Informacion</h2>

            <div class="information-menu">
                <div class="information-menu__item">
                    <div class="information-menu__button" id="information-messages">
                        <h3 class="information-menu__title">Mensajes</h3>

                        <div class="information-menu__arrow">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_609_1250)">
                                    <path class="information-item-icon" d="M12.7717 18.2259L23.6805 7.31682C24.1065 6.89085 24.1065 6.20009 23.6804 5.77405C23.2544 5.34809 22.5637 5.34809 22.1376 5.77413L12.0002 15.9118L1.86223 5.77405C1.43619 5.34809 0.745499 5.34809 0.319463 5.77413C0.106445 5.98707 -2.83323e-05 6.26627 -2.83323e-05 6.54547C-2.83323e-05 6.82467 0.106445 7.10387 0.319536 7.31689L11.2289 18.2259C11.4335 18.4306 11.711 18.5455 12.0003 18.5455C12.2896 18.5455 12.5671 18.4306 12.7717 18.2259Z" fill="#333333"/>
                                </g>
                                <defs><clipPath id="clip0_609_1250"><rect width="24" height="24" fill="white" transform="matrix(0 1 -1 0 24 0)"/></clipPath></defs>
                            </svg>
                        </div>
                    </div>

                    <div class="information-menu__options" id="information-messages-options">
                        <div class="information-menu__option">
                            <div class="information-option__icon">
                                <svg class="information-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier"> 
                                        <path class="information-stroke-icon" d="M4 18L9 12M20 18L15 12M3 8L10.225 12.8166C10.8665 13.2443 11.1872 13.4582 11.5339 13.5412C11.8403 13.6147 12.1597 13.6147 12.4661 13.5412C12.8128 13.4582 13.1335 13.2443 13.775 12.8166L21 8M6.2 19H17.8C18.9201 19 19.4802 19 19.908 18.782C20.2843 18.5903 20.5903 18.2843 20.782 17.908C21 17.4802 21 16.9201 21 15.8V8.2C21 7.0799 21 6.51984 20.782 6.09202C20.5903 5.71569 20.2843 5.40973 19.908 5.21799C19.4802 5 18.9201 5 17.8 5H6.2C5.0799 5 4.51984 5 4.09202 5.21799C3.71569 5.40973 3.40973 5.71569 3.21799 6.09202C3 6.51984 3 7.07989 3 8.2V15.8C3 16.9201 3 17.4802 3.21799 17.908C3.40973 18.2843 3.71569 18.5903 4.09202 18.782C4.51984 19 5.07989 19 6.2 19Z" stroke="#333333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> 
                                    </g>
                                </svg>
                            </div>
                            
                            <div class="information-option__text">
                                <h4 class="information-option__title">Mensajes Enviados</h4>
                                <p class="information-option__description">Revisa los mensajes que has enviado a nuestro equipo de soporte</p>
                            </div>
                        </div>

                        <div class="information-menu__option">
                            <div class="information-option__icon">
                                <svg class="information-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier"> 
                                        <path class="information-stroke-icon" d="M4 19L9 14M20 19L15 14M3.02832 10L10.2246 14.8166C10.8661 15.2443 11.1869 15.4581 11.5336 15.5412C11.8399 15.6146 12.1593 15.6146 12.4657 15.5412C12.8124 15.4581 13.1332 15.2443 13.7747 14.8166L20.971 10M10.2981 4.06879L4.49814 7.71127C3.95121 8.05474 3.67775 8.22648 3.4794 8.45864C3.30385 8.66412 3.17176 8.90305 3.09111 9.161C3 9.45244 3 9.77535 3 10.4212V16.8C3 17.9201 3 18.4802 3.21799 18.908C3.40973 19.2843 3.71569 19.5903 4.09202 19.782C4.51984 20 5.0799 20 6.2 20H17.8C18.9201 20 19.4802 20 19.908 19.782C20.2843 19.5903 20.5903 19.2843 20.782 18.908C21 18.4802 21 17.9201 21 16.8V10.4212C21 9.77535 21 9.45244 20.9089 9.161C20.8282 8.90305 20.6962 8.66412 20.5206 8.45864C20.3223 8.22648 20.0488 8.05474 19.5019 7.71127L13.7019 4.06879C13.0846 3.68116 12.776 3.48735 12.4449 3.4118C12.152 3.34499 11.848 3.34499 11.5551 3.4118C11.224 3.48735 10.9154 3.68116 10.2981 4.06879Z" stroke="#333333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> 
                                    </g>
                                </svg>
                            </div>
                            
                            <div class="information-option__text">
                                <h4 class="information-option__title">Mensajes Respondidos</h4>
                                <p class="information-option__description">Revisa los mensajes que nuestro equipo de soporte ha respondido</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="information-menu__item">
                    <div class="information-menu__button" id="information-purchases">
                        <h3 class="information-menu__title">Historial de Compras</h3>

                        <div class="information-menu__arrow">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_609_1250)">
                                    <path class="information-item-icon" d="M12.7717 18.2259L23.6805 7.31682C24.1065 6.89085 24.1065 6.20009 23.6804 5.77405C23.2544 5.34809 22.5637 5.34809 22.1376 5.77413L12.0002 15.9118L1.86223 5.77405C1.43619 5.34809 0.745499 5.34809 0.319463 5.77413C0.106445 5.98707 -2.83323e-05 6.26627 -2.83323e-05 6.54547C-2.83323e-05 6.82467 0.106445 7.10387 0.319536 7.31689L11.2289 18.2259C11.4335 18.4306 11.711 18.5455 12.0003 18.5455C12.2896 18.5455 12.5671 18.4306 12.7717 18.2259Z" fill="#333333"/>
                                </g>
                                <defs><clipPath id="clip0_609_1250"><rect width="24" height="24" fill="white" transform="matrix(0 1 -1 0 24 0)"/></clipPath></defs>
                            </svg>
                        </div>
                    </div>

                    <div class="information-menu__options" id="information-purchases-options">
                        <div class="information-menu__option">
                            <div class="information-option__icon">
                                <svg class="information-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier"> 
                                        <path class="information-stroke-icon" d="M21 5L19 12H7.37671M20 16H8L6 3H3M11 6L13 8L17 4M9 20C9 20.5523 8.55228 21 8 21C7.44772 21 7 20.5523 7 20C7 19.4477 7.44772 19 8 19C8.55228 19 9 19.4477 9 20ZM20 20C20 20.5523 19.5523 21 19 21C18.4477 21 18 20.5523 18 20C18 19.4477 18.4477 19 19 19C19.5523 19 20 19.4477 20 20Z" stroke="#333333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> 
                                    </g>
                                </svg>
                            </div>
                            
                            <div class="information-option__text">
                                <h4 class="information-option__title">Consultar mi historial de compras</h4>
                                <p class="information-option__description">Consulta tus compras realizadas hasta el dia de hoy</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="information-menu__item">
                    <div class="information-menu__button" id="information-account">
                        <h3 class="information-menu__title">Datos de Cuenta</h3>

                        <div class="information-menu__arrow">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_609_1250)">
                                    <path class="information-item-icon" d="M12.7717 18.2259L23.6805 7.31682C24.1065 6.89085 24.1065 6.20009 23.6804 5.77405C23.2544 5.34809 22.5637 5.34809 22.1376 5.77413L12.0002 15.9118L1.86223 5.77405C1.43619 5.34809 0.745499 5.34809 0.319463 5.77413C0.106445 5.98707 -2.83323e-05 6.26627 -2.83323e-05 6.54547C-2.83323e-05 6.82467 0.106445 7.10387 0.319536 7.31689L11.2289 18.2259C11.4335 18.4306 11.711 18.5455 12.0003 18.5455C12.2896 18.5455 12.5671 18.4306 12.7717 18.2259Z" fill="#333333"/>
                                </g>
                                <defs><clipPath id="clip0_609_1250"><rect width="24" height="24" fill="white" transform="matrix(0 1 -1 0 24 0)"/></clipPath></defs>
                            </svg>
                        </div>
                    </div>

                    <div class="information-menu__options" id="information-account-options">
                        <div class="information-menu__option" id="information-account-data">
                            <div class="information-option__icon">
                                <svg class="information-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier"> 
                                        <path class="information-stroke-icon" d="M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7Z" stroke="#333333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> 
                                        <path class="information-stroke-icon" d="M12 14C8.13401 14 5 17.134 5 21H19C19 17.134 15.866 14 12 14Z" stroke="#333333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> 
                                    </g>
                                </svg>
                            </div>
                            
                            <div class="information-option__text">
                                <h4 class="information-option__title">Información de mi cuenta</h4>
                                <p class="information-option__description">Mira la información de tu cuenta y actualizala en cualquier momento</p>
                            </div>
                        </div>

                        <div class="information-menu__option" id="information-account-password">
                            <div class="information-option__icon">
                                <svg class="information-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier"> 
                                        <path class="information-stroke-icon" d="M12 14.5V16.5M7 10.0288C7.47142 10 8.05259 10 8.8 10H15.2C15.9474 10 16.5286 10 17 10.0288M7 10.0288C6.41168 10.0647 5.99429 10.1455 5.63803 10.327C5.07354 10.6146 4.6146 11.0735 4.32698 11.638C4 12.2798 4 13.1198 4 14.8V16.2C4 17.8802 4 18.7202 4.32698 19.362C4.6146 19.9265 5.07354 20.3854 5.63803 20.673C6.27976 21 7.11984 21 8.8 21H15.2C16.8802 21 17.7202 21 18.362 20.673C18.9265 20.3854 19.3854 19.9265 19.673 19.362C20 18.7202 20 17.8802 20 16.2V14.8C20 13.1198 20 12.2798 19.673 11.638C19.3854 11.0735 18.9265 10.6146 18.362 10.327C18.0057 10.1455 17.5883 10.0647 17 10.0288M7 10.0288V8C7 5.23858 9.23858 3 12 3C14.7614 3 17 5.23858 17 8V10.0288" stroke="#333333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> 
                                    </g>
                                </svg>
                            </div>
                            
                            <div class="information-option__text">
                                <h4 class="information-option__title">Cambiar mi contraseña</h4>
                                <p class="information-option__description">Actualiza tu contraseña en cualquier momento</p>
                            </div>
                        </div>

                        <div class="information-menu__option" id="information-account-desactivate">
                            <div class="information-option__icon">
                                <svg class="information-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier"> 
                                        <path class="information-stroke-icon" d="M12 6.00011L14 8.00011L10 10.0001L13 13.0001M12 6.00011C10.2006 3.90309 7.19377 3.25515 4.93923 5.17539C2.68468 7.09563 2.36727 10.3062 4.13778 12.5772C5.60984 14.4655 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9816C11.9483 20.0063 12.0393 20.0063 12.1225 19.9816C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4655 19.8499 12.5772C21.6204 10.3062 21.3417 7.07543 19.0484 5.17539C16.7551 3.27535 13.7994 3.90309 12 6.00011Z" stroke="#333333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> 
                                    </g>
                                </svg>
                            </div>
                            
                            <div class="information-option__text">
                                <h4 class="information-option__title">Desactivar mi cuenta</h4>
                                <p class="information-option__description">Desactiva tu cuenta, no te preocupes, en cualquier momento puedes reactivarla nuevamente</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="information-section information-section--content">
            <h2 class="information-section__title">Titulo de la seccion</h2>


        </section>
    </main>

    <?php include_once __DIR__ . "/../templates/footer.php"; ?>

    <script src="assets/js/navbar.js"></script>
    <script type="module" src="assets/js/information.js"></script>
    <script type="module" src="/assets/js/configuration.js"></script>
</body>
</html>