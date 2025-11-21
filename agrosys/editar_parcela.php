<?php
require_once "includes/conexion.php";
require_once "includes/auth.php";
include "includes/header.php";

$parcela = null;

// Obtener parcela a editar
if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id = (int)$_GET['id'];
    $stmt = $conexion->prepare("SELECT id_parcela, nombre, ubicacion, extension, tipo_suelo, lat, lon, comunidad 
                                FROM Parcela WHERE id_parcela = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $parcela = $res->fetch_assoc();
    $stmt->close();
}

$error = "";

// Guardar cambios
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $id = (int)$_POST['id'];
    $nombre = trim($_POST['nombre']);
    $ubicacion = trim($_POST['ubicacion']);
    $extension = trim($_POST['extension']);
    $tipo_suelo = trim($_POST['tipo_suelo']);
    $lat = trim($_POST['lat']);
    $lon = trim($_POST['lon']);
    $comunidad = trim($_POST['comunidad']);

    if ($nombre === '' || $ubicacion === '' || $extension === '' || 
        $tipo_suelo === '' || $lat === '' || $lon === '' || $comunidad === '') {
        
        $error = "Todos los campos son obligatorios.";
    } 
    else {
        $stmt = $conexion->prepare(
            "UPDATE Parcela 
             SET nombre=?, ubicacion=?, extension=?, tipo_suelo=?, lat=?, lon=?, comunidad=?
             WHERE id_parcela=?"
        );

        // lat/lon como decimales
        $stmt->bind_param("ssssddsi", 
            $nombre, $ubicacion, $extension, $tipo_suelo,
            $lat, $lon, $comunidad, $id
        );

        if ($stmt->execute()) {
            header("Location: parcelas.php");
            exit();
        } else {
            $error = "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>

<div class="contenedor" style="max-width:700px;">
    <h1>Editar Parcela</h1>

    <?php if($error): ?>
        <div class="alert error"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php if(!$parcela): ?>
        <p>Parcela no encontrada.</p>
        <a class="btn cancelar" href="parcelas.php">← Volver</a>

    <?php else: ?>

    <form method="POST" class="formulario">
        <input type="hidden" name="id" value="<?= htmlspecialchars($parcela['id_parcela']); ?>">

        <label>Nombre</label>
        <input type="text" name="nombre" value="<?= htmlspecialchars($parcela['nombre']); ?>" required>

        <label>Ubicación</label>
        <input type="text" name="ubicacion" value="<?= htmlspecialchars($parcela['ubicacion']); ?>" required>

        <label>Extensión</label>
        <input type="text" name="extension" value="<?= htmlspecialchars($parcela['extension']); ?>" required>

        <label>Tipo de Suelo</label>
        <input type="text" name="tipo_suelo" value="<?= htmlspecialchars($parcela['tipo_suelo']); ?>" required>

        <label>Latitud</label>
        <input type="text" name="lat" value="<?= htmlspecialchars($parcela['lat']); ?>" required>

        <label>Longitud</label>
        <input type="text" name="lon" value="<?= htmlspecialchars($parcela['lon']); ?>" required>

        <label>Comunidad</label>
        <select name="comunidad" required>
            <option value="">Seleccione una opción</option>
            <option value="San Rafael" 
                <?= $parcela['comunidad'] === "San Rafael" ? "selected" : "" ?>>
                San Rafael
            </option>
            <option value="San Juan Ahuehueyo" 
                <?= $parcela['comunidad'] === "San Juan Ahuehueyo" ? "selected" : "" ?>>
                San Juan Ahuehueyo
            </option>
        </select>

        <div style="margin-top:12px;">
            <button class="btn guardar" type="submit">Actualizar</button>
            <a class="btn cancelar" href="parcelas.php">Cancelar</a>
        </div>
    </form>

    <?php endif; ?>

</div>

</main></body></html>
