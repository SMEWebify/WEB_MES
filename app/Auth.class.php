<?php

namespace App;

Class Auth Extends SQL{

	public function __construct() {}
	

	public function user(): ?User {
		if(session_status() === PHP_SESSION_NONE){
			session_start();
		}
		$IDUSER = $_SESSION['id'] ?? null;
		if($IDUSER === null){
			return null;
		}

		$user = $this->GetQuery('SELECT '. TABLE_ERP_EMPLOYEES .'.idUSER,
										'. TABLE_ERP_EMPLOYEES .'.CODE,
										'. TABLE_ERP_EMPLOYEES .'.NOM,
										'. TABLE_ERP_EMPLOYEES .'.PRENOM,
										'. TABLE_ERP_EMPLOYEES .'.DATE_NAISSANCE,
										'. TABLE_ERP_EMPLOYEES .'.MAIL,
										'. TABLE_ERP_EMPLOYEES .'.NUMERO_PERSO,
										'. TABLE_ERP_EMPLOYEES .'.NUMERO_INTERNE,
										'. TABLE_ERP_EMPLOYEES .'.IMAGE_PROFIL,
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
			WHERE IDUSER=\''. $IDUSER .'\'', true, 'App\User');

			return $user ?: null;
	}

	public function login(string $username, string $password): ?User {

		$user = $this->GetQuery('SELECT '. TABLE_ERP_EMPLOYEES .'.idUSER,
										'. TABLE_ERP_EMPLOYEES .'.CODE,
										'. TABLE_ERP_EMPLOYEES .'.NOM,
										'. TABLE_ERP_EMPLOYEES .'.PRENOM,
										'. TABLE_ERP_EMPLOYEES .'.DATE_NAISSANCE,
										'. TABLE_ERP_EMPLOYEES .'.MAIL,
										'. TABLE_ERP_EMPLOYEES .'.NUMERO_PERSO,
										'. TABLE_ERP_EMPLOYEES .'.NUMERO_INTERNE,
										'. TABLE_ERP_EMPLOYEES .'.IMAGE_PROFIL,
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
										WHERE NAME=\''. $username .'\'', true, 'App\User');
		
		if($user === false){
			return null;
		}
		
		if(password_verify( $password,  $user->PASSWORD )){
			
			if(session_status() === PHP_SESSION_NONE){
				session_start();
			}

			$_SESSION['id'] = $user->idUSER;
			$_SESSION['CODE'] = $user->CODE;
			$_SESSION['NOM'] = $user->NOM;
			$_SESSION['PRENOM'] = $user->PRENOM;
			$_SESSION['DATE_NAISSANCE'] = $user->DATE_NAISSANCE;

			$_SESSION['MAIL'] = $user->MAIL;
			$_SESSION['NUMERO_PERSO'] = $user->NUMERO_PERSO;
			$_SESSION['NUMERO_INTERNE'] = $user->NUMERO_INTERNE;
			$_SESSION['IMAGE_PROFIL'] = $user->IMAGE_PROFIL;

			$_SESSION['STATU'] = $user->STATU;
			$_SESSION['CONNEXION'] = $user->CONNEXION;
			$_SESSION['nom'] = $user->NAME;
			$_SESSION['mdp'] = $user->PASSWORD;
			$_SESSION['fonction'] = $user->FONCTION;
			$_SESSION['UserLanguage'] = $user->LANGUAGE;
			$_SESSION['page_1'] = $user->page_1;
			$_SESSION['page_2'] = $user->page_2;
			$_SESSION['page_3'] = $user->page_3;
			$_SESSION['page_4'] = $user->page_4;
			$_SESSION['page_5'] = $user->page_5;
			$_SESSION['page_6'] = $user->page_6;
			$_SESSION['page_7'] = $user->page_7;
			$_SESSION['page_8'] = $user->page_8;
			$_SESSION['page_9'] = $user->page_9;
			$_SESSION['page_10'] = $user->page_10;

			return $user;
		}
		
		return null;
	}
}

