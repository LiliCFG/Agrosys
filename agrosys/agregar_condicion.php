<?php
include "conexion.php";

// Obtener todas las parcelas para el select
$parcelas = $conexion->query("SELECT id_parcela, nombre FROM Parcela");

if(isset($_POST['guardar'])){
    $fecha = $_POST['fecha'];
    $humedad = $_POST['humedad'];
    $temperatura = $_POST['temperatura'];
    $id_parcela = $_POST['id_parcela'];

    $sql = "INSERT INTO CondicionCultivo (fecha, humedad, temperatura, id_parcela) 
            VALUES ('$fecha', '$humedad', '$temperatura', $id_parcela)";

    if($conexion->query($sql) === TRUE){
        header("Location: condiciones.php");
    } else {
        echo "Error: " . $conexion->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Condición</title>
</head>
<body>
    <h1>Agregar Condición de Cultivo</h1>
    <form method="POST">
        Fecha: <input type="date" name="fecha" required><br><br>
        Humedad (%): <input type="number" name="humedad" step="0.1" required><br><br>
        Temperatura (°C): <input type="number" name="temperatura" step="0.1" required><br><br>
        Parcela: 
        <select name="id_parcela" required>
            <option value="">Selecciona una parcela</option>
            <?php
            while($fila = $parcelas->fetch_assoc()){
                echo "<option value='".$fila['id_parcela']."'>".$fila['nombre']."</option>";
            }
            ?>
        </select><br><br>
        <input type="submit" name="guardar" value="Guardar Condición">
    </form>
    <br>
    <a href="condiciones.php">Volver a Condiciones</a>
</body>
</html>
