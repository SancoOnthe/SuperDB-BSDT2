<?php
include 'conexion.php';

$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';
$sql = "SELECT * FROM Productos";
if ($categoria) {
    $sql .= " WHERE categoria = '$categoria'";
}
$productos = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos por Categoría</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body class="container mt-5">
    <h3>Ver Productos por Categoría</h3>
    <form method="GET">
        <label>Filtrar por Categoría:</label>
        <input type="text" name="categoria" class="form-control">
        <br>
        <button type="submit" class="btn btn-primary">Filtrar</button>
    </form>
    <br>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $productos->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['id_producto'] ?></td>
                    <td><?= $row['nombre'] ?></td>
                    <td><?= $row['categoria'] ?></td>
                    <td><?= $row['precio'] ?></td>
                    <td><?= $row['stock'] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <a href="index.php" class="btn btn-secondary">Volver</a>
</body>
</html>
