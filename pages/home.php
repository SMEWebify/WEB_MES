<?php 
	//phpinfo();
	use \App\Autoloader;
	use \App\Companies\Companies;
	use \App\Quote\Quote;
	use \App\Order\Order;
	use \App\Quality\QL_NFC;
	use \App\Methods\Ressource;
	use App\COMPANY\Employees;
	use \App\Companies\Contact;
	use \App\Study\Article;
	use \App\Order\DeleveryNote;
	use \App\Order\InvoiceOrder;

	//auto load class
	require_once '../app/Autoload.class.php';
	Autoloader::register();
	
	session_start();
	header( 'content-type: text/html; charset=utf-8' );
	
	//init form class
	$Companies = new Companies();
	$Quote = new Quote();
	$Order = new Order();
	$QL_FNC = new QL_NFC();
	$Ressource = new Ressource();
	$Employees= new Employees();
	$Contact =  new Contact();
	$Article = new Article();
	$DeleveryNote =  new DeleveryNote();
	$InvoiceOrder = new InvoiceOrder();

	//Check if the user is authorized to view the page
	if($_SESSION['page_1'] != '1'){
		stop($langue->show_text('SystemInfoAccessDenied'), 161, 'index.php?page=login');
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
			$query="SELECT ETAT, COUNT(ETAT) AS CountEtat FROM ". TABLE_ERP_QUOTE ." GROUP BY ETAT";
			foreach ($bdd->GetQuery($query) as $data){
				If ($data->ETAT == 1) {$Etat = $langue->show_text('SelectOpen');}
				If ($data->ETAT == 2) {$Etat = $langue->show_text('SelectRefuse');}
				If ($data->ETAT == 3) {$Etat = $langue->show_text('SelectWin');}
				If ($data->ETAT == 4) {$Etat = $langue->show_text('SelectSend');}
				If ($data->ETAT == 5) {$Etat = $langue->show_text('SelectDecline');}
				If ($data->ETAT == 6) {$Etat = $langue->show_text('SelectClosed');}
				If ($data->ETAT == 7) {$Etat = $langue->show_text('SelectObsolete');}

				$ListeEtat .= ", ['". $Etat ."',". $data->CountEtat ."]";
			}

			echo $ListeEtat;
?>
        ]);

        var options = {
			title: 'Quote rate statu',
			width: 400,
       		height: 300
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
			$query="SELECT SUM(PRIX_U *	QT) AS PRIX_TOTAL, 
						CASE MONTH(". TABLE_ERP_QUOTE .".DATE) 
							WHEN 1 THEN 'janvier'
							WHEN 2 THEN 'février'
							WHEN 3 THEN 'mars'
							WHEN 4 THEN 'avril'
							WHEN 5 THEN 'mai'
							WHEN 6 THEN 'juin'
							WHEN 7 THEN 'juillet'
							WHEN 8 THEN 'août'
							WHEN 9 THEN 'septembre'
							WHEN 10 THEN 'octobre'
							WHEN 11 THEN 'novembre'
							ELSE 'décembre'
						END AS MONTH
			FROM ". TABLE_ERP_QUOTE_LIGNE ." join ". TABLE_ERP_QUOTE ." ON ". TABLE_ERP_QUOTE_LIGNE .".DEVIS_ID=". TABLE_ERP_QUOTE .".id 
			GROUP BY MONTH(". TABLE_ERP_QUOTE .".DATE)  ";

		//	var_dump($bdd->GetQuery($query));
			foreach ($bdd->GetQuery($query) as $data){

				$ListeEtat .= ", ['". $data->MONTH ."',". $data->PRIX_TOTAL .", \"gray\"]";
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
        title: "Total quote cost month in €",
        width: 400,
        height: 300,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
      chart.draw(view, options);
  }
  </script>
	<div class="tab">
		<button class="tablinks" onclick="openDiv(event, 'div1')" id="defaultOpen"><?=$langue->show_text('Title1'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div2')" id="defaultOpen"><?=$langue->show_text('Title1'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div3')"><?=$langue->show_text('Title3'); ?></button>
	</div>
	<div id="div1" class="tabcontent" >
		<div class="row">
			<div class="column-dashboard">
				<p><i class="fa fa-smile-o"></i></p>
				<h3><?= $Companies->GETCompanieCount(); ?></h3>
				<p>Clients</p>
			</div>
			<div class="column-dashboard">
				<p><i class="fa fa-smile-o"></i></p>
				<h3><?= $Companies->GETCompanieCount('', 'AND STATU_CLIENT = 1'); ?></h3>
				<p>Fournisseur</p>
			</div>
			<div class="column-dashboard">
				<p><i class="fa fa-smile-o"></i></p>
				<h3><?= $Contact->GETContactCount(); ?></h3>
				<p>Contact</p>
			</div>
			<div class="column-dashboard">
				<p><i class="fa fa-smile-o"></i></p>
				<h3><?= $User->GETUserCount(); ?></h3>
				<p>User</p>
			</div>
			
			<div class="column-dashboard">
				<p><i class="fa fa-smile-o"></i></p>
				<h3><?= $Article->GETArticleCount(); ?></h3>
				<p>Article</p>
			</div>
			<div class="column-dashboard">
				<p><i class="fa fa-smile-o"></i></p>
				<h3><?= $Quote->GETQuoteCount(); ?></h3>
				<p>Quote</p>
			</div>
			<div class="column-dashboard">
				<p><i class="fa fa-smile-o"></i></p>
				<h3><?= $Order->GETOrderCount(); ?></h3>
				<p>Order</p>
			</div>
			<div class="column-dashboard">
				<p><i class="fa fa-smile-o"></i></p>
				<h3><?= $DeleveryNote->GETDeleveryNoteCount(); ?></h3>
				<p>Delevery Note</p>
			</div>


			<div class="column-dashboard">
				<p><i class="fa fa-smile-o"></i></p>
				<h3><?= $InvoiceOrder->GETInvoiceOrderCount(); ?></h3>
				<p>Invoice Order</p>
			</div>
			<div class="column-dashboard">
				<p><i class="fa fa-smile-o"></i></p>
				<h3>+</h3>
				<p>Empty</p>
			</div>
			<div class="column-dashboard">
				<p><i class="fa fa-smile-o"></i></p>
				<h3><?= $QL_FNC->GETQNFCCount('',' WHERE MONTH(CREATED) = MONTH(CURRENT_TIMESTAMP)'); ?>+</h3>
				<p>Current month Non-compliance Record</p>
			</div>	
  		</div>
		<div class="row">
			<div class="column-dashboard">
				<div id="piechart" style="width: 100%; height: 300px;"></div>
			</div>
			<div class="column-dashboard">
				<div id="columnchart_values" style="width: 100%; height: 300px;"></div>
			</div>
		</div>
		
	</div>
	<div id="div3" class="tabcontent" >
		<div class="row">
		<?php
		// get employees list
		foreach ($Employees->GETEmployeesList($SteRESP_COM_ID , false) as $data):
		if(!empty($data->IMAGE_PROFIL)){
			$image = PICTURE_FOLDER.PROFIL_FOLDER.$data->IMAGE_PROFIL;
		}
		else{
			$image = PICTURE_FOLDER.PROFIL_FOLDER.'img_avatar.png';
		}
		?>
				<div class="column">
					<div class="card">
						<img src="<?= $image ?>" alt="Profil" class="Image-Logo">
						<h3><?= $data->PRENOM ?> <?= $data->NOM ?></h3>
						<p><?= $data->RIGHT_NAME ?></p>
						<p>&#9742; <?= $data->NUMERO_INTERNE ?></p>
						<p><button onClick="location.href=\'mailto:<?= $data->MAIL ?>\'">&#x2709; <?= $langue->show_text('ContactEmployees') ?></button></p>
					</div>
				</div>
			<?php $i++; endforeach; ?>
			</div>
	</div>

