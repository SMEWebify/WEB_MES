<?php 
	//phpinfo();
	use \App\Autoloader;
	use \App\Form;

	use \App\Methods\Ressource;
	use \App\COMPANY\Employees;
	use \App\Quality\QL_Causes;
	use \App\Quality\QL_Defaut;
	use \App\Quality\QL_Corrections;
	use \App\Quality\QL_Devices;

	//auto load class
	require_once '../app/Autoload.class.php';
	Autoloader::register();
	
	session_start();
	header( 'content-type: text/html; charset=utf-8' );
	//init form class
	$Form = new Form($_POST);
	$Employees = new Employees();
	$Ressource = new Ressource();
	$QL_Causes = new QL_Causes();
	$QL_Defaut = new QL_Defaut();
	$QL_Corrections = new QL_Corrections();
	$QL_Devices = new QL_Devices();


	//Check if the user is authorized to view the page
	if($_SESSION['page_10'] != '1'){
		stop($langue->show_text('SystemInfoAccessDenied'), 161, 'index.php?page=login');
	}

	///////////////////////////
	////MEASURING DEVICE SECTION ///
	//////////////////////////

	//Create New device
	if(isset($_POST['AddCODEAppareil']) AND !empty($_POST['AddCODEAppareil'])){

		$req = $bdd->GetInsert("INSERT INTO ". TABLE_ERP_QL_APP_MESURE ." VALUE ('0',
																		'". addslashes($_POST['AddCODEAppareil']) ."',
																		'". addslashes($_POST['AddLABELAppareil']) ."',
																		'". addslashes($_POST['AddRESSOURCEAppareil']) ."',
																		'". addslashes($_POST['AddUSERAppareil']) ."',
																		'". addslashes($_POST['AddIMMATAppareil']) ."',
																		'". addslashes($_POST['AddDATEAppareil']) ."',
																		'')");
		$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddDeviceNotification')));
	}

	//Update Devices
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

			$bdd->GetUpdate('UPDATE `'. TABLE_ERP_QL_APP_MESURE .'` SET  CODE = \''. addslashes($UpdateCODEAppareil[$i]) .'\',
																LABEL = \''. addslashes($UpdateLABELAppareil[$i]) .'\',
																RESSOURCE_ID = \''. addslashes($UpdateRESSOURCEAppareil[$i]) .'\',
																USER_ID = \''. addslashes($UpdateUSERAppareil[$i]) .'\',
																SERIAL_NUMBER = \''. addslashes($UpdateSERIALAppareil[$i]) .'\',
																DATE = \''. addslashes($UpdateDATEAppareil[$i]) .'\'
																WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateDeviceNotification')));
	}

	////////////////////////
	//// FLAW SECTION    ///
	///////////////////////

	// Create new type flaw
	if(isset($_POST['AddCODEDefaut']) AND !empty($_POST['AddCODEDefaut'])){

		$req = $bdd->GetInsert("INSERT INTO ". TABLE_ERP_DEFAUT ." VALUE ('0',
																		'". addslashes($_POST['AddCODEDefaut']) ."',
																		'". addslashes($_POST['AddLABELDefaut']) ."')");
		$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddFailNotification')));
	}

	//Update Flaw list
	if(isset($_POST['id_Defaut']) AND !empty($_POST['id_Defaut'])){

		$UpdateIdDefaut = $_POST['id_Defaut'];
		$UpdateCODEDefaut = $_POST['UpdateCODEDefaut'];
		$UpdateLABELDefaut = $_POST['UpdateLABELDefaut'];

		$i = 0;
		foreach ($UpdateIdDefaut as $id_generation) {

			$bdd->GetUpdate('UPDATE `'. TABLE_ERP_DEFAUT .'` SET  CODE = \''. addslashes($UpdateCODEDefaut[$i]) .'\',
																LABEL = \''. addslashes($UpdateLABELDefaut[$i]) .'\'
																WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateFailNotification')));
	}

	///////////////////////
	//// Origin  of flaw ////
	//////////////////////

	//Create new origin
	if(isset($_POST['AddCODECauses']) AND !empty($_POST['AddCODECauses'])){

		$req = $bdd->GetInsert("INSERT INTO ". TABLE_ERP_QL_CAUSES ." VALUE ('0',
																		'". addslashes($_POST['AddCODECauses']) ."',
																		'". addslashes($_POST['AddLABELCauses']) ."')");
		$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddCauseNotification')));
	}

	//Update Origin List
	if(isset($_POST['id_Causes']) AND !empty($_POST['id_Causes'])){

		$UpdateIdCauses = $_POST['id_Causes'];
		$UpdateCODECauses = $_POST['UpdateCODECauses'];
		$UpdateLABELCauses = $_POST['UpdateLABELCauses'];

		$i = 0;
		foreach ($UpdateIdCauses as $id_generation) {

			$bdd->GetUpdate('UPDATE `'. TABLE_ERP_QL_CAUSES .'` SET  CODE = \''. addslashes($UpdateCODECauses[$i]) .'\',
																LABEL = \''. addslashes($UpdateLABELCauses[$i]) .'\'
																WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateCauseNotification')));	
	}

	////////////////////////////////
	////  Correction  section ////
	///////////////////////////////

	// Create new correction line
	if(isset($_POST['AddCODECorrection']) AND !empty($_POST['AddCODECorrection'])){

		$req = $bdd->GetInsert("INSERT INTO ". TABLE_ERP_QL_CORRECTIONS ." VALUE ('0',
																		'". addslashes($_POST['AddCODECorrection']) ."',
																		'". addslashes($_POST['AddLABELCorrection'])  ."')");
		$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddCorrectionNotification')));																
	}

	//Uodate correction list
	if(isset($_POST['id_Correction']) AND !empty($_POST['id_Correction'])){

		$UpdateIdCorrection = $_POST['id_Correction'];
		$UpdateCODECorrection = $_POST['UpdateCODECorrection'];
		$UpdateLABELCorrection = $_POST['UpdateLABELCorrection'];

		$i = 0;
		foreach ($UpdateIdCorrection as $id_generation) {

			$bdd->GetUpdate('UPDATE `'. TABLE_ERP_QL_CORRECTIONS .'` SET  CODE = \''. addslashes($UpdateCODECorrection[$i]) .'\',
																LABEL = \''. addslashes($UpdateLABELCorrection[$i]) .'\'
																WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateCorrectionNotification')));	
	}
?>
	<div class="tab">
		<button class="tablinks" onclick="openDiv(event, 'div1')" id="defaultOpen"><?=$langue->show_text('Title1'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div2')"><?=$langue->show_text('Title2'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div3')"><?=$langue->show_text('Title3'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div4')"><?=$langue->show_text('Title4'); ?></button>
	</div>
	<div id="div1" class="tabcontent" >
			<form method="post" name="Section" action="admin.php?page=manage-quality" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th><?=$langue->show_text('TableCODE'); ?></th>
							<th><?=$langue->show_text('TableLabel'); ?></th>
							<th><?=$langue->show_text('TableRessource'); ?></th>
							<th><?=$langue->show_text('TableUser'); ?></th>
							<th><?=$langue->show_text('TableImatNumber'); ?></th>
							<th><?=$langue->show_text('TableEndDate'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
						// Generable Table for device list
						$i = 1;
						foreach ($QL_Devices->GETQL_DevicesList('',false,false) as $data): ?>
						<tr>
							<td><?= $i  ?><input type="hidden" name="id_Appareil[]" id="id_Appareil" value="<?= $data->id ?>"></td>
							<td><input type="text" name="UpdateCODEAppareil[]" value="<?= $data->CODE ?>" size="10"></td>
							<td><input type="text" name="UpdateLABELAppareil[]" value="<?= $data->LABEL ?>" ></td>
							<td>
								<select name="UpdateRESSOURCEAppareil[]">
									<?=$Ressource->GETRessourcesList($data->RESSOURCE_ID) ?>
								</select>
							</td>
							<td>
								<select name="UpdateUSERAppareil[]">
									<option value="<?= $data->USER_ID ?>"><?= $data->NOM_USER ?>- <?= $data->PRENOM_USER ?></option>
									<?=$Employees->GETEmployeesList($data->USER_ID) ?>
								</select>
							</td>
							<td><input type="text" name="UpdateSERIALAppareil[]" value="<?= $data->SERIAL_NUMBER ?>" ></td>
							<td><input type="date" name="UpdateDATEAppareil[]" value="<?= $data->DATE ?>" ></td>
						</tr>		
						<?php $i++; endforeach; ?>
						<tr>
							<td><?= $langue->show_text('Addtext'); ?></td>
							<td><input type="text"  name="AddCODEAppareil"></td>
							<td><input type="text"  name="AddLABELAppareil"></td>
							<td>
								<select name="AddRESSOURCEAppareil">
									<?=$Ressource->GETRessourcesList() ?>
								</select>
							</td>
							<td>
								<select name="AddUSERAppareil">
									<?=$Employees->GETEmployeesList() ?>
								</select>
							</td>
							<td><input type="text"  name="AddIMMATAppareil"></td>
							<td><input type="date"  name="AddDATEAppareil"></td>
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
			<form method="post" name="Section" action="admin.php?page=manage-quality" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th><?=$langue->show_text('TableCODE'); ?></th>
							<th><?=$langue->show_text('TableLabel'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
						// generate table for flaw list
						$i = 1;
						foreach ($QL_Defaut->GETQL_DefautList('',false) as $data): ?>
						<tr>
							<td><?= $i ?> <input type="hidden" name="id_Defaut[]" id="id_Defaut" value="<?= $data->Id ?>"></td>
							<td><input type="text" name="UpdateCODEDefaut[]" value="<?= $data->CODE ?>" size="10"></td>
							<td><input type="text" name="UpdateLABELDefaut[]" value="<?= $data->LABEL ?>" ></td>
						</tr>			
				 		<?php $i++; endforeach; ?>
						<tr>
							<td><?=$langue->show_text('Addtext'); ?></td>
							<td><input type="text"  name="AddCODEDefaut"></td>
							<td><input type="text"  name="AddLABELDefaut" ></td>
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
	<div id="div3" class="tabcontent" >
			<form method="post" name="Section" action="admin.php?page=manage-quality" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th><?=$langue->show_text('TableCODE'); ?></th>
							<th><?=$langue->show_text('TableLabel'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
						//generate origine of flaw list
						$i = 1;
						foreach ($QL_Causes->GETQL_CausesList('',false) as $data): ?>
						<tr>
							<td><?= $i ?> <input type="hidden" name="id_Causes[]" id="id_sector" value="<?= $data->Id ?>"></td>
							<td><input type="text" name="UpdateCODECauses[]" value="<?= $data->CODE ?>" size="10"></td>
							<td><input type="text" name="UpdateLABELCauses[]" value="<?= $data->LABEL ?>" ></td>
						</tr>		
						<?php $i++; endforeach; ?>
						<tr>
							<td><?=$langue->show_text('Addtext'); ?></td>
							<td><input type="text"  name="AddCODECauses"></td>
							<td><input type="text"  name="AddLABELCauses" ></td>
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
	<div id="div4" class="tabcontent" >
			<form method="post" name="Section" action="admin.php?page=manage-quality" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th><?=$langue->show_text('TableCODE'); ?></th>
							<th><?=$langue->show_text('TableLabel'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
						// Generate list of correction
						$i = 1;
						foreach ($QL_Corrections->GETQL_CorrectionsList('',false) as $data): ?>
						<tr>
							<td><?= $i ?> <input type="hidden" name="id_Correction[]" id="id_Correction" value="<?= $data->Id ?>"></td>
							<td><input type="text" name="UpdateCODECorrection[]" value="<?= $data->CODE ?>" size="10"></td>
							<td><input type="text" name="UpdateLABELCorrection[]" value="<?= $data->LABEL ?>" ></td>
						</tr>				
						<?php $i++; endforeach; ?>
						<tr>
							<td><?=$langue->show_text('Addtext'); ?></td>
							<td><input type="text"  name="AddCODECorrection"></td>
							<td><input type="text"  name="AddLABELCorrection" ></td>
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