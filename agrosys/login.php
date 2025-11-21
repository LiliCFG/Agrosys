<?php
require_once "includes/conexion.php";
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $usuario = trim($_POST["usuario"]);
    $password = trim($_POST["password"]);

    // Buscar usuario por correo o nombre
    $sql = "SELECT * FROM Usuario WHERE correo = ? OR nombre = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ss", $usuario, $usuario);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        $row = $res->fetch_assoc();

        // SIN HASH: comparación directa
        if ($password === $row["password"]) {

            $_SESSION["id_usuario"] = $row["id_usuario"];
            $_SESSION["nombre"] = $row["nombre"];
            $_SESSION["tipo_usuario"] = $row["tipo_usuario"];

            header("Location: index.php");
            exit();

        } else {
            $error = "❌ Contraseña incorrecta";
        }
    } else {
        $error = "❌ Usuario no encontrado";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login | Agrosys</title>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/estilos.css">
</head>

<body class="login-container">

<div class="login-card">

    <!-- LOGO -->
    <img src="img/logo.png" alt="Logo Agrosys" class="logo-login">

    <h1>Bienvenido a <span>Agrosys</span></h1>
    <p>Inicia sesión para gestionar tus cultivos 🌱</p>


    <?php if (!empty($error)): ?>
        <div class="error-msg"><?= $error ?></div>
    <?php endif; ?>

    <form action="login.php" method="post" class="neo-form">
      <input type="text" name="usuario" placeholder="Usuario o correo" required>
      <input type="password" name="password" placeholder="Contraseña" required>

      <button type="submit" class="btn">Ingresar</button>
    </form>

  </div>

</body>
</html>
