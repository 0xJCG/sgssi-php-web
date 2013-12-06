-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-12-2013 a las 15:49:39
-- Versión del servidor: 5.6.11
-- Versión de PHP: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `seguridad`
--
CREATE DATABASE IF NOT EXISTS `seguridad` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `seguridad`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mercado`
--

CREATE TABLE IF NOT EXISTS `mercado` (
  `codigo` int(5) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `mensaje` varchar(1000) COLLATE utf8_spanish_ci NOT NULL,
  `usuario` int(3) NOT NULL,
  `ruta_imagen` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` datetime NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `FOREIGN` (`usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `mercado`
--

INSERT INTO `mercado` (`codigo`, `titulo`, `mensaje`, `usuario`, `ruta_imagen`, `fecha`) VALUES
(1, 'Se vende PS3.', 'Se vende PS3 usada en su caja original con 5 juegos y 2 mandos.', 1, NULL, '2013-12-06 12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `codigo` int(3) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `correo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `contrasena` char(128) COLLATE utf8_spanish_ci NOT NULL,
  `tipo` tinyint(1) NOT NULL DEFAULT '0',
  `sal` char(128) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`codigo`, `nombre`, `correo`, `contrasena`, `tipo`, `sal`) VALUES
(1, 'admin', '', '59565e32848db925e5a9e1e4a3afedbfd7eb3002da739f064a8864e6e5c1341a7f03e96ac4ece0952ce1a1338c4f1e91d11d0f2fb9f53ac4ddbe4eeef2ba28c7', 1, '4d6576043a66aeb91f22c829d80a0bc0bc8336b28d23bc3007aa9b1f93b37169c3f1c9fa5d26aa58af7385ef3de8bdf8304eaef9b4af6ba4bd63e66804de3c47');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `mercado`
--
ALTER TABLE `mercado`
  ADD CONSTRAINT `mercado_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

