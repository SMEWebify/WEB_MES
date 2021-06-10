<?php 
	//phpinfo();
	use \App\Autoloader;
	use \App\UI\Form;
	use \App\Auth;
	use \App\SQL;
	
	//auto load class
	require_once '../app/Autoload.class.php';
	Autoloader::register();
	
	session_start();
	header( 'content-type: text/html; charset=utf-8' );
	//init form class
	$Form = new Form($_POST);

    //open sql connexion
	$bdd = new SQL();
	
	$error = false;
	//if isset post variable name and password
	if(isset($_POST['nom']) && !empty($_POST['nom'])){

		$Auth = new Auth($bdd);
		$user = $Auth->login($_POST['nom'],$_POST['mdp']);
		if($user){
							//display good connect and exit page
							echo ' <!DOCTYPE html PUBLIC	"-//W3C//DTD XHTML 1.0	Strict//EN"	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
							<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr"	>
							<head>
								<title>'. $CompanyName .'</title>
								<link	rel="stylesheet"	media="screen"	type="text/css"	title="deco"	href="css/stylesheet.css"	/>
								<link rel="stylesheet" media="screen" type="text/css" title="deco" href="css/content.css"
								<link	rel="stylesheet"	media="screen"	type="text/css"	title="deco"	href="css/tableaux.css"	/>
								<link	rel="stylesheet"	media="screen"	type="text/css"	title="deco"	href="css/forms.css"	/>
								<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
								<meta	name="robots"	content="index,follow,all"/>
								<meta	http-equiv="content-type"	content="text/html;	charset=utf-8"	/>
								<meta	http-equiv="refresh"	content="3;	URL=index.php?page=home"	/>
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
										<a	href="index.php?page=home">Ne	pas	attendre</a><br	/>
										<br	/>
									</p>
								</div>
							</body>
							</html>	';
			exit();
		}

		$CallOutBox->add_notification(array('3', 'Erreur: utilisateur ou mots de pass incorrect'));
	}
	elseif	(isset($_GET['action'])	&	$_GET['action']=="deconnexion"){

		session_unset();
		session_destroy();

		stop('Vous	êtes	bien	déconnecté(e).',	4,	'index.php?page=login');
	}
	elseif	(isset($_GET['action'])	&	$_GET['action']=="deco_probleme"){

		session_unset();
		session_destroy();

		stop('Vous	avez	été	déconnecté	de	force.',	5,	'index.php?page=login');
	}
	else{
		session_unset();
		session_destroy();
		
	}
	?>
		<div id="id01" class="modal">
			<form class="modal-content animate"	action="index.php?page=login"	method="post">
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
		<?php
