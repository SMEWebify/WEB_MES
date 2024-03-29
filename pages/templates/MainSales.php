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
									<td><?= $langue->show_text('TableCustomerReference')  ?></td>
									<td  colspan="2"><?= $Form->input('text', 'REFERENCE', $Maindata->REFERENCE, $langue->show_text('TableCustomerReference'),$ActivateForm) ?></td>
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
											<?php if(isset($_GET['quote'])): ?>
											<option value="1" <?= selected($Maindata->ETAT, 1) ?>><?= $langue->show_text('SelectOpen') ?></option>
											<option value="2" <?= selected($Maindata->ETAT, 2) ?>><?= $langue->show_text('SelectSend') ?></option>
											<option value="3" <?= selected($Maindata->ETAT, 3) ?>><?= $langue->show_text('SelectWin') ?></option>
											<option value="4" <?= selected($Maindata->ETAT, 4) ?>><?= $langue->show_text('SelectRefuse') ?></option>
											<option value="5" <?= selected($Maindata->ETAT, 5) ?>><?= $langue->show_text('SelectDecline') ?></option>
											<option value="6" <?= selected($Maindata->ETAT, 6) ?>><?= $langue->show_text('SelectClosed') ?></option>
											<option value="7" <?= selected($Maindata->ETAT, 7) ?>><?= $langue->show_text('SelectObsolete') ?></option>
											<?php endif ?>
											<?php if(isset($_GET['order'])): ?>
											<option value="1" <?= selected($Maindata->ETAT, 1) ?>><?= $langue->show_text('SelectOpen') ?></option>
											<option value="2" <?= selected($Maindata->ETAT, 2) ?>><?= $langue->show_text('SelectRun') ?></option>
											<option value="3" <?= selected($Maindata->ETAT, 3) ?>><?= $langue->show_text('SelecPartialDelivery') ?></option>
											<option value="4" <?= selected($Maindata->ETAT, 4) ?>><?= $langue->show_text('SelectDelivered') ?></option>
											<option value="5" <?= selected($Maindata->ETAT, 5) ?>><?= $langue->show_text('SelectInvoice') ?></option>
											<option value="6" <?= selected($Maindata->ETAT, 6) ?>><?= $langue->show_text('SelectStop') ?></option>
											<?php endif ?>
											<?php if(isset($_GET['OrderAcknowledgment'])): ?>
											<option value="1" <?= selected($Maindata->ETAT, 1) ?>><?= $langue->show_text('SelectOpen') ?></option>
											<option value="2" <?= selected($Maindata->ETAT, 2) ?>><?= $langue->show_text('SelectSend') ?></option>
											<?php endif ?>
											<?php if(isset($_GET['DeliveryNotes'])): ?>
											<option value="1" <?= selected($Maindata->ETAT, 1) ?>><?= $langue->show_text('SelectOpen') ?></option>
											<option value="2" <?= selected($Maindata->ETAT, 2) ?>><?= $langue->show_text('SelectSend') ?></option>
											<?php endif ?>
											<?php if(isset($_GET['InvoiceOrder'])): ?>
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
				<form method="post" name="Coment" action="<?=$actionForm; ?>" class="content-form" >
					<table class="content-table">
						<thead>
							<tr>
								<th colspan="2" ><?=$langue->show_text('Title2-3'); ?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?= $langue->show_text('TableCondiList') ?></td>
								<td><?= $Form->select('COND_REG_COMPANY_ID', '',  $Maindata->COND_REG_COMPANY_ID,$ActivateForm,$Maindata->COND_REG_LABEL, $PaymentCondition->GETPaymentConditionList(0, false))  ?></td>
							</tr>
							<tr>
								<td><?= $langue->show_text('TableMethodList') ?></td>
								<td><?= $Form->select('MODE_REG_COMPANY_ID', '',  $Maindata->MODE_REG_COMPANY_ID,$ActivateForm,$Maindata->MODE_REG_LABEL, $PaymentMethod->GETPaymentMethodList(0, false))  ?></td>
							</tr>
							<tr>
								<td><?= $langue->show_text('TimeLinePayement') ?></td>
								<td><?= $Form->select('ECHEANCIER_ID', '',  $Maindata->ECHEANCIER_ID,$ActivateForm,$Maindata->ECHEANCIER_LABEL, $PaymentSchedule->GETPaymentScheduleList(0, false))  ?></td>
							</tr>
							<tr>
								<td><?= $langue->show_text('TableDeleveryMode') ?></td>
								<td><?= $Form->select('TRANSPORT_ID', '',  $Maindata->TRANSPORT_ID,$ActivateForm,$Maindata->TRANSPORT_LABEL, $Delevery->GETDeleveryList(0, false))  ?></td>
							</tr>
							<tr>
								<td colspan="2"><?= $Form->submit($langue->show_text('TableUpdateButton'), $ActivateForm) ?></td>
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
							</tr>
							<tr>
								<td><?= $langue->show_text('TableSalesManager') ?></td>
								<td><?= $Form->select('RESP_COM_ID', '',  $Maindata->RESP_COM_ID,$ActivateForm, $Maindata->NOM_RESP_COM .'  '.$Maindata->PRENOM_RESP_COM , $Employees->GETEmployeesList($Maindata->RESP_COM_ID, false) )  ?></td>	</tr>
							<tr>
								<td><?= $langue->show_text('TableTechnicalManager') ?></td>
								<td><?= $Form->select('RESP_TECH_ID', '',  $Maindata->RESP_TECH_ID,$ActivateForm, $Maindata->NOM_RESP_TECH .'  '.$Maindata->PRENOM_RESP_TECH , $Employees->GETEmployeesList($Maindata->RESP_TECH_ID, false) )  ?></td>
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
									<?= $langue->show_text('TableCustomer') ?>
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
								<td><?= $langue->show_text('TableAdresseDelevery') ?></td>
								<td>
									<select name="ADRESSE_ID">
									<?=  $Address->GETAddressList($Maindata->ADRESSE_ID, true, $Maindata->COMPANY_ID,'AND ADRESS_LIV=\'1\'' ) ?>
									</select>
								</td>
							</tr>
							<tr>
								<td><?= $langue->show_text('TableAdresseInvoice') ?></td>
								<td>
									<select name="FACTURATION_ID">
										<?=  $Address->GETAddressList($Maindata->FACTURATION_ID, true, $Maindata->COMPANY_ID,'AND ADRESS_FAC=\'1\'' ) ?>
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
		<?php if(isset($_GET['order']) && !empty($_GET['order'])){ ?>
				<form method="post" name="Coment" action="index.php?page=order&OrderAcknowledgment=new" class="content-form" >
					<table class="content-table" >
						<thead>
							<tr>
								<th colspan="2" >
									---------------------------------------------
								</th>
							</tr>
						</thead>
						<tbody>
				<?php 
				//for converte ORDER TO ACKNOWLEGMENT 
				if( $MakeAR > 0){?>
							<tr>
								<td>
									<?= $langue->show_text('TableCODE') ?> : <?= $Form->input('text', 'NewOrderAcknowledgment',  $Numbering->getCodeNumbering(12),'', $ActivateForm) ?>
								</td>
							</tr>
							<tr>
								<td>
									<?= $Form->input('hidden', 'ORDER_ID', $Maindata->id  ,'', $ActivateForm) ?>
									<?= $Form->submit($langue->show_text('TableNewOrderAcknowledgment'), $ActivateForm) ?>
								</td>
							</tr>
						
				<?php } 
				//DISPLAY ACKNOWLEGMENT 
				if($ARList > 0){?>
				
						<?php foreach ($ARList as $dataAr): ?>
							<tr>
								<td>
								<a  href="index.php?page=order&OrderAcknowledgment=<?= $dataAr->id ?>"><?= $dataAr->CODE ?></a>
								</td>
							</tr>
						<?php endforeach; ?>
				<?php } ?>
						</tbody>
					</table>
				</form>

				<form method="post" name="Coment" action="index.php?page=order&DeliveryNotes=new" class="content-form" >
					<table class="content-table" >
						<thead>
							<tr>
								<th colspan="2" >
								---------------------------------------------
								</th>
							</tr>
						</thead>
						<tbody>
				<?php
				//for converte ORDER TO DELEVERY NOTE 
				if( $MakeDn > 0){?>
							<tr>
								<td>
									<?= $langue->show_text('TableCODE') ?> : <?= $Form->input('text', 'NewDeliveryNotes',  $Numbering->getCodeNumbering(3),'', $ActivateForm) ?>
								</td>
							</tr>
							<tr>
								<td>
									<?= $Form->input('hidden', 'ORDER_ID', $Maindata->id  ,'', $ActivateForm) ?>
									<?= $Form->submit($langue->show_text('TableNewDeliveryNotes'), $ActivateForm) ?>
								</td>
							</tr>
						
				<?php } 
				//DISPLAY  DELEVERY NOTE 
				if($DnList > 0){?>
				
						<?php foreach ($DnList as $dataDn): ?>
							<tr>
								<td>
								<a  href="index.php?page=order&DeliveryNotes=<?= $dataDn->id ?>"><?= $dataDn->CODE ?></a>
								</td>
							</tr>
						<?php endforeach; ?>
				<?php } ?>
						</tbody>
					</table>
				</form>

				<form method="post" name="Coment" action="index.php?page=order&InvoiceOrder=new" class="content-form" >
					<table class="content-table" >
						<thead>
							<tr>
								<th colspan="2" >
								---------------------------------------------
								</th>
							</tr>
						</thead>
						<tbody>
				<?php
				//for converte Invoice 
				if( $MakeIo > 0){?>
							<tr>
								<td>
									<?= $langue->show_text('TableCODE') ?> : <?= $Form->input('text', 'NewInvoiceOrder',  $Numbering->getCodeNumbering(9),'', $ActivateForm) ?>
								</td>
							</tr>
							<tr>
								<td>
									<?= $Form->input('hidden', 'ORDER_ID', $Maindata->id  ,'', $ActivateForm) ?>
									<?= $Form->submit($langue->show_text('TableNewInvoiceOrder'), $ActivateForm) ?>
								</td>
							</tr>
						
				<?php } 
				//DISPLAY  Invoice 
				if($IoList > 0){?>
				
						<?php foreach ($IoList as $dataIn): ?>
							<tr>
								<td>
								<a  href="index.php?page=order&InvoiceOrder=<?= $dataIn->id ?>"><?= $dataIn->CODE ?></a>
								</td>
							</tr>
						<?php endforeach; ?>
				<?php } ?>
						</tbody>
					</table>
				</form>

		<?php } ?>
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
						<th><?= $langue->show_text('TableArticle')?></th>
						<th><?= $langue->show_text('TableLabel')?></th>
						<th><?= $langue->show_text('TableQty')?></th>
						<th><?= $langue->show_text('TableUnit')?></th>
						<th><?= $langue->show_text('TableUnitPrice')?></th>
						<th><?= $langue->show_text('TableDiscount')?></th>
						<th><?= $langue->show_text('TableTotal')?></th>
						<th><?= $langue->show_text('TableRate')?></th>
						<th><?= $langue->show_text('TableDelay')?></th>
						<th><?= $langue->show_text('TableStatu')?></th>
					</tr>
				</thead>
				<?php 
				////DO NOT POSSIBLE TO ADD LINE ON BELLOW MODE ////
				if(!isset($_GET['OrderAcknowledgment']) AND !isset($_GET['DeliveryNotes'] ) AND !isset($_GET['InvoiceOrder'] )): ?>
				<tbody>
					<tr>
						<td>+</td>
						<td><input type="number" name="" id="AddORDRELigne" placeholder="10"  value="10"></td>
						<td>
							<input list="Article" name="AddARTICLELigne" id="AddARTICLELigne">
							<datalist id="Article">
								<?= $ListeArticle ?>
							</datalist>
						</td>
						<td><input type="text"  name="" id="AddLABELLigne" placeholder="Désignation"></td>
						<td><input type="number"  name="" id="AddQTLigne" placeholder="1"  value="1"></td>
						<td><?= $Form->select('AddUNITLigne', 'AddUNITLigne', '',$ActivateForm,'', $Unit->GetUnitList(0, false) )  ?></td>
						<td><input type="number"  name="" id="AAddPrixLigne" step=".001" placeholder="10 €"  value="0"></td>
						<td><input type="number"  name="" id="AddRemiseLigne" min="0" max="100" step=".001" placeholder="0 %" value="0"></td>
						<td></td>
						<td><?= $Form->select('AddTVALigne', 'AddTVALigne', '',$ActivateForm,'', $VAT->GETVATList(0, false) )  ?></td>
						<td><input type="date" name="" id="AddDELAISigne"></td>
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
						////LIGNE LIST FOR QUOTE CONVERT TO ORDER  ////
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
									<input list="Article" name="UpdateIDArticleLigne[]" id="UpdateIDArticleLigne" value="<?= $data->ARTICLE_CODE ?>">
									<datalist id="Article">
										<?= $ListeArticle ?>
									</datalist>
								</td>
								<td><?= $Form->input('text', 'UpdateLABELLigne[]', $data->LABEL,'', $ActivateForm) ?></td>
								<td><?= $Form->input('number', 'UpdateQTLigne[]', $data->QT,'', $ActivateForm) ?></td>
								<td><?= $Form->select('UpdateUNITLigne[]', '',  $data->UNIT_ID,$ActivateForm,$data->LABEL_UNIT, $Unit->GetUnitList($data->UNIT_ID, false) )  ?></td>
								<td><?= $Form->input('number', 'UpdatePrixLigne[]', $data->PRIX_U,'', $ActivateForm, ' step=".001"') ?></td>
								<td><?= $Form->input('number', 'UpdateRemiseLigne[]', $data->DISCOUNT,'', $ActivateForm, ' min="0" max="100" step=".001"') ?></td>
								<td><?= $TotalLigneHTEnCours ?> €</td>
								<td><?= $Form->select('UpdateTVALigne[]', '',  $data->TVA_ID,$ActivateForm,$data->LABEL_TVA, $VAT->GETVATList($data->TVA_ID, false) )  ?></td>
								<td><?= $Form->input('date', 'UpdateDELAISLigne[]',  $data->DELAIS,'', $ActivateForm) ?></td>
								<td>
									<select  name="UpdateETATLigne[]">
										<?php if(isset($_GET['quote'])): ?>
										<option value="1" <?= selected($data->ETAT, 1) ?>><?= $langue->show_text('SelectOpen') ?></option>
										<option value="2" <?= selected($data->ETAT, 2) ?>><?= $langue->show_text('SelectSend') ?></option>
										<option value="3" <?= selected($data->ETAT, 3) ?>><?= $langue->show_text('SelectWin') ?></option>
										<option value="4" <?= selected($data->ETAT, 4) ?>><?= $langue->show_text('SelectRefuse') ?></option>
										<option value="5" <?= selected($data->ETAT, 5) ?>><?= $langue->show_text('SelectDecline') ?></option>
										<option value="6" <?= selected($data->ETAT, 6) ?>><?= $langue->show_text('SelectClosed') ?></option>
										<option value="7" <?= selected($data->ETAT, 7) ?>><?= $langue->show_text('SelectObsolete') ?></option>
										<?php endif ?>
										<?php if(isset($_GET['order'])): ?>
										<option value="1" <?= selected($data->ETAT, 1) ?>><?= $langue->show_text('SelectOpen') ?></option>
										<option value="2" <?= selected($data->ETAT, 2) ?>><?= $langue->show_text('SelectRun') ?></option>
										<option value="3" <?= selected($data->ETAT, 3) ?>><?= $langue->show_text('SelecPartialDelivery') ?></option>
										<option value="4" <?= selected($data->ETAT, 4) ?>><?= $langue->show_text('SelectDelivered') ?></option>
										<option value="5" <?= selected($data->ETAT, 5) ?>><?= $langue->show_text('SelectInvoice') ?></option>
										<option value="6" <?= selected($data->ETAT, 6) ?>><?= $langue->show_text('SelectStop') ?></option>
										<?php endif ?>
										<?php if(isset($_GET['OrderAcknowledgment'])): ?>
										<option value="1" <?= selected($data->ETAT, 1) ?>><?= $langue->show_text('SelectOpen') ?></option>
										<option value="2" <?= selected($data->ETAT, 2) ?>><?= $langue->show_text('SelectSend') ?></option>
										<?php endif ?>
										<?php if(isset($_GET['DeliveryNotes'])): ?>
										<option value="1" <?= selected($data->ETAT, 1) ?>><?= $langue->show_text('SelectOpen') ?></option>
										<option value="2" <?= selected($data->ETAT, 2) ?>><?= $langue->show_text('SelectSend') ?></option>
										<?php endif ?>
										<?php if(isset($_GET['InvoiceOrder'])): ?>
										<option value="1" <?= selected($data->ETAT, 1) ?>><?= $langue->show_text('SelectOpen') ?></option>
										<option value="2" <?= selected($data->ETAT, 2) ?>><?= $langue->show_text('SelectSend') ?></option>
										<?php endif ?>
									</select>
								</td>
							</tr>	
							
							<tr>			
								<td colspan="12">
									<table id="TechnicalCutRow<?= $i ?>" style="display : none;">
										<thead>
											<tr>
												<th></th>
												<th><?=$langue->show_text('TableLabel'); ?></th>
												<th><?=$langue->show_text('TableService'); ?></th>
												<th><?=$langue->show_text('TableSettingTime'); ?></th>
												<th><?=$langue->show_text('TableProductTime'); ?></th>
												<th><?=$langue->show_text('TableProductCost'); ?></th>
												<th><?=$langue->show_text('TableSalePrice'); ?></th>
												<th><?=$langue->show_text('TableStatu'); ?></th>
											</tr>
										</thead>
										<tbody>
											<?php $j = 0; foreach ($Task->GETTechnicalCut($data->id, $_GET['page']) as $DataTechnicalCut): ?>
											<tr>
												<td>#<?=  $DataTechnicalCut->id ?></td>
												<td><?=  $DataTechnicalCut->LABEL ?></td>
												<td><?=  $DataTechnicalCut->LABEL_SERVICE ?></td>
												<td><?=  $DataTechnicalCut->SETING_TIME ?></td>
												<td><?=  $DataTechnicalCut->UNIT_TIME  ?></td>
												<td><?=  $DataTechnicalCut->UNIT_COST  ?></td>
												<td><?=  $DataTechnicalCut->UNIT_PRICE ?></td>
												<td><?=  $DataTechnicalCut->ETAT ?></td>
											</tr>
											<?php $j++; endforeach; 
											if($j == 0):  ?>
												<tr>
													<td colspan="8"><?=$langue->show_text('TableNoData'); ?></td>
												</tr>
											<?php endif?>
											<tr>
												<td colspan="8">	
													<a href="index.php?page=manage-study&amp;id=<?= $data->id ?>&amp;type=<?= $GET ?>&amp;<?= $GET ?>Id=<?= $_GET[$GET] ?>" title="Découpage technique">&#10144;</a>
												</td>
											</tr>
										</tbody>
									</table>
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
