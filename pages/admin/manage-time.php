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
	if($_SESSION['page_10'] != '1'){
		stop($langue->show_text('SystemInfoAccessDenied'), 161, 'index.php?page=login');
	}

	if(isset($_POST['AddCODEEventMach']) AND !empty($_POST['AddCODEEventMach'])){
		//add event machine in db
		$req = $bdd->GetInsert("INSERT INTO ". TABLE_ERP_EVENT_MACHINE ." VALUE ('0',
																		'". addslashes($_POST['AddCODEEventMach']) ."',
																		'". addslashes($_POST['AddORDREEventMach']) ."',
																		'". addslashes($_POST['AddLABELEventMach']) ."',
																		'". addslashes($_POST['AddMASKEventMach']) ."',
																		'". addslashes($_POST['AddCOLOREventMach']) ."',
																		'". addslashes($_POST['AddETATEventMach']) ."'
																		)");
		$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddEventNotification')));
	}
	elseif(isset($_POST['AddLABELImproductTime']) AND !empty($_POST['AddLABELImproductTime'])){
		//add improduct time
		$req = $bdd->GetInsert("INSERT INTO ". TABLE_ERP_EVENT_IMPRODUC_TIME ." VALUE ('0',
																		'". addslashes($_POST['AddLABELImproductTime']) ."',
																		'". addslashes($_POST['AddETATImproductTime']) ."',
																		'". addslashes($_POST['AddRessourceImproductTime']) ."',
																		'". addslashes($_POST['AddMASKImproductTime']) ."'
																		)");
		$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddImproductTimetNotification')));																	
	}
	elseif(isset($_POST['AddCODEAbs']) AND !empty($_POST['AddCODEAbs'])){
		//if add new ligne od absence type
		$req = $bdd->GetInsert("INSERT INTO ". TABLE_ERP_TYPE_ABS ." VALUE ('0',
																		'". addslashes($_POST['AddCODEAbs']) ."',
																		'". addslashes($_POST['AddLABELAbs']) ."',
																		'". addslashes($_POST['AddPAYEAbs']) ."',
																		'". addslashes($_POST['AddCOLORAbs']) ."',
																		'". addslashes($_POST['AddTYPEAbs']) ."')");
			$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddOutNotification')));																
	}
	elseif(isset($_POST['AddLABELFerier']) AND !empty($_POST['AddLABELFerier'])){
		//if add new bank holiday
		$req = $bdd->GetInsert("INSERT INTO ". TABLE_ERP_FERIER ." VALUE ('0',
																		'". addslashes($_POST['AddFixeFerier']) ."',
																		'". addslashes($_POST['AddDATEFerier']) ."',
																		'". addslashes($_POST['AddLABELFerier']) ."')");
		$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddBankNotification')));
	}
	elseif(isset($_POST['CODE']) AND !empty($_POST['CODE'])){
		//if add new hourly model day
		$req = $bdd->GetInsert("INSERT INTO ". TABLE_ERP_DAILY_HOURLY_MODEL ." VALUE ('0',
																		'". addslashes($_POST['CODE']) ."',
																		'". addslashes($_POST['LABEL']) ."')");
		$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddMODELtimeNotification')));
	}
	elseif(isset($_POST['AddORDREHourdlyModelLine']) AND !empty($_POST['AddORDREHourdlyModelLine'])){
		//if add new line of hourly model day 
			$req = $bdd->GetInsert("INSERT INTO ". TABLE_ERP_DAILY_HOURLY_MODEL_LINES ." VALUE ('0',
																			'". addslashes($_GET['HourdlyModel']) ."',
																			'". addslashes($_POST['AddORDREHourdlyModelLine']) ."',
																			'". addslashes($_POST['AddTYPEHourdlyModelLine']) ."',
																			'". addslashes($_POST['AddSTARTHourdlyModelLine']) ."',
																			'". addslashes($_POST['AddENDHourdlyModelLine']) ."')");
			$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddLineMODELtimetNotification')));
	}


	if(isset($_POST['id_EventMach']) AND !empty($_POST['id_EventMach'])){
		//Update list event machine
		$UpdateIdEventMach = $_POST['id_EventMach'];
		$UpdateORDREEventMach = $_POST['UpdateORDREEventMach'];
		$UpdateCODEEventMach = $_POST['UpdateCODEEventMach'];
		$UpdateLABELEventMach = $_POST['UpdateLABELEventMach'];
		$UpdateMASKEventMach = $_POST['UpdateMASKEventMach'];
		$UpdateCOLOREventMach = $_POST['UpdateCOLOREventMach'];
		$UpdateETATEventMach = $_POST['UpdateETATEventMach'];

		$i = 0;
		foreach ($UpdateIdEventMach as $id_generation) {

			$bdd->GetUpdate('UPDATE `'. TABLE_ERP_EVENT_MACHINE .'` SET  CODE = \''. addslashes($UpdateCODEEventMach[$i]) .'\',
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
	elseif(isset($_POST['id_ImproductTime']) AND !empty($_POST['id_ImproductTime'])){
		//update improduct time list
		$i = 0;
		foreach ($_POST['id_ImproductTime'] as $id_generation) {
			$bdd->GetUpdate('UPDATE `'. TABLE_ERP_EVENT_IMPRODUC_TIME .'` SET LABEL = \''. addslashes($_POST['UpdateLABELImproductTime'][$i]) .'\',
																		ETAT_MACHINE = \''. addslashes($_POST['UpdateETATImproductTime'][$i]) .'\',
																		RESSOURCE_NEC = \''. addslashes($_POST['UpdateRESSImproductTime'][$i]) .'\',
																		MASK_TIME = \''. addslashes($_POST['UpdateMASKImproductTime'][$i]) .'\'
																		WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateImproductTimetNotification')));
	}
	elseif(isset($_POST['id_Abs']) AND !empty($_POST['id_Abs'])){
		//update list of absence
		$i = 0;
		foreach ($_POST['id_Abs'] as $id_generation) {
			$bdd->GetUpdate('UPDATE '. TABLE_ERP_TYPE_ABS .' SET CODE = \''. addslashes($_POST['UpdateCODEdAbs'][$i]) .'\',
																		LABEL = \''. addslashes($_POST['UpdateLABELdAbs'][$i]) .'\',
																		PAYE = \''. addslashes($_POST['UpdatePAYEAbs'][$i]) .'\',
																		COLOR = \''. addslashes($_POST['UpdateCOLORAbs'][$i]) .'\',
																		TYPE_JOUR = \''. addslashes($_POST['UpdateTYPEAbs'][$i]) .'\'
																	WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateOutNotification')));
	}
	elseif(isset($_POST['id_Ferrier']) AND !empty($_POST['id_Ferrier'])){
		//update list of bank holiday
		$i = 0;
		foreach ($_POST['id_Ferrier'] as $id_generation) {
			$bdd->GetUpdate('UPDATE '. TABLE_ERP_FERIER .' SET FIXE = \''. addslashes($_POST['UpdateFIXEFerier'][$i]) .'\',
																DATE = \''. addslashes($_POST['UpdateDATEFerier'][$i]) .'\',
																LABEL = \''. addslashes($_POST['UpdateLABELFerier'][$i]) .'\'
															WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateBankNotification')));
	}
	elseif(isset($_POST['UpdateIdHourdlyModel']) AND !empty($_POST['UpdateIdHourdlyModel'])){
		//update hourly model day
		$i = 0;
		foreach ($_POST['UpdateIdHourdlyModel'] as $id_generation) {
			$bdd->GetUpdate('UPDATE '. TABLE_ERP_DAILY_HOURLY_MODEL .' SET  CODE = \''. addslashes($_POST['UpdateCODEHourdlyModel'][$i]) .'\',
																			LABEL = \''. addslashes($_POST['UpdateLABELHourdlyModel'][$i]) .'\'
																		WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateMODELtimeNotification')));
	}
	elseif(isset($_POST['UpdateIdHourdlyModelLine']) AND !empty($_POST['UpdateIdHourdlyModelLine'])){
		//update hourly model day line
		$i = 0;
		foreach ($_POST['UpdateIdHourdlyModelLine'] as $id_generation) {
		
			$bdd->GetUpdate('UPDATE '. TABLE_ERP_DAILY_HOURLY_MODEL_LINES .' SET  ORDRE = \''. addslashes($_POST['UpdateORDREHourdlyModelLine'][$i]) .'\',
																			TYPE = \''. addslashes($_POST['UpdateTYPEHourdlyModelLine'][$i]) .'\',
																			START = \''. addslashes($_POST['UpdateSTARTHourdlyModelLine'][$i]) .'\',
																			END = \''. addslashes($_POST['UpdateENDHourdlyModelLine'][$i]) .'\'
																		WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateLineMODELtimeNotification')));
	}

	if(isset($_GET['HourdlyModel']) AND !empty($_GET['HourdlyModel'])){
		$ParDefautDiv5 = 'id="defaultOpen"';
	}
	else{
		$ParDefautDiv1 = 'id="defaultOpen"';
	}
?>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['timeline']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var container = document.getElementById('timeline');
        var chart = new google.visualization.Timeline(container);
        var dataTable = new google.visualization.DataTable();

        dataTable.addColumn({ type: 'string', id: 'Room' });
		dataTable.addColumn({ type: 'string', id: 'Name' });
		dataTable.addColumn({ type: 'date', id: 'Start' });
		dataTable.addColumn({ type: 'date', id: 'End' });
		dataTable.addRows([
		[ 'day', 'day',       new Date(0,0,0,00,0,0),  new Date(0,0,0,24,0,0) ],
		<?php $query='SELECT '. TABLE_ERP_DAILY_HOURLY_MODEL_LINES .'.id,
									'. TABLE_ERP_DAILY_HOURLY_MODEL_LINES .'.MODEL_ID,
									'. TABLE_ERP_DAILY_HOURLY_MODEL_LINES .'.ORDRE,
									'. TABLE_ERP_DAILY_HOURLY_MODEL_LINES .'.TYPE,
									'. TABLE_ERP_DAILY_HOURLY_MODEL_LINES .'.START,
									'. TABLE_ERP_DAILY_HOURLY_MODEL_LINES .'.END
									FROM `'. TABLE_ERP_DAILY_HOURLY_MODEL_LINES .'`
										WHERE '. TABLE_ERP_DAILY_HOURLY_MODEL_LINES .'.MODEL_ID = \''. 	addslashes($_GET['HourdlyModel']).'\'
									ORDER BY ORDRE';

		$i = 1;
		foreach ($bdd->GetQuery($query) as $data){
			$START=explode(":",$data->START);
			$END=explode(":",$data->END);

			if($data->TYPE == 1) $TYPE = $langue->show_text('Forbiden');
			if($data->TYPE == 2) $TYPE = $langue->show_text('Variable');
			if($data->TYPE == 3) $TYPE = $langue->show_text('Fixed');
		?>
		[ '<?= $TYPE ?>', '<?= $TYPE ?>',       new Date(0,0,0,<?=$START[0]?>,<?=$START[1]?>,<?=$START[2]?>),  new Date(0,0,0,<?=$END[0]?>,<?=$END[1]?>,<?=$END[3]?>) ],
		<?php  $i++; }  ?>
		]);
		var options = {
			timeline: { colorByRowLabel: true },
			width: 1200,
			height: 500,
			timeline: { showRowLabels: false },
       		 avoidOverlappingGridLines: false
		};

		chart.draw(dataTable, options);
      }
    </script>
	<div class="tab">
		<button class="tablinks" onclick="openDiv(event, 'div1')" <?= $ParDefautDiv1 ?>><?=$langue->show_text('Title1'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div2')"><?=$langue->show_text('Title2'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div3')"><?=$langue->show_text('Title3'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div4')"><?=$langue->show_text('Title4'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div5')" <?= $ParDefautDiv5 ?>><?=$langue->show_text('Title5'); ?></button>
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
						//generate list of event machine
						$query='SELECT '. TABLE_ERP_EVENT_MACHINE .'.Id,
									'. TABLE_ERP_EVENT_MACHINE .'.CODE,
									'. TABLE_ERP_EVENT_MACHINE .'.ORDRE,
									'. TABLE_ERP_EVENT_MACHINE .'.LABEL,
									'. TABLE_ERP_EVENT_MACHINE .'.MASK_TIME,
									'. TABLE_ERP_EVENT_MACHINE .'.COLOR,
									'. TABLE_ERP_EVENT_MACHINE .'.ETAT
									FROM `'. TABLE_ERP_EVENT_MACHINE .'`
									ORDER BY Id';

						$i = 1;
						foreach ($bdd->GetQuery($query) as $data): ?>
								<tr>
									<td><?= $i ?> <input type="hidden" name="id_EventMach[]" id="id_EventMach" value="<?= $data->Id ?>"></td>
									<td><input type="number" name="UpdateORDREEventMach[]" value="<?= $data->ORDRE ?>"></td>
									<td><input type="text" name="UpdateCODEEventMach[]" value="<?= $data->CODE ?>" ></td>
									<td><input type="text" name="UpdateLABELEventMach[]" value="<?= $data->LABEL ?>" ></td>
									<td>
										<select name="UpdateMASKEventMach[]">
											<option value="1" <?= selected($data->MASK_TIME, 1) ?>><?= $langue->show_text('Yes') ?></option>
											<option value="0" <?= selected($data->MASK_TIME, 0) ?>><?= $langue->show_text('No') ?></option>
										</select>
									</td>
									<td><input type="color" name="UpdateCOLOREventMach[]" value="<?= $data->COLOR ?>" ></td>
									<td>
										<select name="UpdateETATEventMach[]">
											<option value="1" <?= selected($data->ETAT, 1) ?>><?= $langue->show_text('SelectStop') ?></option>
											<option value="2" <?= selected($data->ETAT, 2) ?>><?= $langue->show_text('SelectSetting') ?></option>
											<option value="3" <?= selected($data->ETAT, 3) ?>><?= $langue->show_text('SelectRun') ?></option>
											<option value="4" <?= selected($data->ETAT, 4) ?>><?= $langue->show_text('SelectOff') ?></option>
										</select>
									</td>
								</tr>
						<?php
						$EventListe .='<option value="'. $data->Id .'">'. $data->LABEL .'</option>';
						$i++; endforeach; ?>
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
							<td><input type="color"  name="AddCOLOREventMach" size="1"></td>
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
								<?= $Form->submit($langue->show_text('TableUpdateButton')) ?> <br/>
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
							//generate list of improduct time
							$i = 1;
							$query='SELECT '. TABLE_ERP_EVENT_IMPRODUC_TIME .'.Id,
									'. TABLE_ERP_EVENT_IMPRODUC_TIME .'.LABEL,
									'. TABLE_ERP_EVENT_IMPRODUC_TIME .'.ETAT_MACHINE,
									'. TABLE_ERP_EVENT_IMPRODUC_TIME .'.RESSOURCE_NEC,
									'. TABLE_ERP_EVENT_IMPRODUC_TIME .'.MASK_TIME,
									'. TABLE_ERP_EVENT_MACHINE .'.LABEL AS LABEL_EVENT_MACHINE
									FROM `'. TABLE_ERP_EVENT_IMPRODUC_TIME .'`
										LEFT JOIN `'. TABLE_ERP_EVENT_MACHINE .'` ON `'. TABLE_ERP_EVENT_MACHINE .'`.`id` = `'. TABLE_ERP_EVENT_IMPRODUC_TIME .'`.`ETAT_MACHINE`
									ORDER BY Id';

							$i = 1;
							foreach ($bdd->GetQuery($query) as $data): ?>
						<tr>
							<td><?= $i ?> <input type="hidden" name="id_ImproductTime[]" id="id_ImproductTime" value="<?= $data->Id ?>"></td>
							<td><input type="text" name="UpdateLABELImproductTime[]" value="<?= $data->LABEL ?>" ></td>
							<td>
								<select name="UpdateETATImproductTime[]">
									<option value="<?= $data->ETAT_MACHINE ?>"><?= $data->LABEL_EVENT_MACHINE ?></option>
									<?= $EventListe  ?>
								</select>
							</td>
							<td>
								<select name="UpdateRESSImproductTime[]">
									<option value="1" <?= selected($data->RESSOURCE_NEC, 1) ?>><?= $langue->show_text('Yes') ?></option>
									<option value="0" <?= selected($data->RESSOURCE_NEC, 0) ?>><?= $langue->show_text('No') ?></option>
								</select>
							</td>
							<td>
								<select name="UpdateMASKImproductTime[]">
									<option value="1" <?= selected($data->MASK_TIME, 1) ?>><?= $langue->show_text('Yes') ?></option>
									<option value="0" <?= selected($data->MASK_TIME, 0) ?>><?= $langue->show_text('No') ?></option>
								</select>
							</td>
						</tr>
						<?php $i++; endforeach; ?>
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
								<?= $Form->submit($langue->show_text('TableUpdateButton')) ?> <br/>
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

						//generate list of absence
						$i = 1;
						$query='SELECT '. TABLE_ERP_TYPE_ABS .'.Id,
									'. TABLE_ERP_TYPE_ABS .'.CODE,
									'. TABLE_ERP_TYPE_ABS .'.LABEL,
									'. TABLE_ERP_TYPE_ABS .'.PAYE,
									'. TABLE_ERP_TYPE_ABS .'.COLOR,
									'. TABLE_ERP_TYPE_ABS .'.TYPE_JOUR
									FROM `'. TABLE_ERP_TYPE_ABS .'`
									ORDER BY Id';

									$i = 1;
						foreach ($bdd->GetQuery($query) as $data): ?>
						<tr>
							<td><?= $i ?> <input type="hidden" name="id_Abs[]" id="id_Abs" value="<?= $data->Id ?>"></td>
							<td><input type="text" name="UpdateCODEdAbs[]" value="<?= $data->CODE ?>" ></td>
							<td><input type="text" name="UpdateLABELdAbs[]" value="<?= $data->LABEL ?>" ></td>
							<td>
								<select name="UpdatePAYEAbs[]">
									<option value="1" <?= selected($data->PAYE, 1) ?>><?= $langue->show_text('Yes') ?></option>
									<option value="0" <?= selected($data->PAYE, 0) ?>><?= $langue->show_text('No') ?></option>
								</select>
							</td>
							<td><input type="color" value="<?= $data->COLOR ?>"  name="UpdateCOLORAbs[]" ></td>
							<td>
								<select name="UpdateTYPEAbs[]">
									<option value="0" <?= selected($data->TYPE_JOUR, 0) ?>><?= $langue->show_text('SelectWorked') ?></option>
									<option value="1" <?= selected($data->TYPE_JOUR, 1) ?>><?= $langue->show_text('SelectOpenable') ?></option>
									<option value="2" <?= selected($data->TYPE_JOUR, 2) ?>><?= $langue->show_text('SelectCalendar') ?></option>
								</select>
							</td>
						</tr>
						<?php $i++; endforeach; ?>
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
								<?= $Form->submit($langue->show_text('TableUpdateButton')) ?> <br/>
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
							//generate list of bank holiday
							$query='SELECT '. TABLE_ERP_FERIER .'.Id,
									'. TABLE_ERP_FERIER .'.FIXE,
									'. TABLE_ERP_FERIER .'.DATE,
									'. TABLE_ERP_FERIER .'.LABEL
										FROM `'. TABLE_ERP_FERIER .'`
									ORDER BY DATE';

									$i = 1;
						foreach ($bdd->GetQuery($query) as $data): ?>
						<tr>
							<td><?= $i ?> <input type="hidden" name="id_Ferrier[]" id="id_Ferrier" value="<?= $data->Id ?>"></td>
							<td>
								<select name="UpdateFIXEFerier[]">
									<option value="1" <?= selected($data->FIXE, 1) ?>><?= $langue->show_text('Yes') ?></option>
									<option value="0" <?= selected($data->FIXE, 0) ?>><?= $langue->show_text('No') ?></option>
								</select>
							</td>
							<td><input type="date" name="UpdateDATEFerier[]" value="<?= $data->DATE ?>" ></td>
							<td><input type="text" name="UpdateLABELFerier[]" value="<?= $data->LABEL ?>" ></td>
						</tr>
						<?php $i++; endforeach; ?>
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
								<?= $Form->submit($langue->show_text('TableUpdateButton')) ?> <br/>
								<br/>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
	</div>
	<div id="div5" class="tabcontent" >
		<form method="post" name="Section" action="admin.php?page=manage-time&HourdlyModel=<?= $_GET['HourdlyModel']  ?>" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th><?= $langue->show_text('TableCODE'); ?></th>
							<th><?= $langue->show_text('TableLabel'); ?></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php
						// generate list of TimeLine payement
						$query='SELECT '. TABLE_ERP_DAILY_HOURLY_MODEL .'.id,
									'. TABLE_ERP_DAILY_HOURLY_MODEL .'.CODE,
									'. TABLE_ERP_DAILY_HOURLY_MODEL .'.LABEL
									FROM `'. TABLE_ERP_DAILY_HOURLY_MODEL .'`
									ORDER BY id';

						$i = 1;
						foreach ($bdd->GetQuery($query) as $data): ?>
						<tr>
							<td><input type="hidden" name="UpdateIdHourdlyModel[]" id="UpdateIdHourdlyModel" value="<?= $data->id ?>"></td>
							<td><input type="text" name="UpdateCODEHourdlyModel[]" value="<?= $data->CODE ?>" required="required"></td>
							<td><input type="text" name="UpdateLABELHourdlyModel[]" value="<?= $data->LABEL ?>" required="required"></td>
							<td><a href="admin.php?page=manage-time&HourdlyModel=<?= $data->id ?>">--></a></td>
						</tr>
						<?php $i++; endforeach; ?>
						<tr>
							<td><?=$langue->show_text('Addtext'); ?></td>
							<td><input type="text" class="input-moyen-vide" name="CODE"></td>
							<td><input type="text" class="input-moyen-vide" name="LABEL"></td>
							<td></td>
						</tr>
						<tr>
							<td colspan="4" >
								<br/>
								<?= $Form->submit($langue->show_text('TableUpdateButton')) ?> <br/>
								<br/>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
			<?php
			//if user want show timeline detail
			if(isset($_GET['HourdlyModel']) AND !empty($_GET['HourdlyModel'])){

				//generate liste of detail timeline payement
			?>
			
			<form method="post" name="Section" action="admin.php?page=manage-time&HourdlyModel=<?= $_GET['HourdlyModel']  ?>" class="content-form" >
				<table class="content-table-decal">
					<thead>
						<tr>
							<th></th>
							<th><?= $langue->show_text('TableOrder') ?></th>
							<th><?= $langue->show_text('TableType') ?></th>
							<th><?= $langue->show_text('TableStart') ?></th>
							<th><?= $langue->show_text('TableEnd') ?></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					<?php
					//generate list of détail TimeLine payement
					$query='SELECT '. TABLE_ERP_DAILY_HOURLY_MODEL_LINES .'.id,
									'. TABLE_ERP_DAILY_HOURLY_MODEL_LINES .'.MODEL_ID,
									'. TABLE_ERP_DAILY_HOURLY_MODEL_LINES .'.ORDRE,
									'. TABLE_ERP_DAILY_HOURLY_MODEL_LINES .'.TYPE,
									'. TABLE_ERP_DAILY_HOURLY_MODEL_LINES .'.START,
									'. TABLE_ERP_DAILY_HOURLY_MODEL_LINES .'.END,
									TIMEDIFF(END, START) AS TIMEDIFF
									FROM `'. TABLE_ERP_DAILY_HOURLY_MODEL_LINES .'`
										WHERE '. TABLE_ERP_DAILY_HOURLY_MODEL_LINES .'.MODEL_ID = \''. 	addslashes($_GET['HourdlyModel']).'\'
									ORDER BY ORDRE';

						$i = 1;
						foreach ($bdd->GetQuery($query) as $data){
						?>
						<tr>
							<td><input type="hidden" name="UpdateIdHourdlyModelLine[]" id="UpdateIdHourdlyModelLine" value="<?= $data->id ?>" required="required"></td>
							<td><input type="number"  name="UpdateORDREHourdlyModelLine[]" value="<?= $data->ORDRE ?>" required="required"></td>
							<td>
								<select name="UpdateTYPEHourdlyModelLine[]">
									<option value="1" <?= selected($data->TYPE, 1) ?>><?= $langue->show_text('Forbiden') ?></option>
									<option value="2" <?= selected($data->TYPE, 2) ?>><?= $langue->show_text('Variable') ?></option>
									<option value="3" <?= selected($data->TYPE, 3) ?>><?= $langue->show_text('Fixed') ?></option>
								</select>
							</td>
							<td><input type="time"  name="UpdateSTARTHourdlyModelLine[]" value="<?= $data->START ?>"  required="required"></td>
							<td><input type="time" name="UpdateENDHourdlyModelLine[]" value="<?= $data->END ?>" required="required"></td>
							<td><?=$data->TIMEDIFF?></td>
						</tr>
						<?php  $i++; }  ?>
						<tr>
							<td><?= $langue->show_text('Addtext') ?></td>
							<td><input type="number" class="input-moyen-vide" name="AddORDREHourdlyModelLine" ></td>
							<td>
								<select name="AddTYPEHourdlyModelLine">
									<option value="1" ><?= $langue->show_text('Forbiden') ?></option>
									<option value="2" ><?= $langue->show_text('Variable') ?></option>
									<option value="3" ><?= $langue->show_text('Fixed') ?></option>
								</select>
							</td>
							<td><input type="time" value="12:00" name="AddSTARTHourdlyModelLine"  ></td>
							<td><input type="time" value="12:00" max="23:59" name="AddENDHourdlyModelLine" ></td>
							<td></td>
						</tr>
						<tr>
							<td colspan="7" >
								<br/>
								<?= $Form->submit($langue->show_text('TableUpdateButton')) ?> <br/>
								<br/>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
			<div id="timeline" style="margin:auto; margin-top:50px; width: 50%;"></div>
		<?php
			}
		?>
	</div>