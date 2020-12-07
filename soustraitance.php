<?php session_start();

	header( 'content-type: text/html; charset=utf-8' );

	//phpinfo();

	//include for the connection to the SQL database
	require_once 'include/include_connection_sql.php';
	// include for functions
	require_once 'include/include_fonctions.php';
	// include for the constants
	require_once 'include/include_recup_config.php';

	//session verification user
	if(isset($_SESSION['mdp'])){
		require_once 'include/verifications_session.php';
	}
	else{
		stop('Aucune session ouverte, l\'accès vous est interdit.', 160, 'connexion.php');
	}

	//Check if the user is authorized to view the page
	if($_SESSION['page_3'] != '1'){

		stop('L\'accès vous est interdit.', 161, 'connexion.php');
	}

	// INIT DE LA VARIABLE CONTENU
	$contenu = "";
	$contenu_tableau ="";

	// INIT DES VARIABLE DE DATE
	$DateDuJour = date('Y-m-d');
	$DateDemain = date('Y-m-d', strtotime('+1 days'));
	$DatesurDemain = date('Y-m-d', strtotime('+2 days'));
	$DateUneSemaine = date('Y-m-d', strtotime('+7 days'));

	$Contenu_tableau ='';


	if(isset($_GET['ok_relance']) AND !empty($_GET['ok_relance'])){
		$res = $bdd->query('select count(*) as nb from `'. TABLE_ERP_SOUS_TRAITANCE .'` WHERE id='. $_GET['ok_relance'] .'');
		$data = $res->fetch();
		$nb = $data['nb'];
		if($nb == 1){

			$bdd->exec('UPDATE `'. TABLE_ERP_SOUS_TRAITANCE .'` SET  STATU_RELANCE =1 WHERE id='. $_GET['ok_relance'] .'');

		}

	}

	if(isset($_GET['ok_reception']) AND !empty($_GET['ok_reception'])){
		$res = $bdd->query('select count(*) as nb from `'. TABLE_ERP_SOUS_TRAITANCE .'` WHERE id='. $_GET['ok_reception'] .'');
		$data = $res->fetch();
		$nb = $data['nb'];
		if($nb == 1){

			$bdd->exec('UPDATE `'. TABLE_ERP_SOUS_TRAITANCE .'` SET  STATU_RECEPTION =1 WHERE id='. $_GET['ok_reception'] .'');

		}

	}

	if(isset($_GET['id_cmd']) AND !empty($_GET['id_cmd'])) $ComplementSQL = '
									`'. TABLE_ERP_SOUS_TRAITANCE .'`.`id_cmd`='. $_GET['id_cmd'] .'
									ORDER BY `'. TABLE_ERP_SOUS_TRAITANCE .'`.`DATE_RECEPTION` ';
	else $ComplementSQL = '
									 `'. TABLE_ERP_SOUS_TRAITANCE .'`.`STATU_RECEPTION`=0
									ORDER BY `'. TABLE_ERP_SOUS_TRAITANCE .'`.`DATE_RECEPTION`, `'. TABLE_ERP_PLANNING .'`.`COMMANDE` ';

	$req = $bdd->query('SELECT `'. TABLE_ERP_SOUS_TRAITANCE .'`.`id` as id_SST,
								`'. TABLE_ERP_SOUS_TRAITANCE .'`.`id_cmd`,
								`'. TABLE_ERP_SOUS_TRAITANCE .'`.`DATE_RELANCE`,
								`'. TABLE_ERP_SOUS_TRAITANCE .'`.`STATU_RELANCE`,
								`'. TABLE_ERP_SOUS_TRAITANCE .'`.`DATE_RECEPTION`,
								`'. TABLE_ERP_SOUS_TRAITANCE .'`.`STATU_RECEPTION`,
								`'. TABLE_ERP_SOUS_TRAITANCE .'`.`FOURNISSEUR`,
								`'. TABLE_ERP_SOUS_TRAITANCE .'`.`CMD_ACHAT`,
								`'. TABLE_ERP_SOUS_TRAITANCE .'`.`PRIX`,
								`'. TABLE_ERP_SOUS_TRAITANCE .'`.`NUM_OFFRE`,
								`'. TABLE_ERP_SOUS_TRAITANCE .'`.`ORDRE`,
								`'. TABLE_ERP_PLANNING .'`.`id`,
								`'. TABLE_ERP_PLANNING .'`.`id_RECURENT`,
								`'. TABLE_ERP_PLANNING .'`.`SUP`,
								`'. TABLE_ERP_PLANNING .'`.`COMMANDE`,
								`'. TABLE_ERP_PLANNING .'`.`CO_CLIENT`,
								`'. TABLE_ERP_PLANNING .'`.`CLIENT`,
								`'. TABLE_ERP_PLANNING .'`.`PLAN`,
								`'. TABLE_ERP_PLANNING .'`.`DESIGNATION`,
								`'. TABLE_ERP_PLANNING .'`.`QT`,
								`'. TABLE_ERP_PLANNING .'`.`PRIX_U`,
								`'. TABLE_ERP_PLANNING .'`.`MATIERE`,
								`'. TABLE_ERP_PLANNING .'`.`EPAISSEUR`,
								`'. TABLE_ERP_PLANNING .'`.`DATE_CLIENT`,
								`'. TABLE_ERP_PLANNING .'`.`DATE_CONFIRM`,
								`'. TABLE_ERP_PLANNING .'`.`QT_EXPEDIER`
							FROM `'. TABLE_ERP_SOUS_TRAITANCE .'`
							LEFT JOIN `'. TABLE_ERP_PLANNING .'` ON `'. TABLE_ERP_SOUS_TRAITANCE .'`.`id_cmd`= `'. TABLE_ERP_PLANNING .'`.`id`
							WHERE '. $ComplementSQL .'');

	$i=0;

	while ($donnees = $req->fetch())
	{
		$DATE_RELANCE = join('/',array_reverse(explode('-',$donnees['DATE_RELANCE'])));
		if($DATE_RELANCE == "00/00/0000") $DATE_RELANCE = "";
		$DATE_RECEPTION = join('/',array_reverse(explode('-',$donnees['DATE_RECEPTION'])));
		if($DATE_RECEPTION == "00/00/0000") $DATE_RECEPTION = "";

		$date_MI = join('/',array_reverse(explode('-',$donnees['DATE_CONFIRM'])));


		if($donnees['ORDRE'] == -1) $ORDRE ='Avant laser';
		elseif($donnees['ORDRE'] == -2) $ORDRE ='Avant Ebavurage';
		elseif($donnees['ORDRE'] == -3) $ORDRE ='Avant Parachèvement';
		elseif($donnees['ORDRE'] == -4) $ORDRE ='Avant Pliage';
		elseif($donnees['ORDRE'] == -5) $ORDRE ='Avant Soudure';
		elseif($donnees['ORDRE'] == 1) $ORDRE ='Fin de process 1';
		elseif($donnees['ORDRE'] == 2) $ORDRE ='Fin de process 2';
		elseif($donnees['ORDRE'] == 3) $ORDRE ='Fin de process 3';
		elseif($donnees['ORDRE'] == 4) $ORDRE ='Fin de process 4';

		if($donnees['STATU_RELANCE'] == 1){
			$class_STATU_RELANCE='livrer';
		}
		elseIf($donnees['DATE_RELANCE'] == $DateDemain ){
			$class_STATU_RELANCE ='Date_lendemain';
		}
		elseIf($donnees['DATE_RELANCE'] == $DatesurDemain ){
			$class_STATU_RELANCE = 'Date_sur_lendemain';
		}
		elseIf($donnees['DATE_RELANCE'] == $DateDuJour ){
			$class_STATU_RELANCE = 'Date_DU_JOUR';;
		}
		elseif($donnees['DATE_RELANCE'] < $DateDuJour) {
			$class_STATU_RELANCE = 'retard_date';
		}
		else{
			$class_STATU_RELANCE='Tableau_87CEFA';
		}

		if($donnees['STATU_RECEPTION'] == 1){
			$class_STATU_RECEPTION='livrer';
		}
		elseIf($donnees['DATE_RECEPTION'] == $DateDemain ){
			$class_STATU_RECEPTION ='Date_lendemain';
		}
		elseIf($donnees['DATE_RECEPTION'] == $DatesurDemain ){
			$class_STATU_RECEPTION = 'Date_sur_lendemain';
		}
		elseIf($donnees['DATE_RECEPTION'] == $DateDuJour ){
			$class_STATU_RECEPTION = 'Date_DU_JOUR';;
		}
		elseif($donnees['DATE_RECEPTION'] < $DateDuJour) {

			$class_STATU_RECEPTION = 'retard_date';
		}
		else{
			$class_STATU_RECEPTION='Tableau_87CEFA';
		}

		if($donnees['QT_EXPEDIER'] >= $donnees['QT']){
			$classStatuLivraison = 'class="livrer"';
		}
		elseIf($donnees['DATE_CONFIRM'] == $DateDemain ){

			$classStatuLivraison ='class="Date_lendemain"';
		}
		elseIf($donnees['DATE_CONFIRM'] == $DatesurDemain ){
			$classStatuLivraison = 'class="Date_sur_lendemain"';
		}
		elseIf($donnees['DATE_CONFIRM'] == $DateDuJour ){
			$classStatuLivraison = 'class="Date_DU_JOUR"';;
		}
		elseIf($donnees['DATE_CONFIRM'] > $DateDuJour ){
			$classStatuLivraison = 'class="avance_date"';
		}
		elseif($donnees['DATE_CONFIRM'] < $DateDuJour) {
			$classStatuLivraison = 'class="retard_date"';
		}
		else{
			$classStatuLivraison =' ';
		}

		$contenu_tableau = $contenu_tableau.'
			<tr>
				<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="commande">
					<a href="planning.php?ref_CO='. $donnees['COMMANDE'] .'"><span title="'. $donnees['DEVIS'] .'">'. $donnees['COMMANDE'] .'</a></span>
				</td>
				<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="co-client"><a href="planning.php?ref_CO_CLI='. $donnees['CO_CLIENT'] .'" >'. $donnees['CO_CLIENT'] .'</a></td>
				<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="CLIENT"><p class="CELLULE_CLIENT"><a href="planning.php?CLIENT='. $donnees['CLIENT'] .'">'. $donnees['CLIENT'] .'</a></p></td>
				<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="PLAN"><p class="CELLULE_PLAN"><span title="'. $donnees['COMMENTAIRES'] .'">'. PLAN($donnees['PLAN'], $donnees['id_RECURENT']) .'</span></p></td>
				<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="DESIGNATION"><p class="CELLULE_DESIGNATION">'. $donnees['DESIGNATION'] .'</p></td>
				<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="QT"><p class="EN_GRAS">'. $donnees['QT'] .'</p></td>
				<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="prix_u"> '. $donnees['PRIX_U'] .'</td>
				<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="MATIERE"><p class="CELLULE_MATIERE">'. $donnees['MATIERE'] .'</p></td>
				<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="EPAISSEUR"><p class="CELLULE_EPAISSEUR">'. $donnees['EPAISSEUR'] .'</p></td>
				<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .'  '. $classStatuLivraison .'>'. $date_MI .'</td>
				<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="Tableau_87CEFA" ><span title="Affectation N°'. $donnees['id_SST'] .' ">'. $donnees['FOURNISSEUR'] .'</span></td>
				<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="Tableau_87CEFA" >'. Affichage_zero($donnees['CMD_ACHAT']) .'</td>
				<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="'. $class_STATU_RELANCE .'" >'. $DATE_RELANCE . ' </td>
				<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="Tableau_87CEFA" ><a href="?id_cmd='. $donnees['id_cmd'] .'&ok_relance='. $donnees['id_SST'] .'"><img src="image/ok.png" title="Relance Affectuée" alt="ok" /></a></td>
				<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="'. $class_STATU_RECEPTION .'" >'. $DATE_RECEPTION .' </td>
				<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="Tableau_87CEFA" ><a href="?id_cmd='. $donnees['id_cmd'] .'&ok_reception='. $donnees['id_SST'] .'"><img src="image/ok.png" title="Recetpion Affectuée" alt="ok" /></a></td>
				<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="Tableau_87CEFA" >'. $donnees['PRIX'] .'</td>
				<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="Tableau_87CEFA" >'. $donnees['NUM_OFFRE'] .'</td>
				<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="Tableau_87CEFA" >'.  $ORDRE .'</td>
				<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="Tableau_87CEFA" ><a href="?sup='. $donnees['id'] .'"><img src="image/supprimer.png" title="Sous-traitance à supprimer" alt="ok" /></a></td>
			</tr>';

			$commandeENCours = $donnees['COMMANDE'];
			$i++;
	}

	if($i == "0"){
		$contenu = '
				<p class="message">

						Aucune sous-traitance en cours

				</p>';

	}
	else{


		$contenu = $contenu.
			'<form  method="post" action="planning.php" id="formulaire_sem">
				<table id="tableau_plannig">
					<thead>
						<tr>
							<th>'. EN_TETE_TABLEAU_COL_01 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_02 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_03 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_04 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_05 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_06 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_07 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_09 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_10 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_12 .'</th>
							<th>Fournisseur</th>
							<th>N° cmd Achat</th>
							<th>Date relance</th>
							<th></th>
							<th>Date reception</th>
							<th></th>
							<th>Prix</th>
							<th>N°Offre</th>
							<th>Gamme</th>
							<th></th>
						</tr>
					</thead>
				<tbody>
				'. $contenu_tableau .'
				</tbody>
				<tfoot>
					<tr>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
				</tfoot>
			</table>';
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

	Echo $contenu;

?>


</body>
</html>
