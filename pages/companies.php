<?php 
	//phpinfo();
	use \App\Autoloader;
	use \App\Form;
	use \App\Companies\Companies;
	use \App\COMPANY\ActivitySector;

	//auto load class
	require_once '../app/Autoload.class.php';
	Autoloader::register();
	
	session_start();
	header( 'content-type: text/html; charset=utf-8' );
	//init form class
	$Form = new Form($_POST);
	$Companies = new Companies();
	$ActivitySector = new ActivitySector();

	//Check if the user is authorized to view the page
	if($_SESSION['page_9'] != '1'){
		stop($langue->show_text('SystemInfoAccessDenied'), 161, 'index.php?page=login');
	}?>

<div class="tab">
	<button class="tablinks" onclick="openDiv(event, 'div1')" id="defaultOpen"><?=$langue->show_text('Titre1'); ?></button>
	<?php if(isset($_GET['id'])  AND  !empty($_GET['id'])){ ?>
	<button class="tablinks" onclick="openDiv(event, 'div2')"><?=$langue->show_text('Titre2'); ?></button>
	<button class="tablinks" onclick="openDiv(event, 'div3')"><?=$langue->show_text('Titre3'); ?></button>
	<button class="tablinks" onclick="openDiv(event, 'div5')"></button>
	<?php } ?>
</div>
<div id="div1" class="tabcontent" >
	<div class="column">
		<input type="text" id="myInput" onkeyup="myFunction()" placeholder="<?=$langue->show_text('FindCompany'); ?>">
		<ul id="myUL">
			<?php
			//generate list for datalist find input
			$query="SELECT id, CODE, NAME FROM ". TABLE_ERP_CLIENT_FOUR ." ORDER BY NAME";
			foreach ($bdd->GetQuery($query) as $data): ?>
			<li><a href="index.php?page=companies&id=<?= $data->id ?>"><?= $data->CODE ?> - <?= $data->NAME ?></a></li>
			<?php $i++; endforeach; ?>
		</ul>
	</div>
	<?php if(isset($_GET['id'])  AND  !empty($_GET['id'])){ ?>
	<div class="column">
			<?php $Data = $Companies->GETCompanie($_GET['id']); ?>
			<table class="content-table">
				<thead>
					<tr>
						<th>
							<?= $Data->CODE ?> - <?= $Data->NAME ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?=$langue->show_text('TableDateCreation') .' '. $Data->DATE_CREA ?> </td>
					</tr>
					<tr>
						<td>
							<?= $Data->WEBSITE ?>
						</td>
					</tr>
					<tr>
						<td>
							<?= $Data->FBSITE ?> <?= $Data->TWITTERSITE ?> <?= $Data->LKDSITE ?>
						</td>
					</tr>
					<tr>
						<td>
							<?= $Data->SIREN ?>
						</td>
					</tr>
					<tr>
						<td>
							<?= $Data->APE ?>
						</td>
					</tr>
					<tr>
						<td>
							<?= $Data->TVA_INTRA ?>
						</td>
					</tr>
					<tr>
						<td>
							<?= $Data->TVA_LABEL ?>
						</td>
					</tr>
					<tr>
						<td>
							<?= $Data->STATU_CLIENT ?>
						</td>
					</tr>
					<tr>
						<td>
							<?= $Data->STATU_FOUR ?>
						</td>
					</tr>
				</tbody>
			</table>
	</div>
	<div class="column">
		<div class="card">
			<img src="<?=$Data->LOGO ?>" title="LOGO entreprise" alt="Logo" Class="Image-Logo"/>
		</div>
	</div>
	<div class="column">
			<table class="content-table">
				<thead>
					<tr>
						<th><?=$langue->show_text('Titre5'); ?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<?= $Data->COMENT ?>
						</td>
					</tr>
				</tbody>
			</table>
	</div>
	<div class="column">
			<table class="content-table">
				<thead>
					<tr>
						<th><?=$langue->show_text('Titre4'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?= $ActivitySector->GETActivitySectorCheckedList($Data->SECTOR_ID) ?>
				</tbody>
			</table>
		</div>
	</div>
	<?php } ?>
</div>
<div id="div2" class="tabcontent" >
</div>
