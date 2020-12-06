<?php

	
	$DateDuJour = date('Y-m-d');
	
	$SommeQt = 0;
	$SommePrix =0;
	$SommeHeure_laser = 0;
	$SommeHeureProduite_laser = 0;
	$SommeHeure_pliage = 0;
	$SommeHeureProduite_pliage = 0;
	$SommeHeure_ebav = 0;
	$SommeHeureProduite_ebav = 0;
	$SommeHeure_para = 0;
	$SommeHeureProduite_para = 0;
	$SommeHeure_MIG = 0;
	$SommeHeureProduite_MIG = 0;
	$SommeHeure_TIG = 0;
	$SommeHeureProduite_TIG = 0;
	$SommePoids = 0;
	
	$BddSemProd = "";

		
	$contenu = $contenu .'
				<form  method="post" action="planning.php" id="formulaire_sem">
					<p style="color : White; text-align: center;">
							<br/>
							Etes vous sur de vouloirs annuler les informations ci-dessous ?<br/>
						<br/>
					</p>
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
								<th>'. EN_TETE_TABLEAU_COL_08 .'</th>
								<th>'. EN_TETE_TABLEAU_COL_09 .'</th>
								<th>'. EN_TETE_TABLEAU_COL_10 .'</th>
								<th>'. EN_TETE_TABLEAU_COL_11 .'</th>
								<th>'. EN_TETE_TABLEAU_COL_12 .'</th>

							</tr>
						</thead>
					<tbody>';
					
	$selected_checkbox = implode(",",$_POST['id_ligne']);
	
	$res = $bdd->query('select count(*) as nb  FROM `'. TABLE_ERP_PLANNING .'` WHERE id IN ('. $selected_checkbox . ') AND sup!=1');
	$data = $res->fetch();
	$nb = $data['nb'];
		
	if($nb == 0){
			$contenu = '
						<p class="message">
							<br/>
								Aucune commande à afficher<br/>
							<br/>
							<input type="button" value="Retour" onClick="window.history.back()">
						
						</p>';
	}
	else{
		
		$req = $bdd->prepare('SELECT * FROM `'. TABLE_ERP_PLANNING .'` WHERE id IN ('. $selected_checkbox . ') AND sup!=1');
		$req->execute(array($selected_checkbox));
		while($donnees = $req->fetch())
		{
			$date_client = join('/',array_reverse(explode('-',$donnees['DATE_CLIENT'])));
			If($date_client == "00/00/0000") $date_client = "";
			
			$date_MI = join('/',array_reverse(explode('-',$donnees['DATE_CONFIRM'])));
				
			if($donnees['QT_EXPEDIER'] >= $donnees['QT_EXPEDIER']){
				$classStatuLivraison ='class="livrer"';
			}
			elseIf($donnees['DATE_CONFIRM'] > $DateDuJour ){
				$classStatuLivraison ='class="avance_date"';
			}
			elseif($donnees['DATE_CONFIRM'] < $DateDuJour) {
				$classStatuLivraison ='class="retard_date"';
			}
			else{
				$classStatuLivraison ='';
			}
				
			$contenu = $contenu.'
			<tr> 
				<td class="commande"><input type="hidden" name="id_anul_ligne[]" value="'. $donnees['id'] .'"> '. $donnees['COMMANDE'] .'</td> 
				<td class="co-client">'. $donnees['CO_CLIENT'] .'</td> 
				<td class="CLIENT"><p class="CELLULE_CLIENT">'. $donnees['CLIENT'] .'</p></td> 
				<td class="PLAN"><p class="CELLULE_PLAN">'. $donnees['PLAN'] .'</p></td> 
				<td class="DESIGNATION"><p class="CELLULE_DESIGNATION">'. $donnees['DESIGNATION'] .'</p></td> 
				<td class="QT"><p class="EN_GRAS">'. $donnees['QT'] .'</p></td> 
				<td class="prix_u">'. $donnees['PRIX_U'] .'</td> 
				<td class="prix_total">'. $donnees['PRIX_U']*$donnees['QT'] .'</td> 
				<td class="MATIERE"><p class="CELLULE_MATIERE">'. $donnees['MATIERE'] .'</p></td> 
				<td class="EPAISSEUR"><p class="CELLULE_EPAISSEUR">'. $donnees['EPAISSEUR'] .'</p></td> 
				<td class="Tableau_blanc">'. $date_client .'</td>
				<td '. $classStatuLivraison .'>'. $date_MI .'</td>';
				
			$SommeQt = $SommeQt + $donnees['QT'];
			$SommePrix = $SommePrix + $donnees['PRIX_U']*$donnees['QT'];
			
			$SommeHeure_laser = $SommeHeure_laser + $donnees['TRUMPH_1'];
			$SommeHeureProduite_laser = $SommeHeureProduite_laser + $donnees['TPS_PRODUIT_L'];
			$SommeHeure_pliage = $SommeHeure_pliage + $donnees['PLIAGE'];
			$SommeHeureProduite_pliage = $SommeHeureProduite_pliage + $donnees['TPS_PRODUIT_PLI'];
			$SommeHeure_ebav = $SommeHeure_ebav + $donnees['EBAVURAGE'];
			$SommeHeureProduite_ebav = $SommeHeureProduite_ebav + $donnees['TPS_PRODUIT_EBAV'];
			$SommeHeure_para = $SommeHeure_para + $donnees['PARACHEVEMENT'];
			$SommeHeureProduite_para = $SommeHeureProduite_para + $donnees['TPS_PRODUIT_P'];
			$SommeHeure_MIG = $SommeHeure_MIG + $donnees['SOUDURE_MIG'];
			$SommeHeureProduite_MIG = $SommeHeureProduite_MIG + $donnees['TPS_PRODUIT_MIG'];
			$SommeHeure_TIG = $SommeHeure_TIG + $donnees['SOUDURE_TIG'];
			$SommeHeureProduite_TIG = $SommeHeureProduite_TIG + $donnees['TPS_PRODUIT_TIG'];
			$SommePoids = $SommePoids + $donnees['POIDS'];
		}
		
		$req->closeCursor();
		
		$contenu = $contenu. 
			'
				</tbody>
				<tfoot>
					<tr> 
						<th> TOTAL </th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th> '. $SommeQt .'</th>
						<th></th>
						<th> '. $SommePrix .'</th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
				</tfoot>
			</table>
			<p>
				<br/>
				<input type="button" value="Retour" onClick="window.history.back()"><input type="submit" value="Annuler les lignes" />
			</p>
		</form>';	
		}
?>