<?php
session_start();
require_once "includes/conexion.php"; // tu conexión MySQL

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = trim($_POST["usuario"]);
    $password = trim($_POST["password"]);

    // Buscar usuario en la base de datos
    $sql = "SELECT id_usuario, nombre, usuario, password FROM usuarios WHERE usuario = ? OR correo = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ss", $usuario, $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $row = $resultado->fetch_assoc();

        // Verifica la contraseña (usa password_hash() en la BD si puedes)
        if (password_verify($password, $row["password"])) {
            // Guardar datos en sesión
            $_SESSION["id_usuario"] = $row["id_usuario"];
            $_SESSION["nombre"] = $row["nombre"];
            $_SESSION["usuario"] = $row["usuario"];

            header("Location: index.php");
            exit();
        } else {
            echo "<script>alert('Contraseña incorrecta'); window.location='login.php';</script>";
        }
    } else {
        echo "<script>alert('Usuario no encontrado'); window.location='login.php';</script>";
    }

    $stmt->close();
}
?>
