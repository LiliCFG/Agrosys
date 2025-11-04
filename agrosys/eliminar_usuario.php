<?php
include "conexion.php";

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "DELETE FROM Usuario WHERE id_usuario = $id";
    if($conexion->query($sql) === TRUE){
        header("Location: usuarios.php");
    } else {
        echo "Error al eliminar usuario: " . $conexion->error;
    }
}
?>
