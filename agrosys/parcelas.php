<?php
include "conexion.php";

// Consulta para obtener todas las parcelas
$sql = "SELECT * FROM Parcela";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Parcelas - Agrosys</title>
</head>
<body>
    <h1>Lista de Parcelas</h1>

    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Ubicación</th>
            <th>Extensión</th>
            <th>Tipo de Suelo</th>
            <th>Acciones</th>
        </tr>

        <?php
        if ($resultado->num_rows > 0) {
            while($fila = $resultado->fetch_assoc()) {
                echo "<tr>
                        <td>".$fila['id_parcela']."</td>
                        <td>".$fila['nombre']."</td>
                        <td>".$fila['ubicación']."</td>
                        <td>".$fila['extensión']."</td>
                        <td>".$fila['tipo_suelo']."</td>
                        <td>
                            <a href='editar_parcela.php?id=".$fila['id_parcela']."'>Editar</a> |
                            <a href='eliminar_parcela.php?id=".$fila['id_parcela']."'>Eliminar</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No hay parcelas</td></tr>";
        }
        ?>
    </table>

    <br>
    <a href="agregar_parcela.php">Agregar Nueva Parcela</a>
</body>
</html>
