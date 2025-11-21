<?php
require_once "includes/conexion.php";
header('Content-Type: application/json');

// Validar entrada
$id = isset($_GET['id_parcela']) ? intval($_GET['id_parcela']) : 0;

if ($id <= 0) {
    echo json_encode(["error" => "ID de parcela inválido"]);
    exit;
}

// Buscar coordenadas de la parcela
$stmt = $conexion->prepare("SELECT lat, lon FROM Parcela WHERE id_parcela = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$parcela = $result->fetch_assoc();

if (!$parcela) {
    echo json_encode(["error" => "Parcela no encontrada"]);
    exit;
}

$lat = $parcela['lat'];
$lon = $parcela['lon'];

// Llamar a API Open-Meteo
$url = "https://api.open-meteo.com/v1/forecast?latitude=$lat&longitude=$lon&current=temperature_2m,relative_humidity_2m";

$datos_api = file_get_contents($url);

if (!$datos_api) {
    echo json_encode(["error" => "No se pudo obtener datos del clima"]);
    exit;
}

$clima = json_decode($datos_api, true);

// Extraer datos
$temp = $clima["current"]["temperature_2m"] ?? null;
$hum = $clima["current"]["relative_humidity_2m"] ?? null;

echo json_encode([
    "temperatura" => $temp,
    "humedad" => $hum
]);
?>
