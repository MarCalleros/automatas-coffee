<?php
namespace App;
use App\Repartidor;
require __DIR__ . '/../../vendor/autoload.php';

$repartidores = Repartidor::all();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $repartidor = new Repartidor();
    
    $repartidor->id = $_POST['id'];
    $repartidor->estatus = $_POST['estatus'];

    if ($repartidor->changeStatus()) {
        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        exit;
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'error' => 'Error en la base de datos']);
        exit;
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
            <h2 class="admin__title">REPARTIDORES</h2>

            <div class="admin__content">
                <div class="admin__table-container">
                    <table class="admin__table">
                        <thead class="admin-table__header">
                            <tr class="admin-table__row">
                                <th class="admin-table__head">ID</th>
                                <th class="admin-table__head">Nombre</th>
                                <th class="admin-table__head">Teléfono</th>
                                <th class="admin-table__head">CURP</th>
                                <th class="admin-table__head">RFC</th>
                                <th class="admin-table__head">T. de Sangre</th>
                                <th class="admin-table__head">NSS</th>
                                <th class="admin-table__head">Vig. de Licencia</th>
                                <th class="admin-table__head">Repartiendo</th>
                                <th class="admin-table__head">Estatus</th>
                                <th class="admin-table__head">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="admin-table__body">
                            <?php foreach ($repartidores as $repartidor) : ?>
                                <tr class="admin-table__row admin-table__row--data">
                                    <td class="admin-table__data"><?= $repartidor->id ?></td>
                                    <td class="admin-table__data"><?= $repartidor->nombre . ' ' . $repartidor->apellido1 . ' ' . $repartidor->apellido2 ?></td>
                                    <td class="admin-table__data"><?= $repartidor->telefono ?></td>
                                    <td class="admin-table__data"><?= $repartidor->curp ?></td>
                                    <td class="admin-table__data"><?= $repartidor->rfc ?></td>
                                    <td class="admin-table__data"><?= $repartidor->tipo_sangre ?></td>
                                    <td class="admin-table__data"><?= $repartidor->nss ?></td>
                                    <td class="admin-table__data"><?= $repartidor->vigencia_licencia ?></td>
                                    <td class="admin-table__data">
                                        <div class="<?= $repartidor->estatus_repartiendo ? 'admin-table__data--active' : 'admin-table__data--inactive' ?>">
                                            <?= $repartidor->estatus_repartiendo ? 'Activo' : 'Inactivo' ?>
                                        </div>
                                    </td>
                                    <td class="admin-table__data">
                                        <div class="<?= $repartidor->estatus ? 'admin-table__data--active' : 'admin-table__data--inactive' ?>">
                                            <?= $repartidor->estatus ? 'Alta' : 'Baja' ?>
                                        </div>
                                    </td>
                                    <td class="admin-table__data">
                                        <div class="admin-table__actions">
                                            <a href="/admin/deliveryman/edit"><button type="button" class="admin-table__action admin-table__action--edit">Editar</button></a>
                                            <form class="admin-deliveryman-status-form" data-id="<?= $repartidor->id ?>" data-estatus="<?= $repartidor->estatus ?>">
                                                <button type="button" class="admin-table__action admin-table__action--delete">
                                                    <?= $repartidor->estatus ? 'Dar de Baja' : 'Dar de Alta' ?>
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
                    <a href="/admin/deliveryman/create"><button type="button" class="admin__button">Agregar Repartidor</button></a>
                </div>
            </div>
        </main>
    </div>

    <script src="/assets/js/navbar.js"></script>
    <script type="module" src="/assets/js/admin.js"></script>
</body>
</html>