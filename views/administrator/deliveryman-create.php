<?php
namespace App;
use App\Repartidor;
require __DIR__ . '/../../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $repartidor = new Repartidor();
    
    $repartidor->nombre = $_POST['nombre'];
    $repartidor->apellido1 = $_POST['apellido1'];
    $repartidor->apellido2 = $_POST['apellido2'];
    $repartidor->telefono = $_POST['telefono'];
    $repartidor->curp = $_POST['curp'];
    $repartidor->rfc = $_POST['rfc'];
    $repartidor->tipo_sangre = $_POST['tipo_sangre'];
    $repartidor->nss = $_POST['nss'];
    $repartidor->vigencia_licencia = $_POST['vigencia'];

    if ($repartidor->save()) {
        //header('Location: /admin/deliveryman');
        //exit;
    }
}
?>

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
                <form action="/admin/deliveryman/create" class="admin-form" method="POST">
                    <div class="admin-form__group">
                        <label class="admin-form__label" for="nombre">Nombre(s)</label>
                        <input class="admin-form__input" type="text" name="nombre" id="" placeholder="Nombre(s)">
                        <span class="admin-form__error">El nombre solo debe de contener letras y espacios</span>
                    </div>

                    <div class="admin-form__group-container">
                        <div class="admin-form__group">
                            <label class="admin-form__label" for="apellido1">Apellido Paterno</label>
                            <input class="admin-form__input" type="text" name="apellido1" id="" placeholder="Apellido Paterno">
                            <span class="admin-form__error">El apellido solo debe de contener letras y espacios</span>
                        </div>

                        <div class="admin-form__group">
                            <label class="admin-form__label" for="apellido2">Apellido Materno</label>
                            <input class="admin-form__input" type="text" name="apellido2" id="" placeholder="Apellido Materno">
                            <span class="admin-form__error">El apellido solo debe de contener letras y espacios</span>
                        </div>
                    </div>

                    <div class="admin-form__group-container">
                        <div class="admin-form__group">
                            <label class="admin-form__label" for="telefono">Telefono</label>
                            <input class="admin-form__input" type="text" name="telefono" id="" placeholder="Telefono">
                            <span class="admin-form__error">El telefono debe de ser de 10 digitos</span>
                        </div>

                        <div class="admin-form__group">
                            <label class="admin-form__label" for="curp">CURP</label>
                            <input class="admin-form__input" type="text" name="curp" id="" placeholder="CURP">
                            <span class="admin-form__error">La CURP debe de ser de 18 caracteres alfanumericos</span>
                        </div>
                    </div>

                    <div class="admin-form__group-container">
                        <div class="admin-form__group">
                            <label class="admin-form__label" for="rfc">RFC</label>
                            <input class="admin-form__input" type="text" name="rfc" id="" placeholder="RFC">
                            <span class="admin-form__error">El RFC debe de ser de 13 caracteres alfanumericos</span>
                        </div>

                        <div class="admin-form__group">
                            <label class="admin-form__label" for="nss">NSS</label>
                            <input class="admin-form__input" type="text" name="nss" id="" placeholder="NSS">
                            <span class="admin-form__error">El RFC debe de ser de 11 caracteres alfanumericos</span>
                        </div>
                    </div>

                    <div class="admin-form__group-container">
                        <div class="admin-form__group">
                            <label class="admin-form__label" for="tipo_sangre">Tipo de Sangre</label>
                            <input class="admin-form__input" type="text" name="tipo_sangre" id="" placeholder="Tipo de Sangre">
                            <span class="admin-form__error">El tipo de sangre no puede ser mayor a 3 caracteres</span>
                        </div>

                        <div class="admin-form__group">
                            <label class="admin-form__label" for="vigencia">Fecha de Vigencia de Licencia</label>
                            <input class="admin-form__input" type="date" name="vigencia" id="" placeholder="Fecha de Vigencia de Licencia">
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