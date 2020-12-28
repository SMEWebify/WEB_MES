<?php

//SQL LOGIN
define('SQL_HOST', 'localhost');
define('DB_NAME', 'erp');
define('DB_USER', 'root');
define('DB_PASSWORD', '');


//DATA BASE TABLE
define('TABLE_ERP_ACTIVITY_SECTOR', 'activity_sector');
define('TABLE_ERP_ARTICLE', 'article');
define('TABLE_ERP_ADRESSE', 'adresses');
define('TABLE_ERP_CLIENT_FOUR', 'client_fourniseur');

//ORDER
define('TABLE_ERP_COMMANDE', 'commande');
define('TABLE_ERP_COMMANDE_LIGNE', 'commande_ligne');

define('TABLE_ERP_COMPANY', 'company_setting');
define('TABLE_ERP_CONDI_REG', 'condition_reg');
define('TABLE_ERP_CONTACT', 'contact');
define('TABLE_ERP_DEC_TECH', 'decoupage_tech');

//QUOTE
define('TABLE_ERP_DEVIS', 'devis');
define('TABLE_ERP_DEVIS_LIGNE', 'devis_lignes');

define('TABLE_ERP_ECHEANCIER_TYPE', 'echeancier_type');
define('TABLE_ERP_ECHEANCIER_TYPE_LIGNE', 'echeancier_type_ligne');
define('TABLE_ERP_EMAIL', 'email');
define('TABLE_ERP_EVENT_MACHINE', 'evenement_machine');
define('TABLE_ERP_EVENT_IMPRODUC_TIME', 'improductive_activity');

//ACOUTING
define('TABLE_ERP_IMPUT_COMPTA', 'imputation_comptables');
define('TABLE_ERP_IMPUT_COMPTA_LIGNE', 'imputation_comptables_ligne');
define('TABLE_ERP_IMPUT_COMPTA_PRESTATION', 'imputation_comptables_prestations');

define('TABLE_ERP_INFO_GENERAL', 'infos_generales'); 
define('TABLE_ERP_FERIER', 'jours_feries');
define('TABLE_ERP_MODE_REG', 'mode_reglement');
define('TABLE_ERP_NOMENCLATURE', 'nomenclature');
define('TABLE_ERP_NUM_DOC', 'num_doc');
define('TABLE_ERP_PRESTATION', 'prestations');

  //QUALITY
define('TABLE_ERP_QL_ACTION', 'ql_action');
define('TABLE_ERP_QL_APP_MESURE', 'ql_appareil_mesure');
define('TABLE_ERP_QL_CAUSES', 'ql_causes');
define('TABLE_ERP_QL_CORRECTIONS', 'ql_corrections');
define('TABLE_ERP_DEFAUT', 'ql_defaut');
define('TABLE_ERP_DEROGATION', 'ql_derogation');
define('TABLE_ERP_NFC', 'ql_nfc');

define('TABLE_ERP_RESSOURCE', 'ressource');
define('TABLE_ERP_RIGHTS', 'rights');
define('TABLE_ERP_SECTION', 'section');
define('TABLE_ERP_SOUS_ENSEMBLE', 'sous_ensemble');
define('TABLE_ERP_SOUS_FAMILLE', 'sous_famille');
define('TABLE_ERP_STOCK_ZONE', 'stock_zone');
define('TABLE_ERP_TVA', 'tva');
define('TABLE_ERP_TYPE_ABS', 'type_absence');
define('TABLE_ERP_TRANSPORT', 'transport');
define('TABLE_ERP_UNIT', 'unit');
define('TABLE_ERP_EMPLOYEES', 'user');

//if turn off web site
define ('MAINTENANCE', 0);

//FOLDER
define('PICTURE_FOLDER', 'images/');
define('PROFIL_FOLDER', 'Profils/');
define('RESSOURCES_FOLDER', 'Ressources/');
define('QUALITY_DEVICES_FOLDER', 'Quality/');


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

/*
  error_reporting(0);  
  set_time_limit(10);
  
 header("Cache-Control: no-cache, must-revalidate");

  //define your constant here
  define('OS', strtoupper(substr(PHP_OS,0,3)) == 'WIN' ? 'WIN' : 'LINUX');
  define('PATH','/url/to/path/');

  define('IMGS_PATH','imgs/');
  define('TEMPLATE_PATH','template/');
  define('LIB_PATH','libs/');

class init {  
  var $envVariables =   array();
  
  function _construct() {
    headers_sent() ? die('FATAL ERROR') : '';
    $this->envVariables['get'] = init::parseVar($_GET);
    $this->envVariables['post'] = init::parseVar($_POST);
    $this->envVariables['cookie'] = init::parseVar($_COOKIE);
    
    unset($GLOBALS['HTTP_GET_VARS'],$GLOBALS['_GET']);
    unset($GLOBALS['HTTP_POST_VARS'],$GLOBALS['_POST']);
    unset($GLOBALS['HTTP_COOKIE_VARS'],$GLOBALS['_COOKIE']);
    unset($GLOBALS['HTTP_SERVER_VARS'],$GLOBALS['_SERVER']);
    unset($GLOBALS['HTTP_ENV_VARS'],$GLOBALS['_ENV']);
    unset($GLOBALS['HTTP_POST_FILES'],$GLOBALS['_FILES']);
    unset($GLOBALS['_REQUEST']);
    register_shutdown_function( array( &$this, "_init" ) );
  }
  
  function _init() {
    unset($this->envVariables);
    $this->envVariables = array();
  }
  
  public static function parseVar($varName) {
    foreach ($varName as $key => $val) {
      $val = !addslashes($val);
      $varName[$key] = $val;
    }    
    return $varName;
  }
  
  function getEnvVariable($envName = '', $varName = '', $default = NULL) {
    if(isset($this->envVariables[$envName])) {
      if(isset($this->envVariables[$envName][$varName])) {
        return $this->envVariables[$envName][$varName];
      }
      elseif(empty($varName)) {
        return $this->envVariables[$envName];
      }
    }
  }
  
  function isCallable($filename = '') {
    return file_exists($filename) && is_readable($filename);
  }
  
}  

//Example of CODE

  $_obj_INIT = new init();

  echo $_obj_INIT->getEnvVariable('get','pge');
  
  if($_obj_INIT->isCallable(PATH.'file.php')) {
    require_once(PATH.'file.php');
  }
  */
?>