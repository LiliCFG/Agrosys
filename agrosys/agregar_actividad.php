<?php
include "conexion.php";

// Obtener todas las parcelas para el select
$parcelas = $conexion->query("SELECT id_parcela, nombre FROM Parcela");

if(isset($_POST['guardar'])){
    $tipo = $_POST['tipo'];
    $fecha = $_POST['fecha'];
    $descripcion = $_POST['descripcion'];
    $id_parcela = $_POST['id_parcela'];

    $sql = "INSERT INTO Actividad (tipo, fecha, descripcion, id_parcela) 
            VALUES ('$tipo', '$fecha', '$descripcion', $id_parcela)";

    if($conexion->query($sql) === TRUE){
        header("Location: actividades.php");
    } else {
        echo "Error: " . $conexion->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Actividad</title>
</head>
<body>
    <h1>Agregar Actividad</h1>
    <form method="POST">
        Tipo: <input type="text" name="tipo" required><br><br>
        Fecha: <input type="date" name="fecha" required><br><br>
        Descripción: <textarea name="descripcion" required></textarea><br><br>
        Parcela: 
        <select name="id_parcela" required>
            <option value="">Selecciona una parcela</option>
            <?php
            while($fila = $parcelas->fetch_assoc()){
                echo "<option value='".$fila['id_parcela']."'>".$fila['nombre']."</option>";
            }
            ?>
        </select><br><br>
        <input type="submit" name="guardar" value="Guardar Actividad">
    </form>
    <br>
    <a href="actividades.php">Volver a Actividades</a>
</body>
</html>
