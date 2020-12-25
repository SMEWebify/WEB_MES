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
	if($_SESSION['page_5'] != '1'){
		stop($langue->show_text('SystemInfoAccessDenied'), 161, 'index.php?page=login');
	}

	///////////////////////////////
	//// COMMMENT ////
	///////////////////////////////
	if(isset($_POST['Comment']) AND !empty($_POST['Comment'])){

		$bdd->GetUpdate("UPDATE  ". TABLE_ERP_DEVIS ." SET 	COMENT='". addslashes($_POST['Comment']) ."'
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

		$bdd->GetUpdate("UPDATE  ". TABLE_ERP_DEVIS ." SET 	RESP_COM_ID='". addslashes($PostRepsComDevis) ."',
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

		$bdd->GetUpdate("UPDATE  ". TABLE_ERP_DEVIS ." SET 	COND_REG_CLIENT_ID='". addslashes($PostCondiRegDevis) ."',
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

		$bdd->GetUpdate("UPDATE  ". TABLE_ERP_DEVIS ." SET 	CONTACT_ID='". addslashes($PostContactDevis) ."',
																ADRESSE_ID='". addslashes($PostAdresseLivraisonDevis) ."',
																FACTURATION_ID='". addslashes($PostAdresseFacturationDevis) ."'
															WHERE CODE='". addslashes($_POST['CODEDevis'])."'");
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateInfoCustomerNotification')));
	}

	///////////////////////////////
	//// DELETE LIGNE ////
	///////////////////////////////
	if(isset($_GET['delete']) AND !empty($_GET['delete'])){

		$bdd->GetDelete("DELETE FROM ". TABLE_ERP_DEVIS_LIGNE ." WHERE id='". addslashes($_GET['delete'])."'");
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

		$bdd->GetUpdate("UPDATE  ". TABLE_ERP_DEVIS ." SET 	LABEL='". addslashes($PostDevisLABEL) ."',
																LABEL_INDICE='". addslashes($PostDevisLABELIndice) ."',
																REFERENCE='". addslashes($PostDevisReference) ."',
																DATE_VALIDITE='". addslashes($PostDevisDATE_VALIDITE) ."',
																ETAT='". addslashes($PostDevisEtat) ."'
															WHERE CODE='". addslashes($_POST['CODEDevis'])."'");
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateGeneralInfoNotification')));

		if(isset($_POST['DevisMajLigne']) AND !empty($_POST['DevisMajLigne'])){

			$bdd->GetUpdate("UPDATE  ". TABLE_ERP_DEVIS_LIGNE ." SET 	ETAT='". addslashes($PostDevisEtat) ."'
															WHERE 	DEVIS_ID='". addslashes($_POST['IdDevis'])."'");
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateStatuLineNotification')));
		}
	}

	//If user create new quote
	if(isset($_POST['AddDevis']) And !empty($_POST['AddDevis'])){

		//we find num sequence for number quoting
		$query='SELECT '. TABLE_ERP_NUM_DOC .'.Id,
									'. TABLE_ERP_NUM_DOC .'.DOC_TYPE,
									'. TABLE_ERP_NUM_DOC .'.MODEL,
									'. TABLE_ERP_NUM_DOC .'.DIGIT,
									'. TABLE_ERP_NUM_DOC .'.COMPTEUR
									FROM `'. TABLE_ERP_NUM_DOC .'`
									WHERE DOC_TYPE=8';
		$data = $bdd->GetQuery($query, true);

		//make num sequence
		$CODE = NumDoc($data->MODEL,$data->COMPTEUR, $data->DIGIT);

		//insert in DB new quote
		$req = $bdd->GetInsert("INSERT INTO ". TABLE_ERP_DEVIS ." VALUE ('0',
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
		$bdd->GetUpdate('UPDATE `'. TABLE_ERP_NUM_DOC .'` SET  COMPTEUR = COMPTEUR + 1 WHERE DOC_TYPE IN (8)');

		//select last id add in db
		$query="SELECT CODE FROM ". TABLE_ERP_DEVIS ." ORDER BY id DESC LIMIT 0, 1";
		$data = $bdd->GetQuery($query, true);
		$CODEDevisAjout = $data->CODE;
	}

	//If user want display an quote we check id isset GET or POST
	if(isset($_GET['id']) And !empty($_GET['id']) Or isset($_POST['AddDevis']) And !empty($_POST['AddDevis'])){

		//Initialise CODE quote for SQL requête
		if(isset($_GET['id'])){$CODEDevis = addslashes($_GET['id']);}
		if(isset($_POST['AddDevis']) And !empty($_POST['AddDevis'])){$CODEDevis = $CODEDevisAjout;}

		//we check if quote was in DB
		//Check if is existe
		$data=$bdd->GetQuery("SELECT COUNT(id) as nb FROM ". TABLE_ERP_DEVIS ." WHERE CODE = '". $CODEDevis."'", true);
		$nb = $data->nb;

		//if ok
		if($nb=1){

				//Load data
				$query='SELECT '. TABLE_ERP_DEVIS .'.Id,
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
									WHERE '. TABLE_ERP_DEVIS .'.CODE = \''. $CODEDevis.'\' ';
			$data = $bdd->GetQuery($query, true);

			$titleOnglet1 = $langue->show_text('TableUpdateButton');

			$IDDevisSQL = $data->Id;
			$CommentaireDevis = $data->COMENT;
			$DevisCLIENT_ID = $data->CLIENT_ID;
			$DevisCONTACT_ID = $data->CONTACT_ID;
			$DevisCLIENT_NAME = $data->NAME;
			$DevisADRESSE_ID = $data->ADRESSE_ID;
			$DevisFACTURATION_ID = $data->FACTURATION_ID;
			$DevisNomName = $data->NOM;
			$DevisNomPrenom = $data->PRENOM;
			$DevisRESP_COM_ID = $data->RESP_COM_ID;
			$DevisRESP_TECH_ID = $data->RESP_TECH_ID;
			$DevisCONDI_REG_ID = $data->COND_REG_CLIENT_ID;
			$DevisMODE_REG_ID = $data->MODE_REG_CLIENT_ID;
			$DevisEcheancier_ID = $data->ECHEANCIER_ID;
			$DevisTransport_ID = $data->TRANSPORT_ID;

			$DevisCODE = $data->CODE;
			$DevisINDICE = $data->INDICE;
			$DevisLABEL = $data->LABEL;
			$DevisLABEL_INDICE = $data->LABEL_INDICE;

			$DevisDATE = $data->DATE;
			$DevisDATE_VALIDITE = $data->DATE_VALIDITE;
			$DevisETAT = $data->ETAT;
			$DevisREFERENCE = $data->REFERENCE;

			//create liste employees
			$query='SELECT '. TABLE_ERP_EMPLOYEES .'.idUSER,
									'. TABLE_ERP_EMPLOYEES .'.NOM,
									'. TABLE_ERP_EMPLOYEES .'.PRENOM,
									'. TABLE_ERP_RIGHTS .'.RIGHT_NAME
							FROM `'. TABLE_ERP_EMPLOYEES .'`
								LEFT JOIN `'. TABLE_ERP_RIGHTS .'` ON `'. TABLE_ERP_EMPLOYEES .'`.`FONCTION` = `'. TABLE_ERP_RIGHTS .'`.`id`';

			 $EmployeeListe1 .=  '<option value="null" '. selected($DevisRESP_COM_ID, 0) .'>Aucun</option>';
			 $EmployeeListe2 .=  '<option value="null" '. selected($DevisRESP_TECH_ID, 0) .'>Aucun</option>';

			foreach ($bdd->GetQuery($query) as $data){
				 $EmployeeListe1 .=  '<option value="'. $data->idUSER .'" '. selected($DevisRESP_COM_ID, $data->idUSER) .'>'. $data->NOM .' '. $data->PRENOM .' - '. $data->RIGHT_NAME .'</option>';
				 $EmployeeListe2 .=  '<option value="'. $data->idUSER .'" '. selected($DevisRESP_TECH_ID, $data->idUSER) .'>'. $data->NOM .' '. $data->PRENOM .' - '. $data->RIGHT_NAME .'</option>';
			}

			//create list mode payment
			$query='SELECT Id, LABEL FROM '. TABLE_ERP_MODE_REG .'';
			foreach ($bdd->GetQuery($query) as $data){
				$RegListe1 .='<option value="'. $data->Id .'" '. selected($DevisCONDI_REG_ID, $data->Id) .'>'. $data->LABEL .'</option>';
			}

			//Create list condition payment
			$query='SELECT Id, LABEL FROM '. TABLE_ERP_CONDI_REG .'';
			foreach ($bdd->GetQuery($query) as $data){
				$CondiListe1 .='<option value="'. $data->Id .'" '. selected($DevisMODE_REG_ID, $data->Id) .'>'. $data->LABEL .'</option>';
			}

			//deadline payment list
			$query='SELECT Id, LABEL FROM '. TABLE_ERP_ECHEANCIER_TYPE .'';
			foreach ($bdd->GetQuery($query) as $data){
				$EcheancierListe1 .='<option value="'. $data->Id .'" '. selected($DevisEcheancier_ID, $data->Id) .'>'. $data->LABEL .'</option>';
			}

			//List transport
			$query='SELECT Id, LABEL FROM '. TABLE_ERP_TRANSPORT .'';
			foreach ($bdd->GetQuery($query) as $data){
				$TransportListe1 .='<option value="'. $data->Id .'" '. selected($DevisTransport_ID, $data->Id) .'>'. $data->LABEL .'</option>';
			}

			//Contact quote list from company
			$ContactDevisListe1 =  '<option value="null" '. selected($DevisCONTACT_ID, 0) .'>Aucun</option>';
			$query='SELECT Id, PRENOM, NOM FROM '. TABLE_ERP_CONTACT .' WHERE ID_COMPANY=\''. $DevisCLIENT_ID.'\'';
			foreach ($bdd->GetQuery($query) as $data){
				$ContactDevisListe1 .='<option value="'. $data->Id .'" '. selected($DevisCONTACT_ID, $data->Id) .'>'.$data->PRENOM .' '. $data->NOM .'</option>';
			}

			//delevery adress list
			$AdresseLivraisonListe1 =  '<option value="null" '. selected($DevisADRESSE_ID, 0) .'>Aucune</option>';
			$query='SELECT id, LABEL, ADRESSE, CITY FROM '. TABLE_ERP_ADRESSE .' WHERE ID_COMPANY=\''. $DevisCLIENT_ID.'\' AND ADRESS_LIV=\'1\'';
			foreach ($bdd->GetQuery($query) as $data){
				$AdresseLivraisonListe1 .='<option value="'. $data->id .'" '. selected($DevisADRESSE_ID, $data->id) .'>'. $data->LABEL .' - '. $data->ADRESSE .' - '. $data->CITY .' </option>';
			}
			
			//Billing adress list
			$AdresseFacturationListe1 =  '<option value="null" '. selected($DevisFACTURATION_ID, 0) .'>Aucune</option>';
			$query='SELECT id, LABEL, ADRESSE, CITY FROM '. TABLE_ERP_ADRESSE .' WHERE ID_COMPANY=\''. $DevisCLIENT_ID.'\' AND ADRESS_FAC=\'1\' ';
			foreach ($bdd->GetQuery($query) as $data){
				$AdresseFacturationListe1 .='<option value="'. $data->id .'" '. selected($DevisFACTURATION_ID, $data->id) .'>'. $data->LABEL .' - '. $data->ADRESSE .' - '. $data->CITY .' </option>';
			}

			/////////////////////////////////////////
			////DEBUT GESTION DES LIGNE DE DEVIS  ////
			/////////////////////////////////////////

				///////////////////////////////
				////    AJOUT DE LIGNE     ////
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

								$req = $bdd->GetInsert("INSERT INTO ". TABLE_ERP_DEVIS_LIGNE ." VALUE ('0',
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

								$bdd->GetUpdate("UPDATE  ". TABLE_ERP_DEVIS_LIGNE ." SET 	ORDRE='". addslashes($UpdateORDRELigneDevis[$i]) ."',
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

			}
		}

	$query="SELECT id, CODE, NAME FROM ". TABLE_ERP_CLIENT_FOUR ." ORDER BY NAME";
	foreach ($bdd->GetQuery($query) as $data){
		$ListeSte .= '<option  value="'. $data->id .'" >'. $data->NAME .'</option>';
	}

	$ListeArticleJava  ='"';
	$query="SELECT id, CODE, LABEL FROM ". TABLE_ERP_ARTICLE ." ORDER BY LABEL";
	foreach ($bdd->GetQuery($query) as $data){
		$ListeArticle  .= '<option  value="'. $data->CODE .'" >';
		$ListeArticleJava  .= '<option  value=\"'. $data->CODE .'\" >';
	}
	$ListeArticleJava  .='"';

	//Adtape default display from isset type
	if(isset($_GET['delete']) AND !empty($_GET['delete'])){
		$ParDefautDiv1 = '';
		$ParDefautDiv2 = '';
		$ParDefautDiv3 = 'id="defaultOpen"';
		$ImputButton = '<input type="submit" class="input-moyen" value="'. $langue->show_text('TableUpdateButton') .'" />';
		$actionForm = 'index.php?page=quote&id='. $DevisCODE .'';

	}
	elseif(isset($_GET['id']) AND !empty($_GET['id'])){
		$ParDefautDiv1 = '';
		$ParDefautDiv2 = 'id="defaultOpen"';
		$ParDefautDiv3 = '';
		$ImputButton = '<input type="submit" class="input-moyen" value="'. $langue->show_text('TableUpdateButton') .'" />';
		$actionForm = 'index.php?page=quote&id='. $DevisCODE .'';

	}
	else{
		$ParDefautDiv3 = '';
		$ParDefautDiv2 = '';
		$ParDefautDiv1 = 'id="defaultOpen"';
		$VerrouInput = ' disabled="disabled"  Value="-" ';
		$ImputButton = $langue->show_text('TablenoQuote');
		$actionForm = 'index.php?page=quote';
	}

		//make list quote for display an other quote
		$query='SELECT '. TABLE_ERP_DEVIS .'.id,
						'. TABLE_ERP_DEVIS .'.CODE,
						'. TABLE_ERP_DEVIS .'.LABEL,
						'. TABLE_ERP_CLIENT_FOUR .'.NAME
				FROM '. TABLE_ERP_DEVIS .'
				LEFT JOIN `'. TABLE_ERP_CLIENT_FOUR .'` ON `'. TABLE_ERP_DEVIS .'`.`CLIENT_ID` = `'. TABLE_ERP_CLIENT_FOUR .'`.`id`
				ORDER BY  '. TABLE_ERP_DEVIS .'.id DESC';
		foreach ($bdd->GetQuery($query) as $data){
			$ListeQuote .= '<option  value="'. $data->CODE .'" >';
			$ListeQuotePrincipale  .= '<li><a href="index.php?page=quote&id='. $data->CODE .'">'. $data->CODE .' - '. $data->NAME .' </a></li>';
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
			$query="SELECT ETAT, COUNT(ETAT) AS CountEtat FROM ". TABLE_ERP_DEVIS ." GROUP BY ETAT";
			foreach ($bdd->GetQuery($query) as $data){
				If ($data->ETAT == 1) {$Etat = 'En cours';}
				If ($data->ETAT == 2) {$Etat = 'Refusé';}
				If ($data->ETAT == 3) {$Etat = 'Envoyé';}
				If ($data->ETAT == 4) {$Etat = 'Décliné';}
				If ($data->ETAT == 5) {$Etat = 'Fermé';}
				If ($data->ETAT == 6) {$Etat = 'Obselète';}

				$ListeEtat .= ", ['". $Etat ."',". $data->CountEtat ."]";
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
	</div>
	<div id="div1" class="tabcontent">
		<div class="column">
			<input type="text" id="myInput" onkeyup="myFunction()" placeholder="<?= $langue->show_text('TableFindQuote') ?>">
			<ul id="myUL">
				<?= $ListeQuotePrincipale ?>
			</ul>
		</div>
		<div class="column">
			<form method="post" name="quote" action="<?= $actionForm ?>" class="content-form" enctype="multipart/form-data" >
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
								<?= $langue->show_text('TableNewQuoteFor') ?>
							<td>
							<td>
								<select name="AddDevis">
									<?= $ListeSte ?>
								</select>
							<td>
						</tr>
						<tr>
							<td colspan="6" >
								<br/>
								<input type="submit" class="input-moyen" value="<?= $langue->show_text('TableNewButton') ?>" /> <br/>
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
		</div>
	</div>
	<div id="div2" class="tabcontent">
		<form method="post" name="Coment" action="<?=$actionForm; ?>" class="content-form" >
			<table class="content-table">
					<thead>
						<tr>
							<th colspan="5">
							<?= $langue->show_text('TableNumberQuote')  ?> <?= $DevisCODE  ?> <?= $langue->show_text('TableIndexQuote')  ?>  <?= $DevisINDICE  ?>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<input type="hidden" name="IdDevis" value="<?= $IDDevisSQL  ?>">
								<input type="hidden" name="CODEDevis" value="<?= $CODEDevis  ?>">
								<?= $langue->show_text('TableCodeLabel')  ?>
							</td>
							<td>
							<?= $DevisCODE ?>
							</td>
							<td>
								<input type="text" name="DevisLABEL" value="<?= $DevisLABEL  ?>" placeholder="<?= $langue->show_text('TableLabelquote')  ?>">
							</td>
						</tr>
						<tr>
							<td>
								<?= $langue->show_text('TableIndexLabel')  ?>
							</td>
							<td>
								<?= $DevisINDICE  ?>
							</td>
							<td>
								<input type="text" name="DevisLABELIndice" value="<?= $DevisLABEL_INDICE  ?>" placeholder="<?= $langue->show_text('TableLabelIndexquote') ?>">
							</td>
						</tr>
						<tr>
							<td>
								<?= $langue->show_text('TableCustomerReference')  ?>
							</td>
							<td>
								<input type="text" name="DevisReference" value="<?= $DevisREFERENCE ?>" placeholder="<?= $langue->show_text('TableCustomerReference') ?>" >
							</td>
							<td></td>
						</tr>
						<tr>
							<td>
								<?= $langue->show_text('TableCreationDate')  ?>
							</td>
							<td>
								<?= $DevisDATE  ?>
							</td>
							<td></td>
						</tr>
						<tr>
							<td>
								<?= $langue->show_text('TableValidityDate')  ?>	
							</td>
							<td>
								<input type="date" name="DevisDATE_VALIDITE" value="<?= $DevisDATE_VALIDITE  ?>" >
							</td>
							<td></td>
						</tr>
						<tr>
							<td>
								<?= $langue->show_text('TableQuoteStatu') ?>
							</td>
							<td>
								<select name="EtatDevis">
									<option value="1" <?= selected($DevisETAT, 1) ?>><?= $langue->show_text('SelectOpen') ?></option>
									<option value="2" <?= selected($DevisETAT, 2) ?>><?= $langue->show_text('SelectRefuse') ?></option>
									<option value="3" <?= selected($DevisETAT, 3) ?>><?= $langue->show_text('SelectSend') ?></option>
									<option value="4" <?= selected($DevisETAT, 4) ?>><?= $langue->show_text('SelectDecline') ?></option>
									<option value="5" <?= selected($DevisETAT, 5) ?>><?= $langue->show_text('SelectClosed') ?></option>
									<option value="6" <?= selected($DevisETAT, 6) ?>><?= $langue->show_text('SelectObsolete') ?></option>
								</select>
							</td>
							<td><input type="checkbox" id="DevisMajLigne" name="DevisMajLigne" checked="checked"><label ><?= $langue->show_text('UpdateQuoteLine') ?></label></td>
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
	<div id="div3" class="tabcontent">
		<form method="post" name="Coment" action="<?=$actionForm; ?>" class="content-form" >
			<table class="content-table-devis" style="width: 50%;">
				<thead>
					<tr>
						<th colspan="12" >
						<?= $langue->show_text('TableNumberQuote')  ?> <?= $DevisCODE  ?> <?= $langue->show_text('TableIndexQuote')  ?>  <?= $DevisINDICE  ?>
						</th>
					</tr>
					<tr>
						<th></th>
						<th><?= $langue->show_text('TableOrder')?></th>
						<th><?= $langue->show_text('TableArticle')?></th>
						<th><?= $langue->show_text('Tablelabel')?></th>
						<th><?= $langue->show_text('TableQty')?></th>
						<th><?= $langue->show_text('TableUnit')?></th>
						<th><?= $langue->show_text('TableUnitPrice')?></th>
						<th><?= $langue->show_text('TableDiscount')?></th>
						<th><?= $langue->show_text('TableTotal')?></th>
						<th><?= $langue->show_text('TableRate')?></th>
						<th><?= $langue->show_text('TableDelay')?></th>
						<th><?= $langue->show_text('TableStatu')?></th>
					</tr>
				</thead>
				<tbody>
					<?php
						///////////////////////////////
						//// LISTE DES LIGNES  ////
						///////////////////////////////

						$UnitListe ='<option value="0">Aucune</option>';
						$query='SELECT Id, LABEL   FROM '. TABLE_ERP_UNIT .'';
						foreach ($bdd->GetQuery($query) as $data){
							$UnitListe .='<option value="'. $data->Id .'" '. selected($ArticleUNIT_ID, $data->Id) .'>'. $data->LABEL .'</option>';
						}
					
						$query='SELECT Id, LABEL, TAUX FROM '. TABLE_ERP_TVA .' ORDER BY TAUX DESC';
						foreach ($bdd->GetQuery($query) as $data){
							$TVAListe .='<option value="'. $data->Id .'">'. $data->TAUX .'%</option>';
						}

						$query='SELECT  '. TABLE_ERP_DEVIS_LIGNE .'.Id,
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
														ORDER BY '. TABLE_ERP_DEVIS_LIGNE .'.ORDRE ';
						$tableauTVA = array();

						foreach ($bdd->GetQuery($query) as $data): 

							$TotalLigneHTEnCours = ($data->QT*$data->PRIX_U)-($data->QT*$data->PRIX_U)*($data->REMISE/100);
							$TotalLigneTVAEnCours =  $TotalLigneHTEnCours*($data->TAUX/100) ;
							$TotalLigneTTCEnCours = $TotalLigneTVAEnCours+$TotalLigneHTEnCours;

							$TotalLigneDevisHT += $TotalLigneHTEnCours;
							$TotalLigneDevisTTC += $TotalLigneTVAEnCours+$TotalLigneHTEnCours;

							if(array_key_exists($data->TVA_ID, $tableauTVA)){
								$tableauTVA[$data->TVA_ID][0] += $TotalLigneHTEnCours;
								$tableauTVA[$data->TVA_ID][2] += $TotalLigneTVAEnCours;
								$tableauTVA[$data->TVA_ID][3] += $TotalLigneTTCEnCours;
							}
							else{
								$tableauTVA[$data->TVA_ID] = array($TotalLigneHTEnCours, $data->TAUX, $TotalLigneTVAEnCours, $TotalLigneTTCEnCours);
							}
							$LignePourCommande .='
							<tr>
								<td><input type="hidden" name="UpdateIdLigneDevis[]" id="UpdateIdLigneDevis" value="'. $data->Id .'"></td>
								<td>
									<label class="container">
										<input type="checkbox" title="'. $data->id .'" name="id_ligne[]" value="'. $data->id .'" id="'. $data->id .'" checked="checked"/>
										<span class="checkmark"></span>
									</label>
								</td>
								<td>'. $data->LABEL .'</td>
								<td>'. $data->QT .'</td>
								<td>'. $data->PRIX_U .' €</td>
								<td>'. $data->REMISE .' %</td>
								<td>'.   $TotalLigneHTEnCours .' € </td>
								<td>'. $data->DELAIS .'</td>
							</tr>';

							?>
							<tr>
								<td><input type="hidden" name="UpdateIdLigneDevis[]" id="UpdateIdLigneDevis" value="<?= $data->Id ?>"><a href="index.php?page=quote&id=<?= $_GET['id'] ?>&amp;delete=<?= $data->Id ?>" title="Supprimer la ligne">x</a></td>
								<td><input type="number" name="UpdateORDRELigneDevis[]" value="<?= $data->ORDRE ?>" ></td>
								<td>
									<input list="Article" name="UpdateIDArticleLigneDevis[]" id="UpdateIDArticleLigneDevis" value="<?= $data->ARTICLE_CODE ?>">
									<datalist id="Article">
										<?= $ListeArticle ?>
									</datalist>
								</td>
								<td><input type="text"  name="UpdateLABELLigneDevis[]" value="<?= $data->LABEL ?>"></td>
								<td><input type="number"  name="UpdateQTLigneDevis[]" value="<?= $data->QT ?>" ></td>
								<td>
									<select  name="UpdateUNITLigneDevis[]">
									<option value="<?= $data->UNIT_ID ?>" <?= selected($data->UNIT_ID, $data->UNIT_ID) ?>><?= $data->LABEL_UNIT ?></option>
									<?= $UnitListe ?>
									</select>
								</td>
								<td><input type="number"  name="UpdatePrixLigneDevis[]" step=".001" value="<?= $data->PRIX_U ?>" ></td>
								<td><input type="number"   name="UpdateRemiseLigneDevis[]" min="0" max="100" step=".001" value="<?= $data->REMISE ?>" ></td>
								<td><?=   $TotalLigneHTEnCours ?> €</td>

								<td>
									<select  name="UpdateTVALigneDevis[]">
										<option value="<?= $data->TVA_ID ?>" selected><?= $data->TAUX ?>%</option>
										<?=  $TVAListe ?>
									</select>
								</td>
								<td><input type="date" name="UpdateDELAISLigneDevis[]" value="<?= $data->DELAIS ?>"></td>
								<td>
									<select  name="UpdateETATLigneDevis[]">
										<option value="1" <?= selected($data->ETAT, 1) ?>><?= $langue->show_text('SelectOpen') ?></option>
										<option value="2" <?= selected($data->ETAT, 2) ?>><?= $langue->show_text('SelectRefuse') ?></option>
										<option value="3" <?= selected($data->ETAT, 3) ?>><?= $langue->show_text('SelectSend') ?></option>
										<option value="4" <?= selected($data->ETAT, 4) ?>><?= $langue->show_text('SelectDecline') ?></option>
										<option value="5" <?= selected($data->ETAT, 5) ?>><?= $langue->show_text('SelectClosed') ?></option>
										<option value="6" <?= selected($data->ETAT, 6) ?>><?= $langue->show_text('SelectObsolete') ?></option>
									</select>
								</td>
							</tr>	
					</tr>
					<?php $i++; endforeach; ?>
					<tr>
						<th></th>
						<th></th>
						<th></th>
						<th colspan="2" ><?= $langue->show_text('TotalPriceWithOutTax')?></th>
						<th ><?= $langue->show_text('TableRate')?></th>
						<th colspan="2" ><?= $langue->show_text('TotalTax')?></th>
						<th><?= $langue->show_text('TotalPriceWithTax')?></th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
					<?php 
					///////////////////////////////
					//// FIN GESTION DES LIGNE DE DEVIS   ////
					///////////////////////////////

					asort($tableauTVA);
					foreach($tableauTVA as $key => $value):?>
					<tr>
						<th></th>
						<th></th>
						<th></th>
						<th colspan="2" ><?= $tableauTVA[$key][0] ?> €</th>
						<th><?= $tableauTVA[$key][1] ?> %</th>
						<th colspan="2" ><?= $tableauTVA[$key][2] ?> €</th>
						<th><?= $tableauTVA[$key][3] ?> €</th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
					<?php $i++; endforeach; ?>
					<tr>
						<th></th>
						<th></th>
						<th><?= $langue->show_text('TotalWithOutTax') ?></th>
						<th colspan="2"><?= $TotalLigneDevisHT ?> €</th>
						<th></th>
						<th colspan="2" ><?= $langue->show_text('TotalWithTax') ?></th>
						<th><?= $TotalLigneDevisTTC ?> €</th>
						<th></th>
						<th></th>
						<th></th>
					<tr>
					</tr>
						<th colspan="12" >
							<?= $langue->show_text('Addline') ?>
						</th>
					</tr>
					<tr>
						<td></td>
						<td><input type="number" name="" id="AddORDRELigneDevis" placeholder="10"  value="10"></td>
						<td>
							<input list="Article" name="AddARTICLELigneDevis" id="AddARTICLELigneDevis">
							<datalist id="Article">
								<?= $ListeArticle ?>
							</datalist>
						</td>
						<td><input type="text"  name="" id="AddLABELLigneDevis" placeholder="Désignation"></td>
						<td><input type="number"  name="" id="AddQTLigneDevis" placeholder="1"  value="1"></td>
						<td>
							<select name="" id="AddUNITLigneDevis">
								<?= $UnitListe ?>
							</select>
						</td>
						<td><input type="number"  name="" id="AddPrixLigneDevis" step=".001" placeholder="10 €"  value="0"></td>
						<td><input type="number"  name="" id="AddRemiseLigneDevis" min="0" max="100" step=".001" placeholder="0 %" value="0"></td>
						<td></td>
						<td>
							<select name="" id="AddTVALigneDevis">
								<?=  $TVAListe ?>
							</select>
						</td>
						<td><input type="date" name="" id="AddDELAISigneDevis" required="required"></td>
						<td></td>
					</tr>
					<tr>
						<td colspan="12" >
							<input type="button" class="add" value="<?= $langue->show_text('Addline') ?>">
							<input type="button" class="delete" value="<?= $langue->show_text('Deleteline') ?>">
							<input type="submit" class="input-moyen" value="<?= $langue->show_text('UpdateQuoteLine') ?>" />
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
	<div id="div4" class="tabcontent">
		<form method="post" name="Coment" action="<?=$actionForm; ?>" class="content-form" >
			<table class="content-table" style="width: 50%;">
				<thead>
					<tr>
						<th colspan="2" >
							<?= $langue->show_text('TableNumberQuote') ?> <?= $DevisCODE ?> <?= $langue->show_text('TableIndexQuote') ?>  <?= $DevisINDICE ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<input type="hidden" name="CODEDevis" value="<?= $CODEDevis ?>">
							<?= $langue->show_text('TableUserCreate') ?>
						</td>
						<td>
							<?= $DevisNomName ?> <?= $DevisNomPrenom ?>
						</td>
					</tr>
					<tr>
						<td>
							<?= $langue->show_text('TableSalesManager') ?>
						</td>
						<td>
							<select name="RepsComDevis">
								<?=  $EmployeeListe1 ?>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<?= $langue->show_text('TableTechnicalManager') ?>
						</td>
						<td>
							<select name="RespTechDevis">
								<?= $EmployeeListe2 ?>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2" >
							<input type="submit" class="input-moyen" value="<?= $langue->show_text('TableUpdateButton') ?>" />
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
	<div id="div5" class="tabcontent">
		<form method="post" name="Coment" action="<?=$actionForm; ?>" class="content-form" >
			<table class="content-table" style="width: 50%;">
				<thead>
					<tr>
						<th colspan="2" >
							<?= $langue->show_text('TableNumberQuote') ?> <?= $DevisCODE ?> <?= $langue->show_text('TableIndexQuote') ?>  <?= $DevisINDICE ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<input type="hidden" name="CODEDevis" value="<?= $CODEDevis ?>">
							<?= $langue->show_text('TableContact') ?>
						</td>
						<td>
							<select name="ContactDevis">
							<?= $ContactDevisListe1 ?>
							</select>
						</td>
					</tr>
					<tr>
						<td>
						<?= $langue->show_text('TableAdresseDelevery') ?>
						</td>
						<td>
							<select name="AdresseLivraisonDevis">
							<?=  $AdresseLivraisonListe1 ?>
							</select>
						</td>
					</tr>
					<tr>
						<td>
						<?= $langue->show_text('TableAdresseInvoice') ?>
						</td>
						<td>
							<select name="AdresseFacturationDevis">
								<?=  $AdresseFacturationListe1 ?>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2" >
							<input type="submit" class="input-moyen" value="<?= $langue->show_text('TableUpdateButton') ?>" />
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
	<div id="div6" class="tabcontent">
		<form method="post" name="Coment" action="<?=$actionForm; ?>" class="content-form" >
			<table class="content-table" style="width: 50%;">
				<thead>
					<tr>
						<th colspan="2" >
							<?= $langue->show_text('TableNumberQuote') ?> <?= $DevisCODE ?> <?= $langue->show_text('TableIndexQuote') ?>  <?= $DevisINDICE ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<input type="hidden" name="CODEDevis" value="<?= $CODEDevis ?>">
							<?= $langue->show_text('TableCondiList') ?>
						</td>
						<td>
							<select name="CondiRegDevis">
								<?= $CondiListe1 ?>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<?= $langue->show_text('TableMethodList') ?>
						</td>
						<td>
							<select name="ModeRegDevis">
								<?=  $RegListe1 ?>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<?= $langue->show_text('TimeLinePayement') ?>
						</td>
						<td>
							<select name="EcheancierDevis">
								<?=  $EcheancierListe1 ?>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<?= $langue->show_text('TableDeleveryMode') ?>
						</td>
						<td>
							<select name="ModeLivraisonDevis">
							<?=  $TransportListe1 ?>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2" >
							<input type="submit" class="input-moyen" value="<?= $langue->show_text('TableUpdateButton') ?>" />
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
	<div id="div7" class="tabcontent">
		<form method="post" name="Coment" action="<?=$actionForm; ?>" class="content-form" >
			<table class="content-table" style="width: 50%;">
				<thead>
					<tr>
						<th>
						<?= $langue->show_text('TableNumberQuote') ?> <?= $DevisCODE ?> <?= $langue->show_text('TableIndexQuote') ?>  <?= $DevisINDICE ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<input type="hidden" name="CODEDevis" value="<?= $CODEDevis ?>">
							<textarea class="Comment" name="Comment" rows="40" ><?= $CommentaireDevis ?></textarea>
						</td>
					</tr>
					<tr>
						<td>
							<input type="submit" class="input-moyen" value="<?= $langue->show_text('TableUpdateButton') ?>" />
						</td>
					</tr>
				</tbody>
			</table>?>
		</form>
	</div>
	<div id="div8" class="tabcontent">
		<form method="post" name="Coment" action="commandes.php" class="content-form" >	
				<div class="column">
					<table class="content-table" >
						<thead>
							<tr>
								<th colspan="9" >
									<?= $langue->show_text('TableNumberQuote') ?> <?= $DevisCODE ?> <?= $langue->show_text('TableIndexQuote') ?>  <?= $DevisINDICE ?>
								</th>
							</tr>
						</thead>
						<tbody>
							<?= $LignePourCommande  ?>
						</tbody>
					</table>
				</div>
				<div class="column">
					<table class="content-table" >
						<thead>
							<tr>
								<th colspan="12" >
								<?= $langue->show_text('TableSelectOrder') ?>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<input type="radio" id="new" name="AddCmd" value="0"><label for="new"><?= $langue->show_text('TableNewOrder') ?></label>
							</td>
						</tr>
						<?php
						$query='SELECT '. TABLE_ERP_COMMANDE .'.id,
										'. TABLE_ERP_COMMANDE .'.CODE,
										'. TABLE_ERP_COMMANDE .'.LABEL,
										'. TABLE_ERP_CLIENT_FOUR .'.NAME
								FROM '. TABLE_ERP_COMMANDE .'
									LEFT JOIN `'. TABLE_ERP_CLIENT_FOUR .'` ON `'. TABLE_ERP_COMMANDE .'`.`CLIENT_ID` = `'. TABLE_ERP_CLIENT_FOUR .'`.`id`
								ORDER BY '. TABLE_ERP_COMMANDE .'.id';
						$i = 1;
						foreach ($bdd->GetQuery($query) as $data): ?>
						<tr>
							<td>
								<input type="radio" id="new<?= $data->id ?>" name="AddCmd" value="<?= $data->id ?>"><label for="new<?= $data->id ?>"><?= $data->CODE ?> - <?= $data->NAME ?></label>
							</td>
						</tr>
						<?php $i++; endforeach; ?>
					</tbody>
				</table>
			</div>
			<div class="column">
				<table class="content-table" >
					<thead>
						<tr>
							<th colspan="12" >
							<?= $langue->show_text('TableGeneralInfo') ?>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
							<?= $langue->show_text('TableCustomerReference') ?> <input type="text" name="AddReferenceClient" placeholder="<?= $langue->show_text('TableNumberCustomerOrder') ?>">
							</td>
						</tr>
						<tr>
							<td>
							<?= $langue->show_text('TableDeleveryDate') ?> <input type="date" name="AddDELAISCommande" required="required">
							</td>
						</tr>
						<tr>
							<td>
								<input type="submit" class="input-moyen" value="<?= $langue->show_text('TableCreateOrder') ?>" />
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</form>
	</div>