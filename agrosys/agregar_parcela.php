<?php
require_once "includes/conexion.php";
require_once "includes/auth.php";
include "includes/header.php";

// 📌 INCLUYE ESTILOS
echo '<link rel="stylesheet" href="css/estilos.css">';

$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre     = trim($_POST['nombre'] ?? '');
    $ubicacion  = trim($_POST['ubicacion'] ?? '');
    $extension  = trim($_POST['extension'] ?? '');
    $tipo_suelo = trim($_POST['tipo_suelo'] ?? '');
    $lat        = trim($_POST['lat'] ?? '');
    $lon        = trim($_POST['lon'] ?? '');
    $comunidad  = trim($_POST['comunidad'] ?? '');

    if ($nombre === '' || $ubicacion === '' || $extension === '' ||
        $tipo_suelo === '' || $lat === '' || $lon === '' || $comunidad === '') {

        $error = "Todos los campos son obligatorios.";
    } else {

        $stmt = $conexion->prepare("
            INSERT INTO Parcela (nombre, ubicacion, extension, tipo_suelo, lat, lon, comunidad)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param("ssssdds", $nombre, $ubicacion, $extension, $tipo_suelo, $lat, $lon, $comunidad);

        if ($stmt->execute()) {
            header("Location: parcelas.php?msg=ok");
            exit();
        } else {
            $error = "Error: " . $stmt->error;
        }
    }
}
?>

<div class="contenedor" style="max-width:750px;">
    <h1>Agregar Parcela</h1>

    <?php if ($error): ?>
        <div class="alert error"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" class="formulario">

        <label>Nombre de la Parcela:</label>
        <input type="text" name="nombre" required>

        <label>Ubicación (descripción):</label>
        <input type="text" name="ubicacion" required>

        <label>Extensión (m² / ha):</label>
        <input type="text" name="extension" required>

        <label>Tipo de Suelo:</label>
        <input type="text" name="tipo_suelo" required>

        <label>Comunidad:</label>
        <select name="comunidad" required>
            <option value="">Seleccione una opción</option>
            <option value="San Rafael">San Rafael</option>
            <option value="San Juan Ahuehueyo">San Juan Ahuehueyo</option>
        </select>

        <label>📍 Latitud:</label>
        <input type="text" id="lat" name="lat" readonly required>

        <label>📍 Longitud:</label>
        <input type="text" id="lon" name="lon" readonly required>

        <!-- CORREGIDO: cambio de class="guardar" a class="btn-ubicacion" -->
        <button type="button" class="btn-ubicacion" onclick="obtenerUbicacion()">
            📌 Obtener ubicación automática
        </button>

        <br><br>

        <h3>O selecciona manualmente en el mapa:</h3>

        <div id="map" 
             style="height:350px;border-radius:15px;margin:15px 0;
                    box-shadow:0 0 10px rgba(0,0,0,0.2);">
        </div>

        <!-- BOTONES -->
        <div class="botones-form">
            <button class="btn-guardar" type="submit">Guardar Parcela</button>
            <a class="btn-cancelar" href="parcelas.php">Cancelar</a>
        </div>

    </form>
</div>

<!-- LEAFLET -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
// Obtener ubicación GPS
function obtenerUbicacion() {
    if (!navigator.geolocation) {
        alert("Tu navegador no soporta geolocalización.");
        return;
    }

    navigator.geolocation.getCurrentPosition((pos) => {
        const lat = pos.coords.latitude;
        const lon = pos.coords.longitude;

        document.getElementById("lat").value = lat;
        document.getElementById("lon").value = lon;

        marker.setLatLng([lat, lon]);
        map.setView([lat, lon], 18);
    }, 
    () => alert("Activa la ubicación para usar esta función."));
}

// MAPA
var map = L.map('map').setView([18.71, -98.95], 14);

// Capa
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19
}).addTo(map);

// Marcador
var marker = L.marker([18.71, -98.95]).addTo(map);

// Click en el mapa
map.on('click', function(e) {
    const lat = e.latlng.lat;
    const lon = e.latlng.lng;

    marker.setLatLng([lat, lon]);
    document.getElementById("lat").value = lat;
    document.getElementById("lon").value = lon;
});
</script>

</main>
</body>
</html>
