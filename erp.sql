-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 28 déc. 2020 à 22:36
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
) ENGINE=MyISAM AUTO_INCREMENT=305 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `adresses`
--

INSERT INTO `adresses` (`id`, `ID_COMPANY`, `ORDRE`, `LABEL`, `ADRESSE`, `ZIPCODE`, `CITY`, `COUNTRY`, `NUMBER`, `MAIL`, `ADRESS_LIV`, `ADRESS_FAC`) VALUES
(1, 9, 2, 'LYON', '1 rue arcelor du mital', '69300', 'LYON', 'FRANCE', '02.64.354.546', 'lyon.arcelor@arcelor.com', 0, 1),
(2, 9, 1, 'Grenoble', '2 rue mital du arcelor', '38100', 'GRENOBLE', 'FRANCE', '02.64.354.546', 'alienbackflip@gmail.com', 0, 1),
(3, 1, 1, 'GRENOBLE', '1 rue de grenoble', '38100', 'Grenoble', 'France', '02.99.54.65.35', 'metalerie-grenoble@gmail.com', 1, 1),
(5, 83, 40, '5534 Vestibulum Impasse', 'CP 389, 9116 Tempus Rd.', '10200', 'Perth', 'Malta', '07 54 91 38 05', 'Phasellus.dolor.elit@tempus.edu', 1, 1),
(6, 108, 70, 'Appartement 240-2918 Purus Rd.', 'Appartement 110-7825 Nec Chemin', '23366-79737', 'Rosolini', 'Netherlands', '01 87 15 25 19', 'semper@aliquetmolestie.net', 0, 1),
(7, 172, 80, '1264 At, Route', '876-5234 Dictum Route', '688568', 'Crieff', 'South Africa', '01 21 55 87 61', 'facilisi@sempercursus.edu', 0, 0),
(8, 85, 100, 'Appartement 820-7912 Lectus, Rue', '291-3610 Phasellus Avenue', '15430', 'Elektrougli', 'Bermuda', '09 06 40 01 60', 'sagittis.semper@loremtristiquealiquet.net', 1, 0),
(9, 79, 40, 'Appartement 609-3392 Blandit Av.', 'Appartement 380-2385 Erat Impasse', '61-471', 'Kediri', 'Fiji', '05 29 40 48 13', 'eleifend.vitae.erat@eu.net', 1, 0),
(10, 26, 20, 'Appartement 351-347 Tellus Chemin', 'CP 786, 1315 Lectus, Route', '56373', 'Heppignies', 'Marshall Islands', '01 42 06 86 99', 'primis.in@nec.net', 1, 1),
(11, 42, 70, 'CP 725, 4002 Auctor, Impasse', '5600 Sapien. Av.', '04204', 'Orciano Pisano', 'Bahamas', '05 00 49 30 56', 'nisi.a.odio@vel.com', 0, 0),
(12, 150, 20, '356-9357 Suspendisse Ave', 'Appartement 765-6393 Feugiat Route', 'Z3403', 'Norwich', 'Romania', '03 70 70 86 46', 'ac@ullamcorper.ca', 1, 1),
(13, 190, 20, 'CP 225, 728 Nisi Ave', 'CP 460, 4079 Ligula. Ave', '71835-515', 'Pemberton', 'Benin', '07 89 68 84 75', 'Pellentesque@mollisInteger.co.uk', 1, 0),
(14, 122, 10, '9909 Varius Chemin', 'CP 959, 9861 Porta Avenue', 'GY9A 3PJ', 'Peine', 'Northern Mariana Islands', '05 02 70 56 76', 'metus.urna.convallis@adipiscingenimmi.ca', 1, 0),
(15, 117, 50, '120-3840 Donec Chemin', 'Appartement 673-6537 Convallis Route', '18355', 'Kapuskasing', 'Falkland Islands', '03 06 25 32 46', 'mattis.semper.dui@justoProin.ca', 0, 1),
(16, 118, 90, 'Appartement 803-897 Mus. Avenue', 'CP 701, 4348 Lacus, Route', '17133', 'Bondo', 'Bhutan', '09 71 76 62 20', 'lobortis.quis@Nullamvelit.ca', 0, 1),
(17, 196, 80, 'CP 575, 8938 Consequat Av.', '3901 Felis Ave', '6198', 'San Rafael', 'Korea, South', '08 74 15 00 85', 'lobortis@DonecegestasDuis.com', 1, 0),
(18, 81, 50, 'CP 384, 1880 Pretium Rd.', '9291 Volutpat Av.', '704428', 'Bal‰tre', 'Estonia', '06 65 64 93 05', 'lacus.Mauris.non@nec.com', 1, 0),
(19, 11, 40, 'CP 225, 6256 Nam Route', '6473 A Chemin', 'Z0535', 'Montbéliard', 'Liberia', '02 36 63 60 15', 'lorem.fringilla.ornare@eu.co.uk', 0, 0),
(20, 205, 30, '987-1266 Donec Route', '139-7105 Luctus. Rue', '432702', 'Dollard-des-Ormeaux', 'Australia', '06 10 02 40 15', 'quis.diam@vitae.ca', 0, 0),
(21, 148, 80, 'CP 485, 8922 Mauris Ave', '164-6756 Metus Impasse', '68189', 'San Giovanni la Punta', 'Denmark', '04 40 48 81 61', 'feugiat.non.lobortis@mollis.edu', 1, 0),
(22, 6, 80, '1720 Nascetur Impasse', 'CP 898, 1537 Hendrerit Route', '5296', 'Precenicco', 'Ireland', '02 91 95 55 92', 'libero.Integer.in@velitduisemper.com', 0, 0),
(23, 109, 80, 'Appartement 704-5705 Faucibus Rue', 'CP 510, 3414 Ligula Route', 'LA0S 3YZ', 'Palanzano', 'Western Sahara', '01 53 89 07 89', 'vulputate.nisi@Nuncquis.org', 0, 1),
(24, 27, 10, '393-5358 Phasellus Rue', '5874 Cursus Ave', '45441', 'Cupar', 'Sri Lanka', '08 08 18 86 29', 'molestie.tellus.Aenean@faucibusleoin.edu', 0, 1),
(25, 5, 10, 'CP 387, 2837 Integer Chemin', '8758 Erat. Av.', '28827', 'Bayswater', 'Marshall Islands', '06 68 96 77 65', 'erat.Etiam@vitae.co.uk', 1, 1),
(26, 164, 20, 'Appartement 497-3868 Quis Ave', '125 At Ave', '38025', 'LaSalle', 'Greece', '07 83 79 81 40', 'augue.eu.tellus@natoque.edu', 1, 0),
(27, 154, 100, '642-4553 Lorem, Avenue', 'CP 899, 4608 Nunc Impasse', '652457', 'Ukkel', 'Taiwan', '08 47 42 38 12', 'dis.parturient@orci.com', 1, 1),
(28, 173, 100, 'CP 304, 4358 Adipiscing Av.', 'CP 704, 8360 Egestas Avenue', '71068', 'Girardot', 'Zimbabwe', '07 12 58 31 27', 'eu@dapibusidblandit.ca', 1, 1),
(29, 76, 80, 'Appartement 880-5192 Consequat Rd.', '9382 Velit Ave', '63860', 'Alanya', 'French Polynesia', '07 09 72 08 25', 'Aenean@lectus.org', 0, 0),
(30, 129, 50, '295-1133 Quis, Chemin', '300 Tincidunt Rue', '09144', 'Chetwynd', 'Czech Republic', '04 54 08 41 94', 'aliquam.enim@Pellentesquehabitant.edu', 0, 1),
(31, 173, 20, '642-6515 Quis Rd.', 'CP 562, 730 Tristique Rd.', 'Z8386', 'Graz', 'Maldives', '07 43 80 39 64', 'dis.parturient.montes@Donec.edu', 0, 1),
(32, 184, 80, '8231 Est, Av.', 'Appartement 470-3620 In Ave', '10114', 'Eindhout', 'Monaco', '03 52 20 87 85', 'Donec.sollicitudin@consequatpurusMaecenas.com', 1, 1),
(33, 131, 50, '7856 Mauris Chemin', 'CP 526, 5943 Lorem Chemin', 'OF5B 5XH', 'Okotoks', 'Hungary', '01 05 93 43 80', 'tincidunt.tempus@vestibulumneque.net', 0, 1),
(34, 164, 20, '211-6180 Vel Avenue', 'Appartement 183-2899 A Chemin', '35921', 'Bolsward', 'Congo (Brazzaville)', '08 56 65 41 80', 'Phasellus.dolor.elit@velturpis.net', 1, 1),
(35, 63, 100, '441-6184 Cras Chemin', 'CP 253, 2518 Venenatis Ave', '299028', 'Castanhal', 'Aruba', '06 86 39 08 20', 'nonummy.ipsum@pharetraut.com', 0, 1),
(36, 74, 40, 'CP 955, 2116 Risus. Route', 'CP 318, 3742 Nunc Chemin', '1637', 'Cap-Saint-Ignace', 'Netherlands', '05 07 04 78 86', 'elit.erat.vitae@ut.net', 1, 0),
(37, 35, 20, 'Appartement 263-5508 Rhoncus. Chemin', '2580 Etiam Av.', '94201', 'Morro Reatino', 'Somalia', '04 42 95 67 69', 'quis.pede.Suspendisse@urnajusto.co.uk', 0, 1),
(38, 190, 20, '8503 Luctus Avenue', 'CP 614, 5824 Eget Impasse', '64544', 'Navojoa', 'Malaysia', '07 13 50 26 85', 'semper.pretium.neque@luctus.net', 0, 0),
(39, 155, 80, 'CP 843, 9173 In Chemin', 'CP 944, 1595 Ac Impasse', '12208', 'Illkirch-Graffenstaden', 'Egypt', '04 99 86 45 35', 'Donec.porttitor@mauris.ca', 0, 0),
(40, 29, 90, 'Appartement 604-4849 At Rd.', '577-5866 Molestie Ave', 'Z0471', 'Leduc', 'Taiwan', '02 02 94 58 03', 'non.bibendum.sed@pulvinararcu.net', 1, 0),
(41, 56, 50, 'CP 274, 4897 Eget, Chemin', 'Appartement 338-3617 Pretium Chemin', 'N8N 3L7', 'Builth Wells', 'Croatia', '05 34 69 16 33', 'amet@velitSed.edu', 0, 1),
(42, 69, 80, '2382 Commodo Ave', 'CP 363, 2593 Nec Route', '490393', 'Valera Fratta', 'British Indian Ocean Territory', '08 86 91 63 23', 'tincidunt.tempus@Curabitur.edu', 1, 0),
(43, 153, 10, '5047 Mi Ave', 'CP 723, 3632 Felis Route', '71105', 'Esneux', 'Azerbaijan', '01 94 78 46 10', 'felis.orci.adipiscing@elitpede.org', 1, 1),
(44, 166, 20, '745-6185 Nec Av.', 'CP 312, 6775 Ullamcorper. Chemin', '6059 UP', 'Bogor', 'British Indian Ocean Territory', '04 72 67 99 89', 'vulputate@semut.net', 0, 0),
(45, 75, 90, 'CP 809, 3926 Arcu. Av.', 'Appartement 306-3828 Sit Ave', '956358', 'Barrow-in-Furness', 'Papua New Guinea', '06 30 28 47 78', 'libero.et@nislsemconsequat.com', 0, 1),
(46, 92, 60, 'Appartement 461-1505 Ultricies Chemin', 'Appartement 286-8395 Cursus. Impasse', '42708', 'Strathcona County', 'Sudan', '06 68 05 59 82', 'parturient.montes.nascetur@Quisquevarius.co.uk', 1, 0),
(47, 78, 80, 'CP 498, 352 A Av.', 'Appartement 976-7293 Dapibus Route', 'Z2438', 'Lesve', 'Cocos (Keeling) Islands', '02 49 56 36 88', 'Nunc.commodo@interdum.net', 1, 1),
(48, 57, 30, 'Appartement 802-2118 Cursus Route', 'Appartement 843-2885 Rhoncus. Rd.', '914223', 'Grangemouth', 'Trinidad and Tobago', '05 73 17 25 82', 'purus.Duis@orciinconsequat.com', 0, 1),
(49, 62, 50, 'CP 273, 5159 Phasellus Avenue', '7140 Nascetur Ave', '64247-877', 'Salamanca', 'Chile', '01 08 19 91 41', 'posuere.vulputate.lacus@gravidamaurisut.co.uk', 1, 0),
(50, 169, 40, '9217 Amet, Rue', 'CP 206, 1555 Est Route', '8440', 'Bientina', 'Somalia', '03 95 49 58 00', 'rutrum.magna@idante.net', 1, 1),
(51, 75, 90, '4170 Neque Route', '294-540 Tincidunt Impasse', '61579-061', 'Leers-et-Fosteau', 'Uzbekistan', '03 15 48 88 55', 'Pellentesque.habitant@mollisdui.net', 1, 1),
(52, 52, 10, 'CP 130, 2032 In, Impasse', 'Appartement 580-3489 Eu Rd.', '35914', 'Klemskerke', 'Micronesia', '07 59 45 48 61', 'lectus.pede@eget.co.uk', 0, 0),
(53, 125, 50, '8369 Non Impasse', 'Appartement 280-2023 Vestibulum Rue', '23637', 'Sainte-Flavie', 'Poland', '07 05 32 57 01', 'turpis.vitae.purus@mauris.ca', 0, 1),
(54, 18, 90, '278-6717 Risus. Chemin', 'CP 533, 9933 Ipsum. Impasse', '17260', 'Puno', 'Finland', '07 83 53 97 97', 'ipsum.dolor@vulputatemaurissagittis.net', 1, 0),
(55, 70, 80, 'CP 951, 4640 Amet Av.', 'Appartement 158-3146 Iaculis Ave', '13288', 'Bismil', 'Mauritania', '04 78 31 92 12', 'nulla.at@natoquepenatibus.edu', 1, 1),
(56, 49, 50, '811-8415 Dolor Rue', 'CP 917, 525 Vitae Impasse', '84265-18541', 'Adelaide', 'Georgia', '08 52 81 09 65', 'accumsan.laoreet.ipsum@ametconsectetueradipiscing.org', 0, 0),
(57, 200, 10, 'Appartement 501-6327 Nisi Avenue', '6074 Sagittis Impasse', '10336-62781', 'Fernie', 'Monaco', '07 35 49 55 60', 'vehicula@leoMorbineque.co.uk', 1, 0),
(58, 179, 90, '376-3290 Molestie Ave', '9613 Malesuada Av.', '00271', 'Alençon', 'Puerto Rico', '03 11 58 72 22', 'enim@magnased.com', 0, 0),
(59, 24, 30, '5592 Nisl Rd.', 'CP 944, 4904 Pulvinar Rd.', 'Y3L 2Z4', 'Neiva', 'Swaziland', '05 65 06 82 98', 'eu.eleifend@eutempor.com', 1, 1),
(60, 85, 50, 'CP 401, 3232 Parturient Rue', '4434 Diam Av.', '5384 OE', 'Roccamena', 'Netherlands', '03 94 00 93 51', 'Donec.egestas@orciconsectetuereuismod.ca', 1, 1),
(61, 79, 40, '8459 Sem Ave', '3692 Risus. Chemin', '33030', 'Kielce', 'Namibia', '08 44 88 73 21', 'non@pedeet.co.uk', 0, 0),
(62, 63, 10, 'CP 439, 6617 Amet Avenue', 'CP 847, 5733 Neque. Impasse', '6926', 'Casole d\'Elsa', 'Spain', '02 65 99 46 61', 'arcu@semmollisdui.ca', 0, 0),
(63, 94, 30, '5811 Taciti Rd.', '132-7235 Erat. Avenue', 'SK5 8LH', 'Wellingborough', 'Georgia', '05 51 53 74 38', 'ut.mi.Duis@loremsemperauctor.com', 0, 1),
(64, 122, 100, '509-9774 Et, Rue', '9750 Ornare Av.', '356840', 'Dégelis', 'Sint Maarten', '07 14 69 91 92', 'tortor.Nunc.commodo@eu.net', 1, 1),
(65, 109, 40, '937-3888 Nec Impasse', 'Appartement 397-5209 Nec Rd.', '96555', 'Cumberland County', 'Ghana', '04 75 05 95 96', 'Nulla@faucibus.org', 0, 1),
(66, 163, 50, 'Appartement 909-5955 Fringilla Rue', 'Appartement 613-7893 Dui Impasse', '99851', 'Brisbane', 'Tuvalu', '05 70 37 40 21', 'Nam.interdum.enim@rutrumloremac.com', 0, 1),
(67, 6, 10, 'Appartement 130-7004 Ipsum Av.', 'Appartement 530-4262 Nunc Impasse', '4527 VA', 'Newark', 'Luxembourg', '04 55 88 95 80', 'Proin@sodalesMaurisblandit.com', 1, 1),
(68, 16, 10, 'CP 471, 6035 Eu Chemin', 'Appartement 100-2799 Ac Ave', '05270', 'Mackay', 'Senegal', '08 73 96 85 69', 'arcu.Vivamus.sit@ametnullaDonec.edu', 0, 1),
(69, 138, 20, 'Appartement 115-4656 Nec Rue', 'Appartement 806-8706 Non Chemin', '216120', 'North Vancouver', 'Libya', '04 08 25 92 98', 'ultricies.sem@Sed.edu', 0, 1),
(70, 127, 30, '7211 Ipsum Route', 'Appartement 216-6204 Primis Ave', '946049', 'Tiel', 'Bolivia', '08 27 64 80 42', 'rhoncus.Nullam.velit@luctusetultrices.co.uk', 1, 0),
(71, 134, 60, '745-1636 Cras Chemin', 'Appartement 370-6344 Montes, Impasse', 'Y6Q 3EN', 'Dos Hermanas', 'India', '03 37 79 31 54', 'ante.dictum@sitametconsectetuer.edu', 1, 1),
(72, 133, 100, 'CP 418, 9689 Elit, Rd.', '783-1925 At, Chemin', '811128', 'Lasbela', 'Norfolk Island', '01 07 01 72 85', 'magna.Lorem@sodales.ca', 1, 1),
(73, 15, 100, 'CP 414, 8280 Et, Ave', '3427 Quis, Ave', '82649-485', 'Blankenberge', 'Latvia', '03 11 32 20 17', 'nec@InfaucibusMorbi.co.uk', 0, 0),
(74, 193, 60, 'CP 998, 1140 Velit. Route', 'CP 642, 9450 Varius Av.', '99-803', 'Gijzegem', 'Korea, South', '09 92 64 87 14', 'quis@dictumcursus.co.uk', 0, 0),
(75, 19, 80, '1273 At Impasse', '3255 Tortor, Avenue', '967285', 'Liernu', 'Uzbekistan', '02 35 62 06 02', 'primis.in@DonecegestasDuis.edu', 1, 0),
(76, 130, 50, '660-3773 Mollis Ave', '851-167 Sem, Ave', '1937', 'Hulshout', 'Sri Lanka', '08 55 50 09 63', 'magna@eulacus.ca', 0, 0),
(77, 187, 70, 'CP 913, 9083 Morbi Chemin', 'Appartement 170-6529 Diam Ave', '7390', 'Shawville', 'Equatorial Guinea', '02 13 35 72 35', 'ipsum.primis@duiCumsociis.com', 1, 0),
(78, 75, 30, 'CP 315, 8032 Auctor Avenue', 'Appartement 246-5264 Congue. Rd.', '22305', 'Quesada', 'American Samoa', '05 70 35 48 83', 'quis.massa@ultricies.com', 0, 1),
(79, 114, 90, '284 Integer Rue', 'CP 298, 1726 Primis Av.', '3811', 'Itagüí', 'Cambodia', '07 70 74 83 59', 'lobortis.mauris.Suspendisse@sem.com', 0, 0),
(80, 46, 50, '796-519 Est, Ave', '6062 Amet Ave', 'YS37 4EW', 'Forbach', 'Mayotte', '03 38 17 33 39', 'urna.Vivamus@cursusluctusipsum.org', 1, 1),
(81, 150, 50, 'CP 699, 2716 Iaculis Ave', '938-5924 Adipiscing Route', '6034', 'Walhain-Saint-Paul', 'Palestine, State of', '04 88 18 78 45', 'aptent@loremtristiquealiquet.ca', 0, 0),
(82, 22, 10, 'Appartement 937-1569 Scelerisque, Rue', '4631 Mi. Impasse', 'M1K 6Z5', 'Posina', 'Montserrat', '06 51 04 51 45', 'tellus@ligulatortordictum.ca', 1, 0),
(83, 165, 20, 'Appartement 638-9099 Velit. Route', '4253 Faucibus Chemin', 'L3 9RU', 'LouveignŽ', 'Equatorial Guinea', '02 41 37 59 19', 'adipiscing.elit@penatibusetmagnis.ca', 1, 0),
(84, 14, 30, '516-9578 Dapibus Rue', '273-7341 Ipsum Rue', '30102', 'Belgrade', 'Burkina Faso', '02 57 72 77 02', 'amet.consectetuer@nonummy.net', 0, 0),
(85, 98, 70, 'CP 882, 9330 Vitae Ave', '934-2767 Scelerisque Impasse', '30902', 'Silius', 'Laos', '06 83 44 33 17', 'eu.dui.Cum@at.org', 1, 1),
(86, 35, 80, '349-2443 Erat. Av.', '1828 Pellentesque Rue', '61348', 'Trivandrum', 'Latvia', '06 00 73 78 02', 'turpis@eu.ca', 1, 0),
(87, 153, 20, '876 Cras Impasse', 'CP 924, 6391 Sapien Impasse', '61-245', 'Hope', 'Bermuda', '03 37 43 64 96', 'justo.Praesent@Utsagittislobortis.edu', 1, 0),
(88, 35, 60, '977-2264 Dis Rd.', 'CP 436, 2465 Tincidunt Av.', '959706', 'Frauenkirchen', 'Eritrea', '05 35 00 44 52', 'pede.Cras.vulputate@sagittis.co.uk', 1, 0),
(89, 13, 100, '1353 Mollis Av.', 'CP 539, 816 Enim Impasse', '565251', 'Fresno', 'Reunion', '02 50 23 30 73', 'blandit.at@etlibero.edu', 0, 1),
(90, 6, 10, '5872 Pede. Avenue', 'CP 175, 8382 Malesuada Chemin', '85-085', 'Wepion', 'Lithuania', '02 78 71 95 45', 'nec@eu.edu', 0, 0),
(91, 126, 70, 'Appartement 771-3678 Senectus Chemin', 'Appartement 173-7604 Ante Route', '11938', 'Alviano', 'Heard Island and Mcdonald Islands', '03 60 50 31 67', 'Donec.porttitor@penatibusetmagnis.net', 1, 0),
(92, 206, 40, 'CP 681, 7801 Sit Impasse', '651-8595 Feugiat Avenue', '22-275', 'Punitaqui', 'Romania', '05 35 15 73 84', 'diam.Proin.dolor@Suspendisse.net', 1, 0),
(93, 61, 60, 'Appartement 908-1264 Pellentesque. Rd.', 'CP 607, 2329 Ornare Chemin', '50918', 'As', 'San Marino', '07 47 25 40 83', 'Quisque.ornare@varius.com', 1, 1),
(94, 166, 50, 'Appartement 130-4689 Neque Rd.', 'CP 112, 4289 Donec Rd.', '30459', 'San Cesario di Lecce', 'Chad', '03 48 32 62 17', 'non.ante.bibendum@aliquamenim.org', 1, 0),
(95, 143, 40, '914-3597 Dignissim Impasse', 'CP 201, 9303 Eu Rd.', '6256', 'Bierk Bierghes', 'Gambia', '08 03 39 03 49', 'luctus@lectusasollicitudin.co.uk', 1, 1),
(96, 200, 70, 'Appartement 201-7673 Cursus Avenue', '1981 Metus. Av.', '1909', 'Jaranwala', 'Kazakhstan', '09 29 60 97 30', 'tellus.eu@sociis.org', 1, 0),
(97, 153, 100, '715-9474 Pellentesque Chemin', 'Appartement 732-6610 Aliquam Route', '21376', 'Smolensk', 'Taiwan', '03 03 14 80 22', 'Curae.Donec@id.net', 0, 0),
(98, 66, 50, '8920 Arcu. Route', 'Appartement 369-554 Cras Ave', '54536', 'Zona Bananera', 'Slovenia', '03 29 15 44 38', 'nec.eleifend@augueutlacus.ca', 1, 0),
(99, 19, 40, 'Appartement 291-432 Leo, Route', '9285 Ligula. Impasse', '9233', 'Kędzierzyn-Koźle', 'Algeria', '02 45 49 51 25', 'vitae@Nunc.edu', 0, 0),
(100, 69, 10, '7423 Eu Ave', '431-5147 Duis Route', '66777', 'Bucaramanga', 'Montserrat', '02 09 18 69 90', 'tellus.faucibus.leo@lectus.co.uk', 1, 1),
(101, 180, 50, 'Appartement 608-5829 Adipiscing Rd.', '4242 Eu Av.', '512782', 'Santomenna', 'United States Minor Outlying Islands', '02 28 21 55 34', 'est.Nunc.ullamcorper@gravida.com', 1, 1),
(102, 33, 50, '4138 Curae; Rd.', 'CP 304, 437 Risus. Route', '545714', 'Brussel X-Luchthaven Remailing', 'Cameroon', '07 47 15 03 86', 'rutrum@aodiosemper.edu', 1, 1),
(103, 20, 100, '587-4431 Nulla. Chemin', 'Appartement 876-4764 Ut, Av.', '48-232', 'Hampstead', 'Georgia', '02 00 05 96 05', 'Aliquam.gravida.mauris@Proinnonmassa.edu', 1, 1),
(104, 57, 70, '413-3481 Eu Chemin', 'Appartement 124-600 Sed Av.', '75776-81285', 'Santomenna', 'Morocco', '08 86 63 26 19', 'tempus@scelerisqueduiSuspendisse.ca', 0, 1),
(105, 46, 10, 'KR', 'Appartement 745-7745 Id Route', '5077', 'Milnathort', 'Kiribati', '08 14 43 56 85', 'nonummy.Fusce.fermentum@antedictum.ca', 1, 0),
(106, 19, 40, 'N.', 'CP 238, 8643 Quis Avenue', '7162', 'Oosterhout', 'Luxembourg', '03 17 53 36 20', 'luctus.et@odiosempercursus.net', 1, 0),
(107, 202, 10, 'Chu', '1394 Convallis Rd.', '4805', 'Jecheon', 'Macao', '05 82 43 39 33', 'cursus@quisdiamPellentesque.co.uk', 0, 0),
(108, 45, 90, 'MP', '208-432 Nullam Rd.', '66565', 'Kraków', 'Egypt', '05 44 16 97 88', 'Fusce.fermentum.fermentum@massa.net', 1, 0),
(109, 23, 20, 'JT', 'CP 672, 958 Mi Avenue', '19611-126', 'Semarang', 'Austria', '09 81 25 86 49', 'vel.pede.blandit@Inatpede.com', 1, 1),
(110, 128, 10, 'New South Wales', '390-1137 Morbi Rd.', '530216', 'Bathurst', 'El Salvador', '07 61 62 04 51', 'nec.eleifend.non@tristiquesenectuset.ca', 1, 1),
(111, 128, 70, 'Vladimir Oblast', 'CP 343, 1186 Phasellus Chemin', '22939', 'Vladimir', 'Zimbabwe', '08 77 40 93 54', 'placerat@malesuada.edu', 0, 1),
(112, 198, 20, 'CDM', 'CP 206, 8488 Accumsan Rd.', '19466', 'Mexico City', 'Kazakhstan', '03 57 61 92 36', 'dolor@magnamalesuadavel.net', 1, 1),
(113, 92, 30, 'BC', '6596 Egestas Rd.', '23782', 'Hudson\'s Hope', 'India', '09 11 04 25 06', 'mauris.sapien.cursus@nulla.edu', 0, 0),
(114, 47, 20, 'Alajuela', 'CP 493, 9826 Sed Ave', '671739', 'Alajuela', 'Christmas Island', '09 56 93 14 35', 'Pellentesque@Uttincidunt.co.uk', 1, 1),
(115, 201, 20, 'Swiętokrzyskie', 'CP 805, 9385 Donec Rd.', '25237', 'Starachowice', 'Tonga', '07 67 95 16 16', 'lacus@neceuismod.org', 1, 0),
(116, 60, 80, 'Vienna', '284-3785 Feugiat Route', '9554', 'Vienna', 'French Southern Territories', '01 39 01 32 98', 'magna.Nam@imperdietornare.co.uk', 0, 1),
(117, 53, 70, 'Västra Götalands län', 'CP 476, 7739 Nascetur Impasse', '32005', 'Vänersborg', 'Bouvet Island', '05 37 05 97 16', 'elit.Curabitur@euismodmauriseu.co.uk', 1, 1),
(118, 45, 100, 'Berlin', '9676 Orci. Route', '38062-261', 'Berlin', 'Thailand', '03 38 07 57 60', 'tempus@pede.edu', 1, 1),
(119, 192, 70, 'Western Australia', 'CP 309, 366 Nec Ave', '4547', 'Albany', 'Qatar', '08 87 23 13 74', 'tortor@quismassa.edu', 1, 1),
(120, 58, 90, 'Bolívar', 'CP 960, 3797 Quis, Ave', '11012', 'Magangué', 'Botswana', '01 82 25 81 16', 'adipiscing.lacus@tempusnon.net', 1, 0),
(121, 194, 90, 'N.', '7035 Amet, Impasse', '583153', 'Naarden', 'Argentina', '02 50 11 98 73', 'gravida@ipsumnunc.net', 0, 1),
(122, 187, 30, 'Ohio', '101-7223 Ipsum Ave', '63005', 'Cincinnati', 'El Salvador', '09 30 10 51 83', 'rutrum.magna.Cras@nibhQuisquenonummy.co.uk', 1, 1),
(123, 104, 50, 'RM', 'Appartement 697-4621 Dui Rd.', '53451', 'Lo Barnechea', 'Curaçao', '02 07 74 64 17', 'pharetra@arcuac.org', 0, 0),
(124, 30, 100, 'Vienna', 'Appartement 811-2212 Ultrices. Ave', '3668', 'Vienna', 'Namibia', '04 31 09 79 21', 'quis.pede@senectus.co.uk', 1, 0),
(125, 116, 90, 'Alaska', '3582 Sapien Rue', '979649', 'Ketchikan', 'Lesotho', '06 25 35 69 04', 'enim@at.ca', 1, 1),
(126, 137, 60, 'Wyoming', 'Appartement 693-7442 Nulla Route', '750745', 'Cheyenne', 'Saint Pierre and Miquelon', '01 74 17 28 84', 'et@Vivamus.ca', 1, 0),
(127, 74, 40, 'NI', '183-7429 Sollicitudin Av.', '54621-509', 'Minna', 'Italy', '02 84 69 73 46', 'sem.ut@loremluctus.org', 1, 0),
(128, 4, 80, 'BC', '7279 Nullam Avenue', '00248', 'Surrey', 'Paraguay', '09 19 17 18 98', 'et.ipsum@lobortistellusjusto.edu', 0, 1),
(129, 24, 40, 'North Island', '6828 Quisque Impasse', '41649', 'Waiheke Island', 'France', '01 38 96 38 96', 'semper.Nam.tempor@Sed.org', 0, 0),
(130, 61, 80, 'OR', 'CP 904, 5240 Dictum. Rd.', 'Z6544', 'Raurkela Civil Township', 'Lesotho', '07 30 61 36 22', 'quam.Curabitur@duisemperet.edu', 0, 1),
(131, 35, 90, 'LX', '670-3174 Nibh Rue', '40641', 'Lamorteau', 'Falkland Islands', '02 49 72 11 44', 'Donec.elementum.lorem@egestasurna.com', 0, 1),
(132, 26, 60, 'Hawaii', '471-9596 Dolor. Chemin', '440087', 'Kailua', 'Venezuela', '03 77 11 01 90', 'mauris@sollicitudin.net', 1, 1),
(133, 180, 60, 'BE', '421-8638 Porta Route', '75312', 'Berlin', 'Aruba', '09 16 82 67 25', 'cursus.a@scelerisquenequeNullam.net', 1, 1),
(134, 97, 70, 'Gan', '233-7172 Dis Ave', '94-173', 'Chuncheon', 'Saudi Arabia', '07 83 19 24 88', 'sed.tortor.Integer@sapienCras.net', 0, 1),
(135, 78, 40, 'SK', 'Appartement 336-9360 In Chemin', '653970', 'Moose Jaw', 'Djibouti', '04 17 49 04 44', 'dictum.Phasellus@Curabitur.com', 0, 1),
(136, 97, 20, 'Gyeonggi', '933-3008 Nulla Ave', '86107', 'Ansan', 'Niue', '01 78 09 25 25', 'eros.nec.tellus@magna.com', 1, 1),
(137, 157, 10, 'O\'Higgins', '142-6987 Hendrerit Avenue', '937050', 'San Fernando', 'Ethiopia', '01 15 46 57 31', 'Praesent@facilisisloremtristique.edu', 0, 0),
(138, 28, 90, 'AN', 'CP 303, 9714 Sed Rue', '1180', 'Málaga', 'Namibia', '09 27 74 85 71', 'pharetra.Quisque@maurisipsumporta.co.uk', 1, 1),
(139, 10, 40, 'Madrid', 'Appartement 216-6752 Vestibulum. Route', '3881', 'Alcalá de Henares', 'Bhutan', '06 78 98 22 82', 'id@urna.co.uk', 0, 1),
(140, 177, 90, 'CH', 'CP 985, 7651 Odio Rd.', '7951', 'Wallasey', 'Bermuda', '03 98 09 50 89', 'velit@lorem.com', 0, 1),
(141, 197, 90, 'Pue', '978-1699 Dui, Avenue', '08560-849', 'Tehuacán', 'Kyrgyzstan', '06 99 08 71 36', 'rhoncus@tellusidnunc.co.uk', 1, 1),
(142, 17, 30, 'LD', 'Appartement 503-7923 Lacus. Route', '02143-847', 'Pabianice', 'Holy See (Vatican City State)', '05 20 32 90 94', 'eu@augue.edu', 0, 1),
(143, 25, 40, 'Kurgan Oblast', '743 Dictum Ave', '30317', 'Kurgan', 'Hungary', '02 22 51 37 34', 'felis@lectusasollicitudin.co.uk', 0, 0),
(144, 22, 40, 'GB', '742-5145 Nisl. Route', '78388-81656', 'Ghizer', 'Sierra Leone', '04 51 49 12 07', 'Morbi.vehicula.Pellentesque@Donecegestas.com', 0, 1),
(145, 42, 100, 'RI', '2697 Laoreet Rue', '17015', 'Buguma', 'Malaysia', '08 03 26 86 44', 'consectetuer.adipiscing.elit@velitSed.net', 1, 1),
(146, 209, 30, 'A', 'CP 149, 7384 Interdum Route', 'Z9732', 'Alajuela', 'Andorra', '08 12 06 93 48', 'pulvinar.arcu.et@nullaante.com', 0, 0),
(147, 47, 10, 'Alberta', 'Appartement 381-2861 Enim. Ave', '96360', 'Legal', 'Norway', '09 47 55 01 16', 'pede.Nunc.sed@velturpis.net', 1, 1),
(148, 144, 20, 'ANT', 'Appartement 929-2204 Ornare Ave', '56044', 'Rionegro', 'United Kingdom (Great Britain)', '08 94 09 09 88', 'non@feugiatmetussit.co.uk', 0, 0),
(149, 62, 50, 'SP', 'Appartement 155-6918 In Impasse', '224942', 'Campinas', 'France', '02 57 24 38 94', 'magna.nec.quam@asollicitudin.com', 1, 1),
(150, 113, 10, 'Cusco', '905-7197 Risus. Route', '7014 SP', 'Sicuani', 'French Polynesia', '06 17 49 91 68', 'Aenean.eget.magna@necmollis.net', 1, 0),
(151, 69, 40, 'FL', 'CP 850, 2785 Blandit Ave', '2312', 'Miami', 'Bonaire, Sint Eustatius and Saba', '06 96 75 69 00', 'quis.urna.Nunc@Maecenasliberoest.net', 1, 1),
(152, 126, 40, 'Florida', 'Appartement 659-8531 Sed, Ave', '380585', 'Jacksonville', 'Solomon Islands', '06 08 07 64 63', 'libero.at@eleifend.com', 1, 0),
(153, 47, 40, 'Cajamarca', '7727 Dolor Impasse', '1995 PF', 'Jaén', 'Slovakia', '01 74 35 42 76', 'orci@dictum.co.uk', 1, 0),
(154, 81, 10, 'SP', '569-9306 Integer Ave', '64452', 'Carapicuíba', 'Djibouti', '05 69 07 88 57', 'Aenean.eget@loremvitae.co.uk', 0, 0),
(155, 129, 70, 'Jeo', '2438 Blandit Ave', '11206', 'Mokpo', 'Micronesia', '06 13 13 04 43', 'tempor.est@Phasellusin.com', 1, 1),
(156, 95, 10, 'AP', '6685 Ac Ave', '49196', 'Vishakhapatnam', 'Portugal', '09 11 95 69 77', 'elit.pede@lectusCumsociis.co.uk', 1, 1),
(157, 26, 90, 'New Brunswick', '5294 Donec Chemin', '76-384', 'Saint-L�onard', 'Russian Federation', '07 63 36 24 20', 'in.dolor@aduiCras.com', 0, 1),
(158, 33, 40, 'North Island', '6709 Urna Ave', '72-108', 'Porirua', 'Bolivia', '01 12 10 62 70', 'cursus.purus@eu.edu', 1, 0),
(159, 16, 50, 'Overijssel', 'Appartement 569-2621 Mollis. Chemin', '0097 KK', 'Hengelo', 'San Marino', '07 38 61 87 64', 'iaculis.odio@leoelementum.net', 0, 0),
(160, 190, 20, 'Gan', 'CP 669, 8400 Sit Avenue', '08695', 'Chuncheon', 'Sweden', '08 37 68 41 56', 'neque.Sed@Aliquam.com', 0, 0),
(161, 140, 90, 'Michoacán', '954-5057 Non Chemin', '109957', 'Morelia', 'Saint Kitts and Nevis', '02 60 17 81 60', 'ac.turpis@Nullatempor.com', 1, 1),
(162, 83, 10, 'CAJ', 'CP 748, 1343 Auctor, Ave', '2346', 'Jaén', 'Barbados', '09 55 14 29 08', 'vestibulum.lorem@sapienAenean.edu', 1, 1),
(163, 39, 90, 'JI', 'Appartement 437-5812 At, Route', '8598', 'Dutse', 'Papua New Guinea', '03 24 16 44 44', 'senectus@Pellentesquehabitant.ca', 0, 0),
(164, 6, 40, 'TAM', '790 Consectetuer Rue', '3147', 'Tambov', 'Gambia', '06 38 46 21 67', 'eleifend@eratEtiam.co.uk', 1, 0),
(165, 94, 100, 'SAR', 'Appartement 151-126 Donec Rue', '7168', 'Saratov', 'Burkina Faso', '08 22 80 61 82', 'vulputate@Sednunc.edu', 0, 0),
(166, 16, 10, 'Cajamarca', '161-1556 Dignissim Impasse', '1847', 'Cajamarca', 'Tokelau', '05 55 67 17 59', 'lorem@iaculisaliquetdiam.org', 1, 1),
(167, 203, 20, 'MH', 'Appartement 317-2562 Eget Route', '30106', 'Ichalkaranji', 'Montenegro', '03 63 64 72 86', 'amet.risus.Donec@urnaVivamusmolestie.org', 0, 0),
(168, 126, 50, 'Alabama', 'Appartement 398-4051 Fames Rue', '461404', 'Tuscaloosa', 'Morocco', '03 65 57 52 41', 'at.libero.Morbi@Cras.org', 0, 0),
(169, 58, 70, 'WV', '2193 Orci, Chemin', '346317', 'Nieuwmunster', 'Jamaica', '05 44 85 23 44', 'blandit.viverra@ametluctusvulputate.org', 1, 1),
(170, 159, 20, 'RM', 'CP 961, 8118 Duis Ave', '569832', 'Padre Hurtado', 'Greenland', '09 84 34 90 30', 'iaculis.odio.Nam@felisadipiscing.org', 1, 1),
(171, 96, 100, 'Antioquia', '3479 Fermentum Chemin', 'X7R 3Y3', 'Rionegro', 'Honduras', '05 89 89 13 80', 'non.hendrerit.id@Ut.org', 0, 0),
(172, 11, 100, 'Atlántico', 'CP 708, 6911 Ligula Route', '81771', 'Malambo', 'Azerbaijan', '01 77 65 50 12', 'dapibus@pharetrasedhendrerit.co.uk', 0, 1),
(173, 44, 40, 'Ist', '156-7447 Non Route', 'Z5825', 'Istanbul', 'Finland', '01 02 13 07 69', 'est.mollis@loremegetmollis.ca', 0, 0),
(174, 37, 100, 'Mersin', '4706 At, Ave', '40596-552', 'Mersin', 'Gibraltar', '01 53 42 25 05', 'nunc@nislQuisque.org', 1, 1),
(175, 42, 70, 'OG', 'Appartement 460-9586 Imperdiet, Avenue', '3645', 'Sagamu', 'Afghanistan', '03 99 48 56 46', 'auctor.Mauris@penatibusetmagnis.com', 0, 0),
(176, 191, 80, 'N.', 'Appartement 914-6418 Tortor. Chemin', '30316', 'Breda', 'Mexico', '09 69 88 83 37', 'purus@accumsanlaoreet.edu', 1, 1),
(177, 125, 70, 'Gro', '2570 A Ave', '484856', 'Acapulco', 'Slovenia', '08 34 95 48 77', 'tellus.sem.mollis@ligula.ca', 1, 0),
(178, 180, 80, 'Kahramanmaraş', 'CP 901, 4622 Eu Av.', '5490', 'Elbistan', 'Australia', '02 69 66 33 07', 'Aliquam.rutrum.lorem@sed.edu', 1, 1),
(179, 207, 60, 'North Island', 'CP 258, 6738 Lacinia Rue', '27438', 'Napier', 'Libya', '03 78 72 08 31', 'quis.arcu@convallisligulaDonec.org', 0, 0),
(180, 118, 80, 'BA', '637-8489 Nunc Rd.', 'Z2381', 'Feira de Santana', 'Ukraine', '05 32 29 00 83', 'neque@habitant.ca', 0, 1),
(181, 103, 40, 'Ist', 'CP 353, 2103 Lacinia Ave', '20337', 'Istanbul', 'Bangladesh', '04 54 08 72 62', 'Ut@nislMaecenas.org', 1, 1),
(182, 13, 10, 'OR', '4128 Cras Impasse', '41866-323', 'Gresham', 'Northern Mariana Islands', '06 67 55 69 93', 'nec.urna@lectusante.net', 1, 0),
(183, 72, 10, 'Metropolitana de Santiago', '949-3014 Justo Impasse', '58387', 'San Miguel', 'Reunion', '07 79 96 95 15', 'blandit@tortornibh.co.uk', 0, 0),
(184, 101, 60, 'Vienna', '376-7715 Montes, Avenue', '17190', 'Vienna', 'Bermuda', '04 59 60 90 96', 'elementum@blanditNam.co.uk', 0, 0),
(185, 192, 100, 'PB', 'Appartement 986-6255 Vulputate, Route', '93443', 'Manokwari', 'Micronesia', '06 42 49 88 65', 'ac@vitae.com', 1, 1),
(186, 41, 20, 'Hgo', '857-3869 Eu Ave', '611004', 'Pachuca', 'Kuwait', '06 70 72 06 10', 'Morbi@Morbinequetellus.com', 1, 1),
(187, 121, 90, 'Nebraska', 'CP 515, 2632 Hendrerit Ave', 'Z6844', 'Grand Island', 'Togo', '06 74 60 39 00', 'tortor@dignissimMaecenasornare.edu', 0, 1),
(188, 176, 10, 'Bengkulu', '8439 Eget, Avenue', '21318', 'Bengkulu', 'Suriname', '01 27 05 51 54', 'rhoncus@nuncsed.net', 0, 1),
(189, 54, 60, 'Uttar Pradesh', '3049 Metus Av.', '1515', 'Jaunpur', 'Algeria', '09 18 26 86 95', 'Donec.egestas@liberonecligula.edu', 1, 0),
(190, 2, 80, 'Leinster', 'Appartement 564-7545 Et Rd.', '36852', 'Dublin', 'New Caledonia', '04 58 22 16 27', 'at.arcu.Vestibulum@vitae.ca', 0, 1),
(191, 21, 80, 'Berlin', '729-8650 Fringilla Rd.', '68356', 'Berlin', 'Wallis and Futuna', '08 37 73 14 94', 'Cum@ipsumdolor.net', 0, 0),
(192, 177, 30, 'Manitoba', '9969 Nec Impasse', '46099', 'Stonewall', 'Togo', '01 14 59 94 81', 'a@diameudolor.co.uk', 1, 1),
(193, 48, 20, 'WB', 'Appartement 980-6241 Eu Rue', '292850', 'Orp-Jauche', 'Mali', '07 43 19 25 76', 'interdum.Curabitur@dui.com', 0, 1),
(194, 17, 90, 'KLU', '961-6793 In Impasse', '7662 WB', 'Kaluga', 'Montenegro', '02 32 57 49 03', 'convallis.in.cursus@nibhQuisquenonummy.com', 1, 1),
(195, 181, 60, 'CUS', 'Appartement 615-6517 Luctus, Rd.', '3027 HN', 'Cusco', 'Azerbaijan', '04 77 20 72 54', 'Integer.vitae.nibh@tellus.org', 1, 1),
(196, 2, 50, 'KE', '2220 Erat Route', '156417', 'Greenwich', 'Bhutan', '07 74 03 46 78', 'scelerisque.scelerisque@vulputatemaurissagittis.net', 1, 0),
(197, 107, 40, 'PA', '3402 Class Route', '995869', 'Cholet', 'Niue', '09 44 20 14 74', 'metus.In.nec@condimentum.edu', 1, 0),
(198, 139, 30, 'Drenthe', 'CP 393, 4040 Convallis Impasse', 'V1A 4B6', 'Assen', 'Samoa', '05 79 09 37 90', 'mauris.id@estmauris.com', 0, 1),
(199, 15, 40, 'M', '928-8173 Dui. Route', '12747', 'Cork', 'Niger', '08 81 11 94 12', 'dictum.sapien.Aenean@cubiliaCuraePhasellus.org', 1, 0),
(200, 165, 60, 'Opolskie', '3021 Vel Rue', 'H7B 7X3', 'Opole', 'Mali', '03 34 15 99 55', 'lectus.a@rutrum.net', 0, 0),
(201, 107, 60, 'PA', '5501 Euismod Route', '5626', 'Allentown', 'Azerbaijan', '04 00 88 25 26', 'feugiat@turpis.com', 0, 1),
(202, 207, 100, 'N.', '118-1883 Non Route', '676053', 'Hoorn', 'Aruba', '07 99 16 79 20', 'molestie.sodales.Mauris@pharetraQuisqueac.com', 0, 0),
(203, 172, 80, 'WA', '554-9130 Ante Chemin', '892975', 'Stirling', 'Cayman Islands', '09 71 95 51 20', 'scelerisque.scelerisque.dui@enim.co.uk', 0, 0),
(204, 38, 100, 'ATL', 'CP 833, 7703 Mi, Rue', '2456', 'Malambo', 'Falkland Islands', '03 09 37 80 64', 'dolor.quam@Naminterdum.co.uk', 1, 0),
(205, 82, 10, 'Sindh', 'Appartement 438-8283 Risus. Rue', '9423', 'Umerkot', 'Antigua and Barbuda', '02 68 17 75 79', 'mi.Duis.risus@sitamet.co.uk', 1, 1),
(206, 204, 60, 'UP', 'Appartement 661-7138 Odio Av.', '679560', 'Firozabad', 'Afghanistan', '06 75 46 64 72', 'nisi.Aenean@scelerisque.ca', 1, 1),
(207, 44, 100, 'BE', '939-3564 Metus Avenue', '17834', 'Berlin', 'France', '05 36 19 39 59', 'Suspendisse.aliquet@nisl.co.uk', 1, 0),
(208, 143, 40, 'Kaduna', '215-2756 Tempus Ave', '68235-68461', 'Kaduna', 'South Georgia and The South Sandwich Islands', '04 11 15 88 47', 'adipiscing@ut.org', 1, 1),
(209, 90, 60, 'SP', 'Appartement 633-2012 Mauris Rd.', '229419', 'Diadema', 'Greece', '04 95 50 34 20', 'facilisis@ametmassa.net', 1, 0),
(210, 208, 40, 'Arkhangelsk Oblast', '227-9241 Semper Av.', '163267', 'Mirny', 'Netherlands', '05 53 55 31 94', 'enim@neceuismod.net', 0, 1),
(211, 3, 90, 'TAM', 'Appartement 100-2559 Nec, Impasse', '01406', 'Tambov', 'Lithuania', '07 07 57 98 09', 'ante@Etiam.co.uk', 0, 0),
(212, 110, 50, 'Cartago', '4377 Suspendisse Ave', '6421', 'San Nicolás', 'Martinique', '08 94 20 91 55', 'nec.tempus.scelerisque@scelerisqueloremipsum.co.uk', 0, 0),
(213, 152, 30, 'JK', '4839 Faucibus Rue', '56895-666', 'Jammu', 'French Southern Territories', '08 14 85 07 66', 'eu.ligula.Aenean@mus.edu', 0, 0),
(214, 172, 30, 'MI', '6231 Nulla. Rue', '8508', 'Flint', 'Saint Vincent and The Grenadines', '04 91 00 38 90', 'sagittis@magna.org', 1, 1),
(215, 199, 30, 'MA', '850-7854 Vel Route', '3264 ES', 'Siedlce', 'Slovakia', '09 45 92 82 78', 'In@ante.ca', 0, 1),
(216, 110, 80, 'ID', '742-8845 Vitae Chemin', 'V0W 0V0', 'Nampa', 'Ireland', '04 74 84 85 92', 'Nunc.lectus.pede@magnatellusfaucibus.co.uk', 0, 1),
(217, 109, 60, 'CE', '360-4722 Amet Avenue', '60921-014', 'Blois', 'Saint Lucia', '06 69 26 92 16', 'Duis.ac@diamDuismi.edu', 0, 1),
(218, 167, 20, 'SK', 'CP 750, 7393 Aenean Rue', '918663', 'Ostrowiec Świętokrzyski', 'Timor-Leste', '08 36 84 37 95', 'Aliquam.erat.volutpat@velvulputate.edu', 0, 0),
(219, 184, 70, 'TN', 'CP 486, 3221 Ac Route', '2546', 'Erode', 'Holy See (Vatican City State)', '08 07 81 05 18', 'amet.faucibus@egetmollis.edu', 1, 0),
(220, 161, 20, 'Wie', '745-9904 Cras Av.', '57561', 'Vienna', 'Slovakia', '05 69 51 63 44', 'non@musDonec.edu', 1, 0),
(221, 139, 60, 'Maryland', 'CP 646, 7322 Accumsan Ave', '5522', 'Frederick', 'Somalia', '06 15 66 18 45', 'dui@vitaeerat.edu', 0, 0),
(222, 170, 50, 'LO', '157 Aliquet Rue', '05-440', 'Montigny-lès-Metz', 'El Salvador', '03 18 93 13 07', 'auctor.odio.a@sapiengravidanon.net', 1, 0),
(223, 160, 90, 'O\'Higgins', 'CP 746, 5297 Lectus Rd.', '71706', 'Placilla', 'Laos', '09 58 08 93 30', 'tortor.Integer.aliquam@lectus.ca', 0, 0),
(224, 73, 90, 'Alabama', 'Appartement 612-1505 Urna Rd.', 'Z0266', 'Tuscaloosa', 'Uzbekistan', '03 61 55 71 86', 'gravida@tacitisociosqu.net', 1, 0),
(225, 206, 10, 'GA', 'CP 271, 7193 Augue Route', 'Z8409', 'Augusta', 'Papua New Guinea', '02 51 84 08 60', 'nisl.arcu@augue.org', 1, 0),
(226, 176, 20, 'Azad Kashmir', 'CP 683, 1308 Fames Chemin', '968612', 'Neelum Valley', 'Belgium', '03 95 88 33 69', 'consequat@adipiscing.com', 1, 1),
(227, 12, 10, 'CV', '843-2113 Risus. Av.', '10338', 'Torrevieja', 'Samoa', '01 84 14 73 35', 'ipsum.dolor@egestas.edu', 1, 0),
(228, 27, 30, 'Metropolitana de Santiago', 'Appartement 597-1874 Lorem Av.', '71311-036', 'Recoleta', 'Iceland', '05 59 50 58 50', 'mi@pedenonummy.net', 0, 1),
(229, 114, 40, 'NSW', '521 Adipiscing. Avenue', '10-691', 'Queanbeyan', 'Saint Helena, Ascension and Tristan da Cunha', '09 87 88 76 59', 'eu.placerat@neque.net', 1, 1),
(230, 31, 100, 'Uttar Pradesh', 'CP 708, 9118 Neque. Impasse', '35197-19208', 'Mathura', 'Antarctica', '08 74 37 52 62', 'neque.Nullam@atlibero.net', 1, 0),
(231, 11, 80, 'São Paulo', '132-2628 Iaculis Rd.', '2316', 'Ribeirão Preto', 'Costa Rica', '09 48 64 09 95', 'sem.Pellentesque.ut@scelerisquescelerisquedui.org', 1, 1),
(232, 96, 60, 'JB', '747 Ridiculus Impasse', '3666', 'Tasikmalaya', 'Peru', '08 11 64 04 57', 'Suspendisse.eleifend@dictumeueleifend.ca', 1, 0),
(233, 138, 10, 'Saratov Oblast', '131-3696 Et Rd.', '598785', 'Saratov', 'Kuwait', '02 16 39 19 85', 'quis@aliquet.net', 0, 0),
(234, 71, 60, 'Antioquia', 'CP 247, 1061 Magna Route', '5063', 'Apartadó', 'Kazakhstan', '01 20 41 55 76', 'non.quam@ac.ca', 0, 0),
(235, 93, 80, 'Emilia-Romagna', 'Appartement 490-8648 Fringilla Impasse', '87464-760', 'Poviglio', 'Antarctica', '02 79 03 80 50', 'fermentum.convallis@Aenean.com', 1, 1),
(236, 197, 20, 'Berlin', 'CP 807, 7249 Montes, Chemin', '02269', 'Berlin', 'Cyprus', '04 85 82 53 22', 'blandit@egestas.com', 1, 0),
(237, 165, 70, 'Nord-Pas-de-Calais', '8473 Adipiscing Rd.', '650444', 'Béthune', 'Heard Island and Mcdonald Islands', '02 79 34 73 47', 'amet@acfeugiat.edu', 0, 0),
(238, 117, 10, 'Henegouwen', 'CP 564, 7596 Ac Avenue', 'Z2149', 'BiercŽe', 'Thailand', '03 02 90 93 35', 'tincidunt.dui@lectus.net', 1, 1),
(239, 158, 30, 'Sindh', 'Appartement 498-7369 Aliquet Route', '61319', 'Nankana Sahib', 'Guinea-Bissau', '08 42 23 23 66', 'neque.tellus@mattis.com', 1, 1),
(240, 34, 60, 'MO', 'Appartement 636-9364 Dictum Ave', '67596-47609', 'Saint Louis', 'Montenegro', '01 10 74 90 76', 'Sed.malesuada.augue@facilisiseget.co.uk', 1, 0),
(241, 84, 40, 'Tyumen Oblast', '493 Parturient Chemin', '21900', 'Tyumen', 'Montenegro', '05 26 10 95 46', 'tempor.arcu.Vestibulum@eget.com', 1, 0),
(242, 89, 100, 'Kent', 'CP 341, 853 Morbi Ave', '76803', 'Canterbury', 'Singapore', '01 60 01 19 13', 'porttitor@fringilla.com', 1, 0),
(243, 35, 80, 'North Island', 'CP 280, 7522 Elit, Rue', '03-428', 'Cambridge', 'Sierra Leone', '08 83 02 73 08', 'Aenean@atortor.co.uk', 1, 0),
(244, 107, 60, 'SA', '4814 Erat Avenue', 'Z6478', 'Bridgnorth', 'Belize', '03 20 00 70 99', 'Fusce.mi.lorem@augue.edu', 1, 1),
(245, 23, 10, 'Maule', '500-2810 Sed Route', 'Z0884', 'Chanco', 'Brazil', '05 72 48 59 05', 'sapien.Cras@Integertincidunt.co.uk', 0, 0),
(246, 206, 10, 'Alsace', '719-5797 Enim, Chemin', '98493-155', 'Mulhouse', 'Trinidad and Tobago', '04 00 20 05 10', 'interdum.ligula.eu@ornareInfaucibus.co.uk', 0, 0),
(247, 26, 80, 'Ank', 'Appartement 136-7367 Eu Impasse', '6376 TH', 'Şereflikoçhisar', 'Norfolk Island', '08 72 50 75 48', 'lacus.Nulla.tincidunt@ametconsectetueradipiscing.com', 1, 1),
(248, 125, 60, 'IV', 'CP 660, 8367 Cras Avenue', '09489', 'Andacollo', 'Mexico', '09 85 95 22 35', 'mauris.elit.dictum@necmauris.net', 1, 0),
(249, 12, 50, 'Aquitaine', 'Appartement 264-6376 Nec Route', '979238', 'Périgueux', 'French Guiana', '06 88 91 01 92', 'sociis@sitamet.co.uk', 0, 0),
(250, 75, 20, 'Antioquia', 'Appartement 307-3968 Nec Chemin', '00863', 'Bello', 'Turkmenistan', '03 89 16 65 19', 'primis.in.faucibus@nibhlaciniaorci.net', 0, 1),
(251, 54, 20, 'UT', 'Appartement 581-1239 Nulla Ave', '17241', 'Salt Lake City', 'Estonia', '01 04 47 17 74', 'Vestibulum.ut@maurisid.co.uk', 0, 1),
(252, 157, 20, 'ATL', 'CP 197, 742 Mauris. Av.', '27156', 'Soledad', 'Syria', '05 70 45 88 31', 'sed@facilisis.net', 0, 0),
(253, 186, 80, 'BA', 'Appartement 635-1230 Enim, Rue', '27830', 'Buckie', 'Guinea-Bissau', '03 93 70 52 69', 'arcu@FuscemollisDuis.com', 1, 1),
(254, 190, 30, 'Vlaams-Brabant', 'Appartement 244-5052 Nec Avenue', '3473', 'Mollem', 'Nicaragua', '02 41 68 80 48', 'Nullam.suscipit@SuspendisseeleifendCras.co.uk', 1, 1),
(255, 201, 40, 'ERM', '5967 Sit Avenue', '890335', 'Modena', 'Thailand', '02 29 62 99 28', 'lectus.ante@consequatauctor.org', 1, 1),
(256, 128, 30, 'Gyeonggi', 'Appartement 237-7284 Nunc Ave', '9814', 'Yongin', 'Azerbaijan', '06 48 89 35 63', 'Phasellus.in.felis@ipsumnonarcu.co.uk', 0, 1),
(257, 18, 40, 'QLD', 'Appartement 646-9996 Quam Rue', '31414', 'Brisbane', 'Equatorial Guinea', '09 58 78 66 34', 'odio.tristique@Sedneque.edu', 1, 1),
(258, 4, 30, 'AK', 'CP 546, 7676 Quam Avenue', '637636', 'Jonesboro', 'Burundi', '08 67 05 17 27', 'Quisque.ornare.tortor@mattisInteger.edu', 1, 1),
(259, 158, 60, 'BA', '1115 Eget Ave', '5560', 'Camaçari', 'Mongolia', '01 54 73 66 66', 'aliquet.magna@idmagna.edu', 1, 0),
(260, 164, 50, 'VA', '2790 Metus Avenue', '0967', 'Virginia Beach', 'Montserrat', '04 12 76 78 03', 'tempor@a.net', 1, 0),
(261, 209, 70, 'Namen', 'CP 655, 4349 Dolor. Rd.', '56633', 'Falisolle', 'Guernsey', '07 73 82 72 42', 'sem@Curabitur.net', 0, 0),
(262, 78, 70, 'CAM', 'Appartement 487-8077 Erat Route', '925664', 'Corbara', 'Benin', '05 54 02 51 15', 'dictum.sapien@diam.edu', 1, 1),
(263, 153, 40, 'Metropolitana de Santiago', '4698 Enim. Chemin', '31012', 'Macul', 'Liberia', '08 63 46 77 85', 'lacus.Nulla@nec.co.uk', 1, 0),
(264, 130, 30, 'San José', '262-8626 Nunc Route', 'BT5 4UU', 'Purral', 'South Georgia and The South Sandwich Islands', '08 37 29 69 73', 'lobortis@non.ca', 0, 0),
(265, 183, 40, 'Provence-Alpes-Côte d\'Azur', 'Appartement 387-9270 Cursus Rue', '72936', 'Aix-en-Provence', 'Denmark', '07 16 12 23 75', 'urna.Ut@Curabiturvel.ca', 0, 1),
(266, 191, 90, 'Colorado', 'Appartement 292-6655 Ipsum Chemin', 'N9P 9G4', 'Lakewood', 'United States Minor Outlying Islands', '04 21 09 33 05', 'orci@luctus.com', 0, 1),
(267, 200, 10, 'Provence-Alpes-Côte d\'Azur', '379-6840 Felis. Rue', '184481', 'Salon-de-Provence', 'Maldives', '02 12 77 13 36', 'Morbi.metus@magnis.edu', 0, 0),
(268, 111, 30, 'South Jeolla', '1247 Neque Impasse', '225751', 'Gwangyang', 'Mexico', '05 78 69 40 77', 'iaculis.enim.sit@fermentum.ca', 0, 1),
(269, 88, 60, 'QC', 'Appartement 793-9967 Ultricies Ave', '828159', 'Dorval', 'Dominican Republic', '01 01 09 78 61', 'tincidunt.dui.augue@acurnaUt.com', 1, 0),
(270, 65, 80, 'Antwerpen', '521-6387 Fusce Chemin', '40585', 'Borgerhout', 'French Polynesia', '04 84 04 88 07', 'mi.Duis.risus@Donec.org', 0, 1),
(271, 149, 30, 'RJ', 'CP 100, 5898 Ac Route', '12543', 'São João de Meriti', 'Malawi', '03 60 56 80 41', 'sodales@idante.edu', 1, 0),
(272, 182, 70, 'Stockholms län', 'CP 507, 2776 Sem. Avenue', '5466', 'Södertälje', 'Montenegro', '03 00 55 73 50', 'Donec@turpisIn.net', 0, 0),
(273, 96, 70, 'X', 'CP 791, 7995 Pharetra. Chemin', '85-476', 'Bollnäs', 'Georgia', '07 53 18 39 85', 'tincidunt@Nullam.org', 0, 0),
(274, 149, 70, 'Victoria', '6613 Sem. Av.', '05497', 'Shepparton', 'Lesotho', '09 10 36 14 21', 'gravida.sagittis@facilisi.ca', 1, 1),
(275, 129, 20, 'SAM', '840-7070 Gravida Chemin', '230553', 'Samara', 'Georgia', '06 32 14 08 31', 'Aliquam.fringilla@ipsumdolorsit.org', 0, 0),
(276, 56, 10, 'İzm', '5800 Ullamcorper, Rue', '04204', 'Tire', 'Israel', '06 14 49 67 71', 'ipsum@diamdictumsapien.ca', 0, 1),
(277, 190, 100, 'UMB', 'Appartement 761-2415 Cursus Rue', 'Z8137', 'Castel Ritaldi', 'Tokelau', '06 68 81 04 94', 'eros@necdiam.ca', 1, 1),
(278, 196, 10, 'NSW', 'CP 605, 6941 Ornare Chemin', '87677', 'Wollongong', 'Paraguay', '05 16 12 45 82', 'ornare.sagittis@nullaante.com', 0, 1),
(279, 75, 30, 'OK', 'Appartement 333-3647 Nunc Chemin', 'Z1170', 'Norman', 'Saint Vincent and The Grenadines', '03 31 06 74 72', 'augue.ac.ipsum@aliquetmetus.co.uk', 1, 1),
(280, 15, 70, 'L', '9564 Adipiscing Avenue', 'BE1 5WY', 'Limón (Puerto Limón)', 'Anguilla', '05 44 01 93 02', 'dolor.sit.amet@velsapienimperdiet.co.uk', 1, 0),
(281, 201, 50, 'AS', 'CP 588, 2662 Pellentesque Rd.', 'Z0906', 'Guwahati', 'Vanuatu', '01 71 60 12 28', 'mollis.vitae@tellusNunc.ca', 0, 1),
(282, 191, 80, 'Michoacán', 'CP 218, 1619 Netus Ave', '60314', 'Zamora de Hidalgo', 'Iraq', '07 51 35 94 08', 'nisi.Cum.sociis@pharetra.com', 1, 1),
(283, 38, 30, 'QC', '667 Tincidunt Route', '16666-403', 'Shawville', 'San Marino', '06 91 17 78 01', 'porttitor.eros@elementumloremut.ca', 1, 0),
(284, 151, 90, 'OS', 'Appartement 987-595 Porta Rue', '314356', 'Ilesa', 'Belgium', '08 27 76 56 77', 'ullamcorper.eu@acmattis.net', 1, 1),
(285, 31, 50, 'Hidalgo', 'CP 835, 7643 Vitae Rd.', '18264', 'Pachuca', 'Bulgaria', '06 60 61 53 85', 'dictum.magna@Nunclaoreet.edu', 1, 1),
(286, 130, 80, 'Bur', '352-6545 Pellentesque. Chemin', '286085', 'Karacabey', 'Somalia', '08 26 25 08 18', 'sem.ut.cursus@mattis.ca', 1, 1),
(287, 111, 100, 'HE', '931-3600 Erat Rue', '30115', 'Vaulx-lez-Chimay', 'Swaziland', '09 45 96 65 54', 'Etiam@faucibus.edu', 0, 1),
(288, 150, 70, 'PB', 'CP 799, 6982 Sed Rue', '28771', 'Bahawalpur', 'Norway', '09 12 16 25 43', 'ipsum@primis.net', 1, 0),
(289, 38, 80, 'Vienna', 'CP 615, 2771 Ut Impasse', '17454', 'Vienna', 'Gibraltar', '02 19 60 22 40', 'luctus.et.ultrices@euturpis.edu', 1, 0),
(290, 41, 70, 'ML', '550-6822 Curae; Rd.', '404394', 'Dalkeith', 'Russian Federation', '02 11 82 72 86', 'enim.consequat.purus@rhoncusDonec.co.uk', 0, 0),
(291, 167, 90, 'X', 'Appartement 206-7532 Felis. Chemin', '64715', 'Gävle', 'Sao Tome and Principe', '06 96 12 39 38', 'augue.porttitor@enimcondimentumeget.org', 1, 1),
(292, 180, 20, 'Gl', 'Appartement 123-1367 Dolor Rue', 'Z3467', 'Nijmegen', 'Côte D\'Ivoire (Ivory Coast)', '05 43 28 80 78', 'vulputate@estMauris.edu', 1, 0),
(293, 160, 60, 'West Sulawesi', 'Appartement 298-2148 Libero. Av.', '55159', 'Mamuju', 'Cameroon', '02 25 21 48 61', 'leo.in.lobortis@pharetrased.co.uk', 0, 0),
(294, 49, 50, 'Alberta', 'Appartement 692-9912 Id, Rue', '74573', 'Warburg', 'Antigua and Barbuda', '06 37 68 24 27', 'mauris@perconubianostra.co.uk', 0, 0),
(295, 43, 30, 'NL', '162 In Route', '8384', 'Rigolet', 'Western Sahara', '08 33 56 78 16', 'et@necimperdietnec.edu', 0, 0),
(296, 118, 40, 'QLD', '946-9140 Lacus. Route', 'VU0E 6PO', 'Gladstone', 'Bermuda', '07 77 87 35 28', 'neque.et@nulla.org', 1, 0),
(297, 22, 90, 'Gye', 'CP 564, 3569 Neque Rue', '30003', 'Gunpo', 'Lesotho', '08 02 77 37 14', 'orci.Ut@Morbivehicula.edu', 1, 1),
(298, 56, 10, 'III', '8333 Faucibus Route', 'Z1019', 'Huasco', 'Montenegro', '06 76 09 14 02', 'faucibus.id.libero@tinciduntnequevitae.com', 1, 0),
(299, 93, 60, 'New South Wales', 'Appartement 799-5873 Consectetuer Av.', '75244', 'Lithgow', 'Myanmar', '08 05 08 77 30', 'dui.Cum.sociis@Donecluctusaliquet.edu', 0, 1),
(300, 157, 40, 'Piemonte', '666-5667 Magnis Impasse', '7713', 'Monteu Roero', 'Haiti', '03 73 38 10 77', 'penatibus.et@amet.co.uk', 0, 1),
(301, 58, 20, 'MB', 'Appartement 182-8052 Nam Av.', '7254', 'Beausejour', 'Serbia', '06 50 56 91 47', 'magna.Nam@Inat.edu', 0, 1),
(302, 105, 40, 'SA', 'Appartement 772-7873 Primis Ave', '38666', 'Whyalla', 'Mali', '04 00 49 99 00', 'et.euismod.et@Quisquevarius.ca', 1, 0),
(303, 44, 70, 'Pskov Oblast', 'CP 866, 5208 Metus Rd.', '05642', 'Pskov', 'Rwanda', '04 07 24 21 60', 'facilisis@euismodacfermentum.co.uk', 0, 0),
(304, 105, 80, 'Wie', '8020 Mollis Avenue', '350710', 'Vienna', 'India', '09 66 02 82 30', 'ornare@neceleifend.co.uk', 0, 0);

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
) ENGINE=MyISAM AUTO_INCREMENT=71 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `CODE`, `LABEL`, `IND`, `PRESTATION_ID`, `FAMILLE_ID`, `ACHETER`, `PRIX_ACHETER`, `VENDU`, `PRIX_VENDU`, `UNITE_ID`, `MATIERE`, `EP`, `DIM_X`, `DIM_Y`, `DIM_Z`, `POIDS`, `SUR_X`, `SUR_Y`, `SUR_Z`, `COMMENT`, `IMAGE`) VALUES
(1, 'TOLE_S235_EP2', 'Tôle acier s235 ep 2', '1', 1, 0, 1, '0.000', 0, '0.000', 0, 'ACIER', '1.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', 'images/ArticlesImage/'),
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
(26, 'VIS_ACIER_H_M10_LG100', 'Vis ACIER H M10 longueur 100mm', '1', 14, 3, 1, '0.001', 0, '0.000', 8, 'ACIER', '0.000', '10.000', '10.000', '100.000', '0.001', '0.000', '0.000', '0.000', '', 'images/ArticlesImage/vis-metaux-tete-hexagonale-th-classe-109-10x35-filetage-total-p12as5-acier.jpg'),
(27, 'TOLE_304_EP2', 'Tôle inox 304L ep 2', '1', 1, 0, 1, '3.000', 0, '0.000', 0, 'INOX', '2.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', ''),
(28, 'TOLE_304_EP2', 'Tôle inox 304L ep 2', '1', 1, 0, 1, '3.000', 0, '0.000', 0, 'INOX', '2.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', ''),
(29, 'TOLE_304_EP2.5', 'Tôle inox 304L ep 2.5', '1', 1, 0, 1, '3.000', 0, '0.000', 0, 'INOX', '2.500', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', ''),
(30, 'TOLE_304_EP3', 'Tôle inox 304L ep 3', '1', 1, 0, 1, '3.000', 0, '0.000', 0, 'INOX', '3.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', ''),
(31, 'TOLE_304_EP4', 'Tôle inox 304L ep 4', '1', 1, 0, 1, '3.000', 0, '0.000', 0, 'INOX', '4.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', ''),
(32, 'TOLE_304_EP5', 'Tôle inox 304L ep 5', '1', 1, 0, 1, '3.000', 0, '0.000', 0, 'INOX', '5.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', ''),
(33, 'TOLE_304_EP6', 'Tôle inox 304L ep 6', '1', 1, 0, 1, '3.000', 0, '0.000', 0, 'INOX', '6.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', ''),
(34, 'TOLE_304_EP8', 'Tôle inox 304L ep 8', '1', 1, 0, 1, '3.000', 0, '0.000', 0, 'INOX', '8.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', ''),
(35, 'TOLE_304_EP10', 'Tôle inox 304L ep 10', '1', 1, 0, 1, '3.000', 0, '0.000', 0, 'INOX', '10.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', ''),
(36, 'TOLE_304_EP12', 'Tôle inox 304L ep 12', '1', 1, 0, 1, '3.000', 0, '0.000', 0, 'INOX', '12.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', ''),
(37, 'TOLE_304_EP15', 'Tôle inox 304L ep 15', '1', 1, 0, 1, '3.000', 0, '0.000', 0, 'INOX', '15.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', ''),
(38, 'TOLE_304_EP20', 'Tôle inox 304L ep 20', '1', 1, 0, 1, '3.000', 0, '0.000', 0, 'INOX', '20.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', ''),
(39, 'TOLE_304_EP25', 'Tôle inox 304L ep 25', '1', 1, 0, 1, '3.000', 0, '0.000', 0, 'INOX', '25.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', ''),
(40, 'TOLE_304_EP30', 'Tôle inox 304L ep 30', '1', 1, 0, 1, '3.000', 0, '0.000', 0, 'INOX', '30.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', ''),
(41, 'TOLE_DD11_EP1', 'Tôle inox DD11 ep 1', '1', 1, 0, 1, '3.000', 0, '0.000', 0, 'ACIER', '1.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', ''),
(42, 'TOLE_DD11_EP2', 'Tôle inox DD11 ep 2', '1', 1, 0, 1, '3.000', 0, '0.000', 0, 'ACIER', '2.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', ''),
(43, 'TOLE_DD11_EP2.5', 'Tôle inox DD11 ep 2.5', '1', 1, 0, 1, '3.000', 0, '0.000', 0, 'ACIER', '2.500', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', ''),
(44, 'TOLE_DD11_EP3', 'Tôle inox DD11 ep 3', '1', 1, 0, 1, '3.000', 0, '0.000', 0, 'ACIER', '3.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', ''),
(45, 'TOLE_DD11_EP4', 'Tôle inox DD11 ep 4', '1', 1, 0, 1, '3.000', 0, '0.000', 0, 'ACIER', '4.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', ''),
(46, 'TOLE_DD11_EP5', 'Tôle inox DD11 ep 5', '1', 1, 0, 1, '3.000', 0, '0.000', 0, 'ACIER', '5.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', ''),
(47, 'TOLE_DD11_EP6', 'Tôle inox DD11 ep 6', '1', 1, 0, 1, '3.000', 0, '0.000', 0, 'ACIER', '6.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', ''),
(48, 'TOLE_DD11_EP8', 'Tôle inox DD11 ep 8', '1', 1, 0, 1, '3.000', 0, '0.000', 0, 'ACIER', '8.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', ''),
(49, 'TOLE_DD11_EP10', 'Tôle inox DD11 ep 10', '1', 1, 0, 1, '3.000', 0, '0.000', 0, 'ACIER', '10.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', ''),
(50, 'TOLE_DD11_EP12', 'Tôle inox DD11 ep 12', '1', 1, 0, 1, '3.000', 0, '0.000', 0, 'ACIER', '12.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', ''),
(51, 'TOLE_DD11_EP15', 'Tôle inox DD11 ep 15', '1', 1, 0, 1, '3.000', 0, '0.000', 0, 'ACIER', '15.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', ''),
(52, 'TOLE_DD11_EP20', 'Tôle inox DD11 ep 20', '1', 1, 0, 1, '3.000', 0, '0.000', 0, 'ACIER', '20.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', ''),
(53, 'TOLE_DD11_EP25', 'Tôle inox DD11 ep 25', '1', 1, 0, 1, '3.000', 0, '0.000', 0, 'ACIER', '25.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', ''),
(54, 'TOLE_DD11_EP30', 'Tôle inox DD11 ep 30', '1', 1, 0, 1, '3.000', 0, '0.000', 0, 'ACIER', '30.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', ''),
(55, 'TOLE_S355_EP3', 'Tôle inox S355 ep 3', '1', 1, 0, 1, '3.000', 0, '0.000', 0, 'ACIER', '3.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', ''),
(56, 'TOLE_S355_EP4', 'Tôle inox S355 ep 4', '1', 1, 0, 1, '3.000', 0, '0.000', 0, 'ACIER', '4.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', ''),
(57, 'TOLE_S355_EP5', 'Tôle inox S355 ep 5', '1', 1, 0, 1, '3.000', 0, '0.000', 0, 'ACIER', '5.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', ''),
(58, 'TOLE_S355_EP6', 'Tôle inox S355 ep 6', '1', 1, 0, 1, '3.000', 0, '0.000', 0, 'ACIER', '6.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', ''),
(59, 'TOLE_S355_EP8', 'Tôle inox S355 ep 8', '1', 1, 0, 1, '3.000', 0, '0.000', 0, 'ACIER', '8.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', ''),
(60, 'TOLE_S355_EP10', 'Tôle inox S355 ep 10', '1', 1, 0, 1, '3.000', 0, '0.000', 0, 'ACIER', '10.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', ''),
(61, 'TOLE_S355_EP12', 'Tôle inox S355 ep 12', '1', 1, 0, 1, '3.000', 0, '0.000', 0, 'ACIER', '12.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', ''),
(62, 'TOLE_S355_EP15', 'Tôle inox S355 ep 15', '1', 1, 0, 1, '3.000', 0, '0.000', 0, 'ACIER', '15.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', ''),
(63, 'TOLE_S355_EP20', 'Tôle inox S355 ep 20', '1', 1, 0, 1, '3.000', 0, '0.000', 0, 'ACIER', '20.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', ''),
(64, 'TOLE_S355_EP25', 'Tôle inox S355 ep 25', '1', 1, 0, 1, '3.000', 0, '0.000', 0, 'ACIER', '25.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', ''),
(65, 'TOLE_S355_EP30', 'Tôle inox S355 ep 30', '1', 1, 0, 1, '3.000', 0, '0.000', 0, 'ACIER', '30.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', ''),
(66, 'TOLE_GALVA_EP0.5', 'Tôle inox GALVA ep 0.5', '1', 1, 0, 1, '3.000', 0, '0.000', 0, 'ACIER', '0.500', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', ''),
(67, 'TOLE_GALVA_EP1', 'Tôle inox GALVA ep 1', '1', 1, 0, 1, '3.000', 0, '0.000', 0, 'ACIER', '1.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', ''),
(68, 'TOLE_GALVA_EP2', 'Tôle inox GALVA ep 2', '1', 1, 0, 1, '3.000', 0, '0.000', 0, 'ACIER', '2.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', ''),
(69, 'TOLE_GALVA_EP2.5', 'Tôle inox GALVA ep 2.5', '1', 1, 0, 1, '3.000', 0, '0.000', 0, 'ACIER', '2.500', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', ''),
(70, 'TOLE_GALVA_EP3', 'Tôle inox GALVA ep 3', '1', 1, 0, 1, '3.000', 0, '0.000', 0, 'ACIER', '3.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', '', '');

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
  `COND_REG_CLIENT_ID` int(11) DEFAULT NULL,
  `MODE_REG_CLIENT_ID` int(11) DEFAULT NULL,
  `REMISE` int(11) NOT NULL,
  `RESP_COM_ID` int(11) NOT NULL,
  `RESP_TECH_ID` int(11) NOT NULL,
  `COMPTE_GEN_CLIENT` int(11) DEFAULT '0',
  `COMPTE_AUX_CLIENT` int(11) DEFAULT '0',
  `STATU_FOUR` int(11) NOT NULL,
  `COND_REG_FOUR_ID` int(11) NOT NULL,
  `MODE_REG_FOUR_ID` int(11) NOT NULL,
  `COMPTE_GEN_FOUR` int(11) NOT NULL DEFAULT '0',
  `COMPTE_AUX_FOUR` int(11) NOT NULL DEFAULT '0',
  `CONTROLE_FOUR` int(11) NOT NULL,
  `DATE_CREA` date NOT NULL,
  `COMMENT` text COLLATE utf8_unicode_ci NOT NULL,
  `SECTOR_ID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=213 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `client_fourniseur`
--

INSERT INTO `client_fourniseur` (`id`, `CODE`, `NAME`, `WEBSITE`, `FBSITE`, `TWITTERSITE`, `LKDSITE`, `SIREN`, `APE`, `TVA_INTRA`, `TVA_ID`, `LOGO`, `STATU_CLIENT`, `COND_REG_CLIENT_ID`, `MODE_REG_CLIENT_ID`, `REMISE`, `RESP_COM_ID`, `RESP_TECH_ID`, `COMPTE_GEN_CLIENT`, `COMPTE_AUX_CLIENT`, `STATU_FOUR`, `COND_REG_FOUR_ID`, `MODE_REG_FOUR_ID`, `COMPTE_GEN_FOUR`, `COMPTE_AUX_FOUR`, `CONTROLE_FOUR`, `DATE_CREA`, `COMMENT`, `SECTOR_ID`) VALUES
(1, 'METALI', 'METALERIE GRENOBLE ALPE', 'https://www.site.com/', '', 'https://twitter.com/', 'https://www.linkedin.com/', '12345679910', '350', '', 4, 'images/ClientLogo/', 2, 8, 1, 0, 2, 1, 401000, 400000, 0, 8, 1, 401000, 400000, 1, '2020-10-28', '', ''),
(2, 'LASERDEC ', 'LASER DECOUPE', 'https://www.decoupe.com/', 'https://www.facebook.com/', 'https://twitter.com/', 'https://www.linkedin.com/', '12345679910', '350', '', 4, 'images/ClientLogo/', 2, 1, 2, 0, 1, 2, 401000, 400000, 0, 1, 1, 401000, 400000, 1, '2020-10-28', '', ''),
(3, 'METALJ', 'METAL JOLI', 'https://www.jolie.com/', 'https://www.facebook.com/', 'https://twitter.com/', 'https://www.linkedin.com/', '12345679910', '350', '', 4, 'images/ClientLogo/', 2, 1, 1, 0, 1, 2, 401000, 400000, 0, 1, 1, 401000, 400000, 1, '2020-10-28', '', ''),
(4, 'GLOB1', 'GLOBAL METAL1', 'https://www.site.com/', 'https://www.facebook.com/', 'https://twitter.com/', 'https://www.linkedin.com/', '12345679910', '350', '', 4, 'images/ClientLogo/', 2, 1, 1, 10, 1, 2, 401000, 400000, 0, 1, 1, 401000, 400000, 1, '2020-10-28', '', ''),
(5, 'GLOB', 'GLOBAL METAL', 'https://www.site.com/', 'https://www.facebook.com/', 'https://twitter.com/', 'https://www.linkedin.com/', '12345679910', '350', '', 4, 'images/ClientLogo/', 2, 1, 1, 10, 1, 2, 401000, 400000, 0, 1, 1, 401000, 400000, 1, '2020-10-28', '', ''),
(6, 'GLOB4', 'GLOBAL METAL4', 'https://www.site.com/', 'https://www.facebook.com/', 'https://twitter.com/', 'https://www.linkedin.com/', '12345679910', '350', '', 4, 'images/ClientLogo/', 2, 1, 1, 10, 1, 2, 401000, 400000, 0, 1, 1, 401000, 400000, 1, '2020-10-28', '', ''),
(7, 'GLOB3', 'GLOBAL METAL3', 'https://www.site.com/', 'https://www.facebook.com/', 'https://twitter.com/', 'https://www.linkedin.com/', '12345679910', '350', '', 4, 'images/ClientLogo/', 2, 1, 1, 10, 1, 2, 401000, 400000, 0, 1, 1, 401000, 400000, 1, '2020-10-28', '', ''),
(8, 'GLOB2', 'GLOBAL METAL2', 'https://www.site.com/', 'https://www.facebook.com/', 'https://twitter.com/', 'https://www.linkedin.com/', '12345679910', '350', '', 4, 'images/ClientLogo/', 2, 1, 1, 10, 1, 2, 401000, 400000, 0, 1, 1, 401000, 400000, 1, '2020-10-28', '', ''),
(9, 'ADM1', 'ARCELOR MITAL 1', 'https://e-steel.arcelormittal.com/FR/fr/', '', '', '', '46950096100641', '', '', 4, 'images/ClientLogo/1200px-Logo_ArcelorMittal.svg.png', 0, 8, 1, 0, 1, 2, 0, 0, 1, 8, 1, 401000, 400000, 1, '2020-10-28', '', ''),
(10, 'SVDPM', 'KDI SVDMP', 'https://www.kloecknermetals.fr/fr.html', 'https://www.facebook.com/KloecknerFrance/', 'https://twitter.com/KloecknerFrance', 'https://www.linkedin.com/company/klockner-distribution-industrielle/?originalSubdomain=fr', '54208635000411', '350', '', 4, 'images/ClientLogo/téléchargement.png', 0, 1, 1, 0, 1, 1, 0, 0, 1, 1, 1, 401000, 400000, 1, '2020-10-28', '', ''),
(11, 'ADM2', 'ARCELOR MITAL 2', 'https://e-steel.arcelormittal.com/FR/fr/', '', '', '', '46950096100641', '', '', 4, 'images/ClientLogo/', 0, 8, 1, 0, 1, 2, 0, 0, 1, 8, 1, 401000, 400000, 1, '2020-11-08', '', ''),
(12, 'ADM3', 'ARCELOR MITAL3', 'https://e-steel.arcelormittal.com/FR/fr/', '', '', '', '46950096100641', '', '', 4, 'images/ClientLogo/', 0, 8, 1, 0, 1, 2, 0, 0, 1, 8, 1, 401000, 400000, 1, '2020-11-08', '', ''),
(13, '26', 'Mollis Non Cursus Institute', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '996837720', '9300', '8', 5, 'logo.png', 1, 3, 1, 7, 8, 8, 0, 0, 1, 3, 4, 0, 0, 0, '2020-02-29', 'Aucun', ''),
(14, '713', 'Sodales Mauris Blandit PC', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '213093578', '6604', '6', 3, 'logo.png', 0, 4, 3, 6, 4, 5, 0, 0, 0, 3, 1, 0, 0, 0, '2021-06-14', 'Aucun', ''),
(15, '829', 'Id LLP', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '151314267', '5898', '7', 2, 'logo.png', 0, 3, 3, 3, 4, 9, 0, 0, 0, 6, 4, 0, 0, 0, '2021-10-27', 'Aucun', ''),
(16, '589', 'Aliquam Foundation', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '360811111', '2757', '8', 3, 'logo.png', 2, 3, 4, 2, 3, 3, 0, 0, 0, 5, 3, 0, 0, 1, '2020-01-06', 'Aucun', ''),
(17, '795', 'Mattis Ornare Institute', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '920568607', '6086', '9', 3, 'logo.png', 0, 4, 1, 7, 4, 4, 0, 0, 1, 5, 2, 0, 0, 1, '2020-07-15', 'Aucun', ''),
(18, '998', 'Suspendisse Institute', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '301799656', '5713', '7', 5, 'logo.png', 2, 6, 1, 7, 7, 8, 0, 0, 0, 6, 2, 0, 0, 2, '2020-02-16', 'Aucun', ''),
(19, '783', 'Enim Foundation', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '472291376', '5257', '2', 2, 'logo.png', 0, 5, 5, 3, 10, 10, 0, 0, 0, 3, 5, 0, 0, 2, '2021-01-23', 'Aucun', ''),
(20, '164', 'Volutpat Industries', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '099014433', '8689', '8', 4, 'logo.png', 1, 5, 4, 1, 8, 9, 0, 0, 1, 3, 1, 0, 0, 2, '2021-06-16', 'Aucun', ''),
(21, '38', 'Tristique Senectus Ltd', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '390321727', '9384', '6', 1, 'logo.png', 0, 5, 4, 9, 2, 2, 0, 0, 0, 4, 1, 0, 0, 2, '2020-05-26', 'Aucun', ''),
(22, '955', 'Morbi Quis Urna Associates', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '490746997', '6107', '2', 4, 'logo.png', 0, 4, 2, 5, 4, 9, 0, 0, 0, 4, 1, 0, 0, 1, '2021-10-26', 'Aucun', ''),
(23, '292', 'Convallis Ligula Donec Consulting', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '227881661', '4114', '9', 4, 'logo.png', 0, 4, 2, 3, 5, 5, 0, 0, 0, 5, 1, 0, 0, 2, '2020-12-07', 'Aucun', ''),
(24, '257', 'Ipsum Associates', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '937444065', '4587', '3', 1, 'logo.png', 1, 5, 1, 8, 7, 6, 0, 0, 1, 3, 3, 0, 0, 1, '2021-01-26', 'Aucun', ''),
(25, '76', 'Lacus PC', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '759309198', '9555', '4', 3, 'logo.png', 1, 4, 5, 8, 9, 8, 0, 0, 0, 4, 2, 0, 0, 1, '2020-04-06', 'Aucun', ''),
(26, '961', 'Dapibus Ligula Company', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '823922695', '6462', '7', 5, 'logo.png', 2, 4, 4, 6, 5, 8, 0, 0, 0, 5, 3, 0, 0, 1, '2020-07-09', 'Aucun', ''),
(27, '304', 'Ut Pellentesque Incorporated', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '348794504', '1336', '5', 1, 'logo.png', 2, 5, 3, 1, 1, 2, 0, 0, 1, 3, 5, 0, 0, 0, '2020-08-01', 'Aucun', ''),
(28, '792', 'At Iaculis Foundation', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '811462357', '3281', '1', 3, 'logo.png', 1, 3, 5, 4, 2, 8, 0, 0, 1, 3, 5, 0, 0, 0, '2021-08-12', 'Aucun', ''),
(29, '410', 'Arcu Vestibulum LLC', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '263482853', '9919', '9', 4, 'logo.png', 2, 5, 2, 9, 7, 3, 0, 0, 0, 6, 4, 0, 0, 2, '2020-11-06', 'Aucun', ''),
(30, '731', 'A Institute', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '238969661', '5878', '8', 5, 'logo.png', 2, 5, 5, 6, 1, 1, 0, 0, 1, 5, 4, 0, 0, 0, '2021-03-24', 'test', '1,6'),
(31, '479', 'Ac Company', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '556396091', '4436', '7', 5, 'logo.png', 2, 4, 5, 9, 7, 6, 0, 0, 1, 5, 3, 0, 0, 0, '2020-10-05', 'Aucun', ''),
(32, '77', 'Non Justo LLP', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '415853209', '3688', '8', 3, 'logo.png', 1, 6, 3, 8, 8, 2, 0, 0, 1, 4, 1, 0, 0, 2, '2020-05-31', 'Aucun', ''),
(33, '173', 'Eu Eros Nam Inc.', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '198682940', '8106', '3', 4, 'logo.png', 2, 3, 2, 1, 8, 1, 0, 0, 1, 3, 3, 0, 0, 1, '2021-04-11', 'Aucun', ''),
(34, '337', 'Auctor Odio A Inc.', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '982341794', '3934', '8', 1, 'logo.png', 1, 5, 3, 7, 2, 8, 0, 0, 0, 4, 5, 0, 0, 1, '2020-07-26', 'Aucun', ''),
(35, '885', 'Mauris Quis Turpis Corporation', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '252679501', '4066', '1', 3, 'logo.png', 1, 6, 5, 10, 8, 10, 0, 0, 0, 6, 1, 0, 0, 1, '2021-03-07', 'Aucun', ''),
(36, '620', 'Urna Nullam Lobortis Ltd', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '540482585', '8328', '5', 3, 'logo.png', 1, 5, 2, 3, 4, 6, 0, 0, 1, 4, 2, 0, 0, 0, '2021-09-09', 'Aucun', ''),
(37, '899', 'Scelerisque Sed Sapien Institute', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '418854915', '9822', '5', 4, 'logo.png', 0, 4, 3, 7, 7, 3, 0, 0, 1, 3, 4, 0, 0, 1, '2020-05-19', 'Aucun', ''),
(38, '69', 'Convallis Ante Lectus Corp.', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '602456238', '7386', '2', 2, 'logo.png', 0, 4, 5, 10, 6, 5, 0, 0, 1, 6, 1, 0, 0, 1, '2021-03-01', 'Aucun', ''),
(39, '714', 'Cum Sociis Foundation', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '581089901', '2349', '2', 1, 'logo.png', 0, 3, 5, 7, 2, 2, 0, 0, 1, 3, 3, 0, 0, 0, '2020-03-21', 'Aucun', ''),
(40, '523', 'Tincidunt Tempus Risus LLC', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '590848925', '1360', '5', 5, 'logo.png', 2, 6, 2, 9, 1, 6, 0, 0, 1, 4, 1, 0, 0, 2, '2020-09-30', 'Aucun', ''),
(41, '689', 'Bibendum Fermentum LLP', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '986289585', '6361', '9', 3, 'logo.png', 1, 5, 1, 1, 1, 9, 0, 0, 0, 4, 3, 0, 0, 0, '2021-03-28', 'Aucun', ''),
(42, '550', 'Gravida Sit Amet Foundation', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '481375988', '4232', '5', 2, 'logo.png', 0, 3, 1, 9, 9, 6, 0, 0, 0, 4, 5, 0, 0, 1, '2020-02-12', 'Aucun', ''),
(43, '608', 'Tristique Incorporated', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '542723002', '8489', '1', 4, 'logo.png', 2, 4, 2, 4, 7, 6, 0, 0, 1, 3, 5, 0, 0, 0, '2021-03-03', 'Aucun', ''),
(44, '118', 'Cursus Et Magna Limited', 'www.website.com', '', 'www.website.com', 'www.website.com', '446283863', '4841', '4', 1, 'logo.png', 2, 8, 4, 5, 36, 1, 0, 0, 0, 3, 1, 0, 0, 0, '2020-06-07', 'Aucun', ''),
(45, '399', 'Consectetuer Adipiscing Elit PC', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '510510746', '8271', '5', 5, 'logo.png', 0, 6, 4, 10, 4, 4, 0, 0, 1, 4, 2, 0, 0, 2, '2020-05-22', 'Aucun', ''),
(46, '529', 'Aliquam Enim Institute', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '501604375', '5355', '1', 5, 'logo.png', 0, 6, 1, 1, 9, 9, 0, 0, 1, 5, 3, 0, 0, 2, '2021-08-08', 'Aucun', ''),
(47, '583', 'Tincidunt Nibh Phasellus Inc.', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '139412423', '5653', '1', 1, 'logo.png', 1, 3, 3, 9, 6, 8, 0, 0, 0, 4, 2, 0, 0, 2, '2020-09-17', 'Aucun', ''),
(48, '772', 'Et Industries', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '819689530', '8070', '8', 4, 'logo.png', 0, 6, 1, 9, 10, 8, 0, 0, 0, 5, 5, 0, 0, 0, '2021-05-07', 'Aucun', ''),
(49, '967', 'Pellentesque PC', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '338270606', '4996', '7', 2, 'logo.png', 0, 5, 5, 2, 10, 2, 0, 0, 1, 4, 2, 0, 0, 0, '2021-03-19', 'Aucun', ''),
(50, '460', 'Maecenas Institute', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '451839419', '1161', '8', 4, 'logo.png', 2, 6, 1, 10, 9, 4, 0, 0, 1, 5, 3, 0, 0, 2, '2021-08-06', 'Aucun', ''),
(51, '522', 'Nisl Nulla Eu Consulting', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '890440613', '7412', '2', 3, 'logo.png', 2, 3, 4, 9, 3, 8, 0, 0, 0, 3, 5, 0, 0, 0, '2020-02-01', 'Aucun', ''),
(52, '421', 'Orci Sem Limited', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '337135404', '9763', '6', 5, 'logo.png', 1, 4, 4, 6, 5, 7, 0, 0, 1, 6, 5, 0, 0, 2, '2021-02-10', 'Aucun', ''),
(53, '760', 'Risus Nulla PC', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '548229855', '5644', '2', 5, 'logo.png', 0, 4, 1, 5, 2, 7, 0, 0, 1, 3, 5, 0, 0, 2, '2020-05-10', 'Aucun', ''),
(54, '189', 'Laoreet Ipsum Curabitur Institute', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '139229983', '9093', '3', 4, 'logo.png', 1, 4, 1, 10, 10, 8, 0, 0, 1, 4, 1, 0, 0, 0, '2020-05-25', 'Aucun', ''),
(55, '618', 'Elit Fermentum Consulting', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '170310635', '8685', '4', 2, 'logo.png', 2, 5, 3, 5, 3, 1, 0, 0, 1, 4, 4, 0, 0, 1, '2020-07-21', 'Aucun', ''),
(56, '680', 'Pellentesque Massa Lobortis Inc.', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '054945258', '9027', '4', 2, 'logo.png', 2, 3, 1, 5, 3, 6, 0, 0, 1, 6, 2, 0, 0, 2, '2020-01-30', 'Aucun', ''),
(57, '625', 'Donec Ltd', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '560856015', '5111', '8', 1, 'logo.png', 1, 4, 1, 1, 2, 6, 0, 0, 1, 3, 5, 0, 0, 0, '2021-11-24', 'Aucun', ''),
(58, '980', 'Orci Lacus Inc.', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '006362560', '3328', '7', 1, 'logo.png', 1, 4, 4, 3, 1, 3, 0, 0, 0, 6, 2, 0, 0, 0, '2020-05-07', 'Aucun', ''),
(59, '75', 'Ipsum Institute', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '413896754', '2169', '9', 3, 'logo.png', 1, 6, 4, 7, 8, 5, 0, 0, 0, 5, 2, 0, 0, 1, '2021-04-16', 'Aucun', ''),
(60, '415', 'Purus In Ltd', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '723579363', '8391', '5', 3, 'logo.png', 1, 3, 5, 2, 2, 6, 0, 0, 0, 4, 2, 0, 0, 1, '2020-05-02', 'Aucun', ''),
(61, '563', 'Pellentesque Habitant LLP', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '522826320', '3190', '1', 2, 'logo.png', 0, 3, 5, 4, 8, 6, 0, 0, 0, 5, 4, 0, 0, 1, '2020-10-08', 'Aucun', ''),
(62, '433', 'Donec PC', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '398039693', '8159', '8', 2, 'logo.png', 0, 6, 1, 9, 2, 5, 0, 0, 0, 6, 5, 0, 0, 0, '2021-11-08', 'Aucun', ''),
(63, '810', 'Amet Ornare Lectus Inc.', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '456230846', '8027', '2', 3, 'logo.png', 0, 5, 2, 10, 4, 4, 0, 0, 0, 3, 2, 0, 0, 2, '2021-05-07', 'Aucun', ''),
(64, '980', 'Vitae Diam Proin Associates', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '321563710', '3188', '5', 1, 'logo.png', 2, 3, 4, 2, 7, 2, 0, 0, 0, 3, 5, 0, 0, 0, '2020-09-08', 'Aucun', ''),
(65, '299', 'Fermentum Vel Mauris Institute', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '002362101', '5084', '9', 3, 'logo.png', 2, 3, 5, 9, 6, 1, 0, 0, 0, 3, 2, 0, 0, 2, '2021-10-18', 'Aucun', ''),
(66, '787', 'Mauris Rhoncus Corp.', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '377580311', '7613', '5', 3, 'logo.png', 0, 4, 3, 10, 10, 7, 0, 0, 0, 6, 1, 0, 0, 1, '2020-09-11', 'Aucun', ''),
(67, '82', 'Vestibulum Massa Incorporated', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '484488630', '9454', '2', 5, 'logo.png', 1, 5, 4, 4, 5, 9, 0, 0, 0, 4, 1, 0, 0, 0, '2020-05-30', 'Aucun', ''),
(68, '93', 'Curabitur Dictum Phasellus Limited', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '627643844', '9229', '2', 4, 'logo.png', 1, 4, 1, 6, 8, 5, 0, 0, 0, 3, 3, 0, 0, 2, '2020-12-02', 'Aucun', ''),
(69, '4', 'Consectetuer Euismod Est Foundation', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '209472554', '1225', '9', 3, 'logo.png', 0, 4, 5, 10, 5, 6, 0, 0, 0, 4, 3, 0, 0, 1, '2021-06-28', 'Aucun', ''),
(70, '7', 'Urna LLC', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '303752265', '3297', '9', 2, 'logo.png', 0, 4, 1, 3, 5, 6, 0, 0, 0, 6, 1, 0, 0, 0, '2021-05-18', 'Aucun', ''),
(71, '451', 'Elementum Dui Quis Foundation', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '133271668', '6462', '6', 1, 'logo.png', 0, 6, 5, 7, 1, 2, 0, 0, 1, 5, 4, 0, 0, 2, '2020-01-01', 'Aucun', ''),
(72, '204', 'Erat Inc.', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '715741674', '7875', '7', 4, 'logo.png', 0, 6, 4, 9, 10, 5, 0, 0, 0, 3, 1, 0, 0, 1, '2020-11-30', 'Aucun', ''),
(73, '965', 'Molestie Tellus Aenean Inc.', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '855099875', '9250', '7', 5, 'logo.png', 2, 3, 4, 4, 10, 10, 0, 0, 0, 4, 2, 0, 0, 1, '2019-12-26', 'Aucun', ''),
(74, '913', 'Ullamcorper Velit In Corporation', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '722923703', '3836', '9', 3, 'logo.png', 0, 4, 3, 9, 7, 3, 0, 0, 0, 3, 4, 0, 0, 2, '2021-02-26', 'Aucun', ''),
(75, '885', 'Aliquam Company', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '773623889', '5145', '5', 2, 'logo.png', 0, 5, 2, 2, 7, 8, 0, 0, 1, 6, 4, 0, 0, 2, '2020-03-28', 'Aucun', ''),
(76, '518', 'Laoreet Lectus Quis Inc.', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '195126735', '3260', '1', 4, 'logo.png', 1, 3, 5, 1, 5, 4, 0, 0, 0, 6, 1, 0, 0, 1, '2020-02-07', 'Aucun', ''),
(77, '830', 'Feugiat Lorem Ipsum Corp.', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '385791785', '6650', '7', 3, 'logo.png', 0, 4, 3, 2, 1, 7, 0, 0, 0, 5, 2, 0, 0, 2, '2021-01-06', 'Aucun', ''),
(78, '59', 'Luctus Ipsum Company', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '231546581', '3862', '6', 1, 'logo.png', 1, 6, 5, 3, 10, 2, 0, 0, 1, 3, 4, 0, 0, 1, '2021-08-14', 'Aucun', ''),
(79, '78', 'Nunc Ac LLP', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '279167035', '6715', '5', 1, 'logo.png', 2, 3, 2, 1, 10, 9, 0, 0, 0, 3, 5, 0, 0, 1, '2021-12-24', 'Aucun', ''),
(80, '568', 'Malesuada Integer Id Inc.', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '023018575', '1183', '9', 2, 'logo.png', 2, 6, 2, 6, 8, 9, 0, 0, 0, 6, 1, 0, 0, 2, '2021-03-08', 'Aucun', ''),
(81, '355', 'Velit Cras Lorem Institute', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '620181792', '3385', '9', 2, 'logo.png', 0, 3, 1, 8, 4, 5, 0, 0, 1, 4, 2, 0, 0, 1, '2021-04-06', 'Aucun', ''),
(82, '964', 'Risus LLC', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '373114925', '4025', '8', 1, 'logo.png', 2, 6, 1, 7, 2, 7, 0, 0, 1, 5, 3, 0, 0, 2, '2020-12-08', 'Aucun', ''),
(83, '252', 'Libero Institute', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '420846305', '7308', '4', 4, 'logo.png', 2, 3, 4, 4, 5, 2, 0, 0, 0, 4, 3, 0, 0, 0, '2020-11-20', 'Aucun', ''),
(84, '613', 'Dolor Sit LLC', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '934873639', '7942', '3', 2, 'logo.png', 0, 6, 5, 10, 4, 3, 0, 0, 1, 3, 2, 0, 0, 0, '2021-04-03', 'Aucun', ''),
(85, '329', 'Interdum PC', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '296203532', '7155', '1', 4, 'logo.png', 1, 3, 3, 4, 9, 6, 0, 0, 1, 5, 5, 0, 0, 1, '2019-12-28', 'Aucun', ''),
(86, '805', 'Ipsum Institute', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '648292472', '5015', '7', 2, 'logo.png', 1, 6, 5, 6, 3, 2, 0, 0, 1, 6, 4, 0, 0, 0, '2021-11-03', 'Aucun', ''),
(87, '655', 'Nullam Enim Company', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '088912100', '1188', '3', 1, 'logo.png', 0, 6, 1, 5, 3, 4, 0, 0, 0, 4, 2, 0, 0, 1, '2020-05-11', 'Aucun', ''),
(88, '218', 'Egestas LLC', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '598953966', '9238', '5', 3, 'logo.png', 2, 6, 2, 5, 8, 8, 0, 0, 1, 5, 2, 0, 0, 2, '2021-11-29', 'Aucun', ''),
(89, '958', 'Sit Amet Associates', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '526145354', '9828', '9', 4, 'logo.png', 1, 4, 4, 9, 5, 5, 0, 0, 1, 5, 2, 0, 0, 1, '2020-02-25', 'Aucun', ''),
(90, '947', 'Nunc Sollicitudin Commodo PC', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '957131428', '7337', '6', 2, 'logo.png', 1, 4, 4, 6, 3, 4, 0, 0, 0, 4, 1, 0, 0, 2, '2020-01-28', 'Aucun', ''),
(91, '513', 'Molestie Tellus Incorporated', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '928141886', '2687', '9', 2, 'logo.png', 1, 6, 2, 8, 1, 3, 0, 0, 1, 3, 1, 0, 0, 1, '2020-09-04', 'Aucun', ''),
(92, '354', 'Vel Vulputate Corporation', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '597729540', '7912', '8', 5, 'logo.png', 0, 4, 4, 2, 7, 2, 0, 0, 1, 5, 4, 0, 0, 1, '2021-06-22', 'Aucun', ''),
(93, '46', 'Mauris Magna Duis PC', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '770749687', '3094', '2', 5, 'logo.png', 1, 4, 4, 4, 5, 5, 0, 0, 0, 4, 5, 0, 0, 2, '2020-09-28', 'Aucun', ''),
(94, '685', 'In Lobortis Tellus Ltd', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '174894170', '2457', '6', 4, 'logo.png', 0, 3, 1, 8, 2, 3, 0, 0, 0, 6, 3, 0, 0, 0, '2020-11-29', 'Aucun', ''),
(95, '834', 'Augue Eu Incorporated', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '878724434', '8065', '1', 2, 'logo.png', 0, 5, 4, 9, 7, 2, 0, 0, 0, 5, 4, 0, 0, 1, '2020-03-24', 'Aucun', ''),
(96, '449', 'Lectus Convallis Est Consulting', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '674808746', '4631', '4', 2, 'logo.png', 1, 4, 3, 9, 4, 5, 0, 0, 0, 4, 2, 0, 0, 0, '2021-12-18', 'Aucun', ''),
(97, '663', 'Phasellus In Felis Consulting', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '820970143', '5805', '3', 4, 'logo.png', 1, 6, 4, 3, 3, 3, 0, 0, 0, 6, 4, 0, 0, 1, '2021-05-17', 'Aucun', ''),
(98, '386', 'Erat Eget Industries', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '540691599', '2613', '4', 4, 'logo.png', 2, 5, 1, 9, 1, 9, 0, 0, 0, 5, 3, 0, 0, 2, '2021-01-08', 'Aucun', ''),
(99, '156', 'Gravida Praesent Eu PC', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '563657576', '2046', '2', 5, 'logo.png', 2, 6, 1, 1, 10, 5, 0, 0, 0, 6, 5, 0, 0, 1, '2020-09-02', 'Aucun', ''),
(100, '966', 'Dolor Nulla Semper Corporation', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '442249991', '1713', '1', 1, 'logo.png', 1, 3, 3, 1, 5, 4, 0, 0, 1, 5, 3, 0, 0, 0, '2021-06-27', 'Aucun', ''),
(101, '438', 'Nullam Ut Nisi LLC', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '041208687', '2121', '2', 5, 'logo.png', 2, 6, 5, 7, 9, 5, 0, 0, 1, 5, 1, 0, 0, 0, '2020-01-03', 'Aucun', ''),
(102, '588', 'Ipsum Dolor Limited', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '882379811', '3722', '2', 5, 'logo.png', 2, 3, 1, 3, 5, 8, 0, 0, 1, 4, 5, 0, 0, 2, '2020-02-01', 'Aucun', ''),
(103, '207', 'Est Nunc Incorporated', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '222474272', '5904', '9', 3, 'logo.png', 0, 4, 4, 4, 2, 7, 0, 0, 0, 5, 1, 0, 0, 0, '2020-11-30', 'Aucun', ''),
(104, '752', 'Ultrices Vivamus Rhoncus Limited', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '143753812', '9589', '6', 1, 'logo.png', 1, 6, 1, 8, 3, 6, 0, 0, 1, 5, 2, 0, 0, 2, '2021-05-29', 'Aucun', ''),
(105, '861', 'Eu Ltd', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '534956750', '1817', '1', 1, 'logo.png', 1, 3, 2, 5, 6, 4, 0, 0, 0, 4, 1, 0, 0, 0, '2021-06-21', 'Aucun', ''),
(106, '892', 'Vehicula Pellentesque Tincidunt Industries', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '932464688', '8687', '9', 3, 'logo.png', 2, 5, 3, 3, 10, 1, 0, 0, 1, 5, 4, 0, 0, 2, '2021-02-14', 'Aucun', ''),
(107, '895', 'Sociis PC', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '987977980', '2763', '9', 5, 'logo.png', 2, 3, 4, 1, 2, 4, 0, 0, 0, 3, 3, 0, 0, 0, '2021-12-15', 'Aucun', ''),
(108, '121', 'Nunc Ullamcorper Institute', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '601212350', '5603', '9', 4, 'logo.png', 2, 3, 2, 2, 9, 6, 0, 0, 0, 6, 4, 0, 0, 2, '2020-06-21', 'Aucun', ''),
(109, '838', 'Duis Incorporated', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '777611674', '1767', '9', 1, 'logo.png', 0, 5, 2, 1, 10, 2, 0, 0, 1, 5, 5, 0, 0, 2, '2021-04-13', 'Aucun', ''),
(110, '982', 'Ligula Nullam Corporation', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '118316892', '6276', '2', 3, 'logo.png', 2, 3, 5, 3, 9, 3, 0, 0, 0, 6, 3, 0, 0, 1, '2020-04-05', 'Aucun', ''),
(111, '734', 'Amet Foundation', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '969760206', '5848', '6', 2, 'logo.png', 0, 4, 1, 8, 7, 1, 0, 0, 1, 5, 1, 0, 0, 2, '2020-11-22', 'Aucun', ''),
(112, '533', 'At Velit Industries', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '850856402', '3527', '7', 1, 'logo.png', 0, 6, 4, 5, 9, 7, 0, 0, 0, 4, 4, 0, 0, 2, '2020-07-04', 'Aucun', ''),
(113, '350', 'Feugiat Metus PC', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '264218264', '9920', '7', 4, 'logo.png', 2, 6, 5, 1, 9, 4, 0, 0, 0, 4, 5, 0, 0, 2, '2021-08-23', 'Aucun', ''),
(114, '844', 'Molestie Tellus Corp.', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '894760073', '7003', '2', 2, 'logo.png', 0, 4, 2, 6, 6, 5, 0, 0, 1, 6, 4, 0, 0, 2, '2020-02-03', 'Aucun', ''),
(115, '922', 'Nec Corporation', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '618675094', '6669', '9', 1, 'logo.png', 1, 6, 5, 6, 5, 10, 0, 0, 0, 5, 1, 0, 0, 0, '2021-06-20', 'Aucun', ''),
(116, '558', 'Sit LLP', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '186119954', '6358', '5', 1, 'logo.png', 0, 3, 4, 1, 8, 6, 0, 0, 1, 3, 5, 0, 0, 2, '2021-05-14', 'Aucun', ''),
(117, '900', 'Non Limited', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '621668060', '6905', '8', 4, 'logo.png', 0, 4, 1, 2, 1, 9, 0, 0, 0, 5, 2, 0, 0, 0, '2021-09-16', 'Aucun', ''),
(118, '273', 'Vel Lectus LLP', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '523763746', '4750', '4', 3, 'logo.png', 2, 4, 2, 4, 8, 10, 0, 0, 0, 4, 3, 0, 0, 2, '2021-11-16', 'Aucun', ''),
(119, '345', 'Aliquam Iaculis Lacus Institute', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '631600855', '2315', '8', 3, 'logo.png', 0, 3, 2, 7, 9, 2, 0, 0, 1, 5, 5, 0, 0, 1, '2020-02-29', 'Aucun', ''),
(120, '167', 'Risus Quis Diam PC', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '560931594', '8873', '3', 5, 'logo.png', 2, 6, 1, 10, 6, 10, 0, 0, 1, 6, 4, 0, 0, 0, '2021-10-02', 'Aucun', ''),
(121, '6', 'Tincidunt Foundation', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '573737020', '9918', '5', 3, 'logo.png', 0, 6, 5, 6, 1, 4, 0, 0, 0, 3, 4, 0, 0, 2, '2021-05-27', 'Aucun', ''),
(122, '262', 'Felis Eget PC', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '330464553', '2518', '7', 4, 'logo.png', 2, 5, 4, 7, 9, 7, 0, 0, 1, 6, 5, 0, 0, 0, '2020-02-01', 'Aucun', ''),
(123, '503', 'Eleifend Nunc Corporation', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '294057823', '9347', '5', 5, 'logo.png', 1, 5, 3, 8, 5, 5, 0, 0, 1, 3, 2, 0, 0, 0, '2021-04-22', 'Aucun', ''),
(124, '128', 'Id Enim Curabitur Foundation', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '145088795', '6930', '7', 1, 'logo.png', 2, 5, 4, 5, 3, 8, 0, 0, 0, 4, 1, 0, 0, 1, '2021-03-02', 'Aucun', ''),
(125, '81', 'Libero Et Tristique Incorporated', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '549348340', '9030', '2', 1, 'logo.png', 1, 6, 4, 7, 7, 1, 0, 0, 0, 5, 2, 0, 0, 1, '2021-06-30', 'Aucun', ''),
(126, '927', 'Accumsan Laoreet Company', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '810020685', '9642', '9', 5, 'logo.png', 0, 5, 2, 8, 4, 4, 0, 0, 0, 4, 4, 0, 0, 2, '2021-09-28', 'Aucun', ''),
(127, '473', 'Tincidunt Foundation', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '764945382', '4070', '1', 1, 'logo.png', 0, 5, 4, 6, 3, 4, 0, 0, 0, 3, 5, 0, 0, 2, '2021-12-26', 'Aucun', ''),
(128, '585', 'Duis Cursus Diam LLP', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '394881569', '6090', '5', 3, 'logo.png', 1, 6, 5, 5, 7, 3, 0, 0, 0, 6, 5, 0, 0, 1, '2020-01-31', 'Aucun', ''),
(129, '422', 'Sapien Inc.', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '966665341', '3188', '2', 2, 'logo.png', 2, 3, 3, 4, 8, 3, 0, 0, 0, 5, 2, 0, 0, 1, '2021-12-08', 'Aucun', ''),
(130, '781', 'Dapibus Id Blandit Associates', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '133086371', '1626', '7', 3, 'logo.png', 2, 3, 2, 5, 7, 3, 0, 0, 1, 4, 2, 0, 0, 1, '2019-12-29', 'Aucun', ''),
(131, '415', 'Consectetuer Rhoncus Nullam Foundation', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '979650330', '1347', '5', 4, 'logo.png', 2, 3, 3, 7, 10, 1, 0, 0, 0, 6, 3, 0, 0, 1, '2020-01-10', 'Aucun', ''),
(132, '889', 'Quis Pede PC', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '255898892', '4002', '1', 4, 'logo.png', 2, 4, 2, 6, 9, 10, 0, 0, 0, 3, 3, 0, 0, 2, '2021-10-20', 'Aucun', ''),
(133, '485', 'Interdum Curabitur Incorporated', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '423813286', '4993', '3', 5, 'logo.png', 1, 4, 1, 9, 9, 3, 0, 0, 0, 3, 4, 0, 0, 2, '2021-03-13', 'Aucun', ''),
(134, '379', 'Mi Tempor Incorporated', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '976439307', '2988', '7', 5, 'logo.png', 1, 5, 4, 8, 1, 4, 0, 0, 1, 4, 5, 0, 0, 2, '2020-05-08', 'Aucun', ''),
(135, '479', 'Hendrerit LLC', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '280297813', '3900', '9', 3, 'logo.png', 1, 5, 4, 2, 3, 5, 0, 0, 1, 5, 1, 0, 0, 0, '2021-05-04', 'Aucun', ''),
(136, '700', 'Lectus Ante Institute', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '584760466', '1636', '4', 2, 'logo.png', 2, 5, 3, 2, 10, 2, 0, 0, 0, 4, 3, 0, 0, 2, '2020-10-20', 'Aucun', ''),
(137, '532', 'Molestie Arcu Sed Ltd', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '193730983', '2266', '1', 2, 'logo.png', 0, 3, 3, 5, 2, 7, 0, 0, 1, 6, 1, 0, 0, 0, '2021-06-05', 'Aucun', ''),
(138, '651', 'Justo Sit LLP', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '469574057', '6308', '9', 4, 'logo.png', 0, 6, 3, 6, 8, 9, 0, 0, 0, 5, 3, 0, 0, 0, '2020-11-28', 'Aucun', ''),
(139, '305', 'Quam A Consulting', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '378512750', '9260', '4', 4, 'logo.png', 0, 4, 3, 6, 2, 2, 0, 0, 1, 4, 4, 0, 0, 2, '2021-11-27', 'Aucun', ''),
(140, '259', 'Nibh LLC', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '058487174', '9184', '5', 5, 'logo.png', 2, 3, 1, 3, 9, 3, 0, 0, 0, 3, 3, 0, 0, 0, '2021-07-31', 'Aucun', ''),
(141, '639', 'Natoque Penatibus LLC', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '037875515', '7100', '4', 5, 'logo.png', 0, 6, 4, 4, 6, 8, 0, 0, 0, 5, 1, 0, 0, 2, '2021-07-01', 'Aucun', ''),
(142, '392', 'Pellentesque Massa Limited', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '849207485', '2353', '5', 2, 'logo.png', 1, 3, 4, 9, 9, 1, 0, 0, 0, 3, 5, 0, 0, 2, '2019-12-29', 'Aucun', ''),
(143, '604', 'Nullam LLC', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '401137278', '3204', '7', 4, 'logo.png', 0, 4, 4, 1, 2, 7, 0, 0, 1, 3, 3, 0, 0, 1, '2021-10-12', 'Aucun', ''),
(144, '464', 'Libero At Institute', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '304716590', '4851', '3', 2, 'logo.png', 2, 3, 4, 8, 4, 1, 0, 0, 1, 3, 2, 0, 0, 0, '2019-12-26', 'Aucun', ''),
(145, '383', 'A PC', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '595316571', '4799', '8', 2, 'logo.png', 1, 4, 3, 6, 1, 3, 0, 0, 1, 3, 1, 0, 0, 1, '2021-07-23', 'Aucun', ''),
(146, '847', 'Vitae Semper Corporation', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '848165163', '9513', '4', 1, 'logo.png', 0, 3, 5, 5, 1, 7, 0, 0, 0, 4, 1, 0, 0, 2, '2020-03-25', 'Aucun', ''),
(147, '156', 'Risus Donec Company', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '323158493', '9623', '4', 3, 'logo.png', 1, 6, 3, 8, 1, 3, 0, 0, 1, 6, 3, 0, 0, 1, '2020-04-27', 'Aucun', ''),
(148, '863', 'Scelerisque Scelerisque Dui Incorporated', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '115258907', '5312', '2', 3, 'logo.png', 2, 5, 3, 5, 10, 10, 0, 0, 0, 4, 2, 0, 0, 0, '2020-11-12', 'Aucun', ''),
(149, '472', 'Donec Consectetuer Inc.', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '335078184', '8133', '6', 5, 'logo.png', 0, 5, 5, 9, 6, 3, 0, 0, 1, 6, 1, 0, 0, 0, '2020-08-27', 'Aucun', ''),
(150, '880', 'Gravida Nunc LLC', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '784837866', '6165', '1', 5, 'logo.png', 0, 4, 5, 5, 6, 4, 0, 0, 1, 3, 2, 0, 0, 0, '2020-12-22', 'Aucun', ''),
(151, '200', 'Arcu Associates', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '940226376', '8246', '7', 1, 'logo.png', 1, 5, 1, 10, 10, 9, 0, 0, 1, 6, 1, 0, 0, 1, '2020-09-16', 'Aucun', ''),
(152, '850', 'Ultricies Adipiscing Enim Associates', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '892635897', '8303', '4', 1, 'logo.png', 2, 5, 3, 7, 3, 5, 0, 0, 1, 5, 2, 0, 0, 2, '2021-04-07', 'Aucun', ''),
(153, '885', 'Odio Phasellus LLC', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '319729760', '9393', '1', 2, 'logo.png', 0, 4, 1, 8, 10, 10, 0, 0, 0, 3, 2, 0, 0, 1, '2020-07-29', 'Aucun', ''),
(154, '727', 'In Corporation', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '084615798', '1816', '1', 5, 'logo.png', 1, 3, 4, 3, 3, 6, 0, 0, 1, 5, 2, 0, 0, 0, '2021-02-23', 'Aucun', ''),
(155, '835', 'Nec Institute', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '839520160', '4310', '4', 4, 'logo.png', 0, 4, 1, 7, 9, 3, 0, 0, 1, 3, 3, 0, 0, 0, '2021-04-20', 'Aucun', ''),
(156, '604', 'Turpis Nec Mauris Ltd', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '119446094', '7593', '8', 1, 'logo.png', 1, 6, 4, 8, 8, 9, 0, 0, 0, 4, 3, 0, 0, 1, '2020-02-06', 'Aucun', ''),
(157, '763', 'Feugiat Metus Sit Ltd', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '049139199', '8616', '4', 2, 'logo.png', 1, 6, 1, 8, 3, 4, 0, 0, 0, 4, 1, 0, 0, 0, '2021-08-08', 'Aucun', ''),
(158, '841', 'Quisque LLP', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '266070630', '7584', '7', 2, 'logo.png', 2, 6, 4, 4, 6, 1, 0, 0, 0, 5, 2, 0, 0, 2, '2020-11-01', 'Aucun', ''),
(159, '848', 'Fermentum Convallis Corp.', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '644727513', '6391', '9', 3, 'logo.png', 0, 4, 4, 7, 9, 1, 0, 0, 0, 6, 1, 0, 0, 2, '2021-07-15', 'Aucun', ''),
(160, '338', 'Quisque LLC', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '794605063', '3180', '7', 5, 'logo.png', 0, 6, 4, 3, 8, 1, 0, 0, 1, 4, 1, 0, 0, 0, '2020-09-28', 'Aucun', ''),
(161, '398', 'Pellentesque Sed Dictum Inc.', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '674493341', '9174', '2', 5, 'logo.png', 2, 6, 1, 10, 9, 2, 0, 0, 1, 4, 4, 0, 0, 0, '2021-03-25', 'Aucun', ''),
(162, '335', 'Tempor Est Ac Corporation', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '718195332', '2457', '5', 3, 'logo.png', 1, 4, 5, 1, 2, 8, 0, 0, 0, 5, 4, 0, 0, 1, '2020-01-20', 'Aucun', ''),
(163, '565', 'Enim Sed Nulla Company', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '196293013', '1774', '8', 3, 'logo.png', 1, 6, 3, 7, 5, 10, 0, 0, 0, 6, 1, 0, 0, 1, '2020-12-31', 'Aucun', ''),
(164, '755', 'Primis In Faucibus Corporation', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '769618604', '6271', '9', 4, 'logo.png', 0, 3, 3, 4, 2, 8, 0, 0, 1, 4, 5, 0, 0, 2, '2020-01-18', 'Aucun', ''),
(165, '283', 'Cursus Purus Inc.', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '307779785', '6665', '1', 5, 'logo.png', 0, 5, 5, 3, 2, 2, 0, 0, 0, 3, 1, 0, 0, 0, '2020-02-26', 'Aucun', ''),
(166, '961', 'Mauris Vestibulum Incorporated', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '156788564', '1913', '4', 5, 'logo.png', 1, 4, 5, 10, 2, 8, 0, 0, 0, 6, 5, 0, 0, 2, '2021-09-18', 'Aucun', ''),
(167, '768', 'Tempus Lorem Limited', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '965183783', '8880', '3', 1, 'logo.png', 0, 3, 4, 9, 4, 2, 0, 0, 1, 5, 4, 0, 0, 2, '2020-01-30', 'Aucun', ''),
(168, '385', 'Nec Diam Associates', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '217748938', '3010', '2', 3, 'logo.png', 0, 3, 3, 4, 9, 8, 0, 0, 1, 5, 1, 0, 0, 0, '2021-08-26', 'Aucun', ''),
(169, '795', 'Donec Non Justo Corporation', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '551311244', '3923', '3', 2, 'logo.png', 1, 4, 5, 10, 10, 10, 0, 0, 1, 5, 4, 0, 0, 2, '2021-11-13', 'Aucun', ''),
(170, '567', 'Venenatis Vel Industries', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '244089827', '7114', '6', 5, 'logo.png', 1, 6, 5, 3, 1, 6, 0, 0, 0, 4, 3, 0, 0, 2, '2020-05-12', 'Aucun', ''),
(171, '836', 'Commodo Hendrerit Consulting', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '604561175', '6818', '3', 2, 'logo.png', 1, 3, 1, 1, 10, 5, 0, 0, 0, 4, 1, 0, 0, 1, '2021-05-31', 'Aucun', ''),
(172, '891', 'Adipiscing Inc.', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '255021495', '4939', '7', 3, 'logo.png', 2, 6, 1, 6, 10, 2, 0, 0, 0, 6, 1, 0, 0, 2, '2021-01-13', 'Aucun', ''),
(173, '140', 'Amet Diam Inc.', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '576234710', '8422', '3', 1, 'logo.png', 2, 6, 3, 8, 4, 9, 0, 0, 0, 5, 3, 0, 0, 1, '2021-05-13', 'Aucun', ''),
(174, '199', 'Pede Associates', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '313994477', '2398', '5', 5, 'logo.png', 1, 5, 2, 4, 9, 5, 0, 0, 1, 5, 3, 0, 0, 0, '2021-04-15', 'Aucun', ''),
(175, '672', 'Venenatis Inc.', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '404507881', '1381', '5', 1, 'logo.png', 0, 5, 5, 9, 8, 1, 0, 0, 0, 3, 4, 0, 0, 0, '2020-09-13', 'Aucun', ''),
(176, '913', 'Nunc Pulvinar Incorporated', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '959111550', '3412', '6', 1, 'logo.png', 1, 4, 2, 4, 8, 3, 0, 0, 1, 4, 4, 0, 0, 2, '2020-09-28', 'Aucun', ''),
(177, '810', 'Enim Diam Vel Associates', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '604919084', '7926', '6', 4, 'logo.png', 0, 4, 4, 8, 1, 1, 0, 0, 1, 6, 1, 0, 0, 0, '2020-05-09', 'Aucun', ''),
(178, '990', 'Aliquet Limited', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '787182039', '5140', '4', 5, 'logo.png', 2, 5, 2, 10, 5, 2, 0, 0, 1, 5, 4, 0, 0, 1, '2020-11-27', 'Aucun', ''),
(179, '498', 'Convallis Est Vitae Inc.', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '426516878', '5925', '9', 2, 'logo.png', 0, 6, 4, 7, 5, 8, 0, 0, 1, 4, 4, 0, 0, 0, '2021-06-04', 'Aucun', ''),
(180, '348', 'Lorem Ac Associates', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '483119467', '4962', '8', 2, 'logo.png', 0, 3, 4, 2, 5, 4, 0, 0, 1, 4, 5, 0, 0, 0, '2020-02-19', 'Aucun', ''),
(181, '667', 'Morbi Incorporated', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '198361933', '2208', '5', 2, 'logo.png', 0, 6, 1, 7, 1, 10, 0, 0, 1, 6, 3, 0, 0, 0, '2021-01-24', 'Aucun', ''),
(182, '302', 'Nascetur Ridiculus Limited', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '873263305', '5200', '3', 4, 'logo.png', 0, 3, 2, 6, 3, 6, 0, 0, 0, 3, 3, 0, 0, 2, '2020-06-12', 'Aucun', ''),
(183, '629', 'Odio Corporation', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '556641660', '7565', '2', 3, 'logo.png', 1, 6, 4, 1, 4, 6, 0, 0, 0, 4, 2, 0, 0, 1, '2020-10-16', 'Aucun', ''),
(184, '821', 'Molestie Orci Incorporated', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '407451582', '4600', '9', 4, 'logo.png', 2, 3, 2, 10, 5, 7, 0, 0, 0, 5, 1, 0, 0, 2, '2020-05-23', 'Aucun', ''),
(185, '582', 'Vulputate Dui Nec Foundation', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '071940324', '5696', '1', 5, 'logo.png', 1, 5, 2, 2, 4, 9, 0, 0, 0, 3, 4, 0, 0, 2, '2021-08-12', 'Aucun', ''),
(186, '88', 'Sollicitudin Adipiscing Ligula Associates', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '936845593', '9562', '9', 1, 'logo.png', 0, 3, 2, 10, 4, 8, 0, 0, 0, 5, 2, 0, 0, 2, '2021-06-18', 'Aucun', ''),
(187, '1', 'Scelerisque Mollis Company', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '716729777', '6187', '8', 3, 'logo.png', 1, 5, 4, 9, 8, 10, 0, 0, 1, 3, 1, 0, 0, 0, '2021-03-12', 'Aucun', ''),
(188, '888', 'Luctus Curabitur Foundation', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '713771061', '1751', '9', 2, 'logo.png', 2, 4, 2, 10, 2, 5, 0, 0, 1, 4, 1, 0, 0, 1, '2020-01-20', 'Aucun', ''),
(189, '529', 'Consectetuer Euismod Ltd', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '257102673', '4423', '6', 4, 'logo.png', 1, 5, 2, 1, 1, 10, 0, 0, 0, 4, 5, 0, 0, 2, '2021-12-04', 'Aucun', ''),
(190, '670', 'Sed Et Libero Ltd', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '317128056', '1938', '2', 1, 'logo.png', 0, 3, 3, 9, 5, 10, 0, 0, 0, 4, 4, 0, 0, 1, '2021-12-16', 'Aucun', ''),
(191, '625', 'Enim Commodo Corporation', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '268299260', '6500', '1', 4, 'logo.png', 1, 4, 4, 7, 6, 8, 0, 0, 0, 3, 5, 0, 0, 2, '2020-11-09', 'Aucun', ''),
(192, '731', 'Justo Praesent Luctus Ltd', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '672724770', '5211', '1', 2, 'logo.png', 1, 4, 2, 4, 4, 4, 0, 0, 1, 3, 4, 0, 0, 0, '2021-04-07', 'Aucun', ''),
(193, '267', 'Et Netus LLP', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '237424973', '7322', '7', 4, 'logo.png', 1, 5, 1, 5, 6, 1, 0, 0, 1, 4, 1, 0, 0, 0, '2021-04-16', 'Aucun', ''),
(194, '612', 'Ligula Elit Corporation', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '081547275', '1610', '7', 2, 'logo.png', 0, 6, 5, 1, 3, 5, 0, 0, 0, 4, 4, 0, 0, 0, '2021-08-12', 'Aucun', ''),
(195, '309', 'Duis Cursus Diam Associates', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '191427889', '6736', '1', 2, 'logo.png', 0, 4, 2, 5, 8, 3, 0, 0, 1, 4, 5, 0, 0, 1, '2020-05-04', 'Aucun', ''),
(196, '903', 'Mi Felis LLC', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '159690635', '1670', '3', 1, 'logo.png', 0, 5, 1, 1, 7, 1, 0, 0, 0, 6, 2, 0, 0, 2, '2020-01-16', 'Aucun', ''),
(197, '72', 'Dolor Sit Amet Consulting', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '166582304', '6460', '3', 2, 'logo.png', 2, 6, 4, 2, 4, 1, 0, 0, 0, 4, 3, 0, 0, 1, '2020-07-29', 'Aucun', ''),
(198, '861', 'Non Associates', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '833831019', '2448', '9', 3, 'logo.png', 1, 4, 4, 4, 8, 7, 0, 0, 1, 3, 5, 0, 0, 2, '2020-08-30', 'Aucun', ''),
(199, '709', 'Placerat Inc.', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '698691540', '1510', '3', 1, 'logo.png', 1, 5, 2, 7, 7, 1, 0, 0, 0, 5, 4, 0, 0, 0, '2020-04-24', 'Aucun', ''),
(200, '439', 'Aliquam Eu Accumsan Incorporated', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '948284005', '3674', '3', 2, 'logo.png', 0, 3, 3, 5, 1, 9, 0, 0, 1, 3, 2, 0, 0, 0, '2020-09-23', 'Aucun', ''),
(201, '574', 'Sed Dui Incorporated', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '583829502', '8817', '3', 2, 'logo.png', 1, 5, 5, 9, 8, 6, 0, 0, 0, 5, 4, 0, 0, 1, '2020-01-21', 'Aucun', ''),
(202, '158', 'Ligula Tortor Company', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '649814449', '2437', '5', 1, 'logo.png', 0, 6, 2, 5, 4, 1, 0, 0, 1, 5, 5, 0, 0, 2, '2020-11-25', 'Aucun', ''),
(203, '513', 'Suspendisse Ac Metus Company', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '104915657', '5935', '1', 2, 'logo.png', 2, 5, 1, 9, 10, 8, 0, 0, 0, 3, 2, 0, 0, 2, '2021-02-28', 'Aucun', ''),
(204, '59', 'Metus Facilisis Lorem Inc.', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '126144575', '4696', '6', 1, 'logo.png', 0, 6, 1, 5, 7, 2, 0, 0, 1, 4, 2, 0, 0, 1, '2020-09-03', 'Aucun', ''),
(205, '561', 'Venenatis Incorporated', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '620827246', '5637', '5', 2, 'logo.png', 1, 5, 5, 5, 9, 3, 0, 0, 1, 6, 5, 0, 0, 0, '2021-01-28', 'Aucun', ''),
(206, '64', 'Nam Corporation', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '605350099', '6491', '7', 4, 'logo.png', 1, 4, 4, 2, 8, 8, 0, 0, 0, 3, 5, 0, 0, 1, '2021-03-15', 'Aucun', ''),
(207, '883', 'Aliquet Incorporated', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '184341618', '6102', '3', 5, 'logo.png', 1, 4, 2, 3, 3, 9, 0, 0, 0, 3, 2, 0, 0, 1, '2021-07-04', 'Aucun', ''),
(208, '604', 'Amet Consectetuer Institute', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '234191153', '3032', '3', 3, 'logo.png', 1, 3, 5, 3, 4, 2, 0, 0, 0, 6, 5, 0, 0, 2, '2021-10-14', 'Aucun', ''),
(209, '232', 'Rutrum Non Associates', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '160769543', '6404', '6', 1, 'logo.png', 0, 4, 2, 9, 3, 5, 0, 0, 0, 6, 1, 0, 0, 1, '2020-12-08', 'Aucun', ''),
(210, '966', 'Blandit Congue In LLC', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '496180308', '4230', '3', 4, 'logo.png', 1, 6, 3, 8, 9, 1, 0, 0, 0, 4, 5, 0, 0, 1, '2020-11-04', 'Aucun', ''),
(211, '328', 'Turpis Aliquam Industries', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '179157789', '6388', '2', 1, 'logo.png', 2, 4, 5, 8, 7, 9, 0, 0, 0, 3, 1, 0, 0, 2, '2020-09-20', 'Aucun', ''),
(212, '285', 'Nunc Consulting', 'www.website.com', 'www.website.com', 'www.website.com', 'www.website.com', '087347431', '3438', '2', 2, 'logo.png', 1, 5, 2, 2, 2, 4, 0, 0, 0, 3, 5, 0, 0, 1, '2021-06-24', 'Aucun', '');

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
(1, 'CDE201205-002', '1', '', '', 9, 1, 0, 0, '2020-12-05', 1, 1, 2, 0, '', 9, 5, 0, 0, '');

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
(1, '0', '2', '0', '4000', '0', '0', '679214987', '0', '0', '0', '0', '0', 'images/unnamed.jpg', '362', '12347', '0', 20, '0', '400');

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
(3, 1, 1, 1, 'Julie', 'SOUCHIER', 'Acheteuse', 3, '02.64.25.25', '', '');

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
(1, 2, '3MOIS1', '33.333', '33.333', 8, 1, 0),
(2, 2, '3MOIS2', '33.333', '33.333', 8, 1, 0),
(3, 2, '3MOIS3', '33.330', '33.334', 8, 1, 0);

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
-- Structure de la table `imputation_comptables_prestations`
--

DROP TABLE IF EXISTS `imputation_comptables_prestations`;
CREATE TABLE IF NOT EXISTS `imputation_comptables_prestations` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `PRESTATION_ID` int(11) NOT NULL,
  `ORDRE` int(11) NOT NULL,
  `IMPUTATION_ID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `imputation_comptables_prestations`
--

INSERT INTO `imputation_comptables_prestations` (`ID`, `PRESTATION_ID`, `ORDRE`, `IMPUTATION_ID`) VALUES
(1, 4, 10, 1);

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
(1, 10, 23, 22, 'Tole', '1.000', 5, '2.000', '2.000'),
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
(4, 0, 'ST<AA><MM><JJ>-<I>', 3, 0),
(5, 0, 'DV<AA><MM><JJ>-<I>', 2, 4);

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
  `PROVIDER_ID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `prestations`
--

INSERT INTO `prestations` (`id`, `CODE`, `ORDRE`, `LABEL`, `TYPE`, `TAUX_H`, `MARGE`, `COLOR`, `IMAGE`, `PROVIDER_ID`) VALUES
(1, 'MAT', 2, 'Tôle', 3, 0, 20, '#8fd548', '', '9,11,12'),
(2, 'LAS', 20, 'laser', 1, 110, 0, '#da1010', '', '0'),
(3, 'PROFILE', 3, 'Profilé', 4, 0, 0, '#39c926', '', '0'),
(4, 'PFTOL', 0, 'Produit finie de tolerie', 8, 10, 10, '#41c6c8', '', '0'),
(6, 'PLI', 40, 'Pliage', 1, 50, 0, '#5ebbe4', '', '0'),
(7, 'ETU', 5, 'Etude', 1, 50, 0, '#f07c24', '', '0'),
(8, 'SOUDT', 50, 'Soudure TIG', 1, 60, 0, '#fbff05', '', '0'),
(9, 'SOUDM', 60, 'Soudure MIG', 1, 50, 0, '#afa72c', '', '0'),
(10, 'PARA', 70, 'Parachèvemet', 1, 45, 0, '#9e0000', '', '0'),
(11, 'EMB', 90, 'Emballage', 1, 50, 0, '#0818f7', '', '0'),
(12, 'TRANSEXT', 110, 'Transport externe', 7, 0, 0, '#0afbff', '', '0'),
(13, 'PAINT', 100, 'Peinture', 7, 0, 0, '#f019a1', '', '0'),
(14, 'ACHAT', 4, 'Consomables', 6, 0, 0, '#f20202', '', '9');

-- --------------------------------------------------------

--
-- Structure de la table `ql_action`
--

DROP TABLE IF EXISTS `ql_action`;
CREATE TABLE IF NOT EXISTS `ql_action` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `DATE` date NOT NULL,
  `CREATEUR_ID` int(11) NOT NULL,
  `TYPE` int(11) NOT NULL,
  `STATU` int(11) NOT NULL,
  `RESP_ID` int(11) NOT NULL,
  `PB_DESCP` text COLLATE utf8_unicode_ci NOT NULL,
  `CAUSE` text COLLATE utf8_unicode_ci NOT NULL,
  `ACTION` text COLLATE utf8_unicode_ci NOT NULL,
  `COLOR` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `NFC_ID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `ql_action`
--

INSERT INTO `ql_action` (`id`, `CODE`, `LABEL`, `DATE`, `CREATEUR_ID`, `TYPE`, `STATU`, `RESP_ID`, `PB_DESCP`, `CAUSE`, `ACTION`, `COLOR`, `NFC_ID`) VALUES
(1, 'ACT000001', 'test update', '2020-12-27', 1, 2, 2, 1, 'test', 'test', 'test', '#d10000', 1),
(2, 'ACT000002', 'test création', '2020-12-27', 1, 1, 1, 1, '', '', '', '#000000', 0);

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
  `PICTURE_DEVICES` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `ql_appareil_mesure`
--

INSERT INTO `ql_appareil_mesure` (`id`, `CODE`, `LABEL`, `RESSOURCE_ID`, `USER_ID`, `SERIAL_NUMBER`, `DATE`, `PICTURE_DEVICES`) VALUES
(1, 'PIED', 'pied à coulisse', 1, 1, '1235467', '2020-10-31', '45921.jpg'),
(2, 'PILCAL14', 'Pige de calage 14 x 125', 2, 36, '165477', '2021-02-28', '');

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
-- Structure de la table `ql_derogation`
--

DROP TABLE IF EXISTS `ql_derogation`;
CREATE TABLE IF NOT EXISTS `ql_derogation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `DATE` date NOT NULL,
  `CREATEUR_ID` int(11) NOT NULL,
  `TYPE` int(11) NOT NULL,
  `ETAT` int(11) NOT NULL,
  `RESP_ID` int(11) NOT NULL,
  `PB_DESCP` text COLLATE utf8_unicode_ci NOT NULL,
  `PROPOSAL` text COLLATE utf8_unicode_ci NOT NULL,
  `REPLY` int(11) NOT NULL,
  `COMMENT` text COLLATE utf8_unicode_ci NOT NULL,
  `NFC_ID` int(11) NOT NULL,
  `DECISION` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `ql_derogation`
--

INSERT INTO `ql_derogation` (`id`, `CODE`, `LABEL`, `DATE`, `CREATEUR_ID`, `TYPE`, `ETAT`, `RESP_ID`, `PB_DESCP`, `PROPOSAL`, `REPLY`, `COMMENT`, `NFC_ID`, `DECISION`) VALUES
(1, 'DER000001', 'validation création', '2020-12-27', 1, 1, 1, 1, '', '', 1, '', 1, ''),
(6, 'DER000006', 'validation numéro', '2020-12-27', 1, 1, 1, 1, '', '', 1, '', 0, ''),
(5, 'DER000001', 'validation modification', '2020-12-27', 1, 1, 2, 1, 'test', 'test', 2, 'test', 0, 'test');

-- --------------------------------------------------------

--
-- Structure de la table `ql_nfc`
--

DROP TABLE IF EXISTS `ql_nfc`;
CREATE TABLE IF NOT EXISTS `ql_nfc` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ETAT` int(11) NOT NULL,
  `DATE` date NOT NULL,
  `TYPE` int(11) NOT NULL,
  `CREATEUR_ID` int(11) NOT NULL,
  `CAUSED_BY_ID` int(11) NOT NULL,
  `SECTION_ID` int(11) NOT NULL,
  `RESSOURCE_ID` int(11) NOT NULL,
  `DEFAUT_ID` int(11) NOT NULL,
  `DEFAUT_COMMENT` text COLLATE utf8_unicode_ci NOT NULL,
  `CAUSE_ID` int(11) NOT NULL,
  `CAUSE_COMMENT` text COLLATE utf8_unicode_ci NOT NULL,
  `CORRECTION_ID` int(11) NOT NULL,
  `CORRECTION_COMMENT` text COLLATE utf8_unicode_ci NOT NULL,
  `COMMENT` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `ql_nfc`
--

INSERT INTO `ql_nfc` (`ID`, `CODE`, `LABEL`, `ETAT`, `DATE`, `TYPE`, `CREATEUR_ID`, `CAUSED_BY_ID`, `SECTION_ID`, `RESSOURCE_ID`, `DEFAUT_ID`, `DEFAUT_COMMENT`, `CAUSE_ID`, `CAUSE_COMMENT`, `CORRECTION_ID`, `CORRECTION_COMMENT`, `COMMENT`) VALUES
(1, 'FNC000001', 'test', 1, '2020-12-27', 1, 1, 1, 7, 3, 1, 'test', 1, 'test', 2, 'test', 'test'),
(2, 'FNC000002', 'test', 1, '2020-12-28', 2, 1, 1, 0, 0, 0, '', 0, '', 0, '', '');

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
  `PRESTATION_ID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `COMMENT` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `ressource`
--

INSERT INTO `ressource` (`id`, `CODE`, `LABEL`, `IMAGE`, `MASK_TIME`, `ORDRE`, `CAPACITY`, `SECTION_ID`, `COLOR`, `PRESTATION_ID`, `COMMENT`) VALUES
(1, 'LASER1', 'Laser trumpf', 'images/Ressources/TruLaser-3030-L20.jpg', 0, 10, '71', 4, '#d01616', '2', 'test'),
(2, 'LASER2', 'Laser Bystronic', 'images/Ressources/téléchargement (1).jpg', 0, 20, '70', 4, '#dd4b4b', '2', ''),
(3, 'PLIEUSE1', 'PLieuse Perrot', 'images/Ressources/téléchargement.jpg', 0, 30, '35', 5, '#39a923', '6', ''),
(4, 'PLIEUSE2', 'Plieuse Amada', 'images/Ressources/527.jpg', 0, 40, '35', 5, '#000000', '', ''),
(5, 'POINC', 'Poinçonneuse Primat', 'images/Ressources/7222.jpg', 0, 25, '30', 4, '#b56e2c', '', ''),
(7, 'USI', 'Centre d\'usinage Mazak', 'images/Ressources/téléchargement (2).jpg', 0, 50, '25', 7, '#4ba7be', '', ''),
(8, 'SOUD', 'Soudure MIG', 'images/Ressources/soudure-jpg5d405386fe9b670001920b04.jpg', 0, 60, '30', 6, '#db8814', '', ''),
(9, 'SOUD2', 'Soudure TIG', 'images/Ressources/téléchargement (3).jpg', 0, 65, '30', 6, '#7c4c27', '8', ''),
(10, 'EMB', 'Emballage', 'images/Ressources/product_9722964b.jpg', 0, 70, '32', 8, '#e9cd16', '11', '');

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
  `PASSWORD` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `FONCTION` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `SECTION_ID` int(11) NOT NULL,
  `LANGUAGE` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idUSER`)
) ENGINE=InnoDB AUTO_INCREMENT=212 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`idUSER`, `CODE`, `NOM`, `PRENOM`, `DATE_NAISSANCE`, `MAIL`, `NUMERO_PERSO`, `NUMERO_INTERNE`, `IMAGE_PROFIL`, `STATU`, `CONNEXION`, `NAME`, `PASSWORD`, `FONCTION`, `SECTION_ID`, `LANGUAGE`) VALUES
(1, 'U33', 'Kévin', 'Duchamp', '2020-11-18', 'kevin.duchamps@mail.fr', '0697764654', '553', 'img_avatar.png', '1', 1608917003, 'Billy', '$2y$10$6t9BuSEAJp.KYZxobYRqdOdTicOIFBudoRC2OW0seV/MujJ5jDugq', '1', 1, 'en'),
(35, 'GH', 'Gareth', 'Head', '1990-05-11', 'tempus@odio.ca', '06 97 67 67 53', '08 38 54 38 04', 'img_avatar.png', '1', 1637099054, 'Gareth', 'a', '4', 0, 'fr'),
(36, 'Z', 'Elton', 'Stephens', '1977-01-18', 'sem.Nulla.interdum@odioPhasellusat.com', '06 42 10 41 36', '09 86 09 50 06', 'img_avatar.png', '1', 1591554783, 'Elton', 'a', '6', 1, 'fr'),
(37, 'V', 'Sean', 'Conway', '1979-02-12', 'ultricies.adipiscing@temporest.org', '06 02 61 47 58', '05 32 23 72 50', 'img_avatar.png', '1', 1618408924, 'Sean', 'a', '5', 6, 'fr'),
(38, 'O', 'Raphael', 'Combs', '1985-07-20', 'lectus.Nullam.suscipit@lorem.org', '06 59 72 42 60', '04 45 04 97 22', 'img_avatar.png', '1', 1599887950, 'Raphael', 'a', '6', 6, 'fr'),
(39, 'K', 'Courtney', 'Fox', '1983-11-04', 'at@Aeneangravidanunc.org', '06 08 31 53 49', '08 79 25 82 98', 'img_avatar.png', '1', 1588754342, 'Courtney', 'a', '4', 1, 'fr'),
(40, 'Y', 'Aquila', 'Browning', '1987-02-18', 'vitae.sodales@dolor.org', '06 80 75 94 40', '03 99 60 94 56', 'img_avatar.png', '1', 1582903784, 'Aquila', 'a', '6', 6, 'fr'),
(41, 'I', 'Kane', 'Tanner', '1977-02-27', 'aliquam.eu@acmi.edu', '06 00 30 68 52', '08 11 80 68 48', 'img_avatar.png', '1', 1625204548, 'Kane', 'a', '7', 5, 'fr'),
(42, 'W', 'Dakota', 'Leonard', '2003-12-27', 'non@velitCraslorem.org', '06 50 07 07 62', '06 19 10 79 16', 'img_avatar.png', '1', 1601519187, 'Dakota', 'a', '4', 4, 'fr'),
(43, 'W', 'Aileen', 'Gilbert', '1982-06-28', 'magna.et@mattisornare.net', '06 63 60 24 78', '09 58 67 68 99', 'img_avatar.png', '1', 1598730055, 'Aileen', 'a', '4', 5, 'fr'),
(44, 'S', 'Mariam', 'Lott', '1999-01-19', 'risus.Nulla@ategestasa.com', '06 37 50 45 08', '01 75 67 69 85', 'img_avatar.png', '1', 1601834644, 'Mariam', 'a', '7', 8, 'fr'),
(45, 'M', 'Brendan', 'Durham', '1990-05-17', 'eget.massa@ipsumnuncid.com', '06 79 71 67 80', '01 78 38 39 77', 'img_avatar.png', '1', 1632393766, 'Brendan', 'a', '3', 5, 'fr'),
(46, 'T', 'Alexis', 'Turner', '1990-08-17', 'orci.luctus@sitametnulla.org', '06 30 47 94 89', '01 62 89 98 51', 'img_avatar.png', '1', 1636375338, 'Alexis', 'a', '8', 6, 'fr'),
(47, 'O', 'Ramona', 'Haynes', '1992-06-13', 'dolor.Nulla.semper@imperdietornare.com', '06 51 10 42 55', '08 13 34 50 52', 'img_avatar.png', '1', 1639447768, 'Ramona', 'a', '4', 7, 'fr'),
(48, 'H', 'Jocelyn', 'Gamble', '1976-12-31', 'vulputate@vitae.net', '06 43 91 64 28', '09 72 41 72 72', 'img_avatar.png', '1', 1628135097, 'Jocelyn', 'a', '6', 7, 'fr'),
(49, 'L', 'Hanae', 'Butler', '2003-05-14', 'at@consequat.com', '06 58 49 70 01', '09 43 10 30 40', 'img_avatar.png', '1', 1640067051, 'Hanae', 'a', '7', 1, 'fr'),
(50, 'T', 'Tamara', 'Delaney', '1999-05-28', 'Quisque.purus@PhasellusornareFusce.co.uk', '06 57 34 27 78', '01 64 04 32 91', 'img_avatar.png', '1', 1590625230, 'Tamara', 'a', '4', 8, 'fr'),
(51, 'J', 'Xaviera', 'Howe', '1986-07-06', 'sagittis.semper.Nam@interdumenim.org', '06 39 17 73 87', '05 23 93 20 52', 'img_avatar.png', '1', 1589910201, 'Xaviera', 'a', '8', 6, 'fr'),
(52, 'X', 'Ishmael', 'Jackson', '1993-02-01', 'mollis.dui.in@venenatislacusEtiam.org', '06 68 35 87 90', '04 33 78 88 46', 'img_avatar.png', '1', 1579745037, 'Ishmael', 'a', '5', 6, 'fr'),
(53, 'H', 'Tamara', 'Burt', '1993-06-11', 'pellentesque@quamelementum.co.uk', '06 39 32 54 96', '08 62 38 53 80', 'img_avatar.png', '1', 1591654846, 'Tamara', 'a', '8', 4, 'fr'),
(54, 'I', 'Tara', 'Winters', '2002-08-09', 'Etiam.imperdiet@nequetellus.net', '06 69 27 64 79', '06 18 32 27 26', 'img_avatar.png', '1', 1622676729, 'Tara', 'a', '4', 5, 'fr'),
(55, 'X', 'Rina', 'Solomon', '2000-05-05', 'Duis@Cum.edu', '06 93 99 04 50', '04 33 31 96 76', 'img_avatar.png', '1', 1632504578, 'Rina', 'a', '4', 5, 'fr'),
(56, 'P', 'Gary', 'Curry', '2001-07-05', 'ipsum@neque.net', '06 68 67 15 57', '05 46 51 19 16', 'img_avatar.png', '1', 1589907785, 'Gary', 'a', '6', 8, 'fr'),
(57, 'W', 'Hope', 'Joseph', '1981-04-29', 'mollis.lectus.pede@nunc.edu', '06 09 31 53 27', '03 92 26 55 52', 'img_avatar.png', '1', 1622761314, 'Hope', 'a', '3', 8, 'fr'),
(58, 'X', 'Aristotle', 'Reese', '1980-08-23', 'vestibulum@non.ca', '06 55 94 74 38', '07 66 10 19 23', 'img_avatar.png', '1', 1619436547, 'Aristotle', 'a', '4', 6, 'fr'),
(211, 'X', 'Aristotl', 'Rees', '2020-12-27', '', '', '', '', '1', 1609024106, 'Aristotle', '', '5', 0, '1');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
