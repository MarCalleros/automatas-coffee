<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="stylesheet" href="/assets/css/contact.css">
    <link rel="stylesheet" href="/assets/css/variables.css">
    <link rel="shortcut icon" href="/assets/img/logo-coffee.png">
    <title>Contacto</title>
</head>
<body>
    <div class="conteinergeneral">
        <?php include_once __DIR__ . "/../templates/navbar.php"; ?>
        <div class="conteiner ">
            <div class="titulo">
                <h2 class="title--page">¿Quienes somos?</h2>
            </div>
            <div class="contenido">
                <div class="imagenlogo">
                    <img src="/assets/img/Logo-g.png" alt="Logo" class="imagen-logo">
                </div>
                <div class="texto">
                    <p>En Automatas Coffee, llevamos la experiencia del café a otro nivel. Nuestra cafetería se distingue por ofrecer bebidas de alta calidad, preparadas con leche premium de Milkwas, una empresa comprometida con la excelencia y el sabor natural.
                    </p>
                    <p>
                    Lo que hace única a Automatas Coffee es su origen: somos una creación de Automatas Software, una compañía innovadora en tecnología que ha decidido fusionar el mundo del software y la gastronomía para ofrecer una experiencia moderna y eficiente.
                    </p>
                </div>
            </div> 
                
        </div>
    
    
        <div class="conteiner contactanos">
            <div class="titulo">
                <h2 class="title--page">Contactanos</h2>
            </div>
            <form method="post" autocomplete="off" class="formulario">
                <div class="entradas">
                    <div class="grupocontacto">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="Nombre" class ="inputs" >
                    </div>
                    <div class="grupocontacto">
                        <label for="correo">Correo</label>
                        <input type="email" id="correo" name="Correo" class="inputs" >
                    </div>
                </div>
                <div class="entradas mensaje">
                    <label for="mensaje">Mensaje</label>
                    <textarea id="mensaje" name="Mensaje" cols="30" rows="10" ></textarea>
    
                </div>
                <div class="botonescontacto">
                    <input type="submit" name="contacto " value="Enviar mensaje" class="botoncontacto">
                    <input type="reset" name="resetear " value="Resetear campos" class="botonreseteo">
                </div>
            </form>
            
        </div>

        <?php include_once __DIR__ . "/../templates/footer.php"; ?>
        
    </div>

    <script src="/assets/js/configuration.js"></script>
</body>
</html>