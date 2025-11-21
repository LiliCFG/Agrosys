<?php
require_once "includes/conexion.php";
require_once "includes/auth.php";
include "includes/header.php";

// Consulta incluyendo la comunidad
$sql = "SELECT c.id_condicion, c.fecha, c.humedad, c.temperatura, 
               p.nombre AS parcela, p.comunidad
        FROM CondicionCultivo c
        LEFT JOIN Parcela p ON c.id_parcela = p.id_parcela
        ORDER BY c.fecha ASC";
$res = $conexion->query($sql);
?>
<div class="contenedor">
    <h1>Condiciones de Cultivo</h1>

    <!-- BOTONES DE GRÁFICAS -->
    <div style="margin-bottom:25px; display:flex; justify-content:center; gap:15px;">
        <a class="btn guardar" href="graficas_sanrafael.php">📊 Gráfica San Rafael</a>
        <a class="btn guardar" href="graficas_sanjuan.php">📈 Gráfica San Juan Ahuehueyo</a>
    </div>


    <!-- TABLA -->
    <table>
        <tr>
            <th>ID</th><th>Fecha</th><th>Humedad</th>
            <th>Temperatura</th><th>Parcela</th>
            <th>Comunidad</th><th>Acciones</th>
        </tr>
        <?php 
        if($res && $res->num_rows>0): 
            while($f=$res->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($f['id_condicion']); ?></td>
                <td><?= htmlspecialchars($f['fecha']); ?></td>
                <td><?= htmlspecialchars($f['humedad']); ?></td>
                <td><?= htmlspecialchars($f['temperatura']); ?></td>
                <td><?= htmlspecialchars($f['parcela']); ?></td>
                <td><?= htmlspecialchars($f['comunidad']); ?></td>

                <td>
                    <a class="btn editar" href="editar_condicion.php?id=<?= $f['id_condicion']; ?>">Editar</a>
                    <a class="btn eliminar" href="eliminar_condicion.php?id=<?= $f['id_condicion']; ?>" onclick="return confirm('¿Eliminar condición?')">Eliminar</a>
                </td>
            </tr>
        <?php endwhile; else: ?>
            <tr><td colspan="7">No hay condiciones registrados.</td></tr>
        <?php endif;?>
    </table>

    <a class="btn guardar" href="agregar_condicion.php">+ Agregar Condición</a>
    <a class="btn cancelar" href="index.php" style="margin-left:10px;">← Volver</a>
</div>

</main></body></html>
