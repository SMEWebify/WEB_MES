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
		
		$IdQuote = addslashes($_GET['quote']);
		//If user create new quote
		if(isset($_POST['CutomerID']) And !empty($_POST['CutomerID'])){
			$ParDefautDiv2 = 'id="defaultOpen"';
			//insert in DB new quote
			$IdQuote = $Quote->NewQuote(addslashes($_POST['CODE']), addslashes($_POST['CutomerID']), $User->idUSER);
			$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddQuoteNotification')));
			//update increment in num sequence db
			$Numbering->getIncrementNumbering(8);

		}
		elseif(isset($_POST['COMENT']) AND !empty($_POST['COMENT'])){
			//// COMMMENT ////
			$bdd->GetUpdatePOST(TABLE_ERP_DEVIS, $_POST, 'WHERE id=\''. addslashes($_GET['quote']).'\'');
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateCommentNotification')));
		}
		elseif(isset($_POST['RepsComDevis']) AND !empty($_POST['RepsComDevis'])){
			//// GENERAL UPDATE ////
			$PostRepsComDevis= $_POST['RepsComDevis'];
			$PostRespTechDevis = $_POST['RespTechDevis'];

			if($_POST['RepsComDevis'] == 'null'){ $PostRepsComDevis = 0; }
			if($_POST['RespTechDevis'] == 'null'){ $PostRespTechDevis = 0; }

			$bdd->GetUpdate("UPDATE  ". TABLE_ERP_DEVIS ." SET 	RESP_COM_ID='". addslashes($PostRepsComDevis) ."',
																	RESP_TECH_ID='". addslashes($PostRespTechDevis) ."'
																			WHERE id='". addslashes($_POST['id'])."'");
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateGeneralNotification')));
		}
		elseif(isset($_POST['DATE_VALIDITE']) AND !empty($_POST['DATE_VALIDITE'])){
			//// ACCEUIL DEVIS  ////
			if(isset($_POST['DevisMajLigne']) AND !empty($_POST['DevisMajLigne'])){
				$bdd->GetUpdate("UPDATE  ". TABLE_ERP_DEVIS_LIGNE ." SET 	ETAT='". addslashes($PostDevisEtat) ."'	WHERE 	DEVIS_ID='". addslashes($_POST['IdDevis'])."'");
				$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateStatuLineNotification')));
			}

			unset($_POST['DevisMajLigne']);
			$bdd->GetUpdatePOST(TABLE_ERP_DEVIS, $_POST, 'WHERE id=\''. addslashes($_GET['quote']).'\'');
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateGeneralInfoNotification')));
		}
		elseif(isset($_POST['ContactDevis']) AND !empty($_POST['ContactDevis'])){
			//// CLIENT INFO UPDATE ////
			$PostContactDevis= $_POST['ContactDevis'];
			$PostAdresseLivraisonDevis = $_POST['AdresseLivraisonDevis'];
			$PostAdresseFacturationDevis = $_POST['AdresseFacturationDevis'];
	
			if($_POST['ContactDevis'] == 'null'){ $PostContactDevis = 0; }
			if($_POST['AdresseLivraisonDevis'] == 'null'){ $PostAdresseLivraisonDevis = 0; }
			if($_POST['AdresseFacturationDevis'] == 'null'){ $PostAdresseFacturationDevis = 0; }
	
			$bdd->GetUpdate("UPDATE  ". TABLE_ERP_DEVIS ." SET 	CONTACT_ID='". addslashes($PostContactDevis) ."',
																	ADRESSE_ID='". addslashes($PostAdresseLivraisonDevis) ."',
																	FACTURATION_ID='". addslashes($PostAdresseFacturationDevis) ."'
																WHERE id='". addslashes($_POST['id'])."'");
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateInfoCustomerNotification')));
		}
		elseif(isset($_POST['COND_REG_CLIENT_ID']) AND !empty($_POST['COND_REG_CLIENT_ID'])){
			//// COMMERCIAL UPDATE ////
			$bdd->GetUpdatePOST(TABLE_ERP_DEVIS, $_POST, 'WHERE id=\''. addslashes($_GET['quote']).'\'');
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateSalesInfoNotification')));
		}
		elseif(isset($_GET['delete']) AND !empty($_GET['delete'])){
			//// DELETE LIGNE ////
			$bdd->GetDelete("DELETE FROM ". TABLE_ERP_DEVIS_LIGNE ." WHERE id='". addslashes($_GET['delete'])."'");
			$CallOutBox->add_notification(array('4', $i . $langue->show_text('DeleteQuoteLineNotification')));
		}
		elseif(isset($_POST['AddORDRELigneDevis']) AND !empty($_POST['AddORDRELigneDevis'])){
			//// AJOUT DE LIGNE  ////
			$i = 0;
			foreach ($_POST['AddORDRELigneDevis'] as $id_generation) {
				$QuoteLines->NewQuoteLine($IdQuote, $_POST['AddORDRELigneDevis'][$i],  $_POST['AddARTICLELigneDevis'][$i], $_POST['AddLABELLigneDevis'][$i], $_POST['AddQTLigneDevis'][$i], $_POST['AddUNITLigneDevis'][$i], $_POST['AddPrixLigneDevis'][$i],$_POST['AddRemiseLigneDevis'][$i], $_POST['AddTVALigneDevis'][$i],$_POST['AddDELAISigneDevis'][$i]);
				$i++;
			}
			$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddQuoteLineNotification')));
		}

		if(isset($_POST['UpdateIdLigneDevis']) AND !empty($_POST['UpdateIdLigneDevis'])){
			$i = 0;
			foreach ($_POST['UpdateIdLigneDevis'] as $id) {
				$QuoteLines->UpdateQuoteLine($id, $_POST['UpdateORDRELigneDevis'][$i],  $_POST['UpdateIDArticleLigneDevis'][$i], $_POST['UpdateLABELLigneDevis'][$i], $_POST['UpdateQTLigneDevis'][$i], $_POST['UpdateUNITLigneDevis'][$i], $_POST['UpdatePrixLigneDevis'][$i],$_POST['UpdateRemiseLigneDevis'][$i], $_POST['UpdateTVALigneDevis'][$i],$_POST['UpdateDELAISLigneDevis'][$i],$_POST['UpdateETATLigneDevis'][$i] );
				$i++;
			}
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateLineNotification')));
		}
	
		//Load data
		$data= $Quote->GETQuote($IdQuote);
		
		$IdQuote = $data->id;
		$CommentaireDevis = $data->COMENT;
		$DevisCLIENT_ID = $data->CLIENT_ID;
		$DevisCONTACT_ID = $data->CONTACT_ID;
		$DevisCLIENT_NAME = $data->NAME;
		$DevisADRESSE_ID = $data->ADRESSE_ID;
		$DevisFACTURATION_ID = $data->FACTURATION_ID;
		$DevisNomName = $data->NOM;
		$DevisNomPrenom = $data->PRENOM;
		$DevisRESP_COM_ID = $data->RESP_COM_ID;
		$DevisRESP_TECH_ID = $data->RESP_TECH_ID;
		$DevisCONDI_REG_ID = $data->COND_REG_CLIENT_ID;
		$DevisMODE_REG_ID = $data->MODE_REG_CLIENT_ID;
		$DevisEcheancier_ID = $data->ECHEANCIER_ID;
		$DevisTransport_ID = $data->TRANSPORT_ID;

		$DevisCODE = $data->CODE;
		$DevisINDICE = $data->INDICE;
		$DevisLABEL = $data->LABEL;
		$DevisLABEL_INDICE = $data->LABEL_INDICE;

		$DevisDATE = $data->DATE;
		$DevisDATE_VALIDITE = $data->DATE_VALIDITE;
		$DevisETAT = $data->ETAT;
		$DevisREFERENCE = $data->REFERENCE;

			//deadline payment list
			$query='SELECT Id, LABEL FROM '. TABLE_ERP_ECHEANCIER_TYPE .'';
			foreach ($bdd->GetQuery($query) as $data){
				$EcheancierListe1 .='<option value="'. $data->Id .'" '. selected($DevisEcheancier_ID, $data->Id) .'>'. $data->LABEL .'</option>';
			}	
	}

	$ListeArticleJava  ='"';
	$query="SELECT id, CODE, LABEL FROM ". TABLE_ERP_ARTICLE ."  WHERE VENDU=1 ORDER BY LABEL";
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
		$actionForm = 'index.php?page=quote&quote='. $IdQuote .'';

	}
	elseif(isset($_GET['quote']) AND !empty($_GET['quote'])){
		$ParDefautDiv1 = '';
		$ParDefautDiv2 = 'id="defaultOpen"';
		$ParDefautDiv3 = '';
		$ImputButton = '<input type="submit" class="input-moyen" value="'. $langue->show_text('TableUpdateButton') .'" />';
		$actionForm = 'index.php?page=quote&quote='. $IdQuote .'';
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
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
 <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
		var data = google.visualization.arrayToDataTable([
<?php
			$ListeEtat = "['Task', 'Number of Quote']";
			$query="SELECT ETAT, COUNT(ETAT) AS CountEtat FROM ". TABLE_ERP_DEVIS ." GROUP BY ETAT";
			foreach ($bdd->GetQuery($query) as $data){
				If ($data->ETAT == 1) {$Etat = 'En cours';}
				If ($data->ETAT == 2) {$Etat = 'Refusé';}
				If ($data->ETAT == 3) {$Etat = 'Envoyé';}
				If ($data->ETAT == 4) {$Etat = 'Décliné';}
				If ($data->ETAT == 5) {$Etat = 'Fermé';}
				If ($data->ETAT == 6) {$Etat = 'Obselète';}

				$ListeEtat .= ", ['". $Etat ."',". $data->CountEtat ."]";
			}

			echo $ListeEtat;
?>
        ]);

        var options = {
          title: 'Taux de transformation'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
	<script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
    	var data = google.visualization.arrayToDataTable([
		<?php
			$ListeEtat = "['Element', 'Total Price', { role: 'style' } ]";
			$query="SELECT SUM(PRIX_U*	QT) AS PRIX_TOTAL FROM ". TABLE_ERP_DEVIS_LIGNE ." GROUP BY DEVIS_ID";
			foreach ($bdd->GetQuery($query) as $data){

				$ListeEtat .= ", ['". $data->MONTH ."',". $data->PRIX_TOTAL .", \"#b87333\"]";
			}

			echo $ListeEtat;
?>
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Montant chiffré ce mois ci",
        width: 400,
        height: 300,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
      chart.draw(view, options);
  }
  </script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $(".add").click(function() {
        var AddORDRELigneDevis = $("#AddORDRELigneDevis").val();
        var AddARTICLELigneDevis = $("#AddARTICLELigneDevis").val();
		var AddLABELLigneDevis = $("#AddLABELLigneDevis").val();
		var AddQTLigneDevis = $("#AddQTLigneDevis").val();
		var AddUNITLigneDevis = $("#AddUNITLigneDevis").val();
		var AddPrixLigneDevis = $("#AddPrixLigneDevis").val();
		var AddRemiseLigneDevis = $("#AddRemiseLigneDevis").val();
		var AddTVALigneDevis = $("#AddTVALigneDevis").val();
		var AddDELAISigneDevis = $("#AddDELAISigneDevis").val();

		var TotalPrix = (AddQTLigneDevis*AddPrixLigneDevis)-(AddQTLigneDevis*AddPrixLigneDevis)*(AddRemiseLigneDevis/100);

		var ligne = "<tr>";
		var ligne = ligne + "<td><input type=\"checkbox\" name=\"select\"></td>";
		var ligne = ligne + "<td><input type=\"number\" name=\"AddORDRELigneDevis[]\" value=\""+ AddORDRELigneDevis +"\" id=\"number\" required=\"required\"></td>";
		var ligne = ligne + "<td><input list=\"Article\" name=\"AddARTICLELigneDevis[]\" value=\"" + AddARTICLELigneDevis +"\"><datalist id=\"Article\">";
		var ligne = ligne + <?= $ListeArticleJava ?> ;
		var ligne = ligne + "</datalist></td>";
		var ligne = ligne + "<td><input type=\"text\" name=\"AddLABELLigneDevis[]\" value=\""+ AddLABELLigneDevis +"\" ></td>";
		var ligne = ligne + "<td><input type=\"number\" name=\"AddQTLigneDevis[]\" value=\""+ AddQTLigneDevis +"\"  id=\"number\" required=\"required\"></td>";
		var ligne = ligne + "<td><input type=\"hidden\" name=\"AddUNITLigneDevis[]\" value=\"" + AddUNITLigneDevis + "\">-</td>";
		var ligne = ligne + "<td><input type=\"number\" name=\"AddPrixLigneDevis[]\" value=\""+ AddPrixLigneDevis +"\"  step=\".001\" id=\"number\" required=\"required\"></td>";
		var ligne = ligne + "<td><input type=\"number\" name=\"AddRemiseLigneDevis[]\" value=\""+ AddRemiseLigneDevis +"\" min=\"0\" max=\"100\" step=\".001\" id=\"number\" required=\"required\"></td>";
		var ligne = ligne + "<td>"+ TotalPrix +" €</td>";
		var ligne = ligne + "<td><input type=\"hidden\" name=\"AddTVALigneDevis[]\" value=\"" + AddTVALigneDevis + "\">-</td>";
		var ligne = ligne + "<td><input type=\"date\" name=\"AddDELAISigneDevis[]\"  value=\"" + AddDELAISigneDevis+"\" required=\"required\"></td>";
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
		<button class="tablinks" onclick="openDiv(event, 'div4')"><?=$langue->show_text('Title4'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div5')"><?=$langue->show_text('Title5'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div6')"><?=$langue->show_text('Title6'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div7')"><?=$langue->show_text('Title7'); ?></button>
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
	<div id="div1" class="tabcontent">
		<div class="column">
			<input type="text" id="myInput" onkeyup="myFunction()" placeholder="<?= $langue->show_text('TableFindQuote') ?>">
			<ul id="myUL">
				<?php
				//generate list for datalist find input
				foreach ($Quote->GETQuoteList('',false) as $data): ?>
				<li><a href="index.php?page=quote&quote=<?= $data->id ?>"><?= $data->CODE ?> - <?= $data->NAME ?></a></li>
				<?php $i++; endforeach; ?>
			</ul>
		</div>
		<div class="column">
			<form method="post" name="quote" action="<?= $actionForm ?>" class="content-form" enctype="multipart/form-data" >
				<table class="content-table">
					<thead>
						<tr>
							<th colspan="5">
								<br/>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><?= $langue->show_text('TableNewQuoteFor') ?></td>
							<td>
								<select name="CutomerID">
									<?= $Companies->GetCustomerList() ?>
								</select>
							</td>
						</tr>
						<tr>
							<td><?= $langue->show_text('TableNumberQuote') ?></td>
							<td><?= $Form->input('text', 'CODE',  $Numbering->getCodeNumbering(8)) ?></td>
						</tr>
						<tr>
							<td colspan="6" >
								<br/>
								<input type="submit" class="input-moyen" value="<?= $langue->show_text('TableNewButton') ?>" /> <br/>
								<br/>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>
		<div class="column">
			<div id="piechart" style="width: 100%; height: 300px;"></div>
			<div id="columnchart_values" style="width: 100%; height: 300px;"></div>
		</div>
	</div>
	<?php if(isset($_GET['quote']) AND !empty($_GET['quote'])){ ?>
	<div id="div2" class="tabcontent">
		<form method="post" name="Coment" action="<?=$actionForm; ?>" class="content-form" >
			<table class="content-table">
					<thead>
						<tr>
							<th colspan="5">
							<?= $langue->show_text('TableNumberQuote')  ?> <?= $DevisCODE  ?> <?= $langue->show_text('TableIndexQuote')  ?>  <?= $DevisINDICE  ?>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><?= $langue->show_text('TableCodeLabel')  ?></td>
							<td><?= $DevisCODE ?></td>
							<td>
								<input type="text" name="LABEL" value="<?= $DevisLABEL  ?>" placeholder="<?= $langue->show_text('TableLabelquote')  ?>">
							</td>
						</tr>
						<tr>
							<td><?= $langue->show_text('TableIndexLabel')  ?></td>
							<td><?= $DevisINDICE  ?></td>
							<td>
								<input type="text" name="LABEL_INDICE" value="<?= $DevisLABEL_INDICE  ?>" placeholder="<?= $langue->show_text('TableLabelIndexquote') ?>">
							</td>
						</tr>
						<tr>
							<td><?= $langue->show_text('TableCustomerReference')  ?></td>
							<td>
								<input type="text" name="REFERENCE" value="<?= $DevisREFERENCE ?>" placeholder="<?= $langue->show_text('TableCustomerReference') ?>" >
							</td>
							<td></td>
						</tr>
						<tr>
							<td><?= $langue->show_text('TableCreationDate')  ?></td>
							<td><?= $DevisDATE  ?></td>
							<td></td>
						</tr>
						<tr>
							<td><?= $langue->show_text('TableValidityDate')  ?></td>
							<td><input type="date" name="DATE_VALIDITE" value="<?= $DevisDATE_VALIDITE  ?>" ></td>
							<td></td>
						</tr>
						<tr>
							<td><?= $langue->show_text('TableQuoteStatu') ?></td>
							<td>
								<select name="ETAT">
									<option value="1" <?= selected($DevisETAT, 1) ?>><?= $langue->show_text('SelectOpen') ?></option>
									<option value="2" <?= selected($DevisETAT, 2) ?>><?= $langue->show_text('SelectRefuse') ?></option>
									<option value="3" <?= selected($DevisETAT, 3) ?>><?= $langue->show_text('SelectSend') ?></option>
									<option value="4" <?= selected($DevisETAT, 4) ?>><?= $langue->show_text('SelectDecline') ?></option>
									<option value="5" <?= selected($DevisETAT, 5) ?>><?= $langue->show_text('SelectClosed') ?></option>
									<option value="6" <?= selected($DevisETAT, 6) ?>><?= $langue->show_text('SelectObsolete') ?></option>
								</select>
							</td>
							<td><input type="checkbox" id="DevisMajLigne" name="DevisMajLigne" checked="checked"><label ><?= $langue->show_text('UpdateQuoteLine') ?></label></td>
						</tr>
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
	<div id="div3" class="tabcontent">
		<form method="post" name="Coment" action="<?=$actionForm; ?>" class="content-form" >
			<table class="content-table-devis" style="width: 50%;">
				<thead>
					<tr>
						<th colspan="12" >
						<?= $langue->show_text('TableNumberQuote')  ?> <?= $DevisCODE  ?> <?= $langue->show_text('TableIndexQuote')  ?>  <?= $DevisINDICE  ?>
						</th>
					</tr>
					<tr>
						<th></th>
						<th><?= $langue->show_text('TableOrder')?></th>
						<th><?= $langue->show_text('TableArticle')?></th>
						<th><?= $langue->show_text('Tablelabel')?></th>
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
				</tr>
						<th colspan="12" >
							<?= $langue->show_text('Addline') ?>
						</th>
					</tr>
					<tr>
						<td></td>
						<td><input type="number" name="" id="AddORDRELigneDevis" placeholder="10"  value="10"></td>
						<td>
							<input list="Article" name="AddARTICLELigneDevis" id="AddARTICLELigneDevis">
							<datalist id="Article">
								<?= $ListeArticle ?>
							</datalist>
						</td>
						<td><input type="text"  name="" id="AddLABELLigneDevis" placeholder="Désignation"></td>
						<td><input type="number"  name="" id="AddQTLigneDevis" placeholder="1"  value="1"></td>
						<td>
							<select name="" id="AddUNITLigneDevis">
							<?= $Unit->GetUnitList() ?>
							</select>
						</td>
						<td><input type="number"  name="" id="AddPrixLigneDevis" step=".001" placeholder="10 €"  value="0"></td>
						<td><input type="number"  name="" id="AddRemiseLigneDevis" min="0" max="100" step=".001" placeholder="0 %" value="0"></td>
						<td></td>
						<td>
							<select name="" id="AddTVALigneDevis">
							<?= $VAT->GETVATList() ?>
							</select>
						</td>
						<td><input type="date" name="" id="AddDELAISigneDevis"></td>
						<td></td>
					</tr>
					<tr>
						<td colspan="12" >
							<input type="button" class="add" value="<?= $langue->show_text('Addline') ?>">
							<input type="button" class="delete" value="<?= $langue->show_text('Deleteline') ?>">
							<input type="submit" class="input-moyen" value="<?= $langue->show_text('UpdateQuoteLine') ?>" />
						</td>
					</tr>
					<?php
						//// LISTE DES LIGNES  ////
						$i =0;
						$tableauTVA = array();
						foreach ($QuoteLines->GETQuoteLineList('', false, $IdQuote) as $data): 

							$TotalLigneHTEnCours = ($data->QT*$data->PRIX_U)-($data->QT*$data->PRIX_U)*($data->REMISE/100);
							$TotalLigneTVAEnCours =  $TotalLigneHTEnCours*($data->TAUX/100) ;
							$TotalLigneTTCEnCours = $TotalLigneTVAEnCours+$TotalLigneHTEnCours;

							$TotalLigneDevisHT += $TotalLigneHTEnCours;
							$TotalLigneDevisTTC += $TotalLigneTVAEnCours+$TotalLigneHTEnCours;

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
								<td><input type="hidden" name="UpdateIdLigneDevis[]" id="UpdateIdLigneDevis" value="'. $data->id .'"></td>
								<td>
									<label class="container">
										<input type="checkbox" title="'. $data->id .'" name="id_ligne[]" value="'. $data->id .'" id="'. $data->id .'" checked="checked"/>
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
								<td><input type="hidden" name="UpdateIdLigneDevis[]" id="UpdateIdLigneDevis" value="<?= $data->id ?>"><a href="index.php?page=quote&quote=<?= $_GET['quote'] ?>&amp;delete=<?= $data->id ?>" title="Supprimer la ligne">&#10007;</a></td>
								<td><input type="number" name="UpdateORDRELigneDevis[]" value="<?= $data->ORDRE ?>" ></td>
								<td>
									<input list="Article" name="UpdateIDArticleLigneDevis[]" id="UpdateIDArticleLigneDevis" value="<?= $data->ARTICLE_CODE ?>">
									<datalist id="Article">
										<?= $ListeArticle ?>
									</datalist>
								</td>
								<td><input type="text"  name="UpdateLABELLigneDevis[]" value="<?= $data->LABEL ?>"></td>
								<td><input type="number"  name="UpdateQTLigneDevis[]" value="<?= $data->QT ?>" ></td>
								<td>
									<select  name="UpdateUNITLigneDevis[]">
										<?= $Unit->GetUnitList($data->UNIT_ID, true) ?>
									</select>
								</td>
								<td><input type="number"  name="UpdatePrixLigneDevis[]" step=".001" value="<?= $data->PRIX_U ?>" ></td>
								<td><input type="number"   name="UpdateRemiseLigneDevis[]" min="0" max="100" step=".001" value="<?= $data->REMISE ?>" ></td>
								<td><?=   $TotalLigneHTEnCours ?> €</td>

								<td>
									<select  name="UpdateTVALigneDevis[]">
										<?= $VAT->GETVATList($data->TVA_ID) ?>
									</select>
								</td>
								<td><input type="date" name="UpdateDELAISLigneDevis[]" value="<?= $data->DELAIS ?>"></td>
								<td>
									<select  name="UpdateETATLigneDevis[]">
										<option value="1" <?= selected($data->ETAT, 1) ?>><?= $langue->show_text('SelectOpen') ?></option>
										<option value="2" <?= selected($data->ETAT, 2) ?>><?= $langue->show_text('SelectRefuse') ?></option>
										<option value="3" <?= selected($data->ETAT, 3) ?>><?= $langue->show_text('SelectSend') ?></option>
										<option value="4" <?= selected($data->ETAT, 4) ?>><?= $langue->show_text('SelectDecline') ?></option>
										<option value="5" <?= selected($data->ETAT, 5) ?>><?= $langue->show_text('SelectClosed') ?></option>
										<option value="6" <?= selected($data->ETAT, 6) ?>><?= $langue->show_text('SelectObsolete') ?></option>
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
						<th colspan="2"><?= $TotalLigneDevisHT ?> €</th>
						<th></th>
						<th colspan="2" ><?= $langue->show_text('TotalWithTax') ?></th>
						<th><?= $TotalLigneDevisTTC ?> €</th>
						<th></th>
						<th></th>
						<th></th>
					<tr>
					<?php } ?>
				</tbody>
			</table>
		</form>
	</div>
	<div id="div4" class="tabcontent">
		<form method="post" name="Coment" action="<?=$actionForm; ?>" class="content-form" >
			<table class="content-table" style="width: 50%;">
				<thead>
					<tr>
						<th colspan="2" >
							<?= $langue->show_text('TableNumberQuote') ?> <?= $DevisCODE ?> <?= $langue->show_text('TableIndexQuote') ?>  <?= $DevisINDICE ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<input type="hidden" name="id" value="<?= $IdQuote ?>">
							<?= $langue->show_text('TableUserCreate') ?>
						</td>
						<td><?= $DevisNomName ?> <?= $DevisNomPrenom ?></td>
					</tr>
					<tr>
						<td><?= $langue->show_text('TableSalesManager') ?></td>
						<td>
							<select name="RepsComDevis">
								<?=$Employees->GETEmployeesList($DevisRESP_COM_ID) ?>
							</select>
						</td>
					</tr>
					<tr>
						<td><?= $langue->show_text('TableTechnicalManager') ?></td>
						<td>
							<select name="RespTechDevis">
							<?=$Employees->GETEmployeesList($DevisRESP_TECH_ID) ?>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2" ><input type="submit" class="input-moyen" value="<?= $langue->show_text('TableUpdateButton') ?>" /></td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
	<div id="div5" class="tabcontent">
		<form method="post" name="Coment" action="<?=$actionForm; ?>" class="content-form" >
			<table class="content-table" style="width: 50%;">
				<thead>
					<tr>
						<th colspan="2" >
							<?= $langue->show_text('TableNumberQuote') ?> <?= $DevisCODE ?> <?= $langue->show_text('TableIndexQuote') ?>  <?= $DevisINDICE ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<input type="hidden" name="id" value="<?= $IdQuote ?>">
							<?= $langue->show_text('TableContact') ?>
						</td>
						<td>
							<select name="ContactDevis">
								<?=  $Contact->GETContactList($DevisCONTACT_ID, true, $DevisCLIENT_ID )  ?>
							</select>
						</td>
					</tr>
					<tr>
						<td><?= $langue->show_text('TableAdresseDelevery') ?></td>
						<td>
							<select name="AdresseLivraisonDevis">
							<?=  $Address->GETAddressList($DevisADRESSE_ID, true, $DevisCLIENT_ID,'AND ADRESS_LIV=\'1\'' ) ?>
							</select>
						</td>
					</tr>
					<tr>
						<td><?= $langue->show_text('TableAdresseInvoice') ?></td>
						<td>
							<select name="AdresseFacturationDevis">
								<?=  $Address->GETAddressList($DevisFACTURATION_ID, true, $DevisCLIENT_ID,'AND ADRESS_FAC=\'1\'' ) ?>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2" >
							<input type="submit" class="input-moyen" value="<?= $langue->show_text('TableUpdateButton') ?>" />
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
	<div id="div6" class="tabcontent">
		<form method="post" name="Coment" action="<?=$actionForm; ?>" class="content-form" >
			<table class="content-table" style="width: 50%;">
				<thead>
					<tr>
						<th colspan="2" >
							<?= $langue->show_text('TableNumberQuote') ?> <?= $DevisCODE ?> <?= $langue->show_text('TableIndexQuote') ?>  <?= $DevisINDICE ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?= $langue->show_text('TableCondiList') ?></td>
						<td>
							<select name="COND_REG_CLIENT_ID">
								<?=$PaymentCondition->GETPaymentConditionList($DevisCONDI_REG_ID)?>
							</select>
						</td>
					</tr>
					<tr>
						<td><?= $langue->show_text('TableMethodList') ?></td>
						<td>
							<select name="MODE_REG_CLIENT_ID">
								<?=$PaymentMethod->GETPaymentMethodList($DevisMODE_REG_ID); ?>
							</select>
						</td>
					</tr>
					<tr>
						<td><?= $langue->show_text('TimeLinePayement') ?></td>
						<td>
							<select name="ECHEANCIER_ID">
								<?=  $EcheancierListe1 ?>
							</select>
						</td>
					</tr>
					<tr>
						<td><?= $langue->show_text('TableDeleveryMode') ?></td>
						<td>
							<select name="TRANSPORT_ID">
								<?=  $Delevery->GETDeleveryList($DevisTransport_ID, true) ?>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2" >
							<input type="submit" class="input-moyen" value="<?= $langue->show_text('TableUpdateButton') ?>" />
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
	<div id="div7" class="tabcontent">
		<form method="post" name="Coment" action="<?=$actionForm; ?>" class="content-form" >
			<table class="content-table" style="width: 50%;">
				<thead>
					<tr>
						<th>
						<?= $langue->show_text('TableNumberQuote') ?> <?= $DevisCODE ?> <?= $langue->show_text('TableIndexQuote') ?>  <?= $DevisINDICE ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><textarea class="Comment" name="COMENT" id="COMENT" rows="40" ><?= $CommentaireDevis ?></textarea></td>
					</tr>
					<tr>
						<td><input type="submit" class="input-moyen" value="<?= $langue->show_text('TableUpdateButton') ?>" /></td>
					</tr>
				</tbody>
			</table>?>
		</form>
	</div>
	<div id="div8" class="tabcontent">
		<form method="post" name="Coment" action="commandes.php" class="content-form" >	
				<div class="column">
					<table class="content-table" >
						<thead>
							<tr>
								<th colspan="9" >
									<?= $langue->show_text('TableNumberQuote') ?> <?= $DevisCODE ?> <?= $langue->show_text('TableIndexQuote') ?>  <?= $DevisINDICE ?>
								</th>
							</tr>
						</thead>
						<tbody>
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
							<td><input type="radio" id="new" name="AddCmd" value="0"><label for="new"><?= $langue->show_text('TableNewOrder') ?></label></td>
						</tr>
						<?php
						$query='SELECT '. TABLE_ERP_COMMANDE .'.id,
										'. TABLE_ERP_COMMANDE .'.CODE,
										'. TABLE_ERP_COMMANDE .'.LABEL,
										'. TABLE_ERP_CLIENT_FOUR .'.NAME
								FROM '. TABLE_ERP_COMMANDE .'
									LEFT JOIN `'. TABLE_ERP_CLIENT_FOUR .'` ON `'. TABLE_ERP_COMMANDE .'`.`CLIENT_ID` = `'. TABLE_ERP_CLIENT_FOUR .'`.`id`
								ORDER BY '. TABLE_ERP_COMMANDE .'.id';
						$i = 1;
						foreach ($bdd->GetQuery($query) as $data): ?>
						<tr>
							<td>
								<input type="radio" id="new<?= $data->id ?>" name="AddCmd" value="<?= $data->id ?>"><label for="new<?= $data->id ?>"><?= $data->CODE ?> - <?= $data->NAME ?></label>
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
							<?= $langue->show_text('TableCustomerReference') ?> <input type="text" name="AddReferenceClient" placeholder="<?= $langue->show_text('TableNumberCustomerOrder') ?>">
							</td>
						</tr>
						<tr>
							<td>
							<?= $langue->show_text('TableDeleveryDate') ?> <input type="date" name="AddDELAISCommande" required="required">
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
	<?php }else{ ?>
	<div id="div9" class="tabcontent">
		<div class="column">
				<input type="text" id="myInput" onkeyup="myFunction()" placeholder="<?= $langue->show_text('TableFindQuote') ?>">
				<ul id="myUL">
					<?php
					//generate list for datalist find input
					foreach ($QuoteLines->GETQuoteLineList('',false, 0) as $data): ?>
					<li><a href="index.php?page=quote&quote=<?= $data->DEVIS_ID ?>"><?= $data->ARTICLE_CODE ?> - <?= $data->LABEL ?></a></li>
					<?php $i++; endforeach; ?>
				</ul>
			</div>
		</div>
	<?php } ?>
