<?php
	//phpinfo();

	//include pour la connection à la base SQL 
	require_once 'include/include_connection_sql.php';
	//include pour les fonctions
	require_once 'include/include_fonctions.php';
	//include pour les constantes
	require_once 'include/include_recup_config.php';
	
	$content = '';  
	$Contenu_tableau = ''; 
	$SemProd = $_GET['sem'];
	
	if(isset($_GET['sem'])){

		$req = $bdd->query('SELECT * FROM `'. TABLE_ERP_PLANNING .'` 
										WHERE  `'. TABLE_ERP_PLANNING .'`.sup!=1 AND `'. TABLE_ERP_PLANNING .'`.sup!=2
										AND (`'. TABLE_ERP_PLANNING .'`.SEM_PROD_LASER=\''. $SemProd.'\' 
										OR `'. TABLE_ERP_PLANNING .'`.SEM_PROD_EBAV=\''. $SemProd.'\' 
										OR `'. TABLE_ERP_PLANNING .'`.SEM_PROD_PARA=\''. $SemProd.'\' 
										OR `'. TABLE_ERP_PLANNING .'`.SEM_PROD_PLI=\''. $SemProd.'\' 
										OR `'. TABLE_ERP_PLANNING .'`.SEM_PROD_MIG=\''. $SemProd.'\' 
										OR `'. TABLE_ERP_PLANNING .'`.SEM_PROD_TIG=\''. $SemProd.'\' )
										ORDER BY `'. TABLE_ERP_PLANNING .'`.`DATE_CONFIRM` ASC,  `'. TABLE_ERP_PLANNING .'`.`id` ASC ');
	}
	elseif($_GET['operation'] == "expedition"){
		
		// INIT DES VARIABLE DE DATE
		$DateDuJour = date('Y-m-d');
		$DateDemain = date('Y-m-d', strtotime('+1 days'));
		$DatesurDemain = date('Y-m-d', strtotime('+2 days'));
		$DateUneSemaine = date('Y-m-d', strtotime('+7 days'));
		
		if(date('w')== 5){
			
			$DateDemain = date('Y-m-d', strtotime('+3 days'));
			$DatesurDemain = date('Y-m-d', strtotime('+4 days'));
		}
		elseif(date('w')== 4){
			$DateDemain = date('Y-m-d', strtotime('+1 days'));
			$DatesurDemain = date('Y-m-d', strtotime('+4 days'));
		}
	
		$req = $bdd->query("SELECT DISTINCT COMMANDE, CO_CLIENT, CLIENT, DATE_FORMAT(DATE_CONFIRM, '%d/%m/%Y') AS DATE_CONFIRM, TRANSPORTEUR FROM ". TABLE_ERP_PLANNING ."  WHERE sup!=1 AND sup!=2 AND sup!=3 AND DATE_CONFIRM =\"". $DateDemain ."\" AND QT_EXPEDIER < QT ORDER BY id, DATE_FORMAT(DATE_CONFIRM, '%d/%m/%Y') ASC");
			
	}
	elseif($_GET['operation'] == "retard"){
		
		$req = $bdd->query("SELECT DISTINCT COMMANDE, CO_CLIENT, CLIENT, DATE_FORMAT(DATE_CONFIRM, '%d/%m/%Y') AS DATE_CONFIRM, DATEDIFF(NOW(), DATE_CONFIRM) AS differenceEntreLesDates FROM ". TABLE_ERP_PLANNING ."  WHERE sup!=1 AND sup!=2 AND DATE_CONFIRM != '0000-00-00' AND DATE_CONFIRM < CURDATE()+1 AND QT_EXPEDIER < QT ORDER BY  id, DATE_FORMAT(DATE_CONFIRM, '%d/%m/%Y') ASC");
		
	}

	
	$i = 0;
	
	if($_GET['operation'] == "laser"){
		
		$En_tete ='
			<td style="width: 8%; border: 1px solid black; border-collapse: collapse; text-align:center;">'. EN_TETE_TABLEAU_COL_15 .'</td>
			<td style="width: 5%; border: 1px solid black; border-collapse: collapse; text-align:center;">'. EN_TETE_TABLEAU_COL_16 .'</td>
					';
	}
	elseif($_GET['operation'] == "ebav"){
		
		$En_tete ='
			<td style="width: 8%; border: 1px solid black; border-collapse: collapse; text-align:center;">'. EN_TETE_TABLEAU_COL_19 .'</td>
			<td style="width: 5%; border: 1px solid black; border-collapse: collapse; text-align:center;">'. EN_TETE_TABLEAU_COL_24 .'</td>
					';
	}
	elseif($_GET['operation'] == "para"){
		
		$En_tete ='
			<td style="width: 8%; border: 1px solid black; border-collapse: collapse; text-align:center;">'. EN_TETE_TABLEAU_COL_27 .'</td>
			<td style="width: 5%; border: 1px solid black; border-collapse: collapse; text-align:center;">'. EN_TETE_TABLEAU_COL_32 .'</td>
					';
	}
	elseif($_GET['operation'] == "pliage"){
		
		$En_tete ='
			<td style="width: 6%; border: 1px solid black; border-collapse: collapse; text-align:center;">'. EN_TETE_TABLEAU_COL_35 .'</td>
			<td style="width: 2%; border: 1px solid black; border-collapse: collapse; text-align:center;">'. EN_TETE_TABLEAU_COL_36 .'</td>
			<td style="width: 4%; border: 1px solid black; border-collapse: collapse; text-align:center;">'. EN_TETE_TABLEAU_COL_37 .'</td>
					';
	}
	elseif($_GET['operation'] == "MIG" OR $_GET['operation'] == "MIG"){
		
		$En_tete ='
			<td style="width: 8%; border: 1px solid black; border-collapse: collapse; text-align:center;">'. EN_TETE_TABLEAU_COL_40 .'</td>
			<td style="width: 5%; border: 1px solid black; border-collapse: collapse; text-align:center;">'. EN_TETE_TABLEAU_COL_41 .'</td>
					';
	}
	elseif($_GET['operation'] == "MIG" OR $_GET['operation'] == "TIG"){
		
		$En_tete ='
			<td style="width: 8%; border: 1px solid black; border-collapse: collapse; text-align:center;">'. EN_TETE_TABLEAU_COL_44 .'</td>
			<td style="width: 5%; border: 1px solid black; border-collapse: collapse; text-align:center;">'. EN_TETE_TABLEAU_COL_45 .'</td>
					';
	}
	elseif($_GET['operation'] == "retard"){
		
		$En_tete ='
			<td style="width: 8%; border: 1px solid black; border-collapse: collapse; text-align:center;">Retard (jours)</td>
					';
	}
	elseif($_GET['operation'] == "expedition"){
		
		$En_tete ='
			<td style="width: 10%; border: 1px solid black; border-collapse: collapse; text-align:center;">'. EN_TETE_TABLEAU_COL_65 .'</td>
					';
	}
	
	while ($donnees = $req->fetch())
	{
		$date_MI = join('/',array_reverse(explode('-',$donnees['DATE_CONFIRM'])));
		
		 
		if ($i % 2 == 0)
		{
			$couleur_fond ='background-color: #FFEBCD; ';
		}
		else
		{
			$couleur_fond ='';
		}
	
		$ligne = 
			'<tr>
				<td style="width: 8%; border: 1px solid black; border-collapse: collapse; '. $couleur_fond .'">'. $donnees['COMMANDE'] .'</td>
				<td style="width: 20%; border: 1px solid black; border-collapse: collapse; '. $couleur_fond .'">'. nettoyerChaine($donnees['CLIENT']) .'</td>
				<td style="width: 20%; border: 1px solid black; border-collapse: collapse; '. $couleur_fond .'">'. nettoyerChaine($donnees['PLAN']) .'</td>
				<td style="width: 10%; border: 1px solid black; border-collapse: collapse; '. $couleur_fond .'">'. extrait($donnees['DESIGNATION']) .'</td>
				<td style="width: 5%; border: 1px solid black; border-collapse: collapse; '. $couleur_fond .'">'. $donnees['QT'] .'</td>			
				<td style="width: 10%; border: 1px solid black; border-collapse: collapse; '. $couleur_fond .'">'. $donnees['MATIERE'] .'</td>
				<td style="width: 3%; border: 1px solid black; border-collapse: collapse; text-align:center; '. $couleur_fond .'">'. $donnees['EPAISSEUR'] .'</td>
				<td style="width: 10%; border: 1px solid black; border-collapse: collapse; text-align:center; '. $couleur_fond .'">'. $date_MI .'</td>';
			
			
		if($_GET['operation'] == "laser" AND $SemProd == $donnees['SEM_PROD_LASER'] AND !empty($donnees['TRUMPH_1']) AND ($donnees['QT_PRODUIT_L'] < $donnees['QT_EXPEDIER'] OR empty($donnees['QT_PRODUIT_L']))){
			
			$Contenu_tableau =  $Contenu_tableau . $ligne .'
				<td style="width: 8%; border: 1px solid black; border-collapse: collapse;  text-align:center; '. $couleur_fond .'">'. $donnees['TRUMPH_1'] .'</td>
				<td style="width: 5%; border: 1px solid black; border-collapse: collapse; text-align:center; '. $couleur_fond .'">'. $donnees['SEM_PROD_LASER'] .'</td>
			</tr>';
			
			$i++;
			
		}
		elseif($_GET['operation'] == "ebav" AND $SemProd == $donnees['SEM_PROD_EBAV'] AND !empty($donnees['EBAVURAGE']) AND($donnees['QT_PRODUIT_EBAV'] < $donnees['QT_EXPEDIER']OR empty($donnees['QT_PRODUIT_EBAV']))){
		
			$Contenu_tableau =  $Contenu_tableau . $ligne .'
				<td style="width: 8%; border: 1px solid black; border-collapse: collapse;  text-align:center; '. $couleur_fond .'">'. $donnees['EBAVURAGE'] .'</td>
				<td style="width: 5%; border: 1px solid black; border-collapse: collapse; text-align:center; '. $couleur_fond .'">'. $donnees['SEM_PROD_EBAV'] .'</td>
			</tr>';
			
			$i++;
		}
		elseif($_GET['operation'] == "para" AND $SemProd == $donnees['SEM_PROD_PARA'] AND !empty($donnees['PARACHEVEMENT']) AND($donnees['QT_PRODUIT_PARA'] < $donnees['QT_EXPEDIER']OR empty($donnees['QT_PRODUIT_PARA']))){
			
			$Contenu_tableau =  $Contenu_tableau . $ligne .'
				<td style="width: 8%; border: 1px solid black; border-collapse: collapse;  text-align:center; '. $couleur_fond .'">'. $donnees['PARACHEVEMENT'] .'</td>
				<td style="width: 5%; border: 1px solid black; border-collapse: collapse; text-align:center; '. $couleur_fond .'">'. $donnees['SEM_PROD_PARA'] .'</td>
			</tr>';
			
			$i++;
		}
		elseif($_GET['operation'] == "pliage" AND $SemProd == $donnees['SEM_PROD_PLI'] AND !empty($donnees['PLIAGE']) AND($donnees['QT_PRODUIT_PLI'] < $donnees['QT_EXPEDIER']OR empty($donnees['QT_PRODUIT_PLI']))){
			
			$Contenu_tableau =  $Contenu_tableau . $ligne .'
				<td style="width: 6%; border: 1px solid black; border-collapse: collapse;  text-align:center; '. $couleur_fond .'">'. $donnees['PLIAGE'] .'</td>
				<td style="width: 2%; border: 1px solid black; border-collapse: collapse;  text-align:center; '. $couleur_fond .'">'. $donnees['NBR_OP'] .'</td>
				<td style="width: 4%; border: 1px solid black; border-collapse: collapse; text-align:center; '. $couleur_fond .'">'. $donnees['SEM_PROD_PLI'] .'</td>
			</tr>';
			
			$i++;
		}
		elseif($_GET['operation'] == "MIG" AND $SemProd == $donnees['SEM_PROD_MIG'] AND !empty($donnees['SOUDURE_MIG']) AND($donnees['QT_PRODUIT_MIG'] < $donnees['QT_EXPEDIER']OR empty($donnees['QT_PRODUIT_MIG']))){
			
			$Contenu_tableau =  $Contenu_tableau . $ligne .'
				<td style="width: 8%; border: 1px solid black; border-collapse: collapse;  text-align:center; '. $couleur_fond .'">'. $donnees['SOUDURE_MIG'] .'</td>
				<td style="width: 5%; border: 1px solid black; border-collapse: collapse; text-align:center; '. $couleur_fond .'">'. $donnees['SEM_PROD_MIG'] .'</td>
			</tr>';
			
			$i++;
			
		}
		elseif($_GET['operation'] == "TIG" AND $SemProd == $donnees['SEM_PROD_TIG'] AND !empty($donnees['SOUDURE_TIG']) AND($donnees['QT_PRODUIT_TIG'] < $donnees['QT_EXPEDIER']OR empty($donnees['QT_PRODUIT_TIG']))){
			
			$Contenu_tableau =  $Contenu_tableau . $ligne .'
				<td style="width: 8%; border: 1px solid black; border-collapse: collapse;  text-align:center; '. $couleur_fond .'">'. $donnees['SOUDURE_TIG'] .'</td>
				<td style="width: 5%; border: 1px solid black; border-collapse: collapse; text-align:center; '. $couleur_fond .'">'. $donnees['SEM_PROD_TIG'] .'</td>
			</tr>';
			
			$i++;
			
		}
		elseif($_GET['operation'] == "expedition"){
			
			$Contenu_tableau =  $Contenu_tableau . $ligne .'
				<td style="width: 10%; border: 1px solid black; border-collapse: collapse;  text-align:center; '. $couleur_fond .'">'. $donnees['TRANSPORTEUR'] .'</td>
			</tr>';
			
			$i++;
			
		}
		elseif($_GET['operation'] == "retard"){
		
			$Retard = $donnees['differenceEntreLesDates']-date('Y-m-d');
			$Contenu_tableau =  $Contenu_tableau . $ligne .'
				<td style="width: 5%; border: 1px solid black; border-collapse: collapse; text-align:center; '. $couleur_fond .'">'. $donnees['differenceEntreLesDates']  .'</td>
			</tr>';
			
			$i++;
		}
	}
									
		$content = '
			<table style="width: 100%; border: 1px solid black; border-collapse: collapse;">
				<tr> 
					<td style="width: 8%; border: 1px solid black; border-collapse: collapse; text-align:center;">'. EN_TETE_TABLEAU_COL_01 .'</td>
					<td style="width: 20%; border: 1px solid black; border-collapse: collapse; text-align:center;">'. EN_TETE_TABLEAU_COL_03 .'</td>
					<td style="width: 20%; border: 1px solid black; border-collapse: collapse; text-align:center;">'. EN_TETE_TABLEAU_COL_04 .'</td>
					<td style="width: 10%; border: 1px solid black; border-collapse: collapse; text-align:center;">'. EN_TETE_TABLEAU_COL_05 .'</td>
					<td style="width: 5%; border: 1px solid black; border-collapse: collapse; text-align:center;">'. EN_TETE_TABLEAU_COL_06 .'</td>			
					<td style="width: 10%; border: 1px solid black; border-collapse: collapse; text-align:center;">'. EN_TETE_TABLEAU_COL_09 .'</td>
					<td style="width: 3%; border: 1px solid black; border-collapse: collapse; text-align:center;">'. EN_TETE_TABLEAU_COL_10 .'</td>
					<td style="width: 10%; border: 1px solid black; border-collapse: collapse; text-align:center;">'. EN_TETE_TABLEAU_COL_12 .'</td>				
					'. $En_tete .'
				</tr>
			'. $Contenu_tableau .'
			</table>';

	require_once('\librairie\html2pdf_v4.03\html2pdf.class.php');
	try
	{
		$html2pdf = new HTML2PDF('L', 'A4', 'fr','UTF-8');
		$html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output('extration.pdf');
	}
	catch(HTML2PDF_exception $e) {
		echo $e;
		exit;
	}

?>