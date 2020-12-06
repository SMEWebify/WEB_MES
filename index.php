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
	
	if($_SESSION['page_1'] != '1'){
		
		stop('L\'accès vous est interdit.', 161, 'connexion.php');
	}
	
	
	$req = $bdd->query("SELECT id, ETAT, TIMESTAMP, TEXT FROM ". TABLE_ERP_INFO_GENERAL ." WHERE ETAT =1 ORDER BY id DESC LIMIT 0, 10");
		
		$class = array('left', 'right');
		$nb = count($class);
		$i = 0;
		
		while ($donnees = $req->fetch()){
				
				$info_secteur = $info_secteur .'
				<div class="container-timeline '.$class[$i%$nb].'">
					<div class="content-timeline">
						<h2>'. format_temps($donnees['TIMESTAMP']) .'</h2>
						<p>'. nl2br(htmlspecialchars($donnees['TEXT'])) .'</p>
					</div>
				</div>';
		$i++;
		}
		
	$req = $bdd -> query('SELECT '. TABLE_ERP_EMPLOYEES .'.NOM,
									'. TABLE_ERP_EMPLOYEES .'.PRENOM,
									'. TABLE_ERP_EMPLOYEES .'.PRENOM,
									'. TABLE_ERP_EMPLOYEES .'.MAIL,
									'. TABLE_ERP_EMPLOYEES .'.NUMERO_INTERNE,
									'. TABLE_ERP_EMPLOYEES .'.IMAGE_PROFIL,
									'. TABLE_ERP_EMPLOYEES .'.FONCTION,
									'. TABLE_ERP_SECTION .'.LABEL,
									'. TABLE_ERP_RIGHTS .'.RIGHT_NAME
									FROM `'. TABLE_ERP_EMPLOYEES .'` 
									LEFT JOIN `'. TABLE_ERP_RIGHTS .'` ON `'. TABLE_ERP_EMPLOYEES .'`.`FONCTION` = `'. TABLE_ERP_RIGHTS .'`.`id`
									LEFT JOIN `'. TABLE_ERP_SECTION .'` ON `'. TABLE_ERP_EMPLOYEES .'`.`SECTION_ID` = `'. TABLE_ERP_SECTION .'`.`id`');
	while ($donnees_membre = $req->fetch())
	{
		if(!empty($donnees_membre['IMAGE_PROFIL'])){
			$image = $donnees_membre['IMAGE_PROFIL'];
		}
		else{
			$image = 'images/Profils/img_avatar.png';
			
		}
		$Employees .=  '<div class="column">
							<div class="card">
								<img src="'. $image .'" alt="Profil" class="Image-Logo">
								<h3>'. $donnees_membre['PRENOM'] .' '. $donnees_membre['NOM'] .'</h3>
								<p>'. $donnees_membre['RIGHT_NAME'] .'</p>
								<p>'. $donnees_membre['NUMERO_INTERNE'] .'</p>
								<p><button onClick="location.href=\'mailto:'. $donnees_membre['MAIL'] .'\'">Contact</button></p>
							</div>
						  </div>';
		$i++;
	}
	
	$contenu = '
					<div id="info_millieu">
						<table class="content-table">
							<thead>
								<tr>
									<td colspan="2"  >
										Reception Sous-Traitance
									</td>
								</tr>
							</thead>
							<tbody>
								'. $SST .'
							</tbody>
						</table>
						<table class="content-table">
							<tr>
								<td colspan="2"  >
									Retard  ('. $i_retard_cmd .')
									<a href="pdf.php?operation=retard" onclick="window.open(this.href); return false;" >Impression</a>
								</td>
							</tr>

							'. $retard_cmd .'
							
							<tr>
								<td colspan="2"  >
									Commande au départ Aurjoud\'hui
									<a href="pdf.php?operation=expedition" onclick="window.open(this.href); return false;" >Impression</a>
								</td>
							</tr>

							'. $départ_cmd .'
							
							<tr>
								<td colspan="2" >
									Commande au départ demain
								</td>
							</tr>
							
							'. $départ_48_cmd .'
							<tr>
								<td colspan="2" >
									Commande à confirmer ('. $i_cmd_a_confirmer .')  
								</td>
							</tr>
							
							'. $cmd_a_confirmer .'
							
						</table>
					</div>';
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

	<div class="tab">
		<button class="tablinks" onclick="openDiv(event, 'div1')" id="defaultOpen">Infos</button>
		<button class="tablinks" onclick="openDiv(event, 'div2')">Statu commandes</button>
		<button class="tablinks" onclick="openDiv(event, 'div3')">Contact</button>
	</div>
	<div id="div1" class="tabcontent" >
<?php

	Echo '<div class="timeline">
			'. $info_secteur .'
			</div>';
?>
	</div>
	<div id="div2" class="tabcontent" >
<?php


?>
	</div>
	<div id="div3" class="tabcontent" >
		<div class="row">
<?php
			echo $Employees;
?>
		</div>
	</div>
</body>
</html>