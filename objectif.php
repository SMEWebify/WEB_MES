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

	if($_SESSION['page_7'] != '1'){
		
		stop('L\'accès vous est interdit.', 161, 'connexion.php');
	}
	
	$contenu = "";
	
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

	if(isset($_GET['ANNEE_OBJECTIF'])){
		
		$ANNEE_OBJECTIF = '?a='. $_GET['ANNEE_OBJECTIF'] .'';
	}
	else{
		
		$ANNEE_OBJECTIF = '';
	}
	
	echo '
		<div id="imagegraphique">
			<form action ="objectif.php" method="get" id="ANNEE_OBJECTIF">
				<select name="ANNEE_OBJECTIF" onchange="document.getElementById(\'ANNEE_OBJECTIF\').submit();">
					<option value="2013" '. selected(2013, $_GET['ANNEE_OBJECTIF']) .'>2013</option>
					<option value="2014" '. selected(2014, $_GET['ANNEE_OBJECTIF']) .'>2014</option>
					<option value="2015" '. selected(2015, $_GET['ANNEE_OBJECTIF']) .'>2015</option>
					<option value="2016" '. selected(2016, $_GET['ANNEE_OBJECTIF']) .'>2016</option>
					<option value="2017" '. selected(2017, $_GET['ANNEE_OBJECTIF']) .'>2017</option>
					<option value="2018" '. selected(2018, $_GET['ANNEE_OBJECTIF']) .'>2018</option>
					<option value="2019" '. selected(2019, $_GET['ANNEE_OBJECTIF']) .'>2019</option>
					<option value="2020" '. selected(2020, $_GET['ANNEE_OBJECTIF']) .'>2020</option>
					<option value="2021" '. selected(2021, $_GET['ANNEE_OBJECTIF']) .'>2021</option>
					<option value="2022" '. selected(2022, $_GET['ANNEE_OBJECTIF']) .'>2022</option>
					<option value="2023" '. selected(2023, $_GET['ANNEE_OBJECTIF']) .'>2023</option>
				</select>
			</form>
			<p>
				<img src="include/include_objectif.php'. $ANNEE_OBJECTIF .'" />
			</p>
		</div>';
	
?>

</body>
</html>