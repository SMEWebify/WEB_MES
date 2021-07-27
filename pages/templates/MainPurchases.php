	<!-- Start Document General information -->
	<div id="div1" class="tabcontent">
		<div class="row">
			<div class="column">
				<form method="post" name="Coment" action="<?=$actionForm; ?>" class="content-form" >
					<table class="content-table">
							<thead>
								<tr>
									<th colspan="5">
									<?= $langue->show_text('TableNumberQuote')  ?> <?= $Maindata->CODE  ?> <?= $langue->show_text('TableIndexQuote')  ?>  <?= $Maindata->INDICE  ?>
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?= $langue->show_text('TableCodeLabel')  ?></td>
									<td><?= $Maindata->CODE ?><?= $Form->input('hidden', 'CODE', $Maindata->CODE, '', true) ?></td>
									<td><?= $Form->input('text', 'LABEL', $Maindata->LABEL, $langue->show_text('TableLabelplaceholder'), true) ?></td>
								</tr>
								<tr>
									<td><?= $langue->show_text('TableIndexLabel')  ?></td>
									<td><?= $Maindata->INDICE  ?></td>
									<td><?= $Form->input('text', 'LABEL_INDICE', $Maindata->LABEL_INDICE, $langue->show_text('TableLabelIndexplaceholder'), true) ?></td>
								</tr>
								<tr>
									<td><?= $langue->show_text('TableCreationDate')  ?></td>
									<td  colspan="2"><?= $Maindata->DATE ?></td>
								</tr>
								<?php if(isset($_GET['quote'])): ?>
								<tr>
									<td><?= $langue->show_text('TableValidityDate')  ?></td>
									<td colspan="2"><?= $Form->input('date', 'DATE_VALIDITE', $Maindata->DATE_VALIDITE,'', $ActivateForm) ?></td>
								</tr>
								<?php endif ?>
								<tr>
									<td><?= $langue->show_text('TableStatu') ?></td>
									<td>
										<select name="ETAT">
											<?php if(isset($_GET['PurchaseRequest'])): ?>
											<option value="1" <?= selected($Maindata->ETAT, 1) ?>><?= $langue->show_text('SelectOpen') ?></option>
											<option value="2" <?= selected($Maindata->ETAT, 2) ?>><?= $langue->show_text('SelectSend') ?></option>
											<?php endif ?>
											<?php if(isset($_GET['PurchaseOrder'])): ?>
											<option value="1" <?= selected($Maindata->ETAT, 1) ?>><?= $langue->show_text('SelectOpen') ?></option>
											<option value="2" <?= selected($Maindata->ETAT, 2) ?>><?= $langue->show_text('SelectRun') ?></option>
											<option value="3" <?= selected($Maindata->ETAT, 3) ?>><?= $langue->show_text('SelecPartialDelivery') ?></option>
											<option value="4" <?= selected($Maindata->ETAT, 4) ?>><?= $langue->show_text('SelectDelivered') ?></option>
											<option value="5" <?= selected($Maindata->ETAT, 5) ?>><?= $langue->show_text('SelectInvoice') ?></option>
											<option value="6" <?= selected($Maindata->ETAT, 6) ?>><?= $langue->show_text('SelectStop') ?></option>
											<?php endif ?>
											<?php if(isset($_GET['PurchaseDelivery'])): ?>
											<option value="1" <?= selected($Maindata->ETAT, 1) ?>><?= $langue->show_text('SelectOpen') ?></option>
											<option value="2" <?= selected($Maindata->ETAT, 2) ?>><?= $langue->show_text('SelectSend') ?></option>
											<?php endif ?>
											<?php if(isset($_GET['SupplierInvoice'])): ?>
											<option value="1" <?= selected($Maindata->ETAT, 1) ?>><?= $langue->show_text('SelectOpen') ?></option>
											<option value="2" <?= selected($Maindata->ETAT, 2) ?>><?= $langue->show_text('SelectSend') ?></option>
											<?php endif ?>
										</select>
									</td>
									<td><input type="checkbox" id="MajLigne" name="MajLigne" checked="checked"><label ><?= $langue->show_text('UpdateLine') ?></label></td>
								</tr>
								<tr>
									<td colspan="3" >
										<br/>
										<?= $Form->submit($langue->show_text('TableUpdateButton'), true) ?> <br/>
										<br/>
									</td>
								</tr>
							</tbody>
						</table>
				</form>
			</div>
			<div class="column">
				<form method="post" name="Coment" action="<?=$actionForm; ?>" class="content-form" >
					<table class="content-table">
						<thead>
							<tr>
								<th colspan="2" ><?=$langue->show_text('Title2-1'); ?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<?= $Form->input('hidden', 'id', $Maindata->id) ?>
									<?= $langue->show_text('TableUserCreate') ?>
								</td>
								<td><?= $Maindata->NOM_CREATOR ?> <?= $Maindata->PRENOM_CREATOR ?></td>
							</tr><tr>
								<td><?= $langue->show_text('TableBuyer') ?></td>
								<td><?= $Form->select('BUYER_ID', '',  $Maindata->BUYER_ID,$ActivateForm, $Maindata->NOM_BUYER .'  '.$Maindata->PRENOM_BUYER , $Employees->GETEmployeesList($Maindata->BUYER_ID, false) )  ?></td>
							</tr>
							<tr>
								<td colspan="2" ><?= $Form->submit($langue->show_text('TableUpdateButton'), $ActivateForm) ?></td>
							</tr>
						</tbody>
					</table>
				</form>
				<form method="post" name="Coment" action="<?=$actionForm; ?>" class="content-form" >
					<table class="content-table" style="width: 100%;">
						<thead>
							<tr>
								<th colspan="2" ><?=$langue->show_text('Title2-2'); ?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<input type="hidden" name="id" value="<?= $Maindata->id ?>">
									<?= $langue->show_text('TableSupplier') ?>
								</td>
								<td><a href="index.php?page=companies&id=<?=  $Maindata->COMPANY_ID  ?>"><?=  $Maindata->CUSTOMER_LABEL  ?></a></td>
							</tr>
							<tr>
								<td><?= $langue->show_text('TableContact') ?></td>
								<td>
									<select name="CONTACT_ID">
										<?=  $Contact->GETContactList($Maindata->CONTACT_ID, true, $Maindata->COMPANY_ID )  ?>
									</select>
								</td>
							</tr>
							<tr>
								<td><?= $langue->show_text('TableAdresseSupplier') ?></td>
								<td>
									<select name="ADRESSE_ID">
										<?=  $Address->GETAddressList($Maindata->ADRESSE_ID, true, $Maindata->COMPANY_ID ) ?>
									</select>
								</td>
							</tr>
							<tr>
								<td colspan="2" ><?= $Form->submit($langue->show_text('TableUpdateButton'), $ActivateForm) ?></td>
							</tr>
						</tbody>
					</table>
				</form>	
			</div>
			<div class="column">
				<form method="post" name="Coment" action="<?=$actionForm; ?>" class="content-form" >
					<table class="content-table" >
						<thead>
							<tr>
								<th><?=$langue->show_text('Title2-4'); ?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><textarea class="Comment" name="COMENT" id="COMENT" rows="20" ><?= $Maindata->COMENT ?></textarea></td>
							</tr>
							<tr>
								<td><?= $Form->submit($langue->show_text('TableUpdateButton'), true) ?></td>
							</tr>
						</tbody>
					</table>
				</form>
			</div>
		</div>
	</div>
	<!-- End Document General information -->
	<!-- Start Detail line -->
	<div id="div2" class="tabcontent">
		<form method="post" name="Coment" action="<?=$actionForm; ?>" class="content-form" >
			<table class="content-table-Adding" >
				<thead>
					<tr>
						<th colspan="12" ><?= $langue->show_text('TableNumberQuote')  ?> <?= $Maindata->CODE  ?> <?= $langue->show_text('TableIndexQuote')  ?>  <?= $Maindata->INDICE  ?></th>
					</tr>
					<tr>
						<th></th>
						<th><?= $langue->show_text('TableOrder')?></th>
						<th><?= $langue->show_text('TableTask')?></th>
						<th><?= $langue->show_text('TableArticle')?></th>
						<th><?= $langue->show_text('TableLabel')?></th>
						<th><?= $langue->show_text('TableTecSpecif')?></th>
						<th><?= $langue->show_text('TableQty')?></th>
						<th><?= $langue->show_text('TableUnit')?></th>
						<th><?= $langue->show_text('TableUnitPrice')?></th>
						<th><?= $langue->show_text('TableDiscount')?></th>
						<th><?= $langue->show_text('TableTotal')?></th>
						<th><?= $langue->show_text('TableStatu')?></th>
					</tr>
				</thead>
				<?php 
				////THIS CODE IS FOR ADD LINE, DO NOT POSSIBLE TO ADD LINE ON BELLOW MODE ////
				if(!isset($_GET['SupplierReception']) AND !isset($_GET['SupplierInvoice'] )): ?>
				<tbody>
					<tr>
						<td>+</td>
						<td><input type="number" name="" id="AddORDRELigne" placeholder="10"  value="10"></td>
						<td>
							<input list="Task" name="AddTaskLigne" id="AddTaskLigne">
							<datalist id="Task">
								<?= $ListeTask ?>
							</datalist>
						</td>
						<td>
							<input list="Article" name="AddARTICLELigne" id="AddARTICLELigne">
							<datalist id="Article">
								<?= $ListeArticle ?>
							</datalist>
						</td>
						<td><input type="text"  name="" id="AddLABELLigne" placeholder="Désignation"></td>
						<td><input type="text"  name="" id="AddTechSpecifLigne" placeholder="Désignation"></td>
						<td><input type="number"  name="" id="AddQTLigne" placeholder="1"  value="1"></td>
						<td><?= $Form->select('AddUNITLigne', 'AddUNITLigne', '',$ActivateForm,'', $Unit->GetUnitList(0, false) )  ?></td>
						<td><input type="number"  name="" id="AAddPrixLigne" step=".001" placeholder="10 €"  value="0"></td>
						<td><input type="number"  name="" id="AddRemiseLigne" min="0" max="100" step=".001" placeholder="0 %" value="0"></td>
						<td></td>
						<td><input type="button" class="add" value="<?= $langue->show_text('Addline') ?>"></td>
					</tr>
					<tr>
						<td colspan="12" >
							<input type="button" class="delete" value="<?= $langue->show_text('Deleteline') ?>">
						</td>
					</tr>
				</table>
				<table class="content-table" >
					<tr>
						<th colspan="12" ></th>
					</tr>
					<?php endif ?>
					<?php
						
						$i =0;
						$tableauTVA = array();
						foreach ($reqLines as $data): 

							$TotalLigneHTEnCours = ($data->QT*$data->PRIX_U)-($data->QT*$data->PRIX_U)*($data->DISCOUNT/100);
							$TotalLigneTVAEnCours =  $TotalLigneHTEnCours*($data->TAUX/100) ;
							$TotalLigneTTCEnCours = $TotalLigneTVAEnCours+$TotalLigneHTEnCours;

							$TotalLigneHT += $TotalLigneHTEnCours;
							$TotalLigneTTC += $TotalLigneTVAEnCours+$TotalLigneHTEnCours;

							if(array_key_exists($data->TVA_ID, $tableauTVA)){
								$tableauTVA[$data->TVA_ID][0] += $TotalLigneHTEnCours;
								$tableauTVA[$data->TVA_ID][2] += $TotalLigneTVAEnCours;
								$tableauTVA[$data->TVA_ID][3] += $TotalLigneTTCEnCours;
							}
							else{
								$tableauTVA[$data->TVA_ID] = array($TotalLigneHTEnCours, $data->TAUX, $TotalLigneTVAEnCours, $TotalLigneTTCEnCours);
							}

							////LIGNE LIST FOR QUOTE CONVERT TO ORDER  ////
							$LignePourCommande .='
							<tr>
								<td>
									<label class="container">
										<input type="checkbox" title="'. $data->id .'" name="ADD_ORDER_LINE[]" value="'. $data->id .'" id="'. $data->id .'" checked="checked"/>
										<span class="checkmark"></span>
									</label>
								</td>
								<td>'. $data->LABEL .'</td>
								<td>'. $data->QT .'</td>
								<td>'. $data->PRIX_U .' €</td>
								<td>'. $data->DISCOUNT .' %</td>
								<td>'.   $TotalLigneHTEnCours .' € </td>
								<td>'. $data->DELAIS .'</td>
							</tr>';?>

							<tr class="clickable-row" onclick="ShowTechnicalCut(<?= $i ?>)">
								<td>
									<input type="hidden" name="UpdateIdLigne[]" id="UpdateIdLigne" value="<?= $data->id ?>">
									<a href="index.php?page=<?= $_GET['page'] ?>&amp;<?= $GET ?>=<?= $_GET[$GET] ?>&amp;delete=<?= $data->id ?>" title="Supprimer la ligne">&#10007;</a>
								</td>
								<td><?= $Form->input('number', 'UpdateORDRELigne[]',  $data->ORDRE, '', $ActivateForm)  ?></td>
								<td>
									<input list="Task" name="UpdateIdTaskLigne[]" id="UpdateIdTaskLigne" value="<?= $data->TASK_ID ?>">
									<datalist id="Task">
										<?= $ListeTask ?>
									</datalist>
								</td>
								<td>
									<input list="Article" name="UpdateIDArticleLigne[]" id="UpdateIDArticleLigne" value="<?= $data->ARTICLE_CODE ?>">
									<datalist id="Article">
										<?= $ListeArticle ?>
									</datalist>
								</td>
								<td><?= $Form->input('text', 'UpdateLABELLigne[]', $data->LABEL,'', $ActivateForm) ?></td>
								<td><?= $Form->input('text', 'UpdateTECHNICAL_SPECIFICATIONLigne[]', $data->TECHNICAL_SPECIFICATION,'', $ActivateForm) ?></td>
								<td><?= $Form->input('number', 'UpdateQTLigne[]', $data->QT,'', $ActivateForm) ?></td>
								<td><?= $Form->select('UpdateUNITLigne[]', '',  $data->UNIT_ID,$ActivateForm,$data->LABEL_UNIT, $Unit->GetUnitList($data->UNIT_ID, false) )  ?></td>
								<td><?= $Form->input('number', 'UpdatePrixLigne[]', $data->PRIX_U,'', $ActivateForm, ' step=".001"') ?></td>
								<td><?= $Form->input('number', 'UpdateRemiseLigne[]', $data->DISCOUNT,'', $ActivateForm, ' min="0" max="100" step=".001"') ?></td>
								<td><?= $TotalLigneHTEnCours ?> €</td><td>
									<select  name="UpdateETATLigne[]">
										<?php if(isset($_GET['PurchaseRequest'])): ?>
										<option value="1" <?= selected($data->ETAT, 1) ?>><?= $langue->show_text('SelectOpen') ?></option>
										<option value="2" <?= selected($data->ETAT, 2) ?>><?= $langue->show_text('SelectSend') ?></option>
										<?php endif ?>
										<?php if(isset($_GET['PurchaseOrder'])): ?>
										<option value="1" <?= selected($data->ETAT, 1) ?>><?= $langue->show_text('SelectOpen') ?></option>
										<option value="2" <?= selected($data->ETAT, 2) ?>><?= $langue->show_text('SelectRun') ?></option>
										<option value="3" <?= selected($data->ETAT, 3) ?>><?= $langue->show_text('SelecPartialDelivery') ?></option>
										<option value="4" <?= selected($data->ETAT, 4) ?>><?= $langue->show_text('SelectDelivered') ?></option>
										<option value="5" <?= selected($data->ETAT, 5) ?>><?= $langue->show_text('SelectInvoice') ?></option>
										<option value="6" <?= selected($data->ETAT, 6) ?>><?= $langue->show_text('SelectStop') ?></option>
										<?php endif ?>
										<?php if(isset($_GET['PurchaseDelivery'])): ?>
										<option value="1" <?= selected($data->ETAT, 1) ?>><?= $langue->show_text('SelectOpen') ?></option>
										<option value="2" <?= selected($data->ETAT, 2) ?>><?= $langue->show_text('SelectSend') ?></option>
										<?php endif ?>
										<?php if(isset($_GET['SupplierInvoice'])): ?>
										<option value="1" <?= selected($data->ETAT, 1) ?>><?= $langue->show_text('SelectOpen') ?></option>
										<option value="2" <?= selected($data->ETAT, 2) ?>><?= $langue->show_text('SelectSend') ?></option>
										<?php endif ?>
									</select>
								</td>
							</tr>	
							
					<?php $i++; endforeach; 
					if($i == 0):  ?>
							<tr>
								<td colspan="12"><?=$langue->show_text('TableNoData'); ?></td>
							</tr>
					<?php endif?>
					<tr>
						<td colspan="12" ><?= $Form->submit($langue->show_text('UpdateLine'), $ActivateForm) ?></td>
					</tr>
			</table>
			<table class="content-table">
				<thead>	
					<tr>
						<th colspan="3"></th>
						<th colspan="2" ><?= $langue->show_text('TotalPriceWithOutTax')?></th>
						<th ><?= $langue->show_text('TableRate')?></th>
						<th colspan="2" ><?= $langue->show_text('TotalTax')?></th>
						<th colspan="4"><?= $langue->show_text('TotalPriceWithTax')?></th>
					</tr>
					<?php 
					asort($tableauTVA);
					foreach($tableauTVA as $key => $value):?>
					<tr>
						<td colspan="3"></td>
						<td colspan="2" ><?= $tableauTVA[$key][0] ?> €</td>
						<td><?= $tableauTVA[$key][1] ?> %</td>
						<td colspan="2" ><?= $tableauTVA[$key][2] ?> €</td>
						<td colspan="4"><?= $tableauTVA[$key][3] ?> €</td>
					</tr>
					<?php $i++; endforeach; ?>
					<tr>
						<td colspan="3"><?= $langue->show_text('TotalWithOutTax') ?></td>
						<td colspan="2"><?= $TotalLigneHT ?> €</td>
						<td></td>
						<td colspan="2" ><?= $langue->show_text('TotalWithTax') ?></td>
						<td colspan="4"><?= $TotalLigneTTC ?> €</td>
					<tr>
				</tbody>
			</table>
		</form>
	</div>
	<!-- End Detail line -->
	<!-- Start File stockage -->
	<div id="div3" class="tabcontent">
		<?php 
			echo $Document->GETAjaxScript($DocumentType, $Maindata->id); 
			echo $Document->GETDropZone(); 
			$TitreTable = array($langue->show_text('TableArticle'), $langue->show_text('TableLabel'),  $langue->show_text('TableLabel'), $langue->show_text('TableQty'), $langue->show_text('TableUnit'));
			echo $Document->GETDocumentList($DocumentType, $_GET['page'], $Maindata->id, $TitreTable ); 
		?>
	</div>
	<!-- End File stockage -->
