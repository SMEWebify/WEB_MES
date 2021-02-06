<?php
	//phpinfo();
	use \App\Autoloader;
	use \App\COMPANY\Employees;
	use \App\COMPANY\Numbering;
	use \App\Companies\Companies;
	use \App\Companies\Contact;
	use \App\Companies\Address;
	use \App\Form;
	use \App\Accounting\PaymentMethod;
	use \App\Accounting\PaymentCondition;
	use \App\Accounting\PaymentSchedule;
	use \App\Quote\Quote;
	use \App\Quote\QuoteLines;
	use \App\Accounting\Delevery;
	use \App\Accounting\VAT;
	use \App\Study\Unit;

	//auto load class
	require_once '../app/Autoload.class.php';
	Autoloader::register();
	
	session_start();
	header( 'content-type: text/html; charset=utf-8' );
	//init form class
	$Form = new Form($_POST);
	$Employees = new Employees();
	$Numbering = new Numbering();
	$Companies = new Companies();
	$Contact =  new Contact();
	$Address = new Address();
	$PaymentMethod = new PaymentMethod();
	$PaymentCondition = new PaymentCondition();
	$PaymentSchedule = new PaymentSchedule();
	$Quote = new Quote();
	$QuoteLines = new QuoteLines();
	$Delevery = new Delevery();
	$VAT = new VAT();
	$Unit = new Unit();

	//Check if the user is authorized to view the page
	if($_SESSION['page_5'] != '1'){
		stop($langue->show_text('SystemInfoAccessDenied'), 161, 'index.php?page=login');
	}

	if(isset($_GET['quote']) AND !empty($_GET['quote'])){
		
		$Id = addslashes($_GET['quote']);

		//If user create new quote
		if(isset($_POST['CUSTOMER_ID']) And !empty($_POST['CUSTOMER_ID'])){
			$ParDefautDiv2 = 'id="defaultOpen"';
			//insert in DB new quote
			$Id = $Quote->NewQuote(addslashes($_POST['CODE']), addslashes($_POST['CUSTOMER_ID']), $User->idUSER);
			$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddQuoteNotification')));
			//update increment in num sequence db
			$Numbering->getIncrementNumbering(8);
		}
		elseif(isset($_POST['COMENT']) AND !empty($_POST['COMENT'])){
			//// COMMMENT ////
			$bdd->GetUpdatePOST(TABLE_ERP_QUOTE, $_POST, 'WHERE id=\''. $Id .'\'');
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateCommentNotification')));
		}
		elseif(isset($_POST['RESP_COM_ID']) AND !empty($_POST['RESP_COM_ID'])){
			//// GENERAL UPDATE ////
			$PostRESP_COM_ID= $_POST['RESP_COM_ID'];
			$PostRESP_TECH_ID = $_POST['RESP_TECH_ID'];

			if($_POST['RESP_COM_ID'] == 'null'){ $PostRESP_COM_ID = 0; }
			if($_POST['RESP_TECH_ID'] == 'null'){ $PostRESP_TECH_ID = 0; }

			$bdd->GetUpdate("UPDATE  ". TABLE_ERP_QUOTE ." SET 	RESP_COM_ID='". addslashes($PostRESP_COM_ID) ."',
																RESP_TECH_ID='". addslashes($PostRESP_TECH_ID) ."'
															WHERE id='". $Id ."'");
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateGeneralNotification')));
		}
		elseif(isset($_POST['CODE']) AND !empty($_POST['CODE'])){
			//// ACCEUIL DEVIS  ////
			if(isset($_POST['MajLigne']) AND !empty($_POST['MajLigne'])){
				$bdd->GetUpdate("UPDATE  ". TABLE_ERP_QUOTE_LIGNE ." SET ETAT='". addslashes($_POST['ETAT']) ."'	
																		WHERE DEVIS_ID='". addslashes($_POST['IdDevis'])."'");
				$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateStatuLineNotification')));
			}
			unset($_POST['MajLigne']);
			$bdd->GetUpdatePOST(TABLE_ERP_QUOTE, $_POST, 'WHERE id=\''. $Id .'\'');
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateGeneralInfoNotification')));
		}
		elseif(isset($_POST['CONTACT_ID']) AND !empty($_POST['CONTACT_ID'])){
			//// CLIENT INFO UPDATE ////
			$PostCONTACT_ID= $_POST['CONTACT_ID'];
			$PostADRESSE_ID = $_POST['ADRESSE_ID'];
			$PostFACTURATION_ID = $_POST['FACTURATION_ID'];
	
			if($_POST['CONTACT_ID'] == 'null'){ $PostCONTACT_ID = 0; }
			if($_POST['ADRESSE_ID'] == 'null'){ $PostADRESSE_ID = 0; }
			if($_POST['FACTURATION_ID'] == 'null'){ $PostFACTURATION_ID = 0; }
	
			$bdd->GetUpdate("UPDATE  ". TABLE_ERP_QUOTE ." SET 	CONTACT_ID='". addslashes($PostCONTACT_ID) ."',
																	ADRESSE_ID='". addslashes($PostADRESSE_ID) ."',
																	FACTURATION_ID='". addslashes($PostFACTURATION_ID) ."'
																WHERE id='". $Id ."'");
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateInfoCustomerNotification')));
		}
		elseif(isset($_POST['COND_REG_CUSTOMER_ID']) AND !empty($_POST['COND_REG_CUSTOMER_ID'])){
			//// COMMERCIAL UPDATE ////
			$bdd->GetUpdatePOST(TABLE_ERP_QUOTE, $_POST, 'WHERE id=\''. $Id .'\'');
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateSalesInfoNotification')));
		}
		elseif(isset($_GET['delete']) AND !empty($_GET['delete'])){
			//// DELETE LIGNE ////
			$bdd->GetDelete("DELETE FROM ". TABLE_ERP_QUOTE_LIGNE ." WHERE id='". addslashes($_GET['delete'])."'");
			$CallOutBox->add_notification(array('4', $i . $langue->show_text('DeleteQuoteLineNotification')));
		}
		elseif(isset($_POST['AddORDRELigne']) AND !empty($_POST['AddORDRELigne'])){
			//// AJOUT DE LIGNE  ////
			$i = 0;
			foreach ($_POST['AddORDRELigne'] as $id_generation) {
				$QuoteLines->NewQuoteLine($Id, $_POST['AddORDRELigne'][$i],  $_POST['AddARTICLELigne'][$i], $_POST['UpdateLABELLigne'][$i], $_POST['AddQTLigne'][$i], $_POST['AddUNITLigne'][$i], $_POST['AAddPrixLigne'][$i],$_POST['AddRemiseLigne'][$i], $_POST['AddTVALigne'][$i],$_POST['AddDELAISigne'][$i]);
				$i++;
			}
			$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddQuoteLineNotification')));
		}

		if(isset($_POST['UpdateIdLigne']) AND !empty($_POST['UpdateIdLigne'])){
			$i = 0;
			foreach ($_POST['UpdateIdLigne'] as $id) {
				$QuoteLines->UpdateQuoteLine($id, $_POST['UpdateORDRELigne'][$i],  $_POST['UpdateIDArticleLigne'][$i], $_POST['UpdateLABELLigneDevis'][$i], $_POST['UpdateQTLigne'][$i], $_POST['UpdateUNITLigne'][$i], $_POST['UpdatePrixLigne'][$i],$_POST['UpdateRemiseLigne'][$i], $_POST['UpdateTVALigne'][$i],$_POST['UpdateDELAISLigne'][$i],$_POST['UpdateETATLigne'][$i] );
				$i++;
			}
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateLineNotification')));
		}
	
		//Load data
		$Maindata= $Quote->GETQuote($Id);
	}

	$ListeArticleJava  ='"';
	$query="SELECT id, CODE, LABEL FROM ". TABLE_ERP_STANDARD_ARTICLE ."  WHERE VENDU=1 ORDER BY LABEL";
	foreach ($bdd->GetQuery($query) as $data){
		$ListeArticle  .= '<option  value="'. $data->CODE .'" >';
		$ListeArticleJava  .= '<option  value=\"'. $data->CODE .'\" >';
	}
	$ListeArticleJava  .='"';

	//Adtape default display from isset type
	if(isset($_GET['delete']) AND !empty($_GET['delete'])){
		$ParDefautDiv1 = '';
		$ParDefautDiv2 = '';
		$ParDefautDiv3 = 'id="defaultOpen"';
		$ImputButton = '<input type="submit" class="input-moyen" value="'. $langue->show_text('TableUpdateButton') .'" />';
		$actionForm = 'index.php?page=quote&quote='. $Id .'';

	}
	elseif(isset($_GET['quote']) AND !empty($_GET['quote'])){
		$ParDefautDiv1 = '';
		$ParDefautDiv2 = 'id="defaultOpen"';
		$ParDefautDiv3 = '';
		$ImputButton = '<input type="submit" class="input-moyen" value="'. $langue->show_text('TableUpdateButton') .'" />';
		$actionForm = 'index.php?page=quote&quote='. $Id .'';
		$titleOnglet1 = $langue->show_text('TableUpdateButton');

	}
	else{
		$ParDefautDiv3 = '';
		$ParDefautDiv2 = '';
		$ParDefautDiv1 = 'id="defaultOpen"';
		$VerrouInput = ' disabled="disabled"  Value="-" ';
		$ImputButton = $langue->show_text('TablenoQuote');
		$actionForm = 'index.php?page=quote&quote=new';
	}
?>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $(".add").click(function() {
        var AddORDRELigne = $("#AddORDRELigne").val();
        var AddARTICLELigne = $("#AddARTICLELigne").val();
		var AAddLABELLigne = $("#AAddLABELLigne").val();
		var AddQTLigne = $("#AddQTLigne").val();
		var AddUNITLigne = $("#AddUNITLigne").val();
		var AAddPrixLigne = $("#AAddPrixLigne").val();
		var AddRemiseLigne = $("#AddRemiseLigne").val();
		var AddTVALigne = $("#AddTVALigne").val();
		var AddDELAISigne = $("#AddDELAISigne").val();

		var TotalPrixLigne = (AddQTLigne*AAddPrixLigne)-(AddQTLigne*AAddPrixLigne)*(AddRemiseLigne/100);

		var ligne = "<tr>";
		var ligne = ligne + "<td><input type=\"checkbox\" name=\"select\"></td>";
		var ligne = ligne + "<td><input type=\"number\" name=\"AddORDRELigne[]\" value=\""+ AddORDRELigne +"\" id=\"number\" required=\"required\"></td>";
		var ligne = ligne + "<td><input list=\"Article\" name=\"AddARTICLELigne[]\" value=\"" + AddARTICLELigne +"\"><datalist id=\"Article\">";
		var ligne = ligne + <?= $ListeArticleJava ?> ;
		var ligne = ligne + "</datalist></td>";
		var ligne = ligne + "<td><input type=\"text\" name=\"AAddLABELLigne[]\" value=\""+ AAddLABELLigne +"\" ></td>";
		var ligne = ligne + "<td><input type=\"number\" name=\"AddQTLigne[]\" value=\""+ AddQTLigne +"\"  id=\"number\" required=\"required\"></td>";
		var ligne = ligne + "<td><input type=\"hidden\" name=\"AddUNITLigne[]\" value=\"" + AddUNITLigne + "\">-</td>";
		var ligne = ligne + "<td><input type=\"number\" name=\"AAddPrixLigne[]\" value=\""+ AAddPrixLigne +"\"  step=\".001\" id=\"number\" required=\"required\"></td>";
		var ligne = ligne + "<td><input type=\"number\" name=\"AddRemiseLigne[]\" value=\""+ AddRemiseLigne +"\" min=\"0\" max=\"100\" step=\".001\" id=\"number\" required=\"required\"></td>";
		var ligne = ligne + "<td>"+ TotalPrixLigne +" €</td>";
		var ligne = ligne + "<td><input type=\"hidden\" name=\"AddTVALigne[]\" value=\"" + AddTVALigne + "\">-</td>";
		var ligne = ligne + "<td><input type=\"date\" name=\"AddDELAISigne[]\"  value=\"" + AddDELAISigne+"\" required=\"required\"></td>";
		var ligne = ligne + "<td></td>";
		var ligne = ligne + "</tr>";
        $("table.content-table-devis").append(ligne);
    });
    $(".delete").click(function() {
        $("table.content-table").find('input[name="select"]').each(function() {
            if ($(this).is(":checked")) {
                $(this).parents("table.content-table tr").remove();
            }
        });
    });
});
</script>
	<div class="tab">
		<button class="tablinks" onclick="openDiv(event, 'div1')" <?=$ParDefautDiv1; ?>><?=$langue->show_text('Title1'); ?></button>
	<?php if(isset($_GET['quote']) AND !empty($_GET['quote'])){ ?>
		<button class="tablinks" onclick="openDiv(event, 'div2')" <?=$ParDefautDiv2; ?>><?=$langue->show_text('Title2'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div3')" <?=$ParDefautDiv3; ?>><?=$langue->show_text('Title3'); ?></button>
		<a href="document.php?id=<?= $_GET['quote'] ?>" target="_blank"><button class="tablinks" ><?=$langue->show_text('Title8'); ?></button></a>
		<button class="tablinks" onclick="openDiv(event, 'div8')"><?=$langue->show_text('Title9'); ?></button>
	<?php
	}
	else{?>
		<button class="tablinks" onclick="openDiv(event, 'div9')"><?=$langue->show_text('Title10'); ?></button>
	<?php
	}
	?>
	</div>
	<?php

	$reqList = $Quote->GETQuoteList('',false);
	$reqLines= $QuoteLines->GETQuoteLineList('', false, $Id);
	$GET = 'quote';
	$DocNum = 8;
	require '../pages/templates/main.php';


	//for converte QUOTE TO ORDER
	if(isset($_GET['quote']) && !empty($_GET['quote'])){?>
					
						<div id="div8" class="tabcontent">
							<form method="post" name="Coment" action="index.php?page=order&order=new" class="content-form" >	
									<div class="column">
										<table class="content-table" >
											<thead>
												<tr>
													<th colspan="9" >
														<?= $langue->show_text('TableNumberQuote') ?> <?= $CODE ?> <?= $langue->show_text('TableIndexQuote') ?>  <?= $INDICE ?>
													</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td></td>
													<td><?= $langue->show_text('TableLabel')?></td>
													<td><?= $langue->show_text('TableQty')?></td>
													<td><?= $langue->show_text('TableUnitPrice')?></td>
													<td><?= $langue->show_text('TableDiscount')?></td>
													<td><?= $langue->show_text('TableTotal')?></td>
													<td><?= $langue->show_text('TableDelay')?></td>
												</tr>
												<?= $LignePourCommande  ?>
											</tbody>
										</table>
									</div>
									<div class="column">
										<table class="content-table" >
											<thead>
												<tr>
													<th colspan="12" >
													<?= $langue->show_text('TableSelectOrder') ?>
												</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td><input type="radio" id="new" name="ADD_ORDER_FROM_QUOTE" value="new" checked="checked"><label for="new"><?= $langue->show_text('TableNewOrder') ?></label></td>
											</tr>
											<?php
											$query='SELECT '. TABLE_ERP_ORDER .'.id,
															'. TABLE_ERP_ORDER .'.CODE,
															'. TABLE_ERP_ORDER .'.LABEL,
															'. TABLE_ERP_CLIENT_FOUR .'.NAME
													FROM '. TABLE_ERP_ORDER .'
														LEFT JOIN `'. TABLE_ERP_CLIENT_FOUR .'` ON `'. TABLE_ERP_ORDER .'`.`CUSTOMER_ID` = `'. TABLE_ERP_CLIENT_FOUR .'`.`id`
													ORDER BY '. TABLE_ERP_ORDER .'.id';
											$i = 1;
											foreach ($bdd->GetQuery($query) as $data): ?>
											<tr>
												<td>
													<input type="radio" id="new<?= $data->id ?>" name="ADD_ORDER_FROM_QUOTE" value="<?= $data->id ?>"><label for="new<?= $data->id ?>"><?= $data->CODE ?> - <?= $data->NAME ?></label>
												</td>
											</tr>
											<?php $i++; endforeach; ?>
										</tbody>
									</table>
								</div>
								<div class="column">
									<table class="content-table" >
										<thead>
											<tr>
												<th colspan="12" >
												<?= $langue->show_text('TableGeneralInfo') ?>
												</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>
												<?= $Form->input('hidden', 'CUSTOMER_ID', $CUSTOMER_ID) ?>
													<?= $langue->show_text('TableCODE') ?> : <?= $Form->input('text', 'CODE',  $Numbering->getCodeNumbering(4)) ?>
												</td>
											</tr>
											<tr>
												<td>
													<input type="submit" class="input-moyen" value="<?= $langue->show_text('TableCreateOrder') ?>" />
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</form>
						</div>
		<?php
		}else{ 
			?>
			<div id="div9" class="tabcontent">
				<div class="column">
						<input type="text" id="myInput" onkeyup="myFunction()" placeholder="<?= $langue->show_text('TableFindQuote') ?>">
						<ul id="myUL">
							<?php
							//generate list for datalist find input
							foreach ($QuoteLines->GETQuoteLineList('',false, 0) as $data): ?>
							<li><a href="index.php?page=quote&quote=<?= $data->DEVIS_ID ?>"><?= $data->QUOTE_CODE ?> - <?= $data->ARTICLE_CODE ?>  <?= $data->LABEL ?></a></li>
							<?php $i++; endforeach; ?>
						</ul>
					</div>
				</div>
		<?php }
