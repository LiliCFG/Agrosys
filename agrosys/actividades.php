<?php
require_once "includes/conexion.php";
require_once "includes/auth.php";
include "includes/header.php";

$sql = "SELECT a.id_actividad, a.tipo, a.fecha, a.descripcion, p.nombre AS parcela 
        FROM Actividad a
        LEFT JOIN Parcela p ON a.id_parcela = p.id_parcela
        ORDER BY a.fecha DESC";
$res = $conexion->query($sql);
?>
<div class="contenedor">
    <h1>Actividades</h1>
    <table>
        <tr><th>ID</th><th>Tipo</th><th>Fecha</th><th>Descripción</th><th>Parcela</th><th>Acciones</th></tr>
        <?php if($res && $res->num_rows>0): while($f=$res->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($f['id_actividad']); ?></td>
                <td><?= htmlspecialchars($f['tipo']); ?></td>
                <td><?= htmlspecialchars($f['fecha']); ?></td>
                <td><?= htmlspecialchars($f['descripcion']); ?></td>
                <td><?= htmlspecialchars($f['parcela']); ?></td>
                <td>
                    <a class="btn editar" href="editar_actividad.php?id=<?= $f['id_actividad']; ?>">Editar</a>
                    <a class="btn eliminar" href="eliminar_actividad.php?id=<?= $f['id_actividad']; ?>" onclick="return confirm('¿Eliminar actividad?')">Eliminar</a>
                </td>
            </tr>
        <?php endwhile; else: ?>
            <tr><td colspan="6">No hay actividades registradas.</td></tr>
        <?php endif;?>
    </table>

    <a class="btn guardar" href="agregar_actividad.php">+ Agregar Actividad</a>
    <a class="btn cancelar" href="index.php" style="margin-left:10px;">← Volver</a>
</div>
</main></body></html>
