<?php 
	//phpinfo();
	use \App\Autoloader;
	use \App\Form;

	//auto load class
	require_once '../app/Autoload.class.php';
	Autoloader::register();
	
	session_start();
	header( 'content-type: text/html; charset=utf-8' );
	//session checking  user
	require_once '../include/include_checking_session.php';
	//init form class
	$Form = new Form($_POST);

	//Check if the user is authorized to view the page
	if($_SESSION['page_2'] != '1'){
		stop($langue->show_text('SystemInfoAccessDenied'), 161, 'index.php?page=login');
	}
?>