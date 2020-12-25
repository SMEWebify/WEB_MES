<?php 
	//phpinfo();
	use \App\Autoloader;
	use \App\Form;
	use \App\User;

	//auto load class
	require_once '../app/Autoload.class.php';
	Autoloader::register();

	session_start();
	header( 'content-type: text/html; charset=utf-8' );

	//init form class
	$Form = new Form($_POST);

	//If user make change profil value
	if(isset($_POST['ProfilSpeudo']) AND !empty($_POST['ProfilName'])){

		$UpdateProfilName = $_POST['ProfilName'];
		$UpdateProfilSurName = $_POST['ProfilSurName'];
		$UpdateProfilSpeudo = $_POST['ProfilSpeudo'];
		$UpdateProfilDate = strtotime($_POST['ProfilDate']);
		$UpdateProfilDate = date('Y-m-d H:i:s', $UpdateProfilDate);
		$UpdateProfilMDP = password_hash($_POST['ProfilMDP'], PASSWORD_DEFAULT);
		$UpdateProfilMail = $_POST['ProfilMAIL'];
		$UpdateProfilInternalNumber = $_POST['ProfilInternalNumber'];
		$UpdateProfilPersonnalNumber = $_POST['ProfilPersonnalNumber'];
		$UpdatePhotoProfil = $dossier.$fichier;

		//if picture is updated
		$dossier = 'images/Profils/';
		$fichier = basename($_FILES['PhotoProfil']['name']);
		move_uploaded_file($_FILES['PhotoProfil']['tmp_name'], $dossier . $fichier);
		If(empty($fichier)){
			$AddSQL = '';
		}
		else{
			$AddSQL = 'IMAGE_PROFIL = \''. addslashes($UpdatePhotoProfil) .'\',';
		}

		If(empty($_POST['ProfilMDP'])){
			$AddSQL .= '';
		}else{
			$AddSQL .= 'PASSWORD = \''. addslashes($UpdateProfilMDP) .'\',';
		}
		
															
		//update database
		$bdd->GetUpdate('UPDATE `'. TABLE_ERP_EMPLOYEES .'` SET  NOM = \''. addslashes($UpdateProfilName) .'\',
																PRENOM = \''. addslashes($UpdateProfilSurName) .'\',
																DATE_NAISSANCE = \''. addslashes($UpdateProfilDate) .'\',
																MAIL = \''. addslashes($UpdateProfilMail) .'\',
																NUMERO_PERSO = \''. addslashes($UpdateProfilPersonnalNumber) .'\',
																NUMERO_INTERNE = \''. addslashes($UpdateProfilInternalNumber) .'\',
																'. $AddSQL .'
																NAME = \''. addslashes($UpdateProfilSpeudo) .'\'
																WHERE IdUser=\''. $_SESSION['id'] .'\'');

		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateProfilNotification')));
	}

	//If user make change setting profil
	if(isset($_POST['Language']) AND !empty($_POST['Language'])){
		$User = new User();
		$User->UpdateLanguage($_POST['Language']);
		stop($langue->show_text('SystemInfoLanguageDone'),	300,	'index.php?page=profil');
	}
?>
	<div class="tab">
		<button class="tablinks" onclick="openDiv(event, 'div1')" id="defaultOpen"><?=$langue->show_text('Titre1'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div2')" id="defaultOpen"><?=$langue->show_text('Titre2'); ?></button>
		<button class="tablinks" onclick="window.location.href = 'http://localhost/erp/public/index.php?page=login&action=deconnexion';"><?=$langue->show_text('Titre3'); ?></button>
	</div>
	<div id="div1" class="tabcontent" >
		<form method="post" action="index.php?page=profil" class="content-form" enctype="multipart/form-data" >
			<table class="content-table">
				<thead>
					<tr>
						<th colspan="2">
							<?= $langue->show_text('TitreTable1') ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<?= $langue->show_text('TableNameUser') ?>
						</td>
						<td>
							<input type="text" name="ProfilName" value="<?= $User->NOM ?>">
						</td>
					</tr>
					<tr>
						<td>
							<?= $langue->show_text('TableSurNameUser') ?>
						</td>
						<td>
							<input type="text" name="ProfilSurName" value="<?= $User->PRENOM ?>" >
						</td>
					</tr>
					<tr>
						<td>
							<?= $langue->show_text('TableDateBornUser') ?>
						</td>
						<td>
							<input type="date" name="ProfilDate" value="<?= $User->DATE_NAISSANCE ?>" >
						</td>
					</tr>
					<tr>
						<td>
							<?= $langue->show_text('TableSpeudoUser') ?>
						</td>
						<td>
							<input type="text" name="ProfilSpeudo" value="<?= $User->NAME ?>" >
						</td>
					</tr>
					<tr>
						<td>
							<?= $langue->show_text('TablePasswordUser') ?>
						</td>
						<td>
							<input type="password" name="ProfilMDP" value="" id="ProfilMDP" >
						</td>
					</tr>
					<tr>
						<td>
							<?= $langue->show_text('TableConfirmPasswordUser') ?>
						</td>
						<td>
							<input type="password" name="ProfilMDPComfirm" id="ProfilMDPComfirm" value="" >
						</td>
					</tr>
					<tr>
						<td>
							<?= $langue->show_text('TableMailUser') ?>
						</td>
						<td>
							<input type="text" name="ProfilMAIL" value="<?= $User->MAIL ?>">
						</td>
					</tr>
					<tr>
						<td>
							<?= $langue->show_text('TableInternalNumberUser') ?>
						</td>
						<td>
							<input type="text" name="ProfilInternalNumber" value="<?= $User->NUMERO_INTERNE ?>">
						</td>
					</tr>
					<tr>
						<td>
							<?= $langue->show_text('TablePersonnalNumberUser') ?>
						</td>
						<td>
							<input type="text" name="ProfilPersonnalNumber" value="<?= $User->NUMERO_PERSO ?>" >
						</td>
					</tr>
					<tr>
						<td colspan=2">
							<?= $langue->show_text('TablePictureUser') ?>
						</td>
					</tr>
					<tr>
						<td colspan=2" ><input type="file" name="PhotoProfil" /></td>
					</tr>
					<tr>
						<td colspan=2">
							<img src="<?= $User->IMAGE_PROFIL ?>" title="Photo profil" alt="Photo" />
						</td>
					</tr>
					<tr>
						<td colspan="2" >
							<br/>
							<?= $Form->submit($langue->show_text('TableUpdateButton')) ?> <br/>
							<br/>
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
	<div id="div2" class="tabcontent" >
		<form method="post" action="index.php?page=profil" class="content-form" >
			<table class="content-table">
				<thead>
					<tr>
						<th colspan="2">
						<?= $langue->show_text('TitreTable2') ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?= $langue->show_text('TableLanguageUser') ?></td>
						<td>
							<select name="Language">
								<option value="fr" <?= selected($User->LANGUAGE, 'fr') ?>><?= $langue->show_text('french') ?></option>
								<option value="en" <?= selected($User->LANGUAGE, 'en') ?>><?= $langue->show_text('english') ?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2" >
							<br/>
							<?= $Form->submit($langue->show_text('TableUpdateButton')) ?> <br/>
							<br/>
						</td>
					</tr>	
				</tbody>
			</table>
		</form>
	</div>