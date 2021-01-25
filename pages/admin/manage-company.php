<?php 
	//phpinfo();
	use \App\Autoloader;
	use \App\Form;
	use \App\COMPANY\Numbering;

	//auto load class
	require_once '../app/Autoload.class.php';
	Autoloader::register();
	
	session_start();
	header( 'content-type: text/html; charset=utf-8' );
	//init form class
	$Form = new Form($_POST);
	$Numbering = new Numbering();

	//Check if the user is authorized to view the page
	if($_SESSION['page_10'] != '1'){
		stop($langue->show_text('SystemInfoAccessDenied'), 161, 'index.php?page=login');
	}

	///////////////////////////////////
	////  PARAMETRE DE L'ENTREPRISE  ////
	//////////////////////////////////

	//if update gerenal info of company
	if(isset($_POST['CompanyName']) AND !empty($_POST['CompanyName'])){
		$Company->SetADDRESS('2 Rue Henriette Deloras');

		/*$update = array('NAME' =>  'SUPER ERP',
									'ADDRESS' =>  '2 Rue Henriette Deloras',
									'CITY' =>  'grenoble',
									'ZIPCODE' =>  '4000',
									'REGION' =>  'BRETAGNE' ,
									'COUNTRY' =>  'France' ,
									'PHONE_NUMBER' =>  '0679214987' ,
									'MAIL' =>  'SuperERP@gmail.com', 
									'WEB_SITE' =>  'www.erp.com' ,
									'FACEBOOK_SITE' =>  'https://www.facebook.com/Kevin.Niglaut',
									'TWITTER_SITE' =>  'https://twitter.com/kevin_niglaut/' ,
									'LKD_SITE' =>  '' ,
									'LOGO' =>  'images/unnamed.jpg' ,
									'SIREN' =>  '362 521 879' ,
									'APE' =>  '12347' ,
									'TVA_INTRA' =>  'FR53157896342.',
									'TAUX_TVA' =>  '20',
									'CAPITAL' =>  'SAS au capital de 2500 €',
									'RCS' =>  '400 900 001');*/
		
		
		
		/*$UpdateCompanyName = $_POST['CompanyName'];
		$UpdateCompanyAddress = $_POST['CompanyAddress'];
		$UpdateCompanyCity = $_POST['CompanyCity'];
		$UpdateCompanyZipCode= $_POST['CompanyZipCode'];
		$UpdateCompanyCountry = $_POST['CompanyCountry'];
		$UpdateCompanyRegion = $_POST['CompanyRegion'];
		$UpdateCompanyPhone = $_POST['CompanyPhone'];
		$UpdateCompanyMail = $_POST['CompanyMail'];
		$UpdateCompanyWebSite = $_POST['CompanyWebSite'];
		$UpdateCompanyFbSite = $_POST['CompanyFbSite'];
		$UpdateCompanyTwitter = $_POST['CompanyTwitter'];
		$UpdateCompanyLkd = $_POST['CompanyLkd'];
		$UpdateCompanyLogo = $dossier.$fichier;
		$UpdateCompanySIREN = $_POST['CompanySIREN'];
		$UpdateCompanyAPE = $_POST['CompanyAPE'];
		$UpdateCompanyTVAINTRA = $_POST['CompanyTVAINTRA'];
		$UpdateCompanyTAUXTVA = $_POST['CompanyTAUXTVA'];
		$UpdateCompanyCAPITAL = $_POST['CompanyCAPITAL'];
		$UpdateCompanyRCS = $_POST['CompanyRCS'];

		$dossier = 'images/';
		$fichier = basename($_FILES['fichier_LOGO']['name']);
		move_uploaded_file($_FILES['fichier_LOGO']['tmp_name'], $dossier . $fichier);
		If(empty($fichier)){
			$AddSQL = '';
		}
		else{
			$AddSQL = 'LOGO = \''. addslashes($UpdateCompanyLogo) .'\',';
		}

		//update data in db
		$bdd->exec('UPDATE `'. TABLE_ERP_COMPANY .'` SET  NAME = \''. addslashes($UpdateCompanyName) .'\',
																ADDRESS = \''. addslashes($UpdateCompanyAddress) .'\',
																CITY = \''. addslashes($UpdateCompanyCity) .'\',
																ZIPCODE = \''. addslashes($UpdateCompanyZipCode) .'\',
																REGION = \''. addslashes($UpdateCompanyRegion) .'\',
																COUNTRY = \''. addslashes($UpdateCompanyCountry) .'\',
																PHONE_NUMBER = \''. addslashes($UpdateCompanyPhone) .'\',
																MAIL = \''. addslashes($UpdateCompanyMail) .'\',
																WEB_SITE = \''. addslashes($UpdateCompanyWebSite) .'\',
																FACEBOOK_SITE = \''. addslashes($UpdateCompanyFbSite) .'\',
																TWITTER_SITE = \''. addslashes($UpdateCompanyTwitter) .'\',
																LKD_SITE = \''. addslashes($UpdateCompanyLkd) .'\',
																'. $AddSQL .'
																SIREN = \''. addslashes($UpdateCompanySIREN) .'\',
																APE = \''. addslashes($UpdateCompanyAPE) .'\',
																TVA_INTRA = \''. addslashes($UpdateCompanyTVAINTRA) .'\',
																TAUX_TVA = \''. addslashes($UpdateCompanyTAUXTVA) .'\',
																CAPITAL = \''. addslashes($UpdateCompanyCAPITAL) .'\',
																RCS = \''. addslashes($UpdateCompanyRCS) .'\'
																WHERE Id=1');*/
	}



	////////////////////////
	//// SECTOR ACTIVITY////
	///////////////////////

	//add new sector activity
	if(isset($_POST['AddCODESector']) AND !empty($_POST['AddCODESector'])){

		$req = $bdd->GetInsert("INSERT INTO ". TABLE_ERP_ACTIVITY_SECTOR ." VALUE ('0',
																		'". addslashes($_POST['AddCODESector']) ."',
																		'". addslashes($_POST['AddLABELSector']) ."')");
		$CallOutBox->add_notification(array('2', $langue->show_text('AddSectorNotification')));
	}

	//update sector activity
	if(isset($_POST['id_sector']) AND !empty($_POST['id_sector'])){

		$UpdateIdSector = $_POST['id_sector'];
		$UpdateCODESector = $_POST['UpdateCODESector'];
		$UpdateLABELSector = $_POST['UpdateLABELSector'];

		$i = 0;
		foreach ($UpdateIdSector as $id_generation) {
			$bdd->GetUpdate('UPDATE `'. TABLE_ERP_ACTIVITY_SECTOR .'` SET  CODE = \''. addslashes($UpdateCODESector[$i]) .'\',
																LABEL = \''. addslashes($UpdateLABELSector[$i]) .'\'
																WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateSectorNotification')));
	}

	////////////////////////
	//// NUM DOCUMENTS ////
	///////////////////////

	//if add new document
	if(isset($_POST['AddDOCNum']) AND !empty($_POST['AddDOCNum'])){

		$req = $bdd->GetInsert("INSERT INTO ". TABLE_ERP_NUM_DOC ." VALUE ('0',
																		'". addslashes($_POST['AddDOCNum']) ."',
																		'". addslashes($_POST['AddModeleNum']) ."',
																		'". addslashes($_POST['AddDigitNum']) ."',
																		'0')");
		$CallOutBox->add_notification(array('2', $langue->show_text('AddDocNotification')));
	}

	// if update num sequence document
	if(isset($_POST['id_NumDoc']) AND !empty($_POST['id_NumDoc'])){

		$UpdateIdNumDoc = $_POST['id_NumDoc'];
		$UpdateDOCNum = $_POST['UpdateDOCNum'];
		$UpddateModeleNum = $_POST['UpddateModeleNum'];

		$i = 0;
		foreach ($UpdateIdNumDoc as $id_generation) {

			$bdd->GetUpdate('UPDATE `'. TABLE_ERP_NUM_DOC .'` SET  DOC_TYPE = \''. addslashes($UpdateDOCNum[$i]) .'\',
																MODEL = \''. addslashes($UpddateModeleNum[$i]) .'\'
																WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateDocNotification')));
	}

	////////////////////////
	//// EMAIL ////
	///////////////////////

	//Model email add
	if(isset($_POST['AddCODEMail']) AND !empty($_POST['AddCODEMail'])){

		$req = $bdd->GetInsert("INSERT INTO ". TABLE_ERP_EMAIL ." VALUE ('0',
																		'". addslashes($_POST['AddCODEMail']) ."',
																		'". addslashes($_POST['AddLABELMAIL']) ."',
																		'". addslashes($_POST['AddOBJETMail']) ."',
																		'". addslashes($_POST['AddTEXTMAIL']) ."')");
		$CallOutBox->add_notification(array('2', $langue->show_text('AddMailNotification')));
	}

	//update mail model
	if(isset($_POST['UpdateIdMail']) AND !empty($_POST['UpdateIdMail'])){

		$UpdateIdMail = $_POST['UpdateIdMail'];
		$UpddateObjetMail = $_POST['UpddateObjetMail'];
		$UpddateTextMail = $_POST['UpddateTextMail'];

		$bdd->GetUpdate('UPDATE `'. TABLE_ERP_EMAIL .'` SET  OBJET = \''. addslashes($UpddateObjetMail) .'\',
																TEXT = \''. addslashes($UpddateTextMail) .'\'
																WHERE id = '. $UpdateIdMail.'');
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateMailNotification')));
	}

	////////////////////////
	//// TIMELINE ////
	///////////////////////

	//TIMELINE  add
	if(isset($_POST['AddTEXTTIMELINE']) AND !empty($_POST['AddTEXTTIMELINE'])){

		$req = $bdd->GetInsert("INSERT INTO ". TABLE_ERP_INFO_GENERAL ." VALUE ('0',
																		'". addslashes($_POST['AddEtatTIMELINE']) ."',
																		'". time() ."',
																		'". addslashes($_POST['AddTEXTTIMELINE']) ."')");
		$CallOutBox->add_notification(array('2', $langue->show_text('AddTimelineNotification')));
	}

	//TIMELINE  update
	if(isset($_POST['UpdateIdTimeLine']) AND !empty($_POST['UpdateIdTimeLine'])){

		$UpdateIdTimeLine = $_POST['UpdateIdTimeLine'];
		$UpddateEtatTimeLine = $_POST['UpddateEtatTimeLine'];
		$UpddateTextTimeLine = $_POST['UpddateTextTimeLine'];

		$bdd->GetUpdate('UPDATE `'. TABLE_ERP_INFO_GENERAL .'` SET  ETAT = \''. addslashes($UpddateEtatTimeLine) .'\',
																TEXT = \''. addslashes($UpddateTextTimeLine) .'\'
																WHERE id = '. $UpdateIdTimeLine.'');
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateTimelineNotification')));
	}

	if(isset($_POST['id_sector']) AND !empty($_POST['id_sector'])){
		$ParDefautDiv2 = 'id="defaultOpen"';
	}
	elseif(isset($_GET['mail']) AND !empty($_GET['mail'])){
		$ParDefautDiv3 = 'id="defaultOpen"';
	}
	elseif(isset($_POST['id_NumDoc']) AND !empty($_POST['id_NumDoc'])){
		$ParDefautDiv4 = 'id="defaultOpen"';
	}
	elseif(isset($_GET['timeline']) AND !empty($_GET['timeline'])){
		$ParDefautDiv5 = 'id="defaultOpen"';
	}
	else{
		$ParDefautDiv1 = 'id="defaultOpen"';
	}
?>
	<div class="tab">
		<button class="tablinks" onclick="openDiv(event, 'div1')" <?=$ParDefautDiv1; ?>><?=$langue->show_text('Titre1'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div2')" <?=$ParDefautDiv2; ?>><?=$langue->show_text('Titre2'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div3')" <?=$ParDefautDiv3; ?>><?=$langue->show_text('Titre3'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div4')" <?=$ParDefautDiv4; ?>><?=$langue->show_text('Titre4'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div5')" <?=$ParDefautDiv5; ?>><?=$langue->show_text('Titre5'); ?></button>
	</div>
	<div id="div1" class="tabcontent" >
			<form method="post" name="Company" action="admin.php?page=manage-company" class="content-form" enctype="multipart/form-data" >
				<table class="content-table">
					<thead>
						<tr>
							<th colspan="5"><br/></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><?= $langue->show_text('TableNameCompany') ?></td>
							<td><?= $langue->show_text('TableAdresse') ?></td>
							<td><?= $langue->show_text('TableCity') ?></td>
							<td><?= $langue->show_text('TableZipCode') ?></td>
							<td><?= $langue->show_text('TableRegion') ?></td>
							<td><?= $langue->show_text('TableCountry') ?></td>
						</tr>
						<tr>
							<td >
								<input type="text" name="CompanyName" value="<?= $Company->CompanyName() ?>">
							</td>
							<td >
								<input type="text" name="CompanyAddress" value="<?= $Company->CompanyAddress() ?>">
							</td>
							<td >
								<input type="text" name="CompanyCity" value="<?= $Company->CompanyCity() ?>">
							</td>
							<td >
								<input type="text" name="CompanyZipCode" value="<?= $Company->CompanyZipCode() ?>">
							</td>
							<td>
								<input type="text" name="CompanyRegion" value="<?= $Company->CompanyRegion() ?>">
							</td>
							<td>
								<input type="text" name="CompanyCountry" value="<?= $Company->CompanyCountry() ?>">
							</td>
						</tr>
						<tr>
							<td><?= $langue->show_text('TablePhoneNumber') ?></td>
							<td><?= $langue->show_text('TableMail') ?></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td >
								<input type="text" name="CompanyPhone" value="<?= $Company->CompanyPhone() ?>">
							</td>
							<td >
								<input type="text" name="CompanyMail" value="<?= $Company->CompanyMail() ?>">
							</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td><?= $langue->show_text('TableWebSite') ?></td>
							<td><?= $langue->show_text('TableFacebook') ?></td>
							<td><?= $langue->show_text('TableTwitter') ?></td>
							<td><?= $langue->show_text('TableLinked') ?></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>
								<input type="text" name="CompanyWebSite" value="<?= $Company->CompanyWebSite() ?>">
							</td>
							<td >
								<input type="text" name="CompanyFbSite" value="<?= $Company->CompanyFbSite() ?>">
							</td>
							<td>
								<input type="text" name="CompanyTwitter" value="<?=  $Company->CompanyTwitter() ?>">
							</td>
							<td>
								<input type="text" name="CompanyLkd" value="<?=  $Company->CompanyLkd() ?>">
							</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td><?= $langue->show_text('TableSIREN') ?></td>
							<td><?= $langue->show_text('TableAPE') ?></td>
							<td><?= $langue->show_text('TableTVAINTRA') ?></td>
							<td><?= $langue->show_text('TableTVAType') ?></td>
							<td><?= $langue->show_text('TableCapital') ?></td>
							<td><?= $langue->show_text('TableRCS') ?></td>
						</tr>
						<tr>
							<td >
								<input type="text" name="CompanySIREN" value="<?= $Company->CompanySIREN() ?>" >
							</td>
							<td >
								<input type="text" name="CompanyAPE" value="<?= $Company->CompanyAPE() ?>">
							</td>
							<td >
								<input type="text" name="CompanyTVAINTRA" value="<?= $Company->CompanyTVAINTRA() ?>" >
							</td>
							<td >
								<input type="text" name="CompanyTAUXTVA" value="<?= $Company->CompanyTAUXTVA() ?>" >
							</td>
							<td>
								<input type="text" name="CompanyCAPITAL" value="<?= $Company->CompanyCAPITAL() ?>" >
							</td>
							<td>
								<input type="text" name="CompanyRCS" value="<?= $Company->CompanyRCS() ?>" >
							</td>
						</tr>
						<tr>
							<td colspan=6"><?= $langue->show_text('TableLogo') ?></td>
						</tr>
						<tr>
							<td colspan=6" ><input type="file" name="fichier_LOGO" /></td>
						</tr>
						<tr>
							<td colspan=6"><img src="<?= $Company->CompanyLogo() ?>" title="LOGO entreprise" alt="Logo" /></td>
						</tr>
						<tr>
							<td colspan="6" >
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
			<form method="post" name="Section" action="admin.php?page=manage-company" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th><?=$langue->show_text('TableCODE'); ?></th>
							<th><?=$langue->show_text('TableLabel'); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php
					//generate list of actiity sector
					$query ='SELECT '. TABLE_ERP_ACTIVITY_SECTOR .'.Id,
									'. TABLE_ERP_ACTIVITY_SECTOR .'.CODE,
									'. TABLE_ERP_ACTIVITY_SECTOR .'.LABEL
									FROM `'. TABLE_ERP_ACTIVITY_SECTOR .'`
									ORDER BY Id';

					$i = 1;
					foreach ($bdd->GetQuery($query) as $data): ?>
				<tr>
					<td><?= $i ?><?= $Form->input('hidden', 'id_sector[]',  $data->Id) ?></td>
					<td><?= $Form->input('text', 'UpdateCODESector[]',  $data->CODE) ?></td>
					<td><?= $Form->input('text', 'UpdateLABELSector[]',  $data->LABEL) ?></td>
				</tr>
				<?php $i++; endforeach; ?>
						<tr>
							<td><?=$langue->show_text('Addtext') ?></td>
							<td><input type="text" class="input-moyen-vide" name="AddCODESector"></td>
							<td><input type="text" class="input-moyen-vide" name="AddLABELSector" ></td>
						</tr>
						<tr>
							<td colspan="3" >
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
		<form method="post" name="Section" action="admin.php?page=manage-company" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th><?=$langue->show_text('TableCODE'); ?></th>
							<th><?=$langue->show_text('TableLabel'); ?></th>
							<th><?=$langue->show_text('TableObjet'); ?></th>
							<th><?=$langue->show_text('TableText'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
						//generat list of mail model
						$i = 1;
						$query='SELECT '. TABLE_ERP_EMAIL .'.Id,
									'. TABLE_ERP_EMAIL .'.CODE,
									'. TABLE_ERP_EMAIL .'.LABEL,
									'. TABLE_ERP_EMAIL .'.OBJET,
									'. TABLE_ERP_EMAIL .'.TEXT
									FROM `'. TABLE_ERP_EMAIL .'`
									ORDER BY Id';

						foreach ($bdd->GetQuery($query) as $data):?>
						<tr>
							<td></td>
							<td><a href="admin.php?page=manage-company&mail=<?= $data->Id ?>"><?= $data->CODE ?></a></td>
							<td><a href="admin.php?page=manage-company&mail=<?= $data->Id ?>"><?= $data->LABEL ?></a></td>
							<td><a href="admin.php?page=manage-company&mail=<?= $data->Id ?>"><?= $data->OBJET ?></a></td>
							<td><?= extrait($data->TEXT) ?></td>
						</tr>
						<?php $i++; endforeach; 
						
						//generat detail of select mail
						if(isset($_GET['mail']) AND !empty($_GET['mail'])){

							$Data = $bdd->GetQuery('SELECT '. TABLE_ERP_EMAIL .'.Id,
									'. TABLE_ERP_EMAIL .'.CODE,
									'. TABLE_ERP_EMAIL .'.LABEL,
									'. TABLE_ERP_EMAIL .'.OBJET,
									'. TABLE_ERP_EMAIL .'.TEXT
									FROM `'. TABLE_ERP_EMAIL .'`
									WHERE id = '. addslashes($_GET['mail']).'', True); ?>

						<tr>
							<td><input type="hidden" name="UpdateIdMail" value="<?= $Data->Id ?>">Objet :</td>
							<td colspan="3"><input type="text" name="UpddateObjetMail" value="<?= $Data->OBJET ?>" ></td>
							<td></td>
						</tr>
						<tr>
							<td><?= $langue->show_text('TableMessage') ?></td>
							<td colspan="3" >
								<textarea id="UpddateTextMail" name="UpddateTextMail" rows="10" cols="100" style="align-content:left; white-space: normal;"><?= $Data->TEXT ?></textarea>
							</td>
							<td>
								<p>
									<01> - <?= $langue->show_text('CODEMAIL01') ?><br/>
									<02> - <?= $langue->show_text('CODEMAIL02') ?><br/>
									<03> - <?= $langue->show_text('CODEMAIL03') ?><br/>
									<04> - <?= $langue->show_text('CODEMAIL04') ?><br/>
									<05> - <?= $langue->show_text('CODEMAIL05') ?><br/>
									<06> - <?= $langue->show_text('CODEMAIL06') ?><br/>
									<07> - <?= $langue->show_text('CODEMAIL07') ?><br/>
									<08> - <?= $langue->show_text('CODEMAIL08') ?><br/>
								</p>
							</td>
						</tr>
						<?php } ?>
						<tr>
							<td><?=$langue->show_text('Addtext'); ?></td>
							<td><input type="text" class="input-moyen-vide" name="AddCODEMail" ></td>
							<td><input type="text" class="input-moyen-vide" name="AddLABELMAIL" ></td>
							<td><input type="text" class="input-moyen-vide" name="AddOBJETMail" ></td>
							<td><input type="text" class="input-moyen-vide" name="AddTEXTMAIL" ></td>
						</tr>
						<tr>
							<td colspan="6" >
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
			<form method="post" name="Section" action="admin.php?page=manage-company" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th><?=$langue->show_text('TableDocument'); ?></th>
							<th><?=$langue->show_text('TableModel'); ?></th>
							<th><?=$langue->show_text('TableDigitNumber'); ?></th>
							<th><?=$langue->show_text('TableCurentIndex'); ?></th>
							<th><?=$langue->show_text('TableExemple'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
						//generate list of Sequence number document
						$query='SELECT '. TABLE_ERP_NUM_DOC .'.Id,
												'. TABLE_ERP_NUM_DOC .'.DOC_TYPE,
												'. TABLE_ERP_NUM_DOC .'.MODEL,
												'. TABLE_ERP_NUM_DOC .'.DIGIT,
												'. TABLE_ERP_NUM_DOC .'.COMPTEUR
												FROM `'. TABLE_ERP_NUM_DOC .'`
												ORDER BY Id';

						$i = 1;
						foreach ($bdd->GetQuery($query) as $data): 
							$Exemple = $Numbering->getCodeNumbering($type='0', $sql ='', $data->MODEL , $data->DIGIT, $data->COMPTEUR);
						?>
						<tr>
							<td><?= $i ?> <input type="hidden" name="id_NumDoc[]" id="id_NumDoc" value="<?= $data->Id ?>"></td>
							<td>
								<select name="UpdateDOCNum[]">
									<option value="1" <?= selected($data->DOC_TYPE, 1) ?>><?= $langue->show_text('SelectBLS') ?></option>
									<option value="2" <?= selected($data->DOC_TYPE, 2) ?>><?= $langue->show_text('SelectBLC') ?></option>
									<option value="3" <?= selected($data->DOC_TYPE, 3) ?>><?= $langue->show_text('SelectBL') ?></option>
									<option value="4" <?= selected($data->DOC_TYPE, 4) ?>><?= $langue->show_text('SelectORDER') ?></option>
									<option value="5" <?= selected($data->DOC_TYPE, 5) ?>><?= $langue->show_text('SelectBUYORDER') ?></option>
									<option value="6" <?= selected($data->DOC_TYPE, 6) ?>><?= $langue->show_text('SelectINTORDER') ?></option>
									<option value="7" <?= selected($data->DOC_TYPE, 7) ?>><?= $langue->show_text('SelectASK') ?></option>
									<option value="8" <?= selected($data->DOC_TYPE, 8) ?>><?= $langue->show_text('SelectQUOTE') ?></option>
									<option value="9" <?= selected($data->DOC_TYPE, 9) ?>><?= $langue->show_text('SelectINVOICE') ?></option>
									<option value="10" <?= selected($data->DOC_TYPE, 10) ?>><?= $langue->show_text('SelectINVOICESUP') ?></option>
									<option value="11" <?= selected($data->DOC_TYPE, 11) ?>><?= $langue->show_text('SelectNONCONF') ?></option>
									<option value="12" <?= selected($data->DOC_TYPE, 12) ?>><?= $langue->show_text('SelectAR') ?></option>
								</select>
							</td>
							<td><input type="text" class="input-moyen-vide" name="UpddateModeleNum[]" value="<?= $data->MODEL ?>" ></td>
							<td><?= $data->DIGIT ?></td>
							<td><?= $data->COMPTEUR ?></td>
							<td><?= $Exemple ?></td>
						</tr>
						<?php $i++; endforeach; ?>
						<tr>
							<td><?=$langue->show_text('Addtext'); ?></td>
							<td>
								<select name="AddDOCNum">
									<option value="0"><?=$langue->show_text('SelectAR'); ?></option>
									<option value="1"><?=$langue->show_text('SelectBLS'); ?></option>
									<option value="2"><?=$langue->show_text('SelectBLC'); ?></option>
									<option value="3"><?=$langue->show_text('SelectBL'); ?></option>
									<option value="4"><?=$langue->show_text('SelectORDER'); ?></option>
									<option value="5"><?=$langue->show_text('SelectBUYORDER'); ?></option>
									<option value="6"><?=$langue->show_text('SelectINTORDER'); ?></option>
									<option value="7"><?=$langue->show_text('SelectASK'); ?></option>
									<option value="8"><?=$langue->show_text('SelectQUOTE'); ?></option>
									<option value="9"><?=$langue->show_text('SelectINVOICE'); ?></option>
									<option value="10"><?=$langue->show_text('SelectINVOICESUP'); ?></option>
									<option value="11"><?=$langue->show_text('SelectNONCONF'); ?></option>
								</select>
							</td>
							<td><input type="text" class="input-moyen-vide" name="AddModeleNum" ></td>
							<td colspan="3" ><input type="number" class="input-moyen-vide" name="AddDigitNum" ></td>
						</tr>
						<tr>
							<td colspan="6" >
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
				<form method="post" name="TimeLine" action="admin.php?page=manage-company" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th><?=$langue->show_text('TableState'); ?></th>
							<th><?=$langue->show_text('TableText'); ?></th>
							<th><?=$langue->show_text('TablePostDate'); ?></th>
						</tr>
					</thead>
					<tbody>
<?php
						//generate TIMELINE
						$query='SELECT '. TABLE_ERP_INFO_GENERAL .'.Id,
									'. TABLE_ERP_INFO_GENERAL .'.TIMESTAMP,
									'. TABLE_ERP_INFO_GENERAL .'.ETAT,
									'. TABLE_ERP_INFO_GENERAL .'.TEXT
									FROM `'. TABLE_ERP_INFO_GENERAL .'`
									ORDER BY Id';
						$i = 1;
						foreach ($bdd->GetQuery($query) as $data): 
						if($data->ETAT == 2){$EtatTimeLine = "En édition";}
						if($data->ETAT == 1){$EtatTimeLine = "Afficher";}
						if($data->ETAT == 0){$EtatTimeLine = "Non publiée";}?>
						<tr>
							<td></td>
							<td><a href="admin.php?page=manage-company&timeline=<?= $data->Id ?>"><?= $EtatTimeLine ?></a></td>
							<td><a href="admin.php?page=manage-company&timeline=<?= $data->Id ?>"><?= extrait($data->TEXT) ?></a></td>
							<td><a href="admin.php?page=manage-company&timeline=<?= $data->Id ?>"><?= format_temps($data->TIMESTAMP) ?></a></td>
						</tr>
						<?php $i++; endforeach; 
						
						if(isset($_GET['timeline']) AND !empty($_GET['timeline'])){

							$Data = $bdd->GetQuery('SELECT '. TABLE_ERP_INFO_GENERAL .'.Id,
														'. TABLE_ERP_INFO_GENERAL .'.ETAT,
														'. TABLE_ERP_INFO_GENERAL .'.TEXT
														FROM `'. TABLE_ERP_INFO_GENERAL .'`
														WHERE id = '. addslashes($_GET['timeline']).'', True);
						?>
						<tr>
							<td><input type="hidden" name="UpdateIdTimeLine" value="<?= $Data->Id ?>">Etat :</td>
							<td>
								<select name="UpddateEtatTimeLine">
									<option value="2" <?= selected($Data->ETAT, 2) ?>><?= $langue->show_text('SelectEdition') ?></option>
									<option value="1" <?= selected($Data->ETAT, 1) ?><?= $langue->show_text('SelectDisplay') ?></option>
									<option value="0" <?= selected($Data->ETAT, 0) ?>><?= $langue->show_text('SelectNoDisplay') ?></option>
								</select>
							</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td><?= $langue->show_text('TableMessage') ?></td>
							<td colspan="3" >
								<textarea id="UpddateTextTimeLine" name="UpddateTextTimeLine" rows="10" cols="100" style="align-content:left; white-space: normal;"><?= $Data->TEXT ?></textarea>
							</td>
						</tr>
						<?php }?>
						<tr>
							<td><?=$langue->show_text('Addtext'); ?></td>
							<td>
								<select name="AddEtatTIMELINE">
									<option value="2"><?= $langue->show_text('SelectEdition'); ?></option>
									<option value="1"><?= $langue->show_text('SelectDisplay'); ?></option>
									<option value="0"><?= $langue->show_text('SelectNoDisplay'); ?></option>
								</select>
							</td>
							<td><input type="text" class="input-moyen-vide" name="AddTEXTTIMELINE" ></td>
							<td></td>
						</tr>
						<tr>
							<td colspan="6" >
								<br/>
								<?= $Form->submit($langue->show_text('TableUpdateButton')) ?> <br/>
								<br/>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
	</div>