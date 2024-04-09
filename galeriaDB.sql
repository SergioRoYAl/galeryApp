-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-04-2024 a las 09:04:38
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
-- Base de datos: `galeria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuadro`
--

CREATE TABLE `cuadro` (
  `id` bigint(10) NOT NULL,
  `nombre` varchar(64) NOT NULL,
  `autor` varchar(64) NOT NULL,
  `descripcion` varchar(64) DEFAULT NULL,
  `precio` float NOT NULL,
  `ubicacion` varchar(256) DEFAULT NULL,
  `imagen` varchar(1024) DEFAULT NULL,
  `qr` varchar(128) DEFAULT NULL,
  `valoracion` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cuadro`
--

INSERT INTO `cuadro` (`id`, `nombre`, `autor`, `descripcion`, `precio`, `ubicacion`, `imagen`, `qr`, `valoracion`) VALUES
(3, 'La persistencia de la memoria', 'Salvador Dalí', 'Es un cuadro que representa la permeabilidad de los pensamientos', 2222220, 'Pipo Café, Avenida Rafael Puig Lluvina, Costa Adeje, España', 'images/imagen.jpg', 'qr.png', 3.8),
(7, 'Guernica', 'Picasso', 'Cuadro de gente en una taberna durante la guerra', 912983000, 'Museo Reina Sofía, Calle de Santa Isabel, Madrid, España', 'images/DE00050.jpg', NULL, 3.35714),
(22, 'La pelicula dormida', 'Xekos', 'Un cuadro representao como una escena de cine, mudo', 99191900000, 'Asamblea de Madrid, Avenida de Pablo Neruda, Madrid, España', 'images/1.png', NULL, 3),
(24, 'Porra', '2123', '14124', 12412400, 'e3edita, Calle Hermanos Machado, Puerto del Rosario, España', 'images/uoo.png', NULL, NULL);

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
(1, '2024_04_05_102825_cuadros', 1),
(2, '2024_04_05_103212_valoreurodolar', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valoracion`
--

CREATE TABLE `valoracion` (
  `id` bigint(20) NOT NULL,
  `id_cuadro` bigint(20) NOT NULL,
  `valor` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `valoracion`
--

INSERT INTO `valoracion` (`id`, `id_cuadro`, `valor`) VALUES
(1, 3, 5),
(2, 3, 2),
(3, 3, 2),
(4, 3, 1),
(5, 3, 5),
(6, 3, 5),
(7, 3, 5),
(8, 3, 5),
(9, 7, 1),
(10, 7, 5),
(11, 7, 1),
(12, 7, 5),
(13, 7, 1),
(14, 7, 5),
(15, 7, 1),
(16, 7, 5),
(17, 7, 1),
(18, 7, 5),
(19, 7, 1),
(20, 7, 5),
(21, 7, 1),
(22, 7, 5),
(23, 7, 1),
(24, 7, 4),
(25, 7, 2),
(26, 7, 4),
(27, 7, 2),
(28, 7, 4),
(29, 7, 2),
(30, 7, 5),
(31, 7, 3),
(32, 7, 5),
(33, 7, 5),
(34, 7, 5),
(35, 7, 5),
(36, 7, 5),
(37, 3, 2),
(38, 3, 4),
(39, 3, 5),
(40, 3, 5),
(41, 3, 5),
(42, 3, 5),
(43, 22, 1),
(44, 22, 5),
(45, 22, 5),
(46, 22, 5),
(47, 22, 1),
(48, 22, 1),
(49, 3, 5),
(50, 3, 5),
(51, 3, 4),
(52, 3, 3),
(53, 3, 1),
(54, 3, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valoreurodolar`
--

CREATE TABLE `valoreurodolar` (
  `id` bigint(20) NOT NULL,
  `valored` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `valoreurodolar`
--

INSERT INTO `valoreurodolar` (`id`, `valored`) VALUES
(0, 1.085582);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cuadro`
--
ALTER TABLE `cuadro`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `valoracion`
--
ALTER TABLE `valoracion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `valoreurodolar`
--
ALTER TABLE `valoreurodolar`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cuadro`
--
ALTER TABLE `cuadro`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `valoracion`
--
ALTER TABLE `valoracion`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
