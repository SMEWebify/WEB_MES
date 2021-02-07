<?php
	//phpinfo();
	use \App\Autoloader;
	use \App\Form;
	use \App\Accounting\Allocations;
	use \App\Accounting\PaymentMethod;
	use \App\Accounting\PaymentCondition;
	use \App\Accounting\Delevery;
	use \App\Accounting\VAT;
	use \App\Accounting\PaymentSchedule;
	use \App\Accounting\PaymentScheduleLine;

	//auto load class
	require_once '../app/Autoload.class.php';
	Autoloader::register();
	
	session_start();
	header( 'content-type: text/html; charset=utf-8' );
	//init form class
	$Form = new Form($_POST);
	$Allocations = new Allocations();
	$PaymentMethod = new PaymentMethod();
	$PaymentCondition = new PaymentCondition();
	$Delevery = new Delevery();
	$VAT = new VAT();
	$PaymentSchedule = new PaymentSchedule();
	$PaymentScheduleLine = new PaymentScheduleLine();

	//Check if the user is authorized to view the page
	if($_SESSION['page_10'] != '1'){
		stop($langue->show_text('SystemInfoAccessDenied'), 161, 'index.php?page=login');
	}

	if(isset($_POST['AddCODECondiReg']) AND !empty($_POST['AddCODECondiReg'])){
		//Insert in db new payement condition
		$PaymentCondition->NewPaymentCondition($_POST['AddCODECondiReg'],$_POST['AddLABELCondiReg'],$_POST['AddNbrMoisCondiReg'],$_POST['AddNbrJoursCondiReg'],$_POST['AddFinDeMoiCondiReg']);
		$CallOutBox->add_notification(array('2', $langue->show_text('AddCondiNotification')));	
	}
	elseif(isset($_POST['AddCODEModeRef']) AND !empty($_POST['AddCODEModeRef'])){
		//if add new payment mode
		$PaymentMethod->NewPaymentMethod($_POST['AddCODEModeRef'], $_POST['AddLABELModeRef'], $_POST['AddCODEComptaModeRef']);
		$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddModeNotification')));
	}
	elseif(isset($_POST['AddCODETVA']) AND !empty($_POST['AddCODETVA'])){
		//if add new VAT type
		$VAT->NewVAT($_POST['AddCODETVA'], $_POST['AddLABELTVA'], $_POST['AddTAUXTVA']);
		$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddTVANotification')));
	}	
	elseif(isset($_POST['AddCODEIMPUT']) AND !empty($_POST['AddCODEIMPUT'])){
		//if Add new Accouting entry
		$Allocation->NewAllocations($_POST['AddCODEIMPUT'], $_POST['AddLABELIMPUT'] ,$_POST['AddTVAIMPUT'] ,$_POST['AddCOMPTETVAIMPUT'] , $_POST['AddCODECOMPTAIMPUT'], $_POST['AddTYPEIMPUT']);
		$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddAccountingNotification')));
	}
	elseif(isset($_POST['AddCODEEcheancier']) AND !empty($_POST['AddCODEEcheancier'])){
		//if add new Payment Schedule
		$PaymentSchedule->NewPaymentSchedule($_POST['AddCODEEcheancier'],$_POST['AddLABELEcheancier']);
		$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddTimeLinePayementNotification')));
	}
	elseif(isset($_POST['AddLABELLigneEcheancier']) AND !empty($_POST['AddLABELLigneEcheancier'])){
		//if add new ligne of timeline
		$PaymentScheduleLine->NewPaymentScheduleLine($_GET['Echeancier'], $_POST['AddLABELLigneEcheancier'], $_POST['AddPourcMontantLigneEcheancier'], $_POST['AddPourcTVALigneEcheancier'], $_POST['AddRegLigneEcheancier'],$_POST['AddModeLigneEcheancier'], $_POST['AddDelaisLigneEcheancier']);
		$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddLineTimeLinePayementNotification')));
	}
	elseif(isset($_POST['AddCODETransport']) AND !empty($_POST['AddCODETransport'])){
		//if add new delevery method
		$Delevery->NewDelevery($_POST['AddCODETransport'], $_POST['AddLABELTransport']);
		$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddDeleveryTypeNotification')));
	}

	
	if(isset($_POST['id_CondiReg']) AND !empty($_POST['id_CondiReg'])){
		//if update list condition payement
		$i = 0;
		foreach ($_POST['id_CondiReg'] as $id_generation) {
			$bdd->GetUpdate('UPDATE '. TABLE_ERP_CONDI_REG .' SET  CODE = \''. addslashes($_POST['CODE'][$i]) .'\',
																LABEL = \''. addslashes($_POST['LABEL'][$i]) .'\',
																NBR_MOIS = \''. addslashes($_POST['NBR_MOIS'][$i]) .'\',
																NBR_JOURS = \''. addslashes($_POST['NBR_JOURS'][$i]) .'\',
																FIN_MOIS = \''. addslashes($_POST['FIN_MOIS'][$i]) .'\'
																WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateCondiNotification')));
	}
	elseif(isset($_POST['id_ModeReg']) AND !empty($_POST['id_ModeReg'])){
	//Update mode payement list
		$i = 0;
		foreach ($_POST['id_ModeReg'] as $id_generation) {
			$bdd->exec('UPDATE '. TABLE_ERP_MODE_REG .' SET  CODE = \''. addslashes($_POST['CODE'][$i]) .'\',
																LABEL = \''. addslashes($_POST['LABEL'][$i]) .'\',
																CODE_COMPTABLE = \''. addslashes($_POST['CODE_COMPTABLE'][$i]) .'\'
																WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateModeNotification')));
	}
	elseif(isset($_POST['id_TVA']) AND !empty($_POST['id_TVA'])){
	//update VAT List
		$i = 0;
		foreach ($_POST['id_TVA'] as $id_generation) {
			$bdd->GetUpdate('UPDATE `'. TABLE_ERP_TVA .'` SET  CODE = \''. addslashes($_POST['CODE'][$i]) .'\',
																LABEL = \''. addslashes($_POST['LABEL'][$i]) .'\',
																TAUX = \''. addslashes($_POST['TAUX'][$i]) .'\'
																WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateTVANotification')));
	}
	elseif(isset($_POST['id_IMPUT']) AND !empty($_POST['id_IMPUT'])){
		//update list of entry accouting
		$i = 0;
		foreach ($_POST['id_IMPUT'] as $id_generation) {
			$bdd->GetUpdate('UPDATE `'. TABLE_ERP_IMPUT_COMPTA .'` SET  CODE = \''. addslashes($_POST['CODE'][$i]) .'\',
																	LABEL = \''. addslashes($_POST['LABEL'][$i]) .'\',
																	TVA = \''. addslashes($_POST['TVA'][$i]) .'\',
																	COMPTE_TVA = \''. addslashes($_POST['COMPTE_TVA'][$i]) .'\',
																	CODE_COMPTA = \''. addslashes($_POST['CODE_COMPTA'][$i]) .'\',
																	TYPE_IMPUTATION = \''. addslashes($_POST['TYPE_IMPUTATION'][$i]) .'\'
																	WHERE id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateAccountingNotification')));
	}
	elseif(isset($_POST['UpdateIdTransport']) AND !empty($_POST['UpdateIdTransport'])){
	//udpdate list of delevery method
		$i = 0;
		foreach ($_POST['UpdateIdTransport'] as $id_generation) {
			$bdd->GetUpdate('UPDATE `'. TABLE_ERP_TRANSPORT .'` SET  CODE = \''. addslashes($_POST['CODE'][$i]) .'\',
																LABEL = \''. addslashes($_POST['LABEL'][$i]) .'\'
																WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateDeleveryNotification')));
	}
	elseif(isset($_POST['UpdateIdEcheancier']) AND !empty($_POST['UpdateIdEcheancier'])){
		//update TimeLine payement list
		$i = 0;
		foreach ($_POST['UpdateIdEcheancier'] as $id_generation) {
			$bdd->GetUpdate('UPDATE `'. TABLE_ERP_ECHEANCIER_TYPE .'` SET  CODE = \''. addslashes($_POST['CODE'][$i]) .'\',
																			LABEL = \''. addslashes($_POST['LABEL'][$i]) .'\'
																			WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateTimeLinePayementNotification')));
	}
	elseif(isset($_POST['UpdateIdLigneEcheancier']) AND !empty($_POST['UpdateIdLigneEcheancier'])){
		//update timeline détail list	
		$i = 0;
		foreach ($_POST['UpdateIdLigneEcheancier'] as $id_generation) {	
			$bdd->GetUpdate('UPDATE `'. TABLE_ERP_ECHEANCIER_TYPE_LIGNE .'` SET  LABEL = \''. addslashes($_POST['LABEL'][$i]) .'\',
																			POURC_MONTANT = \''. addslashes($_POST['POURC_MONTANT'][$i]) .'\',
																			POURC_TVA = \''. addslashes($_POST['POURC_TVA'][$i]) .'\',
																			CONDI_REG_ID = \''. addslashes($_POST['CONDI_REG_ID'][$i]) .'\',
																			MODE_REG_ID = \''. addslashes($_POST['MODE_REG_ID'][$i]) .'\',
																			DELAI = \''. addslashes($_POST['DELAI'][$i]) .'\'
																			WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateLineTimeLinePayementNotification')));
	}
	
	//if user want show timeline detail
	if(isset($_GET['Echeancier']) AND !empty($_GET['Echeancier'])){
		//we change default view on this section
		$ParDefautDiv5 = 'id="defaultOpen"';
	}else{
		$ParDefautDiv1 = 'id="defaultOpen"';
	}
?>
	<div class="tab">
		<button class="tablinks" onclick="openDiv(event, 'div1')" <?=$ParDefautDiv1; ?>><?=$langue->show_text('Title1'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div2')"><?=$langue->show_text('Title2'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div3')"><?=$langue->show_text('Title3'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div4')"><?=$langue->show_text('Title4'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div5')" <?=$ParDefautDiv5; ?> ><?=$langue->show_text('Title5'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div6')" ><?=$langue->show_text('Title6'); ?></button>
	</div>
	<div id="div1" class="tabcontent" >
			<form method="post" name="Section" action="admin.php?page=manage-accounting" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th><?=$langue->show_text('TableCODE'); ?></th>
							<th><?=$langue->show_text('TableLabel'); ?></th>
							<th><?=$langue->show_text('TableNumberOfMonth'); ?></th>
							<th><?=$langue->show_text('TableNumberOfDay'); ?></th>
							<th><?=$langue->show_text('TableEndMonth'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
							//generate condition payement liste
							$i = 1;
							foreach ($PaymentCondition->GETPaymentConditionList('', false) as $data): ?>
						<tr>
							<td><?= $i ?> <input type="hidden" name="id_CondiReg[]" id="id_CondiReg" value="<?= $data->id ?>"></td>
							<td><input type="text" name="CODE[]" value="<?= $data->CODE ?>" required="required"></td>
							<td><input type="text" name="LABEL[]" value="<?= $data->LABEL ?>" required="required"></td>
							<td><input type="number" name="NBR_MOIS[]" value="<?= $data->NBR_MOIS ?>" required="required"></td>
							<td><input type="number" name="NBR_JOURS[]" value="<?= $data->NBR_JOURS ?>" required="required"></td>
							<td>
								<select name="FIN_MOIS[]">
									<option value="1" <?= selected($data->FIN_MOIS, "1") ?>><?= $langue->show_text('Yes') ?></option>
									<option value="0" <?= selected($data->FIN_MOIS, "0") ?>><?= $langue->show_text('No') ?></option>
								</select>
							</td>
						</tr>
						<?php $i++; endforeach; ?>
						<tr>
							<td><?= $langue->show_text('Addtext'); ?></td>
							<td><input type="text" class="input-moyen-vide" name="AddCODECondiReg" ></td>
							<td><input type="text" class="input-moyen-vide" name="AddLABELCondiReg" ></td>
							<td><input type="number" class="input-moyen-vide" name="AddNbrMoisCondiReg" ></td>
							<td><input type="number" class="input-moyen-vide" name="AddNbrJoursCondiReg" ></td>
							<td>
								<select name="AddFinDeMoiCondiReg">
									<option value="1"><?=$langue->show_text('Yes'); ?></option>
									<option value="0"><?=$langue->show_text('No'); ?></option>
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
	<div id="div2" class="tabcontent" >
			<form method="post" name="Section" action="admin.php?page=manage-accounting" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th><?=$langue->show_text('TableCODE'); ?></th>
							<th><?=$langue->show_text('TableLabel'); ?></th>
							<th><?=$langue->show_text('TableAcountCODE'); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php
						//generate liste of payement mode
						$i = 1;
						foreach ($PaymentMethod->GETPaymentMethodList('', false) as $data): ?>
						<tr>
							<td><?= $i ?> <input type="hidden" name="id_ModeReg[]" id="id_ModeReg" value="<?= $data->id ?>"></td>
							<td><input type="text" name="CODE[]" value="<?= $data->CODE ?>" required="required"></td>
							<td><input type="text" name="LABEL[]" value="<?= $data->LABEL ?>" required="required"></td>
							<td><input type="text" name="CODE_COMPTABLE[]" value="<?= $data->CODE_COMPTABLE ?>" required="required"></td>
						</tr>
						<?php $i++; endforeach; ?>
						<tr>
							<td><?=$langue->show_text('Addtext'); ?></td>
							<td><input type="text" class="input-moyen-vide" name="AddCODEModeRef" ></td>
							<td><input type="text" class="input-moyen-vide" name="AddLABELModeRef" ></td>
							<td><input type="text" class="input-moyen-vide" name="AddCODEComptaModeRef" ></td>
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
	<div id="div3" class="tabcontent">
			<form method="post" name="Section" action="admin.php?page=manage-accounting" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th><?=$langue->show_text('TableCODE'); ?></th>
							<th><?=$langue->show_text('TableLabel'); ?></th>
							<th><?=$langue->show_text('TableRate'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
						//Generate TVA list
						$i = 1;
						foreach ($VAT->GETVATList('',False) as $data): ?>
						<tr>
							<td><?= $i ?> <input type="hidden" name="id_TVA[]" id="id_TVA" value="<?= $data->Id ?>"></td>
							<td><input type="text" name="CODE[]" value="<?= $data->CODE ?>" required="required"></td>
							<td><input type="text" name="LABEL[]" value="<?= $data->LABEL ?>" required="required"></td>
							<td><input type="text" name="TAUX[]" value="<?= $data->TAUX ?>" required="required"></td>
						</tr>
						<?php $i++; endforeach; ?>
						<tr>
							<td><?=$langue->show_text('Addtext'); ?></td>
							<td><input type="text" class="input-moyen-vide" name="AddCODETVA" ></td>
							<td><input type="text" class="input-moyen-vide" name="AddLABELTVA" ></td>
							<td><input type="number" class="input-moyen-vide" name="AddTAUXTVA" step=".001"></td>
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
	<div id="div4" class="tabcontent" >
			<form method="post" name="Section" action="admin.php?page=manage-accounting" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th><?=$langue->show_text('TableCODE'); ?></th>
							<th><?=$langue->show_text('TableLabel'); ?></th>
							<th><?=$langue->show_text('TableTVAType'); ?></th>
							<th><?=$langue->show_text('TableAccountTVA'); ?></th>
							<th><?=$langue->show_text('TableAcountCODE'); ?></th>
							<th><?=$langue->show_text('TableImputationType'); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php
						//gererate list of entry accouting
						$i = 1;
						foreach ($Allocations->GETAllocationsList('', false) as $data): ?>
						<tr>
							<td><?= $i ?> <input type="hidden" name="id_IMPUT[]" id="id_IMPUT" value="<?= $data->id ?>"></td>
							<td><input type="text" name="CODE[]" value="<?= $data->CODE ?>" required="required"></td>
							<td><input type="text" name="LABEL[]" value="<?= $data->LABEL ?>" required="required"></td>
							<td>
								<select name="TVA[]">
									<?= $VAT->GETVATList($data->TVA) ?>
								</select>
							</td>
							<td><input type="text" name="COMPTE_TVA[]" value="<?= $data->COMPTE_TVA ?>" required="required"></td>
							<td><input type="text" name="CODE_COMPTA[]" value="<?= $data->CODE_COMPTA ?>" required="required"></td>
							<td>
								<select name="TYPE_IMPUTATION[]">
									<option value="1" <?= selected($data->TYPE_IMPUTATION, 1) ?>><?= $langue->show_text('TableSelect1') ?></option>
									<option value="2" <?= selected($data->TYPE_IMPUTATION, 2) ?>><?= $langue->show_text('TableSelect2') ?></option>
									<option value="3" <?= selected($data->TYPE_IMPUTATION, 3) ?>><?= $langue->show_text('TableSelect3') ?></option>
									<option value="4" <?= selected($data->TYPE_IMPUTATION, 4) ?>><?= $langue->show_text('TableSelect4') ?></option>
									<option value="5" <?= selected($data->TYPE_IMPUTATION, 5) ?>><?= $langue->show_text('TableSelect5') ?></option>
									<option value="6" <?= selected($data->TYPE_IMPUTATION, 6) ?>><?= $langue->show_text('TableSelect6') ?></option>
								</select>
							</td>
						</tr>
						<?php $i++; endforeach; ?>
						<tr>
							<td><?=$langue->show_text('Addtext'); ?></td>
							<td><input type="text" class="input-moyen-vide" name="AddCODEIMPUT" ></td>
							<td><input type="text" class="input-moyen-vide" name="AddLABELIMPUT"></td>
							<td>
								<select name="AddTVAIMPUT">
									<?= $VAT->GETVATList('') ?>
								</select>
							</td>
							<td><input type="number" class="input-moyen-vide" name="AddCOMPTETVAIMPUT" ></td>
							<td><input type="number" class="input-moyen-vide" name="AddCODECOMPTAIMPUT" ></td>
							<td>
								<select name="AddTYPEIMPUT">
									<option value="1"><?=$langue->show_text('TableSelect1'); ?></option>
									<option value="2"><?=$langue->show_text('TableSelect2'); ?></option>
									<option value="3"><?=$langue->show_text('TableSelect3'); ?></option>
									<option value="4"><?=$langue->show_text('TableSelect4'); ?></option>
									<option value="5"><?=$langue->show_text('TableSelect5'); ?></option>
									<option value="6"><?=$langue->show_text('TableSelect6'); ?></option>
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
	<div id="div5" class="tabcontent" >
			<form method="post" name="Section" action="admin.php?page=manage-accounting" class="content-form" >
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
						$i = 1;
						foreach ($PaymentSchedule->GETPaymentScheduleList('', false) as $data): ?>
						<tr>
							<td><input type="hidden" name="UpdateIdEcheancier[]" id="UpdateIdEcheancier" value="<?= $data->id ?>"></td>
							<td><input type="text" name="CODE[]" value="<?= $data->CODE ?>" required="required"></td>
							<td><input type="text" name="LABEL[]" value="<?= $data->LABEL ?>" required="required"></td>
							<td><a href="admin.php?page=manage-accounting&Echeancier=<?= $data->id ?>">--></a></td>
						</tr>
						<?php $i++; endforeach; ?>
						<tr>
							<td><?=$langue->show_text('Addtext'); ?></td>
							<td><input type="text" class="input-moyen-vide" name="AddCODEEcheancier"></td>
							<td><input type="text" class="input-moyen-vide" name="AddLABELEcheancier"></td>
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
			if(isset($_GET['Echeancier']) AND !empty($_GET['Echeancier'])){
				//generate liste of detail timeline payement
			?>
			<form method="post" name="Section" action="admin.php?page=manage-accounting&Echeancier=<?= $_GET['Echeancier'] ?>" class="content-form" >
				<table class="content-table-decal">
					<thead>
						<tr>
							<th></th>
							<th><?= $langue->show_text('TableLabel') ?></th>
							<th><?= $langue->show_text('TableAmountHT') ?></th>
							<th><?= $langue->show_text('TableAmountTVA') ?></th>
							<th><?= $langue->show_text('TableCondiList') ?></th>
							<th><?= $langue->show_text('TableMethodList') ?></th>
							<th><?= $langue->show_text('TableDayDelay') ?></th>
						</tr>
					</thead>
					<tbody>
					<?php
					//generate list of détail TimeLine payement

						$i = 1;
						foreach ($PaymentScheduleLine->GETPaymentScheduleLineList($_GET['Echeancier'],false) as $data){		
						?>
						<tr>
							<td><input type="hidden" name="UpdateIdLigneEcheancier[]" id="UpdateIdLigneEcheancier" value="<?= $data->id ?>" required="required"></td>
							<td><input type="text"  name="LABEL[]" value="<?= $data->LABEL ?>" required="required"></td>
							<td><input type="number" name="POURC_MONTANT[]" value="<?= $data->POURC_MONTANT ?>" step=".001" required="required"></td>
							<td><input type="number"  name="POURC_TVA[]" value="<?= $data->POURC_TVA ?>" step=".001" required="required"></td>
							<td>
								<select name="CONDI_REG_ID[]">
									<?=$PaymentCondition->GETPaymentConditionList($data->CONDI_REG_ID)?>
								</select>
							</td>
							<td>
								<select name="MODE_REG_ID[]">
									<?=$PaymentMethod->GETPaymentMethodList($data->MODE_REG_ID); ?>
								</select>
							</td>
							<td><input type="number" class="input-moyen-vide" name="DELAI[]" value="<?= $data->DELAI ?>" required="required"></td>
						</tr>
						<?php $CondiListe1 = '';$RegListe1 = '';  $i++; 
							}  ?>
						<tr>
							<td><?= $langue->show_text('Addtext') ?></td>
							<td><input type="text" class="input-moyen-vide" name="AddLABELLigneEcheancier" ></td>
							<td><input type="number" class="input-moyen-vide" name="AddPourcMontantLigneEcheancier" step=".001" ></td>
							<td><input type="number" class="input-moyen-vide" name="AddPourcTVALigneEcheancier" step=".001" ></td>
							<td>
								<select name="AddRegLigneEcheancier">
									<?=$PaymentCondition->GETPaymentConditionList()?>
								</select>
							</td>
							<td>
								<select name="AddModeLigneEcheancier">
									<?=$PaymentMethod->GETPaymentMethodList(); ?>
								</select>
							</td>
							<td><input type="number"  name="AddDelaisLigneEcheancier" ></td>
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
		<?php
			}
		?>
	</div>
	<div id="div6" class="tabcontent" >
		<form method="post" name="Section" action="admin.php?page=manage-accounting" class="content-form" >
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
						//generate list of delevery
						$i = 1;
						foreach ($Delevery->GETDeleveryList('', false) as $data): ?>
						<tr>
							<td><input type="hidden" name="UpdateIdTransport[]" id="UpdateIdTransport" value="<?= $data->id ?>" ></td>
							<td><input type="text" name="CODE[]" value="<?= $data->CODE ?>" required="required"></td>
							<td><input type="text" name="LABEL[]" value="<?= $data->LABEL ?>" required="required"></td>
						</tr>
						<?php $i++; endforeach; ?>
						<tr>
							<td><?= $langue->show_text('Addtext'); ?></td>
							<td><input type="text" class="input-moyen-vide" name="AddCODETransport"></td>
							<td><input type="text" class="input-moyen-vide" name="AddLABELTransport"></td>
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