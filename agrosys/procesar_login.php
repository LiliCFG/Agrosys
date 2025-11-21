<?php
session_start();
require_once "includes/conexion.php"; // Asegúrate de que este archivo funciona

// Verificar que se enviaron los datos
if (!isset($_POST['usuario'], $_POST['password'])) {
    header("Location: login.php");
    exit();
}

$usuario = $_POST['usuario'];
$password = $_POST['password'];

// Consulta para validar al usuario
$sql = "SELECT id_usuario, nombre, password FROM Usuario WHERE nombre = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $fila = $result->fetch_assoc();

    // Aquí puedes poner password_verify si luego usas hash
    if ($password === $fila['password']) {

        // Crear sesión
        $_SESSION['id_usuario'] = $fila['id_usuario'];
        $_SESSION['nombre'] = $fila['nombre'];

        header("Location: index.php");
        exit();
    }
}

// Si falla el login:
header("Location: login.php?error=1");
exit();
?>
