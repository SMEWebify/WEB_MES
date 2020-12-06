<?php session_start();

	header( 'content-type: text/html; charset=utf-8' );

	//phpinfo();

	//include pour la connection à la base SQL 
	require_once 'include/include_connection_sql.php';
	//include pour les fonctions
	require_once 'include/include_fonctions.php';
	//include pour les constantes
	require_once 'include/include_recup_config.php';

	if(isset($_SESSION['mdp'])){
		//verification  de la session
		require_once 'include/verifications_session.php';
	}
	else{
		stop('Aucune session ouverte, l\'accès vous est interdit.', 160, 'connexion.php');
	}
	
	if($_SESSION['page_9'] != '1'){
		
		stop('L\'accès vous est interdit.', 161, 'connexion.php');
	}

	if(isset($_GET['mois']) & isset($_GET['annee'])) 
	{
		$mois = intval($_GET['mois']);
		$annee = intval($_GET['annee']);
	}
				
	setlocale(LC_ALL, 'fr_FR.utf-8', 'fr_FR','fr','fr','fra','fr_FR@euro');
				
	if((empty($_GET["mois"]) || !ctype_digit($_GET["mois"]) || $_GET["mois"]<=0 || $_GET["mois"]>12) && !isset($mois))
	{
		$mois=date('m') ;
	}
	elseif(!empty($_GET["mois"]) && ctype_digit($_GET["mois"]) && $_GET["mois"]>0 && $_GET["mois"]<=12 && !isset($mois))
	{	
		if(strlen($_GET["mois"])==1)
		{
			$mois='0'.$_GET["mois"] ;
		}
		else
		{
			$mois=$_GET["mois"] ;
		}
	}
	elseif(isset($mois) && strlen($mois)==1)
	{
		$mois='0'.$mois ;
	}
				
	if((empty($_GET["annee"]) || !ctype_digit($_GET["annee"])) && !isset($annee))
	{
		$annee=date('Y') ;
	}
	elseif(!isset($annee))
	{
		$annee=$_GET["annee"] ;
	}
			
	$timestampreference=mktime(1, 0, 0, $mois, 1, $annee) ;
	$nombrejours=date('t', $timestampreference) ;
	$iterations=0 ;
	$jour=1 ;
	$correspondancejourfr=array(1 => 'lu', 2 => 'ma', 3 => 'me', 4 => 'je', 5 => 've', 6 => 'sa', 7 => 'di') ;
	$correspondancejouren=array(1 => 'mo', 2 => 'tu', 3 => 'we', 4 => 'th', 5 => 'fr', 6 => 'sa', 7 => 'su') ; 

	if($mois!=01)
	{
		$contenu .='<a href="calendrier.php?mois='.($mois-1).'&amp;annee='.$annee.'">«</a> ';
	}
	else
	{
		$contenu .='<a href="calendrier.php?mois=12&amp;annee='.($annee-1).'">«</a> ';
	}
		
	if(setlocale(LC_ALL, 'fr_FR.utf-8', 'fr_FR','fr','fr','fra','fr_FR@euro'))
	{
		$contenu .= ucfirst(strftime('%B', $timestampreference)).' '.$annee ; 
	}
	else
	{
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
										
		$contenu .= $correspondancesmois[strftime('%B', $timestampreference)].' '.$annee ;
	}	

	if($mois!=12)
	{
								$contenu .='<a href="calendrier.php?mois='.($mois+1).'&amp;annee='.$annee.'">»</a>
									<br/>
									<br/>';
	}
	else
	{
								$contenu .='<a href="calendrier.php?mois=01&amp;annee='.($annee+1).'">»</a>
									<br/>
									<br/>';	
	}	

					$contenu .="\n\t\t\t\t\t\t\t\t";
					$contenu .='</th>
							</tr>
							<tr>
								<th>Lundi</th><th>Mardi</th><th>Mercredi</th><th>Jeudi</th><th>Vendredi</th><th>Samedi</th><th>Dimanche</th>
							</tr>
						</thead>
						<tbody>
							<tr>';
						
	$req = $bdd -> query('SELECT id, LABEL
						FROM `'. TABLE_ERP_COMMANDE_LIGNE .'`
						WHERE DELAIS_INTERNE
							BETWEEN "'.$annee.'-'.$mois.'-01 00:00:00"
							AND "'.$annee.'-'.$mois.'-'.$nombrejours.' 23:59:59"
						ORDER BY id ASC') ;
						
	unset($cles) ;
	$id=array() ;
	$titres=array() ;		
	$datesdebut=array() ;
	$heuresdebut=array() ;
	$datesfin=array() ;
	$heuresfin=array() ;
	$nombreresultat=0 ;
						
	while($donnees=$req->fetch())
	{
		$debut=explode(' ', $donnees['debut']) ;
							
		if(!empty($donnees['fin'])){
			$fin=explode(' ', $donnees['fin']) ;
		}
		$id[$nombreresultat]=$donnees['id'] ;
		$titres[$nombreresultat]=htmlspecialchars($donnees['titre']) ;
		$datesdebut[$nombreresultat]=$debut[0] ;
		$heuresdebut[$nombreresultat]=substr($debut[1], 0, 5) ;
							
		if(!empty($donnees['fin'])){
			$datesfin[$nombreresultat]=$fin[0] ;
			$heuresfin[$nombreresultat]=substr($fin[1], 0, 5) ;
		}
			
		$nombreresultat++ ;
	}
						
	while($iterations<35)
	{
		$iterations++ ;
		$valeur=$iterations-7*floor($iterations/7.1) ;
								
		if(strlen($jour)==1){
			$jour='0'.$jour ;
		}
		
		if((substr(strftime('%A', $timestampreference), 0, 2)==$correspondancejourfr[$valeur] || strtolower(substr(strftime('%A', $timestampreference), 0, 2))==$correspondancejouren[$valeur])&& $jour<=$nombrejours)
		{
								$contenu .="\n\t\t\t\t\t\t\t\t";
								$contenu .='<td' ;
								
								if($timestampreference==mktime(0, 0, 0))
								{
									$contenu .='class="today" ';
								}
								if(in_array($annee.'-'.$mois.'-'.$jour, $datesdebut) || in_array($annee.'-'.$mois.'-'.$jour, $datesfin)) 
								{
									$cles=array_keys($datesdebut, $annee.'-'.$mois.'-'.$jour) ;
									$cles+=array_keys($datesfin, $annee.'-'.$mois.'-'.$jour) ;
								}
								
								$contenu .='>
									<span class="jour">'.$jour.'</span>
									<div class="eventslist">';

								if(in_array($annee.'-'.$mois.'-'.$jour, $datesdebut) || in_array($annee.'-'.$mois.'-'.$jour, $datesfin))
								{
									$contenu .="\n\t\t\t\t\t\t\t\t\t\t";
									$contenu .='<div class="evenement">' ;
									foreach($cles as $cle)
									{
										$contenu .="\n\t\t\t\t\t\t\t\t\t\t\t";
										if(array_key_exists($cle, $datesfin) && $datesfin[$cle]==$datesdebut[$cle])
										{
											$contenu .='<h6>'.$titres[$cle].'</h6>' ;
										}
										elseif(array_key_exists($cle, $datesfin) && $datesfin[$cle]==$annee.'-'.$mois.'-'.$jour)
										{
											$contenu .='<h6>Fin de : '.$titres[$cle].'</h6>' ;
										}
										else
										{
											$contenu .='<h6>'.$titres[$cle].'</h6>' ;
										}
									}
									$contenu .="\n\t\t\t\t\t\t\t\t\t\t";
									$contenu .='</div>' ;
								}
						$contenu .="\n\t\t\t\t\t\t\t\t\t";
						$contenu .='</div>
								</td>' ;
			$jour++ ;
			$timestampreference+=24*60*60 ;
		}
		else
		{
					$contenu .="\n\t\t\t\t\t\t\t\t";
					$contenu .='<td>
									<div class="jour_vide"></div>
								</td>' ;
		}
							
		if(($iterations%7)==0 && $jour!=$nombrejours && $iterations!=35)
		{
			$contenu .="\n\t\t\t\t\t\t\t";
			$contenu .='</tr>
							<tr>' ;
		}
							
		if($iterations==35 && $jour<=$nombrejours)
		{
			$contenu .="\n\t\t\t\t\t\t\t";
			$contenu .='<tr>
							<tr>' ;
			$iterations-=7 ;
		}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
<?php
	//include interface
	require_once 'include/include_header.php';

?>
</head>
<body>
<?php
	//include interface
	require_once 'include/include_interface.php';

?>
<section>
<div id="grand_calendrier">
					<table class="content-table-decal">
						<thead>
							<tr>
								<th colspan="7">
<?php

	echo $contenu;

?>
								</tr>
						</tbody>
					</table>
</div>
</section>

</body>
</html>