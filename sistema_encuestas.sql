
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";



CREATE TABLE `encuestas` (
  `id_encuesta` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `titulo` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8_unicode_ci NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `fecha_inicio` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fecha_final` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `encuestas` (`id_encuesta`, `id_usuario`, `titulo`, `descripcion`, `estado`, `fecha_inicio`, `fecha_final`) VALUES
(1, 1, 'Encuesta1', 'Probemos este nuevo usuario', 1, '2023-01-14 17:25:04', '2023-01-15 17:00:00'),
(2, 1, 'Prueba 2', 'Esta es una prueba 2', 1, '2023-01-15 00:13:43', '2023-01-16 00:13:18'),
(3, 1, 'Probemos ahora si dice leida', 'La leida dice que si funkaa', 0, '2023-01-15 00:37:48', '2023-01-16 00:37:30');



CREATE TABLE `opciones` (
  `id_opcion` int(11) NOT NULL,
  `id_pregunta` int(11) NOT NULL,
  `valor` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `opciones` (`id_opcion`, `id_pregunta`, `valor`) VALUES
(4, 2, '123'),
(5, 2, '123'),
(6, 2, '12412'),
(7, 3, '125'),
(8, 3, '23523'),
(9, 3, '235235235'),
(10, 1, 'Muestars'),
(11, 5, 'si'),
(12, 5, 'no'),
(13, 5, 'talvez'),
(14, 6, 'si'),
(15, 6, 'no'),
(16, 6, 'talvez'),
(17, 7, 'si'),
(18, 7, 'no'),
(19, 7, 'talvez'),
(20, 8, 'Bien'),
(21, 8, 'Mal'),
(22, 8, 'Machomenos'),
(23, 9, 'Si soy'),
(24, 9, 'No soy'),
(25, 9, 'Leida es'),
(26, 10, 'Si soy'),
(27, 10, 'No soy'),
(28, 10, 'Leida es');



CREATE TABLE `preguntas` (
  `id_pregunta` int(11) NOT NULL,
  `id_encuesta` int(11) NOT NULL,
  `titulo` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `id_tipo_pregunta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `preguntas` (`id_pregunta`, `id_encuesta`, `titulo`, `id_tipo_pregunta`) VALUES
(1, 1, 'asd', 1),
(2, 1, '123', 1),
(3, 1, '1442', 1),
(5, 2, 'Quien eres', 1),
(6, 2, 'Porque eres', 1),
(7, 2, 'Nosotros somos', 1),
(8, 3, 'Como estas', 1),
(9, 3, 'Eres o no eres', 1),
(10, 3, 'Eres o te haces', 1);


CREATE TABLE `resultados` (
  `id_resultado` int(11) NOT NULL,
  `id_opcion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `resultados` (`id_resultado`, `id_opcion`) VALUES
(5, 11),
(2, 12),
(8, 12),
(3, 14),
(6, 15),
(9, 16),
(10, 17),
(4, 19),
(7, 19),
(14, 21),
(17, 21),
(11, 22),
(12, 23),
(15, 23),
(18, 23),
(13, 26),
(16, 26),
(19, 27);


CREATE TABLE `tipo_pregunta` (
  `id_tipo_pregunta` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


INSERT INTO `tipo_pregunta` (`id_tipo_pregunta`, `nombre`, `descripcion`) VALUES
(1, 'Selección múltiple', 'Se podrá escoger solo una opción\r\nelemento input type radio'),
(2, 'Desplegable', 'Se podrá escoger una opción\r\nElemento select y option'),
(3, 'Casilla de verificación', 'Se podrá escoger más de una opción\r\ninput type checkbox'),
(4, 'Texto', 'Se almacenara la respuesta');


CREATE TABLE `tipo_usuario` (
  `id_tipo_usuario` int(11) NOT NULL,
  `nombre` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `tipo_usuario` (`id_tipo_usuario`, `nombre`) VALUES
(1, 'Administrador'),
(2, 'Usuario');


CREATE TABLE `usuarios` (
  `id_usuario` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `clave` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `nombres` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `apellidos` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `id_tipo_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `usuarios` (`id_usuario`, `clave`, `nombres`, `apellidos`, `email`, `id_tipo_usuario`) VALUES
('1', MD5('123'), 'ADMIN', 'uno', 'admin@test.com', 1),
('2', MD5('123'), 'usuario', 'dos', 'asd@asd', 2);


CREATE TABLE `usuarios_encuestas` (
  `id_usuario` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `id_encuesta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



INSERT INTO `usuarios_encuestas` (`id_usuario`, `id_encuesta`) VALUES
(2, 1),
(2, 2),
(3, 2),
(4, 2),
(2, 3),
(3, 3),
(4, 3);



ALTER TABLE `encuestas`
  ADD PRIMARY KEY (`id_encuesta`),
  ADD KEY `id_usuario` (`id_usuario`);

ALTER TABLE `opciones`
  ADD PRIMARY KEY (`id_opcion`),
  ADD KEY `id_pregunta` (`id_pregunta`);


ALTER TABLE `preguntas`
  ADD PRIMARY KEY (`id_pregunta`),
  ADD KEY `id_encuesta` (`id_encuesta`),
  ADD KEY `id_tipo_pregunta` (`id_tipo_pregunta`);


ALTER TABLE `resultados`
  ADD PRIMARY KEY (`id_resultado`),
  ADD KEY `id_opcion` (`id_opcion`);


ALTER TABLE `tipo_pregunta`
  ADD PRIMARY KEY (`id_tipo_pregunta`);


ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`id_tipo_usuario`);


ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `id_tipo_usuario` (`id_tipo_usuario`);


ALTER TABLE `usuarios_encuestas`
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_encuesta` (`id_encuesta`);


ALTER TABLE `encuestas`
  MODIFY `id_encuesta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;


ALTER TABLE `opciones`
  MODIFY `id_opcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;


ALTER TABLE `preguntas`
  MODIFY `id_pregunta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;


ALTER TABLE `resultados`
  MODIFY `id_resultado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;


ALTER TABLE `tipo_pregunta`
  MODIFY `id_tipo_pregunta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;


ALTER TABLE `tipo_usuario`
  MODIFY `id_tipo_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;


ALTER TABLE `opciones`
  ADD CONSTRAINT `opciones_ibfk_1` FOREIGN KEY (`id_pregunta`) REFERENCES `preguntas` (`id_pregunta`) ON DELETE CASCADE ON UPDATE CASCADE;


ALTER TABLE `preguntas`
  ADD CONSTRAINT `preguntas_ibfk_1` FOREIGN KEY (`id_tipo_pregunta`) REFERENCES `tipo_pregunta` (`id_tipo_pregunta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `preguntas_ibfk_2` FOREIGN KEY (`id_encuesta`) REFERENCES `encuestas` (`id_encuesta`) ON DELETE CASCADE ON UPDATE CASCADE;


ALTER TABLE `resultados`
  ADD CONSTRAINT `resultados_ibfk_1` FOREIGN KEY (`id_opcion`) REFERENCES `opciones` (`id_opcion`) ON DELETE CASCADE ON UPDATE CASCADE;


ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_tipo_usuario`) REFERENCES `tipo_usuario` (`id_tipo_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `usuarios_encuestas`
  ADD CONSTRAINT `usuarios_encuestas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuarios_encuestas_ibfk_2` FOREIGN KEY (`id_encuesta`) REFERENCES `encuestas` (`id_encuesta`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

