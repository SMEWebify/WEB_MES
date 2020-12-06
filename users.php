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

	if(isset($_POST['Addnom_ajout']) AND !empty($_POST['Addnom_ajout'])){
		
		$req = $bdd->exec("INSERT INTO ". TABLE_ERP_EMPLOYEES ." VALUE ('0',
																		'". $_POST['Addcode_ajout'] ."',
																		'',
																		'',
																		'',
																		'',
																		'',
																		'',
																		'',
																		'1',
																		'". time() ."',
																		'". $_POST['Addnom_ajout'] ."',
																		'". $_POST['Addmdp_ajout'] ."',
																		'". $_POST['Addposte_ajout'] ."',
																		'". $_POST['Addsection_ajout'] ."')");
																		
		
	}
	
	if(isset($_POST['AddRight']) AND !empty($_POST['AddRight'])){
	
		
		$req = $bdd->exec("INSERT INTO ". TABLE_ERP_RIGHTS ." VALUE ('0',
																		'". $_POST['AddRight'] ."',
																		'". $_POST['Addpage_1_ajout'] ."',
																		'". $_POST['Addpage_2_ajout'] ."',
																		'". $_POST['Addpage_3_ajout'] ."',
																		'". $_POST['Addpage_4_ajout'] ."',
																		'". $_POST['Addpage_5_ajout'] ."',
																		'". $_POST['Addpage_6_ajout'] ."',
																		'". $_POST['Addpage_7_ajout'] ."',
																		'". $_POST['Addpage_8_ajout'] ."',
																		'". $_POST['Addpage_9_ajout'] ."',
																		'". $_POST['Addpage_10_ajout'] ."')");
	}
	
	if(isset($_POST['id_membre']) AND !empty($_POST['id_membre'])){
		
		$id_membre = $_POST['id_membre'];
		$CODEmembre = $_POST['CODEmembre'];
		$nom_membre = $_POST['nom_membre'];
		$mdp_membre = $_POST['mdp_membre'];
		$poste_membre = $_POST['poste_membre'];
		$SECTIONmembre = $_POST['SECTIONmembre'];
		
		$i = 0;
		foreach ($id_membre as $id_generation) {
		
			$bdd->exec('UPDATE `'. TABLE_ERP_EMPLOYEES .'` SET  CODE = \''. $CODEmembre[$i] .'\',
																NAME = \''. addslashes($nom_membre[$i]) .'\',
																PASSWORD = \''. addslashes($mdp_membre[$i]) .'\',
																FONCTION = \''. $poste_membre[$i] .'\',
																SECTION_ID = \''. $SECTIONmembre[$i] .'\'
																WHERE idUser = '. $id_generation . ' ');
			$i++;
		}
	}
	
	if(isset($_POST['id_Right']) AND !empty($_POST['id_Right'])){
		
		$UpdateIdRight = $_POST['id_Right'];
		$UpdateNameRight = $_POST['RIGHT_NAME'];
		$UpdatePage_1 = $_POST['page_1_membre'];
		$UpdatePage_2 = $_POST['page_2_membre'];
		$UpdatePage_3 = $_POST['page_3_membre'];
		$UpdatePage_4 = $_POST['page_4_membre'];
		$UpdatePage_5 = $_POST['page_5_membre'];
		$UpdatePage_6 = $_POST['page_6_membre'];
		$UpdatePage_7 = $_POST['page_7_membre'];
		$UpdatePage_8 = $_POST['page_8_membre'];
		$UpdatePage_9 = $_POST['page_9_membre'];
		$UpdatePage_10 = $_POST['page_10_membre'];
		
		$i = 0;
		foreach ($UpdateIdRight as $id_generation) {
			
			If(empty($UpdatePage_1[$i])) $FinalUpdatePage_1 = 0; else $FinalUpdatePage_1 = 1;
			If(empty($UpdatePage_2[$i])) $FinalUpdatePage_2 = 0; else $FinalUpdatePage_2 = 1;
			If(empty($UpdatePage_3[$i])) $FinalUpdatePage_3 = 0; else $FinalUpdatePage_3 = 1;
			If(empty($UpdatePage_4[$i])) $FinalUpdatePage_4 = 0; else $FinalUpdatePage_4 = 1;
			If(empty($UpdatePage_5[$i])) $FinalUpdatePage_5 = 0; else $FinalUpdatePage_5 = 1;
			If(empty($UpdatePage_6[$i])) $FinalUpdatePage_6 = 0; else $FinalUpdatePage_6 = 1;
			If(empty($UpdatePage_7[$i])) $FinalUpdatePage_7 = 0; else $FinalUpdatePage_7 = 1;
			If(empty($UpdatePage_8[$i])) $FinalUpdatePage_8 = 0; else $FinalUpdatePage_8 = 1;
			If(empty($UpdatePage_9[$i])) $FinalUpdatePage_9 = 0; else $FinalUpdatePage_9 = 1;
			If(empty($UpdatePage_10[$i])) $FinalUpdatePage_10 = 0; else $FinalUpdatePage_10 = 1;
		
			$bdd->exec('UPDATE `'. TABLE_ERP_RIGHTS .'` SET  RIGHT_NAME = \''. addslashes($UpdateNameRight[$i]) .'\',
																page_1 = \''. $FinalUpdatePage_1 .'\',
																page_2 = \''. $FinalUpdatePage_2 .'\',
																page_3 = \''. $FinalUpdatePage_3 .'\',
																page_4 = \''. $FinalUpdatePage_4 .'\',
																page_5 = \''. $FinalUpdatePage_5 .'\',
																page_6 = \''. $FinalUpdatePage_6 .'\',
																page_7 = \''. $FinalUpdatePage_7 .'\',
																page_8 = \''. $FinalUpdatePage_8 .'\',
																page_9 = \''. $FinalUpdatePage_9 .'\',
																page_10 = \''. $FinalUpdatePage_10 .'\'
																
																WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
	}
	
	$req = $bdd -> query('SELECT Id, RIGHT_NAME   FROM '. TABLE_ERP_RIGHTS .'');
	while ($DonneesRight = $req->fetch())
	{
		$RightListe .='<option value="'. $DonneesRight['Id'] .'">'. $DonneesRight['RIGHT_NAME'] .'</option>';
	}
	
	$req = $bdd -> query('SELECT Id, LABEL   FROM '. TABLE_ERP_SECTION .'');
	while ($DonneesSection = $req->fetch())
	{
		$SectionListe .='<option value="'. $DonneesSection['Id'] .'">'. $DonneesSection['LABEL'] .'</option>';
	}
	
	$i = 1;
	$req = $bdd -> query('SELECT '. TABLE_ERP_EMPLOYEES .'.IdUser,
									'. TABLE_ERP_EMPLOYEES .'.CODE,
									'. TABLE_ERP_EMPLOYEES .'.STATU,
									'. TABLE_ERP_EMPLOYEES .'.CONNEXION,
									'. TABLE_ERP_EMPLOYEES .'.NAME,
									'. TABLE_ERP_EMPLOYEES .'.PASSWORD,
									'. TABLE_ERP_EMPLOYEES .'.FONCTION,
									'. TABLE_ERP_EMPLOYEES .'.SECTION_ID,
									'. TABLE_ERP_RIGHTS .'.RIGHT_NAME,
									'. TABLE_ERP_SECTION .'.LABEL
									FROM `'. TABLE_ERP_EMPLOYEES .'` 
									LEFT JOIN `'. TABLE_ERP_RIGHTS .'` ON `'. TABLE_ERP_EMPLOYEES .'`.`FONCTION` = `'. TABLE_ERP_RIGHTS .'`.`id`
									LEFT JOIN `'. TABLE_ERP_SECTION .'` ON `'. TABLE_ERP_EMPLOYEES .'`.`SECTION_ID` = `'. TABLE_ERP_SECTION .'`.`id`');
									

	
	while ($donnees_membre = $req->fetch())
	{
		
		 $contenu1 = $contenu1 .'
				<tr>
					<td>'. $i .' <input type="hidden" name="id_membre[]" id="id_membre" value="'. $donnees_membre['IdUser'] .'"></td>
					<td>'. format_temps($donnees_membre['CONNEXION']) .'</td>
					<td><input type="text" name="CODEmembre[]" value="'. $donnees_membre['CODE'] .'" size="10"></td>
					<td><input type="text" name="nom_membre[]" value="'. $donnees_membre['NAME'] .'" size="10"></td>
					<td><input type="password" name="mdp_membre[]" value="'. $donnees_membre['PASSWORD'] .'" size="10"></td>
					<td>
						<select name="poste_membre[]">
							<option value="'. $donnees_membre['FONCTION'] .'">'. $donnees_membre['RIGHT_NAME'] .'</option>
							'.  $RightListe .'
						</select>
					</td>
					<td>
						<select name="SECTIONmembre[]">
							<option value="'. $donnees_membre['SECTION_ID'] .'" '. selected($donnees_membre['SECTIONmembre'], 1) .'>'. $donnees_membre['LABEL'] .'</option>
							'.  $SectionListe .'
						</select>
					</td>
				</tr>	';
		$i++;
	}
			
	$contenu4;
	$req = $bdd -> query('SELECT Id, RIGHT_NAME, page_1, page_2, page_3, page_4, page_5, page_6, page_7, page_8, page_9, page_10   FROM '. TABLE_ERP_RIGHTS .'');
	while ($DonneesRight = $req->fetch())
	{
		 $contenu4 = $contenu4 .'
				<tr>
					<td>'. $i .' <input type="hidden" name="id_Right[]" id="id_Right" value="'. $DonneesRight['Id'] .'"></td>
					<td><input type="text" name="RIGHT_NAME[]" value="'. $DonneesRight['RIGHT_NAME'] .'"></td>
					<td>
						<select name="page_1_membre[]">
							<option value="1" '. selected($DonneesRight['page_1'], "1") .'>Oui</option>
							<option value="0" '. selected($DonneesRight['page_1'], "0") .'>Non</option>
						</select>
					</td>
					<td>
						<select name="page_2_membre[]">
							<option value="1" '. selected($DonneesRight['page_2'], "1") .'>Oui</option>
							<option value="0" '. selected($DonneesRight['page_2'], "0") .'>Non</option>
						</select>
					</td>
					<td>
						<select name="page_3_membre[]">
							<option value="1" '. selected($DonneesRight['page_3'], "1") .'>Oui</option>
							<option value="0" '. selected($DonneesRight['page_3'], "0") .'>Non</option>
						</select>
					</td>
					<td>
						<select name="page_4_membre[]">
							<option value="1" '. selected($DonneesRight['page_4'], "1") .'>Oui</option>
							<option value="0" '. selected($DonneesRight['page_4'], "0") .'>Non</option>
						</select>
					</td>
					<td>
						<select name="page_5_membre[]">
							<option value="1" '. selected($DonneesRight['page_5'], "1") .'>Oui</option>
							<option value="0" '. selected($DonneesRight['page_5'], "0") .'>Non</option>
						</select>
					</td>
					<td>
						<select name="page_6_membre[]">
							<option value="1" '. selected($DonneesRight['page_6'], "1") .'>Oui</option>
							<option value="0" '. selected($DonneesRight['page_6'], "0") .'>Non</option>
						</select>
					</td>
					<td>
						<select name="page_7_membre[]">
							<option value="1" '. selected($DonneesRight['page_7'], "1") .'>Oui</option>
							<option value="0" '. selected($DonneesRight['page_7'], "0") .'>Non</option>
						</select>
					</td>
					<td>
						<select name="page_8_membre[]">
							<option value="1" '. selected($DonneesRight['page_8'], "1") .'>Oui</option>
							<option value="0" '. selected($DonneesRight['page_8'], "0") .'>Non</option>
						</select>
					</td>
					<td>
						<select name="page_9_membre[]">
							<option value="1" '. selected($DonneesRight['page_9'], "1") .'>Oui</option>
							<option value="0" '. selected($DonneesRight['page_9'], "0") .'>Non</option>
						</select>
					</td>
					<td>
						<select name="page_10_membre[]">
							<option value="1" '. selected($DonneesRight['page_10'], "1") .'>Oui</option>
							<option value="0" '. selected($DonneesRight['page_10'], "0") .'>Non</option>
						</select>
					</td>
				</tr>	';
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
		<button class="tablinks" onclick="openDiv(event, 'div1')" id="defaultOpen">Gestion des employés et utilisateurs</button>
		<button class="tablinks" onclick="openDiv(event, 'div2')">Gestion des droits</button>
	</div>
		<div id="div1" class="tabcontent" >
			<form method="post" name="Employees" action="users.php" class="content-form">
				<table class="content-table" >
					<thead>
						<tr>
							<th colspan="7">
								 
							</th>
						</tr>
						<tr>
							<th>N°</th>
							<th>Dernière co</th>
							<th>CODE</th>
							<th>Speudo</th>
							<th>MDP</th>
							<th>Poste</th>
							<th>Section</th>
						</tr>
					</thead>
					<tbody>
							<?php

								Echo $contenu1;
								Echo $membre_ok;
							?>
						<tr>
							<td>Ajout</td>
							<td></td>
							<td><input type="text" class="input-moyen-vide" name="Addcode_ajout" size="1"></td>
							<td><input type="text" class="input-moyen-vide" name="Addnom_ajout" size="1"></td>
							<td><input type="text" class="input-moyen-vide" name="Addmdp_ajout" size="1"></td>
							<td>
								<select name="Addposte_ajout">
									<?php echo $RightListe ?>
								</select>
							</td>
							<td>
								<select name="Addsection_ajout">
									<?php echo $SectionListe ?>
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
		<div id="div2" class="tabcontent">
			<form method="post" name="Right" action="users.php" class="content-form">
				<table class="content-table" >
					<thead>
						<tr>
							<th></th>
							<th>Fonction</th>
							<th>Accueil</th>
							<th>Devis/Etudes</th>
							<th>Commande</th>
							<th>Planning</th>
							<th>Calendrier</th>
							<th>Achat</th>
							<th>Articles</th>
							<th>Qualité</th>
							<th>Gestion</th>
							<th>Compta</th>
						</tr>
					</thead>
					<tbody>
							<?php

								Echo $contenu4;
							?>
						<tr>
							<td>Ajout</td>
							<td><input type="text" class="input-moyen-vide" name="AddRight" size="1"></td>
							<td>
								<select name="Addpage_1_ajout">
									<option value="1">Oui</option>
									<option value="0">Non</option>
								</select>
							</td>
							<td>
								<select name="Addpage_2_ajout">
									<option value="1">Oui</option>
									<option value="0">Non</option>
								</select>
							</td>
							<td>
								<select name="Addpage_3_ajout">
									<option value="1">Oui</option>
									<option value="0">Non</option>
								</select>
							</td>
							<td>
								<select name="Addpage_4_ajout">
									<option value="1">Oui</option>
									<option value="0">Non</option>
								</select>
							</td>
							<td>
								<select name="Addpage_5_ajout">
									<option value="1">Oui</option>
									<option value="0">Non</option>
								</select>
							</td>
							<td>
								<select name="Addpage_6_ajout">
									<option value="1">Oui</option>
									<option value="0">Non</option>
								</select>
							</td>
							<td>
								<select name="Addpage_7_ajout">
									<option value="1">Oui</option>
									<option value="0">Non</option>
								</select>
							</td>
							<td>
								<select name="Addpage_8_ajout">
									<option value="1">Oui</option>
									<option value="0">Non</option>
								</select>
							</td>
							<td>
								<select name="Addpage_9_ajout">
									<option value="1">Oui</option>
									<option value="0">Non</option>
								</select>
							</td>
							<td>
								<select name="Addpage_10_ajout">
									<option value="1">Oui</option>
									<option value="0">Non</option>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="12" >
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