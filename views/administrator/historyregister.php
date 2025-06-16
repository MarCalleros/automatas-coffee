<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="stylesheet" href="/assets/css/historyregister.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <title>Historial de Registros</title>
</head>
<body>
<div class="admin-panel">
    <?php require_once __DIR__ . '/../templates/sidebar.php'; ?>
    
    <main class="admin">
        <h2 class="admin__title">Historial de Registros</h2>
        <div class="admin__content">
            <div id="fecha-personalizada" class="fecha-personalizada" style="display: <?php echo $periodo == 'personalizado' ? 'flex' : 'none'; ?>;">
                <div class="fecha-container">
                    <label for="fecha_inicio">Desde:</label>
                    <input type="date" id="fecha_inicio" name="fecha_inicio" value="<?php echo $filtros['desde'] ?? ''; ?>">
                </div>
                <div class="fecha-container">
                    <label for="fecha_fin">Hasta:</label>
                    <input type="date" id="fecha_fin" name="fecha_fin" value="<?php echo $filtros['hasta'] ?? ''; ?>">
                </div>
                <button type="button" id="aplicar-fechas" class="btn-aplicar">Aplicar</button>
                <button type="button" id="btn-pdf" class="btn-aplicar">Generar PDF</button>

            </div>
            <!--Tabla-->
            <div class="table-container">
                <table class="admin__table">
                    <thead class="admin-table__header">
                        <tr class="admin-table__row">
                            <th class="admin-table__head">ID Empleado</th>
                            <th class="admin-table__head">Empleado</th>
                            <th class="admin-table__head">Fecha</th>
                            <th class="admin-table__head">Horario Entrada</th>
                            <th class="admin-table__head">Horario Salida</th>
                        </tr>
                    </thead>
                    <tbody class="admin-table__body" id="tablaRegistrosNFC">
                        <!-- Aquí se cargarán los registros -->

                        <?php if (empty($registros)): ?>
                            <tr class="admin-table__row admin-table__row--data">
                                <td colspan="4" style="text-align: center; padding: 20px;">
                                    <!--No se encontraron registros-->
                                </td>
                            </tr>
                        <?php else: ?>  
                            <?php foreach ($registros as $registro): ?>
                                <tr data-id="<?php echo $registro->id; ?>">
                                    <td class="admin-table__data"><?php echo $registro->id_empleado; ?></td>
                                    <td class="admin-table__data"><?php echo $registro->nombre_empleado; ?></td>
                                    <td class="admin-table__data"><?php echo $registro->fecha; ?></td>
                                    <td class="admin-table__data"><?php echo $registro->hora_entrada ?? '-'; ?></td>
                                    <td class="admin-table__data"><?php echo $registro->hora_salida ?? '-'; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="btn-container">
                <!-- Botón de eliminar -->
                <button class="btn-delete">Borrar una entrada/salida</button>
            </div>
        </div>

        <!-- Paginación -->
        <?php if ($paginacion['total_paginas'] > 1): ?>
            <div class="pagination" id="paginacionRegistros">
                <?php if ($paginacion['pagina_actual'] > 1): ?>
                    <a href="?pagina=<?php echo $paginacion['pagina_actual'] - 1; ?><?php echo !empty($filtros['desde']) ? '&desde=' . $filtros['desde'] : ''; ?><?php echo !empty($filtros['hasta']) ? '&hasta=' . $filtros['hasta'] : ''; ?>" class="pagination-btn">&laquo;</a>
                <?php endif; ?>
                
                <?php for ($i = 1; $i <= $paginacion['total_paginas']; $i++): ?>
                    <a href="?pagina=<?php echo $i; ?><?php echo !empty($filtros['desde']) ? '&desde=' . $filtros['desde'] : ''; ?><?php echo !empty($filtros['hasta']) ? '&hasta=' . $filtros['hasta'] : ''; ?>" class="pagination-btn <?php echo $i === $paginacion['pagina_actual'] ? 'active' : ''; ?>"><?php echo $i; ?></a>
                <?php endfor; ?>
                
                <?php if ($paginacion['pagina_actual'] < $paginacion['total_paginas']): ?>
                    <a href="?pagina=<?php echo $paginacion['pagina_actual'] + 1; ?><?php echo !empty($filtros['desde']) ? '&desde=' . $filtros['desde'] : ''; ?><?php echo !empty($filtros['hasta']) ? '&hasta=' . $filtros['hasta'] : ''; ?>" class="pagination-btn">&raquo;</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </main>
</div>
<script type="module" src="/assets/js/historyregister.js"></script>
<script type="module" src="/assets/js/admin.js"></script>
</body>
</html>