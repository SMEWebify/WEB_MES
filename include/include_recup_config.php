<?php
//SQL LOGIN
define('SQL_HOST', 'localhost');
define('DB_NAME', 'erp');
define('DB_USER', 'root');

//DATA BASE TABLE
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

//if turn off web site
define ('MAINTENANCE', 0);

if(MAINTENANCE == 1)
{
	echo'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
		<head>
			<title-- Of line --</title>
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
?>
