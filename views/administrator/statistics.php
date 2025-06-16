<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="stylesheet" href="/assets/css/estadisticas.css">
    <link rel="stylesheet" href="/assets/css/product-search-modal.css">
    <link rel="shortcut icon" href="/assets/img/logo-coffee.png">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body data-page="estadisticas">
<?php
require_once __DIR__ . '/../../includes/database.php';
require_once __DIR__ . '/../../includes/functions.php';

// Obtener el valor de la pestaña activa que se encuentra en la URL (/admin/estadisticas/productos)
//$section = isset($_GET['section']) ? $_GET['section'] : 'productos';

//$tab = isset($_GET['tab']) ? $_GET['tab'] : 'productos';
$tab = $section ?? 'productos';
$pagina = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$periodo = isset($_GET['periodo']) ? $_GET['periodo'] : 'dia';
?>

<div class="admin-panel">
    <?php include_once __DIR__ . "/../templates/sidebar.php"; ?>

    <div class="admin">
        <h2 class="admin__title">ESTADISTICAS</h2>
            <?php include_once __DIR__ . '/product-search-modal.php'; ?>
            
        <div class="tabs">
            <a href="/admin/estadisticas/productos" data-tab="productos" class="tab <?php echo $tab == 'productos' ? 'active' : ''; ?>">Productos Vendidos</a>
            <a href="/admin/estadisticas/ingresos" data-tab="ingresos" class="tab <?php echo $tab == 'ingresos' ? 'active' : ''; ?>">Ingresos por Producto</a>
            <a href="/admin/estadisticas/compras" data-tab="compras" class="tab <?php echo $tab == 'compras' ? 'active' : ''; ?>">Clientes por Compras</a>
            <a href="/admin/estadisticas/clientes" data-tab="clientes" class="tab <?php echo $tab == 'clientes' ? 'active' : ''; ?>">Clientes por ingresos</a>
            <a href="/admin/estadisticas/ventas" data-tab="ventas" class="tab <?php echo $tab == 'ventas' ? 'active' : ''; ?>">Ventas por Período</a>
        </div>

        <div id="productos" class="tab-content <?php echo $tab == 'productos' ? 'active' : ''; ?>">
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

        <div id="ingresos" class="tab-content <?php echo $tab == 'ingresos' ? 'active' : ''; ?>">
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

        <div id="compras" class="tab-content <?php echo $tab == 'compras' ? 'active' : ''; ?>">
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

        <div id="clientes" class="tab-content <?php echo $tab == 'clientes' ? 'active' : ''; ?>">
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

        <div id="ventas" class="tab-content <?php echo $tab == 'ventas' ? 'active' : ''; ?>">
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

<script src="/assets/js/product-search-modal.js"></script>
<script src="/assets/js/estadisticas.js"></script>
</body>
</html> 