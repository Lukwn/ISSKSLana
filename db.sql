-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 22-10-2023 a las 18:41:12
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
  `pasahitza` varchar(100) NOT NULL,
  `salt` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ERABILTZAILE`
--

INSERT INTO `ERABILTZAILE` (`Izen_Abizenak`, `NAN`, `Telefonoa`, `Jaiotze_data`, `email`, `pasahitza`, `salt`) VALUES
('Luken Escobero', '46374748D', 123456789, '2003-04-21', 'lol@mail.com', '$2y$10$zebi0z7i5eCAmfVY8h8Z0.Njul7IH6yz5NsXpLM35um6IOwgdwvsa', 'd1b65f4963452be3a3aad1ae54d877a4');

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
(11, 'Marroi', 'L', 20, 'Marroia', 'Zara', 'img/kamiseta3.jpg'),
(15, 'Beltza', 'S', 18, 'Beltza', 'Burshke', 'img/kamiseta2.jpg'),
(16, 'Zuria', 'XXL', 100, 'Zuria', 'Pull', 'img/kamiseta1.jpg'),
(19, 'Grisa', 'XXXL', 100, 'Gris', 'Zaru', 'img/kamiseta4.jpg'),
(20, 'Kamiseta', 'XS', 30, 'Urdina', 'Generikoa', 'img/camiseta.jpeg'),
(23, 'Kamiseta', 'XXS', 17, 'Grisa', 'Zarza', 'img/kamiseta4.jpg'),
(24, 'Patroia', 'XXL', 100, 'ASKO', 'Muyigual', 'img/gptr,1265x,front,black-c,330,402,600,600-bg,f8f8f8.jpg');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

