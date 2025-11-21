<?php
require_once "includes/conexion.php";
require_once "includes/auth.php";
if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id = (int)$_GET['id'];
    $stmt = $conexion->prepare("DELETE FROM CondicionCultivo WHERE id_condicion = ?");
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $stmt->close();
}
header("Location: condiciones.php");
exit();
