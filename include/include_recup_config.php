<?php

//SQL LOGIN
define('SQL_HOST', 'localhost');
define('DB_NAME', 'erp');
define('DB_USER', 'root');
define('DB_PASSWORD', '');


//DATA BASE ACCOUTING
define('TABLE_ERP_TRANSPORT', 'ac_delivery');
define('TABLE_ERP_CONDI_REG', 'ac_payment_condition');
define('TABLE_ERP_MODE_REG', 'ac_payment_method');
define('TABLE_ERP_TVA', 'ac_VAT');
define('TABLE_ERP_IMPUT_COMPTA', 'ac_accounting_allocation');
define('TABLE_ERP_IMPUT_COMPTA_LIGNE', 'ac_accounting_allocation_lines');
define('TABLE_ERP_IMPUT_COMPTA_PRESTATION', 'ac_accounting_allocation_services');
define('TABLE_ERP_ECHEANCIER_TYPE', 'ac_timeline_paiement');
define('TABLE_ERP_ECHEANCIER_TYPE_LIGNE', 'ac_timeline_paiement_lines');

//DATA
define('TABLE_ERP_ATTACHED_DOCUMENT', 'attached_document');
//DATA BASE COMPANIES
define('TABLE_ERP_CLIENT_FOUR', 'companies');
define('TABLE_ERP_ADRESSE', 'companies_addresses');
define('TABLE_ERP_CONTACT', 'companies_contact');
//DATA BASE COMPANY
define('TABLE_ERP_ACTIVITY_SECTOR', 'company_activity_sector');
define('TABLE_ERP_COMPANY', 'company_setting');
define('TABLE_ERP_RIGHTS', 'company_rights');
define('TABLE_ERP_EMPLOYEES', 'company_user');
define('TABLE_ERP_EMAIL', 'company_email_type');
define('TABLE_ERP_INFO_GENERAL', 'company_timeline'); 
define('TABLE_ERP_NUM_DOC', 'company_document_numbering');

//DATA BASE QUOTE
define('TABLE_ERP_QUOTE', 'quote');
define('TABLE_ERP_QUOTE_LIGNE', 'quote_lines');
define('TABLE_ERP_QUOTE_SUB_ASSEMBLY', 'quote_sub_assembly');
//DATA BASE ORDER
define('TABLE_ERP_ORDER', 'orders');
define('TABLE_ERP_ORDER_LIGNE', 'orders_lines');
define('TABLE_ERP_ORDER_SUB_ASSEMBLY', 'order_sub_assembly');
//DATA BASE ORDER ACKNOWLEGMENT
define('TABLE_ERP_ORDER_ACKNOWLEGMENT', 'order_acknowledgment');
define('TABLE_ERP_ORDER_ACKNOWLEGMENT_LINES', 'order_acknowledgment_lines');
//DATA BASE ORDER DELERERY NOTE
define('TABLE_ERP_ORDER_DELIVERY_NOTE', 'order_delivery_note');
define('TABLE_ERP_ORDER_DELIVERY_NOTE_LINES', 'order_delivery_note_lines');
// DATA PURCHASE REQUEST
define('TABLE_ERP_PURCHASE_REQUEST', 'purchase_request');
define('TABLE_ERP_PURCHASE_REQUEST_LINES', 'purchase_request_lines');

//DATA BASE QUALITY
define('TABLE_ERP_QL_ACTION', 'ql_action');
define('TABLE_ERP_QL_APP_MESURE', 'ql_appareil_mesure');
define('TABLE_ERP_QL_CAUSES', 'ql_causes');
define('TABLE_ERP_QL_CORRECTIONS', 'ql_corrections');
define('TABLE_ERP_DEFAUT', 'ql_defaut');
define('TABLE_ERP_DEROGATION', 'ql_derogation');
define('TABLE_ERP_NFC', 'ql_nfc');


//DATA BASE STOCK
define('TABLE_ERP_STOCK', 'stock');
define('TABLE_ERP_STOCK_LOCATION', 'stock_location');

//DATA BASE STUDY
define('TABLE_ERP_UNIT', 'study_unit');
define('TABLE_ERP_SOUS_FAMILLE', 'study_sub_familly');
define('TABLE_ERP_STANDARD_ARTICLE', 'study_standard_article');
define('TABLE_ERP_STANDARD_SUB_ASSEMBLY', 'study_standard_sub_assembly');

//DATA BASE METHODS
define('TABLE_ERP_SECTION', 'methods_section');
define('TABLE_ERP_RESSOURCE', 'methods_resource');
define('TABLE_ERP_STOCK_ZONE', 'methods_stock_zone');
define('TABLE_ERP_PRESTATION', 'methods_services');

//DATA BASE TIME
define('TABLE_ERP_DAILY_HOURLY_MODEL', 'time_daily_hourly_model');
define('TABLE_ERP_DAILY_HOURLY_MODEL_LINES', 'time_daily_hourly_model_line');
define('TABLE_ERP_TYPE_ABS', 'time_absence_type');
define('TABLE_ERP_FERIER', 'time_bank_holiday');
define('TABLE_ERP_EVENT_MACHINE', 'time_event_machine');
define('TABLE_ERP_EVENT_IMPRODUC_TIME', 'time_improductive_activity');
define('TABLE_ERP_ABS_HISTORY', 'time_absence_history');

//DATA TASK
define('TABLE_ERP_TASK', 'task');
define('TABLE_ERP_TASK_REMAINING_TIME', 'order_remaining_time');

//TOOL
define('TABLE_ERP_TOOL', 'tool');

//if turn off web site
define ('MAINTENANCE', 0);

//FOLDER
define('PICTURE_FOLDER', 'images/');
define('PROFIL_FOLDER', 'Profils/');
define('RESSOURCES_FOLDER', 'Ressources/');
define('QUALITY_DEVICES_FOLDER', 'Quality/');
define('STUDY_ARTICLE_FOLDER', 'Articles/');
define('COMPANIES_FOLDER', 'Clients/');
define('COMPANY_FOLDER', 'Company/');


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