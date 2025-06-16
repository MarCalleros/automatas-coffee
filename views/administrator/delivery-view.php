<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="shortcut icon" href="/assets/img/logo-coffee.png">
    <title>Pedidos</title>
</head>
<body>
<div class="admin-panel">
        <?php include_once __DIR__ . "/../templates/sidebar.php"; ?>
        
        <main class="admin">
            <h2 class="admin__title">VER PEDIDO</h2>

            <div class="admin-form__container">
                <form action="/admin/message/view" id="admin-message-form" class="admin-form" method="POST">
                    <!--<input type="hidden" name="id_mensaje" id="id_mensaje" value="<?php echo $mensaje[0]->id; ?>">     -->

                    <div class="admin-form__group-container">
                        <div class="admin-form__group">
                            <label class="admin-form__label" for="nombre">Nombre</label>
                            <input class="admin-form__input" type="text" name="nombre" id="nombre" value="<?php echo $delivery[0]->usuario->nombre ?>" disabled>
                            <span class="admin-form__error">Error</span>
                        </div>

                        <div class="admin-form__group">
                            <label class="admin-form__label" for="usuario">Usuario</label>
                            <input class="admin-form__input" type="text" name="usuario" id="usuario" value="<?php echo $delivery[0]->usuario->usuario ?>" disabled>
                            <span class="admin-form__error">Error</span>
                        </div>
                    </div>

                    <div class="admin-form__group-container">
                        <div class="admin-form__group">
                            <label class="admin-form__label" for="fecha">Fecha de Envio</label>
                            <input class="admin-form__input" type="text" name="fecha" id="fecha" value="<?php echo $delivery[0]->fecha ?>" disabled>
                            <span class="admin-form__error">Error</span>
                        </div>

                        <div class="admin-form__group">
                            <label class="admin-form__label" for="identificador">Numero de Mensaje</label>
                            <input class="admin-form__input" type="text" name="identificador" id="identificador" value="<?php echo $delivery[0]->identificador ?>" disabled>
                            <span class="admin-form__error">Error</span>
                        </div>
                    </div>

                    <div class="admin-form__group-container">
                        <div class="admin-form__group">
                            <label class="admin-form__label" for="contenido">Detalle del Pedido</label>

                            <?php foreach ($delivery[0]->detalle as $detail) : ?>
                                <div class="information-purchase information-purchase--separator-down">
                                    <div>
                                        <img class="information-purchase__image" <?php echo "src='/assets/img/product/" . $detail->producto['ruta'] . ".jpg'" ?> alt="Imagen del producto">
                                    </div>
                                    <div class="information-purchase__content">
                                        <strong class="information-purchase__text"><?php echo $detail->producto['nombre'] ?></strong>
                                        <strong class="information-purchase__text"><?php echo $detail->tamaño->nombre ?></strong>
                                        <p class="information-purchase__text"><?php echo $detail->producto['descripcion'] ?></p>

                                        <p class="information-purchase__text"><strong>Cantidad: </strong><?php echo $detail->cantidad ?></p>
                                        <div class="information-purchase__price">
                                            <p class="information-purchase__text"><strong>P. Unitario: </strong>$<?php echo $detail->precio_unitario ?></p>
                                        </div>

                                        <div class="information-purchase__total">
                                            <p class="information-purchase__text"><strong>Subtotal: </strong>$<?php echo $detail->subtotal ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="admin-form__buttons-container">
                        <a href="/admin/delivery"><button class="admin-form__button admin-form__button--return" type="button">Regresar</button></a>
                        <div class="admin-form__buttons-action">
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script src="/assets/js/navbar.js"></script>
    <script type="module" src="/assets/js/admin.js"></script>
</body>
</html>