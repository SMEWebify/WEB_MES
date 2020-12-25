<?php
if(!isset($_SESSION['mdp'])){
	stop('Aucune session ouverte, l\'accès vous est interdit.', 160, 'index.php');
}
else{
	
	$nom = addslashes($_SESSION['nom']);
	$mdp = addslashes($_SESSION['mdp']);

	$data=$bdd->GetQuery('SELECT count(*) as nb FROM '. TABLE_ERP_EMPLOYEES .' WHERE NAME=\''. $nom .'\' AND PASSWORD=\''. $mdp .'\'');
	$nb	= $data[0]->nb;
		
	if($nb ==0 ){
		session_unset();
		session_destroy();
			
		stop('Session inexistante.', 160, 'login.php');
	}
	else{
		$req = $bdd->GetQuery('SELECT '. TABLE_ERP_EMPLOYEES .'.IDUSER,
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
			
		$id = $req[0]->IDUSER;
		$statu = $req[0]->statu;
		$connexion = $req[0]->connexion;
		$nom = stripslashes($req[0]->NAME);
		$mdp = stripslashes($req[0]->PASSWORD);
		$UserLanguage = $req[0]->LANGUAGE;
	
		$fonction = $req[0]->fonction;
		$page_1 = $req[0]->page_1;
		$page_2 = $req[0]->page_2;
		$page_3 = $req[0]->page_3;
		$page_4 = $req[0]->page_4;
		$page_5 = $req[0]->page_5;
		$page_6 = $req[0]->page_6;
		$page_7 = $req[0]->page_7;
		$page_8 = $req[0]->page_8;
		$page_9 = $req[0]->page_9;
		$page_10 = $req[0]->page_10;
			
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
			
		$bdd->GetUpdate('UPDATE '. TABLE_ERP_EMPLOYEES .' SET  connexion=\''. time() .'\' WHERE IDUSER=\''. $id .'\'');	
	}
}
