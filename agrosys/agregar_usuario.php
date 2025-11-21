<?php
require_once "includes/conexion.php";
require_once "includes/auth.php";
include "includes/header.php";

// Mensaje de error
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = trim($_POST['nombre'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $clave = trim($_POST['clave'] ?? '');
    $tipo = $_POST['tipo_usuario'] ?? 'usuario';

    if ($nombre === '' || $correo === '' || $clave === '') {
        $error = "Todos los campos son obligatorios.";
    } else {

        // Encriptar contraseña
        $hash = password_hash($clave, PASSWORD_DEFAULT);

        // Guardar en BD
        $stmt = $conexion->prepare(
            "INSERT INTO Usuario (nombre, correo, password, tipo_usuario)
             VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("ssss", $nombre, $correo, $hash, $tipo);

        if ($stmt->execute()) {
            header("Location: usuarios.php");
            exit();
        } else {
            $error = "Error al guardar: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>

<link rel="stylesheet" href="css/usuarios.css">

<div class="form-box">
    <h2>Agregar Usuario</h2>

    <?php if ($error): ?>
        <div class="alert error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">

        <label>Nombre</label>
        <input type="text" name="nombre" required>

        <label>Correo</label>
        <input type="email" name="correo" required>

        <label>Contraseña</label>
        <input type="password" name="clave" required>

        <label>Tipo de usuario</label>
        <select name="tipo_usuario">
            <option value="admin">Administrador</option>
            <option value="usuario" selected>Usuario</option>
        </select>

        <div class="form-actions">
            <button class="btn guardar" type="submit">Guardar</button>
            <a href="usuarios.php" class="btn cancelar">Cancelar</a>
        </div>
    </form>
</div>

</main></body></html>
