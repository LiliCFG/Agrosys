<?php
require_once "includes/conexion.php";
require_once "includes/auth.php";
include "includes/header.php";

// Consulta
$sql = "SELECT id_usuario, nombre, correo, tipo_usuario FROM Usuario";
$res = $conexion->query($sql);
?>

<div class="contenedor">
    <h1>Lista de Usuarios</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Tipo</th>
            <th>Acciones</th>
        </tr>

        <?php if ($res && $res->num_rows > 0): ?>
            <?php while ($fila = $res->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($fila['id_usuario']); ?></td>
                    <td><?= htmlspecialchars($fila['nombre']); ?></td>
                    <td><?= htmlspecialchars($fila['correo']); ?></td>
                    <td><?= htmlspecialchars($fila['tipo_usuario']); ?></td>
                    <td>
                        <a class="btn editar" 
                           href="editar_usuario.php?id=<?= $fila['id_usuario']; ?>">
                           Editar
                        </a>

                        <a class="btn eliminar" 
                           href="eliminar_usuario.php?id=<?= $fila['id_usuario']; ?>" 
                           onclick="return confirm('¿Eliminar usuario?')">
                           Eliminar
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">No hay usuarios registrados.</td>
            </tr>
        <?php endif; ?>
    </table>

    <a class="btn guardar" href="agregar_usuario.php">+ Agregar Nuevo Usuario</a>
    <a class="btn cancelar" href="index.php" style="margin-left: 10px;">← Volver</a>
</div>

</main>
</body>
</html>
