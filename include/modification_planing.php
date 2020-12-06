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
	
	$contenu_tableau = '';

	$SelectZone_client = '<option value=""></option>';
	$reponse = $bdd -> query('SELECT DISTINCT CLIENT FROM `'. TABLE_ERP_PLANNING .'` ORDER BY CLIENT ');
	while ($donneesSelectZone = $reponse->fetch())
	{
		$SelectZone_client = $SelectZone_client .'
									<option value="'. $donneesSelectZone['CLIENT'] .'">'. $donneesSelectZone['CLIENT'] .'</option>';
	}
	
	
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
		
		$Select_piece_recurente = '';
		$reponse = $bdd -> query('SELECT DISTINCT id, CLIENT, PLAN, NOM_FICHIER FROM `'. TABLE_ERP_PIECE_RECURENTE .'` ORDER BY CLIENT ');
		while ($donneesSelectZone = $reponse->fetch())
		{
				if($client_en_cours != $donneesSelectZone['CLIENT']){
					$Select_piece_recurente = $Select_piece_recurente .'<option value=""></option>';
				}
					
			
				$Select_piece_recurente = $Select_piece_recurente .'<option value="'. $donneesSelectZone['id'] .'">'. $donneesSelectZone['CLIENT'] .' - '. $donneesSelectZone['PLAN'] .'</option>';
			
				$client_en_cours = $donneesSelectZone['CLIENT'];
		}
			
							
		$req = $bdd->prepare('SELECT * FROM `'. TABLE_ERP_PLANNING .'` WHERE id IN ('. $selected_checkbox . ')  AND sup!=1');
		$req->execute(array($selected_checkbox));
		while($donnees = $req->fetch())
		{
			if($donnees['SUP'] == 0 OR $donnees['SUP'] == 4 ){
				$date_client = join('/',array_reverse(explode('-',$donnees['DATE_CLIENT'])));
				If($date_client == "00/00/0000") $date_client = "";
				$date_MI = join('/',array_reverse(explode('-',$donnees['DATE_CONFIRM'])));
				
				$date_SST_DISPO = join('/',array_reverse(explode('-',$donnees['MISE_A_DISPO'])));
				If($date_SST_DISPO == "00/00/0000") $date_SST_DISPO = "";
				
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
					$classStatuLivraison ='';
				}
			}
			elseif($donnees['SUP'] == 2){
				$date_client = 'Annulé';
				$date_MI = 'Annulé';
			}
			elseif($donnees['SUP'] == 3){
				$date_client = 'Stock';
				$date_MI = 'Stock';
			}
				
			
			if($donnees['QT_PRODUIT_L'] < $donnees['QT'] AND !empty($donnees['TRUMPH_1'])){
				$classStatuHeuresLaser ='class="TRUMPH_1"';
				$classStatuLaserHeuresProduitesLaser ='class="TPS_PRODUIT_L"';
			}
			else{
				$classStatuHeuresLaser ='class="case_produite"'; 
				$classStatuLaserHeuresProduitesLaser ='class="case_produite"'; 
			}

			if($donnees['QT_PRODUIT_EBAV'] < $donnees['QT'] AND !empty($donnees['EBAVURAGE'])){
				$classStatuHeuresEbav ='class="EBAVURAGE"';
				$classStatuLaserHeuresProduitesEbav ='class="TPS_PROD_EBAVURAGE"';
			}
			else{
				$classStatuHeuresEbav ='class="Tableau_blege"'; 
				$classStatuLaserHeuresProduitesEbav ='class="Tableau_blege"'; 
			}
				
			if($donnees['QT_PRODUIT_PARA'] < $donnees['QT'] AND !empty($donnees['PARACHEVEMENT'])){
				$classStatuHeuresPara ='class="PARACHEVEMENT"';
				$classStatuLaserHeuresProduitesPara ='class="TPS_PROD_PARACHEVEMENT"';
			}
			else{
				$classStatuHeuresPara ='class="Tableau_MistyRose"'; 
				$classStatuLaserHeuresProduitesPara ='class="Tableau_MistyRose"'; 
			}
				
			if($donnees['QT_PRODUIT_PLI'] < $donnees['QT'] AND !empty($donnees['PLIAGE'])){
				$classStatuHeuresPliage ='class="PLIAGE"';
				$classStatuLaserHeuresProduitesPliage ='class="TPS_PROD_PLIAGE"';
			}
			else{
				$classStatuHeuresPliage ='class="Tableau_8FBC8F"'; 
				$classStatuLaserHeuresProduitesPliage ='class="Tableau_8FBC8F"'; 
			}
				
			if($donnees['QT_PRODUIT_MIG'] < $donnees['QT'] AND !empty($donnees['SOUDURE_MIG']) OR $donnees['QT_PRODUIT_TIG'] < $donnees['QT'] AND !empty($donnees['SOUDURE_TIG'])){
				$classStatuHeuresSoudure ='class="SOUDURE"';
				$classStatuLaserHeuresProduitesSoudure ='class="TPS_PROD_SOUDURE"';
			}
			else{
				$classStatuHeuresSoudure ='class="Tableau_F08080"'; 
				$classStatuLaserHeuresProduitesSoudure ='class="Tableau_F08080"'; 
			}
				
			$contenu_tableau = $contenu_tableau.'
			<tr> 
				<td class="commande"><input type="hidden" name="id_modif_ligne[]" value="'. $donnees['id'] .'"><br/><input type="text" name="num_cmd[]" value="'. $donnees['COMMANDE'] .'" size="6"><br/><br/></td> 
				<td class="co-client"><input type="text" name="cmd_client[]" value="'. $donnees['CO_CLIENT'] .'" size="10"></td> 
				<td class="CLIENT"><select name="CLIENT_NOM_MODIF[]" size="1"><option value="'. $donnees['CLIENT'] .'">'. $donnees['CLIENT'] .'</option>'. $SelectZone_client .'</select></td> 
				<td class="PLAN"><input type="text" name="plan[]" value="'. $donnees['PLAN'] .'" size="12"></td> 
				
				<td class="PLAN">
					<select name="ID_PLAN[]">
						'. $Select_piece_recurente .'
					</select>
				</td>
				
				<td class="DESIGNATION"><p class="CELLULE_CLIENT"><input type="text" name="designation[]" value="'. $donnees['DESIGNATION'] .'" size="12"></p></td> 
				<td class="QT"><input type="text" name="QT[]" value="'. $donnees['QT'] .'" size="1"></td> 
				<td class="prix_u"><input type="text" name="prix_u[]" value="'. $donnees['PRIX_U'] .'" size="1"></td> 
				<td class="prix_total">'. $donnees['PRIX_U']*$donnees['QT'] .'</td> 
				<td class="MATIERE"><input type="text" name="matiere[]" value="'. $donnees['MATIERE'] .'" size="8"></td> 
				<td class="EPAISSEUR"><input type="text" name="epaisseur[]" value="'. $donnees['EPAISSEUR'] .'" size="1"></td> 
				<td  class="Tableau_blanc"><input type="text" name="date_client[]" value="'. $date_client .'" size="7"></td>
				<td '. $classStatuLivraison .'><input type="text" name="date_confirm[]" value="'. $date_MI .'" size="7"></td>
				<td class="ETUDE"><input type="text" name="etude[]" value="'. $donnees['ETUDE'] .'" size="1"></td>
				<td class="STOCK"><input type="text" name="stock[]" value="'. $donnees['STOCK'] .'" size="1"></td>
				
				<td '. $classStatuHeuresLaser .'><input type="text" name="heure_laser[]" '. $classStatuHeuresLaser .' value="'. $donnees['TRUMPH_1'] .'" size="1"></td>
				<td '. $classStatuLaserHeuresProduitesLaser .'><input type="text" '. $classStatuLaserHeuresProduitesLaser .' name="sem_laser[]" value="'. $donnees['SEM_PROD_LASER'] .'" size="1"></td>
				<td '. $classStatuLaserHeuresProduitesLaser .'><input type="text" '. $classStatuLaserHeuresProduitesLaser .' name="heure_produite_laser[]" value="'. $donnees['TPS_PRODUIT_L'] .'" size="1"></td>
				<td '. $classStatuLaserHeuresProduitesLaser .'><input type="text" '. $classStatuLaserHeuresProduitesLaser .' name="QT_PRODUIT_L[]" value="'. $donnees['QT_PRODUIT_L'] .'" size="1"></td>
				
				<td '. $classStatuHeuresEbav .'><input type="text" '. $classStatuHeuresEbav .' name="EBAVURAGE[]" value="'. $donnees['EBAVURAGE'] .'" size="1"></td>
				<td '. $classStatuHeuresEbav .'><input type="text" '. $classStatuHeuresEbav .' name="ORBITALE[]" value="'. $donnees['ORBITALE'] .'" size="1"></td>
				<td '. $classStatuHeuresEbav .'><input type="text" '. $classStatuHeuresEbav .' name="EBAV_CHAMPS[]" value="'. $donnees['EBAV_CHAMPS'] .'" size="1"></td>
				<td '. $classStatuHeuresEbav .'><input type="text" '. $classStatuHeuresEbav .' name="SUP_MICRO_ATTACHE[]" value="'. $donnees['SUP_MICRO_ATTACHE'] .'" size="1"></td>
				<td '. $classStatuHeuresEbav .'><input type="text" '. $classStatuHeuresEbav .' name="TRIBOFINITION[]" value="'. $donnees['TRIBOFINITION'] .'" size="1"></td>
				<td '. $classStatuLaserHeuresProduitesEbav .'><input type="text" '. $classStatuLaserHeuresProduitesEbav .' name="sem_ebav[]" value="'. $donnees['SEM_PROD_EBAV'] .'" size="1"></td>
				<td '. $classStatuLaserHeuresProduitesEbav .'><input type="text" '. $classStatuLaserHeuresProduitesEbav .' name="heure_produite_ebav[]" value="'. $donnees['TPS_PRODUIT_EBAV'] .'" size="1"></td>
				<td '. $classStatuLaserHeuresProduitesEbav .'><input type="text" '. $classStatuLaserHeuresProduitesEbav .' name="QT_PRODUIT_EBAV[]" value="'. $donnees['QT_PRODUIT_EBAV'] .'" size="1"></td>
				
				<td '. $classStatuHeuresPara .'><input type="text" '. $classStatuHeuresPara .' name="PARACHEVEMENT[]" value="'. $donnees['PARACHEVEMENT'] .'" size="1"></td>
				<td '. $classStatuHeuresPara .'><input type="text" '. $classStatuHeuresPara .' name="PERCAGE[]" value="'. $donnees['PERCAGE'] .'" size="1"></td>
				<td '. $classStatuHeuresPara .'><input type="text" '. $classStatuHeuresPara .' name="TARAUDAGE[]" value="'. $donnees['TARAUDAGE'] .'" size="1"></td>
				<td '. $classStatuHeuresPara .'><input type="text" '. $classStatuHeuresPara .' name="FRAISURAGE[]" value="'. $donnees['FRAISURAGE'] .'" size="1"></td>
				<td '. $classStatuHeuresPara .'><input type="text" '. $classStatuHeuresPara .' name="INSERT_P[]" value="'. $donnees['INSERT_P'] .'" size="1"></td>
				<td '. $classStatuLaserHeuresProduitesPara .'><input type="text" '. $classStatuLaserHeuresProduitesPara .' name="sem_PARACHEVEMENT[]" value="'. $donnees['SEM_PROD_PARA'] .'" size="1"></td>
				<td '. $classStatuLaserHeuresProduitesPara .'><input type="text" '. $classStatuLaserHeuresProduitesPara .' name="heure_produite_PARACHEVEMENT[]" value="'. $donnees['TPS_PRODUIT_P'] .'" size="1"></td>
				<td '. $classStatuLaserHeuresProduitesPara .'><input type="text" '. $classStatuLaserHeuresProduitesPara .' name="QT_PRODUIT_PARA[]" value="'. $donnees['QT_PRODUIT_PARA'] .'" size="1"></td>
				
				<td '. $classStatuHeuresPliage .'><input type="text" '. $classStatuHeuresPliage .' name="PLIAGE[]" value="'. $donnees['PLIAGE'] .'" size="1"></td>
				<td '. $classStatuHeuresPliage .'><input type="text" '. $classStatuHeuresPliage .' name="nbr_op[]" value="'. $donnees['NBR_OP'] .'" size="1"></td>
				<td '. $classStatuLaserHeuresProduitesPliage .'><input type="text" '. $classStatuLaserHeuresProduitesPliage .' name="SEM_PROD_PLI[]" value="'. $donnees['SEM_PROD_PLI'] .'" size="1"></td>
				<td '. $classStatuLaserHeuresProduitesPliage .'><input type="text" '. $classStatuLaserHeuresProduitesPliage .' name="TPS_PRODUIT_PLI[]" value="'. $donnees['TPS_PRODUIT_PLI'] .'" size="1"></td>
				<td '. $classStatuLaserHeuresProduitesPliage .'><input type="text" '. $classStatuLaserHeuresProduitesPliage .' name="QT_PRODUIT_PLI[]" value="'. $donnees['QT_PRODUIT_PLI'] .'" size="1"></td>
				
				<td '. $classStatuHeuresSoudure .'><input type="text" '. $classStatuHeuresSoudure .' name="SOUDURE_MIG[]" value="'. $donnees['SOUDURE_MIG'] .'" size="1"></td>
				<td '. $classStatuLaserHeuresProduitesSoudure .'><input type="text" '. $classStatuLaserHeuresProduitesSoudure .' name="SEM_PROD_MIG[]" value="'. $donnees['SEM_PROD_MIG'] .'" size="1"></td>
				<td '. $classStatuLaserHeuresProduitesSoudure .'><input type="text" '. $classStatuLaserHeuresProduitesSoudure .' name="TPS_PRODUIT_MIG[]" value="'. $donnees['TPS_PRODUIT_MIG'] .'" size="1"></td>
				<td '. $classStatuLaserHeuresProduitesSoudure .'><input type="text" '. $classStatuLaserHeuresProduitesSoudure .' name="QT_PRODUIT_MIG[]" value="'. $donnees['QT_PRODUIT_MIG'] .'" size="1"></td>
				
				<td '. $classStatuHeuresSoudure .'><input type="text" '. $classStatuHeuresSoudure .' name="SOUDURE_TIG[]" value="'. $donnees['SOUDURE_TIG'] .'" size="1"></td>
				<td '. $classStatuLaserHeuresProduitesSoudure .'><input type="text" '. $classStatuLaserHeuresProduitesSoudure .' name="SEM_PROD_TIG[]" value="'. $donnees['SEM_PROD_TIG'] .'" size="1"></td>
				<td '. $classStatuLaserHeuresProduitesSoudure .'><input type="text" '. $classStatuLaserHeuresProduitesSoudure .' name="TPS_PRODUIT_TIG[]" value="'. $donnees['TPS_PRODUIT_TIG'] .'" size="1"></td>
				<td '. $classStatuLaserHeuresProduitesSoudure .'><input type="text" '. $classStatuLaserHeuresProduitesSoudure .' name="QT_PRODUIT_TIG[]" value="'. $donnees['QT_PRODUIT_TIG'] .'" size="1"></td>
				

				<td class="Tableau_blanc"><input type="text" name="QT_EXPEDIER[]" value="'. $donnees['QT_EXPEDIER'] .'" size="6"></td>
				<td class="Tableau_blanc"><select name="TRANSPORTEUR[]"><option value="'. $donnees['TRANSPORTEUR'] .'">'. $donnees['TRANSPORTEUR'] .'</option>'. TRANSPORT_LISTE .'</select></td>
				<td class="Tableau_blanc"><input type="text" name="commentaire[]" value="'. $donnees['COMMENTAIRES'] .'" size="10"></td>
				<td class="Tableau_blanc"><input type="text" name="poids[]" value="'. $donnees['POIDS'] .'" size="10"></td>
				<td class="Tableau_blanc"><input type="text" name="DEVIS[]" value="'. $donnees['DEVIS'] .'" size="10"></td>
			</tr>';
			
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
			'<form  method="post" action="planning.php" id="formulaire_sem">
				<table id="tableau_plannig">
					<thead>
						<tr> 
							<th>'. EN_TETE_TABLEAU_COL_01 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_02 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_03 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_04 .'</th>
							
							<th> Affecter une référence récurrente</th>
							
							<th>'. EN_TETE_TABLEAU_COL_05 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_06 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_07 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_08 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_09 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_10 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_11 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_12 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_13 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_14 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_15 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_16 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_17 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_18 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_19 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_20 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_21 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_22 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_23 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_24 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_25 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_26 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_27 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_28 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_29 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_30 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_31 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_32 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_33 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_34 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_35 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_36 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_37 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_38 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_39 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_40 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_41 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_42 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_43 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_44 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_45 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_46 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_47 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_64 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_65 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_66 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_67 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_68 .'</th>
						</tr>
					</thead>
				<tbody>
				'. $contenu_tableau .'
				</tbody>
				<tfoot>
					<tr> 
						<th>TOTAL</th>
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
						<th></th>
						<th></th>
						<th></th>
						<th>'. $SommeHeure_laser .'</th>
						<th></th>
						<th>'. $SommeHeureProduite_laser .'</th>
						<th>'. $SommeHeure_ebav .'</th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th>'. $SommeHeureProduite_ebav .'</th>
						<th>'. $SommeHeure_para .'</th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th>'. $SommeHeureProduite_para .'</th>
						<th>'. $SommeHeure_pliage .'</th>
						<th></th>
						<th></th>
						<th></th>
						<th>'. $SommeHeureProduite_pliage .'</th>
						<th>'. $SommeHeure_MIG .'</th>
						<th></th>
						<th>'. $SommeHeureProduite_MIG .'</th>
						<th></th>
						<th>'. $SommeHeure_TIG .'</th>
						<th></th>
						<th>'. $SommeHeureProduite_TIG .'</th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th>'. $SommePoids .'</th>
						<th></th>
					</tr>
				</tfoot>
			</table>
			<p>
				<br/>
				<input type="button" value="Retour" onClick="window.history.back()"><input type="submit" value="Modifier les lignes" onclick="Alert_modif()" />
			</p>
		</form>';
	}
?>