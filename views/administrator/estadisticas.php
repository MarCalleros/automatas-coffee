<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="stylesheet" href="/assets/css/estadisticas.css">
    <link rel="shortcut icon" href="/assets/img/logo-coffee.png">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body data-page="estadisticas">
<?php
require_once __DIR__ . '/../../includes/database.php';
require_once __DIR__ . '/../../includes/functions.php';

$tab = isset($_GET['tab']) ? $_GET['tab'] : 'productos_cantidad';
$pagina = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$periodo = isset($_GET['periodo']) ? $_GET['periodo'] : 'dia';
?>

<div class="admin-panel">
    <?php include_once __DIR__ . "/../templates/sidebar.php"; ?>

    <div class="admin">
        <h2 class="admin__title">ESTADISTICAS</h2>
        <div class="tabs">
            <a href="#" data-tab="productos_cantidad" class="tab <?php echo $tab == 'productos_cantidad' ? 'active' : ''; ?>">Productos Vendidos</a>
            <a href="#" data-tab="productos_ingresos" class="tab <?php echo $tab == 'productos_ingresos' ? 'active' : ''; ?>">Ingresos por Producto</a>
            <a href="#" data-tab="clientes_compras" class="tab <?php echo $tab == 'clientes_compras' ? 'active' : ''; ?>">Clientes por Compras</a>
            <a href="#" data-tab="clientes_ingresos" class="tab <?php echo $tab == 'clientes_ingresos' ? 'active' : ''; ?>">Clientes por ingresos</a>
            <a href="#" data-tab="ventas_periodo" class="tab <?php echo $tab == 'ventas_periodo' ? 'active' : ''; ?>">Ventas por Período</a>
        </div>

        <div id="productos_cantidad" class="tab-content <?php echo $tab == 'productos_cantidad' ? 'active' : ''; ?>">
            <div class="charts-container">
                <div class="chart-card">
                    <h1>Productos Más Vendidos</h1>
                    <p>5 productos más vendidos</p>
                    <div class="chart-container">
                        <canvas id="chartMasVendidos"></canvas>
                    </div>  
                </div>
                <div class="chart-card">
                    <h1>Productos Menos Vendidos</h1>
                    <p>5 productos menos vendidos</p>
                    <div class="chart-container">
                        <canvas id="chartMenosVendidos"></canvas>
                    </div>
                </div>
            </div>

            <div class="table-container">
                <h1>Productos por Cantidad Vendida</h1>
                <table class="admin__table">
                    <thead class="admin-table__header">
                        <tr class="admin-table__row">
                            <th class="admin-table__head">Número</th>
                            <th class="admin-table__head">Producto</th>
                            <th class="admin-table__head">Cantidad Vendida</th>
                            <th class="admin-table__head">Precio</th>
                        </tr>
                    </thead>
                    <tbody class="admin-table__body" id="tablaProductosVendidos">
                    </tbody>
                </table>
                <div class="pagination" id="paginacionProductosVendidos">
                </div>
            </div>
        </div>

        <div id="productos_ingresos" class="tab-content <?php echo $tab == 'productos_ingresos' ? 'active' : ''; ?>">
            <div class="charts-container">
                <div class="chart-card">
                    <h1>Productos con Más Ingresos</h1>
                    <p>5 productos con más ingresos</p>
                    <div class="chart-container">
                        <canvas id="chartMasIngresos"></canvas>
                    </div>
                </div>
                <div class="chart-card">
                    <h1>Productos con Menos Ingresos</h1>
                    <p>5 productos con menos ingresos</p>
                    <div class="chart-container">
                        <canvas id="chartMenosIngresos"></canvas>
                    </div>
                </div>
            </div>

            <div class="table-container">
                <h1>Productos por Ingresos</h1>
                <table class="admin__table">
                    <thead class="admin-table__header">
                        <tr class="admin-table__row">
                            <th class="admin-table__head">Número</th>
                            <th class="admin-table__head">Producto</th>
                            <th class="admin-table__head">Ingresos</th>
                            <th class="admin-table__head">Cantidad Vendida</th>
                        </tr>
                    </thead>
                    <tbody class="admin-table__body"id="tablaProductosIngresos">
                    </tbody>
                </table>
                <div class="pagination" id="paginacionProductosIngresos">
                </div>
            </div>
        </div>

        <div id="clientes_compras" class="tab-content <?php echo $tab == 'clientes_compras' ? 'active' : ''; ?>">
            <div class="chart-card full-width">
                <h1>Clientes con Más Compras</h1>
                <p>5 clientes que compran más productos</p>
                <div class="chart-container">
                <canvas id="chartClientesCompras"></canvas>
                </div>
            </div>

            <div class="table-container">
                <h1>Clientes por Número de Compras</h1>
                <table class="admin__table">
                    <thead class="admin-table__header">
                        <tr class="admin-table__row">
                            <th class="admin-table__head">Número</th>
                            <th class="admin-table__head">Cliente</th>
                            <th class="admin-table__head">Total Compras</th>
                            <th class="admin-table__head">Última Compra</th>
                        </tr>
                    </thead>
                    <tbody class="admin-table__body" id="tablaClientesCompras">
                    </tbody>
                </table>
                <div class="pagination" id="paginacionClientesCompras">
                </div>
            </div>
        </div>

        <div id="clientes_ingresos" class="tab-content <?php echo $tab == 'clientes_ingresos' ? 'active' : ''; ?>">
            <div class="chart-card full-width">
                <h1>Clientes que han generado más Ingresos</h1>
                <p>5 clientes que generan más ingresos</p>
                <div class="chart-container">
                <canvas id="chartClientesIngresos"></canvas>
                </div>

            </div>

            <div class="table-container">
                <h1>Clientes por Ingresos Generados</h1>
                <table class="admin__table">
                    <thead class="admin-table__header">
                        <tr class="admin-table__row">
                            <th class="admin-table__head">Número</th>
                            <th class="admin-table__head">Cliente</th>
                            <th class="admin-table__head">Total Ingresos</th>
                            <th class="admin-table__head">Compras Realizadas</th>
                        </tr>
                    </thead>
                    <tbody class="admin-table__body"id="tablaClientesIngresos">
                    </tbody>
                </table>
                <div class="pagination" id="paginacionClientesIngresos">
                </div>
            </div>
        </div>

        <div id="ventas_periodo" class="tab-content <?php echo $tab == 'ventas_periodo' ? 'active' : ''; ?>">
            <div class="period-selector">
                <a href="#" data-periodo="dia" class="period-btn <?php echo $periodo == 'dia' ? 'active' : ''; ?>">Por Día</a>
                <a href="#" data-periodo="semana" class="period-btn <?php echo $periodo == 'semana' ? 'active' : ''; ?>">Por Semana</a>
                <a href="#" data-periodo="mes" class="period-btn <?php echo $periodo == 'mes' ? 'active' : ''; ?>">Por Mes</a>
                <a href="#" data-periodo="personalizado" class="period-btn <?php echo $periodo == 'personalizado' ? 'active' : ''; ?>">Personalizado</a>
            </div>

        <div id="fecha-personalizada" class="fecha-personalizada" style="display: <?php echo $periodo == 'personalizado' ? 'flex' : 'none'; ?>;">
            <div class="fecha-container">
                <label for="fecha_inicio">Desde:</label>
                <input type="date" id="fecha_inicio" name="fecha_inicio" value="<?php echo $_GET['fecha_inicio'] ?? date('Y-m-d', strtotime('-30 days')); ?>">
            </div>
            <div class="fecha-container">
                <label for="fecha_fin">Hasta:</label>
                <input type="date" id="fecha_fin" name="fecha_fin" value="<?php echo $_GET['fecha_fin'] ?? date('Y-m-d'); ?>">
            </div>
                <button type="button" id="aplicar-fechas" class="btn-aplicar">Aplicar</button>
            </div>

            <div class="table-container">
                <h1>Ventas por <?php echo ucfirst($periodo); ?></h1>
                <table class="admin__table">
                    <thead class="admin-table__header">
                        <tr class="admin-table__row">
                            <th class="admin-table__head">Período</th>
                            <th class="admin-table__head">Total Ventas</th>
                            <th class="admin-table__head">Total Ingresos</th>
                            <th class="admin-table__head">Promedio por Venta</th>
                        </tr>
                    </thead>
                    <tbody class="admin-table__body"id="tablaVentasPeriodo">
                    </tbody>
                </table>
                <div class="pagination" id="paginacionVentasPeriodo">
                </div>
            </div>
        </div>
        </div>
    </div>
</div>

<script src="/assets/js/estadisticas.js"></script>
</body>
</html> 