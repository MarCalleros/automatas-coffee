<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="/assets/css/variables.css">
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="shortcut icon" href="/assets/img/logo-coffee.png">
</head>
<body class="page--full-height">
<?php include_once __DIR__ . "/../templates/navbar.php"; ?>
    <h2 class="title--page">Complete su Pedido</h2>
    
    <main class="main--full-height">
        <div class="delivery__container">
            <div class="delivery__step">
                <svg class="delivery-number-icon" width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_843_1445)">
                        <mask id="mask0_843_1445" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="50" height="50"><path d="M50 0H0V50H50V0Z" fill="white"/></mask>
                        <g mask="url(#mask0_843_1445)">
                            <path class="number-path number-path--active" d="M26.0417 35.4168V14.5835L21.875 18.7502" stroke="#FF5100" stroke-width="4.8" stroke-linecap="round" stroke-linejoin="round"/>
                            <path class="number-path number-path--active" d="M25 43.75C35.3553 43.75 43.75 35.3553 43.75 25C43.75 14.6447 35.3553 6.25 25 6.25C14.6447 6.25 6.25 14.6447 6.25 25C6.25 35.3553 14.6447 43.75 25 43.75Z" stroke="#FF5100" stroke-width="4.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </g>
                    </g>
                    <defs>
                        <clipPath id="clip0_843_1445"><rect width="50" height="50" fill="white"/></clipPath>
                    </defs>
                </svg>
            </div>

            <div class="delivery__step">
                <h3 class="delivery__header">Elija donde Recibir su Pedido</h3>
            </div>

            <div class="step__separator"></div>

            <div class="delivery__content delivery__content--receive">
                <div class="delivery-receive__options">
                    <div class="delivery-receive__option">
                        <p class="delivery-receive__title">Recoge en Sucursal</p>
                        <div class="delivery-receive__container delivery-receive__container--receive" data-option="subsidiary">
                            <svg width="125" height="125" viewBox="0 0 125 125" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path class="receive-path" d="M20.8335 104.167H56.9965M56.9965 104.167H57.5871M56.9965 104.167C57.095 104.168 57.1934 104.168 57.2918 104.168C57.3903 104.168 57.4887 104.168 57.5871 104.167M56.9965 104.167C36.997 104.008 20.8335 87.7438 20.8335 67.7073V46.4732C20.8335 43.818 22.9848 41.6667 25.64 41.6667H88.9413C91.5965 41.6667 93.7502 43.818 93.7502 46.4732V46.875M57.5871 104.167H93.7502M57.5871 104.167C77.5866 104.008 93.7502 87.7438 93.7502 67.7073M93.7502 46.875H101.563C108.754 46.875 114.583 52.7047 114.583 59.8958C114.583 67.087 108.754 72.9167 101.563 72.9167H93.7502V67.7073M93.7502 46.875V67.7073M78.1252 15.625L72.9168 26.0417M62.5002 15.625L57.2918 26.0417M46.8752 15.625L41.6668 26.0417" stroke="#333333" stroke-width="7.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>
                    
                    <div class="delivery-receive__option">
                        <p class="delivery-receive__title">Envio a Domicilio</p>
                        <div class="delivery-receive__container delivery-receive__container--receive" data-option="address">
                            <svg width="125" height="125" viewBox="0 0 125 125" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path class="receive-path" d="M62.4998 109.375C80.729 90.625 98.9582 73.8354 98.9582 53.125C98.9582 32.4143 82.6353 15.625 62.4998 15.625C42.3645 15.625 26.0415 32.4143 26.0415 53.125C26.0415 73.8354 44.2707 90.625 62.4998 109.375Z" stroke="#333333" stroke-width="7.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path class="receive-path" d="M62.5 67.7085C71.1297 67.7085 78.125 60.7132 78.125 52.0835C78.125 43.4541 71.1297 36.4585 62.5 36.4585C53.8703 36.4585 46.875 43.4541 46.875 52.0835C46.875 60.7132 53.8703 67.7085 62.5 67.7085Z" stroke="#333333" stroke-width="7.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="delivery-receive__card delivery-receive__card--subsidiary">
                    <div class="delivery-receive__separator"></div>

                    <div class="delivery-receive__info-container">
                        <img class="delivery-receive__image" src="/assets/img/logo-coffee.png" alt="Sucursal">
                        <div class="delivery-receive__info">
                            <strong class="delivery-receive__text">Sucursal Principal Automatas Coffee</strong>
                            <p class="delivery-receive__text">Fuentes de Poseidon, 81210 Los Mochis, Sinaloa</p>
                            <a class="delivery-receive__text" target="_blank" href="https://www.google.com/maps/place/Facultad+De+Ingenieria+Mochis/@25.8145063,-108.9797897,19z/data=!4m14!1m7!3m6!1s0x86ba28b9f818dc49:0xbe7faef935f982f0!2sFacultad+De+Ingenieria+Mochis!8m2!3d25.8146408!4d-108.9798737!16s%2Fg%2F1tdcxjgm!3m5!1s0x86ba28b9f818dc49:0xbe7faef935f982f0!8m2!3d25.8146408!4d-108.9798737!16s%2Fg%2F1tdcxjgm?hl=es&entry=ttu&g_ep=EgoyMDI1MDUyMS4wIKXMDSoASAFQAw%3D%3D">Encuentranos</a>
                        </div>
                    </div>

                    <div class="delivery-receive__separator"></div>
                </div>

                <div class="delivery-receive__card delivery-receive__card--address">
                    <div class="delivery-receive__separator"></div>

                    <div class="delivery-receive__info-container">
                        <svg width="100" height="100" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path class="receive-path" d="M50 25H50.0417M37.5 83.3333L12.5 70.8333V16.6667L20.8333 20.8333M37.5 83.3333L62.5 70.8333M37.5 83.3333V58.3333M62.5 70.8333L87.5 83.3333V29.1667L79.1667 25M62.5 70.8333V58.3333M62.5 25.8333C62.5 33.1971 56.25 39.1667 50 45.8333C43.75 39.1667 37.5 33.1971 37.5 25.8333C37.5 18.4695 43.0962 12.5 50 12.5C56.9037 12.5 62.5 18.4695 62.5 25.8333Z" stroke="#333333" stroke-width="7.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>

                        <div class="delivery-receive__info">
                            <strong class="delivery-receive__text">Usar mi Ubicación Actual</strong>
                            <p class="delivery-receive__text">Obtenga su ubicación actual mediante el gps</p>
                            <p class="delivery-receive__text">Necesita activar la opción de ubicación en su dispositivo*</p>
                        </div>
                    </div>

                    <div class="delivery-receive__separator"></div>

                    <div class="delivery-receive__info">
                        <div class="delivery-receive__info-container">
                            <img class="delivery-receive__image" src="/assets/img/logo-coffee.png" alt="Sucursal">
                            <div class="delivery-receive__info">
                                <strong class="delivery-receive__text">Casa Viñedos</strong>
                                <p class="delivery-receive__text">Fuentes de Poseidon, 81210 Los Mochis, Sinaloa</p>
                                <a class="delivery-receive__text" target="_blank" href="https://www.google.com/maps/place/Facultad+De+Ingenieria+Mochis/@25.8145063,-108.9797897,19z/data=!4m14!1m7!3m6!1s0x86ba28b9f818dc49:0xbe7faef935f982f0!2sFacultad+De+Ingenieria+Mochis!8m2!3d25.8146408!4d-108.9798737!16s%2Fg%2F1tdcxjgm!3m5!1s0x86ba28b9f818dc49:0xbe7faef935f982f0!8m2!3d25.8146408!4d-108.9798737!16s%2Fg%2F1tdcxjgm?hl=es&entry=ttu&g_ep=EgoyMDI1MDUyMS4wIKXMDSoASAFQAw%3D%3D">Encuentranos</a>
                            </div>
                        </div>
                    </div>

                    <div class="delivery-receive__separator"></div>
                </div>
            </div>

            <div clas="delivery__step">
                <svg class="delivery-number-icon" width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_843_1453)">
                        <mask id="mask0_843_1453" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="50" height="50"><path d="M50 0H0V50H50V0Z" fill="white"/></mask>
                        <g mask="url(#mask0_843_1453)">
                            <path class="number-path" d="M25 43.75C35.3553 43.75 43.75 35.3553 43.75 25C43.75 14.6447 35.3553 6.25 25 6.25C14.6447 6.25 6.25 14.6447 6.25 25C6.25 35.3553 14.6447 43.75 25 43.75Z" stroke="#333333" stroke-width="4.8" stroke-linecap="round" stroke-linejoin="round"/>
                            <path class="number-path" d="M19.7915 19.7918C19.7915 18.4589 20.3 17.126 21.3169 16.109C23.3509 14.075 26.6488 14.075 28.6828 16.109C30.7167 18.143 30.7167 21.4408 28.6828 23.4747L20.7068 31.4506C20.1208 32.0366 19.7915 32.8314 19.7915 33.6604V35.4168H30.2082" stroke="#333333" stroke-width="4.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </g>
                    </g>
                    <defs>
                        <clipPath id="clip0_843_1453"><rect width="50" height="50" fill="white"/></clipPath>
                    </defs>
                </svg>
            </div>

            <div class="delivery__step">
                <h3 class="delivery__header">Elija un Método de Pago</h3>
            </div>

            <div class="step__separator"></div>

            <div class="delivery__content delivery__content--method">
                <div class="delivery-receive__options">
                    <div class="delivery-receive__option">
                        <p class="delivery-receive__title">Tarjeta</p>
                        <div class="delivery-receive__container delivery-receive__container--method" data-option="card">
                            <svg width="125" height="125" viewBox="0 0 125 125" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path class="receive-path" d="M31.25 78.1248H41.6667M15.625 57.2915H109.375M15.625 41.6665H109.375M62.5 78.1248H83.3333M32.2917 98.9582H92.7083C98.5422 98.9582 101.459 98.9582 103.688 97.8227C105.647 96.8243 107.241 95.2306 108.24 93.2707C109.375 91.0425 109.375 88.1254 109.375 82.2915V42.7082C109.375 36.8743 109.375 33.9573 108.24 31.7291C107.241 29.7691 105.647 28.1755 103.688 27.1769C101.459 26.0415 98.5422 26.0415 92.7083 26.0415H32.2917C26.4578 26.0415 23.5408 26.0415 21.3126 27.1769C19.3526 28.1755 17.759 29.7691 16.7604 31.7291C15.625 33.9573 15.625 36.8743 15.625 42.7082V82.2915C15.625 88.1254 15.625 91.0425 16.7604 93.2707C17.759 95.2306 19.3526 96.8243 21.3126 97.8227C23.5408 98.9582 26.4578 98.9582 32.2917 98.9582Z" stroke="#333333" stroke-width="7.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>
                    
                    <div class="delivery-receive__option">
                        <p class="delivery-receive__title">Efectivo</p>
                        <div class="delivery-receive__container delivery-receive__container--method" data-option="money">
                            <svg width="125" height="125" viewBox="0 0 125 125" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path class="receive-path" d="M30.3298 31.2519C32.4911 33.1606 33.8542 35.9523 33.8542 39.0625C33.8542 44.8155 29.1905 49.4792 23.4375 49.4792C20.3273 49.4792 17.5356 48.1161 15.6269 45.9548M30.3298 31.2519C30.945 31.25 31.5977 31.25 32.2917 31.25H92.7083C93.4021 31.25 94.0552 31.25 94.6703 31.2519M30.3298 31.2519C25.7735 31.266 23.2758 31.3851 21.3126 32.3854C19.3526 33.384 17.759 34.9776 16.7604 36.9376C15.7601 38.9008 15.641 41.3985 15.6269 45.9548M15.6269 45.9548C15.625 46.57 15.625 47.2227 15.625 47.9167V77.0833C15.625 77.7771 15.625 78.4302 15.6269 79.0453M94.6703 31.2519C92.5089 33.1606 91.1458 35.9523 91.1458 39.0625C91.1458 44.8155 95.8094 49.4792 101.563 49.4792C104.672 49.4792 107.465 48.1161 109.373 45.9548M94.6703 31.2519C99.2266 31.266 101.724 31.3851 103.688 32.3854C105.647 33.384 107.241 34.9776 108.24 36.9376C109.24 38.9008 109.359 41.3985 109.373 45.9548M15.6269 79.0453C17.5356 76.8839 20.3273 75.5208 23.4375 75.5208C29.1905 75.5208 33.8542 80.1844 33.8542 85.9375C33.8542 89.0474 32.4911 91.8396 30.3298 93.7479M15.6269 79.0453C15.641 83.6016 15.7601 86.099 16.7604 88.0625C17.759 90.0224 19.3526 91.6161 21.3126 92.6146C23.2758 93.6151 25.7735 93.7339 30.3298 93.7479M30.3298 93.7479C30.945 93.75 31.5977 93.75 32.2917 93.75H92.7083C93.4021 93.75 94.0552 93.75 94.6703 93.7479M94.6703 93.7479C92.5089 91.8396 91.1458 89.0474 91.1458 85.9375C91.1458 80.1844 95.8094 75.5208 101.563 75.5208C104.673 75.5208 107.466 76.8849 109.375 79.0474M94.6703 93.7479C99.2266 93.7339 101.724 93.6151 103.688 92.6146C105.647 91.6161 107.241 90.0224 108.24 88.0625C109.24 86.0995 109.361 83.6021 109.375 79.0474M109.375 79.0474C109.377 78.4318 109.375 77.7781 109.375 77.0833V47.9167C109.375 47.2227 109.375 46.57 109.373 45.9548M72.9167 62.5C72.9167 68.2531 68.2531 72.9167 62.5 72.9167C56.7469 72.9167 52.0833 68.2531 52.0833 62.5C52.0833 56.7469 56.7469 52.0833 62.5 52.0833C68.2531 52.0833 72.9167 56.7469 72.9167 62.5Z" stroke="#333333" stroke-width="7.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="delivery-receive__card delivery-receive__card--card">
                    <div class="delivery-receive__separator"></div>

                    <div class="delivery-method__info-container delivery-method__info-container--small">
                        <div class="delivery-method__info">
                            <label class="delivery-method__label" for="name">Titular de la Tarjeta</label>
                            <input class="delivery-method__input" type="text" placeholder="Nombre del Titular" name="name">
                        </div>

                        <div class="delivery-method__info">
                            <label class="delivery-method__label" for="number">Numero de la Tarjeta</label>
                            <div class="delivery-method__number" name="number">
                                <input class="delivery-method__input delivery-method__input--short" type="number" placeholder="XXXX" name="number-1" data-number="1">
                                <p class="delivery-method__middle">—</p>
                                <input class="delivery-method__input delivery-method__input--short" type="number" placeholder="XXXX" name="number-2" data-number="2">
                                <p class="delivery-method__middle">—</p>
                                <input class="delivery-method__input delivery-method__input--short" type="number" placeholder="XXXX" name="number-3" data-number="3">
                                <p class="delivery-method__middle">—</p>
                                <input class="delivery-method__input delivery-method__input--short" type="number" placeholder="XXXX" name="number-4" data-number="4">
                            </div>
                        </div>

                        <div class="delivery-method__input-container">
                            <div class="delivery-method__info">
                                <label class="delivery-method__label" for="date">Fecha de Caducidad (MM/YY)</label>
                                <div class="delivery-method__number" name="date">
                                    <input class="delivery-method__input delivery-method__input--short" type="number" placeholder="MM" name="date-1" data-number="5">
                                    <p class="delivery-method__middle delivery-method__middle--without-margin">/</p>
                                    <input class="delivery-method__input delivery-method__input--short" type="number" placeholder="YY" name="date-2" data-number="6">
                                </div>
                            </div>

                            <div class="delivery-method__info">
                                <label class="delivery-method__label" for="cvc">CVC</label>
                                <div class="delivery-method__number" name="cvc">
                                    <input class="delivery-method__input delivery-method__input--short" type="number" placeholder="XXX" name="cvc-1" data-number="7">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="filter__item delivery-method__save">
                        <input class="filter__input--category" type="checkbox" name="save" id="save">
                        <label for="save"></label>
                        <span class="filter__description">Guardar mi Tarjeta para Futuras Compras</span>
                    </div>

                    <div class="delivery-receive__separator"></div>

                    <div class="delivery-method__card">
                        <div class="delivery-method__card-container">
                            <img class="delivery-receive__image" src="/assets/img/logo-coffee.png" alt="Sucursal">
                            <div class="delivery-receive__info">
                                <strong class="delivery-receive__text">Tarjeta con Terminación XXXX-XXXX-XXXX-2812</strong>
                                <p class="delivery-receive__text">Martin Alejandro Calleros Camarillo</p>
                                <p class="delivery-receive__text">10 / 28</p>
                            </div>
                        </div>

                        <div class="delivery-method__card-container">
                            <img class="delivery-receive__image" src="/assets/img/logo-coffee.png" alt="Sucursal">
                            <div class="delivery-receive__info">
                                <strong class="delivery-receive__text">Tarjeta con Terminación XXXX-XXXX-XXXX-2812</strong>
                                <p class="delivery-receive__text">Martin Alejandro Calleros Camarillo</p>
                                <p class="delivery-receive__text">10 / 28</p>
                            </div>
                        </div>
                    </div>

                    <div class="delivery-receive__separator"></div>
                </div>
            </div>

            <div clas="delivery__step">
                <svg class="delivery-number-icon" width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_843_1461)">
                        <mask id="mask0_843_1461" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="50" height="50"><path d="M50 0H0V50H50V0Z" fill="white"/></mask>
                        <g mask="url(#mask0_843_1461)">
                            <path class="number-path" d="M25 43.75C35.3553 43.75 43.75 35.3553 43.75 25C43.75 14.6447 35.3553 6.25 25 6.25C14.6447 6.25 6.25 14.6447 6.25 25C6.25 35.3553 14.6447 43.75 25 43.75Z" stroke="#333333" stroke-width="4.8" stroke-linecap="round" stroke-linejoin="round"/>
                            <path class="number-path" d="M20.8335 33.8254C21.9393 34.815 23.3993 35.4168 25.0002 35.4168C28.452 35.4168 31.2502 32.6187 31.2502 29.1668C31.2502 25.715 28.452 22.9168 25.0002 22.9168L31.2502 14.5835H20.8335" stroke="#333333" stroke-width="4.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </g>
                    </g>
                    <defs>
                        <clipPath id="clip0_843_1461"><rect width="50" height="50" fill="white"/></clipPath>
                    </defs>
                </svg>
            </div>

            <div class="delivery__step">
                <h3 class="delivery__header">Confirme su Pedido</h3>
            </div>

            <div></div>

            <div class="delivery__content delivery__content--delivery">
                <div class="delivery-receive__info">
                    <div class="delivery-receive__info-container">
                        <div class="delivery-receive__info">
                            <p class="delivery-receive__text delivery-delivery__text"><strong>Pago: </strong></p>
                            <p class="delivery-receive__text delivery-delivery__text"><strong>Dirección: </strong></p>
                            <p class="delivery-receive__text delivery-delivery__text"><strong>Total a pagar: </strong>$</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <?php include_once __DIR__ . "/../templates/footer.php"; ?>   
    <script type="module" src="/assets/js/carrito.js"></script>    
    <script type="module" src="/assets/js/delivery.js"></script>    
    <script type="module" src="/assets/js/configuration.js"></script>
</body>
</html>