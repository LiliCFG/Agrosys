<?php
require_once "includes/conexion.php";
require_once "includes/auth.php";
include "includes/header.php";

// Obtener lista de parcelas
$parcelas = $conexion->query("SELECT id_parcela, nombre FROM Parcela");

// Valores por defecto
$actividad = [
    'id_actividad' => '',
    'tipo' => '',
    'fecha' => '',
    'descripcion' => '',
    'id_parcela' => ''
];

// Si viene ID → cargar datos
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $conexion->prepare("
        SELECT id_actividad, tipo, fecha, descripcion, id_parcela 
        FROM Actividad WHERE id_actividad = ?
    ");
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $res = $stmt->get_result();
    $actividad = $res->fetch_assoc();
    $stmt->close();
}

$error = "";

// Si se envió formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id'];
    $tipo = trim($_POST['tipo']);
    $fecha = $_POST['fecha'];
    $descripcion = trim($_POST['descripcion']);
    $id_parcela = (int)$_POST['id_parcela'];

    $stmt = $conexion->prepare("
        UPDATE Actividad 
        SET tipo=?, fecha=?, descripcion=?, id_parcela=? 
        WHERE id_actividad=?
    ");

    $stmt->bind_param("sssii",$tipo,$fecha,$descripcion,$id_parcela,$id);

    if ($stmt->execute()) {
        header("Location: actividades.php");
        exit();
    } else {
        $error = "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<div class="form-box">
    <h2>Editar Actividad</h2>

    <?php if (!empty($error)): ?>
        <div class="alert error"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($actividad['id_actividad']); ?>">

        <label>Tipo de actividad</label>
        <input type="text" name="tipo" value="<?= htmlspecialchars($actividad['tipo']); ?>" required>

        <label>Fecha</label>
        <input type="date" name="fecha" value="<?= htmlspecialchars($actividad['fecha']); ?>" required>

        <label>Descripción</label>
        <textarea name="descripcion" required><?= htmlspecialchars($actividad['descripcion']); ?></textarea>

        <label>Parcela asociada</label>
        <select name="id_parcela" required>
            <?php 
            $parcelas = $conexion->query("SELECT id_parcela, nombre FROM Parcela");
            while ($p = $parcelas->fetch_assoc()):
                $sel = ($p['id_parcela'] == $actividad['id_parcela']) ? "selected" : "";
            ?>
            <option value="<?= $p['id_parcela']; ?>" <?= $sel; ?>>
                <?= htmlspecialchars($p['nombre']); ?>
            </option>
            <?php endwhile; ?>
        </select>

        <div class="form-actions">
            <button class="btn guardar" type="submit">Actualizar</button>
            <a class="btn cancelar" href="actividades.php">Cancelar</a>
        </div>
    </form>
</div>

</main></body></html>
