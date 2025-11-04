<?php
include "conexion.php";

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "SELECT * FROM Parcela WHERE id_parcela = $id";
    $resultado = $conexion->query($sql);
    $parcela = $resultado->fetch_assoc();
}

if(isset($_POST['actualizar'])){
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $ubicacion = $_POST['ubicación'];
    $extension = $_POST['extension'];
    $tipo_suelo = $_POST['tipo_suelo'];

    $sql = "UPDATE Parcela SET 
                nombre='$nombre', 
                ubicación='$ubicacion', 
                extensión='$extension', 
                tipo_suelo='$tipo_suelo' 
            WHERE id_parcela=$id";

    if($conexion->query($sql) === TRUE){
        header("Location: parcelas.php");
    } else {
        echo "Error: " . $conexion->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Parcela</title>
</head>
<body>
    <h1>Editar Parcela</h1>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $parcela['id_parcela']; ?>">
        Nombre: <input type="text" name="nombre" value="<?php echo $parcela['nombre']; ?>" required><br><br>
        Ubicación: <input type="text" name="ubicación" value="<?php echo $parcela['ubicación']; ?>" required><br><br>
        Extensión: <input type="text" name="extension" value="<?php echo $parcela['extensión']; ?>" required><br><br>
        Tipo de Suelo: <input type="text" name="tipo_suelo" value="<?php echo $parcela['tipo_suelo']; ?>" required><br><br>
        <input type="submit" name="actualizar" value="Actualizar Parcela">
    </form>
    <br>
    <a href="parcelas.php">Volver a Parcelas</a>
</body>
</html>
