-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-11-2025 a las 19:13:13
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
-- Base de datos: `api_prueba_tecnica`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudades`
--

CREATE TABLE `ciudades` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `ciudades`
--

INSERT INTO `ciudades` (`id`, `nombre`, `activo`, `deleted_at`) VALUES
(1, 'Cali', 1, NULL),
(2, 'Bogota', 0, NULL),
(3, 'Medellin', 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

CREATE TABLE `vehiculos` (
  `id` int(11) NOT NULL,
  `placa` varchar(45) DEFAULT NULL,
  `color` varchar(45) DEFAULT NULL,
  `fecha_ingreso` timestamp NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `vehiculos`
--

INSERT INTO `vehiculos` (`id`, `placa`, `color`, `fecha_ingreso`, `created_at`) VALUES
(1, 'AAA123', 'Azul', '2025-07-11 02:36:14', NULL),
(2, 'BBB456', 'Verde', '2025-07-11 02:36:14', NULL),
(3, 'CCC789', 'Rojo', '2025-07-11 02:36:14', NULL),
(4, 'DDD963', 'Azul', '2025-07-11 02:36:14', NULL),
(5, 'EEE852', 'Rojo', '2025-07-11 02:36:14', NULL),
(6, 'FFF741', 'Azul', '2025-07-11 02:36:14', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `viajes`
--

CREATE TABLE `viajes` (
  `id` int(11) NOT NULL,
  `vehiculo_id` int(11) NOT NULL,
  `ciudad_origen_id` int(11) DEFAULT NULL,
  `ciudad_destino_id` int(11) DEFAULT NULL,
  `tiempo_min` int(11) DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `viajes`
--

INSERT INTO `viajes` (`id`, `vehiculo_id`, `ciudad_origen_id`, `ciudad_destino_id`, `tiempo_min`, `fecha`, `created_at`, `deleted_at`) VALUES
(1, 1, 3, 2, 8, '2025-09-16 03:03:00', NULL, NULL),
(2, 2, 2, 3, 6, '2025-09-26 03:03:53', NULL, NULL),
(3, 2, 3, 1, 12, '2025-09-30 03:03:53', NULL, NULL),
(4, 3, 1, 2, 10, '2025-10-09 03:04:35', NULL, NULL),
(5, 1, 1, 3, 15, '2025-10-11 03:23:29', NULL, NULL),
(6, 2, 1, 2, 7, '2025-10-16 03:23:29', NULL, NULL),
(7, 3, 2, 1, 9, '2025-10-30 03:23:54', NULL, NULL),
(8, 1, 1, 2, 95, '2025-10-08 05:00:00', '2025-11-05 17:43:55', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ciudades`
--
ALTER TABLE `ciudades`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `placa` (`placa`);

--
-- Indices de la tabla `viajes`
--
ALTER TABLE `viajes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehiculo_id` (`vehiculo_id`),
  ADD KEY `ciudad_origen_id` (`ciudad_origen_id`),
  ADD KEY `ciudad_destino_id` (`ciudad_destino_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ciudades`
--
ALTER TABLE `ciudades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `viajes`
--
ALTER TABLE `viajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `viajes`
--
ALTER TABLE `viajes`
  ADD CONSTRAINT `viajes_ibfk_1` FOREIGN KEY (`vehiculo_id`) REFERENCES `vehiculos` (`id`),
  ADD CONSTRAINT `viajes_ibfk_2` FOREIGN KEY (`ciudad_origen_id`) REFERENCES `ciudades` (`id`),
  ADD CONSTRAINT `viajes_ibfk_3` FOREIGN KEY (`ciudad_destino_id`) REFERENCES `ciudades` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
