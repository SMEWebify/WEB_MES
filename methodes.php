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
															
	}
	
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
	}
	
	if(isset($_POST['AddSection']) AND !empty($_POST['AddSection'])){
					

		
		$req = $bdd->exec("INSERT INTO ". TABLE_ERP_SECTION ." VALUE ('0',
																		'". $_POST['ORDRESection'] ."',
																		'". addslashes($_POST['CODESection']) ."',
																		'". addslashes($_POST['AddSection']) ."',
																		'". $_POST['TAUXHSection'] ."',
																		'". $_POST['RESPSection'] ."',
																		'". $_POST['COLORSection'] ."')");
															
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
															
	}
	
	$req = $bdd -> query('SELECT '. TABLE_ERP_EMPLOYEES .'.idUSER,
									'. TABLE_ERP_EMPLOYEES .'.NOM,
									'. TABLE_ERP_EMPLOYEES .'.PRENOM,
									'. TABLE_ERP_RIGHTS .'.RIGHT_NAME
									FROM `'. TABLE_ERP_EMPLOYEES .'` 
									LEFT JOIN `'. TABLE_ERP_RIGHTS .'` ON `'. TABLE_ERP_EMPLOYEES .'`.`FONCTION` = `'. TABLE_ERP_RIGHTS .'`.`id`');
	while ($donnees_membre = $req->fetch())
	{
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
									


	
	while ($donnees_presta = $req->fetch())
	{
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
	while ($DonneesSection = $req->fetch())
	{
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
	
	while ($donnees_Ressources = $req->fetch())
	{
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
	while ($donnees_section = $req->fetch())
	{
		
		 $contenu3 = $contenu3 .'
				<tr>
					<td>'. $i .' <input type="hidden" name="id_section[]" id="id_section" value="'. $donnees_section['Id'] .'"></td>
					<td><input type="text" name="UpdateCODESection[]" value="'. $donnees_section['CODE'] .'" ></td>
					<td><input type="number" name="UpdateORDRESection[]" value="'. $donnees_section['ORDRE'] .'" id="number"></td>
					<td><input type="text" name="UpdateLABELSection[]" value="'. $donnees_section['LABEL'] .'" ></td>
					<td><input type="number" name="UpdateTAUX_HSection[]" value="'. $donnees_section['COUT_H'] .'" id="number"></td>
					<td>
						<select name="UpdateRESPONSABLESection">
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
	while ($DonneesRessource = $req->fetch())
	{
		$RessourcesListe .='<option value="'. $DonneesRessource['Id'] .'">'. $DonneesRessource['LABEL'] .'</option>';
	}

	if(isset($_POST['AddCODEZoneStock']) AND !empty($_POST['AddCODEZoneStock'])){

		
		$req = $bdd->exec("INSERT INTO ". TABLE_ERP_STOCK_ZONE ." VALUE ('0',
																		'". addslashes($_POST['AddCODEZoneStock']) ."',
																		'". addslashes($_POST['AddLABELZoneStock']) ."',
																		'". $_POST['AddRESSOURCEZoneStock'] ."',
																		'". $_POST['AddCOLORZoneStock'] ."')");
															
	}
	
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
	}
	
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
	
	while ($donnees_ZoneStock = $req->fetch())
	{
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
		<button class="tablinks" onclick="openDiv(event, 'div1')" id="defaultOpen">Prestations</button>
		<button class="tablinks" onclick="openDiv(event, 'div2')">Ressources</button>
		<button class="tablinks" onclick="openDiv(event, 'div3')">Section</button>
		<button class="tablinks" onclick="openDiv(event, 'div4')">Emplacement dans l'atelier</button>
	</div>
	<div id="div1" class="tabcontent">
			<form method="post" name="PosteCharge" action="methodes.php" class="content-form" enctype="multipart/form-data">
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th>Index</th>
							<th>CODE</th>
							<th>Label</th>
							<th>Type</th>
							<th>Taux horraire</th>
							<th>Marge</th>
							<th>Couleur</th>
							<th>Image</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
							<?php

								Echo $contenu1;
							?>
						<tr>
							<td>Ajout</td>
							<td><input type="number" name="ORDREPosteCharge" size="1" id="number"></td>
							<td><input type="text"  name="CODEPosteCharge" size="10"></td>
							<td><input type="text"  name="AddPosteCharge" ></td>
							<td>
								<select name="TYPEPosteCharge">
									<option value="1">Productive</option>
									<option value="2">Matière première</option>
									<option value="3">Matière première (tôle)</option>
									<option value="4">Matière première (profilé)</option>
									<option value="5">Matière première (bloc)</option>
									<option value="6">Fourniture</option>
									<option value="7">Sous-traitance</option>
									<option value="8">Article composés</option>
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
			<form method="post" name="Ressources" action="methodes.php" class="content-form" enctype="multipart/form-data">
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th>CODE</th>
							<th>index</th>
							<th>Label</th>
							<th>Temps masqué</th>
							<th>Capacité</th>
							<th>Section</th>
							<th>Couleur</th>
							<th>Image</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
							<?php

								Echo $contenu2;
							?>
						<tr>
							<td>Ajout</td>
							<td><input type="text"  name="CODERessource" size="1"></td>
							<td><input type="number"  name="ORDRERessource" size="1" id="number"></td>
							<td><input type="text"  name="AddRessource" size="10"></td>
							<td>
								<select name="MASKRessource">
									<option value="0">Non</option>
									<option value="1">Oui</option>
								</select>
							</td>
							<td><input type="number"  name="CAPARessource" size="1" id="number"></td>
							<td>
								<select name="SECTIONRessource">
									<?php echo $SectionListe ?>
								</select>
							</td>
							<td><input type="color"  name="COLORRessource" size="1"></td>
							<td></td>
							<td><input type="file" name="IMAGERessource" /></td>
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
	<div id="div3" class="tabcontent">
			<form method="post" name="Section" action="methodes.php" class="content-form" enctype="multipart/form-data">
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th>CODE</th>
							<th>index</th>
							<th>Label</th>
							<th>Taux H</th>
							<th>Responsable</th>
							<th>Couleur</th>
						</tr>
					</thead>
					<tbody>
							<?php

								Echo $contenu3;
							?>
						<tr>
							<td>Ajout</td>
							<td><input type="text"  name="CODESection" size="10"></td>
							<td><input type="number"  name="ORDRESection" id="number"></td>
							<td><input type="text"  name="AddSection" size="20"></td>
							<td><input type="number"  name="TAUXHSection" size="1" id="number"></td>
							<td>
								<select name="RESPSection">
									<?php echo $EmployeeListe ?>
								</select>
							</td>
							<td><input type="color"  name="COLORSection" ></td>
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
	<div id="div4" class="tabcontent">
			<form method="post" name="Section" action="methodes.php" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th>CODE</th>
							<th>Label</th>
							<th>RESSOURCE</th>
							<th>Couleur</th>
						</tr>
					</thead>
					<tbody>
							<?php

								Echo $contenu4;
							?>
						<tr>
							<td>Ajout</td>
							<td><input type="text"  name="AddCODEZoneStock"></td>
							<td><input type="text"  name="AddLABELZoneStock" ></td>
							<td>
								<select name="AddRESSOURCEZoneStock">
									<?php echo $RessourcesListe ?>
								</select>
							</td>
							<td><input type="color"  name="AddCOLORZoneStock"></td>
						</tr>
						<tr>
							<td colspan="5" >
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