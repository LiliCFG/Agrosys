<?php
include "conexion.php";

// Consulta para obtener todas las actividades junto con el nombre de la parcela
$sql = "SELECT a.id_actividad, a.tipo, a.fecha, a.descripcion, p.nombre AS parcela 
        FROM Actividad a
        INNER JOIN Parcela p ON a.id_parcela = p.id_parcela";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actividades - Agrosys</title>
</head>
<body>
    <h1>Lista de Actividades</h1>

    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Tipo</th>
            <th>Fecha</th>
            <th>Descripción</th>
            <th>Parcela</th>
            <th>Acciones</th>
        </tr>

        <?php
        if ($resultado->num_rows > 0) {
            while($fila = $resultado->fetch_assoc()) {
                echo "<tr>
                        <td>".$fila['id_actividad']."</td>
                        <td>".$fila['tipo']."</td>
                        <td>".$fila['fecha']."</td>
                        <td>".$fila['descripcion']."</td>
                        <td>".$fila['parcela']."</td>
                        <td>
                            <a href='editar_actividad.php?id=".$fila['id_actividad']."'>Editar</a> |
                            <a href='eliminar_actividad.php?id=".$fila['id_actividad']."'>Eliminar</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No hay actividades</td></tr>";
        }
        ?>
    </table>

    <br>
    <a href="agregar_actividad.php">Agregar Nueva Actividad</a>
</body>
</html>
