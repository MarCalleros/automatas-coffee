<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/variables.css">
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="shortcut icon" href="/assets/img/logo-coffee.png">
    <title>Confirmacion</title>
</head>
<body class="page--full-height">
    <?php include_once __DIR__ . "/../templates/navbar.php"; ?>
    
    <main class="main--full-height">
        <?php if ($token) : ?> 
            <div class="confirmation__message">
                <h2 class="title--page">¡Gracias por confirmar tu cuenta!</h2>
                <p class="confirmation__text">Tu cuenta ha sido confirmada exitosamente. Ahora puedes iniciar sesión y disfrutar de todas las funcionalidades de Automatas Coffee.</p>
            </div>
        <?php else : ?>
            <div class="confirmation__message">
                <h2 class="title--page">¡Error al confirmar tu cuenta!</h2>
                <p class="confirmation__text">El token de confirmación no es válido o ha expirado. Por favor, verifica el enlace que recibiste en tu correo electrónico.</p>
            </div>
        <?php endif; ?>
    </main>

    <?php include_once __DIR__ . "/../templates/footer.php"; ?>

    <script src="/assets/js/navbar.js"></script>
    <script type="module" src="/assets/js/configuration.js"></script>
</body>
</html>