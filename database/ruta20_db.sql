-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-02-2026 a las 16:00:20
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
-- Base de datos: `ruta20_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades`
--

CREATE TABLE `actividades` (
  `id` int(11) NOT NULL,
  `ciudad` varchar(50) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tipo` enum('actividad','traslado') DEFAULT 'actividad',
  `activo` tinyint(4) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `actividades`
--

INSERT INTO `actividades` (`id`, `ciudad`, `nombre`, `descripcion`, `precio`, `tipo`, `activo`, `created_at`) VALUES
(1, 'Armenia', 'Recorrido Cafetero', 'Visita a finca cafetera con degustación', 80000.00, 'actividad', 1, '2026-02-24 02:15:20'),
(2, 'Armenia', 'Parque del Café', 'Entrada y atracciones del Parque del Café', 120000.00, 'actividad', 1, '2026-02-24 02:15:20'),
(3, 'Armenia', 'Traslado Aeropuerto-Hotel', 'Desde El Edén hasta el hotel', 50000.00, 'traslado', 1, '2026-02-24 02:15:20'),
(4, 'Armenia', 'Traslado Hotel-Aeropuerto', 'Desde el hotel hasta El Edén', 50000.00, 'traslado', 1, '2026-02-24 02:15:20'),
(5, 'Pereira', 'Termales Santa Rosa', 'Día en aguas termales Santa Rosa de Cabal', 90000.00, 'actividad', 1, '2026-02-24 02:15:20'),
(6, 'Pereira', 'Recorrido Ciudad Pereira', 'City tour por los principales atractivos', 60000.00, 'actividad', 1, '2026-02-24 02:15:20'),
(7, 'Pereira', 'Traslado Aeropuerto-Hotel', 'Desde Matecaña hasta el hotel', 55000.00, 'traslado', 1, '2026-02-24 02:15:20'),
(8, 'Pereira', 'Traslado Hotel-Termales', 'Desde el hotel hasta Termales Santa Rosa', 45000.00, 'traslado', 1, '2026-02-24 02:15:20'),
(9, 'Pereira', 'Traslado Hotel-Aeropuerto', 'Desde el hotel hasta Matecaña', 55000.00, 'traslado', 1, '2026-02-24 02:15:20'),
(10, 'Manizales', 'Nevado del Ruiz', 'Excursión al Parque Nacional Los Nevados', 150000.00, 'actividad', 1, '2026-02-24 02:15:20'),
(11, 'Manizales', 'Recorrido Cable Aéreo', 'Paseo en teleférico sobre Manizales', 70000.00, 'actividad', 1, '2026-02-24 02:15:20'),
(12, 'Manizales', 'Traslado Aeropuerto-Hotel', 'Desde La Nubia hasta el hotel', 60000.00, 'traslado', 1, '2026-02-24 02:15:20'),
(13, 'Manizales', 'Traslado Hotel-Aeropuerto', 'Desde el hotel hasta La Nubia', 60000.00, 'traslado', 1, '2026-02-24 02:15:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizaciones`
--

CREATE TABLE `cotizaciones` (
  `id` int(11) NOT NULL,
  `origen` varchar(100) DEFAULT NULL,
  `destino` varchar(50) DEFAULT NULL,
  `fecha_ida` date DEFAULT NULL,
  `fecha_regreso` date DEFAULT NULL,
  `adultos` int(11) DEFAULT 1,
  `ninos` int(11) DEFAULT 0,
  `hotel_id` int(11) DEFAULT NULL,
  `tipo_habitacion` enum('sencilla','doble','triple') DEFAULT 'doble',
  `habitaciones` int(11) DEFAULT 1,
  `nombres` varchar(100) DEFAULT NULL,
  `apellidos` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `servicios_ids` text DEFAULT NULL,
  `actividades_ids` text DEFAULT NULL,
  `estado` enum('pendiente','confirmada','cancelada') DEFAULT 'pendiente',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `destinos`
--

CREATE TABLE `destinos` (
  `id` int(11) NOT NULL,
  `ciudad` varchar(50) NOT NULL,
  `precio_base` decimal(10,2) NOT NULL,
  `aeropuerto` varchar(100) DEFAULT NULL,
  `activo` tinyint(4) DEFAULT 1,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `destinos`
--

INSERT INTO `destinos` (`id`, `ciudad`, `precio_base`, `aeropuerto`, `activo`, `updated_at`) VALUES
(1, 'Armenia', 250000.00, 'Aeropuerto El Edén', 1, '2026-02-24 02:14:02'),
(2, 'Pereira', 280000.00, 'Aeropuerto Internacional Matecaña', 1, '2026-02-24 02:14:02'),
(3, 'Manizales', 300000.00, 'Aeropuerto La Nubia', 1, '2026-02-24 02:14:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hoteles`
--

CREATE TABLE `hoteles` (
  `id` int(11) NOT NULL,
  `ciudad` varchar(50) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `precio_sencilla` decimal(10,2) DEFAULT 0.00,
  `precio_doble` decimal(10,2) DEFAULT 0.00,
  `precio_triple` decimal(10,2) DEFAULT 0.00,
  `descripcion` text DEFAULT NULL,
  `activo` tinyint(4) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `hoteles`
--

INSERT INTO `hoteles` (`id`, `ciudad`, `nombre`, `precio_sencilla`, `precio_doble`, `precio_triple`, `descripcion`, `activo`, `created_at`) VALUES
(1, 'Armenia', 'Hotel Centenario', 150000.00, 200000.00, 260000.00, NULL, 1, '2026-02-24 02:14:39'),
(2, 'Armenia', 'Hotel Boutique Armenia', 180000.00, 240000.00, 300000.00, NULL, 1, '2026-02-24 02:14:39'),
(3, 'Pereira', 'Hotel Soratama', 160000.00, 210000.00, 270000.00, NULL, 1, '2026-02-24 02:14:39'),
(4, 'Pereira', 'Hotel Movich', 200000.00, 260000.00, 320000.00, NULL, 1, '2026-02-24 02:14:39'),
(5, 'Manizales', 'Hotel Estelar', 170000.00, 220000.00, 280000.00, NULL, 1, '2026-02-24 02:14:39'),
(6, 'Manizales', 'Hotel Termales', 190000.00, 250000.00, 310000.00, NULL, 1, '2026-02-24 02:14:39');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paquetes`
--

CREATE TABLE `paquetes` (
  `id` int(11) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `precio` varchar(50) NOT NULL,
  `descripcion` text NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `destacado` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `paquetes`
--

INSERT INTO `paquetes` (`id`, `ciudad`, `titulo`, `precio`, `descripcion`, `imagen`, `link`, `fecha_creacion`, `destacado`) VALUES
(1, 'Armenia', 'paquete armenia par una persona ', '100000', 'disfruta del viaje a armenia con todo pago ', 'Diseño sin título (1).png', NULL, '2026-02-22 22:14:36', 1),
(2, 'Pereira', 'Paqute hotal soratama ', '2000000', 'es un paquete que incluye todo ', 'escena 4.png', NULL, '2026-02-22 23:43:14', 0),
(3, 'Armenia', 'Parque del cafe ', '150000', 'atracciones parque del cafe ', 'ChatGPT Image 19 feb 2026, 09_12_31 p.m..png', NULL, '2026-02-22 23:55:32', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `id` int(11) NOT NULL,
  `paquete_id` int(11) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `personas` int(11) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `total` decimal(12,2) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reservas`
--

INSERT INTO `reservas` (`id`, `paquete_id`, `ciudad`, `personas`, `nombres`, `apellidos`, `telefono`, `correo`, `total`, `fecha`) VALUES
(1, 0, '', 1, 'cesar', 'henao', '3127542176', 'cesa@prueba.com', 0.00, '2026-02-23 00:46:28'),
(2, 3, 'Armenia', 5, 'cesar', 'henao', '3127542176', 'cesa@prueba.com', 750000.00, '2026-02-23 00:54:28'),
(3, 3, 'Armenia', 5, 'cesar', 'henao', '3127542176', 'cesa@prueba.com', 750000.00, '2026-02-23 19:11:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rutas`
--

CREATE TABLE `rutas` (
  `id` int(11) NOT NULL,
  `ciudad` varchar(50) NOT NULL,
  `origen` varchar(100) NOT NULL,
  `destino` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `duracion` varchar(50) DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `tipo` enum('aeropuerto','hotel','turistico','entre_ciudades') DEFAULT 'turistico',
  `activo` tinyint(4) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL DEFAULT 0.00,
  `activo` tinyint(4) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id`, `nombre`, `descripcion`, `precio`, `activo`, `created_at`) VALUES
(1, 'Tiquete aéreo ida y vuelta', 'Tiquete aéreo desde Bogotá al destino y regreso', 450000.00, 1, '2026-02-24 02:15:53'),
(2, 'Seguro de viaje', 'Seguro médico y de equipaje durante el viaje', 35000.00, 1, '2026-02-24 02:15:53'),
(3, 'Guía turístico', 'Guía bilingüe durante todo el recorrido', 80000.00, 1, '2026-02-24 02:15:53');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hotel_id` (`hotel_id`);

--
-- Indices de la tabla `destinos`
--
ALTER TABLE `destinos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `hoteles`
--
ALTER TABLE `hoteles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `paquetes`
--
ALTER TABLE `paquetes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rutas`
--
ALTER TABLE `rutas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividades`
--
ALTER TABLE `actividades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `destinos`
--
ALTER TABLE `destinos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `hoteles`
--
ALTER TABLE `hoteles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `paquetes`
--
ALTER TABLE `paquetes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `rutas`
--
ALTER TABLE `rutas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  ADD CONSTRAINT `cotizaciones_ibfk_1` FOREIGN KEY (`hotel_id`) REFERENCES `hoteles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
