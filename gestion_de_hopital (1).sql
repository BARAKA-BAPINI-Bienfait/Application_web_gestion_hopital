-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 02 juin 2026 à 11:04
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
-- Doublure de structure pour la vue `affichage_consultation`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `affichage_consultation` (
`id_consultation` int(40)
,`date_consultation` date
,`diagnostique` varchar(100)
,`prescription` varchar(100)
,`motif` varchar(100)
,`id_patients` int(40)
,`id_services` int(40)
,`id_personnels` int(40)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `affichage_consultation_nom`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `affichage_consultation_nom` (
`id_consultation` int(40)
,`date_consultation` date
,`diagnostique` varchar(100)
,`prescription` varchar(100)
,`motif` varchar(100)
,`nom_patients` varchar(30)
,`nom_service` varchar(30)
,`nom_personnels` varchar(30)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `affichage_de_consultation_pour_la_quelle_pas_dhospitalisation`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `affichage_de_consultation_pour_la_quelle_pas_dhospitalisation` (
`id_consultation` int(40)
,`date_consultation` date
,`nom_patients` varchar(30)
,`diagnostique` varchar(100)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `affichage_hospitalisation`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `affichage_hospitalisation` (
`id_hospitalisation` int(40)
,`date_entree` date
,`date_sortie` date
,`nom_patients` varchar(30)
,`id_consultation` int(40)
,`nom_service` varchar(30)
,`nom_personnels` varchar(30)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `affichage_patient_consultee`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `affichage_patient_consultee` (
`id_patients` int(40)
,`nom_patients` varchar(30)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `affichage_payement`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `affichage_payement` (
`id_payement` int(40)
,`date_payement` date
,`montant` double(12,2)
,`mode_payement` varchar(40)
,`statut` varchar(40)
,`nom_patients` varchar(30)
,`service_consultation` varchar(30)
,`service_hospitalisation` varchar(30)
,`id_consultation` int(40)
,`date_consultation` date
,`prescription` varchar(100)
,`id_hospitalisation` int(40)
,`date_entree` date
,`date_sortie` date
);

-- --------------------------------------------------------

--
-- Structure de la table `consultation`
--

CREATE TABLE `consultation` (
  `id_consultation` int(40) NOT NULL,
  `date_consultation` date DEFAULT NULL,
  `diagnostique` varchar(100) DEFAULT NULL,
  `prescription` varchar(100) DEFAULT NULL,
  `motif` varchar(100) DEFAULT NULL,
  `id_patients` int(40) NOT NULL,
  `id_services` int(40) NOT NULL,
  `id_personnels` int(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `consultation`
--

INSERT INTO `consultation` (`id_consultation`, `date_consultation`, `diagnostique`, `prescription`, `motif`, `id_patients`, `id_services`, `id_personnels`) VALUES
(5, '2026-03-22', 'sida', 'parastamol', 'mal au dos ', 3, 2, 7),
(6, '2026-03-20', 'maleria', 'parastamol 4es', 'mal a la tete', 5, 2, 7),
(100, '2026-03-27', 'maleria', 'parastamol 4es', 'mal a la tete', 2, 2, 7);

-- --------------------------------------------------------

--
-- Structure de la table `hospitalisation`
--

CREATE TABLE `hospitalisation` (
  `id_hospitalisation` int(40) NOT NULL,
  `date_entree` date DEFAULT NULL,
  `date_sortie` date DEFAULT NULL,
  `id_patients` int(40) NOT NULL,
  `id_consultation` int(40) NOT NULL,
  `id_services` int(40) NOT NULL,
  `id_personnels` int(40) NOT NULL
) ;

--
-- Déchargement des données de la table `hospitalisation`
--

INSERT INTO `hospitalisation` (`id_hospitalisation`, `date_entree`, `date_sortie`, `id_patients`, `id_consultation`, `id_services`, `id_personnels`) VALUES
(2, '2026-03-14', '2026-03-28', 2, 100, 1, 3),
(8, '2026-03-07', '2026-03-21', 3, 5, 3, 1),
(12, '2026-03-06', '2026-03-28', 5, 6, 3, 1);

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
(1, 'PACIFIC', '2003-11-20', 'M', 'HOHO', '0821135167', 'A'),
(2, 'PACIFIC FAIDA', '2006-11-01', 'M', 'HOHO', '0821135112', 'AB'),
(3, 'ZAWADI DILE', '2007-02-02', 'M', 'KINDIA', '0832465674', 'O'),
(5, 'ALESI ANDROA', '2001-02-04', 'F', 'AIROPORT', '0821134167', 'AB'),
(6, 'HWELOSI LUSI', '2006-03-01', 'F', 'AIROPORT', '0821134465', 'B'),
(9, 'NDJANGO KOMBU', '2005-12-01', 'M', 'ISP', '0991929345', 'A'),
(10, 'IRAGI TCHOMBE', '1999-03-01', 'F', 'KAZUNGA', '0821137461', 'B'),
(11, 'JOEL FABRICE', '2020-01-01', 'M', 'KAZUNGA', '0821324356', 'B');

-- --------------------------------------------------------

--
-- Structure de la table `payement`
--

CREATE TABLE `payement` (
  `id_payement` int(40) NOT NULL,
  `date_payement` date DEFAULT NULL,
  `montant` double(12,2) DEFAULT NULL,
  `mode_payement` varchar(40) DEFAULT NULL,
  `statut` varchar(40) DEFAULT NULL,
  `id_consultation` int(40) NOT NULL,
  `id_hospitalisation` int(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `payement`
--

INSERT INTO `payement` (`id_payement`, `date_payement`, `montant`, `mode_payement`, `statut`, `id_consultation`, `id_hospitalisation`) VALUES
(1, '2026-03-28', 1000.00, 'cach', 'tout payer', 100, 2);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `payement_consultation`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `payement_consultation` (
`id_consultation` int(40)
,`nom_patients` varchar(30)
,`date_consultation` date
,`prescription` varchar(100)
,`nom_service` varchar(30)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `payement_hospitalisation`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `payement_hospitalisation` (
`id_hospitalisation` int(40)
,`nom_patients` varchar(30)
,`date_entree` date
,`nom_service` varchar(30)
);

-- --------------------------------------------------------

--
-- Structure de la table `personnels`
--

CREATE TABLE `personnels` (
  `id_personnels` int(40) NOT NULL,
  `nom_personnels` varchar(30) DEFAULT NULL,
  `role` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `personnels`
--

INSERT INTO `personnels` (`id_personnels`, `nom_personnels`, `role`) VALUES
(1, 'PALUKU', 'medecin'),
(3, 'JOEL', 'infirmier'),
(7, 'BAPINI', 'recepteur');

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
-- Déchargement des données de la table `services`
--

INSERT INTO `services` (`id_services`, `nom_service`, `description`) VALUES
(1, 'mecine interne', 'tout soins'),
(2, 'cabinet consultation', 'consul.'),
(3, 'chirugie', 'operation'),
(4, 'pediatrie', 'soin enfant');

-- --------------------------------------------------------

--
-- Structure de la vue `affichage_consultation`
--
DROP TABLE IF EXISTS `affichage_consultation`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `affichage_consultation`  AS   (select `consultation`.`id_consultation` AS `id_consultation`,`consultation`.`date_consultation` AS `date_consultation`,`consultation`.`diagnostique` AS `diagnostique`,`consultation`.`prescription` AS `prescription`,`consultation`.`motif` AS `motif`,`patients`.`id_patients` AS `id_patients`,`services`.`id_services` AS `id_services`,`personnels`.`id_personnels` AS `id_personnels` from (((`consultation` join `patients` on(`consultation`.`id_patients` = `patients`.`id_patients`)) join `services` on(`consultation`.`id_services` = `services`.`id_services`)) join `personnels` on(`consultation`.`id_personnels` = `personnels`.`id_personnels`)) order by `consultation`.`id_consultation` desc)  ;

-- --------------------------------------------------------

--
-- Structure de la vue `affichage_consultation_nom`
--
DROP TABLE IF EXISTS `affichage_consultation_nom`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `affichage_consultation_nom`  AS   (select `consultation`.`id_consultation` AS `id_consultation`,`consultation`.`date_consultation` AS `date_consultation`,`consultation`.`diagnostique` AS `diagnostique`,`consultation`.`prescription` AS `prescription`,`consultation`.`motif` AS `motif`,`patients`.`nom_patients` AS `nom_patients`,`services`.`nom_service` AS `nom_service`,`personnels`.`nom_personnels` AS `nom_personnels` from (((`consultation` join `patients` on(`consultation`.`id_patients` = `patients`.`id_patients`)) join `services` on(`consultation`.`id_services` = `services`.`id_services`)) join `personnels` on(`consultation`.`id_personnels` = `personnels`.`id_personnels`)))  ;

-- --------------------------------------------------------

--
-- Structure de la vue `affichage_de_consultation_pour_la_quelle_pas_dhospitalisation`
--
DROP TABLE IF EXISTS `affichage_de_consultation_pour_la_quelle_pas_dhospitalisation`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `affichage_de_consultation_pour_la_quelle_pas_dhospitalisation`  AS   (select `consultation`.`id_consultation` AS `id_consultation`,`consultation`.`date_consultation` AS `date_consultation`,`patients`.`nom_patients` AS `nom_patients`,`consultation`.`diagnostique` AS `diagnostique` from (`consultation` join `patients` on(`consultation`.`id_patients` = `patients`.`id_patients`)) where !exists(select 1 from `hospitalisation` where `hospitalisation`.`id_consultation` = `consultation`.`id_consultation` limit 1))  ;

-- --------------------------------------------------------

--
-- Structure de la vue `affichage_hospitalisation`
--
DROP TABLE IF EXISTS `affichage_hospitalisation`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `affichage_hospitalisation`  AS   (select `hospitalisation`.`id_hospitalisation` AS `id_hospitalisation`,`hospitalisation`.`date_entree` AS `date_entree`,`hospitalisation`.`date_sortie` AS `date_sortie`,`patients`.`nom_patients` AS `nom_patients`,`consultation`.`id_consultation` AS `id_consultation`,`services`.`nom_service` AS `nom_service`,`personnels`.`nom_personnels` AS `nom_personnels` from ((((`hospitalisation` join `patients` on(`hospitalisation`.`id_patients` = `patients`.`id_patients`)) join `consultation` on(`hospitalisation`.`id_consultation` = `consultation`.`id_consultation`)) join `services` on(`hospitalisation`.`id_services` = `services`.`id_services`)) join `personnels` on(`hospitalisation`.`id_personnels` = `personnels`.`id_personnels`)))  ;

-- --------------------------------------------------------

--
-- Structure de la vue `affichage_patient_consultee`
--
DROP TABLE IF EXISTS `affichage_patient_consultee`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `affichage_patient_consultee`  AS   (select `patients`.`id_patients` AS `id_patients`,`patients`.`nom_patients` AS `nom_patients` from (`patients` join `consultation` on(`patients`.`id_patients` = `consultation`.`id_patients`)))  ;

-- --------------------------------------------------------

--
-- Structure de la vue `affichage_payement`
--
DROP TABLE IF EXISTS `affichage_payement`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `affichage_payement`  AS   (select `payement`.`id_payement` AS `id_payement`,`payement`.`date_payement` AS `date_payement`,`payement`.`montant` AS `montant`,`payement`.`mode_payement` AS `mode_payement`,`payement`.`statut` AS `statut`,`patients`.`nom_patients` AS `nom_patients`,`s1`.`nom_service` AS `service_consultation`,`s2`.`nom_service` AS `service_hospitalisation`,`consultation`.`id_consultation` AS `id_consultation`,`consultation`.`date_consultation` AS `date_consultation`,`consultation`.`prescription` AS `prescription`,`hospitalisation`.`id_hospitalisation` AS `id_hospitalisation`,`hospitalisation`.`date_entree` AS `date_entree`,`hospitalisation`.`date_sortie` AS `date_sortie` from (((((`payement` join `consultation` on(`payement`.`id_consultation` = `consultation`.`id_consultation`)) join `patients` on(`consultation`.`id_patients` = `patients`.`id_patients`)) join `services` `s1` on(`consultation`.`id_services` = `s1`.`id_services`)) join `hospitalisation` on(`payement`.`id_hospitalisation` = `hospitalisation`.`id_hospitalisation`)) join `services` `s2` on(`hospitalisation`.`id_services` = `s2`.`id_services`)))  ;

-- --------------------------------------------------------

--
-- Structure de la vue `payement_consultation`
--
DROP TABLE IF EXISTS `payement_consultation`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `payement_consultation`  AS   (select `consultation`.`id_consultation` AS `id_consultation`,`patients`.`nom_patients` AS `nom_patients`,`consultation`.`date_consultation` AS `date_consultation`,`consultation`.`prescription` AS `prescription`,`services`.`nom_service` AS `nom_service` from ((`consultation` join `patients` on(`consultation`.`id_patients` = `patients`.`id_patients`)) join `services` on(`consultation`.`id_services` = `services`.`id_services`)))  ;

-- --------------------------------------------------------

--
-- Structure de la vue `payement_hospitalisation`
--
DROP TABLE IF EXISTS `payement_hospitalisation`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `payement_hospitalisation`  AS   (select `hospitalisation`.`id_hospitalisation` AS `id_hospitalisation`,`patients`.`nom_patients` AS `nom_patients`,`hospitalisation`.`date_entree` AS `date_entree`,`services`.`nom_service` AS `nom_service` from ((`hospitalisation` join `patients` on(`hospitalisation`.`id_patients` = `patients`.`id_patients`)) join `services` on(`hospitalisation`.`id_services` = `services`.`id_services`)))  ;

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
