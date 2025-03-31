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
                        <th class="admin-table__head">Estatus</th>
                        <th class="admin-table__head">Acciones</th>
                    </tr>
                </thead>
                <tbody class="admin-table__body">
                    <tr class="admin-table__row admin-table__row--data">
                        <td class="admin-table__data">1</td>
                        <td class="admin-table__data">Martin Calleros Camarillo</td>
                        <td class="admin-table__data">6682451652</td>
                        <td class="admin-table__data">CACM041110HSLLMRA5</td>
                        <td class="admin-table__data">CACM041110HD7</td>
                        <td class="admin-table__data">O+</td>
                        <td class="admin-table__data">91806082491</td>
                        <td class="admin-table__data">12/10/2030</td>
                        <td class="admin-table__data">
                            <div class="admin-table__data--active">
                                Activo
                            </div>
                        </td>
                        <td class="admin-table__data">
                            <div class="admin-table__actions">
                                <a class="admin-table__action admin-table__action--edit" href="/admin/deliveryman/edit/">Editar</a>
                                <a class="admin-table__action admin-table__action--delete" href="/admin/deliveryman/delete/">Eliminar</a>
                            </div>
                        </td>
                    </tr>

                    <tr class="admin-table__row admin-table__row--data">
                        <td class="admin-table__data">1</td>
                        <td class="admin-table__data">Martin Calleros Camarillo</td>
                        <td class="admin-table__data">6682451652</td>
                        <td class="admin-table__data">CACM041110HSLLMRA5</td>
                        <td class="admin-table__data">CACM041110HD7</td>
                        <td class="admin-table__data">O+</td>
                        <td class="admin-table__data">91806082491</td>
                        <td class="admin-table__data">12/10/2030</td>
                        <td class="admin-table__data">
                            <div class="admin-table__data--active">
                                Activo
                            </div>
                        </td>
                        <td class="admin-table__data">
                            <div class="admin-table__actions">
                                <a class="admin-table__action admin-table__action--edit" href="/admin/deliveryman/edit/">Editar</a>
                                <a class="admin-table__action admin-table__action--delete" href="/admin/deliveryman/delete/">Eliminar</a>
                            </div>
                        </td>
                    </tr>

                    <tr class="admin-table__row admin-table__row--data">
                        <td class="admin-table__data">1</td>
                        <td class="admin-table__data">Martin Calleros Camarillo</td>
                        <td class="admin-table__data">6682451652</td>
                        <td class="admin-table__data">CACM041110HSLLMRA5</td>
                        <td class="admin-table__data">CACM041110HD7</td>
                        <td class="admin-table__data">O+</td>
                        <td class="admin-table__data">91806082491</td>
                        <td class="admin-table__data">12/10/2030</td>
                        <td class="admin-table__data">
                            <div class="admin-table__data--inactive">
                                Inactivo
                            </div>
                        </td>
                        <td class="admin-table__data">
                            <div class="admin-table__actions">
                                <a class="admin-table__action admin-table__action--edit" href="/admin/deliveryman/edit/">Editar</a>
                                <a class="admin-table__action admin-table__action--delete" href="/admin/deliveryman/delete/">Eliminar</a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </main>
    </div>

    <script src="/assets/js/navbar.js"></script>
</body>
</html>