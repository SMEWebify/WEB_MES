<?php session_start();

	header( 'content-type: text/html; charset=utf-8' );

	//phpinfo();

	// include for the constants
	require_once 'include/include_recup_config.php';
	//include for the connection to the SQL database
	require_once 'class/sql.class.php';
	$bdd = SQL::getInstance();
	// include for functions
	require_once 'include/include_fonctions.php';
	//session checking  user
	require_once 'include/include_checking_session.php';
	//load info company
	require_once 'include/include_recup_config_company.php';
	// load language class
	require_once 'class/language.class.php';
	$langue = new Langues('lang', 'quality', $UserLanguage);
	//load callOut notification box class
	require_once 'class/notification.class.php';
	$CallOutBox = new CallOutBox();

	//Check if the user is authorized to view the page
	if($_SESSION['page_6'] != '1'){
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
	//include ui
	require_once 'include/include_interface.php';
?>
	<div class="tab">
		<button class="tablinks" onclick="openDiv(event, 'div1')"><?=$langue->show_text('Title1'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div2')"><?=$langue->show_text('Title2'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div3')"><?=$langue->show_text('Title3'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div4')"><?=$langue->show_text('Title4'); ?></button>
	</div>
	<div id="div1" class="tabcontent" >
	</div>
	<div id="div2" class="tabcontent" >
	</div>
	<div id="div3" class="tabcontent" >
	</div>
	<div id="div4" class="tabcontent" >
	</div>
<?php
	//include CallOut
	require_once 'include/include_CallOutBox.php';
?>
</body>
</html>
