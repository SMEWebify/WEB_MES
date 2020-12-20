<?php 
	//phpinfo();
	use \ERP\Autoloader;
	use \ERP\SQL;
	use \ERP\COMPANY\Company;
	use \ERP\COMPANY\CompanyManager;
	use \ERP\Language;
	use \ERP\CallOutBox;

	// include for the constants
	require_once 'include/include_recup_config.php';
	//auto load class
	require_once 'class/Autoload.class.php';
	Autoloader::register();

	session_start();
	header( 'content-type: text/html; charset=utf-8' );

	//open sql connexion
	$bdd = SQL::getInstance();
	//load company vairiable
	$CompanyManager = new CompanyManager($bdd);
	$donneesCompany = $CompanyManager->getDb();
	$Company = new Company($donneesCompany);
	// include for functions
	require_once 'include/include_fonctions.php';
	//session checking  user
	require_once 'include/include_checking_session.php';
	//init xml for user language
	$langue = new Language('lang', 'purchase', $UserLanguage);
	//init call out box for notification
	$CallOutBox = new CallOutBox();

	//Check if the user is authorized to view the page
	if($_SESSION['page_3'] != '1'){
		stop($langue->show_text('SystemInfoAccessDenied'), 161, 'login.php');
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
<?php
	//include interface
	require_once 'include/include_header.php';
?>
</head>
<body>
<?php
	//include interface
	require_once 'include/include_interface.php';
?>
<?php
	//include CallOut
	require_once 'include/include_CallOutBox.php';
?>
</body>
</html>
