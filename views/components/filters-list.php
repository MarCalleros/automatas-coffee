<div class="filter-container">
    <h3 class="filter__title">Filtros</h3>
    <div class="filter-container__list">
        <ul class="filter__list">
            <li class="filter__item">
                <input type="checkbox" id="filter-like" name="filter-like" <?php if ($filters["liked"] == 1) echo "checked" ?>>
                <label for="filter-like"></label>
                <span class="filter__description">Favoritos</span>
            </li>
        </ul>
    </div>

    <h3 class="filter__title">Categoria</h3>
    <div>
        <ul>
            <li class="filter__item">
                <input class="filter__input--category" data-filter="1" type="checkbox" id="filter-category-1" name="filter-category-1" <?php if (in_array(1, $filters['category'] ?? [])) echo "checked" ?>>
                <label for="filter-category-1"></label>
                <span class="filter__description">Café Caliente</span>
            </li>
            <li class="filter__item">
                <input class="filter__input--category" data-filter="2" type="checkbox" id="filter-category-2" name="filter-category-2" <?php if (in_array(2, $filters['category'] ?? [])) echo "checked" ?>>
                <label for="filter-category-2"></label>
                <span class="filter__description">Café Frio</span>
            </li>
            <li class="filter__item">
                <input class="filter__input--category" data-filter="3" type="checkbox" id="filter-category-3" name="filter-category-3" <?php if (in_array(3, $filters['category'] ?? [])) echo "checked" ?>>
                <label for="filter-category-3"></label>
                <span class="filter__description">Frapuccino</span>
            </li>
            <li class="filter__item">
                <input class="filter__input--category" data-filter="4" type="checkbox" id="filter-category-4" name="filter-category-4" <?php if (in_array(4, $filters['category'] ?? [])) echo "checked" ?>>
                <label for="filter-category-4"></label>
                <span class="filter__description">Postre</span>
            </li>
        </ul>
    </div>

    <h3 class="filter__title">Tamaño</h3>
    <div>
        <ul>
            <li class="filter__item">
                <input class="filter__input--size" data-filter="1" type="checkbox" id="filter-size-1" name="filter-size-1" <?php if (in_array(1, $filters['size'] ?? [])) echo "checked" ?>>
                <label for="filter-size-1"></label>
                <span class="filter__description">Chico</span>
            </li>
            <li class="filter__item">
                <input class="filter__input--size" data-filter="2" type="checkbox" id="filter-size-2" name="filter-size-2" <?php if (in_array(2, $filters['size'] ?? [])) echo "checked" ?>>
                <label for="filter-size-2"></label>
                <span class="filter__description">Mediano</span>
            </li>
            <li class="filter__item">
                <input class="filter__input--size" data-filter="3" type="checkbox" id="filter-size-3" name="filter-size-3" <?php if (in_array(3, $filters['size'] ?? [])) echo "checked" ?>>
                <label for="filter-size-3"></label>
                <span class="filter__description">Grande</span>
            </li>
        </ul>
    </div>

    <h3 class="filter__title">Precio</h3>
    <div>
        <ul>
            <li class="filter__item">
                <input class="filter__input--price" data-filter="1" type="checkbox" id="filter-price-1" name="filter-price-1" <?php if ($filters["price"] == 1) echo "checked" ?>>
                <label for="filter-price-1"></label>
                <span class="filter__description">Ascendente</span>
            </li>
            <li class="filter__item">
                <input class="filter__input--price" data-filter="2" type="checkbox" id="filter-price-2" name="filter-price-2" <?php if ($filters["price"] == 2) echo "checked" ?>>
                <label for="filter-price-2"></label>
                <span class="filter__description">Descendente</span>
            </li>
        </ul>
    </div>

    <div class="filter__buttons">
        <button type="button" class="filter__button--primary" id="filter-apply">Aplicar Filtros</button>
        <button type="button" class="filter__button--primary" id="filter-reset">Reiniciar Filtros</button>
    </div>
</div>