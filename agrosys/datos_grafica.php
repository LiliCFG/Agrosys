<?php
require_once "includes/conexion.php";

$parcela = $_GET["parcela"] ?? "";

if ($parcela === "sanjuan") {
    $comunidad = "San Juan Ahuehueyo";
} elseif ($parcela === "sanrafael") {
    $comunidad = "San Rafael";
} else {
    echo json_encode(["error" => "Parcela no válida"]);
    exit;
}

$sql = "SELECT fecha, temperatura, humedad
        FROM CondicionCultivo
        INNER JOIN Parcela ON CondicionCultivo.id_parcela = Parcela.id_parcela
        WHERE Parcela.comunidad = ?
        ORDER BY fecha DESC
        LIMIT 7";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $comunidad);
$stmt->execute();
$result = $stmt->get_result();

$fechas = [];
$temp = [];
$hum = [];

while ($row = $result->fetch_assoc()) {
    $fechas[] = $row["fecha"];
    $temp[] = $row["temperatura"];
    $hum[] = $row["humedad"];
}

echo json_encode([
    "labels" => array_reverse($fechas),
    "temperatura" => array_reverse($temp),
    "humedad"     => array_reverse($hum)
]);
