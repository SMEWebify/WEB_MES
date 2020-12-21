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
	$langue = new Language('lang', 'manage-time', $UserLanguage);
	//init call out box for notification
	$CallOutBox = new CallOutBox();

	//Check if the user is authorized to view the page
	if($_SESSION['page_10'] != '1'){
		stop($langue->show_text('SystemInfoAccessDenied'), 161, 'login.php');
	}

	////////////////////////
	//// EVENT MACHINE////
	///////////////////////
	//add event machine in db
	if(isset($_POST['AddCODEEventMach']) AND !empty($_POST['AddCODEEventMach'])){

		$req = $bdd->exec("INSERT INTO ". TABLE_ERP_EVENT_MACHINE ." VALUE ('0',
																		'". addslashes($_POST['AddCODEEventMach']) ."',
																		'". addslashes($_POST['AddORDREEventMach']) ."',
																		'". addslashes($_POST['AddLABELEventMach']) ."',
																		'". addslashes($_POST['AddMASKEventMach']) ."',
																		'". addslashes($_POST['AddCOLOREventMach']) ."',
																		'". addslashes($_POST['AddETATEventMach']) ."'
																		)");
		$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddEventNotification')));
	}

	//Update list event machine
	if(isset($_POST['id_EventMach']) AND !empty($_POST['id_EventMach'])){

		$UpdateIdEventMach = $_POST['id_EventMach'];
		$UpdateORDREEventMach = $_POST['UpdateORDREEventMach'];
		$UpdateCODEEventMach = $_POST['UpdateCODEEventMach'];
		$UpdateLABELEventMach = $_POST['UpdateLABELEventMach'];
		$UpdateMASKEventMach = $_POST['UpdateMASKEventMach'];
		$UpdateCOLOREventMach = $_POST['UpdateCOLOREventMach'];
		$UpdateETATEventMach = $_POST['UpdateETATEventMach'];

		$i = 0;
		foreach ($UpdateIdEventMach as $id_generation) {

			$bdd->exec('UPDATE `'. TABLE_ERP_EVENT_MACHINE .'` SET  CODE = \''. addslashes($UpdateCODEEventMach[$i]) .'\',
																ORDRE = \''. addslashes($UpdateORDREEventMach[$i]) .'\',
																LABEL = \''. addslashes($UpdateLABELEventMach[$i]) .'\',
																MASK_TIME = \''. addslashes($UpdateMASKEventMach[$i]) .'\',
																COLOR = \''. addslashes($UpdateCOLOREventMach[$i]) .'\',
																ETAT = \''. addslashes($UpdateETATEventMach[$i]) .'\'
																WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateEventNotification')));
	}

	//generate list of event machine
	$i = 1;
	$req = $bdd -> query('SELECT '. TABLE_ERP_EVENT_MACHINE .'.Id,
									'. TABLE_ERP_EVENT_MACHINE .'.CODE,
									'. TABLE_ERP_EVENT_MACHINE .'.ORDRE,
									'. TABLE_ERP_EVENT_MACHINE .'.LABEL,
									'. TABLE_ERP_EVENT_MACHINE .'.MASK_TIME,
									'. TABLE_ERP_EVENT_MACHINE .'.COLOR,
									'. TABLE_ERP_EVENT_MACHINE .'.ETAT
									FROM `'. TABLE_ERP_EVENT_MACHINE .'`
									ORDER BY Id');

	while ($donnees_EventMach = $req->fetch()){
		 $contenu1 = $contenu1 .'
				<tr>
					<td>'. $i .' <input type="hidden" name="id_EventMach[]" id="id_EventMach" value="'. $donnees_EventMach['Id'] .'"></td>
					<td><input type="number" name="UpdateORDREEventMach[]" value="'. $donnees_EventMach['ORDRE'] .'"></td>
					<td><input type="text" name="UpdateCODEEventMach[]" value="'. $donnees_EventMach['CODE'] .'" ></td>
					<td><input type="text" name="UpdateLABELEventMach[]" value="'. $donnees_EventMach['LABEL'] .'" ></td>
					<td>
						<select name="UpdateMASKEventMach[]">
							<option value="1" '. selected($donnees_EventMach['MASK_TIME'], 1) .'>'. $langue->show_text('Yes') .'</option>
							<option value="0" '. selected($donnees_EventMach['MASK_TIME'], 0) .'>'. $langue->show_text('No') .'</option>
						</select>
					</td>
					<td><input type="color" name="UpdateCOLOREventMach[]" value="'. $donnees_EventMach['COLOR'] .'" ></td>
					<td>
						<select name="UpdateETATEventMach[]">
							<option value="1" '. selected($donnees_EventMach['ETAT'], 1) .'>'. $langue->show_text('SelectStop') .'</option>
							<option value="2" '. selected($donnees_EventMach['ETAT'], 2) .'>'. $langue->show_text('SelectSetting') .'</option>
							<option value="3" '. selected($donnees_EventMach['ETAT'], 3) .'>'. $langue->show_text('SelectRun') .'</option>
							<option value="4" '. selected($donnees_EventMach['ETAT'], 4) .'>'. $langue->show_text('SelectOff') .'</option>
						</select>
					</td>
				</tr>	';

		$EventListe .='<option value="'. $donnees_EventMach['Id'] .'">'. $donnees_EventMach['LABEL'] .'</option>';
		$i++;
	}

	////////////////////////
	//// IMPRODUCT TIME ////
	///////////////////////

	//add improduct time
	if(isset($_POST['AddLABELImproductTime']) AND !empty($_POST['AddLABELImproductTime'])){
		$req = $bdd->exec("INSERT INTO ". TABLE_ERP_EVENT_IMPRODUC_TIME ." VALUE ('0',
																		'". addslashes($_POST['AddLABELImproductTime']) ."',
																		'". addslashes($_POST['AddETATImproductTime']) ."',
																		'". addslashes($_POST['AddRessourceImproductTime']) ."',
																		'". addslashes($_POST['AddMASKImproductTime']) ."'
																		)");
		$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddImproductTimetNotification')));																	
	}

	//update improduct time list
	if(isset($_POST['id_ImproductTime']) AND !empty($_POST['id_ImproductTime'])){

		$UpdateIdEventMach = $_POST['id_ImproductTime'];
		$UpdateLABELImproductTime = $_POST['UpdateLABELImproductTime'];
		$UpdateETATImproductTime = $_POST['UpdateETATImproductTime'];
		$UpdateRESSImproductTime = $_POST['UpdateRESSImproductTime'];
		$UpdateMASKImproductTime = $_POST['UpdateMASKImproductTime'];

		$i = 0;
		foreach ($UpdateIdEventMach as $id_generation) {
			$bdd->exec('UPDATE `'. TABLE_ERP_EVENT_IMPRODUC_TIME .'` SET LABEL = \''. addslashes($UpdateLABELImproductTime[$i]) .'\',
																		ETAT_MACHINE = \''. addslashes($UpdateETATImproductTime[$i]) .'\',
																		RESSOURCE_NEC = \''. addslashes($UpdateRESSImproductTime[$i]) .'\',
																		MASK_TIME = \''. addslashes($UpdateMASKImproductTime[$i]) .'\'
																		WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateImproductTimetNotification')));
	}

	//generate list of improduct time
	$i = 1;
	$req = $bdd -> query('SELECT '. TABLE_ERP_EVENT_IMPRODUC_TIME .'.Id,
									'. TABLE_ERP_EVENT_IMPRODUC_TIME .'.LABEL,
									'. TABLE_ERP_EVENT_IMPRODUC_TIME .'.ETAT_MACHINE,
									'. TABLE_ERP_EVENT_IMPRODUC_TIME .'.RESSOURCE_NEC,
									'. TABLE_ERP_EVENT_IMPRODUC_TIME .'.MASK_TIME,
									'. TABLE_ERP_EVENT_MACHINE .'.LABEL AS LABEL_EVENT_MACHINE
									FROM `'. TABLE_ERP_EVENT_IMPRODUC_TIME .'`
										LEFT JOIN `'. TABLE_ERP_EVENT_MACHINE .'` ON `'. TABLE_ERP_EVENT_MACHINE .'`.`id` = `'. TABLE_ERP_EVENT_IMPRODUC_TIME .'`.`ETAT_MACHINE`
									ORDER BY Id');

	while ($donnees_ImproductTime = $req->fetch()){
		 $contenu2 = $contenu2 .'
				<tr>
					<td>'. $i .' <input type="hidden" name="id_ImproductTime[]" id="id_ImproductTime" value="'. $donnees_ImproductTime['Id'] .'"></td>
					<td><input type="text" name="UpdateLABELImproductTime[]" value="'. $donnees_ImproductTime['LABEL'] .'" ></td>
					<td>
						<select name="UpdateETATImproductTime[]">
							<option value="'. $donnees_ImproductTime['ETAT_MACHINE'] .'">'. $donnees_ImproductTime['LABEL_EVENT_MACHINE'] .'</option>
							'. $EventListe  .'
						</select>
					</td>
					<td>
						<select name="UpdateRESSImproductTime[]">
							<option value="1" '. selected($donnees_ImproductTime['RESSOURCE_NEC'], 1) .'>'. $langue->show_text('Yes') .'</option>
							<option value="0" '. selected($donnees_ImproductTime['RESSOURCE_NEC'], 0) .'>'. $langue->show_text('No') .'</option>
						</select>
					</td>
					<td>
						<select name="UpdateMASKImproductTime[]">
							<option value="1" '. selected($donnees_ImproductTime['MASK_TIME'], 1) .'>'. $langue->show_text('Yes') .'</option>
							<option value="0" '. selected($donnees_ImproductTime['MASK_TIME'], 0) .'>'. $langue->show_text('No') .'</option>
						</select>
					</td>
				</tr>	';
		$i++;
	}

	////////////////////////
	//// TYPE ABSENCE ////
	///////////////////////

	//if add new ligne od absence type
	if(isset($_POST['AddCODEAbs']) AND !empty($_POST['AddCODEAbs'])){
		$req = $bdd->exec("INSERT INTO ". TABLE_ERP_TYPE_ABS ." VALUE ('0',
																		'". addslashes($_POST['AddCODEAbs']) ."',
																		'". addslashes($_POST['AddLABELAbs']) ."',
																		'". addslashes($_POST['AddPAYEAbs']) ."',
																		'". addslashes($_POST['AddCOLORAbs']) ."',
																		'". addslashes($_POST['AddTYPEAbs']) ."')");
			$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddOutNotification')));																
	}

	//update list of absence
	if(isset($_POST['id_Abs']) AND !empty($_POST['id_Abs'])){

		$UpdateIdAbs = $_POST['id_Abs'];
		$UpdateCODEdAbs = $_POST['UpdateCODEdAbs'];
		$UpdateLABELdAbs = $_POST['UpdateLABELdAbs'];
		$UpdatePAYEAbs = $_POST['UpdatePAYEAbs'];
		$UpdateCOLORAbs = $_POST['UpdateCOLORAbs'];
		$UpdateTYPEAbs = $_POST['UpdateTYPEAbs'];

		$i = 0;
		foreach ($UpdateIdAbs as $id_generation) {
			$bdd->exec('UPDATE `'. TABLE_ERP_TYPE_ABS .'` SET CODE = \''. addslashes($UpdateCODEdAbs[$i]) .'\',
																		LABEL = \''. addslashes($UpdateLABELdAbs[$i]) .'\',
																		PAYE = \''. addslashes($UpdatePAYEAbs[$i]) .'\',
																		COLOR = \''. addslashes($UpdateCOLORAbs[$i]) .'\',
																		TYPE_JOUR = \''. addslashes($UpdateTYPEAbs[$i]) .'\'
																		WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateOutNotification')));
	}

	//generate list of absence
	$i = 1;
	$req = $bdd -> query('SELECT '. TABLE_ERP_TYPE_ABS .'.Id,
									'. TABLE_ERP_TYPE_ABS .'.CODE,
									'. TABLE_ERP_TYPE_ABS .'.LABEL,
									'. TABLE_ERP_TYPE_ABS .'.PAYE,
									'. TABLE_ERP_TYPE_ABS .'.COLOR,
									'. TABLE_ERP_TYPE_ABS .'.TYPE_JOUR
									FROM `'. TABLE_ERP_TYPE_ABS .'`
									ORDER BY Id');

	while ($donnees_TypeAbs = $req->fetch()){
		 $contenu3 = $contenu3 .'
				<tr>
					<td>'. $i .' <input type="hidden" name="id_Abs[]" id="id_Abs" value="'. $donnees_TypeAbs['Id'] .'"></td>
					<td><input type="text" name="UpdateCODEdAbs[]" value="'. $donnees_TypeAbs['CODE'] .'" ></td>
					<td><input type="text" name="UpdateLABELdAbs[]" value="'. $donnees_TypeAbs['LABEL'] .'" ></td>
					<td>
						<select name="UpdatePAYEAbs[]">
							<option value="1" '. selected($donnees_TypeAbs['PAYE'], 1) .'>'. $langue->show_text('Yes') .'</option>
							<option value="0" '. selected($donnees_TypeAbs['PAYE'], 0) .'>'. $langue->show_text('No') .'</option>
						</select>
					</td>
					<td><input type="color" value="'. $donnees_TypeAbs['COLOR'] .'"  name="UpdateCOLORAbs[]" ></td>
					<td>
						<select name="UpdateTYPEAbs[]">
							<option value="0" '. selected($donnees_TypeAbs['TYPE_JOUR'], 0) .'>'. $langue->show_text('SelectWorked') .'</option>
							<option value="1" '. selected($donnees_TypeAbs['TYPE_JOUR'], 1) .'>'. $langue->show_text('SelectOpenable') .'</option>
							<option value="2" '. selected($donnees_TypeAbs['TYPE_JOUR'], 2) .'>'. $langue->show_text('SelectCalendar') .'</option>
						</select>
					</td>
				</tr>	';
		$i++;
	}

	////////////////////////
	//// bank holiday ////
	///////////////////////

	//if add new bank holiday
	if(isset($_POST['AddLABELFerier']) AND !empty($_POST['AddLABELFerier'])){
		$req = $bdd->exec("INSERT INTO ". TABLE_ERP_FERIER ." VALUE ('0',
																		'". addslashes($_POST['AddFixeFerier']) ."',
																		'". addslashes($_POST['AddDATEFerier']) ."',
																		'". addslashes($_POST['AddLABELFerier']) ."')");
		$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddBankNotification')));
	}

	//update list of bank holiday
	if(isset($_POST['id_Ferrier']) AND !empty($_POST['id_Ferrier'])){
		$UpdateIdFerier = $_POST['id_Ferrier'];
		$UpdateFIXEFerier = $_POST['UpdateFIXEFerier'];
		$UpdateDATEFerier = $_POST['UpdateDATEFerier'];
		$UpdateLABELFerier = $_POST['UpdateLABELFerier'];

		$i = 0;
		foreach ($UpdateIdFerier as $id_generation) {
			$bdd->exec('UPDATE `'. TABLE_ERP_FERIER .'` SET FIXE = \''. addslashes($UpdateFIXEFerier[$i]) .'\',
															DATE = \''. addslashes($UpdateDATEFerier[$i]) .'\',
															LABEL = \''. addslashes($UpdateLABELFerier[$i]) .'\'
														WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateBankNotification')));
	}

	//generate list of bank holiday
	$i = 1;
	$req = $bdd -> query('SELECT '. TABLE_ERP_FERIER .'.Id,
									'. TABLE_ERP_FERIER .'.FIXE,
									'. TABLE_ERP_FERIER .'.DATE,
									'. TABLE_ERP_FERIER .'.LABEL
										FROM `'. TABLE_ERP_FERIER .'`
									ORDER BY DATE');

	while ($donnees_Ferier = $req->fetch()){
		 $contenu4 = $contenu4 .'
				<tr>
					<td>'. $i .' <input type="hidden" name="id_Ferrier[]" id="id_Ferrier" value="'. $donnees_Ferier['Id'] .'"></td>
					<td>
						<select name="UpdateFIXEFerier[]">
							<option value="1" '. selected($donnees_Ferier['FIXE'], 1) .'>'. $langue->show_text('Yes') .'</option>
							<option value="0" '. selected($donnees_Ferier['FIXE'], 0) .'>'. $langue->show_text('No') .'</option>
						</select>
					</td>
					<td><input type="date" name="UpdateDATEFerier[]" value="'. $donnees_Ferier['DATE'] .'" ></td>
					<td><input type="text" name="UpdateLABELFerier[]" value="'. $donnees_Ferier['LABEL'] .'" ></td>
				</tr>';
		$i++;
	}
?>
<script type="text/javascript">
  google.charts.load("current", {packages:["timeline"]});
  google.charts.load('visualization', '1', {'packages':['corechart'], 'language': 'en'});
  google.charts.setOnLoadCallback(drawChart);
  function drawChart() {

    var container = document.getElementById('example5.1');
    var chart = new google.visualization.Timeline(container);
    var dataTable = new google.visualization.DataTable();
    dataTable.addColumn({ type: 'string', id: 'Room' });
    dataTable.addColumn({ type: 'string', id: 'Name' });
    dataTable.addColumn({ type: 'date', id: 'Start' });
    dataTable.addColumn({ type: 'date', id: 'End' });
    dataTable.addRows([
      [ 'Interdite', 'Interdite',       new Date(0,0,0,03,0,0),  new Date(0,0,0,9,0,0) ],
      [ 'Variable', 'Variable',    new Date(0,0,0,9,0,0),  new Date(0,0,0,9,30,0) ],
      [ 'Fixe', 'Fixe',        new Date(0,0,0,9,30,0),  new Date(0,0,0,12,30,0) ],
      [ 'Variable',   'Variable',    new Date(0,0,0,12,30,0), new Date(0,0,0,14,0,0) ],
      [ 'Fixe',   'Fixe', new Date(0,0,0,14,0,0), new Date(0,0,0,17,0,0) ],
      [ 'Interdite',   'Interdite',     new Date(0,0,0,17,00,0), new Date(0,0,0,18,0,0) ]]);

    var options = {
      timeline: { colorByRowLabel: true },
	  width: 1200
    };

    chart.draw(dataTable, options);
  }

</script>

	<div class="tab">
		<button class="tablinks" onclick="openDiv(event, 'div1')" id="defaultOpen"><?=$langue->show_text('Title1'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div2')"><?=$langue->show_text('Title2'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div3')"><?=$langue->show_text('Title3'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div4')"><?=$langue->show_text('Title4'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div5')"><?=$langue->show_text('Title5'); ?></button>
	</div>
	<div id="div1" class="tabcontent" >
		<form method="post" name="Section" action="admin.php?page=manage-time" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th><?=$langue->show_text('TableOrder'); ?></th>
							<th><?=$langue->show_text('TableCODE'); ?></th>
							<th><?=$langue->show_text('TableLabel'); ?></th>
							<th><?=$langue->show_text('TableMasktime'); ?></th>
							<th><?=$langue->show_text('TableColor'); ?></th>
							<th><?=$langue->show_text('TableMachineStatu'); ?></th>
						</tr>
					</thead>
					<tbody>
<?php
								Echo $contenu1;
?>
						<tr>
							<td><?=$langue->show_text('Addtext'); ?></td>
							<td><input type="number" class="input-moyen-vide" name="AddORDREEventMach"></td>
							<td><input type="text" class="input-moyen-vide" name="AddCODEEventMach"></td>
							<td><input type="text" class="input-moyen-vide" name="AddLABELEventMach" ></td>
							<td>
								<select name="AddMASKEventMach">
									<option value="0"><?=$langue->show_text('No'); ?></option>
									<option value="1"><?=$langue->show_text('Yes'); ?></option>
								</select>
							</td>
							<td><input type="color" class="input-moyen-vide" name="AddCOLOREventMach" size="1"></td>
							<td>
								<select name="AddETATEventMach">
									<option value="1"><?=$langue->show_text('SelectStop'); ?></option>
									<option value="2"><?=$langue->show_text('SelectSetting'); ?></option>
									<option value="3"><?=$langue->show_text('SelectRun'); ?></option>
									<option value="4"><?=$langue->show_text('SelectOff'); ?></option>
								</select>
							</td>
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
	<div id="div2" class="tabcontent" >
			<form method="post" name="Section" action="admin.php?page=manage-time" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th><?=$langue->show_text('TableLabel'); ?></th>
							<th><?=$langue->show_text('TableMachineStatu'); ?></th>
							<th><?=$langue->show_text('TablenecessaryRessource'); ?></th>
							<th><?=$langue->show_text('TableMasktime'); ?></th>
						</tr>
					</thead>
					<tbody>
<?php
								Echo $contenu2;
?>
						<tr>
							<td><?=$langue->show_text('Addtext'); ?></td>
							<td><input type="text" class="input-moyen-vide" name="AddLABELImproductTime" ></td>
							<td>
								<select name="AddETATImproductTime">
									<?=$EventListe ; ?>
								</select>
							</td>
							<td>
								<select name="AddRessourceImproductTime">
									<option value="0"><?=$langue->show_text('No'); ?></option>
									<option value="1"><?=$langue->show_text('Yes'); ?></option>
								</select>
							</td>
							<td>
								<select name="AddMASKImproductTime">
									<option value="0"><?=$langue->show_text('No'); ?></option>
									<option value="1"><?=$langue->show_text('Yes'); ?></option>
								</select>
							</td>
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
	<div id="div3" class="tabcontent" >
			<form method="post" name="Section" action="admin.php?page=manage-time" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th><?=$langue->show_text('TableCODE'); ?></th>
							<th><?=$langue->show_text('TableLabel'); ?></th>
							<th><?=$langue->show_text('TablePaid'); ?></th>
							<th><?=$langue->show_text('TableColor'); ?></th>
							<th><?=$langue->show_text('TableDayType'); ?></th>
						</tr>
					</thead>
					<tbody>
							<?php

								Echo $contenu3;
							?>
						<tr>
							<td><?=$langue->show_text('Addtext'); ?></td>
							<td><input type="text" class="input-moyen-vide" name="AddCODEAbs" ></td>
							<td><input type="text" class="input-moyen-vide" name="AddLABELAbs" ></td>
							<td>
								<select name="AddPAYEAbs">
									<option value="0"><?=$langue->show_text('No'); ?></option>
									<option value="1"><?=$langue->show_text('Yes'); ?></option>
								</select>
							</td>
							<td><input type="color"  name="AddCOLORAbs" ></td>
							<td>
								<select name="AddTYPEAbs">
									<option value="0"><?=$langue->show_text('SelectWorked'); ?></option>
									<option value="1"><?=$langue->show_text('SelectOpenable'); ?></option>
									<option value="2"><?=$langue->show_text('SelectCalendar'); ?></option>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="6" >
								<br/>
								<input type="submit" class="input-moyen" value="<?=$langue->show_text('TableUpdateButton'); ?>" /> <br/>
								<br/>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>
	<div id="div4" class="tabcontent" >
			<form method="post" name="Section" action="admin.php?page=manage-time" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th><?=$langue->show_text('TableFixedDate'); ?></th>
							<th><?=$langue->show_text('TableDate'); ?></th>
							<th><?=$langue->show_text('TableLabel'); ?></th>
						</tr>
					</thead>
					<tbody>
<?php
								Echo $contenu4;
?>
						<tr>
							<td><?=$langue->show_text('Addtext'); ?></td>
							<td>
								<select name="AddFixeFerier">
									<option value="1"><?=$langue->show_text('Yes'); ?></option>
									<option value="0"><?=$langue->show_text('No'); ?></option>
								</select>
							</td>
							<td><input type="date" class="input-moyen-vide" name="AddDATEFerier" ></td>
							<td><input type="text" class="input-moyen-vide" name="AddLABELFerier" ></td>
						</tr>
						<tr>
							<td colspan="4" >
								<br/>
								<input type="submit" class="input-moyen" value="<?=$langue->show_text('TableUpdateButton'); ?>" /> <br/>
								<br/>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
	</div>
	<div id="div5" class="tabcontent" >
		<form method="post" name="Section" action="admin.php?page=manage-time" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<div id="example5.1" style="height: 200px; width: 1300px;"></div>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
	</div>