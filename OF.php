<?php
	//phpinfo();

	//include pour la connection à la base SQL 
	require_once 'include/include_connection_sql.php';
	//include pour les fonctions
	require_once 'include/include_fonctions.php';
	//include pour les constantes
	require_once 'include/include_recup_config.php';
	
	$content = '';  
	
	$selected_checkbox = implode(",",$_POST['id_ligne']);

	$res = $bdd->query('select count(*) as nb  FROM `'. TABLE_ERP_PLANNING .'` WHERE id IN ('. $selected_checkbox . ')  AND sup!=1');
	$data = $res->fetch();
	$nb = $data['nb'];
		
	if($nb == 0){
			$content = '
						<p class="message">
							
								Aucune commande à afficher
							
						
							<input type="button" value="Retour" onClick="window.history.back()">
						</p>';
	}
	else{

		$tr = 0;
		
		$LASER = 0;
		$EBAV = 0;
		$PARA = 0;
		$PLIAGE = 0;
		$SOUDURE = 0;
		
		$POIDS =0;
		$ref ='';
		
		$i = 0;
		
		$req = $bdd->prepare('SELECT * FROM `'. TABLE_ERP_PLANNING .'`
										LEFT JOIN `'. TABLE_SOUS_TRAITANCE .'` ON `'. TABLE_ERP_PLANNING .'`.`id` = `'. TABLE_SOUS_TRAITANCE .'`.`id_cmd`
										WHERE `'. TABLE_ERP_PLANNING .'`.`id` IN ('. $selected_checkbox . ')  AND sup!=1');
		$req->execute(array($selected_checkbox));
		while($donnees = $req->fetch())
		{
			$Client = $donnees['CLIENT'];
			$COMMANDE = $donnees['COMMANDE'];
			$date_MI = join('/',array_reverse(explode('-',$donnees['DATE_CONFIRM'])));
			
			$LASER = $LASER + $donnees['TRUMPH_1'];
			$EBAV = $EBAV + $donnees['EBAVURAGE'];
			$PARA = $PARA + $donnees['PARACHEVEMENT'];
			$PLIAGE = $PLIAGE + $donnees['PLIAGE'];
			$SOUDURE = $SOUDURE + $donnees['SOUDURE_MIG']+ $donnees['SOUDURE_TIG'];
			
			
			if(!empty($donnees['SEM_PROD_LASER'])) $SEM_LASER = $donnees['SEM_PROD_LASER'];
			if(!empty($donnees['SEM_PROD_EBAV'])) $SEM_EBAV = $donnees['SEM_PROD_EBAV'];
			if(!empty($donnees['SEM_PROD_PARA'])) $SEM_PARA = $donnees['SEM_PROD_PARA'];
			if(!empty($donnees['SEM_PROD_PLI'])) $SEM_PLIAGE = $donnees['SEM_PROD_PLI'];
			if(!empty($donnees['SEM_PROD_MIG'])) $SEM_SOUDURE = $donnees['SEM_PROD_MIG'];
			if(!empty($donnees['SEM_PROD_TIG'])) $SEM_SOUDURE = $donnees['SEM_PROD_TIG'];
			
			if(!empty($donnees['ORBITALE'])) $ORBITALE = $donnees['ORBITALE'];
			if(!empty($donnees['EBAV_CHAMPS'])) $EBAV_CHAMPS = $donnees['EBAV_CHAMPS'];
			if(!empty($donnees['SUP_MICRO_ATTACHE'])) $SUP_MICRO_ATTACHE = $donnees['SUP_MICRO_ATTACHE'];
			if(!empty($donnees['TRIBOFINITION'])) $TRIBOFINITION = $donnees['TRIBOFINITION'];
			if(!empty($donnees['PERCAGE'])) $PERCAGE = $donnees['PERCAGE'];
			if(!empty($donnees['TARAUDAGE'])) $TARAUDAGE = $donnees['TARAUDAGE'];
			if(!empty($donnees['FRAISURAGE'])) $FRAISURAGE = $donnees['FRAISURAGE'];
			if(!empty($donnees['INSERT_P'])) $INSERT_P = $donnees['INSERT_P'];
			
			
			if(stristr($Sous_traitance, $donnees['FOURNISSEUR']) === false) {
				$Sous_traitance = $donnees['FOURNISSEUR'] .' N° ...............  - ' . $Sous_traitance; 
			}
			
			
			$TRANSPORTEUR = $donnees['TRANSPORTEUR'];
			$POIDS = $POIDS + $donnees['POIDS'];
			
			$i++;
			
			if($i==1){
				$ref = ' - Ref '.$donnees['PLAN'] .' - QT : '. $donnees['QT'] ;
			
			}
			else{
				$ref = '';
			}
		}
		
		if($LASER >0) $couleur_LASER = "background-color: #E6E6FA;"; else $couleur_LASER = "";
		if($EBAV >0) $couleur_EBAV = "background-color: #E6E6FA;"; else $couleur_EBAV = "";
		if($PARA >0) $couleur_PARA = "background-color: #E6E6FA;"; else $couleur_PARA = "";
		if($PLIAGE >0) $couleur_PLIAGE = "background-color: #E6E6FA;"; else $couleur_PLIAGE = "";
		if($SOUDURE >0) $couleur_SOUDURE = "background-color: #E6E6FA;"; else $couleur_SOUDURE = "";
		

		
		$content = $content.'
	<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
			<title>Etiquette</title>
		</head>
		<body>
			<div style="width: 98%; margin:auto; margin-bottom:15px;margin-top:-20px;">
				<p style="text-align:center;">
					GAMME DE FABRICATION
				</p>
			</div>
			<table style="width: 98%; border: 1px solid black; margin: auto; text-align:center;">
				<tr>
					<td rowspan="3"><img src="image/OF/logo.png" title="case" /></td>
					<td  style="width: 28%; text-align:left; ">Nom Client :</td><td style="width: 54%; text-align:left;">'. $Client .'</td>
					<td rowspan="3"><img src="image/OF/tronbone.png" title="case" /></td>
				</tr>
				<tr>
					<td  style="width: 28%; text-align:left;">N°Commande :</td><td  style="width: 54%;  text-align:left;">'. $COMMANDE .''. $ref .'</td>
				</tr>
				<tr>
					<td style="width: 28%; text-align:left;">Date de confirmation :</td><td style="width: 54%;  text-align:left;">'. $date_MI .'</td>
				</tr>
			</table>
			<table style="width: 98%; border: 1px solid black; margin: auto; text-align:center; margin-top:5px;">
				<tr>
					<td colspan="14" style="width: 7%;">Matière à utiliser</td>
				</tr>
				<tr>
					<td style="width: 7%;">Nuance</td><td style="width: 7%;"></td><td style="width: 7%;">Format</td><td style="width: 7%;"></td><td style="width: 7%;">Ep.</td>
					<td style="width: 7%;"></td><td style="width: 7%;">Qt</td><td style="width: 7%;"></td><td style="width: 7%;">Sur Stock</td><td style="width: 7%;">Sur Cde</td>
					<td style="width: 7%;"></td><td style="width: 7%;">Fourniseur</td><td style="width: 7%;"></td><td style="width: 7%;">Réception</td>
				</tr>
				<tr>
					<td style="width: 7%;"><br/></td><td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"></td>
					<td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"><img src="image/OF/case.png" title="case" /></td><td style="width: 7%;"><img src="image/OF/case.png" title="case" /></td>
					<td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"></td>
				</tr>
				<tr>
					<td style="width: 7%;"><br/></td><td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"></td>
					<td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"><img src="image/OF/case.png" title="case" /></td><td style="width: 7%;"><img src="image/OF/case.png" title="case" /></td>
					<td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"></td>
				</tr>
				<tr>
					<td style="width: 7%;"><br/></td><td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"></td>
					<td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"><img src="image/OF/case.png" title="case" /></td><td style="width: 7%;"><img src="image/OF/case.png" title="case" /></td>
					<td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"></td>
				</tr>
				<tr>
					<td style="width: 7%;"><br/></td><td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"></td>
					<td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"><img src="image/OF/case.png" title="case" /></td><td style="width: 7%;"><img src="image/OF/case.png" title="case" /></td>
					<td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"></td>
				</tr>
				<tr>
					<td style="width: 7%;"><br/></td><td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"></td>
					<td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"><img src="image/OF/case.png" title="case" /></td><td style="width: 7%;"><img src="image/OF/case.png" title="case" /></td>
					<td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"></td>
				</tr>
				<tr>
					<td style="width: 7%;"><br/></td><td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"></td>
					<td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"><img src="image/OF/case.png" title="case" /></td><td style="width: 7%;"><img src="image/OF/case.png" title="case" /></td>
					<td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"></td>
				</tr>
				<tr>
					<td style="width: 7%;"><br/></td><td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"></td>
					<td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"><img src="image/OF/case.png" title="case" /></td><td style="width: 7%;"><img src="image/OF/case.png" title="case" /></td>
					<td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"></td>
				</tr>
				<tr>
					<td style="width: 7%;"><br/></td><td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"></td>
					<td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"><img src="image/OF/case.png" title="case" /></td><td style="width: 7%;"><img src="image/OF/case.png" title="case" /></td>
					<td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"></td><td style="width: 7%;"></td>
				</tr>
			</table>
				
			<table style="width: 98%; border: 1px solid black; margin: auto; text-align:center; margin-top:5px; font-size: 11px;">
				<tr>
					<td style="width: 7%; text-align:left; padding-top:15px; padding-bottom:10px;">LASER</td>
					<td style="width: 7%; text-align:right;">Technologie </td>
					<td style="width: 7%;">O2 <img src="image/OF/case.png" title="case" /></td>
					<td style="width: 7%;">N2 <img src="image/OF/case.png" title="case" /></td>
					<td style="width: 7%;">HV <img src="image/OF/case.png" title="case" /></td>
					<td style="width: 7%;">Auto <img src="image/OF/case.png" title="case" /></td>
					<td style="width: 7%;">A dessiner :</td>
					<td style="width: 7%;"></td>
					<td style="width: 7%; text-align:right;">Autre info :</td>
					<td style="width: 7%;text-align:left;"></td>
					<td style="width: 7%;"></td>
					<td style="width: 7%; text-align:right;">Sem :</td>
					<td style="width: 7%;text-align:left;">'. $SEM_LASER .'</td>
					<td style="width: 7%;  '. $couleur_LASER .'">'. $LASER .'</td>
				</tr>
				<tr>
					<td colspan="14"><hr style="height: 1px;"></td>
				</tr>
				<tr>
					<td style="width: 7%; text-align:left; padding-top:10px; padding-bottom:10px;">EBAVURAGE</td>
					<td style="width: 7%; text-align:right;"> </td>
					<td style="width: 7%; text-align:right;">Orbitale</td>
					<td style="width: 7%;"> '. case_OF($ORBITALE) .'</td>
					<td style="width: 7%; text-align:right;">Micro-attache</td>
					<td style="width: 7%;"> '. case_OF($SUP_MICRO_ATTACHE) .'</td>
					<td style="width: 7%; text-align:right;">Tribofinition</td>
					<td style="width: 7%;"> '. case_OF($TRIBOFINITION) .'</td>
					<td style="width: 7%; text-align:right;">Champs</td>
					<td style="width: 7%;"> '. case_OF($EBAV_CHAMPS) .'</td>
					<td style="width: 7%;"></td>
					<td style="width: 7%; text-align:right;">Sem :</td>
					<td style="width: 7%;text-align:left;">'. $SEM_EBAV .'</td>
					<td style="width: 7%; '. $couleur_EBAV .'">'. $EBAV .'</td>
				</tr>
				<tr>
					<td colspan="14"><hr style="height: 1px;"></td>
				</tr>
				<tr>
					<td style="width: 7%; text-align:left;  padding-top:10px; ">PARACHEVEMENT</td>
					<td style="width: 7%; text-align:right;"> </td>
					<td style="width: 7%; text-align:right;">Taraudage</td>
					<td style="width: 7%;"> '. case_OF($TARAUDAGE) .'</td>
					<td style="width: 7%; text-align:right;">Perçage</td>
					<td style="width: 7%;"> '. case_OF($PERCAGE) .'</td>
					<td style="width: 7%; text-align:right;">Pose Insert</td>
					<td style="width: 7%;"> '. case_OF($INSERT_P) .'</td>
					<td style="width: 7%;"></td>
					<td style="width: 7%;"></td>
					<td style="width: 7%;"></td>
					<td style="width: 7%; text-align:right;">Sem :</td>
					<td style="width: 7%;text-align:left;">'. $SEM_PARA .'</td>
					<td rowspan="2" style="width: 7%;'. $couleur_PARA .'">'. $PARA .'</td>
				</tr>
				
				<tr>
					<td style="width: 7%;  padding-bottom:10px;"><br/></td>
					<td style="width: 7%; text-align:right;"> </td>
					<td style="width: 7%; text-align:right;">Fraisage</td>
					<td style="width: 7%;"> '. case_OF($FRAISURAGE) .'</td>
					<td style="width: 7%; text-align:right;">Ponçage</td>
					<td style="width: 7%;"> <img src="image/OF/case.png" title="case" /></td>
					<td style="width: 7%; text-align:right;">Brossage</td>
					<td style="width: 7%;"> <img src="image/OF/case.png" title="case" /></td>
					<td style="width: 7%;"></td>
					<td style="width: 7%;"></td>
					<td style="width: 7%;"></td>
					<td style="width: 7%;"></td>
					<td style="width: 7%;"></td>
				</tr>
				<tr>
					<td colspan="14"><hr style="height: 1px;"></td>
				</tr>
				<tr>
					<td style="width: 7%; text-align:left;  padding-top:10px; padding-bottom:10px;">PLIAGE</td>
					<td style="width: 7%;"></td>
					<td style="width: 7%;"></td>
					<td style="width: 7%;"></td>
					<td style="width: 7%;"></td>
					<td style="width: 7%;"></td>
					<td style="width: 7%;"></td>
					<td style="width: 7%;"></td>
					<td style="width: 7%;"></td>
					<td style="width: 7%;"></td>
					<td style="width: 7%;"></td>
					<td style="width: 7%; text-align:right;">Sem :</td>
					<td style="width: 7%;text-align:left;">'. $SEM_PLIAGE .'</td>
					<td style="width: 7%; '. $couleur_PLIAGE .'">'. $PLIAGE .'</td>
				</tr>
				<tr>
					<td colspan="14"><hr style="height: 1px;"></td>
				</tr>
				<tr>
					<td colspan="2" style="width: 7%; text-align:left;  padding-top:10px; padding-bottom:15px;">ASSEMBLAGE / SOUDURE</td>
					
					<td style="width: 7%;"></td>
					<td style="width: 7%;"></td>
					<td style="width: 7%;"></td>
					<td style="width: 7%;"></td>
					<td style="width: 7%;"></td>
					<td style="width: 7%;"></td>
					<td style="width: 7%;"></td>
					<td style="width: 7%;"></td>
					<td style="width: 7%;"></td>
					<td style="width: 7%; text-align:right;">Sem :</td>
					<td style="width: 7%;text-align:left;">'. $SEM_SOUDURE .'</td>
					<td style="width: 7%; '. $couleur_SOUDURE .'">'. $SOUDURE .'</td>
				</tr>
			</table>
			<table style="width: 98%; border: 1px solid black; margin: auto; text-align:center; margin-top:5px; font-size: 11px; padding-top:5px; padding-bottom:5px;">
				<tr>
					<td style="width: 98%;  text-align:left;">Sous-traitance '. $Sous_traitance .'</td>
					<!--<td style="width: 7%; text-align:right;">Peinture </td>
					<td style="width: 7%; text-align:left;"><img src="image/OF/case.png" title="case" /></td>
					<td style="width: 8%; text-align:right;">Galvanisation </td>
					<td style="width: 7%; text-align:left;"><img src="image/OF/case.png" title="case" /></td>
					<td style="width: 7%; text-align:right;">Electro-poli </td>
					<td style="width: 7%; text-align:left;"><img src="image/OF/case.png" title="case" /></td>
					<td style="width: 9%; text-align:right;">Soudure </td>
					<td style="width: 7%; text-align:left;"><img src="image/OF/case.png" title="case" /></td>
					<td style="width: 7%; text-align:right;">Usinage </td>
					<<td style="width: 7%; text-align:left;"><img src="image/OF/case.png" title="case" /></td>
					<td style="width: 8%; text-align:right;">Laser Tube </td>
					<td style="width: 7%; text-align:left;"><img src="image/OF/case.png" title="case" /></td>
					<td style="width: 3%;"></td>-->
				</tr>
				<!--<tr>
					<td style="width: 7%;"></td>
					<td style="width: 7%; text-align:right;">Zingage </td>
					<td style="width: 7%; text-align:left;"><img src="image/OF/case.png" title="case" /></td>
					<td style="width: 8%; text-align:right;">Anodisation </td>
					<td style="width: 7%; text-align:left;"><img src="image/OF/case.png" title="case" /></td>
					<td style="width: 7%; text-align:right;">Pliage </td>
					<td style="width: 7%; text-align:left;"><img src="image/OF/case.png" title="case" /></td>
					<td style="width: 9%; text-align:right;">Parachèvement </td>
					<td style="width: 7%; text-align:left;"><img src="image/OF/case.png" title="case" /></td>
					<td style="width: 7%; text-align:right;">Brossage </td>
					<<td style="width: 7%; text-align:left;"><img src="image/OF/case.png" title="case" /></td>
					<td style="width: 8%; text-align:right;">Poinçonnage </td>
					<td style="width: 7%; text-align:left;"><img src="image/OF/case.png" title="case" /></td>
					<td style="width: 3%;"></td>
				</tr>-->
			</table>
			<table style="width:98%; margin: auto; margin-left:18px;">
				<tr>
					<td>
						<table style=" border: 1px solid black; text-align:center; margin-top:5px; font-size: 11px; padding-top:5px; padding-bottom:5px;">
							<tr>
								<td style="width: 14%; text-align:left;>Contrôle : </td>
								<td style="width: 7%; text-align:right;">EI : </td>
								<td style="width: 7%; text-align:left;"><img src="image/OF/case.png" title="case" /></td>
								<td style="width: 7%; text-align:right;">Echantillonnage :</td>
								<td style="width: 7%; text-align:left;"><img src="image/OF/case.png" title="case" /></td>
								<td style="width: 7%;">100%</td>
								<td style="width: 7%; text-align:left;"><img src="image/OF/case.png" title="case" /></td>
							</tr>
						</table>
					</td>
					<td>
						<table style="width: 90%; border: 1px solid black; text-align:center; margin-top:5px; font-size: 11px; padding-top:5px; padding-bottom:5px;">
							<tr>
								<td style="width: 15%; text-align:left;">Conditionnement : </td>
								<td style="width: 10%; text-align:right;">Etiquetage </td>
								<td style="width: 4%; text-align:left;"><img src="image/OF/case.png" title="case" /></td>
								<td style="width: 10%; text-align:right;">Marquage</td>
								<td style="width: 4%; text-align:left;"><img src="image/OF/case.png" title="case" /></td>
								<td style="width: 10%; text-align:right;">Palette Europe</td>
								<td style="width: 4%; text-align:left;"><img src="image/OF/case.png" title="case" /></td>
								<td style="width: 10%; text-align:right;">1 Ref / Palette</td>
								<td style="width: 4%; text-align:left;"><img src="image/OF/case.png" title="case" /></td>
								<td style="width: 17%; text-align:right;">Zone de stockage :</td>
								<td style="width: 7.5%; text-align:left;"></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<table style="width: 98%; border: 1px solid black; margin: auto; text-align:center; margin-top:5px; font-size: 11px;">
				<tr>
					<td style="width: 7%; text-align:left; padding-top:15px; padding-bottom:15px;">Transport : </td>
					<td style="width: 7%;">'. $TRANSPORTEUR .'</td>
					<td style="width: 7%;"></td>
					<td style="width: 7%;text-align:right;"> Poids :</td>
					<td style="width: 7%;">'. $POIDS .' kg</td>
					<td style="width: 7%;"></td>
					<td style="width: 7%;"></td>
					<td style="width: 7%;"></td>
					<td style="width: 7%;"></td>
					<td style="width: 7%;"></td>
					<td style="width: 7%;"></td>
					<td style="width: 7%; text-align:right;">Sem :</td>
					<td style="width: 7%;text-align:left;">'. date('W', $donnees['DATE_CONFIRM']) .'</td>
					<td style="width: 7%;"></td>
				</tr>
			</table>
		</body>
	</html>
';
	}
		

	require_once('\librairie\html2pdf_v4.03\html2pdf.class.php');
	try
	{
		$html2pdf = new HTML2PDF('L', 'A4', 'fr','UTF-8');
		$html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output('OF.pdf');
		exit;
	}
	catch(HTML2PDF_exception $e) {
		echo $e;
		exit;
	}

?>