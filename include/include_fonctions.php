<?php
	// Rapporter toutes les erreurs à part les E_NOTICE
	error_reporting(E_ALL ^ E_NOTICE);
	
	// temps de génération de la page
	function getmicrotime(){  
		list($usec, $sec) = explode(" ",microtime());  
		return ((float)$usec + (float)$sec);  
	}  
	
	// 1 mesure du temps
	$time_start = getmicrotime(); 

	// chiffre aleatoire a 30 caractéres
	function id_aleatoire($longeur){
		$retour = '';
		$elements = "123456789AZERTYUIOPMLKJHGFDSQWXCVBN";
		srand(time());
		if(empty($longeur)) $longeur = '30';
		
		for ($ligne=0;$ligne<$longeur;$ligne++)
		{
			$retour.=substr($elements,(rand()%(strlen($elements))),1);
		}
		return $retour;
	}
	
	// securité des messages
	function secu_message(){
		$retour = '';
		$elements = "abcdefghijklmnopqrstuvwxyz123456789AZERTYUIOPMLKJHGFDSQWXCVBN";
		srand(time());
		for ($ligne=0;$ligne<10;$ligne++)
		{
			$retour.=substr($elements,(rand()%(strlen($elements))),1);
		}
		return $retour;
	}
	
	
	//extrai de texte
	function extrait($string,$start = 20,$end = 15,$sep = ' [...]'){
	
		if(str_word_count($string) > 5){
			$extrait = substr($string,0,$start);
			$extrait = substr($string,0,strrpos($extrait,' ')).$sep;
			$extrait2 = strstr(substr($string, -$end,$end),' ');
		}
		else{
			$extrait = $string;
		}
		
        return $extrait.' '.$extrait2;
    }
	
	// Selection année
	function selected($value, $get){
		
		if($value == $get){
			return 'selected';
			
		}
		elseif($value == date("Y") AND empty($get)){
			return 'selected';
			
		}
		
	}
	
	function checked($value, $get){
		
		if($value == $get){
			return 'checked="checked"';
			
		}
		elseif($value == date("Y") AND empty($get)){
			return 'checked="checked"';
			
		}
		
	}
	
	function dateclient($date_client){
		if(empty($date_client)){
			$date_client ="";
		}
		
		return $date_client;
	}
	
	function modifieValeurArray($tab,$val,$remplace){
		$cle = array_search($val,$tab);
		if($cle!==false)
		{
			$tab[$cle]=$remplace;
			return $tab;
		}
	}

	
	//remplacer les espace par des %20 pour l'url
	function espace_url($variable){
		//on remplace les caractere spéciaux
		$variable = str_replace(array('ä', 'à'), 'a', $variable);
		$variable = str_replace(array('ê', 'ë', 'è', 'é'), 'e', $variable);
		$variable = str_replace(array('ô', 'ö'), 'o', $variable);
		$variable = str_replace(array('î', 'ï'), 'i', $variable);
		$variable = str_replace(array('û', 'ü', 'ù'), 'u', $variable);
		$variable = str_replace(array('ÿ'), 'y', $variable);
		$variable = str_replace(array('ç'), 'c', $variable);
		
		//on remplace les caractere plus  généralitste
		$variable = str_replace(array('€', '#', '+', '*', ' ', '\'', '"', '²', '&', '~', '"', '{', '(', '[', '|', '`', '^', ')', '}', '=', ']', '^', '$', '£', '¤', '%', '*', 'µ', ',', '?', ';', ':', '.', '/', '!', '§', '>', '<'), '-', $variable);
		
		// on enleve les espace ou les doublon
		$variable = preg_replace('#-+#', '-', $variable);
		$variable = preg_replace('# +#', '-', $variable);
		
		$debutVariable =  substr($variable , 0, 1);
		if($debutVariable == "-")
		{
			$NombreCaractere = strlen($variable);
			$variable =  substr($variable , 1-$NombreCaractere);
		}
		
		$FinVariable =  substr($variable , -1);
		if($FinVariable == "-")
		{
			$variable =  substr($variable ,0, -1);
		}
		
		return $variable; 
	}

	//remplace caractère spéciaux
	function nettoyerChaine($chaine){
		return str_replace( array('à','á','â','ã','ä', 'ç', 'è','é','ê','ë', 'ì','í','î','ï', 'ñ', 'ò','ó','ô','õ','ö', 'ù','ú','û','ü', 'ý','ÿ', 'À','Á','Â','Ã','Ä', 'Ç', 'È','É','Ê','Ë', 'Ì','Í','Î','Ï', 'Ñ', 'Ò','Ó','Ô','Õ','Ö', 'Ù','Ú','Û','Ü', 'Ý'), array('a','a','a','a','a', 'c', 'e','e','e','e', 'i','i','i','i', 'n', 'o','o','o','o','o', 'u','u','u','u', 'y','y', 'A','A','A','A','A', 'C', 'E','E','E','E', 'I','I','I','I', 'N', 'O','O','O','O','O', 'U','U','U','U', 'Y'), $chaine);

	}

	// remplacer  la vigule par le point
	function Remplace_virgule($valeur_a_remplacer_virgule){
		
		$valeur_a_remplacer_virgule = str_replace(',', '.', $valeur_a_remplacer_virgule);
		return $valeur_a_remplacer_virgule;
	}
	
	// calcul du pourcentage
	function pourcent($nombre_1, $nombre_2){
		if($nombre_2 == 0){
			$nombre_2 = 1;
		}
		$pourcent = round($nombre_1 / $nombre_2 * 100,2);
		return $pourcent; 
	}
	
	// rajouter des point a un grand chiffre
	function format_nbr($nbr){
        if(!strpos($nbr, '.'))
                $nbr = number_format($nbr,0,'',' ');
        $nbr = '<strong>'.$nbr.'</strong>';

		return $nbr;
	}
	
	//formate l'heure
	function format_temps($timestamp){
		$timestamp_actuel = time();
		$temps = $timestamp_actuel - $timestamp;
		
		$heure = date("H");
		$minute = date("i");
		$seconde = date("s");
		
		$timestamp_minuit = time() -  ($heure *3600 + $minute *60 + $seconde);
		$timestamp_minuit_hier = time() -  ( $heure *3600 + $minute *60 + $seconde + 86400);
		
		$temps_minuit = $timestamp_actuel - $timestamp_minuit;
		$temps_minuit_hier = $timestamp_actuel - $timestamp_minuit_hier;
		
		if($temps < "59")
		{
			$resulta ='il y a '. $temps .'s';
		}
		elseif($temps >= "60" & $temps <= "3600")
		{
			$o = $temps / 60;
			$o = ceil($o);
			$resulta ='Il y a '. $o .'min';
		}
		elseif($temps > "3600" &  $temps < $temps_minuit )
		{
			$resulta =  'Aujourd\'hui à '. date ( "H:i:s"  , $timestamp);
		}
		elseif($temps > $temps_minuit & $temps < $temps_minuit_hier)
		{
			$resulta =  'Hier à '. date ( "H:i:s"  , $timestamp);
		}
		else
		{
			$resulta =  'le '. date ( "d/m/y à H:i:s"  , $timestamp);
		}
		
		return $resulta;
	}
	
	function oui_non($oui_non){
		if($oui_non == "1")
		{
			$oui_non ="oui";
		}
		else{
			$oui_non ="non";
			
		}
		return $oui_non;
	}
	
	function date_fr($date) {
		
		$texte_en = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
		$texte_fr = array("Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche", "Janvier", "F&eacute;vrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Ao&ucirc;t", "Septembre", "Octobre", "Novembre", "D&eacute;cembre");

		$date = str_replace($texte_en, $texte_fr, $date);
		$date = str_replace(".", " ", $date);
		return $date;

	}
	
	function stop($phrase, $numero, $adresse_redirection){
		
		global $url;
		global $adresse_site;
		
		if(empty($numero)){
			$numero = 'Auncun';
		}
		
		if(!empty($adresse_redirection)){
		
			if(substr($adresse_redirection , 0, 34) == "http://localhost/erp/"){
				$meta = '<meta http-equiv="refresh" content="3; URL='. $adresse_redirection .'" />';
			}
			else{
				$meta = '<meta http-equiv="refresh" content="3; URL='. $adresse_site . $adresse_redirection .'" />';
			}
		}
		else{
			$meta = '<meta http-equiv="refresh" content="3; URL='. $adresse_site .'" />';
		}
		
		
		echo'
						<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
							<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
							<head>
								<title>General Error</title>
								<link	rel="stylesheet"	media="screen"	type="text/css"	title="deco"	href="css/stylesheet.css"	/>
								<link rel="stylesheet" media="screen" type="text/css" title="deco" href="css/content.css" 
								<link	rel="stylesheet"	media="screen"	type="text/css"	title="deco"	href="css/tableaux.css"	/>
								<link	rel="stylesheet"	media="screen"	type="text/css"	title="deco"	href="css/forms.css"	/>
								<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
								<meta	name="robots"	content="index,follow,all"/>
								<meta	http-equiv="content-type"	content="text/html;	charset=utf-8"	/>
								'. $meta .'
								<link	rel="icon"	type="images/ico"	href="images/favicon.ico"	/>
							</head>
							<body style="background-color: #34495e; color:#555;  text-align:left; padding-top:50px;">
								<div class="transition" >
									<p>	
										Message	n°	'. $numero .':<br	/>
										<br	/>
										<strong>'. $phrase .'</strong><br	/>
										<br	/>
										Vous	allez	être	redirigé	dans	3	secondes<br	/>
										<br	/>
										<button class="buttonload"><i class="fa fa-spinner fa-spin"></i>Loading</button><br	/>
										<br	/>
										<a	href="'. $adresse_redirection .'">Ne	pas	attendre</a><br	/>
										<br	/>
									</p>
								</div>
							</body>
							</html>	';
		
		exit;
	}
	
	function premiereLigneAafficher($constante, $ordre, $nombreDePages){
		
		if(isset($_GET['p']) AND ctype_digit($_GET['p'])){
			$page = $_GET['p']; 
		}
		elseif(isset($_GET['lp']) AND ctype_digit($_GET['lp'])){
			$page = $_GET['lp']; 
		}
		elseif(isset($_GET['np']) AND ctype_digit($_GET['np'])){
			$page = $_GET['np']; 
		}
		elseif(isset($_GET['sp']) AND ctype_digit($_GET['sp'])){
			$page = $_GET['sp']; 
		}
		else{
			if($ordre == true){
				$page = 1;
			}
			else{
				$page = $nombreDePages;
			}
		}
		
		if($page == 0 AND $ordre == true){
			$page = 1;
		}
		elseif($page == 0 AND $ordre == false){
			$page = $nombreDePages;
		}
		
		if($ordre == true){
			$premiereLigneAafficher = ($page - 1) * $constante;
		}
		else{
			$premiereLigneAafficher = ($nombreDePages - $page) * $constante;
		}
		
		if($premiereLigneAafficher < 0){
			$premiereLigneAafficher = 0;
		}
		
		return $premiereLigneAafficher;
	}
	// $nombreDePages, $page_url_debut, $page_url_fin, $page_actuel, $ordre, $center, $input, $nbr_D_G 
	function pagination($nombreDePages, $page_url_debut, $page_url_fin, $page_actuel, $ordre, $center, $input, $nbr_D_G){

		$pagination ='';
		$user_agent_name = '';
		if($nombreDePages >=1){
		
			if(strpos($_SERVER["HTTP_USER_AGENT"], 'MSIE') !== false){
				$user_agent_name = 'Internet Explorer ';
			}

			if(empty($page_actuel) or !ctype_digit($page_actuel)){
			
				if($ordre == true){
					$page_actuel = 1;
				}
				else{
					$page_actuel = $nombreDePages;
				}
				
				if($page_actuel == 0){
					$page_actuel = 1;
				}
			}

		
			if($ordre == true){
				for ($i = 1 ; $i <= $nombreDePages ; $i++){
					if (($i < $nbr_D_G) OR ($i > $nombreDePages - $nbr_D_G) OR (($i < $page_actuel + $nbr_D_G) AND ($i > $page_actuel -$nbr_D_G)))
					{
						if($page_actuel == $i){
							$pagination .=' ' . $i . '';
						}
						else
						{
							$pagination .=' <a href="'. $page_url_debut .'p' . $i . $page_url_fin .'">' . $i . '</a>';
						}
					}
					else{
						
						if ($i >= $nbr_D_G AND $i <= $page_actuel - $nbr_D_G)
						{
							$i = $page_actuel - $nbr_D_G;
							$pagination .= ' ...';
						}
						elseif ($i >= $page_actuel + $nbr_D_G AND $i <= $nombreDePages - $nbr_D_G)
						{
							$i = $nombreDePages - $nbr_D_G;
							$pagination .= ' ...';
						}
						
						if($i > $nombreDePages)
						{
							$i= $nbr_D_G;
						}
					}
				}
			}
			else{
				for ($i = $nombreDePages ; $i >=1  ; $i--){
					
					if (($i > $nombreDePages - $nbr_D_G) OR ($i < $nbr_D_G) OR (($i < $page_actuel + $nbr_D_G) AND ($i > $page_actuel - $nbr_D_G)))
					{
						if($page_actuel == $i){
							$pagination .=' ' . $i . '';
						}
						else
						{
							$pagination .=' <a href="'. $page_url_debut .'p' . $i . $page_url_fin .'">' . $i . '</a>';
						}
					}
					else{
						if ($i <= $nombreDePages - $nbr_D_G AND $i >= $page_actuel + $nbr_D_G)
						{
							$i = $page_actuel + $nbr_D_G;
							$pagination .= ' ...';
						}
						elseif ($i <= $page_actuel - $nbr_D_G AND $i >= $nbr_D_G)
						{
							$i = $nbr_D_G;
							$pagination .= ' ...';
						}
					}

				}
			}
			
			if($center == true){
				$pagination = '<div class="centrer" >Page : '. $pagination .'</div>';
			}
			else{
				$pagination = 'Page : '. $pagination;
			}
		}
		return $pagination;
	}
	
	function Affichage_zero($valeur_a_remplacer_zero){
	   if($valeur_a_remplacer_zero == 0){
		   
		   $valeur_a_remplacer_zero = "";
	   }
	   
	   return $valeur_a_remplacer_zero;
	}
	
?>