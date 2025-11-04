<?php
include "conexion.php";

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "DELETE FROM Actividad WHERE id_actividad = $id";
    if($conexion->query($sql) === TRUE){
        header("Location: actividades.php");
    } else {
        echo "Error al eliminar actividad: " . $conexion->error;
    }
}
?>
