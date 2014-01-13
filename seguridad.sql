-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-12-2013 a las 17:53:21
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
  `descripcion` varchar(1000) COLLATE utf8_spanish_ci NOT NULL,
  `usuario` int(3) NOT NULL,
  `ruta_imagen` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` datetime NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `FOREIGN` (`usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=17 ;

--
-- Volcado de datos para la tabla `mercado`
--

INSERT INTO `mercado` (`codigo`, `titulo`, `descripcion`, `usuario`, `ruta_imagen`, `fecha`) VALUES
(5, 'Prueba 1', 'Prueba, prueba, prueba.', 1, '', '2013-12-08 16:47:28'),
(6, 'Prueba 2', 'Prueba, prueba, prueba.', 1, '', '2013-12-10 15:56:10'),
(7, 'Prueba 3', 'Prueba, prueba, prueba.', 1, '', '2013-12-10 15:56:15'),
(8, 'Prueba 4', 'Prueba, prueba, prueba.', 1, '', '2013-12-10 15:56:19'),
(9, 'Prueba 5', 'Prueba, prueba, prueba.', 1, '', '2013-12-10 15:56:22'),
(10, 'Prueba 6', 'Prueba, prueba, prueba.', 1, '', '2013-12-10 15:56:26'),
(11, 'Prueba 7', 'Prueba, prueba, prueba.', 1, '', '2013-12-10 15:56:29'),
(12, 'Prueba 8', 'Prueba, prueba, prueba.', 1, '', '2013-12-10 15:56:34'),
(13, 'Prueba 9', 'Prueba, prueba, prueba.', 1, '', '2013-12-10 15:56:38'),
(14, 'Prueba 10', 'Prueba, prueba, prueba.', 1, '', '2013-12-10 15:56:41'),
(15, 'Prueba 11', 'Prueba, prueba, prueba.', 1, '', '2013-12-10 16:01:38'),
(16, 'Prueba 12', 'Prueba, prueba, prueba.', 1, '', '2013-12-10 16:28:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `codigo` int(3) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `correo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `telefono` int(9) NOT NULL,
  `contrasena` char(128) COLLATE utf8_spanish_ci NOT NULL,
  `tipo` tinyint(1) NOT NULL DEFAULT '0',
  `sal` char(128) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`codigo`),
  UNIQUE KEY `nombre` (`nombre`),
  UNIQUE KEY `correo` (`correo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=17 ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`codigo`, `nombre`, `correo`, `telefono`, `contrasena`, `tipo`, `sal`) VALUES
(1, 'admin', 'admin@seguridad.com', 666666668, '59565e32848db925e5a9e1e4a3afedbfd7eb3002da739f064a8864e6e5c1341a7f03e96ac4ece0952ce1a1338c4f1e91d11d0f2fb9f53ac4ddbe4eeef2ba28c7', 1, '4d6576043a66aeb91f22c829d80a0bc0bc8336b28d23bc3007aa9b1f93b37169c3f1c9fa5d26aa58af7385ef3de8bdf8304eaef9b4af6ba4bd63e66804de3c47');

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
