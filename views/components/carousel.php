<div class="carousel swiper">
    <div class="card-wrapper">
        <ul class="card-list swiper-wrapper">
            <?php foreach ($products as $product): ?>
                <li class="card swiper-slide">
                    <img class="card__image" src="/assets/img/product/<?php echo $product->ruta ?>.jpg" alt="Cafe Helado">

                    <div class="card__information">
                        <h3 class="card__title"><?php echo $product->nombre ?></h3>
                        <p class="card__price">$<?php echo $product->precio ?></p>
                        <p class="card__description"><?php echo $product->descripcion ?></p>
                    </div>

                    <div class="card__footer">
                        <button class="card__footer-button">Agregar al carrito</button>
                        <div class="card__footer-like">
                                <svg class="heart-icon" viewBox="0 0 24 24" width="26" height="26">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                            </svg>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>

        
    </div>
        <div class="swiper-pagination"></div>

        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
</div>