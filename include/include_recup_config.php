<?php


//TABLE
define('TABLE_ERP_ACTIVITY_SECTOR', 'activity_sector');
define('TABLE_ERP_ARTICLE', 'article');
define('TABLE_ERP_ADRESSE', 'adresses');
define('TABLE_ERP_CLIENT_FOUR', 'client_fourniseur');
define('TABLE_ERP_COMMANDE', 'commande');
define('TABLE_ERP_COMMANDE_LIGNE', 'commande_ligne');
define('TABLE_ERP_COMPANY', 'company_setting');
define('TABLE_ERP_CONDI_REG', 'condition_reg');
define('TABLE_ERP_CONTACT', 'contact');
define('TABLE_ERP_DEC_TECH', 'decoupage_tech');
define('TABLE_ERP_DEVIS', 'devis');
define('TABLE_ERP_DEVIS_LIGNE', 'devis_lignes');
define('TABLE_ERP_ECHEANCIER_TYPE', 'echeancier_type');
define('TABLE_ERP_ECHEANCIER_TYPE_LIGNE', 'echeancier_type_ligne');
define('TABLE_ERP_EMAIL', 'email');
define('TABLE_ERP_EVENT_MACHINE', 'evenement_machine');
define('TABLE_ERP_EVENT_IMPRODUC_TIME', 'improductive_activity');
define('TABLE_ERP_IMPUT_COMPTA', 'imputation_comptables');
define('TABLE_ERP_IMPUT_COMPTA_LIGNE', 'imputation_comptables_ligne');
define('TABLE_ERP_INFO_GENERAL', 'infos_generales'); 
define('TABLE_ERP_FERIER', 'jours_feries');
define('TABLE_ERP_MODE_REG', 'mode_reglement');
define('TABLE_ERP_NOMENCLATURE', 'nomenclature');
define('TABLE_ERP_NUM_DOC', 'num_doc');
define('TABLE_ERP_PLANNING', 'planning'); //OLD
define('TABLE_ERP_PRESTATION', 'prestations');
define('TABLE_ERP_QL_APP_MESURE', 'ql_appareil_mesure');
define('TABLE_ERP_QL_CAUSES', 'ql_causes');
define('TABLE_ERP_QL_CORRECTIONS', 'ql_corrections');
define('TABLE_ERP_DEFAUT', 'ql_defaut');
define('TABLE_ERP_RESSOURCE', 'ressource');
define('TABLE_ERP_RIGHTS', 'rights');
define('TABLE_ERP_SECTION', 'section');
define('TABLE_ERP_SOUS_ENSEMBLE', 'sous_ensemble');
define('TABLE_ERP_SOUS_FAMILLE', 'sous_famille');
define('TABLE_ERP_SOUS_TRAITANCE', 'sous_traitance'); //OLD
define('TABLE_ERP_STOCK_ZONE', 'stock_zone');
define('TABLE_ERP_TVA', 'tva');
define('TABLE_ERP_TYPE_ABS', 'type_absence');
define('TABLE_ERP_TRANSPORT', 'transport');
define('TABLE_ERP_UNIT', 'unit');
define('TABLE_ERP_EMPLOYEES', 'user');

//EN_TETE_TABLEAU
define('EN_TETE_TABLEAU_COL_01', 'Commande');
define('EN_TETE_TABLEAU_COL_02', 'Commande client');
define('EN_TETE_TABLEAU_COL_03', 'Client');
define('EN_TETE_TABLEAU_COL_04', 'Plan');
define('EN_TETE_TABLEAU_COL_05', 'Désignation');
define('EN_TETE_TABLEAU_COL_06', 'QT');
define('EN_TETE_TABLEAU_COL_07', 'Prix Unitaire');
define('EN_TETE_TABLEAU_COL_08', 'Prix Total');
define('EN_TETE_TABLEAU_COL_09', 'Matière');
define('EN_TETE_TABLEAU_COL_10', 'Ep');
define('EN_TETE_TABLEAU_COL_11', 'Date souhaitée');
define('EN_TETE_TABLEAU_COL_12', 'Date confirmée');
define('EN_TETE_TABLEAU_COL_13', 'Etude');
define('EN_TETE_TABLEAU_COL_14', 'Stock');
define('EN_TETE_TABLEAU_COL_15', 'HEURE LASER');
define('EN_TETE_TABLEAU_COL_16', 'SEM PROD LASER');
define('EN_TETE_TABLEAU_COL_17', 'TPS PRODUIT');
define('EN_TETE_TABLEAU_COL_18', 'QT PRODUITE');
define('EN_TETE_TABLEAU_COL_19', 'EBAV.');
define('EN_TETE_TABLEAU_COL_20', 'ORBITALE');
define('EN_TETE_TABLEAU_COL_21', 'EBAV CHAMPS');
define('EN_TETE_TABLEAU_COL_22', 'MICRO ATTACHE');
define('EN_TETE_TABLEAU_COL_23', 'TRIBO.');
define('EN_TETE_TABLEAU_COL_24', 'SEM PROD EBAV');
define('EN_TETE_TABLEAU_COL_25', 'TPS PRODUIT');
define('EN_TETE_TABLEAU_COL_26', 'QT PRODUITE');
define('EN_TETE_TABLEAU_COL_27', 'PARACH.');
define('EN_TETE_TABLEAU_COL_28', 'PERCAGE');
define('EN_TETE_TABLEAU_COL_29', 'TARAUDAGE');
define('EN_TETE_TABLEAU_COL_30', 'FRAISURAGE');
define('EN_TETE_TABLEAU_COL_31', 'INSERT');
define('EN_TETE_TABLEAU_COL_32', 'SEM PROD PARA');
define('EN_TETE_TABLEAU_COL_33', 'TPS PRODUIT');
define('EN_TETE_TABLEAU_COL_34', 'Qt PRODUITE');
define('EN_TETE_TABLEAU_COL_35', 'PLIAGE');
define('EN_TETE_TABLEAU_COL_36', 'NBR d\'OP');
define('EN_TETE_TABLEAU_COL_37', 'SEM PROD PLI');
define('EN_TETE_TABLEAU_COL_38', 'TPS PRODUIT PLI');
define('EN_TETE_TABLEAU_COL_39', 'QT PRODUITE');
define('EN_TETE_TABLEAU_COL_40', 'SOUDURE MIG	');
define('EN_TETE_TABLEAU_COL_41', 'SEM PROD MIG');
define('EN_TETE_TABLEAU_COL_42', 'TPS PRODUIT');
define('EN_TETE_TABLEAU_COL_43', 'QT PRODUITE');
define('EN_TETE_TABLEAU_COL_44', 'SOUDURE TIG');
define('EN_TETE_TABLEAU_COL_45', 'SEM PROD TIG');
define('EN_TETE_TABLEAU_COL_46', 'TPS PRODUIT');
define('EN_TETE_TABLEAU_COL_47', 'QT PRODUITE');
define('EN_TETE_TABLEAU_COL_48', 'SST');
define('EN_TETE_TABLEAU_COL_49', '');
define('EN_TETE_TABLEAU_COL_50', '');
define('EN_TETE_TABLEAU_COL_51', '');
define('EN_TETE_TABLEAU_COL_52', '');
define('EN_TETE_TABLEAU_COL_53', '');
define('EN_TETE_TABLEAU_COL_54', '');
define('EN_TETE_TABLEAU_COL_55', '');
define('EN_TETE_TABLEAU_COL_56', '');
define('EN_TETE_TABLEAU_COL_57', '');
define('EN_TETE_TABLEAU_COL_58', '');
define('EN_TETE_TABLEAU_COL_59', '');
define('EN_TETE_TABLEAU_COL_60', '');
define('EN_TETE_TABLEAU_COL_61', '');
define('EN_TETE_TABLEAU_COL_62', '');
define('EN_TETE_TABLEAU_COL_63', '');
define('EN_TETE_TABLEAU_COL_64', 'QT EXP/PRO');
define('EN_TETE_TABLEAU_COL_65', 'TRANSPORTEUR');
define('EN_TETE_TABLEAU_COL_66', 'COMMENTAIRES');
define('EN_TETE_TABLEAU_COL_67', 'POIDS');
define('EN_TETE_TABLEAU_COL_68', 'DEVIS');

define ('MAINTENANCE', 0);


if(MAINTENANCE == 1)
{
	echo'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
		<head>
			<title>Tous les Logiciels  libres</title>
			<meta name="robots" content="index,follow,all"/>
			<meta http-equiv="content-type" content="text/html; charset=utf-8" />
			<link rel="icon" type="images/ico" href="images/favicon.ico" />
		</head>
		<body style="background-color: #34495e;; color:white; margin-left:200px; text-align:left;">
			<p> 
				<br/>
				Site en maintenance.<br/>
				<br/>
				Cela peut prendre quelques minutes à plusieures heures, veuillez nous excuser pour le dérangement occasionné.<br/>
				Nous travaillons pour rétablir le site au plus vite.<br/>
				<br/>
				<br/>
				L’équipe du site.<br/>
				<br/>
				<br/>
				<pre>            /////</pre>
				 <pre>         (o)-(o)</pre>
				 -----ooO---(_)---Ooo--------------------------<br/>
			</p>
		</body>
		</html>';
	exit;	
}

$req = $bdd -> query('SELECT NAME,
							ADDRESS,
							ZIPCODE,
							REGION,
							COUNTRY,
							PHONE_NUMBER,
							MAIL,
							WEB_SITE,
							FACEBOOK_SITE,
							TWITTER_SITE,
							LKD_SITE,
							LOGO,
							SIREN,
							APE,
							TVA_INTRA,
							TAUX_TVA,
							CAPITAL,
							RCS
							FROM '. TABLE_ERP_COMPANY .'');
$donnees = $req->fetch();

$CompanyName = $donnees['NAME'];
$CompanyAddress = $donnees['ADDRESS'];
$CompanyZipCode= $donnees['ZIPCODE'];
$CompanyCountry = $donnees['COUNTRY'];
$CompanyRegion = $donnees['REGION'];
$CompanyPhone = $donnees['PHONE_NUMBER'];
$CompanyMail = $donnees['MAIL'];
$CompanyWebSite = $donnees['WEB_SITE'];
$CompanyFbSite = $donnees['FACEBOOK_SITE'];
$CompanyTwitter = $donnees['TWITTER_SITE'];
$CompanyLkd = $donnees['LKD_SITE'];
$CompanyLogo = $donnees['LOGO'];
$CompanySIREN = $donnees['SIREN'];
$CompanyAPE = $donnees['APE'];
$CompanyTVAINTRA = $donnees['TVA_INTRA'];
$CompanyTAUXTVA = $donnees['TAUX_TVA'];
$CompanyCAPITAL = $donnees['CAPITAL'];
$CompanyRCS = $donnees['RCS'];
		
//QUANTITATIF
define ('NBR_LIGNE_A_AFFICHER', 20);

//FORMULAIRE
define('LISTE_MATIERE', '
												<option value=""></option>
												<option value="ACIER motif">ACIER motif</option>
												<option value="ACIER DC01">ACIER vDC01</option>
												<option value="ACIER DKP">ACIER DKP</option>
												<option value="ACIER s235">ACIER s235</option>
												<option value="ACIER s240">ACIER s240</option>
												<option value="ACIER s355">ACIER s355</option>
												<option value="ACIER s500">ACIER s500</option>
												<option value="ACIER s700">ACIER s700</option>
												<option value="ACIER s690Ql">ACIER s690Ql</option>
												<option value="EZ">ACIER EZ</option>
												<option value="GALVA">ACIER GALVA</option>
												<option value="ACIER RAEX 400">ACIER RAEX 400</option>
												<option value="ACIER RAEX 450">ACIER RAEX 450</option>
												<option value="5754">AG3 - 5754</option>
												<option value="5083">AG4 - 5083</option>
												<option value="5005">Anodisé 5005</option>
												<option value="4003">Thybranox 4003</option>
												<option value="INOX F17">INOX F17</option>
												<option value="INOX 304 lac">INOX 304 lac</option>
												<option value="INOX 304 lac">INOX 304 laf</option>
												<option value="INOX 316">INOX 316</option>
												<option value="INOX 316 brossé">INOX 316 brossé</option>
												<option value="INOX 316 PM">INOX 316 PM</option>
												<option value="INOX B220">INOX Grain 220</option>
												<option value="INOX B400">INOX Grain 400</option>
												<option value="INOX PM">INOX PM</option>');


define('LISTE_EPAISSEUR', '
												<option value=""></option>
												<option value="0.1">0.1</option>
												<option value="0.2">0.2</option>
												<option value="0.5">0.5</option>
												<option value="0.6">0.6</option>
												<option value="0.8">0.8</option>
												<option value="1">1</option>
												<option value="1.2">1.2</option>
												<option value="1.5">1.5</option>
												<option value="2">2</option>
												<option value="2.5">2.5</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
												<option value="6">6</option>
												<option value="8">8</option>
												<option value="10">10</option>
												<option value="12">12</option>
												<option value="15">15</option>
												<option value="20">20</option>
												<option value="25">25</option>');

define('ACTION_FORMULAIRE', '
				<option value=""></option>
				<option value="decla_laser">Déclaration Laser</option>
				<option value="decla_ebav">Déclaration Ebavurage</option>
				<option value="decla_para">Déclaration Parachèvement</option>
				<option value="decla_pli">Déclaration Pliage</option>
				<option value="decla_soudure_mig">Déclaration Soudure MIG</option>
				<option value="decla_soudure_tig">Déclaration Soudure TIG</option>
				<option value="decla_expe">Déclaration Expédition</option>
				<option value=""></option>
				<option value="ajout_SST">Affecter sous-traitance</option>
				<option value=""></option>
				<option value="export_exel">Exportoration Exel</option>
				<option value="etiquette_petite">Générer Petite Etiquette</option>
				<option value="etiquette_grande">Générer Grande Etiquette</option>
				<option value=""></option>
				<option value="OF">Générer ordre de fabrication</option>
				<option value=""></option>
				<option value="modifier_cmd">Modifier les lignes</option>
				<option value="annuler_cmd">Annuler les lignes</option>
				<option value="supprimer_cmd">Supprimer les lignes</option>');
				
define('TRANSPORT_LISTE', '
				<option value=""></option>
				<option value="MESSAGERIE">MESSAGERIE</option>
				<option value="FRET">FRET</option>
				<option value="CLIENT">CLIENT</option>
				<option value="METAL INDUSTRIE">METAL INDUSTRIE</option>');
?>
