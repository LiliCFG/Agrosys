<?php
include "conexion.php"; // Incluimos la conexión a la BD

// Consulta para obtener todos los usuarios
$sql = "SELECT * FROM Usuario";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Usuarios - Agrosys</title>
</head>
<body>
    <h1>Lista de Usuarios</h1>

    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Tipo de Usuario</th>
            <th>Acciones</th>
        </tr>

        <?php
        if ($resultado->num_rows > 0) {
            while($fila = $resultado->fetch_assoc()) {
                echo "<tr>
                        <td>".$fila['id_usuario']."</td>
                        <td>".$fila['nombre']."</td>
                        <td>".$fila['correo']."</td>
                        <td>".$fila['tipo_usuario']."</td>
                        <td>
                            <a href='editar_usuario.php?id=".$fila['id_usuario']."'>Editar</a> |
                            <a href='eliminar_usuario.php?id=".$fila['id_usuario']."'>Eliminar</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No hay usuarios</td></tr>";
        }
        ?>
    </table>

    <br>
    <a href="agregar_usuario.php">Agregar Nuevo Usuario</a>
</body>
</html>
