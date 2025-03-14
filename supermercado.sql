-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-03-2025 a las 02:41:02
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `supermercado`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarPrecio` (IN `p_id_producto` INT, IN `p_nuevo_precio` DECIMAL(10,2))   BEGIN
    UPDATE Productos 
    SET precio = p_nuevo_precio 
    WHERE id_producto = p_id_producto;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarStock` (IN `p_id_producto` INT, IN `p_nuevo_stock` INT)   BEGIN
    UPDATE productos 
    SET stock = p_nuevo_stock
    WHERE id_producto = p_id_producto;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `AgregarProducto` (IN `p_nombre` VARCHAR(100), IN `p_categoria` VARCHAR(50), IN `p_precio` DECIMAL(10,2), IN `p_stock` INT)   BEGIN
    INSERT INTO Productos (nombre, categoria, precio, stock) 
    VALUES (p_nombre, p_categoria, p_precio, p_stock);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `AgregarProductoAVenta` (IN `p_id_venta` INT, IN `p_id_producto` INT, IN `p_cantidad` INT)   BEGIN
    DECLARE v_precio DECIMAL(10,2);
    DECLARE v_stock INT;
    
    -- Obtener el precio y stock del producto
    SELECT precio, stock INTO v_precio, v_stock FROM Productos WHERE id_producto = p_id_producto;
    
    -- Verificar si hay suficiente stock
    IF v_stock >= p_cantidad THEN
        -- Insertar en Detalle_Venta
        INSERT INTO Detalle_Venta (id_venta, id_producto, cantidad, subtotal) 
        VALUES (p_id_venta, p_id_producto, p_cantidad, v_precio * p_cantidad);
        
        -- Restar stock
        UPDATE Productos SET stock = stock - p_cantidad WHERE id_producto = p_id_producto;
    ELSE
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Stock insuficiente';
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CalcularTotalVenta` (IN `p_id_venta` INT)   BEGIN
    DECLARE v_total DECIMAL(10,2);
    
    -- Calcular la suma de los subtotales
    SELECT SUM(subtotal) INTO v_total FROM Detalle_Venta WHERE id_venta = p_id_venta;
    
    -- Actualizar el total en la tabla Ventas
    UPDATE Ventas SET total = v_total WHERE id_venta = p_id_venta;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarVentasPorCliente` (IN `p_id_cliente` INT)   BEGIN
    SELECT v.id_venta, v.fecha, v.total, c.nombre AS cliente
    FROM ventas v
    JOIN clientes c ON v.id_cliente = c.id_cliente
    WHERE v.id_cliente = p_id_cliente;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RegistrarVenta` (IN `p_id_cliente` INT, OUT `p_id_venta` INT)   BEGIN
    INSERT INTO Ventas (id_cliente, total) VALUES (p_id_cliente, 0);
    SET p_id_venta = LAST_INSERT_ID();
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nombre`, `telefono`, `email`, `correo`) VALUES
(1, 'Juan Pérez', NULL, NULL, 'juan@example.com'),
(2, 'María Gómez', NULL, NULL, 'maria@example.com'),
(3, 'Carlos Rodríguez', NULL, NULL, 'carlos@example.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `id_detalle` int(11) NOT NULL,
  `id_venta` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ventas`
--

CREATE TABLE `detalle_ventas` (
  `id_detalle` int(11) NOT NULL,
  `id_venta` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) GENERATED ALWAYS AS (`cantidad` * `precio_unitario`) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_ventas`
--

INSERT INTO `detalle_ventas` (`id_detalle`, `id_venta`, `id_producto`, `cantidad`, `precio_unitario`) VALUES
(1, 1, 1, 2, 2500.00),
(2, 2, 2, 2, 3000.00),
(3, 3, 3, 3, 1800.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre`, `categoria`, `precio`, `stock`) VALUES
(1, 'Arroz', NULL, 2500.00, 50),
(2, 'Frijoles', NULL, 3000.00, 40),
(3, 'Azúcar', NULL, 1800.00, 60);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `contraseña` varchar(255) DEFAULT NULL,
  `rol` enum('admin','cliente') DEFAULT 'cliente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `correo`, `contraseña`, `rol`) VALUES
(1, 'RONALD DAVID e', 'ronal23sancho@gmail.com', '$2y$10$ztYiXbm3bxASrYFWGMnRvOX6ZLFrc.W5wyNmdX3dGOPFIOQj5xrnm', 'admin'),
(2, 'RONALD DAVID', 'rdsanchez@miuniclaretiana.edu.co', '$2y$10$UyicqTfcopS7joNN9B7E0umui/MrMCJ1NE81eRt7pagTfA0K/KaIK', 'cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id_venta` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id_venta`, `id_cliente`, `fecha`, `total`) VALUES
(1, 1, '2024-03-10 05:00:00', 5000.00),
(2, 2, '2024-03-11 05:00:00', 6000.00),
(3, 1, '2024-03-12 05:00:00', 7500.00);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_venta` (`id_venta`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_venta` (`id_venta`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id_venta`),
  ADD KEY `ventas_ibfk_1` (`id_cliente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD CONSTRAINT `detalle_venta_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id_venta`),
  ADD CONSTRAINT `detalle_venta_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD CONSTRAINT `detalle_ventas_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id_venta`),
  ADD CONSTRAINT `detalle_ventas_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
