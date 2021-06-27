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

		//Load data
		$Maindata= $PurchaseRequest->GETPurchaseRequest($Id);
	}
?>
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
	<?php } elseif(isset($_GET['SupplierReception']) AND !empty($_GET['SupplierReception'])){?>
		<button class="tablinks" onclick="window.location.href = 'http://localhost/erp/public/index.php?page=purchase';"><?=$langue->show_text('Title1back'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div1')" <?=$ParDefautDiv1; ?>><?=$langue->show_text('Title8'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div2')" <?=$ParDefautDiv2; ?>><?=$langue->show_text('Title3'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div3')" <?=$ParDefautDiv3; ?>><?=$langue->show_text('Title4'); ?></button>
		<a href="index.php?page=document$type=SupplierReception&id=<?= $_GET['id'] ?>" target="_blank"><button class="tablinks" ><?=$langue->show_text('Title5'); ?></button></a>
	<?php } elseif(isset($_GET['SupplierInvoice']) AND !empty($_GET['SupplierInvoice'])){?>
		<button class="tablinks" onclick="window.location.href = 'http://localhost/erp/public/index.php?page=purchase';"><?=$langue->show_text('Title1back'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div1')" <?=$ParDefautDiv1; ?>><?=$langue->show_text('Title9'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div2')" <?=$ParDefautDiv2; ?>><?=$langue->show_text('Title3'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div3')" <?=$ParDefautDiv3; ?>><?=$langue->show_text('Title4'); ?></button>
		<a href="index.php?page=document$type=SupplierInvoice&id=<?= $_GET['id'] ?>" target="_blank"><button class="tablinks" ><?=$langue->show_text('Title5'); ?></button></a>
	<?php }else{ ?>
		<button class="tablinks" onclick="openDiv(event, 'div1')" id="defaultOpen"><?=$langue->show_text('Title2'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div2')" ><?=$langue->show_text('Title10'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div3')" ><?=$langue->show_text('Title6'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div4')" ><?=$langue->show_text('Title8'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div5')" ><?=$langue->show_text('Title9'); ?></button>	
	<?php } ?>
	</div>
	<?php
		if(isset($_GET[$GET]) AND !empty($_GET[$GET])){ 
			require '../pages/templates/main.php';
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
	</div>
	<!-- End list Purchase order -->
	<!-- Start list Supplier reception -->
	<div id="div3" class="tabcontent" >
	</div>
	<!-- End list Supplier reception -->
	<!-- Start list Delevry form -->
	<div id="div4" class="tabcontent" >
	</div>
	<!-- End list Delevry form -->
	<!-- Start list Invoice -->
	<div id="div5" class="tabcontent" >
	</div>
	<!-- End list Invoice -->
	<?php 
	}