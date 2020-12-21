<?php 
	//phpinfo();
	use \App\Autoloader;
	use \App\SQL;
	use \App\Language;
	use \App\COMPANY\Company;
	use \App\COMPANY\CompanyManager;
	use \App\CallOutBox;

	// include for the constants
	require_once '../include/include_recup_config.php';
	//auto load class
	require_once '../app/Autoload.class.php';
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
	require_once '../include/include_fonctions.php';
	//session checking  user
	require_once '../include/include_checking_session.php';
	//init xml for user language
	$langue = new Language('lang', 'index', $UserLanguage);
	//init call out box for notification
	$CallOutBox = new CallOutBox();

	//Check if the user is authorized to view the page
	if($_SESSION['page_1'] != '1'){
		stop($langue->show_text('SystemInfoAccessDenied'), 161, 'index.php?page=login');
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

