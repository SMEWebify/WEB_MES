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

	//------------------------------
	// SERVICE
	//------------------------------

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

		$i = 0;
		foreach ($UpdateIdPresta as $id_generation) {
			$bdd->GetUpdate('UPDATE `'. TABLE_ERP_PRESTATION .'` SET  CODE = \''. addslashes($UpdateCODEpresta[$i]) .'\',
																ORDRE = \''. $UpdateORDREpresta[$i] .'\',
																LABEL = \''. addslashes($UpdateLABELpresta[$i]) .'\',
																TYPE = \''. $UpdateTYPEpresta[$i] .'\',
																TAUX_H = \''. $UpdateTAUX_Hpresta[$i] .'\',
																MARGE = \''. $UpdateMARGEpresta[$i] .'\',
																COLOR = \''. $UpdateCOLORpresta[$i] .'\',
																WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateServiceNotification')));
	}

	//------------------------------
	// SECTION
	//------------------------------

	//add new section in db
	if(isset($_POST['AddSection']) AND !empty($_POST['AddSection'])){
		$req = $bdd->GetInsert("INSERT INTO ". TABLE_ERP_SECTION ." VALUE ('0',
																		'". $_POST['ORDRESection'] ."',
																		'". addslashes($_POST['CODESection']) ."',
																		'". addslashes($_POST['AddSection']) ."',
																		'". $_POST['TAUXHSection'] ."',
																		'". $_POST['RESPSection'] ."',
																		'". $_POST['COLORSection'] ."')");
		$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddSectionNotification')));
	}

	//update section list 
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

			$bdd->GetUpdate('UPDATE `'. TABLE_ERP_SECTION .'` SET  ORDRE = \''. $UpdateORDRESection[$i] .'\',
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

	//------------------------------
	// RESSOURCES
	//------------------------------

	//add new ressource 
	if(isset($_POST['AddRessource']) AND !empty($_POST['AddRessource'])){

		$req = $bdd->GetInsert("INSERT INTO ". TABLE_ERP_RESSOURCE ." VALUE ('0',
																		'". addslashes($_POST['CODERessource']) ."',
																		'". addslashes($_POST['AddRessource']) ."',
																		'',
																		'". $_POST['MASKRessource'] ."',
																		'". $_POST['ORDRERessource'] ."',
																		'". $_POST['CAPARessource'] ."',
																		'". $_POST['SECTIONRessource'] ."',
																		'". $_POST['COLORRessource'] ."')");
		$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddRessourcesnNotification')));	
	}


	//------------------------------
	// ZONE OF STOCK
	//------------------------------

	//add new stock zone in dd
	if(isset($_POST['AddCODEZoneStock']) AND !empty($_POST['AddCODEZoneStock'])){

		$req = $bdd->GetInsert("INSERT INTO ". TABLE_ERP_STOCK_ZONE ." VALUE ('0',
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

			$bdd->GetUpdate('UPDATE `'. TABLE_ERP_STOCK_ZONE .'` SET CODE = \''. addslashes($UpdateCODEZoneStock[$i]) .'\',
																LABEL = \''. addslashes($UpdateLABELZoneStock[$i]) .'\',
																RESSOURCE_ID = \''. $UpdateRESSOURCEIDZoneStock[$i] .'\',
																COLOR = \''. $UpdateCOLORZoneStock[$i] .'\'
																WHERE id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateLocationNotification')));
	}

	// Create selected value list
	$query='SELECT '. TABLE_ERP_EMPLOYEES .'.idUSER,
			'. TABLE_ERP_EMPLOYEES .'.NOM,
			'. TABLE_ERP_EMPLOYEES .'.PRENOM,
			'. TABLE_ERP_RIGHTS .'.RIGHT_NAME
		FROM `'. TABLE_ERP_EMPLOYEES .'`
		LEFT JOIN `'. TABLE_ERP_RIGHTS .'` ON `'. TABLE_ERP_EMPLOYEES .'`.`FONCTION` = `'. TABLE_ERP_RIGHTS .'`.`id`';
	foreach ($bdd->GetQuery($query) as $data){
	$EmployeeListe .=  '<option value="'. $dat->idUSER .'">'. $dat->NOM .' '. $dat->PRENOM .' - '. $dat->RIGHT_NAME .'</option>';
	}

	$RessourcesListe ='<option value="0">Aucune</option>';
	$query='SELECT Id, LABEL   FROM '. TABLE_ERP_RESSOURCE .'';
	foreach ($bdd->GetQuery($query) as $data){
		$RessourcesListe .='<option value="'. $dat->Id .'">'. $data->LABEL .'</option>';
	}

	if(isset($_GET['prestation']) && !empty($_GET['prestation'])){
?>
	<div class="tab">
		<button class="tablinks" onclick="window.location.href = 'http://localhost/erp/public/admin.php?page=manage-methodes';"><?=$langue->show_text('TitrePresta1'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div1')" id="defaultOpen"><?=$langue->show_text('TitrePresta2'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div2')"><?=$langue->show_text('TitrePresta3'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div3')"><?=$langue->show_text('TitrePresta4'); ?></button>
	</div>
	<div id="div1" class="tabcontent">
		<form method="post" name="prestation" action="admin.php?page=manage-methodes?prestation=<?= $_GET['prestation'] ?> class="content-form" enctype="multipart/form-data">
			<table class="content-table">
				<thead>
					<tr>
						<td></td>
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
	<div id="div2" class="tabcontent">
		<form method="post" name="prestation" action="admin.php?page=manage-methodes?prestation=<?= $_GET['prestation'] ?> class="content-form" >
			<table class="content-table">
				<thead>
					<tr>
						<td></td>
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
	<div id="div3" class="tabcontent">
		<form method="post" name="prestation" action="admin.php?page=manage-methodes?prestation=<?= $_GET['prestation'] ?> class="content-form">
			<table class="content-table">
				<thead>
					<tr>
						<td></td>
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
<?php

	}
	elseif(isset($_GET['resources']) && !empty($_GET['resources'])){
?>
	<div class="tab">
		<button class="tablinks" onclick="window.location.href = 'http://localhost/erp/public/admin.php?page=manage-methodes';"><?=$langue->show_text('TitreRessource1'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div1')" id="defaultOpen"><?=$langue->show_text('TitreRessource2');  ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div2')"><?=$langue->show_text('TitreRessource3'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div3')"><?=$langue->show_text('TitreRessource4'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div4')"><?=$langue->show_text('TitreRessource5'); ?></button>
	</div>
	<div id="div1" class="tabcontent">
		<form method="post" name="prestation" action="admin.php?page=manage-methodes?resources=<?= $_GET['resources'] ?> class="content-form" enctype="multipart/form-data">
			<table class="content-table">
				<thead>
					<tr>
						<td></td>
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
	<div id="div2" class="tabcontent">
		<form method="post" name="prestation" action="admin.php?page=manage-methodes?resources=<?= $_GET['resources'] ?> class="content-form" enctype="multipart/form-data">
			<table class="content-table">
				<thead>
					<tr>
						<td></td>
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
	<div id="div3" class="tabcontent">
		<form method="post" name="prestation" action="admin.php?page=manage-methodes?resources=<?= $_GET['resources'] ?> class="content-form" enctype="multipart/form-data">
			<table class="content-table">
				<thead>
					<tr>
						<td></td>
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
		<form method="post" name="prestation" action="admin.php?page=manage-methodes?resources=<?= $_GET['resources'] ?> class="content-form" enctype="multipart/form-data">
			<table class="content-table">
				<thead>
					<tr>
						<td></td>
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
							<th><?=$langue->show_text('TablePicture'); ?></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php
						//------------------------------
						// PRESTA
						//------------------------------

						$query='SELECT '. TABLE_ERP_PRESTATION .'.Id,
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
									ORDER BY ORDRE';

						$i = 1;
						foreach ($bdd->GetQuery($query) as $data): ?>
						<tr>
							<td>
								<input type="hidden" name="id_presta[]" id="id_presta" value="<?= $data->Id ?>">
								<a href="admin.php?page=manage-methodes&prestation=<?= $data->Id ?>">-></a>
							</td>
							<td><input type="number" name="ORDREpresta[]" value="<?= $data->ORDRE ?>" id="number"></td>
							<td><input type="text" name="CODEpresta[]" value="<?= $data->CODE ?>" ></td>
							<td><input type="text" name="LABELpresta[]" value="<?= $data->LABEL ?>" ></td>
							<td>
								<select name="TYPEpresta[]">
									<option value="1" <?= selected($data->TYPE, 1) ?>><?=$langue->show_text('SelectProductive'); ?></option>
									<option value="2" <?= selected($data->TYPE, 2) ?>><?=$langue->show_text('SelectRawMat'); ?></option>
									<option value="3" <?= selected($data->TYPE, 3) ?>><?=$langue->show_text('SelectRawMatSheet'); ?></option>
									<option value="4" <?= selected($data->TYPE, 4) ?>><?=$langue->show_text('SelectRawMatProfil'); ?></option>
									<option value="5" <?= selected($data->TYPE, 5) ?>><?=$langue->show_text('SelectRawMatBlock'); ?></option>
									<option value="6" <?= selected($data->TYPE, 6) ?>><?=$langue->show_text('SelectSupplies'); ?><</option>
									<option value="7" <?= selected($data->TYPE, 7) ?>><?=$langue->show_text('SelectSubcontracting'); ?></option>
									<option value="8" <?= selected($data->TYPE, 8) ?>><?=$langue->show_text('SelectCompoundItem'); ?></option>
								</select>
								</td>
							<td><input type="number" name="TAUX_Hpresta[]" value="<?= $data->TAUX_H ?>" id="number"></td>
							<td><input type="number" name="MARGEpresta[]" value="<?= $data->MARGE ?>" id="number"></td>
							<td><input type="color" name="COLORpresta[]" value="<?= $data->COLOR ?>"></td>
							<td><img Class="Image-small" src="<?= $data->IMAGE ?>" title="Image <?= $data->LABEL ?>" alt="Prestation Image" /></td>
							<td></td>
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
							<td></td>
							<td><input type="file" name="IMAGEPosteCharge" /></td>
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
						//------------------------------
						// RESSOURCES
						//------------------------------

						$query='SELECT Id, LABEL   FROM '. TABLE_ERP_SECTION .'';
						foreach ($bdd->GetQuery($query) as $data){
							$SectionListe .='<option value="'. $data->Id .'">'. $data->LABEL .'</option>';
						}

						$query='SELECT '. TABLE_ERP_RESSOURCE .'.Id,
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
						ORDER BY ORDRE';

						$i = 1;
						foreach ($bdd->GetQuery($query) as $data): ?>
						<tr>
							<td>
								<input type="hidden" name="id_ressource[]" id="id_presta" value="<?=  $data->Id ?>">
								<a href="admin.php?page=manage-methodes&resources=<?= $data->Id ?>">-></a>
							</td>
							<td><input type="text" name="UpdateORDREressource[]" value="<?=  $data->CODE ?>" ></td>
							<td><input type="number" name="UpdateCODEressource[]" value="<?=  $data->ORDRE ?>" id="number"></td>
							<td><input type="text" name="UpdateLABELressource[]" value="<?=  $data->LABEL ?>" ></td>
							<td>
								<select name="UpdateMASKressource[]">
									<option value="1" <?=  selected($data->MASK_TIME, 1) ?>><?=$langue->show_text('No'); ?></option>
									<option value="0" <?=  selected($data->MASK_TIME, 0) ?>><?=$langue->show_text('Yes'); ?></option>
								</select>
							</td>
							<td><input type="number" name="UpdateCAPACITYressource[]" value="<?=  $data->CAPACITY ?>" id="number"></td>
							<td>
								<select name="UpdateSECTIONIDressource[]">
									<option value="<?=  $data->SECTION_ID ?>"><?=  $data->LABEL_SECTOR ?></option>
									<?=  $SectionListe ?>
								</select>
							</td>
							<td><input type="color" name="UpdateCOLORressource[]" value="<?=  $data->COLOR ?>" size="10"></td>
							<td><img Class="Image-small" src="<?=  $data->IMAGE ?>" title="Image <?=  $data->LABEL ?>" alt="Ressource Image" /></td>
							<td><input type="file" name="UpdateIMAGEPosteCharge[]" /></td>
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
									<?=$EmployeeListe ?>
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
									<?=$EmployeeListe ?>
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
									<?= $RessourcesListe ?>
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
									<?=$RessourcesListe ?>
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