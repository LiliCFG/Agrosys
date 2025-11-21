<?php
require_once "includes/conexion.php";
require_once "includes/auth.php";
include "includes/header.php";

$parcela = null;
if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id = (int)$_GET['id'];
    $stmt = $conexion->prepare("SELECT id_parcela, nombre, ubicacion, extension, tipo_suelo FROM Parcela WHERE id_parcela = ?");
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $res = $stmt->get_result();
    $parcela = $res->fetch_assoc();
    $stmt->close();
}

$error = "";
if($_SERVER['REQUEST_METHOD']==='POST'){
    $id = (int)$_POST['id'];
    $nombre = trim($_POST['nombre']);
    $ubicacion = trim($_POST['ubicacion']);
    $extension = trim($_POST['extension']);
    $tipo_suelo = trim($_POST['tipo_suelo']);
    if($nombre===''||$ubicacion===''||$extension===''||$tipo_suelo===''){ $error="Todos los campos obligatorios."; }
    else {
        $stmt = $conexion->prepare("UPDATE Parcela SET nombre=?, ubicacion=?, extension=?, tipo_suelo=? WHERE id_parcela=?");
        $stmt->bind_param("ssssi",$nombre,$ubicacion,$extension,$tipo_suelo,$id);
        if($stmt->execute()){ header("Location: parcelas.php"); exit(); }
        else { $error = "Error: ".$stmt->error; }
        $stmt->close();
    }
}
?>
<div class="contenedor" style="max-width:700px;">
    <h1>Editar Parcela</h1>
    <?php if($error): ?><div class="alert error"><?= htmlspecialchars($error); ?></div><?php endif; ?>
    <?php if(!$parcela): ?>
        <p>Parcela no encontrada.</p>
        <a class="btn cancelar" href="parcelas.php">← Volver</a>
    <?php else: ?>
    <form method="POST" class="formulario">
        <input type="hidden" name="id" value="<?= htmlspecialchars($parcela['id_parcela']); ?>">
        <label>Nombre</label><input type="text" name="nombre" value="<?= htmlspecialchars($parcela['nombre']); ?>" required>
        <label>Ubicación</label><input type="text" name="ubicacion" value="<?= htmlspecialchars($parcela['ubicacion']); ?>" required>
        <label>Extensión</label><input type="text" name="extension" value="<?= htmlspecialchars($parcela['extension']); ?>" required>
        <label>Tipo de Suelo</label><input type="text" name="tipo_suelo" value="<?= htmlspecialchars($parcela['tipo_suelo']); ?>" required>
        <div style="margin-top:12px;">
            <button class="btn guardar" type="submit">Actualizar</button>
            <a class="btn cancelar" href="parcelas.php">Cancelar</a>
        </div>
    </form>
    <?php endif; ?>
</div>
</main></body></html>
