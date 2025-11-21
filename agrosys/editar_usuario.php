<?php
require_once "includes/conexion.php";
require_once "includes/auth.php";
include "includes/header.php";

$usuario = null;

// Obtener usuario
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $conexion->prepare(
        "SELECT id_usuario, nombre, correo, password, tipo_usuario 
         FROM Usuario WHERE id_usuario = ?"
    );
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $usuario = $res->fetch_assoc();
    $stmt->close();
}

$error = "";

// Procesar actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id'];
    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $clave = trim($_POST['clave']);
    $tipo = $_POST['tipo_usuario'];

    if ($nombre === '' || $correo === '') {
        $error = "Nombre y correo son obligatorios.";
    } else {
        // Si escriben una clave nueva → se hashea
        if ($clave !== '') {
            $hash = password_hash($clave, PASSWORD_DEFAULT);
        } else {
            // Se mantiene la actual
            $stmt = $conexion->prepare("SELECT password FROM Usuario WHERE id_usuario = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            $hash = $result['password'];
            $stmt->close();
        }

        $stmt = $conexion->prepare(
            "UPDATE Usuario 
             SET nombre=?, correo=?, password=?, tipo_usuario=? 
             WHERE id_usuario=?"
        );
        $stmt->bind_param("ssssi", $nombre, $correo, $hash, $tipo, $id);

        if ($stmt->execute()) {
            header("Location: usuarios.php");
            exit();
        } else {
            $error = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<div class="form-box">
    <h2>Editar Usuario</h2>

    <?php if ($error): ?>
        <div class="alert error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if (!$usuario): ?>
        <p>Usuario no encontrado.</p>
        <a href="usuarios.php" class="btn cancelar">← Regresar</a>

    <?php else: ?>
    <form method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($usuario['id_usuario']) ?>">

        <label>Nombre</label>
        <input type="text" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>

        <label>Correo</label>
        <input type="email" name="correo" value="<?= htmlspecialchars($usuario['correo']) ?>" required>

        <label>Nueva contraseña (opcional)</label>
        <input type="password" name="clave" placeholder="Dejar vacío para conservar">

        <label>Tipo de usuario</label>
        <select name="tipo_usuario">
            <option value="admin" <?= $usuario['tipo_usuario'] == 'admin' ? 'selected' : '' ?>>
                Administrador
            </option>
            <option value="usuario" <?= $usuario['tipo_usuario'] == 'usuario' ? 'selected' : '' ?>>
                Usuario
            </option>
        </select>

        <div class="form-actions">
            <button class="btn guardar" type="submit">Actualizar</button>
            <a href="usuarios.php" class="btn cancelar">Cancelar</a>
        </div>
    </form>
    <?php endif; ?>
</div>

</main></body></html>
