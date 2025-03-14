<?php
include 'conexion.php';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=ventas.xls");

echo "ID Venta\tFecha\tTotal\tCliente\n";

$result = $conn->query("SELECT v.id_venta, v.fecha, v.total, c.nombre AS cliente FROM ventas v JOIN clientes c ON v.id_cliente = c.id_cliente");

while ($row = $result->fetch_assoc()) {
    echo "{$row['id_venta']}\t{$row['fecha']}\t{$row['total']}\t{$row['cliente']}\n";
}
?>
