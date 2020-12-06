<?php

	header( 'content-type: text/html; charset=utf-8' );

	require_once 'include_connection_sql.php';
	require_once 'include_fonctions.php';
	require_once 'include_recup_config.php';

	$Objectif = array(227772,196669, 175967,207020,207020,227772,217371,165616,227772,217371,62106,227772);
	$SecteurMois = array('Octobre','Novembre','Decembre','Janvier','Fevrier','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre');

		
	$max=  max($Objectif);
	$min= min($Objectif);
		
	// L'image fait 1024x800
	$largeur = 1500;
	$hauteur = 700;
	$hauteur_de_base = 800;
	$img = imageCreate($largeur, $hauteur_de_base);

	$Fond = imageColorAllocate($img, 230, 185, 184);
	$Fond2 =  imageColorAllocate($img, 250, 192, 144);
		
	imageFilledRectangle($img, 20, 50, $largeur-25, $hauteur_de_base-50, $Fond2);
		
	$noir  = imageColorAllocate($img, 0, 0, 0);
	$barreOBJECTIF  = imageColorAllocate($img,0,255,0);
	$barreExpedier  = imageColorAllocate($img,255, 102,204);
	$barreCC  = imageColorAllocate($img,255,51,153);
	$barreCC2  = imageColorAllocate($img,255,51,0);
		
		
	imageFilledRectangle($img, 20, 50, $largeur-25, $hauteur_de_base-50, $Fond2);
		
		//$barreLargeur = (int)(($largeur-60)/(1.5*sizeOf($data))+38);
		$barreLargeur = 80;
		//for ($i=0; $i<12; $i++) {
			
			//if ($data[$i]>$max) $max = $data[$i];
			
		//}
		
	
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
	
	
		
		$m = 10;
		
		$m2 =1;
		
		for ($i=0; $i<12; $i++) {
			
			if($m <= 12){
				$queryEXPEDIER = $bdd->query("SELECT SUM(PRIX_U*QT) AS PRIX_TOTAL FROM `planning` WHERE sup!=1 AND !=2 AND !=3 AND QT_EXPEDIER >= QT AND  YEAR(DATE_CONFIRM)=". $anneeAV ." AND MONTH(DATE_CONFIRM)=". $m .""); //OR  YEAR(DATE_CONFIRM)=". $anneeAV .") AND MONTH(DATE_CONFIRM)=". $m ." 
				$queryCC = $bdd->query("SELECT SUM(PRIX_U*QT) AS PRIX_TOTAL FROM `planning` WHERE sup!=1 AND !=2 AND !=3 AND QT_EXPEDIER < QT AND YEAR(DATE_CONFIRM)=". $anneeAV ."  AND MONTH(DATE_CONFIRM)=". $m ." ");
				$m++;
			}
			else{
				$queryEXPEDIER = $bdd->query("SELECT SUM(PRIX_U*QT) AS PRIX_TOTAL FROM `planning` WHERE sup!=1 AND QT_EXPEDIER >= QT AND  YEAR(DATE_CONFIRM)=". $annee ." AND MONTH(DATE_CONFIRM)=". $m2 .""); //OR  YEAR(DATE_CONFIRM)=". $anneeAV .") AND  MONTH(DATE_CONFIRM)=". $m2 ." 
				$queryCC = $bdd->query("SELECT SUM(PRIX_U*QT) AS PRIX_TOTAL FROM `planning` WHERE sup!=1 AND QT_EXPEDIER < QT AND YEAR(DATE_CONFIRM)=". $annee ."  AND  MONTH(DATE_CONFIRM)=". $m2 ." ");
				$m2++;
			}
			
			$dataEXPEDIER = $queryEXPEDIER->fetch();
			$dataCC = $queryCC->fetch();
			
			$x = 10+(int)($barreLargeur*(0.5+$i*1.5));
			$barreHauteurEXPEDIER = (int)(($dataEXPEDIER[0] *($hauteur-80))/$max);  
			$barreHauteurCC = (int)(($dataCC[0] *($hauteur-80))/$max);  

			imageFilledRectangle($img, $x, $hauteur_de_base-50-$barreHauteurCC-$barreHauteurEXPEDIER,$x+$barreLargeur,$hauteur_de_base-50,$barreCC);
			
			imageFilledRectangle($img, $x, $hauteur_de_base-50-$barreHauteurEXPEDIER,$x+$barreLargeur,$hauteur_de_base-50,$barreExpedier);
			
								
			$CAEXPEDIER = round($dataEXPEDIER[0],0);
			$hauteurCAEXPEDIER = $hauteur_de_base-40-$barreHauteurEXPEDIER;
			if($CAEXPEDIER == 0){
				$hauteurCAEXPEDIER =730;
				
			}
			
			imageString($img, 4, $x+15, $hauteurCAEXPEDIER, $CAEXPEDIER , $noir);
			imageString($img, 4, $x+15, $hauteurCAEXPEDIER-50, round($dataCC[0],0) , $noir);
			
			imageString($img, 4, $x+15, 780, round($dataCC[0],0)+ $CAEXPEDIER, $noir);

		}
		
		$DepartTitreCharge_x = 35;
		$DepartTitreCharge_y = 750;
		for ($i=0; $i<12; $i++) {
			
			if($i==0){
				$x_ligne = 50+(int)($barreLargeur*(0.5+$i*1.5));
				$y_ligne = -(int)(($Objectif[$i] *($hauteur))/$max)+800; 
				$x_ligne_suiv = $x_ligne+$barreLargeur+40;
				$y_ligne_suiv = -(int)(($Objectif[$i+1] *($hauteur))/$max)+800;
				imageString($img, 4,$x_ligne-25, $y_ligne-20 , $Objectif[$i], $noir);
			}
			elseif($i>0 & $i<11) {
				$x_ligne = $x_ligne+$barreLargeur+40;
				$y_ligne = -(int)(($Objectif[$i] *($hauteur))/$max)+800; 
				$x_ligne_suiv = $x_ligne+$barreLargeur+40;
				$y_ligne_suiv = -(int)(($Objectif[$i+1] *($hauteur))/$max)+800;
				imageString($img, 4,$x_ligne-25, $y_ligne-20 , $Objectif[$i], $noir);
			}
			else{
				$x_ligne = $x_ligne;
				$y_ligne = -(int)(($Objectif[$i] *($hauteur))/$max)+800; 
				$x_ligne_suiv =  $x_ligne;
				$y_ligne_suiv = -(int)(($Objectif[$i] *($hauteur))/$max)+800; 
				imageString($img, 4,$x_ligne+100, $y_ligne-20 , $Objectif[$i], $noir);

			}
			
			imageline($img,$x_ligne,$y_ligne, $x_ligne_suiv, $y_ligne_suiv ,$noir);

			
			imageString($img, 4,$DepartTitreCharge_x, $DepartTitreCharge_y , $SecteurMois[$i], $noir);
			
			$DepartTitreCharge_x = $DepartTitreCharge_x + 122;
			
		}
			
		imagePNG($img);
		imageDestroy($img);
	
?>