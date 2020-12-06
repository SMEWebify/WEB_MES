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

	if($_SESSION['page_5'] != '1'){
		
		stop('L\'accès vous est interdit.', 161, 'connexion.php');
	}
	
	$contenu = '';

	
	///////////////////////////////
	//// COMMMENT ////
	///////////////////////////////
	if(isset($_POST['Comment']) AND !empty($_POST['Comment'])){
		
		$req = $bdd->exec("UPDATE  ". TABLE_ERP_COMMANDE ." SET 	COMENT='". addslashes($_POST['Comment']) ."'
																		WHERE CODE='". addslashes($_POST['CODEcommande'])."'");
	}
	
	///////////////////////////////
	//// GENERAL UPDATE ////
	///////////////////////////////
	if(isset($_POST['RepsComcommande']) AND !empty($_POST['RepsComcommande'])){
		$PostRepsComcommande= $_POST['RepsComcommande'];
		$PostRespTechcommande = $_POST['RespTechcommande'];
		
		if($_POST['RepsComcommande'] == 'null'){ $PostRepsComcommande = 0; }
		if($_POST['RespTechcommande'] == 'null'){ $PostRespTechcommande = 0; }
		
		$req = $bdd->exec("UPDATE  ". TABLE_ERP_COMMANDE ." SET 	RESP_COM_ID='". addslashes($PostRepsComcommande) ."',
																RESP_TECH_ID='". addslashes($PostRespTechcommande) ."'
																		WHERE CODE='". addslashes($_POST['CODEcommande'])."'");
																		
	}
	
	///////////////////////////////
	//// COMMERCIAL UPDATE ////
	///////////////////////////////
	if(isset($_POST['CondiRegcommande']) AND !empty($_POST['CondiRegcommande'])){
		$PostCondiRegcommande= $_POST['CondiRegcommande'];
		$PostModeRegcommande = $_POST['ModeRegcommande'];
		$PostEcheanciercommande = $_POST['Echeanciercommande'];
		$PostModeLivraisoncommande = $_POST['ModeLivraisoncommande'];
		
		$req = $bdd->exec("UPDATE  ". TABLE_ERP_COMMANDE ." SET 	COND_REG_CLIENT_ID='". addslashes($PostCondiRegcommande) ."',
																MODE_REG_CLIENT_ID='". addslashes($PostModeRegcommande) ."',
																ECHEANCIER_ID='". addslashes($PostEcheanciercommande) ."',
																TRANSPORT_ID='". addslashes($PostModeLivraisoncommande) ."'
															WHERE CODE='". addslashes($_POST['CODEcommande'])."'");
	}
	
	///////////////////////////////
	//// CLIENT INFO UPDATE ////
	///////////////////////////////
	if(isset($_POST['Contactcommande']) AND !empty($_POST['Contactcommande'])){
		$PostContactcommande= $_POST['Contactcommande'];
		$PostAdresseLivraisoncommande = $_POST['AdresseLivraisoncommande'];
		$PostAdresseFacturationcommande = $_POST['AdresseFacturationcommande'];
		
		if($_POST['Contactcommande'] == 'null'){ $PostContactcommande = 0; }
		if($_POST['AdresseLivraisoncommande'] == 'null'){ $PostAdresseLivraisoncommande = 0; }
		if($_POST['AdresseFacturationcommande'] == 'null'){ $PostAdresseFacturationcommande = 0; }
		
		$req = $bdd->exec("UPDATE  ". TABLE_ERP_COMMANDE ." SET 	CONTACT_ID='". addslashes($PostContactcommande) ."',
																ADRESSE_ID='". addslashes($PostAdresseLivraisoncommande) ."',
																FACTURATION_ID='". addslashes($PostAdresseFacturationcommande) ."'
															WHERE CODE='". addslashes($_POST['CODEcommande'])."'");
	}
	
	///////////////////////////////
	//// DELETE LIGNE ////
	///////////////////////////////
	if(isset($_GET['delete']) AND !empty($_GET['delete'])){
		
		$req = $bdd->exec("DELETE FROM ". TABLE_ERP_COMMANDE_LIGNE ." WHERE id='". addslashes($_GET['delete'])."'");
	}
	
	///////////////////////////////
	//// ACCEUIL commande  ////
	///////////////////////////////
	if(isset($_POST['Etatcommande']) AND !empty($_POST['Etatcommande'])){
		
		
		$PostcommandeLABEL= $_POST['commandeLABEL'];
		$PostcommandeLABELIndice = $_POST['commandeLABELIndice'];
		$PostcommandeReference = $_POST['commandeReference'];
		$PostcommandeEtat = $_POST['Etatcommande'];
		
		$req = $bdd->exec("UPDATE  ". TABLE_ERP_COMMANDE ." SET 	LABEL='". addslashes($PostcommandeLABEL) ."',
																LABEL_INDICE='". addslashes($PostcommandeLABELIndice) ."',
																REFERENCE='". addslashes($PostcommandeReference) ."'
																ETAT='". addslashes($PostcommandeEtat) ."'
															WHERE CODE='". addslashes($_POST['CODEcommande'])."'");
															
		if(isset($_POST['commandeMajLigne']) AND !empty($_POST['commandeMajLigne'])){
			
			$req = $bdd->exec("UPDATE  ". TABLE_ERP_COMMANDE_LIGNE ." SET 	ETAT='". addslashes($PostcommandeEtat) ."'
															WHERE 	commande_ID='". addslashes($_POST['Idcommande'])."'");
		}
	}
	
	if(isset($_POST['Addcommande']) And !empty($_POST['Addcommande'])){
		
		$req = $bdd -> query('SELECT '. TABLE_ERP_NUM_DOC .'.Id,
									'. TABLE_ERP_NUM_DOC .'.DOC_TYPE,
									'. TABLE_ERP_NUM_DOC .'.MODEL,
									'. TABLE_ERP_NUM_DOC .'.DIGIT,
									'. TABLE_ERP_NUM_DOC .'.COMPTEUR
									FROM `'. TABLE_ERP_NUM_DOC .'`
									WHERE DOC_TYPE=4');
		$donnees_Num_doc = $req->fetch();
		
		$CODE = NumDoc($donnees_Num_doc['MODEL'],$donnees_Num_doc['COMPTEUR'], $donnees_Num_doc['DIGIT']);
		
		$req = $bdd->exec("INSERT INTO ". TABLE_ERP_COMMANDE ." VALUE ('0',
																				'". $CODE ."',
																				'1',
																				'',
																				'',
																				'". addslashes($_POST['Addcommande']) ."',
																				'0',
																				'0',
																				'0',
																				NOW(),
																				'1',
																				'". $id ."',
																				'0',
																				'0',
																				'',
																				'9',
																				'5',
																				'0',
																				'0',
																				'')");
																				
		$bdd->exec('UPDATE `'. TABLE_ERP_NUM_DOC .'` SET  COMPTEUR = COMPTEUR + 1 WHERE DOC_TYPE IN (4)');
			
		$req = $bdd->query("SELECT CODE FROM ". TABLE_ERP_COMMANDE ." ORDER BY id DESC LIMIT 0, 1");
		$Donneescommande = $req->fetch();
		$req->closeCursor();
		$CODEcommandeAjout = $Donneescommande['CODE'];
		
	}
	
	$req = $bdd->query('SELECT '. TABLE_ERP_COMMANDE .'.CODE,
								'. TABLE_ERP_COMMANDE .'.LABEL,
								'. TABLE_ERP_CLIENT_FOUR .'.NAME
								FROM '. TABLE_ERP_COMMANDE .' 
									LEFT JOIN `'. TABLE_ERP_CLIENT_FOUR .'` ON `'. TABLE_ERP_COMMANDE .'`.`CLIENT_ID` = `'. TABLE_ERP_CLIENT_FOUR .'`.`id`
								ORDER BY '. TABLE_ERP_COMMANDE .'.id DESC');
	while ($donnees_commande = $req->fetch())
	{
		$ListeCommande .= '<option  value="'. $donnees_commande['CODE'] .'" >';
		$ListeCommandePrincipale  .= '<li><a href="commandes.php?id='. $donnees_commande['CODE'] .'">'. $donnees_commande['CODE'] .' - '. $donnees_commande['NAME'] .' </a></li>';
	}
	

	
	if(isset($_GET['id']) And !empty($_GET['id']) Or isset($_POST['Addcommande']) And !empty($_POST['Addcommande'])){
		
		
		if(isset($_GET['id'])){$CODEcommande = addslashes($_GET['id']);}
		if(isset($_POST['Addcommande']) And !empty($_POST['Addcommande'])){$CODEcommande = $CODEcommandeAjout;}
			
		$req = $bdd->query("SELECT COUNT(id) as nb FROM ". TABLE_ERP_COMMANDE ." WHERE CODE = '". $CODEcommande."'");
		$data = $req->fetch();
		$req->closeCursor();
		$nb = $data['nb'];
			
		if($nb=1){
			
				$req = $bdd -> query('SELECT '. TABLE_ERP_COMMANDE .'.Id,
									'. TABLE_ERP_COMMANDE .'.CODE,
									'. TABLE_ERP_COMMANDE .'.INDICE,
									'. TABLE_ERP_COMMANDE .'.LABEL,
									'. TABLE_ERP_COMMANDE .'.LABEL_INDICE,
									'. TABLE_ERP_COMMANDE .'.CLIENT_ID,
									'. TABLE_ERP_COMMANDE .'.CONTACT_ID,
									'. TABLE_ERP_COMMANDE .'.ADRESSE_ID,
									'. TABLE_ERP_COMMANDE .'.FACTURATION_ID,
									'. TABLE_ERP_COMMANDE .'.DATE,
									'. TABLE_ERP_COMMANDE .'.ETAT,
									'. TABLE_ERP_COMMANDE .'.CREATEUR_ID,
									'. TABLE_ERP_COMMANDE .'.RESP_COM_ID,
									'. TABLE_ERP_COMMANDE .'.RESP_TECH_ID,
									'. TABLE_ERP_COMMANDE .'.REFERENCE,
									'. TABLE_ERP_COMMANDE .'.COND_REG_CLIENT_ID,
									'. TABLE_ERP_COMMANDE .'.MODE_REG_CLIENT_ID,
									'. TABLE_ERP_COMMANDE .'.ECHEANCIER_ID,
									'. TABLE_ERP_COMMANDE .'.TRANSPORT_ID,
									'. TABLE_ERP_COMMANDE .'.COMENT,
									'. TABLE_ERP_CLIENT_FOUR .'.NAME,
									'. TABLE_ERP_EMPLOYEES .'.NOM,
									'. TABLE_ERP_EMPLOYEES .'.PRENOM
									FROM `'. TABLE_ERP_COMMANDE .'`
										LEFT JOIN `'. TABLE_ERP_CLIENT_FOUR .'` ON `'. TABLE_ERP_COMMANDE .'`.`CLIENT_ID` = `'. TABLE_ERP_CLIENT_FOUR .'`.`id`
										LEFT JOIN `'. TABLE_ERP_EMPLOYEES .'` ON `'. TABLE_ERP_COMMANDE .'`.`CREATEUR_ID` = `'. TABLE_ERP_EMPLOYEES .'`.`idUSER`
									WHERE '. TABLE_ERP_COMMANDE .'.CODE = \''. $CODEcommande.'\' ');
			$Donneescommande = $req->fetch();
			$req->closeCursor();
			
			$titleOnglet1 = "Mettre à jours";
			
			$IDcommandeSQL = $Donneescommande['Id'];
			$Commentairecommande = $Donneescommande['COMENT'];
			$commandeCLIENT_ID = $Donneescommande['CLIENT_ID'];
			$commandeCONTACT_ID = $Donneescommande['CONTACT_ID'];
			$commandeCLIENT_NAME = $Donneescommande['NAME'];
			$commandeADRESSE_ID = $Donneescommande['ADRESSE_ID'];
			$commandeFACTURATION_ID = $Donneescommande['FACTURATION_ID'];
			$commandeNomName = $Donneescommande['NOM'];
			$commandeNomPrenom = $Donneescommande['PRENOM'];
			$commandeRESP_COM_ID = $Donneescommande['RESP_COM_ID'];
			$commandeRESP_TECH_ID = $Donneescommande['RESP_TECH_ID'];
			$commandeCONDI_REG_ID = $Donneescommande['COND_REG_CLIENT_ID'];
			$commandeMODE_REG_ID = $Donneescommande['MODE_REG_CLIENT_ID'];
			$commandeEcheancier_ID = $Donneescommande['ECHEANCIER_ID'];
			$commandeTransport_ID = $Donneescommande['TRANSPORT_ID'];
			
			$commandeCODE = $Donneescommande['CODE'];
			$commandeINDICE = $Donneescommande['INDICE'];
			$commandeLABEL = $Donneescommande['LABEL'];
			$commandeLABEL_INDICE = $Donneescommande['LABEL_INDICE'];
			
			$commandeDATE = $Donneescommande['DATE'];
			$commandeETAT = $Donneescommande['ETAT'];
			$commandeREFERENCE = $Donneescommande['REFERENCE'];
			
			$req = $bdd -> query('SELECT '. TABLE_ERP_EMPLOYEES .'.idUSER,
									'. TABLE_ERP_EMPLOYEES .'.NOM,
									'. TABLE_ERP_EMPLOYEES .'.PRENOM,
									'. TABLE_ERP_RIGHTS .'.RIGHT_NAME
									FROM `'. TABLE_ERP_EMPLOYEES .'` 
									LEFT JOIN `'. TABLE_ERP_RIGHTS .'` ON `'. TABLE_ERP_EMPLOYEES .'`.`FONCTION` = `'. TABLE_ERP_RIGHTS .'`.`id`');
									
			 $EmployeeListe1 .=  '<option value="null" '. selected($commandeRESP_COM_ID, 0) .'>Aucun</option>';
			 $EmployeeListe2 .=  '<option value="null" '. selected($commandeRESP_TECH_ID, 0) .'>Aucun</option>';
			
			while ($donnees_membre = $req->fetch())
			{
				 $EmployeeListe1 .=  '<option value="'. $donnees_membre['idUSER'] .'" '. selected($commandeRESP_COM_ID, $donnees_membre['idUSER']) .'>'. $donnees_membre['NOM'] .' '. $donnees_membre['PRENOM'] .' - '. $donnees_membre['RIGHT_NAME'] .'</option>';
				 $EmployeeListe2 .=  '<option value="'. $donnees_membre['idUSER'] .'" '. selected($commandeRESP_TECH_ID, $donnees_membre['idUSER']) .'>'. $donnees_membre['NOM'] .' '. $donnees_membre['PRENOM'] .' - '. $donnees_membre['RIGHT_NAME'] .'</option>';
			}
			$req->closeCursor();
			
			$req = $bdd -> query('SELECT Id, LABEL FROM '. TABLE_ERP_MODE_REG .'');
			while ($DonneesModeReg = $req->fetch())
			{
				$RegListe1 .='<option value="'. $DonneesModeReg['Id'] .'" '. selected($commandeCONDI_REG_ID, $DonneesModeReg['Id']) .'>'. $DonneesModeReg['LABEL'] .'</option>';
			}
			$req->closeCursor();
			
			$req = $bdd -> query('SELECT Id, LABEL FROM '. TABLE_ERP_CONDI_REG .'');
			while ($DonneesConditionReg = $req->fetch())
			{
				$CondiListe1 .='<option value="'. $DonneesConditionReg['Id'] .'" '. selected($commandeMODE_REG_ID, $DonneesConditionReg['Id']) .'>'. $DonneesConditionReg['LABEL'] .'</option>';
			}
			$req->closeCursor();
			
			$req = $bdd -> query('SELECT Id, LABEL FROM '. TABLE_ERP_ECHEANCIER_TYPE .'');
			while ($DonneesEcheancier = $req->fetch())
			{
				$EcheancierListe1 .='<option value="'. $DonneesEcheancier['Id'] .'" '. selected($commandeEcheancier_ID, $DonneesEcheancier['Id']) .'>'. $DonneesEcheancier['LABEL'] .'</option>';
			}
			$req->closeCursor();
			
			$req = $bdd -> query('SELECT Id, LABEL FROM '. TABLE_ERP_TRANSPORT .'');
			while ($DonneesTransport = $req->fetch())
			{
				$TransportListe1 .='<option value="'. $DonneesTransport['Id'] .'" '. selected($commandeTransport_ID, $DonneesTransport['Id']) .'>'. $DonneesTransport['LABEL'] .'</option>';
			}
			$req->closeCursor();
			
			$ContactcommandeListe1 =  '<option value="null" '. selected($commandeCONTACT_ID, 0) .'>Aucun</option>';
			$req = $bdd -> query('SELECT Id, PRENOM, NOM FROM '. TABLE_ERP_CONTACT .' WHERE ID_COMPANY=\''. $commandeCLIENT_ID.'\'');
			while ($DonneesContact = $req->fetch())
			{
				$ContactcommandeListe1 .='<option value="'. $DonneesContact['Id'] .'" '. selected($commandeCONTACT_ID, $DonneesContact['Id']) .'>'. $DonneesContact['PRENOM'] .' '. $DonneesContact['NOM'] .'</option>';
			}
			$req->closeCursor();
			
			$AdresseLivraisonListe1 =  '<option value="null" '. selected($commandeADRESSE_ID, 0) .'>Aucune</option>';
			$req = $bdd -> query('SELECT id, LABEL, ADRESSE, CITY FROM '. TABLE_ERP_ADRESSE .' WHERE ID_COMPANY=\''. $commandeCLIENT_ID.'\' AND ADRESS_LIV=\'1\'');
			while ($DonneesAdresse = $req->fetch())
			{
				$AdresseLivraisonListe1 .='<option value="'. $DonneesAdresse['id'] .'" '. selected($commandeADRESSE_ID, $DonneesAdresse['id']) .'>'. $DonneesAdresse['LABEL'] .' - '. $DonneesAdresse['ADRESSE'] .' - '. $DonneesAdresse['CITY'] .' </option>';
			}
			$req->closeCursor();
			
			$AdresseFacturationListe1 =  '<option value="null" '. selected($commandeFACTURATION_ID, 0) .'>Aucune</option>';
			$req = $bdd -> query('SELECT id, LABEL, ADRESSE, CITY FROM '. TABLE_ERP_ADRESSE .' WHERE ID_COMPANY=\''. $commandeCLIENT_ID.'\' AND ADRESS_FAC=\'1\' ');
			while ($DonneesAdresse = $req->fetch())
			{
				$AdresseFacturationListe1 .='<option value="'. $DonneesAdresse['id'] .'" '. selected($commandeFACTURATION_ID, $DonneesAdresse['id']) .'>'. $DonneesAdresse['LABEL'] .' - '. $DonneesAdresse['ADRESSE'] .' - '. $DonneesAdresse['CITY'] .' </option>';
			}
			$req->closeCursor();
			
			$commandeAcceuil = 
				'<table class="content-table">
					<thead>
						<tr>
							<th colspan="5">
								Modification / Consultation - commandes '. $commandeCODE .' version  '. $commandeINDICE .'
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<input type="hidden" name="Idcommande" value="'. $IDcommandeSQL .'">
								<input type="hidden" name="CODEcommande" value="'. $CODEcommande .'">
								Code et libellé de la commande:
							</td>
							<td>
								'. $commandeCODE .' 
							</td>
							<td>
								<input type="text" name="commandeLABEL" value="'. $commandeLABEL .'" placeholder="Libellé de la commande">
							</td>
						</tr>
						<tr>
							<td>
								Indice et libellé de version  :
							</td>
							<td>
								'. $commandeINDICE .' 
							</td>
							<td>
								<input type="text" name="commandeLABELIndice" value="'. $commandeLABEL_INDICE .'" placeholder="Libellé de la version">
							</td>
						</tr>
						<tr>
							<td>
								Référence client  :
							</td>
							<td>
								<input type="text" name="commandeReference" value="'. $commandeREFERENCE .'" placeholder="Référence demande client" >
							</td>
							<td></td>
						</tr>
						<tr>
							<td>
								Date de création :
							</td>
							<td>
								'. $commandeDATE .'
							</td>
							<td></td>
						</tr>
						<tr>
							<td>
								Etat de la commande : 
							</td>
							<td>
								<select name="Etatcommande">
									<option value="1" '. selected($commandeETAT, 1) .'>En cours</option>
									<option value="2" '. selected($commandeETAT, 2) .'>Refusé</option>
									<option value="3" '. selected($commandeETAT, 3) .'>Envoyé</option>
									<option value="4" '. selected($commandeETAT, 4) .'>Décliné</option>
									<option value="5" '. selected($commandeETAT, 5) .'>Fermé</option>
									<option value="6" '. selected($commandeETAT, 6) .'>Obselète</option>
								</select>
							</td>
							<td><input type="checkbox" id="commandeMajLigne" name="commandeMajLigne" checked="checked"><label >Mettre à jours les lignes de la commande</label></td>
						</tr>
						<tr>
							<td colspan="3" >
								<br/>
								<input type="submit" class="input-moyen" value="Mettre à jours" /> <br/>
								<br/>
							</td>
						</tr>
					</tbody>
				</table>';
				
			$commandeGeneral = '
			<table class="content-table" style="width: 50%;">
				<thead>
					<tr>
						<th colspan="2" >
							Général - commande '. $commandeCODE .' version  '. $commandeINDICE .'
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<input type="hidden" name="CODEcommande" value="'. $CODEcommande .'">
							Créateur :
						</td>
						<td>
							'. $Donneescommande['NOM'] .' '. $Donneescommande['PRENOM'] .'
						</td>
					</tr>
					<tr>
						<td>
							Responsable commercial :
						</td>
						<td>
							<select name="RepsComcommande">
								'.  $EmployeeListe1 .'
							</select>
						</td>
					</tr>
					<tr>
						<td>
							Responsable technique :
						</td>
						<td>
							<select name="RespTechcommande">
								'. $EmployeeListe2 .'
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2" >
							<input type="submit" class="input-moyen" value="Mettre à jour" />
						</td>
					</tr>
				</tbody>
			</table>';
			
		$commandeInfoClient = '
			<table class="content-table" style="width: 50%;">
				<thead>
					<tr>
						<th colspan="2" >
							Général - commande '. $commandeCODE .' version  '. $commandeINDICE .'
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<input type="hidden" name="CODEcommande" value="'. $CODEcommande .'">
							Contact  :
						</td>
						<td>
							<select name="Contactcommande">
								'. $ContactcommandeListe1 .'
							</select>
						</td>
					</tr>
					<tr>
						<td>
							Adresse de livraison :
						</td>
						<td>
							<select name="AdresseLivraisoncommande">
								'.  $AdresseLivraisonListe1 .'
							</select>
						</td>
					</tr>
					<tr>
						<td>
							Adresse de facturation :
						</td>
						<td>
							<select name="AdresseFacturationcommande">
								'.  $AdresseFacturationListe1 .'
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2" >
							<input type="submit" class="input-moyen" value="Mettre à jour" />
						</td>
					</tr>
				</tbody>
			</table>';
				
				
		$commandeInfoCommercial = '
			<table class="content-table" style="width: 50%;">
				<thead>
					<tr>
						<th colspan="2" >
							Général - commande '. $commandeCODE .' version  '. $commandeINDICE .'
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<input type="hidden" name="CODEcommande" value="'. $CODEcommande .'">
							Condition de réglement :
						</td>
						<td>
							<select name="CondiRegcommande">
								'. $CondiListe1 .'
							</select>
						</td>
					</tr>
					<tr>
						<td>
							Mode de réglement :
						</td>
						<td>
							<select name="ModeRegcommande">
								'.  $RegListe1 .'
							</select>
						</td>
					</tr>
					<tr>
						<td>
							Echeancier Type :
						</td>
						<td>
							<select name="Echeanciercommande">
								'.  $EcheancierListe1 .'
							</select>
						</td>
					</tr>
					<tr>
						<td>
							Mode de livraison :
						</td>
						<td>
							<select name="ModeLivraisoncommande">
								'.  $TransportListe1 .'
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2" >
							<input type="submit" class="input-moyen" value="Mettre à jour" />
						</td>
					</tr>
				</tbody>
			</table>';
				
			$commandeCommentaire = '
			<table class="content-table" style="width: 50%;">
				<thead>
					<tr>
						<th>
							Commentaire - commande '. $commandeCODE .' version  '. $commandeINDICE .'
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<input type="hidden" name="CODEcommande" value="'. $CODEcommande .'">
							<textarea class="Comment" name="Comment" rows="40" >'. $Commentairecommande .'</textarea>
						</td>
					</tr>
					<tr>
						<td>
							<input type="submit" class="input-moyen" value="Mettre à jour" />
						</td>
					</tr>
				</tbody>
			</table>';
			
						///////////////////////////////
						////DEBUT GESTION DES LIGNE DE commande  ////
						///////////////////////////////
						
									///////////////////////////////
									//// AJOUT DE LIGNE  ////
									///////////////////////////////
						
						if(isset($_POST['AddORDRELignecommande']) AND !empty($_POST['AddORDRELignecommande'])){
							
							$AddORDRELignecommande = $_POST['AddORDRELignecommande'];
							$AddARTICLELignecommande = $_POST['AddARTICLELignecommande'];
							$AddLABELLignecommande = $_POST['AddLABELLignecommande'];
							$AddQTLignecommande = $_POST['AddQTLignecommande'];
							$AddUNITLignecommande = $_POST['AddUNITLignecommande'];
							$AddPrixLignecommande = $_POST['AddPrixLignecommande'];
							$AddRemiseLignecommande = $_POST['AddRemiseLignecommande'];
							$AddTVALignecommande = $_POST['AddTVALignecommande'];
							$AddDELAISignecommande = $_POST['AddDELAISignecommande'];
							
							$i = 0;
							foreach ($AddORDRELignecommande as $id_generation) {
								
								$req = $bdd->exec("INSERT INTO ". TABLE_ERP_COMMANDE_LIGNE ." VALUE ('0',
																									'". $IDcommandeSQL ."',
																									'". addslashes($AddORDRELignecommande[$i]) ."',
																									'". addslashes($AddARTICLELignecommande[$i]) ."',
																									'". addslashes($AddLABELLignecommande[$i]) ."',
																									'". addslashes($AddQTLignecommande[$i]) ."',
																									'". addslashes($AddUNITLignecommande[$i]) ."',
																									'". addslashes($AddPrixLignecommande[$i]) ."',
																									'". addslashes($AddRemiseLignecommande[$i]) ."',
																									'". addslashes($AddTVALignecommande[$i]) ."',
																									'". addslashes($AddDELAISignecommande[$i]) ."',
																									'1')");
								$i++;
							}
						}
						
						if(isset($_POST['UpdateIdLignecommande']) AND !empty($_POST['UpdateIdLignecommande'])){
							
							$UpdateIdLignecommande = $_POST['UpdateIdLignecommande'];
							$UpdateORDRELignecommande = $_POST['UpdateORDRELignecommande'];
							$UpdateIDArticleLignecommande = $_POST['UpdateIDArticleLignecommande'];
							$UpdateLABELLignecommande = $_POST['UpdateLABELLignecommande'];
							$UpdateQTLignecommande = $_POST['UpdateQTLignecommande'];
							$UpdateUNITLignecommande = $_POST['UpdateUNITLignecommande'];
							$UpdatePrixLignecommande = $_POST['UpdatePrixLignecommande'];
							$UpdateRemiseLignecommande = $_POST['UpdateRemiseLignecommande'];
							$UpdateDELAISLignecommande = $_POST['UpdateDELAISLignecommande'];
							$UpdateTVALignecommande = $_POST['UpdateTVALignecommande'];
							$UpdateETATLignecommande = $_POST['UpdateETATLignecommande'];
							
							
							$i = 0;
							foreach ($UpdateIdLignecommande as $id_generation) {
								
								$req = $bdd->exec("UPDATE  ". TABLE_ERP_COMMANDE_LIGNE ." SET 	ORDRE='". addslashes($UpdateORDRELignecommande[$i]) ."',
																						ARTICLE_CODE='". addslashes($UpdateIDArticleLignecommande[$i]) ."',
																						LABEL='". addslashes($UpdateLABELLignecommande[$i]) ."',
																						QT='". addslashes($UpdateQTLignecommande[$i]) ."',
																						UNIT_ID='". addslashes($UpdateUNITLignecommande[$i]) ."',
																						PRIX_U='". addslashes($UpdatePrixLignecommande[$i]) ."',
																						REMISE='". addslashes($UpdateRemiseLignecommande[$i]) ."',
																						TVA_ID='". addslashes($UpdateTVALignecommande[$i]) ."',
																						DELAIS='". addslashes($UpdateDELAISLignecommande[$i]) ."',
																						ETAT='". addslashes($UpdateETATLignecommande[$i]) ."'
																						WHERE id='". addslashes($id_generation)."'");
								$i++;
							}
						}
						
									///////////////////////////////
									//// LISTE DES LIGNES  ////
									///////////////////////////////
									
						$UnitListe ='<option value="0">Aucune</option>';
						$req = $bdd -> query('SELECT Id, LABEL   FROM '. TABLE_ERP_UNIT .'');
						while ($DonneesUnit = $req->fetch()){
							$UnitListe .='<option value="'. $DonneesUnit['Id'] .'" '. selected($ArticleUNIT_ID, $DonneesUnit['Id']) .'>'. $DonneesUnit['LABEL'] .'</option>';
						}
						$req->closeCursor();
						
						$ListeArticleJava  ='"';
						$req = $bdd->query("SELECT id, CODE, LABEL FROM ". TABLE_ERP_ARTICLE ." ORDER BY LABEL");
						while ($donnees_Article = $req->fetch())
						{
							$ListeArticle  .= '<option  value="'. $donnees_Article['CODE'] .'" >';
							$ListeArticleJava  .= '<option  value=\"'. $donnees_Article['CODE'] .'\" >';
						}
						$ListeArticleJava  .='"';
						$req->closeCursor();
					
						$req = $bdd -> query('SELECT Id, LABEL, TAUX FROM '. TABLE_ERP_TVA .' ORDER BY TAUX DESC');
						while ($DonneesTVA = $req->fetch())
						{
							$TVAListe .='<option value="'. $DonneesTVA['Id'] .'">'. $DonneesTVA['TAUX'] .'%</option>';
						}
						$req->closeCursor();
						
						$req = $bdd -> query('SELECT  '. TABLE_ERP_COMMANDE_LIGNE .'.Id, 
														'. TABLE_ERP_COMMANDE_LIGNE .'.ORDRE,
														'. TABLE_ERP_COMMANDE_LIGNE .'.ARTICLE_CODE,
														'. TABLE_ERP_COMMANDE_LIGNE .'.LABEL,
														'. TABLE_ERP_COMMANDE_LIGNE .'.QT,
														'. TABLE_ERP_COMMANDE_LIGNE .'.UNIT_ID,
														'. TABLE_ERP_COMMANDE_LIGNE .'.PRIX_U,
														'. TABLE_ERP_COMMANDE_LIGNE .'.REMISE,
														'. TABLE_ERP_COMMANDE_LIGNE .'.TVA_ID,
														'. TABLE_ERP_COMMANDE_LIGNE .'.DELAIS_INTERNE,
														'. TABLE_ERP_COMMANDE_LIGNE .'.DELAIS,
														'. TABLE_ERP_COMMANDE_LIGNE .'.ETAT,
														'. TABLE_ERP_TVA .'.TAUX,
														'. TABLE_ERP_TVA .'.LABEL AS LABEL_TVA,
														'. TABLE_ERP_UNIT .'.LABEL AS LABEL_UNIT
														FROM '. TABLE_ERP_COMMANDE_LIGNE .'
															LEFT JOIN `'. TABLE_ERP_TVA .'` ON `'. TABLE_ERP_COMMANDE_LIGNE .'`.`TVA_ID` = `'. TABLE_ERP_TVA .'`.`id`
															LEFT JOIN `'. TABLE_ERP_UNIT .'` ON `'. TABLE_ERP_COMMANDE_LIGNE .'`.`UNIT_ID` = `'. TABLE_ERP_UNIT .'`.`id`
															WHERE '. TABLE_ERP_COMMANDE_LIGNE .'.COMMANDE_ID = \''. $IDcommandeSQL.'\' 
														ORDER BY '. TABLE_ERP_COMMANDE_LIGNE .'.ORDRE ');
						$tableauTVA = array();
						
						while ($DonneesListeLigneDucommande = $req->fetch()){
							
							$TotalLigneHTEnCours = ($DonneesListeLigneDucommande['QT']*$DonneesListeLigneDucommande['PRIX_U'])-($DonneesListeLigneDucommande['QT']*$DonneesListeLigneDucommande['PRIX_U'])*($DonneesListeLigneDucommande['REMISE']/100); 
							$TotalLigneTVAEnCours =  $TotalLigneHTEnCours*($DonneesListeLigneDucommande['TAUX']/100) ;
							$TotalLigneTTCEnCours = $TotalLigneTVAEnCours+$TotalLigneHTEnCours;
							
							$TotalLignecommandeHT += $TotalLigneHTEnCours;
							$TotalLignecommandeTTC += $TotalLigneTVAEnCours+$TotalLigneHTEnCours;
							
							if(array_key_exists($DonneesListeLigneDucommande['TVA_ID'], $tableauTVA)){
								$tableauTVA[$DonneesListeLigneDucommande['TVA_ID']][0] += $TotalLigneHTEnCours;
								$tableauTVA[$DonneesListeLigneDucommande['TVA_ID']][2] += $TotalLigneTVAEnCours;
								$tableauTVA[$DonneesListeLigneDucommande['TVA_ID']][3] += $TotalLigneTTCEnCours;
							}
							else{
								$tableauTVA[$DonneesListeLigneDucommande['TVA_ID']] = array($TotalLigneHTEnCours, $DonneesListeLigneDucommande['TAUX'], $TotalLigneTVAEnCours, $TotalLigneTTCEnCours);
							}
							
							
							$DetailLigneDucommande .='
							<tr>
								<td><input type="hidden" name="UpdateIdLignecommande[]" id="UpdateIdLignecommande" value="'. $DonneesListeLigneDucommande['Id'] .'"><a href="commandes.php?id='. $_GET['id'] .'&amp;delete='. $DonneesListeLigneDucommande['Id'] .'" title="Supprimer la ligne">x</a></td>
								<td><input type="number" name="UpdateORDRELignecommande[]" value="'. $DonneesListeLigneDucommande['ORDRE'] .'" id="number"></td>
								<td>
									<input list="Article" name="UpdateIDArticleLignecommande[]" id="UpdateIDArticleLignecommande" value="'. $DonneesListeLigneDucommande['ARTICLE_CODE'] .'">
									<datalist id="Article">
										'. $ListeArticle .'
									</datalist>
								</td>
								<td><input type="text"  name="UpdateLABELLignecommande[]" value="'. $DonneesListeLigneDucommande['LABEL'] .'"></td>
								<td><input type="number"  name="UpdateQTLignecommande[]" value="'. $DonneesListeLigneDucommande['QT'] .'" id="number"></td>
								<td>
									<select  name="UpdateUNITLignecommande[]">
									<option value="'. $DonneesListeLigneDucommande['UNIT_ID'] .'" '. selected($DonneesListeLigneDucommande['UNIT_ID'], $DonneesListeLigneDucommande['UNIT_ID']) .'>'. $DonneesListeLigneDucommande['LABEL_UNIT'] .'</option>
									'. $UnitListe .'
									</select>
								</td>
								<td><input type="number"  name="UpdatePrixLignecommande[]" step=".001" value="'. $DonneesListeLigneDucommande['PRIX_U'] .'" id="number"></td>
								<td><input type="number"   name="UpdateRemiseLignecommande[]" min="0" max="100" step=".001" value="'. $DonneesListeLigneDucommande['REMISE'] .'" id="number"></td>
								<td>'.   $TotalLigneHTEnCours .' €</td>

								<td>
									<select  name="UpdateTVALignecommande[]">
										<option value="'. $DonneesListeLigneDucommande['TVA_ID'] .'" selected>'. $DonneesListeLigneDucommande['TAUX'] .'%</option>
										'.  $TVAListe .'
									</select>
								</td>
								<td><input type="date" name="UpdateDELAISLignecommande[]" value="'. $DonneesListeLigneDucommande['DELAIS'] .'"></td>
								<td>
									<select  name="UpdateETATLignecommande[]">
										<option value="1" '. selected($DonneesListeLigneDucommande['ETAT'], 1) .'>En cours</option>
										<option value="2" '. selected($DonneesListeLigneDucommande['ETAT'], 2) .'>Refusé</option>
										<option value="3" '. selected($DonneesListeLigneDucommande['ETAT'], 3) .'>Envoyé</option>
										<option value="4" '. selected($DonneesListeLigneDucommande['ETAT'], 4) .'>Décliné</option>
										<option value="5" '. selected($DonneesListeLigneDucommande['ETAT'], 5) .'>Fermé</option>
										<option value="6" '. selected($DonneesListeLigneDucommande['ETAT'], 6) .'>Obselète</option>
									</select>
								</td>
							</tr>';
							
						}
					$req->closeCursor();
									
						///////////////////////////////
						//// FIN GESTION DES LIGNE DE commande   ////
						///////////////////////////////
				
				asort($tableauTVA);
				 foreach($tableauTVA as $key => $value){
					
					$DetailLigneTVA .='
						<tr>
							<th></th>
							<th></th>
							<th></th>
							<th colspan="2" >'. $tableauTVA[$key][0] . ' €</th>
							<th>'. $tableauTVA[$key][1] . ' %</th>
							<th colspan="2" >'. $tableauTVA[$key][2] . ' €</th>
							<th>'. $tableauTVA[$key][3] . ' €</th>
							<th></th>
							<th></th>
							<th></th>
						</tr>';
				}
			}

			$commandeLignes ='
			<table class="content-table-commande" style="width: 50%;">
				<thead>
					<tr>
						<th colspan="12" >
							Général - commandes '. $commandeCODE .' version  '. $commandeINDICE .'
						</th>
					</tr>
					<tr>
						<th></th>
						<th>Ordre</th>
						<th>Aricle</th>
						<th>Label</th>
						<th>Qt</th>
						<th>Unité</th>
						<th>Prix U.H.T (€)</th>
						<th>Remise %</th>
						<th>Total</th>
						<th>T.V.A.</th>
						<th>Délais</th>
						<th>Etat</th>
					</tr>
				</thead>
				<tbody>
					'. $DetailLigneDucommande .'
					<tr>
						<th></th>
						<th></th>
						<th></th>
						<th colspan="2" >Montant H.T.</th>
						<th >T.V.A.</th>
						<th colspan="2" >Valeur de la T.V.A</th>
						<th>Montant T.T.C</th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
						'.  $DetailLigneTVA .'
					<tr>
						<th></th>
						<th></th>
						<th  >Total H.T. :</th>
						<th colspan="2">'. $TotalLignecommandeHT .' €</th>
						<th ></th>
						<th colspan="2" >Total T.T.C. :</th>
						<th>'. $TotalLignecommandeTTC .' €</th>
						<th></th>
						<th></th>
						<th></th>
					<tr>
					</tr>
						<th colspan="12" >
							Ajouts de ligne
						</th>
					</tr>
					<tr>
						<td></td>
						<td><input type="number" name="" id="AddORDRELignecommande" placeholder="10"  value="10"></td>
						<td>
							<input list="Article" name="AddARTICLELignecommande" id="AddARTICLELignecommande">
							<datalist id="Article">
								'. $ListeArticle .'
							</datalist>
						</td>
						<td><input type="text"  name="" id="AddLABELLignecommande" placeholder="Désignation"></td>
						<td><input type="number"  name="" id="AddQTLignecommande" placeholder="1"  value="1"></td>
						<td>
							<select name="" id="AddUNITLignecommande">
							'. $UnitListe .'
							</select>
						</td>
						<td><input type="number"  name="" id="AddPrixLignecommande" step=".001" placeholder="10 €"  value="0"></td>
						<td><input type="number"  name="" id="AddRemiseLignecommande" min="0" max="100" step=".001" placeholder="0 %" value="0"></td>
						<td></td>
						<td>
							<select name="" id="AddTVALignecommande">
								'.  $TVAListe .'
							</select>
						</td>
						<td><input type="date" name="" id="AddDELAISignecommande" required="required"></td>
						<td></td>
					</tr>
					<tr>
						<td colspan="12" >
							<input type="button" class="add" value="Ajouter une ligne">
							<input type="button" class="delete" value="Supprimer une ligne">
							<input type="submit" class="input-moyen" value="Mettre à jours de la commande" />
						</td>
					</tr>
				</tbody>
			</table>';
			
		}
	
				
			$req = $bdd->query("SELECT id, CODE, NAME FROM ". TABLE_ERP_CLIENT_FOUR ." ORDER BY NAME");
			while ($donnees_ste = $req->fetch())
			{
				$ListeSte .= '<option  value="'. $donnees_ste['id'] .'" >'. $donnees_ste['NAME'] .'</option>';
			}
	
			$Acceuil = 
				'<div class="column">
					<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Chercher une commande">
					<ul id="myUL">
						'. $ListeCommandePrincipale .'
					</ul>
				</div>
				<script>
				function myFunction() {
				  // Declare variables
				  var input, filter, ul, li, a, i, txtValue;
				  input = document.getElementById(\'myInput\');
				  filter = input.value.toUpperCase();
				  ul = document.getElementById("myUL");
				  li = ul.getElementsByTagName(\'li\');

				  for (i = 0; i < li.length; i++) {
					a = li[i].getElementsByTagName("a")[0];
					txtValue = a.textContent || a.innerText;
					if (txtValue.toUpperCase().indexOf(filter) > -1) {
					  li[i].style.display = "";
					} else {
					  li[i].style.display = "none";
					}
				  }
				}
				</script>
			<div class="column">
				<form method="post" name="Commande" action="'. $actionForm .'" class="content-form" enctype="multipart/form-data" >
					<table class="content-table">
						<thead>
							<tr>
								<th colspan="5">
									  <br/>
								</th>
								
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									Créer une nouvelle commande pour le client :
								<td>
								<td>
									<select name="Addcommande">
										'. $ListeSte .'
									</select>
								<td>
							</tr>
							<tr>
								<td colspan="6" >
									<br/>
									<input type="submit" class="input-moyen" value="Nouvelle commande" /> <br/>
									<br/>
								</td>
							</tr>
						</tbody>
					</table>
				</form>
			</div>
			<div class="column">
			</div>';
			
	if(isset($_GET['delete']) AND !empty($_GET['delete'])){
		$ParDefautDiv1 = '';
		$ParDefautDiv2 = '';
		$ParDefautDiv3 = 'id="defaultOpen"';
		$ImputButton = '<input type="submit" class="input-moyen" value="Mettre à jour" />';
		$actionForm = 'commande.php?id='. $_GET['id'] .'';
		
	}
	elseif(isset($_GET['id']) AND !empty($_GET['id'])){
		$ParDefautDiv1 = '';
		$ParDefautDiv2 = 'id="defaultOpen"';
		$ParDefautDiv3 = '';
		$ImputButton = '<input type="submit" class="input-moyen" value="Mettre à jour" />';
		$actionForm = 'commande.php?id='. $_GET['id'] .'';
		
	}
	else{
		$ParDefautDiv3 = '';
		$ParDefautDiv2 = '';
		$ParDefautDiv1 = 'id="defaultOpen"';
		$VerrouInput = ' disabled="disabled"  Value="-" ';
		$ImputButton = ' Aucune commande chargée';
		$actionForm = 'commande.php';
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
<?php
	//include interface
	require_once 'include/include_header.php';

?>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $(".add").click(function() {
        var AddORDRELignecommande = $("#AddORDRELignecommande").val();
        var AddARTICLELignecommande = $("#AddARTICLELignecommande").val();
		var AddLABELLignecommande = $("#AddLABELLignecommande").val();
		var AddQTLignecommande = $("#AddQTLignecommande").val();
		var AddUNITLignecommande = $("#AddUNITLignecommande").val();
		var AddPrixLignecommande = $("#AddPrixLignecommande").val();
		var AddRemiseLignecommande = $("#AddRemiseLignecommande").val();
		var AddTVALignecommande = $("#AddTVALignecommande").val();
		var AddDELAISignecommande = $("#AddDELAISignecommande").val();
		
		var TotalPrix = (AddQTLignecommande*AddPrixLignecommande)-(AddQTLignecommande*AddPrixLignecommande)*(AddRemiseLignecommande/100);
		
		var ligne = "<tr>";
		var ligne = ligne + "<td><input type=\"checkbox\" name=\"select\"></td>";
		var ligne = ligne + "<td><input type=\"number\" name=\"AddORDRELignecommande[]\" value=\""+ AddORDRELignecommande +"\" id=\"number\" required=\"required\"></td>";
		var ligne = ligne + "<td><input list=\"Article\" name=\"AddARTICLELignecommande[]\" value=\"" + AddARTICLELignecommande +"\"><datalist id=\"Article\">";
		var ligne = ligne + <?php echo $ListeArticleJava ?>  ;
		var ligne = ligne + "</datalist></td>";
		var ligne = ligne + "<td><input type=\"text\" name=\"AddLABELLignecommande[]\" value=\""+ AddLABELLignecommande +"\" ></td>";
		var ligne = ligne + "<td><input type=\"number\" name=\"AddQTLignecommande[]\" value=\""+ AddQTLignecommande +"\"  id=\"number\" required=\"required\"></td>";
		var ligne = ligne + "<td><input type=\"hidden\" name=\"AddUNITLignecommande[]\" value=\"" + AddUNITLignecommande + "\">-</td>";
		var ligne = ligne + "<td><input type=\"number\" name=\"AddPrixLignecommande[]\" value=\""+ AddPrixLignecommande +"\"  step=\".001\" id=\"number\" required=\"required\"></td>";
		var ligne = ligne + "<td><input type=\"number\" name=\"AddRemiseLignecommande[]\" value=\""+ AddRemiseLignecommande +"\" min=\"0\" max=\"100\" step=\".001\" id=\"number\" required=\"required\"></td>";
		var ligne = ligne + "<td>"+ TotalPrix +" €</td>";
		var ligne = ligne + "<td><input type=\"hidden\" name=\"AddTVALignecommande[]\" value=\"" + AddTVALignecommande + "\">-</td>";
		var ligne = ligne + "<td><input type=\"date\" name=\"AddDELAISignecommande[]\"  value=\"" + AddDELAISignecommande+"\" required=\"required\"></td>";
		var ligne = ligne + "<td></td>";
		var ligne = ligne + "</tr>";
        $("table.content-table-commande").append(ligne);
    });
    $(".delete").click(function() {
        $("table.content-table").find('input[name="select"]').each(function() {
            if ($(this).is(":checked")) {
                $(this).parents("table.content-table tr").remove();
            }
        });
    });
});
</script>
</head>
<body>
    
<?php

	//include interface
	require_once 'include/include_interface.php';
	


?>

	<div class="tab">
		<button class="tablinks" onclick="openDiv(event, 'div1')" <?php echo $ParDefautDiv1; ?>>Accueil</button>
<?php
	if(isset($_POST['CODESte']) AND isset($_POST['NameSte']) AND !empty($_POST['CODESte']) AND !empty($_POST['NameSte']) OR  isset($_GET['id']) AND !empty($_GET['id']))
	{
?>
		<button class="tablinks" onclick="openDiv(event, 'div2')" <?php echo $ParDefautDiv2; ?>>Commande</button>
		<button class="tablinks" onclick="openDiv(event, 'div3')" <?php echo $ParDefautDiv3; ?>>Détail de la commande</button>
		<button class="tablinks" onclick="openDiv(event, 'div4')">Général</button>
		<button class="tablinks" onclick="openDiv(event, 'div5')">Détail client</button>
		<button class="tablinks" onclick="openDiv(event, 'div6')">Détail commerciales</button>
		<button class="tablinks" onclick="openDiv(event, 'div7')">Commentaire</button>
		<a href="document.php?id=<?php echo  $_GET['id'] ?>" target="_blank"><button class="tablinks" >Document</button></a>

<?php
	}
?>
		<div class="DataListDroite">
			<form method="get" name="commande" action="<?php echo $actionForm; ?>">  
				Commande : <input list="commande" name="id" id="id" required>
				<datalist id="commande">
					<?php echo $ListeCommande; ?>
				</datalist>
				<input type="submit" class="input-moyen" value="Go !" />
			</form>
		</div>
	</div>
	<div id="div1" class="tabcontent">
			<?php echo $Acceuil; ?>
	</div>	
	<div id="div2" class="tabcontent">
		<form method="post" name="Coment" action="<?php echo $actionForm; ?>" class="content-form" >
			<?php echo $commandeAcceuil; ?>
		</form>
	</div>
	<div id="div3" class="tabcontent">
		<form method="post" name="Coment" action="<?php echo $actionForm; ?>" class="content-form" >
			<?php echo $commandeLignes ?>
		</form>
	</div>
	<div id="div4" class="tabcontent">
		<form method="post" name="Coment" action="<?php echo $actionForm; ?>" class="content-form" >
			<?php echo $commandeGeneral; ?>
		</form>
	</div>	
	<div id="div5" class="tabcontent">
		<form method="post" name="Coment" action="<?php echo $actionForm; ?>" class="content-form" >
			<?php echo $commandeInfoClient; ?>
		</form>
	</div>	
	<div id="div6" class="tabcontent">
		<form method="post" name="Coment" action="<?php echo $actionForm; ?>" class="content-form" >
			<?php echo $commandeInfoCommercial; ?>
		</form>
	</div>	
	<div id="div7" class="tabcontent">
		<form method="post" name="Coment" action="<?php echo $actionForm; ?>" class="content-form" >
			<?php echo $commandeCommentaire; ?>
		</form>
	</div>	
</body>
</html>