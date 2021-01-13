<?php 
	//phpinfo();
	use \App\Autoloader;
	use \App\Companies\Companies;
	use \App\Quote\Quote;

	//auto load class
	require_once '../app/Autoload.class.php';
	Autoloader::register();
	
	session_start();
	header( 'content-type: text/html; charset=utf-8' );
	
	//init form class
	$Companies = new Companies();
	$Quote = new Quote();

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
		<div class="column-half">
			<div class="dashboard">
				<p><i class="fa fa-smile-o"></i></p>
				<h3><?= $Companies->GETCompanieCount(); ?>+</h3>
				<p>Clients</p>
			</div>
			<div class="dashboard">
				<p><i class="fa fa-smile-o"></i></p>
				<h3><?= $User->GETUserCount(); ?></h3>
				<p>User</p>
			</div>
			<div class="dashboard">
				<p><i class="fa fa-smile-o"></i></p>
				<h3>+</h3>
				<p>Empty</p>
			</div>
			<div class="dashboard">
				<p><i class="fa fa-smile-o"></i></p>
				<h3>+</h3>
				<p>Current month order</p>
			</div>
			<div class="dashboard">
				<p><i class="fa fa-smile-o"></i></p>
				<h3><?= $Quote->GETQuoteCount('',' WHERE MONTH(DATE) = MONTH(CURRENT_TIMESTAMP)'); ?>+</h3>
				<p>Current month quote</p>
			</div>
			<div class="dashboard">
				<p><i class="fa fa-smile-o"></i></p>
				<h3>+</h3>
				<p>Current month Non-compliance Record</p>
			</div>
		</div>	
		<div class="column-half">
			
		</div>
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
			$image = PICTURE_FOLDER.PROFIL_FOLDER.$data->IMAGE_PROFIL;
		}
		else{
			$image = PICTURE_FOLDER.PROFIL_FOLDER.'img_avatar.png';
		}
		?>
				<div class="column">
					<div class="card">
						<img src="<?= $image ?>" alt="Profil" class="Image-Logo">
						<h3><?= $data->PRENOM ?> <?= $data->NOM ?></h3>
						<p><?= $data->RIGHT_NAME ?></p>
						<p>&#9742; <?= $data->NUMERO_INTERNE ?></p>
						<p><button onClick="location.href=\'mailto:<?= $data->MAIL ?>\'">&#x2709; <?= $langue->show_text('ContactEmployees') ?></button></p>
					</div>
				</div>
			<?php $i++; endforeach; ?>
			</div>
	</div>

