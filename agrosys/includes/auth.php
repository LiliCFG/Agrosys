<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    // Redirige al login correcto dentro de la misma carpeta raíz
    header("Location: login.php");
    exit();
}
?>
