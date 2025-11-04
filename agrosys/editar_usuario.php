<?php
include "conexion.php";

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "SELECT * FROM Usuario WHERE id_usuario = $id";
    $resultado = $conexion->query($sql);
    $usuario = $resultado->fetch_assoc();
}

if(isset($_POST['actualizar'])){
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $clave = $_POST['clave'];
    $tipo = $_POST['tipo_usuario'];

    $sql = "UPDATE Usuario SET 
                nombre='$nombre', 
                correo='$correo', 
                contraseña='$clave', 
                tipo_usuario='$tipo' 
            WHERE id_usuario=$id";

    if($conexion->query($sql) === TRUE){
        header("Location: usuarios.php");
    } else {
        echo "Error: " . $conexion->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
</head>
<body>
    <h1>Editar Usuario</h1>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $usuario['id_usuario']; ?>">
        Nombre: <input type="text" name="nombre" value="<?php echo $usuario['nombre']; ?>" required><br><br>
        Correo: <input type="email" name="correo" value="<?php echo $usuario['correo']; ?>" required><br><br>
        Contraseña: <input type="text" name="clave" value="<?php echo $usuario['contraseña']; ?>" required><br><br>
        Tipo de Usuario: 
        <select name="tipo_usuario">
            <option value="admin" <?php if($usuario['tipo_usuario']=="admin") echo "selected"; ?>>Admin</option>
            <option value="usuario" <?php if($usuario['tipo_usuario']=="usuario") echo "selected"; ?>>Usuario</option>
        </select><br><br>
        <input type="submit" name="actualizar" value="Actualizar Usuario">
    </form>
    <br>
    <a href="usuarios.php">Volver a Usuarios</a>
</body>
</html>
