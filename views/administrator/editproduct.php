<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/variables.css">
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="stylesheet" href="/assets/css/addproduct.css">
    <title>Productos</title>
</head>
<body>
    <?php include_once __DIR__ . "/../templates/sidebar.php"; ?>

    <div class="main">
        <div class="titulo"> Editar producto </div>

        <div class="seccion1">
            <div class="seccion11">
                <label for="nombre">Nombre del producto</label>
                <input type="text" id="nombre" placeholder="Ingresar nombre">    
            </div>
            <div class="seccion12">
                <label for="categoria">Categoria</label>
                <select id="categoria">
                    <option value="cafefrio">Café frío</option>
                    <option value="cafecaliente">Café caliente</option>
                    <option value="capuccino">Capuccino</option>
                </select>
            </div>
        </div>
        <div class="seccion2">
            <div class="seccion21">
                <label for="precio">Precio</label>
                <input type="text" id="precio" placeholder="$0.00">
            </div>
            <div class="seccion22">
                <label for="tamano">Tamaño del producto</label>
                <div class="opciones">
                    <div class="opcion">
                        <div>
                            <input type="checkbox" name="tamano" value="ch">
                        </div>
                        <div>
                            <label>Chico</label>
                        </div>
                    </div>
                    <div class="opcion">
                        <div>
                            <input type="checkbox" name="tamano" value="md">
                        </div>
                        <div>
                            <label>Mediano</label>
                        </div>
                    </div>
                    <div class="opcion">
                        <div>
                            <input type="checkbox" name="tamano" value="gr">
                        </div>
                        <div>
                            <label>Grande</label>
                        </div>
                    </div>
                </div>                
            </div>
        </div>

        <div class="seccion3">
            <div>
                <label for="">Descripcion del producto</label>
                <textarea id="descripcion"></textarea>
                <input type="file">
            </div>
        </div>

        <div class="seccion4">
            <div id="agregar">
                <label for="">Editar producto</label>
            </div>
            <div id="cancelar">
                <label for="">Cancelar</label>
            </div>
        </div>

    </div>
    
    <div class="panel2"> 
        <img id="logo2" src="../assets/img/logo_white.png" alt="">
    </div>


    <script src="js/sidebar.js"></script>
</body>
</html>