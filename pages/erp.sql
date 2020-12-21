-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : Dim 06 déc. 2020 à 22:45
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
-- Base de données : `erp`
--

-- --------------------------------------------------------

--
-- Structure de la table `activity_sector`
--

DROP TABLE IF EXISTS `activity_sector`;
CREATE TABLE IF NOT EXISTS `activity_sector` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `activity_sector`
--

INSERT INTO `activity_sector` (`id`, `CODE`, `LABEL`) VALUES
(1, 'AERO', 'AERONAUTIQUE'),
(7, 'MEDIC', 'MEDICALE'),
(6, 'BAT', 'BATIMENT'),
(5, 'AUTO', 'AUTOMOBILE'),
(8, 'AGRI', 'AGRICOLE'),
(9, 'PARTI', 'PARTICULIER');

-- --------------------------------------------------------

--
-- Structure de la table `adresses`
--

DROP TABLE IF EXISTS `adresses`;
CREATE TABLE IF NOT EXISTS `adresses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ID_COMPANY` int(11) NOT NULL,
  `ORDRE` int(11) NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ADRESSE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ZIPCODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `CITY` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `COUNTRY` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `NUMBER` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `MAIL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ADRESS_LIV` int(11) NOT NULL,
  `ADRESS_FAC` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `adresses`
--

INSERT INTO `adresses` (`id`, `ID_COMPANY`, `ORDRE`, `LABEL`, `ADRESSE`, `ZIPCODE`, `CITY`, `COUNTRY`, `NUMBER`, `MAIL`, `ADRESS_LIV`, `ADRESS_FAC`) VALUES
(1, 9, 2, 'LYON', '1 rue arcelor du mital', '69300', 'LYON', 'FRANCE', '02.64.354.546', 'lyon.arcelor@arcelor.com', 0, 1),
(2, 9, 1, 'Grenoble', '2 rue mital du arcelor', '38100', 'GRENOBLE', 'FRANCE', '02.64.354.546', 'alienbackflip@gmail.com', 0, 1),
(3, 1, 1, 'GRENOBLE', '1 rue de grenoble', '38100', 'Grenoble', 'France', '02.99.54.65.35', 'metalerie-grenoble@gmail.com', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `IND` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `PRESTATION_ID` int(11) NOT NULL,
  `FAMILLE_ID` int(11) NOT NULL,
  `ACHETER` int(11) NOT NULL,
  `PRIX_ACHETER` decimal(10,3) NOT NULL,
  `VENDU` int(11) NOT NULL,
  `PRIX_VENDU` decimal(10,3) NOT NULL,
  `UNITE_ID` int(11) NOT NULL,
  `MATIERE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `EP` decimal(10,3) NOT NULL,
  `DIM_X` decimal(10,3) NOT NULL,
  `DIM_Y` decimal(10,3) NOT NULL,
  `DIM_Z` decimal(10,3) NOT NULL,
  `POIDS` decimal(10,3) NOT NULL,
  `SUR_X` decimal(10,3) NOT NULL,
  `SUR_Y` decimal(10,3) NOT NULL,
  `SUR_Z` decimal(10,3) NOT NULL,
  `COMMENT` text COLLATE utf8_unicode_ci NOT NULL,
  `IMAGE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `CODE`, `LABEL`, `IND`, `PRESTATION_ID`, `FAMILLE_ID`, `ACHETER`, `PRIX_ACHETER`, `VENDU`, `PRIX_VENDU`, `UNITE_ID`, `MATIERE`, `EP`, `DIM_X`, `DIM_Y`, `DIM_Z`, `POIDS`, `SUR_X`, `SUR_Y`, `SUR_Z`, `COMMENT`, `IMAGE`) VALUES
(1, 'TOLE_S235_EP2', 'Tôle acier s235 ep 2', '1', 0, 0, 1, '0.000', 0, '0.000', 0, 'ACIER', '1.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', 'images/ArticlesImage/'),
(3, 'TOLE_S235_EP3', 'Tôle acier s235 ep 3', '1', 0, 0, 1, '1.000', 0, '0.000', 0, 'ACIER', '1.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', 'images/ArticlesImage/'),
(4, 'TOLE_S235_EP1', 'Tôle acier s235 ep 1', '1', 1, 0, 1, '1.000', 0, '0.000', 5, 'ACIER', '1.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', 'images/ArticlesImage/'),
(22, 'TOLE_S235_EP8', 'Tôle acier s235 ep 8', '1', 1, 0, 1, '1.000', 0, '1.000', 5, 'ACIER', '8.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', 'images/ArticlesImage/'),
(23, 'PLATINE1', 'Platine 100x100 4 trou', '1', 4, 0, 0, '0.000', 1, '10.000', 5, 'ACIER', '8.000', '100.000', '100.000', '8.000', '0.000', '10.000', '10.000', '10.000', '', 'images/ArticlesImage/platine.jpg'),
(24, 'POTEAU_1M', 'Poteau acier de 1 mètre', '1', 4, 0, 0, '0.000', 1, '50.000', 8, 'ACIER', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', 'Peinture anthracite', 'images/ArticlesImage/platine-pour-poteau-rond-gris-P-545747-2004687_1.webp'),
(25, 'TUBE_ACIER_ROND_60_2', 'Tube acier s235 rond 60 ep 2 mm', '1', 3, 2, 1, '1.000', 0, '0.000', 6, 'ACIER', '2.000', '60.000', '60.000', '990.000', '1.000', '0.000', '0.000', '5.000', '', 'images/ArticlesImage/'),
(21, 'TOLE_S235_EP6', 'Tôle acier s235 ep 6', '1', 1, 0, 1, '1.000', 0, '0.000', 5, 'ACIER', '6.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', 'images/ArticlesImage/'),
(20, 'TOLE_S235_EP5', 'Tôle acier s235 ep 5', '1', 0, 0, 0, '1.000', 0, '0.000', 0, 'ACIER', '1.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', 'images/ArticlesImage/'),
(16, 'TOLE_S235_EP4', 'Tôle acier s235 ep 4', '1', 1, 0, 1, '1.000', 0, '0.000', 5, 'ACIER', '2.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', 'images/ArticlesImage/'),
(17, 'TOLE_304_EP1', 'Tôle inox 304L ep 1', '1', 0, 0, 1, '3.000', 0, '0.000', 0, 'INOX', '1.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', 'images/ArticlesImage/'),
(26, 'VIS_ACIER_H_M10_LG100', 'Vis ACIER H M10 longueur 100mm', '1', 14, 3, 1, '0.001', 0, '0.000', 8, 'ACIER', '0.000', '10.000', '10.000', '100.000', '0.001', '0.000', '0.000', '0.000', '', 'images/ArticlesImage/vis-metaux-tete-hexagonale-th-classe-109-10x35-filetage-total-p12as5-acier.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `client_fourniseur`
--

DROP TABLE IF EXISTS `client_fourniseur`;
CREATE TABLE IF NOT EXISTS `client_fourniseur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `NAME` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `WEBSITE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `FBSITE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `TWITTERSITE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LKDSITE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `SIREN` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `APE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `TVA_INTRA` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `TVA_ID` int(11) NOT NULL,
  `LOGO` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `STATU_CLIENT` int(11) NOT NULL,
  `COND_REG_CLIENT_ID` int(11) NOT NULL,
  `MODE_REG_CLIENT_ID` int(11) NOT NULL,
  `REMISE` int(11) NOT NULL,
  `RESP_COM_ID` int(11) NOT NULL,
  `RESP_TECH_ID` int(11) NOT NULL,
  `COMPTE_GEN_CLIENT` int(11) NOT NULL,
  `COMPTE_AUX_CLIENT` int(11) NOT NULL,
  `STATU_FOUR` int(11) NOT NULL,
  `COND_REG_FOUR_ID` int(11) NOT NULL,
  `MODE_REG_FOUR_ID` int(11) NOT NULL,
  `COMPTE_GEN_FOUR` int(11) NOT NULL,
  `COMPTE_AUX_FOUR` int(11) NOT NULL,
  `CONTROLE_FOUR` int(11) NOT NULL,
  `DATE_CREA` date NOT NULL,
  `COMMENT` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `client_fourniseur`
--

INSERT INTO `client_fourniseur` (`id`, `CODE`, `NAME`, `WEBSITE`, `FBSITE`, `TWITTERSITE`, `LKDSITE`, `SIREN`, `APE`, `TVA_INTRA`, `TVA_ID`, `LOGO`, `STATU_CLIENT`, `COND_REG_CLIENT_ID`, `MODE_REG_CLIENT_ID`, `REMISE`, `RESP_COM_ID`, `RESP_TECH_ID`, `COMPTE_GEN_CLIENT`, `COMPTE_AUX_CLIENT`, `STATU_FOUR`, `COND_REG_FOUR_ID`, `MODE_REG_FOUR_ID`, `COMPTE_GEN_FOUR`, `COMPTE_AUX_FOUR`, `CONTROLE_FOUR`, `DATE_CREA`, `COMMENT`) VALUES
(1, 'METALI', 'METALERIE GRENOBLE ALPE', 'https://www.site.com/', 'https://www.facebook.com/', 'https://twitter.com/', 'https://www.linkedin.com/', '12345679910', '350', '', 4, 'images/ClientLogo/', 2, 1, 1, 0, 2, 1, 401000, 400000, 0, 1, 1, 401000, 400000, 1, '2020-10-28', ''),
(2, 'LASERDEC ', 'LASER DECOUPE', 'https://www.decoupe.com/', 'https://www.facebook.com/', 'https://twitter.com/', 'https://www.linkedin.com/', '12345679910', '350', '', 4, 'images/ClientLogo/', 2, 1, 2, 0, 1, 2, 401000, 400000, 0, 1, 1, 401000, 400000, 1, '2020-10-28', ''),
(3, 'METALJ', 'METAL JOLI', 'https://www.jolie.com/', 'https://www.facebook.com/', 'https://twitter.com/', 'https://www.linkedin.com/', '12345679910', '350', '', 4, 'images/ClientLogo/', 2, 1, 1, 0, 1, 2, 401000, 400000, 0, 1, 1, 401000, 400000, 1, '2020-10-28', ''),
(4, 'GLOB1', 'GLOBAL METAL1', 'https://www.site.com/', 'https://www.facebook.com/', 'https://twitter.com/', 'https://www.linkedin.com/', '12345679910', '350', '', 4, 'images/ClientLogo/', 2, 1, 1, 10, 1, 2, 401000, 400000, 0, 1, 1, 401000, 400000, 1, '2020-10-28', ''),
(5, 'GLOB', 'GLOBAL METAL', 'https://www.site.com/', 'https://www.facebook.com/', 'https://twitter.com/', 'https://www.linkedin.com/', '12345679910', '350', '', 4, 'images/ClientLogo/', 2, 1, 1, 10, 1, 2, 401000, 400000, 0, 1, 1, 401000, 400000, 1, '2020-10-28', ''),
(6, 'GLOB4', 'GLOBAL METAL4', 'https://www.site.com/', 'https://www.facebook.com/', 'https://twitter.com/', 'https://www.linkedin.com/', '12345679910', '350', '', 4, 'images/ClientLogo/', 2, 1, 1, 10, 1, 2, 401000, 400000, 0, 1, 1, 401000, 400000, 1, '2020-10-28', ''),
(7, 'GLOB3', 'GLOBAL METAL3', 'https://www.site.com/', 'https://www.facebook.com/', 'https://twitter.com/', 'https://www.linkedin.com/', '12345679910', '350', '', 4, 'images/ClientLogo/', 2, 1, 1, 10, 1, 2, 401000, 400000, 0, 1, 1, 401000, 400000, 1, '2020-10-28', ''),
(8, 'GLOB2', 'GLOBAL METAL2', 'https://www.site.com/', 'https://www.facebook.com/', 'https://twitter.com/', 'https://www.linkedin.com/', '12345679910', '350', '', 4, 'images/ClientLogo/', 2, 1, 1, 10, 1, 2, 401000, 400000, 0, 1, 1, 401000, 400000, 1, '2020-10-28', ''),
(9, 'ADM1', 'ARCELOR MITAL 1', 'https://e-steel.arcelormittal.com/FR/fr/', '', '', '', '46950096100641', '', '', 4, 'images/ClientLogo/1200px-Logo_ArcelorMittal.svg.png', 0, 8, 1, 0, 1, 2, 0, 0, 1, 8, 1, 401000, 400000, 1, '2020-10-28', ''),
(10, 'SVDPM', 'KDI SVDMP', 'https://www.kloecknermetals.fr/fr.html', 'https://www.facebook.com/KloecknerFrance/', 'https://twitter.com/KloecknerFrance', 'https://www.linkedin.com/company/klockner-distribution-industrielle/?originalSubdomain=fr', '54208635000411', '350', '', 4, 'images/ClientLogo/téléchargement.png', 0, 1, 1, 0, 1, 1, 0, 0, 1, 1, 1, 401000, 400000, 1, '2020-10-28', ''),
(11, 'ADM2', 'ARCELOR MITAL 2', 'https://e-steel.arcelormittal.com/FR/fr/', '', '', '', '46950096100641', '', '', 4, 'images/ClientLogo/', 0, 8, 1, 0, 1, 2, 0, 0, 1, 8, 1, 401000, 400000, 1, '2020-11-08', ''),
(12, 'ADM3', 'ARCELOR MITAL3', 'https://e-steel.arcelormittal.com/FR/fr/', '', '', '', '46950096100641', '', '', 4, 'images/ClientLogo/', 0, 8, 1, 0, 1, 2, 0, 0, 1, 8, 1, 401000, 400000, 1, '2020-11-08', '');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `INDICE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL_INDICE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `CLIENT_ID` int(11) NOT NULL,
  `CONTACT_ID` int(11) NOT NULL,
  `ADRESSE_ID` int(11) NOT NULL,
  `FACTURATION_ID` int(11) NOT NULL,
  `DATE` date NOT NULL,
  `ETAT` int(11) NOT NULL,
  `CREATEUR_ID` int(11) NOT NULL,
  `RESP_COM_ID` int(11) NOT NULL,
  `RESP_TECH_ID` int(11) NOT NULL,
  `REFERENCE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `COND_REG_CLIENT_ID` int(11) NOT NULL,
  `MODE_REG_CLIENT_ID` int(11) NOT NULL,
  `ECHEANCIER_ID` int(11) NOT NULL,
  `TRANSPORT_ID` int(11) NOT NULL,
  `COMENT` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id`, `CODE`, `INDICE`, `LABEL`, `LABEL_INDICE`, `CLIENT_ID`, `CONTACT_ID`, `ADRESSE_ID`, `FACTURATION_ID`, `DATE`, `ETAT`, `CREATEUR_ID`, `RESP_COM_ID`, `RESP_TECH_ID`, `REFERENCE`, `COND_REG_CLIENT_ID`, `MODE_REG_CLIENT_ID`, `ECHEANCIER_ID`, `TRANSPORT_ID`, `COMENT`) VALUES
(1, 'CDE201205-002', '1', '', '', 9, 0, 0, 0, '2020-12-05', 1, 1, 0, 0, '', 9, 5, 0, 0, '');

-- --------------------------------------------------------

--
-- Structure de la table `commande_ligne`
--

DROP TABLE IF EXISTS `commande_ligne`;
CREATE TABLE IF NOT EXISTS `commande_ligne` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `COMMANDE_ID` int(11) NOT NULL,
  `ORDRE` int(11) NOT NULL,
  `ARTICLE_CODE` int(11) NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `QT` int(11) NOT NULL,
  `UNIT_ID` int(11) NOT NULL,
  `PRIX_U` decimal(10,3) NOT NULL,
  `REMISE` decimal(10,3) NOT NULL,
  `TVA_ID` int(11) NOT NULL,
  `DELAIS_INTERNE` date NOT NULL,
  `DELAIS` date NOT NULL,
  `ETAT` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `company_setting`
--

DROP TABLE IF EXISTS `company_setting`;
CREATE TABLE IF NOT EXISTS `company_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ADDRESS` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `CITY` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ZIPCODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `REGION` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `COUNTRY` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `PHONE_NUMBER` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `MAIL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `WEB_SITE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `FACEBOOK_SITE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `TWITTER_SITE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LKD_SITE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LOGO` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `SIREN` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `APE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `TVA_INTRA` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `TAUX_TVA` int(11) NOT NULL,
  `CAPITAL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `RCS` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `company_setting`
--

INSERT INTO `company_setting` (`id`, `NAME`, `ADDRESS`, `CITY`, `ZIPCODE`, `REGION`, `COUNTRY`, `PHONE_NUMBER`, `MAIL`, `WEB_SITE`, `FACEBOOK_SITE`, `TWITTER_SITE`, `LKD_SITE`, `LOGO`, `SIREN`, `APE`, `TVA_INTRA`, `TAUX_TVA`, `CAPITAL`, `RCS`) VALUES
(1, 'SUPER ERP', '2 Rue Henriette Deloras', 'GRENOBLE', '4000', 'BRETAGNE', 'France', '0679214987', 'SuperERP@gmail.com', 'www.erp.com', 'https://www.facebook.com/Kevin.Niglaut', 'https://twitter.com/kevin_niglaut/', '', 'images/unnamed.jpg', '362 521 879', '12347', 'FR 53 157896342.', 20, 'SAS au capital de 2500 €', '400 900 001');

-- --------------------------------------------------------

--
-- Structure de la table `condition_reg`
--

DROP TABLE IF EXISTS `condition_reg`;
CREATE TABLE IF NOT EXISTS `condition_reg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `NBR_MOIS` int(11) NOT NULL,
  `NBR_JOURS` int(11) NOT NULL,
  `FIN_MOIS` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `condition_reg`
--

INSERT INTO `condition_reg` (`id`, `CODE`, `LABEL`, `NBR_MOIS`, `NBR_JOURS`, `FIN_MOIS`) VALUES
(8, '45FDM', '45 jours fin du mois', 0, 45, '1'),
(3, 'REC_FAC', 'A la réception de la facture', 0, 0, '0'),
(4, '30NET', '30 jours net', 0, 30, '0'),
(5, '30FDM', '30 jours fin de mois', 0, 30, '1'),
(6, '30FDM15', '30 jours fin de mois le 15', 1, 15, '1'),
(9, 'NONDEF', 'Non Définit', 0, 0, '1');

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ID_COMPANY` int(11) NOT NULL,
  `ORDRE` int(11) NOT NULL,
  `CIVILITE` int(11) NOT NULL,
  `PRENOM` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `NOM` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `FONCTION` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ADRESSE_ID` int(11) NOT NULL,
  `NUMBER` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `MOBILE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `MAIL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `contact`
--

INSERT INTO `contact` (`id`, `ID_COMPANY`, `ORDRE`, `CIVILITE`, `PRENOM`, `NOM`, `FONCTION`, `ADRESSE_ID`, `NUMBER`, `MOBILE`, `MAIL`) VALUES
(1, 9, 1, 0, 'Gérad', 'Normand', 'Acheteur', 1, '026497345', '0654976', 'robert@arcelor.com'),
(2, 9, 2, 2, 'Geraldine', 'Le marchand', 'Direction', 2, '026497345', '065497', ''),
(3, 1, 1, 1, 'Julie', 'SOUCHIER', 'Acheteuse', 3, '02.64.25.25', '', 'julie@metalerie-grenoble.com');

-- --------------------------------------------------------

--
-- Structure de la table `decoupage_tech`
--

DROP TABLE IF EXISTS `decoupage_tech`;
CREATE TABLE IF NOT EXISTS `decoupage_tech` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ARTICLE_ID` int(11) NOT NULL,
  `ORDRE` int(11) NOT NULL,
  `PRESTA_ID` int(11) NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `TPS_PREP` decimal(10,3) NOT NULL,
  `TPS_PRO` decimal(10,3) NOT NULL,
  `COUT` decimal(10,3) NOT NULL,
  `PRIX` decimal(10,3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `decoupage_tech`
--

INSERT INTO `decoupage_tech` (`id`, `ARTICLE_ID`, `ORDRE`, `PRESTA_ID`, `LABEL`, `TPS_PREP`, `TPS_PRO`, `COUT`, `PRIX`) VALUES
(1, 23, 10, 7, 'Etude', '0.100', '0.100', '0.000', '1.000'),
(3, 23, 20, 2, 'Laser', '0.100', '0.200', '0.000', '1.000'),
(4, 24, 10, 9, 'Soudure MIG', '0.500', '0.250', '5.000', '5.000'),
(5, 24, 20, 13, 'Peinture RAL 9010', '0.000', '0.000', '0.000', '5.000'),
(6, 24, 30, 12, 'FRET', '0.250', '0.050', '0.000', '1.000');

-- --------------------------------------------------------

--
-- Structure de la table `devis`
--

DROP TABLE IF EXISTS `devis`;
CREATE TABLE IF NOT EXISTS `devis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `INDICE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL_INDICE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `CLIENT_ID` int(11) NOT NULL,
  `CONTACT_ID` int(11) NOT NULL,
  `ADRESSE_ID` int(11) NOT NULL,
  `FACTURATION_ID` int(11) NOT NULL,
  `DATE` date NOT NULL,
  `DATE_VALIDITE` date NOT NULL,
  `ETAT` int(11) NOT NULL,
  `CREATEUR_ID` int(11) NOT NULL,
  `RESP_COM_ID` int(11) NOT NULL,
  `RESP_TECH_ID` int(11) NOT NULL,
  `REFERENCE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `COND_REG_CLIENT_ID` int(11) NOT NULL,
  `MODE_REG_CLIENT_ID` int(11) NOT NULL,
  `ECHEANCIER_ID` int(11) NOT NULL,
  `TRANSPORT_ID` int(11) NOT NULL,
  `COMENT` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `devis`
--

INSERT INTO `devis` (`id`, `CODE`, `INDICE`, `LABEL`, `LABEL_INDICE`, `CLIENT_ID`, `CONTACT_ID`, `ADRESSE_ID`, `FACTURATION_ID`, `DATE`, `DATE_VALIDITE`, `ETAT`, `CREATEUR_ID`, `RESP_COM_ID`, `RESP_TECH_ID`, `REFERENCE`, `COND_REG_CLIENT_ID`, `MODE_REG_CLIENT_ID`, `ECHEANCIER_ID`, `TRANSPORT_ID`, `COMENT`) VALUES
(3, 'DV201118-01', '1', '', '', 1, 3, 3, 3, '2020-11-18', '2020-11-21', 3, 1, 2, 2, '1er demande de metalerie', 8, 1, 2, 1, 'test\r\naar'),
(5, 'DV201128-03', '1', '', '', 3, 0, 0, 0, '2020-11-29', '2020-11-29', 1, 1, 1, 1, '', 9, 5, 0, 0, ''),
(6, 'DV201205-04', '1', '', '', 2, 0, 0, 0, '2020-12-05', '2020-12-05', 1, 1, 0, 0, '', 9, 5, 0, 0, '');

-- --------------------------------------------------------

--
-- Structure de la table `devis_lignes`
--

DROP TABLE IF EXISTS `devis_lignes`;
CREATE TABLE IF NOT EXISTS `devis_lignes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `DEVIS_ID` int(11) NOT NULL,
  `ORDRE` int(11) NOT NULL,
  `ARTICLE_CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `QT` int(11) NOT NULL,
  `UNIT_ID` int(11) NOT NULL,
  `PRIX_U` decimal(10,3) NOT NULL,
  `REMISE` decimal(10,3) NOT NULL,
  `TVA_ID` int(11) NOT NULL,
  `DELAIS` date NOT NULL,
  `ETAT` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `devis_lignes`
--

INSERT INTO `devis_lignes` (`id`, `DEVIS_ID`, `ORDRE`, `ARTICLE_CODE`, `LABEL`, `QT`, `UNIT_ID`, `PRIX_U`, `REMISE`, `TVA_ID`, `DELAIS`, `ETAT`) VALUES
(1, 3, 10, 'PLATINE1', '', 2, 8, '100.000', '100.000', 1, '2020-10-29', 3),
(2, 3, 20, 'super ligne', '', 2, 2, '100.000', '100.000', 1, '2020-11-20', 3),
(3, 3, 30, 'super ligne3', '', 2, 4, '100.000', '0.000', 2, '2020-11-20', 3),
(4, 3, 40, 'ligne inter', '', 2, 5, '100.000', '0.000', 2, '2020-11-05', 3),
(5, 3, 50, 'super ligne', '', 2, 6, '100.000', '0.000', 3, '2020-11-23', 3),
(6, 3, 50, 'super ligne', '', 2, 7, '100.000', '0.000', 3, '2020-11-23', 3),
(9, 5, 10, '', '', 1, 1, '10.000', '0.000', 4, '2020-12-31', 1),
(10, 5, 10, 'PLATINE1', '', 1, 1, '10.000', '0.000', 4, '2020-12-31', 1),
(11, 5, 10, '', '', 1, 0, '0.000', '0.000', 4, '2020-11-05', 1),
(12, 5, 10, '', '', 1, 0, '0.000', '0.000', 4, '2020-11-05', 1);

-- --------------------------------------------------------

--
-- Structure de la table `echeancier_type`
--

DROP TABLE IF EXISTS `echeancier_type`;
CREATE TABLE IF NOT EXISTS `echeancier_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `echeancier_type`
--

INSERT INTO `echeancier_type` (`id`, `CODE`, `LABEL`) VALUES
(1, '12MOIS', 'Échéancier sur 12 mois'),
(2, '3MOIS', 'Échéancier sur 3 mois'),
(0, 'AUCUN', 'Aucun');

-- --------------------------------------------------------

--
-- Structure de la table `echeancier_type_ligne`
--

DROP TABLE IF EXISTS `echeancier_type_ligne`;
CREATE TABLE IF NOT EXISTS `echeancier_type_ligne` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ECHEANCIER_ID` int(11) NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `POURC_MONTANT` decimal(10,3) NOT NULL,
  `POURC_TVA` decimal(10,3) NOT NULL,
  `CONDI_REG_ID` int(11) NOT NULL,
  `MODE_REG_ID` int(11) NOT NULL,
  `DELAI` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `echeancier_type_ligne`
--

INSERT INTO `echeancier_type_ligne` (`id`, `ECHEANCIER_ID`, `LABEL`, `POURC_MONTANT`, `POURC_TVA`, `CONDI_REG_ID`, `MODE_REG_ID`, `DELAI`) VALUES
(1, 2, '3MOIS1', '33.333', '33.333', 0, 0, 0),
(2, 2, '3MOIS2', '33.333', '33.333', 0, 0, 0),
(3, 2, '3MOIS3', '33.330', '33.334', 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `email`
--

DROP TABLE IF EXISTS `email`;
CREATE TABLE IF NOT EXISTS `email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `OBJET` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `TEXT` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `email`
--

INSERT INTO `email` (`id`, `CODE`, `LABEL`, `OBJET`, `TEXT`) VALUES
(1, 'ARC', 'Accusé réception de commande', 'Accusé récéption de commande numéro <05>', 'Bonjour <02> <03>;\r\n\r\nVous trouverez ci joint notre accusé de réception de commande pour votre commande <05>\r\n\r\nRestant à votre disposition\r\n\r\nCordialement'),
(2, 'BL', 'Bon de livraison', 'Bon de livraison <05>', 'Bonjour <02> <03>;\r\n\r\nVous trouverez ci joint notre bon de livraison pour votre commande <05> en date du <07>\r\n\r\nRestant à votre disposition\r\n\r\nCordialement'),
(3, 'DEV', 'Offre de prix', 'Offre de prix <05>', 'Bonjour <02> <03>;\r\n\r\nVeuillez trouver en pièce jointe notre offre de prix <05>\r\n\r\nCordialement\r\n\r\n');

-- --------------------------------------------------------

--
-- Structure de la table `evenement_machine`
--

DROP TABLE IF EXISTS `evenement_machine`;
CREATE TABLE IF NOT EXISTS `evenement_machine` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ORDRE` int(11) NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `MASK_TIME` int(11) NOT NULL,
  `COLOR` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ETAT` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `evenement_machine`
--

INSERT INTO `evenement_machine` (`id`, `CODE`, `ORDRE`, `LABEL`, `MASK_TIME`, `COLOR`, `ETAT`) VALUES
(1, 'STOP', 10, 'Machine arrêtée', 0, '#ff0000', 4),
(2, 'PREP', 20, 'Machine en préparation', 0, '#ff6f00', 2),
(3, 'RUN', 30, 'Machine en fonctionnement', 0, '#37ff00', 3),
(4, 'OUT', 40, 'Machine en panne', 0, '#ff0000', 4);

-- --------------------------------------------------------

--
-- Structure de la table `improductive_activity`
--

DROP TABLE IF EXISTS `improductive_activity`;
CREATE TABLE IF NOT EXISTS `improductive_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ETAT_MACHINE` int(11) NOT NULL,
  `RESSOURCE_NEC` int(11) NOT NULL,
  `MASK_TIME` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `improductive_activity`
--

INSERT INTO `improductive_activity` (`id`, `LABEL`, `ETAT_MACHINE`, `RESSOURCE_NEC`, `MASK_TIME`) VALUES
(1, 'Attente tâche / Préparation travail', 1, 0, 0),
(2, 'Entretien / Nettoyage / Rangement', 1, 0, 0),
(3, 'Réunion', 1, 0, 0),
(4, 'Formation administrative', 1, 0, 0),
(5, 'Formation machine', 1, 1, 0),
(6, 'Activité interne', 1, 0, 0),
(7, 'Panne', 1, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `imputation_comptables`
--

DROP TABLE IF EXISTS `imputation_comptables`;
CREATE TABLE IF NOT EXISTS `imputation_comptables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `TVA` int(11) NOT NULL,
  `COMPTE_TVA` int(11) NOT NULL,
  `CODE_COMPTA` int(11) NOT NULL,
  `TYPE_IMPUTATION` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `imputation_comptables`
--

INSERT INTO `imputation_comptables` (`id`, `CODE`, `LABEL`, `TVA`, `COMPTE_TVA`, `CODE_COMPTA`, `TYPE_IMPUTATION`) VALUES
(1, '419100', 'ACOMPTE SUR COMMANDE', 4, 0, 419100, 6),
(2, '445661', 'TVA ACHAT FRANCE', 4, 0, 445661, 6),
(3, '445710', 'TVA VENTE FRANCE', 4, 0, 445710, 6),
(4, '601000', 'ACHAT FRANCE', 4, 445661, 601000, 1),
(5, '602000', 'ACHAT UK', 5, 0, 602000, 1),
(6, '701000', 'VENTE PRODUIT FRANCE', 4, 445710, 701000, 1);

-- --------------------------------------------------------

--
-- Structure de la table `imputation_comptables_ligne`
--

DROP TABLE IF EXISTS `imputation_comptables_ligne`;
CREATE TABLE IF NOT EXISTS `imputation_comptables_ligne` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ARTICLE_ID` int(11) NOT NULL,
  `ORDRE` int(11) NOT NULL,
  `IMPUTATION_ID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `imputation_comptables_ligne`
--

INSERT INTO `imputation_comptables_ligne` (`ID`, `ARTICLE_ID`, `ORDRE`, `IMPUTATION_ID`) VALUES
(1, 24, 10, 6);

-- --------------------------------------------------------

--
-- Structure de la table `infos_generales`
--

DROP TABLE IF EXISTS `infos_generales`;
CREATE TABLE IF NOT EXISTS `infos_generales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ETAT` int(11) NOT NULL,
  `TIMESTAMP` int(11) NOT NULL,
  `TEXT` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `infos_generales`
--

INSERT INTO `infos_generales` (`id`, `ETAT`, `TIMESTAMP`, `TEXT`) VALUES
(1, 1, 1607188734, 'Fermeture semaine 52 et 53\r\n\r\n...___.._____\r\n....\'/,-Y\".............\"~-.\r\n..l.Y.......................^.\r\n./\\............................_\\_\r\ni.................... ___/\"....\"\\\r\n|.................../\"....\"\\ .....o !\r\nl..................].......o !__../\r\n.\\..._..._.........\\..___./...... \"~\\\r\n..X...\\/...\\.....................___./\r\n.(. \\.___......_.....--~~\".......~`-.\r\n....`.Z,--........./...........................\\\r\n.......\\__....(......../..........______)\r\n...........\\.........l......../-----~~\" /\r\n............Y.......\\...................../\r\n............|........\"x______.^\r\n............|........................\\\r\n............j..........................Y'),
(2, 1, 1607189659, 'Joyeuses Fêtes de fin d\'année');

-- --------------------------------------------------------

--
-- Structure de la table `jours_feries`
--

DROP TABLE IF EXISTS `jours_feries`;
CREATE TABLE IF NOT EXISTS `jours_feries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FIXE` int(11) NOT NULL,
  `DATE` date NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `jours_feries`
--

INSERT INTO `jours_feries` (`id`, `FIXE`, `DATE`, `LABEL`) VALUES
(1, 1, '2020-01-01', 'Jour de l\'an'),
(2, 1, '2020-05-01', 'Fête du travail'),
(3, 1, '2020-05-05', '8 Mai 1945'),
(4, 1, '2020-07-14', 'Fête national'),
(5, 1, '2020-08-15', 'Assomption'),
(6, 1, '2020-11-01', 'La Toussaint'),
(7, 1, '2020-11-11', 'Armistice 1918'),
(8, 1, '2020-12-25', 'Noël');

-- --------------------------------------------------------

--
-- Structure de la table `mode_reglement`
--

DROP TABLE IF EXISTS `mode_reglement`;
CREATE TABLE IF NOT EXISTS `mode_reglement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `CODE_COMPTABLE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `mode_reglement`
--

INSERT INTO `mode_reglement` (`id`, `CODE`, `LABEL`, `CODE_COMPTABLE`) VALUES
(1, 'VIR', 'VIREMENT', ''),
(2, 'CHQ', 'CHEQUE', ''),
(3, 'CB', 'CARTE BANCAIRE', ''),
(4, 'CMPT', 'COMPTANT', ''),
(5, 'NONDEF', 'Non définit', '');

-- --------------------------------------------------------

--
-- Structure de la table `nomenclature`
--

DROP TABLE IF EXISTS `nomenclature`;
CREATE TABLE IF NOT EXISTS `nomenclature` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ORDRE` int(11) NOT NULL,
  `PARENT_ID` int(11) NOT NULL,
  `ARTICLE_ID` int(11) NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `QT` decimal(10,3) NOT NULL,
  `UNIT_ID` int(11) NOT NULL,
  `PRIX_U` decimal(10,3) NOT NULL,
  `PRIX_ACHAT` decimal(10,3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `nomenclature`
--

INSERT INTO `nomenclature` (`id`, `ORDRE`, `PARENT_ID`, `ARTICLE_ID`, `LABEL`, `QT`, `UNIT_ID`, `PRIX_U`, `PRIX_ACHAT`) VALUES
(1, 10, 23, 22, '', '1.000', 5, '2.000', '2.000'),
(2, 10, 24, 25, 'Tube', '1.000', 1, '0.000', '1.000'),
(3, 20, 24, 26, 'Vis', '4.000', 1, '0.000', '0.500');

-- --------------------------------------------------------

--
-- Structure de la table `num_doc`
--

DROP TABLE IF EXISTS `num_doc`;
CREATE TABLE IF NOT EXISTS `num_doc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `DOC_TYPE` int(11) NOT NULL,
  `MODEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `DIGIT` int(11) NOT NULL,
  `COMPTEUR` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `num_doc`
--

INSERT INTO `num_doc` (`id`, `DOC_TYPE`, `MODEL`, `DIGIT`, `COMPTEUR`) VALUES
(1, 4, 'CDE<AA><MM><JJ>-<I>', 3, 5),
(2, 0, 'AR<AA><MM><JJ>-<I>', 3, 0),
(3, 3, 'BL<AA><MM><JJ>-<I>', 3, 0),
(4, 6, 'ST<AA><MM><JJ>-<I>', 3, 0),
(5, 8, 'DV<AA><MM><JJ>-<I>', 2, 4);

-- --------------------------------------------------------

--
-- Structure de la table `planning`
--

DROP TABLE IF EXISTS `planning`;
CREATE TABLE IF NOT EXISTS `planning` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_RECURENT` int(11) NOT NULL,
  `SUP` tinyint(1) NOT NULL,
  `COMMANDE` int(11) NOT NULL,
  `CO_CLIENT` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `CLIENT` int(11) NOT NULL,
  `PLAN` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `DESIGNATION` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `QT` decimal(10,0) NOT NULL,
  `PRIX_U` decimal(10,0) NOT NULL,
  `MATIERE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `EPAISSEUR` decimal(10,0) NOT NULL,
  `DATE_CLIENT` date NOT NULL,
  `DATE_CONFIRM` date NOT NULL,
  `ETUDE` int(11) NOT NULL,
  `STOCK` int(11) NOT NULL,
  `TRUMPH_1` int(11) NOT NULL,
  `SEM_PROD_LASER` int(11) NOT NULL,
  `TPS_PRODUIT_L` int(11) NOT NULL,
  `QT_PRODUIT_L` int(11) NOT NULL,
  `EBAVURAGE` int(11) NOT NULL,
  `ORBITALE` int(11) NOT NULL,
  `EBAV_CHAMPS` int(11) NOT NULL,
  `SUP_MICRO_ATTACHE` int(11) NOT NULL,
  `TRIBOFINITION` int(11) NOT NULL,
  `SEM_PROD_EBAV` int(11) NOT NULL,
  `TPS_PRODUIT_EBAV` int(11) NOT NULL,
  `QT_PRODUIT_EBAV` int(11) NOT NULL,
  `PARACHEVEMENT` int(11) NOT NULL,
  `PERCAGE` int(11) NOT NULL,
  `TARAUDAGE` int(11) NOT NULL,
  `FRAISURAGE` int(11) NOT NULL,
  `INSERT_P` int(11) NOT NULL,
  `SEM_PROD_PARA` int(11) NOT NULL,
  `TPS_PRODUIT_P` int(11) NOT NULL,
  `QT_PRODUIT_PARA` int(11) NOT NULL,
  `PLIAGE` int(11) NOT NULL,
  `NBR_OP` int(11) NOT NULL,
  `SEM_PROD_PLI` int(11) NOT NULL,
  `TPS_PRODUIT_PLI` int(11) NOT NULL,
  `QT_PRODUIT_PLI` int(11) NOT NULL,
  `SOUDURE_MIG` int(11) NOT NULL,
  `SEM_PROD_MIG` int(11) NOT NULL,
  `TPS_PRODUIT_MIG` int(11) NOT NULL,
  `QT_PRODUIT_MIG` int(11) NOT NULL,
  `SOUDURE_TIG` int(11) NOT NULL,
  `SEM_PROD_TIG` int(11) NOT NULL,
  `TPS_PRODUIT_TIG` int(11) NOT NULL,
  `QT_PRODUIT_TIG` int(11) NOT NULL,
  `QT_EXPEDIER` int(11) NOT NULL,
  `TRANSPORTEUR` int(11) NOT NULL,
  `COMMENTAIRES` text COLLATE utf8_unicode_ci NOT NULL,
  `POIDS` decimal(10,0) NOT NULL,
  `DEVIS` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `prestations`
--

DROP TABLE IF EXISTS `prestations`;
CREATE TABLE IF NOT EXISTS `prestations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ORDRE` int(11) NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `TYPE` int(11) NOT NULL,
  `TAUX_H` int(11) NOT NULL,
  `MARGE` int(11) NOT NULL,
  `COLOR` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `IMAGE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `RESSOURCE_ID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `prestations`
--

INSERT INTO `prestations` (`id`, `CODE`, `ORDRE`, `LABEL`, `TYPE`, `TAUX_H`, `MARGE`, `COLOR`, `IMAGE`, `RESSOURCE_ID`) VALUES
(1, 'MAT', 2, 'Tôle', 3, 0, 20, '#8fd548', '', ''),
(2, 'LAS', 20, 'laser', 1, 110, 0, '#da1010', '', ''),
(3, 'PROFILE', 3, 'Profilé', 4, 0, 0, '#39c926', '', ''),
(4, 'PFTOL', 1, 'Produit finie de tolerie', 8, 0, 0, '#c0f1f2', '', ''),
(6, 'PLI', 40, 'Pliage', 1, 50, 0, '#5ebbe4', '', ''),
(7, 'ETU', 5, 'Etude', 1, 50, 0, '#f07c24', '', ''),
(8, 'SOUDT', 50, 'Soudure TIG', 1, 60, 0, '#fbff05', '', ''),
(9, 'SOUDM', 60, 'Soudure MIG', 1, 50, 0, '#afa72c', '', ''),
(10, 'PARA', 70, 'Parachèvemet', 1, 45, 0, '#9e0000', '', ''),
(11, 'EMB', 90, 'Emballage', 1, 50, 0, '#0818f7', '', ''),
(12, 'TRANSEXT', 110, 'Transport externe', 7, 0, 0, '#0afbff', '', ''),
(13, 'PAINT', 100, 'Peinture', 7, 0, 0, '#f019a1', '', ''),
(14, 'ACHAT', 4, 'Consomables', 6, 0, 0, '#e72323', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `ql_appareil_mesure`
--

DROP TABLE IF EXISTS `ql_appareil_mesure`;
CREATE TABLE IF NOT EXISTS `ql_appareil_mesure` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `RESSOURCE_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `SERIAL_NUMBER` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `DATE` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `ql_appareil_mesure`
--

INSERT INTO `ql_appareil_mesure` (`id`, `CODE`, `LABEL`, `RESSOURCE_ID`, `USER_ID`, `SERIAL_NUMBER`, `DATE`) VALUES
(1, 'PIED', 'Pied à coulisse', 0, 1, '1235467', '2020-10-31');

-- --------------------------------------------------------

--
-- Structure de la table `ql_causes`
--

DROP TABLE IF EXISTS `ql_causes`;
CREATE TABLE IF NOT EXISTS `ql_causes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `ql_causes`
--

INSERT INTO `ql_causes` (`id`, `CODE`, `LABEL`) VALUES
(1, 'USURE', 'Usure de l\'appareil');

-- --------------------------------------------------------

--
-- Structure de la table `ql_corrections`
--

DROP TABLE IF EXISTS `ql_corrections`;
CREATE TABLE IF NOT EXISTS `ql_corrections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `ql_corrections`
--

INSERT INTO `ql_corrections` (`id`, `CODE`, `LABEL`) VALUES
(2, 'REMPLA', 'Remplacement de l\'appareil de mesure');

-- --------------------------------------------------------

--
-- Structure de la table `ql_defaut`
--

DROP TABLE IF EXISTS `ql_defaut`;
CREATE TABLE IF NOT EXISTS `ql_defaut` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `ql_defaut`
--

INSERT INTO `ql_defaut` (`id`, `CODE`, `LABEL`) VALUES
(1, 'CALIB', 'Mauvaise calibration');

-- --------------------------------------------------------

--
-- Structure de la table `ressource`
--

DROP TABLE IF EXISTS `ressource`;
CREATE TABLE IF NOT EXISTS `ressource` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `IMAGE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `MASK_TIME` int(11) NOT NULL,
  `ORDRE` int(11) NOT NULL,
  `CAPACITY` decimal(11,0) NOT NULL,
  `SECTION_ID` int(11) NOT NULL,
  `COLOR` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `ressource`
--

INSERT INTO `ressource` (`id`, `CODE`, `LABEL`, `IMAGE`, `MASK_TIME`, `ORDRE`, `CAPACITY`, `SECTION_ID`, `COLOR`) VALUES
(1, 'LASER1', 'Laser trumpf', 'images/Ressources/TruLaser-3030-L20.jpg', 0, 10, '70', 4, '#d01616'),
(2, 'LASER2', 'Laser Bystronic', 'images/Ressources/téléchargement (1).jpg', 0, 20, '70', 4, '#dd4b4b'),
(3, 'PLIEUSE1', 'PLieuse Perrot', 'images/Ressources/téléchargement.jpg', 0, 30, '35', 5, '#39a923'),
(4, 'PLIEUSE2', 'Plieuse Amada', 'images/Ressources/527.jpg', 0, 40, '35', 5, '#000000'),
(5, 'POINC', 'Poinçonneuse Primat', 'images/Ressources/7222.jpg', 0, 25, '30', 4, '#b56e2c'),
(7, 'USI', 'Centre d\'usinage Mazak', 'images/Ressources/téléchargement (2).jpg', 0, 50, '25', 7, '#4ba7be'),
(8, 'SOUD', 'Soudure MIG', 'images/Ressources/soudure-jpg5d405386fe9b670001920b04.jpg', 0, 60, '30', 6, '#db8814'),
(9, 'SOUD2', 'Soudure TIG', 'images/Ressources/téléchargement (3).jpg', 0, 65, '30', 6, '#7c4c27'),
(10, 'EMB', 'Emballage', 'images/Ressources/product_9722964b.jpg', 0, 70, '32', 8, '#e9cd16');

-- --------------------------------------------------------

--
-- Structure de la table `rights`
--

DROP TABLE IF EXISTS `rights`;
CREATE TABLE IF NOT EXISTS `rights` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `RIGHT_NAME` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `page_1` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `page_2` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `page_3` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `page_4` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `page_5` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `page_6` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `page_7` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `page_8` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `page_9` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `page_10` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `rights`
--

INSERT INTO `rights` (`id`, `RIGHT_NAME`, `page_1`, `page_2`, `page_3`, `page_4`, `page_5`, `page_6`, `page_7`, `page_8`, `page_9`, `page_10`) VALUES
(1, 'Admin', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1'),
(3, 'Reponsable de site', '1', '0', '1', '1', '1', '1', '1', '1', '1', '1'),
(4, 'Ordonnancement', '1', '1', '1', '1', '1', '1', '1', '1', '1', '0'),
(5, 'Deviseur', '1', '1', '1', '1', '1', '1', '1', '1', '1', '0'),
(6, 'Programmeur', '1', '1', '1', '1', '1', '1', '1', '1', '1', '0'),
(7, 'Opérateur', '1', '1', '1', '0', '1', '1', '1', '0', '1', '0'),
(8, 'Responsable commercial', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');

-- --------------------------------------------------------

--
-- Structure de la table `section`
--

DROP TABLE IF EXISTS `section`;
CREATE TABLE IF NOT EXISTS `section` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ORDRE` int(11) NOT NULL,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `COUT_H` int(11) NOT NULL,
  `RESPONSABLE` int(11) NOT NULL,
  `COLOR` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `section`
--

INSERT INTO `section` (`id`, `ORDRE`, `CODE`, `LABEL`, `COUT_H`, `RESPONSABLE`, `COLOR`) VALUES
(1, 10, 'ADM', 'Administratif', 90, 1, '#cf1717'),
(4, 20, 'LAS', 'Atelier Découpe laser', 110, 1, '#249c1c'),
(5, 30, 'PLI', 'Atelier Pliage', 50, 1, '#40b5ad'),
(6, 40, 'SOUD', 'Atelier Soudure', 60, 1, '#ac2bb6'),
(7, 25, 'MECA', 'Atelier Mécanique', 45, 1, '#a45913'),
(8, 70, 'EXPE', 'Expedition', 50, 1, '#d3ed0c');

-- --------------------------------------------------------

--
-- Structure de la table `sous_ensemble`
--

DROP TABLE IF EXISTS `sous_ensemble`;
CREATE TABLE IF NOT EXISTS `sous_ensemble` (
  `id` int(11) NOT NULL,
  `PARENT_ID` int(11) NOT NULL,
  `ORDRE` int(11) NOT NULL,
  `ARTICLE_ID` int(11) NOT NULL,
  `QT` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `sous_ensemble`
--

INSERT INTO `sous_ensemble` (`id`, `PARENT_ID`, `ORDRE`, `ARTICLE_ID`, `QT`) VALUES
(0, 24, 10, 23, 1);

-- --------------------------------------------------------

--
-- Structure de la table `sous_famille`
--

DROP TABLE IF EXISTS `sous_famille`;
CREATE TABLE IF NOT EXISTS `sous_famille` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `PRESTATION_ID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `sous_famille`
--

INSERT INTO `sous_famille` (`id`, `CODE`, `LABEL`, `PRESTATION_ID`) VALUES
(1, 'CARRE', 'Profilé carré', 3),
(2, 'ROND', 'Profilé rond', 3),
(3, 'Vis', 'Visserie', 14),
(4, 'Rivets', 'Rivets', 14),
(5, 'Rondelles', 'Rondelles', 14),
(6, 'PRODUITS_FINIS', 'Produit finis', 4);

-- --------------------------------------------------------

--
-- Structure de la table `sous_traitance`
--

DROP TABLE IF EXISTS `sous_traitance`;
CREATE TABLE IF NOT EXISTS `sous_traitance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cmd` int(11) NOT NULL,
  `DATE_RELANCE` date NOT NULL,
  `STATU_RELANCE` tinyint(1) NOT NULL,
  `DATE_RECEPTION` date NOT NULL,
  `STATU_RECEPTION` int(11) NOT NULL,
  `FOURNISSEUR` int(11) NOT NULL,
  `CMD_ACHAT` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `PRIX` decimal(10,0) NOT NULL,
  `NUM_OFFRE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ORDRE` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `stock_zone`
--

DROP TABLE IF EXISTS `stock_zone`;
CREATE TABLE IF NOT EXISTS `stock_zone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `RESSOURCE_ID` int(11) NOT NULL,
  `COLOR` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `stock_zone`
--

INSERT INTO `stock_zone` (`id`, `CODE`, `LABEL`, `RESSOURCE_ID`, `COLOR`) VALUES
(1, 'Expe', 'Expédition Transport', 10, '#fff700'),
(3, 'Laser1', 'Laser Trumpf', 1, '#ff0000'),
(4, 'Laser2', 'Laser Bystronic', 2, '#f21818'),
(5, 'Zone1', 'Zone inter 1', 0, '#8861f5'),
(6, 'Zone2', 'Zone inter 2', 0, '#8367ad'),
(7, 'Zone3', 'Zone inter 3', 0, '#9a73c9'),
(8, 'Pliage', 'Plieuses', 3, '#28864c');

-- --------------------------------------------------------

--
-- Structure de la table `transport`
--

DROP TABLE IF EXISTS `transport`;
CREATE TABLE IF NOT EXISTS `transport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `transport`
--

INSERT INTO `transport` (`id`, `CODE`, `LABEL`) VALUES
(1, 'FRANCO', 'Franco de port et d\'emballage'),
(2, 'DEPART', 'Prix départ'),
(0, 'AUCUN', 'Aucun transport');

-- --------------------------------------------------------

--
-- Structure de la table `tva`
--

DROP TABLE IF EXISTS `tva`;
CREATE TABLE IF NOT EXISTS `tva` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `TAUX` decimal(10,3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `tva`
--

INSERT INTO `tva` (`id`, `CODE`, `LABEL`, `TAUX`) VALUES
(1, '0%EX', 'TVA Exonérée', '0.000'),
(2, '5%', 'TVA France réduite', '5.000'),
(3, '10%', 'TVA France réduite', '10.000'),
(4, '20%', 'TVA France', '20.000'),
(5, 'NULL', 'Aucune', '0.000');

-- --------------------------------------------------------

--
-- Structure de la table `type_absence`
--

DROP TABLE IF EXISTS `type_absence`;
CREATE TABLE IF NOT EXISTS `type_absence` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `PAYE` int(11) NOT NULL,
  `COLOR` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `TYPE_JOUR` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `type_absence`
--

INSERT INTO `type_absence` (`id`, `CODE`, `LABEL`, `PAYE`, `COLOR`, `TYPE_JOUR`) VALUES
(1, 'ABSBR', 'Absence non rémunéré', 1, '#000000', 0),
(2, 'ABSR', 'Absence rémunéré', 1, '#1dff1a', 0),
(3, 'ACCT', 'Accident de travail', 0, '#c10606', 0),
(4, 'ACTJ', 'Accident de trajet', 0, '#d52a85', 0),
(5, 'CEXP', 'Congé exceptionnels', 1, '#896eb9', 0),
(6, 'CMALA', 'Congé Maladie', 1, '#d65d29', 0),
(7, 'CPAR', 'Congé Parent', 1, '#000000', 2),
(8, 'CP', 'Congé payé', 1, '#d7f019', 0),
(9, 'RTT', 'Réduction du temps de travail', 0, '#91cd56', 0);

-- --------------------------------------------------------

--
-- Structure de la table `unit`
--

DROP TABLE IF EXISTS `unit`;
CREATE TABLE IF NOT EXISTS `unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `TYPE` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `unit`
--

INSERT INTO `unit` (`id`, `CODE`, `LABEL`, `TYPE`) VALUES
(8, 'BTE', 'Boite', 5),
(2, 'CM', 'Centimètre', 2),
(4, 'GRA', 'Gramme', 1),
(5, 'KG', 'Kilogramme', 1),
(6, 'M', 'Mètre', 2),
(7, 'PCE', 'Pièce', 5),
(1, 'UNI', 'Unité', 5),
(9, 'MM', 'Milimètre', 2);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `idUSER` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `NOM` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `PRENOM` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `DATE_NAISSANCE` date NOT NULL,
  `MAIL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `NUMERO_PERSO` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `NUMERO_INTERNE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `IMAGE_PROFIL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `STATU` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CONNEXION` int(45) DEFAULT NULL,
  `NAME` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PASSWORD` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `FONCTION` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `SECTION_ID` int(11) NOT NULL,
  PRIMARY KEY (`idUSER`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`idUSER`, `CODE`, `NOM`, `PRENOM`, `DATE_NAISSANCE`, `MAIL`, `NUMERO_PERSO`, `NUMERO_INTERNE`, `IMAGE_PROFIL`, `STATU`, `CONNEXION`, `NAME`, `PASSWORD`, `FONCTION`, `SECTION_ID`) VALUES
(1, 'KNB', 'Kévin', 'Duchamps', '2020-11-18', 'kevin.duchamps@mail.fr', '0697764654', '553', 'images/Profils/photo,medium.1459798851.jpg', '1', 1607294706, 'Billy', 'KN1', '1', 1),
(2, 'U11', 'Dupond', 'Robert', '2020-11-18', '', '00.00.00.00.01', '00.00.00.00.01', '', '1', 1602538750, 'USER11', 'USER1', '8', 1),
(3, 'U1', 'THOMAS', 'DEBOUT', '2020-11-18', '', '00.00.00.00.01', '00.00.00.00.01', '', '1', 1602538787, 'USER1', 'USER1', '3', 1),
(4, 'U3', 'Judi', 'LEGROUC', '2020-11-18', '', '00.00.00.00.01', '00.00.00.00.01', '', '1', 1602538811, 'USER1', 'USER1', '5', 1),
(5, 'U2', 'Yoann', 'DEPARIS', '2020-11-18', '', '00.00.00.00.01', '00.00.00.00.01', '', '1', 1602538917, 'USER2', 'USER2', '6', 4),
(6, 'U33', 'Corine', 'VENDUPAIN', '2020-11-18', '', '00.00.00.00.01', '00.00.00.00.01', '', '1', 1602539125, 'USER33', 'USER33', '7', 4);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
