<?php
include "conexion.php";

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "DELETE FROM CondicionCultivo WHERE id_condicion = $id";
    if($conexion->query($sql) === TRUE){
        header("Location: condiciones.php");
    } else {
        echo "Error al eliminar condición: " . $conexion->error;
    }
}
?>
