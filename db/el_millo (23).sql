-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 10-07-2025 a las 03:53:51
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `el_millo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carritos`
--

CREATE TABLE `carritos` (
  `id` int(10) UNSIGNED NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carritos`
--

INSERT INTO `carritos` (`id`, `usuario_id`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 9, '2025-06-16 03:51:08', '2025-06-16 03:51:08'),
(3, 12, '2025-07-01 21:43:43', '2025-07-01 21:43:43'),
(6, 15, '2025-07-09 18:12:13', '2025-07-09 18:12:13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito_items`
--

CREATE TABLE `carrito_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `carritos_id` int(10) UNSIGNED NOT NULL,
  `producto_id` int(10) UNSIGNED NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1,
  `talle` varchar(5) DEFAULT NULL,
  `talle_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Adultos', 'Productos para adultos'),
(2, 'Niños', 'Productos para niños'),
(3, 'Retros', 'Camisetas retro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `dni` varchar(15) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `localidad` varchar(255) DEFAULT NULL,
  `provincias` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id`, `usuario_id`, `nombre`, `email`, `direccion`, `telefono`, `dni`, `fecha`, `localidad`, `provincias`) VALUES
(1, NULL, 'fsfsadsa', 'dsadas@safds', 'sadsa', '32423423', NULL, '2025-06-20 01:22:01', '', ''),
(2, 9, 'Gadiel', 'admin@elmillo.com', 'virreycisneros', '3321321321', NULL, '2025-06-20 19:15:56', '', ''),
(3, 9, 'Gadiel', 'admin@elmillo.com', 'virreycisneros', '3321321321', NULL, '2025-06-20 19:18:34', '', ''),
(4, 9, 'ramiro', 'ramiro.caballero.t1vl@gmail.com', 'virreycisneros2356', '11 7623-1788', NULL, '2025-06-20 20:40:06', '', ''),
(5, 9, 'Administrador', 'admin@elmillo.com', 'virreycisneros', '7623-1788', NULL, '2025-06-20 23:57:44', '', ''),
(6, 9, 'Lucas', 'admin@elmillo.com', 'virreycisneros', '3457-8012', NULL, '2025-06-21 00:08:49', '', ''),
(7, 9, 'Lucas', 'admin@elmillo.com', 'virreycisneros', '3457-8012', NULL, '2025-06-21 00:14:41', '', ''),
(8, 9, 'Lucas', 'admin@elmillo.com', 'virreycisneros', '3457-8012', NULL, '2025-06-21 00:15:07', '', ''),
(9, 9, 'Lucas', 'admin@elmillo.com', 'virreycisneros', '3457-8012', NULL, '2025-06-21 00:17:23', '', ''),
(10, 9, 'Lucas', 'admin@elmillo.com', 'virreycisneros', '3457-8012', NULL, '2025-06-21 00:17:54', '', ''),
(11, 9, 'Franco', 'ramiro.caballerot.t1vl@gmail.com', 'virreycisneros2356', '7623-1788', NULL, '2025-06-21 19:55:02', '', ''),
(12, 9, 'Lucas', 'luchocampanelli1@gmail.com', 'virreycisneros2356', '7623-1788', NULL, '2025-06-25 12:50:14', '', ''),
(13, 9, 'carlos', 'ramiro.caballero.t1vl@gmail.com', 'virreycisneros2356', '7623-1788', NULL, '2025-06-25 13:13:18', '', ''),
(14, 9, 'Administrador', 'franco.mastan.t1vl@gmail.com', 'virreycisneros34233', '4324-3243-24', NULL, '2025-06-25 13:29:11', '', ''),
(15, 12, 'pantalon ', 'rrrrrrrrrrrrr@gmail.com', 'rrrrrr', '23-1321-2312', NULL, '2025-07-02 02:19:52', '', ''),
(16, 12, 'pantalon ', 'rrrrrrrrrrrrr@gmail.com', 'rrrrrr', '23-1321-2312', NULL, '2025-07-02 02:20:10', '', ''),
(17, 12, 'pantalon ', 'rrrrrrrrrrrrr@gmail.com', 'rrrrrr', '23-1321-2312', NULL, '2025-07-02 02:20:58', '', ''),
(18, 12, 'pantalon ', 'rrrrrrrrrrrrr@gmail.com', 'rrrrrr', '23-1321-2312', NULL, '2025-07-02 02:25:37', '', ''),
(19, 12, 'pantalon ', 'rrrrrrrrrrrrr@gmail.com', 'rrrrrr', '23-1321-2312', NULL, '2025-07-02 02:33:28', '', ''),
(20, 12, 'pantalon ', 'rrrrrrrrrrrrr@gmail.com', 'rrrrrr', '23-1321-2312', NULL, '2025-07-02 03:00:54', '', ''),
(21, 12, 'ramiro', 'ramiro.caballero.t1vl@gmail.com', 'vireyy 23', '23-1321-2312', NULL, '2025-07-02 03:04:31', '', ''),
(22, 9, 'ramiro', 'ramiro.caballero.t1vl@gmail.com', 'vireyy 23', '23-1321-2312', NULL, '2025-07-02 03:11:54', '', ''),
(23, 9, 'Owen Olea', 'owen.olea.t1vl@gmail.com', 'maderos2356', '11-2739-6244', NULL, '2025-07-02 12:25:34', '', ''),
(24, 9, 'Owen Olea', 'owen.olea.t1vl@gmail.com', 'maderos2356', '11-2739-6244', NULL, '2025-07-02 12:26:32', '', ''),
(25, 9, 'Owen Olea', 'owen.olea.t1vl@gmail.com', 'maderos2356', '11-2739-6244', NULL, '2025-07-02 12:26:58', '', ''),
(26, 9, 'Owen Olea', 'owen.olea.t1vl@gmail.com', 'maderos2356', '11-2739-6244', NULL, '2025-07-02 12:27:09', '', ''),
(27, 9, 'Owen Olea', 'owen.olea.t1vl@gmail.com', 'maderos2356', '11-2739-6244', NULL, '2025-07-02 12:27:27', '', ''),
(28, 9, 'Owen Olea', 'owen.olea.t1vl@gmail.com', 'maderos2356', '11-2739-6244', NULL, '2025-07-02 12:27:30', '', ''),
(29, 9, 'Owen Olea', 'owen.olea.t1vl@gmail.com', 'maderos2356', '11-2739-6244', NULL, '2025-07-02 12:27:34', '', ''),
(30, 9, 'Owen Olea', 'owen.olea.t1vl@gmail.com', 'maderos2356', '11-2739-6244', NULL, '2025-07-02 12:27:55', '', ''),
(31, 9, 'Owen Olea', 'owen.olea.t1vl@gmail.com', 'maderos2356', '11-2739-6244', NULL, '2025-07-02 12:36:16', '', ''),
(32, 9, 'Owen Olea', 'owen.olea.t1vl@gmail.com', 'maderos2356', '11-2739-6244', NULL, '2025-07-02 12:36:20', '', ''),
(33, 9, 'Owen Olea', 'owen.olea.t1vl@gmail.com', 'maderos2356', '11-2739-6244', NULL, '2025-07-02 12:37:24', '', ''),
(34, 9, 'Owen Olea', 'owen.olea.t1vl@gmail.com', 'maderos2356', '11-2739-6244', NULL, '2025-07-02 12:37:27', '', ''),
(35, 9, 'Owen Olea', 'owen.olea.t1vl@gmail.com', 'maderos2356', '11-2739-6244', NULL, '2025-07-02 12:37:35', '', ''),
(36, 9, 'Owen Olea', 'owen.olea.t1vl@gmail.com', 'maderos2356', '11-2739-6244', NULL, '2025-07-02 12:37:37', '', ''),
(37, 9, 'Owen Olea', 'owen.olea.t1vl@gmail.com', 'maderos2356', '11-2739-6244', NULL, '2025-07-02 12:39:44', '', ''),
(38, 9, 'Owen Olea', 'owen.olea.t1vl@gmail.com', 'maderos2356', '11-2739-6244', NULL, '2025-07-02 12:39:48', '', ''),
(39, 9, 'Owen Olea', 'owen.olea.t1vl@gmail.com', 'maderos2356', '11-2739-6244', NULL, '2025-07-02 12:39:51', '', ''),
(40, 9, 'Owen Olea', 'owen.olea.t1vl@gmail.com', 'maderos2356', '11-2739-6244', NULL, '2025-07-02 12:40:41', '', ''),
(41, 9, 'Owen Olea', 'owen.olea.t1vl@gmail.com', 'maderos2356', '11-2739-6244', NULL, '2025-07-02 12:41:46', '', ''),
(42, 9, 'Administrador', 'ramiro.caballero.t1vl@gmail.com', 'virreycisneros2356', '11-2739-6244', NULL, '2025-07-02 12:43:13', '', ''),
(43, 9, 'Gadiel', 'ramiro.caballero.t1vl@gmail.com', 'virreycisneros2356', '11-2739-6244', NULL, '2025-07-02 12:48:11', '', ''),
(44, 9, 'Gadiel', 'ramiro.caballero.t1vl@gmail.com', 'virreycisneros2356', '11-2739-6244', NULL, '2025-07-02 12:50:31', '', ''),
(45, 9, 'joaco', 'ramiro.caballero.t1vl@gmail.com', 'virreycisneros2356', '11-2739-6244', NULL, '2025-07-02 12:59:44', '', ''),
(46, 9, 'joaco', 'ramiro.caballero.t1vl@gmail.com', 'virreycisneros2356', '11-2739-6244', NULL, '2025-07-02 13:05:14', '', ''),
(47, 9, 'joaco', 'ramiro.caballero.t1vl@gmail.com', 'virreycisneros2356', '11-2739-6244', NULL, '2025-07-02 13:10:16', '', ''),
(48, 9, 'joaco', 'ramiro.caballero.t1vl@gmail.com', 'virreycisneros2356', '11-2739-6244', NULL, '2025-07-02 13:13:35', '', ''),
(49, 9, 'Administrador', 'ramiro.caballero.t1vl@gmail.com', 'virreycisneros2356', '11-2739-6244', NULL, '2025-07-02 13:21:49', '', ''),
(50, 9, 'Administrador', 'ramiro.caballero.t1vl@gmail.com', 'virreycisneros2356', '11-2739-6244', NULL, '2025-07-02 13:25:39', '', ''),
(51, 9, 'Lucas', 'ramiro.caballero.t1vl@gmail.com', 'virreycisneros2356', '11-2739-6244', NULL, '2025-07-02 13:37:03', '', ''),
(52, 9, 'Lucas', 'ramiro.caballero.t1vl@gmail.com', 'virreycisneros2356', '11-2739-6244', NULL, '2025-07-02 14:07:07', '', ''),
(53, 9, 'Administrador', 'ramiro.caballero.t1vl@gmail.com', 'virreycisneros2356', '11-2739-6244', '48-6444-653', '2025-07-02 14:18:15', '', ''),
(54, 9, 'Nancy Martinez', 'martineznan18@gmail.com', 'virreycisneros2356', '11-3557-6514', '26-5656-5465', '2025-07-02 14:29:05', '', ''),
(55, 9, 'Nancy Martinez', 'martineznan78@gmail.com', 'virreycisneros2356', '11-3557-6514', '26-5656-5465', '2025-07-02 14:36:09', '', ''),
(56, 9, 'Lucas', 'ramiro.caballero.t1vl@gmail.com', 'virreycisneros2356', '11-2739-6244', '26-5656-5465', '2025-07-02 15:07:08', '', ''),
(57, 9, 'Lucas', 'ramiro.caballero.t1vl@gmail.com', 'virreycisneros2356', '11-2739-6244', '26-5656-5465', '2025-07-02 15:10:42', '', ''),
(58, 9, 'Gadiel', 'ramiro.caballero.t1vl@gmail.com', 'virreycisneros2356', '11-2739-6244', '26-5656-5465', '2025-07-02 15:14:19', '', ''),
(59, 9, 'rama', 'ramiro.caballero.t1vl@gmail.com', 'virreycisneros2356', '11-2739-6244', '26-5656-5465', '2025-07-02 15:21:58', '', ''),
(60, 9, 'Franco', 'ramiro.caballero.t1vl@gmail.com', 'virreycisneros2356', '11-2739-6244', '26-5656-5465', '2025-07-02 15:27:12', '', ''),
(61, 9, 'Franco', 'ramiro.caballero.t1vl@gmail.com', 'virreycisneros2356', '11-2739-6244', '26-5656-5465', '2025-07-02 15:27:57', '', ''),
(62, 9, 'Lucas', 'ramiro.caballero.t1vl@gmail.com', 'virreycisneros2356', '11-2739-6244', '26-5656-5465', '2025-07-02 15:29:01', '', ''),
(63, 9, 'Administrador', 'franco.mastan.t1vl@gmail.com', 'virreycisneros2356', '11-2739-6244', '26.565.654', '2025-07-09 18:36:12', '', ''),
(64, 9, 'Administrador', 'owen.olea.t1vl@gmail.com', 'virreycisneros2356', '11-2739-6244', '45.675.675', '2025-07-09 20:15:02', 'san martin ', NULL),
(65, 9, 'Administrador', 'owen.olea.t1vl@gmail.com', 'virreycisneros2356', '11-2739-6244', '45.675.675', '2025-07-09 20:17:18', 'san martin ', NULL),
(66, 9, 'ramiro ', 'ramiro.caballerot.t1vl@gmail.com', 'virreycisneros2356', '11-2739-6244', '26.565.654', '2025-07-09 20:33:41', 'san martin ', NULL),
(67, 9, 'Ramiro ', 'ramiro.caballero.t1vl@gmail.com', 'virreycisneros2356', '11-2739-6244', '26.565.654', '2025-07-09 20:35:14', 'san martin ', NULL),
(68, 9, 'Owen', 'owen.olea.t1vl@gmail.com', 'maderos2356', '11-2739-6244', '26.565.654', '2025-07-09 20:54:05', 'san martin ', NULL),
(69, 9, 'ramiro ', 'ramiro.caballero.t1vl@gmail.com', 'virreycisneros2356', '11-2739-6244', '26.565.654', '2025-07-09 20:54:56', 'san martin ', NULL),
(70, 9, 'Administrador', 'ramiro.caballero.t1vl@gmail.com', 'virreycisneros2356', '11-2739-6244', '26.565.654', '2025-07-09 20:58:06', 'san martin ', NULL),
(71, 9, 'Administrador', 'ramiro.caballero.t1vl@gmail.com', 'virreycisneros2356', '34-5780-12', '45.675.675', '2025-07-09 20:59:12', 'san martin ', NULL),
(72, 9, 'Administrador', 'ramiro.caballero.t1vl@gmail.com', 'virreycisneros2356', '11-2739-6244', '26.565.654', '2025-07-09 21:04:28', 'san martin ', 'Buenos Aires');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra_items`
--

CREATE TABLE `compra_items` (
  `id` int(11) NOT NULL,
  `orden_id` int(11) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `talle` varchar(10) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `talle_id` int(11) DEFAULT NULL,
  `precio_unitario` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compra_items`
--

INSERT INTO `compra_items` (`id`, `orden_id`, `producto_id`, `talle`, `cantidad`, `talle_id`, `precio_unitario`) VALUES
(1, 1, 3, 'S', 1, NULL, 0.00),
(2, 2, 2, 'S', 1, NULL, 0.00),
(3, 4, 2, 'L', 1, NULL, 0.00),
(4, 5, 4, 'L', 1, NULL, 0.00),
(5, 6, 3, 'S', 1, NULL, 0.00),
(6, 11, 1, 'XL', 1, NULL, 0.00),
(7, 12, 2, 'S', 1, NULL, 0.00),
(8, 13, 2, 'M', 1, NULL, 0.00),
(9, 14, 28, '4', 1, NULL, 0.00),
(10, 51, 23, 'S', 3, NULL, 80000.00),
(11, 52, 7, 'XS', 1, NULL, 90000.00),
(12, 52, 1, 'XS', 3, NULL, 80000.00),
(13, 53, 32, '16', 1, NULL, 50500.00),
(14, 54, 2, 'M', 1, NULL, 80000.00),
(15, 55, 3, 'XS', 1, NULL, 75000.00),
(16, 56, 2, 'M', 1, NULL, 80000.00),
(17, 57, 1, 'L', 1, NULL, 80000.00),
(18, 58, 1, 'L', 1, NULL, 80000.00),
(19, 59, 2, 'M', 1, NULL, 80000.00),
(20, 60, 13, 'L', 1, NULL, 90500.00),
(21, 62, 4, 'L', 1, NULL, 78500.00),
(22, 63, 1, 'M', 1, NULL, 80000.00),
(23, 64, 1, 'M', 1, NULL, 80000.00),
(24, 66, 1, 'M', 1, NULL, 80000.00),
(25, 67, 1, 'M', 1, NULL, 80000.00),
(26, 68, 3, 'S', 1, NULL, 75000.00),
(27, 69, 32, '8', 1, NULL, 50500.00),
(28, 70, 1, 'M', 1, NULL, 80000.00),
(29, 71, 3, 'S', 1, NULL, 75000.00),
(30, 72, 3, 'L', 1, NULL, 75000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `subcategoria_id` int(11) DEFAULT NULL,
  `imagen_principal` varchar(255) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `stock` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `categoria_id`, `subcategoria_id`, `imagen_principal`, `fecha_creacion`, `fecha_actualizacion`, `stock`) VALUES
(1, 'Remera titular', 'Camiseta oficial titular del equipo', 80000.00, 1, 1, 'titular.png', '2025-06-10 16:35:31', '2025-07-09 23:58:06', 0),
(2, 'Remera suplente', 'Camiseta oficial suplente del equipo', 80000.00, 1, 1, 'suplente.png', '2025-06-10 16:35:31', '2025-07-09 16:25:36', 0),
(3, 'Remera alternativa', 'Camiseta alternativa del equipo', 75000.00, 1, 1, 'tercera.png', '2025-06-10 16:35:31', '2025-07-10 00:04:28', 1),
(4, 'Remera Pre-Partido', 'Camiseta de calentamiento pre-partido', 78500.00, 1, 1, 'pre partido.png', '2025-06-10 16:35:31', '2025-07-09 16:25:36', 4),
(5, 'Camiseta titular arquero', 'Camiseta oficial del arquero', 88500.00, 1, 1, 'arquero titular.png', '2025-06-10 16:35:31', '2025-07-09 16:25:36', 5),
(6, 'Remera de entrenamiento', 'Camiseta para entrenamientos', 78500.00, 1, 1, 'camiseta entrenamiento.png', '2025-06-10 16:35:31', '2025-07-09 16:25:36', 5),
(7, 'Campera Deportiva', 'Campera deportiva oficial', 90000.00, 1, 2, 'Campera Deportiva.png', '2025-06-10 16:36:13', '2025-07-09 16:25:36', 4),
(8, 'Campera entrenamiento', 'Campera para entrenamientos', 90500.00, 1, 2, 'campera entrenamiento.png', '2025-06-10 16:36:13', '2025-07-09 16:25:36', 5),
(9, 'Campera invierno', 'Campera de invierno', 90500.00, 1, 2, 'campera invierno.png', '2025-06-10 16:36:13', '2025-07-09 16:25:36', 5),
(10, 'Campera lluvia', 'Campera impermeable', 90500.00, 1, 2, 'campera lluvia.png', '2025-06-10 16:36:13', '2025-07-09 16:25:36', 5),
(11, 'Campera SZN', 'Campera de temporada', 90500.00, 1, 2, 'Campera SZN.png', '2025-06-10 16:36:13', '2025-07-09 16:25:36', 5),
(12, 'Campera Wint Jkt', 'Campera de invierno premium', 90000.00, 1, 2, 'Campera Wint Jkt.png', '2025-06-10 16:36:13', '2025-07-09 16:25:36', 5),
(13, 'Pantalon titular', 'Pantalón oficial titular', 90500.00, 1, 3, 'Panta titular.png', '2025-06-10 16:36:13', '2025-07-09 16:25:36', 4),
(14, 'Pantalon suplente', 'Pantalón oficial suplente', 90500.00, 1, 3, 'Pantalon suplente.png', '2025-06-10 16:36:13', '2025-07-09 16:25:36', 5),
(15, 'Pantalon alternativo', 'Pantalón alternativo', 90000.00, 1, 3, 'pantalon tercero.png', '2025-06-10 16:36:13', '2025-07-09 16:25:36', 5),
(19, 'Camiseta retro sanyo 1994', 'Camiseta retro edición 1994', 88500.00, 3, 7, 'Camiseta retro sanyo 1994.png', '2025-06-10 16:36:13', '2025-07-02 04:09:38', 5),
(20, 'Retro 1996 tricampeon', 'Camiseta retro tricampeón 1996', 90000.00, 3, 7, 'Retro 1996 premium tricampeon.png', '2025-06-10 16:36:13', '2025-07-02 04:09:38', 5),
(21, 'Retro 2018', 'Camiseta retro 2018', 80500.00, 3, 7, 'Retro 2018.png', '2025-06-10 16:36:13', '2025-07-02 04:09:38', 5),
(22, 'Retro tricolor 2006', 'Camiseta retro tricolor 2006', 75000.00, 3, 7, 'Retro tricolor 2006.png', '2025-06-10 16:36:13', '2025-07-02 04:09:38', 5),
(23, 'Retro 2001', 'Camiseta retro 2001', 80000.00, 3, 7, 'retro2001.png', '2025-06-10 16:36:13', '2025-07-02 16:37:03', 2),
(24, 'Camiseta retro 1986', 'Camiseta retro 1986', 88500.00, 3, 7, 'Camiseta retro 1986.png', '2025-06-10 16:36:13', '2025-07-02 04:09:38', 5),
(25, 'Short retro 2000', 'Short retro año 2000', 70500.00, 3, 8, 'Short retro 2000.png', '2025-06-10 16:36:13', '2025-07-02 04:09:38', 5),
(26, 'Short retro 2001', 'Short retro año 2001', 70500.00, 3, 8, 'Short retro 2001.png', '2025-06-10 16:36:13', '2025-07-02 04:09:38', 5),
(27, 'Campera retro 1998', 'Campera retro 1998', 78000.00, 3, 9, 'Campera retro 1998.png', '2025-06-10 16:36:13', '2025-07-02 04:09:38', 5),
(28, 'Remera titular niños', '', 50000.00, 2, 4, 'Camiseta Titular niño.jpg', '2025-06-21 19:26:46', '2025-07-02 04:05:10', 5),
(29, 'Remera suplente niños', '', 70000.00, 2, 4, 'Camiseta suplente Niño.png', '2025-06-21 19:26:46', '2025-07-02 04:05:10', 5),
(30, 'Camiseta arquero niños', '', 55000.00, 2, 4, 'Camiseta arquero niños 2024.png', '2025-06-21 19:26:46', '2025-07-02 04:05:10', 5),
(31, 'Campera impermeable niños', '', 70000.00, 2, 5, 'CI.jpg', '2025-06-21 19:26:46', '2025-07-02 04:05:10', 5),
(32, 'Camperon de niños', '', 50500.00, 2, 5, 'Camperon de niños.png', '2025-06-21 19:26:46', '2025-07-09 23:54:56', 3),
(33, 'Conjunto niño campera más pantalón', '', 90500.00, 2, 5, 'Conjunto River Plate niño campera más pantalón.png', '2025-06-21 19:26:46', '2025-07-02 04:05:10', 5),
(34, 'Short titular niño', '', 40000.00, 2, 6, 'Short titular Niño.png', '2025-06-21 19:26:46', '2025-07-02 04:05:11', 5),
(35, 'Short alternativo niño', '', 45500.00, 2, 6, 'Short Alternativo Niño.png', '2025-06-21 19:26:46', '2025-07-02 04:05:11', 5),
(36, 'Short entrenamiento niño', '', 35500.00, 2, 6, 'Short de Entrenamiento  Niño.png', '2025-06-21 19:26:46', '2025-07-02 04:05:11', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcategorias`
--

CREATE TABLE `subcategorias` (
  `id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `subcategorias`
--

INSERT INTO `subcategorias` (`id`, `categoria_id`, `nombre`, `descripcion`) VALUES
(1, 1, 'Remeras', NULL),
(2, 1, 'Camperas', NULL),
(3, 1, 'Shorts', NULL),
(4, 2, 'Remeras niño', NULL),
(5, 2, 'Camperas niño', NULL),
(6, 2, 'Shorts niño', NULL),
(7, 3, 'Camisetas Retro', NULL),
(8, 3, 'Shorts Retro', NULL),
(9, 3, 'Camperas Retro', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `talles`
--

CREATE TABLE `talles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(10) NOT NULL,
  `orden` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `talles`
--

INSERT INTO `talles` (`id`, `nombre`, `orden`) VALUES
(1, 'XS', 1),
(2, 'S', 2),
(3, 'M', 3),
(4, 'L', 4),
(5, 'XL', 5),
(6, 'XXL', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `talles_niños`
--

CREATE TABLE `talles_niños` (
  `id` int(11) NOT NULL,
  `nombre` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `talles_niños`
--

INSERT INTO `talles_niños` (`id`, `nombre`) VALUES
(1, '4'),
(2, '6'),
(3, '8'),
(4, '10'),
(5, '12'),
(6, '14'),
(7, '16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `clave` varchar(255) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `rol` varchar(20) DEFAULT 'cliente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `email`, `clave`, `nombre`, `apellido`, `telefono`, `direccion`, `descripcion`, `foto_perfil`, `fecha_registro`, `rol`) VALUES
(8, 'lucas', '', '$2y$10$cZYxuh0aKbJSQ.pEXXMbv..6sxIb.ERHsiELp9uhCcjp57Bj0Vk.2', '', '', NULL, NULL, NULL, NULL, '2025-06-15 00:28:49', 'cliente'),
(9, 'El \"10\"', 'franco.mastan.t1vl@gmail.com', '$2y$10$/pcUahMFPiPTIQHq2RwwyOPxhIgGyU4p3CfBpAcBvznjDrwU5Xr6C', 'Rama', 'Mastantuono', '1176231788', 'virrey del pino 3456', '', 'perfil_9_1749954568.jpg', '2025-06-15 02:27:22', 'cliente'),
(12, 'admin', 'admin@example.com', '$2y$10$.wkvQ4VudfK26XN69eLwb.bCl2UJ6ED9NJT3h16hoasQryp5BN0ii', 'Administrador', 'Principal', NULL, NULL, NULL, NULL, '2025-06-27 02:20:01', 'admin'),
(15, 'owenpro10', 'owen.olea.t1vl@gmail.com', '$2y$10$ABmLVPiyEHQOtbSF4jLSwOsmEsj0J/xPBESG2MUAqJcFFww01hsI.', 'Owen', 'olea', NULL, NULL, NULL, NULL, '2025-07-09 18:12:13', 'cliente');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carritos`
--
ALTER TABLE `carritos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_carritos_usuario` (`usuario_id`);

--
-- Indices de la tabla `carrito_items`
--
ALTER TABLE `carrito_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_carritos_id` (`carritos_id`),
  ADD KEY `idx_producto_id` (`producto_id`),
  ADD KEY `fk_carrito_items_talle` (`talle_id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_compras_usuarios` (`usuario_id`);

--
-- Indices de la tabla `compra_items`
--
ALTER TABLE `compra_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_orden_id` (`orden_id`),
  ADD KEY `idx_producto_id` (`producto_id`),
  ADD KEY `fk_compra_items_talle` (`talle_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria_id` (`categoria_id`),
  ADD KEY `subcategoria_id` (`subcategoria_id`),
  ADD KEY `idx_categoria_id` (`categoria_id`),
  ADD KEY `idx_subcategoria_id` (`subcategoria_id`);

--
-- Indices de la tabla `subcategorias`
--
ALTER TABLE `subcategorias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Indices de la tabla `talles`
--
ALTER TABLE `talles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `talles_niños`
--
ALTER TABLE `talles_niños`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carritos`
--
ALTER TABLE `carritos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `carrito_items`
--
ALTER TABLE `carrito_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=196;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT de la tabla `compra_items`
--
ALTER TABLE `compra_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `subcategorias`
--
ALTER TABLE `subcategorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `talles`
--
ALTER TABLE `talles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `talles_niños`
--
ALTER TABLE `talles_niños`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carritos`
--
ALTER TABLE `carritos`
  ADD CONSTRAINT `fk_carritos_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `carrito_items`
--
ALTER TABLE `carrito_items`
  ADD CONSTRAINT `fk_carrito_items_carritos` FOREIGN KEY (`carritos_id`) REFERENCES `carritos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_carrito_items_productos` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `fk_carrito_items_talle` FOREIGN KEY (`talle_id`) REFERENCES `talles` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `fk_compras_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `compra_items`
--
ALTER TABLE `compra_items`
  ADD CONSTRAINT `fk_compra_items_compras` FOREIGN KEY (`orden_id`) REFERENCES `compras` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_compra_items_talle` FOREIGN KEY (`talle_id`) REFERENCES `talles` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`),
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`subcategoria_id`) REFERENCES `subcategorias` (`id`);

--
-- Filtros para la tabla `subcategorias`
--
ALTER TABLE `subcategorias`
  ADD CONSTRAINT `subcategorias_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
