<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Productos y Ventas</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Bienvenido, <?= $_SESSION['usuario']; ?></h2>

        <?php if ($_SESSION['rol'] == 'admin'): ?>
            <a href="dashboard.php" class="btn btn-primary">Ver Dashboard</a>
            <a href="agregar.php" class="btn btn-primary">Agregar Producto</a>
        <?php endif; ?>

        <a href="ventas.php" class="btn btn-primary">Consultar Ventas</a>
        <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
    </div>
</body>
</html>

