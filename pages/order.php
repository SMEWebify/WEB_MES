<?php
	//phpinfo();
	use \App\Autoloader;
	use \App\COMPANY\Employees;
	use \App\COMPANY\Numbering;
	use \App\Companies\Companies;
	use \App\Companies\Contact;
	use \App\Companies\Address;
	use \App\Accounting\PaymentMethod;
	use \App\Accounting\PaymentCondition;
	use \App\Accounting\PaymentSchedule;
	use \App\Order\Order;
	use \App\Order\OrderLines;
	use \App\Order\OrderAcknowledgment;
	use \App\Order\OrderAcknowledgmentLines;
	use \App\Order\DeleveryNote;
	use \App\Order\DeleveryNoteLines;
	use \App\Order\InvoiceOrder;
	use \App\Order\InvoiceOrderLines;
	use \App\Accounting\Delevery;
	use \App\Accounting\VAT;
	use \App\Study\Unit;
	use \App\UI\Document;
	use \App\UI\Form;

	//auto load class
	require_once '../app/Autoload.class.php';
	Autoloader::register();

	session_start();
	header( 'content-type: text/html; charset=utf-8' );
	//init class
	$Form = new Form($_POST);
	$Employees = new Employees();
	$Numbering = new Numbering();
	$Companies = new Companies();
	$Contact =  new Contact();
	$Address = new Address();
	$PaymentMethod = new PaymentMethod();
	$PaymentCondition = new PaymentCondition();
	$PaymentSchedule = new PaymentSchedule();
	$Order = new Order();
	$OrderLines = new OrderLines();
	$OrderAcknowledgment = new OrderAcknowledgment();
	$OrderAcknowledgmentLines = new OrderAcknowledgmentLines();
	$DeleveryNote = new DeleveryNote();
	$DeleveryNoteLines = new DeleveryNoteLines();
	$InvoiceOrder = new InvoiceOrder();
	$InvoiceOrderLines = new InvoiceOrderLines();
	$Delevery = new Delevery();
	$VAT = new VAT();
	$Unit = new Unit();
	$Document = new Document();

	//Check if the user is authorized to view the page
	if($_SESSION['page_5'] != '1'){
		stop($langue->show_text('SystemInfoAccessDenied'), 161, 'index.php?page=login');
	}
	
	if(isset($_GET['order']) AND !empty($_GET['order'])){

		$Id = addslashes($_GET['order']);
		
		if(isset($_POST['ADD_ORDER_FROM_QUOTE']) And !empty($_POST['ADD_ORDER_FROM_QUOTE'])){
			//If user create new order from quote
			$ParDefautDiv2 = 'id="defaultOpen"';
			$Id = $_POST['ADD_ORDER_FROM_QUOTE'];
			if($_POST['ADD_ORDER_FROM_QUOTE'] === 'new'){ 
			//insert in DB new order
				$Id = $Order->NewOrder(addslashes($_POST['CODE']), '',addslashes($_POST['CUSTOMER_ID']), 0 , 0 , 0 , $User->idUSER, 0 ,0 ,9 ,5 ,0 ,0,0);
				$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddOrderNotification')));
				//update increment in num sequence db
				$Numbering->getIncrementNumbering(4);
			}

			if($_POST['ADD_ORDER_FROM_QUOTE'] != 'new') $Id = $_POST['ADD_ORDER_FROM_QUOTE'];
			//If add line with new order from quote line
			
			$i=0;
			foreach ($_POST['ADD_ORDER_LINE'] as $id_generation) {
				$OrderLines->NewOrderLineFromQuote($Id,$id_generation, $User->idUSER);
				$bdd->GetUpdatePOST(TABLE_ERP_QUOTE_LIGNE, array("ETAT"=>3), 'WHERE id=\''. $id_generation .'\'');
				$i++;
			}

			$bdd->GetUpdatePOST(TABLE_ERP_QUOTE, array("ETAT"=>3), 'WHERE id=\''. $_POST['QUOTE_ID'] .'\'');

			$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddOrderLineNotification')));
		}
		elseif(isset($_POST['CUSTOMER_ID']) And !empty($_POST['CUSTOMER_ID'])){
			//If user create new order
			$ParDefautDiv2 = 'id="defaultOpen"';
			//insert in DB new order
			$Id = $Order->NewOrder(addslashes($_POST['CODE']), '',addslashes($_POST['CUSTOMER_ID']), 0 , 0 , 0 , $User->idUSER, 0 ,0 ,9 ,5 ,0 ,0,0);
			$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddOrderNotification')));
			//update increment in num sequence db
			$Numbering->getIncrementNumbering(4);
		}
		elseif(isset($_POST['COMENT']) AND !empty($_POST['COMENT'])){
			//// COMMMENT ////
			$bdd->GetUpdatePOST(TABLE_ERP_ORDER, $_POST, 'WHERE id=\''. $Id .'\'');
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateCommentNotification')));
		}
		elseif(isset($_POST['RESP_COM_ID']) AND !empty($_POST['RESP_COM_ID'])){
			//// GENERAL UPDATE ////
			$PostRESP_COM_ID= $_POST['RESP_COM_ID'];
			$PostRESP_TECH_ID = $_POST['RESP_TECH_ID'];

			if($_POST['RESP_COM_ID'] == 'null'){ $PostRESP_COM_ID = 0; }
			if($_POST['RESP_TECH_ID'] == 'null'){ $PostRESP_TECH_ID = 0; }

			$bdd->GetUpdate("UPDATE  ". TABLE_ERP_ORDER ." SET 	RESP_COM_ID='". addslashes($PostRESP_COM_ID) ."',
																RESP_TECH_ID='". addslashes($PostRESP_TECH_ID) ."'
																WHERE id='". $Id ."'");
			

			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateGeneralNotification')));
		}
		elseif(isset($_POST['CODE']) AND !empty($_POST['CODE'])){
			//// DETAIL UPDATE ORDER  ////
			
			if(isset($_POST['MajLigne']) AND !empty($_POST['MajLigne'])){
	
				$bdd->GetUpdate("UPDATE  ". TABLE_ERP_ORDER_LIGNE ." SET ETAT='". addslashes($_POST['ETAT']) ."'
																WHERE 	ORDER_ID='". $Id ."'");

				$bdd->GetUpdate("UPDATE  ". TABLE_ERP_TASK ." 
										LEFT JOIN `". TABLE_ERP_ORDER_LIGNE ."` ON `". TABLE_ERP_ORDER_LIGNE ."`.`id` = `". TABLE_ERP_TASK ."`.`ORDER_LINE_ID`
											SET ". TABLE_ERP_TASK .".ETAT='". addslashes($_POST['ETAT']) ."'
										WHERE 	". TABLE_ERP_ORDER_LIGNE .".ORDER_ID='". $Id ."'");

				$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateStatuLineNotification')));
			}
			unset($_POST['MajLigne']);
		
			$bdd->GetUpdatePOST(TABLE_ERP_ORDER, $_POST, 'WHERE id=\''. $Id .'\'');
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

			$bdd->GetUpdate("UPDATE  ". TABLE_ERP_ORDER ." SET 	CONTACT_ID='". addslashes($PostCONTACT_ID) ."',
																	ADRESSE_ID='". addslashes($PostADRESSE_ID) ."',
																	FACTURATION_ID='". addslashes($PostFACTURATION_ID) ."'
																WHERE id='". $Id ."'");
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateInfoCustomerNotification')));
		}
		elseif(isset($_POST['COND_REG_CUSTOMER_ID']) AND !empty($_POST['COND_REG_CUSTOMER_ID'])){
			//// COMMERCIAL UPDATE ////
			$bdd->GetUpdatePOST(TABLE_ERP_ORDER, $_POST, 'WHERE id=\''. $Id .'\'');
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateSalesInfoNotification')));
		}
		elseif(isset($_GET['delete']) AND !empty($_GET['delete'])){
			//// DELETE LIGNE ////
			$bdd->GetDelete("DELETE FROM ". TABLE_ERP_ORDER_LIGNE ." WHERE id='". addslashes($_GET['delete'])."'");
			$bdd->GetDelete("DELETE FROM ". TABLE_ERP_ORDER_ACKNOWLEGMENT_LINES ." WHERE ORDER_LINE_ID='". addslashes($_GET['delete'])."'");
			$bdd->GetDelete("DELETE FROM ". TABLE_ERP_TASK ." WHERE ORDER_LINE_ID='". addslashes($_GET['delete'])."'");
			$bdd->GetDelete("DELETE FROM ". TABLE_ERP_ORDER_SUB_ASSEMBLY ." WHERE PARENT_ID='". addslashes($_GET['delete'])."'");

			$CallOutBox->add_notification(array('4', $i . $langue->show_text('DeleteOrderLineNotification')));
			$CallOutBox->add_notification(array('4', $i . $langue->show_text('DeleteOrderAcknowledgmentLinesNotification')));
		}
		elseif(isset($_POST['AddORDRELigne']) AND !empty($_POST['AddORDRELigne'])){
			//// AJOUT DE LIGNE  ////
			$i = 0;
			foreach ($_POST['AddORDRELigne'] as $id_generation) {
				$OrderLines->NewOrderLine($Id, $_POST['AddORDRELigne'][$i],  $_POST['AddARTICLELigne'][$i], $_POST['AddLABELLigne'][$i], $_POST['AddQTLigne'][$i], $_POST['AddUNITLigne'][$i], $_POST['AAddPrixLigne'][$i],$_POST['AddRemiseLigne'][$i], $_POST['AddTVALigne'][$i],$_POST['AddDELAISigne'][$i], $id_generation);
				$i++;
			}
			$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddOrderLineNotification')));
		}

		if(isset($_POST['UpdateIdLigne']) AND !empty($_POST['UpdateIdLigne'])){
			$i = 0;
			foreach ($_POST['UpdateIdLigne'] as $id) {
				$OrderLines->UpdateOrderLine($id, $_POST['UpdateORDRELigne'][$i],  $_POST['UpdateIDArticleLigne'][$i], $_POST['UpdateLABELLigne'][$i], $_POST['UpdateQTLigne'][$i], $_POST['UpdateUNITLigne'][$i], $_POST['UpdatePrixLigne'][$i],$_POST['UpdateRemiseLigne'][$i], $_POST['UpdateTVALigne'][$i],$_POST['UpdateDELAISLigne'][$i],$_POST['UpdateETATLigne'][$i] );
				$i++;
			}
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateLineNotification')));
		}

		//Load data
		$Maindata= $Order->GETOrder($Id);
	}
	elseif(isset($_GET['OrderAcknowledgment']) AND !empty($_GET['OrderAcknowledgment'])){
		$Id = addslashes($_GET['OrderAcknowledgment']);

		//If user create new Order Acknowledgment
		if(isset($_POST['NewOrderAcknowledgment']) And !empty($_POST['NewOrderAcknowledgment'])){
			// Create new Order Acknowledgment and keep id
			$Id=$OrderAcknowledgment->NewOrderAcknowledgment($_POST['NewOrderAcknowledgment'], $_POST['ORDER_ID'], $User->idUSER);
			//update increment in num sequence db
			$Numbering->getIncrementNumbering(12);
			$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddOrderAcknowledgmentNotification')));
			$i=0;
			//Select line who dont have an OA
			foreach ($OrderLines->GETOrderLineList(0, false, $_POST['ORDER_ID'], ' AND AR=0') as $data){	
				//Create OA line
				$OrderAcknowledgmentLines->NewOrderacknowledgmentlines($Id, $_POST['ORDER_ID'], $data->ORDRE, $data->id);
				//update order line
				$bdd->GetUpdatePOST(TABLE_ERP_ORDER_LIGNE, array("AR"=>1), 'WHERE id=\''. $data->id .'\'');
				$i++;
			}
			$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddOrderAcknowledgmentLinesNotification')));
		}
		elseif(isset($_POST['CODE']) AND !empty($_POST['CODE'])){
			//// ORDER ACKNOWLEGMENT DETAIL UPDATE ////
			
			if(isset($_POST['MajLigne']) AND !empty($_POST['MajLigne'])){
	
				$bdd->GetUpdate("UPDATE  ". TABLE_ERP_ORDER_ACKNOWLEGMENT_LINES ." SET ETAT='". addslashes($_POST['ETAT']) ."'
																WHERE 	ORDER_ACKNOWLEGMENT_ID	='". $Id ."'");

				$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateStatuLineNotification')));
			}
			unset($_POST['MajLigne']);
		
			$bdd->GetUpdatePOST(TABLE_ERP_ORDER_ACKNOWLEGMENT, $_POST, 'WHERE id=\''. $Id .'\'');
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateGeneralInfoNotification')));
		}
		elseif(isset($_POST['COMENT']) AND !empty($_POST['COMENT'])){
			//// COMMMENT ////
			$bdd->GetUpdatePOST(TABLE_ERP_ORDER_ACKNOWLEGMENT, $_POST, 'WHERE id=\''. $Id .'\'');
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateCommentNotification')));
		}
		elseif(isset($_GET['delete']) AND !empty($_GET['delete'])){
			//// DELETE LIGNE ////
			$IdOrderLineToUpdate = $bdd->GetQuery('SELECT ORDER_LINE_ID FROM '. TABLE_ERP_ORDER_ACKNOWLEGMENT_LINES .' WHERE id='. addslashes($_GET['delete']).'',true);
			$bdd->GetUpdatePOST(TABLE_ERP_ORDER_LIGNE, array("AR"=>0), 'WHERE id=\''. $IdOrderLineToUpdate->ORDER_LINE_ID .'\'');
			$bdd->GetDelete("DELETE FROM ". TABLE_ERP_ORDER_ACKNOWLEGMENT_LINES ." WHERE id='". addslashes($_GET['delete'])."'");

			$CallOutBox->add_notification(array('4', $i . $langue->show_text('DeleteOrderAcknowledgmentLinesNotification')));
		}
		//Load data
		$Maindata= $OrderAcknowledgment->GETOrderAcknowledgment($Id);
	}
	elseif(isset($_GET['DeliveryNotes']) AND !empty($_GET['DeliveryNotes'])){

		$Id = addslashes($_GET['DeliveryNotes']);
		
		//If user create new Delevery note
		if(isset($_POST['NewDeliveryNotes']) And !empty($_POST['NewDeliveryNotes'])){
			// Create new Delivery note and keep id
			$Id=$DeleveryNote->NewDeleveryNote($_POST['NewDeliveryNotes'], $_POST['ORDER_ID'], $User->idUSER);

			//update increment in num sequence db
			$Numbering->getIncrementNumbering(3);

			$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddDeliveryNoteNotification')));
			$i=0;
			//Select line who dont have an OA
			foreach ($OrderLines->GETOrderLineList(0, false, $_POST['ORDER_ID'], ' AND DELIVERED_REMAINING_QTY > 0') as $data){	
				
				//Create OA line
				$DeleveryNoteLines->NewDeleveryNoteLines($Id, $_POST['ORDER_ID'], $data->ORDRE, $data->id, $data->DELIVERED_REMAINING_QTY);
				//update order line
				$bdd->GetUpdatePOST(TABLE_ERP_ORDER_LIGNE, array("DELIVERED_QTY"=>$data->DELIVERED_REMAINING_QTY, "DELIVERED_REMAINING_QTY"=>0), 'WHERE id=\''. $data->id .'\'');
				$i++;
			}
			$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddDeliveryNoteLineNotification')));
		}
		elseif(isset($_POST['CODE']) AND !empty($_POST['CODE'])){
			//// ORDER ACKNOWLEGMENT DETAIL UPDATE ////
			
			if(isset($_POST['MajLigne']) AND !empty($_POST['MajLigne'])){
	
				$bdd->GetUpdate("UPDATE  ". TABLE_ERP_ORDER_DELIVERY_NOTE_LINES ." SET ETAT='". addslashes($_POST['ETAT']) ."'
																WHERE 	ORDER_DELEVERY_NOTE_ID	='". $Id ."'");

				$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateStatuLineNotification')));
			}
			unset($_POST['MajLigne']);
		
			$bdd->GetUpdatePOST(TABLE_ERP_ORDER_DELIVERY_NOTE, $_POST, 'WHERE id=\''. $Id .'\'');
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateGeneralInfoNotification')));
		}
		elseif(isset($_POST['COMENT']) AND !empty($_POST['COMENT'])){
			//// COMMMENT ////
			$bdd->GetUpdatePOST(TABLE_ERP_ORDER_DELIVERY_NOTE, $_POST, 'WHERE id=\''. $Id .'\'');
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateCommentNotification')));
		}
		elseif(isset($_GET['delete']) AND !empty($_GET['delete'])){
			//// DELETE LIGNE ////
			$IdOrderLineToUpdate = $bdd->GetQuery('SELECT ORDER_LINE_ID, QT FROM '. TABLE_ERP_ORDER_DELIVERY_NOTE_LINES .' WHERE id='. addslashes($_GET['delete']).'',true);
			$bdd->GetUpdatePOST(TABLE_ERP_ORDER_LIGNE, array("DELIVERED_QTY"=>0, "DELIVERED_REMAINING_QTY"=>$IdOrderLineToUpdate->QT), 'WHERE id=\''. $IdOrderLineToUpdate->ORDER_LINE_ID .'\'');
			$bdd->GetDelete("DELETE FROM ". TABLE_ERP_ORDER_DELIVERY_NOTE_LINES ." WHERE id='". addslashes($_GET['delete'])."'");

			$CallOutBox->add_notification(array('4', $i . $langue->show_text('DeleteDeliveryNoteLineNotification')));
		}
		
		//Load data
		$Maindata= $DeleveryNote->GETDeleveryNote($Id);
	}
	elseif(isset($_GET['InvoiceOrder']) AND !empty($_GET['InvoiceOrder'])){

		$Id = addslashes($_GET['InvoiceOrder']);
		
		//If user create new Delevery note
		if(isset($_POST['NewInvoiceOrder']) And !empty($_POST['NewInvoiceOrder'])){
			// Create new Delivery note and keep id
			$Id=$InvoiceOrder->NewInvoiceOrder($_POST['NewInvoiceOrder'], $_POST['ORDER_ID'], $User->idUSER);

			//update increment in num sequence db
			$Numbering->getIncrementNumbering(9);

			$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddInvoiceOrderNotification')));
			$i=0;
			//Select line who dont have an OA
			foreach ($OrderLines->GETOrderLineList(0, false, $_POST['ORDER_ID'], ' AND DELIVERED_REMAINING_QTY = 0 AND INVOICED_REMAINING_QTY > 0') as $data){	
				
				//Create OA line
				$InvoiceOrderLines->NewInvoiceOrderLines($Id, $_POST['ORDER_ID'], $data->ORDRE, $data->id, $data->INVOICED_REMAINING_QTY);
				//update order line
				$bdd->GetUpdatePOST(TABLE_ERP_ORDER_LIGNE, array("INVOICED_QTY"=>$data->INVOICED_REMAINING_QTY, "INVOICED_REMAINING_QTY"=>0), 'WHERE id=\''. $data->id .'\'');
				$i++;
			}
			$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddInvoiceOrderLineNotification')));
		}
		elseif(isset($_POST['CODE']) AND !empty($_POST['CODE'])){
			//// ORDER ACKNOWLEGMENT DETAIL UPDATE ////
			
			if(isset($_POST['MajLigne']) AND !empty($_POST['MajLigne'])){
	
				$bdd->GetUpdate("UPDATE  ". TABLE_ERP_ORDER_INVOICE_LINES ." SET ETAT='". addslashes($_POST['ETAT']) ."'
																					WHERE 	ORDER_INVOICE_ID	='". $Id ."'");

				$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateStatuLineNotification')));
			}
			unset($_POST['MajLigne']);
		
			$bdd->GetUpdatePOST(TABLE_ERP_ORDER_INVOICE, $_POST, 'WHERE id=\''. $Id .'\'');
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateGeneralInfoNotification')));
		}
		elseif(isset($_POST['COMENT']) AND !empty($_POST['COMENT'])){
			//// COMMMENT ////
			$bdd->GetUpdatePOST(TABLE_ERP_ORDER_INVOICE, $_POST, 'WHERE id=\''. $Id .'\'');
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateCommentNotification')));
		}
		elseif(isset($_GET['delete']) AND !empty($_GET['delete'])){
			//// DELETE LIGNE ////
			$IdOrderLineToUpdate = $bdd->GetQuery('SELECT ORDER_LINE_ID, QT FROM '. TABLE_ERP_ORDER_INVOICE_LINES .' WHERE id='. addslashes($_GET['delete']).'',true);
			$bdd->GetUpdatePOST(TABLE_ERP_ORDER_LIGNE, array("INVOICED_QTY"=>0, "INVOICED_REMAINING_QTY"=>$IdOrderLineToUpdate->QT), 'WHERE id=\''. $IdOrderLineToUpdate->ORDER_LINE_ID .'\'');
			$bdd->GetDelete("DELETE FROM ". TABLE_ERP_ORDER_INVOICE_LINES ." WHERE id='". addslashes($_GET['delete'])."'");

			$CallOutBox->add_notification(array('4', $i . $langue->show_text('DeleteInvoiceOrderLineNotification')));
		}
		
		//Load data
		$Maindata= $InvoiceOrder->GETInvoiceOrder($Id);
	}
	
	$ListeArticleJava  ='"';
	$query="SELECT id, CODE, LABEL FROM ". TABLE_ERP_STANDARD_ARTICLE ."  WHERE VENDU=1 ORDER BY LABEL";
	foreach ($bdd->GetQuery($query) as $data){
		$ListeArticle  .= '<option  value="'. $data->CODE .'" >';
		$ListeArticleJava  .= '<option  value=\"'. $data->CODE .'\" >';
	}
	$ListeArticleJava  .='"';

	if(isset($_GET['order']) AND !empty($_GET['order'])){
		$ActivateForm=true;
		$reqList = $Order->GETOrderList('',false);
		$reqLines = $OrderLines->GETOrderLineList('', false, $Id);
		// IF OrderAcknowledgment is avaiable
		$ARList = $OrderAcknowledgment->GETOrderAcknowledgmentList('',false, $Id);
		$MakeAR = $bdd->GetCount(TABLE_ERP_ORDER_LIGNE,'AR', 'WHERE ORDER_ID='. $Id .'  AND AR=0');
		// IF Delevery note is avaiable
		$DnList = $DeleveryNote->GETDeleveryNoteList('',false, $Id);
		$MakeDn = $bdd->GetCount(TABLE_ERP_ORDER_LIGNE,'id', 'WHERE ORDER_ID= '. $Id .' AND DELIVERED_REMAINING_QTY > 0');
		// IF Inovice is avaiable
		$IoList = $InvoiceOrder->GETInvoiceOrderList('',false, $Id);
		$MakeIo = $bdd->GetCount(TABLE_ERP_ORDER_LIGNE,'id', 'WHERE ORDER_ID= '. $Id .' AND DELIVERED_REMAINING_QTY = 0 AND INVOICED_REMAINING_QTY > 0');

		$GET = 'order';
		$ParDefautDiv1 = '';
		$ParDefautDiv2 = 'id="defaultOpen"';
		$ParDefautDiv3 = '';
		$ParDefautDiv4 = '';
		$ParDefautDiv5 = '';
		$actionForm = 'index.php?page=order&order='. $Id  .'';
		$DocumentType = 'ORDER_ID';

		if(isset($_GET['delete']) AND !empty($_GET['delete'])){
			$ParDefautDiv1 = '';
			$ParDefautDiv2 = '';
			$ParDefautDiv3 = 'id="defaultOpen"';
			$ParDefautDiv4 = '';
			$ParDefautDiv5 = '';
		}
	}
	elseif(isset($_GET['OrderAcknowledgment']) AND !empty($_GET['OrderAcknowledgment'])){
		$ActivateForm=false;
		$reqList = $OrderAcknowledgment->GETOrderAcknowledgmentList('',false, 0);
		$reqLines = $OrderAcknowledgmentLines->GETOrderacknowledgmentlinesList('', false, $Id);
		$GET = 'OrderAcknowledgment';
		$ParDefautDiv1 = '';
		$ParDefautDiv2 = 'id="defaultOpen"';
		$ParDefautDiv3 = '';
		$ParDefautDiv4 = '';
		$ParDefautDiv5 = '';
		$actionForm = 'index.php?page=order&OrderAcknowledgment='.$Id  .'';
		$DocumentType = 'ORDER_ACKNOWLEDGMENT_ID';

		if(isset($_GET['delete']) AND !empty($_GET['delete'])){
			$ParDefautDiv1 = '';
			$ParDefautDiv2 = '';
			$ParDefautDiv3 = 'id="defaultOpen"';
			$ParDefautDiv4 = '';
			$ParDefautDiv5 = '';
		}
	}
	elseif(isset($_GET['DeliveryNotes']) AND !empty($_GET['DeliveryNotes'])){
		$ActivateForm=false;
		$reqList = $DeleveryNoteLines->GETDeleveryNoteList('',false, 0);
		$reqLines = $DeleveryNoteLines->GETDeleveryNoteLinesList('', false, $Id);
		$GET = 'DeliveryNotes';
		$ParDefautDiv1 = '';
		$ParDefautDiv2 = 'id="defaultOpen"';
		$ParDefautDiv3 = '';
		$ParDefautDiv4 = '';
		$ParDefautDiv5 = '';
		$actionForm = 'index.php?page=order&DeliveryNotes='.$Id  .'';
		$DocumentType = 'DELIVERY_NOTE_ID';

		if(isset($_GET['delete']) AND !empty($_GET['delete'])){
			$ParDefautDiv1 = '';
			$ParDefautDiv2 = '';
			$ParDefautDiv3 = 'id="defaultOpen"';
			$ParDefautDiv4 = '';
			$ParDefautDiv5 = '';
		}
	}
	elseif(isset($_GET['InvoiceOrder']) AND !empty($_GET['InvoiceOrder'])){
		$ActivateForm=false;
		$reqList = $InvoiceOrderLines->GETInvoiceOrderList('',false, 0);
		$reqLines = $InvoiceOrderLines->GETInvoiceOrderLinesList('', false, $Id);
		$GET = 'InvoiceOrder';
		$ParDefautDiv1 = '';
		$ParDefautDiv2 = 'id="defaultOpen"';
		$ParDefautDiv3 = '';
		$ParDefautDiv4 = '';
		$ParDefautDiv5 = '';
		$actionForm = 'index.php?page=order&InvoiceOrder='.$Id  .'';
		$DocumentType = 'INVOICE_ID';

		if(isset($_GET['delete']) AND !empty($_GET['delete'])){
			$ParDefautDiv1 = '';
			$ParDefautDiv2 = '';
			$ParDefautDiv3 = 'id="defaultOpen"';
			$ParDefautDiv4 = '';
			$ParDefautDiv5 = '';
		}
	}
	else{
		$ActivateForm=true;
		$GET = 'order';
		$reqList = $Order->GETOrderList('',false);
		$ParDefautDiv1 = 'id="defaultOpen"';
		$ParDefautDiv2 = '';
		$ParDefautDiv3 = '';
		$ParDefautDiv4 = '';
		$ParDefautDiv5 = '';
		$actionForm = 'index.php?page=order&order=new';
	}
?>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $(".add").click(function() {
        var AddORDRELigne = $("#AddORDRELigne").val();
        var AddARTICLELigne = $("#AddARTICLELigne").val();
		var AddLABELLigne = $("#AddLABELLigne").val();
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
		var ligne = ligne + "<td><input type=\"text\" name=\"AddLABELLigne[]\" value=\""+ AddLABELLigne +"\" ></td>";
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
        $("table.content-table-devis").find('input[name="select"]').each(function() {
            if ($(this).is(":checked")) {
                $(this).parents("table.content-table-devis tr").remove();
            }
        });
    });
});
</script>
	<div class="tab">
		
	<?php if(isset($_GET['order']) AND !empty($_GET['order'])){ ?>
		<button class="tablinks" onclick="window.location.href = 'http://localhost/erp/public/index.php?page=order';"><?=$langue->show_text('Title1back'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div2')" <?=$ParDefautDiv2; ?>><?=$langue->show_text('Title2'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div3')" <?=$ParDefautDiv3; ?>><?=$langue->show_text('Title3'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div4')" <?=$ParDefautDiv3; ?>><?=$langue->show_text('Title4'); ?></button>
		<a href="index.php?page=document$type=order&id=<?= $_GET['order'] ?>" target="_blank"><button class="tablinks" ><?=$langue->show_text('Title5'); ?></button></a>	
	<?php } elseif(isset($_GET['OrderAcknowledgment']) AND !empty($_GET['OrderAcknowledgment'])){?>
		<button class="tablinks" onclick="window.location.href = 'http://localhost/erp/public/index.php?page=order';"><?=$langue->show_text('Title1back'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div2')" <?=$ParDefautDiv2; ?>><?=$langue->show_text('Title6'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div3')" <?=$ParDefautDiv3; ?>><?=$langue->show_text('Title3'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div4')" <?=$ParDefautDiv3; ?>><?=$langue->show_text('Title4'); ?></button>
		<a href="index.php?page=document$type=OrderAcknowledgment&id=<?= $_GET['OrderAcknowledgment'] ?>" target="_blank"><button class="tablinks" ><?=$langue->show_text('Title5'); ?></button></a>
	<?php } elseif(isset($_GET['DeliveryNotes']) AND !empty($_GET['DeliveryNotes'])){?>
		<button class="tablinks" onclick="window.location.href = 'http://localhost/erp/public/index.php?page=order';"><?=$langue->show_text('Title1back'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div2')" <?=$ParDefautDiv2; ?>><?=$langue->show_text('Title8'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div3')" <?=$ParDefautDiv3; ?>><?=$langue->show_text('Title3'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div4')" <?=$ParDefautDiv3; ?>><?=$langue->show_text('Title4'); ?></button>
		<a href="index.php?page=document$type=DeliveryNotes&id=<?= $_GET['DeliveryNotes'] ?>" target="_blank"><button class="tablinks" ><?=$langue->show_text('Title5'); ?></button></a>
	<?php } elseif(isset($_GET['InvoiceOrder']) AND !empty($_GET['InvoiceOrder'])){?>
		<button class="tablinks" onclick="window.location.href = 'http://localhost/erp/public/index.php?page=order';"><?=$langue->show_text('Title1back'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div2')" <?=$ParDefautDiv2; ?>><?=$langue->show_text('Title9'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div3')" <?=$ParDefautDiv3; ?>><?=$langue->show_text('Title3'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div4')" <?=$ParDefautDiv3; ?>><?=$langue->show_text('Title4'); ?></button>
		<a href="index.php?page=document$type=InvoiceOrder&id=<?= $_GET['InvoiceOrder'] ?>" target="_blank"><button class="tablinks" ><?=$langue->show_text('Title5'); ?></button></a>
	<?php }else{ ?>
		<button class="tablinks" onclick="openDiv(event, 'div1')" <?=$ParDefautDiv1; ?>><?=$langue->show_text('Title1'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div2')"><?=$langue->show_text('Title10'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div3')"><?=$langue->show_text('Title6'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div4')"><?=$langue->show_text('Title8'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div5')"><?=$langue->show_text('Title9'); ?></button>	
	<?php } ?>
	</div>
	<?php

	if(!isset($_GET['order']) && !isset($_GET['OrderAcknowledgment']) && !isset($_GET['DeliveryNotes'])  && !isset($_GET['InvoiceOrder'])){
		?>
		<div id="div2" class="tabcontent">
			<div class="column">
					<input type="text" id="myInput" onkeyup="myFunction()" placeholder="<?= $langue->show_text('TableFindQuote') ?>">
					<ul id="myUL">
						<?php
						//generate list for datalist find input.
						foreach ($OrderLines->GETOrderLineList('',false, 0) as $data): if($data->ETAT == 1) $class="info";
						elseif($data->ETAT == 2) $class="warning";
						elseif($data->ETAT == 3) $class="success";
						elseif($data->ETAT == 6) $class="alert";
						else $class="normal";?>
						<li><a class=<?= $class ?>  href="index.php?page=order&order=<?= $data->ORDER_ID ?>"><?= $data->ORDER_CODE ?> - <?= $data->ARTICLE_CODE ?> <?= $data->LABEL ?></a></li>
						<?php $i++; endforeach; ?>
					</ul>
			</div>
		</div>
		<div id="div3" class="tabcontent">
			<div class="column">
					<input type="text" id="myInput" onkeyup="myFunction()" placeholder="<?= $langue->show_text('TableFindOrder') ?>">
					<ul id="myUL">
						<?php
						//generate list for datalist find input
						foreach ($OrderAcknowledgment->GETOrderAcknowledgmentList('',false, 0) as $data): if($data->ETAT == 1) $class="info";
						elseif($data->ETAT == 2) $class="warning";
						elseif($data->ETAT == 3) $class="success";
						elseif($data->ETAT == 6) $class="alert";
						else $class="normal";?>
						<li><a class=<?= $class ?>  href="index.php?page=order&OrderAcknowledgment=<?= $data->id ?>"><?= $data->CODE ?> - <?= $data->NAME ?></a></li>
						<?php $i++; endforeach; ?>
					</ul>
			</div>
		</div>
		<div id="div4" class="tabcontent">
			<div class="column">
					<input type="text" id="myInput" onkeyup="myFunction()" placeholder="<?= $langue->show_text('TableFindDeliveryNotes') ?>">
					<ul id="myUL">
						<?php
						//generate list for datalist find input
						foreach ($DeleveryNote->GETDeleveryNoteList('',false, 0) as $data): if($data->ETAT == 1) $class="info";
						elseif($data->ETAT == 2) $class="warning";
						elseif($data->ETAT == 3) $class="success";
						elseif($data->ETAT == 6) $class="alert";
						else $class="normal";?>
						<li><a class=<?= $class ?>  href="index.php?page=order&DeliveryNotes=<?= $data->id ?>"><?= $data->CODE ?> - <?= $data->NAME ?></a></li>
						<?php $i++; endforeach; ?>
					</ul>
			</div>
		</div>
		<div id="div5" class="tabcontent">
			<div class="column">
					<input type="text" id="myInput" onkeyup="myFunction()" placeholder="<?= $langue->show_text('TableFindInvoice') ?>">
					<ul id="myUL">
						<?php
						//generate list for datalist find input
						foreach ($InvoiceOrder->GETInvoiceOrderList('',false, 0) as $data): if($data->ETAT == 1) $class="info";
						elseif($data->ETAT == 2) $class="warning";
						elseif($data->ETAT == 3) $class="success";
						elseif($data->ETAT == 6) $class="alert";
						else $class="normal";?>
						<li><a class=<?= $class ?>  href="index.php?page=order&InvoiceOrder=<?= $data->id ?>"><?= $data->CODE ?> - <?= $data->NAME ?></a></li>
						<?php $i++; endforeach; ?>
					</ul>
			</div>
		</div>
	<?php 
	}

	$DocNum = 4;
	require '../pages/templates/main.php';