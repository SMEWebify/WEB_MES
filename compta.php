<?php session_start();

	header( 'content-type: text/html; charset=utf-8' );

	//phpinfo();

	//include pour la connection à la base SQL 
	require_once 'include/include_connection_sql.php';
	//include pour les fonctions
	require_once 'include/include_fonctions.php';
	//include pour les constantes
	require_once 'include/include_recup_config.php';

	if(isset($_SESSION['mdp'])){
		//verification  de la session
		require_once 'include/verifications_session.php';
	}
	else{
		stop('Aucune session ouverte, l\'accès vous est interdit.', 160, 'connexion.php');
	}
	
	if($_SESSION['page_10'] != '1'){
		
		stop('L\'accès vous est interdit.', 161, 'connexion.php');
	}
	
	////////////////////////
	//// CONDITION REG ////
	///////////////////////
	
	if(isset($_POST['AddCODECondiReg']) AND !empty($_POST['AddCODECondiReg'])){

		$req = $bdd->exec("INSERT INTO ". TABLE_ERP_CONDI_REG ." VALUE ('0',
																		'". addslashes($_POST['AddCODECondiReg']) ."',
																		'". addslashes($_POST['AddLABELCondiReg']) ."',
																		'". addslashes($_POST['AddNbrMoisCondiReg']) ."',
																		'". addslashes($_POST['AddNbrJoursCondiReg']) ."',
																		'". addslashes($_POST['AddFinDeMoiCondiReg']) ."')");
															
	}
	
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
	}
	
	$i = 1;
	$req = $bdd -> query('SELECT '. TABLE_ERP_CONDI_REG .'.Id,
									'. TABLE_ERP_CONDI_REG .'.CODE,
									'. TABLE_ERP_CONDI_REG .'.LABEL,
									'. TABLE_ERP_CONDI_REG .'.NBR_MOIS,
									'. TABLE_ERP_CONDI_REG .'.NBR_JOURS,
									'. TABLE_ERP_CONDI_REG .'.FIN_MOIS
									FROM `'. TABLE_ERP_CONDI_REG .'`
									ORDER BY Id');
									
	while ($donnees_id_CondiReg = $req->fetch())
	{
		 $contenu1 = $contenu1 .'
				<tr>
					<td>'. $i .' <input type="hidden" name="id_CondiReg[]" id="id_CondiReg" value="'. $donnees_id_CondiReg['Id'] .'"></td>
					<td><input type="text" name="UpdateCODECondiReg[]" value="'. $donnees_id_CondiReg['CODE'] .'" required="required"></td>
					<td><input type="text" name="UpdateLABELCondiReg[]" value="'. $donnees_id_CondiReg['LABEL'] .'" required="required"></td>
					<td><input type="number" name="UpdateNBRMOISCondiReg[]" value="'. $donnees_id_CondiReg['NBR_MOIS'] .'" required="required"></td>
					<td><input type="number" name="UpdateNBRJOURSCondiReg[]" value="'. $donnees_id_CondiReg['NBR_JOURS'] .'" required="required"></td>
					<td>
						<select name="FINMOISCondiReg[]">
							<option value="1" '. selected($donnees_id_CondiReg['FIN_MOIS'], "1") .'>Oui</option>
							<option value="0" '. selected($donnees_id_CondiReg['FIN_MOIS'], "0") .'>Non</option>
						</select>
					</td>
				</tr>	';
		$i++;
	}
	
	/////////////////////////
	////  MODE REGLEMENT ////
	/////////////////////////
	
	if(isset($_POST['AddCODEModeRef']) AND !empty($_POST['AddCODEModeRef'])){
		
		$req = $bdd->exec("INSERT INTO ". TABLE_ERP_MODE_REG ." VALUE ('0',
																		'". addslashes($_POST['AddCODEModeRef']) ."',
																		'". addslashes($_POST['AddLABELModeRef']) ."',
																		'". addslashes($_POST['AddCODEComptaModeRef']) ."')");
															
	}
	
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
	}
	
	$i = 1;
	$req = $bdd -> query('SELECT '. TABLE_ERP_MODE_REG .'.Id,
									'. TABLE_ERP_MODE_REG .'.CODE,
									'. TABLE_ERP_MODE_REG .'.LABEL,
									'. TABLE_ERP_MODE_REG .'.CODE_COMPTABLE
									FROM `'. TABLE_ERP_MODE_REG .'`
									ORDER BY Id');
									
	while ($donnees_ModeReg = $req->fetch())
	{
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
					
	if(isset($_POST['AddCODETVA']) AND !empty($_POST['AddCODETVA'])){
		
		$req = $bdd->exec("INSERT INTO ". TABLE_ERP_TVA ." VALUE ('0',
																		'". addslashes($_POST['AddCODETVA']) ."',
																		'". addslashes($_POST['AddLABELTVA']) ."',
																		'". addslashes($_POST['AddTAUXTVA']) ."')");
															
	}
	
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
	}
	
	$i = 1;
	$req = $bdd -> query('SELECT '. TABLE_ERP_TVA .'.Id,
									'. TABLE_ERP_TVA .'.CODE,
									'. TABLE_ERP_TVA .'.LABEL,
									'. TABLE_ERP_TVA .'.TAUX
									FROM `'. TABLE_ERP_TVA .'`
									ORDER BY Id');
									
	while ($donnees_TVA = $req->fetch())
	{
		 $contenu3 = $contenu3 .'
				<tr>
					<td>'. $i .' <input type="hidden" name="id_TVA[]" id="id_TVA" value="'. $donnees_TVA['Id'] .'"></td>
					<td><input type="text" name="UpdateCODETVA[]" value="'. $donnees_TVA['CODE'] .'" required="required"></td>
					<td><input type="text" name="UpdateLABELTVA[]" value="'. $donnees_TVA['LABEL'] .'" required="required"></td>
					<td><input type="text" name="UpdateTAUXTVA[]" value="'. $donnees_TVA['TAUX'] .'" required="required"></td>
				</tr>';
		$i++;
	}
	
	
	///////////////////////////////
	////  IMPUTATION COMPTABLE ////
	///////////////////////////////
	
	$req = $bdd -> query('SELECT Id, LABEL, TAUX FROM '. TABLE_ERP_TVA .'');
	while ($DonneesTVA = $req->fetch())
	{
		$TVAListe .='<option value="'. $DonneesTVA['Id'] .'">'. $DonneesTVA['TAUX'] .'% - '. $DonneesTVA['LABEL'] .'</option>';
	}
	
	if(isset($_POST['AddCODEIMPUT']) AND !empty($_POST['AddCODEIMPUT'])){
		
		$req = $bdd->exec("INSERT INTO ". TABLE_ERP_IMPUT_COMPTA ." VALUE ('0',
																		'". addslashes($_POST['AddCODEIMPUT']) ."',
																		'". addslashes($_POST['AddLABELIMPUT']) ."',
																		'". addslashes($_POST['AddTVAIMPUT']) ."',
																		'". addslashes($_POST['AddCOMPTETVAIMPUT']) ."',
																		'". addslashes($_POST['AddCODECOMPTAIMPUT']) ."',
																		'". addslashes($_POST['AddTYPEIMPUT']) ."')");
															
	}
	
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
	}
	
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
									
	while ($donnees_IMPUT = $req->fetch())
	{
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
							<option value="1" '. selected($donnees_IMPUT['TYPE_IMPUTATION'], 1) .'>Achat</option>
							<option value="2" '. selected($donnees_IMPUT['TYPE_IMPUTATION'], 2) .'>Achat (stock)</option>
							<option value="3" '. selected($donnees_IMPUT['TYPE_IMPUTATION'], 3) .'>Acompte</option>
							<option value="4" '. selected($donnees_IMPUT['TYPE_IMPUTATION'], 4) .'>Acompte (avec TVA)</option>
							<option value="5" '. selected($donnees_IMPUT['TYPE_IMPUTATION'], 5) .'>Autre</option>
							<option value="6" '. selected($donnees_IMPUT['TYPE_IMPUTATION'], 6) .'>TVA</option>
						</select>
					</td>
				</tr>';
		$i++;
	}
	
	////////////////////////
	//// ECHEANCIER TYPE ////
	///////////////////////
	
	if(isset($_POST['AddCODEEcheancier']) AND !empty($_POST['AddCODEEcheancier'])){

		$req = $bdd->exec("INSERT INTO ". TABLE_ERP_ECHEANCIER_TYPE ." VALUE ('0',
																		'". addslashes($_POST['AddCODEEcheancier']) ."',
																		'". addslashes($_POST['AddLABELEcheancier']) ."')");
															
	}
	
	if(isset($_POST['UpdateIdEcheancier']) AND !empty($_POST['UpdateIdEcheancier'])){
		
		$UpdateIdEcheancier = $_POST['UpdateIdEcheancier'];
		$UpdateCODEEcheancier = $_POST['UpdateCODEEcheancier'];
		$UpdateLABELEcheancier = $_POST['UpdateLABELEcheancier'];
		
		$i = 0;
		foreach ($UpdateIdEcheancier as $id_generation) {
			
			$bdd->exec('UPDATE `'. TABLE_ERP_CONDI_REG .'` SET  CODE = \''. addslashes($UpdateCODEEcheancier[$i]) .'\',
																LABEL = \''. addslashes($UpdateLABELEcheancier[$i]) .'\'
																WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
	}
	
	$i = 1;
	$req = $bdd -> query('SELECT '. TABLE_ERP_ECHEANCIER_TYPE .'.Id,
									'. TABLE_ERP_ECHEANCIER_TYPE .'.CODE,
									'. TABLE_ERP_ECHEANCIER_TYPE .'.LABEL
									FROM `'. TABLE_ERP_ECHEANCIER_TYPE .'`
									ORDER BY Id');
									
	while ($donnees_Echeancier = $req->fetch())
	{
		 $EcheanchierTypeContenu = $EcheanchierTypeContenu .'
				<tr>
					<td><input type="hidden" name="UpdateIdEcheancier[]" id="UpdateIdEcheancier" value="'. $donnees_Echeancier['Id'] .'"></td>
					<td><input type="text" name="UpdateCODEEcheancier[]" value="'. $donnees_Echeancier['CODE'] .'" required="required"></td>
					<td><input type="text" name="UpdateLABELEcheancier[]" value="'. $donnees_Echeancier['LABEL'] .'" required="required"></td>
					<td><a href="compta.php?Echeancier='. $donnees_Echeancier['Id']  .'">--></a></td>
				</tr>	';
		$i++;
	}
	
	if(isset($_GET['Echeancier']) AND !empty($_GET['Echeancier'])){
		
		
		$ParDefautDiv5 = 'id="defaultOpen"';
		
		if(isset($_POST['AddLABELLigneEcheancier']) AND !empty($_POST['AddLABELLigneEcheancier'])){

			$req = $bdd->exec("INSERT INTO ". TABLE_ERP_ECHEANCIER_TYPE_LIGNE ." VALUE ('0',
																		'". addslashes($_GET['Echeancier']) ."',
																		'". addslashes($_POST['AddLABELLigneEcheancier']) ."',
																		'". addslashes($_POST['AddPourcMontantLigneEcheancier']) ."',
																		'". addslashes($_POST['AddPourcTVALigneEcheancier']) ."',
																		'". addslashes($_POST['AddRegLigneEcheancier']) ."',
																		'". addslashes($_POST['AddModeLigneEcheancier']) ."',
																		'". addslashes($_POST['AddDelaisLigneEcheancier']) ."')");
															
		}
		
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
	}
		
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
									
		while ($donnees_Ligne_Echeancier = $req->fetch())
		{
			$reqConditionReg = $bdd -> query('SELECT Id, LABEL FROM '. TABLE_ERP_CONDI_REG .'');
			while ($DonneesConditionReg = $reqConditionReg->fetch())
			{
				$CondiListe1 .='<option value="'. $DonneesConditionReg['Id'] .'" '. selected( $donnees_Ligne_Echeancier['CONDI_REG_ID'], $DonneesConditionReg['Id']) .'>'. $DonneesConditionReg['LABEL'] .'</option>';
			}
				
			$reqModeReg = $bdd -> query('SELECT Id, LABEL FROM '. TABLE_ERP_MODE_REG .'');
			while ($DonneesModeReg = $reqModeReg->fetch())
			{
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
			$req = $bdd -> query('SELECT Id, LABEL FROM '. TABLE_ERP_CONDI_REG .'');
			while ($DonneesConditionReg = $req->fetch())
			{
				$CondiListe1 .='<option value="'. $DonneesConditionReg['Id'] .'" >'. $DonneesConditionReg['LABEL'] .'</option>';
			}
			$req->closeCursor();
				
			$req = $bdd -> query('SELECT Id, LABEL FROM '. TABLE_ERP_MODE_REG .'');
			while ($DonneesModeReg = $req->fetch())
			{
				$RegListe1 .='<option value="'. $DonneesModeReg['Id'] .'" >'. $DonneesModeReg['LABEL'] .'</option>';
			}
			
		 $EcheanchierLigneContenu = $EcheanchierLigneContenu .'
			<form method="post" name="Section" action="compta.php?Echeancier='. $_GET['Echeancier'] .'" class="content-form" >
				<table class="content-table-decal">
					<thead>
						<tr>
							<th></th>
							<th>Libellé</th>
							<th>Montant H.T. (%)</th>
							<th>Montant TVA (%)</th>
							<th>Condition de réglement</th>
							<th>Mode de réglement</th>
							<th>Délai (en jours)</th>
						</tr>
					</thead>
					<tbody>
						'. $LigneContenu .'
						<tr>
							<td>Ajout</td>
							<td><input type="text" class="input-moyen-vide" name="AddLABELLigneEcheancier" required="required"></td>
							<td><input type="number" class="input-moyen-vide" name="AddPourcMontantLigneEcheancier" step=".001" required="required"></td>
							<td><input type="number" class="input-moyen-vide" name="AddPourcTVALigneEcheancier" step=".001" required="required"></td>
							<td>
								<select name="AddRegLigneEcheancier">
									'. $CondiListe1 .'
								</select>
							</td>
							<td>
								<select name="AddModeLigneEcheancier">
									'.$RegListe1 .'
								</select>
							</td>
							<td><input type="number"  name="AddDelaisLigneEcheancier" required="required"></td>
						</tr>
						<tr>
							<td colspan="7" >
								<br/>
								<input type="submit" class="input-moyen" value="Mettre à jour" /> <br/>
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
	//// TRANSPORT ////
	///////////////////////
	
	if(isset($_POST['AddCODETransport']) AND !empty($_POST['AddCODETransport'])){

		$req = $bdd->exec("INSERT INTO ". TABLE_ERP_TRANSPORT ." VALUE ('0',
																		'". addslashes($_POST['AddCODETransport']) ."',
																		'". addslashes($_POST['AddLABELTransport']) ."')");
															
	}
	
	if(isset($_POST['UpdateIdEcheancier']) AND !empty($_POST['UpdateIdEcheancier'])){
		
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
	}
	
	$i = 1;
	$req = $bdd -> query('SELECT '. TABLE_ERP_TRANSPORT .'.Id,
									'. TABLE_ERP_TRANSPORT .'.CODE,
									'. TABLE_ERP_TRANSPORT .'.LABEL
									FROM `'. TABLE_ERP_TRANSPORT .'`
									ORDER BY Id');
									
	while ($donnees_Transport= $req->fetch())
	{
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
	//include interface
	require_once 'include/include_header.php';
?>
</head>
<body>
<?php
	//include interface
	require_once 'include/include_interface.php';

?>


	<div class="tab">
		<button class="tablinks" onclick="openDiv(event, 'div1')" <?php echo $ParDefautDiv1; ?>> Condition de réglement</button>
		<button class="tablinks" onclick="openDiv(event, 'div2')">Mode de réglement</button>
		<button class="tablinks" onclick="openDiv(event, 'div3')">TVA</button>
		<button class="tablinks" onclick="openDiv(event, 'div4')">Imputations comptables</button>
		<button class="tablinks" onclick="openDiv(event, 'div5')" <?php echo $ParDefautDiv5; ?> >Echéancier types</button>
		<button class="tablinks" onclick="openDiv(event, 'div6')" >Transport</button>
	</div>
	<div id="div1" class="tabcontent" >
			<form method="post" name="Section" action="compta.php" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th>CODE</th>
							<th>Libellé</th>
							<th>Nombre de mois</th>
							<th>Nombre de jours</th>
							<th>Fin de mois</th>
						</tr>
					</thead>
					<tbody>
							<?php

								Echo $contenu1;
							?>
						<tr>
							<td>Ajout</td>
							<td><input type="text" class="input-moyen-vide" name="AddCODECondiReg" required="required"></td>
							<td><input type="text" class="input-moyen-vide" name="AddLABELCondiReg" required="required"></td>
							<td><input type="number" class="input-moyen-vide" name="AddNbrMoisCondiReg" required="required"></td>
							<td><input type="number" class="input-moyen-vide" name="AddNbrJoursCondiReg" required="required"></td>
							<td>
								<select name="AddFinDeMoiCondiReg">
									<option value="1">Oui</option>
									<option value="0">Non</option>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="6" >
								<br/>
								<input type="submit" class="input-moyen" value="Mettre à jour" /> <br/>
								<br/>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>
	<div id="div2" class="tabcontent" >
			<form method="post" name="Section" action="compta.php" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th>CODE</th>
							<th>Libellé</th>
							<th>CODE_COMTABLE</th>
						</tr>
					</thead>
					<tbody>
							<?php

								Echo $contenu2;
							?>
						<tr>
							<td>Ajout</td>
							<td><input type="text" class="input-moyen-vide" name="AddCODEModeRef" required="required"></td>
							<td><input type="text" class="input-moyen-vide" name="AddLABELModeRef" required="required"></td>
							<td><input type="text" class="input-moyen-vide" name="AddCODEComptaModeRef" required="required"></td>
						</tr>
						<tr>
							<td colspan="4" >
								<br/>
								<input type="submit" class="input-moyen" value="Mettre à jour" /> <br/>
								<br/>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>
	<div id="div3" class="tabcontent">
			<form method="post" name="Section" action="compta.php" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th>CODE</th>
							<th>Libellé</th>
							<th>Taux</th>
						</tr>
					</thead>
					<tbody>
							<?php

								Echo $contenu3;
							?>
						<tr>
							<td>Ajout</td>
							<td><input type="text" class="input-moyen-vide" name="AddCODETVA" required="required"></td>
							<td><input type="text" class="input-moyen-vide" name="AddLABELTVA" required="required"></td>
							<td><input type="number" class="input-moyen-vide" name="AddTAUXTVA" step=".001" required="required"></td>
						</tr>
						<tr>
							<td colspan="4" >
								<br/>
								<input type="submit" class="input-moyen" value="Mettre à jour" /> <br/>
								<br/>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>
	<div id="div4" class="tabcontent" >
			<form method="post" name="Section" action="compta.php" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th>CODE</th>
							<th>Libellé</th>
							<th>TVA</th>
							<th>Compte TVA</th>
							<th>CODE Compta</th>
							<th>TYPE IMPUTATION</th>
						</tr>
					</thead>
					<tbody>
							<?php

								Echo $contenu4;
							?>
						<tr>
							<td>Ajout</td>
							<td><input type="text" class="input-moyen-vide" name="AddCODEIMPUT" required="required"></td>
							<td><input type="text" class="input-moyen-vide" name="AddLABELIMPUT" required="required"></td>
							<td>
								<select name="AddTVAIMPUT">
									<?php echo $TVAListe ?>
								</select>
							</td>
							<td><input type="number" class="input-moyen-vide" name="AddCOMPTETVAIMPUT" required="required"></td>
							<td><input type="number" class="input-moyen-vide" name="AddCODECOMPTAIMPUT" required="required"></td>
							<td>
								<select name="AddTYPEIMPUT">
								
									<option value="1">Achat</option>
									<option value="2">Achat (stock)</option>
									<option value="3">Acompte</option>
									<option value="4">Acompte (avec TVA)</option>
									<option value="5">Autre</option>
									<option value="6">TVA</option>
								</select>
							</td>
						</tr>
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
	<div id="div5" class="tabcontent" >
			<form method="post" name="Section" action="compta.php" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th>CODE</th>
							<th>Libellé</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
							<?php
								Echo $EcheanchierTypeContenu;
							?>
						<tr>
							<td>Ajout</td>
							<td><input type="text" class="input-moyen-vide" name="AddCODEEcheancier" required="required"></td>
							<td><input type="text" class="input-moyen-vide" name="AddLABELEcheancier" required="required"></td>
							<td></td>
						<tr>
							<td colspan="4" >
								<br/>
								<input type="submit" class="input-moyen" value="Mettre à jour" /> <br/>
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
		<form method="post" name="Section" action="compta.php" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th>CODE</th>
							<th>Libellé</th>
						</tr>
					</thead>
					<tbody>
							<?php
								Echo $TransportContenu;
							?>
						<tr>
							<td>Ajout</td>
							<td><input type="text" class="input-moyen-vide" name="AddCODETransport" required="required"></td>
							<td><input type="text" class="input-moyen-vide" name="AddLABELTransport" required="required"></td>
						<tr>
							<td colspan="3" >
								<br/>
								<input type="submit" class="input-moyen" value="Mettre à jour" /> <br/>
								<br/>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
	</div>
</body>
</html>