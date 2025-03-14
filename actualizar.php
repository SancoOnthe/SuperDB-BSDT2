<?php
include 'conexion.php'; // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_producto = $_POST["id_producto"];
    $nuevo_stock = $_POST["nuevo_stock"];

    if (is_numeric($id_producto) && is_numeric($nuevo_stock)) {
        $sql = "CALL ActualizarStock(?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $id_producto, $nuevo_stock);

        if ($stmt->execute()) {
            echo "<script>alert('Stock actualizado con éxito'); window.location='index.php';</script>";
        } else {
            echo "<script>alert('Error al actualizar el stock'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Datos inválidos'); window.history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Stock</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h3>Actualizar Stock</h3>
        <form action="actualizar.php" method="POST">
            <div class="mb-3">
                <label class="form-label">ID del Producto:</label>
                <input type="number" name="id_producto" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Nuevo Stock:</label>
                <input type="number" name="nuevo_stock" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="index.php" class="btn btn-secondary">Volver</a>
        </form>
    </div>
</body>
</html>
