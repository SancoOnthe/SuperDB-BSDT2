<?php
include 'conexion.php'; // Archivo de conexión a la base de datos

$ventas = []; // Asegurar que la variable está definida antes de su uso

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_cliente = $_POST["id_cliente"];

    if (is_numeric($id_cliente)) {
        $sql = "CALL ConsultarVentasPorCliente(?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_cliente);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $ventas[] = $row; // Guardar resultados en la variable $ventas
        }
    } else {
        echo "<script>alert('ID inválido'); window.history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consultar Ventas por Cliente</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h3>Consultar Ventas por Cliente</h3>
        <form action="ventas.php" method="POST">
            <div class="mb-3">
                <label class="form-label">ID del Cliente:</label>
                <input type="number" name="id_cliente" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Consultar</button>
            <a href="index.php" class="btn btn-secondary">Volver</a>
        </form>
        <a href="exportar.php" class="btn btn-success">Exportar a Excel</a>

        <?php if (!empty($ventas)): ?>
            <h3 class="mt-4">Resultados</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID Venta</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Cliente</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ventas as $venta): ?>
                        <tr>
                            <td><?= htmlspecialchars($venta['id_venta']) ?></td>
                            <td><?= htmlspecialchars($venta['fecha']) ?></td>
                            <td><?= htmlspecialchars($venta['total']) ?></td>
                            <td><?= htmlspecialchars($venta['cliente']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
