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
	if(isset($_POST['NOM']) AND !empty($_POST['NOM'])){
		$bdd->GetUpdatePOST(TABLE_ERP_EMPLOYEES, $_POST, 'WHERE IdUser='. $User->idUSER . '');
		$User = $auth->User();
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateProfilNotification')));
	}

	//If user make change language profil
	if(isset($_POST['Language']) AND !empty($_POST['Language'])){
		$User = new User();
		$User->UpdateLanguage($_POST['Language']);
		stop($langue->show_text('SystemInfoLanguageDone'),	300,	'index.php?page=profil');
	}

	//if picture is updated
	if(isset($_POST['IMAGE_PROFIL']) AND !empty($_POST['IMAGE_PROFIL'])){	
		
		$dossier = PICTURE_FOLDER.PROFIL_FOLDER;
		$fichier = basename($_FILES['IMAGE_PROFIL']['name']);

		If(!empty($_POST)){		
			move_uploaded_file($_FILES['IMAGE_PROFIL']['tmp_name'], $dossier . $fichier);
			$bdd->GetUpdatePOST(TABLE_ERP_EMPLOYEES, $_POST, 'WHERE IdUser='. $User->idUSER . '');
		}	
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateProfilNotification')));
	}
	
	//if password is updated
	if(isset($_POST['PASSWORD']) AND !empty($_POST['PASSWORD'])){

		$UpdateProfilMDP = array('PASSWORD' => password_hash($_POST['PASSWORD'], PASSWORD_DEFAULT));
		$bdd->GetUpdatePOST(TABLE_ERP_EMPLOYEES, $UpdateProfilMDP, 'WHERE IdUser='. $User->idUSER . '');
		$User = $auth->User();
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateProfilNotification')));
	}
			
				
?>
	<div class="tab">
		<button class="tablinks" onclick="openDiv(event, 'div1')" id="defaultOpen"><?=$langue->show_text('Titre1'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div2')" id="defaultOpen"><?=$langue->show_text('Titre2'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div3')" id="defaultOpen"><?=$langue->show_text('Titre3'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div4')" id="defaultOpen"><?=$langue->show_text('Titre4'); ?></button>
		<button class="tablinks" onclick="window.location.href = 'http://localhost/erp/public/index.php?page=login&action=deconnexion';"><?=$langue->show_text('Titre5'); ?></button>
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
							<input type="text" name="NOM" value="<?= $User->NOM ?>">
						</td>
					</tr>
					<tr>
						<td>
							<?= $langue->show_text('TableSurNameUser') ?>
						</td>
						<td>
							<input type="text" name="PRENOM" value="<?= $User->PRENOM ?>" >
						</td>
					</tr>
					<tr>
						<td>
							<?= $langue->show_text('TableDateBornUser') ?>
						</td>
						<td>
							<input type="date" name="DATE_NAISSANCE" value="<?= $User->DATE_NAISSANCE ?>" >
						</td>
					</tr>
					<tr>
						<td>
							<?= $langue->show_text('TableSpeudoUser') ?>
						</td>
						<td>
							<input type="text" name="NAME" value="<?= $User->NAME ?>" >
						</td>
					</tr>
					<tr>
						<td>
							<?= $langue->show_text('TableMailUser') ?>
						</td>
						<td>
							<input type="text" name="MAIL" value="<?= $User->MAIL ?>">
						</td>
					</tr>
					<tr>
						<td>
							<?= $langue->show_text('TableInternalNumberUser') ?>
						</td>
						<td>
							<input type="text" name="NUMERO_INTERNE" value="<?= $User->NUMERO_INTERNE ?>">
						</td>
					</tr>
					<tr>
						<td>
							<?= $langue->show_text('TablePersonnalNumberUser') ?>
						</td>
						<td>
							<input type="text" name="NUMERO_PERSO" value="<?= $User->NUMERO_PERSO ?>" >
						</td>
					</tr>
					<tr>
						<td colspan=2">
							<?= $langue->show_text('TablePictureUser') ?>
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
	<div id="div3" class="tabcontent" >
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
						<td>
							<?= $langue->show_text('TablePasswordUser') ?>
						</td>
						<td>
							<input type="password" name="PASSWORD" value="" id="ProfilMDP" >
						</td>
					</tr>
					<tr>
						<td>
							<?= $langue->show_text('TableConfirmPasswordUser') ?>
						</td>
						<td>
							<input type="password" name="PASSWORDComfirm" id="ProfilMDPComfirm" value="" >
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
	<div id="div4" class="tabcontent" >
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
						<td colspan=2" ><input type="file" name="IMAGE_PROFIL" /></td>
					</tr>
					<tr>
						<td colspan=2">
							<img src="<?= PICTURE_FOLDER.PROFIL_FOLDER.$User->IMAGE_PROFIL ?>" title="Photo profil" alt="Photo" />
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