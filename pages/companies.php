<?php 
	//phpinfo();
	use \App\Autoloader;
	use \App\UI\Form;
	use \App\Companies\Companies;
	use \App\COMPANY\ActivitySector;
	use \App\Companies\Contact;
	use \App\Companies\Address;
	use \App\UI\UI;

	//auto load class
	require_once '../app/Autoload.class.php';
	Autoloader::register();
	
	session_start();
	header( 'content-type: text/html; charset=utf-8' );
	//init form class
	$Form = new Form($_POST);
	$Companies = new Companies();
	$ActivitySector = new ActivitySector();
	$Contact =  new Contact();
	$Address = new Address();
	$UI = new UI();
	
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
	<div class="row">
		<div class="column-menu">
			<?php echo $UI->GetSearchMenu($Companies->GetCustomerList('',false), 'index.php?page=companies&id', $langue->show_text('FindCompany') ); ?>
		</div>
		<?php if(isset($_GET['id'])  AND  !empty($_GET['id'])){ ?>
		<div class="column">
				<?php $Data = $Companies->GETCompanie($_GET['id']); ?>
				<table class="content-table">
					<thead>
						<tr>
							<th><?= $Data->CODE ?> - <?= $Data->LABEL ?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><?=$langue->show_text('TableDateCreation') .' '. $Data->DATE_CREA ?> </td>
						</tr>
						<tr>
							<td><?= $Data->WEBSITE ?></td>
						</tr>
						<tr>
							<td><?= $Data->FBSITE ?> <?= $Data->TWITTERSITE ?> <?= $Data->LKDSITE ?></td>
						</tr>
						<tr>
							<td><?= $Data->SIREN ?></td>
						</tr>
						<tr>
							<td><?= $Data->APE ?></td>
						</tr>
						<tr>
							<td><?= $Data->TVA_INTRA ?></td>
						</tr>
						<tr>
							<td><?= $Data->TVA_LABEL ?></td>
						</tr>
						<tr>
							<td><?= $Data->STATU_CLIENT ?></td>
						</tr>
						<tr>
							<td><?= $Data->STATU_FOUR ?></td>
						</tr>
					</tbody>
				</table>
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
		<?php if(!empty($Data->LOGO)):?>
		<div class="column">
			<div class="card">
				<img src="<?= PICTURE_FOLDER.COMPANIES_FOLDER.$Data->LOGO ?>" title="LOGO entreprise" alt="Logo" Class="Image-Logo"/>
			</div>
		<?php endif;?>
		<?php if(!empty($Data->COMENT)):?>
				<table class="content-table">
					<thead>
						<tr>
							<th><?=$langue->show_text('Titre5'); ?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><?= $Data->COMENT ?></td>
						</tr>
					</tbody>
				</table>
		
		<?php endif;?>
		</div>
		<?php } ?>
	</div>
</div>
<div id="div2" class="tabcontent" >
	<div class="row">
		<?php foreach ($Address->GETAddressList('', false, $_GET['id'] ) as $data): ?>
			<div class="column">
				<div class="card">
					<h3><?= $data->LABEL ?></h3>
					<p><?= $data->ADRESSE ?></p>
					<p><?= $data->CITY ?> - <?= $data->ZIPCODE ?></p>
					<p><?= $data->COUNTRY ?></p>
					<p><?= $data->ADRESSE ?></p>
					<p>&#9742; <?= $data->NUMBER ?></p>
					<p><button onClick="location.href=\'mailto:<?= $data->MAIL ?>\'">&#x2709; <?= $langue->show_text('ContactEmployees') ?></button></p>
				</div>
			
				<div class="card">
					<div id="map-container-google-1" class="z-depth-1-half map-container-5" style="height: 200px">
						<iframe src="https://maps.google.com/maps?q=<?= $data->COUNTRY ?>-<?= $data->CITY ?>-<?= $data->ADRESSE ?>&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" style="border:0" allowfullscreen></iframe>
				</div>
				</div>
			</div>
		<?php $i++; endforeach; ?>
	</div>
</div>
<div id="div3" class="tabcontent" >
<?php foreach ($Contact->GETContactList('', false, $_GET['id'] ) as $data): ?>
	<div class="column">
		<div class="card">
			<h3><?= $data->PRENOM ?> <?= $data->NOM ?></h3>
			<p><?= $data->FONCTION ?></p>
			<p>&#9742; <?= $data->NUMBER ?></p>
			<p>&#9742; <?= $data->MOBILE ?></p>
			
			<p><button onClick="location.href=\'mailto:<?= $data->MAIL ?>\'">&#x2709; <?= $langue->show_text('ContactEmployees') ?></button></p>
		</div>
	</div>
<?php $i++; endforeach; ?>
</div>
