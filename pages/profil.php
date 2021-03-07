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
	elseif(isset($_POST['Language']) AND !empty($_POST['Language'])){
		//If user make change language profil
		$User = new User();
		$User->UpdateLanguage($_POST['Language']);
		stop($langue->show_text('SystemInfoLanguageDone'),	300,	'index.php?page=profil&password');
	}
	elseif( isset( $_FILES["IMAGE_PROFIL"] ) && !empty( $_FILES["IMAGE_PROFIL"]["name"] ) ) {
		//if picture is updated
		$dossier = PICTURE_FOLDER.PROFIL_FOLDER;
		$fichier = basename($_FILES['IMAGE_PROFIL']['name']);

		If(!empty($_POST)){		
			move_uploaded_file($_FILES['IMAGE_PROFIL']['tmp_name'], $dossier . $fichier);
			$bdd->GetUpdatePOST(TABLE_ERP_EMPLOYEES, array("IMAGE_PROFIL" => $fichier ), 'WHERE IdUser='. $User->idUSER . '');
		}	
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateProfilNotification')));
	}
	elseif(isset($_POST['PASSWORD']) AND !empty($_POST['PASSWORD'])){
		//if password is updated
		$UpdateProfilMDP = array('PASSWORD' => password_hash($_POST['PASSWORD'], PASSWORD_DEFAULT));
		$bdd->GetUpdatePOST(TABLE_ERP_EMPLOYEES, $UpdateProfilMDP, 'WHERE IdUser='. $User->idUSER . '');
		$User = $auth->User();
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateProfilNotification')));
	}
			
	if(isset($_GET['password'])){
		$ParDefautDiv2 = 'id="defaultOpen"';
	}
	elseif(isset($_POST['IMAGE_PROFIL']) AND !empty($_POST['IMAGE_PROFIL'])){	
		$ParDefautDiv3 = 'id="defaultOpen"';
	}
	else{
		$ParDefautDiv1 = 'id="defaultOpen"';
	}
					
?>
	<div class="tab">
		<button class="tablinks" onclick="openDiv(event, 'div1')"  <?= $ParDefautDiv1 ?>><?=$langue->show_text('Titre1'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div2')"  <?= $ParDefautDiv2 ?>><?=$langue->show_text('Titre2'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div3')"  <?= $ParDefautDiv3 ?>><?=$langue->show_text('Titre3'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div4')"  <?= $ParDefautDiv4 ?>><?=$langue->show_text('Titre4'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div5')"  <?= $ParDefautDiv4 ?>>RGPD</button>
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
						<td colspan="2" >
							<br/>
							<?=$Company->NAME ?> traite les données recueillies pour la gestion des l'entreprise.<br/>
							<br/>
							Pour en savoir plus sur la gestion de vos données personnelles et pour exercer vos droits, reportez-vous à la notice dans l'onglet ci-dessus.
							<br/>
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
		<form method="post" action="index.php?page=profil" class="content-form" enctype="multipart/form-data" >
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
	<div id="div5" class="tabcontent" >
		
			<table class="content-table">
				<thead>
					<tr>
						<th>RGPD</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							Les informations recueillies dans le questionnaire sont enregistrées dans un fichier informatisé par [coordonnées du responsable de traitement].<br/>
							<br/>
							Les données marquées par un astérisque dans le questionnaire doivent obligatoirement être fournies. Dans le cas contraire, [préciser les conséquences éventuelles en cas de non-fourniture des données].<br/>
							<br/>
							Les données collectées seront communiquées aux seuls clients inclue dans la base de données.<br/>
							<br/>
							Elles sont conservées pendant [durée de conservation des données prévue par le responsable du traitement ou critères permettant de la déterminer].<br/>
							<br/>
							Vous pouvez accéder aux données vous concernant, les rectifier, demander leur effacement ou exercer votre droit à la limitation du traitement de vos données. (en fonction de la base légale du traitement, mentionner également : Vous pouvez retirer à tout moment votre consentement au traitement de vos données ; Vous pouvez également vous opposer au traitement de vos données ; Vous pouvez également exercer votre droit à la portabilité de vos données)<br/>
							<br/><br/>
							Pour exercer ces droits ou pour toute question sur le traitement de vos données dans ce dispositif, vous pouvez contacter  : <br/>
						</td>
					</tr>
				</tbody>
			</table>
	</div>