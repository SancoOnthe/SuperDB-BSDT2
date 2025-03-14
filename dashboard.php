<?php
include 'conexion.php';

// Obtener total de ventas
$totalVentasQuery = $conn->query("SELECT COUNT(*) AS total FROM ventas");
$totalVentas = $totalVentasQuery->fetch_assoc()['total'];

// Obtener producto más vendido
$productoQuery = $conn->query("
    SELECT p.nombre, SUM(dv.cantidad) AS total_vendido 
    FROM detalle_ventas dv 
    JOIN productos p ON dv.id_producto = p.id_producto 
    GROUP BY dv.id_producto 
    ORDER BY total_vendido DESC 
    LIMIT 1
");
$productoMasVendido = $productoQuery->fetch_assoc();

// Obtener cliente con más compras
$clienteQuery = $conn->query("
    SELECT c.nombre, COUNT(v.id_venta) AS total_compras 
    FROM ventas v 
    JOIN clientes c ON v.id_cliente = c.id_cliente 
    GROUP BY v.id_cliente 
    ORDER BY total_compras DESC 
    LIMIT 1
");
$clienteFrecuente = $clienteQuery->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Dashboard del Supermercado</h2>
        <p><strong>Total de Ventas:</strong> <?= $totalVentas ?></p>
        <p><strong>Producto Más Vendido:</strong> <?= $productoMasVendido['nombre'] ?> (<?= $productoMasVendido['total_vendido'] ?> unidades)</p>
        <p><strong>Cliente Más Frecuente:</strong> <?= $clienteFrecuente['nombre'] ?> (<?= $clienteFrecuente['total_compras'] ?> compras)</p>
        <a href="index.php" class="btn btn-primary">Volver</a>
    </div>
</body>
</html>
