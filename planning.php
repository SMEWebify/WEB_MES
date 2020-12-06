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
	
	if($_SESSION['page_2'] != '1'){
		
		stop('L\'accès vous est interdit.', 161, 'connexion.php');
	}
	
	if(isset($_POST['planning']) AND $_POST['planning'] == "export_exel"){
	
		Include("include/exportexel.php");
	}
	elseif(isset($_POST['planning']) AND $_POST['planning'] == "etiquette_petite" OR isset($_POST['planning']) AND $_POST['planning'] == "etiquette_grande"){
		
		Include("etiquette.php");
	}
	elseif(isset($_POST['planning']) AND $_POST['planning'] == "OF"){
		
		Include("OF.php");
	}
	elseif(isset($_GET['export']) AND isset($_GET['sem']) AND !empty($_GET['sem']) AND isset($_GET['annee']) AND !empty($_GET['annee'])){
		
		Include("export_sem.php");
	}
	

	$SelectZone_CLIENT = '<option value=""></option>';
	
	// LISTING DES CLIENT
	$reponse = $bdd -> query('SELECT DISTINCT CLIENT FROM `'. TABLE_ERP_PLANNING .'` WHERE  `'. TABLE_ERP_PLANNING .'`.sup!=1 ORDER BY CLIENT ');
	while ($donneesSelectZone = $reponse->fetch())
	{
		$SelectZone_CLIENT = $SelectZone_CLIENT .'
														<option value="'. $donneesSelectZone['CLIENT'] .'">'. $donneesSelectZone['CLIENT'] .'</option>';
	}
	
	// LISTING DES COMMANDE
	$SelectZone_COMMANDE = '<option value=""></option>';
	$reponse = $bdd -> query('SELECT DISTINCT COMMANDE FROM `'. TABLE_ERP_PLANNING .'` WHERE `'. TABLE_ERP_PLANNING .'`.sup!=1 ORDER BY COMMANDE ');
	while ($donneesSelectZone = $reponse->fetch())
	{
		$SelectZone_COMMANDE = $SelectZone_COMMANDE .'
														<option value="'. $donneesSelectZone['COMMANDE'] .'">'. $donneesSelectZone['COMMANDE'] .'</option>';
	}
	
	if(isset($_GET['sem'])){
		$sem = intval($_GET['sem']);
	}
	
	$contenu = '
		<form  method="get" action="planning.php" class="content-form">
			<table class="content-table">
				<tr>
					<td>
												<br/>
												N° de semaine (ex : 01 / 16 / 09 nuit) <input type="text" value="'. $sem .'" name="sem" />
												<select name="annee">
													<option value="2013" '. selected(2013, $_GET['annee']) .'>2013</option>
													<option value="2014" '. selected(2014, $_GET['annee']) .'>2014</option>
													<option value="2015" '. selected(2015, $_GET['annee']) .'>2015</option>
													<option value="2016" '. selected(2016, $_GET['annee']) .'>2016</option>
													<option value="2017" '. selected(2017, $_GET['annee']) .'>2017</option>
													<option value="2018" '. selected(2018, $_GET['annee']) .'>2018</option>
													<option value="2019" '. selected(2019, $_GET['annee']) .'>2019</option>
													<option value="2020" '. selected(2020, $_GET['annee']) .'>2020</option>
													<option value="2021" '. selected(2021, $_GET['annee']) .'>2021</option>
													<option value="2022" '. selected(2022, $_GET['annee']) .'>2022</option>
													<option value="2023" '. selected(2023, $_GET['annee']) .'>2023</option>
												</select>
												<br/>
												<br/>
												<input type="checkbox" '. checked(1, $_GET['1']) .' name="1" value="1" id="Planning_laser" /> <label for="Laser">Laser</label>
												<input type="checkbox" '. checked(1, $_GET['2']) .' name="2" value="1" id="Planning_ebav" /> <label for="Ebavurage">Ebavurage</label>
												<input type="checkbox" '. checked(1, $_GET['3']) .' name="3" value="1" id="Planning_para" /> <label for="Parachevement">Parachèvement</label>
												<input type="checkbox" '. checked(1, $_GET['4']) .' name="4" value="1" id="Planning_pliage" /> <label for="Laser">Pliage</label>
												<input type="checkbox" '. checked(1, $_GET['5']) .' name="5" value="1" id="Planning_MIG" /> <label for="Laser">Soudure MIG</label>
												<input type="checkbox" '. checked(1, $_GET['6']) .' name="6" value="1" id="Planning_TIG" /> <label for="Laser">Soudure TIG</label>
					</td>
					<td>
												<br/>
												N° de cmd  MI :  <select name="ref_CO">'. $SelectZone_COMMANDE .'</select><br/>
												<br/>
												Nom de Client : <select name="CLIENT">'. $SelectZone_CLIENT .'</select><br/>
					</td>
				</tr>
				<tr>
					<td colspan="2" >
						<br/>
						<input type="submit" class="input-moyen"  value="Générer Planning" /> <br/>
						<br/>
					</td>
				</tr>
			</table>
		</form>
		';


	if(isset($_GET['sem']) OR isset($_GET['ref_CO']) OR isset($_GET['ref_CO_CLI']) OR isset($_GET['CLIENT'])){
		
		Include("include/generation_planing.php");
	}
	elseif(isset($_POST['planning']) AND $_POST['planning'] == "modifier_cmd"){
		
		Include("include/modification_planing.php");

	}
	elseif(isset($_POST['id_modif_ligne']) AND !empty($_POST['id_modif_ligne'])){
		
		$id_modif = $_POST['id_modif_ligne'];						$id_recurrent = $_POST['ID_PLAN'];						$num_cmd = $_POST['num_cmd']; 													$cmd_client = $_POST['cmd_client'];
		$CLIENT_NOM = $_POST['CLIENT_NOM_MODIF'];					$plan = $_POST['plan'];									$designation = $_POST['designation'];
		$QT = $_POST['QT'];											$prix_u = $_POST['prix_u'];
		$matiere = $_POST['matiere'];								$epaisseur = $_POST['epaisseur'];						$date_client_array = $_POST['date_client'];
		$date_confirm_array = $_POST['date_confirm'];				$etude = $_POST['etude'];								$stock = $_POST['stock'];
			
		$heure_laser = $_POST['heure_laser'];						$sem_laser = $_POST['sem_laser'];						$heure_produite_laser = $_POST['heure_produite_laser'];							$QT_PRODUIT_L = $_POST['QT_PRODUIT_L'];				
			
		$EBAVURAGE = $_POST['EBAVURAGE'];							$ORBITALE = $_POST['ORBITALE'];							$EBAV_CHAMPS = $_POST['EBAV_CHAMPS'];											$SUP_MICRO_ATTACHE = $_POST['SUP_MICRO_ATTACHE'];					$TRIBOFINITION = $_POST['TRIBOFINITION'];		$SEM_EBAV = $_POST['sem_ebav'];							$heure_produite_ebav = $_POST['heure_produite_ebav'];							$QT_PRODUIT_EBAV = $_POST['QT_PRODUIT_EBAV'];			
				
		$PARACHEVEMENT = $_POST['PARACHEVEMENT'];					$PERCAGE = $_POST['PERCAGE'];							$TARAUDAGE = $_POST['TARAUDAGE'];												$FRAISURAGE = $_POST['FRAISURAGE'];									$INSERT_P = $_POST['INSERT_P'];					$sem_PARACHEVEMENT = $_POST['sem_PARACHEVEMENT'];		$heure_produite_PARACHEVEMENT = $_POST['heure_produite_PARACHEVEMENT'];			$QT_PRODUIT_PARA = $_POST['QT_PRODUIT_PARA'];
				
		$PLIAGE = $_POST['PLIAGE'];									$nbr_op = $_POST['nbr_op'];								$SEM_PROD_PLI = $_POST['SEM_PROD_PLI'];											$TPS_PRODUIT_PLI = $_POST['TPS_PRODUIT_PLI'];						$QT_PRODUIT_PLI	 = $_POST['QT_PRODUIT_PLI'];		
			
		$SOUDURE_MIG = $_POST['SOUDURE_MIG'];						$SEM_PROD_MIG = $_POST['SEM_PROD_MIG'];					$TPS_PRODUIT_MIG = $_POST['TPS_PRODUIT_MIG'];									$QT_PRODUIT_MIG = $_POST['QT_PRODUIT_MIG'];
		$SOUDURE_TIG = $_POST['SOUDURE_TIG'];						$SEM_PROD_TIG = $_POST['SEM_PROD_TIG'];					$TPS_PRODUIT_TIG = $_POST['TPS_PRODUIT_TIG'];									$QT_PRODUIT_TIG = $_POST['QT_PRODUIT_TIG'];
			
		$mise_a_dispo = $_POST['mise_a_dispo'];						$QT_EXPEDIER = $_POST['QT_EXPEDIER'];					$TRANSPORTEUR = $_POST['TRANSPORTEUR'];											$commentaire = $_POST['commentaire'];								$poids = $_POST['poids']; 						$DEVIS = $_POST['DEVIS'];
			
		$contenu = $contenu. '
							<p class="message">';
		
		$i = 0;
		foreach ($id_modif as $id_generation) {
				
				$date_client = join('-',array_reverse(explode('/',$date_client_array[$i])));
				$date_confirm = join('-',array_reverse(explode('/',$date_confirm_array[$i])));
				
				//addslashes() 
				//stripslashes
				
				if(empty($id_recurrent[$i])){
					$id_rec ='';
				}
				else{
					$id_rec = 'id_RECURENT = \''. $id_recurrent[$i] .'\',';
				}
				
				
				$bdd->exec('UPDATE `'. TABLE_ERP_PLANNING .'` SET '. $id_rec .'  COMMANDE = \''. $num_cmd[$i] .'\', CO_CLIENT = \''. addslashes($cmd_client[$i]) .'\', CLIENT = \''. addslashes($CLIENT_NOM[$i]) .'\',
												PLAN = \''. addslashes($plan[$i]) .'\', DESIGNATION = \''. addslashes($designation[$i]) .'\', QT = \''. round($QT[$i]) .'\',
												PRIX_U = \''. Remplace_virgule($prix_u[$i]) .'\', MATIERE = \''. $matiere[$i] .'\',
												EPAISSEUR = \''. $epaisseur[$i] .'\', DATE_CLIENT = \''. $date_client .'\', DATE_CONFIRM = \''. $date_confirm .'\',
												ETUDE = \''. $etude[$i] .'\', STOCK = \''. $stock[$i] .'\',
												TRUMPH_1 = \''. Remplace_virgule($heure_laser[$i]) .'\', SEM_PROD_LASER = \''. round($sem_laser[$i]) .'\', TPS_PRODUIT_L = \''. Remplace_virgule($heure_produite_laser[$i]) .'\', QT_PRODUIT_L = \''. round($QT_PRODUIT_L[$i]) .'\',
												EBAVURAGE = \''. Remplace_virgule($EBAVURAGE[$i]) .'\', ORBITALE = \''. $ORBITALE[$i] .'\', EBAV_CHAMPS = \''. $EBAV_CHAMPS[$i] .'\', SUP_MICRO_ATTACHE = \''. $SUP_MICRO_ATTACHE[$i] .'\', TRIBOFINITION = \''. $TRIBOFINITION[$i] .'\', SEM_PROD_EBAV = \''. round($SEM_EBAV[$i]) .'\', TPS_PRODUIT_EBAV = \''. Remplace_virgule($heure_produite_ebav[$i]) .'\',QT_PRODUIT_EBAV = \''. round($QT_PRODUIT_EBAV[$i]) .'\',
												PARACHEVEMENT = \''. Remplace_virgule($PARACHEVEMENT[$i]) .'\', PERCAGE = \''. $PERCAGE[$i] .'\', TARAUDAGE = \''. $TARAUDAGE[$i] .'\', FRAISURAGE = \''. $FRAISURAGE[$i] .'\', INSERT_P = \''. $INSERT_P[$i] .'\', SEM_PROD_PARA = \''. round($sem_PARACHEVEMENT[$i]) .'\', TPS_PRODUIT_P = \''. Remplace_virgule($heure_produite_PARACHEVEMENT[$i]) .'\', QT_PRODUIT_PARA = \''. round($QT_PRODUIT_PARA[$i]) .'\',
												PLIAGE = \''. Remplace_virgule($PLIAGE[$i]) .'\', NBR_OP = \''. round($nbr_op[$i]) .'\', SEM_PROD_PLI = \''. round($SEM_PROD_PLI[$i]) .'\', TPS_PRODUIT_PLI = \''. Remplace_virgule($TPS_PRODUIT_PLI[$i]) .'\', QT_PRODUIT_PLI = \''. round($QT_PRODUIT_PLI[$i]) .'\',
												SOUDURE_MIG = \''. Remplace_virgule($SOUDURE_MIG[$i]) .'\', SEM_PROD_MIG = \''. round($SEM_PROD_MIG[$i]) .'\', TPS_PRODUIT_MIG = \''. Remplace_virgule($TPS_PRODUIT_MIG[$i]) .'\', QT_PRODUIT_MIG = \''. round($QT_PRODUIT_MIG[$i]) .'\',
												SOUDURE_TIG = \''. Remplace_virgule($SOUDURE_TIG[$i]) .'\', SEM_PROD_TIG = \''. round($SEM_PROD_TIG[$i]) .'\', TPS_PRODUIT_TIG = \''. Remplace_virgule($TPS_PRODUIT_TIG[$i]) .'\', QT_PRODUIT_TIG = \''. round($QT_PRODUIT_TIG[$i]) .'\',
												QT_EXPEDIER = \''. round($QT_EXPEDIER[$i]) .'\', 
												TRANSPORTEUR = \''. $TRANSPORTEUR[$i] .'\',
												COMMENTAIRES = \''. addslashes($commentaire[$i]) .'\', 
												POIDS = \''. Remplace_virgule($poids[$i]) .'\',
												DEVIS = \''. addslashes($DEVIS[$i]) .'\'
				WHERE id IN ('. $id_generation . ')');
			
				$contenu = $contenu. '
									'. $i .' - La commande <a href="planning.php?ref_CO='. $num_cmd[$i] .'">'. $num_cmd[$i] .'</a>, référence :  '. $plan[$i] .' à bien été modifiée <br/>';
			$i++;
		}
				
		$contenu = $contenu. '</p>';
		
	}
	elseif(isset($_POST['planning']) AND $_POST['planning'] == "annuler_cmd"){
		
		Include("include/annuler_planing.php");
	}
	elseif(isset($_POST['id_anul_ligne']) AND !empty($_POST['id_anul_ligne'])){
		
		$selected_checkbox = implode(",",$_POST['id_anul_ligne']);
		
		$bdd->exec('UPDATE `'. TABLE_ERP_PLANNING .'` SET sup = 2 WHERE id IN ('. $selected_checkbox . ')');
			
			
		$contenu = $contenu. '
							<p class="message">
								Les lignes on été annulées
							</p>';
	}
	elseif(isset($_POST['planning']) AND $_POST['planning'] == "supprimer_cmd"){
		
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
								Etes vous sur de vouloirs supprimer les informations ci-dessous ?<br/>
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
					<td class="commande"><input type="hidden" name="id_sup_ligne[]" value="'. $donnees['id'] .'"> '. $donnees['COMMANDE'] .'</td> 
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
					<input type="button" value="Retour" onClick="window.history.back()"><input type="submit" value="Supprimer les lignes" />
				</p>
			</form>';	
		}
	}
	elseif(isset($_POST['planning']) AND $_POST['planning'] == "ajout_SST"){ 
	
		Include("include/ajout_SST.php");
		
	}
	elseif(isset($_POST['id_sup_ligne']) AND !empty($_POST['id_sup_ligne'])){
		
		$selected_checkbox = implode(",",$_POST['id_sup_ligne']);
		
		$bdd->exec('UPDATE `'. TABLE_ERP_PLANNING .'` SET sup = 1 WHERE id IN ('. $selected_checkbox . ')');
			
			
		$contenu = $contenu. '
							<p class="message">
								Les lignes on été supprimées
							</p>';
	}
	elseif(isset($_POST['planning']) AND ($_POST['planning'] == "decla_laser" OR $_POST['planning'] == "decla_ebav" OR $_POST['planning'] == "decla_para" OR $_POST['planning'] == "decla_pli" OR $_POST['planning'] == "decla_soudure_mig"  OR $_POST['planning'] == "decla_soudure_tig" OR $_POST['planning'] == "decla_expe")){
		
		Include("include/declaration.php");
		
	}
	elseif(isset($_POST['id_decla_ligne']) AND !empty($_POST['id_decla_ligne'])){
		
		$complementRequete = '';

		$id_modif = $_POST['id_decla_ligne'];					

		if(isset($_POST['TRUMPH_1'])){
			$heure_produite_laser = $_POST['TPS_PRODUIT'];						$QT_PRODUIT_L = $_POST['QT_PRODUITE'];				
		}
		if(isset($_POST['EBAVURAGE'])){
			$heure_produite_ebav = $_POST['TPS_PRODUIT'];						$QT_PRODUIT_EBAV = $_POST['QT_PRODUITE'];			
		}
		if(isset($_POST['PARACHEVEMENT'])){
			$heure_produite_PARACHEVEMENT = $_POST['TPS_PRODUIT'];				$QT_PRODUIT_PARA = $_POST['QT_PRODUITE'];
		}
		if(isset($_POST['PLIAGE'])){
			$TPS_PRODUIT_PLI = $_POST['TPS_PRODUIT'];							$QT_PRODUIT_PLI	 = $_POST['QT_PRODUITE'];		
		}
		if(isset($_POST['SOUDURE_MIG'])){
			$TPS_PRODUIT_MIG = $_POST['TPS_PRODUIT'];							$QT_PRODUIT_MIG = $_POST['QT_PRODUITE'];
		}
		if(isset($_POST['SOUDURE_TIG'])){
			$TPS_PRODUIT_TIG = $_POST['TPS_PRODUIT'];							$QT_PRODUIT_TIG = $_POST['QT_PRODUITE'];
		}
		if(isset($_POST['QT_EXPEDIER'])){
			$QT_EXPEDIER = $_POST['QT_PRODUITE'];
		}
		

		$commentaire = $_POST['commentaire'];				
		$poids = $_POST['poids'];
		
		$contenu = $contenu. '
						<p class="message">';
		
		$i = 0;
		foreach ($id_modif as $id_generation) {
		
			if(isset($_POST['TRUMPH_1'])){
				$complementRequete = ' TPS_PRODUIT_L = \''. Remplace_virgule($heure_produite_laser[$i]) .'\', QT_PRODUIT_L = \''.round($QT_PRODUIT_L[$i]) .'\',';
			}
			if(isset($_POST['EBAVURAGE'])){
				$complementRequete = ' TPS_PRODUIT_EBAV = \''. Remplace_virgule($heure_produite_ebav[$i]) .'\',QT_PRODUIT_EBAV = \''. round($QT_PRODUIT_EBAV[$i]) .'\',';
			}
			if(isset($_POST['PARACHEVEMENT'])){
				$complementRequete = ' TPS_PRODUIT_P = \''. Remplace_virgule($heure_produite_PARACHEVEMENT[$i]) .'\', QT_PRODUIT_PARA = \''. round($QT_PRODUIT_PARA[$i]) .'\',';
			}
			if(isset($_POST['PLIAGE'])){
				$complementRequete = ' TPS_PRODUIT_PLI = \''. Remplace_virgule($TPS_PRODUIT_PLI[$i]) .'\', QT_PRODUIT_PLI = \''. round($QT_PRODUIT_PLI[$i]) .'\',';
			}
			if(isset($_POST['SOUDURE_MIG'])){
				$complementRequete = ' TPS_PRODUIT_MIG = \''. Remplace_virgule($TPS_PRODUIT_MIG[$i]) .'\', QT_PRODUIT_MIG = \''. round($QT_PRODUIT_MIG[$i]) .'\',';
			}
			if(isset($_POST['SOUDURE_TIG'])){
				$complementRequete = ' TPS_PRODUIT_TIG = \''. Remplace_virgule($TPS_PRODUIT_TIG[$i]) .'\', QT_PRODUIT_TIG = \''. round($QT_PRODUIT_TIG[$i]) .'\',';
			}
			if(isset($_POST['QT_EXPEDIER'])){
				$complementRequete = 'QT_EXPEDIER = \''. round($QT_EXPEDIER[$i]) .'\', ';
			}
				
			$bdd->exec('UPDATE `'. TABLE_ERP_PLANNING .'`
								SET  '. $complementRequete .'
									COMMENTAIRES = \''. addslashes($commentaire[$i]) .'\'
								WHERE id IN ('. $id_generation . ')');
		
			$contenu = $contenu .' '. $i .' Ligne(s) de la commande <a href="planning.php?ref_CO='.  $_POST['COMMANDE'] .'">'.  $_POST['COMMANDE'] .'</a> modifiée(s)<br/>';
			$i++;
		}
								
		$contenu = $contenu. '</p>';
		
	}
	elseif(isset($_POST['id_ajout_SST_ligne']) AND !empty($_POST['id_ajout_SST_ligne'])){
		
		$id_ajout_SST_ligne = $_POST['id_ajout_SST_ligne'];						
		$FOURNISSEUR = $_POST['FOURNISSEUR'];	
		$CMD_ACHAT = $_POST['CMD_ACHAT'];			
		$DATE_RELANCE = $_POST['DATE_RELANCE']; 		
		$DATE_RECEPTION = $_POST['DATE_RECEPTION'];
		$PRIX = $_POST['PRIX'];
		$NUM_OFFRE = $_POST['NUM_OFFRE'];
		$ORDRE = $_POST['ORDRE'];
		$COMMANDE = $_POST['COMMANDE'];
		
		$contenu = $contenu. '
							<p class="message">';
		
		$i = 0;
		foreach ($id_ajout_SST_ligne as $id_generation) {
				
				$DATE_RELANCE_ajouter = join('-',array_reverse(explode('/',$DATE_RELANCE[$i])));
				$DATE_RECEPTION_ajouter  = join('-',array_reverse(explode('/',$DATE_RECEPTION[$i])));
				
				//addslashes() 
				//stripslashes
				
				$req = $bdd->exec("INSERT INTO `". TABLE_ERP_SOUS_TRAITANCE ."` VALUE ('' ,'". $id_generation ."', CURDATE(),'". $DATE_RELANCE_ajouter  ."' , '0', '". $DATE_RECEPTION_ajouter  ."' ,'0','". addslashes($FOURNISSEUR[$i]) ."','". $CMD_ACHAT[$i] ."','". $PRIX[$i] ."','". addslashes($NUM_OFFRE[$i]) ."','". $ORDRE[$i] ."' ) ");

			
				$contenu = $contenu. '
									'. $i .' - La Sous-traitance pour  la commande <a href="planning.php?ref_CO='. $COMMANDE[$i] .'">'. $COMMANDE[$i] .'</a>, Fournisseur :  '. $FOURNISSEUR[$i] .' à bien été ajoutée <br/>';
			$i++;
		}
				
		$contenu = $contenu. '</p>';
		
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

</section>

</body>
</html>