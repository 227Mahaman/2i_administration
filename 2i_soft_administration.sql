-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  mar. 27 oct. 2020 à 08:48
-- Version du serveur :  10.3.15-MariaDB
-- Version de PHP :  7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `2i_soft_administration`
--

-- --------------------------------------------------------

--
-- Structure de la table `action`
--

CREATE TABLE `action` (
  `id_action` int(11) NOT NULL,
  `id_groupe` int(11) NOT NULL,
  `libelle_action` varchar(45) DEFAULT NULL,
  `description_action` varchar(100) DEFAULT NULL,
  `url_action` varchar(100) DEFAULT NULL,
  `ordre_affichage_action` varchar(45) DEFAULT NULL,
  `statut` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `action`
--

INSERT INTO `action` (`id_action`, `id_groupe`, `libelle_action`, `description_action`, `url_action`, `ordre_affichage_action`, `statut`) VALUES
(1, 1, 'Profil', 'Gestion des profils', 'profil', '1', 1),
(2, 1, 'Module', 'Gestion des modules', 'module', '2', 1),
(3, 1, 'Menu', 'Gestion des menu', 'menu', '3', 1),
(5, 2, 'test', 'testing', 'test', '2', 1),
(6, 1, 'Ajout Utilisateur', 'Ajouter les utilisateurs', 'addUser', '4', 1),
(7, 1, 'Liste Utilisateur', 'Listing des Utilisateurs', 'lstUser', '5', 1),
(8, 1, 'meni', 'menu', 'menu', 'menu', 1);

-- --------------------------------------------------------

--
-- Structure de la table `groupe_action`
--

CREATE TABLE `groupe_action` (
  `id_groupe` int(11) NOT NULL,
  `libelle_groupe` varchar(45) DEFAULT NULL,
  `icon_groupe` varchar(255) NOT NULL,
  `bloc_menu` varchar(45) DEFAULT NULL COMMENT 'config ou simple',
  `ordre_affichage_groupe` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `groupe_action`
--

INSERT INTO `groupe_action` (`id_groupe`, `libelle_groupe`, `icon_groupe`, `bloc_menu`, `ordre_affichage_groupe`) VALUES
(1, 'Administration', 'lnr lnr-flag', 'administration', NULL),
(2, 'Configuration', 'fa fa-settings', 'configuration', '2'),
(3, 'Testeur', 'fa fa-example', 'testeur', '');

-- --------------------------------------------------------

--
-- Structure de la table `profil`
--

CREATE TABLE `profil` (
  `id_profil` int(11) NOT NULL,
  `libelle_profil` varchar(45) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `modified_by` int(11) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `profil`
--

INSERT INTO `profil` (`id_profil`, `libelle_profil`, `created_by`, `created_at`, `modified_by`, `modified_at`) VALUES
(1, 'Administrateur', NULL, '2020-10-22 23:00:00', NULL, NULL),
(3, 'Utilisateur', 1, '2020-10-23 22:01:29', NULL, NULL),
(5, 'Visiteur', 1, '2020-10-25 20:40:55', 1, '2020-10-26 08:41:19'),
(7, 'Instructeur', 1, '2020-10-26 07:45:49', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `profil_has_action`
--

CREATE TABLE `profil_has_action` (
  `id_profil` int(11) NOT NULL,
  `id_action` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `profil_has_action`
--

INSERT INTO `profil_has_action` (`id_profil`, `id_action`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 5),
(1, 6),
(1, 7),
(5, 8);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `id_profil` int(11) NOT NULL,
  `nom_user` varchar(45) DEFAULT NULL,
  `prenom_user` varchar(45) DEFAULT NULL,
  `login` varchar(45) DEFAULT NULL,
  `password` text DEFAULT NULL,
  `statut_activation` int(11) DEFAULT 1,
  `statut_connexion` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `modified_by` int(11) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `id_profil`, `nom_user`, `prenom_user`, `login`, `password`, `statut_activation`, `statut_connexion`, `created_by`, `created_at`, `modified_by`, `modified_at`) VALUES
(1, 1, 'Mahaman Tahirou', 'Zalkilphily Abass', '227Mahaman', '85ef73ae77b91f440d8ec0579a9221d0', 1, NULL, NULL, '2020-10-22 23:00:00', NULL, NULL),
(2, 3, 'Taheer', 'Mouhammad', 'Taheer', 'e8ef56655a67a9543f37e38465d09583', 1, NULL, NULL, '2020-10-23 22:02:09', NULL, '2020-10-26 14:56:39'),
(3, 3, '2isoft', '2isoft', '2isoft', '541b4bfa1f19916592b7c9747f3ec226', 1, NULL, 1, '2020-10-26 13:02:10', NULL, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `action`
--
ALTER TABLE `action`
  ADD PRIMARY KEY (`id_action`),
  ADD KEY `fk_action_groupe_action_idx` (`id_groupe`);

--
-- Index pour la table `groupe_action`
--
ALTER TABLE `groupe_action`
  ADD PRIMARY KEY (`id_groupe`);

--
-- Index pour la table `profil`
--
ALTER TABLE `profil`
  ADD PRIMARY KEY (`id_profil`);

--
-- Index pour la table `profil_has_action`
--
ALTER TABLE `profil_has_action`
  ADD KEY `fk_profil_has_action_action1_idx` (`id_action`),
  ADD KEY `fk_profil_has_action_profil1_idx` (`id_profil`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `loginl_UNIQUE` (`login`),
  ADD KEY `fk_user_profil1_idx` (`id_profil`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `action`
--
ALTER TABLE `action`
  MODIFY `id_action` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `groupe_action`
--
ALTER TABLE `groupe_action`
  MODIFY `id_groupe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `profil`
--
ALTER TABLE `profil`
  MODIFY `id_profil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_profil`) REFERENCES `profil` (`id_profil`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
