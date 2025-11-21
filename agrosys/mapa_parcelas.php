<?php
require_once "includes/conexion.php";
require_once "includes/auth.php";

$res = $conexion->query("SELECT nombre, comunidad, lat, lon FROM Parcela");
$parcelas = $res->fetch_all(MYSQLI_ASSOC);

include "includes/header.php";
?>

<div class="contenedor">
    <h1>Mapa de Parcelas</h1>

    <div id="map" style="height:500px;
                         border-radius:15px;
                         box-shadow:0 0 10px rgba(0,0,0,0.15);">
    </div>

    <a class="btn cancelar" href="parcelas.php" style="margin-top:20px;">← Volver</a>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
var map = L.map('map').setView([18.71, -98.95], 13);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 })
  .addTo(map);

<?php foreach ($parcelas as $p): ?>

L.marker([<?= $p["lat"] ?>, <?= $p["lon"] ?>])
  .addTo(map)
  .bindPopup("<b><?= $p['nombre'] ?></b><br><?= $p['comunidad'] ?>");

<?php endforeach; ?>
</script>

</main></body></html>
