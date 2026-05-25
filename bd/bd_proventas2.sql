-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-05-2026 a las 04:37:11
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
-- Base de datos: `bd_proventas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacenes`
--

CREATE TABLE `almacenes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sucursal_id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `almacenes`
--

INSERT INTO `almacenes` (`id`, `sucursal_id`, `nombre`, `descripcion`, `estado`, `created_at`, `updated_at`) VALUES
(1, 7, 'Almacén Principal Lima', 'Almacén central', 1, '2026-05-21 02:21:02', '2026-05-21 02:21:02'),
(2, 7, 'Almacén Secundario Lima', 'Stock auxiliar', 1, '2026-05-21 02:21:02', '2026-05-21 02:21:02'),
(3, 8, 'Almacén San Isidro', 'Almacén principal sede San Isidro', 1, '2026-05-21 02:21:02', '2026-05-21 02:21:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cajas`
--

CREATE TABLE `cajas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sucursal_id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `estado` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cajas`
--

INSERT INTO `cajas` (`id`, `sucursal_id`, `nombre`, `estado`, `created_at`, `updated_at`) VALUES
(1, 7, 'Caja 01', 1, '2026-05-21 02:24:00', '2026-05-21 02:24:00'),
(2, 7, 'Caja 02', 1, '2026-05-21 02:24:00', '2026-05-21 02:24:00'),
(3, 8, 'Caja Principal', 1, '2026-05-21 02:24:00', '2026-05-21 02:24:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` bigint(20) NOT NULL,
  `update_at` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`, `update_at`) VALUES
(9, 'BEBIDAS', 'Gaseosas y bebidas', 1779330497, 1779330497),
(10, 'GALLETAS', 'Galletas dulces y saladas', 1779330497, 1779330497),
(11, 'TECNOLOGIA', 'Productos tecnológicos', 1779330497, 1779330497);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `tipodocumento_id` bigint(20) NOT NULL,
  `total_cost` decimal(8,2) NOT NULL,
  `purchase_date` date NOT NULL,
  `status` bigint(20) NOT NULL,
  `created_at` bigint(20) NOT NULL,
  `updated_at` bigint(20) NOT NULL,
  `sucursal_id` bigint(20) UNSIGNED NOT NULL,
  `almacen_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id`, `supplier_id`, `user_id`, `tipodocumento_id`, `total_cost`, `purchase_date`, `status`, `created_at`, `updated_at`, `sucursal_id`, `almacen_id`) VALUES
(1, 1, 1, 2, 500.00, '2026-05-20', 1, 1779330849, 1779330849, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `empresa_nombre` varchar(150) NOT NULL,
  `empresa_ruc` varchar(20) NOT NULL,
  `empresa_email` varchar(120) DEFAULT NULL,
  `empresa_telefono` varchar(30) DEFAULT NULL,
  `empresa_direccion` varchar(255) DEFAULT NULL,
  `empresa_web` varchar(150) DEFAULT NULL,
  `empresa_logo` varchar(255) DEFAULT NULL,
  `igv` decimal(5,2) NOT NULL DEFAULT 18.00,
  `moneda` varchar(10) NOT NULL DEFAULT 'PEN',
  `simbolo_moneda` varchar(10) NOT NULL DEFAULT 'S/',
  `serie_factura` varchar(10) DEFAULT 'F001',
  `serie_boleta` varchar(10) DEFAULT 'B001',
  `modo_oscuro` tinyint(1) DEFAULT 0,
  `mantenimiento` tinyint(1) DEFAULT 0,
  `mensaje_ticket` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id`, `empresa_nombre`, `empresa_ruc`, `empresa_email`, `empresa_telefono`, `empresa_direccion`, `empresa_web`, `empresa_logo`, `igv`, `moneda`, `simbolo_moneda`, `serie_factura`, `serie_boleta`, `modo_oscuro`, `mantenimiento`, `mensaje_ticket`, `created_at`, `updated_at`) VALUES
(2, 'FULLVENTAS 360', '20123456789', 'ventas@fullventas360.com', '999999999', 'Lima - Perú', NULL, 'logo.png', 18.00, 'PEN', 'S/', 'F001', 'B001', 0, 0, 'Gracias por su compra', '2026-05-21 02:14:49', '2026-05-21 02:14:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ruc` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` bigint(20) NOT NULL,
  `update_at` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `customers`
--

INSERT INTO `customers` (`id`, `ruc`, `name`, `email`, `phone`, `address`, `photo`, `status`, `created_at`, `update_at`) VALUES
(2, 20600011122, 'RICARDO FLORES', 'cliente@gmail.com', '999888777', 'LIMA', 'default.png', 'ACTIVO', 1779330682, 1779330682);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compras`
--

CREATE TABLE `detalle_compras` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_cost` decimal(8,2) NOT NULL,
  `subtotal` decimal(8,2) NOT NULL,
  `created_at` bigint(20) NOT NULL,
  `updated_at` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_compras`
--

INSERT INTO `detalle_compras` (`id`, `purchase_id`, `product_id`, `quantity`, `unit_cost`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 100, 2.50, 250.00, 1779330873, 1779330873);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_transferencias`
--

CREATE TABLE `detalle_transferencias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transferencia_id` bigint(20) UNSIGNED NOT NULL,
  `producto_id` bigint(20) UNSIGNED NOT NULL,
  `cantidad` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ventas`
--

CREATE TABLE `detalle_ventas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sales_id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(8,2) NOT NULL,
  `subtotal` decimal(8,2) NOT NULL,
  `created_at` bigint(20) NOT NULL,
  `update_at` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_ventas`
--

INSERT INTO `detalle_ventas` (`id`, `sales_id`, `product_id`, `quantity`, `unit_price`, `subtotal`, `created_at`, `update_at`) VALUES
(1, 1, 1, 5, 3.50, 17.50, 1779330833, 1779330833),
(2, 1, 3, 1, 45.00, 45.00, 1779330833, 1779330833);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventories`
--

CREATE TABLE `inventories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `type` varchar(255) NOT NULL,
  `quantity` bigint(20) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `created_at` bigint(20) NOT NULL,
  `updated_at` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `route` varchar(150) DEFAULT NULL,
  `parent_id` bigint(20) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `status` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `menus`
--

INSERT INTO `menus` (`id`, `name`, `icon`, `route`, `parent_id`, `sort_order`, `status`) VALUES
(1, 'Dashboard', 'dashboard', '/dashboard', NULL, 0, 1),
(2, 'Productos2026', 'inventory', NULL, NULL, 0, 1),
(3, 'Lista Productos', 'list', '/productos', 2, 0, 1),
(4, 'Categorias', 'category', '/categorias', 2, 0, 1),
(5, 'Ventas', 'shopping_cart', NULL, NULL, 0, 1),
(6, 'Nueva2026 Venta', 'point_of_sale', '/ventas', 5, 0, 1),
(7, 'Usuarios', 'group', '/usuarios', NULL, 0, 1),
(8, 'Dashboard', 'dashboard', '/dashboard', NULL, 1, 1),
(9, 'Productos', 'inventory', NULL, NULL, 2, 1),
(10, 'Lista Productos', 'list', '/productos', 2, 1, 1),
(11, 'Categorias', 'category', '/categorias', 2, 2, 1),
(12, 'Ventas', 'shopping_cart', NULL, NULL, 3, 1),
(13, 'Nueva Venta', 'point_of_sale', '/ventas', 5, 1, 1),
(14, 'Compras', 'shopping_bag', '/compras', NULL, 4, 1),
(15, 'Usuarios', 'group', '/usuarios', NULL, 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2026_05_13_222632_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos_inventario`
--

CREATE TABLE `movimientos_inventario` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `almacen_id` bigint(20) UNSIGNED NOT NULL,
  `producto_id` bigint(20) UNSIGNED NOT NULL,
  `tipo_movimiento` enum('COMPRA','VENTA','AJUSTE','TRANSFERENCIA','DEVOLUCION') NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `stock_anterior` decimal(10,2) NOT NULL,
  `stock_nuevo` decimal(10,2) NOT NULL,
  `referencia_id` bigint(20) DEFAULT NULL,
  `observacion` varchar(255) DEFAULT NULL,
  `usuario_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `movimientos_inventario`
--

INSERT INTO `movimientos_inventario` (`id`, `almacen_id`, `producto_id`, `tipo_movimiento`, `cantidad`, `stock_anterior`, `stock_nuevo`, `referencia_id`, `observacion`, `usuario_id`, `created_at`) VALUES
(1, 1, 1, 'COMPRA', 100.00, 0.00, 100.00, 1, 'Ingreso por compra', 1, '2026-05-21 02:34:51'),
(2, 3, 1, 'VENTA', 5.00, 75.00, 70.00, 1, 'Salida por venta', 2, '2026-05-21 02:34:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `category_id` bigint(20) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` bigint(20) NOT NULL,
  `update_at` bigint(20) NOT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `qrcode` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `user_id`, `name`, `description`, `price`, `quantity`, `category_id`, `status`, `created_at`, `update_at`, `barcode`, `qrcode`) VALUES
(1, 1, 'COCA COLA 500ML', 'Gaseosa Coca Cola', 3.50, 0, 1, 'ACTIVO', 1779330535, 1779330535, '7751234567890', 'QR001'),
(2, 1, 'GALLETA OREO', 'Galleta Oreo clásica', 2.00, 0, 2, 'ACTIVO', 1779330535, 1779330535, '7751234567891', 'QR002'),
(3, 1, 'MOUSE LOGITECH', 'Mouse inalámbrico', 45.00, 0, 3, 'ACTIVO', 1779330535, 1779330535, '7751234567892', 'QR003');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_image`
--

CREATE TABLE `product_image` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` bigint(20) NOT NULL,
  `update_at` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `product_image`
--

INSERT INTO `product_image` (`id`, `product_id`, `image_path`, `created_at`, `update_at`) VALUES
(2, 1, 'storage/products/images/nueva.png', 1779244165, 1779244165),
(3, 10, 'storage/products/images/1779250284_11.jpg', 1779250284, 1779250284),
(4, 12, 'storage/products/images/1779328213_66.jpg', 1779250704, 1779328213),
(5, 11, 'storage/products/images/1779251504_44.jpg', 1779251504, 1779251504);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`) VALUES
(1, 'ADMINISTRADOR', 'Control total del sistema'),
(2, 'VENDEDOR', 'Gestión de ventas'),
(3, 'ALMACENERO', 'Gestión de inventario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_menu`
--

CREATE TABLE `role_menu` (
  `role_id` bigint(20) NOT NULL,
  `menu_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `role_menu`
--

INSERT INTO `role_menu` (`role_id`, `menu_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(2, 1),
(2, 5),
(2, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock_productos`
--

CREATE TABLE `stock_productos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `producto_id` bigint(20) UNSIGNED NOT NULL,
  `almacen_id` bigint(20) UNSIGNED NOT NULL,
  `stock` decimal(10,2) NOT NULL DEFAULT 0.00,
  `stock_minimo` decimal(10,2) DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `stock_productos`
--

INSERT INTO `stock_productos` (`id`, `producto_id`, `almacen_id`, `stock`, `stock_minimo`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 100.00, 10.00, '2026-05-21 02:31:06', '2026-05-21 02:31:06'),
(2, 1, 2, 50.00, 5.00, '2026-05-21 02:31:06', '2026-05-21 02:31:06'),
(3, 1, 3, 70.00, 10.00, '2026-05-21 02:31:06', '2026-05-21 02:31:06'),
(4, 2, 1, 80.00, 10.00, '2026-05-21 02:31:06', '2026-05-21 02:31:06'),
(5, 2, 2, 40.00, 5.00, '2026-05-21 02:31:06', '2026-05-21 02:31:06'),
(6, 3, 3, 25.00, 3.00, '2026-05-21 02:31:06', '2026-05-21 02:31:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursales`
--

CREATE TABLE `sucursales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `configuracion_id` bigint(20) UNSIGNED NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `ruc` varchar(20) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `direccion` varchar(255) NOT NULL,
  `ciudad` varchar(100) DEFAULT NULL,
  `pais` varchar(100) DEFAULT 'PERU',
  `logo` varchar(255) DEFAULT NULL,
  `serie_factura` varchar(10) DEFAULT 'F001',
  `serie_boleta` varchar(10) DEFAULT 'B001',
  `estado` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sucursales`
--

INSERT INTO `sucursales` (`id`, `configuracion_id`, `codigo`, `nombre`, `ruc`, `telefono`, `email`, `direccion`, `ciudad`, `pais`, `logo`, `serie_factura`, `serie_boleta`, `estado`, `created_at`, `updated_at`) VALUES
(7, 2, 'SUC001', 'Sucursal Lima Centro', '20123456789', '999111222', 'lima@fullventas360.com', 'Av. Abancay 123', 'Lima', 'PERU', 'sucursal1.png', 'F001', 'B001', 1, '2026-05-21 02:18:26', '2026-05-21 02:18:26'),
(8, 2, 'SUC002', 'Sucursal San Isidro', '20123456789', '999333444', 'sanisidro@fullventas360.com', 'Av. Javier Prado 456', 'Lima', 'PERU', 'sucursal2.png', 'F002', 'B002', 1, '2026-05-21 02:18:26', '2026-05-21 02:18:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ruc` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` bigint(20) NOT NULL,
  `update_at` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `suppliers`
--

INSERT INTO `suppliers` (`id`, `ruc`, `name`, `email`, `phone`, `address`, `photo`, `status`, `created_at`, `update_at`) VALUES
(0, 20555555555, 'DISTRIBUIDORA PERU SAC', 'proveedor@gmail.com', '988111222', 'LIMA', 'default.png', 'ACTIVO', 1779330715, 1779330715);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipodocumento`
--

CREATE TABLE `tipodocumento` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `created_at` bigint(20) NOT NULL,
  `update_at` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipodocumento`
--

INSERT INTO `tipodocumento` (`id`, `name`, `description`, `type`, `created_at`, `update_at`) VALUES
(1, 'BOLETA', 'Boleta electrónica', 'VENTA', 1779330751, 1779330751),
(2, 'FACTURA', 'Factura electrónica', 'VENTA', 1779330751, 1779330751);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `reference_id` bigint(20) NOT NULL,
  `description` varchar(255) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `created_at` bigint(20) NOT NULL,
  `update_at` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `transactions`
--

INSERT INTO `transactions` (`id`, `type`, `amount`, `reference_id`, `description`, `user_id`, `created_at`, `update_at`) VALUES
(1, 'VENTA', 50.00, 1, 'Pago venta realizada', 2, 1779330914, 1779330914);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transferencias`
--

CREATE TABLE `transferencias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `almacen_origen_id` bigint(20) UNSIGNED NOT NULL,
  `almacen_destino_id` bigint(20) UNSIGNED NOT NULL,
  `usuario_id` bigint(20) UNSIGNED NOT NULL,
  `total` decimal(10,2) DEFAULT 0.00,
  `estado` enum('PENDIENTE','ENVIADO','RECIBIDO','CANCELADO') DEFAULT 'PENDIENTE',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `adress` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `role_id` bigint(20) NOT NULL,
  `created_at` bigint(20) NOT NULL,
  `update_at` bigint(20) NOT NULL,
  `sucursal_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `adress`, `photo`, `role_id`, `created_at`, `update_at`, `sucursal_id`) VALUES
(1, 'ADMIN', 'admin@gmail.com', '$2y$12$abcdefghijklmnopqrstuv', '999999999', 'LIMA', 'default.png', 1, 1, 1779330434, 1779330434),
(2, 'VENDEDOR 01', 'vendedor@gmail.com', '$2y$12$abcdefghijklmnopqrstuv', '988777666', 'SAN ISIDRO', 'default.png', 2, 7, 1779330434, 1779330434);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `tipodocumento_id` bigint(20) NOT NULL,
  `total_price` decimal(8,2) NOT NULL,
  `sale_date` date NOT NULL,
  `status` varchar(255) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `created_at` bigint(20) NOT NULL,
  `updated_at` bigint(20) NOT NULL,
  `sucursal_id` bigint(20) UNSIGNED NOT NULL,
  `caja_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `customer_id`, `user_id`, `tipodocumento_id`, `total_price`, `sale_date`, `status`, `payment_method`, `created_at`, `updated_at`, `sucursal_id`, `caja_id`) VALUES
(0, 1, 2, 1, 50.00, '2026-05-20', 'PAGADO', 'EFECTIVO', 1779330806, 1779330806, 2, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `almacenes`
--
ALTER TABLE `almacenes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_almacen_sucursal` (`sucursal_id`);

--
-- Indices de la tabla `cajas`
--
ALTER TABLE `cajas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_caja_sucursal` (`sucursal_id`);

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_transferencias`
--
ALTER TABLE `detalle_transferencias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inventories`
--
ALTER TABLE `inventories`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `movimientos_inventario`
--
ALTER TABLE `movimientos_inventario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `product_image`
--
ALTER TABLE `product_image`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `stock_productos`
--
ALTER TABLE `stock_productos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_producto_almacen` (`producto_id`,`almacen_id`);

--
-- Indices de la tabla `sucursales`
--
ALTER TABLE `sucursales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sucursal_configuracion` (`configuracion_id`);

--
-- Indices de la tabla `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipodocumento`
--
ALTER TABLE `tipodocumento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `transferencias`
--
ALTER TABLE `transferencias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `almacenes`
--
ALTER TABLE `almacenes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cajas`
--
ALTER TABLE `cajas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `detalle_transferencias`
--
ALTER TABLE `detalle_transferencias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `movimientos_inventario`
--
ALTER TABLE `movimientos_inventario`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `product_image`
--
ALTER TABLE `product_image`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `stock_productos`
--
ALTER TABLE `stock_productos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `sucursales`
--
ALTER TABLE `sucursales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `transferencias`
--
ALTER TABLE `transferencias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `almacenes`
--
ALTER TABLE `almacenes`
  ADD CONSTRAINT `fk_almacen_sucursal` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`);

--
-- Filtros para la tabla `cajas`
--
ALTER TABLE `cajas`
  ADD CONSTRAINT `fk_caja_sucursal` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`);

--
-- Filtros para la tabla `sucursales`
--
ALTER TABLE `sucursales`
  ADD CONSTRAINT `fk_sucursal_configuracion` FOREIGN KEY (`configuracion_id`) REFERENCES `configuracion` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
