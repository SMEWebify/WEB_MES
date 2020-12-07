<?php session_start();

	header( 'content-type: text/html; charset=utf-8' );

	//phpinfo();

	//include for the connection to the SQL database
	require_once 'include/include_connection_sql.php';
	// include for functions
	require_once 'include/include_fonctions.php';
	// include for the constants
	require_once 'include/include_recup_config.php';

	//session verification user
	if(isset($_SESSION['mdp'])){
		require_once 'include/verifications_session.php';
	}
	else{
		stop('Aucune session ouverte, l\'accès vous est interdit.', 160, 'connexion.php');
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

	Echo $contenu;

?>


</body>
</html>
