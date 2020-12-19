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
	$langue = new Langues('lang', 'index', $UserLanguage);
	//load callOut notification box class
	require_once 'class/notification.class.php';
	$CallOutBox = new CallOutBox();

	//Check if the user is authorized to view the page
	if($_SESSION['page_1'] != '1'){
		stop($langue->show_text('SystemInfoAccessDenied'), 161, 'login.php');
	}

	// Get general info for timeline
	$req = $bdd->query("SELECT id, ETAT, TIMESTAMP, TEXT FROM ". TABLE_ERP_INFO_GENERAL ." WHERE ETAT =1 ORDER BY id DESC LIMIT 0, 10");

		$class = array('left', 'right');
		$nb = count($class);
		$i = 0;

		while ($donnees = $req->fetch()){

				$info_secteur = $info_secteur .'
				<div class="container-timeline '.$class[$i%$nb].'">
					<div class="content-timeline">
						<h2>'. format_temps($donnees['TIMESTAMP']) .'</h2>
						<p>'. nl2br(htmlspecialchars($donnees['TEXT'])) .'</p>
					</div>
				</div>';
		$i++;
		}

	// get employees list
	$req = $bdd -> query('SELECT '. TABLE_ERP_EMPLOYEES .'.NOM,
									'. TABLE_ERP_EMPLOYEES .'.PRENOM,
									'. TABLE_ERP_EMPLOYEES .'.PRENOM,
									'. TABLE_ERP_EMPLOYEES .'.MAIL,
									'. TABLE_ERP_EMPLOYEES .'.NUMERO_INTERNE,
									'. TABLE_ERP_EMPLOYEES .'.IMAGE_PROFIL,
									'. TABLE_ERP_EMPLOYEES .'.FONCTION,
									'. TABLE_ERP_SECTION .'.LABEL,
									'. TABLE_ERP_RIGHTS .'.RIGHT_NAME
									FROM `'. TABLE_ERP_EMPLOYEES .'`
									LEFT JOIN `'. TABLE_ERP_RIGHTS .'` ON `'. TABLE_ERP_EMPLOYEES .'`.`FONCTION` = `'. TABLE_ERP_RIGHTS .'`.`id`
									LEFT JOIN `'. TABLE_ERP_SECTION .'` ON `'. TABLE_ERP_EMPLOYEES .'`.`SECTION_ID` = `'. TABLE_ERP_SECTION .'`.`id`');
	while ($donnees_membre = $req->fetch())
	{
		if(!empty($donnees_membre['IMAGE_PROFIL'])){
			$image = $donnees_membre['IMAGE_PROFIL'];
		}
		else{
			$image = 'images/Profils/img_avatar.png';

		}
		$Employees .=  '<div class="column">
							<div class="card">
								<img src="'. $image .'" alt="Profil" class="Image-Logo">
								<h3>'. $donnees_membre['PRENOM'] .' '. $donnees_membre['NOM'] .'</h3>
								<p>'. $donnees_membre['RIGHT_NAME'] .'</p>
								<p>'. $donnees_membre['NUMERO_INTERNE'] .'</p>
								<p><button onClick="location.href=\'mailto:'. $donnees_membre['MAIL'] .'\'">'. $langue->show_text('ContactEmployees') .'</button></p>
							</div>
						  </div>';
		$i++;
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
		<button class="tablinks" onclick="openDiv(event, 'div1')" id="defaultOpen"><?=$langue->show_text('Title1'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div2')"><?=$langue->show_text('Title2'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div3')"><?=$langue->show_text('Title3'); ?></button>
	</div>
	<div id="div1" class="tabcontent" >
			<div class="timeline">
<?php
			Echo $info_secteur;
?>
		</div>
	</div>
	<div id="div2" class="tabcontent" >
	</div>
	<div id="div3" class="tabcontent" >
		<div class="row">
<?php
			echo $Employees;
?>
		</div>
	</div>
<?php
	//include CallOut
	require_once 'include/include_CallOutBox.php';
?>
</body>
</html>
