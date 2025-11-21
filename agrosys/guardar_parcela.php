<?php
require_once "includes/conexion.php";

$nombre    = $_POST["nombre"];
$comunidad = $_POST["comunidad"];
$lat       = $_POST["lat"];
$lon       = $_POST["lon"];

$sql = "INSERT INTO Parcela (nombre, comunidad, lat, lon)
        VALUES (?, ?, ?, ?)";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("ssdd", $nombre, $comunidad, $lat, $lon);

if ($stmt->execute()) {
    header("Location: parcelas.php?msg=ok");
} else {
    echo "Error: " . $conexion->error;
}
