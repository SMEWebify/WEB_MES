<?php session_start();

	header( 'content-type: text/html; charset=utf-8' );

	//phpinfo();

	//include for the connection to the SQL database
	require_once 'include/include_connection_sql.php';
	// include for functions
	require_once 'include/include_fonctions.php';
	// include for the constants
	require_once 'include/include_recup_config.php';

	//session verification user
	if(isset($_SESSION['mdp'])){
		require_once 'include/verifications_session.php';
	}
	else{
		stop('Aucune session ouverte, l\'accès vous est interdit.', 160, 'connexion.php');
	}

	//Check if the user is authorized to view the page
	if($_SESSION['page_10'] != '1'){
		stop('L\'accès vous est interdit.', 161, 'connexion.php');
	}

	///////////////////////////
	//// APPAREIL DE MESURE ///
	//////////////////////////

	if(isset($_POST['AddCODEAppareil']) AND !empty($_POST['AddCODEAppareil'])){

		$req = $bdd->exec("INSERT INTO ". TABLE_ERP_QL_APP_MESURE ." VALUE ('0',
																		'". addslashes($_POST['AddCODEAppareil']) ."',
																		'". addslashes($_POST['AddLABELAppareil']) ."',
																		'". addslashes($_POST['AddRESSOURCEAppareil']) ."',
																		'". addslashes($_POST['AddUSERAppareil']) ."',
																		'". addslashes($_POST['AddIMMATAppareil']) ."',
																		'". addslashes($_POST['AddDATEAppareil']) ."')");

	}

	if(isset($_POST['id_Appareil']) AND !empty($_POST['id_Appareil'])){

		$UpdateIdAppareil = $_POST['id_Appareil'];
		$UpdateCODEAppareil = $_POST['UpdateCODEAppareil'];
		$UpdateLABELAppareil = $_POST['UpdateLABELAppareil'];
		$UpdateRESSOURCEAppareil = $_POST['UpdateRESSOURCEAppareil'];
		$UpdateUSERAppareil = $_POST['UpdateUSERAppareil'];
		$UpdateSERIALAppareil = $_POST['UpdateSERIALAppareil'];
		$UpdateDATEAppareil = $_POST['UpdateDATEAppareil'];

		$i = 0;
		foreach ($UpdateIdAppareil as $id_generation) {

			$bdd->exec('UPDATE `'. TABLE_ERP_QL_APP_MESURE .'` SET  CODE = \''. addslashes($UpdateCODEAppareil[$i]) .'\',
																LABEL = \''. addslashes($UpdateLABELAppareil[$i]) .'\',
																RESSOURCE_ID = \''. addslashes($UpdateRESSOURCEAppareil[$i]) .'\',
																USER_ID = \''. addslashes($UpdateUSERAppareil[$i]) .'\',
																SERIAL_NUMBER = \''. addslashes($UpdateSERIALAppareil[$i]) .'\',
																DATE = \''. addslashes($UpdateDATEAppareil[$i]) .'\'
																WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
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

	$RessourcesListe ='<option value="0">Aucune</option>';
	$req = $bdd -> query('SELECT Id, LABEL   FROM '. TABLE_ERP_RESSOURCE .'');
	while ($DonneesRessource = $req->fetch())
	{
		$RessourcesListe .='<option value="'. $DonneesRessource['Id'] .'">'. $DonneesRessource['LABEL'] .'</option>';
	}


	$i = 1;
	$req = $bdd -> query('SELECT '. TABLE_ERP_QL_APP_MESURE .'.Id,
									'. TABLE_ERP_QL_APP_MESURE .'.CODE,
									'. TABLE_ERP_QL_APP_MESURE .'.LABEL,
									'. TABLE_ERP_QL_APP_MESURE .'.RESSOURCE_ID,
									'. TABLE_ERP_QL_APP_MESURE .'.USER_ID,
									'. TABLE_ERP_QL_APP_MESURE .'.SERIAL_NUMBER,
									'. TABLE_ERP_QL_APP_MESURE .'.DATE,
									'. TABLE_ERP_RESSOURCE .'.LABEL AS LABEL_RESSOURCE,
									'. TABLE_ERP_EMPLOYEES .'.NOM AS NOM_USER,
									'. TABLE_ERP_EMPLOYEES .'.PRENOM AS PRENOM_USER
									FROM `'. TABLE_ERP_QL_APP_MESURE .'`
									LEFT JOIN `'. TABLE_ERP_RESSOURCE .'` ON `'. TABLE_ERP_QL_APP_MESURE .'`.`RESSOURCE_ID` = `'. TABLE_ERP_RESSOURCE .'`.`id`
									LEFT JOIN `'. TABLE_ERP_EMPLOYEES .'` ON `'. TABLE_ERP_QL_APP_MESURE .'`.`USER_ID` = `'. TABLE_ERP_EMPLOYEES .'`.`idUser`
									ORDER BY Id');

	while ($donnees_Appareil = $req->fetch())
	{
		 $contenu1 = $contenu1 .'
				<tr>
					<td>'. $i .' <input type="hidden" name="id_Appareil[]" id="id_Appareil" value="'. $donnees_Appareil['Id'] .'"></td>
					<td><input type="text" name="UpdateCODEAppareil[]" value="'. $donnees_Appareil['CODE'] .'" size="10"></td>
					<td><input type="text" name="UpdateLABELAppareil[]" value="'. $donnees_Appareil['LABEL'] .'" ></td>
					<td>
						<select name="UpdateRESSOURCEAppareil">
							<option value="0" '. selected($donnees_ImproductTime['RESSOURCE_ID'], 0) .' >Aucune</option>
							<option value="'. $donnees_Appareil['RESSOURCE_ID'] .'" >'. $donnees_Appareil['LABEL_RESSOURCE'] .'</option>
							'. $RessourcesListe .'
						</select>
					</td>
					<td>
						<select name="UpdateUSERAppareil">
							<option value="'. $donnees_Appareil['USER_ID'] .'">'. $donnees_Appareil['NOM_USER'] .'- '. $donnees_Appareil['PRENOM_USER'] .'</option>
							'. $EmployeeListe .'
						</select>
					</td>
					<td><input type="text" name="UpdateSERIALAppareil[]" value="'. $donnees_Appareil['SERIAL_NUMBER'] .'" ></td>
					<td><input type="date" name="UpdateDATEAppareil[]" value="'. $donnees_Appareil['DATE'] .'" ></td>
				</tr>	';
		$i++;
	}

	////////////////////////
	//// DEFAUTS         ///
	///////////////////////

	if(isset($_POST['AddCODEDefaut']) AND !empty($_POST['AddCODEDefaut'])){

		$req = $bdd->exec("INSERT INTO ". TABLE_ERP_DEFAUT ." VALUE ('0',
																		'". addslashes($_POST['AddCODEDefaut']) ."',
																		'". addslashes($_POST['AddLABELDefaut']) ."')");

	}

	if(isset($_POST['id_Defaut']) AND !empty($_POST['id_Defaut'])){

		$UpdateIdDefaut = $_POST['id_Defaut'];
		$UpdateCODEDefaut = $_POST['UpdateCODEDefaut'];
		$UpdateLABELDefaut = $_POST['UpdateLABELDefaut'];

		$i = 0;
		foreach ($UpdateIdDefaut as $id_generation) {

			$bdd->exec('UPDATE `'. TABLE_ERP_DEFAUT .'` SET  CODE = \''. addslashes($UpdateCODEDefaut[$i]) .'\',
																LABEL = \''. addslashes($UpdateLABELDefaut[$i]) .'\'
																WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
	}

	$i = 1;
	$req = $bdd -> query('SELECT '. TABLE_ERP_DEFAUT .'.Id,
									'. TABLE_ERP_DEFAUT .'.CODE,
									'. TABLE_ERP_DEFAUT .'.LABEL
									FROM `'. TABLE_ERP_DEFAUT .'`
									ORDER BY Id');

	while ($donnees_defaut = $req->fetch())
	{
		 $contenu2 = $contenu2 .'
				<tr>
					<td>'. $i .' <input type="hidden" name="id_Defaut[]" id="id_Defaut" value="'. $donnees_defaut['Id'] .'"></td>
					<td><input type="text" name="UpdateCODEDefaut[]" value="'. $donnees_defaut['CODE'] .'" size="10"></td>
					<td><input type="text" name="UpdateLABELDefaut[]" value="'. $donnees_defaut['LABEL'] .'" ></td>
				</tr>	';
		$i++;
	}

	///////////////
	//// CAUSES ////
	///////////////

	if(isset($_POST['AddCODECauses']) AND !empty($_POST['AddCODECauses'])){

		$req = $bdd->exec("INSERT INTO ". TABLE_ERP_QL_CAUSES ." VALUE ('0',
																		'". addslashes($_POST['AddCODECauses']) ."',
																		'". addslashes($_POST['AddLABELCauses']) ."')");

	}

	if(isset($_POST['id_Causes']) AND !empty($_POST['id_Causes'])){

		$UpdateIdCauses = $_POST['id_Causes'];
		$UpdateCODECauses = $_POST['UpdateCODECauses'];
		$UpdateLABELCauses = $_POST['UpdateLABELCauses'];

		$i = 0;
		foreach ($UpdateIdCauses as $id_generation) {

			$bdd->exec('UPDATE `'. TABLE_ERP_QL_CAUSES .'` SET  CODE = \''. addslashes($UpdateCODECauses[$i]) .'\',
																LABEL = \''. addslashes($UpdateLABELCauses[$i]) .'\'
																WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
	}

	$i = 1;
	$req = $bdd -> query('SELECT '. TABLE_ERP_QL_CAUSES .'.Id,
									'. TABLE_ERP_QL_CAUSES .'.CODE,
									'. TABLE_ERP_QL_CAUSES .'.LABEL
									FROM `'. TABLE_ERP_QL_CAUSES .'`
									ORDER BY Id');

	while ($donnees_Causes = $req->fetch())
	{
		 $contenu3 = $contenu3 .'
				<tr>
					<td>'. $i .' <input type="hidden" name="id_Causes[]" id="id_sector" value="'. $donnees_Causes['Id'] .'"></td>
					<td><input type="text" name="UpdateCODECauses[]" value="'. $donnees_Causes['CODE'] .'" size="10"></td>
					<td><input type="text" name="UpdateLABELCauses[]" value="'. $donnees_Causes['LABEL'] .'" ></td>
				</tr>';
		$i++;
	}

	////////////////////////
	////  Corresction  ////
	///////////////////////


	if(isset($_POST['AddCODECorrection']) AND !empty($_POST['AddCODECorrection'])){

		$req = $bdd->exec("INSERT INTO ". TABLE_ERP_QL_CORRECTIONS ." VALUE ('0',
																		'". addslashes($_POST['AddCODECorrection']) ."',
																		'". addslashes($_POST['AddLABELCorrection'])  ."')");
	}

	if(isset($_POST['id_Correction']) AND !empty($_POST['id_Correction'])){

		$UpdateIdCorrection = $_POST['id_Correction'];
		$UpdateCODECorrection = $_POST['UpdateCODECorrection'];
		$UpdateLABELCorrection = $_POST['UpdateLABELCorrection'];

		$i = 0;
		foreach ($UpdateIdCorrection as $id_generation) {

			$bdd->exec('UPDATE `'. TABLE_ERP_QL_CORRECTIONS .'` SET  CODE = \''. addslashes($UpdateCODECorrection[$i]) .'\',
																LABEL = \''. addslashes($UpdateLABELCorrection[$i]) .'\'
																WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
	}

	$i = 1;
	$req = $bdd -> query('SELECT '. TABLE_ERP_QL_CORRECTIONS .'.Id,
									'. TABLE_ERP_QL_CORRECTIONS .'.CODE,
									'. TABLE_ERP_QL_CORRECTIONS .'.LABEL
									FROM `'. TABLE_ERP_QL_CORRECTIONS .'`
									ORDER BY Id');

	while ($donnees_correction = $req->fetch())
	{
		 $contenu4 = $contenu4 .'
				<tr>
					<td>'. $i .' <input type="hidden" name="id_Correction[]" id="id_Correction" value="'. $donnees_correction['Id'] .'"></td>
					<td><input type="text" name="UpdateCODECorrection[]" value="'. $donnees_correction['CODE'] .'" size="10"></td>
					<td><input type="text" name="UpdateLABELCorrection[]" value="'. $donnees_correction['LABEL'] .'" ></td>
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
		<button class="tablinks" onclick="openDiv(event, 'div1')" id="defaultOpen">Appareils de mesure</button>
		<button class="tablinks" onclick="openDiv(event, 'div2')">Défauts</button>
		<button class="tablinks" onclick="openDiv(event, 'div3')">Causes</button>
		<button class="tablinks" onclick="openDiv(event, 'div4')">Corrections</button>
	</div>
		<div id="div1" class="tabcontent" >
			<form method="post" name="Section" action="admqualite.php" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th>CODE</th>
							<th>Libellé</th>
							<th>Ressource</th>
							<th>Utilisateur</th>
							<th>Immatriculation</th>
							<th>Date de fin</th>
						</tr>
					</thead>
					<tbody>
							<?php

								Echo $contenu1;
							?>
						<tr>
							<td>Ajout</td>
							<td><input type="text" class="input-moyen-vide" name="AddCODEAppareil"></td>
							<td><input type="text" class="input-moyen-vide" name="AddLABELAppareil"></td>
							<td>
								<select name="AddRESSOURCEAppareil">
									<?php echo $RessourcesListe ?>
								</select>
							</td>
							<td>
								<select name="AddUSERAppareil">
									<?php echo $EmployeeListe ?>
								</select>
							</td>
							<td><input type="text" class="input-moyen-vide" name="AddIMMATAppareil"></td>
							<td><input type="date" class="input-moyen-vide" name="AddDATEAppareil"></td>
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
		<div id="div2" class="tabcontent" >
			<form method="post" name="Section" action="admqualite.php" class="content-form" >
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
							<td><input type="text" class="input-moyen-vide" name="AddCODEDefaut"></td>
							<td><input type="text" class="input-moyen-vide" name="AddLABELDefaut" ></td>
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
			<form method="post" name="Section" action="admqualite.php" class="content-form" >
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

								Echo $contenu3;
							?>
						<tr>
							<td>Ajout</td>
							<td><input type="text" class="input-moyen-vide" name="AddCODECauses"></td>
							<td><input type="text" class="input-moyen-vide" name="AddLABELCauses" ></td>
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
		<div id="div4" class="tabcontent" >
			<form method="post" name="Section" action="admqualite.php" class="content-form" >
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

								Echo $contenu4;
							?>
						<tr>
							<td>Ajout</td>
							<td><input type="text" class="input-moyen-vide" name="AddCODECorrection"></td>
							<td><input type="text" class="input-moyen-vide" name="AddLABELCorrection" ></td>
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
</body>
</html>
