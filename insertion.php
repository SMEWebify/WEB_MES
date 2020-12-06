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
	
	if($_SESSION['page_4'] != '1'){
		
		stop('L\'accès vous est interdit.', 161, 'connexion.php');
	}

	$contenu = "";
	
	if(isset($_FILES['fichier_csv'])){
		
		$contenu = '<p class="message">';
		
		if(empty($_POST['numero_cmd_MI'])){
			
			$contenu = $contenu .'Aucun numéro de commande saisie';
			
		}
		else{
			
			$dossier = 'upload/';
			$fichier = basename($_FILES['fichier_csv']['name']);
			
			if(move_uploaded_file($_FILES['fichier_csv']['tmp_name'], $dossier . $fichier))
			{
				$contenu = $contenu . 'Upload du fichier effectué avec succès !<br/>';
				
				$contenu = $contenu .  'Chemin du fichier : upload/'.$_FILES['fichier_csv']['name'].'<br><br>Resultat Import SQL : <br/>';
		 
				$fichier = fopen("upload/".$_FILES['fichier_csv']['name'], "r");
				
				$date_MI = join('-',array_reverse(explode('/',$_POST['DATE_CONF'])));
						
				$nom_devis = '';
						
				$i = 0;
				echo feof($fichier);
				//tant qu'on est pas a la fin du fichier :
				while (!feof($fichier))
				{
					// On recupere toute la ligne
					$LigneFichier = addslashes(fgets($fichier));
					
					//On met dans un tableau les differentes valeurs trouvés (ici séparées par un ';')
					$tableauValeurs = explode(';', $LigneFichier);
					
					if(!empty($tableauValeurs[2]) AND $i > 0){
						
						if($i == 1) $nom_devis = $tableauValeurs[62];
							
						// On crée la requete pour inserer les donner 
						$req = $bdd->exec("INSERT INTO `". TABLE_ERP_PLANNING ."` VALUE ('' 
														,'0'
														,'0'
														,'". $_POST['numero_cmd_MI'] ."'
														,'". $_POST['numero_cmd_client'] ."'
														,'". $tableauValeurs[2]."'
														,'". addslashes($tableauValeurs[3])."'
														,'". addslashes($tableauValeurs[4])."'
														,'". addslashes($tableauValeurs[5])."'
														,'". $tableauValeurs[6]."'
														,'". $tableauValeurs[8]."'
														,'". $tableauValeurs[9]."'
														,'". dateclient($tableauValeurs[10]) ."'
														,'". $date_MI ."'
														,''
														,''
														,'". Remplace_virgule($tableauValeurs[15])."'
														,'". round($_POST['SemLaser']) ."'
														,''
														,'0'
														,'". Remplace_virgule($tableauValeurs[18])."'
														,'".$tableauValeurs[19]."'
														,'".$tableauValeurs[20]."'
														,'".$tableauValeurs[21]."'
														,'".$tableauValeurs[22]."'
														,'". round($_POST['SemEbav']) ."'
														,''
														,'0'
														, '". Remplace_virgule($tableauValeurs[25])."'
														, '".$tableauValeurs[26]."'
														, '".$tableauValeurs[27]."'
														, '".$tableauValeurs[28]."'
														, '".$tableauValeurs[29]."'
														,'". round($_POST['SemPara']) ."'
														,''
														,'0'
														, '". Remplace_virgule($tableauValeurs[32])."'
														, '".$tableauValeurs[33]."'
														,'". round($_POST['SemPLiage']) ."'
														,''
														,'0'
														, '". Remplace_virgule($tableauValeurs[36])."'
														,'". round($_POST['SemMIG']) ."'
														,''
														,'0'
														, '". Remplace_virgule($tableauValeurs[39])."'
														,'". round($_POST['SemTIG']) ."'
														,''
														,'0'
														,'0'
														, '".$tableauValeurs[58]."'
														, '". addslashes($tableauValeurs[59])."'
														, '". Remplace_virgule($tableauValeurs[60])."'
														, '". $nom_devis ."') ");
					}
					
					$i++;
				}
				
				//vérification et envoi d'une réponse à l'utilisateur
				if ($req)
				{
					$contenu = $contenu . '
					Ajout dans la base de données effectué avec succès <a href="planning.php?ref_CO='. $_POST['numero_cmd_MI'] .'"> Vérifier la commande </a>';
				}
				else
				{
					$contenu = $contenu . 'Echec dans l\'ajout dans la base de données 1<br/>';
				}
			}
			else
			{
				$contenu = $contenu . 'Echec de l\'upload ! ou fichier non transmit.<br/>';
			}
		}
		
		$contenu = $contenu . '</p>';
	}
	elseif(isset($_POST['AJOUT_REF_PLANNING'])){
		
		$contenu = '<p class="message">';
		
		if(empty($_POST['QT'])){
			
			$contenu = $contenu .'Merci d\'indiquer une Qt<br/>';
		}
		else{
			
			$ValeurSaisie = $_POST['AJOUT_REF_PLANNING'];
			
			$req = $bdd->prepare('SELECT * FROM `'. TABLE_ERP_PIECE_RECURENTE .'` WHERE id= ?');
			$req->execute(array($ValeurSaisie));
			
			$donnees = $req->fetch();
			
			
			if(isset($_POST['stock'])){
				
				$numero_cmd_MI =  "STOCK-" . id_aleatoire(6);
				
				$TYPE = '3';
				$PRIX_U = '';
				$DATE_CLIENT = '0000-00-00';
				$date_MI = join('-',array_reverse(explode('/',$_POST['DATE_CONF'])));
				$TRUMPH_1 = round(($_POST['QT']*$donnees['TPS_LASER'])/3600,2);
				$EBAVURAGE = round(($_POST['QT']*$donnees['TPS_EBAV'])/3600,2);
				$PARACHEVEMENT = round(($_POST['QT']*$donnees['TPS_PARA'])/3600,2);
				$PLIAGE = round(($_POST['QT']*$donnees['TPS_PLI'])/3600,2);
				$SOUDURE_MIG = round(($_POST['QT']*$donnees['TPS_MIG'])/3600,2);
				$SOUDURE_TIG = round(($_POST['QT']*$donnees['TPS_TIG'])/3600,2);
				$TRANSPORTEUR = '';
				$POIDS = round($_POST['QT']*$donnees['POIDS'],2);
				$nom_devis = $_POST['numero_cmd_MI'];
			
			}
			elseif(isset($_POST['appel'])){
				
				$numero_cmd_MI = $_POST['numero_cmd_MI'];
				
				$TYPE = '4';
				$PRIX_U = Remplace_virgule($donnees['PRIX_U']);
				$date_MI = join('-',array_reverse(explode('/',$_POST['DATE_CONF'])));
				$DATE_CLIENT = join('-',array_reverse(explode('/',$_POST['DATE_CLIENT'])));
				$TRUMPH_1 = '';
				$EBAVURAGE = '';
				$PARACHEVEMENT = '';
				$PLIAGE = '';
				$SOUDURE_MIG = '';
				$SOUDURE_TIG = '';
				$TRANSPORTEUR = $donnees['TRANSPORTEUR'];
				$POIDS = round($_POST['QT']*$donnees['POIDS'],2);
				$nom_devis = "Récurrent";
			}
			else{
				
				$numero_cmd_MI = $_POST['numero_cmd_MI'];
				
				$TYPE = '0';
				$PRIX_U = Remplace_virgule($donnees['PRIX_U']);
				$date_MI = join('-',array_reverse(explode('/',$_POST['DATE_CONF'])));
				$DATE_CLIENT = join('-',array_reverse(explode('/',$_POST['DATE_CLIENT'])));
				$TRUMPH_1 = round(($_POST['QT']*$donnees['TPS_LASER'])/3600,2);
				$EBAVURAGE = round(($_POST['QT']*$donnees['TPS_EBAV'])/3600,2);
				$PARACHEVEMENT = round(($_POST['QT']*$donnees['TPS_PARA'])/3600,2);
				$PLIAGE = round(($_POST['QT']*$donnees['TPS_PLI'])/3600,2);
				$SOUDURE_MIG = round(($_POST['QT']*$donnees['TPS_MIG'])/3600,2);
				$SOUDURE_TIG = round(($_POST['QT']*$donnees['TPS_TIG'])/3600,2);
				$TRANSPORTEUR = $donnees['TRANSPORTEUR'];
				$POIDS = round($_POST['QT']*$donnees['POIDS'],2);
				$nom_devis = "Récurrent";
			}
			
			
			$req = $bdd->exec("INSERT INTO `". TABLE_ERP_PLANNING ."` VALUE (''
														,'". $donnees['id'] ."'
														,'". $TYPE ."'
														,'". $numero_cmd_MI ."'
														,'". $_POST['numero_cmd_client'] ."'
														,'". addslashes($donnees['CLIENT']) ."'
														,'". addslashes($donnees['PLAN']) ."'
														,'". addslashes($donnees['DESIGNATION']) ."'
														,'". round($_POST['QT']) ."'
														,'". $PRIX_U ."'
														,'". $donnees['MATIERE'] ."'
														,'". Remplace_virgule($donnees['EPAISSEUR']) ."'
														,'". dateclient($DATE_CLIENT) ."'
														,'". $date_MI ."'
														,''
														,''
														,'". $TRUMPH_1 ."'
														,'". round($_POST['SemLaser']) ."'
														,''
														,'0'
														,'". $EBAVURAGE ."'
														,'". $donnees['ORTBITALE'] ."'
														,'". $donnees['EBAV_CHAMPS'] ."'
														,'". $donnees['SUP_MICRO_ATTACHE'] ."'
														,'". $donnees['TRIBOFINITION'] ."'
														,'". round($_POST['SemEbav']) ."'
														,''
														,'0'
														,'".$PARACHEVEMENT."'
														,'". $donnees['PERCAGE'] ."'
														,'". $donnees['TARAUDAGE'] ."'
														,'". $donnees['FRAISURAGE'] ."'
														,'". $donnees['INSERT_P'] ."'
														,'". round($_POST['SemPara']) ."'
														,''
														,'0'
														,'". $PLIAGE ."'
														,'". round($donnees['NBR_OP']) ."'
														,'". round($_POST['SemPLiage']) ."'
														,''
														,'0'
														,'".$SOUDURE_MIG."'
														,'". round($_POST['SemMIG']) ."'
														,''
														,'0'
														,'".$SOUDURE_TIG."'
														,'". round($_POST['SemTIG']) ."'
														,''
														,'0'
														,'0'
														,'". $TRANSPORTEUR ."'
														,'". addslashes($donnees['COMMENTAIRES']) ."'
														,'". $POIDS ."'
														, '". $nom_devis ."')");
														
				if ($req)
				{
					$contenu = $contenu . ' Ajout au planning effectué avec succès <a href="planning.php?ref_CO='. $numero_cmd_MI .'"> Vérifier la commande </a><br/>';
				}
				else
				{
					$contenu = $contenu . 'Echec dans l\'ajout dans la base de données 2<br/>';
				}
		}
		
		$contenu = $contenu. '</p>';
	}
	elseif(isset($_POST['AJOUT_CLIENT_RECURENTE']) AND isset($_POST['PLAN'])){
			
		$contenu ='<p class="message">';
	
		If (empty($_POST['AJOUT_CLIENT_RECURENTE'])){
			
			$contenu = $contenu .'Aucun Client selectionné<br/>';
		}
		elseif(empty($_POST['PLAN'])) {
			
			$contenu = $contenu .'Merci de rentrer un N° de Plan<br/>';
		}
		else{
		
			$res = $bdd->query('select count(*) as nb from `'. TABLE_ERP_PIECE_RECURENTE .'` WHERE  PLAN = \''. $_POST['PLAN'] .'\'');
			$data = $res->fetch();
			$nb = $data['nb'];
			if($nb > 0){
				$contenu = '
							La référence '. $_POST['PLAN'] .' existe déjà<br/>
							<br/>
							<input type="button" value="Retour" onClick="window.history.back()">';
			}
			else{
			
				$dossier_plan = 'plan/'. $_POST['AJOUT_CLIENT_RECURENTE'] .'/';
				if(!is_dir($dossier_plan)){
				   mkdir($dossier_plan);
				}

				$fichier_plan = basename($_FILES['fichier_plan_pdf']['name']);
				
				if(move_uploaded_file($_FILES['fichier_plan_pdf']['tmp_name'], $dossier_plan . $fichier_plan)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
				{
					
					
					$contenu = $contenu . 'Upload du fichier effectué avec succès ! <br/>';
					
					if(!isset($_POST['ORBITALE'])) {$orbitale = "";}else{$orbitale = "1";}
					if(!isset($_POST['EBAV_CHAMPS'])) {$ebav_champs = "";}else{$ebav_champs = "1";}
					if(!isset($_POST['SUP_MICRO_ATTACHE'])) {$sup_micro_attache = "";}else{$sup_micro_attache = "1";}
					if(!isset($_POST['TRIBOFINITION'])) {$tribofinition = "";}else{$tribofinition = "1";}
					if(!isset($_POST['PERCAGE'])) {$percage = "";}else{$percage = "1";}
					if(!isset($_POST['TARAUDAGE'])) {$taraudage = "";}else{$taraudage = "1";}
					if(!isset($_POST['FRAISURAGE'])) {$fraisurage = "";}else{$fraisurage = "1";}
					if(!isset($_POST['INSERT_P'])) {$insert_p = "";}else{$insert_p = "1";}
					
					$req = $bdd->exec("INSERT INTO `". TABLE_ERP_PIECE_RECURENTE ."` VALUE (''
																,'". addslashes($_POST['AJOUT_CLIENT_RECURENTE']) ."'
																,'". addslashes($_POST['PLAN']) ."'
																,'". addslashes($_POST['DESIGNATION']) ."'
																,'". Remplace_virgule($_POST['PRIX_U']) ."'
																,'". $_POST['MATIERE'] ."'
																,'". Remplace_virgule($_POST['EPAISSEUR']) ."'
																,'". Remplace_virgule($_POST['TPS_LASER']) ."'
																,'". Remplace_virgule($_POST['TPS_EBAV']) ."'
																,'". $orbitale ."'
																,'". $ebav_champs ."'
																,'". $sup_micro_attache ."'
																,'". $tribofinition ."'
																,'". Remplace_virgule($_POST['TPS_PARA']) ."'
																,'". $percage ."'
																,'". $taraudage ."'
																,'". $fraisurage ."'
																,'". $insert_p ."'
																,'". Remplace_virgule($_POST['TPS_PLIAGE']) ."'
																,'". round($_POST['NBR_OP']) ."'
																,'". Remplace_virgule($_POST['TPS_MIG']) ."'
																,'". Remplace_virgule($_POST['TPS_TIG']) ."'
																,'". addslashes($_POST['FOURNISSEUR_1']) ."'
																,'". Remplace_virgule($_POST['PRIX_SST1']) ."'
																,'". addslashes($_POST['NUM_OFFRE_1']) ."'
																,'". $_POST['ORDRE_1'] ."'
																,'". addslashes($_POST['FOURNISSEUR_2']) ."'
																,'". Remplace_virgule($_POST['PRIX_SST2']) ."'
																,'". addslashes($_POST['NUM_OFFRE_2']) ."'
																,'". $_POST['ORDRE_2'] ."'
																,'". addslashes($_POST['FOURNISSEUR_3']) ."'
																,'". Remplace_virgule($_POST['PRIX_SST3']) ."'
																,'". addslashes($_POST['NUM_OFFRE_3']) ."'
																,'". $_POST['ORDRE_3'] ."'
																,'". addslashes($_POST['FOURNISSEUR_4']) ."'
																,'". Remplace_virgule($_POST['PRIX_SST4']) ."'
																,'". addslashes($_POST['NUM_OFFRE_4']) ."'
																,'". $_POST['ORDRE_4'] ."'
																,'". $_POST['TRANSPORTEUR'] ."'
																,'". addslashes($_POST['COMMENTAIRES']) ."'
																,'". Remplace_virgule($_POST['POIDS']) ."'
																,'". $fichier_plan ."'
																,''
																,''
																,'')");
																
					//vérification et envoi d'une réponse à l'utilisateur
					if ($req)
					{
						$reponse = $bdd->query('SELECT MAX(id) FROM '. TABLE_ERP_PIECE_RECURENTE .'');
						$data = $reponse->fetch();

						
						$res = $bdd->query('select count(*) as nb from `'. TABLE_ERP_PIECE_RECURENTE .'` WHERE  PLAN = \''. $_POST['PLAN'] .'\'');
						
						$contenu = $contenu . 'Ajout dans la base de données effectué avec succès <br/>
											<br/>
											Voir <a href="plan.php?ref='. $data[0] .'">'. $_POST['PLAN'] .'</a>';

					}
					else
					{
						$contenu = $contenu . 'Echec dans l\'ajout dans la base de données<br/>';
					}
				}
				else
				{
					$contenu = $contenu . 'Echec de l\'upload !<br/>';
				}
			}
		}

		$contenu = $contenu . '</p>';
	}
	else{
		
		$jour_select ='<option value=""></option>';
		for($i=1; $i<=31; $i++)
		{
			$jour_select =  $jour_select .'<option value="'. $i .'">'. $i .'</option>';
		}
			
		$mois_select ='<option value=""></option>';
		for($i=1; $i<=12; $i++)
		{
			$mois_select =  $mois_select .'<option value="'. $i .'">'. $i .'</option>';
		}
	 
		$annee_select_encour = '';
		$annee_select ='<option value=""></option>';
			
		for($i=2014; $i<=2017; $i++)
		{
			///if($i == date('Y'))
			//{
			//	$annee_select_encour = ' selected="selected"';
			//}
			$annee_select =  $annee_select .'<option value="'. $i .'"'. $annee_select_encour .'>'. $i .'</option>';
		}
			
		$Sem_prod ='<option value=""></option>';
		for($i=1; $i<=52; $i++)
		{
			$Sem_prod =  $Sem_prod .'<option value="'. $i .'">'. $i .'</option>';
		}
			
		$Sem_prod_nuit ='';
		for($i=1; $i<=52; $i++)
		{

			$Sem_prod_nuit =  $Sem_prod_nuit .'<option value="'. $i .' nuit">'. $i .' de nuit</option>';
		}
			
			
		$Select_piece_recurente = '<option value=""></option>';
		$reponse = $bdd -> query('SELECT DISTINCT id, CLIENT, PLAN FROM `'. TABLE_ERP_PIECE_RECURENTE .'` ORDER BY CLIENT, PLAN ');
		while ($donneesSelectZone = $reponse->fetch())
		{
				
			if($client_en_cours != $donneesSelectZone['CLIENT']){
					
				$Select_piece_recurente = $Select_piece_recurente .'
										<option value=""></option>';
			}
				
			$Select_piece_recurente = $Select_piece_recurente .'
										<option value="'. $donneesSelectZone['id'] .'">'. $donneesSelectZone['CLIENT'] .' - '. $donneesSelectZone['PLAN'] .'</option>';
				
			$client_en_cours = $donneesSelectZone['CLIENT'];
		}
			
		$Select_client ='<option value=""></option>';
					
		$reponse = $bdd -> query('SELECT DISTINCT CLIENT FROM `'. TABLE_ERP_PLANNING .'` WHERE  `'. TABLE_ERP_PLANNING .'`.sup!=1 ORDER BY CLIENT ');
		while ($donneesSelectZone = $reponse->fetch())
		{
			$Select_client = $Select_client .'<option value="'. $donneesSelectZone['CLIENT'] .'">'. $donneesSelectZone['CLIENT'] .'</option>';
				
		}

		$reponse->closeCursor();
			
		$contenu = $contenu. '
					<form  method="post" action="insertion.php" class="content-form" enctype="multipart/form-data">
						<table class="content-table">
							<thead>
								<tr>
									<th colspan="3"   >
										<p>
											Entrer les informations suivante pour ajouter une commande :
										</p>
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td colspan="3" >
										Fichier au format .csv :<br/>
										<input type="file" name="fichier_csv" /><br/>
										<br/>
									</td>
								</tr>
								<tr>
									<td colspan="3" style="text-align:left;">
										Numéro de commande Metal Industrie  :<br/>
										<input type="text" name="numero_cmd_MI" id="numero_cmd_MI" /><br/>
										<br/>
									</td>
								</tr>
								<tr>
									<td colspan="3" style="text-align:left;">
										Numéro de commande Client  :<br/>
										<input type="text" name="numero_cmd_client" id="numero_cmd_client" /><br/>
										<br/>
									</td>
								</tr>
								<tr>
									<td colspan="3" >
										Date comfirmée  : <input type="text" name="DATE_CONF" id="datepicker"><br/>
										<br/>
									</td>
								</tr>
								<tr>
									<td colspan="3" >
										Semaine production : <br/>
										<br/>
									</td>
								</tr>
								<tr>
									<td style="text-align:left;">
										Laser : <select name="SemLaser">'. $Sem_prod . $Sem_prod_nuit .'</select> 
									</td>
									<td style="text-align:left;">
										EBAVURAGE : <select name="SemEbav">'. $Sem_prod .'</select>  
										</td>
									<td  style="text-align:left;">
										Parachèvement : <select name="SemPara">'. $Sem_prod .'</select> <br/>
									</td>
								</tr>
								<tr>
									<td  style="text-align:left;">
										Pliage : <select name="SemPLiage">'. $Sem_prod .'</select> 
									</td>
									<td  style="text-align:left;">
										Soudure MIG : <select name="SemMIG">'. $Sem_prod .'</select>  
									</td>
									<td  style="text-align:left;">
										Soudure TIG : <select name="SemTIG">'. $Sem_prod .'</select> <br/>
									</td>
								</tr>
								<tr>
									<td colspan="3" >
										<input type="submit" value="Inserer" /> 
									</td>
								</tr>
							<tbody>
						</table>
					</form>
					
					
					
					<form  method="post" action="insertion.php" class="content-form">
						<table class="content-table">
							<thead>
								<tr>
									<th colspan="3"   >
										<p>
											Importer une référence récurente au planing au planning
										</p>
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td colspan="2" >
										<select name="AJOUT_REF_PLANNING">
											'. $Select_piece_recurente .'
										</select>
									</td>
									<td class="QT" style="text-align:left;">
										Quantité : <input type="text" name="QT" id="QT" />
									</td>
								</tr>
								<tr>
									<td colspan="3" >
										Type de ligne : <br/>
										<br/>
									</td>
								</tr>
								<tr>
									<td >
										<input type="checkbox" name="stock" value="stock" id="stock" /> <label for="Laser">Stock : (H)</label>
									</td>
									<td >
										<input type="checkbox" name="appel" value="appel" id="appel" /> <label for="Laser">Livraison sur appel : (C.A.)</label>
									</td>
									<td >
										<input type="checkbox" name="classic" value="classic" id="classic" /> <label for="Laser">Commande : (H + C.A.)</label>
									</td>
								</tr>
								<tr>
									<td colspan="3" class="commande" style="text-align:left;">
										Numéro de commande Metal Industrie  : (pas de numéro si stock)<br/>
										<input type="text" name="numero_cmd_MI" id="numero_cmd_MI" /><br/>
										<br/>
									</td>
								</tr>
								<tr>
									<td colspan="3" class="co-client" style="text-align:left;">
										Numéro de commande Client  :<br/>
										<input type="text" name="numero_cmd_client" id="numero_cmd_client" /><br/>
										<br/>
									</td>
								</tr>
								<tr>
									<td colspan="3" >
										Date Client  : (JJ/MM/AAAA) <input type="text" name="DATE_CLIENT"> (pas de date si stock)<br/>
										<br/>
									</td>
								</tr>
								<tr>
									<td colspan="3" >
										Date comfirmée  : (JJ/MM/AAAA) <input type="text" name="DATE_CONF"> (si stock : 1ere date de commande)<br/>
										<br/>
									</td>
								</tr>
								<tr>
									<td colspan="3" >
										Semaine production : <br/>
										<br/>
									</td>
								</tr>
								<tr>
									<td style="text-align:left;">
										Laser : <select name="SemLaser">'. $Sem_prod . $Sem_prod_nuit .'</select> 
									</td>
									<td style="text-align:left;">
										Ebavurage : <select name="SemEbav">'. $Sem_prod .'</select>  
										</td>
									<td  style="text-align:left;">
										Parachèvement : <select name="SemPara">'. $Sem_prod .'</select> <br/>
									</td>
								</tr>
								<tr>
									<td style="text-align:left;">
										Pliage : <select name="SemPLiage">'. $Sem_prod .'</select> 
									</td>
									<td  style="text-align:left;">
										Soudure MIG : <select name="SemMIG">'. $Sem_prod .'</select>  
									</td>
									<td  style="text-align:left;">
										Soudure TIG : <select name="SemTIG">'. $Sem_prod .'</select> <br/>
									</td>
								</tr>
								<tr>
									<td colspan="3" >
										<input type="submit" value="Inserer" /> 
									</td>
								</tr>
							</tbody>
						</table>
					</form>
					
					
					
					<form  method="post" action="insertion.php" class="content-form"  enctype= "multipart/form-data">
						<table class="content-table">
							<thead>
								<tr>
									<th colspan="3"   >
										<p>
											Ajouter une référence récurente 
										</p>
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td colspan="3" style="text-align:left;">
										Client : <select name="AJOUT_CLIENT_RECURENTE">
											'. $Select_client .'
										</select>
									</td>
								</tr>
								<tr>
									<td  colspan="2"  style="text-align:left;">
										Code Plan : <input type="text" name="PLAN" id="PLAN" />
									</td>
									<td  style="text-align:left;">
										Désignation : <input type="text" name="DESIGNATION" id="DESIGNATION" />
									</td>
								</tr>
								<tr>
									<td colspan="3" style="text-align:left;">
										Prix Unitaire : <input type="text" name="PRIX_U" id="PRIX_U" />
									</td>
									
								</tr>
								<tr>
									<td colspan="2" style="text-align:left;">
										Matière : <select name="MATIERE">
													'. LISTE_MATIERE .'
												</select>
									</td>
									<td style="text-align:left;">
										Epaisseur  : 
										<select name="EPAISSEUR">
													'. LISTE_EPAISSEUR .'
										</select>
									</td>
								</tr>
								<tr>
									<td colspan="3" >
										Temps production par pièce : <br/>
										<br/>
									</td>
								</tr>
								<tr>
									<td  colspan="3"  style="text-align:left;">
										Temps Laser en s/p : <input type="text" name="TPS_LASER" id="TPS_LASER" size="2" />
									</td>
								</tr>
								<tr>
									<td  colspan="3"  style="text-align:left;">
										Temps Ebavurage en s/p : <input type="text" name="TPS_EBAV" id="TPS_EBAV"  size="2"/>
									</td>
									
								</tr>
								<tr>
									<td  colspan="3" style="text-align:left;">
										<input type="checkbox" name="ORBITALE" value"1" id="ORBITALE" /> <label for="ORBITALE">Orbitale</label>
										<input type="checkbox" name="EBAV_CHAMPS" value"1" id="EBAV_CHAMPS" /> <label for="EBAV_CHAMPS">Ebavurage des champs</label>
										<input type="checkbox" name="SUP_MICRO_ATTACHE" value"1" id="SUP_MICRO_ATTACHE" /> <label for="SUP_MICRO_ATTACHE">Suppression de la micro</label>
										<input type="checkbox" name="TRIBOFINITION" value"1" id="TRIBOFINITION" /> <label for="TRIBOFINITION">Tribofinition</label>
									</td>
								</tr>
								<tr>
									<td  colspan="3" style="text-align:left;">
										Temps Parachèvement en s/p : <input type="text" name="TPS_PARA" id="TPS_PARA"  size="2"/>
									</td>
								</tr>
								<tr>
									<td  colspan="3" style="text-align:left;">
										<input type="checkbox" name="PERCAGE" value"1" id="PERCAGE" /> <label for="PERCAGE">Perçage</label>
										<input type="checkbox" name="TARAUDAGE" value"1" id="TARAUDAGE" /> <label for="TARAUDAGE">Taraudage</label>
										<input type="checkbox" name="FRAISURAGE" value"1" id="FRAISURAGE" /> <label for="FRAISURAGE">Fraisurage</label>
										<input type="checkbox" name="INSERT_P" value"1" id="INSERT_P" /> <label for="INSERT_P">Pose d\'insert</label>
									</td>
								</tr>
								<tr>
									<td  style="text-align:left;">
										Temps Pliage en s/p / Nbr d\'opérateur: <br/><input type="text" name="TPS_PLIAGE" id="TPS_PLIAGE" size="2" /><input type="text" name="NBR_OP" id="NBR_OP" size="1" />
									</td>
									<td style="text-align:left;">
										Temps Soudure MIG en s/p : <input type="text" name="TPS_MIG" id="TPS_MIG" size="2"/>
									</td>
									<td style="text-align:left;">
										Temps Soudure TIG en s/p : <input type="text" name="TPS_TIG" id="TPS_TIG" size="2"/>
									</td>
								</tr>
								<tr>
									<td  colspan="3"  style="text-align:left;">
										Sous-traitance 1 --  
										Fournisseur : <input type="text" name="FOURNISSEUR_1" id="FOURNISSEUR_1" size="4" /> --  
										Prix : <input type="text" name="PRIX_SST1" id="PRIX_SST1" size="2" /> -- 
										N°Offre <input type="text" name="NUM_OFFRE_1" id="NUM_OFFRE_1" size="4" />
										Ordre :
										<select name="ORDRE_1">
											<option value="-1">Avant Laser</option>
											<option value="-2">Avant Ebavurage</option>
											<option value="-3">Avant Parachèvement</option>
											<option value="-4">Avant Pliage</option>
											<option value="-5">Avant Soudure</option>
											<option value="1">Fin de process 1</option>
											<option value="2">Fin de process 2</option>
											<option value="3">Fin de process 3</option>
											<option value="4">Fin de process 4</option>
										</select>
									</td>
								</tr>
								<tr>
									<td  colspan="3"  style="text-align:left;">
										Sous-traitance 2 --  Fournisseur : <input type="text" name="FOURNISSEUR_2" id="FOURNISSEUR_2" size="4" /> --  Prix : <input type="text" name="PRIX_SST2" id="PRIX_SST2" size="2" /> -- N°Offre <input type="text" name="NUM_OFFRE_2" id="NUM_OFFRE_2" size="4" />
										Ordre :
										<select name="ORDRE_2">
											<option value="-1">Avant Laser</option>
											<option value="-2">Avant Ebavurage</option>
											<option value="-3">Avant Parachèvement</option>
											<option value="-4">Avant Pliage</option>
											<option value="-5">Avant Soudure</option>
											<option value="1">Fin de process 1</option>
											<option value="2">Fin de process 2</option>
											<option value="3">Fin de process 3</option>
											<option value="4">Fin de process 4</option>
										</select>
									</td>
								</tr>
								<tr>
									<td  colspan="3"  style="text-align:left;">
										Sous-traitance 3 --  Fournisseur : <input type="text" name="FOURNISSEUR_3" id="FOURNISSEUR_3" size="4" /> --  Prix : <input type="text" name="PRIX_SST3" id="PRIX_SST3" size="2" /> -- N°Offre <input type="text" name="NUM_OFFRE_3" id="NUM_OFFRE_3" size="4" />
										Ordre :
										<select name="ORDRE_3">
											<option value="-1">Avant Laser</option>
											<option value="-2">Avant Ebavurage</option>
											<option value="-3">Avant Parachèvement</option>
											<option value="-4">Avant Pliage</option>
											<option value="-5">Avant Soudure</option>
											<option value="1">Fin de process 1</option>
											<option value="2">Fin de process 2</option>
											<option value="3">Fin de process 3</option>
											<option value="4">Fin de process 4</option>
										</select>
									</td>
								</tr>
								<tr>
									<td  colspan="3"  style="text-align:left;">
										Sous-traitance 4 --  Fournisseur : <input type="text" name="FOURNISSEUR_4" id="FOURNISSEUR_4" size="4" /> --  Prix : <input type="text" name="PRIX_SST4" id="PRIX_SST4" size="2" /> -- N°Offre <input type="text" name="NUM_OFFRE_4" id="NUM_OFFRE_4" size="4" />
										Ordre :
										<select name="ORDRE_4">
											<option value="-1">Avant Laser</option>
											<option value="-2">Avant Ebavurage</option>
											<option value="-3">Avant Parachèvement</option>
											<option value="-4">Avant Pliage</option>
											<option value="-5">Avant Soudure</option>
											<option value="1">Fin de process 1</option>
											<option value="2">Fin de process 2</option>
											<option value="3">Fin de process 3</option>
											<option value="4">Fin de process 4</option>
										</select>
									</td>
								</tr>
								<tr>
									<td >
										Transporteur : 
										<select name="TRANSPORTEUR">
											'. TRANSPORT_LISTE .'
										</select>
									</td>
									<td >
										Commentaire : <input type="text" name="COMMENTAIRES" id="COMMENTAIRES" />
									</td>
									<td >
										Poids en kg : <input type="text" name="POIDS" id="POIDS" />
									</td>
								</tr>
								<tr>
									<td colspan="3" >
										Fichier au format .pdf :<br/>
										<input type="file" name="fichier_plan_pdf" /><br/>
									</td>
								</tr>
								<tr>
									<td colspan="3" >
										<input type="submit" value="Inserer" /> 
									</td>
								</tr>
							<tbody>
						</table>
					</form>';
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