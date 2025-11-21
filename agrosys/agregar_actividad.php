<?php
require_once "includes/conexion.php";
require_once "includes/auth.php";
include "includes/header.php";

$parcelas = $conexion->query("SELECT id_parcela, nombre FROM Parcela");
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo = trim($_POST['tipo'] ?? '');
    $fecha = $_POST['fecha'] ?? '';
    $descripcion = trim($_POST['descripcion'] ?? '');
    $id_parcela = $_POST['id_parcela'] ?? '';

    if ($tipo === '' || $fecha === '' || $descripcion === '' || $id_parcela === '') {
        $error = "Todos los campos son obligatorios.";
    } else {
        $stmt = $conexion->prepare(
            "INSERT INTO Actividad (tipo, fecha, descripcion, id_parcela) 
             VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("sssi", $tipo, $fecha, $descripcion, $id_parcela);

        if ($stmt->execute()) {
            header("Location: actividades.php");
            exit();
        } else {
            $error = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<div class="form-box">
    <h2>Agregar Actividad</h2>

    <?php if ($error): ?>
        <div class="alert error"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST">

        <label>Tipo de Actividad</label>
        <input type="text" name="tipo" placeholder="Ej. Riego, Fertilización" required>

        <label>Fecha</label>
        <input type="date" name="fecha" required>

        <label>Descripción</label>
        <textarea name="descripcion" style="height: 120px;" required></textarea>

        <label>Parcela</label>
        <select name="id_parcela" required>
            <option value="">Selecciona una parcela</option>
            <?php while ($p = $parcelas->fetch_assoc()): ?>
                <option value="<?= $p['id_parcela']; ?>">
                    <?= htmlspecialchars($p['nombre']); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <div class="form-actions">
            <button class="btn guardar" type="submit">Guardar</button>
            <a class="btn cancelar" href="actividades.php">Cancelar</a>
        </div>
    </form>
</div>

</main></body></html>
