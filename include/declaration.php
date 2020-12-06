<?php

	
	$DateDuJour = date('Y-m-d');
	
	$SommeQt = 0;
	$SommePrix =0;
	$SommeHeure = 0;
	$SommePoids = 0;
	
	$contenu_tableau  = "";
	$ContenuDenTete  = "";
	$ContenuDeSecteur   = "";
	$ContenudeFooter    = "";

	if(empty($_POST['id_ligne'])){
		
		$selected_checkbox = 0;
	}
	else{
		
		$selected_checkbox = implode(",",$_POST['id_ligne']);
	}
	
	$res = $bdd->query('select count(*) as nb  FROM `'. TABLE_ERP_PLANNING .'` WHERE id IN ('. $selected_checkbox . ')  AND sup!=1 ');
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
				
				if(isset($_POST['planning']) AND $_POST['planning'] == "decla_laser"){
		
					if($donnees['QT_PRODUIT_L'] < $donnees['QT'] AND !empty($donnees['TRUMPH_1'])){
						$classStatuHeuresLaser ='class="TRUMPH_1"';
						$classStatuLaserHeuresProduitesLaser ='class="TPS_PRODUIT_L"';
					}
					else{
						$classStatuHeuresLaser ='class="case_produite"'; 
						$classStatuLaserHeuresProduitesLaser ='class="case_produite"'; 
					}
					
					$ContenuDenTete  = '
						<th>'. EN_TETE_TABLEAU_COL_15 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_16 .'</th>
						<th><a href="#" onclick="DeclarationTPSAuto();">'. EN_TETE_TABLEAU_COL_17 .'</a></th>
						<th><a href="#" onclick="DeclarationQTAuto();">'. EN_TETE_TABLEAU_COL_18 .'</a></th>';
					
					$ContenuDeSecteur  = '
						<td '. $classStatuHeuresLaser .'><input type="hidden" name="TPS[]" id="TPS" value="'. $donnees['TRUMPH_1'] .'"><input type="hidden" name="TRUMPH_1" value="'. $donnees['TRUMPH_1'] .'">'. $donnees['TRUMPH_1'] .'</td>
						<td '. $classStatuLaserHeuresProduitesLaser .'>'. $donnees['SEM_PROD_LASER'] .'</td>
						<td '. $classStatuLaserHeuresProduitesLaser .'><input type="text" name="TPS_PRODUIT[]" id="TPS_PRODUIT" value="'. $donnees['TPS_PRODUIT_L'] .'" size="1"></td>
						<td '. $classStatuLaserHeuresProduitesLaser .'><input type="text" name="QT_PRODUITE[]" id="QT_PRODUITE" value="'. $donnees['QT_PRODUIT_L'] .'" size="1"></td>';
						
					$ContenudeFooter ='
						<th></th>
						<th></th>
						<th></th>';
						
					$SommeHeure = $SommeHeure + $donnees['TRUMPH_1'];
					
				}
				if(isset($_POST['planning']) AND $_POST['planning'] == "decla_ebav"){
					
					if($donnees['QT_PRODUIT_EBAV'] < $donnees['QT'] AND !empty($donnees['EBAVURAGE'])){
						$classStatuHeuresEbav ='class="EBAVURAGE"';
						$classStatuLaserHeuresProduitesEbav ='class="TPS_PROD_EBAVURAGE"';
					}
					else{
						$classStatuHeuresEbav ='class="Tableau_blege"'; 
						$classStatuLaserHeuresProduitesEbav ='class="Tableau_blege"'; 
					}
					
					$ContenuDenTete  = '
						<th>'. EN_TETE_TABLEAU_COL_19 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_20 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_21 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_22 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_23 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_24 .'</th>
						<th><a href="#" onclick="DeclarationTPSAuto();">'. EN_TETE_TABLEAU_COL_25 .'</a></th>
						<th><a href="#" onclick="DeclarationQTAuto();">'. EN_TETE_TABLEAU_COL_26 .'</a></th>';
						
					$ContenuDeSecteur  = '
						<td '. $classStatuHeuresEbav .'><input type="hidden" name="TPS[]" id="TPS" value="'. $donnees['EBAVURAGE'] .'"><input type="hidden" name="EBAVURAGE" value="'. $donnees['EBAVURAGE'] .'">'. $donnees['EBAVURAGE'] .'</td>
						<td '. $classStatuHeuresEbav .'>'. $donnees['ORBITALE'] .'</td>
						<td '. $classStatuHeuresEbav .'>'. $donnees['EBAV_CHAMPS'] .'</td>
						<td '. $classStatuHeuresEbav .'>'. $donnees['SUP_MICRO_ATTACHE'] .'</td>
						<td '. $classStatuHeuresEbav .'>'. $donnees['TRIBOFINITION'] .'</td>
						<td '. $classStatuLaserHeuresProduitesEbav .'>'. $donnees['SEM_PROD_EBAV'] .'</td>
						<td '. $classStatuLaserHeuresProduitesEbav .'><input type="text" name="TPS_PRODUIT[]" id="TPS_PRODUIT" value="'. $donnees['TPS_PRODUIT_EBAV'] .'" size="1"></td>
						<td '. $classStatuLaserHeuresProduitesEbav .'><input type="text" name="QT_PRODUITE[]" id="QT_PRODUITE" value="'. $donnees['QT_PRODUIT_EBAV'] .'" size="1"></td>'; 
						
					$ContenudeFooter ='
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>';
						
					$SommeHeure = $SommeHeure + $donnees['EBAVURAGE'];
				}
				
				if(isset($_POST['planning']) AND $_POST['planning'] == "decla_para"){
					
					if($donnees['QT_PRODUIT_PARA'] < $donnees['QT'] AND !empty($donnees['PARACHEVEMENT'])){
						$classStatuHeuresPara ='class="PARACHEVEMENT"';
						$classStatuLaserHeuresProduitesPara ='class="TPS_PROD_PARACHEVEMENT"';
					}
					else{
						$classStatuHeuresPara ='class="Tableau_MistyRose"'; 
						$classStatuLaserHeuresProduitesPara ='class="Tableau_MistyRose"'; 
					}
					$ContenuDenTete  = '
						<th>'. EN_TETE_TABLEAU_COL_27 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_28 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_29 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_30 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_31 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_32 .'</th>
						<th><a href="#" onclick="DeclarationTPSAuto();">'. EN_TETE_TABLEAU_COL_33 .'</a></th>
						<th><a href="#" onclick="DeclarationQTAuto();">'. EN_TETE_TABLEAU_COL_34 .'</a></th>';
								
					$ContenuDeSecteur  = '
						<td '. $classStatuHeuresPara .'><input type="hidden" name="TPS[]" id="TPS" value="'. $donnees['PARACHEVEMENT'] .'"><input type="hidden" name="PARACHEVEMENT" value="'. $donnees['PARACHEVEMENT'] .'">'. $donnees['PARACHEVEMENT'] .'</td>
						<td '. $classStatuHeuresPara .'>'. $donnees['PERCAGE'] .'</td>
						<td '. $classStatuHeuresPara .'>'. $donnees['TARAUDAGE'] .'</td>
						<td '. $classStatuHeuresPara .'>'. $donnees['FRAISURAGE'] .'</td>
						<td '. $classStatuHeuresPara .'>'. $donnees['INSERT_P'] .'</td>
						<td '. $classStatuLaserHeuresProduitesPara .'>'. $donnees['SEM_PROD_PARA'] .'</td>
						<td '. $classStatuLaserHeuresProduitesPara .'><input type="text" name="TPS_PRODUIT[]" id="TPS_PRODUIT" value="'. $donnees['TPS_PRODUIT_P'] .'" size="1"></td>
						<td '. $classStatuLaserHeuresProduitesPara .'><input type="text" name="QT_PRODUITE[]" id="QT_PRODUITE" value="'. $donnees['QT_PRODUIT_PARA'] .'" size="1"></td>'; 
						
					$ContenudeFooter ='
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>';
						
					$SommeHeure = $SommeHeure + $donnees['PARACHEVEMENT'];
				}
				
				if(isset($_POST['planning']) AND $_POST['planning'] == "decla_pli"){
					
					if($donnees['QT_PRODUIT_PLI'] < $donnees['QT'] AND !empty($donnees['PLIAGE'])){
						$classStatuHeuresPliage ='class="PLIAGE"';
						$classStatuLaserHeuresProduitesPliage ='class="TPS_PROD_PLIAGE"';
					}
					else{
						$classStatuHeuresPliage ='class="Tableau_8FBC8F"'; 
						$classStatuLaserHeuresProduitesPliage ='class="Tableau_8FBC8F"'; 
					}
					$ContenuDenTete  = '
						<th>'. EN_TETE_TABLEAU_COL_35 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_36 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_37 .'</th>
						<th><a href="#" onclick="DeclarationTPSAuto();">'. EN_TETE_TABLEAU_COL_38 .'</a></th>
						<th><a href="#" onclick="DeclarationQTAuto();">'. EN_TETE_TABLEAU_COL_39 .'</a></th>'; 
								
					$ContenuDeSecteur  = '
						<td '. $classStatuHeuresPliage .'><input type="hidden" name="TPS[]" id="TPS" value="'. $donnees['PLIAGE'] .'"><input type="hidden" name="PLIAGE" value="'. $donnees['PLIAGE'] .'">'. $donnees['PLIAGE'] .'</td>
						<td '. $classStatuHeuresPliage .'>'. $donnees['NBR_OP'] .'</td>
						<td '. $classStatuLaserHeuresProduitesPliage .'>'. $donnees['SEM_PROD_PLI'] .'</td>
						<td '. $classStatuLaserHeuresProduitesPliage .'><input type="text" name="TPS_PRODUIT[]" id="TPS_PRODUIT" value="'. $donnees['TPS_PRODUIT_PLI'] .'" size="1"></td>
						<td '. $classStatuLaserHeuresProduitesPliage .'><input type="text" name="QT_PRODUITE[]" id="QT_PRODUITE" value="'. $donnees['QT_PRODUIT_PLI'] .'" size="1"></td>'; 
				
					$ContenudeFooter ='
						<th></th>
						<th></th>
						<th></th>
						<th></th>';
						
					$SommeHeure = $SommeHeure + $donnees['PLIAGE'];
				}
				
				if(isset($_POST['planning']) AND $_POST['planning'] == "decla_soudure_mig" OR isset($_POST['planning']) AND $_POST['planning'] == "decla_soudure_tig"){
					
					if($donnees['QT_PRODUIT_MIG'] < $donnees['QT'] AND !empty($donnees['SOUDURE_MIG']) OR $donnees['QT_PRODUIT_TIG'] < $donnees['QT'] AND !empty($donnees['SOUDURE_TIG'])){
						$classStatuHeuresSoudure ='class="SOUDURE"';
						$classStatuLaserHeuresProduitesSoudure ='class="TPS_PROD_SOUDURE"';
					}
					else{
						$classStatuHeuresSoudure ='class="Tableau_F08080"'; 
						$classStatuLaserHeuresProduitesSoudure ='class="Tableau_F08080"'; 
					}
					
					if(isset($_POST['planning']) AND $_POST['planning'] == "decla_soudure_mig"){
						$ContenuDenTete  = '
						<th>'. EN_TETE_TABLEAU_COL_40 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_41 .'</th>
						<th><a href="#" onclick="DeclarationTPSAuto();">'. EN_TETE_TABLEAU_COL_42 .'</a></th>
						<th><a href="#" onclick="DeclarationQTAuto();">'. EN_TETE_TABLEAU_COL_43 .'</a></th>'; 
						
						$ContenuDeSecteur  = '
						<td '. $classStatuHeuresSoudure .'><input type="hidden" name="TPS[]" id="TPS" value="'. $donnees['SOUDURE_MIG'] .'"><input type="hidden" name="SOUDURE_MIG" value="'. $donnees['SOUDURE_MIG'] .'">'. $donnees['SOUDURE_MIG'] .'</td>
						<td '. $classStatuLaserHeuresProduitesSoudure .'>'. $donnees['SEM_PROD_MIG'] .'</td>
						<td '. $classStatuLaserHeuresProduitesSoudure .'><input type="text" name="TPS_PRODUIT[]" id="TPS_PRODUIT" value="'. $donnees['TPS_PRODUIT_MIG'] .'" size="1"></td>
						<td '. $classStatuLaserHeuresProduitesSoudure .'><input type="text" name="QT_PRODUITE[]" id="QT_PRODUITE" value="'. $donnees['QT_PRODUIT_MIG'] .'" size="1"></td>';

						$SommeHeure = $SommeHeure + $donnees['SOUDURE_MIG'];
					}
					elseif(isset($_POST['planning']) AND $_POST['planning'] == "decla_soudure_tig"){

						$ContenuDenTete  = '
						<th>'. EN_TETE_TABLEAU_COL_44 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_45 .'</th>
						<th><a href="#" onclick="DeclarationTPSAuto();">'. EN_TETE_TABLEAU_COL_46 .'</a></th>
						<th><a href="#" onclick="DeclarationQTAuto();">'. EN_TETE_TABLEAU_COL_47 .'</a></th>'; 
								
						$ContenuDeSecteur  = '
						<td '. $classStatuHeuresSoudure .'><input type="hidden" name="TPS[]" id="TPS" value="'. $donnees['SOUDURE_TIG'] .'"><input type="hidden" name="SOUDURE_TIG" value="'. $donnees['SOUDURE_TIG'] .'">'. $donnees['SOUDURE_TIG'] .'</td>
						<td '. $classStatuLaserHeuresProduitesSoudure .'>'. $donnees['SEM_PROD_TIG'] .'</td>
						<td '. $classStatuLaserHeuresProduitesSoudure .'><input type="text" name="TPS_PRODUIT[]" id="TPS_PRODUIT" value="'. $donnees['TPS_PRODUIT_TIG'] .'" size="1"></td>
						<td '. $classStatuLaserHeuresProduitesSoudure .'><input type="text" name="QT_PRODUITE[]" id="QT_PRODUITE" value="'. $donnees['QT_PRODUIT_TIG'] .'" size="1"></td>';

						$SommeHeure = $SommeHeure + $donnees['SOUDURE_TIG'];						
					}
					
					$ContenudeFooter ='
						<th></th>
						<th></th>
						<th></th>';
				}
				if(isset($_POST['planning']) AND $_POST['planning'] == "decla_expe"){
					
					$ContenuDenTete  = '
						<th><a href="#" onclick="DeclarationQTAuto();">'. EN_TETE_TABLEAU_COL_64 .'</a></th>'; 
					$ContenuDeSecteur  = '
						<td class="Tableau_blanc"><input type="hidden" name="QT_EXPEDIER[]" id="TPS" ><input type="text" name="QT_PRODUITE[]" id="QT_PRODUITE" value="'. $donnees['QT_EXPEDIER'] .'" size="6"></td>'; 
				}
				
			$contenu_tableau = $contenu_tableau.'
			<tr> 
				<td class="commande"><input type="hidden" name="id_decla_ligne[]" value="'. $donnees['id'] .'"><input type="hidden" name="COMMANDE" value="'. $donnees['COMMANDE'] .'"><a href="planning.php?ref_CO='. $donnees['COMMANDE'] .'">'. $donnees['COMMANDE'] .'</a></td> 
				<td class="co-client"><a href="planning.php?ref_CO_CLI='. $donnees['CO_CLIENT'] .'">'. $donnees['CO_CLIENT'] .'</a></td> 
				<td class="CLIENT"><p class="CELLULE_CLIENT"><a href="planning.php?CLIENT='. $donnees['CLIENT'] .'">'. $donnees['CLIENT'] .'</a></p></td> 
				<td class="PLAN">'. $donnees['PLAN'] .'</td> 
				<td class="DESIGNATION"><p class="CELLULE_DESIGNATION">'. $donnees['DESIGNATION'] .'</p></td> 
				<td class="QT"><input type="hidden" name="QT[]" id="QT" value="'. $donnees['QT'] .'">'. $donnees['QT'] .'</td> 
				<td class="prix_u">'. $donnees['PRIX_U'] .'</td> 
				<td class="prix_total">'. $donnees['PRIX_U']*$donnees['QT'] .'</td> 
				<td class="MATIERE"><p class="CELLULE_MATIERE">'. $donnees['MATIERE'] .'</p></td> 
				<td class="EPAISSEUR"><p class="CELLULE_EPAISSEUR">'. $donnees['EPAISSEUR'] .'</p></td> 
				<td class="Tableau_blanc">'. $date_client .'</td>
				<td '. $classStatuLivraison .'>'. $date_MI .'</td>
				<td class="ETUDE">'. $donnees['ETUDE'] .'</td>
				<td class="STOCK">'. $donnees['STOCK'] .'</td>
				'. $ContenuDeSecteur .'
				<td class="Tableau_blanc">'. $donnees['TRANSPORTEUR'] .'</td>
				<td class="Tableau_blanc"><input type="text" name="commentaire[]" value="'. $donnees['COMMENTAIRES'] .'" size="10"></td>
				<td class="Tableau_blanc">'. $donnees['POIDS'] .' kg</td>
			</tr>';
			
			$SommeQt = $SommeQt + $donnees['QT'];
			$SommePrix = $SommePrix + $donnees['PRIX_U']*$donnees['QT'];
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
							'. $ContenuDenTete .'
							<th>'. EN_TETE_TABLEAU_COL_65 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_66 .'</th>
							<th>'. EN_TETE_TABLEAU_COL_67 .'</th>
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
							<th>'. $SommeHeure .'</th>
							<th></th>
							<th></th>
							'. $ContenudeFooter .'
							<th>'. $SommePoids .'</th>
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