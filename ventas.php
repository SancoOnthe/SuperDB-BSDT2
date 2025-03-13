<?php
include 'conexion.php';

$id_cliente = isset($_GET['id_cliente']) ? $_GET['id_cliente'] : '';
$ventas = [];

if ($id_cliente) {
    $sql = "CALL ConsultarVentasPorCliente($id_cliente)";
    $result = $conn->query($sql);
    if ($result) {
        $ventas = $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consultar Ventas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body class="container mt-5">
    <h3>Consultar Ventas por Cliente</h3>
    <form method="GET">
        <label>ID Cliente:</label>
        <input type="number" name="id_cliente" class="form-control" required>
        <br>
        <button type="submit" class="btn btn-primary">Consultar</button>
    </form>
    <br>
    <?php if ($ventas) { ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Venta</th>
                    <th>Fecha</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ventas as $venta) { ?>
                    <tr>
                        <td><?= $venta['id_venta'] ?></td>
                        <td><?= $venta['fecha'] ?></td>
                        <td><?= $venta['total'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>No hay ventas registradas para este cliente.</p>
    <?php } ?>
    <a href="index.php" class="btn btn-secondary">Volver</a>
</body>
</html>
