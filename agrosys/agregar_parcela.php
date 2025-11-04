<?php
include "conexion.php";

if(isset($_POST['guardar'])){
    $nombre = $_POST['nombre'];
    $ubicacion = $_POST['ubicación'];
    $extension = $_POST['extension'];
    $tipo_suelo = $_POST['tipo_suelo'];

    $sql = "INSERT INTO Parcela (nombre, ubicación, extensión, tipo_suelo) 
            VALUES ('$nombre', '$ubicacion', '$extension', '$tipo_suelo')";

    if($conexion->query($sql) === TRUE){
        header("Location: parcelas.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Parcela</title>
</head>
<body>
    <h1>Agregar Parcela</h1>
    <form method="POST">
        Nombre: <input type="text" name="nombre" required><br><br>
        Ubicación: <input type="text" name="ubicación" required><br><br>
        Extensión: <input type="text" name="extension" required><br><br>
        Tipo de Suelo: <input type="text" name="tipo_suelo" required><br><br>
        <input type="submit" name="guardar" value="Guardar Parcela">
    </form>
    <br>
    <a href="parcelas.php">Volver a Parcelas</a>
</body>
</html>
