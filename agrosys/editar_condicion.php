<?php
include "conexion.php";

// Obtener todas las parcelas para el select
$parcelas = $conexion->query("SELECT id_parcela, nombre FROM Parcela");

// Obtener datos de la condición a editar
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "SELECT * FROM CondicionCultivo WHERE id_condicion = $id";
    $resultado = $conexion->query($sql);
    $condicion = $resultado->fetch_assoc();
}

// Actualizar condición
if(isset($_POST['actualizar'])){
    $id = $_POST['id'];
    $fecha = $_POST['fecha'];
    $humedad = $_POST['humedad'];
    $temperatura = $_POST['temperatura'];
    $id_parcela = $_POST['id_parcela'];

    $sql = "UPDATE CondicionCultivo SET 
                fecha='$fecha', 
                humedad='$humedad', 
                temperatura='$temperatura', 
                id_parcela=$id_parcela 
            WHERE id_condicion=$id";

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
    <title>Editar Condición</title>
</head>
<body>
    <h1>Editar Condición de Cultivo</h1>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $condicion['id_condicion']; ?>">
        Fecha: <input type="date" name="fecha" value="<?php echo $condicion['fecha']; ?>" required><br><br>
        Humedad (%): <input type="number" name="humedad" step="0.1" value="<?php echo $condicion['humedad']; ?>" required><br><br>
        Temperatura (°C): <input type="number" name="temperatura" step="0.1" value="<?php echo $condicion['temperatura']; ?>" required><br><br>
        Parcela: 
        <select name="id_parcela" required>
            <?php
            while($fila = $parcelas->fetch_assoc()){
                $selected = ($fila['id_parcela'] == $condicion['id_parcela']) ? "selected" : "";
                echo "<option value='".$fila['id_parcela']."' $selected>".$fila['nombre']."</option>";
            }
            ?>
        </select><br><br>
        <input type="submit" name="actualizar" value="Actualizar Condición">
    </form>
    <br>
    <a href="condiciones.php">Volver a Condiciones</a>
</body>
</html>
