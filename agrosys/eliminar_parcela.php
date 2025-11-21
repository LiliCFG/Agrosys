<?php
require_once "includes/conexion.php";
require_once "includes/auth.php";

if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id = (int)$_GET['id'];

    // 1. Eliminar actividades relacionadas
    $stmtA = $conexion->prepare("DELETE FROM actividad WHERE id_parcela = ?");
    $stmtA->bind_param("i", $id);
    $stmtA->execute();
    $stmtA->close();

    // 2. Eliminar condiciones relacionadas
    $stmtC = $conexion->prepare("DELETE FROM condicioncultivo WHERE id_parcela = ?");
    $stmtC->bind_param("i", $id);
    $stmtC->execute();
    $stmtC->close();

    // 3. Eliminar la parcela
    $stmtP = $conexion->prepare("DELETE FROM parcela WHERE id_parcela = ?");
    $stmtP->bind_param("i", $id);
    $stmtP->execute();
    $stmtP->close();
}

header("Location: parcelas.php");
exit();
