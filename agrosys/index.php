<?php
// index.php — Panel principal de Agrosys
session_start();
// Si no hay sesión activa, redirigir (opcional)
// if(!isset($_SESSION['id_usuario'])){ header("Location: login.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Agrosys | Panel Principal</title>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/estilos.css">
</head>

<body>

  <!-- Barra superior -->
  <header class="topbar">
    <div class="logo">
        <img src="img/logo.png" alt="Logo Agrosys" class="logo-header">
        <span>AGROSYS</span>
    </div>

    <div class="user-box">
      <span>👤 Administrador</span>
      <a href="login.php" class="btn-logout">Cerrar sesión</a>
    </div>
  </header>

  <!-- Contenido principal -->
  <main class="menu-grid">

    <div class="card">
      <div class="icono">👤</div>
      <h2>Usuarios</h2>
      <p>Gestiona todos los usuarios del sistema.</p>
      <a href="usuarios.php" class="btn">Entrar</a>
    </div>

    <div class="card">
      <div class="icono">🌾</div>
      <h2>Parcelas</h2>
      <p>Administra todas las parcelas registradas.</p>
      <a href="parcelas.php" class="btn">Entrar</a>
    </div>

    <div class="card">
      <div class="icono">🧺</div>
      <h2>Actividades</h2>
      <p>Organiza las actividades agrícolas de tus cultivos.</p>
      <a href="actividades.php" class="btn">Entrar</a>
    </div>

    <div class="card">
      <div class="icono">🌡️</div>
      <h2>Condiciones</h2>
      <p>Monitorea la humedad y temperatura de las parcelas.</p>
      <a href="condiciones.php" class="btn">Entrar</a>
    </div>

  </main>

</body>
</html>
