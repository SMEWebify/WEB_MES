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
	if($_SESSION['page_6'] != '1'){
		stop($langue->show_text('SystemInfoAccessDenied'), 161, 'index.php?page=login');
	}
?>
	<div class="tab">
		<button class="tablinks" onclick="openDiv(event, 'div1')" id="defaultOpen"><?=$langue->show_text('Title1'); ?></button>
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