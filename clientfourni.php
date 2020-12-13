<?php session_start();

	header( 'content-type: text/html; charset=utf-8' );

	//phpinfo();

	// include for the constants
	require_once 'include/include_recup_config.php';
	//include for the connection to the SQL database
	require_once 'include/include_connection_sql.php';
	// include for functions
	require_once 'include/include_fonctions.php';
	//session checking  user
	require_once 'include/include_checking_session.php';
	//load info company
	require_once 'include/include_recup_config_company.php';
	// load language class
	require_once 'class/language.class.php';
	$langue = new Langues('lang', 'profil', $UserLanguage);

	//Check if the user is authorized to view the page
	if($_SESSION['page_10'] != '1'){
		stop($langue->show_text('SystemInfoAccessDenied'), 161, 'login.php');
	}

	///////////////////////////////////
	////  CLIENT / FOURNISSEUR   ////
	//////////////////////////////////

	$titleOnglet1 = "Ajouter une société";

	//if post CODE or isset get Id for display company
	if(isset($_POST['CODESte']) AND isset($_POST['NameSte']) AND !empty($_POST['CODESte']) AND !empty($_POST['NameSte']) OR  isset($_GET['id']) AND !empty($_GET['id'])){

		//if isset new CODE company
		if(isset($_POST['CODESte'])){

			// check if exist
			$req = $bdd->query("SELECT COUNT(id) as nb FROM ". TABLE_ERP_CLIENT_FOUR ." WHERE id = '". addslashes($_POST['IDSte'])."'");
			$data = $req->fetch();
			$req->closeCursor();
			$nb = $data['nb'];

			// if existe
			if($nb=1){

				//change title tag
				$titleOnglet1 = "Mettre à jours";

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
				$req = $bdd->exec("UPDATE  ". TABLE_ERP_CLIENT_FOUR ." SET 		CODE='". addslashes($_POST['CODESte']) ."',
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
				//select new values for display
				$req = $bdd->query("SELECT * FROM ". TABLE_ERP_CLIENT_FOUR ." WHERE id = '". addslashes($_POST['IDSte'])."'");
			}
			else{
				//if not existe, we create new company or provider

				$titleOnglet1 = "Mettre à jours";

				$dossier = 'images/ClientLogo/';
				$fichier = basename($_FILES['fichier_LOGOSte']['name']);
				move_uploaded_file($_FILES['fichier_LOGOSte']['tmp_name'], $dossier . $fichier);
				$InsertImage = $dossier.$fichier;

				//add to sql db
				$req = $bdd->exec("INSERT INTO ". TABLE_ERP_CLIENT_FOUR ." VALUE ('0',
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

				$req->closeCursor();

				//we can now selectt new value from new add
				$req = $bdd->query("SELECT * FROM ". TABLE_ERP_CLIENT_FOUR ." ORDER BY id DESC LIMIT 0, 1");
			}
		}
		else{

			//if is get we select form db value
			$Name = preg_replace('#-+#', ' ', addslashes($_GET['id']));
			$titleOnglet1 = "Mettre à jours";

			$req = $bdd->query("SELECT * FROM ". TABLE_ERP_CLIENT_FOUR ." WHERE NAME = '". $Name ."'");
		}

		$DonneesSte = $req->fetch();
		$req->closeCursor();

		// stock value in variable for dislpay on form
		$SteId = $DonneesSte['id'];
		$SteCODE = $DonneesSte['CODE'];
		$SteNAME = $DonneesSte['NAME'];

		$SteWEBSITE = $DonneesSte['WEBSITE'];
		$SteFBSITE = $DonneesSte['FBSITE'];
		$SteTWITTERSITE = $DonneesSte['TWITTERSITE'];
		$SteLKDSITE = $DonneesSte['LKDSITE'];

		$SteSIREN = $DonneesSte['SIREN'];
		$SteAPE = $DonneesSte['APE'];
		$SteTVA_INTRA = $DonneesSte['TVA_INTRA'];
		$SteTVA_ID = $DonneesSte['TVA_ID'];

		$SteLOGO = $DonneesSte['LOGO'];
		$SteSTATU_CLIENT = $DonneesSte['STATU_CLIENT'];
		$SteCOND_REG_CLIENT_ID = $DonneesSte['COND_REG_CLIENT_ID'];
		$SteMODE_REG_CLIENT_ID = $DonneesSte['MODE_REG_CLIENT_ID'];
		$SteREMISE = $DonneesSte['REMISE'];
		$SteRESP_COM_ID = $DonneesSte['RESP_COM_ID'];
		$SteRESP_TECH_ID = $DonneesSte['RESP_TECH_ID'];
		$SteCOMPTE_GEN_CLIENT = $DonneesSte['COMPTE_GEN_CLIENT'];
		$SteCOMPTE_AUX_CLIENT = $DonneesSte['COMPTE_AUX_CLIENT'];

		$SteSTATU_FOUR = $DonneesSte['STATU_FOUR'];
		$SteCOND_REG_FOUR_ID = $DonneesSte['COND_REG_FOUR_ID'];
		$SteMODE_REG_FOUR_ID = $DonneesSte['MODE_REG_FOUR_ID'];
		$SteCOMPTE_GEN_FOUR = $DonneesSte['COMPTE_GEN_FOUR'];
		$SteCOMPTE_AUX_FOUR = $DonneesSte['COMPTE_AUX_FOUR'];
		$SteCONTROLE_FOUR = $DonneesSte['CONTROLE_FOUR'];
		$SteDATE_CREA = $DonneesSte['DATE_CREA'];
		$SteCOMMENT = $DonneesSte['COMMENT'];
	}

	// Create liste for TVA choise
	$req = $bdd -> query('SELECT Id, LABEL, TAUX FROM '. TABLE_ERP_TVA .'');
	while ($DonneesTVA = $req->fetch()){
		$TVAListe .='<option value="'. $DonneesTVA['Id'] .'"  '. selected($SteTVA_ID, $DonneesTVA['Id']) .' $SteTVA_INTRA>'. $DonneesTVA['TAUX'] .'% - '. $DonneesTVA['LABEL'] .'</option>';
	}
	$req->closeCursor();

	// Create liste for payment regulation choise
	$req = $bdd -> query('SELECT Id, LABEL FROM '. TABLE_ERP_CONDI_REG .'');
	while ($DonneesConditionReg = $req->fetch()){
		$CondiListe1 .='<option value="'. $DonneesConditionReg['Id'] .'" '. selected($SteMODE_REG_CLIENT_ID, $DonneesConditionReg['Id']) .'>'. $DonneesConditionReg['LABEL'] .'</option>';
		$CondiListe2 .='<option value="'. $DonneesConditionReg['Id'] .'" '. selected($SteCOND_REG_FOUR_ID, $DonneesConditionReg['Id']) .'>'. $DonneesConditionReg['LABEL'] .'</option>';
	}
	$req->closeCursor();

	// Create liste for payment mode choise
	$req = $bdd -> query('SELECT Id, LABEL FROM '. TABLE_ERP_MODE_REG .'');
	while ($DonneesModeReg = $req->fetch())	{
		$RegListe1 .='<option value="'. $DonneesModeReg['Id'] .'" '. selected($SteCOND_REG_CLIENT_ID, $DonneesModeReg['Id']) .'>'. $DonneesModeReg['LABEL'] .'</option>';
		$RegListe2 .='<option value="'. $DonneesModeReg['Id'] .'" '. selected($SteMODE_REG_FOUR_ID, $DonneesModeReg['Id']) .'>'. $DonneesModeReg['LABEL'] .'</option>';
	}
	$req->closeCursor();

	// Create liste for person in charge choise
	$req = $bdd -> query('SELECT '. TABLE_ERP_EMPLOYEES .'.idUSER,
									'. TABLE_ERP_EMPLOYEES .'.NOM,
									'. TABLE_ERP_EMPLOYEES .'.PRENOM,
									'. TABLE_ERP_RIGHTS .'.RIGHT_NAME
									FROM `'. TABLE_ERP_EMPLOYEES .'`
									LEFT JOIN `'. TABLE_ERP_RIGHTS .'` ON `'. TABLE_ERP_EMPLOYEES .'`.`FONCTION` = `'. TABLE_ERP_RIGHTS .'`.`id`');
	while ($donnees_membre = $req->fetch())	{
		 $EmployeeListe1 .=  '<option value="'. $donnees_membre['idUSER'] .'" '. selected($SteRESP_COM_ID, $donnees_membre['idUSER']) .'>'. $donnees_membre['NOM'] .' '. $donnees_membre['PRENOM'] .' - '. $donnees_membre['RIGHT_NAME'] .'</option>';
		 $EmployeeListe2 .=  '<option value="'. $donnees_membre['idUSER'] .'" '. selected($SteRESP_TECH_ID, $donnees_membre['idUSER']) .'>'. $donnees_membre['NOM'] .' '. $donnees_membre['PRENOM'] .' - '. $donnees_membre['RIGHT_NAME'] .'</option>';
	}
	$req->closeCursor();

	// Create liste datalist find company
	$req = $bdd->query("SELECT * FROM ". TABLE_ERP_CLIENT_FOUR ." ORDER BY NAME");
	while ($donnees_ste = $req->fetch()){
		$ListeSte .= '<option  value="'. $donnees_ste['NAME'] .'" >';
	}
	$req->closeCursor();

	/////////////////////////////
	////  Company SITE section  ////
	/////////////////////////////

	// if creat new site we add in db
	if(isset($_POST['AddLABELSite']) AND !empty($_POST['AddLABELSite'])){

		$req = $bdd->exec("INSERT INTO ". TABLE_ERP_ADRESSE ." VALUE ('0',
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

			$bdd->exec('UPDATE `'. TABLE_ERP_ADRESSE .'` SET  ORDRE = \''. addslashes($UpdateORDRESite[$i]) .'\',
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
		$req->closeCursor();
	}

//display all site on form ligne
	$i = 1;
	$req = $bdd -> query('SELECT '. TABLE_ERP_ADRESSE .'.Id,
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
									ORDER BY ORDRE');

	while ($donnees_Site = $req->fetch())	{
		 $contenu2 = $contenu2 .'
				<tr>
					<td>'. $i .' <input type="hidden" name="UpdateIdSite[]" id="UpdateIdSite" value="'. $donnees_Site['Id'] .'"></td>
					<td><input type="number" name="UpdateORDRESite[]" value="'. $donnees_Site['ORDRE'] .'" size="10" id="number"></td>
					<td><input type="text" name="UpdateLABELSite[]" value="'. $donnees_Site['LABEL'] .'" ></td>
					<td><input type="text" name="UpdateADRESSESite[]" value="'. $donnees_Site['ADRESSE'] .'" ></td>
					<td><input type="text" name="UpdateZIPCODESite[]" value="'. $donnees_Site['ZIPCODE'] .'" ></td>
					<td><input type="text" name="UpdateCITYSite[]" value="'. $donnees_Site['CITY'] .'" ></td>
					<td><input type="text" name="UpdateCOUNTRYSite[]" value="'. $donnees_Site['COUNTRY'] .'" ></td>
					<td><input type="text" name="UpdateNUMBERSite[]" value="'. $donnees_Site['NUMBER'] .'" ></td>
					<td><input type="text" name="UpdateMAILSite[]" value="'. $donnees_Site['MAIL'] .'" ></td>
					<td>
						<select name="UpdateLIVSite[]">
							<option value="0" '. selected($donnees_Site['ADRESS_LIV'], 0) .'>Non</option>
							<option value="1" '. selected($donnees_Site['ADRESS_LIV'], 1) .'>Oui</option>
						</select>
					</td>
					<td>
						<select name="UpdateFacSite[]">
							<option value="0" '. selected($donnees_Site['ADRESS_FAC'], 0) .'>Non</option>
							<option value="1" '. selected($donnees_Site['ADRESS_FAC'], 1) .'>Oui</option>
						</select>
					</td>
				</tr>';

				$AdresseListe .='<option value="'. $donnees_Site['Id'] .'" >'. $donnees_Site['LABEL'] .'</option>';
		$i++;
	}
	$req->closeCursor();

	//////////////////
	////  CONTACT Section  ////
	//////////////////

	//add new contact in db
	if(isset($_POST['AddPrenomContact']) AND !empty($_POST['AddPrenomContact'])){

		$req = $bdd->exec("INSERT INTO ". TABLE_ERP_CONTACT ." VALUE ('0',
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

			$bdd->exec('UPDATE `'. TABLE_ERP_CONTACT .'` SET  ORDRE = \''. addslashes($UpdateORDREContact[$i]) .'\',
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
	}

// display all contact of comppany in form line
	$i = 1;
	$req = $bdd -> query('SELECT '. TABLE_ERP_CONTACT .'.Id,
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
									ORDER BY ORDRE');

	while ($donnees_Contact = $req->fetch()){
		 $contenu3 = $contenu3 .'
				<tr>
					<td>'. $i .' <input type="hidden" name="UpdateIdContact[]" id="UpdateIdContact" value="'. $donnees_Contact['Id'] .'"></td>
					<td><input type="number"  name="UpdateORDREContact[]"  value="'. $donnees_Contact['ORDRE'] .'" id="number"></td>
					<td>
						<select name="UpdateCiviContact[]">
									<option value="0" '. selected($donnees_Contact['CIVILITE'], 0) .'>Mr.</option>
									<option value="1" '. selected($donnees_Contact['CIVILITE'], 1) .'>Mme</option>
									<option value="2" '. selected($donnees_Contact['CIVILITE'], 2) .'>Mlle</option>
								</select>
					<td><input type="text"  name="UpdatePrenomContact[]"  value="'. $donnees_Contact['PRENOM'] .'"></td>
					<td><input type="text"  name="UpdateNomContact[]"  value="'. $donnees_Contact['NOM'] .'"></td>
					<td><input type="text"  name="UpdateFonctionContact[]"   value="'. $donnees_Contact['FONCTION'] .'"></td>
					<td>
						<select name="UpdateAdresseContact[]">
							<option value="'. $donnees_Contact['ADRESSE_ID'] .'" >'. $donnees_Contact['LABEL'] .'</option>
						'.  $AdresseListe .'
						</select>
					</td>
					<td><input type="text"  name="UpdateNumberContact[]" value="'. $donnees_Contact['NUMBER'] .'"></td>
					<td><input type="text"  name="UpdateMobileContact[]"  value="'. $donnees_Contact['MOBILE'] .'"></td>
					<td><input type="text"  name="UpdateMailContact[]"  value="'. $donnees_Contact['MAIL'] .'"></td>
				</select>
			</td>
		</tr>';
		$i++;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
<?php
	//include header
	require_once 'include/include_header.php';
?>
</head>
<body>
<?php
	//include ui
	require_once 'include/include_interface.php';

	// we cant change codeId of DB, he can be used on other table
	if(!empty($SteCODE)){$DisplayCode = '<input type="hidden" name="CODESte" value="'. $SteCODE .'">' .$SteCODE;}
	else{ $DisplayCode ='<input type="text" name="CODESte" required="required">'; }

//variable of page if load an company
	if(!isset($_GET['id']) or empty($_GET['id'])){
		$VerrouInput = ' disabled="disabled"  Value="-" ';
		$ImputButton = ' Aucun client chargé';
		$actionForm = 'clientfourni.php';

	}
	else{
			$ImputButton = '<input type="submit" class="input-moyen" value="Mettre à jour" />';
			$actionForm = 'clientfourni.php?id='. $SteNAME .'';
	}
?>
	<div class="tab">
		<button class="tablinks" onclick="openDiv(event, 'div1')" id="defaultOpen"><?php echo $titleOnglet1; ?></button>
<?php
	// not display this menu if we dont have customer load
	if(isset($_POST['CODESte']) AND isset($_POST['NameSte']) AND !empty($_POST['CODESte']) AND !empty($_POST['NameSte']) OR  isset($_GET['id']) AND !empty($_GET['id'])){
?>
		<button class="tablinks" onclick="openDiv(event, 'div2')">Sites</button>
		<button class="tablinks" onclick="openDiv(event, 'div3')">Contacts</button>
		<button class="tablinks" onclick="openDiv(event, 'div4')">Secteur d'activité et commentaire</button>


<?php
	}
?>
		<div class="DataListDroite">
			<form method="get" name="client" action="<?php echo $actionForm; ?>">
				Client : <input list="client" name="id" id="id" required>
				<datalist id="client">
					<?php echo $ListeSte; ?>
				</datalist>
				<input type="submit" class="input-moyen" value="Go !" />
			</form>
		</div>
	</div>
	<div id="div1" class="tabcontent">
			<form method="post" name="Section" action="<?php echo $actionForm; ?>" class="content-form" enctype="multipart/form-data">
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
							<td>CODE société</td>
							<td>Nom de la Société</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td >
								<input type="hidden" name="IDSte" value="<?php echo $SteId; ?>" size="10">
								<?php echo $DisplayCode;?>
							</td>
							<td>
								<input type="text" name="NameSte" value="<?php echo $SteNAME;?>" size="10">
							</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>Site Web</td>
							<td>FaceBook</td>
							<td>Twitter</td>
							<td>Linked</td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>
								<input type="text" name="WebSiteSte" value="<?php echo  $SteWEBSITE;?>" size="20">
							</td>
							<td>
								<input type="text" name="FbSiteSte" value="<?php echo  $SteFBSITE;?>" size="20">
							</td>
							<td >
								<input type="text" name="TwitterSte" value="<?php echo  $SteTWITTERSITE;?>" size="20">
							</td>
							<td >
								<input type="text" name="LkdSte" value="<?php echo  $SteLKDSITE;?>" size="20">
							</td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>SIREN</td>
							<td>Code APE</td>
							<td>TVA INTRA</td>
							<td>Taux TVA</td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td >
								<input type="text" name="SIRENSte" value="<?php echo  $SteSIREN;?>" size="10">
							</td>
							<td >
								<input type="text" name="APESte" value="<?php echo  $SteAPE;?>" size="10">
							</td>
							<td >
								<input type="text" name="TVAINTRASte" value="<?php echo  $SteTVA_INTRA;?>" size="10">
							</td>
							<td >

								<select name="TAUXTVASte">
									<?php echo $TVAListe ?>
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
							<td colspan="5"><img src="<?php echo $SteLOGO; ?>" title="LOGO entreprise" alt="Logo" Class="Image-Logo"/></td>
							<td></td>
						</tr>
					</tbody>
					<thead>
						<tr>
							<th colspan="7">
								 Général  Client
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td >
								Statu client :
							</td>
							<td >
								<select name="StatuSte">
									<option value="0"  <?php  echo selected($SteSTATU_CLIENT, 0) ?>>Inactif</option>
									<option value="1"  <?php  echo selected($SteSTATU_CLIENT, 1) ?>>Prospect</option>
									<option value="2"  <?php  echo selected($SteSTATU_CLIENT, 2) ?>>Client</option>
								</select>
							</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>Cond. Réglement</td>
							<td>Mode de Réglement</td>
							<td>Remise %</td>
							<td colspan="2">Responsable commercial</td>
							<td colspan="2">Responsable technique</td>
						</tr>
						<tr>
							<td >
								<select name="CondiSte">
									<?php echo $CondiListe1 ?>
								</select>
							</td>
							<td >
								<select name="RegSte">
									<?php echo $RegListe1 ?>
								</select>
							</td>
							<td >
								<input type="number" name="RemiseSte" value="<?php echo  $SteREMISE;?>" size="10">
							</td>
							<td colspan="2">
								<select name="RepsComSte">
									<?php echo $EmployeeListe1 ?>
								</select>
							</td>
							<td colspan="2">
								<select name="RespTechSte">
									<?php echo $EmployeeListe2 ?>
								</select>
							</td>
						</tr>
						<tr>
							<td>Compte général</td>
							<td>Compte auxiliaire</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>
								<input type="number" name="CompteGeSte" value="<?php echo  $SteCOMPTE_GEN_CLIENT;?>">
							</td>
							<td >
								<input type="number" name="CompteAuxSte" value="<?php echo  $SteCOMPTE_AUX_CLIENT;?>" >
							</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					</tbody>
					<thead>
						<tr>
							<th colspan="7">
								 Général  Fournisseur
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td >
								Statu Fournisseur :
							</td>
							<td >
								<select name="StatuFour">
									<option value="0" <?php  echo selected($SteSTATU_FOUR, 0) ?> >Inactif</option>
									<option value="1" <?php  echo selected($SteSTATU_FOUR, 1) ?> >Fournisseur</option>
								</select>
							</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>Cond. Réglement</td>
							<td>Mode de Réglement</td>
							<td>Comppte général</td>
							<td>Compte auxiliaire</td>
							<td colspan="2">Contrôle reception :</td>
							<td></td>
						</tr>
						<tr>
							<td >
								<select name="CondiFourSte">
									<?php echo $CondiListe2 ?>
								</select>
							</td>
							<td >
								<select name="RegFourSte">
									<?php echo $RegListe2 ?>
								</select>
							</td>
							<td >
								<input type="number" name="CompteGeFourSte" value="<?php echo  $SteCOMPTE_GEN_FOUR;?>" size="10">
							</td>
							<td >
								<input type="number" name="CompteAuxFourSte" value="<?php echo  $SteCOMPTE_AUX_FOUR;?>" size="10">
							</td>
							<td colspan="2">
								<select name="ControlFour">
									<option value="0" <?php  echo selected($SteCONTROLE_FOUR, 0) ?> >Pas de contrôle</option>
									<option value="1" <?php  echo selected($SteCONTROLE_FOUR, 1) ?> >Contrôle sans bloquer reception</option>
									<option value="2" <?php  echo selected($SteCONTROLE_FOUR, 2) ?> >Contrôle avec blocage reception</option>
								</select>
							</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="7" >
								<br/>
								<input type="submit" class="input-moyen" value="Mettre à jour" /> <br/>
								<br/>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>
<?php
	if(isset($_POST['CODESte']) AND isset($_POST['NameSte']) AND !empty($_POST['CODESte']) AND !empty($_POST['NameSte']) OR  isset($_GET['id']) AND !empty($_GET['id'])){
?>
		<div id="div2" class="tabcontent">
			<form method="post" name="Section" action="<?php echo $actionForm; ?>" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th>ODRE</th>
							<th>Desciption</th>
							<th>Adresse</th>
							<th>Code postal</th>
							<th>Ville</th>
							<th>Pays</th>
							<th>Téléphone</th>
							<th>E-Mail</th>
							<th>Adresse de livraison</th>
							<th>Adresse de facturation</th>
						</tr>
					</thead>
					<tbody>
<?php 	Echo $contenu2; 	?>
						<tr>
							<td>Ajout<input type="hidden"  name="AddIdSite" value="<?php echo $SteId; ?>"></td>
							<td><input type="number"  name="AddORDRESite" size="2" <?php echo $VerrouInput; ?> id="number"></td>
							<td><input type="text"  name="AddLABELSite" size="2" <?php echo $VerrouInput; ?>></td>
							<td><input type="text"  name="AddAdressSite" size="7" <?php echo $VerrouInput; ?>></td>
							<td><input type="text"  name="AddZIPSite" size="7" <?php echo $VerrouInput; ?>></td>
							<td><input type="text"  name="AddCITYSite" size="7"<?php echo $VerrouInput; ?>></td>
							<td><input type="text"  name="AddCOUNTRYSite" size="7" <?php echo $VerrouInput; ?>></td>
							<td><input type="text"  name="AddNumberSite" size="7" <?php echo $VerrouInput; ?>></td>
							<td><input type="text"  name="AddEmailSite" size="7" <?php echo $VerrouInput; ?>></td>
							<td>
								<select name="AddLIVSite">
									<option value="0">Non</option>
									<option value="1">Oui</option>
								</select>
							</td>
							<td>
								<select name="AddFacSite">
									<option value="0">Non</option>
									<option value="1">Oui</option>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="11" >
								<br/>
<?php echo $ImputButton; ?><br/>
								<br/>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>
		<div id="div3" class="tabcontent">
			<form method="post" name="Section" action="<?php echo $actionForm; ?>" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th>ODRE</th>
							<th>Civilité</th>
							<th>Prénom</th>
							<th>Nom</th>
							<th>Fonction</th>
							<th>Adresse</th>
							<th>Téléphone</th>
							<th>Mobile</th>
							<th>E-Mail</th>
						</tr>
					</thead>
					<tbody>
<?php	Echo $contenu3; ?>
						<tr>
							<td>Ajout<input type="hidden"  name="AddIdContact" value="<?php echo $SteId;; ?>"></td>
							<td><input type="number"  name="AddORDREContact" size="2" <?php echo $VerrouInput; ?> id="number"></td>
							<td>
								<select name="AddCiviContact">
									<option value="0">Mr.</option>
									<option value="1">Mme</option>
									<option value="2">Mlle</option>
								</select>
							</td>
							<td><input type="text"  name="AddPrenomContact" size="7" <?php echo $VerrouInput; ?>></td>
							<td><input type="text"  name="AddNomContact" size="7"<?php echo $VerrouInput; ?>></td>
							<td><input type="text"  name="AddFonctionContact" size="7" <?php echo $VerrouInput; ?>></td>
							<td>
								<select name="AddAdresseContact">
<?php echo $AdresseListe; ?>
								</select>
							</td>
							<td><input type="text"  name="AddNumberContact" size="7" <?php echo $VerrouInput; ?>></td>
							<td><input type="text"  name="AddMobileContact" size="7" <?php echo $VerrouInput; ?>></td>
							<td><input type="text"  name="AddMailContact" size="7" <?php echo $VerrouInput; ?>></td>
						</tr>
						<tr>
							<td colspan="10" >
								<br/>
<?php echo $ImputButton; ?><br/>
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
?>
</body>
</html>
