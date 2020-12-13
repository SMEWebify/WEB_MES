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
	////  PARAMETRE DE L'ENTREPRISE  ////
	//////////////////////////////////

	if(isset($_POST['CompanyName']) AND !empty($_POST['CompanyName'])){

		$dossier = 'images/';
		$fichier = basename($_FILES['fichier_LOGO']['name']);

		move_uploaded_file($_FILES['fichier_LOGO']['tmp_name'], $dossier . $fichier);

		$UpdateCompanyName = $_POST['CompanyName'];
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

		If(empty($fichier)){
			$AddSQL = '';
		}
		else{
			$AddSQL = 'LOGO = \''. addslashes($UpdateCompanyLogo) .'\',';
		}


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
																WHERE Id=1');

		$req = $bdd -> query('SELECT NAME,
							ADDRESS,
							CITY,
							ZIPCODE,
							REGION,
							COUNTRY,
							PHONE_NUMBER,
							MAIL,
							WEB_SITE,
							FACEBOOK_SITE,
							TWITTER_SITE,
							LKD_SITE,
							LOGO,
							SIREN,
							APE,
							TVA_INTRA,
							TAUX_TVA,
							CAPITAL,
							RCS
							FROM '. TABLE_ERP_COMPANY .'');

		$donnees = $req->fetch();

		$CompanyName = $donnees['NAME'];
		$CompanyAddress = $donnees['ADDRESS'];
		$CompanyCity = $donnees['CITY'];
		$CompanyZipCode= $donnees['ZIPCODE'];
		$CompanyCountry = $donnees['COUNTRY'];
		$CompanyRegion = $donnees['REGION'];
		$CompanyPhone = $donnees['PHONE_NUMBER'];
		$CompanyMail = $donnees['MAIL'];
		$CompanyWebSite = $donnees['WEB_SITE'];
		$CompanyFbSite = $donnees['FACEBOOK_SITE'];
		$CompanyTwitter = $donnees['TWITTER_SITE'];
		$CompanyLkd = $donnees['LKD_SITE'];
		$CompanyLogo = $donnees['LOGO'];
		$CompanySIREN = $donnees['SIREN'];
		$CompanyAPE = $donnees['APE'];
		$CompanyTVAINTRA = $donnees['TVA_INTRA'];
		$CompanyTAUXTVA = $donnees['TAUX_TVA'];
		$CompanyCAPITAL = $donnees['CAPITAL'];
		$CompanyRCS = $donnees['RCS'];
	}

	$contenu1 = '
				<tr>
					<td>Nom de la Société</td>
					<td>Adresse</td>
					<td>Ville</td>
					<td>Code postal</td>
					<td>Région</td>
					<td>Pays</td>
				</tr>
				<tr>
					<td >
						<input type="text" name="CompanyName" value="'. $CompanyName .'" >
					</td>
					<td >
						<input type="text" name="CompanyAddress" value="'. $CompanyAddress .'" >
					</td>
					<td >
						<input type="text" name="CompanyCity" value="'. $CompanyCity .'" >
					</td>
					<td >
						<input type="text" name="CompanyZipCode" value="'. $CompanyZipCode .'" size="10">
					</td>
					<td >
						<input type="text" name="CompanyRegion" value="'. $CompanyRegion .'" size="10">
					</td>
					<td >
						<input type="text" name="CompanyCountry" value="'. $CompanyCountry .'" size="10">
					</td>
				</tr>
				<tr>
					<td>Numéro de téléphone</td>
					<td>Mail</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td >
						<input type="text" name="CompanyPhone" value="'. $CompanyPhone .'" size="10">
					</td>
					<td >
						<input type="text" name="CompanyMail" value="'. $CompanyMail .'" >
					</td>
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
				</tr>
				<tr>
					<td >
						<input type="text" name="CompanyWebSite" value="'. $CompanyWebSite .'" size="10">
					</td>
					<td >
						<input type="text" name="CompanyFbSite" value="'. $CompanyFbSite .'" size="10">
					</td>
					<td >
						<input type="text" name="CompanyTwitter" value="'. $CompanyTwitter .'" size="10">
					</td>
					<td >
						<input type="text" name="CompanyLkd" value="'. $CompanyLkd .'" size="10">
					</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>SIREN</td>
					<td>Code APE</td>
					<td>TVA INTRA</td>
					<td>Taux TVA</td>
					<td>CAPITAL</td>
					<td>RCS</td>
				</tr>
				<tr>
					<td >
						<input type="text" name="CompanySIREN" value="'. $CompanySIREN .'" >
					</td>
					<td >
						<input type="text" name="CompanyAPE" value="'. $CompanyAPE .'" size="10">
					</td>
					<td >
						<input type="text" name="CompanyTVAINTRA" value="'. $CompanyTVAINTRA .'" >
					</td>
					<td >
						<input type="text" name="CompanyTAUXTVA" value="'. $CompanyTAUXTVA .'" size="10">
					</td>
					<td>
						<input type="text" name="CompanyCAPITAL" value="'. $CompanyCAPITAL .'" >
					</td>
					<td>
						<input type="text" name="CompanyRCS" value="'. $CompanyRCS .'" size="10">
					</td>
				</tr>
				<tr>
					<td colspan=6">Logo</td>
				</tr>
				<tr>
					<td colspan=6" ><input type="file" name="fichier_LOGO" /></td>
				</tr>
				<tr>
					<td colspan=6"><img src="'. $CompanyLogo .'" title="LOGO entreprise" alt="Logo" /></td>
				</tr>
				';

	////////////////////////
	//// SECTOR ACTIVITY////
	///////////////////////

	if(isset($_POST['AddCODESector']) AND !empty($_POST['AddCODESector'])){

		$req = $bdd->exec("INSERT INTO ". TABLE_ERP_ACTIVITY_SECTOR ." VALUE ('0',
																		'". addslashes($_POST['AddCODESector']) ."',
																		'". addslashes($_POST['AddLABELSector']) ."')");

	}

	if(isset($_POST['id_sector']) AND !empty($_POST['id_sector'])){

		$UpdateIdSector = $_POST['id_sector'];
		$UpdateCODESector = $_POST['UpdateCODESector'];
		$UpdateLABELSector = $_POST['UpdateLABELSector'];

		$i = 0;
		foreach ($UpdateIdSector as $id_generation) {

			$bdd->exec('UPDATE `'. TABLE_ERP_ACTIVITY_SECTOR .'` SET  CODE = \''. addslashes($UpdateCODESector[$i]) .'\',
																LABEL = \''. addslashes($UpdateLABELSector[$i]) .'\'
																WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
	}

	$i = 1;
	$req = $bdd -> query('SELECT '. TABLE_ERP_ACTIVITY_SECTOR .'.Id,
									'. TABLE_ERP_ACTIVITY_SECTOR .'.CODE,
									'. TABLE_ERP_ACTIVITY_SECTOR .'.LABEL
									FROM `'. TABLE_ERP_ACTIVITY_SECTOR .'`
									ORDER BY Id');

	while ($donnees_sector = $req->fetch())
	{
		 $contenu2 = $contenu2 .'
				<tr>
					<td>'. $i .' <input type="hidden" name="id_sector[]" id="id_sector" value="'. $donnees_sector['Id'] .'"></td>
					<td><input type="text" name="UpdateCODESector[]" value="'. $donnees_sector['CODE'] .'" size="10"></td>
					<td><input type="text" name="UpdateLABELSector[]" value="'. $donnees_sector['LABEL'] .'" ></td>
				</tr>	';
		$i++;
	}

	////////////////////////
	//// NUM DOCUMENTS ////
	///////////////////////



	if(isset($_POST['AddDOCNum']) AND !empty($_POST['AddDOCNum'])){

		$req = $bdd->exec("INSERT INTO ". TABLE_ERP_NUM_DOC ." VALUE ('0',
																		'". addslashes($_POST['AddDOCNum']) ."',
																		'". addslashes($_POST['AddModeleNum']) ."',
																		'". addslashes($_POST['AddDigitNum']) ."',
																		'0')");

	}

	if(isset($_POST['id_NumDoc']) AND !empty($_POST['id_NumDoc'])){

		$UpdateIdNumDoc = $_POST['id_NumDoc'];
		$UpdateDOCNum = $_POST['UpdateDOCNum'];
		$UpddateModeleNum = $_POST['UpddateModeleNum'];

		$i = 0;
		foreach ($UpdateIdNumDoc as $id_generation) {

			$bdd->exec('UPDATE `'. TABLE_ERP_NUM_DOC .'` SET  DOC_TYPE = \''. addslashes($UpdateDOCNum[$i]) .'\',
																MODEL = \''. addslashes($UpddateModeleNum[$i]) .'\'
																WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
	}

	$i = 1;
	$req = $bdd -> query('SELECT '. TABLE_ERP_NUM_DOC .'.Id,
									'. TABLE_ERP_NUM_DOC .'.DOC_TYPE,
									'. TABLE_ERP_NUM_DOC .'.MODEL,
									'. TABLE_ERP_NUM_DOC .'.DIGIT,
									'. TABLE_ERP_NUM_DOC .'.COMPTEUR
									FROM `'. TABLE_ERP_NUM_DOC .'`
									ORDER BY Id');

	while ($donnees_Num_doc = $req->fetch())
	{

		$Exemple = NumDoc($donnees_Num_doc['MODEL'],$donnees_Num_doc['COMPTEUR'], $donnees_Num_doc['DIGIT']);

		 $contenu4 = $contenu4 .'
				<tr>
					<td>'. $i .' <input type="hidden" name="id_NumDoc[]" id="id_NumDoc" value="'. $donnees_Num_doc['Id'] .'"></td>
					<td>
						<select name="UpdateDOCNum[]">
							<option value="0" '. selected($donnees_Num_doc['DOC_TYPE'], 0) .'>Accusés de reception</option>
							<option value="1" '. selected($donnees_Num_doc['DOC_TYPE'], 1) .'>Bon de livraison fournisseur</option>
							<option value="2" '. selected($donnees_Num_doc['DOC_TYPE'], 2) .'>Bon de retour client</option>
							<option value="3" '. selected($donnees_Num_doc['DOC_TYPE'], 3) .'>Bon de livraison</option>
							<option value="4" '. selected($donnees_Num_doc['DOC_TYPE'], 4) .'>Commande</option>
							<option value="5" '. selected($donnees_Num_doc['DOC_TYPE'], 5) .'>Commande d\'achat</option>
							<option value="6" '. selected($donnees_Num_doc['DOC_TYPE'], 6) .'>Commande interne</option>
							<option value="7" '. selected($donnees_Num_doc['DOC_TYPE'], 7) .'>Consultation</option>
							<option value="8" '. selected($donnees_Num_doc['DOC_TYPE'], 8) .'>Devis</option>
							<option value="9" '. selected($donnees_Num_doc['DOC_TYPE'], 9) .'>Facture</option>
							<option value="10" '. selected($donnees_Num_doc['DOC_TYPE'], 10) .'>Facture fournisseur</option>
							<option value="11" '. selected($donnees_Num_doc['DOC_TYPE'], 11) .'>Fiche non conformité</option>
						</select>
					</td>
					<td><input type="text" class="input-moyen-vide" name="UpddateModeleNum[]" value="'. $donnees_Num_doc['MODEL'] .'" ></td>
					<td>'. $donnees_Num_doc['DIGIT'] .'</td>
					<td>'. $donnees_Num_doc['COMPTEUR'] .'</td>
					<td>'. $Exemple .'</td>
				</tr>';
		$i++;
	}

	////////////////////////
	//// EMAIL ////
	///////////////////////


	if(isset($_POST['AddCODEMail']) AND !empty($_POST['AddCODEMail'])){

		$req = $bdd->exec("INSERT INTO ". TABLE_ERP_EMAIL ." VALUE ('0',
																		'". addslashes($_POST['AddCODEMail']) ."',
																		'". addslashes($_POST['AddLABELMAIL']) ."',
																		'". addslashes($_POST['AddOBJETMail']) ."',
																		'". addslashes($_POST['AddTEXTMAIL']) ."')");

	}

	if(isset($_POST['UpdateIdMail']) AND !empty($_POST['UpdateIdMail'])){

		$UpdateIdMail = $_POST['UpdateIdMail'];
		$UpddateObjetMail = $_POST['UpddateObjetMail'];
		$UpddateTextMail = $_POST['UpddateTextMail'];

			$bdd->exec('UPDATE `'. TABLE_ERP_EMAIL .'` SET  OBJET = \''. addslashes($UpddateObjetMail) .'\',
																TEXT = \''. addslashes($UpddateTextMail) .'\'
																WHERE id = '. $UpdateIdMail.'');

	}

	$i = 1;
	$req = $bdd -> query('SELECT '. TABLE_ERP_EMAIL .'.Id,
									'. TABLE_ERP_EMAIL .'.CODE,
									'. TABLE_ERP_EMAIL .'.LABEL,
									'. TABLE_ERP_EMAIL .'.OBJET,
									'. TABLE_ERP_EMAIL .'.TEXT
									FROM `'. TABLE_ERP_EMAIL .'`
									ORDER BY Id');

	while ($donnees_Mail = $req->fetch())
	{

		 $contenu3 = $contenu3 .'
				<tr>
					<td></td>
					<td><a href="manage-company.php?mail='. $donnees_Mail['Id'] .'">'. $donnees_Mail['CODE'] .'</a></td>
					<td><a href="manage-company.php?mail='. $donnees_Mail['Id'] .'">'. $donnees_Mail['LABEL'] .'</a></td>
					<td><a href="manage-company.php?mail='. $donnees_Mail['Id'] .'">'. $donnees_Mail['OBJET'] .'</a></td>
					<td>'. extrait($donnees_Mail['TEXT']) .'</td>
				</tr>';
		$i++;
	}

	if(isset($_GET['mail']) AND !empty($_GET['mail'])){

		$req = $bdd -> query('SELECT '. TABLE_ERP_EMAIL .'.Id,
									'. TABLE_ERP_EMAIL .'.CODE,
									'. TABLE_ERP_EMAIL .'.LABEL,
									'. TABLE_ERP_EMAIL .'.OBJET,
									'. TABLE_ERP_EMAIL .'.TEXT
									FROM `'. TABLE_ERP_EMAIL .'`
									WHERE id = '. addslashes($_GET['mail']).'');
		$donnees_Mail = $req->fetch();

		 $contenu3 = $contenu3 .'
					<tr>
						<td><input type="hidden" name="UpdateIdMail" value="'. $donnees_Mail['Id'] .'">Objet :</td>
						<td colspan="3"><input type="text" name="UpddateObjetMail" value="'. $donnees_Mail['OBJET'] .'" ></td>
						<td></td>
					</tr>
					<tr>
						<td>Message :</td>
						<td colspan="3" >
							<textarea id="UpddateTextMail" name="UpddateTextMail" rows="10" cols="100" style="align-content:left; white-space: normal;">'. $donnees_Mail['TEXT'] .'</textarea>
						</td>
						<td>
							<p>
								<01> - Politesse du contact<br/>
								<02> - Civilité du contact<br/>
								<03> - Nom du contact<br/>
								<04> - Prénom du contact<br/>
								<05> - Code du documents<br/>
								<06> - Desciption du documents<br/>
								<07> - Date du documents<br/>
								<08> - Commentaire du document<br/>
							</p>
						</td>
					</tr>';


	}

	////////////////////////
	//// TIMELINE ////
	///////////////////////


	if(isset($_POST['AddTEXTTIMELINE']) AND !empty($_POST['AddTEXTTIMELINE'])){

		$req = $bdd->exec("INSERT INTO ". TABLE_ERP_INFO_GENERAL ." VALUE ('0',
																		'". addslashes($_POST['AddEtatTIMELINE']) ."',
																		'". time() ."',
																		'". addslashes($_POST['AddTEXTTIMELINE']) ."')");

	}

	if(isset($_POST['UpdateIdTimeLine']) AND !empty($_POST['UpdateIdTimeLine'])){

		$UpdateIdTimeLine = $_POST['UpdateIdTimeLine'];
		$UpddateEtatTimeLine = $_POST['UpddateEtatTimeLine'];
		$UpddateTextTimeLine = $_POST['UpddateTextTimeLine'];

			$bdd->exec('UPDATE `'. TABLE_ERP_INFO_GENERAL .'` SET  ETAT = \''. addslashes($UpddateEtatTimeLine) .'\',
																TEXT = \''. addslashes($UpddateTextTimeLine) .'\'
																WHERE id = '. $UpdateIdTimeLine.'');

	}

	$i = 1;
	$req = $bdd -> query('SELECT '. TABLE_ERP_INFO_GENERAL .'.Id,
									'. TABLE_ERP_INFO_GENERAL .'.TIMESTAMP,
									'. TABLE_ERP_INFO_GENERAL .'.ETAT,
									'. TABLE_ERP_INFO_GENERAL .'.TEXT
									FROM `'. TABLE_ERP_INFO_GENERAL .'`
									ORDER BY Id');

	while ($donnees_TimeLine = $req->fetch())
	{
		if($donnees_TimeLine['ETAT'] == 2){$EtatTimeLine = "En édition";}
		if($donnees_TimeLine['ETAT'] == 1){$EtatTimeLine = "Afficher";}
		if($donnees_TimeLine['ETAT'] == 0){$EtatTimeLine = "Non publiée";}

		 $contenu5 = $contenu5 .'
				<tr>
					<td></td>
					<td><a href="manage-company.php?timeline='. $donnees_TimeLine['Id'] .'">'. $EtatTimeLine .'</a></td>
					<td><a href="manage-company.php?timeline='. $donnees_TimeLine['Id'] .'">'. extrait($donnees_TimeLine['TEXT']) .'</a></td>
					<td><a href="manage-company.php?timeline='. $donnees_TimeLine['Id'] .'">'. format_temps($donnees_TimeLine['TIMESTAMP']) .'</a></td>
				</tr>';
		$i++;
	}

	if(isset($_GET['timeline']) AND !empty($_GET['timeline'])){

		$req = $bdd -> query('SELECT '. TABLE_ERP_INFO_GENERAL .'.Id,
									'. TABLE_ERP_INFO_GENERAL .'.ETAT,
									'. TABLE_ERP_INFO_GENERAL .'.TEXT
									FROM `'. TABLE_ERP_INFO_GENERAL .'`
									WHERE id = '. addslashes($_GET['timeline']).'');
		$donnees_TimeLine = $req->fetch();

		 $contenu5 = $contenu5 .'
					<tr>
						<td><input type="hidden" name="UpdateIdTimeLine" value="'. $donnees_TimeLine['Id'] .'">Etat :</td>
						<td>
							<select name="UpddateEtatTimeLine">
									<option value="2" '. selected($donnees_TimeLine['ETAT'], 2) .'>En édition</option>
									<option value="1" '. selected($donnees_TimeLine['ETAT'], 1) .'>Afficher</option>
									<option value="0" '. selected($donnees_TimeLine['ETAT'], 0) .'>Non publiée</option>
								</select>
						</td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td>Message :</td>
						<td colspan="3" >
							<textarea id="UpddateTextTimeLine" name="UpddateTextTimeLine" rows="10" cols="100" style="align-content:left; white-space: normal;">'. $donnees_TimeLine['TEXT'] .'</textarea>
						</td>
					</tr>';
	}

	if(isset($_GET['mail']) AND !empty($_GET['mail'])){
		$ParDefautDiv3 = 'id="defaultOpen"';
	}
	elseif(isset($_GET['timeline']) AND !empty($_GET['timeline'])){
		$ParDefautDiv5 = 'id="defaultOpen"';
	}
	else{
		$ParDefautDiv1 = 'id="defaultOpen"';
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
		<button class="tablinks" onclick="openDiv(event, 'div1')" <?php echo $ParDefautDiv1; ?>>Gestion de la société</button>
		<button class="tablinks" onclick="openDiv(event, 'div2')">Secteurs d'activités</button>
		<button class="tablinks" onclick="openDiv(event, 'div3')"<?php echo $ParDefautDiv3; ?>>Gestion des e-mails</button>
		<button class="tablinks" onclick="openDiv(event, 'div4')">Numérotation des documents</button>
		<button class="tablinks" onclick="openDiv(event, 'div5')" <?php echo $ParDefautDiv5; ?>>Timeline Informations</button>
	</div>
	<div id="div1" class="tabcontent" >
			<form method="post" name="Company" action="manage-company.php" class="content-form" enctype="multipart/form-data" >
				<table class="content-table">
					<thead>
						<tr>
							<th colspan="5">
								  <br/>
							</th>
							<th>

							</th>
						</tr>
					</thead>
					<tbody>
<?php
								Echo $contenu1;
?>
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
			<form method="post" name="Section" action="manage-company.php" class="content-form" >
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
								Echo $contenu2;
?>
						<tr>
							<td>Ajout</td>
							<td><input type="text" class="input-moyen-vide" name="AddCODESector"></td>
							<td><input type="text" class="input-moyen-vide" name="AddLABELSector" ></td>
						</tr>
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
	<div id="div3" class="tabcontent" >
		<form method="post" name="Section" action="manage-company.php" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th>CODE</th>
							<th>Desciption</th>
							<th>Objet</th>
							<th>Texte</th>
						</tr>
					</thead>
					<tbody>
<?php
								Echo $contenu3;
?>
						<tr>
							<td>Ajout</td>
							<td><input type="text" class="input-moyen-vide" name="AddCODEMail" ></td>
							<td><input type="text" class="input-moyen-vide" name="AddLABELMAIL" ></td>
							<td><input type="text" class="input-moyen-vide" name="AddOBJETMail" ></td>
							<td><input type="text" class="input-moyen-vide" name="AddTEXTMAIL" ></td>
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
	<div id="div4" class="tabcontent" >
			<form method="post" name="Section" action="manage-company.php" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th>Document</th>
							<th>Modèle</th>
							<th>Nombre de digits</th>
							<th>Compteur actuel</th>
							<th>Exemple</th>
						</tr>
					</thead>
					<tbody>
							<?php

								Echo $contenu4;
							?>
						<tr>
							<td>Ajout</td>
							<td>
								<select name="AddDOCNum">
									<option value="0">Accusés de reception</option>
									<option value="1">Bon de livraison fournisseur</option>
									<option value="2">Bon de retour client</option>
									<option value="3">Bon de livraison</option>
									<option value="4">Commande</option>
									<option value="5">Commande d'achat</option>
									<option value="6">Commande interne</option>
									<option value="7">Consultation</option>
									<option value="8">Devis</option>
									<option value="9">Facture</option>
									<option value="10">Facture fournisseur</option>
									<option value="11">Fiche non conformité</option>
								</select>
							</td>
							<td><input type="text" class="input-moyen-vide" name="AddModeleNum" ></td>
							<td><input type="number" class="input-moyen-vide" name="AddDigitNum" ></td>
							<td></td>
							<td></td>
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
	<div id="div5" class="tabcontent" >
				<form method="post" name="TimeLine" action="manage-company.php" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th>Etat</th>
							<th>Texte</th>
							<th>Posté le :</th>
						</tr>
					</thead>
					<tbody>
							<?php

								Echo $contenu5;
							?>
						<tr>
							<td>Ajout</td>
							<td>
								<select name="AddEtatTIMELINE">
									<option value="2">En édition</option>
									<option value="1">Afficher</option>
									<option value="0">Non publiée</option>
								</select>
							</td>
							<td><input type="text" class="input-moyen-vide" name="AddTEXTTIMELINE" ></td>
							<td></td>
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
</body>
</html>
