-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-10-2019 a las 19:32:04
-- Versión del servidor: 5.6.21
-- Versión de PHP: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `u115752684_asesores`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbestadotest`
--

CREATE TABLE IF NOT EXISTS `tbestadotest` (
`idestadotest` int(11) NOT NULL,
  `estadotest` varchar(190) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tbestadotest`
--

INSERT INTO `tbestadotest` (`idestadotest`, `estadotest`) VALUES
(1, 'SE ADECÚA A LO QUE ESTÁS BUSCANDO'),
(2, 'NO SE ADECÚA A LO QUE ESTÁS BUSCANDO'),
(3, 'NO PUEDE OFRECERTE UN SUELDO FIJO, SIN EMBARGO SE ADAPTA A TUS EXPECTATIVAS ECONÓMICAS');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbestadotest`
--
ALTER TABLE `tbestadotest`
 ADD PRIMARY KEY (`idestadotest`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbestadotest`
--
ALTER TABLE `tbestadotest`
MODIFY `idestadotest` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
