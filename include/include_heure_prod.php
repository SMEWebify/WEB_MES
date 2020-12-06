<?php

	header( 'content-type: text/html; charset=utf-8' );

	require_once 'include_connection_sql.php';
	require_once 'include_fonctions.php';
	require_once 'include_recup_config.php';

	if(isset($_GET['a'])){
		$annee = $_GET['a'];
		$anneeAV = $annee-1;
	}
	elseif(date("m")>10){
		$annee = date("Y");	
		$annee = $annee+1;
		$anneeAV = $annee-1;
	}
	else{
		$annee = date("Y");	
		$anneeAV = $annee-1;
	}
	echo 'SELECT SUM(TRUMPH_1) as Tps_Laser
							, SUM(TPS_PRODUIT_L) as Tps_ProduitLaser 
							, SUM(EBAVURAGE) as Tps_Ebav 
							, SUM(TPS_PRODUIT_EBAV) as Tps_ProduitEbav 
							, SUM(PARACHEVEMENT) as Tps_Para 
							, SUM(TPS_PRODUIT_P) as Tps_ProduitPara 
							, SUM(PLIAGE) as Tps_Pliage 
							, SUM(TPS_PRODUIT_PLI) as Tps_ProduitPliage
							, SUM(SOUDURE_MIG) as Tps_MIG 
							, SUM(TPS_PRODUIT_MIG) as Tps_ProduitMIG 
							, SUM(SOUDURE_TIG) as Tps_TIG 
							, SUM(TPS_PRODUIT_TIG) as Tps_ProduitTIG 
							FROM `'. TABLE_ERP_PLANNING .'` 
							WHERE sup!=1 AND QT_EXPEDIER >= QT AND COMMANDE !=\'MAINTENANCE\' AND between (YEAR(DATE_CONFIRM)=\''. $anneeAV .'\' AND MONTH(DATE_CONFIRM)=\'10\' AND  YEAR(DATE_CONFIRM)=\''. $annee .'\' AND MONTH(DATE_CONFIRM)=\'10\'';
	
	$query = $bdd->query('SELECT SUM(TRUMPH_1) as Tps_Laser
							, SUM(TPS_PRODUIT_L) as Tps_ProduitLaser  
							, SUM(EBAVURAGE) as Tps_Ebav 
							, SUM(TPS_PRODUIT_EBAV) as Tps_ProduitEbav  
							, SUM(PARACHEVEMENT) as Tps_Para 
							, SUM(TPS_PRODUIT_P) as Tps_ProduitPara  
							, SUM(PLIAGE) as Tps_Pliage 
							, SUM(TPS_PRODUIT_PLI) as Tps_ProduitPliage 
							, SUM(SOUDURE_MIG) as Tps_MIG 
							, SUM(TPS_PRODUIT_MIG) as Tps_ProduitMIG  
							, SUM(SOUDURE_TIG) as Tps_TIG 
							, SUM(TPS_PRODUIT_TIG) as Tps_ProduitTIG  
							FROM `'. TABLE_ERP_PLANNING .'` 
							WHERE sup!=1 AND QT_EXPEDIER >= QT AND COMMANDE !=\'MAINTENANCE\' AND between (YEAR(DATE_CONFIRM)=\''. $anneeAV .'\' AND MONTH(DATE_CONFIRM)=\'10\' AND  YEAR(DATE_CONFIRM)=\''. $annee .'\' AND MONTH(DATE_CONFIRM)=\'10\')');
							
	
	
	
	$i=0;
	
	$data = $query->fetch();

	$max=  max($data);
	$min= min($data);

	$SecteurOperation = array('Heures Laser','H Laser Produites','Heures EBAVURAGE','H EBAVURAGE Produites','Heures Parachevement','H Parachevement Produites','Heures Pliage','H Pliage Produites','Heures Soudure MIG','H Soudure MIG Produites','Heures Soudure TIG','H Soudure TIG Produites');

	// Ce qui suit est le code d'une image PNG
	header("Content-type: image/png");
	
	
	// L'image fait 1024x800
	$largeur = 1500;
	$hauteur = 700;
	$img = imageCreate($largeur, $hauteur);

	$Fond = imageColorAllocate($img, 230, 185, 184);
	$Fond2 =  imageColorAllocate($img, 250, 192, 144);
	$noir  = imageColorAllocate($img, 0, 0, 0);
	$barreCouleur  = imageColorAllocate($img,0,255,0);
	$barreLaser  = imageColorAllocate($img,255, 102,204);
	$barreLaserProd  = imageColorAllocate($img,255,51,153);
	$barreEbavPara  = imageColorAllocate($img,255,255,102);
	$barreEbavParaProd  = imageColorAllocate($img,255,255,0);
	$barrePliage  = imageColorAllocate($img,153,255,153);
	$barrePliageProd  = imageColorAllocate($img,95,190,48);
	$barreSoudure  = imageColorAllocate($img,255,80,90);
	$barreSoudureProd  = imageColorAllocate($img,255,0,0);
	
	$titre_police = 5;
	
	imageFilledRectangle($img, 20, 50, $largeur-25, $hauteur-50, $Fond2);
	
	$barreLargeur = (int)(($largeur-60)/(1.5*sizeOf($data))+38);
	
	//for ($i=0; $i<12; $i++) {
		
		//if ($data[$i]>$max) $max = $data[$i];
		
	//}
	
	for ($i=0; $i<12; $i++) {
		
		$x = 10+(int)($barreLargeur*(0.5+$i*1.5));
		$barreHauteur = (int)(($data[$i] *($hauteur-80))/$max);  
		
		if($i< 12) $barreCouleur = $barreSoudureProd;
		if($i< 11) $barreCouleur = $barreSoudure;
		if($i< 10) $barreCouleur = $barreSoudureProd;
		if($i< 9) $barreCouleur = $barreSoudure;
		if($i< 8) $barreCouleur = $barrePliageProd;
		if($i< 7) $barreCouleur = $barrePliage;
		if($i< 6) $barreCouleur = $barreEbavParaProd;
		if($i< 5) $barreCouleur = $barreEbavPara;
		if($i< 4) $barreCouleur = $barreEbavParaProd;
		if($i< 3) $barreCouleur = $barreEbavPara;
		if($i< 2) $barreCouleur = $barreLaserProd;
		if($i< 1) $barreCouleur = $barreLaser;
		
		imageFilledRectangle($img, $x, 
							$hauteur-15-$barreHauteur,
							$x+$barreLargeur,
							$hauteur-50,
							$barreCouleur);
							
		$heure = round($data[$i],0);
		$hauteurheure = $hauteur-15-$barreHauteur;
		imageString($img, 4, $x+15, $hauteurheure, $heure , $noir);
	}
	
	$DepartTitreCharge_x = 35;
	$DepartTitreCharge_y = 650;
	
	for ($i=0; $i<12; $i++) {
		
		
		imageString($img, 4,$DepartTitreCharge_x, $DepartTitreCharge_y , $SecteurOperation[$i], $noir);
		
		$DepartTitreCharge_x = $DepartTitreCharge_x + 115;
		
		if ($i&1){
			$DepartTitreCharge_y = $DepartTitreCharge_y - 20;
		}
		else{
			$DepartTitreCharge_y = $DepartTitreCharge_y + 20;
		}
	}
		
	imagePNG($img);
	imageDestroy($img); 
  
?>