<?php
require_once "includes/conexion.php";
require_once "includes/auth.php";
include "includes/header.php";

$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $ubicacion = trim($_POST['ubicacion'] ?? '');
    $extension = trim($_POST['extension'] ?? '');
    $tipo_suelo = trim($_POST['tipo_suelo'] ?? '');

    if ($nombre===''|| $ubicacion===''|| $extension===''|| $tipo_suelo==='') {
        $error = "Todos los campos son obligatorios.";
    } else {
        $stmt = $conexion->prepare("INSERT INTO Parcela (nombre, ubicacion, extension, tipo_suelo) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nombre, $ubicacion, $extension, $tipo_suelo);
        if ($stmt->execute()) {
            header("Location: parcelas.php"); exit();
        } else {
            $error = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>
<div class="contenedor" style="max-width:700px;">
    <h1>Agregar Parcela</h1>
    <?php if($error): ?><div class="alert error"><?= htmlspecialchars($error); ?></div><?php endif; ?>
    <form method="POST" class="formulario">
        <label>Nombre</label><input type="text" name="nombre" required>
        <label>Ubicación</label><input type="text" name="ubicacion" required>
        <label>Extensión</label><input type="text" name="extension" required>
        <label>Tipo de Suelo</label><input type="text" name="tipo_suelo" required>
        <div style="margin-top:12px;">
            <button class="btn guardar" type="submit">Guardar</button>
            <a class="btn cancelar" href="parcelas.php">Cancelar</a>
        </div>
    </form>
</div>
</main></body></html>
