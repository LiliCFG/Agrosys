<?php
$servidor = "localhost";
$usuario = "root";
$contraseña = "";
$baseDeDatos = "agrosys";
$puerto = 3307;

$conexion = new mysqli($servidor, $usuario, $contraseña, $baseDeDatos, $puerto);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>
