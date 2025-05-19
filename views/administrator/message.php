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
            <h2 class="admin__title">MENSAJES</h2>

            <div class="admin__content">
                <div class="admin__table-container">
                    <table class="admin__table">
                        <thead class="admin-table__header">
                            <tr class="admin-table__row">
                                <th class="admin-table__head">ID</th>
                                <th class="admin-table__head">Nro. Mensaje</th>
                                <th class="admin-table__head">Msj. Original</th>
                                <th class="admin-table__head">Nombre</th>
                                <th class="admin-table__head">Usuario</th>
                                <th class="admin-table__head">Fecha Envio</th>
                                <th class="admin-table__head">Leido</th>
                                <th class="admin-table__head">Respondido</th>
                                <th class="admin-table__head">Tipo</th>
                                <th class="admin-table__head">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="admin-table__body">
                            <?php foreach ($mensajes as $mensaje) : ?>
                                <tr class="admin-table__row admin-table__row--data">
                                    <td class="admin-table__data"><?= $mensaje->id ?></td>
                                    <td class="admin-table__data"><?= $mensaje->identificador ?></td>
                                    <td class="admin-table__data"><?= $mensaje->identificador_mensaje ?></td>
                                    <td class="admin-table__data"><?= $mensaje->usuario->nombre ?></td>
                                    <td class="admin-table__data"><?= $mensaje->usuario->usuario ?></td>
                                    <td class="admin-table__data"><?= $mensaje->fecha ?></td>
                                    <td class="admin-table__data">
                                        <div class="<?= $mensaje->leido ? 'admin-table__data--active' : 'admin-table__data--inactive' ?>">
                                            <?= $mensaje->leido ? 'Leído' : 'No Leído' ?>
                                        </div>
                                    </td>
                                    <td class="admin-table__data">
                                        <div class="<?= $mensaje->respondido ? 'admin-table__data--active' : 'admin-table__data--inactive' ?>">
                                            <?= $mensaje->respondido ? 'Respondido' : 'No Respondido' ?>
                                        </div>
                                    </td>
                                    <td class="admin-table__data">
                                        <div class="<?= $mensaje->id_mensaje ? 'admin-table__data--Respuesta' : 'admin-table__data--Mensaje' ?>">
                                            <?= $mensaje->id_mensaje ? 'Respuesta' : 'Mensaje' ?>
                                        </div>
                                    </td>
                                    <td class="admin-table__data">
                                        <div class="admin-table__actions">
                                            <a href="<?php echo '/admin/message/view?id=' . $mensaje->id ?>"><button type="button" class="admin-table__action admin-table__action--edit">Ver</button></a>
                                            <form class="admin-message-status-form" data-id="<?= $mensaje->id ?>" data-leido="<?= $mensaje->leido ?>">
                                                <button type="button" class="admin-table__action admin-table__action--delete">
                                                    <?= $mensaje->leido ? 'Marcar como no Leído' : 'Marcar como Leído' ?>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script src="/assets/js/navbar.js"></script>
    <script type="module" src="/assets/js/admin.js"></script>
</body>
</html>