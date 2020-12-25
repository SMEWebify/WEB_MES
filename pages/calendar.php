<?php 
	//phpinfo();
	use \App\Autoloader;
	use \App\Form;

	//auto load class
	require_once '../app/Autoload.class.php';
	Autoloader::register();
	
	session_start();
	header( 'content-type: text/html; charset=utf-8' );
	//session checking  user
	require_once '../include/include_checking_session.php';
	//init form class
	$Form = new Form($_POST);

	//Check if the user is authorized to view the page
	if($_SESSION['page_9'] != '1'){
		stop($langue->show_text('SystemInfoAccessDenied'), 161, 'index.php?page=login');
	}

	if(isset($_GET['mois']) & isset($_GET['annee'])){
		$mois = intval($_GET['mois']);
		$annee = intval($_GET['annee']);
	}
?>
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
		echo '<a href="index.php?page=calendar&mois='.($mois-1).'&amp;annee='.$annee.'">«</a> ';
	}
	else	{
		echo '<a href="index.php?page=calendar&mois=12&amp;annee='.($annee-1).'">«</a> ';
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
								echo '<a href="index.php?page=calendar&mois='.($mois+1).'&amp;annee='.$annee.'">»</a>
									<br/>
									<br/>';
	}
	else{
								echo '<a href="index.php?page=calendar&mois=01&amp;annee='.($annee+1).'">»</a>
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

	$query='SELECT id, LABEL
						FROM `'. TABLE_ERP_COMMANDE_LIGNE .'`
						WHERE DELAIS_INTERNE
							BETWEEN "'.$annee.'-'.$mois.'-01 00:00:00"
							AND "'.$annee.'-'.$mois.'-'.$nombrejours.' 23:59:59"
						ORDER BY id ASC';

	unset($cles) ;
	$id=array() ;
	$titres=array() ;
	$datesdebut=array() ;
	$heuresdebut=array() ;
	$datesfin=array() ;
	$heuresfin=array() ;
	$nombreresultat=0 ;

	foreach ($bdd->GetQuery($query, false) as $data):
		$debut=explode(' ', $data->debut) ;

		if(!empty($data['fin'])){
			$fin=explode(' ', $data->fin) ;
		}
		$id[$nombreresultat]=$data->id ;
		$titres[$nombreresultat]=htmlspecialchars($data->titre) ;
		$datesdebut[$nombreresultat]=$debut[0] ;
		$heuresdebut[$nombreresultat]=substr($debut[1], 0, 5) ;

		if(!empty($data->fin)){
			$datesfin[$nombreresultat]=$fin[0] ;
			$heuresfin[$nombreresultat]=substr($fin[1], 0, 5) ;
		}

		$nombreresultat++ ;
	endforeach;

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
										echo "\n\t\t\t\t\t\t\t\t\t\t\t";
										if(array_key_exists($cle, $datesfin) && $datesfin[$cle]==$datesdebut[$cle]){
											echo '<h6>'.$titres[$cle].'</h6>' ;
										}
										elseif(array_key_exists($cle, $datesfin) && $datesfin[$cle]==$annee.'-'.$mois.'-'.$jour){
											echo '<h6>Fin de : '.$titres[$cle].'</h6>' ;
										}
										else{
											echo '<h6>'.$titres[$cle].'</h6>' ;
										}
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

