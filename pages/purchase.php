<?php 
	//phpinfo();
	use \App\Autoloader;
	use \App\COMPANY\Employees;
	use \App\COMPANY\Numbering;
	use \App\Companies\Companies;
	use \App\Companies\Contact;
	use \App\Companies\Address;
	use \App\Accounting\VAT;
	use \App\Study\Unit;
	use \App\UI\Document;
	use \App\UI\Form;
	use \App\UI\UI;
	use \App\Planning\Task;
	use \App\Purchase\PurchaseRequest;
	use \App\Purchase\PurchaseRequestLines;
	use \App\Purchase\PurchaseOrder;
	use \App\Purchase\PurchaseOrderLines;
	use \App\Purchase\PurchaseDelivery;
	use \App\Purchase\PurchaseDeliveryLines;

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
	$VAT = new VAT();
	$Unit = new Unit();
	$Document = new Document();
	$UI = new UI();
	$Task = new Task();
	$PurchaseRequest = new PurchaseRequest();
	$PurchaseRequestLines = new PurchaseRequestLines();
	$PurchaseOrder = new PurchaseOrder();
	$PurchaseOrderLines = new PurchaseOrderLines();
	$PurchaseDelivery =  new PurchaseDelivery();
	$PurchaseDeliveryLines =  new PurchaseDeliveryLines();

	//Check if the user is authorized to view the page
	if($_SESSION['page_3'] != '1'){
		stop($langue->show_text('SystemInfoAccessDenied'), 161, 'index.php?page=login');
	}

	if(isset($_GET['PurchaseRequest']) AND !empty($_GET['PurchaseRequest'])){
		
		$Id = addslashes($_GET['PurchaseRequest']);

		//If user create new PurchaseRequest
		if(isset($_POST['COMPANY_ID']) And !empty($_POST['COMPANY_ID'])){
			$ParDefautDiv2 = 'id="defaultOpen"';
			//insert in DB new PurchaseRequest
			$Id = $PurchaseRequest->NewPurchaseRequest(addslashes($_POST['CODE']), addslashes($_POST['COMPANY_ID']), $User->idUSER);
			
			$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddPurchaseRequestNotification')));
			//update increment in num sequence db
			$Numbering->getIncrementNumbering(13);
		}
		elseif(isset($_POST['COMENT']) AND !empty($_POST['COMENT'])){
			//// COMMMENT ////
			$bdd->GetUpdatePOST(TABLE_ERP_PURCHASE_REQUEST, $_POST, 'WHERE id=\''. $Id .'\'');
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateCommentNotification')));
		}
		elseif(isset($_POST['BUYER_ID']) AND !empty($_POST['BUYER_ID'])){
			//// GENERAL UPDATE ////
			$BUYER_ID= $_POST['BUYER_ID'];

			if($_POST['BUYER_ID'] == 'null'){ $BUYER_ID = 0; }

			$bdd->GetUpdate("UPDATE  ". TABLE_ERP_PURCHASE_REQUEST ." SET 	BUYER_ID='". addslashes($BUYER_ID) ."' WHERE id='". $Id ."'");
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateGeneralNotification')));
		}
		elseif(isset($_POST['CODE']) AND !empty($_POST['CODE'])){
			//// GENERAL INFO  ////
			
			if(isset($_POST['MajLigne']) AND !empty($_POST['MajLigne'])){
				$bdd->GetUpdate("UPDATE  ". TABLE_ERP_PURCHASE_REQUEST_LINES ." SET ETAT='". addslashes($_POST['ETAT']) ."' WHERE PURCHASE_REQUEST_ID='". addslashes($Id)."'");
				$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateStatuLineNotification')));
			}
			unset($_POST['MajLigne']);
			$bdd->GetUpdatePOST(TABLE_ERP_PURCHASE_REQUEST, $_POST, 'WHERE id=\''. $Id .'\'');
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateGeneralInfoNotification')));
		}
		elseif(isset($_POST['CONTACT_ID']) AND !empty($_POST['CONTACT_ID'])){
			//// CLIENT INFO UPDATE ////
			$PostCONTACT_ID= $_POST['CONTACT_ID'];
			$PostADRESSE_ID = $_POST['ADRESSE_ID'];
	
			if($_POST['CONTACT_ID'] == 'null'){ $PostCONTACT_ID = 0; }
			if($_POST['ADRESSE_ID'] == 'null'){ $PostADRESSE_ID = 0; }
	
			$bdd->GetUpdate("UPDATE  ". TABLE_ERP_PURCHASE_REQUEST ." SET 	CONTACT_ID='". addslashes($PostCONTACT_ID) ."',
																	ADRESSE_ID='". addslashes($PostADRESSE_ID) ."'
																WHERE id='". $Id ."'");
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateInfoCustomerNotification')));
		}
		elseif(isset($_GET['delete']) AND !empty($_GET['delete'])){
			//// DELETE LIGNE ////
			$bdd->GetDelete("DELETE FROM ". TABLE_ERP_PURCHASE_REQUEST_LINES ." WHERE id='". addslashes($_GET['delete'])."'");

			$CallOutBox->add_notification(array('4', $i . $langue->show_text('DeleteQuoteLineNotification')));
		}
		elseif(isset($_POST['AddORDRELigne']) AND !empty($_POST['AddORDRELigne'])){
			//// AJOUT DE LIGNE  ////
			$i = 0;
			foreach ($_POST['AddORDRELigne'] as $id_generation) {
				
				$PurchaseRequestLines->NewPurchaseRequestLines($Id,   $_POST['AddTaskLigne'][$i], $_POST['AddARTICLELigne'][$i], $_POST['AddORDRELigne'][$i], $_POST['AddLABELLigne'][$i], $_POST['AddTechSpecifLigne'][$i], $_POST['AddQTLigne'][$i], $_POST['AddUNITLigne'][$i], $_POST['AAddPrixLigne'][$i],$_POST['AddRemiseLigne'][$i],1);
				$i++;
			}
			$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddQuoteLineNotification')));
		}

		if(isset($_POST['UpdateIdLigne']) AND !empty($_POST['UpdateIdLigne'])){
			$i = 0;
			foreach ($_POST['UpdateIdLigne'] as $id) {
				$PurchaseRequestLines->UpdatePurchaseRequestLines($id, $_POST['UpdateIdTaskLigne'][$i],  $_POST['UpdateIDArticleLigne'][$i], $_POST['UpdateORDRELigne'][$i],  $_POST['UpdateLABELLigne'][$i], $_POST['UpdateTechSpecifLigne'][$i], $_POST['UpdateQTLigne'][$i], $_POST['UpdateUNITLigne'][$i], $_POST['UpdatePrixLigne'][$i],$_POST['UpdateRemiseLigne'][$i], $_POST['UpdateETATLigne'][$i] );
				$i++;
			}
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateLineNotification')));
		}

		//Load data
		$Maindata= $PurchaseRequest->GETPurchaseRequest($Id);
	}
	elseif(isset($_GET['PurchaseOrder']) AND !empty($_GET['PurchaseOrder'])){
		
		$Id = addslashes($_GET['PurchaseOrder']);

		//If user create new PurchaseOrder
		if(isset($_POST['COMPANY_ID']) And !empty($_POST['COMPANY_ID'])){
			$ParDefautDiv2 = 'id="defaultOpen"';
			//insert in DB new PurchaseOrder
			
			$Id = $PurchaseOrder->NewPurchaseOrder(addslashes($_POST['CODE']), addslashes($_POST['COMPANY_ID']), $User->idUSER);
			$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddPurchaseOrderNotification')));
			//update increment in num sequence db
			$Numbering->getIncrementNumbering(5);
		}
		elseif(isset($_POST['COMENT']) AND !empty($_POST['COMENT'])){
			//// COMMMENT ////
			$bdd->GetUpdatePOST(TABLE_ERP_PURCHASE_ORDER, $_POST, 'WHERE id=\''. $Id .'\'');
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateCommentNotification')));
		}
		elseif(isset($_POST['BUYER_ID']) AND !empty($_POST['BUYER_ID'])){
			//// GENERAL UPDATE ////
			$BUYER_ID= $_POST['BUYER_ID'];

			if($_POST['BUYER_ID'] == 'null'){ $BUYER_ID = 0; }

			$bdd->GetUpdate("UPDATE  ". TABLE_ERP_PURCHASE_ORDER ." SET 	BUYER_ID='". addslashes($BUYER_ID) ."' WHERE id='". $Id ."'");
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateGeneralNotification')));
		}
		elseif(isset($_POST['CODE']) AND !empty($_POST['CODE'])){
			//// GENERAL INFO  ////
			
			if(isset($_POST['MajLigne']) AND !empty($_POST['MajLigne'])){
				$bdd->GetUpdate("UPDATE  ". TABLE_ERP_PURCHASE_ORDER_LINES ." SET ETAT='". addslashes($_POST['ETAT']) ."' WHERE PURCHASE_ORDER_ID='". addslashes($Id)."'");
				$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateStatuLineNotification')));
			}
			unset($_POST['MajLigne']);
			$bdd->GetUpdatePOST(TABLE_ERP_PURCHASE_ORDER, $_POST, 'WHERE id=\''. $Id .'\'');
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateGeneralInfoNotification')));
		}
		elseif(isset($_POST['CONTACT_ID']) AND !empty($_POST['CONTACT_ID'])){
			//// CLIENT INFO UPDATE ////
			$PostCONTACT_ID= $_POST['CONTACT_ID'];
			$PostADRESSE_ID = $_POST['ADRESSE_ID'];
	
			if($_POST['CONTACT_ID'] == 'null'){ $PostCONTACT_ID = 0; }
			if($_POST['ADRESSE_ID'] == 'null'){ $PostADRESSE_ID = 0; }
	
			$bdd->GetUpdate("UPDATE  ". TABLE_ERP_PURCHASE_ORDER ." SET 	CONTACT_ID='". addslashes($PostCONTACT_ID) ."',
																	ADRESSE_ID='". addslashes($PostADRESSE_ID) ."'
																WHERE id='". $Id ."'");
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateInfoCustomerNotification')));
		}
		elseif(isset($_GET['delete']) AND !empty($_GET['delete'])){
			//// DELETE LIGNE ////
			$bdd->GetDelete("DELETE FROM ". TABLE_ERP_PURCHASE_ORDER_LINES ." WHERE id='". addslashes($_GET['delete'])."'");

			$CallOutBox->add_notification(array('4', $i . $langue->show_text('DeleteQuoteLineNotification')));
		}
		elseif(isset($_POST['AddORDRELigne']) AND !empty($_POST['AddORDRELigne'])){
			//// AJOUT DE LIGNE  ////
			$i = 0;
			foreach ($_POST['AddORDRELigne'] as $id_generation) {
				
				$PurchaseOrderLines->NewPurchaseOrderLines($Id,   $_POST['AddTaskLigne'][$i], $_POST['AddARTICLELigne'][$i], $_POST['AddORDRELigne'][$i], $_POST['AddLABELLigne'][$i], $_POST['AddTechSpecifLigne'][$i], $_POST['AddQTLigne'][$i], $_POST['AddUNITLigne'][$i], $_POST['AAddPrixLigne'][$i],$_POST['AddRemiseLigne'][$i],1);
				$i++;
			}
			$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddQuoteLineNotification')));
		}

		if(isset($_POST['UpdateIdLigne']) AND !empty($_POST['UpdateIdLigne'])){
			$i = 0;
			foreach ($_POST['UpdateIdLigne'] as $id) {
				$PurchaseOrderLines->UpdatePurchaseOrderLines($id, $_POST['UpdateIdTaskLigne'][$i],  $_POST['UpdateIDArticleLigne'][$i], $_POST['UpdateORDRELigne'][$i],  $_POST['UpdateLABELLigne'][$i], $_POST['UpdateTechSpecifLigne'][$i], $_POST['UpdateQTLigne'][$i], $_POST['UpdateUNITLigne'][$i], $_POST['UpdatePrixLigne'][$i],$_POST['UpdateRemiseLigne'][$i], $_POST['UpdateETATLigne'][$i] );
				$i++;
			}
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateLineNotification')));
		}

		//Load data
		$Maindata= $PurchaseOrder->GETPurchaseOrder($Id);
	}
	elseif(isset($_GET['PurchaseDelivery']) AND !empty($_GET['PurchaseDelivery'])){
		
		$Id = addslashes($_GET['PurchaseDelivery']);

		//If user create new PurchaseDelivery
		if(isset($_POST['COMPANY_ID']) And !empty($_POST['COMPANY_ID'])){
			$ParDefautDiv2 = 'id="defaultOpen"';
			//insert in DB new PurchaseDelivery
			
			$Id = $PurchaseDelivery->NewPurchaseDelivery(addslashes($_POST['CODE']), addslashes($_POST['COMPANY_ID']), $User->idUSER);
			$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddPurchaseDeliveryNotification')));
			//update increment in num sequence db
			$Numbering->getIncrementNumbering(5);
		}
		elseif(isset($_POST['COMENT']) AND !empty($_POST['COMENT'])){
			//// COMMMENT ////
			$bdd->GetUpdatePOST(TABLE_ERP_PURCHASE_DELIVERY_NOTE, $_POST, 'WHERE id=\''. $Id .'\'');
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateCommentNotification')));
		}
		elseif(isset($_POST['BUYER_ID']) AND !empty($_POST['BUYER_ID'])){
			//// GENERAL UPDATE ////
			$BUYER_ID= $_POST['BUYER_ID'];

			if($_POST['BUYER_ID'] == 'null'){ $BUYER_ID = 0; }

			$bdd->GetUpdate("UPDATE  ". TABLE_ERP_PURCHASE_DELIVERY_NOTE ." SET 	BUYER_ID='". addslashes($BUYER_ID) ."' WHERE id='". $Id ."'");
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateGeneralNotification')));
		}
		elseif(isset($_POST['CODE']) AND !empty($_POST['CODE'])){
			//// GENERAL INFO  ////
			
			if(isset($_POST['MajLigne']) AND !empty($_POST['MajLigne'])){
				$bdd->GetUpdate("UPDATE  ". TABLE_ERP_PURCHASE_DELIVERY_NOTE_LINES ." SET ETAT='". addslashes($_POST['ETAT']) ."' WHERE PURCHASE_ORDER_ID='". addslashes($Id)."'");
				$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateStatuLineNotification')));
			}
			unset($_POST['MajLigne']);
			$bdd->GetUpdatePOST(TABLE_ERP_PURCHASE_DELIVERY_NOTE, $_POST, 'WHERE id=\''. $Id .'\'');
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateGeneralInfoNotification')));
		}
		elseif(isset($_POST['CONTACT_ID']) AND !empty($_POST['CONTACT_ID'])){
			//// CLIENT INFO UPDATE ////
			$PostCONTACT_ID= $_POST['CONTACT_ID'];
			$PostADRESSE_ID = $_POST['ADRESSE_ID'];
	
			if($_POST['CONTACT_ID'] == 'null'){ $PostCONTACT_ID = 0; }
			if($_POST['ADRESSE_ID'] == 'null'){ $PostADRESSE_ID = 0; }
	
			$bdd->GetUpdate("UPDATE  ". TABLE_ERP_PURCHASE_DELIVERY_NOTE ." SET 	CONTACT_ID='". addslashes($PostCONTACT_ID) ."',
																	ADRESSE_ID='". addslashes($PostADRESSE_ID) ."'
																WHERE id='". $Id ."'");
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateInfoCustomerNotification')));
		}
		elseif(isset($_GET['delete']) AND !empty($_GET['delete'])){
			//// DELETE LIGNE ////
			$bdd->GetDelete("DELETE FROM ". TABLE_ERP_PURCHASE_DELIVERY_NOTE_LINES ." WHERE id='". addslashes($_GET['delete'])."'");

			$CallOutBox->add_notification(array('4', $i . $langue->show_text('DeleteQuoteLineNotification')));
		}
		elseif(isset($_POST['AddORDRELigne']) AND !empty($_POST['AddORDRELigne'])){
			//// AJOUT DE LIGNE  ////
			$i = 0;
			foreach ($_POST['AddORDRELigne'] as $id_generation) {
				
				$PurchaseDeliveryLines->NewPurchaseDeliveryLines($Id,   $_POST['AddTaskLigne'][$i], $_POST['AddARTICLELigne'][$i], $_POST['AddORDRELigne'][$i], $_POST['AddLABELLigne'][$i], $_POST['AddTechSpecifLigne'][$i], $_POST['AddQTLigne'][$i], $_POST['AddUNITLigne'][$i], $_POST['AAddPrixLigne'][$i],$_POST['AddRemiseLigne'][$i],1);
				$i++;
			}
			$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddQuoteLineNotification')));
		}

		if(isset($_POST['UpdateIdLigne']) AND !empty($_POST['UpdateIdLigne'])){
			$i = 0;
			foreach ($_POST['UpdateIdLigne'] as $id) {
				$PurchaseDeliveryLines->UpdatePurchaseDeliveryLines($id, $_POST['UpdateIdTaskLigne'][$i],  $_POST['UpdateIDArticleLigne'][$i], $_POST['UpdateORDRELigne'][$i],  $_POST['UpdateLABELLigne'][$i], $_POST['UpdateTechSpecifLigne'][$i], $_POST['UpdateQTLigne'][$i], $_POST['UpdateUNITLigne'][$i], $_POST['UpdatePrixLigne'][$i],$_POST['UpdateRemiseLigne'][$i], $_POST['UpdateETATLigne'][$i] );
				$i++;
			}
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateLineNotification')));
		}

		//Load data
		$Maindata= $PurchaseDelivery->GETPurchaseDelivery($Id);
	}

	$ListeArticleJava  ='"';
	$query="SELECT id, CODE, LABEL FROM ". TABLE_ERP_STANDARD_ARTICLE ."  WHERE VENDU=1 ORDER BY LABEL";
	foreach ($bdd->GetQuery($query) as $data){
		$ListeArticle  .= '<option  value="'. $data->CODE .'" >';
		$ListeArticleJava  .= '<option  value=\"'. $data->CODE .'\" >';
	}

	$ListeArticleJava  .='"';
	$ParDefautDiv1 = 'id="defaultOpen"';
	$ParDefautDiv2 = '';
	$ParDefautDiv3 = '';
	$ActivateForm=false;
	$GET = 'PurchaseRequest';

	if(isset($_GET['PurchaseRequest']) AND !empty($_GET['PurchaseRequest'])){
		$ActivateForm=true;
		$reqLines = $PurchaseRequestLines->GETPurchaseRequestlinesList('', false, $Id);
		$actionForm = 'index.php?page=purchase&PurchaseRequest='. $Id  .'';
		$DocumentType = 'PURCHASE_REQUEST_ID';
	}
	elseif(isset($_GET['PurchaseOrder']) AND !empty($_GET['PurchaseOrder'])){
		$ActivateForm=true;
		$reqLines = $PurchaseOrderLines->GETPurchaseOrderLinesList('', false, $Id);
		$actionForm = 'index.php?page=purchase&PurchaseOrder='. $Id  .'';
		$DocumentType = 'PURCHASE_ORDER_ID';
		$GET = 'PurchaseOrder';
	}
	elseif(isset($_GET['PurchaseDelivery']) AND !empty($_GET['PurchaseDelivery'])){
		$ActivateForm=true;
		$reqLines = $PurchaseDeliveryLines->GETPurchaseDeliveryLinesList('', false, $Id);
		$actionForm = 'index.php?page=purchase&PurchaseDelivery='. $Id  .'';
		$DocumentType = 'PURCHASE_DELIVERY_NOTE_ID';
		$GET = 'PurchaseDelivery';
	}
?>
	<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function() {
		$(".add").click(function() {
			var AddORDRELigne = $("#AddORDRELigne").val();
			var AddTaskLigne = $("#AddTaskLigne").val();
			var AddARTICLELigne = $("#AddARTICLELigne").val();
			var AddLABELLigne = $("#AddLABELLigne").val();
			var AddTechSpecifLigne = $("#AddTechSpecifLigne").val();
			
			var AddQTLigne = $("#AddQTLigne").val();
			var AddUNITLigne = $("#AddUNITLigne").val();
			var AAddPrixLigne = $("#AAddPrixLigne").val();
			var AddRemiseLigne = $("#AddRemiseLigne").val();

			var TotalPrixLigne = (AddQTLigne*AAddPrixLigne)-(AddQTLigne*AAddPrixLigne)*(AddRemiseLigne/100);
				
			var ligne = "<tr>";
			var ligne = ligne + "<td><input type=\"checkbox\" name=\"select\"></td>";
			var ligne = ligne + "<td><input type=\"number\" name=\"AddORDRELigne[]\" value=\""+ AddORDRELigne +"\" id=\"number\" required=\"required\"></td>";
			var ligne = ligne + "<td><input list=\"Task\" name=\"AddTaskLigne[]\" value=\"" + AddTaskLigne +"\"><datalist id=\"Task\">";
			var ligne = ligne + <?= $ListeArticleJava ?> ;
			var ligne = ligne + "</datalist></td>";
			var ligne = ligne + "<td><input list=\"Article\" name=\"AddARTICLELigne[]\" value=\"" + AddARTICLELigne +"\"><datalist id=\"Article\">";
			var ligne = ligne + <?= $ListeArticleJava ?> ;
			var ligne = ligne + "</datalist></td>";
			var ligne = ligne + "<td><input type=\"text\" name=\"AddLABELLigne[]\" value=\""+ AddLABELLigne +"\" ></td>";
			var ligne = ligne + "<td><input type=\"text\" name=\"AddTechSpecifLigne[]\" value=\""+ AddTechSpecifLigne +"\" ></td>";
			var ligne = ligne + "<td><input type=\"number\" name=\"AddQTLigne[]\" value=\""+ AddQTLigne +"\"  id=\"number\" required=\"required\"></td>";
			var ligne = ligne + "<td><input type=\"hidden\" name=\"AddUNITLigne[]\" value=\"" + AddUNITLigne + "\">-</td>";
			var ligne = ligne + "<td><input type=\"number\" name=\"AAddPrixLigne[]\" value=\""+ AAddPrixLigne +"\"  step=\".001\" id=\"number\" required=\"required\"></td>";
			var ligne = ligne + "<td><input type=\"number\" name=\"AddRemiseLigne[]\" value=\""+ AddRemiseLigne +"\" min=\"0\" max=\"100\" step=\".001\" id=\"number\" required=\"required\"></td>";
			var ligne = ligne + "<td>"+ TotalPrixLigne +" €</td>";
			var ligne = ligne + "<td></td>";
			var ligne = ligne + "</tr>";
			$("table.content-table-Adding").append(ligne);
		});
		$(".delete").click(function() {
			$("table.content-table-Adding").find('input[name="select"]').each(function() {
				if ($(this).is(":checked")) {
					$(this).parents("table.content-table-Adding tr").remove();
				}
			});
		});
	});
	</script>
	<div class="tab">		
	<?php if(isset($_GET['PurchaseRequest']) AND !empty($_GET['PurchaseRequest'])){ ?>
		<button class="tablinks" onclick="window.location.href = 'http://localhost/erp/public/index.php?page=purchase';"><?=$langue->show_text('Title1back'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div1')" <?=$ParDefautDiv1; ?>><?=$langue->show_text('Title2'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div2')" <?=$ParDefautDiv2; ?>><?=$langue->show_text('Title3'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div3')" <?=$ParDefautDiv3; ?>><?=$langue->show_text('Title4'); ?></button>
		<a href="index.php?page=document$type=PurchaseRequest&id=<?= $_GET['id'] ?>" target="_blank"><button class="tablinks" ><?=$langue->show_text('Title5'); ?></button></a>	
	<?php } elseif(isset($_GET['PurchaseOrder']) AND !empty($_GET['PurchaseOrder'])){?>
		<button class="tablinks" onclick="window.location.href = 'http://localhost/erp/public/index.php?page=purchase';"><?=$langue->show_text('Title1back'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div1')" <?=$ParDefautDiv1; ?>><?=$langue->show_text('Title6'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div2')" <?=$ParDefautDiv2; ?>><?=$langue->show_text('Title3'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div3')" <?=$ParDefautDiv3; ?>><?=$langue->show_text('Title4'); ?></button>
		<a href="index.php?page=document$type=PurchaseOrder&id=<?= $_GET['id'] ?>" target="_blank"><button class="tablinks" ><?=$langue->show_text('Title5'); ?></button></a>
	<?php } elseif(isset($_GET['PurchaseDelivery']) AND !empty($_GET['PurchaseDelivery'])){?>
		<button class="tablinks" onclick="window.location.href = 'http://localhost/erp/public/index.php?page=purchase';"><?=$langue->show_text('Title1back'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div1')" <?=$ParDefautDiv1; ?>><?=$langue->show_text('Title8'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div2')" <?=$ParDefautDiv2; ?>><?=$langue->show_text('Title3'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div3')" <?=$ParDefautDiv3; ?>><?=$langue->show_text('Title4'); ?></button>
		<a href="index.php?page=document$type=PurchaseDelivery&id=<?= $_GET['id'] ?>" target="_blank"><button class="tablinks" ><?=$langue->show_text('Title5'); ?></button></a>
	<?php } elseif(isset($_GET['SupplierInvoice']) AND !empty($_GET['SupplierInvoice'])){?>
		<button class="tablinks" onclick="window.location.href = 'http://localhost/erp/public/index.php?page=purchase';"><?=$langue->show_text('Title1back'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div1')" <?=$ParDefautDiv1; ?>><?=$langue->show_text('Title9'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div2')" <?=$ParDefautDiv2; ?>><?=$langue->show_text('Title3'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div3')" <?=$ParDefautDiv3; ?>><?=$langue->show_text('Title4'); ?></button>
		<a href="index.php?page=document$type=SupplierInvoice&id=<?= $_GET['id'] ?>" target="_blank"><button class="tablinks" ><?=$langue->show_text('Title5'); ?></button></a>
	<?php }else{ ?>
		<button class="tablinks" onclick="openDiv(event, 'div1')" id="defaultOpen"><?=$langue->show_text('Title2'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div2')" ><?=$langue->show_text('Title6'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div3')" ><?=$langue->show_text('Title10'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div4')" ><?=$langue->show_text('Title8'); ?></button>

	<?php } ?>
	</div>
	<?php
		if(isset($_GET[$GET]) AND !empty($_GET[$GET])){ 
			require '../pages/templates/MainPurchases.php';
		}
		else{
	?>
	<!-- Start list purchase or new purchase -->
	<div id="div1" class="tabcontent" >
		<div class="row">
			<div class="column-menu">
				<?php echo $UI->GetSearchMenu($PurchaseRequest->GETPurchaseRequestList('',false, 0), 'index.php?page=purchase&PurchaseRequest', $langue->show_text('TableFindPurchaseRequest') ); ?>
			</div>
			<div class="column">
				<form method="POST" name="purchase" action="index.php?page=<?= $_GET['page'] ?>&PurchaseRequest=new" class="content-form" >
					<?php $UI->GetNewDocument($langue->show_text('TableNew'), $langue->show_text('TableNumber'), $Companies->GetCustomerList(), $Form->input('text', 'CODE',  $Numbering->getCodeNumbering(13)), $Form->submit($langue->show_text('TableNewButton'))); ?>
				</form>
			</div>
		</div>
	</div>
	<!-- end list purchase or new purchase -->
	<!-- Start list Purchase order -->
	<div id="div2" class="tabcontent" >
		<div class="row">
			<div class="column-menu">
				<?php echo $UI->GetSearchMenu($PurchaseOrder->GETPurchaseOrderList('',false, 0), 'index.php?page=purchase&PurchaseOrder', $langue->show_text('TableFindPurchaseOrder') ); ?>
			</div>
			<div class="column">
				<form method="POST" name="purchase" action="index.php?page=<?= $_GET['page'] ?>&PurchaseOrder=new" class="content-form" >
					<?php $UI->GetNewDocument($langue->show_text('TableNew'), $langue->show_text('TableNumber'), $Companies->GetCustomerList(), $Form->input('text', 'CODE',  $Numbering->getCodeNumbering(5)), $Form->submit($langue->show_text('TableNewButton'))); ?>
				</form>
			</div>
		</div>
	</div>
	<!-- End list Purchase order -->
	<!-- Start list Supplier reception -->
	<div id="div3" class="tabcontent" >
		<div class="row">
			<div class="column-menu">
				<?php  echo $UI->GetSearchMenu($PurchaseDelivery->GETPurchaseDeliveryList('',false, 0), 'index.php?page=purchase&PurchaseDelivery', $langue->show_text('TableFindPurchaseOrder') ); ?>
			</div>
			<div class="column">
				<form method="POST" name="purchase" action="index.php?page=<?= $_GET['page'] ?>&PurchaseDelivery=new" class="content-form" >
					<?php  $UI->GetNewDocument($langue->show_text('TableNew'), $langue->show_text('TableNumber'), $Companies->GetCustomerList(), $Form->input('text', 'CODE',  $Numbering->getCodeNumbering(1)), $Form->submit($langue->show_text('TableNewButton'))); ?>
				</form>
			</div>
		</div>
	</div>
	<!-- End list Supplier reception -->
	<!-- Start list Invoice -->
	<div id="div4" class="tabcontent" >
	</div>
	<!-- End list Invoice -->
	<?php 
	}