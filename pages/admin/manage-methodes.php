<?php 
	//phpinfo();
	use \App\Autoloader;
	use \App\Methods\Prestation;
	use \App\Methods\Ressource;
	use \App\Methods\Section;
	use \App\COMPANY\Employees;
	use \App\Companies\Companies;
	use \App\Form;
	use \App\Accounting\Allocations;

	//auto load class
	require_once '../app/Autoload.class.php';
	Autoloader::register();
	
	session_start();
	header( 'content-type: text/html; charset=utf-8' );
	//init form class
	$Form = new Form($_POST);
	$Employees = new Employees();
	$Ressource = new Ressource();
	$Prestation = new Prestation();
	$Section = new Section();
	$Companies = new Companies();
	$Allocations = new Allocations();

	//Check if the user is authorized to view the page
	if($_SESSION['page_10'] != '1'){
		stop($langue->show_text('SystemInfoAccessDenied'), 161, 'index.php?page=login');
	}

	//if add new service
	if(isset($_POST['AddPosteCharge']) AND !empty($_POST['AddPosteCharge'])){

		$req = $bdd->GetInsert("INSERT INTO ". TABLE_ERP_PRESTATION ." VALUE ('0',
																		'". addslashes($_POST['CODEPosteCharge']) ."',
																		'". $_POST['ORDREPosteCharge'] ."',
																		'". addslashes($_POST['AddPosteCharge']) ."',
																		'". $_POST['TYPEPosteCharge'] ."',
																		'". $_POST['TAUXPosteCharge'] ."',
																		'". $_POST['MARGEPosteCharge'] ."',
																		'". $_POST['COLORPosteCharge'] ."',
																		'',
																		'')");
		$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddServiceNotification')));
	}	
	elseif(isset($_POST['AddSection']) AND !empty($_POST['AddSection'])){
		//add new section in db
		$req = $bdd->GetInsert("INSERT INTO ". TABLE_ERP_SECTION ." VALUE ('0',
																		'". $_POST['ORDRESection'] ."',
																		'". addslashes($_POST['CODESection']) ."',
																		'". addslashes($_POST['AddSection']) ."',
																		'". $_POST['TAUXHSection'] ."',
																		'". $_POST['RESPSection'] ."',
																		'". $_POST['COLORSection'] ."')");
		$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddSectionNotification')));
	}
	elseif(isset($_POST['AddRessource']) AND !empty($_POST['AddRessource'])){
		//add new ressource
		$req = $bdd->GetInsert("INSERT INTO ". TABLE_ERP_RESSOURCE ." VALUE ('0',
																		'". addslashes($_POST['CODERessource']) ."',
																		'". addslashes($_POST['AddRessource']) ."',
																		'',
																		'". $_POST['MASKRessource'] ."',
																		'". $_POST['ORDRERessource'] ."',
																		'". $_POST['CAPARessource'] ."',
																		'". $_POST['SECTIONRessource'] ."',
																		'". $_POST['COLORRessource'] ."',
																		'',
																		'')");
		$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddRessourcesnNotification')));	
	}
	elseif(isset($_POST['AddCODEZoneStock']) AND !empty($_POST['AddCODEZoneStock'])){
		//add new stock zone in dd
		$req = $bdd->GetInsert("INSERT INTO ". TABLE_ERP_STOCK_ZONE ." VALUE ('0',
																		'". addslashes($_POST['AddCODEZoneStock']) ."',
																		'". addslashes($_POST['AddLABELZoneStock']) ."',
																		'". $_POST['AddRESSOURCEZoneStock'] ."',
																		'". $_POST['AddCOLORZoneStock'] ."')");
		$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddLocationNotification')));																		
	}

	 
	if(isset($_POST['id_presta']) AND !empty($_POST['id_presta'])){
		//update service list
		$i = 0;
		foreach ($_POST['id_presta'] as $id_generation) {
			$bdd->GetUpdate('UPDATE `'. TABLE_ERP_PRESTATION .'` SET  
																ORDRE = \''. $_POST['ORDREpresta'][$i] .'\',
																TYPE = \''. $_POST['TYPEpresta'][$i] .'\',
																COLOR = \''. $_POST['COLORpresta'][$i] .'\'
																WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateServiceNotification')));
	}
	elseif(isset($_POST['id_section']) AND !empty($_POST['id_section'])){
		//update section list 
		$i = 0;
		foreach ($_POST['id_section'] as $id_generation) {

			$bdd->GetUpdate('UPDATE `'. TABLE_ERP_SECTION .'` SET  ORDRE = \''. $_POST['UpdateORDRESection'][$i] .'\',
																CODE = \''. addslashes($_POST['UpdateCODESection'][$i]) .'\',
																LABEL = \''. addslashes($_POST['UpdateLABELSection'][$i]) .'\',
																COUT_H = \''. $_POST['UpdateTAUX_HSection'][$i] .'\',
																RESPONSABLE = \''. $_POST['UpdateRESPONSABLESection'][$i] .'\',
																COLOR = \''. $_POST['UpdateCOLORSection'][$i] .'\'
																WHERE id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateSectionNotification')));
	}
	elseif(isset($_POST['id_ZoneStock']) AND !empty($_POST['id_ZoneStock'])){
		//update list stock zone
		$i = 0;
		foreach ($_POST['id_ZoneStock'] as $id_generation) {

			$bdd->GetUpdate('UPDATE `'. TABLE_ERP_STOCK_ZONE .'` SET CODE = \''. addslashes($_POST['UpdateCODEZoneStock'][$i]) .'\',
																LABEL = \''. addslashes($_POST['UpdateLABELZoneStock'][$i]) .'\',
																RESSOURCE_ID = \''. $_POST['UpdateRESSOURCEIDZoneStock'][$i] .'\',
																COLOR = \''.$_POST['UpdateCOLORZoneStock'][$i] .'\'
																WHERE id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateLocationNotification')));
	}

	//if user want display prestation detail
	if(isset($_GET['prestation']) && !empty($_GET['prestation'])){
		
		//if update data from prestation
		if(isset($_POST['id']) && !empty($_POST['id'])){
			$bdd->GetUpdatePOST(TABLE_ERP_PRESTATION, $_POST, 'WHERE id IN ('. $_POST['id'] . ')');
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateServiceNotification')));
		}

		//if update data from provider list
		if(isset($_POST['PROVIDER_ID']) && !empty($_POST['PROVIDER_ID'])){
			foreach($_POST['PROVIDER_ID'] as $POST => $Value){
				$PROVIDER_ID .= $Value .',';
			}
			$UpdatePROVIDER_ID = array('PROVIDER_ID' => substr($PROVIDER_ID, 0, -1));
			$bdd->GetUpdatePOST(TABLE_ERP_PRESTATION, $UpdatePROVIDER_ID, 'WHERE id IN ('. $_GET['prestation'] . ')');
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateServiceNotification')));
		}

		//if add new allocation accouting
		if(isset($_POST['PRESTATION_ID']) && !empty($_POST['ORDRE'])){
			$bdd->GetInsertPOST(TABLE_ERP_IMPUT_COMPTA_PRESTATION, $_POST);
			$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddAccountingNotification')));
		}	

		if(isset($_GET['delete']) && !empty($_GET['delete'])){
			$bdd->GetDelete("DELETE FROM ". TABLE_ERP_IMPUT_COMPTA_PRESTATION ." WHERE id='". addslashes($_GET['delete'])."'");
			$CallOutBox->add_notification(array('4', $i . $langue->show_text('DeleteAccountingNotification')));
		}

		//init new data
		$Prestation = New Prestation();
		$Data= $Prestation->GETPrestation($_GET['prestation']);
	?>
	<div class="tab">
		<button class="tablinks" onclick="window.location.href = 'http://localhost/erp/public/admin.php?page=manage-methodes';"><?=$langue->show_text('TitrePresta1'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div1')" id="defaultOpen"><?=$langue->show_text('TitrePresta2'); ?> - <?= $Data->LABEL?> </button>
		<button class="tablinks" onclick="openDiv(event, 'div2')"><?=$langue->show_text('TitrePresta3'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div3')"><?=$langue->show_text('TitrePresta4'); ?></button>
	</div>
	<div id="div1" class="tabcontent">
		<form method="post" name="prestation" action="admin.php?page=manage-methodes&prestation=<?= $_GET['prestation'] ?>" class="content-form" enctype="multipart/form-data">
			<table class="content-table">
				<thead>
					<tr>
						<td colspan="3" ><?= $Data->LABEL?> - <?= $Data->CODE?> </td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<input type="hidden" name="id" id="id" value="<?= $Data->id ?>">
							<?=$langue->show_text('TableOrder'); ?> <?= $Data->ORDRE ?>
						</td>
						<td><?=$langue->show_text('TableCODE'); ?> <?= $Data->CODE ?></td>
						<td><?=$langue->show_text('TablePicture'); ?></td>
					</tr>
					<tr>
						<td><?=$langue->show_text('TableLabel'); ?></td>
						<td><input type="text" name="LABEL" value="<?= $Data->LABEL ?>" ></td>
						<td rowspan="3"><img Class="Image-small" src="<?= $data->IMAGE ?>" title="Image <?= $data->LABEL ?>" alt="Prestation Image" /></td>
					</tr>
					<tr>
						<td><?=$langue->show_text('TableType'); ?></td>
						<td>
							<select name="TYPE">
								<option value="1" <?= selected($Data->TYPE, 1) ?>><?=$langue->show_text('SelectProductive'); ?></option>
								<option value="2" <?= selected($Data->TYPE, 2) ?>><?=$langue->show_text('SelectRawMat'); ?></option>
								<option value="3" <?= selected($Data->TYPE, 3) ?>><?=$langue->show_text('SelectRawMatSheet'); ?></option>
								<option value="4" <?= selected($Data->TYPE, 4) ?>><?=$langue->show_text('SelectRawMatProfil'); ?></option>
								<option value="5" <?= selected($Data->TYPE, 5) ?>><?=$langue->show_text('SelectRawMatBlock'); ?></option>
								<option value="6" <?= selected($Data->TYPE, 6) ?>><?=$langue->show_text('SelectSupplies'); ?></option>
								<option value="7" <?= selected($Data->TYPE, 7) ?>><?=$langue->show_text('SelectSubcontracting'); ?></option>
								<option value="8" <?= selected($Data->TYPE, 8) ?>><?=$langue->show_text('SelectCompoundItem'); ?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td><?=$langue->show_text('TableHourlyRate'); ?><input type="number" name="TAUX_H" value="<?= $Data->TAUX_H ?>" id="number"></td>
						<td><?=$langue->show_text('TableMargin'); ?><input type="number" name="MARGE" value="<?= $Data->MARGE ?>" id="number"></td>
					</tr>
					<tr>
						<td><?=$langue->show_text('TableColor'); ?></td>
						<td><input type="color" name="COLOR" value="<?= $Data->COLOR ?>"></td>
						<td><input type="file" name="IMAGE" /></td>
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
	<div id="div2" class="tabcontent">
		<form method="post" name="prestation" action="admin.php?page=manage-methodes&prestation=<?= $_GET['prestation'] ?>" class="content-form" >
			<table class="content-table">
				<thead>
					<tr>
						<td><?= $Data->LABEL?> - <?= $Data->CODE?> </td>
					</tr>
				</thead>
				<tbody>
					<?= $Companies->GetProviderCheckedList($Data->PROVIDER_ID) ?>
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
		<form method="post" name="prestation" action="admin.php?page=manage-methodes&prestation=<?= $_GET['prestation'] ?>" class="content-form">
			<table class="content-table">
				<thead>
					<tr>
						<td colspan="5" ><?= $Data->LABEL?> - <?= $Data->CODE?> </td>
					</tr>
					<tr>
							<th></th>
							<th><?=$langue->show_text('TableOrder'); ?></th>
							<th><?=$langue->show_text('TableImputationType'); ?></th>
							<th><?=$langue->show_text('TableTVAType'); ?></th>
							<th></th>
						</tr>
					</thead>
						<?php
						$query='SELECT '. TABLE_ERP_IMPUT_COMPTA_PRESTATION .'.Id,
										'. TABLE_ERP_IMPUT_COMPTA_PRESTATION .'.ORDRE,
										'. TABLE_ERP_IMPUT_COMPTA_PRESTATION .'.IMPUTATION_ID,
										'. TABLE_ERP_IMPUT_COMPTA .'.CODE AS CODE_IMPUTATION,
										'. TABLE_ERP_IMPUT_COMPTA .'.LABEL AS LABEL_IMPUTATION,
										'. TABLE_ERP_IMPUT_COMPTA .'.TYPE_IMPUTATION,
										'. TABLE_ERP_TVA .'.LABEL AS LABEL_TVA
									FROM `'. TABLE_ERP_IMPUT_COMPTA_PRESTATION .'`
										LEFT JOIN `'. TABLE_ERP_IMPUT_COMPTA .'` ON `'. TABLE_ERP_IMPUT_COMPTA_PRESTATION .'`.`IMPUTATION_ID` = `'. TABLE_ERP_IMPUT_COMPTA .'`.`ID`
										LEFT JOIN `'. TABLE_ERP_TVA .'` ON `'. TABLE_ERP_IMPUT_COMPTA .'`.`TVA` = `'. TABLE_ERP_TVA .'`.`ID`
									WHERE '. TABLE_ERP_IMPUT_COMPTA_PRESTATION .'.PRESTATION_ID = '. $Data->id .'
										ORDER BY '. TABLE_ERP_IMPUT_COMPTA_PRESTATION .'.ORDRE';
		
						$i = 1;
						foreach ($bdd->GetQuery($query) as $data):
						if($data->TYPE_IMPUTATION == 1) $TypeImputation = $langue->show_text('TableSelect1');
						if($data->TYPE_IMPUTATION == 2) $TypeImputation = $langue->show_text('TableSelect2');
						if($data->TYPE_IMPUTATION == 3) $TypeImputation = $langue->show_text('TableSelect3');
						if($data->TYPE_IMPUTATION == 4) $TypeImputation = $langue->show_text('TableSelect4');
						if($data->TYPE_IMPUTATION == 5) $TypeImputation = $langue->show_text('TableSelect5');
						if($data->TYPE_IMPUTATION == 6) $TypeImputation = $langue->show_text('TableSelect6');?>
		
							<tr>
								<td><a href="admin.php?page=manage-methodes&prestation=<?=$_GET['prestation'] ?>&delete=<?= $data->Id ?>">X</a></td>
								<td><?= $data->ORDRE ?></td>
								<td> <?= $data->CODE_IMPUTATION ?> - <?= $data->LABEL_IMPUTATION ?></td>
								<td><?= $data->LABEL_TVA ?></td>
								<td><?= $TypeImputation ?></td>
							</tr>
							<?php $i++; endforeach; ?>
							<tr>
								<td>
									<?=$langue->show_text('Addtext'); ?>
									<input type="hidden" name="PRESTATION_ID" value="<?=$_GET['prestation'] ?>">
								</td>
								<td><input type="number" name="ORDRE" ></td>
								<td>
									<select name="IMPUTATION_ID">
										<?= $Allocations->GETAllocationsList() ?>
									</select>
								</td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td colspan="5" >
									<?= $Form->submit($langue->show_text('TableUpdateButton')) ?> <br/>
								</td>
							</tr>
				</tbody>
			</table>
		</form>
	</div>	
	<?php

	}
	elseif(isset($_GET['resources']) && !empty($_GET['resources'])){

		if(isset($_POST['id']) && !empty($_POST['id'])){
			$bdd->GetUpdatePOST(TABLE_ERP_RESSOURCE, $_POST, 'WHERE id IN ('. $_POST['id'] . ')');
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdatRessourcesnNotification')));
		}

		//if update data from provider list
		if(isset($_POST['PRESTATION_ID']) && !empty($_POST['PRESTATION_ID'])){
			foreach($_POST['PRESTATION_ID'] as $POST => $Value){
				$PRESTATION_ID .= $Value .',';
			}
			$UpdatePRESTATION_ID = array('PRESTATION_ID' => substr($PRESTATION_ID, 0, -1));
			$bdd->GetUpdatePOST(TABLE_ERP_RESSOURCE, $UpdatePRESTATION_ID, 'WHERE id IN ('. $_GET['resources'] . ')');
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdatRessourcesnNotification')));
		}

		//if update data from comment
		if(isset($_POST['COMMENT']) && !empty($_POST['COMMENT'])){
			$bdd->GetUpdatePOST(TABLE_ERP_RESSOURCE, $_POST, 'WHERE id IN ('. $_GET['resources'] . ')');
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdatRessourcesnNotification')));
		}

		//init new data
		$Resources = New Ressource();
		$Data= $Resources->GETRessource($_GET['resources']);
	?>
	<div class="tab">
		<button class="tablinks" onclick="window.location.href = 'http://localhost/erp/public/admin.php?page=manage-methodes';"><?=$langue->show_text('TitreRessource1'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div1')" id="defaultOpen"><?=$langue->show_text('TitreRessource2');  ?> - <?= $Data->LABEL?></button>
		<button class="tablinks" onclick="openDiv(event, 'div2')"><?=$langue->show_text('TitreRessource3'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div3')"><?=$langue->show_text('TitreRessource4'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div4')"><?=$langue->show_text('TitreRessource5'); ?></button>
	</div>
	<div id="div1" class="tabcontent">
		<form method="post" name="prestation" action="admin.php?page=manage-methodes&resources=<?= $_GET['resources'] ?>" class="content-form" enctype="multipart/form-data">
			<table class="content-table">
				<thead>
					<tr>
						<td colspan="3" ><?= $Data->LABEL?> - <?= $Data->CODE?> </td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<input type="hidden" name="id" id="id" value="<?= $Data->id ?>">
							<?=$langue->show_text('TableOrder'); ?> <?= $Data->ORDRE ?>
						</td>
						<td><?=$langue->show_text('TableCODE'); ?> <?= $Data->CODE ?></td>
						<td><?=$langue->show_text('TablePicture'); ?></td>
					</tr>
					<tr>
						<td><?=$langue->show_text('TableLabel'); ?></td>
						<td><input type="text" name="LABEL" value="<?= $Data->LABEL ?>" ></td>
						<td rowspan="3"><img Class="Image-small" src="<?= $Data->IMAGE ?>" title="Image <?= $Data->LABEL ?>" alt="Ressource Image" /></td>
					</tr>
					<tr>
						<td><?=$langue->show_text('TableSection'); ?></td>
						<td>
							<select name="SECTION_ID">
								<?=  $Section->GetSectionList($Data->SECTION_ID) ?>
							</select>
						</td>
					</tr>
					<tr>
						<td><?=$langue->show_text('TableColor'); ?><input type="color" name="COLOR" value="<?= $Data->COLOR ?>"></td>
						<td><?=$langue->show_text('TableCapacity'); ?><input type="number" name="CAPACITY" value="<?= $Data->CAPACITY ?>" id="number"></td>
					</tr>
					<tr>
						<td colspan="2" ><?=$langue->show_text('TableMasktime'); ?>
							<select name="MASK_TIME">
								<option value="1" <?=  selected($data->MASK_TIME, 1) ?>><?=$langue->show_text('No'); ?></option>
								<option value="0" <?=  selected($data->MASK_TIME, 0) ?>><?=$langue->show_text('Yes'); ?></option>
							</select>
						</td>
						<td><input type="file" name="IMAGE" /></td>
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
	<div id="div2" class="tabcontent">
		<form method="post" name="prestation" action="admin.php?page=manage-methodes&resources=<?= $_GET['resources'] ?>" class="content-form" enctype="multipart/form-data">
			<table class="content-table">
				<thead>
					<tr>
						<td><?= $Data->LABEL?> - <?= $Data->CODE?> </td>
					</tr>
				</thead>
				<tbody>
					<?= $Prestation->GetPrestationCheckedList($Data->PRESTATION_ID) ?>
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
		<form method="post" name="prestation" action="admin.php?page=manage-methodes&resources=<?= $_GET['resources'] ?>" class="content-form" enctype="multipart/form-data">
			<table class="content-table">
				<thead>
					<tr>
						<td colspan="3" ><?= $Data->LABEL?> - <?= $Data->CODE?> </td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
						
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
	<div id="div4" class="tabcontent">
		<form method="post" name="prestation" action="admin.php?page=manage-methodes&resources=<?= $_GET['resources'] ?>" class="content-form" enctype="multipart/form-data">
			<table class="content-table"  style="width: 50%;">
				<thead>
					<tr>
						<td ><?= $Data->LABEL?> - <?= $Data->CODE?> </td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<textarea class="Comment" name="COMMENT" rows="40" ><?= $Data->COMMENT ?></textarea>
						</td>
					</tr>
					<tr>
						<td >
							<br/>
							<?= $Form->submit($langue->show_text('TableUpdateButton')) ?> <br/>
							<br/>
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>

	<?php
	}
	else{
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
						</tr>
					</thead>
					<tbody>
						<?php
						// PRESTA
						$i = 1;
						foreach ($Prestation->GetPrestationList('',false) as $data): ?>
						<tr>
							<td>
								<input type="hidden" name="id_presta[]" id="id_presta" value="<?= $data->Id ?>">
							</td>
							<td><input type="number" name="ORDREpresta[]" value="<?= $data->ORDRE ?>" id="number"></td>
							<td><?= $data->CODE ?></td>
							<td><a href="admin.php?page=manage-methodes&prestation=<?= $data->Id ?>"><?= $data->LABEL ?></a></td>
							<td>
								<select name="TYPEpresta[]">
									<option value="1" <?= selected($data->TYPE, 1) ?>><?=$langue->show_text('SelectProductive'); ?></option>
									<option value="2" <?= selected($data->TYPE, 2) ?>><?=$langue->show_text('SelectRawMat'); ?></option>
									<option value="3" <?= selected($data->TYPE, 3) ?>><?=$langue->show_text('SelectRawMatSheet'); ?></option>
									<option value="4" <?= selected($data->TYPE, 4) ?>><?=$langue->show_text('SelectRawMatProfil'); ?></option>
									<option value="5" <?= selected($data->TYPE, 5) ?>><?=$langue->show_text('SelectRawMatBlock'); ?></option>
									<option value="6" <?= selected($data->TYPE, 6) ?>><?=$langue->show_text('SelectSupplies'); ?></option>
									<option value="7" <?= selected($data->TYPE, 7) ?>><?=$langue->show_text('SelectSubcontracting'); ?></option>
									<option value="8" <?= selected($data->TYPE, 8) ?>><?=$langue->show_text('SelectCompoundItem'); ?></option>
								</select>
								</td>
							<td><?= $data->TAUX_H ?></td>
							<td><?= $data->MARGE ?></td>
							<td><input type="color" name="COLORpresta[]" value="<?= $data->COLOR ?>"></td>
						</tr>
						<?php $i++; endforeach; ?>
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
						</tr>
						<tr>
							<td colspan="10" >
								<br/>
								<?= $Form->submit($langue->show_text('TableUpdateButton')) ?> <br/>
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
							<th><?=$langue->show_text('TableOrder'); ?></th>
							<th><?=$langue->show_text('TableCODE'); ?></th>
							<th><?=$langue->show_text('TableLabel'); ?></th>
							<th><?=$langue->show_text('TableMasktime'); ?></th>
							<th><?=$langue->show_text('TableCapacity'); ?></th>
							<th><?=$langue->show_text('TableSection'); ?></th>
							<th><?=$langue->show_text('TableColor'); ?></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php
						// RESSOURCES
						$i = 1;
						foreach ($Ressource->GETRessourcesList('',false) as $data): ?>
						<tr>
							<td><input type="hidden" name="id_ressource[]" id="id_presta" value="<?=  $data->Id ?>"></td>
							<td><input type="number" name="UpdateCODEressource[]" value="<?=  $data->ORDRE ?>" id="number"></td>
							<td><?=  $data->CODE ?></td>
							<td><a href="admin.php?page=manage-methodes&resources=<?= $data->Id ?>"><?=  $data->LABEL ?></a></td>
							<td>
								<select name="UpdateMASKressource[]">
									<option value="1" <?=  selected($data->MASK_TIME, 1) ?>><?=$langue->show_text('No'); ?></option>
									<option value="0" <?=  selected($data->MASK_TIME, 0) ?>><?=$langue->show_text('Yes'); ?></option>
								</select>
							</td>
							<td><?=  $data->CAPACITY ?></td>
							<td>
								<select name="UpdateSECTIONIDressource[]">
									<?=  $Section->GetSectionList($data->SECTION_ID) ?>
								</select>
							</td>
							<td><input type="color" name="UpdateCOLORressource[]" value="<?=  $data->COLOR ?>" size="10"></td>
							<td></td>
						</tr>
						<?php $i++; endforeach; ?>
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
									<?=$Section->GetSectionList() ?>
								</select>
							</td>
							<td><input type="color"  name="COLORRessource" size="1"></td>
							<td></td>
						</tr>
						<tr>
							<td colspan="10" >
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
						//------------------------------
						// SECTION
						//------------------------------
						$i = 1;
						$query='SELECT '. TABLE_ERP_SECTION .'.Id,
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
								ORDER BY '. TABLE_ERP_SECTION .'.ORDRE';

						$i = 1;
						foreach ($bdd->GetQuery($query) as $data): ?>
						<tr>
							<td><?= $i ?><input type="hidden" name="id_section[]" id="id_section" value="<?= $data->Id  ?>"></td>
							<td><input type="text" name="UpdateCODESection[]" value="<?= $data->CODE  ?>" ></td>
							<td><input type="number" name="UpdateORDRESection[]" value="<?= $data->ORDRE ?>" id="number"></td>
							<td><input type="text" name="UpdateLABELSection[]" value="<?= $data->LABEL  ?>" ></td>
							<td><input type="number" name="UpdateTAUX_HSection[]" value="<?= $data->COUT_H  ?>" id="number"></td>
							<td>
								<select name="UpdateRESPONSABLESection[]">
									<option value="<?= $data->idUSER  ?>"><?= $data->NOM  ?> <?= $data->PRENOM  ?> - <?= $data->RIGHT_NAME  ?></option>
									<?=$Employees->GETEmployeesList() ?>
								</select>
							</td>
							<td><input type="color" name="UpdateCOLORSection[]" value="<?= $data->COLOR  ?>" size="10"></td>
						</tr>	
						<?php $i++; endforeach; ?>
						<tr>
							<td><?=$langue->show_text('Addtext'); ?></td>
							<td><input type="text"  name="CODESection" size="10"></td>
							<td><input type="number"  name="ORDRESection" id="number"></td>
							<td><input type="text"  name="AddSection" size="20"></td>
							<td><input type="number"  name="TAUXHSection" size="1" id="number"></td>
							<td>
								<select name="RESPSection">
									<?=$Employees->GETEmployeesList() ?>
								</select>
							</td>
							<td><input type="color"  name="COLORSection" ></td>
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
						//------------------------------
						// ZONE OF STOCK
						//------------------------------
						$i = 1;
						$query='SELECT '. TABLE_ERP_STOCK_ZONE .'.Id,
										'. TABLE_ERP_STOCK_ZONE .'.CODE,
										'. TABLE_ERP_STOCK_ZONE .'.LABEL,
										'. TABLE_ERP_STOCK_ZONE .'.RESSOURCE_ID,
										'. TABLE_ERP_STOCK_ZONE .'.COLOR,
										'. TABLE_ERP_RESSOURCE .'.LABEL AS LABEL_RESSOURCE
									FROM `'. TABLE_ERP_STOCK_ZONE .'`
										LEFT JOIN `'. TABLE_ERP_RESSOURCE .'` ON `'. TABLE_ERP_STOCK_ZONE .'`.`RESSOURCE_ID` = `'. TABLE_ERP_RESSOURCE .'`.`id`
									ORDER BY '.TABLE_ERP_RESSOURCE .'.id ';

						$i = 1;
						foreach ($bdd->GetQuery($query) as $data): ?>
						<tr>
							<td><?= $i ?><input type="hidden" name="id_ZoneStock[]" id="id_ZoneStock" value="<?= $data->Id ?>"></td>
							<td><input type="text" name="UpdateCODEZoneStock[]" value="<?= $data->CODE ?>" id="number"></td>
							<td><input type="text" name="UpdateLABELZoneStock[]" value="<?= $data->LABEL ?>" </td>
							<td>
								<select name="UpdateRESSOURCEIDZoneStock[]">
									<option value="<?= $data->RESSOURCE_ID ?>"><?= $data->LABEL_RESSOURCE ?></option>
									<?= $Ressource->GETRessourcesList() ?>
								</select>
							</td>
							<td><input type="color" name="UpdateCOLORZoneStock[]" value="<?= $data->COLOR ?>" size="10"></td>
						</tr>
						<?php $i++; endforeach; ?>
						<tr>
							<td><?=$langue->show_text('Addtext'); ?></td>
							<td><input type="text"  name="AddCODEZoneStock"></td>
							<td><input type="text"  name="AddLABELZoneStock" ></td>
							<td>
								<select name="AddRESSOURCEZoneStock">
									<?=$Ressource->GETRessourcesList() ?>
								</select>
							</td>
							<td><input type="color"  name="AddCOLORZoneStock"></td>
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
<?php 
}