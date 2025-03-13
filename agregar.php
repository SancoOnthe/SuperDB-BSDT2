<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $categoria = $_POST['categoria'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    $sql = "CALL AgregarProducto('$nombre', '$categoria', $precio, $stock)";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Producto agregado con éxito'); window.location='index.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Producto</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body class="container mt-5">
    <h3>Agregar Nuevo Producto</h3>
    <form method="POST">
        <label>Nombre:</label>
        <input type="text" name="nombre" class="form-control" required>
        <label>Categoría:</label>
        <input type="text" name="categoria" class="form-control" required>
        <label>Precio:</label>
        <input type="number" step="0.01" name="precio" class="form-control" required>
        <label>Stock:</label>
        <input type="number" name="stock" class="form-control" required>
        <br>
        <button type="submit" class="btn btn-primary">Agregar</button>
        <a href="index.php" class="btn btn-secondary">Volver</a>
    </form>
</body>
</html>
