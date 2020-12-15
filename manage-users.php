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
	$langue = new Langues('lang', 'manage-users', $UserLanguage);
	//load callOut notification box class
	require_once 'class/callOutBox.class.php';
	$CallOutBox = new CallOutBox();

	//Check if the user is authorized to view the page
	if($_SESSION['page_10'] != '1'){
		stop($langue->show_text('SystemInfoAccessDenied'), 161, 'login.php');
	}

	// if add new employe
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
																		'',
																		'". $_POST['Addposte_ajout'] ."',
																		'". $_POST['Addsection_ajout'] ."',
																		'1')");


	}

	//If add Right
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

	//Update data employees
	if(isset($_POST['id_membre']) AND !empty($_POST['id_membre'])){

		$id_membre = $_POST['id_membre'];
		$CODEmembre = $_POST['CODEmembre'];
		$nom_membre = $_POST['nom_membre'];
		$poste_membre = $_POST['poste_membre'];
		$SECTIONmembre = $_POST['SECTIONmembre'];

		$i = 0;
		foreach ($id_membre as $id_generation) {

			$bdd->exec('UPDATE `'. TABLE_ERP_EMPLOYEES .'` SET  CODE = \''. $CODEmembre[$i] .'\',
																NAME = \''. addslashes($nom_membre[$i]) .'\',
																FONCTION = \''. $poste_membre[$i] .'\',
																SECTION_ID = \''. $SECTIONmembre[$i] .'\'
																WHERE idUser = '. $id_generation . ' ');
			$i++;
		}

		$CallOutBox->add_notification(array('2', $i . ' Ligne(s) employé mise à jours'));
	}

	//Update data right
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

			//Cant be use empty value for sql
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

	//Right list for employees
	$req = $bdd -> query('SELECT Id, RIGHT_NAME   FROM '. TABLE_ERP_RIGHTS .'');
	while ($DonneesRight = $req->fetch()){
		$RightListe .='<option value="'. $DonneesRight['Id'] .'">'. $DonneesRight['RIGHT_NAME'] .'</option>';
	}

	//section list for employees
	$req = $bdd -> query('SELECT Id, LABEL   FROM '. TABLE_ERP_SECTION .'');
	while ($DonneesSection = $req->fetch()){
		$SectionListe .='<option value="'. $DonneesSection['Id'] .'">'. $DonneesSection['LABEL'] .'</option>';
	}

	//Generate employees list
	$i = 1;
	$req = $bdd -> query('SELECT '. TABLE_ERP_EMPLOYEES .'.IdUser,
									'. TABLE_ERP_EMPLOYEES .'.CODE,
									'. TABLE_ERP_EMPLOYEES .'.STATU,
									'. TABLE_ERP_EMPLOYEES .'.CONNEXION,
									'. TABLE_ERP_EMPLOYEES .'.NAME,
									'. TABLE_ERP_EMPLOYEES .'.FONCTION,
									'. TABLE_ERP_EMPLOYEES .'.SECTION_ID,
									'. TABLE_ERP_RIGHTS .'.RIGHT_NAME,
									'. TABLE_ERP_SECTION .'.LABEL
									FROM `'. TABLE_ERP_EMPLOYEES .'`
									LEFT JOIN `'. TABLE_ERP_RIGHTS .'` ON `'. TABLE_ERP_EMPLOYEES .'`.`FONCTION` = `'. TABLE_ERP_RIGHTS .'`.`id`
									LEFT JOIN `'. TABLE_ERP_SECTION .'` ON `'. TABLE_ERP_EMPLOYEES .'`.`SECTION_ID` = `'. TABLE_ERP_SECTION .'`.`id`');



	while ($donnees_membre = $req->fetch()){
		 $EmployeesListContent = $EmployeesListContent .'
				<tr>
					<td>'. $i .' <input type="hidden" name="id_membre[]" id="id_membre" value="'. $donnees_membre['IdUser'] .'"></td>
					<td>'. format_temps($donnees_membre['CONNEXION']) .'</td>
					<td><input type="text" name="CODEmembre[]" value="'. $donnees_membre['CODE'] .'" size="10"></td>
					<td><input type="text" name="nom_membre[]" value="'. $donnees_membre['NAME'] .'" size="10"></td>
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

	//generate right list
	$i = 1;
	$req = $bdd -> query('SELECT Id, RIGHT_NAME, page_1, page_2, page_3, page_4, page_5, page_6, page_7, page_8, page_9, page_10   FROM '. TABLE_ERP_RIGHTS .'');
	while ($DonneesRight = $req->fetch()){
		 $RightContent = $RightContent .'
				<tr>
					<td>'. $i .' <input type="hidden" name="id_Right[]" id="id_Right" value="'. $DonneesRight['Id'] .'"></td>
					<td><input type="text" name="RIGHT_NAME[]" value="'. $DonneesRight['RIGHT_NAME'] .'"></td>
					<td>
						<select name="page_1_membre[]">
							<option value="1" '. selected($DonneesRight['page_1'], "1") .'>'. $langue->show_text('Yes') .'</option>
							<option value="0" '. selected($DonneesRight['page_1'], "0") .'>'. $langue->show_text('No') .'</option>
						</select>
					</td>
					<td>
						<select name="page_2_membre[]">
							<option value="1" '. selected($DonneesRight['page_2'], "1") .'>'. $langue->show_text('Yes') .'</option>
							<option value="0" '. selected($DonneesRight['page_2'], "0") .'>'. $langue->show_text('No') .'</option>
						</select>
					</td>
					<td>
						<select name="page_3_membre[]">
							<option value="1" '. selected($DonneesRight['page_3'], "1") .'>'. $langue->show_text('Yes') .'</option>
							<option value="0" '. selected($DonneesRight['page_3'], "0") .'>'. $langue->show_text('No') .'</option>
						</select>
					</td>
					<td>
						<select name="page_4_membre[]">
							<option value="1" '. selected($DonneesRight['page_4'], "1") .'>'. $langue->show_text('Yes') .'</option>
							<option value="0" '. selected($DonneesRight['page_4'], "0") .'>'. $langue->show_text('No') .'</option>
						</select>
					</td>
					<td>
						<select name="page_5_membre[]">
							<option value="1" '. selected($DonneesRight['page_5'], "1") .'>'. $langue->show_text('Yes') .'</option>
							<option value="0" '. selected($DonneesRight['page_5'], "0") .'>'. $langue->show_text('No') .'</option>
						</select>
					</td>
					<td>
						<select name="page_6_membre[]">
							<option value="1" '. selected($DonneesRight['page_6'], "1") .'>'. $langue->show_text('Yes') .'</option>
							<option value="0" '. selected($DonneesRight['page_6'], "0") .'>'. $langue->show_text('No') .'</option>
						</select>
					</td>
					<td>
						<select name="page_7_membre[]">
							<option value="1" '. selected($DonneesRight['page_7'], "1") .'>'. $langue->show_text('Yes') .'</option>
							<option value="0" '. selected($DonneesRight['page_7'], "0") .'>'. $langue->show_text('No') .'</option>
						</select>
					</td>
					<td>
						<select name="page_8_membre[]">
							<option value="1" '. selected($DonneesRight['page_8'], "1") .'>'. $langue->show_text('Yes') .'</option>
							<option value="0" '. selected($DonneesRight['page_8'], "0") .'>'. $langue->show_text('No') .'</option>
						</select>
					</td>
					<td>
						<select name="page_9_membre[]">
							<option value="1" '. selected($DonneesRight['page_9'], "1") .'>'. $langue->show_text('Yes') .'</option>
							<option value="0" '. selected($DonneesRight['page_9'], "0") .'>'. $langue->show_text('No') .'</option>
						</select>
					</td>
					<td>
						<select name="page_10_membre[]">
							<option value="1" '. selected($DonneesRight['page_10'], "1") .'>'. $langue->show_text('Yes') .'</option>
							<option value="0" '. selected($DonneesRight['page_10'], "0") .'>'. $langue->show_text('No') .'</option>
						</select>
					</td>
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
		<button class="tablinks" onclick="openDiv(event, 'div1')" id="defaultOpen"><?php echo $langue->show_text('Title1'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div2')"><?php echo $langue->show_text('Title2'); ?></button>
	</div>
		<div id="div1" class="tabcontent" >
			<form method="post" name="Employees" action="manage-users.php" class="content-form">
				<table class="content-table" >
					<thead>
						<tr>
							<th><?php echo $langue->show_text('TableNumber'); ?></th>
							<th><?php echo $langue->show_text('TableLastConnexion'); ?></th>
							<th><?php echo $langue->show_text('TableCODE'); ?></th>
							<th><?php echo $langue->show_text('TableSeudo'); ?></th>
							<th><?php echo $langue->show_text('TableRight'); ?></th>
							<th><?php echo $langue->show_text('TableSection'); ?></th>
						</tr>
					</thead>
					<tbody>
<?php
								Echo $EmployeesListContent;
?>
						<tr>
							<td><?php echo $langue->show_text('Addtext'); ?></td>
							<td></td>
							<td><input type="text" class="input-moyen-vide" name="Addcode_ajout" size="1"></td>
							<td><input type="text" class="input-moyen-vide" name="Addnom_ajout" size="1"></td>
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
							<td colspan="6" >
								<br/>
								<input type="submit" class="input-moyen" value="<?php echo $langue->show_text('TableUpdateButton'); ?>" /> <br/>
								<br/>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>
		<div id="div2" class="tabcontent">
			<form method="post" name="Right" action="manage-users.php" class="content-form">
				<table class="content-table" >
					<thead>
						<tr>
							<th></th>
							<th><?php echo $langue->show_text('TableRightName'); ?></th>
							<th><?php echo $langue->show_text('TableIndex'); ?></th>
							<th><?php echo $langue->show_text('TableQuoteStudy'); ?></th>
							<th><?php echo $langue->show_text('TableOrder'); ?></th>
							<th><?php echo $langue->show_text('TablePlanning'); ?></th>
							<th><?php echo $langue->show_text('TableCalendar'); ?></th>
							<th><?php echo $langue->show_text('TablePurchase'); ?></th>
							<th><?php echo $langue->show_text('TableArticle'); ?></th>
							<th><?php echo $langue->show_text('TableQuality'); ?></th>
							<th><?php echo $langue->show_text('TableGeneralSetting'); ?></th>
							<th><?php echo $langue->show_text('TableAcounting'); ?></th>
						</tr>
					</thead>
					<tbody>
<?php
								Echo $RightContent;
?>
						<tr>
							<td><?php echo $langue->show_text('Addtext'); ?></td>
							<td><input type="text" class="input-moyen-vide" name="AddRight" size="1"></td>
							<td>
								<select name="Addpage_1_ajout">
								<option value="1">"<?php echo $langue->show_text('Yes'); ?></option>
									<option value="0"><?php echo $langue->show_text('No'); ?></option>
								</select>
							</td>
							<td>
								<select name="Addpage_2_ajout">
								<option value="1">"<?php echo $langue->show_text('Yes'); ?></option>
									<option value="0"><?php echo $langue->show_text('No'); ?></option>
								</select>
							</td>
							<td>
								<select name="Addpage_3_ajout">
									<option value="1">"<?php echo $langue->show_text('Yes'); ?></option>
									<option value="0"><?php echo $langue->show_text('No'); ?></option>
								</select>
							</td>
							<td>
								<select name="Addpage_4_ajout">
									<option value="1">"<?php echo $langue->show_text('Yes'); ?></option>
									<option value="0"><?php echo $langue->show_text('No'); ?></option>
								</select>
							</td>
							<td>
								<select name="Addpage_5_ajout">
									<option value="1">"<?php echo $langue->show_text('Yes'); ?></option>
									<option value="0"><?php echo $langue->show_text('No'); ?></option>
								</select>
							</td>
							<td>
								<select name="Addpage_6_ajout">
									<option value="1">"<?php echo $langue->show_text('Yes'); ?></option>
									<option value="0"><?php echo $langue->show_text('No'); ?></option>
								</select>
							</td>
							<td>
								<select name="Addpage_7_ajout">
								<option value="1">"<?php echo $langue->show_text('Yes'); ?></option>
									<option value="0"><?php echo $langue->show_text('No'); ?></option>
								</select>
							</td>
							<td>
								<select name="Addpage_8_ajout">
								<option value="1">"<?php echo $langue->show_text('Yes'); ?></option>
									<option value="0"><?php echo $langue->show_text('No'); ?></option>
								</select>
							</td>
							<td>
								<select name="Addpage_9_ajout">
								<option value="1">"<?php echo $langue->show_text('Yes'); ?></option>
									<option value="0"><?php echo $langue->show_text('No'); ?></option>
								</select>
							</td>
							<td>
								<select name="Addpage_10_ajout">
									<option value="1">"<?php echo $langue->show_text('Yes'); ?></option>
									<option value="0"><?php echo $langue->show_text('No'); ?></option>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="12" >
								<br/>
								<input type="submit" class="input-moyen" value="<?php echo $langue->show_text('TableUpdateButton'); ?>" /> <br/>
								<br/>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
	</div>
</body>
</html>