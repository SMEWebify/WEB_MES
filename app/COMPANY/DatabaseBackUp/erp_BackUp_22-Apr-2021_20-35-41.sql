-- ----------------------
-- dump de la base erp au 22-Apr-2021
-- ----------------------


-- 
-- Structure de la table ac_accounting_allocation
-- 
CREATE TABLE `ac_accounting_allocation` (
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
-- Structure de la table ac_accounting_allocation_lines
-- 
CREATE TABLE `ac_accounting_allocation_lines` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ARTICLE_ID` int(11) NOT NULL,
  `ORDRE` int(11) NOT NULL,
  `IMPUTATION_ID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Structure de la table ac_accounting_allocation_services
-- 
CREATE TABLE `ac_accounting_allocation_services` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `PRESTATION_ID` int(11) NOT NULL,
  `ORDRE` int(11) NOT NULL,
  `IMPUTATION_ID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Structure de la table ac_delivery
-- 
CREATE TABLE `ac_delivery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Structure de la table ac_payment_condition
-- 
CREATE TABLE `ac_payment_condition` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `NBR_MOIS` int(11) NOT NULL,
  `NBR_JOURS` int(11) NOT NULL,
  `FIN_MOIS` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Structure de la table ac_payment_method
-- 
CREATE TABLE `ac_payment_method` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `CODE_COMPTABLE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Structure de la table ac_timeline_paiement
-- 
CREATE TABLE `ac_timeline_paiement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Structure de la table ac_timeline_paiement_lines
-- 
CREATE TABLE `ac_timeline_paiement_lines` (
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
-- Structure de la table ac_vat
-- 
CREATE TABLE `ac_vat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `TAUX` decimal(10,3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Structure de la table companies
-- 
CREATE TABLE `companies` (
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
-- Structure de la table companies_addresses
-- 
CREATE TABLE `companies_addresses` (
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
-- Structure de la table companies_contact
-- 
CREATE TABLE `companies_contact` (
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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Structure de la table company_activity_sector
-- 
CREATE TABLE `company_activity_sector` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Structure de la table company_document_numbering
-- 
CREATE TABLE `company_document_numbering` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `DOC_TYPE` int(11) NOT NULL,
  `MODEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `DIGIT` int(11) NOT NULL,
  `COMPTEUR` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Structure de la table company_email_type
-- 
CREATE TABLE `company_email_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `OBJET` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `TEXT` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Structure de la table company_rights
-- 
CREATE TABLE `company_rights` (
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
-- Structure de la table company_setting
-- 
CREATE TABLE `company_setting` (
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
  `PICTURE_COMPANY` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `SIREN` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `APE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `TVA_INTRA` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `TAUX_TVA` int(11) NOT NULL,
  `CAPITAL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `RCS` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Structure de la table company_timeline
-- 
CREATE TABLE `company_timeline` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ETAT` int(11) NOT NULL,
  `TIMESTAMP` int(11) NOT NULL,
  `TEXT` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Structure de la table company_user
-- 
CREATE TABLE `company_user` (
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
-- Structure de la table methods_resource
-- 
CREATE TABLE `methods_resource` (
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
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Structure de la table methods_section
-- 
CREATE TABLE `methods_section` (
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
-- Structure de la table methods_services
-- 
CREATE TABLE `methods_services` (
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
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Structure de la table methods_stock_zone
-- 
CREATE TABLE `methods_stock_zone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `RESSOURCE_ID` int(11) NOT NULL,
  `COLOR` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Structure de la table order_acknowledgment
-- 
CREATE TABLE `order_acknowledgment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ORDER_ID` int(11) NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `DATE` date NOT NULL,
  `ETAT` int(11) NOT NULL,
  `CREATEUR_ID` int(11) NOT NULL,
  `INCOTERM` int(11) NOT NULL,
  `COMENT` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Structure de la table order_acknowledgment_lines
-- 
CREATE TABLE `order_acknowledgment_lines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ORDER_ACKNOWLEGMENT_ID` int(11) NOT NULL,
  `ORDER_ID` int(11) NOT NULL,
  `ORDRE` int(11) NOT NULL,
  `ORDER_LINE_ID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=91 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Structure de la table order_date_plan_task
-- 
CREATE TABLE `order_date_plan_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ORDER_TECHNICAL_CUT_ID` int(11) NOT NULL,
  `ORDER_LINE_ID` int(11) NOT NULL,
  `START_TIMESTAMPS` int(11) NOT NULL,
  `END_START_TIMESTAMPS` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=151 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Structure de la table order_nomenclature
-- 
CREATE TABLE `order_nomenclature` (
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
) ENGINE=MyISAM AUTO_INCREMENT=66 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Structure de la table order_sub_assembly
-- 
CREATE TABLE `order_sub_assembly` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `PARENT_ID` int(11) NOT NULL,
  `ORDRE` int(11) NOT NULL,
  `ARTICLE_ID` int(11) NOT NULL,
  `QT` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Structure de la table order_technical_cut
-- 
CREATE TABLE `order_technical_cut` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ARTICLE_ID` int(11) NOT NULL,
  `ORDRE` int(11) NOT NULL,
  `PRESTA_ID` int(11) NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `TPS_PREP` decimal(10,3) NOT NULL,
  `TPS_PRO` decimal(10,3) NOT NULL,
  `COUT` decimal(10,3) NOT NULL,
  `PRIX` decimal(10,3) NOT NULL,
  `ETAT` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=307 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Structure de la table orders
-- 
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `INDICE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL_INDICE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `CUSTOMER_ID` int(11) NOT NULL,
  `CONTACT_ID` int(11) NOT NULL,
  `ADRESSE_ID` int(11) NOT NULL,
  `FACTURATION_ID` int(11) NOT NULL,
  `DATE` date NOT NULL,
  `ETAT` int(11) NOT NULL,
  `CREATEUR_ID` int(11) NOT NULL,
  `RESP_COM_ID` int(11) NOT NULL,
  `RESP_TECH_ID` int(11) NOT NULL,
  `REFERENCE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `COND_REG_CUSTOMER_ID` int(11) NOT NULL,
  `MODE_REG_CUSTOMER_ID` int(11) NOT NULL,
  `ECHEANCIER_ID` int(11) NOT NULL,
  `TRANSPORT_ID` int(11) NOT NULL,
  `COMENT` text COLLATE utf8_unicode_ci NOT NULL,
  `QUOTE_ID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Structure de la table orders_lines
-- 
CREATE TABLE `orders_lines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ORDER_ID` int(11) NOT NULL,
  `ORDRE` int(11) NOT NULL,
  `ARTICLE_CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `QT` int(11) NOT NULL,
  `UNIT_ID` int(11) NOT NULL,
  `PRIX_U` decimal(10,3) NOT NULL,
  `REMISE` decimal(10,3) NOT NULL,
  `TVA_ID` int(11) NOT NULL,
  `DELAIS_INTERNE` date NOT NULL,
  `DELAIS` date NOT NULL,
  `ETAT` int(11) NOT NULL,
  `AR` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=126 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Structure de la table purchase_request
-- 
CREATE TABLE `purchase_request` (
  `id` int(11) NOT NULL,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `INDICE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL_INDICE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `DATE` date NOT NULL,
  `DATE_REQUIREMENT` date NOT NULL,
  `ETAT` int(11) NOT NULL,
  `CREATEUR_ID` int(11) NOT NULL,
  `COMENT` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Structure de la table purchase_request_lines
-- 
CREATE TABLE `purchase_request_lines` (
  `id` int(11) NOT NULL,
  `PURCHASE_REQUEST_ID` int(11) NOT NULL,
  `TASK_ID` int(11) NOT NULL,
  `ORDRE` int(11) NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `QT` int(11) NOT NULL,
  `UNIT_ID` int(11) NOT NULL,
  `PRIX_U` decimal(10,3) NOT NULL,
  `ETAT` int(11) NOT NULL,
  `ORDER_ID` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Structure de la table ql_action
-- 
CREATE TABLE `ql_action` (
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
-- Structure de la table ql_appareil_mesure
-- 
CREATE TABLE `ql_appareil_mesure` (
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
-- Structure de la table ql_causes
-- 
CREATE TABLE `ql_causes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Structure de la table ql_corrections
-- 
CREATE TABLE `ql_corrections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Structure de la table ql_defaut
-- 
CREATE TABLE `ql_defaut` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Structure de la table ql_derogation
-- 
CREATE TABLE `ql_derogation` (
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
-- Structure de la table ql_nfc
-- 
CREATE TABLE `ql_nfc` (
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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Structure de la table quote
-- 
CREATE TABLE `quote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `INDICE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL_INDICE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `CUSTOMER_ID` int(11) NOT NULL,
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
  `COND_REG_CUSTOMER_ID` int(11) NOT NULL,
  `MODE_REG_CUSTOMER_ID` int(11) NOT NULL,
  `ECHEANCIER_ID` int(11) NOT NULL,
  `TRANSPORT_ID` int(11) NOT NULL,
  `COMENT` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Structure de la table quote_lines
-- 
CREATE TABLE `quote_lines` (
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
) ENGINE=MyISAM AUTO_INCREMENT=70 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Structure de la table quote_nomenclature
-- 
CREATE TABLE `quote_nomenclature` (
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
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Structure de la table quote_sub_assembly
-- 
CREATE TABLE `quote_sub_assembly` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `PARENT_ID` int(11) NOT NULL,
  `ORDRE` int(11) NOT NULL,
  `ARTICLE_ID` int(11) NOT NULL,
  `QT` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Structure de la table quote_technical_cut
-- 
CREATE TABLE `quote_technical_cut` (
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
) ENGINE=MyISAM AUTO_INCREMENT=65 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Structure de la table study_standard_article
-- 
CREATE TABLE `study_standard_article` (
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
) ENGINE=MyISAM AUTO_INCREMENT=76 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Structure de la table study_standard_nomenclature
-- 
CREATE TABLE `study_standard_nomenclature` (
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
-- Structure de la table study_standard_sub_assembly
-- 
CREATE TABLE `study_standard_sub_assembly` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `PARENT_ID` int(11) NOT NULL,
  `ORDRE` int(11) NOT NULL,
  `ARTICLE_ID` int(11) NOT NULL,
  `QT` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Structure de la table study_standard_technical_cut
-- 
CREATE TABLE `study_standard_technical_cut` (
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
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Structure de la table study_sub_familly
-- 
CREATE TABLE `study_sub_familly` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `PRESTATION_ID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Structure de la table study_unit
-- 
CREATE TABLE `study_unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `TYPE` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Structure de la table time_absence_type
-- 
CREATE TABLE `time_absence_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `PAYE` int(11) NOT NULL,
  `COLOR` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `TYPE_JOUR` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Structure de la table time_bank_holiday
-- 
CREATE TABLE `time_bank_holiday` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FIXE` int(11) NOT NULL,
  `DATE` date NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Structure de la table time_daily_hourly_model
-- 
CREATE TABLE `time_daily_hourly_model` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CODE` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Structure de la table time_daily_hourly_model_line
-- 
CREATE TABLE `time_daily_hourly_model_line` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `MODEL_ID` int(11) NOT NULL,
  `ORDRE` int(11) NOT NULL,
  `TYPE` int(11) NOT NULL,
  `START` time NOT NULL,
  `END` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Structure de la table time_event_machine
-- 
CREATE TABLE `time_event_machine` (
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
-- Structure de la table time_improductive_activity
-- 
CREATE TABLE `time_improductive_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `LABEL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ETAT_MACHINE` int(11) NOT NULL,
  `RESSOURCE_NEC` int(11) NOT NULL,
  `MASK_TIME` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

