-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 01-07-2024 a las 23:21:34
-- Versión del servidor: 8.0.17
-- Versión de PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `yugioh`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `RegistrarUsuarioEnEvento` (IN `p_UsuarioID` INT, IN `p_EventoID` INT)  BEGIN
    DECLARE v_Capacidad INT;

    -- Obtener la capacidad actual del evento
    SELECT Capacidad INTO v_Capacidad
    FROM eventos
    WHERE ID = p_EventoID;

    -- Verificar si hay capacidad disponible
    IF v_Capacidad > 0 THEN
        -- Insertar el registro en la tabla intermedia
        INSERT INTO usuario_eventos (UsuarioID, EventoID)
        VALUES (p_UsuarioID, p_EventoID);

        -- Disminuir la capacidad del evento
        UPDATE eventos
        SET Capacidad = Capacidad - 1
        WHERE ID = p_EventoID;
    ELSE
        -- Lanzar un error si no hay capacidad
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'No hay capacidad disponible para este evento.';
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `ID` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Descripcion` varchar(100) NOT NULL,
  `Ubicacion` varchar(50) NOT NULL,
  `Capacidad` int(11) NOT NULL,
  `Fecha` date NOT NULL,
  `Precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`ID`, `Nombre`, `Descripcion`, `Ubicacion`, `Capacidad`, `Fecha`, `Precio`) VALUES
(1, 'Yu-Gi-Oh! World Championship 2024', 'El evento más grande del año donde los mejores duelistas del mundo compiten por el título de campeón', 'Tokyo International Forum, Tokio, Japón', 5000, '2024-08-10', '150.00'),
(2, 'Yu-Gi-Oh! National Championship USA 2024', 'El campeonato nacional de Yu-Gi-Oh! en Estados Unidos para determinar al mejor duelista del país.', 'Los Angeles Convention Center, Los Angeles, CA, US', 3000, '2024-05-20', '100.00'),
(3, 'Yu-Gi-Oh! European Championship 2024', 'El campeonato europeo donde los mejores duelistas de Europa se enfrentan.', 'Messe Frankfurt, Frankfurt, Alemania', 3500, '2024-07-15', '120.00'),
(4, 'Yu-Gi-Oh! Latin America Championship 2024', 'l campeonato para los duelistas de América Latina.', 'Centro de Convenciones de São Paulo, São Paulo, Br', 2500, '2024-06-10', '80.00'),
(5, 'Yu-Gi-Oh! Asia Championship 2024', 'El campeonato asiático que reúne a los mejores duelistas del continente.', 'Hong Kong Convention and Exhibition Centre, Hong K', 4000, '2024-09-05', '130.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registros`
--

CREATE TABLE `registros` (
  `UsuarioID` int(11) NOT NULL,
  `EventoID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `ID` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Usuario` varchar(254) NOT NULL,
  `Contrasenia` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `registros`
--
ALTER TABLE `registros`
  ADD PRIMARY KEY (`UsuarioID`,`EventoID`),
  ADD KEY `EventoID` (`EventoID`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `registros`
--
ALTER TABLE `registros`
  ADD CONSTRAINT `registros_ibfk_1` FOREIGN KEY (`UsuarioID`) REFERENCES `usuarios` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `registros_ibfk_2` FOREIGN KEY (`EventoID`) REFERENCES `eventos` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
