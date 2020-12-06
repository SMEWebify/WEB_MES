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
	
	if($_SESSION['page_6'] != '1'){
		
		stop('L\'accès vous est interdit.', 161, 'connexion.php');
	}

	$contenu = '';


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


	
?>
	<div class="tab">
		<button class="tablinks" onclick="openDiv(event, 'div1')" >Fiche de non conformité</button>
		<button class="tablinks" onclick="openDiv(event, 'div2')">Actions</button>
		<button class="tablinks" onclick="openDiv(event, 'div3')">Dérogations</button>
		<button class="tablinks" onclick="openDiv(event, 'div4')">Appareils de mesure </button>
	</div>
	<div id="div1" class="tabcontent" >
	</div>
	<div id="div2" class="tabcontent" >
	</div>
	<div id="div3" class="tabcontent" >
	</div>
	<div id="div4" class="tabcontent" >
	</div>
</body>
</html>