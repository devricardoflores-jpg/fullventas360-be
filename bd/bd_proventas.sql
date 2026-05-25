-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-05-2026 a las 03:58:49
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
(1, 'LIQUIDOS', 'GASEOSAS', 0, 0),
(2, 'GALLETAS', 'GASEOSA INCA COLA', 0, 0),
(3, 'Electrónicos', 'Productos electrónicos', 1778366456, 1778366456),
(4, 'Limpieza', 'Material de limpieza', 1778721965, 1778721965),
(6, 'Tecnologia', 'Productos tecnologicos 2026', 1779164043, 1779166591),
(8, 'SDSF', 'SDFDSFSDFSDADSF', 1779166718, 1779166718);

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
  `updated_at` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'FULLVENTAS 360', '20123456789', 'dev.ricardoflores@gmail.com', '999999999', 'Lima - Perú', NULL, 'logo.png', 18.00, 'PEN', 'S/', 'F001', 'B001', 0, 0, 'Gracias por su compra', '2026-05-21 01:45:48', '2026-05-21 01:45:48');

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
(1, 20600011122, 'FLORES BAÑARES RICARDO BORIS', 'boris@gmail.com', '999888777', 'LIMA', 'default.png', 'ACTIVO', 1778731111, 1778731111);

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
(7, 'Usuarios', 'group', '/usuarios', NULL, 0, 1);

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

--
-- Volcado de datos para la tabla `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'auth_token', '01c615395c2e84b79198b1a45178ef4f6a1b28a8a12f738e11193ff96d0db44c', '[\"*\"]', NULL, NULL, '2026-05-14 03:52:02', '2026-05-14 03:52:02'),
(2, 'App\\Models\\User', 1, 'auth_token', 'ba19a262a69aad11d1ac6491c79a27339a0e3548193e04cf3f214ecf2f5981b6', '[\"*\"]', NULL, NULL, '2026-05-14 03:52:53', '2026-05-14 03:52:53'),
(3, 'App\\Models\\User', 1, 'auth_token', 'da18f97ffcd048a2f4d7240041d45fe42810746753ba0bd7e329c5314fb6dae1', '[\"*\"]', NULL, NULL, '2026-05-14 05:36:32', '2026-05-14 05:36:32'),
(4, 'App\\Models\\User', 1, 'auth_token', '79b9a73430d9dccc6a429dc485a3ab9e784fb940833846b0891ce95d7cd28bf5', '[\"*\"]', NULL, NULL, '2026-05-14 05:38:25', '2026-05-14 05:38:25'),
(5, 'App\\Models\\User', 1, 'auth_token', 'ab0f9a5bc889e9d9d213f173b4c7c327cfd8bd02b9e12576c0f1885fc7a35120', '[\"*\"]', NULL, NULL, '2026-05-14 06:02:04', '2026-05-14 06:02:04'),
(6, 'App\\Models\\User', 1, 'auth_token', '98a4a37ded03641fea670dc0786621a283f5abbe255e17e86e5f7e4a70187e70', '[\"*\"]', '2026-05-14 06:06:26', NULL, '2026-05-14 06:06:15', '2026-05-14 06:06:26'),
(7, 'App\\Models\\User', 1, 'auth_token', 'a29839b7beca44b0a77f7a9c6e9a7b79ba68e9cf3f6cd109074c3903e4d9661d', '[\"*\"]', '2026-05-14 06:26:10', NULL, '2026-05-14 06:22:17', '2026-05-14 06:26:10'),
(8, 'App\\Models\\User', 1, 'auth_token', 'f02d5fe4eda73e6a06c0e95b826fafaf4815798dfef086f9e00b1339f80060ee', '[\"*\"]', '2026-05-14 06:33:19', NULL, '2026-05-14 06:33:01', '2026-05-14 06:33:19'),
(9, 'App\\Models\\User', 1, 'auth_token', 'a138031747a5c90cbf50103e3bca6ed2ae9d5462b18baea4df85c0b909af0c03', '[\"*\"]', '2026-05-14 06:33:50', NULL, '2026-05-14 06:33:42', '2026-05-14 06:33:50'),
(10, 'App\\Models\\User', 1, 'auth_token', '337672936fb39e223a3bc5c8a32920dff42656ae72ba2b37023e5b0a261c2558', '[\"*\"]', '2026-05-14 06:39:21', NULL, '2026-05-14 06:39:12', '2026-05-14 06:39:21'),
(11, 'App\\Models\\User', 1, 'auth_token', 'a5b01c62e6f3597681f0198eec3e8fcb97039326593701dffc6202e082bb80e7', '[\"*\"]', NULL, NULL, '2026-05-14 06:45:56', '2026-05-14 06:45:56'),
(12, 'App\\Models\\User', 1, 'auth_token', 'ee362157ab05a0719e18638c3dd40a5fd56f18aa8b94f38cb454952b3fe7aeda', '[\"*\"]', '2026-05-14 06:53:41', NULL, '2026-05-14 06:53:27', '2026-05-14 06:53:41'),
(13, 'App\\Models\\User', 1, 'auth_token', '5ca1e0bfbba5494bc0725f5a0cab2ce04020b0b0829f535050ab8b1f86405dac', '[\"*\"]', '2026-05-18 10:43:47', NULL, '2026-05-14 07:16:35', '2026-05-18 10:43:47'),
(14, 'App\\Models\\User', 1, 'auth_token', 'af9a51013abf05595b79d1808a51e4cea55e6ea2eb48ce6b0df360752432c9d5', '[\"*\"]', NULL, NULL, '2026-05-14 07:35:09', '2026-05-14 07:35:09'),
(15, 'App\\Models\\User', 1, 'auth_token', '555a9eb04668036b11cff1da72ee953cf78b7399baa4e0d157793d6a87406077', '[\"*\"]', NULL, NULL, '2026-05-14 07:36:47', '2026-05-14 07:36:47'),
(16, 'App\\Models\\User', 1, 'auth_token', '7e33717428d6f7840689e7461a2232299d4fe65e38e3f17b18fa16305c4dbbc6', '[\"*\"]', '2026-05-14 07:49:44', NULL, '2026-05-14 07:43:15', '2026-05-14 07:49:44'),
(17, 'App\\Models\\User', 1, 'auth_token', 'fab2a1f412cac783d25bbf64e56e79f025a44c8b958b18f7a6bbd354b9e0d6d0', '[\"*\"]', '2026-05-14 08:03:52', NULL, '2026-05-14 08:01:03', '2026-05-14 08:03:52'),
(18, 'App\\Models\\User', 1, 'auth_token', '8fab7e5e300167e0bd68944e4f2e6b3b2f9f140cd52a24d84e6b311e6f8f64f6', '[\"*\"]', '2026-05-14 08:10:50', NULL, '2026-05-14 08:10:12', '2026-05-14 08:10:50'),
(19, 'App\\Models\\User', 1, 'auth_token', 'be39bc672f149ba7672fec35fcdf37cd0bd049ac77b7baf486ccbefcb6d071f4', '[\"*\"]', '2026-05-14 08:31:14', NULL, '2026-05-14 08:27:38', '2026-05-14 08:31:14'),
(20, 'App\\Models\\User', 1, 'auth_token', '2697902941861ec44121e5ab311ff86ccfb1f26aa310ed6b74467d2f5ccad44c', '[\"*\"]', '2026-05-14 08:58:43', NULL, '2026-05-14 08:57:31', '2026-05-14 08:58:43'),
(21, 'App\\Models\\User', 1, 'auth_token', 'f00d8da7e6915b35549f2a624e3023ee090e0b646b9496112e32f0ccf98f55d3', '[\"*\"]', '2026-05-14 09:33:01', NULL, '2026-05-14 09:32:52', '2026-05-14 09:33:01'),
(22, 'App\\Models\\User', 1, 'auth_token', 'a8415cb908d479c4641071c717c28589873298d68f7600212a92516e58125169', '[\"*\"]', '2026-05-14 09:34:22', NULL, '2026-05-14 09:34:12', '2026-05-14 09:34:22'),
(23, 'App\\Models\\User', 1, 'auth_token', 'c5c102835f34478e7dfc3a99725b31ec25521585739c32703a38996ddbd992ad', '[\"*\"]', '2026-05-14 09:37:53', NULL, '2026-05-14 09:37:41', '2026-05-14 09:37:53'),
(24, 'App\\Models\\User', 1, 'auth_token', 'e2d5c82d1b7d9f520fb91d6b3b531168aa7672702fb1dbbee451ae4fa0c7954c', '[\"*\"]', '2026-05-14 09:46:46', NULL, '2026-05-14 09:39:09', '2026-05-14 09:46:46'),
(25, 'App\\Models\\User', 1, 'auth_token', '1c8721764127a621b514eb861b1dfb3624bc3e72aae3f151aed7b036d910c801', '[\"*\"]', '2026-05-14 09:47:45', NULL, '2026-05-14 09:41:19', '2026-05-14 09:47:45'),
(26, 'App\\Models\\User', 1, 'auth_token', '3828e2d62ff106db3e0b066cd4164743e89f0c768b66fe2410f33b561ca427b1', '[\"*\"]', '2026-05-14 10:19:05', NULL, '2026-05-14 09:47:34', '2026-05-14 10:19:05'),
(27, 'App\\Models\\User', 1, 'auth_token', 'd4820eb029f9c99c68078247443a53c1aeaf37d36e4a8c04ad8765e6b0bbaf70', '[\"*\"]', NULL, NULL, '2026-05-14 09:55:04', '2026-05-14 09:55:04'),
(28, 'App\\Models\\User', 1, 'auth_token', 'a7dc65627ee4465ae14dbf6af990efec113ef1a5cc44a43931737703ded4d32d', '[\"*\"]', '2026-05-18 10:04:52', NULL, '2026-05-18 10:03:40', '2026-05-18 10:04:52'),
(29, 'App\\Models\\User', 1, 'auth_token', '7029b9cac44aa2fb83745f4ffd1a15bcdcc598617a9f56bb0039a60cbedcd103', '[\"*\"]', NULL, NULL, '2026-05-18 10:18:46', '2026-05-18 10:18:46'),
(30, 'App\\Models\\User', 1, 'auth_token', '73220cbb1b235e46544450a958f595cf17dc43605b27a4afe70bb94e4dc60f55', '[\"*\"]', NULL, NULL, '2026-05-18 10:21:48', '2026-05-18 10:21:48'),
(31, 'App\\Models\\User', 1, 'auth_token', '5dbb1b58b29f8577713721a66f19378422f82c81f525671ea7214c7458158b9c', '[\"*\"]', NULL, NULL, '2026-05-18 10:31:14', '2026-05-18 10:31:14'),
(32, 'App\\Models\\User', 1, 'auth_token', 'd9d9eeec2679cd74a7dce6574ae6e2edb48e591c80f583248964a6bfb4d1d658', '[\"*\"]', NULL, NULL, '2026-05-18 10:42:34', '2026-05-18 10:42:34'),
(33, 'App\\Models\\User', 1, 'auth_token', 'edba8d8aed8e9882da07a1e8fd4ad389f79771b993fe4a661ffa74d84f265e15', '[\"*\"]', '2026-05-18 11:22:25', NULL, '2026-05-18 11:05:41', '2026-05-18 11:22:25'),
(34, 'App\\Models\\User', 1, 'auth_token', 'e984092bb37700f3ac8b9466aef40753d312dd26e00dc84d2e93241b1fb67ea3', '[\"*\"]', NULL, NULL, '2026-05-18 11:13:37', '2026-05-18 11:13:37'),
(35, 'App\\Models\\User', 1, 'auth_token', '77ad9a58d33f8f70191f19be07f969d0157e006a869befe5b17d6968a6ff8e01', '[\"*\"]', NULL, NULL, '2026-05-18 11:14:21', '2026-05-18 11:14:21'),
(36, 'App\\Models\\User', 1, 'auth_token', 'e58d6739f6db7304915e219429e745ebd9c36efe9601c8a0521698c6eca4b8a2', '[\"*\"]', NULL, NULL, '2026-05-18 11:16:45', '2026-05-18 11:16:45'),
(37, 'App\\Models\\User', 1, 'auth_token', '729278ffeaa894730f8fee7073ebe28e5f8f2a684e88d2efc3c97593f32a538b', '[\"*\"]', NULL, NULL, '2026-05-18 11:17:47', '2026-05-18 11:17:47'),
(38, 'App\\Models\\User', 1, 'auth_token', '72fdd8b730b57a927f72610f9b0c31cf28ae62b4a57e0e9611969339f43498a8', '[\"*\"]', NULL, NULL, '2026-05-18 11:21:13', '2026-05-18 11:21:13'),
(39, 'App\\Models\\User', 1, 'auth_token', '2cd2671a79935f48e889626f5ddb0d4edcd63bda27bc1e794dec61070b412706', '[\"*\"]', NULL, NULL, '2026-05-18 11:21:56', '2026-05-18 11:21:56'),
(40, 'App\\Models\\User', 1, 'auth_token', '1ebe9519ac80127452e6bbb70c368e8195533aa133918560c944bbccba379fb7', '[\"*\"]', NULL, NULL, '2026-05-18 11:25:49', '2026-05-18 11:25:49'),
(41, 'App\\Models\\User', 1, 'auth_token', '02b5e36fcb8fb5d2ed91426dfa90334d2303a8b11b6a7883aebd761b7d5a12e9', '[\"*\"]', NULL, NULL, '2026-05-18 11:26:49', '2026-05-18 11:26:49'),
(42, 'App\\Models\\User', 1, 'auth_token', '20b1799e2bbd8af5e5e9cf3239b2b5c5028323460c6a70d6ffc4e0b658423689', '[\"*\"]', NULL, NULL, '2026-05-18 11:32:33', '2026-05-18 11:32:33'),
(43, 'App\\Models\\User', 1, 'auth_token', 'a0bf7f07dd491877f4f7d476960f7d4239c337918a4cb68e53654b8d9108f121', '[\"*\"]', NULL, NULL, '2026-05-18 11:34:00', '2026-05-18 11:34:00'),
(44, 'App\\Models\\User', 1, 'auth_token', '02779a44ac0a6139e154c575e5ba71514712b6c737f22d4b2ec12de2da1c648f', '[\"*\"]', '2026-05-18 11:36:25', NULL, '2026-05-18 11:34:26', '2026-05-18 11:36:25'),
(45, 'App\\Models\\User', 1, 'auth_token', 'e531bf5b4bbc7dcab2c5461aa43a519b2a48bc9fbe83b937a022994886e4c23a', '[\"*\"]', '2026-05-18 11:37:04', NULL, '2026-05-18 11:37:04', '2026-05-18 11:37:04'),
(46, 'App\\Models\\User', 1, 'auth_token', 'd3deeae14a1350e55c55f48f0437c1fe2d41f08628cdb8115cf26384b876ac6b', '[\"*\"]', '2026-05-18 11:43:49', NULL, '2026-05-18 11:38:13', '2026-05-18 11:43:49'),
(47, 'App\\Models\\User', 1, 'auth_token', '59f617378c1c5d50b803a6a0f2a6af705ee6806a315644219c55dcc035748d0a', '[\"*\"]', NULL, NULL, '2026-05-19 06:52:26', '2026-05-19 06:52:26'),
(48, 'App\\Models\\User', 1, 'auth_token', 'ed6245e3abb654b8683c6d2441f5f9953cd6f3dedad9a3a4131135dbb2a449af', '[\"*\"]', '2026-05-19 07:17:01', NULL, '2026-05-19 07:17:01', '2026-05-19 07:17:01'),
(49, 'App\\Models\\User', 1, 'auth_token', 'cb98d8a45714cee57780a3f188661cfb63427bed95a3929d38abb01e8650647d', '[\"*\"]', '2026-05-19 07:17:29', NULL, '2026-05-19 07:17:29', '2026-05-19 07:17:29'),
(50, 'App\\Models\\User', 1, 'auth_token', 'ab65ea67ccb8643a6882f9e8299863306bc1b7ffd443d9dbf260ce5e0be8b0f3', '[\"*\"]', '2026-05-19 09:25:56', NULL, '2026-05-19 07:34:07', '2026-05-19 09:25:56'),
(51, 'App\\Models\\User', 1, 'auth_token', '72b8f030bdc6469881d67a35d8681128d5637cb7a748528f1a823120cea5e66c', '[\"*\"]', '2026-05-19 08:07:25', NULL, '2026-05-19 08:07:00', '2026-05-19 08:07:25'),
(52, 'App\\Models\\User', 1, 'auth_token', '14e1a2fff1ab5b93fa19c98149ec3329572bb603664d3cdc60e749fe6148afce', '[\"*\"]', '2026-05-20 09:11:24', NULL, '2026-05-19 08:09:26', '2026-05-20 09:11:24'),
(53, 'App\\Models\\User', 1, 'auth_token', 'f9935e9e0369d192db90a6a2b76d552b027dfccec65c799d45873eb51ab5911c', '[\"*\"]', '2026-05-19 09:31:19', NULL, '2026-05-19 09:26:22', '2026-05-19 09:31:19'),
(54, 'App\\Models\\User', 1, 'auth_token', 'd50026931f310892ed0514d089acae5138b3dfb840c3a9d63def79de7cb3b7a7', '[\"*\"]', '2026-05-20 10:59:39', NULL, '2026-05-19 09:31:35', '2026-05-20 10:59:39'),
(55, 'App\\Models\\User', 1, 'auth_token', '632700d7caa6899a9ef0ba5d229e09798a1a8a8e668273971fcd78ecc7dc2f50', '[\"*\"]', NULL, NULL, '2026-05-20 06:20:33', '2026-05-20 06:20:33'),
(56, 'App\\Models\\User', 1, 'auth_token', '40cccb6a1f0c19b05ca225e29f712c7f7a6c53ed25988d39f58d5c69a1b8bb61', '[\"*\"]', '2026-05-20 08:39:42', NULL, '2026-05-20 06:21:40', '2026-05-20 08:39:42'),
(57, 'App\\Models\\User', 1, 'auth_token', '3ce356215c32674b7d26ce4e2371067f335152e1bd0587db63d46ea50eb06f28', '[\"*\"]', '2026-05-20 07:58:31', NULL, '2026-05-20 07:58:30', '2026-05-20 07:58:31'),
(58, 'App\\Models\\User', 1, 'auth_token', '5389733e90b909bc2b7dbdf5ad643f94444cd9029966127a4c612fb090cb5f7c', '[\"*\"]', '2026-05-20 08:03:20', NULL, '2026-05-20 07:59:07', '2026-05-20 08:03:20'),
(59, 'App\\Models\\User', 1, 'auth_token', '08fdcb9f4b40c4bdcf335e28d32940b10921480700e45d3e3d1700de54c64332', '[\"*\"]', '2026-05-20 08:06:16', NULL, '2026-05-20 08:03:49', '2026-05-20 08:06:16'),
(60, 'App\\Models\\User', 1, 'auth_token', 'cc4706eea6c95618c78d180dfff232c6e0a62169f34a217077dc3ceaaecc2f00', '[\"*\"]', '2026-05-20 08:41:26', NULL, '2026-05-20 08:06:46', '2026-05-20 08:41:26'),
(61, 'App\\Models\\User', 1, 'auth_token', '070a6b83ed76b1ff555af68507ff4ddb8880021ea49470bba28c28cc7d2e1ec2', '[\"*\"]', '2026-05-20 08:47:37', NULL, '2026-05-20 08:47:31', '2026-05-20 08:47:37'),
(62, 'App\\Models\\User', 1, 'auth_token', '9e9622ea90597e02b91499de902b59995f5306eb5cbdf52a2b6607d77cc77f5e', '[\"*\"]', NULL, NULL, '2026-05-21 06:05:37', '2026-05-21 06:05:37'),
(63, 'App\\Models\\User', 1, 'auth_token', 'd8d943366edb2e8aed874de19eecb8a82caa08eece49bb3a4157a98ed3fdc4a5', '[\"*\"]', NULL, NULL, '2026-05-21 06:34:49', '2026-05-21 06:34:49'),
(64, 'App\\Models\\User', 1, 'auth_token', 'c6f1a38198bcb23fa97a8cc2e0c103387776e7a668fb62950f3a3d5b84ae8775', '[\"*\"]', '2026-05-21 06:57:41', NULL, '2026-05-21 06:40:28', '2026-05-21 06:57:41');

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
(1, 1, 'Laptop HP', 'Core i7', 2500.00, 10, 2, '1', 1778733639, 1778733639, NULL, NULL),
(2, 1, 'Laptop HP200', 'Core i7', 2500.00, 10, 2, '1', 1778734603, 1778734603, NULL, NULL),
(3, 1, 'Laptop HP200', 'Core i7', 2500.00, 10, 2, '1', 1778735014, 1778735014, NULL, NULL),
(4, 1, 'Laptop HP3000', 'Core i7', 2500.00, 10, 2, '1', 1778735079, 1778735079, NULL, NULL),
(5, 1, 'Laptop HP3000', 'Core i7', 2500.00, 10, 2, '1', 1778735512, 1778735512, NULL, NULL),
(6, 1, 'Laptop HP6000', 'Core i7', 2500.00, 10, 2, '1', 1778735719, 1778735719, NULL, NULL),
(7, 1, 'Laptop HP mesa', 'Core i7', 2500.00, 10, 2, '1', 1778735945, 1778735945, NULL, NULL),
(8, 1, 'Laptop HP mesa', 'Core i7', 2500.00, 10, 2, '1', 1779242001, 1779242001, NULL, NULL),
(9, 1, 'Laptop HP flores', 'Core i8', 2500.00, 10, 2, '0', 1779242214, 1779242214, NULL, NULL),
(10, 1, 'Laptop Lenovo Gamer', 'Core i7 16GB RAM999999', 155.00, 10, 1, '0', 1779242514, 1779250528, 'storage/products/barcode/10.png', 'storage/products/qrcode/10.png'),
(11, 1, 'sal', 'ddasddasdsd', 10.00, 55, 8, '1', 1779247645, 1779252186, 'storage/products/barcode/11.png', 'storage/products/qrcode/11.png'),
(12, 1, 'pepino', 'gdfgfd', 10.00, 5, 2, '1', 1779250704, 1779328213, 'storage/products/barcode/12.png', 'storage/products/qrcode/12.png');

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
(2, 'REGISTRADOR', 'Registrador de sistemas');

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
(2, 1),
(2, 5),
(2, 6);

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
(1, 20111111111, 'GLORIA SAC', 'gloria@gmail.com', '999999999', 'LIMA', 'default.png', 'ACTIVO', 1778729326, 1778729326),
(2, 202020202020, 'FLORES SAC', 'flores@gmail.com', '70389236', 'LIMA', 'flores.png', 'ACTIVO', 1778729439, 1778729439);

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
(1, 'FACTURA', 'Documento factura', 'VENTA', 1778726936, 1778726936);

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
  `update_at` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `adress`, `photo`, `role_id`, `created_at`, `update_at`) VALUES
(1, 'ADMIN', 'admin@gmail.com', '$2y$12$fgM3CHPdokbk6oNiB0Sn4OSg5/FK1XGC5sEnrRFXwcmcC2pdw/E4K', '999999999', 'LIMA', 'flores.png', 1, 1778711589, 1778711589),
(2, 'RICARDO', 'ricardo@gmail.com', '$2y$12$Mb5aYP.QbAMxn5BfRWcxtOumawZgIHJl4sfghM830MgWUzyLlSpce', '999999999', 'LIMA', 'default.png', 2, 1778728226, 1778728226);

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
  `updated_at` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

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
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inventories`
--
ALTER TABLE `inventories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `product_image`
--
ALTER TABLE `product_image`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipodocumento`
--
ALTER TABLE `tipodocumento`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
