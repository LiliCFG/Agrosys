<?php
require_once "includes/conexion.php";
require_once "includes/auth.php";
include "includes/header.php";

$sql = "SELECT c.id_condicion, c.fecha, c.humedad, c.temperatura, p.nombre AS parcela 
        FROM CondicionCultivo c
        LEFT JOIN Parcela p ON c.id_parcela = p.id_parcela
        ORDER BY c.fecha DESC";
$res = $conexion->query($sql);
?>
<div class="contenedor">
    <h1>Condiciones de Cultivo</h1>
    <table>
        <tr><th>ID</th><th>Fecha</th><th>Humedad</th><th>Temperatura</th><th>Parcela</th><th>Acciones</th></tr>
        <?php if($res && $res->num_rows>0): while($f=$res->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($f['id_condicion']); ?></td>
                <td><?= htmlspecialchars($f['fecha']); ?></td>
                <td><?= htmlspecialchars($f['humedad']); ?></td>
                <td><?= htmlspecialchars($f['temperatura']); ?></td>
                <td><?= htmlspecialchars($f['parcela']); ?></td>
                <td>
                    <a class="btn editar" href="editar_condicion.php?id=<?= $f['id_condicion']; ?>">Editar</a>
                    <a class="btn eliminar" href="eliminar_condicion.php?id=<?= $f['id_condicion']; ?>" onclick="return confirm('¿Eliminar condición?')">Eliminar</a>
                </td>
            </tr>
        <?php endwhile; else: ?>
            <tr><td colspan="6">No hay condiciones registradas.</td></tr>
        <?php endif;?>
    </table>

    <a class="btn guardar" href="agregar_condicion.php">+ Agregar Condición</a>
    <a class="btn cancelar" href="index.php" style="margin-left:10px;">← Volver</a>
</div>
</main></body></html>
