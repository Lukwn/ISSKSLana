-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 14-10-2023 a las 11:28:26
-- Versión del servidor: 10.8.2-MariaDB-1:10.8.2+maria~focal
-- Versión de PHP: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `database`
--
CREATE DATABASE IF NOT EXISTS `database` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `database`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ERABILTZAILE`
--

CREATE TABLE `ERABILTZAILE` (
  `Izen_Abizenak` varchar(40) NOT NULL,
  `NAN` varchar(10) NOT NULL,
  `Telefonoa` int(9) NOT NULL,
  `Jaiotze_data` date NOT NULL,
  `email` varchar(100) NOT NULL,
  `pasahitza` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ERABILTZAILE`
--

INSERT INTO `ERABILTZAILE` (`Izen_Abizenak`, `NAN`, `Telefonoa`, `Jaiotze_data`, `email`, `pasahitza`) VALUES
('Luken Escobero', '46374748D', 688696167, '2003-04-21', 'lukenescobero01@gmail.com', 'Admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `OBJEKTUA`
--

CREATE TABLE `OBJEKTUA` (
  `id` int(11) NOT NULL,
  `izena` varchar(100) NOT NULL,
  `neurria` varchar(10) NOT NULL,
  `prezioa` decimal(10,0) NOT NULL,
  `kolorea` varchar(100) NOT NULL,
  `marka` varchar(100) NOT NULL,
  `img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `OBJEKTUA`
--

INSERT INTO `OBJEKTUA` (`id`, `izena`, `neurria`, `prezioa`, `kolorea`, `marka`, `img`) VALUES
(11, 'a', 'a', 2, 'a', 'a', 'kamiseta3'),
(12, 'aasaf', 'asfafasf', 2, 'adfaaa', 'asffas', 'kamiseta1'),
(13, 'aasaf', 'asfafasf', 2, 'adfaaa', 'asffas', 'kamiseta1'),
(14, 'a', 'a', 2, '2', 'aaa', 'kamiseta3'),
(15, 'ADA', 'asffsf', 2, 'asffas', 'asfa', 'kamiseta3'),
(16, 'asfasfs', 'asfafasaf', 343114, 'efdssgd', 'sdgdsgg', 'kamiseta1');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ERABILTZAILE`
--
ALTER TABLE `ERABILTZAILE`
  ADD PRIMARY KEY (`NAN`);

--
-- Indices de la tabla `OBJEKTUA`
--
ALTER TABLE `OBJEKTUA`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `OBJEKTUA`
--
ALTER TABLE `OBJEKTUA`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
