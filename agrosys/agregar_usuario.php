<?php
include "conexion.php";

if(isset($_POST['guardar'])){
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $clave = $_POST['clave'];
    $tipo = $_POST['tipo_usuario'];

    $sql = "INSERT INTO Usuario (nombre, correo, contraseña, tipo_usuario) 
            VALUES ('$nombre', '$correo', '$clave', '$tipo')";

    if($conexion->query($sql) === TRUE){
        header("Location: usuarios.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Usuario</title>
</head>
<body>
    <h1>Agregar Usuario</h1>
    <form method="POST">
        Nombre: <input type="text" name="nombre" required><br><br>
        Correo: <input type="email" name="correo" required><br><br>
        Contraseña: <input type="password" name="clave" required><br><br>
        Tipo de Usuario: 
        <select name="tipo_usuario">
            <option value="admin">Admin</option>
            <option value="usuario">Usuario</option>
        </select><br><br>
        <input type="submit" name="guardar" value="Guardar Usuario">
    </form>
    <br>
    <a href="usuarios.php">Volver a Usuarios</a>
</body>
</html>
