<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);
    $rol = $_POST['rol']; // Puede ser 'admin' o 'cliente'

    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, correo, contraseña, rol) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $correo, $contraseña, $rol);

    if ($stmt->execute()) {
        echo "<script>alert('Registro exitoso. Ahora puedes iniciar sesión.'); window.location='login.php';</script>";
    } else {
        echo "<script>alert('Error al registrar. Intenta con otro correo.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="sre.css">
</head>
<body>
    <div class="container">
        <h2>Registro de Usuario</h2>
        <form action="procesar_registro.php" method="post">
            <input type="text" name="nombre" placeholder="Nombre" required><br>
            <input type="email" name="correo" placeholder="Correo electrónico" required><br>
            <input type="password" name="contraseña" placeholder="Contraseña" required minlength="6"><br>
            <select name="rol" required>
                <option value="cliente">Cliente</option>
                <option value="admin">Administrador</option>
            </select><br>
            <button type="submit">Registrarse</button>
        </form>
        <a href="login.php" style="color: cyan; text-decoration: none;">¿Ya tienes cuenta? Inicia sesión</a>
    </div>
</body>
</html>

