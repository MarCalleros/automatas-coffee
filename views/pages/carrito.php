<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="/assets/css/carrito.css">
    <link rel="stylesheet" href="/assets/css/variables.css">
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
<?php include_once __DIR__ . "/../templates/navbar.php"; ?>
    <h2 class="title--page">Carrito Compras</h2>
    
    <main>
        <div class="container">            
            <div class="cart-container">
                <div class="cart-items">
                    <div class="cart-item">
                        <div class="item-image">
                            <img src="/assets/img/product/espresso.jpg" alt="Espresso">
                        </div>
                        <div class="item-details">
                            <div class="item-header">
                                <div class="item-title">
                                    <h3>Expresso</h3>
                                    <p class="item-size">Chico</p>
                                </div>
                                <p class="item-price">$35.00</p>
                            </div>
                            <p class="item-description">
                                Café intenso y aromático con una crema dorada en la superficie
                            </p>
                            <div class="item-actions">
                                <div class="quantity-control">
                                    <button class="quantity-btn minus">
                                        <svg width="14" height="2" viewBox="0 0 14 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1H13" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </button>
                                    <span class="quantity">1</span>
                                    <button class="quantity-btn plus">
                                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M7 1V13" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M1 7H13" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </button>
                                </div>
                                <button class="delete-btn">Eliminar</button>
                            </div>
                        </div>
                    </div>
                    <!-- Card item -->
                    <div class="cart-item">
                        <div class="item-image">
                            <img src="/assets/img/product/capuccino.jpg" alt="Cappuccino">
                        </div>
                        <div class="item-details">
                            <div class="item-header">
                                <div class="item-title">
                                    <h3>Cappuchino</h3>
                                    <p class="item-size">Mediano</p>
                                </div>
                                <p class="item-price">$50.00</p>
                            </div>
                            <p class="item-description">
                                Café intenso y aromático con una crema dorada en la superficie
                            </p>
                            <div class="item-actions">
                                <div class="quantity-control">
                                    <button class="quantity-btn minus">
                                        <svg width="14" height="2" viewBox="0 0 14 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1H13" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </button>
                                    <span class="quantity">1</span>
                                    <button class="quantity-btn plus">
                                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M7 1V13" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M1 7H13" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </button>
                                </div>
                                <button class="delete-btn">Eliminar</button>
                            </div>
                        </div>
                    </div>                    
                    <div class="cart-item">
                        <div class="item-image">
                            <img src="/assets/img/product/chocolate-helado.jpg" alt="Chocolate Helado">
                        </div>
                        <div class="item-details">
                            <div class="item-header">
                                <div class="item-title">
                                    <h3>Chocolate Helado</h3>
                                    <p class="item-size">Grande</p>
                                </div>
                                <p class="item-price">$40.00</p>
                            </div>
                            <p class="item-description">
                                Cafe Helado de la mas alta calidad
                            </p>
                            <div class="item-actions">
                                <div class="quantity-control">
                                    <button class="quantity-btn minus">
                                        <svg width="14" height="2" viewBox="0 0 14 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1H13" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </button>
                                    <span class="quantity">99</span>
                                    <button class="quantity-btn plus">
                                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M7 1V13" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M1 7H13" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </button>
                                </div>
                                <button class="delete-btn">Eliminar</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="order-summary">
                    <h2>Total de la compra</h2>
                    <div class="total-price">$125.00</div>
                    <button class="buy-btn">Comprar</button>
                </div>
            </div>
        </div>
    </main>
    
    <?php include_once __DIR__ . "/../templates/footer.php"; ?>   
    <script type="module" src="/assets/js/-cookies-carrito.js"></script>
    <script type="module" src="/assets/js/carrito.js"></script>     
</body>
</html>