<?php session_start();

	header( 'content-type: text/html; charset=utf-8' );

	//phpinfo();

	// include for the constants
	require_once 'include/include_recup_config.php';
	//include for the connection to the SQL database
	require_once 'class/sql.class.php';
	$bdd = SQL::getInstance();
	// include for functions
	require_once 'include/include_fonctions.php';
	//session checking  user
	require_once 'include/include_checking_session.php';
	//load info company
	require_once 'include/include_recup_config_company.php';
	// load language class
	require_once 'class/language.class.php';
	$langue = new Langues('lang', 'manage-accounting', $UserLanguage);
	//load callOut notification box class
	require_once 'class/notification.class.php';
	$CallOutBox = new CallOutBox();

	//Check if the user is authorized to view the page
	if($_SESSION['page_10'] != '1'){
		stop($langue->show_text('SystemInfoAccessDenied'), 161, 'login.php');
	}

	////////////////////////
	//// CONDITION REG ////
	///////////////////////

	//Insert in db new payement condition
	if(isset($_POST['AddCODECondiReg']) AND !empty($_POST['AddCODECondiReg'])){

		$req = $bdd->exec("INSERT INTO ". TABLE_ERP_CONDI_REG ." VALUE ('0',
																		'". addslashes($_POST['AddCODECondiReg']) ."',
																		'". addslashes($_POST['AddLABELCondiReg']) ."',
																		'". addslashes($_POST['AddNbrMoisCondiReg']) ."',
																		'". addslashes($_POST['AddNbrJoursCondiReg']) ."',
																		'". addslashes($_POST['AddFinDeMoiCondiReg']) ."')");
		$CallOutBox->add_notification(array('2', $langue->show_text('AddCondiNotification')));	
	}

	//if update list condition payement
	if(isset($_POST['id_CondiReg']) AND !empty($_POST['id_CondiReg'])){

		$UpdateIdCondiReg = $_POST['id_CondiReg'];
		$UpdateCODECondiReg = $_POST['UpdateCODECondiReg'];
		$UpdateLABELCondiReg = $_POST['UpdateLABELCondiReg'];
		$UpdateNBRMOISCondiReg = $_POST['UpdateNBRMOISCondiReg'];
		$UpdateNBRJOURSCondiReg = $_POST['UpdateNBRJOURSCondiReg'];
		$FINMOISCondiReg = $_POST['FINMOISCondiReg'];

		$i = 0;
		foreach ($UpdateIdCondiReg as $id_generation) {

			$bdd->exec('UPDATE `'. TABLE_ERP_CONDI_REG .'` SET  CODE = \''. addslashes($UpdateCODECondiReg[$i]) .'\',
																LABEL = \''. addslashes($UpdateLABELCondiReg[$i]) .'\',
																NBR_MOIS = \''. addslashes($UpdateNBRMOISCondiReg[$i]) .'\',
																NBR_JOURS = \''. addslashes($UpdateNBRJOURSCondiReg[$i]) .'\',
																FIN_MOIS = \''. addslashes($FINMOISCondiReg[$i]) .'\'
																WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateCondiNotification')));
	}

	//generate condition payement liste
	$i = 1;
	$req = $bdd -> query('SELECT '. TABLE_ERP_CONDI_REG .'.Id,
									'. TABLE_ERP_CONDI_REG .'.CODE,
									'. TABLE_ERP_CONDI_REG .'.LABEL,
									'. TABLE_ERP_CONDI_REG .'.NBR_MOIS,
									'. TABLE_ERP_CONDI_REG .'.NBR_JOURS,
									'. TABLE_ERP_CONDI_REG .'.FIN_MOIS
									FROM `'. TABLE_ERP_CONDI_REG .'`
									ORDER BY Id');

	while ($donnees_id_CondiReg = $req->fetch()){
		 $contenu1 = $contenu1 .'
				<tr>
					<td>'. $i .' <input type="hidden" name="id_CondiReg[]" id="id_CondiReg" value="'. $donnees_id_CondiReg['Id'] .'"></td>
					<td><input type="text" name="UpdateCODECondiReg[]" value="'. $donnees_id_CondiReg['CODE'] .'" required="required"></td>
					<td><input type="text" name="UpdateLABELCondiReg[]" value="'. $donnees_id_CondiReg['LABEL'] .'" required="required"></td>
					<td><input type="number" name="UpdateNBRMOISCondiReg[]" value="'. $donnees_id_CondiReg['NBR_MOIS'] .'" required="required"></td>
					<td><input type="number" name="UpdateNBRJOURSCondiReg[]" value="'. $donnees_id_CondiReg['NBR_JOURS'] .'" required="required"></td>
					<td>
						<select name="FINMOISCondiReg[]">
							<option value="1" '. selected($donnees_id_CondiReg['FIN_MOIS'], "1") .'>'. $langue->show_text('Yes') .'</option>
							<option value="0" '. selected($donnees_id_CondiReg['FIN_MOIS'], "0") .'>'. $langue->show_text('No') .'</option>
						</select>
					</td>
				</tr>	';
		$i++;
	}

	/////////////////////////
	////  MODE REGLEMENT ////
	/////////////////////////

	//if add new payment mode
	if(isset($_POST['AddCODEModeRef']) AND !empty($_POST['AddCODEModeRef'])){

		$req = $bdd->exec("INSERT INTO ". TABLE_ERP_MODE_REG ." VALUE ('0',
																		'". addslashes($_POST['AddCODEModeRef']) ."',
																		'". addslashes($_POST['AddLABELModeRef']) ."',
																		'". addslashes($_POST['AddCODEComptaModeRef']) ."')");
		$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddModeNotification')));
	}

	//Update mode payement list
	if(isset($_POST['id_ModeReg']) AND !empty($_POST['id_ModeReg'])){

		$UpdateIdModeReg = $_POST['id_ModeReg'];
		$UpdateCODEModeReg = $_POST['UpdateCODEModeReg'];
		$UpdateLABELModeReg = $_POST['UpdateLABELModeReg'];
		$UpdateCODECOMPTABLEModeReg = $_POST['UpdateCODECOMPTABLEModeReg'];

		$i = 0;
		foreach ($UpdateIdModeReg as $id_generation) {

			$bdd->exec('UPDATE `'. TABLE_ERP_MODE_REG .'` SET  CODE = \''. addslashes($UpdateCODEModeReg[$i]) .'\',
																LABEL = \''. addslashes($UpdateLABELModeReg[$i]) .'\',
																CODE_COMPTABLE = \''. addslashes($UpdateCODECOMPTABLEModeReg[$i]) .'\'
																WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateModeNotification')));
	}

	//generate liste of payement mode
	$i = 1;
	$req = $bdd -> query('SELECT '. TABLE_ERP_MODE_REG .'.Id,
									'. TABLE_ERP_MODE_REG .'.CODE,
									'. TABLE_ERP_MODE_REG .'.LABEL,
									'. TABLE_ERP_MODE_REG .'.CODE_COMPTABLE
									FROM `'. TABLE_ERP_MODE_REG .'`
									ORDER BY Id');

	while ($donnees_ModeReg = $req->fetch()){
		 $contenu2 = $contenu2 .'
				<tr>
					<td>'. $i .' <input type="hidden" name="id_ModeReg[]" id="id_ModeReg" value="'. $donnees_ModeReg['Id'] .'"></td>
					<td><input type="text" name="UpdateCODEModeReg[]" value="'. $donnees_ModeReg['CODE'] .'" required="required"></td>
					<td><input type="text" name="UpdateLABELModeReg[]" value="'. $donnees_ModeReg['LABEL'] .'" required="required"></td>
					<td><input type="text" name="UpdateCODECOMPTABLEModeReg[]" value="'. $donnees_ModeReg['CODE_COMPTABLE'] .'" required="required"></td>
				</tr>';
		$i++;
	}

	//////////////
	////  TVA ////
	//////////////

	//if add new TVA type
	if(isset($_POST['AddCODETVA']) AND !empty($_POST['AddCODETVA'])){

		$req = $bdd->exec("INSERT INTO ". TABLE_ERP_TVA ." VALUE ('0',
																		'". addslashes($_POST['AddCODETVA']) ."',
																		'". addslashes($_POST['AddLABELTVA']) ."',
																		'". addslashes($_POST['AddTAUXTVA']) ."')");
		$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddTVANotification')));
	}

	//update TVA List
	if(isset($_POST['id_TVA']) AND !empty($_POST['id_TVA'])){

		$UpdateIdTVA = $_POST['id_TVA'];
		$UpdateCODETVA = $_POST['UpdateCODETVA'];
		$UpdateLABELTVA = $_POST['UpdateLABELTVA'];
		$UpdateTAUXTVA = $_POST['UpdateTAUXTVA'];

		$i = 0;
		foreach ($UpdateIdTVA as $id_generation) {
			$bdd->exec('UPDATE `'. TABLE_ERP_TVA .'` SET  CODE = \''. addslashes($UpdateCODETVA[$i]) .'\',
																LABEL = \''. addslashes($UpdateLABELTVA[$i]) .'\',
																TAUX = \''. addslashes($UpdateTAUXTVA[$i]) .'\'
																WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateTVANotification')));
	}

	//Generate TVA list
	$i = 1;
	$req = $bdd -> query('SELECT '. TABLE_ERP_TVA .'.Id,
									'. TABLE_ERP_TVA .'.CODE,
									'. TABLE_ERP_TVA .'.LABEL,
									'. TABLE_ERP_TVA .'.TAUX
									FROM `'. TABLE_ERP_TVA .'`
									ORDER BY Id');

	while ($donnees_TVA = $req->fetch()){
		 $contenu3 = $contenu3 .'
				<tr>
					<td>'. $i .' <input type="hidden" name="id_TVA[]" id="id_TVA" value="'. $donnees_TVA['Id'] .'"></td>
					<td><input type="text" name="UpdateCODETVA[]" value="'. $donnees_TVA['CODE'] .'" required="required"></td>
					<td><input type="text" name="UpdateLABELTVA[]" value="'. $donnees_TVA['LABEL'] .'" required="required"></td>
					<td><input type="text" name="UpdateTAUXTVA[]" value="'. $donnees_TVA['TAUX'] .'" required="required"></td>
				</tr>';
		$i++;

		$TVAListe .='<option value="'. $donnees_TVA['Id'] .'">'. $donnees_TVA['TAUX'] .'% - '. $donnees_TVA['LABEL'] .'</option>';
	}


	///////////////////////////////
	////  ACCOUNTING ENTRY////
	///////////////////////////////

	//if Add new Accouting entry
	if(isset($_POST['AddCODEIMPUT']) AND !empty($_POST['AddCODEIMPUT'])){

		$req = $bdd->exec("INSERT INTO ". TABLE_ERP_IMPUT_COMPTA ." VALUE ('0',
																		'". addslashes($_POST['AddCODEIMPUT']) ."',
																		'". addslashes($_POST['AddLABELIMPUT']) ."',
																		'". addslashes($_POST['AddTVAIMPUT']) ."',
																		'". addslashes($_POST['AddCOMPTETVAIMPUT']) ."',
																		'". addslashes($_POST['AddCODECOMPTAIMPUT']) ."',
																		'". addslashes($_POST['AddTYPEIMPUT']) ."')");
		$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddAccountingNotification')));
	}

	//update list of entry accouting
	if(isset($_POST['id_IMPUT']) AND !empty($_POST['id_IMPUT'])){

		$UpdateIdTVA = $_POST['id_IMPUT'];
		$UpdateCODEIMPUT = $_POST['UpdateCODEIMPUT'];
		$UpdateLABELIMPUT = $_POST['UpdateLABELIMPUT'];
		$UpdateTVAIMPUT = $_POST['UpdateTVAIMPUT'];
		$UpdateCOMPTETVAIMPUT = $_POST['UpdateCOMPTETVAIMPUT'];
		$UpdateCODECOMPTAIMPUT = $_POST['UpdateCODECOMPTAIMPUT'];
		$UpdateTYPEIMPUT = $_POST['UpdateTYPEIMPUT'];

		$i = 0;
		foreach ($UpdateIdTVA as $id_generation) {

			$bdd->exec('UPDATE `'. TABLE_ERP_IMPUT_COMPTA .'` SET  CODE = \''. addslashes($UpdateCODEIMPUT[$i]) .'\',
																LABEL = \''. addslashes($UpdateLABELIMPUT[$i]) .'\',
																TVA = \''. addslashes($UpdateTVAIMPUT[$i]) .'\',
																COMPTE_TVA = \''. addslashes($UpdateCOMPTETVAIMPUT[$i]) .'\',
																CODE_COMPTA = \''. addslashes($UpdateCODECOMPTAIMPUT[$i]) .'\',
																TYPE_IMPUTATION = \''. addslashes($UpdateTYPEIMPUT[$i]) .'\'
																WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateAccountingNotification')));
	}

	//gererate list of entry accouting
	$i = 1;
	$req = $bdd -> query('SELECT '. TABLE_ERP_IMPUT_COMPTA .'.Id,
									'. TABLE_ERP_IMPUT_COMPTA .'.CODE,
									'. TABLE_ERP_IMPUT_COMPTA .'.LABEL,
									'. TABLE_ERP_IMPUT_COMPTA .'.TVA,
									'. TABLE_ERP_IMPUT_COMPTA .'.COMPTE_TVA,
									'. TABLE_ERP_IMPUT_COMPTA .'.CODE_COMPTA,
									'. TABLE_ERP_IMPUT_COMPTA .'.TYPE_IMPUTATION,
									'. TABLE_ERP_TVA .'.TAUX,
									'. TABLE_ERP_TVA .'.LABEL AS LABEL_TVA
									FROM `'. TABLE_ERP_IMPUT_COMPTA .'`
										LEFT JOIN `'. TABLE_ERP_TVA .'` ON `'. TABLE_ERP_IMPUT_COMPTA .'`.`TVA` = `'. TABLE_ERP_TVA .'`.`id`
									ORDER BY Id');

	while ($donnees_IMPUT = $req->fetch()){
		 $contenu4 = $contenu4 .'
				<tr>
					<td>'. $i .' <input type="hidden" name="id_IMPUT[]" id="id_IMPUT" value="'. $donnees_IMPUT['Id'] .'"></td>
					<td><input type="text" name="UpdateCODEIMPUT[]" value="'. $donnees_IMPUT['CODE'] .'" required="required"></td>
					<td><input type="text" name="UpdateLABELIMPUT[]" value="'. $donnees_IMPUT['LABEL'] .'" required="required"></td>
					<td>
						<select name="UpdateTVAIMPUT[]">
							<option value="'. $donnees_IMPUT['TVA'] .'">'. $donnees_IMPUT['TAUX'] .'% - '. $donnees_IMPUT['LABEL_TVA'] .'</option>
							'. $TVAListe .'
						</select>
					</td>
					<td><input type="text" name="UpdateCOMPTETVAIMPUT[]" value="'. $donnees_IMPUT['COMPTE_TVA'] .'" required="required"></td>
					<td><input type="text" name="UpdateCODECOMPTAIMPUT[]" value="'. $donnees_IMPUT['CODE_COMPTA'] .'" required="required"></td>
					<td>
						<select name="AddTYPEIMPUT[]">
							<option value="1" '. selected($donnees_IMPUT['TYPE_IMPUTATION'], 1) .'>'. $langue->show_text('TableSelect1') .'</option>
							<option value="2" '. selected($donnees_IMPUT['TYPE_IMPUTATION'], 2) .'>'. $langue->show_text('TableSelect2') .'</option>
							<option value="3" '. selected($donnees_IMPUT['TYPE_IMPUTATION'], 3) .'>'. $langue->show_text('TableSelect3') .'</option>
							<option value="4" '. selected($donnees_IMPUT['TYPE_IMPUTATION'], 4) .'>'. $langue->show_text('TableSelect4') .'</option>
							<option value="5" '. selected($donnees_IMPUT['TYPE_IMPUTATION'], 5) .'>'. $langue->show_text('TableSelect5') .'</option>
							<option value="6" '. selected($donnees_IMPUT['TYPE_IMPUTATION'], 6) .'>'. $langue->show_text('TableSelect6') .'</option>
						</select>
					</td>
				</tr>';
		$i++;
	}

	////////////////////////
	////TYPICAL TIMELINE PAYEMENT ////
	///////////////////////

	//if add new TimeLine payement
	if(isset($_POST['AddCODEEcheancier']) AND !empty($_POST['AddCODEEcheancier'])){

		$req = $bdd->exec("INSERT INTO ". TABLE_ERP_ECHEANCIER_TYPE ." VALUE ('0',
																		'". addslashes($_POST['AddCODEEcheancier']) ."',
																		'". addslashes($_POST['AddLABELEcheancier']) ."')");
		$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddTimeLinePayementNotification')));
	}

	//update TimeLine payement list
	if(isset($_POST['UpdateIdEcheancier']) AND !empty($_POST['UpdateIdEcheancier'])){

		$UpdateIdEcheancier = $_POST['UpdateIdEcheancier'];
		$UpdateCODEEcheancier = $_POST['UpdateCODEEcheancier'];
		$UpdateLABELEcheancier = $_POST['UpdateLABELEcheancier'];

		$i = 0;
		foreach ($UpdateIdEcheancier as $id_generation) {
			$bdd->exec('UPDATE `'. TABLE_ERP_ECHEANCIER_TYPE .'` SET  CODE = \''. addslashes($UpdateCODEEcheancier[$i]) .'\',
																LABEL = \''. addslashes($UpdateLABELEcheancier[$i]) .'\'
																WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateTimeLinePayementNotification')));
	}

	// generate list of TimeLine payement
	$i = 1;
	$req = $bdd -> query('SELECT '. TABLE_ERP_ECHEANCIER_TYPE .'.Id,
									'. TABLE_ERP_ECHEANCIER_TYPE .'.CODE,
									'. TABLE_ERP_ECHEANCIER_TYPE .'.LABEL
									FROM `'. TABLE_ERP_ECHEANCIER_TYPE .'`
									ORDER BY Id');

	while ($donnees_Echeancier = $req->fetch()){
		 $EcheanchierTypeContenu = $EcheanchierTypeContenu .'
				<tr>
					<td><input type="hidden" name="UpdateIdEcheancier[]" id="UpdateIdEcheancier" value="'. $donnees_Echeancier['Id'] .'"></td>
					<td><input type="text" name="UpdateCODEEcheancier[]" value="'. $donnees_Echeancier['CODE'] .'" required="required"></td>
					<td><input type="text" name="UpdateLABELEcheancier[]" value="'. $donnees_Echeancier['LABEL'] .'" required="required"></td>
					<td><a href="manage-accounting.php?Echeancier='. $donnees_Echeancier['Id']  .'">--></a></td>
				</tr>	';
		$i++;
	}

	//if user want show timeline detail
	if(isset($_GET['Echeancier']) AND !empty($_GET['Echeancier'])){

		//we change default view on this section
		$ParDefautDiv5 = 'id="defaultOpen"';

		//if add new ligne of timeline 
		if(isset($_POST['AddLABELLigneEcheancier']) AND !empty($_POST['AddLABELLigneEcheancier'])){

			$req = $bdd->exec("INSERT INTO ". TABLE_ERP_ECHEANCIER_TYPE_LIGNE ." VALUE ('0',
																		'". addslashes($_GET['Echeancier']) ."',
																		'". addslashes($_POST['AddLABELLigneEcheancier']) ."',
																		'". addslashes($_POST['AddPourcMontantLigneEcheancier']) ."',
																		'". addslashes($_POST['AddPourcTVALigneEcheancier']) ."',
																		'". addslashes($_POST['AddRegLigneEcheancier']) ."',
																		'". addslashes($_POST['AddModeLigneEcheancier']) ."',
																		'". addslashes($_POST['AddDelaisLigneEcheancier']) ."')");
			$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddLineTimeLinePayementNotification')));
		}

		//update timeline détail list
		if(isset($_POST['UpdateIdLigneEcheancier']) AND !empty($_POST['UpdateIdLigneEcheancier'])){

		$UpdateIdLigneEcheancier = $_POST['UpdateIdLigneEcheancier'];
		$UpdateLABELLigneEcheancier = $_POST['UpdateLABELLigneEcheancier'];
		$UpdatePourcMontantLigneEcheancier = $_POST['UpdatePourcMontantLigneEcheancier'];
		$UpdatePourcTVALigneEcheancier = $_POST['UpdatePourcTVALigneEcheancier'];
		$UpdateRegLigneEcheancier = $_POST['UpdateRegLigneEcheancier'];
		$UpdateModeLigneEcheancier = $_POST['UpdateModeLigneEcheancier'];
		$UpdateDelaisLigneEcheancier = $_POST['UpdateDelaisLigneEcheancier'];

		$i = 0;
		foreach ($UpdateIdLigneEcheancier as $id_generation) {

			$bdd->exec('UPDATE `'. TABLE_ERP_ECHEANCIER_TYPE_LIGNE .'` SET  LABEL = \''. addslashes($UpdateLABELLigneEcheancier[$i]) .'\',
																POURC_MONTANT = \''. addslashes($UpdatePourcMontantLigneEcheancier[$i]) .'\',
																POURC_TVA = \''. addslashes($UpdatePourcTVALigneEcheancier[$i]) .'\',
																CONDI_REG_ID = \''. addslashes($UpdateRegLigneEcheancier[$i]) .'\',
																MODE_REG_ID = \''. addslashes($UpdateModeLigneEcheancier[$i]) .'\',
																DELAI = \''. addslashes($UpdateDelaisLigneEcheancier[$i]) .'\'
																WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateLineTimeLinePayementNotification')));
	}

	//generate list of détail TimeLine payement
	$req = $bdd -> query('SELECT '. TABLE_ERP_ECHEANCIER_TYPE_LIGNE .'.Id,
									'. TABLE_ERP_ECHEANCIER_TYPE_LIGNE .'.ECHEANCIER_ID,
									'. TABLE_ERP_ECHEANCIER_TYPE_LIGNE .'.LABEL,
									'. TABLE_ERP_ECHEANCIER_TYPE_LIGNE .'.POURC_MONTANT,
									'. TABLE_ERP_ECHEANCIER_TYPE_LIGNE .'.POURC_TVA,
									'. TABLE_ERP_ECHEANCIER_TYPE_LIGNE .'.CONDI_REG_ID,
									'. TABLE_ERP_ECHEANCIER_TYPE_LIGNE .'.MODE_REG_ID,
									'. TABLE_ERP_ECHEANCIER_TYPE_LIGNE .'.DELAI
									FROM `'. TABLE_ERP_ECHEANCIER_TYPE_LIGNE .'`
										WHERE '. TABLE_ERP_ECHEANCIER_TYPE_LIGNE .'.ECHEANCIER_ID = \''. 	addslashes($_GET['Echeancier']).'\'
									ORDER BY Id');

		while ($donnees_Ligne_Echeancier = $req->fetch()){
			$reqConditionReg = $bdd -> query('SELECT Id, LABEL FROM '. TABLE_ERP_CONDI_REG .'');
			while ($DonneesConditionReg = $reqConditionReg->fetch()){
				$CondiListe1 .='<option value="'. $DonneesConditionReg['Id'] .'" '. selected( $donnees_Ligne_Echeancier['CONDI_REG_ID'], $DonneesConditionReg['Id']) .'>'. $DonneesConditionReg['LABEL'] .'</option>';
			}

			$reqModeReg = $bdd -> query('SELECT Id, LABEL FROM '. TABLE_ERP_MODE_REG .'');
			while ($DonneesModeReg = $reqModeReg->fetch()){
				$RegListe1 .='<option value="'. $DonneesModeReg['Id'] .'" '. selected( $donnees_Ligne_Echeancier['MODE_REG_ID'], $DonneesModeReg['Id']) .'>'. $DonneesModeReg['LABEL'] .'</option>';
			}

			$LigneContenu = $LigneContenu .'
					<tr>
							<td><input type="hidden" name="UpdateIdLigneEcheancier[]" id="UpdateIdLigneEcheancier" value="'. $donnees_Ligne_Echeancier['Id'] .'" required="required"></td>
							<td><input type="text"  name="UpdateLABELLigneEcheancier[]" value="'. $donnees_Ligne_Echeancier['LABEL'] .'" required="required"></td>
							<td><input type="number" name="UpdatePourcMontantLigneEcheancier[]" value="'. $donnees_Ligne_Echeancier['POURC_MONTANT'] .'" step=".001" required="required"></td>
							<td><input type="number"  name="UpdatePourcTVALigneEcheancier[]" value="'. $donnees_Ligne_Echeancier['POURC_TVA'] .'" step=".001" required="required"></td>
							<td>
								<select name="UpdateRegLigneEcheancier[]">
									'. $CondiListe1 .'
								</select>
							</td>
							<td>
								<select name="UpdateModeLigneEcheancier[]">
									'. $RegListe1 .'
								</select>
							</td>
							<td><input type="number" class="input-moyen-vide" name="UpdateDelaisLigneEcheancier[]" value="'. $donnees_Ligne_Echeancier['DELAI'] .'" required="required"></td>
						</tr>';

			$RegListe1 = '';
			$CondiListe1 = '';
			$i++;
		}

		//re init liste of condition payement
		$req = $bdd -> query('SELECT Id, LABEL FROM '. TABLE_ERP_CONDI_REG .'');
		while ($DonneesConditionReg = $req->fetch()){
			$CondiListe1 .='<option value="'. $DonneesConditionReg['Id'] .'" >'. $DonneesConditionReg['LABEL'] .'</option>';
		}
		$req->closeCursor();

		//re init liste of methode payement
		$req = $bdd -> query('SELECT Id, LABEL FROM '. TABLE_ERP_MODE_REG .'');
		while ($DonneesModeReg = $req->fetch()){
			$RegListe1 .='<option value="'. $DonneesModeReg['Id'] .'" >'. $DonneesModeReg['LABEL'] .'</option>';
		}

		//generate liste of detail timeline payement
		$EcheanchierLigneContenu = $EcheanchierLigneContenu .'
			<form method="post" name="Section" action="manage-accounting.php?Echeancier='. $_GET['Echeancier'] .'" class="content-form" >
				<table class="content-table-decal">
					<thead>
						<tr>
							<th></th>
							<th>'. $langue->show_text('TableLabel') .'</th>
							<th>'. $langue->show_text('TableAmountHT') .'</th>
							<th>'. $langue->show_text('TableAmountTVA') .'</th>
							<th>'. $langue->show_text('TableCondiList') .'</th>
							<th>'. $langue->show_text('TableMethodList') .'</th>
							<th>'. $langue->show_text('TableDayDelay') .'</th>
						</tr>
					</thead>
					<tbody>
						'. $LigneContenu .'
						<tr>
							<td>'. $langue->show_text('Addtext') .'</td>
							<td><input type="text" class="input-moyen-vide" name="AddLABELLigneEcheancier" ></td>
							<td><input type="number" class="input-moyen-vide" name="AddPourcMontantLigneEcheancier" step=".001" ></td>
							<td><input type="number" class="input-moyen-vide" name="AddPourcTVALigneEcheancier" step=".001" ></td>
							<td>
								<select name="AddRegLigneEcheancier">
									'. $CondiListe1 .'
								</select>
							</td>
							<td>
								<select name="AddModeLigneEcheancier">
									'. $RegListe1 .'
								</select>
							</td>
							<td><input type="number"  name="AddDelaisLigneEcheancier" ></td>
						</tr>
						<tr>
							<td colspan="7" >
								<br/>
								<input type="submit" class="input-moyen" value="'. $langue->show_text('TableUpdateButton') .'" /> <br/>
								<br/>
							</td>
						</tr>
					</tbody>
				</table>
			</form>';
	}
	else{
		$ParDefautDiv1 = 'id="defaultOpen"';
	}

	////////////////////////
	//// DELEVERY ////
	///////////////////////

	//if add new delevery method
	if(isset($_POST['AddCODETransport']) AND !empty($_POST['AddCODETransport'])){
		$req = $bdd->exec("INSERT INTO ". TABLE_ERP_TRANSPORT ." VALUE ('0',
																		'". addslashes($_POST['AddCODETransport']) ."',
																		'". addslashes($_POST['AddLABELTransport']) ."')");
		$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddDeleveryTypeNotification')));
	}

	//udpdate list of delevery method
	if(isset($_POST['UpdateIdTransport']) AND !empty($_POST['UpdateIdTransport'])){

		$UpdateIdTransport = $_POST['UpdateIdTransport'];
		$UpdateCODETransport = $_POST['UpdateCODETransport'];
		$UpdateLABELTransport = $_POST['UpdateLABELTransport'];

		$i = 0;
		foreach ($UpdateIdTransport as $id_generation) {
			$bdd->exec('UPDATE `'. TABLE_ERP_TRANSPORT .'` SET  CODE = \''. addslashes($UpdateCODETransport[$i]) .'\',
																LABEL = \''. addslashes($UpdateLABELTransport[$i]) .'\'
																WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateDeleveryNotification')));
	}

	//generate list of delevery
	$i = 1;
	$req = $bdd -> query('SELECT '. TABLE_ERP_TRANSPORT .'.Id,
									'. TABLE_ERP_TRANSPORT .'.CODE,
									'. TABLE_ERP_TRANSPORT .'.LABEL
									FROM `'. TABLE_ERP_TRANSPORT .'`
									ORDER BY Id');

	while ($donnees_Transport= $req->fetch()){
		 $TransportContenu = $TransportContenu .'
				<tr>
					<td><input type="hidden" name="UpdateIdTransport[]" id="UpdateIdTransport" value="'. $donnees_Transport['Id'] .'" ></td>
					<td><input type="text" name="UpdateCODETransport[]" value="'. $donnees_Transport['CODE'] .'" required="required"></td>
					<td><input type="text" name="UpdateLABELTransport[]" value="'. $donnees_Transport['LABEL'] .'" required="required"></td>
				</tr>	';
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
	//include interface
	require_once 'include/include_interface.php';
?>
	<div class="tab">
		<button class="tablinks" onclick="openDiv(event, 'div1')" <?=$ParDefautDiv1; ?>><?=$langue->show_text('Title1'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div2')"><?=$langue->show_text('Title2'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div3')"><?=$langue->show_text('Title3'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div4')"><?=$langue->show_text('Title4'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div5')" <?=$ParDefautDiv5; ?> ><?=$langue->show_text('Title5'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div6')" ><?=$langue->show_text('Title6'); ?></button>
	</div>
	<div id="div1" class="tabcontent" >
			<form method="post" name="Section" action="manage-accounting.php" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th><?=$langue->show_text('TableCODE'); ?></th>
							<th><?=$langue->show_text('TableLabel'); ?></th>
							<th><?=$langue->show_text('TableNumberOfMonth'); ?></th>
							<th><?=$langue->show_text('TableNumberOfDay'); ?></th>
							<th><?=$langue->show_text('TableEndMonth'); ?></th>
						</tr>
					</thead>
					<tbody>
<?php
								Echo $contenu1;
?>
						<tr>
							<td><?=$langue->show_text('Addtext'); ?></td>
							<td><input type="text" class="input-moyen-vide" name="AddCODECondiReg" ></td>
							<td><input type="text" class="input-moyen-vide" name="AddLABELCondiReg" ></td>
							<td><input type="number" class="input-moyen-vide" name="AddNbrMoisCondiReg" ></td>
							<td><input type="number" class="input-moyen-vide" name="AddNbrJoursCondiReg" ></td>
							<td>
								<select name="AddFinDeMoiCondiReg">
									<option value="1"><?=$langue->show_text('Yes'); ?></option>
									<option value="0"><?=$langue->show_text('No'); ?></option>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="6" >
								<br/>
								<input type="submit" class="input-moyen" value="<?=$langue->show_text('TableUpdateButton'); ?>" /> <br/>
								<br/>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>
	<div id="div2" class="tabcontent" >
			<form method="post" name="Section" action="manage-accounting.php" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th><?=$langue->show_text('TableCODE'); ?></th>
							<th><?=$langue->show_text('TableLabel'); ?></th>
							<th><?=$langue->show_text('TableAcountCODE'); ?></th>
						</tr>
					</thead>
					<tbody>
<?php
								Echo $contenu2;
?>
						<tr>
							<td><?=$langue->show_text('Addtext'); ?></td>
							<td><input type="text" class="input-moyen-vide" name="AddCODEModeRef" ></td>
							<td><input type="text" class="input-moyen-vide" name="AddLABELModeRef" ></td>
							<td><input type="text" class="input-moyen-vide" name="AddCODEComptaModeRef" ></td>
						</tr>
						<tr>
							<td colspan="4" >
								<br/>
								<input type="submit" class="input-moyen" value="<?=$langue->show_text('TableUpdateButton'); ?>" /> <br/>
								<br/>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>
	<div id="div3" class="tabcontent">
			<form method="post" name="Section" action="manage-accounting.php" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th><?=$langue->show_text('TableCODE'); ?></th>
							<th><?=$langue->show_text('TableLabel'); ?></th>
							<th><?=$langue->show_text('TableRate'); ?></th>
						</tr>
					</thead>
					<tbody>
<?php
								Echo $contenu3;
?>
						<tr>
							<td><?=$langue->show_text('Addtext'); ?></td>
							<td><input type="text" class="input-moyen-vide" name="AddCODETVA" ></td>
							<td><input type="text" class="input-moyen-vide" name="AddLABELTVA" ></td>
							<td><input type="number" class="input-moyen-vide" name="AddTAUXTVA" step=".001"></td>
						</tr>
						<tr>
							<td colspan="4" >
								<br/>
								<input type="submit" class="input-moyen" value="<?=$langue->show_text('TableUpdateButton'); ?>" /> <br/>
								<br/>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>
	<div id="div4" class="tabcontent" >
			<form method="post" name="Section" action="manage-accounting.php" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th><?=$langue->show_text('TableCODE'); ?></th>
							<th><?=$langue->show_text('TableLabel'); ?></th>
							<th><?=$langue->show_text('TableTVAType'); ?></th>
							<th><?=$langue->show_text('TableAccountTVA'); ?></th>
							<th><?=$langue->show_text('TableAcountCODE'); ?></th>
							<th><?=$langue->show_text('TableImputationType'); ?></th>
						</tr>
					</thead>
					<tbody>
<?php
								Echo $contenu4;
?>
						<tr>
							<td><?=$langue->show_text('Addtext'); ?></td>
							<td><input type="text" class="input-moyen-vide" name="AddCODEIMPUT" ></td>
							<td><input type="text" class="input-moyen-vide" name="AddLABELIMPUT"></td>
							<td>
								<select name="AddTVAIMPUT">
									<?=$TVAListe ?>
								</select>
							</td>
							<td><input type="number" class="input-moyen-vide" name="AddCOMPTETVAIMPUT" ></td>
							<td><input type="number" class="input-moyen-vide" name="AddCODECOMPTAIMPUT" ></td>
							<td>
								<select name="AddTYPEIMPUT">
									<option value="1"><?=$langue->show_text('TableSelect1'); ?></option>
									<option value="2"><?=$langue->show_text('TableSelect2'); ?></option>
									<option value="3"><?=$langue->show_text('TableSelect3'); ?></option>
									<option value="4"><?=$langue->show_text('TableSelect4'); ?></option>
									<option value="5"><?=$langue->show_text('TableSelect5'); ?></option>
									<option value="6"><?=$langue->show_text('TableSelect6'); ?></option>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="7" >
								<br/>
								<input type="submit" class="input-moyen" value="<?=$langue->show_text('TableUpdateButton'); ?>" /> <br/>
								<br/>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
	</div>
	<div id="div5" class="tabcontent" >
			<form method="post" name="Section" action="manage-accounting.php" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th><?=$langue->show_text('TableCODE'); ?></th>
							<th><?=$langue->show_text('TableLabel'); ?></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
<?php
								Echo $EcheanchierTypeContenu;
?>
						<tr>
							<td><?=$langue->show_text('Addtext'); ?></td>
							<td><input type="text" class="input-moyen-vide" name="AddCODEEcheancier"></td>
							<td><input type="text" class="input-moyen-vide" name="AddLABELEcheancier"></td>
							<td></td>
						</tr>
						<tr>
							<td colspan="4" >
								<br/>
								<input type="submit" class="input-moyen" value="<?=$langue->show_text('TableUpdateButton'); ?>" /> <br/>
								<br/>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
<?php
				Echo $EcheanchierLigneContenu;
?>
	</div>
	<div id="div6" class="tabcontent" >
		<form method="post" name="Section" action="manage-accounting.php" class="content-form" >
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
								Echo $TransportContenu;
							?>
						<tr>
							<td><?=$langue->show_text('Addtext'); ?></td>
							<td><input type="text" class="input-moyen-vide" name="AddCODETransport"></td>
							<td><input type="text" class="input-moyen-vide" name="AddLABELTransport"></td>
						<tr>
							<td colspan="3" >
								<br/>
								<input type="submit" class="input-moyen" value="<?=$langue->show_text('TableUpdateButton'); ?>" /> <br/>
								<br/>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
	</div>
<?php
	//include CallOut
	require_once 'include/include_CallOutBox.php';
?>
</body>
</html>
