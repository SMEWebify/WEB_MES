<?php
	//phpinfo();

	//include pour la connection à la base SQL 
	require_once 'include/include_connection_sql.php';
	//include pour les fonctions
	require_once 'include/include_fonctions.php';
	//include pour les constantes
	require_once 'include/include_recup_config.php';
	
	$annee = intval($_GET['annee']);
	$sem = intval($_GET['sem']);

	
	
	$req = $bdd->query("SELECT  SUM(TRUMPH_1) AS total_TRUMPH_1 FROM ". TABLE_ERP_PLANNING ." WHERE sup!=1 AND sup!=2 AND SEM_PROD_LASER ='". $sem ."' AND YEAR(DATE_CONFIRM)=". $annee ."");
	$donnees_laser = $req->fetch();
	$req = $bdd->query("SELECT  SUM(EBAVURAGE) AS total_EBAV FROM ". TABLE_ERP_PLANNING ." WHERE sup!=1 AND sup!=2 AND SEM_PROD_EBAV ='". $sem ."' AND YEAR(DATE_CONFIRM)=". $annee ."");
	$donnees_ebav = $req->fetch();
	$req = $bdd->query("SELECT  SUM(PARACHEVEMENT) AS total_PARA FROM ". TABLE_ERP_PLANNING ." WHERE sup!=1 AND sup!=2 AND SEM_PROD_PARA ='". $sem ."' AND YEAR(DATE_CONFIRM)=". $annee ."");
	$donnees_para = $req->fetch();
	$req = $bdd->query("SELECT  SUM(PLIAGE) AS total_PLIAGE FROM ". TABLE_ERP_PLANNING ." WHERE sup!=1 AND sup!=2 AND SEM_PROD_PLI ='". $sem ."' AND YEAR(DATE_CONFIRM)=". $annee ."");
	$donnees_pliage = $req->fetch();
	$req = $bdd->query("SELECT  SUM(SOUDURE_MIG) AS total_MIG FROM ". TABLE_ERP_PLANNING ." WHERE sup!=1 AND sup!=2 AND SEM_PROD_MIG ='". $sem ."' AND YEAR(DATE_CONFIRM)=". $annee ."");
	$donnees_MIG = $req->fetch();
	$req = $bdd->query("SELECT  SUM(SOUDURE_TIG) AS total_TIG FROM ". TABLE_ERP_PLANNING ." WHERE sup!=1 AND sup!=2 AND SEM_PROD_TIG ='". $sem ."' AND YEAR(DATE_CONFIRM)=". $annee ."");
	$donnees_TIG = $req->fetch();
	
	$res = $bdd->query('SELECT  count(DISTINCT COMMANDE) as NB_CMD from `'. TABLE_ERP_PLANNING .'` WHERE WEEK(DATE_CONFIRM)='. $sem .'  AND sup!=1 AND sup!=2 ');
	$data = $res->fetch();
	$NB_CMD = $data['NB_CMD'];
	
	$res = $bdd->query('SELECT  count(id) as NB_LIGNE from `'. TABLE_ERP_PLANNING .'` WHERE WEEK(DATE_CONFIRM)='. $sem .'  AND sup!=1 AND sup!=2 ');
	$data = $res->fetch();
	$NB_LIGNE = $data['NB_LIGNE'];
	
	$req = $bdd->query("SELECT  SUM(PRIX_U*QT) AS PRIX_TOTAL  FROM ". TABLE_ERP_PLANNING ." WHERE sup!=1 AND sup!=2 AND sup!=3 AND SEM_PROD_LASER ='". $sem ."' AND YEAR(DATE_CONFIRM)=". $annee ."");
	$CA = $req->fetch();
	
	$content = '
		<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
			<title>EXPORT CHARGE</title>
			<link rel="stylesheet" media="screen" type="text/css" title="deco" href="css/stylesheet.css" />
		</head>
		<body>
		
			<table style="width: 96%; border: 1px solid black; border-collapse: collapse; margin: auto; text-align:center;">
				<tr>
					<th  colspan="7">
						<h1> CHARGE DE PRODUCTION SEM '. $sem . '</h1>
					</th>
				</tr>
				<tr>
					<td  colspan="7">
						<br/>
					</td>
				</tr>
				<tr>
					<td colspan="2" class="TRUMPH_1" >
						LASER (120)   
					</td>
					<td  class="EBAVURAGE" >
						EBAVURAGE (35)
					</td>
					<td  class="PARACHEVEMENT" >
						PARACH (35)
					</td>
					<td  class="PLIAGE" >
						PLIAGE (60)    
					</td>
					<td  class="SOUDURE" >
						SOUDURE MIG (105)
					</td>
					<td  class="SOUDURE" >
						SOUDURE TIG (105)
					</td>
				</tr>
				<tr>
					<td rowspan="2" class="INFO_RETARD_SEMAINE" '. $style_en_cours .'> 
						<a href="planning.php?sem='. $sem_prod .'&annee='. $annee .'"> Sem '. $sem_prod .'</a><br/>
						<a href="planning.php?export&sem='. $sem_prod .'&annee='. $annee .'"><img src="image/image_export.ico" title="Export" alt="Export" /></a>
					</td>
					<td class="TRUMPH_1" '. $style_en_cours .'> 
						<a href="planning.php?sem='. $sem_prod .'&1=1&annee='. $annee .'">'. pourcent($donnees_laser['total_TRUMPH_1'], 120) .' %</a>
					</td>
					<td class="EBAVURAGE"  '. $style_en_cours .'colspan="2"> 
						<a href="planning.php?sem='. $sem_prod .'&2=1&3=1&annee='. $annee .'">'. pourcent($donnees_ebav['total_EBAV']+$donnees_para['total_PARA'],70) .' %</a>	
					</td>
					<td class="PLIAGE"  '. $style_en_cours .'> 
						<a href="planning.php?sem='. $sem_prod .'&4=1&annee='. $annee .'">'. pourcent($donnees_pliage['total_PLIAGE'],60) .' %</a>
					</td>

					<td class="SOUDURE"  '. $style_en_cours .' colspan="2">  
						<a href="planning.php?sem='. $sem_prod .'&5=1&6=1&annee='. $annee .'">'. pourcent($donnees_MIG['total_MIG']+$donnees_TIG['total_TIG'],105) .' %	</a>
					</td>
				</tr>
				<tr>
					<td class="Tableau_blanc"> 
						<a href="pdf.php?sem='. $sem_prod .'&annee='. $annee .'&operation=laser" onclick="window.open(this.href); return false;">'. round($donnees_laser['total_TRUMPH_1'],2) .' h</a>
					</td>
					<td class="Tableau_blanc"> 
						<a href="pdf.php?sem='. $sem_prod .'&annee='. $annee .'&operation=ebav" onclick="window.open(this.href); return false;">'. round($donnees_ebav['total_EBAV'],2) .' h</a>
					</td>
					<td class="Tableau_blanc"> 
						<a href="pdf.php?sem='. $sem_prod .'&annee='. $annee .'&operation=para" onclick="window.open(this.href); return false;">'. round($donnees_para['total_PARA'],2) .' h</a>
					</td>
					<td class="Tableau_blanc"> 
						<a href="pdf.php?sem='. $sem_prod .'&annee='. $annee .'&operation=pliage" onclick="window.open(this.href); return false;">'. round($donnees_pliage['total_PLIAGE'],2) .' h</a>
					</td>
					<td class="Tableau_blanc"> 
						<a href="pdf.php?sem='. $sem_prod .'&annee='. $annee .'&operation=MIG" onclick="window.open(this.href); return false;">'. round($donnees_MIG['total_MIG'],2) .' h</a>
					</td>
					<td class="Tableau_blanc"> 
						<a href="pdf.php?sem='. $sem_prod .'&annee='. $annee .'&operation=TIG" onclick="window.open(this.href); return false;">'. round($donnees_TIG['total_TIG'],2) .' h</a>
					</td>
				</tr>
				<tr>
					<td  colspan="7">
						<br/>
					</td>
				</tr>
				<tr>
					<td  colspan="7" style="text-align:left;">
						Nombre de commande : '. $NB_CMD .'
					</td>
				</tr>
				<tr>
					<td  colspan="7">
						<br/>
					</td>
				</tr>
				<tr>
					<td  colspan="7" style="text-align:left;">
						Nombre de référence (ligne) : '. $NB_LIGNE .'
					</td>
				</tr>
				<tr>
					<td  colspan="7">
						<br/>
					</td>
				</tr>
				<tr>
					<td  colspan="7" style="text-align:left;">
						Total Chiffre d\'affaire : '. round($CA[0],2) .' €
					</td>
				</tr>
			</table>
		</body>
		</html>
		
		';

	require_once('\librairie\html2pdf_v4.03\html2pdf.class.php');
	try
	{
		$html2pdf = new HTML2PDF('P', 'A4', 'fr','UTF-8');
		$html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output('etiquette.pdf');
		exit;
	}
	catch(HTML2PDF_exception $e) {
		echo $e;
		exit;
	}

?>