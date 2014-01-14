-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-01-2014 a las 19:42:25
-- Versión del servidor: 5.5.34
-- Versión de PHP: 5.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `seguridad`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=23 ;

--
-- Volcado de datos para la tabla `mercado`
--

INSERT INTO `mercado` (`codigo`, `titulo`, `descripcion`, `usuario`, `ruta_imagen`, `fecha`) VALUES
(22, 'Prueba', 'Escribiendo una oferta de prueba para probar el funcionamento de la pÃ¡gina web.', 1, NULL, '2014-01-14 19:42:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `codigo` int(3) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `correo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `telefono` int(9) NOT NULL,
  `cbancaria` char(64) COLLATE utf8_spanish_ci NOT NULL,
  `contrasena` char(128) COLLATE utf8_spanish_ci NOT NULL,
  `tipo` tinyint(1) NOT NULL DEFAULT '0',
  `sal` char(128) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`codigo`),
  UNIQUE KEY `nombre` (`nombre`),
  UNIQUE KEY `correo` (`correo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`codigo`, `nombre`, `correo`, `telefono`, `cbancaria`, `contrasena`, `tipo`, `sal`) VALUES
(1, 'admin', 'admin@seguridad.com', 216054588, '005494cc6427229a6f1575c3441fe2b22165c1489075fe4c557f35c0cc6c7309', '59565e32848db925e5a9e1e4a3afedbfd7eb3002da739f064a8864e6e5c1341a7f03e96ac4ece0952ce1a1338c4f1e91d11d0f2fb9f53ac4ddbe4eeef2ba28c7', 1, '4d6576043a66aeb91f22c829d80a0bc0bc8336b28d23bc3007aa9b1f93b37169c3f1c9fa5d26aa58af7385ef3de8bdf8304eaef9b4af6ba4bd63e66804de3c47');

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
