<?php 
	//phpinfo();
	use \App\Autoloader;
	use App\COMPANY\Employees;
	use \App\UI\Form;
	use \App\Methods\Section;

	//auto load class
	require_once '../app/Autoload.class.php';
	Autoloader::register();

	session_start();
	header( 'content-type: text/html; charset=utf-8' );
	//init form class
	$Form = new Form($_POST);
	$Section = new Section();
	$Employees= new Employees();

	//Check if the user is authorized to view the page
	if($_SESSION['page_10'] != '1'){
		stop($langue->show_text('SystemInfoAccessDenied'), 161, 'index.php?page=login');
	}

	// if add new employe
	if(isset($_POST['Addnom_ajout']) AND !empty($_POST['Addnom_ajout'])){

		$req = $bdd->GetInsert("INSERT INTO ". TABLE_ERP_EMPLOYEES ." VALUE ('0',
																		'". $_POST['Addcode_ajout'] ."',
																		'". $_POST['Addnom_ajout'] ."',
																		'". $_POST['Addprenom_ajout'] ."',
																		NOW(),
																		'',
																		'',
																		'',
																		'',
																		'1',
																		'". time() ."',
																		'". $_POST['Addname_ajout'] ."',
																		'',
																		'". $_POST['Addposte_ajout'] ."',
																		'". $_POST['Addsection_ajout'] ."',
																		'1')");	

		$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddUserNotification')));														
	}
	elseif(isset($_POST['AddRight']) AND !empty($_POST['AddRight'])){
		//If add Right
		$req = $bdd->GetInsert("INSERT INTO ". TABLE_ERP_RIGHTS ." VALUE ('0',
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

		$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddRightNotification')));	
	}

	//Update data employees
	if(isset($_POST['id_membre']) AND !empty($_POST['id_membre'])){

		$i = 0;
		foreach ($_POST['id_membre'] as $id_generation) {

			$bdd->GetUpdate('UPDATE `'. TABLE_ERP_EMPLOYEES .'` SET  CODE = \''. $_POST['CODE'][$i] .'\',
																NOM = \''. addslashes($_POST['NOM'][$i]) .'\',
																PRENOM = \''. addslashes($_POST['PRENOM'][$i]) .'\',
																NAME = \''. addslashes($_POST['NAME'][$i]) .'\',
																FONCTION = \''. $_POST['FONCTION'][$i] .'\',
																SECTION_ID = \''. $_POST['SECTION_ID'][$i] .'\'
																WHERE idUser = '. $id_generation . ' ');
			$i++;
		}

		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateUserNotification')));
	}
	elseif(isset($_POST['id_Right']) AND !empty($_POST['id_Right'])){
		//Update data right
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

			$bdd->GetUpdate('UPDATE `'. TABLE_ERP_RIGHTS .'` SET  RIGHT_NAME = \''. addslashes($UpdateNameRight[$i]) .'\',
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
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateRightNotification')));
	}

	//Right list for employees
	$query='SELECT Id, RIGHT_NAME   FROM '. TABLE_ERP_RIGHTS .'';
	foreach ($bdd->GetQuery($query) as $data){
		$RightListe .='<option value="'. $data->Id .'">'.  $data->RIGHT_NAME .'</option>';
	}

?>
	<div class="tab">
		<button class="tablinks" onclick="openDiv(event, 'div1')" id="defaultOpen"><?=$langue->show_text('Title1'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div2')"><?=$langue->show_text('Title2'); ?></button>
	</div>
		<div id="div1" class="tabcontent" >
			<form method="post" name="Employees" action="index.php?page=manage-users" class="content-form">
				<table class="content-table" >
					<thead>
						<tr>
							<th><?=$langue->show_text('TableNumber'); ?></th>
							<th><?=$langue->show_text('TableLastConnexion'); ?></th>
							<th><?=$langue->show_text('TableCODE'); ?></th>
							<th><?=$langue->show_text('TableSeudo'); ?></th>
							<th><?=$langue->show_text('TableSeudo'); ?></th>
							<th><?=$langue->show_text('TableSeudo'); ?></th>
							<th><?=$langue->show_text('TableRight'); ?></th>
							<th><?=$langue->show_text('TableSection'); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php 
					$i = 1;
					foreach ($Employees->GETEmployeesList($SteRESP_COM_ID , false) as $data): ?>
						<tr>
							<td><?= $i .''. $Form->input('hidden', 'id_membre[]',  $data->id) ?></td>
							<td><?= format_temps($data->CONNEXION) ?></td>
							<td><?= $Form->input('text', 'CODE[]',  $data->CODE) ?></td>
							<td><?= $Form->input('text', 'NAME[]',  $data->NAME) ?></td>
							<td><?= $Form->input('text', 'NOM[]',  $data->NOM) ?></td>
							<td><?= $Form->input('text', 'PRENOM[]',  $data->PRENOM) ?></td>
							<td>
								<select name="FONCTION[]">
									<option value="<?= $data->FONCTION ?>"><?= $data->RIGHT_NAME ?></option>
									<?=  $RightListe ?>
								</select>
							</td>
							<td>
								<select name="SECTION_ID[]">
									<?=  $Section->GetSectionList($data->SECTION_ID) ?>
								</select>
							</td>
						</tr>
						<?php $i++; endforeach; ?>
						<tr>
							<td><?=$langue->show_text('Addtext'); ?></td>
							<td></td>
							<td><?= $Form->input('text', 'Addcode_ajout', ''); ?></td>
							<td><?= $Form->input('text', 'Addname_ajout', ''); ?></td>
							<td><?= $Form->input('text', 'Addnom_ajout', ''); ?></td>
							<td><?= $Form->input('text', 'Addprenom_ajout', ''); ?></td>
							<td>
								<select name="Addposte_ajout">
									<?=$RightListe ?>
								</select>
							</td>
							<td>
								<select name="Addsection_ajout">
									<?=  $Section->GetSectionList() ?>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="8" >
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
			<form method="post" name="Right" action="index.php?page=manage-users" class="content-form">
				<table class="content-table" >
					<thead>
						<tr>
							<th></th>
							<th><?=$langue->show_text('TableRightName'); ?></th>
							<th><?=$langue->show_text('TableIndex'); ?></th>
							<th><?=$langue->show_text('TableQuoteStudy'); ?></th>
							<th><?=$langue->show_text('TableOrder'); ?></th>
							<th><?=$langue->show_text('TablePlanning'); ?></th>
							<th><?=$langue->show_text('TableCompanies'); ?></th>
							<th><?=$langue->show_text('TablePurchase'); ?></th>
							<th><?=$langue->show_text('TableArticle'); ?></th>
							<th><?=$langue->show_text('TableQuality'); ?></th>
							<th><?=$langue->show_text('TableGeneralSetting'); ?></th>
							<th><?=$langue->show_text('TableAcounting'); ?></th>
						</tr>
					</thead>
					<tbody>
				<?php
				//generate right list
				$query='SELECT Id, RIGHT_NAME, page_1, page_2, page_3, page_4, page_5, page_6, page_7, page_8, page_9, page_10   FROM '. TABLE_ERP_RIGHTS .'';
				$i = 1;
				foreach ($bdd->GetQuery($query) as $data): ?>
				<tr>
					<td><?= $i ?> <?= $Form->input('hidden', 'id_Right[]',  $data->Id) ?></td>
					<td><?= $Form->input('text', 'RIGHT_NAME[]',  $data->RIGHT_NAME) ?></td>
					<td>
						<select name="page_1_membre[]">
							<option value="1" <?= selected($data->page_1, "1") ?>><?= $langue->show_text('Yes') ?></option>
							<option value="0" <?= selected($data->page_1, "0") ?>><?= $langue->show_text('No') ?></option>
						</select>
					</td>
					<td>
						<select name="page_2_membre[]">
							<option value="1" <?= selected($data->page_2, "1") ?>><?= $langue->show_text('Yes') ?></option>
							<option value="0" <?= selected($data->page_2, "0") ?>><?= $langue->show_text('No') ?></option>
						</select>
					</td>
					<td>
						<select name="page_3_membre[]">
							<option value="1" <?= selected($data->page_3, "1") ?>><?= $langue->show_text('Yes') ?></option>
							<option value="0" <?= selected($data->page_3, "0") ?>><?= $langue->show_text('No') ?></option>
						</select>
					</td>
					<td>
						<select name="page_4_membre[]">
							<option value="1" <?= selected($data->page_4, "1") ?>><?= $langue->show_text('Yes') ?></option>
							<option value="0" <?= selected($data->page_4, "0") ?>><?= $langue->show_text('No') ?></option>
						</select>
					</td>
					<td>
						<select name="page_5_membre[]">
							<option value="1" <?= selected($data->page_5, "1") ?>><?= $langue->show_text('Yes') ?></option>
							<option value="0" <?= selected($data->page_5, "0") ?>><?= $langue->show_text('No') ?></option>
						</select>
					</td>
					<td>
						<select name="page_6_membre[]">
							<option value="1" <?= selected($data->page_6, "1") ?>><?= $langue->show_text('Yes') ?></option>
							<option value="0" <?= selected($data->page_6, "0") ?>><?= $langue->show_text('No') ?></option>
						</select>
					</td>
					<td>
						<select name="page_7_membre[]">
							<option value="1" <?= selected($data->page_7, "1") ?>><?= $langue->show_text('Yes') ?></option>
							<option value="0" <?= selected($data->page_7, "0") ?>><?= $langue->show_text('No') ?></option>
						</select>
					</td>
					<td>
						<select name="page_8_membre[]">
							<option value="1" <?= selected($data->page_8, "1") ?>><?= $langue->show_text('Yes') ?></option>
							<option value="0" <?= selected($data->page_8, "0") ?>><?= $langue->show_text('No') ?></option>
						</select>
					</td>
					<td>
						<select name="page_9_membre[]">
							<option value="1" <?= selected($data->page_9, "1") ?>><?= $langue->show_text('Yes') ?></option>
							<option value="0" <?= selected($data->page_9, "0") ?>><?= $langue->show_text('No') ?></option>
						</select>
					</td>
					<td>
						<select name="page_10_membre[]">
							<option value="1" <?=selected($data->page_10, "1") ?>><?= $langue->show_text('Yes') ?></option>
							<option value="0" <?= selected($data->page_10, "0") ?>><?= $langue->show_text('No') ?></option>
						</select>
					</td>
				</tr>
				<?php $i++; endforeach; ?>
						<tr>
							<td><?=$langue->show_text('Addtext'); ?></td>
							<td><input type="text" class="input-moyen-vide" name="AddRight" size="1"></td>
							<td>
								<select name="Addpage_1_ajout">
								<option value="1">"<?=$langue->show_text('Yes'); ?></option>
									<option value="0"><?=$langue->show_text('No'); ?></option>
								</select>
							</td>
							<td>
								<select name="Addpage_2_ajout">
								<option value="1">"<?=$langue->show_text('Yes'); ?></option>
									<option value="0"><?=$langue->show_text('No'); ?></option>
								</select>
							</td>
							<td>
								<select name="Addpage_3_ajout">
									<option value="1">"<?=$langue->show_text('Yes'); ?></option>
									<option value="0"><?=$langue->show_text('No'); ?></option>
								</select>
							</td>
							<td>
								<select name="Addpage_4_ajout">
									<option value="1">"<?=$langue->show_text('Yes'); ?></option>
									<option value="0"><?=$langue->show_text('No'); ?></option>
								</select>
							</td>
							<td>
								<select name="Addpage_5_ajout">
									<option value="1">"<?=$langue->show_text('Yes'); ?></option>
									<option value="0"><?=$langue->show_text('No'); ?></option>
								</select>
							</td>
							<td>
								<select name="Addpage_6_ajout">
									<option value="1">"<?=$langue->show_text('Yes'); ?></option>
									<option value="0"><?=$langue->show_text('No'); ?></option>
								</select>
							</td>
							<td>
								<select name="Addpage_7_ajout">
								<option value="1">"<?=$langue->show_text('Yes'); ?></option>
									<option value="0"><?=$langue->show_text('No'); ?></option>
								</select>
							</td>
							<td>
								<select name="Addpage_8_ajout">
								<option value="1">"<?=$langue->show_text('Yes'); ?></option>
									<option value="0"><?=$langue->show_text('No'); ?></option>
								</select>
							</td>
							<td>
								<select name="Addpage_9_ajout">
								<option value="1">"<?=$langue->show_text('Yes'); ?></option>
									<option value="0"><?=$langue->show_text('No'); ?></option>
								</select>
							</td>
							<td>
								<select name="Addpage_10_ajout">
									<option value="1">"<?=$langue->show_text('Yes'); ?></option>
									<option value="0"><?=$langue->show_text('No'); ?></option>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="12" >
								<br/>
								<?= $Form->submit($langue->show_text('TableUpdateButton')) ?> <br/>
								<br/>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
	</div>