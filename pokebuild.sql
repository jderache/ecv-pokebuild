-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : mer. 13 déc. 2023 à 22:04
-- Version du serveur : 5.7.39
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `pokebuild`
--

-- --------------------------------------------------------

--
-- Structure de la table `pokemons`
--

CREATE TABLE `pokemons` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `sprite` varchar(255) NOT NULL,
  `generation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `pokemons`
--

INSERT INTO `pokemons` (`id`, `name`, `image`, `sprite`, `generation`) VALUES
(1, 'Bulbizarre', './public/images/1.png', './public/images/sprites/1.png', 1),
(2, 'Herbizarre', './public/images/2.png', './public/images/sprites/2.png', 1),
(3, 'Florizarre', './public/images/3.png', './public/images/sprites/3.png', 1),
(4, 'Salamèche', './public/images/4.png', './public/images/sprites/4.png', 1),
(5, 'Reptincel', './public/images/5.png', './public/images/sprites/5.png', 1),
(6, 'Dracaufeu', './public/images/6.png', './public/images/sprites/6.png', 1),
(7, 'Carapuce', './public/images/7.png', './public/images/sprites/7.png', 1),
(8, 'Carabaffe', './public/images/8.png', './public/images/sprites/8.png', 1),
(9, 'Tortank', './public/images/9.png', './public/images/sprites/9.png', 1),
(10, 'Chenipan', './public/images/10.png', './public/images/sprites/10.png', 1),
(11, 'Chrysacier', './public/images/11.png', './public/images/sprites/11.png', 1),
(12, 'Papilusion', './public/images/12.png', './public/images/sprites/12.png', 1),
(13, 'Aspicot', './public/images/13.png', './public/images/sprites/13.png', 1),
(14, 'Coconfort', './public/images/14.png', './public/images/sprites/14.png', 1),
(15, 'Dardargnan', './public/images/15.png', './public/images/sprites/15.png', 1),
(16, 'Roucool', './public/images/16.png', './public/images/sprites/16.png', 1),
(17, 'Roucoups', './public/images/17.png', './public/images/sprites/17.png', 1),
(18, 'Roucarnage', './public/images/18.png', './public/images/sprites/18.png', 1),
(19, 'Rattata', './public/images/19.png', './public/images/sprites/19.png', 1),
(20, 'Rattatac', './public/images/20.png', './public/images/sprites/20.png', 1),
(21, 'Piafabec', './public/images/21.png', './public/images/sprites/21.png', 1),
(22, 'Rapasdepic', './public/images/22.png', './public/images/sprites/22.png', 1),
(23, 'Abo', './public/images/23.png', './public/images/sprites/23.png', 1),
(24, 'Arbok', './public/images/24.png', './public/images/sprites/24.png', 1),
(25, 'Pikachu', './public/images/25.png', './public/images/sprites/25.png', 1),
(26, 'Raichu', './public/images/26.png', './public/images/sprites/26.png', 1),
(27, 'Sabelette', './public/images/27.png', './public/images/sprites/27.png', 1),
(28, 'Sablaireau', './public/images/28.png', './public/images/sprites/28.png', 1),
(29, 'Nidoran♀', './public/images/29.png', './public/images/sprites/29.png', 1),
(30, 'Nidorina', './public/images/30.png', './public/images/sprites/30.png', 1),
(220, 'Marcacrin', './public/images/220.png', './public/images/sprites/220.png', 2),
(221, 'Cochignon', './public/images/221.png', './public/images/sprites/221.png', 2),
(235, 'Queulorior', './public/images/235.png', './public/images/sprites/235.png', 2),
(339, 'Barloche', './public/images/339.png', './public/images/sprites/339.png', 3),
(340, 'Barbicha', './public/images/340.png', './public/images/sprites/340.png', 3),
(341, 'Écrapince', './public/images/341.png', './public/images/sprites/341.png', 3),
(342, 'Colhomard', './public/images/342.png', './public/images/sprites/342.png', 3),
(473, 'Mammochon', './public/images/473.png', './public/images/sprites/473.png', 4);

-- --------------------------------------------------------

--
-- Structure de la table `pokemons_evolutions`
--

CREATE TABLE `pokemons_evolutions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `pokemonId` int(11) NOT NULL,
  `evolutionPokemonId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `pokemons_evolutions`
--

INSERT INTO `pokemons_evolutions` (`id`, `name`, `pokemonId`, `evolutionPokemonId`) VALUES
(75, 'Herbizarre', 1, 2),
(76, 'Florizarre', 2, 3),
(77, 'Reptincel', 4, 5),
(78, 'Dracaufeu', 5, 6),
(79, 'Carabaffe', 7, 8),
(80, 'Tortank', 8, 9),
(81, 'Chrysacier', 10, 11),
(82, 'Papilusion', 11, 12),
(83, 'Coconfort', 13, 14),
(84, 'Dardargnan', 14, 15),
(85, 'Roucoups', 16, 17),
(86, 'Roucarnage', 17, 18),
(87, 'Rattatac', 19, 20),
(88, 'Rapasdepic', 21, 22),
(89, 'Arbok', 23, 24),
(90, 'Raichu', 25, 26),
(91, 'Sablaireau', 27, 28),
(92, 'Nidorina', 29, 30),
(93, 'Nidoqueen', 30, 31),
(94, 'Colhomard', 341, 342),
(95, 'Barbicha', 339, 340),
(96, 'Cochignon', 220, 221),
(97, 'Mammochon', 221, 473);

-- --------------------------------------------------------

--
-- Structure de la table `pokemons_pre_evolutions`
--

CREATE TABLE `pokemons_pre_evolutions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `pokemonId` int(11) NOT NULL,
  `evolutionPokemonId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `pokemons_pre_evolutions`
--

INSERT INTO `pokemons_pre_evolutions` (`id`, `name`, `pokemonId`, `evolutionPokemonId`) VALUES
(37, 'Bulbizarre', 2, 1),
(38, 'Herbizarre', 3, 2),
(39, 'Salamèche', 5, 4),
(40, 'Reptincel', 6, 5),
(41, 'Carapuce', 8, 7),
(42, 'Carabaffe', 9, 8),
(43, 'Chenipan', 11, 10),
(44, 'Chrysacier', 12, 11),
(45, 'Aspicot', 14, 13),
(46, 'Coconfort', 15, 14),
(47, 'Roucool', 17, 16),
(48, 'Roucoups', 18, 17),
(49, 'Rattata', 20, 19),
(50, 'Abo', 24, 23),
(51, 'Pikachu', 26, 25),
(52, 'Sabelette', 28, 27),
(53, 'Nidoran♀', 30, 29),
(54, 'Piafabec', 22, 21),
(55, 'Écrapince', 342, 341),
(56, 'Barloche', 340, 339),
(57, 'Marcacrin', 221, 220),
(58, 'Cochignon', 473, 221);

-- --------------------------------------------------------

--
-- Structure de la table `pokemons_types`
--

CREATE TABLE `pokemons_types` (
  `id` int(11) NOT NULL,
  `pokemonId` int(11) NOT NULL,
  `typeId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `pokemons_types`
--

INSERT INTO `pokemons_types` (`id`, `pokemonId`, `typeId`) VALUES
(150, 1, 37),
(151, 1, 38),
(152, 2, 37),
(153, 2, 38),
(154, 3, 37),
(155, 3, 38),
(156, 4, 39),
(157, 5, 39),
(158, 6, 40),
(159, 6, 39),
(160, 7, 41),
(161, 8, 41),
(162, 9, 41),
(163, 10, 42),
(164, 11, 42),
(165, 12, 40),
(166, 12, 42),
(167, 13, 37),
(168, 13, 42),
(169, 14, 37),
(170, 14, 42),
(171, 15, 37),
(172, 15, 42),
(173, 16, 43),
(174, 16, 40),
(175, 17, 43),
(176, 17, 40),
(177, 18, 43),
(178, 18, 40),
(179, 19, 43),
(180, 20, 43),
(181, 21, 43),
(182, 21, 40),
(183, 23, 37),
(184, 24, 37),
(185, 25, 44),
(186, 26, 44),
(187, 27, 45),
(188, 28, 45),
(189, 29, 37),
(190, 30, 37),
(191, 22, 43),
(192, 22, 40),
(193, 235, 43),
(194, 341, 41),
(195, 342, 41),
(196, 342, 46),
(197, 340, 45),
(198, 340, 41),
(199, 339, 45),
(200, 339, 41),
(201, 220, 45),
(202, 220, 47),
(203, 221, 45),
(204, 221, 47),
(205, 473, 45),
(206, 473, 47);

-- --------------------------------------------------------

--
-- Structure de la table `types`
--

CREATE TABLE `types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `types`
--

INSERT INTO `types` (`id`, `name`, `image`) VALUES
(37, 'Poison', './public/images/types/Poison.png'),
(38, 'Plante', './public/images/types/Plante.png'),
(39, 'Feu', './public/images/types/Feu.png'),
(40, 'Vol', './public/images/types/Vol.png'),
(41, 'Eau', './public/images/types/Eau.png'),
(42, 'Insecte', './public/images/types/Insecte.png'),
(43, 'Normal', './public/images/types/Normal.png'),
(44, 'Électrik', './public/images/types/Électrik.png'),
(45, 'Sol', './public/images/types/Sol.png'),
(46, 'Ténèbres', './public/images/types/Ténèbres.png'),
(47, 'Glace', './public/images/types/Glace.png');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `pokemons`
--
ALTER TABLE `pokemons`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pokemons_evolutions`
--
ALTER TABLE `pokemons_evolutions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pokemons_pre_evolutions`
--
ALTER TABLE `pokemons_pre_evolutions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pokemons_types`
--
ALTER TABLE `pokemons_types`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `pokemons`
--
ALTER TABLE `pokemons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=474;

--
-- AUTO_INCREMENT pour la table `pokemons_evolutions`
--
ALTER TABLE `pokemons_evolutions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT pour la table `pokemons_pre_evolutions`
--
ALTER TABLE `pokemons_pre_evolutions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT pour la table `pokemons_types`
--
ALTER TABLE `pokemons_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=207;

--
-- AUTO_INCREMENT pour la table `types`
--
ALTER TABLE `types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
