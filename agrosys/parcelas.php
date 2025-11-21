<?php
require_once "includes/conexion.php";
require_once "includes/auth.php";
include "includes/header.php";

// Consulta actualizada incluyendo la comunidad
$sql = "SELECT id_parcela, nombre, ubicacion, extension, tipo_suelo, comunidad 
        FROM Parcela";
$res = $conexion->query($sql);
?>
<div class="contenedor">
    <h1>Parcelas</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Ubicación</th>
            <th>Extensión</th>
            <th>Tipo Suelo</th>
            <th>Comunidad</th>
            <th>Acciones</th>
        </tr>

        <?php if ($res && $res->num_rows > 0): ?>
            <?php while ($f = $res->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($f['id_parcela']); ?></td>
                    <td><?= htmlspecialchars($f['nombre']); ?></td>
                    <td><?= htmlspecialchars($f['ubicacion']); ?></td>
                    <td><?= htmlspecialchars($f['extension']); ?></td>
                    <td><?= htmlspecialchars($f['tipo_suelo']); ?></td>
                    <td><?= htmlspecialchars($f['comunidad']); ?></td>

                    <td>
                        <a class="btn editar" href="editar_parcela.php?id=<?= $f['id_parcela']; ?>">Editar</a>
                        <a class="btn eliminar" href="eliminar_parcela.php?id=<?= $f['id_parcela']; ?>"
                           onclick="return confirm('¿Eliminar parcela?')">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="7">No hay parcelas registradas.</td></tr>
        <?php endif; ?>
    </table>

    <a class="btn guardar" href="agregar_parcela.php">+ Agregar Parcela</a>
    <a class="btn cancelar" href="index.php" style="margin-left:10px;">← Volver</a>
</div>

</main></body></html>
