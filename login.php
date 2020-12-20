<?php 
	//phpinfo();
	use \ERP\Autoloader;
	use \ERP\SQL;
	use \ERP\COMPANY\Company;
	use \ERP\COMPANY\CompanyManager;
	use \ERP\Language;

	// include for the constants
	require_once 'include/include_recup_config.php';
	//auto load class
	require_once 'class/Autoload.class.php';
	Autoloader::register();

	session_start();
	header( 'content-type: text/html; charset=utf-8' );

	//open sql connexion
	$bdd = SQL::getInstance();
	//load company vairiable
	$CompanyManager = new CompanyManager($bdd);
	$donneesCompany = $CompanyManager->getDb();
	$Company = new Company($donneesCompany);
	// include for functions
	require_once 'include/include_fonctions.php';

	//if isset post variable name and password
	if(isset($_POST['nom'])	AND	isset($_POST['mdp'])){

		//protect sql requete
		$nom	=	addslashes($_POST['nom']);
		$mdp	=	addslashes($_POST['mdp']);

		//check if not empty post variable
		if(!empty($nom)	or	strlen($mdp)	>	4)	{
			if(!empty($mdp)){
				$res	=	$bdd->query('SELECT	count(*)	as	nb	FROM	'.	TABLE_ERP_EMPLOYEES	.'	WHERE	NAME=\''.	$nom	.'\'	AND	PASSWORD=\''.	$mdp	.'\'');
				$data	=	$res->fetch();
				$nb	=	$data['nb'];

				//check if user exist
				if($nb	==1	){
					$reponse	=	$bdd	->	query('SELECT	statu	FROM	'.	TABLE_ERP_EMPLOYEES	.'	WHERE	NAME=\''.	$nom	.'\'	AND	PASSWORD=\''.	$mdp	.'\'');
					$verification_statut	=	$reponse->fetch();

					//check if user in not ban
					if($verification_statut['statu']	!=	'1'){
						stop('Votre	compte	a	été	suspendu.',	2,	'login.php');
					}
					else{
						//update time of connexion timestamps
						if($bdd->exec("UPDATE	".	TABLE_ERP_EMPLOYEES	."	SET	connexion='".		time()	."'	WHERE	NAME='".	$nom	."'	AND	PASSWORD='".	$mdp	."'"))	{
							//initiat session variable
							$_SESSION['nom']	=	$nom;
							$_SESSION['mdp']	=	$mdp;

							//display good connect and exit page
							echo	'	<!DOCTYPE	html	PUBLIC	"-//W3C//DTD	XHTML	1.0	Strict//EN"	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
							<html	xmlns="http://www.w3.org/1999/xhtml"	xml:lang="fr"	>
							<head>
								<title>'. $CompanyName .'</title>
								<link	rel="stylesheet"	media="screen"	type="text/css"	title="deco"	href="css/stylesheet.css"	/>
								<link rel="stylesheet" media="screen" type="text/css" title="deco" href="css/content.css"
								<link	rel="stylesheet"	media="screen"	type="text/css"	title="deco"	href="css/tableaux.css"	/>
								<link	rel="stylesheet"	media="screen"	type="text/css"	title="deco"	href="css/forms.css"	/>
								<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
								<meta	name="robots"	content="index,follow,all"/>
								<meta	http-equiv="content-type"	content="text/html;	charset=utf-8"	/>
								<meta	http-equiv="refresh"	content="3;	URL=index.php"	/>
								<link	rel="icon"	type="images/ico"	href="images/favicon.ico"	/>
							</head>
							<body	>
								<div class="transition" >
									<p>
										Message	n°	3:<br	/>
										<br	/>
										<strong>Vous	êtes	bien	connecté(e).</strong><br	/>
										<br	/>
										Vous	allez	être	redirigé	dans	3	secondes<br	/>
										<br	/>
										<button class="buttonload"><i class="fa fa-spinner fa-spin"></i>Loading</button><br	/>
										<br	/>
										<a	href="index.php">Ne	pas	attendre</a><br	/>
										<br	/>
									</p>
								</div>
							</body>
							</html>	';
							exit;

						}
						else{
							stop('Erreur,	impossible	de	modifier	l\'enregistrement.',	300,	'login.php');
						}
					}
				}
				else{
					stop('Votre	mot	de	passe	ne	correspond	pas	avec	l\'identifiant.',	500,	'login.php');
				}
			}
			else	{
				stop('Votre	mot	de	passe	est	invalide.',	102,	'login.php');
			}
		}
		else	{
			stop('Votre	identifiant	est	invalide.',	101,	'login.php');
		}
	}
	elseif	(isset($_GET['action'])	&	$_GET['action']=="deconnexion"){

		session_unset();
		session_destroy();

		stop('Vous	êtes	bien	déconnecté(e).',	4,	'login.php');
	}
	elseif	(isset($_GET['action'])	&	$_GET['action']=="deco_probleme"){

		session_unset();
		session_destroy();

		stop('Vous	avez	été	déconnecté	de	force.',	5,	'login.php');
	}
?>
<!DOCTYPE	html	PUBLIC	"-//W3C//DTD	XHTML	1.0	Transitional//EN"	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html	xmlns="http://www.w3.org/1999/xhtml"	xml:lang="fr"	>
<head>
<?php
	//include header
	require_once 'include/include_header.php';
?>
</head>
<body>
	<div id="id01" class="modal">
		<form class="modal-content animate"	action="login.php"	method="post">
				<div class="container">
					<label	for="uname"><b>Utilisateur</b></label>
					<input	type="text"	name="nom"	id="nom"	required>
					<label	for="psw"><b>Mot de passe</b></label>
					<input	type="password"	name="mdp"	id="mdp"	name="psw"	required>
					<button	type="submit">Connexion</button>
					<input type="checkbox" onclick="DisplayPassword()">Voir mot de passe
				</div>
		</form>
	</div>
</body>
</html>
