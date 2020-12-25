<?php 
	//phpinfo();
	use \App\Autoloader;
	//auto load class
	require_once '../app/Autoload.class.php';
	Autoloader::register();
	
	session_start();
	header( 'content-type: text/html; charset=utf-8' );
	//session checking  user
	require_once '../include/include_checking_session.php';

	//Check if the user is authorized to view the page
	if($_SESSION['page_1'] != '1'){
		stop($langue->show_text('SystemInfoAccessDenied'), 161, 'index.php?page=login');
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
		// Get general info for timeline
		$query ='SELECT id, ETAT, TIMESTAMP, TEXT FROM '. TABLE_ERP_INFO_GENERAL .' WHERE ETAT =1 ORDER BY id DESC LIMIT 0, 10';

		$class = array('left', 'right');
		$nb = count($class);
		$i = 0;
		foreach ($bdd->GetQuery($query) as $data): ?>
			<div class="container-timeline <?= $class[$i%$nb] ?>">
				<div class="content-timeline">
					<h2><?= format_temps($data->TIMESTAMP) ?></h2>
					<p> <?= nl2br(htmlspecialchars($data->TEXT)) ?></p>
				</div>
			</div>
		<?php $i++; endforeach; ?>
		</div>
	</div>
	<div id="div2" class="tabcontent" >
	</div>
	<div id="div3" class="tabcontent" >
		<div class="row">
		<?php
		// get employees list
		$query ='SELECT '. TABLE_ERP_EMPLOYEES .'.NOM,
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
										LEFT JOIN `'. TABLE_ERP_SECTION .'` ON `'. TABLE_ERP_EMPLOYEES .'`.`SECTION_ID` = `'. TABLE_ERP_SECTION .'`.`id`';

		foreach ($bdd->GetQuery($query) as $data): 
		if(!empty($data->IMAGE_PROFIL)){
			$image = $data->IMAGE_PROFIL;
		}
		else{
			$image = 'images/Profils/img_avatar.png';
		}
		?>
				<div class="column">
					<div class="card">
						<img src="<?= $image ?>" alt="Profil" class="Image-Logo">
						<h3><?= $data->PRENOM ?> <?= $data->NOM ?></h3>
						<p><?= $data->RIGHT_NAME ?></p>
						<p><?= $data->NUMERO_INTERNE ?></p>
						<p><button onClick="location.href=\'mailto:<?= $data->MAIL ?>\'"><?= $langue->show_text('ContactEmployees') ?></button></p>
					</div>
				</div>
			<?php $i++; endforeach; ?>
			</div>
	</div>

