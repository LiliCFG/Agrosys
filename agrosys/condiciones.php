<?php
include "conexion.php";

// Consulta para obtener todas las condiciones junto con el nombre de la parcela
$sql = "SELECT c.id_condicion, c.fecha, c.humedad, c.temperatura, p.nombre AS parcela 
        FROM CondicionCultivo c
        INNER JOIN Parcela p ON c.id_parcela = p.id_parcela";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Condiciones de Cultivo - Agrosys</title>
</head>
<body>
    <h1>Lista de Condiciones de Cultivo</h1>

    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>Humedad</th>
            <th>Temperatura</th>
            <th>Parcela</th>
            <th>Acciones</th>
        </tr>

        <?php
        if ($resultado->num_rows > 0) {
            while($fila = $resultado->fetch_assoc()) {
                echo "<tr>
                        <td>".$fila['id_condicion']."</td>
                        <td>".$fila['fecha']."</td>
                        <td>".$fila['humedad']."</td>
                        <td>".$fila['temperatura']."</td>
                        <td>".$fila['parcela']."</td>
                        <td>
                            <a href='editar_condicion.php?id=".$fila['id_condicion']."'>Editar</a> |
                            <a href='eliminar_condicion.php?id=".$fila['id_condicion']."'>Eliminar</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No hay condiciones registradas</td></tr>";
        }
        ?>
    </table>

    <br>
    <a href="agregar_condicion.php">Agregar Nueva Condición</a>
</body>
</html>
