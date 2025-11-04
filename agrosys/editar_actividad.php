<?php
include "conexion.php";

// Obtener todas las parcelas para el select
$parcelas = $conexion->query("SELECT id_parcela, nombre FROM Parcela");

// Obtener datos de la actividad a editar
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "SELECT * FROM Actividad WHERE id_actividad = $id";
    $resultado = $conexion->query($sql);
    $actividad = $resultado->fetch_assoc();
}

// Actualizar actividad
if(isset($_POST['actualizar'])){
    $id = $_POST['id'];
    $tipo = $_POST['tipo'];
    $fecha = $_POST['fecha'];
    $descripcion = $_POST['descripcion'];
    $id_parcela = $_POST['id_parcela'];

    $sql = "UPDATE Actividad SET 
                tipo='$tipo', 
                fecha='$fecha', 
                descripcion='$descripcion', 
                id_parcela=$id_parcela 
            WHERE id_actividad=$id";

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
    <title>Editar Actividad</title>
</head>
<body>
    <h1>Editar Actividad</h1>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $actividad['id_actividad']; ?>">
        Tipo: <input type="text" name="tipo" value="<?php echo $actividad['tipo']; ?>" required><br><br>
        Fecha: <input type="date" name="fecha" value="<?php echo $actividad['fecha']; ?>" required><br><br>
        Descripción: <textarea name="descripcion" required><?php echo $actividad['descripcion']; ?></textarea><br><br>
        Parcela: 
        <select name="id_parcela" required>
            <?php
            while($fila = $parcelas->fetch_assoc()){
                $selected = ($fila['id_parcela'] == $actividad['id_parcela']) ? "selected" : "";
                echo "<option value='".$fila['id_parcela']."' $selected>".$fila['nombre']."</option>";
            }
            ?>
        </select><br><br>
        <input type="submit" name="actualizar" value="Actualizar Actividad">
    </form>
    <br>
    <a href="actividades.php">Volver a Actividades</a>
</body>
</html>
