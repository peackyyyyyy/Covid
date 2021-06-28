-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : Dim 27 juin 2021 à 14:18
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
-- Structure de la table `carousel`
--

DROP TABLE IF EXISTS `carousel`;
CREATE TABLE IF NOT EXISTS `carousel` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `name` text NOT NULL,
  `image` text NOT NULL,
  `url` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `carousel`
--

INSERT INTO `carousel` (`id`, `description`, `name`, `image`, `url`) VALUES
(0, 'Dans son point epidemiologique hebdomadaire, Sante publique France juge « essentiel » de continuer à appliquer les gestes barrière, de se conformer aux regles de dépistage et de « traçage », et de se faire vacciner.', 'Covid-19 : clusters, zones de diffusion...', 'https://www.leparisien.fr/resizer/rs2sKsxB97rB2vrRjAYL4mX4Jvc=/932x582/cloudfront-eu-central-1.images.arcpublishing.com/leparisien/P6PLV7T7XBES5P35DACUAIH6RY.jpg', 'https://www.leparisien.fr/societe/sante/covid-19-clusters-zones-de-diffusion-soutenue-le-variant-delta-se-propage-en-france-25-06-2021-CQ76VTWKDFGB5IUNTVGTVSSHAQ.php'),
(1, 'Un voyage d’étudiants espagnols dans l’archipel des Baléares est à l’origine d’un foyer infectieux de plusieurs centaines de cas et le placement de milliers de jeunes en quarantaine dans le pays.', 'Israël rétablit l’obligation de porter le masque en intérieur', 'https://img.lemde.fr/2021/06/24/0/0/6865/4577/664/0/75/0/82483ce_e7543dee050d4961a2d27ba452d31df8-e7543dee050d4961a2d27ba452d31df8-0.jpg', 'https://www.lemonde.fr/international/article/2021/06/25/covid-19-israel-retablit-l-obligation-du-port-du-masque-dans-les-lieux-publics-fermes_6085633_3210.html'),
(3, 'Plus de 800 rendez-vous ont été réservés pour ces deux jours de cette campagne de vaccination éclair au cœur du site de l\'Université de Cergy-Pontoise (95).', 'Pour partir en vacances, voir leur famille et amis, ils se font vacciner au sein de leur université', 'https://i.f1g.fr/media/cms/616x347_cropupscale/2021/06/22/ac2858d6e2d48808a4cd85dbc2c5726dc696739fcd7b9632b0d390cff137245b.jpg', 'https://www.lefigaro.fr/actualite-france/covid-19-pour-partir-en-vacances-voir-leur-famille-et-amis-ils-se-font-vacciner-au-sein-de-leur-universite-20210623');

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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `favori`
--

INSERT INTO `favori` (`numero`, `url_fav`, `date_ajout`, `id_utilisateur`) VALUES
(7, 'https://www.huffingtonpost.fr/entry/coronavirus-le-plexiglas-lui-aussi-en-rupture-de-stock_fr_5ecb59dbc5b66ddcaf0f02ea', '2021-06-08 22:57:59', 1),
(8, 'https://www.capital.fr/economie-politique/le-coup-de-pouce-supplementaire-de-letat-aux-secteurs-les-plus-durement-touches-par-la-crise-1370806', '2021-06-08 22:58:00', 1),
(9, 'https://www.auto-infos.fr/Le-plan-de-relance-automobile,13964', '2021-06-08 22:58:01', 1),
(10, 'https://www.franceculture.fr/emissions/radiographies-du-coronavirus-la-chronique/radiographies-du-coronavirus-chronique-de-n-martin-du-mercredi-10-juin-2020', '2021-06-08 22:58:03', 1),
(11, 'https://www.capital.fr/economie-politique/le-coup-de-pouce-supplementaire-de-letat-aux-secteurs-les-plus-durement-touches-par-la-crise-1370806', '2021-06-27 00:26:25', 1),
(12, 'https://www.auto-infos.fr/Le-plan-de-relance-automobile,13964', '2021-06-27 00:26:28', 1),
(13, 'https://www.huffingtonpost.fr/entry/coronavirus-le-plexiglas-lui-aussi-en-rupture-de-stock_fr_5ecb59dbc5b66ddcaf0f02ea', '2021-06-27 00:26:30', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `Nom`, `Prenom`, `Mail`, `Adresse_postale`, `Mdp`, `Adm`) VALUES
(1, 'MAR', 'ThÃ©o', 'theo@gmail.com', '6 rue des bigos', '7682fe272099ea26efe39c890b33675b', 1),
(2, 'MALAMAIRE', 'Hugo', 'hugo@gmail.com', '10 rue du docteur', 'azdad', 1);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `favori`
--
ALTER TABLE `favori`
  ADD CONSTRAINT `favori_utilisateur_FK` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
