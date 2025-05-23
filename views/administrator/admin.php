<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="shortcut icon" href="/assets/img/logo-coffee.png">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Admin</title>
</head>
<body>
    <div class="admin-panel">
        <?php include_once __DIR__ . "/../templates/sidebar.php"; ?>
        
        <main class="admin">
            <section class="admin__grid">
                <div class="admin__content admin__content--welcome">
                    <div class="admin__welcome">
                        <img class="admin-welcome__image" src="/assets/img/icon-coffee.png" alt="cafecito">

                        <div class="admin-content__header">
                            <p class="admin-content__subtitle">¡Bienveido de vuelta!</p>
                            <h3 class="admin-content__title"><?php echo $_SESSION['nombre'] ?></h3>
                        </div>
                    </div>

                    <div class="admin__goals">
                        <div class="admin-goals__goal">
                            <div class="admin-content__header">
                                <h3 class="admin-content__title">$123,812.00 MXN</h3>
                                <p class="admin-content__subtitle">Ventas del último mes</p>
                            </div>

                            <div class="admin-goals__progress">
                                <div class="admin-goals__progress-bar admin-goals__progress-bar--background"></div>
                                <div class="admin-goals__progress-bar admin-goals__progress-bar--progress"></div>
                            </div>
                        </div>

                        <div class="admin-goals__separator"></div>

                        <div class="admin-goals__goal">
                            <div class="admin-content__header">
                                <h3 class="admin-content__title">$3,128.00 MXN</h3>
                                <p class="admin-content__subtitle">Ventas de la última semana</p>
                            </div>

                            <div class="admin-goals__progress">
                                <div class="admin-goals__progress-bar admin-goals__progress-bar--background"></div>
                                <div class="admin-goals__progress-bar admin-goals__progress-bar--progress"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="admin__content admin__content--messages">
                    <div class="admin__messages">
                        <div class="admin-content__header">
                            <h3 class="admin-content__title">Mensajes Nuevos</h3>
                            <p class="admin-content__subtitle"><?= count($newMessages ?? []) ?> mensajes que aun no se han leido</p>
                        </div>

                        <div class="admin-messages__list">
                            <?php if ($newMessages): ?>
                                <?php foreach ($newMessages as $message): ?>
                                    <div class="admin-messages__item" data-id="<?php echo $message->id ?>">
                                        <p class="admin-messages__text"><strong>Nombre: </strong><?php echo $message->usuario->nombre ?></p>
                                        <p class="admin-messages__text"><strong>Correo: </strong><?php echo $message->usuario->correo ?></p>
                                        <p class="admin-messages__text"><strong>Mensaje enviado el: </strong><?php echo $message->fecha ?></p>
                                        <p class="admin-messages__text"><strong>Contenido: </strong><?php echo $message->contenido ?></p>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="admin-messages__no-messages">¡No te preocupes! En cualquier momento alguien tendra un problema...</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="admin__content admin__content--registered">
                    <div class="admin__registered">
                        <div class="admin-content__header">
                            <h3 class="admin-content__title">Usuarios Registrados</h3>
                            <p class="admin-content__subtitle"><?php echo $usersCount ?> usuarios registrados</p>
                        </div>

                        <div class="admin__graphic-container">
                            <canvas class="admin__graphic" id="users-registered"></canvas>
                        </div>
                    </div>
                </div>

                <div class="admin__content admin__content--confirmed">
                    <div class="admin__confirmed">
                        <div class="admin-content__header">
                            <h3 class="admin-content__title">Usuarios Confirmados</h3>
                            <p class="admin-content__subtitle" id="percentage-users-confirmed"><?php echo number_format(($usersConfirmed / $usersCount) * 100, 2) ?>% usuarios confirmados</p>
                        </div>

                        <div class="admin__graphic-container">
                            <canvas class="admin__graphic" id="users-confirmed" data-users="<?php echo $usersCount ?>" data-confirmed="<?php echo $usersConfirmed ?>" data-percentage="<?php echo number_format(($usersConfirmed / $usersCount) * 100, 2) ?>"></canvas>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script src="/assets/js/navbar.js"></script>
    <script src="/assets/js/admin-home.js"></script>
</body>
</html>