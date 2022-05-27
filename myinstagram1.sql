-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-02-2022 a las 00:46:48
-- Versión del servidor: 10.1.39-MariaDB
-- Versión de PHP: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `myinstagram1`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `comment`
--

INSERT INTO `comment` (`id`, `post_id`, `user_id`, `descripcion`, `time`) VALUES
(16, 2, 1, 'Across the stars', '2022-02-09 00:00:00'),
(17, 2, 1, 'Epic', '2022-02-08 09:00:00'),
(18, 9, 1, 'Absolutely gorgeous', '2022-02-08 22:00:00'),
(19, 9, 5, 'The best romance with male jedi exile in the dark side', '2022-02-09 08:00:00'),
(20, 5, 5, '\"Watch those wrist rockets!\"', '2022-02-06 13:00:00'),
(21, 5, 5, '\"Lord Vader will not be pleased, fight harder!\"', '2022-02-10 12:40:00'),
(22, 9, 5, '\"My life for yours\"', '2022-02-08 14:08:00'),
(24, 6, 5, 'The last time she saws the light in him', '2022-02-01 09:59:00'),
(25, 8, 5, 'The begining of a legend', '2022-02-02 10:50:00'),
(26, 3, 1, 'The queen of music', '2022-02-09 13:17:00'),
(27, 3, 1, 'Best of c-pop and c-rap!', '2022-02-02 10:41:00'),
(28, 11, 5, 'Awesome', '2022-02-04 12:37:00'),
(29, 13, 5, 'Having a little exercise with my wife', '2022-02-07 11:45:00'),
(31, 13, 5, 'Remebering how we know each other, who will said that she will be the one', '2022-02-01 21:34:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20220119164623', '2022-01-19 17:46:45', 440),
('DoctrineMigrations\\Version20220119173757', '2022-01-19 18:38:25', 1004),
('DoctrineMigrations\\Version20220120172044', '2022-01-20 18:21:04', 1810),
('DoctrineMigrations\\Version20220120201454', '2022-01-20 21:15:08', 749),
('DoctrineMigrations\\Version20220123001034', '2022-01-23 01:10:54', 2363),
('DoctrineMigrations\\Version20220123202527', '2022-01-23 21:25:42', 3001),
('DoctrineMigrations\\Version20220124162941', '2022-01-24 17:30:09', 1728),
('DoctrineMigrations\\Version20220127195540', '2022-01-27 20:56:09', 2057),
('DoctrineMigrations\\Version20220129172901', '2022-01-29 18:29:21', 1384),
('DoctrineMigrations\\Version20220131164330', '2022-02-09 17:53:06', 903),
('DoctrineMigrations\\Version20220131174159', '2022-02-09 17:53:07', 97);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `autor_id` int(11) NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `post`
--

INSERT INTO `post` (`id`, `autor_id`, `foto`, `descripcion`, `time`) VALUES
(2, 1, 'anakin-padme-61edc0a1722c0.jpg', 'Mi primer post!', '2022-02-08 00:00:00'),
(3, 1, '1-61edc3dfdfbcd.jpg', 'G.E.M.', '2022-02-09 17:41:00'),
(5, 5, 'BattlefrontII-2020-01-11-15-01-00-701-61f6bd101184c.png', 'Una joya de juego', '2022-02-08 19:00:00'),
(6, 1, 'IMG-9771-61f6bd36d1678.jpg', 'No words need for the end of the clone wars', '2022-02-08 19:00:00'),
(7, 1, '1024-61fc24028d3f6.jpg', 'The fall of a hero for her love', '2022-02-01 07:00:00'),
(8, 1, 'vader-and-starkiller-620518308224c.png', 'The force unleashed 1 <3', '2022-02-08 15:54:00'),
(9, 1, 'vfull-6205188d48b4d.jpg', 'Visas Marr, the queen', '2022-02-08 20:00:00'),
(10, 1, 'Anakin-And-Padme-62051a048fe4d.jpg', '\"No, I promise you\"', '2022-02-07 18:59:00'),
(11, 5, 'IMG-0202-62051ab36cf1a.jpg', 'A tragic end. Kuiil teach us that a true warrior is by heart and carry the moral in blood', '2022-02-09 18:55:00'),
(12, 5, 'swtor-2019-03-10-13-58-25-847-62051af9a5838.png', 'The rise of a legend turn in mith', '2022-02-08 20:00:00'),
(13, 5, 'swkotor2-2016-10-22-04-02-42-869-62051b6b83d4b.png', 'You have to play it ;)', '2022-02-08 13:27:00'),
(15, 1, 'IMG-0002-62099810a1071.jpg', 'Lightning', '2022-02-14 00:45:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `post_user`
--

CREATE TABLE `post_user` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `post_user`
--

INSERT INTO `post_user` (`post_id`, `user_id`) VALUES
(2, 1),
(3, 1),
(3, 5),
(5, 1),
(5, 5),
(6, 1),
(6, 5),
(8, 5),
(9, 5),
(9, 6),
(11, 1),
(11, 5),
(11, 6),
(13, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `report`
--

CREATE TABLE `report` (
  `id` int(11) NOT NULL,
  `id_post_id` int(11) NOT NULL,
  `id_user_id` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revisado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `report`
--

INSERT INTO `report` (`id`, `id_post_id`, `id_user_id`, `description`, `revisado`) VALUES
(1, 5, 1, 'porque puedo :v', 1),
(2, 12, 6, 'Have you ever heard the tragedy... of Darth Plagueis the Wise??', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nombre_usuario` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_completo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_nac` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto_perfil` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `nombre_usuario`, `roles`, `password`, `nombre_completo`, `descripcion`, `fecha_nac`, `email`, `foto_perfil`) VALUES
(1, 'admin', '[\"ROLE_ADMIN\"]', '$2y$13$uPhuPzGtB1nwA2qExJydNe/xuLiFu1mO4R19.OwH6.S1EANNzpk/.', 'admin admin', 'Hello there :)', '1987-01-01', 'admin@email.com', 'yinyan.jpg'),
(5, 'user1', '[]', '$2y$13$J5TqWeAt7AbCewcY/jQm6OprhVqR2jPRDY5c4mu7xFO3zJBG2SYxK', 'user user', NULL, '1933-02-12', 'user@user', 'defaultProfile.png'),
(6, 'maria1', '[]', '$2y$13$ywI8lxp0ryDZeo1ssMKhsu57E3vRnbTJt1RkhlWS9I7TOnEyimXEe', 'maria maria', NULL, '1934-02-14', 'maria@maria.com', 'defaultProfile.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_user`
--

CREATE TABLE `user_user` (
  `user_source` int(11) NOT NULL,
  `user_target` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `user_user`
--

INSERT INTO `user_user` (`user_source`, `user_target`) VALUES
(1, 5),
(5, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9474526C4B89032C` (`post_id`),
  ADD KEY `IDX_9474526CA76ED395` (`user_id`);

--
-- Indices de la tabla `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indices de la tabla `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5A8A6C8D14D45BBE` (`autor_id`);

--
-- Indices de la tabla `post_user`
--
ALTER TABLE `post_user`
  ADD PRIMARY KEY (`post_id`,`user_id`),
  ADD KEY `IDX_44C6B1424B89032C` (`post_id`),
  ADD KEY `IDX_44C6B142A76ED395` (`user_id`);

--
-- Indices de la tabla `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C42F77849514AA5C` (`id_post_id`),
  ADD KEY `IDX_C42F778479F37AE5` (`id_user_id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649D67CF11D` (`nombre_usuario`);

--
-- Indices de la tabla `user_user`
--
ALTER TABLE `user_user`
  ADD PRIMARY KEY (`user_source`,`user_target`),
  ADD KEY `IDX_F7129A803AD8644E` (`user_source`),
  ADD KEY `IDX_F7129A80233D34C1` (`user_target`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `report`
--
ALTER TABLE `report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_9474526C4B89032C` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`),
  ADD CONSTRAINT `FK_9474526CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `FK_5A8A6C8D14D45BBE` FOREIGN KEY (`autor_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `post_user`
--
ALTER TABLE `post_user`
  ADD CONSTRAINT `FK_44C6B1424B89032C` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_44C6B142A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `report`
--
ALTER TABLE `report`
  ADD CONSTRAINT `FK_C42F778479F37AE5` FOREIGN KEY (`id_user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_C42F77849514AA5C` FOREIGN KEY (`id_post_id`) REFERENCES `post` (`id`);

--
-- Filtros para la tabla `user_user`
--
ALTER TABLE `user_user`
  ADD CONSTRAINT `FK_F7129A80233D34C1` FOREIGN KEY (`user_target`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_F7129A803AD8644E` FOREIGN KEY (`user_source`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
