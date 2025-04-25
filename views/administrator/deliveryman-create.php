<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="shortcut icon" href="/assets/img/logo-coffee.png">
    <title>Repartidores</title>
</head>
<body>
<div class="admin-panel">
        <?php include_once __DIR__ . "/../templates/sidebar.php"; ?>
        
        <main class="admin">
            <h2 class="admin__title">AGREGAR REPARTIDOR</h2>

            <div class="admin-form__container">
                <form action="/admin/deliveryman/create" id="admin-form" class="admin-form" method="POST">
                    <div class="admin-form__group">
                        <label class="admin-form__label" for="nombre">Nombre(s)</label>
                        <input class="admin-form__input" type="text" name="nombre" id="nombre" placeholder="Nombre(s)">
                        <span id="error-nombre" class="admin-form__error">Error</span>
                    </div>

                    <div class="admin-form__group-container">
                        <div class="admin-form__group">
                            <label class="admin-form__label" for="apellido1">Apellido Paterno</label>
                            <input class="admin-form__input" type="text" name="apellido1" id="apellido1" placeholder="Apellido Paterno">
                            <span id="error-apellido1" class="admin-form__error">Error</span>
                        </div>

                        <div class="admin-form__group">
                            <label class="admin-form__label" for="apellido2">Apellido Materno</label>
                            <input class="admin-form__input" type="text" name="apellido2" id="apellido2" placeholder="Apellido Materno">
                            <span id="error-apellido2" class="admin-form__error">Error</span>
                        </div>
                    </div>

                    <div class="admin-form__group-container">
                        <div class="admin-form__group">
                            <label class="admin-form__label" for="telefono">Telefono</label>
                            <input class="admin-form__input" type="text" name="telefono" id="telefono" placeholder="Telefono">
                            <span id="error-telefono" class="admin-form__error">Error</span>
                        </div>

                        <div class="admin-form__group">
                            <label class="admin-form__label" for="curp">CURP</label>
                            <input class="admin-form__input" type="text" name="curp" id="curp" placeholder="CURP">
                            <span id="error-curp" class="admin-form__error">Error</span>
                        </div>
                    </div>

                    <div class="admin-form__group-container">
                        <div class="admin-form__group">
                            <label class="admin-form__label" for="rfc">RFC</label>
                            <input class="admin-form__input" type="text" name="rfc" id="rfc" placeholder="RFC">
                            <span id="error-rfc" class="admin-form__error">Error</span>
                        </div>

                        <div class="admin-form__group">
                            <label class="admin-form__label" for="nss">NSS</label>
                            <input class="admin-form__input" type="text" name="nss" id="nss" placeholder="NSS">
                            <span id="error-nss" class="admin-form__error">Error</span>
                        </div>
                    </div>

                    <div class="admin-form__group-container">
                        <div class="admin-form__group">
                            <label class="admin-form__label" for="tipo_sangre">Tipo de Sangre</label>
                            <div class="admin-form__select-container">
                                <select class="admin-form__input" name="tipo_sangre" id="tipo_sangre">
                                    <option value="" disabled selected>Seleccione un tipo de sangre</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                </select>
                            </div>
                            <span id="error-tipo-sangre" class="admin-form__error">Error</span>
                        </div>

                        <div class="admin-form__group">
                            <label class="admin-form__label" for="vigencia">Fecha de Vigencia de Licencia</label>
                            <input class="admin-form__input" type="date" name="vigencia" id="vigencia" placeholder="Fecha de Vigencia de Licencia" min="<?php echo date('Y-m-d'); ?>">
                            <span id="error-vigencia" class="admin-form__error">Error</span>
                        </div>
                    </div>

                    <div class="admin-form__buttons-container">
                        <a href="/admin/deliveryman"><button class="admin-form__button admin-form__button--return" type="button">Regresar</button></a>
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