<?php
// includes/header.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agrosys</title>

    <!-- Tu CSS principal -->
    <link rel="stylesheet" href="/AGROSYS/css/estilos.css">

    <!-- Fuente Outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">

    </script>
</head>

<body>

<header class="topbar">

    <!-- LOGO -->
    <div class="logo">
        <img src="/AGROSYS/img/logo.png" alt="Logo Agrosys" class="logo-img">
        <span class="logo-text">AGROSYS</span>
    </div>

    <!-- Usuario -->
    <?php if (session_status() === PHP_SESSION_ACTIVE && isset($_SESSION['nombre'])): ?>
    <div class="user-box">
        <span class="user-name"><?= htmlspecialchars($_SESSION['nombre']); ?></span>
        <a class="btn-logout" href="logout.php">Cerrar sesión</a>
    </div>
    <?php endif; ?>

</header>

<main>
