<?php
include "conexion.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agrosys</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f4f4f4; }
        h1 { color: #2c3e50; }
        .menu { display: flex; flex-wrap: wrap; gap: 20px; }
        .card {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 2px 5px rgba(0,0,0,0.2);
            flex: 1 1 200px;
            text-align: center;
        }
        .card a { text-decoration: none; color: #2980b9; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Agrosys</h1>
    <div class="menu">
        <div class="card">
            <h2>Usuarios</h2>
            <p>Gestiona todos los usuarios</p>
            <a href="usuarios.php">Ir a Usuarios</a>
        </div>
        <div class="card">
            <h2>Parcelas</h2>
            <p>Gestiona todas las parcelas</p>
            <a href="parcelas.php">Ir a Parcelas</a>
        </div>
        <div class="card">
            <h2>Actividades</h2>
            <p>Gestiona todas las actividades</p>
            <a href="actividades.php">Ir a Actividades</a>
        </div>
        <div class="card">
            <h2>Condiciones de Cultivo</h2>
            <p>Registra humedad y temperatura</p>
            <a href="condiciones.php">Ir a Condiciones</a>
        </div>
    </div>
</body>
</html>
