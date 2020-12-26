<?php 
	//phpinfo();
	use \App\Autoloader;
	use \App\Form;

	//auto load class
	require_once '../app/Autoload.class.php';
	Autoloader::register();
	
	session_start();
	header( 'content-type: text/html; charset=utf-8' );
	//init form class
	$Form = new Form($_POST);

	//Check if the user is authorized to view the page
	if($_SESSION['page_10'] != '1'){
		stop($langue->show_text('SystemInfoAccessDenied'), 161, 'index.php?page=login');
	}

	///////////////////////////////////
	////  CLIENT / FOURNISSEUR   ////
	//////////////////////////////////

	$titleOnglet1 = $langue->show_text('Titre1');

	//if post CODE or isset get Id for display company
	if(isset($_POST['CODESte']) AND isset($_POST['NameSte']) AND !empty($_POST['CODESte']) AND !empty($_POST['NameSte']) OR  isset($_POST['id']) AND !empty($_POST['id']) OR  isset($_GET['id']) AND !empty($_GET['id'])){

		//if isset new CODE company
		if(isset($_POST['CODESte'])){

			// check if exist
			$data=$bdd->GetQuery("SELECT COUNT(id) as nb FROM ". TABLE_ERP_CLIENT_FOUR ." WHERE id = '". addslashes($_POST['IDSte'])."'", true);
			$nb = $data->nb;

			// if existe
			if($nb=1){

				//change title tag
				$titleOnglet1 = $langue->show_text('TableUpdateButton');

				//up picture of company and add sql or not
				$dossier = 'images/ClientLogo/';
				$fichier = basename($_FILES['fichier_LOGOSte']['name']);
				move_uploaded_file($_FILES['fichier_LOGOSte']['tmp_name'], $dossier . $fichier);
				$InsertImage = $dossier.$fichier;
				If(empty($fichier)){
					$AddSQL = '';
				}
				else{
					$AddSQL = 'LOGO = \''. addslashes($InsertImage) .'\',';
				}

				//update database with post
				$bdd->GetUpdate("UPDATE  ". TABLE_ERP_CLIENT_FOUR ." SET 		CODE='". addslashes($_POST['CODESte']) ."',
																				NAME='". addslashes($_POST['NameSte']) ."',
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
																				REMISE='". addslashes($_POST['RemiseSte']) ."',
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
																			WHERE Id='". addslashes($_POST['IDSte'])."'");

				$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateCompanyNotification')));
				//select new values for display
				$query="SELECT * FROM ". TABLE_ERP_CLIENT_FOUR ." WHERE id = '". addslashes($_POST['IDSte'])."'";
			}
			else{
				//if not existe, we create new company or provider

				$titleOnglet1 = $langue->show_text('TableUpdateButton');

				$dossier = 'images/ClientLogo/';
				$fichier = basename($_FILES['fichier_LOGOSte']['name']);
				move_uploaded_file($_FILES['fichier_LOGOSte']['tmp_name'], $dossier . $fichier);
				$InsertImage = $dossier.$fichier;

				//add to sql db
				$req = $bdd->GetInsert("INSERT INTO ". TABLE_ERP_CLIENT_FOUR ." VALUE ('0',
																				'". addslashes($_POST['CODESte']) ."',
																				'". addslashes($_POST['NameSte']) ."',
																				'". addslashes($_POST['WebSiteSte']) ."',
																				'". addslashes($_POST['FbSiteSte']) ."',
																				'". addslashes($_POST['TwitterSte']) ."',
																				'". addslashes($_POST['LkdSte']) ."',
																				'". addslashes($_POST['SIRENSte']) ."',
																				'". addslashes($_POST['APESte']) ."',
																				'". addslashes($_POST['TVAINTRASte']) ."',
																				'". addslashes($_POST['TAUXTVASte']) ."',
																				'". addslashes($InsertImage) ."',
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
																				'')");
				$CallOutBox->add_notification(array('2', $langue->show_text('AddCompanyNotification')));

				//we can now selectt new value from new add
				$query="SELECT * FROM ". TABLE_ERP_CLIENT_FOUR ." ORDER BY id DESC LIMIT 0, 1";
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

			$query="SELECT * FROM ". TABLE_ERP_CLIENT_FOUR ." WHERE id = '". $Name ."'";
		}

		$data = $bdd->GetQuery($query,true);
		// stock value in variable for dislpay on form
		$SteId = $data->id;
		$SteCODE = $data->CODE;
		$SteNAME = $data->NAME;

		$SteWEBSITE = $data->WEBSITE;
		$SteFBSITE = $DonneesSte->FBSITE;
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
		$SteREMISE = $data->REMISE;
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
	}

	// Create liste for TVA choise
	$query='SELECT Id, LABEL, TAUX FROM '. TABLE_ERP_TVA .'';
	foreach ($bdd->GetQuery($query) as $data){
		$TVAListe .='<option value="'. $data->Id .'"  '. selected($SteTVA_ID, $data->Id) .' $SteTVA_INTRA>'. $data->TAUX .'% - '. $data->LABEL .'</option>';
	}

	// Create liste for payment regulation choise
	$query='SELECT Id, LABEL FROM '. TABLE_ERP_CONDI_REG .'';
	foreach ($bdd->GetQuery($query) as $data){
		$CondiListe1 .='<option value="'. $data->Id .'" '. selected($SteMODE_REG_CLIENT_ID, $data->Id) .'>'. $data->LABEL .'</option>';
		$CondiListe2 .='<option value="'. $data->Id .'" '. selected($SteCOND_REG_FOUR_ID, $data->Id) .'>'. $data->LABEL .'</option>';
	}

	// Create liste for payment mode choise
	$query='SELECT Id, LABEL FROM '. TABLE_ERP_MODE_REG .'';
	foreach ($bdd->GetQuery($query) as $data){
		$RegListe1 .='<option value="'. $data->Id .'" '. selected($SteCOND_REG_CLIENT_ID, $data->Id) .'>'. $data->LABEL .'</option>';
		$RegListe2 .='<option value="'. $data->Id .'" '. selected($SteMODE_REG_FOUR_ID, $data->Id) .'>'. $data->LABEL .'</option>';
	}

	// Create liste for person in charge choise
	$query='SELECT '. TABLE_ERP_EMPLOYEES .'.idUSER,
									'. TABLE_ERP_EMPLOYEES .'.NOM,
									'. TABLE_ERP_EMPLOYEES .'.PRENOM,
									'. TABLE_ERP_RIGHTS .'.RIGHT_NAME
									FROM `'. TABLE_ERP_EMPLOYEES .'`
									LEFT JOIN `'. TABLE_ERP_RIGHTS .'` ON `'. TABLE_ERP_EMPLOYEES .'`.`FONCTION` = `'. TABLE_ERP_RIGHTS .'`.`id`';
	foreach ($bdd->GetQuery($query) as $data){
		 $EmployeeListe1 .=  '<option value="'. $data->idUSER .'" '. selected($SteRESP_COM_ID, $data->idUSER) .'>'. $data->NOM .' '. $data->PRENOM .' - '. $data->RIGHT_NAME .'</option>';
		 $EmployeeListe2 .=  '<option value="'. $data->idUSER .'" '. selected($SteRESP_TECH_ID, $data->idUSER) .'>'. $data->NOM .' '. $data->PRENOM .' - '. $data->RIGHT_NAME .'</option>';
	}

	/////////////////////////////
	////  Company SITE section  ////
	/////////////////////////////

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

	// update data site
	if(isset($_POST['UpdateIdSite']) AND !empty($_POST['UpdateIdSite'])){

		$UpdateIdSite = $_POST['UpdateIdSite'];
		$UpdateORDRESite = $_POST['UpdateORDRESite'];
		$UpdateLABELSite = $_POST['UpdateLABELSite'];
		$UpdateADRESSESite = $_POST['UpdateADRESSESite'];
		$UpdateZIPCODESite = $_POST['UpdateZIPCODESite'];
		$UpdateCITYSite = $_POST['UpdateCITYSite'];
		$UpdateCOUNTRYSite = $_POST['UpdateCOUNTRYSite'];
		$UpdateNUMBERSite = $_POST['UpdateNUMBERSite'];
		$UpdateMAILSite = $_POST['UpdateMAILSite'];
		$UpdateLIVSite = $_POST['UpdateLIVSite'];
		$UpdateFacSite = $_POST['UpdateFacSite'];

		$i = 0;
		foreach ($UpdateIdSite as $id_generation) {

			$bdd->GetUpdate('UPDATE `'. TABLE_ERP_ADRESSE .'` SET  ORDRE = \''. addslashes($UpdateORDRESite[$i]) .'\',
																LABEL = \''. addslashes($UpdateLABELSite[$i]) .'\',
																ADRESSE = \''. addslashes($UpdateADRESSESite[$i]) .'\',
																ZIPCODE = \''. addslashes($UpdateZIPCODESite[$i]) .'\',
																CITY = \''. addslashes($UpdateCITYSite[$i]) .'\',
																COUNTRY = \''. addslashes($UpdateCOUNTRYSite[$i]) .'\',
																NUMBER = \''. addslashes($UpdateNUMBERSite[$i]) .'\',
																MAIL = \''. addslashes($UpdateMAILSite[$i]) .'\',
																ADRESS_LIV = \''. addslashes($UpdateLIVSite[$i]) .'\',
																ADRESS_FAC = \''. addslashes($UpdateFacSite[$i]) .'\'
																WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateSiteNotification')));
	}

	//////////////////
	////  CONTACT Section  ////
	//////////////////

	//add new contact in db
	if(isset($_POST['AddPrenomContact']) AND !empty($_POST['AddPrenomContact'])){

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

	//update all contact
	if(isset($_POST['UpdateIdContact']) AND !empty($_POST['UpdateIdContact'])){

		$UpdateIdContact = $_POST['UpdateIdContact'];
		$UpdateORDREContact = $_POST['UpdateORDREContact'];
		$UpdateCiviContact = $_POST['UpdateCiviContact'];
		$UpdatePrenomContact = $_POST['UpdatePrenomContact'];
		$UpdateNomContact = $_POST['UpdateNomContact'];
		$UpdateFonctionContact = $_POST['UpdateFonctionContact'];
		$UpdateAdresseContact = $_POST['UpdateAdresseContact'];
		$UpdateNumberContact = $_POST['UpdateNumberContact'];
		$UpdateMobileContact = $_POST['UpdateMobileContact'];
		$UpdateMailContact = $_POST['UpdateMailContact'];

		$i = 0;
		foreach ($UpdateIdContact as $id_generation) {

			$bdd->GetUpdate('UPDATE `'. TABLE_ERP_CONTACT .'` SET  ORDRE = \''. addslashes($UpdateORDREContact[$i]) .'\',
																CIVILITE = \''. addslashes($UpdateCiviContact[$i]) .'\',
																PRENOM = \''. addslashes($UpdatePrenomContact[$i]) .'\',
																NOM = \''. addslashes($UpdateNomContact[$i]) .'\',
																FONCTION = \''. addslashes($UpdateFonctionContact[$i]) .'\',
																ADRESSE_ID = \''. addslashes($UpdateAdresseContact[$i]) .'\',
																NUMBER = \''. addslashes($UpdateNumberContact[$i]) .'\',
																MOBILE = \''. addslashes($UpdateMobileContact[$i]) .'\',
																MAIL = \''. addslashes($UpdateMailContact[$i]) .'\'
															WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateContactNotification')));
	}

	// we cant change codeId of DB, he can be used on other table
	if(!empty($SteCODE)){$DisplayCode = '<input type="hidden" name="CODESte" value="'. $SteCODE .'">' .$SteCODE;}
	else{ $DisplayCode ='<input type="text" name="CODESte" required="required">'; }

	//variable of page if load an company
	if(!isset($_GET['id'])  AND  !isset($_POST['id'])){
		$VerrouInput = ' disabled="disabled"  Value="-" ';
		$ImputButton = ' Aucun client chargé';
		$actionForm = 'admin.php?page=manage-companies';
	}
	else{
		$ImputButton = $Form->submit($langue->show_text('TableUpdateButton'));
		$actionForm = 'admin.php?page=manage-companies&id='. $SteNAME .'';
	}
?>
	<div class="tab">
		<button class="tablinks" onclick="openDiv(event, 'div1')" id="defaultOpen"><?=$titleOnglet1; ?></button>
<?php
	// not display this menu if we dont have customer load
	if(isset($_POST['CODESte']) AND isset($_POST['NameSte']) AND !empty($_POST['CODESte']) AND !empty($_POST['NameSte']) OR  isset($_POST['id']) AND !empty($_POST['id']) OR  isset($_GET['id']) AND !empty($_GET['id'])){
?>
		<button class="tablinks" onclick="openDiv(event, 'div2')"><?=$langue->show_text('Titre2'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div3')"><?=$langue->show_text('Titre3'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div4')"><?=$langue->show_text('Titre4'); ?></button>
<?php
	}
?>
	</div>
	<div id="div1" class="tabcontent">
			<div class="column">
				<input type="text" id="myInput" onkeyup="myFunction()" placeholder="<?=$langue->show_text('FindArticle'); ?>">
				<ul id="myUL">
					<?php
					//generate list for datalist find input
					$query="SELECT id, CODE, NAME FROM ". TABLE_ERP_CLIENT_FOUR ." ORDER BY NAME";
					foreach ($bdd->GetQuery($query) as $data): ?>
					<li><a href="admin.php?page=manage-companies&id=<?= $data->id ?>"><?= $data->CODE ?> - <?= $data->NAME ?></a></li>
					<?php $i++; endforeach; ?>
				</ul>
			</div>
			<form method="post" name="Section" action="<?=$actionForm; ?>" class="content-form" enctype="multipart/form-data">
				<table class="content-table">
					<thead>
						<tr>
							<th colspan="7">
								 <br/>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><?=$langue->show_text('TableCODE'); ?></td>
							<td><?=$langue->show_text('TableNameCompany'); ?></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td >
								<input type="hidden" name="IDSte" value="<?=$SteId; ?>" size="10">
								<?=$DisplayCode;?>
							</td>
							<td>
								<input type="text" name="NameSte" value="<?=$SteNAME;?>" size="10">
							</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td><?=$langue->show_text('TableWebSite'); ?></td>
							<td><?=$langue->show_text('TableFacebook'); ?></td>
							<td><?=$langue->show_text('TableTwitter'); ?></td>
							<td><?=$langue->show_text('TableLinked'); ?></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>
								<input type="text" name="WebSiteSte" value="<?= $SteWEBSITE;?>" size="20">
							</td>
							<td>
								<input type="text" name="FbSiteSte" value="<?= $SteFBSITE;?>" size="20">
							</td>
							<td >
								<input type="text" name="TwitterSte" value="<?= $SteTWITTERSITE;?>" size="20">
							</td>
							<td >
								<input type="text" name="LkdSte" value="<?= $SteLKDSITE;?>" size="20">
							</td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td><?=$langue->show_text('TableSIREN'); ?></td>
							<td><?=$langue->show_text('TableAPE'); ?></td>
							<td><?=$langue->show_text('TableTVAINTRA'); ?></td>
							<td><?=$langue->show_text('TableTVAType'); ?></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td >
								<input type="text" name="SIRENSte" value="<?= $SteSIREN;?>" size="10">
							</td>
							<td >
								<input type="text" name="APESte" value="<?= $SteAPE;?>" size="10">
							</td>
							<td >
								<input type="text" name="TVAINTRASte" value="<?= $SteTVA_INTRA;?>" size="10">
							</td>
							<td >

								<select name="TAUXTVASte">
									<?=$TVAListe ?>
								</select>
							</td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td colspan="7">Logo</td>
						</tr>
						<tr>
							<td colspan="7" ><input type="file" name="fichier_LOGOSte" /></td>
						</tr>
						<tr>
							<td></td>
							<td colspan="5"><img src="<?=$SteLOGO; ?>" title="LOGO entreprise" alt="Logo" Class="Image-Logo"/></td>
							<td></td>
						</tr>
					</tbody>
					<thead>
						<tr>
							<th colspan="7">
								<?=$langue->show_text('TableGeneralCustomer'); ?>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<?=$langue->show_text('TableCustomerStatus'); ?>
							</td>
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
									<?=$CondiListe1 ?>
								</select>
							</td>
							<td >
								<select name="RegSte">
									<?=$RegListe1 ?>
								</select>
							</td>
							<td >
								<input type="number" name="RemiseSte" value="<?= $SteREMISE;?>" size="10">
							</td>
							<td colspan="2">
								<select name="RepsComSte">
									<?=$EmployeeListe1 ?>
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
							<td>
								<input type="number" name="CompteGeSte" value="<?= $SteCOMPTE_GEN_CLIENT;?>">
							</td>
							<td >
								<input type="number" name="CompteAuxSte" value="<?= $SteCOMPTE_AUX_CLIENT;?>" >
							</td>
							<td></td>
							<td colspan="2">
							<select name="RespTechSte">
									<?=$EmployeeListe2 ?>
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
									<?=$CondiListe2 ?>
								</select>
							</td>
							<td >
								<select name="RegFourSte">
									<?=$RegListe2 ?>
								</select>
							</td>
							<td >
								<input type="number" name="CompteGeFourSte" value="<?= $SteCOMPTE_GEN_FOUR;?>" >
							</td>
							<td >
								<input type="number" name="CompteAuxFourSte" value="<?= $SteCOMPTE_AUX_FOUR;?>" >
							</td>
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
<?php
	// not display this content if we dont have customer load
	if(isset($_POST['CODESte']) AND isset($_POST['NameSte']) AND !empty($_POST['CODESte']) AND !empty($_POST['NameSte']) OR  isset($_POST['id']) AND !empty($_POST['id']) OR  isset($_GET['id']) AND !empty($_GET['id'])){
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
						$query='SELECT '. TABLE_ERP_ADRESSE .'.Id,
									'. TABLE_ERP_ADRESSE .'.ID_COMPANY,
									'. TABLE_ERP_ADRESSE .'.ORDRE,
									'. TABLE_ERP_ADRESSE .'.LABEL,
									'. TABLE_ERP_ADRESSE .'.ADRESSE,
									'. TABLE_ERP_ADRESSE .'.ZIPCODE,
									'. TABLE_ERP_ADRESSE .'.CITY,
									'. TABLE_ERP_ADRESSE .'.COUNTRY,
									'. TABLE_ERP_ADRESSE .'.NUMBER,
									'. TABLE_ERP_ADRESSE .'.MAIL,
									'. TABLE_ERP_ADRESSE .'.ADRESS_LIV,
									'. TABLE_ERP_ADRESSE .'.ADRESS_FAC
									FROM `'. TABLE_ERP_ADRESSE .'`
									WHERE ID_COMPANY=\''. $SteId .'\'
									ORDER BY ORDRE';
				foreach ($bdd->GetQuery($query) as $data): ?>
				<tr>
					<td><?= $i ?> <input type="hidden" name="UpdateIdSite[]" id="UpdateIdSite" value="<?= $data->Id ?>"></td>
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
				</tr>';
				<?php
				$AdresseListe .='<option value="'. $data->Id .'" >'. $data->LABEL .'</option>';
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
						$query='SELECT '. TABLE_ERP_CONTACT .'.Id,
									'. TABLE_ERP_CONTACT .'.ID_COMPANY,
									'. TABLE_ERP_CONTACT .'.ORDRE,
									'. TABLE_ERP_CONTACT .'.CIVILITE,
									'. TABLE_ERP_CONTACT .'.PRENOM,
									'. TABLE_ERP_CONTACT .'.NOM,
									'. TABLE_ERP_CONTACT .'.FONCTION,
									'. TABLE_ERP_CONTACT .'.ADRESSE_ID,
									'. TABLE_ERP_CONTACT .'.NUMBER,
									'. TABLE_ERP_CONTACT .'.MOBILE,
									'. TABLE_ERP_CONTACT .'.MAIL,
									'. TABLE_ERP_ADRESSE .'.LABEL
									FROM `'. TABLE_ERP_CONTACT .'`
										LEFT JOIN `'. TABLE_ERP_ADRESSE .'` ON `'. TABLE_ERP_CONTACT .'`.`ADRESSE_ID` = `'. TABLE_ERP_ADRESSE .'`.`id`
									WHERE '. TABLE_ERP_CONTACT .'.ID_COMPANY=\''. $SteId .'\'
									ORDER BY ORDRE';

						foreach ($bdd->GetQuery($query) as $data): ?>
						<tr>
							<td><?= $i ?> <input type="hidden" name="UpdateIdContact[]" id="UpdateIdContact" value="<?= $data->Id ?>"></td>
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
									<option value="<?= $data->ADRESSE_ID ?>" ><?= $data->LABEL ?></option>
									<?=  $AdresseListe ?>
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
									<?=$AdresseListe; ?>
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
		</div>
<?php
	}