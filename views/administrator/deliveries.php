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
            <h2 class="admin__title">PEDIDOS</h2>

            <div class="admin__content">
                <div class="admin__table-container">
                    <table class="admin__table">
                        <thead class="admin-table__header">
                            <tr class="admin-table__row">
                                <th class="admin-table__head">ID</th>
                                <th class="admin-table__head">Nro. Pedido</th>
                                <th class="admin-table__head">Nombre</th>
                                <th class="admin-table__head">Usuario</th>
                                <th class="admin-table__head">Fecha Pedido</th>
                                <th class="admin-table__head">Total</th>
                                <th class="admin-table__head">Estatus</th>
                                <th class="admin-table__head">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="admin-table__body">
                            <?php foreach ($deliveries as $delivery) : ?>
                                <tr class="admin-table__row admin-table__row--data">
                                    <td class="admin-table__data"><?= $delivery->id ?></td>
                                    <td class="admin-table__data"><?= $delivery->identificador ?></td>
                                    <td class="admin-table__data"><?= $delivery->usuario->nombre ?></td>
                                    <td class="admin-table__data"><?= $delivery->usuario->usuario ?></td>
                                    <td class="admin-table__data"><?= $delivery->fecha ?></td>
                                    <td class="admin-table__data">$<?= $delivery->total ?></td>
                                    <td class="admin-table__data">
                                        <div class="<?= $delivery->estatus ? 'admin-table__data--active' : 'admin-table__data--inactive' ?>">
                                            <?= $delivery->estatus ? 'Entregado' : 'Pendiente' ?>
                                        </div>
                                    </td>
                                    <td class="admin-table__data">
                                        <div class="admin-table__actions">
                                            <a href="<?php echo '/admin/delivery/view?id=' . $delivery->id ?>"><button type="button" class="admin-table__action admin-table__action--edit">Ver</button></a>
                                            <form class="admin-delivery-status-form" data-id="<?= $delivery->id ?>" data-estatus="<?= $delivery->estatus ?>">
                                                <button type="button" class="admin-table__action admin-table__action--delete">
                                                    <?= $delivery->estatus ? 'Cancelar Pedido' : 'Reactivar Pedido' ?>
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