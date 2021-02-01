<?php 
	//phpinfo();
	use \App\Autoloader;
	use \App\Form;
	use \App\Methods\Prestation;
	use \App\Methods\Ressource;
	use \App\Methods\Section;

	//auto load class
	require_once '../app/Autoload.class.php';
	Autoloader::register();
	
	session_start();
	header( 'content-type: text/html; charset=utf-8' );
	//init form class
	$Form = new Form($_POST);
	$Ressource = new Ressource();
	$Prestation = new Prestation();
	$Section = new Section();

	//Check if the user is authorized to view the page
	if($_SESSION['page_2'] != '1'){
		stop($langue->show_text('SystemInfoAccessDenied'), 161, 'index.php?page=login');
	}

	if(isset($_GET['mois']) & isset($_GET['annee'])){
		$mois = intval($_GET['mois']);
		$annee = intval($_GET['annee']);
	}
?>
	<div class="tab">
		<button class="tablinks" onclick="openDiv(event, 'div1')" id="defaultOpen"><?=$langue->show_text('Title1'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div2')" ><?=$langue->show_text('Title2'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div3')" ><?=$langue->show_text('Title3'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div4')" ><?=$langue->show_text('Title4'); ?></button>
	</div>
	<div id="div1" class="tabcontent" >
		<div id="grand_calendrier">
			<table class="content-table-decal">
			<thead>
				<tr>
					<th colspan="7">
<?php
	setlocale(LC_ALL, 'fr_FR.utf-8', 'fr_FR','fr','fr','fra','fr_FR@euro');

	if((empty($_GET["mois"]) || !ctype_digit($_GET["mois"]) || $_GET["mois"]<=0 || $_GET["mois"]>12) && !isset($mois))	{
		$mois=date('m') ;
	}
	elseif(!empty($_GET["mois"]) && ctype_digit($_GET["mois"]) && $_GET["mois"]>0 && $_GET["mois"]<=12 && !isset($mois))	{
		if(strlen($_GET["mois"])==1)	{
			$mois='0'.$_GET["mois"] ;
		}
		else{
			$mois=$_GET["mois"] ;
		}
	}
	elseif(isset($mois) && strlen($mois)==1)	{
		$mois='0'.$mois ;
	}

	if((empty($_GET["annee"]) || !ctype_digit($_GET["annee"])) && !isset($annee)){
		$annee=date('Y') ;
	}
	elseif(!isset($annee))	{
		$annee=$_GET["annee"] ;
	}

	$timestampreference=mktime(1, 0, 0, $mois, 1, $annee) ;
	$nombrejours=date('t', $timestampreference) ;
	$iterations=0 ;
	$jour=1 ;
	$correspondancejourfr=array(1 => 'lu', 2 => 'ma', 3 => 'me', 4 => 'je', 5 => 've', 6 => 'sa', 7 => 'di') ;
	$correspondancejouren=array(1 => 'mo', 2 => 'tu', 3 => 'we', 4 => 'th', 5 => 'fr', 6 => 'sa', 7 => 'su') ;

	if($mois!=01)	{
		echo '<a href="index.php?page=planning&mois='.($mois-1).'&amp;annee='.$annee.'">«</a> ';
	}
	else	{
		echo '<a href="index.php?page=planning&mois=12&amp;annee='.($annee-1).'">«</a> ';
	}

	if(setlocale(LC_ALL, 'fr_FR.utf-8', 'fr_FR','fr','fr','fra','fr_FR@euro'))	{
		echo  ucfirst(strftime('%B', $timestampreference)).' '.$annee ;
	}
	else{
		$correspondancesmois=array('january' => 'Janvier',
										'february' => 'Février',
										'march' => 'Mars',
										'april' => 'Avril',
										'may' => 'Mai',
										'june' => 'Juin',
										'july' => 'Juillet',
										'august' => 'Aout',
										'september' => 'Septembre',
										'october' => 'Octobre',
										'november' => 'Novembre',
										'december' => 'Décembre') ;

		echo  $correspondancesmois[strftime('%B', $timestampreference)].' '.$annee ;
	}

	if($mois!=12)	{
								echo '<a href="index.php?page=planning&mois='.($mois+1).'&amp;annee='.$annee.'">»</a>
									<br/>
									<br/>';
	}
	else{
								echo '<a href="index.php?page=planning&mois=01&amp;annee='.($annee+1).'">»</a>
									<br/>
									<br/>';
	}

					echo "\n\t\t\t\t\t\t\t\t";
					echo '</th>
							</tr>
							<tr>
								<th>Lundi</th><th>Mardi</th><th>Mercredi</th><th>Jeudi</th><th>Vendredi</th><th>Samedi</th><th>Dimanche</th>
							</tr>
						</thead>
						<tbody>
							<tr>';

	$query='SELECT '. TABLE_ERP_ORDER_LIGNE .'.id,
					'. TABLE_ERP_ORDER_LIGNE .'.ARTICLE_CODE,
					'. TABLE_ERP_ORDER_LIGNE .'.ORDER_ID,
					'. TABLE_ERP_ORDER_LIGNE .'.DELAIS,
					'. TABLE_ERP_ORDER .'.CODE
					FROM '. TABLE_ERP_ORDER_LIGNE .'
						LEFT JOIN `'. TABLE_ERP_ORDER .'` ON `'. TABLE_ERP_ORDER_LIGNE .'`.`ORDER_ID` = `'. TABLE_ERP_ORDER .'`.`id`
					WHERE  MONTH(DELAIS)='.$mois.' and YEAR(DELAIS)='.$annee.'';


	unset($cles) ;
	$id=array() ;
	$titres=array() ;
	$datesdebut=array() ;
	$heuresdebut=array() ;
	$datesfin=array() ;
	$heuresfin=array() ;
	$nombreresultat=0 ;

	foreach ($bdd->GetQuery($query, false) as $data){
		$debut=explode(' ', $data->DELAIS) ;

		if(!empty($data->DELAIS)){
			$fin=explode(' ', $data->DELAIS) ;
		}
		$id[$nombreresultat]=$data->ORDER_ID ;
		$titres[$nombreresultat]=htmlspecialchars($data->CODE) ;
		$datesdebut[$nombreresultat]=$debut[0] ;
		$heuresdebut[$nombreresultat]=substr($debut[1], 0, 5) ;

		if(!empty($data->DELAIS_INTERNE)){
			$datesfin[$nombreresultat]=$fin[0] ;
			$heuresfin[$nombreresultat]=substr($fin[1], 0, 5) ;
		}

		$nombreresultat++ ;
	}

	while($iterations<35)	{
		$iterations++ ;
		$valeur=$iterations-7*floor($iterations/7.1) ;

		if(strlen($jour)==1){
			$jour='0'.$jour ;
		}

		if((substr(strftime('%A', $timestampreference), 0, 2)==$correspondancejourfr[$valeur] || strtolower(substr(strftime('%A', $timestampreference), 0, 2))==$correspondancejouren[$valeur])&& $jour<=$nombrejours){
								echo "\n\t\t\t\t\t\t\t\t";
								echo '<td' ;

								if($timestampreference==mktime(0, 0, 0)){
									echo 'class="today" ';
								}
								if(in_array($annee.'-'.$mois.'-'.$jour, $datesdebut) || in_array($annee.'-'.$mois.'-'.$jour, $datesfin)){
									$cles=array_keys($datesdebut, $annee.'-'.$mois.'-'.$jour) ;
									$cles+=array_keys($datesfin, $annee.'-'.$mois.'-'.$jour) ;
								}

								echo '>
									<span class="jour">'.$jour.'</span>
									<div class="eventslist">';

								if(in_array($annee.'-'.$mois.'-'.$jour, $datesdebut) || in_array($annee.'-'.$mois.'-'.$jour, $datesfin)){
									echo "\n\t\t\t\t\t\t\t\t\t\t";
									echo '<div class="evenement">' ;
									foreach($cles as $cle){
										
											echo '<h6><a href="index.php?page=order&order='.$id[$cle].'">'.$titres[$cle].'</a></h6>' ;
									}
									echo "\n\t\t\t\t\t\t\t\t\t\t";
									echo '</div>' ;
								}
						echo "\n\t\t\t\t\t\t\t\t\t";
						echo '</div>
								</td>' ;
			$jour++ ;
			$timestampreference+=24*60*60 ;
		}
		else{
					echo "\n\t\t\t\t\t\t\t\t";
					echo '<td>
									<div class="jour_vide"></div>
								</td>' ;
		}

		if(($iterations%7)==0 && $jour!=$nombrejours && $iterations!=35){
			echo "\n\t\t\t\t\t\t\t";
			echo '</tr>
							<tr>' ;
		}

		if($iterations==35 && $jour<=$nombrejours){
			echo "\n\t\t\t\t\t\t\t";
			echo '<tr>
							<tr>' ;
			$iterations-=7 ;
		}
	}
?>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div id="div2" class="tabcontent" >
		<table class="content-table">
			<thead>
				<tr>
						<th></th>
						<th>W<?= strftime("%W", time())+1 ?></th>
					<?php
					for ($w = 1; $w <= 6; $w++): ?>
						<th>W<?= strftime("%W", time())+$w ?></th>
					<?php $i++; endfor; ?>
				</tr>
			</thead>
			<tbody>
			<?php
			$i = 1;
			foreach ($Ressource->GETRessourcesList('',false) as $data): ?>
			<tr>
				<td><a href="admin.php?page=manage-methodes&resources=<?= $data->Id ?>"><?=  $data->LABEL ?></a></td>
				<?php
					for ($w = 1; $w <= 7; $w++): ?>
						<td>%</t>
					<?php $i++; endfor; ?>
			</tr>
			<?php $i++; endforeach; ?>
			</tbody>
		</table>
	</div>
	<div id="div3" class="tabcontent" >
	</div>
	<div id="div4" class="tabcontent" >
	</div>