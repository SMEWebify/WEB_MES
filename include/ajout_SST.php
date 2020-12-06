<?php

	
	$DateDuJour = date('Y-m-d');
	
	
	$contenu_tableau = '';
	
	
	if(empty($_POST['id_ligne'])){
		
		$selected_checkbox = 0;
	}
	else{
		
		$selected_checkbox = implode(",",$_POST['id_ligne']);
	}
		
		
	$res = $bdd->query('select count(*) as nb  FROM `'. TABLE_ERP_PLANNING .'` WHERE id IN ('. $selected_checkbox . ')  AND sup!=1');
	$data = $res->fetch();
	$nb = $data['nb'];
		
	if($nb == 0){
			$contenu = '
						<p class="message">
							
							Aucune commande à afficher<br/>
							<br/>
							<input type="button" value="Retour" onClick="window.history.back()">
						
						</p>';
	}
	else{
							
		$req = $bdd->prepare('SELECT * FROM `'. TABLE_ERP_PLANNING .'` WHERE id IN ('. $selected_checkbox . ')  AND sup!=1');
		$req->execute(array($selected_checkbox));
		while($donnees = $req->fetch())
		{
			$date_MI = join('/',array_reverse(explode('-',$donnees['DATE_CONFIRM'])));
				
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
				$classStatuLivraison ='class="Tableau_blanc" ';
			}
			
			$contenu_tableau = $contenu_tableau.'
			<tr> 
				<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="commande">
					<input type="hidden" name="id_ajout_SST_ligne[]" value="'. $donnees['id'] .'">
					<input type="hidden" name="COMMANDE[]" value="'. $donnees['COMMANDE'] .'">
					<a href="planning.php?ref_CO='. $donnees['COMMANDE'] .'"><span title="'. $donnees['DEVIS'] .'">'. $donnees['COMMANDE'] .'</a></span>
					</td> 
				<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="co-client"><a href="planning.php?ref_CO_CLI='. $donnees['CO_CLIENT'] .'">'. $donnees['CO_CLIENT'] .'</a></td> 
				<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="CLIENT"><p class="CELLULE_CLIENT"><a href="planning.php?CLIENT='. $donnees['CLIENT'] .'">'. $donnees['CLIENT'] .'</a></p></td> 
				<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="PLAN"><p class="CELLULE_PLAN"><span title="'. $donnees['COMMENTAIRES'] .'">'. PLAN($donnees['PLAN'], $donnees['id_RECURENT']) .'</span></p></td> 
				<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="DESIGNATION"><p class="CELLULE_DESIGNATION">'. $donnees['DESIGNATION'] .'</p></td> 
				<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="QT"><p class="EN_GRAS">'. $donnees['QT'] .'</p></td> 
				<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="prix_u"> '. $donnees['PRIX_U'] .'</td> 
				<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="MATIERE"><p class="CELLULE_MATIERE">'. $donnees['MATIERE'] .'</p></td> 
				<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="EPAISSEUR"><p class="CELLULE_EPAISSEUR">'. $donnees['EPAISSEUR'] .'</p></td> 
				<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .'  '. $classStatuLivraison .'>'. $date_MI .'</td>
				<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="Tableau_87CEFA" ><input type="text" name="FOURNISSEUR[]" size="10"></td>
				<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="Tableau_87CEFA" ><input type="text" name="CMD_ACHAT[]" size="10"></td>
				<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="Tableau_87CEFA" ><input type="text" name="DATE_RELANCE[]""></td>
				<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="Tableau_87CEFA" ><input type="text" name="DATE_RECEPTION[]"></td>
				<td  '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .'class="Tableau_87CEFA" ><input type="text" name="PRIX[]" size="1"></td>
				<td  '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .'class="Tableau_87CEFA" ><input type="text" name="NUM_OFFRE[]" size="1"></td>
				<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="Tableau_87CEFA" >
					<select name="ORDRE[]">
						<option value="-1">Avant Laser</option>
						<option value="-2">Avant Ebavurage</option>
						<option value="-3">Avant Parachèvement</option>
						<option value="-4">Avant Pliage</option>
						<option value="-5">Avant Soudure</option>
						<option value="1" selected>Fin de process 1</option>
						<option value="2">Fin de process 2</option>
						<option value="3">Fin de process 3</option>
						<option value="4">Fin de process 4</option>
					</select>
				</td>
				<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="Tableau_87CEFA" ><input type="text" name="COMMENTAIRE[]"  size="50"></td>
			</tr>';
			
			$commandeENCours = $donnees['COMMANDE'];
		}
		
		$req->closeCursor();
		
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
							<th>Date relance (jj/mm/aaaa)</th>
							<th>Date reception (jj/mm/aaaa)</th>
							<th>Prix</th>
							<th>N°Offre</th>
							<th>Gamme</th>
							<th>'. EN_TETE_TABLEAU_COL_66 .'</th>
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
					</tr>
				</tfoot>
			</table>
			<p>
				<br/>
				<input type="button" value="Retour" onClick="window.history.back()"><input type="submit" value="Ajouter sous-traitance" />
			</p>
		</form>';
	}
?>