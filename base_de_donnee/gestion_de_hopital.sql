-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 28 fév. 2026 à 10:14
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_de_hopital`
--

-- --------------------------------------------------------

--
-- Structure de la table `consultation`
--

CREATE TABLE `consultation` (
  `id_consultation` int(40) NOT NULL,
  `date_consultation` datetime DEFAULT NULL,
  `diagnostique` varchar(100) DEFAULT NULL,
  `prescription` varchar(100) DEFAULT NULL,
  `motif` varchar(100) DEFAULT NULL,
  `id_patients` int(40) NOT NULL,
  `id_services` int(40) NOT NULL,
  `id_personnels` int(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `hospitalisation`
--

CREATE TABLE `hospitalisation` (
  `id_hospitalisation` int(40) NOT NULL,
  `date_entree` datetime DEFAULT NULL,
  `date_sortie` datetime DEFAULT NULL,
  `id_patients` int(40) NOT NULL,
  `id_consultation` int(40) NOT NULL,
  `id_services` int(40) NOT NULL,
  `id_personnels` int(40) NOT NULL
) ;

-- --------------------------------------------------------

--
-- Structure de la table `patients`
--

CREATE TABLE `patients` (
  `id_patients` int(40) NOT NULL,
  `nom_patients` varchar(30) DEFAULT NULL,
  `date_de_naissance` date DEFAULT NULL,
  `sexe` varchar(10) DEFAULT NULL,
  `adresse` varchar(30) DEFAULT NULL,
  `telephone` varchar(10) DEFAULT NULL,
  `groupe_sanguin` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `patients`
--

INSERT INTO `patients` (`id_patients`, `nom_patients`, `date_de_naissance`, `sexe`, `adresse`, `telephone`, `groupe_sanguin`) VALUES
(1, 'PALUKU MUHYANA', '2026-02-10', 'M', 'HOHO', '0813456738', 'AB'),
(2, 'BARAKA BAPINI BIENFAIT', '2026-02-07', 'M', 'HOHO', '0813456738', 'AB'),
(3, 'MAKI PANZA', '2026-02-12', 'M', 'BAKOKO', '0843564758', 'A'),
(4, 'FAIDA MWESIGE', '2026-02-11', 'M', 'KINDIA', '0821135167', 'A'),
(7, 'PACIFIC', '2026-02-13', 'm', 'HOHO', '0813456738', 'AB');

-- --------------------------------------------------------

--
-- Structure de la table `payement`
--

CREATE TABLE `payement` (
  `id_payement` int(40) NOT NULL,
  `date_payement` datetime DEFAULT NULL,
  `montant` double(12,2) DEFAULT NULL,
  `mode_payement` varchar(40) DEFAULT NULL,
  `statut` varchar(40) DEFAULT NULL,
  `id_consultation` int(40) NOT NULL,
  `id_hospitalisation` int(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `personnels`
--

CREATE TABLE `personnels` (
  `id_personnels` int(40) NOT NULL,
  `nom_personnels` varchar(30) DEFAULT NULL,
  `role` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `services`
--

CREATE TABLE `services` (
  `id_services` int(40) NOT NULL,
  `nom_service` varchar(30) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `consultation`
--
ALTER TABLE `consultation`
  ADD PRIMARY KEY (`id_consultation`),
  ADD KEY `id_patients` (`id_patients`),
  ADD KEY `id_services` (`id_services`),
  ADD KEY `id_personnels` (`id_personnels`);

--
-- Index pour la table `hospitalisation`
--
ALTER TABLE `hospitalisation`
  ADD PRIMARY KEY (`id_hospitalisation`),
  ADD KEY `id_patients` (`id_patients`),
  ADD KEY `id_consultation` (`id_consultation`),
  ADD KEY `id_services` (`id_services`),
  ADD KEY `id_personnels` (`id_personnels`);

--
-- Index pour la table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id_patients`);

--
-- Index pour la table `payement`
--
ALTER TABLE `payement`
  ADD PRIMARY KEY (`id_payement`),
  ADD KEY `id_consultation` (`id_consultation`),
  ADD KEY `id_hospitalisation` (`id_hospitalisation`);

--
-- Index pour la table `personnels`
--
ALTER TABLE `personnels`
  ADD PRIMARY KEY (`id_personnels`);

--
-- Index pour la table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id_services`);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `consultation`
--
ALTER TABLE `consultation`
  ADD CONSTRAINT `consultation_ibfk_1` FOREIGN KEY (`id_patients`) REFERENCES `patients` (`id_patients`),
  ADD CONSTRAINT `consultation_ibfk_2` FOREIGN KEY (`id_services`) REFERENCES `services` (`id_services`),
  ADD CONSTRAINT `consultation_ibfk_3` FOREIGN KEY (`id_personnels`) REFERENCES `personnels` (`id_personnels`);

--
-- Contraintes pour la table `hospitalisation`
--
ALTER TABLE `hospitalisation`
  ADD CONSTRAINT `hospitalisation_ibfk_1` FOREIGN KEY (`id_patients`) REFERENCES `patients` (`id_patients`),
  ADD CONSTRAINT `hospitalisation_ibfk_2` FOREIGN KEY (`id_consultation`) REFERENCES `consultation` (`id_consultation`),
  ADD CONSTRAINT `hospitalisation_ibfk_3` FOREIGN KEY (`id_services`) REFERENCES `services` (`id_services`),
  ADD CONSTRAINT `hospitalisation_ibfk_4` FOREIGN KEY (`id_personnels`) REFERENCES `personnels` (`id_personnels`);

--
-- Contraintes pour la table `payement`
--
ALTER TABLE `payement`
  ADD CONSTRAINT `payement_ibfk_1` FOREIGN KEY (`id_consultation`) REFERENCES `consultation` (`id_consultation`),
  ADD CONSTRAINT `payement_ibfk_2` FOREIGN KEY (`id_hospitalisation`) REFERENCES `hospitalisation` (`id_hospitalisation`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
