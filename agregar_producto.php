<?php
session_start();
if (!isset($_SESSION["id_usuario"]) || $_SESSION["rol"] != "admin") {
    header("Location: login.php");
    exit();
}
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $precio = $_POST["precio"];
    $stock = $_POST["stock"];
    
    $sql = "INSERT INTO productos (nombre, precio, stock) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdi", $nombre, $precio, $stock);
    
    if ($stmt->execute()) {
        echo "<script>alert('Producto agregado exitosamente'); window.location='admin.php';</script>";
    } else {
        echo "<script>alert('Error al agregar producto'); window.history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Producto</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h3>Agregar Nuevo Producto</h3>
        <form method="POST">
            <label>Nombre del Producto:</label>
            <input type="text" name="nombre" required class="form-control">
            <label>Precio:</label>
            <input type="number" step="0.01" name="precio" required class="form-control">
            <label>Stock:</label>
            <input type="number" name="stock" required class="form-control">
            <br>
            <button type="submit" class="btn btn-success">Agregar</button>
        </form>
    </div>
</body>
</html>
