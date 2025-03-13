<?php include 'conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos y Ventas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body class="bg-light">
    <div class="container text-center mt-5">
        <h2>Gestión de Productos y Ventas</h2>
        <p>Selecciona una acción:</p>
        <div class="d-grid gap-2 col-6 mx-auto">
            <a href="actualizar.php" class="btn btn-primary">Actualizar Stock</a>
            <a href="agregar.php" class="btn btn-info">Agregar Nuevo Producto</a>
            <a href="ver_productos.php" class="btn btn-secondary">Ver Productos por Categoría</a>
            <a href="ventas.php" class="btn btn-success">Consultar Ventas por Cliente</a>
        </div>
    </div>
</body>
</html>
