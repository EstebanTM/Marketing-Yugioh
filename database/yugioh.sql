-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 08-07-2024 a las 18:11:35
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `CancelarRegistroEnEvento` (IN `p_UsuarioID` INT, IN `p_EventoID` INT)  BEGIN
    -- Verificar si el usuario está registrado en el evento
    IF EXISTS (SELECT 1 FROM registros WHERE UsuarioID = p_UsuarioID AND EventoID = p_EventoID) THEN
        -- Eliminar el registro en la tabla intermedia
        DELETE FROM registros WHERE UsuarioID = p_UsuarioID AND EventoID = p_EventoID;

        -- Incrementar la capacidad del evento
        UPDATE eventos SET Capacidad = Capacidad + 1 WHERE ID = p_EventoID;
    ELSE
        -- Lanzar un error si el usuario no está registrado en el evento
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El usuario no está registrado en este evento.';
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MostrarEventosPorUsuario` (IN `p_UsuarioID` INT)  BEGIN
    SELECT e.ID, e.Nombre, e.Descripcion, e.Ubicacion, e.Capacidad, e.Fecha, e.Precio, e.ImagenURL
    FROM registros r
    INNER JOIN eventos e ON r.EventoID = e.ID
    WHERE r.UsuarioID = p_UsuarioID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RegistrarUsuarioEnEvento` (IN `p_UsuarioID` INT, IN `p_EventoID` INT)  BEGIN
    DECLARE v_Capacidad INT;

    -- Obtener la capacidad actual del evento
    SELECT Capacidad INTO v_Capacidad
    FROM eventos
    WHERE ID = p_EventoID;

    -- Verificar si hay capacidad disponible
    IF v_Capacidad > 0 THEN
        -- Insertar el registro en la tabla intermedia
        INSERT INTO registros (UsuarioID, EventoID)
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
  `Precio` decimal(10,2) NOT NULL,
  `ImagenURL` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`ID`, `Nombre`, `Descripcion`, `Ubicacion`, `Capacidad`, `Fecha`, `Precio`, `ImagenURL`) VALUES
(1, 'Yu-Gi-Oh! World Championship 2024', 'El evento más grande del año donde los mejores duelistas del mundo compiten por el título de campeón', 'Tokyo International Forum, Tokio, Japón', 500, '2024-08-10', '150.00', 'https://www.t-i-forum.co.jp/en/mt_images/kv02_sp.jpg'),
(2, 'Yu-Gi-Oh! National Championship USA 2024', 'El campeonato nacional de Yu-Gi-Oh! en Estados Unidos para determinar al mejor duelista del país.', 'Los Angeles Convention Center, Los Angeles, CA, US', 1499, '2024-05-20', '100.00', 'https://www.lacclink.com/assets/img/20160403-DSC00998-2.png-660x360-9434d56321.png'),
(3, 'Yu-Gi-Oh! European Championship 2024', 'El campeonato europeo donde los mejores duelistas de Europa se enfrentan.', 'Messe Frankfurt, Frankfurt, Alemania', 2000, '2024-07-15', '120.00', 'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/13/88/24/47/messe-frankfurt.jpg?w=1200&h=-1&s=1'),
(4, 'Yu-Gi-Oh! Latin America Championship 2024', 'El campeonato para que los duelistas de América Latina muestren sus habilidades al mundo.', 'Centro de Convenciones de São Paulo, São Paulo, Br', 2500, '2024-06-10', '80.00', 'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/26/6f/18/4f/caption.jpg?w=500&h=500&s=1'),
(5, 'Yu-Gi-Oh! Asia Championship 2024', 'El campeonato asiático que reúne a los mejores duelistas del continente.', 'Hong Kong Convention and Exhibition Centre, Hong K', 1500, '2024-09-05', '130.00', 'https://www.mehongkong.com/dam/jcr:c46f4cc3-d802-4f19-82ab-daf5a7be1c14/HKCEC_001_860X484.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registros`
--

CREATE TABLE `registros` (
  `UsuarioID` int(11) NOT NULL,
  `EventoID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `registros`
--

INSERT INTO `registros` (`UsuarioID`, `EventoID`) VALUES
(1, 2);

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
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID`, `Nombre`, `Usuario`, `Contrasenia`) VALUES
(1, 'Esteban', 'estebantm485@gmail.com', '1234');

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
