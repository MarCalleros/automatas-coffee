<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/variables.css">
    <link rel="stylesheet" href="/assets/css/styles.css">
    <title>Nuestros Productos</title>
</head>
<body>
    <?php include_once __DIR__ . "/../templates/navbar.php"; ?>
    
    <h2 class="title--page">Nuestros Productos</h2>

    <div class="flex-container">
        <?php include __DIR__ . "/../components/filters-list.php"; ?>

        <div class="product-container">
            <div class="search">
                <button class="filter__button">
                    <svg class="filter-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M3 4.6C3 4.03995 3 3.75992 3.10899 3.54601C3.20487 3.35785 3.35785 3.20487 3.54601 3.10899C3.75992 3 4.03995 3 4.6 3H19.4C19.9601 3 20.2401 3 20.454 3.10899C20.6422 3.20487 20.7951 3.35785 20.891 3.54601C21 3.75992 21 4.03995 21 4.6V6.33726C21 6.58185 21 6.70414 20.9724 6.81923C20.9479 6.92127 20.9075 7.01881 20.8526 7.10828C20.7908 7.2092 20.7043 7.29568 20.5314 7.46863L14.4686 13.5314C14.2957 13.7043 14.2092 13.7908 14.1474 13.8917C14.0925 13.9812 14.0521 14.0787 14.0276 14.1808C14 14.2959 14 14.4182 14 14.6627V17L10 21V14.6627C10 14.4182 10 14.2959 9.97237 14.1808C9.94787 14.0787 9.90747 13.9812 9.85264 13.8917C9.7908 13.7908 9.70432 13.7043 9.53137 13.5314L3.46863 7.46863C3.29568 7.29568 3.2092 7.2092 3.14736 7.10828C3.09253 7.01881 3.05213 6.92127 3.02763 6.81923C3 6.70414 3 6.58185 3 6.33726V4.6Z" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> 
                        </g>
                    </svg>
                </button>

                <input type="text" class="search__input" placeholder="Buscar producto..." value="<?php echo $filters['search'] ?>">

                <button class="search__button">
                    <svg class="search-icon" fill="#ffffff" height="200px" width="200px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 490.40 490.40" xml:space="preserve" stroke="#ffffff" stroke-width="0.004904">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                        <g> <path d="M484.1,454.796l-110.5-110.6c29.8-36.3,47.6-82.8,47.6-133.4c0-116.3-94.3-210.6-210.6-210.6S0,94.496,0,210.796 s94.3,210.6,210.6,210.6c50.8,0,97.4-18,133.8-48l110.5,110.5c12.9,11.8,25,4.2,29.2,0C492.5,475.596,492.5,463.096,484.1,454.796z M41.1,210.796c0-93.6,75.9-169.5,169.5-169.5s169.6,75.9,169.6,169.5s-75.9,169.5-169.5,169.5S41.1,304.396,41.1,210.796z">
                        </path> </g> </g>
                    </svg>
                </button>

                <button class="view__button">
                    <svg class="view-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier"> 
                            <path d="M22 8.52V3.98C22 2.57 21.36 2 19.77 2H15.73C14.14 2 13.5 2.57 13.5 3.98V8.51C13.5 9.93 14.14 10.49 15.73 10.49H19.77C21.36 10.5 22 9.93 22 8.52Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> 
                            <path d="M22 19.77V15.73C22 14.14 21.36 13.5 19.77 13.5H15.73C14.14 13.5 13.5 14.14 13.5 15.73V19.77C13.5 21.36 14.14 22 15.73 22H19.77C21.36 22 22 21.36 22 19.77Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> 
                            <path d="M10.5 8.52V3.98C10.5 2.57 9.86 2 8.27 2H4.23C2.64 2 2 2.57 2 3.98V8.51C2 9.93 2.64 10.49 4.23 10.49H8.27C9.86 10.5 10.5 9.93 10.5 8.52Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> 
                            <path d="M10.5 19.77V15.73C10.5 14.14 9.86 13.5 8.27 13.5H4.23C2.64 13.5 2 14.14 2 15.73V19.77C2 21.36 2.64 22 4.23 22H8.27C9.86 22 10.5 21.36 10.5 19.77Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> 
                        </g>
                    </svg>
                </button>
            </div>

            <div class="product-list">
                
            </div>

            <div class="pagination">
                
            </div>
        </div>
    </div>

    <?php include_once __DIR__ . "/../templates/footer.php"; ?>

    <div class="background__shadow" id="background-filter"></div>

    <div class="filter-modal">
        <div class="filter-modal__content">
            <button class="modal__close" id="filter-close">
                <svg class="close-icon" width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M29.5762 0.547733C28.9254 -0.103151 27.87 -0.103151 27.2192 0.547733L15.0619 12.705L2.90463 0.547733C2.25376 -0.103151 1.19848 -0.103151 0.547611 0.547733C-0.103273 1.1986 -0.103273 2.25388 0.547611 2.90475L12.7049 15.062L0.547644 27.2192C-0.103239 27.8702 -0.103239 28.9254 0.547644 29.5764C1.19851 30.2272 2.25379 30.2272 2.90466 29.5764L15.0619 17.419L27.2192 29.5764C27.87 30.2272 28.9254 30.2272 29.5762 29.5764C30.227 28.9254 30.227 27.8702 29.5762 27.2194L17.4189 15.062L29.5762 2.90475C30.227 2.25388 30.227 1.1986 29.5762 0.547733Z" fill="black"/>
                </svg>
            </button>

            <?php include __DIR__ . "/../components/filters-list.php"; ?>
        </div>
    </div>

    <script src="/assets/js/navbar.js"></script>
    <script src="/assets/js/hamburguer.js"></script>
    <script src="/assets/js/list-view.js"></script>
    <script src="/assets/js/filter-modal.js"></script>
    <script src="/assets/js/products.js"></script>
    <script type="module" src="/assets/js/cookies-carrito.js"></script>
    <script type="module" src="/assets/js/carrito.js"></script>
    <script src="/assets/js/configuration.js"></script>
</body>
</html>