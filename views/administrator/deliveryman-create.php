<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/styles.css">
    <title>Repartidores</title>
</head>
<body>
<div class="admin-panel">
        <?php include_once __DIR__ . "/../templates/sidebar.php"; ?>
        
        <main class="admin">
            <h2 class="admin__title">AGREGAR REPARTIDOR</h2>

            <div class="admin-form__container">
                <form action="" class="admin-form" method="POST">
                    <div class="admin-form__group">
                        <label class="admin-form__label" for="">Nombre(s)</label>
                        <input class="admin-form__input" type="text" name="nombre" id="" placeholder="Nombre(s)">
                        <span class="admin-form__error">El nombre solo debe de contener letras y espacios</span>
                    </div>

                    <div class="admin-form__group-container">
                        <div class="admin-form__group">
                            <label class="admin-form__label" for="">Apellido Paterno</label>
                            <input class="admin-form__input" type="text" name="nombre" id="" placeholder="Apellido Paterno">
                            <span class="admin-form__error">El apellido solo debe de contener letras y espacios</span>
                        </div>

                        <div class="admin-form__group">
                            <label class="admin-form__label" for="">Apellido Materno</label>
                            <input class="admin-form__input" type="text" name="nombre" id="" placeholder="Apellido Materno">
                            <span class="admin-form__error">El apellido solo debe de contener letras y espacios</span>
                        </div>
                    </div>

                    <div class="admin-form__group-container">
                        <div class="admin-form__group">
                            <label class="admin-form__label" for="">Telefono</label>
                            <input class="admin-form__input" type="text" name="nombre" id="" placeholder="Telefono">
                            <span class="admin-form__error">El telefono debe de ser de 10 digitos</span>
                        </div>

                        <div class="admin-form__group">
                            <label class="admin-form__label" for="">CURP</label>
                            <input class="admin-form__input" type="text" name="nombre" id="" placeholder="CURP">
                            <span class="admin-form__error">La CURP debe de ser de 18 caracteres alfanumericos</span>
                        </div>
                    </div>

                    <div class="admin-form__group-container">
                        <div class="admin-form__group">
                            <label class="admin-form__label" for="">RFC</label>
                            <input class="admin-form__input" type="text" name="nombre" id="" placeholder="RFC">
                            <span class="admin-form__error">El RFC debe de ser de 13 caracteres alfanumericos</span>
                        </div>

                        <div class="admin-form__group">
                            <label class="admin-form__label" for="">NSS</label>
                            <input class="admin-form__input" type="text" name="nombre" id="" placeholder="NSS">
                            <span class="admin-form__error">El RFC debe de ser de 11 caracteres alfanumericos</span>
                        </div>
                    </div>

                    <div class="admin-form__group-container">
                        <div class="admin-form__group">
                            <label class="admin-form__label" for="">Tipo de Sangre</label>
                            <input class="admin-form__input" type="text" name="nombre" id="" placeholder="Tipo de Sangre">
                            <span class="admin-form__error">El tipo de sangre no puede ser mayor a 3 caracteres</span>
                        </div>

                        <div class="admin-form__group">
                            <label class="admin-form__label" for="">Fecha de Vigencia de Licencia</label>
                            <input class="admin-form__input" type="date" name="nombre" id="" placeholder="Fecha de Vigencia de Licencia">
                            <span class="admin-form__error">Seleccione una fecha valida</span>
                        </div>
                    </div>

                    <div class="admin-form__buttons-container">
                        <a href="/admin/deliveryman"><button class="admin-form__button admin-form__button--return" type="button">Regresar</button></a>
                        <div class="admin-form__buttons-action">
                            <button class="admin-form__button admin-form__button--cancel" type="reset">Resetear</button>
                            <button class="admin-form__button admin-form__button--submit" type="submit">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script src="/assets/js/navbar.js"></script>
</body>
</html>