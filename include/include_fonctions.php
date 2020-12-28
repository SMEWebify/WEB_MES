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
	
	function case_OF($valeur){
		if($valeur == ""){
			$img = '<img src="image/OF/case.png" title="case" />';
		}
		else{
			$img = '<img src="image/OF/case_noir.png" title="case" />';
		}
		
		return $img;
	}
	
	function modifieValeurArray($tab,$val,$remplace){
		$cle = array_search($val,$tab);
		if($cle!==false)
		{
			$tab[$cle]=$remplace;
			return $tab;
		}
	}
	
	function PLAN($PLAN, $id_RECURENT){
		if($id_RECURENT != 0){
					
			$PLAN = '<a href="plan.php?ref='. $id_RECURENT .'">'. $PLAN .'</a>';
		}
		else{
			$PLAN =  $PLAN;
		}
		return $PLAN;
	}
	
	function NumDoc($NumDoc,$Index, $digit){
		
		$Index= $Index+1;
		$Index = str_pad($Index, $digit, '0', STR_PAD_LEFT);
		$NumDoc = str_replace('<AAAA>', date("Y") , $NumDoc);
		$NumDoc = str_replace('<AA>', date("y") , $NumDoc);
		$NumDoc = str_replace('<MM>', date("m") , $NumDoc);
		$NumDoc = str_replace('<JJ>', date("d") , $NumDoc);
		$NumDoc = str_replace('<I>',$Index , $NumDoc);
		
		return $NumDoc;
	}
	
	// BBcode
	function code($texte){
		$texte = str_replace(':D', '<img src="images/boutons/12.gif" title="heureux" alt="heureux" />', $texte);
		$texte = str_replace(':mdr:', '<img src="images/boutons/11.gif" title="mdr" alt="mdr" />', $texte);
		$texte = str_replace(':triste:', '<img src="images/boutons/10.gif" title="triste" alt="triste" />', $texte);
		$texte = str_replace(':langue:', '<img src="images/boutons/9.gif" title="langue" alt="langue" />', $texte);
		$texte = str_replace(':rool:', '<img src="images/boutons/8.gif" title="rool" alt="rool" />', $texte);
		$texte = str_replace(';-:', '<img src="images/boutons/7.gif" title="clein" alt="clein" />', $texte);
		$texte = str_replace(':|', '<img src="images/boutons/6.gif" title="neutre" alt="neutre" />', $texte);
		$texte = str_replace(':S', '<img src="images/boutons/5.gif" title="pale" alt="pale" />', $texte);
		$texte = str_replace('oO', '<img src="images/boutons/4.gif" title="suspect" alt="suspect" />', $texte);
		$texte = str_replace(':win:', '<img src="images/boutons/3.png" title="win" alt="win" />', $texte);
		$texte = str_replace(':scratch:', '<img src="images/boutons/2.png" title="scratch" alt="scratch" />', $texte);
		$texte = str_replace(':study:', '<img src="images/boutons/1.png" title="study" alt="study" />', $texte);
		$texte = str_replace(':pc:', '<img src="images/boutons/13.gif" title="win" alt="pc" />', $texte);
		$texte = str_replace(':sos:', '<img src="images/boutons/14.gif" title="scratch" alt="sos" />', $texte);
		$texte = str_replace(':pingu:', '<img src="images/boutons/15.gif" title="study" alt="pingu" />', $texte);
		$texte = str_replace(':capt:', '<img src="images/boutons/16.gif" title="win" alt="capt" />', $texte);
		$texte = str_replace(':incli:', '<img src="images/boutons/17.gif" title="scratch" alt="incli" />', $texte);
		$texte = str_replace(':hiii:', '<img src="images/boutons/18.gif" title="study" alt="hiii" />', $texte);
		
		$texte = str_replace(':hihi:', '<img src="images/boutons/7-1.gif" title="hihi" alt="hihi" />', $texte);
		$texte = str_replace(':yo:', '<img src="images/boutons/7-2.gif" title="yo" alt="yo" />', $texte);
		$texte = str_replace(':cyp:', '<img src="images/boutons/7-3.gif" title="Espion" alt="cyp" />', $texte);
		$texte = str_replace(':na:', '<img src="images/boutons/7-4.gif" title="Na !!" alt="na" />', $texte);
		$texte = str_replace(':boul:', '<img src="images/boutons/7-5.gif" title="Boulet" alt="boul" />', $texte);
		$texte = str_replace(':crouik:', '<img src="images/boutons/7-6.gif" title="Crouik" alt="crouik" />', $texte);
		
		preg_match('`\[code\](.*)\[/code\]`isU', $texte, $entre_balise);
		$original_tag = array('#<#', '#>#', '#"#', '#:#', '#\[#', '#\]#', '#\(#', '#\)#', '#\{#', '#\}#');
		$nouveau_tag = array('&lt;', '&gt;', '&quot;', '&#58;', '&#91;', '&#93;', '&#40;', '&#41;', '&#123;', '&#125;');
		$entre_balise = preg_replace($original_tag, $nouveau_tag, $entre_balise[1]);

		$texte = preg_replace('`\[code\](.+)\[/code\]`isU', '<span class="code_annonce">Code :</span><div class="code">'. $entre_balise .'</div>', $texte);
		
		
	//	$texte = preg_replace('`\[quote=\](.+)\[/quote\]`isU', '<span class="citation_annonce">Citation :</span><div class="citation">$1</div>', $texte);
		
		$texte = preg_replace('`\[quote\]`isU', '<span class="citation_annonce">Citation :</span><div class="citation">', $texte);
		$texte = preg_replace('`\[quote=\]`isU', '<span class="citation_annonce">Citation : $1</span><div class="citation">', $texte);
		$texte = preg_replace('`\[quote=(.+)\]`isU', '<span class="citation_annonce">Citation : $1</span><div class="citation">', $texte);
		$texte = preg_replace('`\[/quote\]`isU', '</div>', $texte);
		
		
		
		$texte = preg_replace('`\[g\](.+)\[/g\]`isU', '<strong>$1</strong>', $texte);
		$texte = preg_replace('`\[i\](.+)\[/i\]`isU', '<em>$1</em>', $texte);
		$texte = preg_replace('`\[s\](.+)\[/s\]`isU', '<span class="souligne">$1</span>', $texte);
		
		$texte = preg_replace('`\[float=left\](.+)\[/float\]`isU', '<div class="float_left">$1</div>', $texte);
		$texte = preg_replace('`\[float=right\](.+)\[/float\]`isU', '<div class="float_right">$1</div>', $texte);
		
		$texte = preg_replace('`\[center\](.+)\[/center\]`isU', '<div class="centrer">$1</div>', $texte);
		$texte = preg_replace('`\[right\](.+)\[/right\]`isU', '<div class="droite-texte">$1</div>', $texte);
		$texte = preg_replace('`\[left\](.+)\[/left\]`isU', '<div class="gauche-texte">$1</div>', $texte);
		$texte = preg_replace('`\[justify\](.+)\[/justify\]`isU', '<div class="justify">$1</div>', $texte);
		
	//	$texte = preg_replace('`\[list\](.+)\[/list\]`isU', '<ul>$1</ul>', $texte);
	//	$texte = preg_replace('`\[*\](.+)`isU', '<li>$1</li>', $texte);
		$texte = preg_replace('`\[img\](.+)\[/img\]`isU', '<img style="margin:5px;" src="$1" alt="Image utilisateur" title="Image utilisateur"/>', $texte);
		$texte = preg_replace('`\[img=\](.+)\[/img\]`isU', '<img style="margin:5px;" src="$1" alt="Image utilisateur" title="Image utilisateur"/>', $texte);
		$texte = preg_replace('`\[img=(.+)\](.+)\[/img\]`isU', '<img style="margin:5px;" src="$2" alt="$1" title="$1"/>', $texte);
		
		$texte = preg_replace('`\[url\](.+)\[/url\]`isU', '<a href="$1">$1</a>', $texte);
		$texte = preg_replace('`\[url=(.+)\](.+)\[/url\]`isU', '<a href="$1">$2</a>', $texte);
		$texte = preg_replace('`\[email\]([a-z0-9&\-_.]+?@[\w\-]+\.([\w\-\.]+\.)?[\w]+)\[/email\]`isU', ' <a href="mailto:$1">$1</a>', $texte);
		$texte = preg_replace('`\[email=([a-z0-9&\-_.]+?@[\w\-]+\.([\w\-\.]+\.)?[\w]+)\](.+)\[/email\]`isU', ' <a href="mailto:$1">$3</a>', $texte);
		
		$texte = preg_replace("#(^|[\n ])([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*)#is", "\\1<a href=\"\\2\" >\\2</a>", $texte);
		$texte = preg_replace("#(^|[\n ])((www|ftp)\.[\w\#$%&~/.\-;:=,?@\[\]+]*)#is", "\\1<a href=\"http://\\2\" >\\2</a>", $texte);
		$texte = preg_replace("#(^|[\n ])([a-z0-9&\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i", "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>", $texte);
		
		$texte = preg_replace('#\[color=(orange|noir|marron|vertf|olive|marine|violet|bleugris|argent|gris|rouge|vertc|jaune|bleu|rose|turquoise|blanc)\](.+)\[/color\]#isU', '<span class="$1">$2</span>', $texte);
		$texte = preg_replace('#\[size=(minuscule|trespetit|petit|moyen|grand|tresgrand|trestresgrand)\](.+)\[/size\]#isU', '<span class="$1">$2</span>', $texte);
		$texte = preg_replace('#\[font=(arial|arialb|comic|courier|georgia|impact|times|trebuchet|verdana)\](.+)\[/font\]#isU', '<span class="$1">$2</span>', $texte);

		return $texte;
	}
	
		// BBcode
	function code_inverse($texte){
		$texte = str_replace(':D', '', $texte);
		$texte = str_replace(':mdr:', '', $texte);
		$texte = str_replace(':triste:', '', $texte);
		$texte = str_replace(':langue:', '', $texte);
		$texte = str_replace(':rool:', '', $texte);
		$texte = str_replace(';-:', '', $texte);
		$texte = str_replace(':|', '', $texte);
		$texte = str_replace(':S', '', $texte);
		$texte = str_replace('oO', '', $texte);
		$texte = str_replace(':win:', '', $texte);
		$texte = str_replace(':scratch:', '', $texte);
		$texte = str_replace(':study:', '', $texte);
		$texte = str_replace(':pc:', '', $texte);
		$texte = str_replace(':sos:', '', $texte);
		$texte = str_replace(':pingu:', '', $texte);
		$texte = str_replace(':capt:', '', $texte);
		$texte = str_replace(':incli:', '', $texte);
		$texte = str_replace(':hiii:', '', $texte);
		
		$texte = str_replace(':hiii:', '', $texte);
		$texte = str_replace(':yo:', '', $texte);
		$texte = str_replace(':cyp:', '', $texte);
		$texte = str_replace(':na:', '', $texte);
		$texte = str_replace(':boul:', '', $texte);
		$texte = str_replace(':crouik:', '', $texte);
		
		preg_match('`\[code\](.*)\[/code\]`isU', $texte, $entre_balise);
		$original_tag = array('#<#', '#>#', '#"#', '#:#', '#\[#', '#\]#', '#\(#', '#\)#', '#\{#', '#\}#');
		$nouveau_tag = array('&lt;', '&gt;', '&quot;', '&#58;', '&#91;', '&#93;', '&#40;', '&#41;', '&#123;', '&#125;');
		$entre_balise = preg_replace($original_tag, $nouveau_tag, $entre_balise[1]);

		$texte = preg_replace('`\[code\](.+)\[/code\]`isU', ''. $entre_balise .'', $texte);
		
		$texte = preg_replace('`\[quote\]`isU', 'Citation :', $texte);
		$texte = preg_replace('`\[quote=(.+)\]`isU', 'Citation :', $texte);
		$texte = preg_replace('`\[/quote\]`isU', '', $texte);
		
		$texte = preg_replace('`\[g\](.+)\[/g\]`isU', '$1', $texte);
		$texte = preg_replace('`\[i\](.+)\[/i\]`isU', '$1', $texte);
		$texte = preg_replace('`\[s\](.+)\[/s\]`isU', '$1', $texte);
		
		$texte = preg_replace('`\[float=left\](.+)\[/float\]`isU', '$1', $texte);
		$texte = preg_replace('`\[float=right\](.+)\[/float\]`isU', '$1', $texte);
		
		$texte = preg_replace('`\[center\](.+)\[/center\]`isU', '$1', $texte);
		$texte = preg_replace('`\[right\](.+)\[/right\]`isU', '$1', $texte);
		$texte = preg_replace('`\[left\](.+)\[/left\]`isU', '$1', $texte);
		$texte = preg_replace('`\[justify\](.+)\[/justify\]`isU', '$1', $texte);
		$texte = preg_replace('`\[list\]\[*\](.+)\[/list\]`isU', '$1', $texte);
		
		$texte = preg_replace('`\[url\](.+)\[/url\]`isU', '($1)', $texte);
		$texte = preg_replace('`\[url=\](.+)\[/url\]`isU', '($2)', $texte);
		$texte = preg_replace('`\[url=(.+)\](.+)\[/url\]`isU', ' $2 ', $texte);
		$texte = preg_replace('`\[email\]([a-z0-9&\-_.]+?@[\w\-]+\.([\w\-\.]+\.)?[\w]+)\[/email\]`isU', '$1', $texte);
		
		$texte = preg_replace('`\[img\](.+)\[/img\]`isU', '', $texte);
		$texte = preg_replace('`\[img=\](.+)\[/img\]`isU', '', $texte);
		$texte = preg_replace('`\[img=(.+)\](.+)\[/img\]`isU', '', $texte);
	
		$texte = preg_replace('#\[color=(orange|noir|marron|vertf|olive|marine|violet|bleugris|argent|gris|rouge|vertc|jaune|bleu|rose|turquoise|blanc)\](.+)\[/color\]#isU', '$2', $texte);
		$texte = preg_replace('#\[size=(minuscule|trespetit|petit|moyen|grand|tresgrand|trestresgrand)\](.+)\[/size\]#isU', '$2', $texte);
		$texte = preg_replace('#\[font=(arial|arialb|comic|courier|georgia|impact|times|trebuchet|verdana)\](.+)\[/font\]#isU', '$2', $texte);

		return $texte;
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
	
	//detection des robots
	function robot($ip)
	{
		$ip =  substr($ip , 0, 7);
		if($ip == "66.249." or $ip == "64.68.9" or $ip == "64.233." or $ip == "216.239")
		{
			$resulta = "Googlebot";
		}
		elseif($ip == "66.196." or $ip == "68.142.")
		{
			$resulta = "Yahoo! Slurp";
		}
		elseif ($ip == "207.68." or $ip == "65.54.1" or $ip =="65.55.2" or $ip =="65.55.1")
		{
			$resulta = "MSNBot";
		}
		elseif ($ip == "208.146" or $ip == "209.202")
		{
			$resulta = "Lycos";
		}
		elseif ($ip == "66.17.1" or $ip == "194.221" or $ip == "204.123")
		{
			$resulta = "Alta Vista";
		}
		elseif ($ip == "195.101")
		{
			$resulta = "Voila";
		}
		elseif ($ip == "128.30.")
		{
			$resulta = "MassachusettsIT";
		}
		else
		{
			$resulta = "Anonyme";
		}
		
		return $resulta;
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

	function type_rapport($type_rapport){
		
		if($type_rapport == 1){
			$TYPE = 'NCF Ext';
		}
		elseif($type_rapport == 2){
			$TYPE = 'RC Ext';
		}
		elseif($type_rapport == 3){
			$TYPE = 'NCF Int';
		}
		elseif($type_rapport == 4){
			$TYPE = 'RC Int';
		}
		else{
			$TYPE = 'N/A';
		}
		
		return $TYPE;
	}
	
	function padding_ligne($commandeEnregistrer, $commandeLigne){
		
		if($commandeEnregistrer == $commandeLigne){
				
			$padding_ligne = '';
		}
		else{
			$padding_ligne = 'style="border-top: 3px solid black; "';
		}
		
		return $padding_ligne;
	}
	
?>