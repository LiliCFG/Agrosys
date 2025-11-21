<?php
require_once "includes/conexion.php";
require_once "includes/auth.php";
include "includes/header.php";

// Obtener parcelas
$parcelas = $conexion->query("SELECT id_parcela, nombre FROM Parcela");

// Obtener condición existente
$condicion = null;
if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id = (int)$_GET['id'];
    $stmt = $conexion->prepare("SELECT id_condicion, fecha, humedad, temperatura, id_parcela 
                                FROM CondicionCultivo WHERE id_condicion = ?");
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $res = $stmt->get_result();
    $condicion = $res->fetch_assoc();
    $stmt->close();
}

$error = "";
if($_SERVER['REQUEST_METHOD']==='POST'){
    $id = (int)$_POST['id'];
    $fecha = $_POST['fecha'] ?? '';
    $humedad = $_POST['humedad'] ?? '';
    $temperatura = $_POST['temperatura'] ?? '';
    $id_parcela = $_POST['id_parcela'] ?? '';

    if($fecha==='' || $humedad==='' || $temperatura==='' || $id_parcela===''){
        $error = "Todos los campos son obligatorios.";
    } else {
        $stmt = $conexion->prepare("UPDATE CondicionCultivo 
                                    SET fecha=?, humedad=?, temperatura=?, id_parcela=? 
                                    WHERE id_condicion=?");
        $stmt->bind_param("sddii",$fecha,$humedad,$temperatura,$id_parcela,$id);

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
    <h1>Editar Condición</h1>

    <?php if($error): ?>
        <div class="alert error"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php if(!$condicion): ?>
        <p>Condición no encontrada.</p>
        <a class="btn cancelar" href="condiciones.php">← Volver</a>
    <?php else: ?>
    <form method="POST" class="formulario">

        <input type="hidden" name="id" value="<?= htmlspecialchars($condicion['id_condicion']); ?>">

        <label>Fecha</label>
        <input type="date" name="fecha" 
               value="<?= htmlspecialchars($condicion['fecha']); ?>" required>

        <label>Humedad (%)</label>
        <input type="number" step="0.1" name="humedad" 
               value="<?= htmlspecialchars($condicion['humedad']); ?>" required>

        <label>Temperatura (°C)</label>
        <input type="number" step="0.1" name="temperatura" 
               value="<?= htmlspecialchars($condicion['temperatura']); ?>" required>

        <label>Parcela</label>
        <select name="id_parcela" required>
            <option value="">Selecciona una parcela</option>
            <?php
            $parcelas = $conexion->query("SELECT id_parcela, nombre FROM Parcela");
            while($p = $parcelas->fetch_assoc()):
                $sel = ($p['id_parcela'] == $condicion['id_parcela']) ? 'selected' : '';
            ?>
                <option value="<?= $p['id_parcela']; ?>" <?= $sel; ?>>
                    <?= htmlspecialchars($p['nombre']); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <div style="margin-top:12px;">
            <button class="btn guardar" type="submit">Actualizar</button>
            <a class="btn cancelar" href="condiciones.php">Cancelar</a>
        </div>
    </form>
    <?php endif; ?>
</div>
</main></body></html>
