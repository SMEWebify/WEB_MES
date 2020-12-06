-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Dim 06 Mars 2016 à 21:19
-- Version du serveur :  5.7.9
-- Version de PHP :  5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `metal_industrie`
--

-- --------------------------------------------------------

--
-- Structure de la table `espace_membre`
--

DROP TABLE IF EXISTS `espace_membre`;
CREATE TABLE IF NOT EXISTS `espace_membre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `statu` int(11) NOT NULL,
  `connexion` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `fonction` int(1) NOT NULL,
  `page_1` int(1) NOT NULL,
  `page_2` int(1) NOT NULL,
  `page_3` int(1) NOT NULL,
  `page_4` int(1) NOT NULL,
  `page_5` int(1) NOT NULL,
  `page_6` int(1) NOT NULL,
  `page_7` int(1) NOT NULL,
  `page_8` int(1) NOT NULL,
  `page_9` int(1) NOT NULL,
  `page_10` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `espace_membre`
--

INSERT INTO `espace_membre` (`id`, `statu`, `connexion`, `nom`, `mdp`, `fonction`, `page_1`, `page_2`, `page_3`, `page_4`, `page_5`, `page_6`, `page_7`, `page_8`, `page_9`, `page_10`) VALUES
(2, 1, 1457299128, 'KN', 'KN1', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(6, 1, 1457294787, 'VG', 'VG2', 2, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(7, 1, 1457295323, 'JP', 'JP3', 3, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0),
(8, 1, 1457295374, 'FH', 'FH4', 4, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0),
(9, 1, 1457295454, 'NJ', 'NJ5', 6, 1, 1, 1, 0, 1, 1, 1, 0, 1, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
