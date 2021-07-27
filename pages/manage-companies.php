<?php 
	//phpinfo();
	use \App\Autoloader;
	use \App\Companies\Companies;
	use \App\Companies\Contact;
	use \App\Companies\Address;
	use \App\COMPANY\Employees;
	use \App\COMPANY\ActivitySector;
	use \App\Accounting\PaymentMethod;
	use \App\Accounting\PaymentCondition;
	use \App\Accounting\VAT;
	use \App\UI\Document;
	use \App\UI\Form;
	use \App\UI\UI;

	//auto load class
	require_once '../app/Autoload.class.php';
	Autoloader::register();
	
	session_start();
	header( 'content-type: text/html; charset=utf-8' );
	//init form class
	$Form = new Form($_POST);
	$Employees = new Employees();
	$Companies = new Companies();
	$Contact =  new Contact();
	$Address = new Address();
	$ActivitySector = new ActivitySector();
	$PaymentMethod = new PaymentMethod();
	$PaymentCondition = new PaymentCondition();
	$VAT = new VAT();
	$Document = new Document();
	$UI = new UI();

	//Check if the user is authorized to view the page
	if($_SESSION['page_10'] != '1'){
		stop($langue->show_text('SystemInfoAccessDenied'), 161, 'index.php?page=login');
	}

	///////////////////////////////////
	////  CLIENT / FOURNISSEUR   ////
	//////////////////////////////////

	$titleOnglet1 = $langue->show_text('Titre1');

	//if post CODE or isset get Id for display company
	if(isset($_POST['CODE']) AND isset($_POST['NameSte']) AND !empty($_POST['CODE']) AND !empty($_POST['NameSte']) OR  isset($_POST['id']) AND !empty($_POST['id']) OR  isset($_GET['id']) AND !empty($_GET['id'])){

		//if isset new CODE company
		if(isset($_POST['CODE'])){

			// check if exist
			if($Companies->GETCompanieCount(addslashes($_POST['id']))==1){

				//change title tag
				$titleOnglet1 = $langue->show_text('TableUpdateButton');

				//up picture of company and add sql or not
				$fichier = basename($_FILES['fichier_LOGOSte']['name']);
				move_uploaded_file($_FILES['fichier_LOGOSte']['tmp_name'], PICTURE_FOLDER.COMPANIES_FOLDER . $fichier);
				If(empty($fichier)){
					$AddSQL = '';
				}
				else{
					$AddSQL = 'LOGO = \''. addslashes($fichier) .'\',';
				}

				//update database with post
				$bdd->GetUpdate("UPDATE  ". TABLE_ERP_COMPANES ." SET 		CODE='". addslashes($_POST['CODE']) ."',
																				LABEL='". addslashes($_POST['NameSte']) ."',
																				WEBSITE='". addslashes($_POST['WebSiteSte']) ."',
																				FBSITE='". addslashes($_POST['FbSiteSte']) ."',
																				TWITTERSITE='". addslashes($_POST['TwitterSte']) ."',
																				LKDSITE='". addslashes($_POST['LkdSte']) ."',
																				SIREN='". addslashes($_POST['SIRENSte']) ."',
																				APE='". addslashes($_POST['APESte']) ."',
																				TVA_INTRA='". addslashes($_POST['TVAINTRASte']) ."',
																				TVA_ID='". addslashes($_POST['TAUXTVASte']) ."',
																				". $AddSQL ."
																				STATU_CLIENT='". addslashes($_POST['StatuSte']) ."',
																				COND_REG_CLIENT_ID='". addslashes($_POST['CondiSte']) ."',
																				MODE_REG_CLIENT_ID='". addslashes($_POST['RegSte']) ."',
																				DISCOUNT='". addslashes($_POST['RemiseSte']) ."',
																				RESP_COM_ID='". addslashes($_POST['RepsComSte']) ."',
																				RESP_TECH_ID='". addslashes($_POST['RespTechSte']) ."',
																				COMPTE_GEN_CLIENT='". addslashes($_POST['CompteGeSte']) ."',
																				COMPTE_AUX_CLIENT='". addslashes($_POST['CompteAuxSte']) ."',
																				STATU_FOUR='". addslashes($_POST['StatuFour']) ."',
																				COND_REG_FOUR_ID='". addslashes($_POST['CondiFourSte']) ."',
																				MODE_REG_FOUR_ID='". addslashes($_POST['RegFourSte']) ."',
																				COMPTE_GEN_FOUR='". addslashes($_POST['CompteGeFourSte']) ."',
																				COMPTE_AUX_FOUR='". addslashes($_POST['CompteAuxFourSte']) ."',
																				CONTROLE_FOUR='". addslashes($_POST['ControlFour']) ."'
																			WHERE Id='". addslashes($_POST['id'])."'");

				$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateCompanyNotification')));
				//select new values for display
				$Name = addslashes($_POST['id']);
			}
			else{
				//if not existe, we create new company or provider

				$titleOnglet1 = $langue->show_text('TableUpdateButton');

				$fichier = basename($_FILES['fichier_LOGOSte']['name']);
				move_uploaded_file($_FILES['fichier_LOGOSte']['tmp_name'], PICTURE_FOLDER.COMPANIES_FOLDER . $fichier);

				//add to sql db
				$req = $bdd->GetInsert("INSERT INTO ". TABLE_ERP_COMPANES ." VALUE ('0',
																				'". addslashes($_POST['CODE']) ."',
																				'". addslashes($_POST['NameSte']) ."',
																				'". addslashes($_POST['WebSiteSte']) ."',
																				'". addslashes($_POST['FbSiteSte']) ."',
																				'". addslashes($_POST['TwitterSte']) ."',
																				'". addslashes($_POST['LkdSte']) ."',
																				'". addslashes($_POST['SIRENSte']) ."',
																				'". addslashes($_POST['APESte']) ."',
																				'". addslashes($_POST['TVAINTRASte']) ."',
																				'". addslashes($_POST['TAUXTVASte']) ."',
																				'". addslashes($fichier) ."',
																				'". addslashes($_POST['StatuSte']) ."',
																				'". addslashes($_POST['CondiSte']) ."',
																				'". addslashes($_POST['RegSte']) ."',
																				'". addslashes($_POST['RemiseSte']) ."',
																				'". addslashes($_POST['RepsComSte']) ."',
																				'". addslashes($_POST['RespTechSte']) ."',
																				'". addslashes($_POST['CompteGeSte']) ."',
																				'". addslashes($_POST['CompteAuxSte']) ."',
																				'". addslashes($_POST['StatuFour']) ."',
																				'". addslashes($_POST['CondiFourSte']) ."',
																				'". addslashes($_POST['RegFourSte']) ."',
																				'". addslashes($_POST['CompteGeFourSte']) ."',
																				'". addslashes($_POST['CompteAuxFourSte']) ."',
																				'". addslashes($_POST['ControlFour']) ."',
																				NOW(),
																				'',
																				'')");
				$CallOutBox->add_notification(array('2', $langue->show_text('AddCompanyNotification')));

				//we can now selectt new value from new add
				$Name = $req;
			}
		}
		else{

			//if is get we select form db value
			if(isset($_GET['id']) AND !empty($_GET['id'])){
				$Name = preg_replace('#-+#', ' ', addslashes($_GET['id']));
			}else{
				$Name = preg_replace('#-+#', ' ', addslashes($_POST['id']));	
			}
			$titleOnglet1 = $langue->show_text('TableUpdateButton');
		}

		$data = $Companies->GETCompanie($Name);
		
		// stock value in variable for dislpay on form
		$SteId = $data->id;
		$SteCODE = $data->CODE;
		$SteLABEL = $data->LABEL;

		$SteWEBSITE = $data->WEBSITE;
		$SteFBSITE = $data->FBSITE;
		$SteTWITTERSITE = $data->TWITTERSITE;
		$SteLKDSITE = $data->LKDSITE;

		$SteSIREN = $data->SIREN;
		$SteAPE = $data->APE;
		$SteTVA_INTRA = $data->TVA_INTRA;
		$SteTVA_ID = $data->TVA_ID;

		$SteLOGO = $data->LOGO;
		$SteSTATU_CLIENT = $data->STATU_CLIENT;
		$SteCOND_REG_CLIENT_ID = $data->COND_REG_CLIENT_ID;
		$SteMODE_REG_CLIENT_ID = $data->MODE_REG_CLIENT_ID;
		$SteDISCOUNT = $data->DISCOUNT;
		$SteRESP_COM_ID = $data->RESP_COM_ID;
		$SteRESP_TECH_ID = $data->RESP_TECH_ID;
		$SteCOMPTE_GEN_CLIENT = $data->COMPTE_GEN_CLIENT;
		$SteCOMPTE_AUX_CLIENT = $data->COMPTE_AUX_CLIENT;

		$SteSTATU_FOUR = $data->STATU_FOUR;
		$SteCOND_REG_FOUR_ID = $data->COND_REG_FOUR_ID;
		$SteMODE_REG_FOUR_ID = $data->MODE_REG_FOUR_ID;
		$SteCOMPTE_GEN_FOUR = $data->COMPTE_GEN_FOUR;
		$SteCOMPTE_AUX_FOUR = $data->COMPTE_AUX_FOUR;
		$SteCONTROLE_FOUR = $data->CONTROLE_FOUR;
		$SteDATE_CREA = $data->DATE_CREA;
		$SteCOMMENT = $data->COMMENT;
		$SteSECTOR_ID = $data->SECTOR_ID;
	}

	// if creat new site we add in db
	if(isset($_POST['AddLABELSite']) AND !empty($_POST['AddLABELSite'])){

		$req = $bdd->GetInsert("INSERT INTO ". TABLE_ERP_ADRESSE ." VALUE ('0',
																		'". addslashes($_POST['AddIdSite']) ."',
																		'". addslashes($_POST['AddORDRESite']) ."',
																		'". addslashes($_POST['AddLABELSite']) ."',
																		'". addslashes($_POST['AddAdressSite']) ."',
																		'". addslashes($_POST['AddZIPSite']) ."',
																		'". addslashes($_POST['AddCITYSite']) ."',
																		'". addslashes($_POST['AddCOUNTRYSite']) ."',
																		'". addslashes($_POST['AddNumberSite']) ."',
																		'". addslashes($_POST['AddEmailSite']) ."',
																		'". addslashes($_POST['AddLIVSite']) ."',
																		'". addslashes($_POST['AddFacSite'])  ."')");

		$CallOutBox->add_notification(array('2', $langue->show_text('AddSiteNotification')));
	}
	elseif(isset($_POST['AddPrenomContact']) AND !empty($_POST['AddPrenomContact'])){
		//add new contact in db
		$req = $bdd->GetInsert("INSERT INTO ". TABLE_ERP_CONTACT ." VALUE ('0',
																		'". addslashes($_POST['AddIdContact']) ."',
																		'". addslashes($_POST['AddORDREContact']) ."',
																		'". addslashes($_POST['AddCiviContact']) ."',
																		'". addslashes($_POST['AddPrenomContact']) ."',
																		'". addslashes($_POST['AddNomContact']) ."',
																		'". addslashes($_POST['AddFonctionContact']) ."',
																		'". addslashes($_POST['AddAdresseContact']) ."',
																		'". addslashes($_POST['AddNumberContact']) ."',
																		'". addslashes($_POST['AddMobileContact']) ."',
																		'". addslashes($_POST['AddMailContact']) ."')");
		$CallOutBox->add_notification(array('2', $langue->show_text('AddContactNotification')));																	
	}

	
	if(isset($_POST['UpdateIdSite']) AND !empty($_POST['UpdateIdSite'])){
	// update data site
		$i = 0;
		foreach ($_POST['UpdateIdSite'] as $id_generation) {

			$bdd->GetUpdate('UPDATE `'. TABLE_ERP_ADRESSE .'` SET  ORDRE = \''. addslashes($_POST['UpdateORDRESite'][$i]) .'\',
																LABEL = \''. addslashes($_POST['UpdateLABELSite'][$i]) .'\',
																ADRESSE = \''. addslashes($_POST['UpdateADRESSESite'][$i]) .'\',
																ZIPCODE = \''. addslashes($_POST['UpdateZIPCODESite'][$i]) .'\',
																CITY = \''. addslashes($_POST['UpdateCITYSite'][$i]) .'\',
																COUNTRY = \''. addslashes($_POST['UpdateCOUNTRYSite'][$i]) .'\',
																NUMBER = \''. addslashes($_POST['UpdateNUMBERSite'][$i]) .'\',
																MAIL = \''. addslashes($_POST['UpdateMAILSite'][$i]) .'\',
																ADRESS_LIV = \''. addslashes($_POST['UpdateLIVSite'][$i]) .'\',
																ADRESS_FAC = \''. addslashes($_POST['UpdateFacSite'][$i]) .'\'
																WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateSiteNotification')));
	}
	elseif(isset($_POST['UpdateIdContact']) AND !empty($_POST['UpdateIdContact'])){
		//update all contact
		$i = 0;
		foreach ($_POST['UpdateIdContact'] as $id_generation) {

			$bdd->GetUpdate('UPDATE `'. TABLE_ERP_CONTACT .'` SET  ORDRE = \''. addslashes($_POST['UpdateORDREContact'][$i]) .'\',
																CIVILITE = \''. addslashes($_POST['UpdateCiviContact'][$i]) .'\',
																PRENOM = \''. addslashes($_POST['UpdatePrenomContact'][$i]) .'\',
																NOM = \''. addslashes($_POST['UpdateNomContact'][$i]) .'\',
																FONCTION = \''. addslashes($_POST['UpdateFonctionContact'][$i]) .'\',
																ADRESSE_ID = \''. addslashes($_POST['UpdateAdresseContact'][$i]) .'\',
																NUMBER = \''. addslashes($_POST['UpdateNumberContact'][$i]) .'\',
																MOBILE = \''. addslashes($_POST['UpdateMobileContact'][$i]) .'\',
																MAIL = \''. addslashes($_POST['UpdateMailContact'][$i]) .'\'
															WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateContactNotification')));
	}
	elseif(isset($_POST['COMMENT']) && !empty($_POST['COMMENT'])){
		// if udpdate comment 
		$bdd->GetUpdatePOST(TABLE_ERP_COMPANES, $_POST, 'WHERE id IN ('. $_GET['id'] . ')');
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateCompanyNotification')));
	}
	elseif(isset($_POST['SECTOR_ID']) && !empty($_POST['SECTOR_ID'])){
		//if update data from sector activity list
		foreach($_POST['SECTOR_ID'] as $POST => $Value){
			$SECTOR_ID .= $Value .',';
		}
		$UpdateSECTOR_ID = array('SECTOR_ID' => substr($SECTOR_ID, 0, -1));
		$bdd->GetUpdatePOST(TABLE_ERP_COMPANES, $UpdateSECTOR_ID, 'WHERE id IN ('. $_GET['id'] . ')');
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateCompanyNotification')));
	}
	elseif(isset($_GET['deleteFile']) AND !empty($_GET['deleteFile'])){
		//// DELETE LIGNE ////
		$Document->DeleteFile($_GET['deleteFile']);
	}

	// we cant change codeId of DB, he can be used on other table
	if(!empty($SteCODE)){$DisplayCode = '<input type="hidden" name="CODE" value="'. $SteCODE .'">' .$SteCODE;}
	else{ $DisplayCode ='<input type="text" name="CODE" required="required">'; }

	//variable of page if load an company
	if(!isset($_GET['id'])  AND  !isset($_POST['id'])){
		$VerrouInput = ' disabled="disabled"  Value="-" ';
		$ImputButton = ' Aucun client chargé';
		$actionForm = 'index.php?page=manage-companies';
	}
	else{
		$ImputButton = $Form->submit($langue->show_text('TableUpdateButton'));
		$actionForm = 'index.php?page=manage-companies&id='. $SteId .'';
	}
?>
	<div class="tab">
		<button class="tablinks" onclick="openDiv(event, 'div1')" id="defaultOpen"><?=$titleOnglet1; ?></button>
<?php
	// not display this menu if we dont have customer load
	if(isset($_POST['CODE']) AND isset($_POST['NameSte']) AND !empty($_POST['CODE']) AND !empty($_POST['NameSte']) OR  isset($_POST['id']) AND !empty($_POST['id']) OR  isset($_GET['id']) AND !empty($_GET['id'])){
?>
		<button class="tablinks" onclick="openDiv(event, 'div2')"><?=$langue->show_text('Titre2'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div3')"><?=$langue->show_text('Titre3'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div4')"><?=$langue->show_text('Titre4'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div5')"><?=$langue->show_text('Titre5'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div6')"><?=$langue->show_text('Titre6'); ?></button>
<?php
	}
?>
	</div>
	<div id="div1" class="tabcontent">
		<div class="row">
			<div class="column-menu">
				<?php echo $UI->GetSearchMenu($Companies->GetCustomerList('',false), 'index.php?page=manage-companies&id', $langue->show_text('FindCompany') ); ?>
			</div>
				<form method="post" name="Section" action="<?=$actionForm; ?>" class="content-form" enctype="multipart/form-data">
					<table class="content-table">
						<thead>
							<tr>
								<th colspan="7"> <br/></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td ><?=$langue->show_text('TableCODE'); ?> : <?=$DisplayCode;?></td>
								<td colspan="3"><?=$langue->show_text('TableNameCompany'); ?> <input type="text" name="NameSte" value="<?=$SteLABEL;?>"></td>
								<td colspan="3">
									<?=$langue->show_text('TableDateCreation') .' '. $SteDATE_CREA ?>
									<input type="hidden" name="id" value="<?=$SteId; ?>" size="10">
								</td>
							</tr>
							<tr>
								<td><?=$langue->show_text('TableWebSite'); ?></td>
								<td><?=$langue->show_text('TableFacebook'); ?></td>
								<td><?=$langue->show_text('TableTwitter'); ?></td>
								<td><?=$langue->show_text('TableLinked'); ?></td>
								<td colspan="3"></td>
							</tr>
							<tr>
								<td><input type="text" name="WebSiteSte" value="<?= $SteWEBSITE;?>" size="20"></td>
								<td><input type="text" name="FbSiteSte" value="<?= $SteFBSITE;?>" size="20"></td>
								<td ><input type="text" name="TwitterSte" value="<?= $SteTWITTERSITE;?>" size="20"></td>
								<td ><input type="text" name="LkdSte" value="<?= $SteLKDSITE;?>" size="20"></td>
								<td colspan="3"></td>
							</tr>
							<tr>
								<td><?=$langue->show_text('TableSIREN'); ?></td>
								<td><?=$langue->show_text('TableAPE'); ?></td>
								<td><?=$langue->show_text('TableTVAINTRA'); ?></td>
								<td><?=$langue->show_text('TableTVAType'); ?></td>
								<td colspan="3"></td>
							</tr>
							<tr>
								<td ><input type="text" name="SIRENSte" value="<?= $SteSIREN;?>" size="10"></td>
								<td ><input type="text" name="APESte" value="<?= $SteAPE;?>" size="10"></td>
								<td ><input type="text" name="TVAINTRASte" value="<?= $SteTVA_INTRA;?>" size="10"></td>
								<td >
									<select name="TAUXTVASte">
										<?= $VAT->GETVATList($SteTVA_ID) ?>
									</select>
								</td>
								<td colspan="3"></td>
							</tr>
							<tr>
								<td colspan="7" >Logo : <input type="file" name="fichier_LOGOSte" /></td>
							</tr>
							<tr>
								<td></td>
								<td colspan="6"><img src="<?=PICTURE_FOLDER.COMPANIES_FOLDER.$SteLOGO; ?>" title="LOGO entreprise" alt="Logo" Class="Image-Logo"/></td>
							</tr>
						</tbody>
						<thead>
							<tr>
								<th colspan="7"><?=$langue->show_text('TableGeneralCustomer'); ?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?=$langue->show_text('TableCustomerStatus'); ?></td>
								<td >
									<select name="StatuSte">
										<option value="0"  <?php  echo selected($SteSTATU_CLIENT, 0) ?>><?=$langue->show_text('SelectInactive'); ?></option>
										<option value="1"  <?php  echo selected($SteSTATU_CLIENT, 1) ?>><?=$langue->show_text('SelectProspect'); ?></option>
										<option value="2"  <?php  echo selected($SteSTATU_CLIENT, 2) ?>><?=$langue->show_text('SelectCustomer'); ?></option>
									</select>
								</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td><?=$langue->show_text('TableCondiList'); ?></td>
								<td><?=$langue->show_text('TableMethodList'); ?></td>
								<td><?=$langue->show_text('TableDiscount'); ?></td>
								<td colspan="2"><?=$langue->show_text('TableSalesManager'); ?></td>
								<td colspan="2"></td>
							</tr>
							<tr>
								<td >
									<select name="CondiSte">
										<?=$PaymentCondition->GETPaymentConditionList($SteCOND_REG_CLIENT_ID)?>
									</select>
								</td>
								<td >
									<select name="RegSte">
										<?=$PaymentMethod->GETPaymentMethodList($SteMODE_REG_CLIENT_ID); ?>
									</select>
								</td>
								<td ><input type="number" name="RemiseSte" value="<?= $SteDISCOUNT;?>" size="10"></td>
								<td colspan="2">
									<select name="RepsComSte">
										<?=$Employees->GETEmployeesList($SteRESP_COM_ID) ?>
									</select>
								</td>
								<td colspan="2">
								</td>
							</tr>
							<tr>
								<td><?=$langue->show_text('TableGeneralAccount'); ?></td>
								<td><?=$langue->show_text('TableSideAccount'); ?></td>
								<td></td>
								<td colspan="2"><?=$langue->show_text('TableTechnicalManager'); ?></td>
								<td colspan="2"></td>
							</tr>
							<tr>
								<td><input type="number" name="CompteGeSte" value="<?= $SteCOMPTE_GEN_CLIENT;?>"></td>
								<td ><input type="number" name="CompteAuxSte" value="<?= $SteCOMPTE_AUX_CLIENT;?>" ></td>
								<td></td>
								<td colspan="2">
									<select name="RespTechSte">
										<?=$Employees->GETEmployeesList($SteRESP_TECH_ID) ?>
									</select>
								</td>
								<td colspan="2"></td>
							</tr>
						</tbody>
						<thead>
							<tr>
								<th colspan="7"><?=$langue->show_text('TableGeneralSupplier'); ?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td ><?=$langue->show_text('TableSupplierStatus'); ?></td>
								<td >
									<select name="StatuFour">
										<option value="0" <?php  echo selected($SteSTATU_FOUR, 0) ?> ><?=$langue->show_text('SelectInactive'); ?></option>
										<option value="1" <?php  echo selected($SteSTATU_FOUR, 1) ?> ><?=$langue->show_text('SelectSupllier'); ?></option>
									</select>
								</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td><?=$langue->show_text('TableCondiList'); ?></td>
								<td><?=$langue->show_text('TableMethodList'); ?></td>
								<td><?=$langue->show_text('TableGeneralAccount'); ?></td>
								<td><?=$langue->show_text('TableSideAccount'); ?></td>
								<td colspan="2"><?=$langue->show_text('TableReceptionControl'); ?></td>
								<td></td>
							</tr>
							<tr>
								<td >
									<select name="CondiFourSte">
										<?=$PaymentCondition->GETPaymentConditionList($SteCOND_REG_FOUR_ID)?>
									</select>
								</td>
								<td >
									<select name="RegFourSte">
										<?=$PaymentMethod->GETPaymentMethodList($SteMODE_REG_FOUR_ID); ?>
									</select>
								</td>
								<td ><input type="number" name="CompteGeFourSte" value="<?= $SteCOMPTE_GEN_FOUR;?>" ></td>
								<td ><input type="number" name="CompteAuxFourSte" value="<?= $SteCOMPTE_AUX_FOUR;?>" ></td>
								<td colspan="2">
									<select name="ControlFour">
										<option value="0" <?php  echo selected($SteCONTROLE_FOUR, 0) ?> ><?=$langue->show_text('SelectNoControl'); ?></option>
										<option value="1" <?php  echo selected($SteCONTROLE_FOUR, 1) ?> ><?=$langue->show_text('SelectControlWithoutBlok'); ?></option>
										<option value="2" <?php  echo selected($SteCONTROLE_FOUR, 2) ?> ><?=$langue->show_text('SelectControlWithBlok'); ?></option>
									</select>
								</td>
								<td></td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td colspan="7" >
									<br/>
									<?= $Form->submit($langue->show_text('TableUpdateButton')) ?> <br/>
									<br/>
								</td>
							</tr>
						</tbody>
					</table>
				</form>
			</div>
		</div>
<?php
	// not display this content if we dont have customer load
	if(isset($_POST['CODE']) AND isset($_POST['NameSte']) AND !empty($_POST['CODE']) AND !empty($_POST['NameSte']) OR  isset($_POST['id']) AND !empty($_POST['id']) OR  isset($_GET['id']) AND !empty($_GET['id'])){
?>
		<div id="div2" class="tabcontent">
			<form method="post" name="Section" action="<?=$actionForm; ?>" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th><?=$langue->show_text('TableOrder'); ?></th>
							<th><?=$langue->show_text('TableLabel'); ?></th>
							<th><?=$langue->show_text('TableAdresse'); ?></th>
							<th><?=$langue->show_text('TableZipCode'); ?></th>
							<th><?=$langue->show_text('TableCity'); ?></th>
							<th><?=$langue->show_text('TableCountry'); ?></th>
							<th><?=$langue->show_text('TablePhoneNumber'); ?></th>
							<th><?=$langue->show_text('TableMailUser'); ?></th>
							<th><?=$langue->show_text('TableAdresseDelevery'); ?></th>
							<th><?=$langue->show_text('TableAdresseDelevery'); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php 	//display all site on form ligne
				foreach ($Address->GETAddressList('', false, $SteId ) as $data): ?>
				<tr>
					<td><?= $i ?> <input type="hidden" name="UpdateIdSite[]" id="UpdateIdSite" value="<?= $data->id ?>"></td>
					<td><input type="number" name="UpdateORDRESite[]" value="<?= $data->ORDRE ?>" id="number"></td>
					<td><input type="text" name="UpdateLABELSite[]" value="<?= $data->LABEL ?>" ></td>
					<td><input type="text" name="UpdateADRESSESite[]" value="<?= $data->ADRESSE ?>" ></td>
					<td><input type="text" name="UpdateZIPCODESite[]" value="<?= $data->ZIPCODE ?>" ></td>
					<td><input type="text" name="UpdateCITYSite[]" value="<?= $data->CITY ?>" ></td>
					<td><input type="text" name="UpdateCOUNTRYSite[]" value="<?= $data->COUNTRY ?>" ></td>
					<td><input type="text" name="UpdateNUMBERSite[]" value="<?= $data->NUMBER ?>" ></td>
					<td><input type="text" name="UpdateMAILSite[]" value="<?= $data->MAIL ?>" ></td>
					<td>
						<select name="UpdateLIVSite[]">
							<option value="0" <?= selected($data->ADRESS_LIV, 0) ?>><?= $langue->show_text('No') ?></option>
							<option value="1" <?= selected($data->ADRESS_LIV, 1) ?>><?= $langue->show_text('Yes') ?></option>
						</select>
					</td>
					<td>
						<select name="UpdateFacSite[]">
							<option value="0" <?= selected($data->ADRESS_FAC, 0) ?>><?= $langue->show_text('No') ?></option>
							<option value="1" <?= selected($data->ADRESS_FAC, 1) ?>><?= $langue->show_text('Yes') ?></option>
						</select>
					</td>
				</tr>
				<?php
				 $i++; endforeach; ?>
						<tr>
							<td><?=$langue->show_text('Addtext'); ?><input type="hidden"  name="AddIdSite" value="<?=$SteId; ?>"></td>
							<td><input type="number"  name="AddORDRESite" size="2" <?=$VerrouInput; ?> id="number"></td>
							<td><input type="text"  name="AddLABELSite" size="2" <?=$VerrouInput; ?>></td>
							<td><input type="text"  name="AddAdressSite" size="7" <?=$VerrouInput; ?>></td>
							<td><input type="text"  name="AddZIPSite" size="7" <?=$VerrouInput; ?>></td>
							<td><input type="text"  name="AddCITYSite" size="7"<?=$VerrouInput; ?>></td>
							<td><input type="text"  name="AddCOUNTRYSite" size="7" <?=$VerrouInput; ?>></td>
							<td><input type="text"  name="AddNumberSite" size="7" <?=$VerrouInput; ?>></td>
							<td><input type="text"  name="AddEmailSite" size="7" <?=$VerrouInput; ?>></td>
							<td>
								<select name="AddLIVSite">
									<option value="0"><?=$langue->show_text('No'); ?></option>
									<option value="1"><?=$langue->show_text('Yes'); ?></option>
								</select>
							</td>
							<td>
								<select name="AddFacSite">
									<option value="0"><?=$langue->show_text('No'); ?></option>
									<option value="1"><?=$langue->show_text('Yes'); ?></option>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="11" >
								<br/>
								<?=$ImputButton; ?><br/>
								<br/>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>
		<div id="div3" class="tabcontent">
			<form method="post" name="Section" action="<?=$actionForm; ?>" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th><?=$langue->show_text('TableOrder'); ?></th>
							<th><?=$langue->show_text('TableCivility'); ?></th>
							<th><?=$langue->show_text('TableSurNameUser'); ?></th>
							<th><?=$langue->show_text('TableNameUser'); ?></th>
							<th><?=$langue->show_text('TableFonction'); ?></th>
							<th><?=$langue->show_text('TableAdresse'); ?></th>
							<th><?=$langue->show_text('TablePhoneNumber'); ?></th>
							<th><?=$langue->show_text('TableMobilNumber'); ?></th>
							<th><?=$langue->show_text('TableMailUser'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php	// display all contact of comppany in form line
						$i = 1;
						foreach ($Contact->GETContactList('', false, $SteId ) as $data): ?>
						<tr>
							<td><?= $i ?> <input type="hidden" name="UpdateIdContact[]" id="UpdateIdContact" value="<?= $data->id ?>"></td>
							<td><input type="number"  name="UpdateORDREContact[]"  value="<?= $data->ORDRE ?>" id="number"></td>
							<td>
								<select name="UpdateCiviContact[]">
									<option value="0" <?= selected($data->CIVILITE, 0) ?>><?=$langue->show_text('SelectMr'); ?></option>
									<option value="1" <?= selected($data->CIVILITE, 1) ?>><?=$langue->show_text('SelectMme'); ?></option>
									<option value="2" <?= selected($data->CIVILITE, 2) ?>><?=$langue->show_text('SelectMlle'); ?></option>
								</select>
							<td><input type="text"  name="UpdatePrenomContact[]"  value="<?= $data->PRENOM ?>"></td>
							<td><input type="text"  name="UpdateNomContact[]"  value="<?= $data->NOM ?>"></td>
							<td><input type="text"  name="UpdateFonctionContact[]"   value="<?= $data->FONCTION ?>"></td>
							<td>
								<select name="UpdateAdresseContact[]">
									<?=  $Address->GETAddressList($data->ADRESSE_ID, true, $SteId ) ?>
								</select>
							</td>
							<td><input type="text"  name="UpdateNumberContact[]" value="<?= $data->NUMBER ?>"></td>
							<td><input type="text"  name="UpdateNumberContact[]" value="<?= $data->MOBILE ?>"></td>
							<td><input type="text"  name="UpdateNumberContact[]" value="<?= $data->MAIL ?>"></td>
						</tr>		
						<?php $i++; endforeach; ?>
						<tr>
							<td><?=$langue->show_text('Addtext'); ?><input type="hidden"  name="AddIdContact" value="<?=$SteId;; ?>"></td>
							<td><input type="number"  name="AddORDREContact" size="2" <?=$VerrouInput; ?> id="number"></td>
							<td>
								<select name="AddCiviContact">
									<option value="0"><?= $langue->show_text('SelectMr'); ?></option>
									<option value="1"><?= $langue->show_text('SelectMme'); ?></option>
									<option value="2"><?= $langue->show_text('SelectMlle'); ?></option>
								</select>
							</td>
							<td><input type="text"  name="AddPrenomContact" size="7" <?=$VerrouInput; ?>></td>
							<td><input type="text"  name="AddNomContact" size="7"<?=$VerrouInput; ?>></td>
							<td><input type="text"  name="AddFonctionContact" size="7" <?=$VerrouInput; ?>></td>
							<td>
								<select name="AddAdresseContact">
								<?=  $Address->GETAddressList('', true, $SteId ) ?>
								</select>
							</td>
							<td><input type="text"  name="AddNumberContact" size="7" <?=$VerrouInput; ?>></td>
							<td><input type="text"  name="AddMobileContact" size="7" <?=$VerrouInput; ?>></td>
							<td><input type="text"  name="AddMailContact" size="7" <?=$VerrouInput; ?>></td>
						</tr>
						<tr>
							<td colspan="10" >
								<br/>
								<?=$ImputButton; ?><br/>
								<br/>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>
		<div id="div4" class="tabcontent">
			<form method="post" name="prestation" action="index.php?page=manage-companies&id=<?= $_GET['id'] ?>" class="content-form" enctype="multipart/form-data">
				<table class="content-table">
					<thead>
						<tr>
						<td ><?= $Data->LABEL?></td>
						</tr>
					</thead>
					<tbody>
						<?= $ActivitySector->GETActivitySectorCheckedList($SteSECTOR_ID) ?>
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
		<div id="div5" class="tabcontent">
			<form method="post" name="prestation" action="index.php?page=manage-companies&id=<?= $_GET['id'] ?>" class="content-form" enctype="multipart/form-data">
				<table class="content-table"  style="width: 50%;">
					<thead>
						<tr>
							<td ><?= $Data->LABEL?></td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><textarea class="Comment" name="COMMENT" rows="40" ><?= $SteCOMMENT ?></textarea></td>
						</tr>
						<tr>
							<td >
								<br/>
								<?= $Form->submit($langue->show_text('TableUpdateButton')) ?> <br/>
								<br/>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>
		<div id="div6" class="tabcontent">
			<?php 
				echo $Document->GETAjaxScript('COMPANY_ID', $_GET['id']); 
				echo $Document->GETDropZone(); 
				$TitreTable = array($langue->show_text('TableArticle'), $langue->show_text('TableLabel'),  $langue->show_text('TableLabel'), $langue->show_text('TableQty'), $langue->show_text('TableUnit'));
				echo $Document->GETDocumentList('COMPANY_ID', $_GET['page'], $_GET['id'], $TitreTable ); 
			?>
		</div>
<?php
	}
