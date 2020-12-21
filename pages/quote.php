<?php 
	//phpinfo();
	use \App\Autoloader;
	use \App\SQL;
	use \App\Language;
	use \App\COMPANY\Company;
	use \App\COMPANY\CompanyManager;
	use \App\CallOutBox;

	// include for the constants
	require_once '../include/include_recup_config.php';
	//auto load class
	require_once '../app/Autoload.class.php';
	Autoloader::register();

	session_start();
	header( 'content-type: text/html; charset=utf-8' );

	//open sql connexion
	$bdd = SQL::getInstance();
	//load company vairiable
	$CompanyManager = new CompanyManager($bdd);
	$donneesCompany = $CompanyManager->getDb();
	$Company = new Company($donneesCompany);
	// include for functions
	require_once '../include/include_fonctions.php';
	//session checking  user
	require_once '../include/include_checking_session.php';
	//init xml for user language
	$langue = new Language('lang', 'quote', $UserLanguage);
	//init call out box for notification
	$CallOutBox = new CallOutBox();

	//Check if the user is authorized to view the page
	if($_SESSION['page_5'] != '1'){
		stop($langue->show_text('SystemInfoAccessDenied'), 161, 'index.php?page=login');
	}

	///////////////////////////////
	//// COMMMENT ////
	///////////////////////////////
	if(isset($_POST['Comment']) AND !empty($_POST['Comment'])){

		$req = $bdd->exec("UPDATE  ". TABLE_ERP_DEVIS ." SET 	COMENT='". addslashes($_POST['Comment']) ."'
																		WHERE CODE='". addslashes($_POST['CODEDevis'])."'");
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateCommentNotification')));
	}

	///////////////////////////////
	//// GENERAL UPDATE ////
	///////////////////////////////
	if(isset($_POST['RepsComDevis']) AND !empty($_POST['RepsComDevis'])){
		$PostRepsComDevis= $_POST['RepsComDevis'];
		$PostRespTechDevis = $_POST['RespTechDevis'];

		if($_POST['RepsComDevis'] == 'null'){ $PostRepsComDevis = 0; }
		if($_POST['RespTechDevis'] == 'null'){ $PostRespTechDevis = 0; }

		$req = $bdd->exec("UPDATE  ". TABLE_ERP_DEVIS ." SET 	RESP_COM_ID='". addslashes($PostRepsComDevis) ."',
																RESP_TECH_ID='". addslashes($PostRespTechDevis) ."'
																		WHERE CODE='". addslashes($_POST['CODEDevis'])."'");
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateGeneralNotification')));
	}

	///////////////////////////////
	//// COMMERCIAL UPDATE ////
	///////////////////////////////
	if(isset($_POST['CondiRegDevis']) AND !empty($_POST['CondiRegDevis'])){
		$PostCondiRegDevis= $_POST['CondiRegDevis'];
		$PostModeRegDevis = $_POST['ModeRegDevis'];
		$PostEcheancierDevis = $_POST['EcheancierDevis'];
		$PostModeLivraisonDevis = $_POST['ModeLivraisonDevis'];

		$req = $bdd->exec("UPDATE  ". TABLE_ERP_DEVIS ." SET 	COND_REG_CLIENT_ID='". addslashes($PostCondiRegDevis) ."',
																MODE_REG_CLIENT_ID='". addslashes($PostModeRegDevis) ."',
																ECHEANCIER_ID='". addslashes($PostEcheancierDevis) ."',
																TRANSPORT_ID='". addslashes($PostModeLivraisonDevis) ."'
															WHERE CODE='". addslashes($_POST['CODEDevis'])."'");
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateSalesInfoNotification')));
	}

	///////////////////////////////
	//// CLIENT INFO UPDATE ////
	///////////////////////////////
	if(isset($_POST['ContactDevis']) AND !empty($_POST['ContactDevis'])){
		$PostContactDevis= $_POST['ContactDevis'];
		$PostAdresseLivraisonDevis = $_POST['AdresseLivraisonDevis'];
		$PostAdresseFacturationDevis = $_POST['AdresseFacturationDevis'];

		if($_POST['ContactDevis'] == 'null'){ $PostContactDevis = 0; }
		if($_POST['AdresseLivraisonDevis'] == 'null'){ $PostAdresseLivraisonDevis = 0; }
		if($_POST['AdresseFacturationDevis'] == 'null'){ $PostAdresseFacturationDevis = 0; }

		$req = $bdd->exec("UPDATE  ". TABLE_ERP_DEVIS ." SET 	CONTACT_ID='". addslashes($PostContactDevis) ."',
																ADRESSE_ID='". addslashes($PostAdresseLivraisonDevis) ."',
																FACTURATION_ID='". addslashes($PostAdresseFacturationDevis) ."'
															WHERE CODE='". addslashes($_POST['CODEDevis'])."'");
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateInfoCustomerNotification')));
	}

	///////////////////////////////
	//// DELETE LIGNE ////
	///////////////////////////////
	if(isset($_GET['delete']) AND !empty($_GET['delete'])){

		$req = $bdd->exec("DELETE FROM ". TABLE_ERP_DEVIS_LIGNE ." WHERE id='". addslashes($_GET['delete'])."'");
		$CallOutBox->add_notification(array('4', $i . $langue->show_text('DeleteQuoteLineNotification')));
	}

	///////////////////////////////
	//// ACCEUIL DEVIS  ////
	///////////////////////////////
	if(isset($_POST['DevisDATE_VALIDITE']) AND !empty($_POST['DevisDATE_VALIDITE'])){


		$PostDevisLABEL= $_POST['DevisLABEL'];
		$PostDevisLABELIndice = $_POST['DevisLABELIndice'];
		$PostDevisReference = $_POST['DevisReference'];
		$PostDevisDATE_VALIDITE = $_POST['DevisDATE_VALIDITE'];
		$PostDevisEtat = $_POST['EtatDevis'];

		$req = $bdd->exec("UPDATE  ". TABLE_ERP_DEVIS ." SET 	LABEL='". addslashes($PostDevisLABEL) ."',
																LABEL_INDICE='". addslashes($PostDevisLABELIndice) ."',
																REFERENCE='". addslashes($PostDevisReference) ."',
																DATE_VALIDITE='". addslashes($PostDevisDATE_VALIDITE) ."',
																ETAT='". addslashes($PostDevisEtat) ."'
															WHERE CODE='". addslashes($_POST['CODEDevis'])."'");
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateGeneralInfoNotification')));

		if(isset($_POST['DevisMajLigne']) AND !empty($_POST['DevisMajLigne'])){

			$req = $bdd->exec("UPDATE  ". TABLE_ERP_DEVIS_LIGNE ." SET 	ETAT='". addslashes($PostDevisEtat) ."'
															WHERE 	DEVIS_ID='". addslashes($_POST['IdDevis'])."'");
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateStatuLineNotification')));
		}
	}

	//If user create new quote
	if(isset($_POST['AddDevis']) And !empty($_POST['AddDevis'])){

		//we find num sequence for number quoting
		$req = $bdd -> query('SELECT '. TABLE_ERP_NUM_DOC .'.Id,
									'. TABLE_ERP_NUM_DOC .'.DOC_TYPE,
									'. TABLE_ERP_NUM_DOC .'.MODEL,
									'. TABLE_ERP_NUM_DOC .'.DIGIT,
									'. TABLE_ERP_NUM_DOC .'.COMPTEUR
									FROM `'. TABLE_ERP_NUM_DOC .'`
									WHERE DOC_TYPE=8');
		$donnees_Num_doc = $req->fetch();

		//make num sequence
		$CODE = NumDoc($donnees_Num_doc['MODEL'],$donnees_Num_doc['COMPTEUR'], $donnees_Num_doc['DIGIT']);

		//insert in DB new quote
		$req = $bdd->exec("INSERT INTO ". TABLE_ERP_DEVIS ." VALUE ('0',
																				'". $CODE ."',
																				'1',
																				'',
																				'',
																				'". addslashes($_POST['AddDevis']) ."',
																				'0',
																				'0',
																				'0',
																				NOW(),
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
		$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddQuoteNotification')));
		//update increment in num sequence db
		$bdd->exec('UPDATE `'. TABLE_ERP_NUM_DOC .'` SET  COMPTEUR = COMPTEUR + 1 WHERE DOC_TYPE IN (8)');

		//select last id add in db
		$req = $bdd->query("SELECT CODE FROM ". TABLE_ERP_DEVIS ." ORDER BY id DESC LIMIT 0, 1");
		$DonneesDevis = $req->fetch();
		$req->closeCursor();
		$CODEDevisAjout = $DonneesDevis['CODE'];

	}

	//make list quote for display an other quote
	$req = $bdd->query('SELECT '. TABLE_ERP_DEVIS .'.CODE,
								'. TABLE_ERP_DEVIS .'.LABEL,
								'. TABLE_ERP_CLIENT_FOUR .'.NAME
								FROM '. TABLE_ERP_DEVIS .'
									LEFT JOIN `'. TABLE_ERP_CLIENT_FOUR .'` ON `'. TABLE_ERP_DEVIS .'`.`CLIENT_ID` = `'. TABLE_ERP_CLIENT_FOUR .'`.`id`
								ORDER BY  '. TABLE_ERP_DEVIS .'.id DESC');
	while ($donnees_Devis = $req->fetch())
	{
		$ListeQuote .= '<option  value="'. $donnees_Devis['CODE'] .'" >';
		$ListeQuotePrincipale  .= '<li><a href="index.php?page=quote&id='. $donnees_Devis['CODE'] .'">'. $donnees_Devis['CODE'] .' - '. $donnees_Devis['NAME'] .' </a></li>';
	}


	//If user want display an quote we check id isset GET or POST
	if(isset($_GET['id']) And !empty($_GET['id']) Or isset($_POST['AddDevis']) And !empty($_POST['AddDevis'])){

		//Initialise CODE quote for SQL requête
		if(isset($_GET['id'])){$CODEDevis = addslashes($_GET['id']);}
		if(isset($_POST['AddDevis']) And !empty($_POST['AddDevis'])){$CODEDevis = $CODEDevisAjout;}

		//we check if quote was in DB
		$req = $bdd->query("SELECT COUNT(id) as nb FROM ". TABLE_ERP_DEVIS ." WHERE CODE = '". $CODEDevis."'");
		$data = $req->fetch();
		$req->closeCursor();
		$nb = $data['nb'];

		//if ok
		if($nb=1){

				//Load data
				$req = $bdd -> query('SELECT '. TABLE_ERP_DEVIS .'.Id,
									'. TABLE_ERP_DEVIS .'.CODE,
									'. TABLE_ERP_DEVIS .'.INDICE,
									'. TABLE_ERP_DEVIS .'.LABEL,
									'. TABLE_ERP_DEVIS .'.LABEL_INDICE,
									'. TABLE_ERP_DEVIS .'.CLIENT_ID,
									'. TABLE_ERP_DEVIS .'.CONTACT_ID,
									'. TABLE_ERP_DEVIS .'.ADRESSE_ID,
									'. TABLE_ERP_DEVIS .'.FACTURATION_ID,
									'. TABLE_ERP_DEVIS .'.DATE,
									'. TABLE_ERP_DEVIS .'.DATE_VALIDITE,
									'. TABLE_ERP_DEVIS .'.ETAT,
									'. TABLE_ERP_DEVIS .'.CREATEUR_ID,
									'. TABLE_ERP_DEVIS .'.RESP_COM_ID,
									'. TABLE_ERP_DEVIS .'.RESP_TECH_ID,
									'. TABLE_ERP_DEVIS .'.REFERENCE,
									'. TABLE_ERP_DEVIS .'.COND_REG_CLIENT_ID,
									'. TABLE_ERP_DEVIS .'.MODE_REG_CLIENT_ID,
									'. TABLE_ERP_DEVIS .'.ECHEANCIER_ID,
									'. TABLE_ERP_DEVIS .'.TRANSPORT_ID,
									'. TABLE_ERP_DEVIS .'.COMENT,
									'. TABLE_ERP_CLIENT_FOUR .'.NAME,
									'. TABLE_ERP_EMPLOYEES .'.NOM,
									'. TABLE_ERP_EMPLOYEES .'.PRENOM
									FROM `'. TABLE_ERP_DEVIS .'`
										LEFT JOIN `'. TABLE_ERP_CLIENT_FOUR .'` ON `'. TABLE_ERP_DEVIS .'`.`CLIENT_ID` = `'. TABLE_ERP_CLIENT_FOUR .'`.`id`
										LEFT JOIN `'. TABLE_ERP_EMPLOYEES .'` ON `'. TABLE_ERP_DEVIS .'`.`CREATEUR_ID` = `'. TABLE_ERP_EMPLOYEES .'`.`idUSER`
									WHERE '. TABLE_ERP_DEVIS .'.CODE = \''. $CODEDevis.'\' ');
			$DonneesDevis = $req->fetch();
			$req->closeCursor();

			$titleOnglet1 = $langue->show_text('TableUpdateButton');

			$IDDevisSQL = $DonneesDevis['Id'];
			$CommentaireDevis = $DonneesDevis['COMENT'];
			$DevisCLIENT_ID = $DonneesDevis['CLIENT_ID'];
			$DevisCONTACT_ID = $DonneesDevis['CONTACT_ID'];
			$DevisCLIENT_NAME = $DonneesDevis['NAME'];
			$DevisADRESSE_ID = $DonneesDevis['ADRESSE_ID'];
			$DevisFACTURATION_ID = $DonneesDevis['FACTURATION_ID'];
			$DevisNomName = $DonneesDevis['NOM'];
			$DevisNomPrenom = $DonneesDevis['PRENOM'];
			$DevisRESP_COM_ID = $DonneesDevis['RESP_COM_ID'];
			$DevisRESP_TECH_ID = $DonneesDevis['RESP_TECH_ID'];
			$DevisCONDI_REG_ID = $DonneesDevis['COND_REG_CLIENT_ID'];
			$DevisMODE_REG_ID = $DonneesDevis['MODE_REG_CLIENT_ID'];
			$DevisEcheancier_ID = $DonneesDevis['ECHEANCIER_ID'];
			$DevisTransport_ID = $DonneesDevis['TRANSPORT_ID'];

			$DevisCODE = $DonneesDevis['CODE'];
			$DevisINDICE = $DonneesDevis['INDICE'];
			$DevisLABEL = $DonneesDevis['LABEL'];
			$DevisLABEL_INDICE = $DonneesDevis['LABEL_INDICE'];

			$DevisDATE = $DonneesDevis['DATE'];
			$DevisDATE_VALIDITE = $DonneesDevis['DATE_VALIDITE'];
			$DevisETAT = $DonneesDevis['ETAT'];
			$DevisREFERENCE = $DonneesDevis['REFERENCE'];

			//create liste employees
			$req = $bdd -> query('SELECT '. TABLE_ERP_EMPLOYEES .'.idUSER,
									'. TABLE_ERP_EMPLOYEES .'.NOM,
									'. TABLE_ERP_EMPLOYEES .'.PRENOM,
									'. TABLE_ERP_RIGHTS .'.RIGHT_NAME
									FROM `'. TABLE_ERP_EMPLOYEES .'`
									LEFT JOIN `'. TABLE_ERP_RIGHTS .'` ON `'. TABLE_ERP_EMPLOYEES .'`.`FONCTION` = `'. TABLE_ERP_RIGHTS .'`.`id`');

			 $EmployeeListe1 .=  '<option value="null" '. selected($DevisRESP_COM_ID, 0) .'>Aucun</option>';
			 $EmployeeListe2 .=  '<option value="null" '. selected($DevisRESP_TECH_ID, 0) .'>Aucun</option>';

			while ($donnees_membre = $req->fetch())
			{
				 $EmployeeListe1 .=  '<option value="'. $donnees_membre['idUSER'] .'" '. selected($DevisRESP_COM_ID, $donnees_membre['idUSER']) .'>'. $donnees_membre['NOM'] .' '. $donnees_membre['PRENOM'] .' - '. $donnees_membre['RIGHT_NAME'] .'</option>';
				 $EmployeeListe2 .=  '<option value="'. $donnees_membre['idUSER'] .'" '. selected($DevisRESP_TECH_ID, $donnees_membre['idUSER']) .'>'. $donnees_membre['NOM'] .' '. $donnees_membre['PRENOM'] .' - '. $donnees_membre['RIGHT_NAME'] .'</option>';
			}
			$req->closeCursor();

			//create list mode payment
			$req = $bdd -> query('SELECT Id, LABEL FROM '. TABLE_ERP_MODE_REG .'');
			while ($DonneesModeReg = $req->fetch())
			{
				$RegListe1 .='<option value="'. $DonneesModeReg['Id'] .'" '. selected($DevisCONDI_REG_ID, $DonneesModeReg['Id']) .'>'. $DonneesModeReg['LABEL'] .'</option>';
			}
			$req->closeCursor();

			//Create list condition payment
			$req = $bdd -> query('SELECT Id, LABEL FROM '. TABLE_ERP_CONDI_REG .'');
			while ($DonneesConditionReg = $req->fetch())
			{
				$CondiListe1 .='<option value="'. $DonneesConditionReg['Id'] .'" '. selected($DevisMODE_REG_ID, $DonneesConditionReg['Id']) .'>'. $DonneesConditionReg['LABEL'] .'</option>';
			}
			$req->closeCursor();

			//deadline payment list
			$req = $bdd -> query('SELECT Id, LABEL FROM '. TABLE_ERP_ECHEANCIER_TYPE .'');
			while ($DonneesEcheancier = $req->fetch())
			{
				$EcheancierListe1 .='<option value="'. $DonneesEcheancier['Id'] .'" '. selected($DevisEcheancier_ID, $DonneesEcheancier['Id']) .'>'. $DonneesEcheancier['LABEL'] .'</option>';
			}
			$req->closeCursor();

			//List transport
			$req = $bdd -> query('SELECT Id, LABEL FROM '. TABLE_ERP_TRANSPORT .'');
			while ($DonneesTransport = $req->fetch())
			{
				$TransportListe1 .='<option value="'. $DonneesTransport['Id'] .'" '. selected($DevisTransport_ID, $DonneesTransport['Id']) .'>'. $DonneesTransport['LABEL'] .'</option>';
			}
			$req->closeCursor();

			//Contact quote list from company
			$ContactDevisListe1 =  '<option value="null" '. selected($DevisCONTACT_ID, 0) .'>Aucun</option>';
			$req = $bdd -> query('SELECT Id, PRENOM, NOM FROM '. TABLE_ERP_CONTACT .' WHERE ID_COMPANY=\''. $DevisCLIENT_ID.'\'');
			while ($DonneesContact = $req->fetch())
			{
				$ContactDevisListe1 .='<option value="'. $DonneesContact['Id'] .'" '. selected($DevisCONTACT_ID, $DonneesContact['Id']) .'>'. $DonneesContact['PRENOM'] .' '. $DonneesContact['NOM'] .'</option>';
			}
			$req->closeCursor();

			//delevery adress list
			$AdresseLivraisonListe1 =  '<option value="null" '. selected($DevisADRESSE_ID, 0) .'>Aucune</option>';
			$req = $bdd -> query('SELECT id, LABEL, ADRESSE, CITY FROM '. TABLE_ERP_ADRESSE .' WHERE ID_COMPANY=\''. $DevisCLIENT_ID.'\' AND ADRESS_LIV=\'1\'');
			while ($DonneesAdresse = $req->fetch())
			{
				$AdresseLivraisonListe1 .='<option value="'. $DonneesAdresse['id'] .'" '. selected($DevisADRESSE_ID, $DonneesAdresse['id']) .'>'. $DonneesAdresse['LABEL'] .' - '. $DonneesAdresse['ADRESSE'] .' - '. $DonneesAdresse['CITY'] .' </option>';
			}
			$req->closeCursor();
			
			//Billing adress list
			$AdresseFacturationListe1 =  '<option value="null" '. selected($DevisFACTURATION_ID, 0) .'>Aucune</option>';
			$req = $bdd -> query('SELECT id, LABEL, ADRESSE, CITY FROM '. TABLE_ERP_ADRESSE .' WHERE ID_COMPANY=\''. $DevisCLIENT_ID.'\' AND ADRESS_FAC=\'1\' ');
			while ($DonneesAdresse = $req->fetch())
			{
				$AdresseFacturationListe1 .='<option value="'. $DonneesAdresse['id'] .'" '. selected($DevisFACTURATION_ID, $DonneesAdresse['id']) .'>'. $DonneesAdresse['LABEL'] .' - '. $DonneesAdresse['ADRESSE'] .' - '. $DonneesAdresse['CITY'] .' </option>';
			}
			$req->closeCursor();

			//HTML section
			$DevisAcceuil =
				'<table class="content-table">
					<thead>
						<tr>
							<th colspan="5">
							'. $langue->show_text('TableNumberQuote') .' '. $DevisCODE .' '. $langue->show_text('TableIndexQuote') .'  '. $DevisINDICE .'
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<input type="hidden" name="IdDevis" value="'. $IDDevisSQL .'">
								<input type="hidden" name="CODEDevis" value="'. $CODEDevis .'">
								'. $langue->show_text('TableCodeLabel') .'
							</td>
							<td>
								'. $DevisCODE .'
							</td>
							<td>
								<input type="text" name="DevisLABEL" value="'. $DevisLABEL .'" placeholder="'. $langue->show_text('TableLabelquote') .'">
							</td>
						</tr>
						<tr>
							<td>
								'. $langue->show_text('TableIndexLabel') .'
							</td>
							<td>
								'. $DevisINDICE .'
							</td>
							<td>
								<input type="text" name="DevisLABELIndice" value="'. $DevisLABEL_INDICE .'" placeholder="'. $langue->show_text('TableLabelIndexquote') .'">
							</td>
						</tr>
						<tr>
							<td>
								'. $langue->show_text('TableCustomerReference') .'
							</td>
							<td>
								<input type="text" name="DevisReference" value="'. $DevisREFERENCE .'" placeholder="'. $langue->show_text('TableCustomerReference') .'" >
							</td>
							<td></td>
						</tr>
						<tr>
							<td>
								'. $langue->show_text('TableCreationDate') .'
							</td>
							<td>
								'. $DevisDATE .'
							</td>
							<td></td>
						</tr>
						<tr>
							<td>
								'. $langue->show_text('TableValidityDate') .'	
							</td>
							<td>
								<input type="date" name="DevisDATE_VALIDITE" value="'. $DevisDATE_VALIDITE .'" >
							</td>
							<td></td>
						</tr>
						<tr>
							<td>
								'. $langue->show_text('TableQuoteStatu') .'
							</td>
							<td>
								<select name="EtatDevis">
									<option value="1" '. selected($DevisETAT, 1) .'>'. $langue->show_text('SelectOpen') .'</option>
									<option value="2" '. selected($DevisETAT, 2) .'>'. $langue->show_text('SelectRefuse') .'</option>
									<option value="3" '. selected($DevisETAT, 3) .'>'. $langue->show_text('SelectSend') .'</option>
									<option value="4" '. selected($DevisETAT, 4) .'>'. $langue->show_text('SelectDecline') .'</option>
									<option value="5" '. selected($DevisETAT, 5) .'>'. $langue->show_text('SelectClosed') .'</option>
									<option value="6" '. selected($DevisETAT, 6) .'>'. $langue->show_text('SelectObsolete') .'</option>
								</select>
							</td>
							<td><input type="checkbox" id="DevisMajLigne" name="DevisMajLigne" checked="checked"><label >'. $langue->show_text('UpdateQuoteLine') .'</label></td>
						</tr>
						<tr>
							<td colspan="3" >
								<br/>
								<input type="submit" class="input-moyen" value="'. $langue->show_text('TableUpdateButton') .'" /> <br/>
								<br/>
							</td>
						</tr>
					</tbody>
				</table>';

			$DevisGeneral = '
			<table class="content-table" style="width: 50%;">
				<thead>
					<tr>
						<th colspan="2" >
						'. $langue->show_text('TableNumberQuote') .' '. $DevisCODE .' '. $langue->show_text('TableIndexQuote') .'  '. $DevisINDICE .'
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<input type="hidden" name="CODEDevis" value="'. $CODEDevis .'">
							'. $langue->show_text('TableUserCreate') .'
						</td>
						<td>
							'. $DonneesDevis['NOM'] .' '. $DonneesDevis['PRENOM'] .'
						</td>
					</tr>
					<tr>
						<td>
							'. $langue->show_text('TableSalesManager') .'
						</td>
						<td>
							<select name="RepsComDevis">
								'.  $EmployeeListe1 .'
							</select>
						</td>
					</tr>
					<tr>
						<td>
							'. $langue->show_text('TableTechnicalManager') .'
						</td>
						<td>
							<select name="RespTechDevis">
								'. $EmployeeListe2 .'
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2" >
							<input type="submit" class="input-moyen" value="'. $langue->show_text('TableUpdateButton') .'" />
						</td>
					</tr>
				</tbody>
			</table>';

		$DevisInfoClient = '
			<table class="content-table" style="width: 50%;">
				<thead>
					<tr>
						<th colspan="2" >
						'. $langue->show_text('TableNumberQuote') .' '. $DevisCODE .' '. $langue->show_text('TableIndexQuote') .'  '. $DevisINDICE .'
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<input type="hidden" name="CODEDevis" value="'. $CODEDevis .'">
							'. $langue->show_text('TableContact') .'
						</td>
						<td>
							<select name="ContactDevis">
								'. $ContactDevisListe1 .'
							</select>
						</td>
					</tr>
					<tr>
						<td>
							'. $langue->show_text('TableAdresseDelevery') .'
						</td>
						<td>
							<select name="AdresseLivraisonDevis">
								'.  $AdresseLivraisonListe1 .'
							</select>
						</td>
					</tr>
					<tr>
						<td>
							'. $langue->show_text('TableAdresseInvoice') .'
						</td>
						<td>
							<select name="AdresseFacturationDevis">
								'.  $AdresseFacturationListe1 .'
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2" >
							<input type="submit" class="input-moyen" value="'. $langue->show_text('TableUpdateButton') .'" />
						</td>
					</tr>
				</tbody>
			</table>';


		$DevisInfoCommercial = '
			<table class="content-table" style="width: 50%;">
				<thead>
					<tr>
						<th colspan="2" >
						'. $langue->show_text('TableNumberQuote') .' '. $DevisCODE .' '. $langue->show_text('TableIndexQuote') .'  '. $DevisINDICE .'
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<input type="hidden" name="CODEDevis" value="'. $CODEDevis .'">
							'. $langue->show_text('TableCondiList') .'
						</td>
						<td>
							<select name="CondiRegDevis">
								'. $CondiListe1 .'
							</select>
						</td>
					</tr>
					<tr>
						<td>
							'. $langue->show_text('TableMethodList') .'
						</td>
						<td>
							<select name="ModeRegDevis">
								'.  $RegListe1 .'
							</select>
						</td>
					</tr>
					<tr>
						<td>
							'. $langue->show_text('TimeLinePayement') .'
						</td>
						<td>
							<select name="EcheancierDevis">
								'.  $EcheancierListe1 .'
							</select>
						</td>
					</tr>
					<tr>
						<td>
							'. $langue->show_text('TableDeleveryMode') .'
						</td>
						<td>
							<select name="ModeLivraisonDevis">
								'.  $TransportListe1 .'
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2" >
							<input type="submit" class="input-moyen" value="'. $langue->show_text('TableUpdateButton') .'" />
						</td>
					</tr>
				</tbody>
			</table>';

			$DevisCommentaire = '
			<table class="content-table" style="width: 50%;">
				<thead>
					<tr>
						<th>
						'. $langue->show_text('TableNumberQuote') .' '. $DevisCODE .' '. $langue->show_text('TableIndexQuote') .'  '. $DevisINDICE .'
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<input type="hidden" name="CODEDevis" value="'. $CODEDevis .'">
							<textarea class="Comment" name="Comment" rows="40" >'. $CommentaireDevis .'</textarea>
						</td>
					</tr>
					<tr>
						<td>
							<input type="submit" class="input-moyen" value="'. $langue->show_text('TableUpdateButton') .'" />
						</td>
					</tr>
				</tbody>
			</table>';

			///////////////////////////////
			////DEBUT GESTION DES LIGNE DE DEVIS  ////
			///////////////////////////////

									///////////////////////////////
									//// AJOUT DE LIGNE  ////
									///////////////////////////////

						if(isset($_POST['AddORDRELigneDevis']) AND !empty($_POST['AddORDRELigneDevis'])){

							$AddORDRELigneDevis = $_POST['AddORDRELigneDevis'];
							$AddARTICLELigneDevis = $_POST['AddARTICLELigneDevis'];
							$AddLABELLigneDevis = $_POST['AddLABELLigneDevis'];
							$AddQTLigneDevis = $_POST['AddQTLigneDevis'];
							$AddUNITLigneDevis = $_POST['AddUNITLigneDevis'];
							$AddPrixLigneDevis = $_POST['AddPrixLigneDevis'];
							$AddRemiseLigneDevis = $_POST['AddRemiseLigneDevis'];
							$AddTVALigneDevis = $_POST['AddTVALigneDevis'];
							$AddDELAISigneDevis = $_POST['AddDELAISigneDevis'];

							$i = 0;
							foreach ($AddORDRELigneDevis as $id_generation) {

								$req = $bdd->exec("INSERT INTO ". TABLE_ERP_DEVIS_LIGNE ." VALUE ('0',
																									'". $IDDevisSQL ."',
																									'". addslashes($AddORDRELigneDevis[$i]) ."',
																									'". addslashes($AddARTICLELigneDevis[$i]) ."',
																									'". addslashes($AddLABELLigneDevis[$i]) ."',
																									'". addslashes($AddQTLigneDevis[$i]) ."',
																									'". addslashes($AddUNITLigneDevis[$i]) ."',
																									'". addslashes($AddPrixLigneDevis[$i]) ."',
																									'". addslashes($AddRemiseLigneDevis[$i]) ."',
																									'". addslashes($AddTVALigneDevis[$i]) ."',
																									'". addslashes($AddDELAISigneDevis[$i]) ."',
																									'1')");
								$i++;
							}
							$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddQuoteLineNotification')));
						}

						if(isset($_POST['UpdateIdLigneDevis']) AND !empty($_POST['UpdateIdLigneDevis'])){

							$UpdateIdLigneDevis = $_POST['UpdateIdLigneDevis'];
							$UpdateORDRELigneDevis = $_POST['UpdateORDRELigneDevis'];
							$UpdateIDArticleLigneDevis = $_POST['UpdateIDArticleLigneDevis'];
							$UpdateLABELLigneDevis = $_POST['UpdateLABELLigneDevis'];
							$UpdateQTLigneDevis = $_POST['UpdateQTLigneDevis'];
							$UpdateUNITLigneDevis = $_POST['UpdateUNITLigneDevis'];
							$UpdatePrixLigneDevis = $_POST['UpdatePrixLigneDevis'];
							$UpdateRemiseLigneDevis = $_POST['UpdateRemiseLigneDevis'];
							$UpdateDELAISLigneDevis = $_POST['UpdateDELAISLigneDevis'];
							$UpdateTVALigneDevis = $_POST['UpdateTVALigneDevis'];
							$UpdateETATLigneDevis = $_POST['UpdateETATLigneDevis'];


							$i = 0;
							foreach ($UpdateIdLigneDevis as $id_generation) {

								$req = $bdd->exec("UPDATE  ". TABLE_ERP_DEVIS_LIGNE ." SET 	ORDRE='". addslashes($UpdateORDRELigneDevis[$i]) ."',
																						ARTICLE_CODE='". addslashes($UpdateIDArticleLigneDevis[$i]) ."',
																						LABEL='". addslashes($UpdateLABELLigneDevis[$i]) ."',
																						QT='". addslashes($UpdateQTLigneDevis[$i]) ."',
																						UNIT_ID='". addslashes($UpdateUNITLigneDevis[$i]) ."',
																						PRIX_U='". addslashes($UpdatePrixLigneDevis[$i]) ."',
																						REMISE='". addslashes($UpdateRemiseLigneDevis[$i]) ."',
																						TVA_ID='". addslashes($UpdateTVALigneDevis[$i]) ."',
																						DELAIS='". addslashes($UpdateDELAISLigneDevis[$i]) ."',
																						ETAT='". addslashes($UpdateETATLigneDevis[$i]) ."'
																						WHERE id='". addslashes($id_generation)."'");
								$i++;
							}
							$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateLineNotification')));
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

						$req = $bdd -> query('SELECT  '. TABLE_ERP_DEVIS_LIGNE .'.Id,
														'. TABLE_ERP_DEVIS_LIGNE .'.ORDRE,
														'. TABLE_ERP_DEVIS_LIGNE .'.ARTICLE_CODE,
														'. TABLE_ERP_DEVIS_LIGNE .'.LABEL,
														'. TABLE_ERP_DEVIS_LIGNE .'.QT,
														'. TABLE_ERP_DEVIS_LIGNE .'.UNIT_ID,
														'. TABLE_ERP_DEVIS_LIGNE .'.PRIX_U,
														'. TABLE_ERP_DEVIS_LIGNE .'.REMISE,
														'. TABLE_ERP_DEVIS_LIGNE .'.TVA_ID,
														'. TABLE_ERP_DEVIS_LIGNE .'.DELAIS,
														'. TABLE_ERP_DEVIS_LIGNE .'.ETAT,
														'. TABLE_ERP_TVA .'.TAUX,
														'. TABLE_ERP_TVA .'.LABEL AS LABEL_TVA,
														'. TABLE_ERP_UNIT .'.LABEL AS LABEL_UNIT
														FROM '. TABLE_ERP_DEVIS_LIGNE .'
															LEFT JOIN `'. TABLE_ERP_TVA .'` ON `'. TABLE_ERP_DEVIS_LIGNE .'`.`TVA_ID` = `'. TABLE_ERP_TVA .'`.`id`
															LEFT JOIN `'. TABLE_ERP_UNIT .'` ON `'. TABLE_ERP_DEVIS_LIGNE .'`.`UNIT_ID` = `'. TABLE_ERP_UNIT .'`.`id`
															WHERE '. TABLE_ERP_DEVIS_LIGNE .'.DEVIS_ID = \''. $IDDevisSQL.'\'
														ORDER BY '. TABLE_ERP_DEVIS_LIGNE .'.ORDRE ');
						$tableauTVA = array();

						while ($DonneesListeLigneDuDevis = $req->fetch()){

							$TotalLigneHTEnCours = ($DonneesListeLigneDuDevis['QT']*$DonneesListeLigneDuDevis['PRIX_U'])-($DonneesListeLigneDuDevis['QT']*$DonneesListeLigneDuDevis['PRIX_U'])*($DonneesListeLigneDuDevis['REMISE']/100);
							$TotalLigneTVAEnCours =  $TotalLigneHTEnCours*($DonneesListeLigneDuDevis['TAUX']/100) ;
							$TotalLigneTTCEnCours = $TotalLigneTVAEnCours+$TotalLigneHTEnCours;

							$TotalLigneDevisHT += $TotalLigneHTEnCours;
							$TotalLigneDevisTTC += $TotalLigneTVAEnCours+$TotalLigneHTEnCours;

							if(array_key_exists($DonneesListeLigneDuDevis['TVA_ID'], $tableauTVA)){
								$tableauTVA[$DonneesListeLigneDuDevis['TVA_ID']][0] += $TotalLigneHTEnCours;
								$tableauTVA[$DonneesListeLigneDuDevis['TVA_ID']][2] += $TotalLigneTVAEnCours;
								$tableauTVA[$DonneesListeLigneDuDevis['TVA_ID']][3] += $TotalLigneTTCEnCours;
							}
							else{
								$tableauTVA[$DonneesListeLigneDuDevis['TVA_ID']] = array($TotalLigneHTEnCours, $DonneesListeLigneDuDevis['TAUX'], $TotalLigneTVAEnCours, $TotalLigneTTCEnCours);
							}


							$DetailLigneDuDevis .='
							<tr>
								<td><input type="hidden" name="UpdateIdLigneDevis[]" id="UpdateIdLigneDevis" value="'. $DonneesListeLigneDuDevis['Id'] .'"><a href="index.php?page=quote&id='. $_GET['id'] .'&amp;delete='. $DonneesListeLigneDuDevis['Id'] .'" title="Supprimer la ligne">x</a></td>
								<td><input type="number" name="UpdateORDRELigneDevis[]" value="'. $DonneesListeLigneDuDevis['ORDRE'] .'" id="number"></td>
								<td>
									<input list="Article" name="UpdateIDArticleLigneDevis[]" id="UpdateIDArticleLigneDevis" value="'. $DonneesListeLigneDuDevis['ARTICLE_CODE'] .'">
									<datalist id="Article">
										'. $ListeArticle .'
									</datalist>
								</td>
								<td><input type="text"  name="UpdateLABELLigneDevis[]" value="'. $DonneesListeLigneDuDevis['LABEL'] .'"></td>
								<td><input type="number"  name="UpdateQTLigneDevis[]" value="'. $DonneesListeLigneDuDevis['QT'] .'" id="number"></td>
								<td>
									<select  name="UpdateUNITLigneDevis[]">
									<option value="'. $DonneesListeLigneDuDevis['UNIT_ID'] .'" '. selected($DonneesListeLigneDuDevis['UNIT_ID'], $DonneesListeLigneDuDevis['UNIT_ID']) .'>'. $DonneesListeLigneDuDevis['LABEL_UNIT'] .'</option>
									'. $UnitListe .'
									</select>
								</td>
								<td><input type="number"  name="UpdatePrixLigneDevis[]" step=".001" value="'. $DonneesListeLigneDuDevis['PRIX_U'] .'" id="number"></td>
								<td><input type="number"   name="UpdateRemiseLigneDevis[]" min="0" max="100" step=".001" value="'. $DonneesListeLigneDuDevis['REMISE'] .'" id="number"></td>
								<td>'.   $TotalLigneHTEnCours .' €</td>

								<td>
									<select  name="UpdateTVALigneDevis[]">
										<option value="'. $DonneesListeLigneDuDevis['TVA_ID'] .'" selected>'. $DonneesListeLigneDuDevis['TAUX'] .'%</option>
										'.  $TVAListe .'
									</select>
								</td>
								<td><input type="date" name="UpdateDELAISLigneDevis[]" value="'. $DonneesListeLigneDuDevis['DELAIS'] .'"></td>
								<td>
									<select  name="UpdateETATLigneDevis[]">
										<option value="1" '. selected($DonneesListeLigneDuDevis['ETAT'], 1) .'>'. $langue->show_text('SelectOpen') .'</option>
										<option value="2" '. selected($DonneesListeLigneDuDevis['ETAT'], 2) .'>'. $langue->show_text('SelectRefuse') .'</option>
										<option value="3" '. selected($DonneesListeLigneDuDevis['ETAT'], 3) .'>'. $langue->show_text('SelectSend') .'</option>
										<option value="4" '. selected($DonneesListeLigneDuDevis['ETAT'], 4) .'>'. $langue->show_text('SelectDecline') .'</option>
										<option value="5" '. selected($DonneesListeLigneDuDevis['ETAT'], 5) .'>'. $langue->show_text('SelectClosed') .'</option>
										<option value="6" '. selected($DonneesListeLigneDuDevis['ETAT'], 6) .'>'. $langue->show_text('SelectObsolete') .'</option>
									</select>
								</td>
							</tr>';

							$LignePourCommande .='
							<tr>
								<td><input type="hidden" name="UpdateIdLigneDevis[]" id="UpdateIdLigneDevis" value="'. $DonneesListeLigneDuDevis['Id'] .'"></td>
								<td>
									<label class="container">
										<input type="checkbox" title="'. $DonneesListeLigneDuDevis['id'] .'" name="id_ligne[]" value="'. $DonneesListeLigneDuDevis['id'] .'" id="'. $DonneesListeLigneDuDevis['id'] .'" checked="checked"/>
										<span class="checkmark"></span>
									</label>
								</td>
								<td>'. $DonneesListeLigneDuDevis['LABEL'] .'</td>
								<td>'. $DonneesListeLigneDuDevis['QT'] .'</td>
								<td>'. $DonneesListeLigneDuDevis['PRIX_U'] .' € </td>
								<td>'. $DonneesListeLigneDuDevis['REMISE'] .' %</td>
								<td>'.   $TotalLigneHTEnCours .' € </td>
								<td>'. $DonneesListeLigneDuDevis['DELAIS'] .'</td>
							</tr>';
						}

			$req = $bdd->query('SELECT '. TABLE_ERP_COMMANDE .'.id,
										'. TABLE_ERP_COMMANDE .'.CODE,
										'. TABLE_ERP_COMMANDE .'.LABEL,
										'. TABLE_ERP_CLIENT_FOUR .'.NAME
								FROM '. TABLE_ERP_COMMANDE .'
									LEFT JOIN `'. TABLE_ERP_CLIENT_FOUR .'` ON `'. TABLE_ERP_COMMANDE .'`.`CLIENT_ID` = `'. TABLE_ERP_CLIENT_FOUR .'`.`id`
								ORDER BY '. TABLE_ERP_COMMANDE .'.id');
							while ($donnees_commande = $req->fetch())
							{
								$CommandeExistante  .= '
										<tr>
											<td>
												<input type="radio" id="new'. $donnees_commande['id'] .'" name="AddCmd" value="'. $donnees_commande['id'] .'"><label for="new'. $donnees_commande['id'] .'">'. $donnees_commande['CODE'] .' - '. $donnees_commande['NAME'] .'</label>
											</td>
										</tr>';
							}

				$DevisAssitCommande = '
							<div class="column">
								<table class="content-table" >
									<thead>
										<tr>
											<th colspan="12" >
											'. $langue->show_text('TableNumberQuote') .' '. $DevisCODE .' '. $langue->show_text('TableIndexQuote') .'  '. $DevisINDICE .'
											</th>
										</tr>
									</thead>
									<tbody>
										'. $LignePourCommande  .'
									</tbody>
								</table>
							</div>
							<div class="column">
								<table class="content-table" >
									<thead>
										<tr>
											<th colspan="12" >
												'. $langue->show_text('TableSelectOrder') .'
											</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												<input type="radio" id="new" name="AddCmd" value="0"><label for="new">'. $langue->show_text('TableNewOrder') .'</label>
											</td>
										</tr>
										'. $CommandeExistante .'
									</tbody>
								</table>
							</div>
							<div class="column">
								<table class="content-table" >
									<thead>
										<tr>
											<th colspan="12" >
											'. $langue->show_text('TableGeneralInfo') .'
											</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
											'. $langue->show_text('TableCustomerReference') .' <input type="text" name="AddReferenceClient" placeholder="'. $langue->show_text('TableNumberCustomerOrder') .'">
											</td>
										</tr>
										<tr>
											<td>
											'. $langue->show_text('TableDeleveryDate') .' <input type="date" name="AddDELAISCommande" required="required">
											</td>
										</tr>
										<tr>
											<td>
												<input type="submit" class="input-moyen" value="'. $langue->show_text('TableCreateOrder') .'" />
											</td>
										</tr>
									</tbody>
								</table>
							</div>';

						$req->closeCursor();

			///////////////////////////////
			//// FIN GESTION DES LIGNE DE DEVIS   ////
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

			$DevisLignes ='
			<table class="content-table-devis" style="width: 50%;">
				<thead>
					<tr>
						<th colspan="12" >
						'. $langue->show_text('TableNumberQuote') .' '. $DevisCODE .' '. $langue->show_text('TableIndexQuote') .'  '. $DevisINDICE .'
						</th>
					</tr>
					<tr>
						<th></th>
						<th>'. $langue->show_text('TableOrder') .'</th>
						<th>'. $langue->show_text('TableArticle') .'</th>
						<th>'. $langue->show_text('Tablelabel') .'</th>
						<th>'. $langue->show_text('TableQty') .'</th>
						<th>'. $langue->show_text('TableUnit') .'</th>
						<th>'. $langue->show_text('TableUnitPrice') .'</th>
						<th>'. $langue->show_text('TableDiscount') .'</th>
						<th>'. $langue->show_text('TableTotal') .'</th>
						<th>'. $langue->show_text('TableRate') .'</th>
						<th>'. $langue->show_text('TableDelay') .'</th>
						<th>'. $langue->show_text('TableStatu') .'</th>
					</tr>
				</thead>
				<tbody>
					'. $DetailLigneDuDevis .'
					<tr>
						<th></th>
						<th></th>
						<th></th>
						<th colspan="2" >'. $langue->show_text('TotalPriceWithOutTax') .'</th>
						<th >'. $langue->show_text('TableRate') .'</th>
						<th colspan="2" >'. $langue->show_text('TotalTax') .'</th>
						<th>'. $langue->show_text('TotalPriceWithTax') .'</th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
						'.  $DetailLigneTVA .'
					<tr>
						<th></th>
						<th></th>
						<th>'. $langue->show_text('TotalWithOutTax') .'</th>
						<th colspan="2">'. $TotalLigneDevisHT .' €</th>
						<th></th>
						<th colspan="2" >'. $langue->show_text('TotalWithTax') .'</th>
						<th>'. $TotalLigneDevisTTC .' €</th>
						<th></th>
						<th></th>
						<th></th>
					<tr>
					</tr>
						<th colspan="12" >
							'. $langue->show_text('Addline') .'
						</th>
					</tr>
					<tr>
						<td></td>
						<td><input type="number" name="" id="AddORDRELigneDevis" placeholder="10"  value="10"></td>
						<td>
							<input list="Article" name="AddARTICLELigneDevis" id="AddARTICLELigneDevis">
							<datalist id="Article">
								'. $ListeArticle .'
							</datalist>
						</td>
						<td><input type="text"  name="" id="AddLABELLigneDevis" placeholder="Désignation"></td>
						<td><input type="number"  name="" id="AddQTLigneDevis" placeholder="1"  value="1"></td>
						<td>
							<select name="" id="AddUNITLigneDevis">
								'. $UnitListe .'
							</select>
						</td>
						<td><input type="number"  name="" id="AddPrixLigneDevis" step=".001" placeholder="10 €"  value="0"></td>
						<td><input type="number"  name="" id="AddRemiseLigneDevis" min="0" max="100" step=".001" placeholder="0 %" value="0"></td>
						<td></td>
						<td>
							<select name="" id="AddTVALigneDevis">
								'.  $TVAListe .'
							</select>
						</td>
						<td><input type="date" name="" id="AddDELAISigneDevis" required="required"></td>
						<td></td>
					</tr>
					<tr>
						<td colspan="12" >
							<input type="button" class="add" value="'. $langue->show_text('Addline') .'">
							<input type="button" class="delete" value="'. $langue->show_text('Deleteline') .'">
							<input type="submit" class="input-moyen" value="'. $langue->show_text('UpdateQuoteLine') .'" />
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
				<input type="text" id="myInput" onkeyup="myFunction()" placeholder="'. $langue->show_text('TableFindQuote') .'">
				<ul id="myUL">
					'. $ListeQuotePrincipale .'
				</ul>
			</div>
			<div class="column">
				<form method="post" name="quote" action="'. $actionForm .'" class="content-form" enctype="multipart/form-data" >
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
								'. $langue->show_text('TableNewQuoteFor') .'
								<td>
								<td>
									<select name="AddDevis">
										'. $ListeSte .'
									</select>
								<td>
							</tr>
							<tr>
								<td colspan="6" >
									<br/>
									<input type="submit" class="input-moyen" value="'. $langue->show_text('TableNewButton') .'" /> <br/>
									<br/>
								</td>
							</tr>
						</tbody>
					</table>
				</form>
			</div>
			<div class="column">
				<div id="piechart" style="width: 100%; height: 300px;"></div>
				<div id="columnchart_values" style="width: 100%; height: 300px;"></div>
			</div>';

	//Adtape default display from isset type
	if(isset($_GET['delete']) AND !empty($_GET['delete'])){
		$ParDefautDiv1 = '';
		$ParDefautDiv2 = '';
		$ParDefautDiv3 = 'id="defaultOpen"';
		$ImputButton = '<input type="submit" class="input-moyen" value="'. $langue->show_text('TableUpdateButton') .'" />';
		$actionForm = 'index.php?page=quote&id='. $_GET['id'] .'';

	}
	elseif(isset($_GET['id']) AND !empty($_GET['id'])){
		$ParDefautDiv1 = '';
		$ParDefautDiv2 = 'id="defaultOpen"';
		$ParDefautDiv3 = '';
		$ImputButton = '<input type="submit" class="input-moyen" value="'. $langue->show_text('TableUpdateButton') .'" />';
		$actionForm = 'index.php?page=quote&id='. $_GET['id'] .'';

	}
	else{
		$ParDefautDiv3 = '';
		$ParDefautDiv2 = '';
		$ParDefautDiv1 = 'id="defaultOpen"';
		$VerrouInput = ' disabled="disabled"  Value="-" ';
		$ImputButton = $langue->show_text('TablenoQuote');
		$actionForm = 'index.php?page=quote';
	}
?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
 <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
		var data = google.visualization.arrayToDataTable([
<?php
			$ListeEtat .= "['Task', 'Number of Quote']";
			$req = $bdd->query("SELECT ETAT, COUNT(ETAT) AS CountEtat FROM ". TABLE_ERP_DEVIS ." GROUP BY ETAT");
			while ($donnees_Etat = $req->fetch())
			{
				If ($donnees_Etat['ETAT'] == 1) {$Etat = 'En cours';}
				If ($donnees_Etat['ETAT'] == 2) {$Etat = 'Refusé';}
				If ($donnees_Etat['ETAT'] == 3) {$Etat = 'Envoyé';}
				If ($donnees_Etat['ETAT'] == 4) {$Etat = 'Décliné';}
				If ($donnees_Etat['ETAT'] == 5) {$Etat = 'Fermé';}
				If ($donnees_Etat['ETAT'] == 6) {$Etat = 'Obselète';}

				$ListeEtat .= ", ['". $Etat ."',". $donnees_Etat['CountEtat'] ."]";
			}

			echo $ListeEtat;
?>
        ]);

        var options = {
          title: 'Taux de transformation'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
	<script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Element", "Density", { role: "style" } ],
        ["Copper", 8.94, "#b87333"],
        ["Silver", 10.49, "silver"],
        ["Gold", 19.30, "gold"],
        ["Platinum", 21.45, "color: #e5e4e2"]
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Montant chiffré ce mois ci",
        width: 400,
        height: 300,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
      chart.draw(view, options);
  }
  </script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $(".add").click(function() {
        var AddORDRELigneDevis = $("#AddORDRELigneDevis").val();
        var AddARTICLELigneDevis = $("#AddARTICLELigneDevis").val();
		var AddLABELLigneDevis = $("#AddLABELLigneDevis").val();
		var AddQTLigneDevis = $("#AddQTLigneDevis").val();
		var AddUNITLigneDevis = $("#AddUNITLigneDevis").val();
		var AddPrixLigneDevis = $("#AddPrixLigneDevis").val();
		var AddRemiseLigneDevis = $("#AddRemiseLigneDevis").val();
		var AddTVALigneDevis = $("#AddTVALigneDevis").val();
		var AddDELAISigneDevis = $("#AddDELAISigneDevis").val();

		var TotalPrix = (AddQTLigneDevis*AddPrixLigneDevis)-(AddQTLigneDevis*AddPrixLigneDevis)*(AddRemiseLigneDevis/100);

		var ligne = "<tr>";
		var ligne = ligne + "<td><input type=\"checkbox\" name=\"select\"></td>";
		var ligne = ligne + "<td><input type=\"number\" name=\"AddORDRELigneDevis[]\" value=\""+ AddORDRELigneDevis +"\" id=\"number\" required=\"required\"></td>";
		var ligne = ligne + "<td><input list=\"Article\" name=\"AddARTICLELigneDevis[]\" value=\"" + AddARTICLELigneDevis +"\"><datalist id=\"Article\">";
		var ligne = ligne + <?= $ListeArticleJava ?> ;
		var ligne = ligne + "</datalist></td>";
		var ligne = ligne + "<td><input type=\"text\" name=\"AddLABELLigneDevis[]\" value=\""+ AddLABELLigneDevis +"\" ></td>";
		var ligne = ligne + "<td><input type=\"number\" name=\"AddQTLigneDevis[]\" value=\""+ AddQTLigneDevis +"\"  id=\"number\" required=\"required\"></td>";
		var ligne = ligne + "<td><input type=\"hidden\" name=\"AddUNITLigneDevis[]\" value=\"" + AddUNITLigneDevis + "\">-</td>";
		var ligne = ligne + "<td><input type=\"number\" name=\"AddPrixLigneDevis[]\" value=\""+ AddPrixLigneDevis +"\"  step=\".001\" id=\"number\" required=\"required\"></td>";
		var ligne = ligne + "<td><input type=\"number\" name=\"AddRemiseLigneDevis[]\" value=\""+ AddRemiseLigneDevis +"\" min=\"0\" max=\"100\" step=\".001\" id=\"number\" required=\"required\"></td>";
		var ligne = ligne + "<td>"+ TotalPrix +" €</td>";
		var ligne = ligne + "<td><input type=\"hidden\" name=\"AddTVALigneDevis[]\" value=\"" + AddTVALigneDevis + "\">-</td>";
		var ligne = ligne + "<td><input type=\"date\" name=\"AddDELAISigneDevis[]\"  value=\"" + AddDELAISigneDevis+"\" required=\"required\"></td>";
		var ligne = ligne + "<td></td>";
		var ligne = ligne + "</tr>";
        $("table.content-table-devis").append(ligne);
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
	<div class="tab">
		<button class="tablinks" onclick="openDiv(event, 'div1')" <?=$ParDefautDiv1; ?>><?=$langue->show_text('Title1'); ?></button>
<?php
	if(isset($_POST['CODESte']) AND isset($_POST['NameSte']) AND !empty($_POST['CODESte']) AND !empty($_POST['NameSte']) OR  isset($_GET['id']) AND !empty($_GET['id']))
	{
?>
		<button class="tablinks" onclick="openDiv(event, 'div2')" <?=$ParDefautDiv2; ?>><?=$langue->show_text('Title2'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div3')" <?=$ParDefautDiv3; ?>><?=$langue->show_text('Title3'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div4')"><?=$langue->show_text('Title4'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div5')"><?=$langue->show_text('Title5'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div6')"><?=$langue->show_text('Title6'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div7')"><?=$langue->show_text('Title7'); ?></button>
		<a href="document.php?id=<?= $_GET['id'] ?>" target="_blank"><button class="tablinks" ><?=$langue->show_text('Title8'); ?></button></a>
		<button class="tablinks" onclick="openDiv(event, 'div8')"><?=$langue->show_text('Title9'); ?></button>
<?php
	}
?>
		<div class="DataListDroite">
			<form method="get" name="devis" action="<?=$actionForm; ?>">
				<?=$langue->show_text('TableFind'); ?> <input list="devis" name="id" id="id" placeholder="Ex: DV201118-01">
				<datalist id="devis">
					<?=$ListeQuote; ?>
				</datalist>
				<input type="submit" class="input-moyen" value="Go !" />
			</form>
		</div>
	</div>
	<div id="div1" class="tabcontent">
			<?=$Acceuil; ?>
	</div>
	<div id="div2" class="tabcontent">
		<form method="post" name="Coment" action="<?=$actionForm; ?>" class="content-form" >
			<?=$DevisAcceuil; ?>
		</form>
	</div>
	<div id="div3" class="tabcontent">
		<form method="post" name="Coment" action="<?=$actionForm; ?>" class="content-form" >
			<?=$DevisLignes ?>
		</form>
	</div>
	<div id="div4" class="tabcontent">
		<form method="post" name="Coment" action="<?=$actionForm; ?>" class="content-form" >
			<?=$DevisGeneral; ?>
		</form>
	</div>
	<div id="div5" class="tabcontent">
		<form method="post" name="Coment" action="<?=$actionForm; ?>" class="content-form" >
			<?=$DevisInfoClient; ?>
		</form>
	</div>
	<div id="div6" class="tabcontent">
		<form method="post" name="Coment" action="<?=$actionForm; ?>" class="content-form" >
			<?=$DevisInfoCommercial; ?>
		</form>
	</div>
	<div id="div7" class="tabcontent">
		<form method="post" name="Coment" action="<?=$actionForm; ?>" class="content-form" >
			<?=$DevisCommentaire; ?>
		</form>
	</div>
	<div id="div8" class="tabcontent">
		<form method="post" name="Coment" action="commandes.php" class="content-form" >
			<?=$DevisAssitCommande; ?>
		</form>
	</div>