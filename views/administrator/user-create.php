<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="shortcut icon" href="/assets/img/logo-coffee.png">
    <title>Usuarios</title>
</head>
<body>
<div class="admin-panel">
        <?php include_once __DIR__ . "/../templates/sidebar.php"; ?>
        
        <main class="admin">
            <h2 class="admin__title">AGREGAR USUARIO</h2>

            <div class="admin-form__container">
                <form action="/admin/usuario/create" id="admin-user-form" class="admin-form" method="POST">

                    <div class="admin-form__group-container">
                        <div class="admin-form__group">
                            <label class="admin-form__label" for="nombre">Nombre</label>
                            <input class="admin-form__input" type="text" name="nombre" id="nombre" placeholder="Nombre">
                            <span id="error-nombre" class="admin-form__error">Error</span>
                        </div>

                        <div class="admin-form__group">
                            <label class="admin-form__label" for="edad">Edad</label>
                            <input class="admin-form__input" type="text" name="edad" id="edad" placeholder="Edad">
                            <span id="error-edad" class="admin-form__error">Error</span>
                        </div>
                    </div>

                    <div class="admin-form__group-container">
                        <div class="admin-form__group">
                            <label class="admin-form__label" for="email">Email</label>
                            <input class="admin-form__input" type="email" name="correo" id="email" placeholder="Email">
                            <span id="error-email" class="admin-form__error">Error</span>
                        </div>

                        <div class="admin-form__group">
                            <label class="admin-form__label" for="usuario">Usuario</label>
                            <input class="admin-form__input" type="text" name="usuario" id="usuario" placeholder="Usuario">
                            <span id="error-usuario" class="admin-form__error">Error</span>
                        </div>
                    </div>

                    <div class="admin-form__group-container">
                        <div class="admin-form__group">
                            <label class="admin-form__label" for="password">Password</label>
                            <input class="admin-form__input" type="text" name="contraseña" id="password" placeholder="Password">
                            <span id="error-password" class="admin-form__error">Error</span>
                        </div>
                    </div>

                    <div class="admin-form__buttons-container">
                        <a href="/admin/usuario"><button class="admin-form__button admin-form__button--return" type="button">Regresar</button></a>
                        <div class="admin-form__buttons-action">
                            <button id="admin-reset-button" class="admin-form__button admin-form__button--cancel" type="reset">Resetear</button>
                            <button id="admin-submit-button" class="admin-form__button admin-form__button--submit" type="submit">Guardar</button>
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