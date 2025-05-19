<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="shortcut icon" href="/assets/img/logo-coffee.png">
    <title>Mensajes</title>
</head>
<body>
<div class="admin-panel">
        <?php include_once __DIR__ . "/../templates/sidebar.php"; ?>
        
        <main class="admin">
            <h2 class="admin__title">VER MENSAJE</h2>

            <div class="admin-form__container">
                <form action="/admin/message/view" id="admin-message-form" class="admin-form" method="POST">
                    <input type="hidden" name="id_mensaje" id="id_mensaje" value="<?php echo $mensaje[0]->id; ?>">

                    <div class="admin-form__group-container">
                        <div class="admin-form__group">
                            <label class="admin-form__label" for="nombre">Nombre</label>
                            <input class="admin-form__input" type="text" name="nombre" id="nombre" value="<?php echo $mensaje[0]->usuario->nombre ?>" disabled>
                            <span class="admin-form__error">Error</span>
                        </div>

                        <div class="admin-form__group">
                            <label class="admin-form__label" for="usuario">Usuario</label>
                            <input class="admin-form__input" type="text" name="usuario" id="usuario" value="<?php echo $mensaje[0]->usuario->usuario ?>" disabled>
                            <span class="admin-form__error">Error</span>
                        </div>
                    </div>

                    <div class="admin-form__group-container">
                        <div class="admin-form__group">
                            <label class="admin-form__label" for="fecha">Fecha de Envio</label>
                            <input class="admin-form__input" type="text" name="fecha" id="fecha" value="<?php echo $mensaje[0]->fecha ?>" disabled>
                            <span class="admin-form__error">Error</span>
                        </div>

                        <div class="admin-form__group">
                            <label class="admin-form__label" for="identificador">Numero de Mensaje</label>
                            <input class="admin-form__input" type="text" name="identificador" id="identificador" value="<?php echo $mensaje[0]->identificador ?>" disabled>
                            <span class="admin-form__error">Error</span>
                        </div>
                    </div>

                    <div class="admin-form__group-container">
                        <div class="admin-form__group">
                            <label class="admin-form__label" for="contenido">Contenido</label>
                            <textarea class="admin-form__area" type="text" name="contenido" id="contenido" disabled><?php echo $mensaje[0]->contenido ?></textarea>
                            <span class="admin-form__error">Error</span>
                        </div>
                    </div>

                    <div class="admin-form__group-container">
                        <div class="admin-form__group">
                            <label class="admin-form__label" for="respuesta">Respuesta</label>
                            <textarea class="admin-form__area" type="text" name="respuesta" id="respuesta"></textarea>
                            <span id="error-respuesta" class="admin-form__error">Error</span>
                        </div>
                    </div>

                    <div class="admin-form__buttons-container">
                        <a href="/admin/message"><button class="admin-form__button admin-form__button--return" type="button">Regresar</button></a>
                        <div class="admin-form__buttons-action">
                            <button id="admin-reset-button" class="admin-form__button admin-form__button--cancel" type="reset">Resetear</button>
                            <button id="admin-submit-button" class="admin-form__button admin-form__button--submit" type="submit">Responder</button>
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