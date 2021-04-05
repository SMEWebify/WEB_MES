    <div id="div1" class="tabcontent">
		<div class="column">
			<input type="text" id="myInput" onkeyup="myFunction()" placeholder="<?= $langue->show_text('TableFind1') ?>">
			<ul id="myUL">
				<?php
				//generate list for datalist find input
				foreach ($reqList as $data): 
					if($data->ETAT == 1) $class="info";
					elseif($data->ETAT == 2) $class="warning";
					elseif($data->ETAT == 3) $class="success";
					elseif($data->ETAT == 6) $class="alert";
					else $class="normal";
                 echo '<li><span ><a class='. $class .' href="index.php?page='. $_GET['page'] .'&'. $GET .'='. $data->id .'">'. $data->CODE .' - '. $data->NAME .'</a></span></li>';
				$i++; endforeach; ?>
			</ul>
		</div>
		<div class="column">
			<form method="post" name="<?= $GET ?>" action="index.php?page=<?= $_GET['page'] ?>&<?= $GET ?>=new" class="content-form" enctype="multipart/form-data" >
				<table class="content-table">
					<thead>
						<tr>
							<th colspan="5"><br/></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><?= $langue->show_text('TableNewQuoteFor') ?></td>
							<td>
								<select name="CUSTOMER_ID">
									<?= $Companies->GetCustomerList() ?>
								</select>
							</td>
						</tr>
						<tr>
							<td><?= $langue->show_text('TableNumberQuote') ?></td>
							<td>
								<?= $Form->input('text', 'CODE',  $Numbering->getCodeNumbering($DocNum),'', $ActivateForm) ?>
							</td>
						</tr>
						<tr>
							<td colspan="6" >
								<br/>
								<?= $Form->submit($langue->show_text('TableNewButton'), $ActivateForm) ?>
								<br/>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>
	</div>
	<?php if(isset($_GET[$GET]) AND !empty($_GET[$GET])){   ?>
	<div id="div2" class="tabcontent">
		<div class="box">
			<form method="post" name="Coment" action="<?=$actionForm; ?>" class="content-form" >
				<div>
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
				</div>
			</form>
			<form method="post" name="Coment" action="<?=$actionForm; ?>" class="content-form" >
				<div>
					<table class="content-table">
						<thead>
							<tr>
								<th colspan="2" ><?=$langue->show_text('Title6'); ?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?= $langue->show_text('TableCondiList') ?></td>
								<td>
									<select name="COND_REG_CUSTOMER_ID">
										<?=$PaymentCondition->GETPaymentConditionList($Maindata->COND_REG_CUSTOMER_ID)?>
									</select>
								</td>
							</tr>
							<tr>
								<td><?= $langue->show_text('TableMethodList') ?></td>
								<td>
										<select name="MODE_REG_CUSTOMER_ID">
											<?=$PaymentMethod->GETPaymentMethodList($Maindata->MODE_REG_CUSTOMER_ID); ?>
										</select>
									</td>
								</tr>
								<tr>
									<td><?= $langue->show_text('TimeLinePayement') ?></td>
									<td>
										<select name="ECHEANCIER_ID">
											<?=  $PaymentSchedule->GETPaymentScheduleList($Maindata->Echeancier_ID, true) ?> 
										</select>
									</td>
								</tr>
								<tr>
									<td><?= $langue->show_text('TableDeleveryMode') ?></td>
									<td>
										<select name="TRANSPORT_ID">
											<?=  $Delevery->GETDeleveryList($Maindata->TRANSPORT_ID, true) ?>
										</select>
									</td>
								</tr>
								<tr>
									<td colspan="2"><?= $Form->submit($langue->show_text('TableUpdateButton'), $ActivateForm) ?></td>
								</tr>
						</tbody>
					</table>
				</div>
			</form>
			<form method="post" name="Coment" action="<?=$actionForm; ?>" class="content-form" >
				<div  class="item1">
					<table class="content-table" >
						<thead>
							<tr>
								<th><?=$langue->show_text('Title7'); ?></th>
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
				</div>
			</form>
			<form method="post" name="Coment" action="<?=$actionForm; ?>" class="content-form" >
				<div>
					<table class="content-table">
						<thead>
							<tr>
								<th colspan="2" ><?=$langue->show_text('Title4'); ?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<?= $Form->input('hidden', 'id', $Maindata->id) ?>
									<?= $langue->show_text('TableUserCreate') ?>
								</td>
								<td><?= $Maindata->NOM ?> <?= $Maindata->PRENOM ?></td>
							</tr>
							<tr>
								<td><?= $langue->show_text('TableSalesManager') ?></td>
								<td>
									<select name="RESP_COM_ID">
										<?=$Employees->GETEmployeesList($Maindata->RESP_COM_ID) ?>
									</select>
								</td>
							</tr>
							<tr>
								<td><?= $langue->show_text('TableTechnicalManager') ?></td>
								<td>
									<select name="RESP_TECH_ID">
									<?=$Employees->GETEmployeesList($Maindata->RESP_TECH_ID) ?>
									</select>
								</td>
							</tr>
							<tr>
								<td colspan="2" ><?= $Form->submit($langue->show_text('TableUpdateButton'), $ActivateForm) ?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</form>
			<form method="post" name="Coment" action="<?=$actionForm; ?>" class="content-form" >
				<div>
					<table class="content-table" style="width: 100%;">
						<thead>
							<tr>
								<th colspan="2" ><?=$langue->show_text('Title5'); ?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<input type="hidden" name="id" value="<?= $Maindata->id ?>">
									<?= $langue->show_text('TableCustomer') ?>
								</td>
								<td><a href="index.php?page=companies&id=<?=  $Maindata->CUSTOMER_ID  ?>"><?=  $Maindata->CUSTOMER_NAME  ?></a></td>
							</tr>
							<tr>
								<td><?= $langue->show_text('TableContact') ?></td>
								<td>
									<select name="CONTACT_ID">
										<?=  $Contact->GETContactList($Maindata->CONTACT_ID, true, $Maindata->CUSTOMER_ID )  ?>
									</select>
								</td>
							</tr>
							<tr>
								<td><?= $langue->show_text('TableAdresseDelevery') ?></td>
								<td>
									<select name="ADRESSE_ID">
									<?=  $Address->GETAddressList($Maindata->ADRESSE_ID, true, $Maindata->CUSTOMER_ID,'AND ADRESS_LIV=\'1\'' ) ?>
									</select>
								</td>
							</tr>
							<tr>
								<td><?= $langue->show_text('TableAdresseInvoice') ?></td>
								<td>
									<select name="FACTURATION_ID">
										<?=  $Address->GETAddressList($Maindata->FACTURATION_ID, true, $Maindata->CUSTOMER_ID,'AND ADRESS_FAC=\'1\'' ) ?>
									</select>
								</td>
							</tr>
							<tr>
								<td colspan="2" ><?= $Form->submit($langue->show_text('TableUpdateButton'), $ActivateForm) ?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</form>
			<?php
			//for converte ORDER TO ACKNOWLEGMENT 
			if(isset($_GET['order']) && !empty($_GET['order'])){ ?>
				<form method="post" name="Coment" action="index.php?page=order&OrderAcknowledgment=new" class="content-form" >
				<div>
					<table class="content-table" >
						<thead>
							<tr>
								<th colspan="12" >
									<?= $langue->show_text('TableGeneralInfo') ?>
								</th>
							</tr>
						</thead>
						<tbody>
				<?php if( $MakeAR > 0){?>
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
						
				<?php } if($ARList > 0){?>
				
						<?php foreach ($ARList as $dataAr): ?>
							<tr>
								<td>
								<a  href="index.php?page=order&OrderAcknowledgment=<?= $dataAr->id ?>"><?= $dataAr->CODE ?></a>
								</td>
							</tr>
						<?php endforeach; ?>
				<?php } 
				}?>
						</tbody>
					</table>
				</div>
		</div>
	</div>
	<div id="div3" class="tabcontent">
		<form method="post" name="Coment" action="<?=$actionForm; ?>" class="content-form" >
			<table class="content-table-devis" >
				<thead>
					<tr>
						<th colspan="12" >
						<?= $langue->show_text('TableNumberQuote')  ?> <?= $Maindata->CODE  ?> <?= $langue->show_text('TableIndexQuote')  ?>  <?= $Maindata->INDICE  ?>
						</th>
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
				<tbody>
					<?php if(!isset($_GET['OrderAcknowledgment'])): ?>
					</tr>
						<th colspan="12" ><?= $langue->show_text('Addline') ?></th>
					</tr>
					<tr>
						<td></td>
						<td><input type="number" name="" id="AddORDRELigne" placeholder="10"  value="10"></td>
						<td>
							<input list="Article" name="AddARTICLELigne" id="AddARTICLELigne">
							<datalist id="Article">
								<?= $ListeArticle ?>
							</datalist>
						</td>
						<td><input type="text"  name="" id="AddLABELLigne" placeholder="Désignation"></td>
						<td><input type="number"  name="" id="AddQTLigne" placeholder="1"  value="1"></td>
						<td>
							<select name="" id="AddUNITLigne">
							<?= $Unit->GetUnitList() ?>
							</select>
						</td>
						<td><input type="number"  name="" id="AAddPrixLigne" step=".001" placeholder="10 €"  value="0"></td>
						<td><input type="number"  name="" id="AddRemiseLigne" min="0" max="100" step=".001" placeholder="0 %" value="0"></td>
						<td></td>
						<td>
							<select name="" id="AddTVALigne">
							<?= $VAT->GETVATList() ?>
							</select>
						</td>
						<td><input type="date" name="" id="AddDELAISigne"></td>
						<td></td>
					</tr>
					<tr>
						<td colspan="12" >
							<input type="button" class="add" value="<?= $langue->show_text('Addline') ?>">
							<input type="button" class="delete" value="<?= $langue->show_text('Deleteline') ?>">
							<?= $Form->submit($langue->show_text('UpdateLine'), $ActivateForm) ?>
						</td>
					</tr>
					<?php endif ?>
					<?php
						////LIGNE LIST  ////
						$i =0;
						$tableauTVA = array();
						foreach ($reqLines as $data): 

							$TotalLigneHTEnCours = ($data->QT*$data->PRIX_U)-($data->QT*$data->PRIX_U)*($data->REMISE/100);
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
								<td>'. $data->REMISE .' %</td>
								<td>'.   $TotalLigneHTEnCours .' € </td>
								<td>'. $data->DELAIS .'</td>
							</tr>';?>
							<tr>
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
									<a href="admin.php?page=manage-study&amp;id=<?= $data->id ?>&amp;type=<?= $GET ?>&amp;<?= $GET ?>Id=<?= $_GET[$GET] ?>" title="Découpage technique">&#10144;</a>
								</td>
								<td><?= $Form->input('text', 'UpdateLABELLigne[]', $data->LABEL,'', $ActivateForm) ?></td>
								<td><?= $Form->input('number', 'UpdateQTLigne[]', $data->QT,'', $ActivateForm) ?></td>
								<td>
									<select  name="UpdateUNITLigne[]">
										<?= $Unit->GetUnitList($data->UNIT_ID, true) ?>
									</select>
								</td>
								<td><?= $Form->input('number', 'UpdatePrixLigne[]', $data->PRIX_U,'', $ActivateForm, ' step=".001"') ?></td>
								<td><?= $Form->input('number', 'UpdateRemiseLigne[]', $data->REMISE,'', $ActivateForm, ' min="0" max="100" step=".001"') ?></td>
								<td><?=   $TotalLigneHTEnCours ?> €</td>

								<td>
									<select  name="UpdateTVALigne[]">
										<?= $VAT->GETVATList($data->TVA_ID) ?>
									</select>
								</td>
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
									</select>
								</td>
							</tr>	
					</tr>
					<?php $i++; endforeach; 
					if($i != 0){ ?>
					<tr>
						<th></th>
						<th></th>
						<th></th>
						<th colspan="2" ><?= $langue->show_text('TotalPriceWithOutTax')?></th>
						<th ><?= $langue->show_text('TableRate')?></th>
						<th colspan="2" ><?= $langue->show_text('TotalTax')?></th>
						<th><?= $langue->show_text('TotalPriceWithTax')?></th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
					<?php 
					asort($tableauTVA);
					foreach($tableauTVA as $key => $value):?>
					<tr>
						<th></th>
						<th></th>
						<th></th>
						<th colspan="2" ><?= $tableauTVA[$key][0] ?> €</th>
						<th><?= $tableauTVA[$key][1] ?> %</th>
						<th colspan="2" ><?= $tableauTVA[$key][2] ?> €</th>
						<th><?= $tableauTVA[$key][3] ?> €</th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
					<?php $i++; endforeach; ?>
					<tr>
						<th></th>
						<th></th>
						<th><?= $langue->show_text('TotalWithOutTax') ?></th>
						<th colspan="2"><?= $TotalLigneHT ?> €</th>
						<th></th>
						<th colspan="2" ><?= $langue->show_text('TotalWithTax') ?></th>
						<th><?= $TotalLigneTTC ?> €</th>
						<th></th>
						<th></th>
						<th></th>
					<tr>
					<?php } ?>
				</tbody>
			</table>
		</form>
	</div>
	<?php
        }

