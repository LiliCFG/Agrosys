<?php
include "conexion.php";

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "DELETE FROM Parcela WHERE id_parcela = $id";
    if($conexion->query($sql) === TRUE){
        header("Location: parcelas.php");
    } else {
        echo "Error al eliminar parcela: " . $conexion->error;
    }
}
?>
