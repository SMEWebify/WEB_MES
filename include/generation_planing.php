<?php
	
	$DateDuJour = date('Y-m-d');
	$DateDemain = date('Y-m-d', strtotime('+1 days'));
	$DatesurDemain = date('Y-m-d', strtotime('+2 days'));
	
	if(isset($_GET['annee'])){
		$annee = intval($_GET['annee']);
	}
	else{
		$annee = date("Y");
	}
		
	if(isset($_GET['sem'])){
		$sem = intval($_GET['sem']);
	}

	$block1 = false;
	$block2 = false;
	$block3 = false;
	$block4 = false;
	$block5 = false;
	$block6 = false;
	$block7 = false;
	
	$block0_contenu = '';
	$block1_contenu = '';
	$block2_contenu = '';
	$block3_contenu = '';
	$block4_contenu = '';
	$block5_contenu = '';
	$block6_contenu = '';
	$block7_contenu = '';
	
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
	$i = 1;
	
	$commandeENCours = '';
	$id_ligne ='';
	
	
	$En_tete ='';
	$Contenu_tableau ='';
	$Pied_page = '';
	$ValeurSaisie = '';
	$BddSemProd = '';
	$STT ='';
	
	$affichage = array(1 => "0", 2 => "0", 3 => "0", 4 => "0",  5 => "0", 6 => "0");
		
			
	if(isset($_GET['sem']) AND !empty($_GET['sem'])){
			
			$BddSemProd = $BddSemProd .'( ';
			
			if(isset($_GET['1']) AND $_GET['1']=="1"){
				$BddSemProd = $BddSemProd .'
										`'. TABLE_ERP_PLANNING .'`.SEM_PROD_LASER =\''. $sem .'\'';
				$i++;
				$affichage[1] = "1";
			}
			
			if(isset($_GET['2']) AND $_GET['2']=="1"){
				if($i > 1) $BddSemProd = $BddSemProd .' OR ';
				$BddSemProd = $BddSemProd .' 
										`'. TABLE_ERP_PLANNING .'`.SEM_PROD_EBAV =\''. $sem .'\'';
				$i++;
				$affichage[2] = "1";
			}
			
			if(isset($_GET['3']) AND $_GET['3']=="1"){
				if($i > 1) $BddSemProd = $BddSemProd .' OR ';
				$BddSemProd = $BddSemProd .' 
										`'. TABLE_ERP_PLANNING .'`.SEM_PROD_PARA =\''. $sem .'\'';
				$i++;
				$affichage[3] = "1";
			}
			
			if(isset($_GET['4']) AND $_GET['4']=="1"){
				if($i > 1) $BddSemProd = $BddSemProd .' OR ';
				$BddSemProd = $BddSemProd .' 
										`'. TABLE_ERP_PLANNING .'`.SEM_PROD_PLI =\''. $sem .'\'';
				$i++;
				$affichage[4] = "1";
			}
				
			if(isset($_GET['5']) AND $_GET['5']=="1"){
				if($i > 1) $BddSemProd = $BddSemProd .' OR ';
				$BddSemProd = $BddSemProd .' 
										`'. TABLE_ERP_PLANNING .'`.SEM_PROD_MIG =\''. $sem .'\'';
				$i++;
				$affichage[5] = "1";
			}
			
			if(isset($_GET['6']) AND $_GET['6']=="1"){
				if($i > 1) $BddSemProd = $BddSemProd .' OR ';
				$BddSemProd = $BddSemProd .' 
										`'. TABLE_ERP_PLANNING .'`.SEM_PROD_TIG =\''. $sem .'\'';
				$i++;
				$affichage[6] = "1";
			}
			
			if(!isset($_GET['1']) AND !isset($_GET['2']) AND !isset($_GET['3']) AND !isset($_GET['4']) AND !isset($_GET['5']) AND !isset($_GET['6'])){
				
				$BddSemProd = $BddSemProd .'
										`'. TABLE_ERP_PLANNING .'`.SEM_PROD_LASER =\''. $sem .'\' OR
										`'. TABLE_ERP_PLANNING .'`.SEM_PROD_EBAV =\''. $sem .'\' OR
										`'. TABLE_ERP_PLANNING .'`.SEM_PROD_PARA =\''. $sem .'\' OR
										`'. TABLE_ERP_PLANNING .'`.SEM_PROD_PLI =\''. $sem .'\' OR
										`'. TABLE_ERP_PLANNING .'`.SEM_PROD_MIG =\''. $sem .'\' OR
										`'. TABLE_ERP_PLANNING .'`.SEM_PROD_TIG =\''. $sem .'\' 
										';
				
				$i++;
				$affichage = array(1 => "1", 2 => "1", 3 => "1", 4 => "1",  5 => "1", 6 => "1");
			}
			
			if($i > 1) $BddSemProd = $BddSemProd .' ) AND ';
			$BddSemProd = $BddSemProd .'
										YEAR(DATE_CONFIRM)="'. $annee .'" ';
			$i++;
		}
		
	if(isset($_GET['ref_CO']) AND !empty($_GET['ref_CO'])) {
			
			if($i > 1) $BddSemProd = $BddSemProd .' OR ';
			
			$BddSemProd = $BddSemProd .' `'. TABLE_ERP_PLANNING .'`.COMMANDE =\''. $_GET['ref_CO'] .'\'';
			
			$i++;
			
			$affichage = array(1 => "1", 2 => "1", 3 => "1", 4 => "1",  5 => "1", 6 => "1");
		}
			
	if(isset($_GET['ref_CO_CLI']) AND !empty($_GET['ref_CO_CLI'])) {
			
		if($i > 1) $BddSemProd = $BddSemProd .' OR ';
			
		$BddSemProd = $BddSemProd .' `'. TABLE_ERP_PLANNING .'`.CO_CLIENT =\''. addslashes($_GET['ref_CO_CLI']) .'\'';
			
		$i++;
			
		$affichage = array(1 => "1", 2 => "1", 3 => "1", 4 => "1",  5 => "1", 6 => "1");
	}
	
	if(isset($_GET['CLIENT']) AND !empty($_GET['CLIENT'])) {
			
		if($i > 1) $BddSemProd = $BddSemProd .' OR ';
			
		$BddSemProd = $BddSemProd .' `'. TABLE_ERP_PLANNING .'`.CLIENT =\''. addslashes($_GET['CLIENT']) .'\'';
			
		$i++;
			
		$affichage = array(1 => "1", 2 => "1", 3 => "1", 4 => "1",  5 => "1", 6 => "1");
	}	
		
	if(isset($_POST['VOIR_PLAN']) AND !empty($_POST['VOIR_PLAN']) OR isset($_GET['ref']) AND !empty($_GET['ref']) OR isset($_POST['id_modif_rec']) AND !empty($_POST['id_modif_rec'])){
		
		if(isset($_POST['VOIR_PLAN'])){
			$id_recurent = $_POST['VOIR_PLAN'];
		}
		elseif(isset($_GET['ref'])){
			$id_recurent = $_GET['ref'];
		}
		elseif(isset($_POST['id_modif_rec'])){
				$id_recurent = implode(",",$_POST['id_modif_rec']);
		}

		
		if($i > 1) $BddSemProd = $BddSemProd .' OR ';
			
		$BddSemProd = $BddSemProd .' `'. TABLE_ERP_PLANNING .'`.id_RECURENT = \''. $donnees['id'] .'\'' ;
			
		$i++;
			
		$affichage = array(1 => "1", 2 => "1", 3 => "1", 4 => "1",  5 => "1", 6 => "1");
	}	
	
	
	if($i ==1 ){
			$BddSemProd = ' `'.TABLE_ERP_PLANNING .'`.id = 0';
		}
		
	/*if(isset($_GET['MATIERE']) AND !empty($_GET['MATIERE'])){
			
		$BddSemProd = $BddSemProd .' AND `'. TABLE_ERP_PLANNING .'`.MATIERE =\''. $_GET['MATIERE'] .'\'';
	}
		
	if(isset($_GET['EPAISSEUR']) AND !empty($_GET['EPAISSEUR'])){
			
		$BddSemProd = $BddSemProd .' AND `'. TABLE_ERP_PLANNING .'`.EPAISSEUR =\''. $_GET['EPAISSEUR'] .'\'';
	}*/
		
	//var_dump('WHERE  `'. TABLE_ERP_PLANNING .'`.sup !=1  AND '. $BddSemProd .' ORDER BY `'. TABLE_ERP_PLANNING .'`.`DATE_CONFIRM` ASC,  `'. TABLE_ERP_PLANNING .'`.`id` ASC)');	
		
	$res = $bdd->query('select count(*) as nb from `'. TABLE_ERP_PLANNING .'` WHERE '. $BddSemProd .' AND sup!=1');
	$data = $res->fetch();
	$nb = $data['nb'];
	if($nb == 0){
		$contenu = '
					<p class="message">
							
							Aucune commande à afficher
							
						
						<input type="button" value="Retour" onClick="window.history.back()">
						
					</p>';
		}
	else{
			
		$req = $bdd->query('SELECT `'. TABLE_ERP_PLANNING .'`.`id`, 
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
									`'. TABLE_ERP_PLANNING .'`.`ETUDE`,
									`'. TABLE_ERP_PLANNING .'`.`STOCK`, 
									`'. TABLE_ERP_PLANNING .'`.`TRUMPH_1`,
									`'. TABLE_ERP_PLANNING .'`.`SEM_PROD_LASER`, 
									`'. TABLE_ERP_PLANNING .'`.`TPS_PRODUIT_L`, 
									`'. TABLE_ERP_PLANNING .'`.`QT_PRODUIT_L`, 
									`'. TABLE_ERP_PLANNING .'`.`EBAVURAGE`, 
									`'. TABLE_ERP_PLANNING .'`.`ORBITALE`, 
									`'. TABLE_ERP_PLANNING .'`.`EBAV_CHAMPS`, 
									`'. TABLE_ERP_PLANNING .'`.`SUP_MICRO_ATTACHE`,
									`'. TABLE_ERP_PLANNING .'`.`TRIBOFINITION`,
									`'. TABLE_ERP_PLANNING .'`.`SEM_PROD_EBAV`,
									`'. TABLE_ERP_PLANNING .'`.`TPS_PRODUIT_EBAV`,
									`'. TABLE_ERP_PLANNING .'`.`QT_PRODUIT_EBAV`, 
									`'. TABLE_ERP_PLANNING .'`.`PARACHEVEMENT`, 
									`'. TABLE_ERP_PLANNING .'`.`PERCAGE`, 
									`'. TABLE_ERP_PLANNING .'`.`TARAUDAGE`,
									`'. TABLE_ERP_PLANNING .'`.`FRAISURAGE`,
									`'. TABLE_ERP_PLANNING .'`.`INSERT_P`, 
									`'. TABLE_ERP_PLANNING .'`.`SEM_PROD_PARA`,
									`'. TABLE_ERP_PLANNING .'`.`TPS_PRODUIT_P`,
									`'. TABLE_ERP_PLANNING .'`.`QT_PRODUIT_PARA`,
									`'. TABLE_ERP_PLANNING .'`.`PLIAGE`, 
									`'. TABLE_ERP_PLANNING .'`.`NBR_OP`, 
									`'. TABLE_ERP_PLANNING .'`.`SEM_PROD_PLI`, 
									`'. TABLE_ERP_PLANNING .'`.`TPS_PRODUIT_PLI`, 
									`'. TABLE_ERP_PLANNING .'`.`QT_PRODUIT_PLI`, 
									`'. TABLE_ERP_PLANNING .'`.`SOUDURE_MIG`, 
									`'. TABLE_ERP_PLANNING .'`.`SEM_PROD_MIG`, 
									`'. TABLE_ERP_PLANNING .'`.`TPS_PRODUIT_MIG`, 
									`'. TABLE_ERP_PLANNING .'`.`QT_PRODUIT_MIG`, 
									`'. TABLE_ERP_PLANNING .'`.`SOUDURE_TIG`, 
									`'. TABLE_ERP_PLANNING .'`.`SEM_PROD_TIG`,
									`'. TABLE_ERP_PLANNING .'`.`TPS_PRODUIT_TIG`,
									`'. TABLE_ERP_PLANNING .'`.`QT_PRODUIT_TIG`, 
									`'. TABLE_ERP_PLANNING .'`.`QT_EXPEDIER`,
									`'. TABLE_ERP_PLANNING .'`.`TRANSPORTEUR`,
									`'. TABLE_ERP_PLANNING .'`.`COMMENTAIRES`,
									`'. TABLE_ERP_PLANNING .'`.`POIDS`,
									`'. TABLE_ERP_PLANNING .'`.`DEVIS`,
									`'. TABLE_ERP_SOUS_TRAITANCE .'`.`id` as id_SST,
									`'. TABLE_ERP_SOUS_TRAITANCE .'`.`DATE_RELANCE`,
									`'. TABLE_ERP_SOUS_TRAITANCE .'`.`STATU_RELANCE`,
									`'. TABLE_ERP_SOUS_TRAITANCE .'`.`DATE_RECEPTION`,
									`'. TABLE_ERP_SOUS_TRAITANCE .'`.`STATU_RECEPTION`,
									`'. TABLE_ERP_SOUS_TRAITANCE .'`.`FOURNISSEUR`,
									`'. TABLE_ERP_SOUS_TRAITANCE .'`.`ORDRE`
									FROM `'. TABLE_ERP_PLANNING .'` LEFT JOIN `'. TABLE_ERP_SOUS_TRAITANCE .'` ON `'. TABLE_ERP_PLANNING .'`.`id` = `'. TABLE_ERP_SOUS_TRAITANCE .'`.`id_cmd`
									WHERE  `'. TABLE_ERP_PLANNING .'`.sup !=1  AND '. $BddSemProd .' ORDER BY `'. TABLE_ERP_PLANNING .'`.`DATE_CONFIRM` ASC,  `'. TABLE_ERP_PLANNING .'`.`id` ASC ');
									
	while ($donnees = $req->fetch())
	{

		
		if($id_ligne == $donnees['id'])
		{
			
				$commandeENCours ='';
				$block0_contenu = $block0_contenu;
				
				if($affichage[1] == "1" AND $block1 == false){ 
				//Affichage laser	
				
				if($donnees['QT_PRODUIT_L'] < $donnees['QT'] AND !empty($donnees['TRUMPH_1'])){
							
					$classStatuHeures ='class="TRUMPH_1"';
					$classStatuHeuresProduites ='class="TPS_PRODUIT_L"';
				}
				else{
					$classStatuHeures ='class="case_produite"'; 
					$classStatuHeuresProduites ='class="case_produite"'; 
				}
				
				if($donnees['SUP']==4){
					$classStatuHeures ='class="case_produite"'; 
					$classStatuHeuresProduites ='class="case_produite"'; 
					$block1_contenu = '<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .' colspan="5"> Livraison sur appel</td>';
				}
				elseif($donnees['SUP']==2){
					$classStatuHeures ='class="case_produite"'; 
					$classStatuHeuresProduites ='class="case_produite"'; 
					$block1_contenu = '<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .' colspan="5"> Annulé</td>';
				}
				else{
					$STT ='';
					if(!empty($donnees['id_SST']) AND $donnees['ORDRE'] == -1){
						$STT = '<a href="soustraitance.php?id_cmd='. $donnees['id'] .'"><span title="'. $donnees['FOURNISSEUR'] .'">oui</a></span>';
						$block1 = true;
					}
					
					$block1_contenu = '
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classSST .'>'. $STT .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeures .'>'. Affichage_zero($donnees['TRUMPH_1']) .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .'><a href="planning.php?sem='. Affichage_zero($donnees['SEM_PROD_LASER']) .'&1=1&annee='. $annee .'">'. Affichage_zero($donnees['SEM_PROD_LASER']) .'</a></td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .'>'. Affichage_zero($donnees['TPS_PRODUIT_L']) .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .'><p class="EN_GRAS">'. Affichage_zero($donnees['QT_PRODUIT_L']) .'</p></td>';
			
				}
				
			}
					
			if($affichage[2] == "1" AND $block2 == false){ 
				//Affichage Ebavurage
				
				if($donnees['QT_PRODUIT_EBAV'] < $donnees['QT'] AND !empty($donnees['EBAVURAGE'])){
					$classStatuHeures ='class="EBAVURAGE"';
					$classStatuHeuresProduites ='class="TPS_PROD_EBAVURAGE"';
				}
				else{
					$classStatuHeures ='class="Tableau_blege"';
					$classStatuHeuresProduites ='class="Tableau_blege"';
				}
				
				if($donnees['SUP']==4){
					$classStatuHeures ='class="case_produite"'; 
					$classStatuHeuresProduites ='class="case_produite"'; 
					$block2_contenu = '<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .' colspan="9"> Livraison sur appel</td>';

					
				}
				elseif($donnees['SUP']==2){
					$classStatuHeures ='class="case_produite"'; 
					$classStatuHeuresProduites ='class="case_produite"'; 
					$block2_contenu = '<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .' colspan="9"> Annulé</td>';
				}
				else{
					
					$STT ='';
					if(!empty($donnees['id_SST']) AND $donnees['ORDRE'] == -2){
						$STT = '<a href="soustraitance.php?id_cmd='. $donnees['id'] .'"><span title="'. $donnees['FOURNISSEUR'] .'">oui</a></span>';
						$block2 = true;
					}
				
				$block2_contenu = '
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classSST .'>'. $STT .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeures .'>'. Affichage_zero($donnees['EBAVURAGE']) .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeures .'>'. $donnees['ORBITALE'] .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeures .'>'. $donnees['EBAV_CHAMPS'] .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeures .'>'. $donnees['SUP_MICRO_ATTACHE'] .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeures .'>'. $donnees['TRIBOFINITION'] .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .'><a href="planning.php?sem='. Affichage_zero($donnees['SEM_PROD_EBAV']) .'&2=1&annee='. $annee .'">'. Affichage_zero($donnees['SEM_PROD_EBAV']) .'</a></td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .'>'. Affichage_zero($donnees['TPS_PRODUIT_EBAV']) .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .'><p class="EN_GRAS">'. Affichage_zero($donnees['QT_PRODUIT_EBAV']) .'</p></td>';
				}
			}
					
			if($affichage[3] == "1" AND $block3 == false){
				//Affichage Parachèvement
				
				if($donnees['QT_PRODUIT_PARA'] < $donnees['QT'] AND !empty($donnees['PARACHEVEMENT'])){
					$classStatuHeures ='class="PARACHEVEMENT"';
					$classStatuHeuresProduites ='class="TPS_PROD_PARACHEVEMENT"';
				}
				else{
					$classStatuHeures ='class="Tableau_MistyRose"'; 
					$classStatuHeuresProduites ='class="Tableau_MistyRose"'; 
				}
					
				if($donnees['SUP']==4){
					$classStatuHeures ='class="case_produite"'; 
					$classStatuHeuresProduites ='class="case_produite"'; 
					$block3_contenu = '<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .' colspan="9"> Livraison sur appel</td>';

					
				}
				elseif($donnees['SUP']==2){
					$classStatuHeures ='class="case_produite"'; 
					$classStatuHeuresProduites ='class="case_produite"'; 
					$block3_contenu = '<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .' colspan="9"> Annulé</td>';
				}
				else{
					
					$STT ='';
					if(!empty($donnees['id_SST']) AND $donnees['ORDRE'] == -3){
						$STT = '<a href="soustraitance.php?id_cmd='. $donnees['id'] .'"><span title="'. $donnees['FOURNISSEUR'] .'">oui</a></span>';
						$block3 = true;
					}
						
					$block3_contenu = '
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classSST .'>'. $STT .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeures .'>'. Affichage_zero($donnees['PARACHEVEMENT']) .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeures .'>'. $donnees['PERCAGE'] .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeures .'>'. $donnees['TARAUDAGE'] .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeures .'>'. $donnees['FRAISURAGE'] .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeures .'>'. $donnees['INSERT_P'] .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .'><a href="planning.php?sem='. Affichage_zero($donnees['SEM_PROD_PARA']) .'&3=1&annee='. $annee .'">'. Affichage_zero($donnees['SEM_PROD_PARA']) .'</a></td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .'>'. Affichage_zero($donnees['TPS_PRODUIT_P']) .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .'><p class="EN_GRAS">'. Affichage_zero($donnees['QT_PRODUIT_PARA']) .'</p></td>';
				}
			}
					
			if($affichage[4] == "1" AND $block4 == false){
			//Affichage Pliage
			
				if($donnees['QT_PRODUIT_PLI'] < $donnees['QT'] AND !empty($donnees['PLIAGE'])){
							
					$classStatuHeures ='class="PLIAGE"';
					$classStatuHeuresProduites ='class="TPS_PROD_PLIAGE"';
				}
				else{
						
					$classStatuHeures ='class="Tableau_8FBC8F"'; 
					$classStatuHeuresProduites ='class="Tableau_8FBC8F"'; 
				}
				
				
				if($donnees['SUP']==4){
					$classStatuHeures ='class="case_produite"'; 
					$classStatuHeuresProduites ='class="case_produite"'; 
					$block4_contenu = '<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .' colspan="6"> Livraison sur appel</td>';

					
				}
				elseif($donnees['SUP']==2){
					$classStatuHeures ='class="case_produite"'; 
					$classStatuHeuresProduites ='class="case_produite"'; 
					$block4_contenu = '<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .' colspan="6"> Annulé</td>';
				}
				else{
						
					$STT ='';
					if(!empty($donnees['id_SST']) AND $donnees['ORDRE'] == -4){
						$STT = '<a href="soustraitance.php?id_cmd='. $donnees['id'] .'"><span title="'. $donnees['FOURNISSEUR'] .'">oui</a></span>';
						$block4 = true;
					}
					
					$block4_contenu = '
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classSST .'>'. $STT .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeures .'>'. Affichage_zero($donnees['PLIAGE']) .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeures .'>'. Affichage_zero($donnees['NBR_OP']) .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .'><a href="planning.php?sem='. Affichage_zero($donnees['SEM_PROD_PLI']) .'&4=1&annee='. $annee .'">'. Affichage_zero($donnees['SEM_PROD_PLI']) .'</a></td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .'>'. Affichage_zero($donnees['TPS_PRODUIT_PLI']) .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .'><p class="EN_GRAS">'. Affichage_zero($donnees['QT_PRODUIT_PLI']) .'</p></td>';
				}
			}
					
			if($affichage[5] == "1" AND $block5 == false){
			//Affichage MIG
			
				if($donnees['QT_PRODUIT_MIG'] < $donnees['QT'] AND !empty($donnees['SOUDURE_MIG'])){
					$classStatuHeures ='class="SOUDURE"';
					$classStatuHeuresProduites ='class="TPS_PROD_SOUDURE"';
				}
				else{
					$classStatuHeures ='class="Tableau_F08080"'; 
					$classStatuHeuresProduites ='class="Tableau_F08080"'; 
				}
					
				if($donnees['SUP']==4){
					$classStatuHeures ='class="case_produite"'; 
					$classStatuHeuresProduites ='class="case_produite"'; 
					$block5_contenu = '<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .' colspan="5"> Livraison sur appel</td>';

				}
				elseif($donnees['SUP']==2){
					$classStatuHeures ='class="case_produite"'; 
					$classStatuHeuresProduites ='class="case_produite"'; 
					$block5_contenu = '<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .' colspan="5"> Annulé</td>';
				}
				else{
					$STT ='';
					if(!empty($donnees['id_SST']) AND $donnees['ORDRE'] == -5){
						$STT = '<a href="soustraitance.php?id_cmd='. $donnees['id'] .'"><span title="'. $donnees['FOURNISSEUR'] .'">oui</a></span>';
						$block5 = true;
					}
					
					$block5_contenu = '
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classSST .'>'. $STT .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeures .'>'. Affichage_zero($donnees['SOUDURE_MIG']) .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .'><a href="planning.php?sem='. Affichage_zero($donnees['SEM_PROD_MIG']) .'&5=1&annee='. $annee .'">'. Affichage_zero($donnees['SEM_PROD_MIG']) .'</a></td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .'>'. Affichage_zero($donnees['TPS_PRODUIT_MIG']) .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .'><p class="EN_GRAS">'. Affichage_zero($donnees['QT_PRODUIT_MIG']) .'</p></td>';
				}
			}
			
			if($affichage[6] == "1" AND $block6 == false){
			//Affichage TIG
			
				if($donnees['QT_PRODUIT_TIG'] < $donnees['QT'] AND !empty($donnees['SOUDURE_TIG'])){
					$classStatuHeures ='class="SOUDURE"';
					$classStatuHeuresProduites ='class="TPS_PROD_SOUDURE"';
				}
				else{
					$classStatuHeures ='class="Tableau_F08080"'; 
					$classStatuHeuresProduites ='class="Tableau_F08080"'; 
				}
					
				if($donnees['SUP']==4){
					$classStatuHeures ='class="case_produite"'; 
					$classStatuHeuresProduites ='class="case_produite"'; 
					$block6_contenu = '<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .' colspan="5"> Livraison sur appel</td>';
				}
				elseif($donnees['SUP']==2){
					$classStatuHeures ='class="case_produite"'; 
					$classStatuHeuresProduites ='class="case_produite"'; 
					$block6_contenu = '<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .' colspan="5"> Annulé</td>';
				}
				else{
						
					$STT ='';
					if(!empty($donnees['id_SST']) AND $donnees['ORDRE'] == -5){
						$STT = '<a href="soustraitance.php?id_cmd='. $donnees['id'] .'"><span title="'. $donnees['FOURNISSEUR'] .'">oui</a></span>';
						$block6 = true;
					}
					
					$block6_contenu = '
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classSST .'>'. $STT .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeures .'>'. Affichage_zero($donnees['SOUDURE_TIG']) .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .'><a href="planning.php?sem='. Affichage_zero($donnees['SEM_PROD_TIG']) .'&6=1&annee='. $annee .'">'. Affichage_zero($donnees['SEM_PROD_TIG']) .'</a></td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .'>'. Affichage_zero($donnees['TPS_PRODUIT_TIG']) .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .'><p class="EN_GRAS">'. Affichage_zero($donnees['QT_PRODUIT_TIG']) .'</p></td>';
				}
			}
					

		
			if($block7 == false){
				$STT ='';
					if(!empty($donnees['id_SST']) AND $donnees['ORDRE'] > 0){
						$STT = '<a href="soustraitance.php?id_cmd='. $donnees['id'] .'"><span title="'. $donnees['FOURNISSEUR'] .'">oui</a></span>';
						$block7 = true;
					}
				
				if($donnees['SUP']==3){
					$classStatuHeures ='class="case_produite"'; 
					$classStatuHeuresProduites ='class="case_produite"'; 
					$block7_contenu = '
						<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classSST .'>'. $STT .'</td>
						<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' ><p class="EN_GRAS">'. $donnees['QT_EXPEDIER'] .'</p></td>
						<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .' colspan="3"> Stock</td>';

				}
				elseif($donnees['SUP']==2){
					$classStatuHeures ='class="case_produite"'; 
					$classStatuHeuresProduites ='class="case_produite"'; 
					$block7_contenu = '<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .' colspan="5"> Annulé</td>';
				}
				else{
							
					$block7_contenu = '
						<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classSST .'>'. $STT .'</td>
						<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' ><p class="EN_GRAS">'. $donnees['QT_EXPEDIER'] .'</p></td>
						<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' >'. $donnees['TRANSPORTEUR'] .'</td>
						<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' > <span title="'. $donnees['COMMENTAIRES'] .'">'. extrait($donnees['COMMENTAIRES']) .'</span></td>
						<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' > '. $donnees['POIDS'] .' Kg</td>
					</tr>';
				}
			}
			
		}
		else{
				
			$Contenu_tableau = $Contenu_tableau . $block0_contenu . $block1_contenu . $block2_contenu . $block3_contenu . $block4_contenu . $block5_contenu . $block6_contenu . $block7_contenu;
			$block1 = false;
			$block2 = false;
			$block3 = false;
			$block4 = false;
			$block5 = false;
			$block6 = false;
			$block7 = false;
			
			
			$classStatuHeures = 'class="case_produite"'; 
			$classStatuHeuresProduites = 'class="case_produite"'; 
			$classSST ='class="Tableau_87CEFA"';
			
			if($donnees['SUP'] == 0 OR $donnees['SUP'] == 4 ){
				
				$date_client = join('/',array_reverse(explode('-',$donnees['DATE_CLIENT'])));
				If($date_client == "00/00/0000") $date_client = "";
				$date_MI = join('/',array_reverse(explode('-',$donnees['DATE_CONFIRM'])));
				
				list($annee, $mois, $jour) = explode('-', $donnees['DATE_CONFIRM']);
				if(empty($annee)) {$annee = date("Y");}
				
				
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
			}
			elseif($donnees['SUP'] == 2){
				$date_client = 'Annulé';
				$date_MI = 'Annulé';
						
				$classStatuLivraison =' ';
			}
			elseif($donnees['SUP'] == 3){
				
				$date_MI = join('/',array_reverse(explode('-',$donnees['DATE_CONFIRM'])));
				
				$date_client = 'Stock';
				$date_MI = 'Stock - '. $date_MI;
						
				$classStatuLivraison =' ';
			}
			
			
			$block0_contenu = '
				<tr> 
					<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' ><input type="checkbox" title="'. $donnees['id'] .'" name="id_ligne[]" value="'. $donnees['id'] .'" id="'. $donnees['id'] .'" /></td> 
					<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="commande"><a href="planning.php?ref_CO='. $donnees['COMMANDE'] .'"><span title="'. $donnees['DEVIS'] .'">'. $donnees['COMMANDE'] .'</a></span></td> 
					<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="co-client"><a href="planning.php?ref_CO_CLI='. $donnees['CO_CLIENT'] .'">'. $donnees['CO_CLIENT'] .'</a></td> 
					<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="CLIENT"><p class="CELLULE_CLIENT"><a href="planning.php?CLIENT='. $donnees['CLIENT'] .'">'. $donnees['CLIENT'] .'</a></p></td> 
					<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="PLAN"><p class="CELLULE_PLAN"><span title="'. $donnees['COMMENTAIRES'] .'">'. PLAN($donnees['PLAN'], $donnees['id_RECURENT']) .'</span></p></td> 
					<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="DESIGNATION"><p class="CELLULE_DESIGNATION">'. $donnees['DESIGNATION'] .'</p></td> 
					<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="QT"><p class="EN_GRAS">'. $donnees['QT'] .'</p></td> 
					<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="prix_u"> '. $donnees['PRIX_U'] .'</td> 
					<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="prix_total"> '. $donnees['PRIX_U']*$donnees['QT'] .'</td> 
					<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="MATIERE"><p class="CELLULE_MATIERE">'. $donnees['MATIERE'] .'</p></td> 
					<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="EPAISSEUR"><p class="CELLULE_EPAISSEUR">'. $donnees['EPAISSEUR'] .'</p></td> 
					<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' > '. $date_client .'</td>
					<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .'  '. $classStatuLivraison .'><span title="'. $donnees['POIDS'] .' Kg">'. $date_MI .'</span></td>
					<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="ETUDE"> '. $donnees['ETUDE'] .'</td>
					<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' class="STOCK"> '. $donnees['STOCK'] .'</td>';
			
			if($affichage[1] == "1"){ 
				//Affichage laser	
				
				if($donnees['QT_PRODUIT_L'] < $donnees['QT'] AND !empty($donnees['TRUMPH_1'])){
							
					$classStatuHeures ='class="TRUMPH_1"';
					$classStatuHeuresProduites ='class="TPS_PRODUIT_L"';
				}
				else{
					$classStatuHeures ='class="case_produite"'; 
					$classStatuHeuresProduites ='class="case_produite"'; 
				}
				
				if($donnees['SUP']==4){
					$classStatuHeures ='class="case_produite"'; 
					$classStatuHeuresProduites ='class="case_produite"'; 
					$block1_contenu = '<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .' colspan="5"> Livraison sur appel</td>';
				}
				elseif($donnees['SUP']==2){
					$classStatuHeures ='class="case_produite"'; 
					$classStatuHeuresProduites ='class="case_produite"'; 
					$block1_contenu = '<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .' colspan="5"> Annulé</td>';
				}
				else{
					$STT ='';
					if(!empty($donnees['id_SST']) AND $donnees['ORDRE'] == -1){
						$STT = '<a href="soustraitance.php?id_cmd='. $donnees['id'] .'"><span title="'. $donnees['FOURNISSEUR'] .'">oui</a></span>';
						$block1 = true;
					}
					
					$block1_contenu = '
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classSST .'>'. $STT .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeures .'>'. Affichage_zero($donnees['TRUMPH_1']) .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .'><a href="planning.php?sem='. Affichage_zero($donnees['SEM_PROD_LASER']) .'&1=1&annee='. $annee .'">'. Affichage_zero($donnees['SEM_PROD_LASER']) .'</a></td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .'>'. Affichage_zero($donnees['TPS_PRODUIT_L']) .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .'><p class="EN_GRAS">'. Affichage_zero($donnees['QT_PRODUIT_L']) .'</p></td>';
			
				}
				
			}
					
			if($affichage[2] == "1"){ 
				//Affichage Ebavurage
				
				if($donnees['QT_PRODUIT_EBAV'] < $donnees['QT'] AND !empty($donnees['EBAVURAGE'])){
					$classStatuHeures ='class="EBAVURAGE"';
					$classStatuHeuresProduites ='class="TPS_PROD_EBAVURAGE"';
				}
				else{
					$classStatuHeures ='class="Tableau_blege"';
					$classStatuHeuresProduites ='class="Tableau_blege"';
				}
				
				if($donnees['SUP']==4){
					$classStatuHeures ='class="case_produite"'; 
					$classStatuHeuresProduites ='class="case_produite"'; 
					$block2_contenu = '<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .' colspan="9"> Livraison sur appel</td>';

					
				}
				elseif($donnees['SUP']==2){
					$classStatuHeures ='class="case_produite"'; 
					$classStatuHeuresProduites ='class="case_produite"'; 
					$block2_contenu = '<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .' colspan="9"> Annulé</td>';
				}
				else{
					
					$STT ='';
					if(!empty($donnees['id_SST']) AND $donnees['ORDRE'] == -2){
						$STT = '<a href="soustraitance.php?id_cmd='. $donnees['id'] .'"><span title="'. $donnees['FOURNISSEUR'] .'">oui</a></span>';
						$block2 = true;
					}
				
				$block2_contenu = '
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classSST .'>'. $STT .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeures .'>'. Affichage_zero($donnees['EBAVURAGE']) .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeures .'>'. $donnees['ORBITALE'] .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeures .'>'. $donnees['EBAV_CHAMPS'] .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeures .'>'. $donnees['SUP_MICRO_ATTACHE'] .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeures .'>'. $donnees['TRIBOFINITION'] .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .'><a href="planning.php?sem='. Affichage_zero($donnees['SEM_PROD_EBAV']) .'&2=1&annee='. $annee .'">'. Affichage_zero($donnees['SEM_PROD_EBAV']) .'</a></td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .'>'. Affichage_zero($donnees['TPS_PRODUIT_EBAV']) .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .'><p class="EN_GRAS">'. Affichage_zero($donnees['QT_PRODUIT_EBAV']) .'</p></td>';
				}
			}
					
			if($affichage[3] == "1"){ 
				//Affichage Parachèvement
				
				if($donnees['QT_PRODUIT_PARA'] < $donnees['QT'] AND !empty($donnees['PARACHEVEMENT'])){
					$classStatuHeures ='class="PARACHEVEMENT"';
					$classStatuHeuresProduites ='class="TPS_PROD_PARACHEVEMENT"';
				}
				else{
					$classStatuHeures ='class="Tableau_MistyRose"'; 
					$classStatuHeuresProduites ='class="Tableau_MistyRose"'; 
				}
					
				if($donnees['SUP']==4){
					$classStatuHeures ='class="case_produite"'; 
					$classStatuHeuresProduites ='class="case_produite"'; 
					$block3_contenu = '<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .' colspan="9"> Livraison sur appel</td>';

					
				}
				elseif($donnees['SUP']==2){
					$classStatuHeures ='class="case_produite"'; 
					$classStatuHeuresProduites ='class="case_produite"'; 
					$block3_contenu = '<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .' colspan="9"> Annulé</td>';
				}
				else{
					
					$STT ='';
					if(!empty($donnees['id_SST']) AND $donnees['ORDRE'] == -3){
						$STT = '<a href="soustraitance.php?id_cmd='. $donnees['id'] .'"><span title="'. $donnees['FOURNISSEUR'] .'">oui</a></span>';
						$block3 = true;
					}
						
					$block3_contenu = '
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classSST .'>'. $STT .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeures .'>'. Affichage_zero($donnees['PARACHEVEMENT']) .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeures .'>'. $donnees['PERCAGE'] .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeures .'>'. $donnees['TARAUDAGE'] .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeures .'>'. $donnees['FRAISURAGE'] .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeures .'>'. $donnees['INSERT_P'] .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .'><a href="planning.php?sem='. Affichage_zero($donnees['SEM_PROD_PARA']) .'&3=1&annee='. $annee .'">'. Affichage_zero($donnees['SEM_PROD_PARA']) .'</a></td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .'>'. Affichage_zero($donnees['TPS_PRODUIT_P']) .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .'><p class="EN_GRAS">'. Affichage_zero($donnees['QT_PRODUIT_PARA']) .'</p></td>';
				}
			}
					
			if($affichage[4] == "1"){ 
			//Affichage Pliage
			
				if($donnees['QT_PRODUIT_PLI'] < $donnees['QT'] AND !empty($donnees['PLIAGE'])){
							
					$classStatuHeures ='class="PLIAGE"';
					$classStatuHeuresProduites ='class="TPS_PROD_PLIAGE"';
				}
				else{
						
					$classStatuHeures ='class="Tableau_8FBC8F"'; 
					$classStatuHeuresProduites ='class="Tableau_8FBC8F"'; 
				}
				
				
				if($donnees['SUP']==4){
					$classStatuHeures ='class="case_produite"'; 
					$classStatuHeuresProduites ='class="case_produite"'; 
					$block4_contenu = '<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .' colspan="6"> Livraison sur appel</td>';

					
				}
				elseif($donnees['SUP']==2){
					$classStatuHeures ='class="case_produite"'; 
					$classStatuHeuresProduites ='class="case_produite"'; 
					$block4_contenu = '<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .' colspan="6"> Annulé</td>';
				}
				else{
						
					$STT ='';
					if(!empty($donnees['id_SST']) AND $donnees['ORDRE'] == -4){
						$STT = '<a href="soustraitance.php?id_cmd='. $donnees['id'] .'"><span title="'. $donnees['FOURNISSEUR'] .'">oui</a></span>';
						$block4 = true;
					}
					
					$block4_contenu = '
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classSST .'>'. $STT .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeures .'>'. Affichage_zero($donnees['PLIAGE']) .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeures .'>'. Affichage_zero($donnees['NBR_OP']) .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .'><a href="planning.php?sem='. Affichage_zero($donnees['SEM_PROD_PLI']) .'&4=1&annee='. $annee .'">'. Affichage_zero($donnees['SEM_PROD_PLI']) .'</a></td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .'>'. Affichage_zero($donnees['TPS_PRODUIT_PLI']) .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .'><p class="EN_GRAS">'. Affichage_zero($donnees['QT_PRODUIT_PLI']) .'</p></td>';
				}
			}
					
			if($affichage[5] == "1"){ 
			//Affichage MIG
			
				if($donnees['QT_PRODUIT_MIG'] < $donnees['QT'] AND !empty($donnees['SOUDURE_MIG'])){
					$classStatuHeures ='class="SOUDURE"';
					$classStatuHeuresProduites ='class="TPS_PROD_SOUDURE"';
				}
				else{
					$classStatuHeures ='class="Tableau_F08080"'; 
					$classStatuHeuresProduites ='class="Tableau_F08080"'; 
				}
					
				if($donnees['SUP']==4){
					$classStatuHeures ='class="case_produite"'; 
					$classStatuHeuresProduites ='class="case_produite"'; 
					$block5_contenu = '<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .' colspan="5"> Livraison sur appel</td>';

				}
				elseif($donnees['SUP']==2){
					$classStatuHeures ='class="case_produite"'; 
					$classStatuHeuresProduites ='class="case_produite"'; 
					$block5_contenu = '<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .' colspan="5"> Annulé</td>';
				}
				else{
					$STT ='';
					if(!empty($donnees['id_SST']) AND $donnees['ORDRE'] == -5){
						$STT = '<a href="soustraitance.php?id_cmd='. $donnees['id'] .'"><span title="'. $donnees['FOURNISSEUR'] .'">oui</a></span>';
						$block5 = true;
					}
					
					$block5_contenu = '
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classSST .'>'. $STT .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeures .'>'. Affichage_zero($donnees['SOUDURE_MIG']) .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .'><a href="planning.php?sem='. Affichage_zero($donnees['SEM_PROD_MIG']) .'&5=1&annee='. $annee .'">'. Affichage_zero($donnees['SEM_PROD_MIG']) .'</a></td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .'>'. Affichage_zero($donnees['TPS_PRODUIT_MIG']) .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .'><p class="EN_GRAS">'. Affichage_zero($donnees['QT_PRODUIT_MIG']) .'</p></td>';
				}
			}
			
			if($affichage[6] == "1"){ 
			//Affichage TIG
			
				if($donnees['QT_PRODUIT_TIG'] < $donnees['QT'] AND !empty($donnees['SOUDURE_TIG'])){
					$classStatuHeures ='class="SOUDURE"';
					$classStatuHeuresProduites ='class="TPS_PROD_SOUDURE"';
				}
				else{
					$classStatuHeures ='class="Tableau_F08080"'; 
					$classStatuHeuresProduites ='class="Tableau_F08080"'; 
				}
					
				if($donnees['SUP']==4){
					$classStatuHeures ='class="case_produite"'; 
					$classStatuHeuresProduites ='class="case_produite"'; 
					$block6_contenu = '<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .' colspan="5"> Livraison sur appel</td>';
				}
				elseif($donnees['SUP']==2){
					$classStatuHeures ='class="case_produite"'; 
					$classStatuHeuresProduites ='class="case_produite"'; 
					$block6_contenu = '<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .' colspan="5"> Annulé</td>';
				}
				else{
						
					$STT ='';
					if(!empty($donnees['id_SST']) AND $donnees['ORDRE'] == -5){
						$STT = '<a href="soustraitance.php?id_cmd='. $donnees['id'] .'"><span title="'. $donnees['FOURNISSEUR'] .'">oui</a></span>';
						$block6 = true;
					}
					
					$block6_contenu = '
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classSST .'>'. $STT .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeures .'>'. Affichage_zero($donnees['SOUDURE_TIG']) .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .'><a href="planning.php?sem='. Affichage_zero($donnees['SEM_PROD_TIG']) .'&6=1&annee='. $annee .'">'. Affichage_zero($donnees['SEM_PROD_TIG']) .'</a></td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .'>'. Affichage_zero($donnees['TPS_PRODUIT_TIG']) .'</td>
							<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .'><p class="EN_GRAS">'. Affichage_zero($donnees['QT_PRODUIT_TIG']) .'</p></td>';
				}
			}
					

		
		
				$STT ='';
					if(!empty($donnees['id_SST']) AND $donnees['ORDRE'] > 0){
						$STT = '<a href="soustraitance.php?id_cmd='. $donnees['id'] .'"><span title="'. $donnees['FOURNISSEUR'] .'">oui</a></span>';
						$block7 = true;
					}
				
				if($donnees['SUP']==3){
					$classStatuHeures ='class="case_produite"'; 
					$classStatuHeuresProduites ='class="case_produite"'; 
					$block7_contenu = '
						<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classSST .'>'. $STT .'</td>
						<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' ><p class="EN_GRAS">'. $donnees['QT_EXPEDIER'] .'</p></td>
						<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .' colspan="3"> Stock</td>';

				}
				elseif($donnees['SUP']==2){
					$classStatuHeures ='class="case_produite"'; 
					$classStatuHeuresProduites ='class="case_produite"'; 
					$block7_contenu = '<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classStatuHeuresProduites .' colspan="5"> Annulé</td>';
				}
				else{
							
					$block7_contenu = '
						<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' '. $classSST .'>'. $STT .'</td>
						<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' ><p class="EN_GRAS">'. $donnees['QT_EXPEDIER'] .'</p></td>
						<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' >'. $donnees['TRANSPORTEUR'] .'</td>
						<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' > <span title="'. $donnees['COMMENTAIRES'] .'">'. extrait($donnees['COMMENTAIRES']) .'</span></td>
						<td '. padding_ligne($commandeENCours, $donnees['COMMANDE']) .' > '. $donnees['POIDS'] .' Kg</td>
					</tr>';
				}
			
			$id_ligne = $donnees['id'];
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
				
			$STT ='';
		}
		
		$commandeENCours = $donnees['COMMANDE'];
	}
	
	$Contenu_tableau = $Contenu_tableau . $block0_contenu . $block1_contenu . $block2_contenu . $block3_contenu . $block4_contenu . $block5_contenu . $block6_contenu . $block7_contenu;
		
	$req->closeCursor();
		
	if($affichage[1] == "1"){ 
			//Affichage laser
			$En_tete = $En_tete .'
						<th>'. EN_TETE_TABLEAU_COL_48 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_15 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_16 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_17 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_18 .'</th>';
						
			$Pied_page = $Pied_page ."
						<th></th>
						<th>". $SommeHeure_laser ."</th>
						<th></th>
						<th>". $SommeHeureProduite_laser ."</th>
						<th></th>";
								
		}
			
		if($affichage[2] == "1"){ 
			//Affichage Ebavurage
			$En_tete = $En_tete .'
						<th>'. EN_TETE_TABLEAU_COL_48 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_19 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_20 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_21 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_22 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_23 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_24 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_25 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_26 .'</th>';
						
			$Pied_page = $Pied_page ."
						<th></th>
						<th>". $SommeHeure_ebav ."</th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th>". $SommeHeureProduite_ebav ."</th>
						<th></th>";
		}
		
		if($affichage[3] == "1"){ 
			//Affichage Parachèvement
			$En_tete = $En_tete .'
						<th>'. EN_TETE_TABLEAU_COL_48 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_27 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_28 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_29 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_30 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_31 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_32 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_33 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_34 .'</th>';
			
			$Pied_page = $Pied_page ."
						<th></th>
						<th>". $SommeHeure_para ."</th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th>". $SommeHeureProduite_para ."</th>
						<th></th>";
		}
		
		if($affichage[4] == "1"){ 
			//Affichage Pliage
			$En_tete = $En_tete .'
						<th>'. EN_TETE_TABLEAU_COL_48 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_35 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_36 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_37 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_38 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_39 .'</th>';
			$Pied_page = $Pied_page ."
						<th></th>
						<th>". $SommeHeure_pliage ."</th>
						<th></th>
						<th></th>
						<th>". $SommeHeureProduite_pliage ."</th>
						<th></th>";
		}
		
		if($affichage[5] == "1"){ 
			//Affichage MIG
			$En_tete = $En_tete .'
						<th>'. EN_TETE_TABLEAU_COL_48 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_40 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_41 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_42 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_43 .'</th>';
						
			$Pied_page = $Pied_page ."
						<th></th>
						<th>". $SommeHeure_MIG ."</th>
						<th></th>
						<th>". $SommeHeureProduite_MIG ."</th>
						<th></th>";
		}

		if($affichage[6] == "1"){ 
			//Affichage TIG
			$En_tete = $En_tete .'
						<th>'. EN_TETE_TABLEAU_COL_48 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_44 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_45 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_46 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_47 .'</th>';
						
			$Pied_page = $Pied_page ."
						<th></th>
						<th>". $SommeHeure_TIG ."</th>
						<th></th>
						<th>". $SommeHeureProduite_TIG ."</th>
						<th></th>";
		}
		
		
	$contenu = $contenu .'
		<form  method="post" action="planning.php" id="formulaire_sem">
			<table id="tableau_plannig">
				<thead>
					<tr> 
						<th><input type= "checkbox" onclick="return cocherOuDecocherTout(this);" /></th>
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
						'. $En_tete .'
						<th>'. EN_TETE_TABLEAU_COL_48 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_64 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_65 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_66 .'</th>
						<th>'. EN_TETE_TABLEAU_COL_67 .'</th>
					</tr>
				</thead>
			<tbody>
			'. $Contenu_tableau .'
			</tbody>
				<tfoot>
					<tr> 
						<th>'. $nb .'</th>
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
						<th></th>
						<th></th>
						'. $Pied_page .'
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th>'. $SommePoids .'</th>
					</tr>
				</tfoot>
			</table>
			<p style="color :white">
				Selectionné votre action : 
				<select name="planning" id="planning">
					'. ACTION_FORMULAIRE .'
				</select>
			</p>
			<p>
				<br/>
				<input type="button" value="Retour" onClick="window.history.back()"><input type="submit" value="Valider" />
			</p>
		</form>
		
		<form>
			<p id="impression">
				<br/>
				<br/>
				<input id="impression" name="impression" type="button" onclick="imprimer_page()" value="Imprimer cette page" />
			</p>
		</form>';
	}

?>