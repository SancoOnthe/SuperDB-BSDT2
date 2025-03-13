<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_producto = $_POST['id_producto'];
    $nuevo_stock = $_POST['nuevo_stock'];

    $sql = "CALL ActualizarStock($id_producto, $nuevo_stock)";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Stock actualizado correctamente'); window.location='index.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

$productos = $conn->query("SELECT id_producto, nombre FROM Productos");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Stock</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body class="container mt-5">
    <h3>Actualizar Stock</h3>
    <form method="POST">
        <label>Selecciona un Producto:</label>
        <select name="id_producto" class="form-control" required>
            <?php while ($row = $productos->fetch_assoc()) { ?>
                <option value="<?= $row['id_producto'] ?>"><?= $row['nombre'] ?></option>
            <?php } ?>
        </select>
        <label>Nuevo Stock:</label>
        <input type="number" name="nuevo_stock" class="form-control" required>
        <br>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="index.php" class="btn btn-secondary">Volver</a>
    </form>
</body>
</html>
