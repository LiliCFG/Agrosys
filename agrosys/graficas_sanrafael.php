<?php
require_once "includes/conexion.php";
require_once "includes/auth.php";
include "includes/header.php";
?>

<div class="contenedor">
    <h1>Gráfica de Temperatura y Humedad – Últimos 7 días (San Rafael Morelos)</h1>

    <div style="background:white;padding:20px;border-radius:15px;
                box-shadow:0 0 10px rgba(0,0,0,0.1);margin-bottom:25px;">
        <canvas id="graficaSR" height="90"></canvas>
    </div>

    <a class="btn cancelar" href="condiciones.php">← Volver</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="grafica.js"></script>

<script>
    cargarGrafica("sanrafael", "graficaSR");
</script>

</main></body></html>
