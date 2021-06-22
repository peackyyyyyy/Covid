-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 03 juin 2021 à 10:32
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `cov19`
--

-- --------------------------------------------------------

--
-- Structure de la table `favori`
--

DROP TABLE IF EXISTS `favori`;
CREATE TABLE IF NOT EXISTS `favori` (
  `numero` int(11) NOT NULL AUTO_INCREMENT,
  `url_fav` longtext NOT NULL,
  `date_ajout` varchar(50) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  PRIMARY KEY (`numero`),
  KEY `favori_utilisateur_FK` (`id_utilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `filtre`
--

DROP TABLE IF EXISTS `filtre`;
CREATE TABLE IF NOT EXISTS `filtre` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `souscrit`
--

DROP TABLE IF EXISTS `souscrit`;
CREATE TABLE IF NOT EXISTS `souscrit` (
  `Id` int(11) NOT NULL,
  `Numero` int(11) NOT NULL,
  PRIMARY KEY (`Id`,`Numero`),
  KEY `souscrit_Utilisateur0_FK` (`Numero`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(50) NOT NULL,
  `Prenom` varchar(50) NOT NULL,
  `Mail` varchar(50) NOT NULL,
  `Adresse_postale` varchar(50) NOT NULL,
  `Mdp` varchar(50) NOT NULL,
  `Adm` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `Nom`, `Prenom`, `Mail`, `Adresse_postale`, `Mdp`, `Adm`) VALUES
(1, 'MARION', 'ThÃ©o', 'theomarion08@gmail.com', '6 rue des bigo', '7682fe272099ea26efe39c890b33675b', 1);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `favori`
--
ALTER TABLE `favori`
  ADD CONSTRAINT `favori_utilisateur_FK` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`);

--
-- Contraintes pour la table `souscrit`
--
ALTER TABLE `souscrit`
  ADD CONSTRAINT `souscrit_Filtre_FK` FOREIGN KEY (`Id`) REFERENCES `filtre` (`Id`),
  ADD CONSTRAINT `souscrit_Utilisateur0_FK` FOREIGN KEY (`Numero`) REFERENCES `utilisateur` (`id_utilisateur`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
