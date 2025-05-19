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
            <h2 class="admin__title">Gestion de empleados</h2>

            <div class="admin__content">
                <div class="admin__table-container">
                    <table class="admin__table">
                        <thead class="admin-table__header">
                            <tr class="admin-table__row">
                                <th class="admin-table__head">ID</th>
                                <th class="admin-table__head">Nombre</th>
                                <th class="admin-table__head">Edad</th>
                                <th class="admin-table__head">Email</th>
                                <th class="admin-table__head">Usuario</th>
                                <th class="admin-table__head">T. de Usuario</th>
                                <th class="admin-table__head">Estatus</th>
                                <th class="admin-table__head">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="admin-table__body">
                            <?php foreach ($Usuario as $usuario) : ?>
                                <tr class="admin-table__row admin-table__row--data">
                                    <td class="admin-table__data"><?= $usuario->id ?></td>
                                    <td class="admin-table__data"><?= $usuario->nombre ?></td>
                                    <td class="admin-table__data"><?= $usuario->edad ?></td>
                                    <td class="admin-table__data"><?= $usuario->correo ?></td>
                                    <td class="admin-table__data"><?= $usuario->usuario ?></td>
                                    <td class="admin-table__data">
                                        <div class="admin-table__data--<?php echo $usuario->tipo_usuario ?>">
                                            <?= $usuario->tipo_usuario ?>
                                        </div>
                                    </td>
                                    <td class="admin-table__data">
                                        <div class="<?= $usuario->estatus ? 'admin-table__data--active' : 'admin-table__data--inactive' ?>">
                                            <?= $usuario->estatus ? 'Alta' : 'Baja' ?>
                                        </div>
                                    </td>
                                    <td class="admin-table__data">
                                        <div class="admin-table__actions">
                                            <a href="<?php echo '/admin/usuario/edit?id=' . $usuario->id ?>"><button type="button" class="admin-table__action admin-table__action--edit">Editar</button></a>
                                            <form class="admin-user-status-form" data-id="<?= $usuario->id ?>" data-estatus="<?= $usuario->estatus ?>">
                                                <button type="button" class="admin-table__action admin-table__action--delete">
                                                    <?= $usuario->estatus ? 'Dar de Baja' : 'Dar de Alta' ?>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="admin__actions">
                    <a href="/admin/usuario/create"><button type="button" class="admin__button">Agregar usuario</button></a>
                </div>
            </div>
        </main>
    </div>

    <script src="/assets/js/navbar.js"></script>
    <script type="module" src="/assets/js/admin.js"></script>
</body>
</html>