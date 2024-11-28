-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-11-2024 a las 21:43:27
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
-- Base de datos: `bdrescevicheria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `numero_mesa` int(11) NOT NULL,
  `cantidad_personas` int(11) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` enum('Pendiente','En proceso','Resuelto') DEFAULT 'Pendiente',
  `fecha_reserva` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reservas`
--

INSERT INTO `reservas` (`id`, `usuario_id`, `numero_mesa`, `cantidad_personas`, `descripcion`, `estado`, `fecha_reserva`) VALUES
(76, 145, 1, 10, 'con mi familia ', 'Resuelto', '2024-11-27 01:58:21'),
(77, 145, 2, 1, 'ada', 'Resuelto', '2024-11-27 02:21:36'),
(78, 145, 3, 4, 'jdad', 'Resuelto', '2024-11-27 02:21:46'),
(79, 58, 1, 1, 'sas', 'Resuelto', '2024-11-27 02:28:03'),
(80, 58, 1, 1, 'dad', 'Resuelto', '2024-11-27 07:27:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbcargo`
--

CREATE TABLE `tbcargo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `tbcargo`
--

INSERT INTO `tbcargo` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Administrador', NULL),
(2, 'cliente', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbpermisos`
--

CREATE TABLE `tbpermisos` (
  `id` int(11) NOT NULL,
  `cargo_id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbproductos`
--

CREATE TABLE `tbproductos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio_personal` decimal(10,2) DEFAULT NULL,
  `precio_mediano` decimal(10,2) DEFAULT NULL,
  `precio_familiar` decimal(10,2) DEFAULT NULL,
  `categoria` enum('Ceviche','Chicharrones y Jaleas','Mariscos','Parihuelas, sudados pasados y encebollados','Las leches del chef','Especiales de la casa','Festival de TACU TACU','Criollos','Sabado, Domingo y Feriados') NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1,
  `tiempo-creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `actualizacion-hora` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbproductos`
--

INSERT INTO `tbproductos` (`id`, `nombre`, `descripcion`, `precio_personal`, `precio_mediano`, `precio_familiar`, `categoria`, `imagen`, `estado`, `tiempo-creacion`, `actualizacion-hora`) VALUES
(60, 'Tres Sabores', 'Langostino, conchas negras y tiradito de rocoto o escabeche', 0.00, 60.00, 0.00, 'Ceviche', '', 1, '2024-11-10 21:08:12', '2024-11-10 21:08:12'),
(61, 'Ceviche de Filete', '', 35.00, 45.00, 55.00, 'Ceviche', '673120ff97ab5.jpg', 1, '2024-11-10 21:09:19', '2024-11-10 21:09:19'),
(62, 'Ceviche de Filete de Caballa', '', 30.00, 40.00, 50.00, 'Ceviche', '673121214ba45.jpg', 1, '2024-11-10 21:09:53', '2024-11-10 21:09:53'),
(63, 'Filete de Mero', '', 0.00, 60.00, 0.00, 'Ceviche', '6731214ee3247.jpg', 1, '2024-11-10 21:10:38', '2024-11-10 21:10:38'),
(64, 'Filete de Mero con Mariscos', '', 0.00, 75.00, 0.00, 'Ceviche', '67312162a825d.jpg', 1, '2024-11-10 21:10:58', '2024-11-10 21:10:58'),
(65, 'Filete en Salsa de Rocoto', '', 40.00, 50.00, 60.00, 'Ceviche', '673121824587e.jpg', 1, '2024-11-10 21:11:30', '2024-11-10 21:11:30'),
(66, 'Filete de Cabrillón', '', 0.00, 70.00, 0.00, 'Ceviche', '673121a349e45.jpg', 1, '2024-11-10 21:12:03', '2024-11-10 21:12:03'),
(67, 'Filete de Cabrillón con Langostino', '', 55.00, 65.00, 75.00, 'Ceviche', '673121be87127.jpg', 1, '2024-11-10 21:12:30', '2024-11-10 21:12:30'),
(68, 'Todo Poderoso', 'Leche de Tigre, Ceviche de Filete con Mariscos y Tiradito de Escabeche', 0.00, 60.00, 0.00, 'Ceviche', '6737dbe044cb8.jpg', 1, '2024-11-10 21:13:35', '2024-11-15 23:40:16'),
(69, 'Bronceado', 'Ceviche de Filete con Mariscos y Tiradito al Olivo', 0.00, 60.00, 0.00, 'Ceviche', '', 1, '2024-11-10 21:14:06', '2024-11-27 01:39:01'),
(70, 'Tiradito Clásico Luigy´s', 'Ceviche de Mero, Cabrillón, Langostino y Tiradito de Caballa', 35.00, 50.00, 65.00, 'Ceviche', '', 1, '2024-11-10 21:16:16', '2024-11-10 21:16:16'),
(71, 'Chicharrón de Pescado', '', 30.00, 40.00, 50.00, 'Chicharrones y Jaleas', '6731273555438.jpg', 1, '2024-11-10 21:35:49', '2024-11-10 21:35:49'),
(72, 'Chicharrón de Pollo', '', 35.00, 45.00, 55.00, 'Chicharrones y Jaleas', '67312808a00a2.jpg', 1, '2024-11-10 21:39:20', '2024-11-10 21:39:20'),
(73, 'Jalea Mixta de Mero o Cabrillón', '', 0.00, 85.00, 100.00, 'Chicharrones y Jaleas', '673128242ce97.jpg', 1, '2024-11-10 21:39:48', '2024-11-10 21:39:48'),
(74, 'Jalea Criolla de Mero o Cabrillón', '', 0.00, 70.00, 90.00, 'Chicharrones y Jaleas', '673129f27d701.jpg', 1, '2024-11-10 21:40:03', '2024-11-10 21:47:30'),
(75, 'Jalea Criolla de Cabrilla', '', 0.00, 50.00, 0.00, 'Chicharrones y Jaleas', '6731284e9a295.jpeg', 1, '2024-11-10 21:40:30', '2024-11-10 21:40:30'),
(76, 'Jalea Mixta de Cabrilla', '', 0.00, 50.00, 70.00, 'Chicharrones y Jaleas', '673128732b44c.jpeg', 1, '2024-11-10 21:41:07', '2024-11-10 21:41:07'),
(77, 'Mero o Cabrillón a lo Macho', '', 0.00, 70.00, 80.00, 'Chicharrones y Jaleas', '6731288e65185.jpg', 1, '2024-11-10 21:41:34', '2024-11-10 21:41:34'),
(78, 'Mero o Cabrillón en salsa de Mariscos', '', 0.00, 70.00, 80.00, 'Chicharrones y Jaleas', '673128bef1e01.jpg', 1, '2024-11-10 21:42:22', '2024-11-10 21:42:22'),
(79, 'Chicharrón de Pescado con Mariscos', '', 45.00, 55.00, 65.00, 'Chicharrones y Jaleas', '673128e667b2f.jpg', 1, '2024-11-10 21:43:02', '2024-11-10 21:43:02'),
(80, 'Chicharrón de Pescado y Pollo', '', 40.00, 50.00, 60.00, 'Chicharrones y Jaleas', '673129004a201.jpg', 1, '2024-11-10 21:43:28', '2024-11-10 21:43:28'),
(81, 'Chicharrón de Pescado en salsa de Mariscos', '', 45.00, 55.00, 65.00, 'Chicharrones y Jaleas', '673129215991f.jpg', 1, '2024-11-10 21:44:01', '2024-11-10 21:44:01'),
(82, 'Chicharrón de Pescado a la Diablada', 'Picante', 45.00, 55.00, 65.00, 'Chicharrones y Jaleas', '6731293c041dc.jpg', 1, '2024-11-10 21:44:28', '2024-11-10 21:44:28'),
(83, 'Arroz con Mariscos', '', 35.00, 45.00, 55.00, 'Mariscos', '67312b51234b9.jpg', 1, '2024-11-10 21:53:21', '2024-11-10 21:53:21'),
(84, 'Arroz con Langostinos', '', 35.00, 45.00, 55.00, 'Mariscos', '67312b8d09499.jpg', 1, '2024-11-10 21:54:21', '2024-11-10 21:54:21'),
(85, 'Majariscos', '', 40.00, 50.00, 60.00, 'Mariscos', '67312b9f934ad.jpeg', 1, '2024-11-10 21:54:39', '2024-11-10 21:54:39'),
(86, 'Mixto 1°', 'Arroz con Mariscos y Arroz con Conchas Negras', 0.00, 60.00, 0.00, 'Mariscos', '67312bbe4a6a6.jpg', 1, '2024-11-10 21:55:10', '2024-11-10 21:55:10'),
(87, 'Mixto 2°', 'Arroz con Langostino y Arroz chaufa con Mariscos', 0.00, 60.00, 0.00, 'Mariscos', '67312c0b97771.jpeg', 1, '2024-11-10 21:56:27', '2024-11-10 21:56:27'),
(88, 'Parihuela \"La Poderosa\"', 'Maricos, Mero, Cangrejo y Ceviche de Conchas Negras', 0.00, 100.00, 0.00, 'Parihuelas, sudados pasados y encebollados', '', 1, '2024-11-10 21:57:26', '2024-11-10 21:57:26'),
(89, 'Parihuela de Mero y Cabrillón', '', 0.00, 70.00, 90.00, 'Parihuelas, sudados pasados y encebollados', '67312ef46e0d9.jpg', 1, '2024-11-10 22:08:52', '2024-11-10 22:08:52'),
(90, 'Parihuela de Cabrilla', '', 60.00, 70.00, 0.00, 'Parihuelas, sudados pasados y encebollados', '67312f0edd801.jpeg', 1, '2024-11-10 22:09:18', '2024-11-10 22:09:18'),
(91, 'Sudado de Cabrillón o Mero', '', 0.00, 70.00, 90.00, 'Parihuelas, sudados pasados y encebollados', '67312f2a05964.jpg', 1, '2024-11-10 22:09:46', '2024-11-10 22:09:46'),
(92, 'Sudado de Cabrilla', '', 45.00, 55.00, 65.00, 'Parihuelas, sudados pasados y encebollados', '67312f4f95b27.jpg', 1, '2024-11-10 22:10:23', '2024-11-10 22:10:23'),
(93, 'Pasadito de Cabrillón o Mero', '', 0.00, 70.00, 90.00, 'Parihuelas, sudados pasados y encebollados', '67312f8305ce6.jpg', 1, '2024-11-10 22:11:15', '2024-11-10 22:11:15'),
(94, 'Pasadito de Filete de Caballa', '', 0.00, 40.00, 0.00, 'Parihuelas, sudados pasados y encebollados', '67312fa1af2b0.jpg', 1, '2024-11-10 22:11:45', '2024-11-10 22:11:45'),
(95, 'Encebollado de Cabrilla o Cachema', '', 45.00, 60.00, 70.00, 'Parihuelas, sudados pasados y encebollados', '67312fc937d9e.jpeg', 1, '2024-11-10 22:12:25', '2024-11-10 22:12:25'),
(96, 'Chupe de Pescado', '', 35.00, 45.00, 55.00, 'Parihuelas, sudados pasados y encebollados', '67312fe9e1731.jpg', 1, '2024-11-10 22:12:57', '2024-11-10 22:12:57'),
(97, 'Chupe de Cangrejos', '', 35.00, 45.00, 55.00, 'Parihuelas, sudados pasados y encebollados', '67312ffd9ef9d.jpeg', 1, '2024-11-10 22:13:17', '2024-11-10 22:13:17'),
(98, 'Chupe Afrodisiaco', 'Cangrejos, Mariscos y Pescado', 0.00, 50.00, 0.00, 'Parihuelas, sudados pasados y encebollados', '6731301aefe9c.jpeg', 1, '2024-11-10 22:13:46', '2024-11-10 22:13:46'),
(99, 'Leche de Tigre de la Casa', '', 0.00, 18.00, 0.00, 'Las leches del chef', '', 1, '2024-11-10 22:19:04', '2024-11-10 22:19:04'),
(100, 'Leche de Pantera', '', 0.00, 25.00, 0.00, 'Las leches del chef', '673132bc8aeb9.jpg', 1, '2024-11-10 22:25:00', '2024-11-10 22:25:00'),
(101, 'Leche de Tigre de Rocoto', '', 0.00, 20.00, 0.00, 'Las leches del chef', '673132d78747a.jpeg', 1, '2024-11-10 22:25:27', '2024-11-10 22:25:27'),
(102, 'Leche de Tigre de Escabeche', '', 0.00, 20.00, 0.00, 'Las leches del chef', '673132eea4223.jpg', 1, '2024-11-10 22:25:50', '2024-11-10 22:25:50'),
(103, 'Leche de Tigre Fria', '', 0.00, 22.00, 0.00, 'Las leches del chef', '673132fd4c529.jpeg', 1, '2024-11-10 22:26:05', '2024-11-10 22:26:05'),
(104, 'Tacu Tacu con Seco de Cabrito al Jugo', '', 0.00, 50.00, 0.00, 'Festival de TACU TACU', '673134318940c.jpg', 1, '2024-11-10 22:31:13', '2024-11-10 22:31:13'),
(105, 'Tacu Tacu con Costillas de Cerdo y Sarsa', '', 0.00, 50.00, 0.00, 'Festival de TACU TACU', '6731345380859.jpeg', 1, '2024-11-10 22:31:47', '2024-11-10 22:31:47'),
(106, 'Tacu Tacu con Carne Aliñada y Sarsa', '', 0.00, 50.00, 0.00, 'Festival de TACU TACU', '673134724d557.jpg', 1, '2024-11-10 22:32:18', '2024-11-10 22:32:18'),
(107, 'Tacu Tacu con Lomito Saltado', '', 0.00, 50.00, 0.00, 'Festival de TACU TACU', '673134d2d9551.jpg', 1, '2024-11-10 22:32:41', '2024-11-10 22:33:54'),
(108, 'Tacu Tacu con Lomito Montado', '', 0.00, 60.00, 0.00, 'Festival de TACU TACU', '67313498e3a0c.jpeg', 1, '2024-11-10 22:32:56', '2024-11-10 22:32:56'),
(109, 'Tacu Tacu en Salsa de Mariscos', '', 0.00, 60.00, 0.00, 'Festival de TACU TACU', '673134ae0192f.jpeg', 1, '2024-11-10 22:33:18', '2024-11-10 22:33:18'),
(110, 'Ronda Criolla', 'Seco de Chabelo, Majadito de yuca, Costilla de cerdo, Carne Aliñada, Chifles, Sarsa y Cremas', 0.00, 90.00, 0.00, 'Especiales de la casa', '67313d56801a9.jpeg', 1, '2024-11-10 22:38:45', '2024-11-10 23:10:14'),
(111, 'Ronda Marina', 'Ceviche de Filete, Arroz con Mariscos, Chicharrón de pescado, Chifles, Sarsa y Cremas', 0.00, 90.00, 0.00, 'Especiales de la casa', '6731362b251f4.jpeg', 1, '2024-11-10 22:39:39', '2024-11-10 22:39:39'),
(112, 'Ronda Mixta', 'Ceviche de Filete, Arroz con Mariscos, Seco de Chabelo y Chicharrón', 0.00, 100.00, 0.00, 'Especiales de la casa', '67313d6c45eda.jpg', 1, '2024-11-10 22:40:12', '2024-11-10 23:10:36'),
(113, 'Ronda a la Diabla', 'Ceviche de Filete, Tiradito clásico, Salsa de Mariscos, Chicharrón de Pescado y Arroz con Mariscos', 0.00, 100.00, 0.00, 'Especiales de la casa', '', 1, '2024-11-10 22:42:03', '2024-11-10 22:42:03'),
(114, 'Ronda Mar y Tierra', 'Ceviche de Pescado, Arroz con Mariscos, Costillas de Cerdo, Carne Aliñada, Chifles y Cremas', 0.00, 100.00, 0.00, 'Especiales de la casa', '673136e207400.jpeg', 1, '2024-11-10 22:42:42', '2024-11-10 22:42:42'),
(115, 'Ronda a la Mariscada', 'Majarisco, Coctel de Mariscos, Langostinos al panko y Arroz con Mariscos', 0.00, 100.00, 0.00, 'Especiales de la casa', '6731370575a5b.jpeg', 1, '2024-11-10 22:43:17', '2024-11-10 22:43:17'),
(116, 'Seco de Chabelo', '', 35.00, 45.00, 55.00, 'Criollos', '67313aaf59b77.jpg', 1, '2024-11-10 22:58:55', '2024-11-10 22:58:55'),
(117, 'Majadito de Yuca', '', 35.00, 45.00, 55.00, 'Criollos', '67313ac981bab.jpg', 1, '2024-11-10 22:59:21', '2024-11-10 22:59:21'),
(118, 'Seco de Chabelo con Costillas de Cerdo o Carne Aliñada', '', 45.00, 55.00, 65.00, 'Criollos', '67313af041f18.jpg', 1, '2024-11-10 23:00:00', '2024-11-10 23:00:00'),
(119, 'Majadito de Yuca con Costillas de cerdo o Carne Aliñada', '', 45.00, 55.00, 65.00, 'Criollos', '67313b4b64bd4.jpeg', 1, '2024-11-10 23:01:31', '2024-11-10 23:01:31'),
(120, 'Costillas de Cero con chifles y sarsa', '', 35.00, 45.00, 55.00, 'Criollos', '67313b6ae6c16.jpg', 1, '2024-11-10 23:02:02', '2024-11-10 23:02:02'),
(121, 'Carne Aliñada con chifle y sarsa', '', 35.00, 45.00, 55.00, 'Criollos', '67313ba1e79ef.jpeg', 1, '2024-11-10 23:02:57', '2024-11-10 23:02:57'),
(122, 'Costilla de Cerdo con Carne Aliñada, Chifles y Sarsa', '', 45.00, 55.00, 65.00, 'Criollos', '67313bbd46696.jpeg', 1, '2024-11-10 23:03:25', '2024-11-10 23:03:25'),
(123, 'Seco de Cabrito con Arroz y Menestra', '', 0.00, 0.00, 0.00, 'Sabado, Domingo y Feriados', '67313c6bb67bc.jpeg', 1, '2024-11-10 23:06:19', '2024-11-10 23:06:19'),
(124, 'Arroz con Pato y Papa a la Huancaina', '', 0.00, 0.00, 0.00, 'Sabado, Domingo y Feriados', '67313c88267d1.jpeg', 1, '2024-11-10 23:06:48', '2024-11-10 23:06:48'),
(126, 'Festival de Causas Acevichadas', '', 0.00, 0.00, 0.00, 'Sabado, Domingo y Feriados', '67313cb558516.jpeg', 1, '2024-11-10 23:07:33', '2024-11-10 23:07:33'),
(128, 'Ceviche de conchas negras', '', 15.00, 30.00, 50.00, 'Ceviche', '', 1, '2024-11-27 01:41:03', '2024-11-27 01:41:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbreclamos`
--

CREATE TABLE `tbreclamos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `asunto` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha_reclamo` timestamp NOT NULL DEFAULT current_timestamp(),
  `respuesta` text DEFAULT NULL,
  `estado` enum('Pendiente','En proceso','Resuelto') DEFAULT 'Pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbreset_tokens`
--

CREATE TABLE `tbreset_tokens` (
  `id` int(11) NOT NULL,
  `token` varchar(6) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `correo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbusuario`
--

CREATE TABLE `tbusuario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellidos` varchar(255) NOT NULL,
  `dni` char(8) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `contrasenia` varchar(255) NOT NULL,
  `cargo_id` int(11) NOT NULL,
  `genero` varchar(20) NOT NULL,
  `fechaNacimiento` date NOT NULL,
  `estado` varchar(20) DEFAULT 'activo',
  `verificado` varchar(10) DEFAULT NULL,
  `token_verificacion` varchar(255) DEFAULT NULL,
  `token_verificacion_expira` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `tbusuario`
--

INSERT INTO `tbusuario` (`id`, `nombre`, `apellidos`, `dni`, `correo`, `contrasenia`, `cargo_id`, `genero`, `fechaNacimiento`, `estado`, `verificado`, `token_verificacion`, `token_verificacion_expira`) VALUES
(58, 'tatiana', 'Oliva Huaman', '74443432', 'OlivaHuamanLesly@gmail.com', 'jaren244', 1, 'Femenino', '2024-11-12', 'activo', '1', NULL, NULL),
(144, 'Jaren Ismael', 'Juarez Saldarriaga', '74443434', 'jjuarezsa01@ucvvirtual.edu.pe', '12345@P14', 2, 'masculino', '2024-11-26', 'activo', '1', NULL, NULL),
(145, 'Oscar ', 'Calero ', '73176565', 'jarenjuarezsaldarriaga25@gmail.com', 'Prueba@123', 2, 'masculino', '2004-11-11', 'activo', '1', NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `tbcargo`
--
ALTER TABLE `tbcargo`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `nombre` (`nombre`) USING BTREE;

--
-- Indices de la tabla `tbpermisos`
--
ALTER TABLE `tbpermisos`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `cargo` (`cargo_id`),
  ADD KEY `nombre` (`nombre`) USING BTREE;

--
-- Indices de la tabla `tbproductos`
--
ALTER TABLE `tbproductos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbreclamos`
--
ALTER TABLE `tbreclamos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `tbreset_tokens`
--
ALTER TABLE `tbreset_tokens`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `email` (`correo`) USING BTREE;

--
-- Indices de la tabla `tbusuario`
--
ALTER TABLE `tbusuario`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `idCargo` (`cargo_id`) USING BTREE,
  ADD KEY `rol_id` (`cargo_id`) USING BTREE,
  ADD KEY `correo` (`correo`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT de la tabla `tbcargo`
--
ALTER TABLE `tbcargo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tbpermisos`
--
ALTER TABLE `tbpermisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbproductos`
--
ALTER TABLE `tbproductos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT de la tabla `tbreclamos`
--
ALTER TABLE `tbreclamos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `tbreset_tokens`
--
ALTER TABLE `tbreset_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT de la tabla `tbusuario`
--
ALTER TABLE `tbusuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `tbusuario` (`id`);

--
-- Filtros para la tabla `tbpermisos`
--
ALTER TABLE `tbpermisos`
  ADD CONSTRAINT `tbpermisos_ibfk_1` FOREIGN KEY (`cargo_id`) REFERENCES `tbcargo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbreclamos`
--
ALTER TABLE `tbreclamos`
  ADD CONSTRAINT `tbreclamos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `tbusuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbreset_tokens`
--
ALTER TABLE `tbreset_tokens`
  ADD CONSTRAINT `tbreset_tokens_ibfk_1` FOREIGN KEY (`correo`) REFERENCES `tbusuario` (`correo`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
