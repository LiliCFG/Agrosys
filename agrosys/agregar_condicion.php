<?php
require_once "includes/conexion.php";
require_once "includes/auth.php";
include "includes/header.php";

// Ahora también obtenemos LAT y LON
$parcelas = $conexion->query("SELECT id_parcela, nombre, lat, lon FROM Parcela");

$error = "";
if($_SERVER['REQUEST_METHOD']==='POST'){
    $fecha = $_POST['fecha'] ?? '';
    $humedad = $_POST['humedad'] ?? '';
    $temperatura = $_POST['temperatura'] ?? '';
    $id_parcela = $_POST['id_parcela'] ?? '';

    if($fecha==='' || $humedad==='' || $temperatura==='' || $id_parcela===''){ 
        $error="Todos los campos son obligatorios."; 
    } else {
        $stmt = $conexion->prepare("INSERT INTO CondicionCultivo (fecha, humedad, temperatura, id_parcela) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sddi",$fecha,$humedad,$temperatura,$id_parcela);

        if($stmt->execute()){ 
            header("Location: condiciones.php"); 
            exit(); 
        } else { 
            $error = "Error: " . $stmt->error; 
        }
        $stmt->close();
    }
}
?>
<div class="contenedor" style="max-width:700px;">
    <h1>Agregar Condición</h1>

    <?php if($error): ?>
        <div class="alert error"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" class="formulario">

        <label>Fecha</label>
        <input type="date" name="fecha" required>

        <label>Humedad (%)</label>
        <input type="number" step="0.1" name="humedad" required>

        <label>Temperatura (°C)</label>
        <input type="number" step="0.1" name="temperatura" required>

        <label>Parcela</label>
        <select name="id_parcela" id="parcela" required>
            <option value="">Selecciona una parcela</option>
            <?php while($p = $parcelas->fetch_assoc()): ?>
                <option 
                    value="<?= $p['id_parcela']; ?>"
                    data-lat="<?= $p['lat']; ?>"
                    data-lon="<?= $p['lon']; ?>"
                >
                    <?= htmlspecialchars($p['nombre']); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <!-- Botón para obtener clima -->
        <div style="margin-top:15px;">
            <button type="button" class="btn guardar" id="btnClima">
                Obtener clima actual
            </button>
        </div>

        <!-- Panel de resultados -->
        <div id="panelClima" style="
            margin-top:15px;
            padding:15px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            display:none;
        ">
            <p><strong>📍 Parcela:</strong> <span id="pc_nombre"></span></p>
            <p><strong>🌡 Temperatura:</strong> <span id="pc_temp"></span> °C</p>
            <p><strong>💧 Humedad:</strong> <span id="pc_hum"></span> %</p>
        </div>

        <div style="margin-top:12px;">
            <button class="btn guardar" type="submit">Guardar</button>
            <a class="btn cancelar" href="condiciones.php">Cancelar</a>
        </div>
    </form>
</div>

<!-- SCRIPT PARA API -->
<script>
document.getElementById("btnClima").addEventListener("click", function() {

    const select = document.getElementById("parcela");
    const opt = select.options[select.selectedIndex];

    if (!opt.value) {
        alert("Selecciona una parcela primero");
        return;
    }

    const lat = opt.dataset.lat;
    const lon = opt.dataset.lon;
    const nombre = opt.textContent;

    const url = `https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&hourly=temperature_2m,relative_humidity_2m&current_weather=true`;

    fetch(url)
        .then(r => r.json())
        .then(data => {

            const temp = data.current_weather.temperature;
            const hum = data.hourly.relative_humidity_2m[0];

            document.getElementById("panelClima").style.display = "block";
            document.getElementById("pc_nombre").textContent = nombre;
            document.getElementById("pc_temp").textContent = temp;
            document.getElementById("pc_hum").textContent = hum;

            document.querySelector('input[name="temperatura"]').value = temp;
            document.querySelector('input[name="humedad"]').value = hum;
        })
        .catch(() => {
            alert("Error obteniendo datos del clima");
        });
});
</script>

</main></body></html>
