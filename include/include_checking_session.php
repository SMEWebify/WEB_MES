<?php

if(!isset($_SESSION['mdp'])){
	stop('Aucune session ouverte, l\'accès vous est interdit.', 160, 'login.php');
}
else{
	
	$nom = addslashes($_SESSION['nom']);
	$mdp = addslashes($_SESSION['mdp']);

	$res = $bdd->query('SELECT count(*) as nb FROM '. TABLE_ERP_EMPLOYEES .' WHERE NAME=\''. $nom .'\' AND PASSWORD=\''. $mdp .'\'');
	$data = $res->fetch();
	$nb = $data['nb'];
		
	if($nb ==0 ){
		session_unset();
		session_destroy();
			
		stop('Session inexistante.', 160, 'login.php');
	}
	else{
		$req = $bdd -> query('SELECT '. TABLE_ERP_EMPLOYEES .'.IDUSER,
										'. TABLE_ERP_EMPLOYEES .'.STATU,
										'. TABLE_ERP_EMPLOYEES .'.CONNEXION,
										'. TABLE_ERP_EMPLOYEES .'.NAME,
										'. TABLE_ERP_EMPLOYEES .'.PASSWORD,
										'. TABLE_ERP_EMPLOYEES .'.FONCTION,
										'. TABLE_ERP_EMPLOYEES .'.LANGUAGE,
										'. TABLE_ERP_RIGHTS .'.page_1,
										'. TABLE_ERP_RIGHTS .'.page_2,
										'. TABLE_ERP_RIGHTS .'.page_3,
										'. TABLE_ERP_RIGHTS .'.page_4,
										'. TABLE_ERP_RIGHTS .'.page_5,
										'. TABLE_ERP_RIGHTS .'.page_6,
										'. TABLE_ERP_RIGHTS .'.page_7,
										'. TABLE_ERP_RIGHTS .'.page_8,
										'. TABLE_ERP_RIGHTS .'.page_9,
										'. TABLE_ERP_RIGHTS .'.page_10
										FROM `'. TABLE_ERP_EMPLOYEES .'` LEFT JOIN `'. TABLE_ERP_RIGHTS .'` ON `'. TABLE_ERP_EMPLOYEES .'`.`FONCTION` = `'. TABLE_ERP_RIGHTS .'`.`id`
										WHERE NAME=\''. $nom .'\' AND PASSWORD=\''. $mdp .'\'');
		$donnees = $req->fetch();
			
		$id = $donnees['IDUSER'];
		$statu = $donnees['statu'];
		$connexion = $donnees['connexion'];
		$nom = stripslashes($donnees['NAME']);
		$mdp = stripslashes($donnees['PASSWORD']);
		$UserLanguage = $donnees['LANGUAGE'];
		
		$fonction = $donnees['fonction'];
		$page_1 = $donnees['page_1'];
		$page_2 = $donnees['page_2'];
		$page_3 = $donnees['page_3'];
		$page_4 = $donnees['page_4'];
		$page_5 = $donnees['page_5'];
		$page_6 = $donnees['page_6'];
		$page_7 = $donnees['page_7'];
		$page_8 = $donnees['page_8'];
		$page_9 = $donnees['page_9'];
		$page_10 = $donnees['page_10'];
			
		$_SESSION['id'] = $id;
		$_SESSION['statu'] = $statu;
		$_SESSION['connexion'] = $connexion;
		$_SESSION['nom'] = $nom;
		$_SESSION['mdp'] = $mdp;
		$_SESSION['fonction'] = $fonction;
		$_SESSION['page_1'] = $page_1;
		$_SESSION['page_2'] = $page_2;
		$_SESSION['page_3'] = $page_3;
		$_SESSION['page_4'] = $page_4;
		$_SESSION['page_5'] = $page_5;
		$_SESSION['page_6'] = $page_6;
		$_SESSION['page_7'] = $page_7;
		$_SESSION['page_8'] = $page_8;
		$_SESSION['page_9'] = $page_9;
		$_SESSION['page_10'] = $page_10;
			
		$bdd->exec('UPDATE '. TABLE_ERP_EMPLOYEES .' SET  connexion=\''. time() .'\' WHERE IDUSER=\''. $id .'\'');	
	}
}
?>