<?php
include 'conexion.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $usuario = $resultado->fetch_assoc();

    if ($usuario && password_verify($contraseña, $usuario['contraseña'])) {
        $_SESSION['usuario'] = $usuario['nombre'];
        $_SESSION['rol'] = $usuario['rol'];

        header("Location: index.php");
    } else {
        echo "<script>alert('Correo o contraseña incorrectos');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
<div class="form-container">
    <h2>Iniciar Sesión</h2>
    <form action="procesar_login.php" method="POST">
        <input type="text" name="usuario" placeholder="Usuario" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Entrar</button>
    </form>
    <a href="registro.php">¿No tienes cuenta? Regístrate</a>
</div>
</body>
</html>
