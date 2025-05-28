<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="shortcut icon" href="/assets/img/logo-coffee.png">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>Reportes</title>
</head>
<body>
    <div class="admin-panel">
        <?php include_once __DIR__ . "/../templates/sidebar.php"; ?>
        
        <main class="admin">
            <h2 class="admin__title">PEDIDOS</h2>

            <div class="admin__content">
                
                    <div id="fecha-personalizada" class="fecha-personalizada">
                        <div class="fecha-container">
                            <label for="reporte_inicio">Desde:</label>
                            <input type="date" id="reporte_inicio" name="reporte_inicio" value="<?php echo $filtros['desde'] ?? ''; ?>">
                        </div>
                        <div class="fecha-container">
                            <label for="reporte_fin">Hasta:</label>
                            <input type="date" id="reporte_fin" name="reporte_fin" value="<?php echo $filtros['hasta'] ?? ''; ?>">
                        </div>
                        <button type="button" id="btn-reporte" class="btn-aplicar">Aplicar</button>
                        <button type="button" id="btn-pdf" class="btn-aplicar">Generar PDF</button>
                    </div>

                <div class="admin__table-container" id="pdf-table">
                    <h3 class="admin__subtitle"></h3>

                    <table class="admin__table">
                        <thead class="admin-table__header">
                            <tr class="admin-table__row">
                                <th class="admin-table__head">Nro. Pedido</th>
                                <th class="admin-table__head">Cliente</th>
                                <th class="admin-table__head">Repartidor</th>
                                <th class="admin-table__head">Fecha Solicitado</th>
                                <th class="admin-table__head">Fecha Entregado</th>
                                <th class="admin-table__head">Pago</th>
                                <th class="admin-table__head">Total</th>
                                <th class="admin-table__head">Estatus</th>
                            </tr>
                        </thead>
                        <tbody class="admin-table__body">
                                <tr class="admin-table__row admin-table__row--data">
                                    <td class="admin-table__data">No hay datos disponibles</td>
                                    <td class="admin-table__data"></td>
                                    <td class="admin-table__data"></td>
                                    <td class="admin-table__data"></td>
                                    <td class="admin-table__data"></td>
                                    <td class="admin-table__data"></td>
                                    <td class="admin-table__data"></td>
                                    <td class="admin-table__data"></td>
                                </tr>
                        </tbody>
                    </table>

                    <h3 class="admin__subtitle admin__subtitle--price"></h3>
                </div>
            </div>
        </main>
    </div>

    <script src="/assets/js/navbar.js"></script>
    <script type="module" src="/assets/js/admin.js"></script>
</body>
</html>