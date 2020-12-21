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
	$langue = new Language('lang', 'manage-methodes', $UserLanguage);
	//init call out box for notification
	$CallOutBox = new CallOutBox();

	//Check if the user is authorized to view the page
	if($_SESSION['page_10'] != '1'){
		stop($langue->show_text('SystemInfoAccessDenied'), 161, 'login.php');
	}

	//if add new service
	if(isset($_POST['AddPosteCharge']) AND !empty($_POST['AddPosteCharge'])){

		$dossier = 'images/Presta/';
		$fichier = basename($_FILES['IMAGEPosteCharge']['name']);
		move_uploaded_file($_FILES['IMAGEPosteCharge']['tmp_name'], $dossier . $fichier);
		$IsertPrestaImage = $dossier.$fichier;

		$req = $bdd->exec("INSERT INTO ". TABLE_ERP_PRESTATION ." VALUE ('0',
																		'". addslashes($_POST['CODEPosteCharge']) ."',
																		'". $_POST['ORDREPosteCharge'] ."',
																		'". addslashes($_POST['AddPosteCharge']) ."',
																		'". $_POST['TYPEPosteCharge'] ."',
																		'". $_POST['TAUXPosteCharge'] ."',
																		'". $_POST['MARGEPosteCharge'] ."',
																		'". $_POST['COLORPosteCharge'] ."',
																		'". addslashes($IsertPrestaImage) ."',
																		'')");
		$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddServiceNotification')));
	}

	//update service list 
	if(isset($_POST['id_presta']) AND !empty($_POST['id_presta'])){
		$UpdateIdPresta = $_POST['id_presta'];
		$UpdateORDREpresta = $_POST['ORDREpresta'];
		$UpdateCODEpresta = $_POST['CODEpresta'];
		$UpdateLABELpresta = $_POST['LABELpresta'];
		$UpdateTYPEpresta = $_POST['TYPEpresta'];
		$UpdateTAUX_Hpresta = $_POST['TAUX_Hpresta'];
		$UpdateMARGEpresta = $_POST['MARGEpresta'];
		$UpdateCOLORpresta = $_POST['COLORpresta'];
		$UpdateINAGEpresta = $_POST['INAGEpresta'];

		$i = 0;
		foreach ($UpdateIdPresta as $id_generation) {
			$bdd->exec('UPDATE `'. TABLE_ERP_PRESTATION .'` SET  CODE = \''. addslashes($UpdateCODEpresta[$i]) .'\',
																ORDRE = \''. $UpdateORDREpresta[$i] .'\',
																LABEL = \''. addslashes($UpdateLABELpresta[$i]) .'\',
																TYPE = \''. $UpdateTYPEpresta[$i] .'\',
																TAUX_H = \''. $UpdateTAUX_Hpresta[$i] .'\',
																MARGE = \''. $UpdateMARGEpresta[$i] .'\',
																COLOR = \''. $UpdateCOLORpresta[$i] .'\',
																IMAGE = \''. addslashes($UpdateINAGEpresta[$i]) .'\'
																WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateServiceNotification')));
	}

	//add new section in db
	if(isset($_POST['AddSection']) AND !empty($_POST['AddSection'])){
		$req = $bdd->exec("INSERT INTO ". TABLE_ERP_SECTION ." VALUE ('0',
																		'". $_POST['ORDRESection'] ."',
																		'". addslashes($_POST['CODESection']) ."',
																		'". addslashes($_POST['AddSection']) ."',
																		'". $_POST['TAUXHSection'] ."',
																		'". $_POST['RESPSection'] ."',
																		'". $_POST['COLORSection'] ."')");
		$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddSectionNotification')));
	}

	if(isset($_POST['id_section']) AND !empty($_POST['id_section'])){

		$UpdateIdSection = $_POST['id_section'];
		$UpdateORDRESection = $_POST['UpdateORDRESection'];
		$UpdateCODESection = $_POST['UpdateCODESection'];
		$UpdateLABELSection = $_POST['UpdateLABELSection'];
		$UpdateTAUX_HSection = $_POST['UpdateTAUX_HSection'];
		$UpdateRESPONSABLESection = $_POST['UpdateRESPONSABLESection'];
		$UpdateCOLORSection = $_POST['UpdateCOLORSection'];

		$i = 0;
		foreach ($UpdateIdSection as $id_generation) {

			$bdd->exec('UPDATE `'. TABLE_ERP_SECTION .'` SET  ORDRE = \''. $UpdateORDRESection[$i] .'\',
																CODE = \''. addslashes($UpdateCODESection[$i]) .'\',
																LABEL = \''. addslashes($UpdateLABELSection[$i]) .'\',
																COUT_H = \''. $UpdateTAUX_HSection[$i] .'\',
																RESPONSABLE = \''. $UpdateRESPONSABLESection[$i] .'\',
																COLOR = \''. $UpdateCOLORSection[$i] .'\'
																WHERE id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateSectionNotification')));
	}

	if(isset($_POST['AddRessource']) AND !empty($_POST['AddRessource'])){

		$dossier = 'images/Ressources/';
		$fichier = basename($_FILES['IMAGERessource']['name']);
		move_uploaded_file($_FILES['IMAGERessource']['tmp_name'], $dossier . $fichier);
		$IsertPrestaImage = $dossier.$fichier;

		$req = $bdd->exec("INSERT INTO ". TABLE_ERP_RESSOURCE ." VALUE ('0',
																		'". addslashes($_POST['CODERessource']) ."',
																		'". addslashes($_POST['AddRessource']) ."',
																		'". addslashes($IsertPrestaImage) ."',
																		'". $_POST['MASKRessource'] ."',
																		'". $_POST['ORDRERessource'] ."',
																		'". $_POST['CAPARessource'] ."',
																		'". $_POST['SECTIONRessource'] ."',
																		'". $_POST['COLORRessource'] ."')");
		$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddRessourcesnNotification')));	
	}

	$req = $bdd -> query('SELECT '. TABLE_ERP_EMPLOYEES .'.idUSER,
									'. TABLE_ERP_EMPLOYEES .'.NOM,
									'. TABLE_ERP_EMPLOYEES .'.PRENOM,
									'. TABLE_ERP_RIGHTS .'.RIGHT_NAME
									FROM `'. TABLE_ERP_EMPLOYEES .'`
									LEFT JOIN `'. TABLE_ERP_RIGHTS .'` ON `'. TABLE_ERP_EMPLOYEES .'`.`FONCTION` = `'. TABLE_ERP_RIGHTS .'`.`id`');
	while ($donnees_membre = $req->fetch()){
		 $EmployeeListe .=  '<option value="'. $donnees_membre['idUSER'] .'">'. $donnees_membre['NOM'] .' '. $donnees_membre['PRENOM'] .' - '. $donnees_membre['RIGHT_NAME'] .'</option>';

	}

	//------------------------------
	// PRESTA
	//------------------------------

	$i = 1;
	$req = $bdd -> query('SELECT '. TABLE_ERP_PRESTATION .'.Id,
									'. TABLE_ERP_PRESTATION .'.CODE,
									'. TABLE_ERP_PRESTATION .'.ORDRE,
									'. TABLE_ERP_PRESTATION .'.LABEL,
									'. TABLE_ERP_PRESTATION .'.TYPE,
									'. TABLE_ERP_PRESTATION .'.TAUX_H,
									'. TABLE_ERP_PRESTATION .'.MARGE,
									'. TABLE_ERP_PRESTATION .'.COLOR,
									'. TABLE_ERP_PRESTATION .'.IMAGE,
									'. TABLE_ERP_PRESTATION .'.RESSOURCE_ID
									FROM `'. TABLE_ERP_PRESTATION .'`
									ORDER BY ORDRE');




	while ($donnees_presta = $req->fetch()){
		 $contenu1 = $contenu1 .'
				<tr>
					<td>'. $i .' <input type="hidden" name="id_presta[]" id="id_presta" value="'. $donnees_presta['Id'] .'"></td>
					<td><input type="number" name="ORDREpresta[]" value="'. $donnees_presta['ORDRE'] .'" id="number"></td>
					<td><input type="text" name="CODEpresta[]" value="'. $donnees_presta['CODE'] .'" ></td>
					<td><input type="text" name="LABELpresta[]" value="'. $donnees_presta['LABEL'] .'" ></td>
					<td>
						<select name="TYPEpresta[]">
							<option value="1" '. selected($donnees_presta['TYPE'], 1) .'>Productive</option>
							<option value="2" '. selected($donnees_presta['TYPE'], 2) .'>Matière première</option>
							<option value="3" '. selected($donnees_presta['TYPE'], 3) .'>Matière première (tôle)</option>
							<option value="4" '. selected($donnees_presta['TYPE'], 4) .'>Matière première (profilé)</option>
							<option value="5" '. selected($donnees_presta['TYPE'], 5) .'>Matière première (bloc)</option>
							<option value="6" '. selected($donnees_presta['TYPE'], 6) .'>Fourniture</option>
							<option value="7" '. selected($donnees_presta['TYPE'], 7) .'>Sous-traitance</option>
							<option value="8" '. selected($donnees_presta['TYPE'], 8) .'>Article composés</option>
						</select>
						</td>
					<td><input type="number" name="TAUX_Hpresta[]" value="'. $donnees_presta['TAUX_H'] .'" id="number"></td>
					<td><input type="number" name="MARGEpresta[]" value="'. $donnees_presta['MARGE'] .'" id="number"></td>
					<td><input type="color" name="COLORpresta[]" value="'. $donnees_presta['COLOR'] .'"></td>
					<td><img Class="Image-small" src="'. $donnees_presta['IMAGE'] .'" title="Image '. $donnees_presta['LABEL'] .'" alt="Prestation Image" /></td>
					<td><input type="file" name="INAGEpresta[]" /></td>
				</tr>	';
		$i++;
	}

	//------------------------------
	// RESSOURCES
	//------------------------------

	$req = $bdd -> query('SELECT Id, LABEL   FROM '. TABLE_ERP_SECTION .'');
	while ($DonneesSection = $req->fetch()){
		$SectionListe .='<option value="'. $DonneesSection['Id'] .'">'. $DonneesSection['LABEL'] .'</option>';
	}

	$i = 1;
	$req = $bdd -> query('SELECT '. TABLE_ERP_RESSOURCE .'.Id,
									'. TABLE_ERP_RESSOURCE .'.CODE,
									'. TABLE_ERP_RESSOURCE .'.LABEL,
									'. TABLE_ERP_RESSOURCE .'.IMAGE,
									'. TABLE_ERP_RESSOURCE .'.MASK_TIME,
									'. TABLE_ERP_RESSOURCE .'.ORDRE,
									'. TABLE_ERP_RESSOURCE .'.CAPACITY,
									'. TABLE_ERP_RESSOURCE .'.SECTION_ID,
									'. TABLE_ERP_RESSOURCE .'.COLOR,
									'. TABLE_ERP_SECTION .'.LABEL AS LABEL_SECTOR
									FROM `'. TABLE_ERP_RESSOURCE .'`
									LEFT JOIN `'. TABLE_ERP_SECTION .'` ON `'. TABLE_ERP_RESSOURCE .'`.`SECTION_ID` = `'. TABLE_ERP_SECTION .'`.`id`
									ORDER BY ORDRE');

	while ($donnees_Ressources = $req->fetch()){
		 $contenu2 = $contenu2 .'
				<tr>
					<td>'. $i .' <input type="hidden" name="id_ressource[]" id="id_presta" value="'. $donnees_Ressources['Id'] .'"></td>
					<td><input type="text" name="UpdateORDREressource[]" value="'. $donnees_Ressources['CODE'] .'" ></td>
					<td><input type="number" name="UpdateCODEressource[]" value="'. $donnees_Ressources['ORDRE'] .'" id="number"></td>
					<td><input type="text" name="UpdateLABELressource[]" value="'. $donnees_Ressources['LABEL'] .'" ></td>
					<td>
						<select name="UpdateMASKressource[]">
							<option value="1" '. selected($donnees_Ressources['MASK_TIME'], 1) .'>Oui</option>
							<option value="0" '. selected($donnees_Ressources['MASK_TIME'], 0) .'>Non</option>
						</select>
					</td>
					<td><input type="number" name="UpdateCAPACITYressource[]" value="'. $donnees_Ressources['CAPACITY'] .'" id="number"></td>
					<td>
						<select name="UpdateSECTIONIDressource[]">
							<option value="'. $donnees_Ressources['SECTION_ID'] .'">'. $donnees_Ressources['LABEL_SECTOR'] .'</option>
							'. $SectionListe .'
						</select>
					</td>
					<td><input type="color" name="UpdateCOLORressource[]" value="'. $donnees_Ressources['COLOR'] .'" size="10"></td>
					<td><img Class="Image-small" src="'. $donnees_Ressources['IMAGE'] .'" title="Image '. $donnees_Ressources['LABEL'] .'" alt="Ressource Image" /></td>
					<td><input type="file" name="UpdateIMAGEPosteCharge[]" /></td>
				</tr>';
		$i++;
	}

	//------------------------------
	// SECTION
	//------------------------------

	$i = 1;
	$req = $bdd -> query('SELECT '. TABLE_ERP_SECTION .'.Id,
								'. TABLE_ERP_SECTION .'.ORDRE,
								'. TABLE_ERP_SECTION .'.CODE,
								'. TABLE_ERP_SECTION .'.LABEL,
								'. TABLE_ERP_SECTION .'.COUT_H,
								'. TABLE_ERP_SECTION .'.COLOR,
								'. TABLE_ERP_EMPLOYEES .'.idUSER,
								'. TABLE_ERP_EMPLOYEES .'.NOM,
								'. TABLE_ERP_EMPLOYEES .'.PRENOM,
								'. TABLE_ERP_RIGHTS .'.RIGHT_NAME
								FROM '. TABLE_ERP_SECTION .'
								LEFT JOIN `'. TABLE_ERP_EMPLOYEES .'` ON `'. TABLE_ERP_EMPLOYEES .'`.`idUSER` = `'. TABLE_ERP_SECTION .'`.`RESPONSABLE`
								LEFT JOIN `'. TABLE_ERP_RIGHTS .'` ON `'. TABLE_ERP_EMPLOYEES .'`.`FONCTION` = `'. TABLE_ERP_RIGHTS .'`.`id`
								ORDER BY '. TABLE_ERP_SECTION .'.ORDRE');
	while ($donnees_section = $req->fetch()){

		 $contenu3 = $contenu3 .'
				<tr>
					<td>'. $i .' <input type="hidden" name="id_section[]" id="id_section" value="'. $donnees_section['Id'] .'"></td>
					<td><input type="text" name="UpdateCODESection[]" value="'. $donnees_section['CODE'] .'" ></td>
					<td><input type="number" name="UpdateORDRESection[]" value="'. $donnees_section['ORDRE'] .'" id="number"></td>
					<td><input type="text" name="UpdateLABELSection[]" value="'. $donnees_section['LABEL'] .'" ></td>
					<td><input type="number" name="UpdateTAUX_HSection[]" value="'. $donnees_section['COUT_H'] .'" id="number"></td>
					<td>
						<select name="UpdateRESPONSABLESection[]">
							<option value="'. $donnees_section['idUSER'] .'">'. $donnees_section['NOM'] .' '. $donnees_section['PRENOM'] .' - '. $donnees_section['RIGHT_NAME'] .'</option>
							'. $EmployeeListe .'
						</select>
					</td>
					<td><input type="color" name="UpdateCOLORSection[]" value="'. $donnees_section['COLOR'] .'" size="10"></td>
				</tr>	';
		$i++;
	}

	//------------------------------
	// ZONE DE STOCKAGE
	//------------------------------

	$RessourcesListe ='<option value="0">Aucune</option>';
	$req = $bdd -> query('SELECT Id, LABEL   FROM '. TABLE_ERP_RESSOURCE .'');
	while ($DonneesRessource = $req->fetch()){
		$RessourcesListe .='<option value="'. $DonneesRessource['Id'] .'">'. $DonneesRessource['LABEL'] .'</option>';
	}

	//add new stock zone in dd
	if(isset($_POST['AddCODEZoneStock']) AND !empty($_POST['AddCODEZoneStock'])){

		$req = $bdd->exec("INSERT INTO ". TABLE_ERP_STOCK_ZONE ." VALUE ('0',
																		'". addslashes($_POST['AddCODEZoneStock']) ."',
																		'". addslashes($_POST['AddLABELZoneStock']) ."',
																		'". $_POST['AddRESSOURCEZoneStock'] ."',
																		'". $_POST['AddCOLORZoneStock'] ."')");
		$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddLocationNotification')));																		
	}

	//update list stock zone
	if(isset($_POST['id_ZoneStock']) AND !empty($_POST['id_ZoneStock'])){

		$UpdateIdZoneStock = $_POST['id_ZoneStock'];
		$UpdateCODEZoneStock = $_POST['UpdateCODEZoneStock'];
		$UpdateLABELZoneStock = $_POST['UpdateLABELZoneStock'];
		$UpdateRESSOURCEIDZoneStock = $_POST['UpdateRESSOURCEIDZoneStock'];
		$UpdateCOLORZoneStock = $_POST['UpdateCOLORZoneStock'];

		$i = 0;
		foreach ($UpdateIdZoneStock as $id_generation) {

			$bdd->exec('UPDATE `'. TABLE_ERP_STOCK_ZONE .'` SET CODE = \''. addslashes($UpdateCODEZoneStock[$i]) .'\',
																LABEL = \''. addslashes($UpdateLABELZoneStock[$i]) .'\',
																RESSOURCE_ID = \''. $UpdateRESSOURCEIDZoneStock[$i] .'\',
																COLOR = \''. $UpdateCOLORZoneStock[$i] .'\'
																WHERE id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateLocationNotification')));
	}

	//generate list of zone stock
	$i = 1;
	$req = $bdd -> query('SELECT '. TABLE_ERP_STOCK_ZONE .'.Id,
									'. TABLE_ERP_STOCK_ZONE .'.CODE,
									'. TABLE_ERP_STOCK_ZONE .'.LABEL,
									'. TABLE_ERP_STOCK_ZONE .'.RESSOURCE_ID,
									'. TABLE_ERP_STOCK_ZONE .'.COLOR,
									'. TABLE_ERP_RESSOURCE .'.LABEL AS LABEL_RESSOURCE
									FROM `'. TABLE_ERP_STOCK_ZONE .'`
									LEFT JOIN `'. TABLE_ERP_RESSOURCE .'` ON `'. TABLE_ERP_STOCK_ZONE .'`.`RESSOURCE_ID` = `'. TABLE_ERP_RESSOURCE .'`.`id`
									ORDER BY '.TABLE_ERP_RESSOURCE .'.id ');

	while ($donnees_ZoneStock = $req->fetch()){
		 $contenu4 = $contenu4 .'
				<tr>
					<td>'. $i .' <input type="hidden" name="id_ZoneStock[]" id="id_ZoneStock" value="'. $donnees_ZoneStock['Id'] .'"></td>
					<td><input type="text" name="UpdateCODEZoneStock[]" value="'. $donnees_ZoneStock['CODE'] .'" id="number"></td>
					<td><input type="text" name="UpdateLABELZoneStock[]" value="'. $donnees_ZoneStock['LABEL'] .'" </td>
					<td>
						<select name="UpdateRESSOURCEIDZoneStock[]">
							<option value="'. $donnees_ZoneStock['RESSOURCE_ID'] .'">'. $donnees_ZoneStock['LABEL_RESSOURCE'] .'</option>
							'. $RessourcesListe .'
						</select>
					</td>
					<td><input type="color" name="UpdateCOLORZoneStock[]" value="'. $donnees_ZoneStock['COLOR'] .'" size="10"></td>
				</tr>';
		$i++;
	}
?>
	<div class="tab">
		<button class="tablinks" onclick="openDiv(event, 'div1')" id="defaultOpen"><?=$langue->show_text('Title1'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div2')"><?=$langue->show_text('Title2'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div3')"><?=$langue->show_text('Title3'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div4')"><?=$langue->show_text('Title4'); ?></button>
	</div>
	<div id="div1" class="tabcontent">
			<form method="post" name="PosteCharge" action="admin.php?page=manage-methodes" class="content-form" enctype="multipart/form-data">
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th><?=$langue->show_text('TableOrder'); ?></th>
							<th><?=$langue->show_text('TableCODE'); ?></th>
							<th><?=$langue->show_text('TableLabel'); ?></th>
							<th><?=$langue->show_text('TableType'); ?></th>
							<th><?=$langue->show_text('TableHourlyRate'); ?></th>
							<th><?=$langue->show_text('TableMargin'); ?></th>
							<th><?=$langue->show_text('TableColor'); ?></th>
							<th><?=$langue->show_text('TablePicture'); ?></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
<?php
								Echo $contenu1;
?>
						<tr>
							<td><?=$langue->show_text('Addtext'); ?></td>
							<td><input type="number" name="ORDREPosteCharge" size="1" id="number"></td>
							<td><input type="text"  name="CODEPosteCharge" size="10"></td>
							<td><input type="text"  name="AddPosteCharge" ></td>
							<td>
								<select name="TYPEPosteCharge">
									<option value="1"><?=$langue->show_text('SelectProductive'); ?></option>
									<option value="2"><?=$langue->show_text('SelectRawMat'); ?></option>
									<option value="3"><?=$langue->show_text('SelectRawMatSheet'); ?></option>
									<option value="4"><?=$langue->show_text('SelectRawMatProfil'); ?></option>
									<option value="5"><?=$langue->show_text('SelectRawMatBlock'); ?></option>
									<option value="6"><?=$langue->show_text('SelectSupplies'); ?></option>
									<option value="7"><?=$langue->show_text('SelectSubcontracting'); ?></option>
									<option value="8"><?=$langue->show_text('SelectCompoundItem'); ?></option>
								</select>
							</td>
							<td><input type="number"  name="TAUXPosteCharge" id="number"></td>
							<td><input type="number"  name="MARGEPosteCharge" id="number"></td>
							<td><input type="color"  name="COLORPosteCharge"></td>
							<td></td>
							<td><input type="file" name="IMAGEPosteCharge" /></td>
						</tr>
						<tr>
							<td colspan="10" >
								<br/>
								<input type="submit" class="input-moyen" value="Mettre à jour" /> <br/>
								<br/>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>
	<div id="div2" class="tabcontent">
			<form method="post" name="Ressources" action="admin.php?page=manage-methodes" class="content-form" enctype="multipart/form-data">
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th><?=$langue->show_text('TableCODE'); ?></th>
							<th><?=$langue->show_text('TableOrder'); ?></th>
							<th><?=$langue->show_text('TableLabel'); ?></th>
							<th><?=$langue->show_text('TableMasktime'); ?></th>
							<th><?=$langue->show_text('TableCapacity'); ?></th>
							<th><?=$langue->show_text('TableSection'); ?></th>
							<th><?=$langue->show_text('TableColor'); ?></th>
							<th><?=$langue->show_text('TablePicture'); ?></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
<?php
								Echo $contenu2;
?>
						<tr>
							<td><?=$langue->show_text('Addtext'); ?></td>
							<td><input type="text"  name="CODERessource" size="1"></td>
							<td><input type="number"  name="ORDRERessource" size="1" id="number"></td>
							<td><input type="text"  name="AddRessource" size="10"></td>
							<td>
								<select name="MASKRessource">
									<option value="0"><?=$langue->show_text('No'); ?></option>
									<option value="1"><?=$langue->show_text('Yes'); ?></option>
								</select>
							</td>
							<td><input type="number"  name="CAPARessource" size="1" id="number"></td>
							<td>
								<select name="SECTIONRessource">
									<?=$SectionListe ?>
								</select>
							</td>
							<td><input type="color"  name="COLORRessource" size="1"></td>
							<td></td>
							<td><input type="file" name="IMAGERessource" /></td>
						</tr>
						<tr>
							<td colspan="10" >
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
			<form method="post" name="Section" action="admin.php?page=manage-methodes" class="content-form" enctype="multipart/form-data">
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th><?=$langue->show_text('TableCODE'); ?></th>
							<th><?=$langue->show_text('TableOrder'); ?></th>
							<th><?=$langue->show_text('TableLabel'); ?></th>
							<th><?=$langue->show_text('TableHourlyRate'); ?></th>
							<th><?=$langue->show_text('TableResponsible'); ?></th>
							<th><?=$langue->show_text('TableColor'); ?></th>
						</tr>
					</thead>
					<tbody>
<?php
								Echo $contenu3;
?>
						<tr>
							<td><?=$langue->show_text('Addtext'); ?></td>
							<td><input type="text"  name="CODESection" size="10"></td>
							<td><input type="number"  name="ORDRESection" id="number"></td>
							<td><input type="text"  name="AddSection" size="20"></td>
							<td><input type="number"  name="TAUXHSection" size="1" id="number"></td>
							<td>
								<select name="RESPSection">
									<?=$EmployeeListe ?>
								</select>
							</td>
							<td><input type="color"  name="COLORSection" ></td>
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
	<div id="div4" class="tabcontent">
			<form method="post" name="Section" action="admin.php?page=manage-methodes" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th><?=$langue->show_text('TableCODE'); ?></th>
							<th><?=$langue->show_text('TableLabel'); ?></th>
							<th><?=$langue->show_text('TableRessource'); ?></th>
							<th><?=$langue->show_text('TableColor'); ?></th>
						</tr>
					</thead>
					<tbody>
<?php
								Echo $contenu4;
?>
						<tr>
							<td><?=$langue->show_text('Addtext'); ?></td>
							<td><input type="text"  name="AddCODEZoneStock"></td>
							<td><input type="text"  name="AddLABELZoneStock" ></td>
							<td>
								<select name="AddRESSOURCEZoneStock">
									<?=$RessourcesListe ?>
								</select>
							</td>
							<td><input type="color"  name="AddCOLORZoneStock"></td>
						</tr>
						<tr>
							<td colspan="5" >
								<br/>
								<input type="submit" class="input-moyen" value="<?=$langue->show_text('TableUpdateButton'); ?>" /> <br/>
								<br/>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>