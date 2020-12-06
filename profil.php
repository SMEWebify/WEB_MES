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

	if(isset($_POST['ProfilSpeudo']) AND !empty($_POST['ProfilName'])){
		
		$dossier = 'images/Profils/';
		$fichier = basename($_FILES['PhotoProfil']['name']);
			
		move_uploaded_file($_FILES['PhotoProfil']['tmp_name'], $dossier . $fichier);
		
		
		$UpdateProfilName = $_POST['ProfilName'];
		$UpdateProfilSurName = $_POST['ProfilSurName'];
		$UpdateProfilSpeudo = $_POST['ProfilSpeudo'];
		$UpdateProfilDate = strtotime($_POST['ProfilDate']);
		$UpdateProfilDate = date('Y-m-d H:i:s', $UpdateProfilDate);
		$UpdateProfilMDP = $_POST['ProfilMDP'];
		$UpdateProfilMail = $_POST['ProfilMAIL'];
		$UpdateProfilInternalNumber = $_POST['ProfilInternalNumber'];
		$UpdateProfilPersonnalNumber = $_POST['ProfilPersonnalNumber'];
		$UpdatePhotoProfil = $dossier.$fichier;
	
		If(empty($fichier)){
			$AddSQL = '';
		}
		else{
			$AddSQL = 'IMAGE_PROFIL = \''. addslashes($UpdatePhotoProfil) .'\',';
		}
				
		$bdd->exec('UPDATE `'. TABLE_ERP_EMPLOYEES .'` SET  NOM = \''. addslashes($UpdateProfilName) .'\',
																PRENOM = \''. addslashes($UpdateProfilSurName) .'\',
																DATE_NAISSANCE = \''. addslashes($UpdateProfilDate) .'\',
																MAIL = \''. addslashes($UpdateProfilMail) .'\',
																NUMERO_PERSO = \''. addslashes($UpdateProfilPersonnalNumber) .'\',
																NUMERO_INTERNE = \''. addslashes($UpdateProfilInternalNumber) .'\',
																'. $AddSQL .'
																NAME = \''. addslashes($UpdateProfilSpeudo) .'\',
																PASSWORD = \''. addslashes($UpdateProfilMDP) .'\'
																WHERE IdUser=\''. $_SESSION['id'] .'\'');
																
	}

	$contenu ='
	<form method="post" action="profil.php" class="content-form" enctype="multipart/form-data" >
		<table class="content-table">
			<thead>
				<tr>
					<th colspan="2">
						 Modification du profil 
					</th>
				</tr>
			</thead>
			<tbody>';
	
	$req = $bdd -> query('SELECT idUSER,
								NOM,
								PRENOM,
								DATE_NAISSANCE,
								MAIL,
								NUMERO_PERSO,
								NUMERO_INTERNE,
								IMAGE_PROFIL,
								STATU,
								CONNEXION,
								NAME,
								PASSWORD,
								FONCTION,
								RIGHT_NAME
								
							FROM `'. TABLE_ERP_EMPLOYEES .'` LEFT JOIN `'. TABLE_ERP_RIGHTS .'` ON `'. TABLE_ERP_EMPLOYEES .'`.`FONCTION` = `'. TABLE_ERP_RIGHTS .'`.`id` WHERE IdUser=\''. $_SESSION['id'] .'\'');
							
	while ($donnees_membre = $req->fetch())
	{
		$contenu .='
				<tr>
					<td>
						Nom :
					</td>
					<td>
						<input type="text" name="ProfilName" value="'. $donnees_membre['NOM'] .'">
					</td>
				</tr>
				<tr>
					<td>
						Prénom :
					</td>
					<td>
						<input type="text" name="ProfilSurName" value="'. $donnees_membre['PRENOM'] .'" >
					</td>
				</tr>	
				<tr>
					<td>
						Date de naissance :
					</td>
					<td>
						<input type="date" name="ProfilDate" value="'. $donnees_membre['DATE_NAISSANCE'] .'" >
					</td>
				</tr>
				<tr>
					<td>
						Speudo :
					</td>
					<td>
						<input type="text" name="ProfilSpeudo" value="'. $donnees_membre['NAME'] .'" >
					</td>
				</tr>
				<tr>
					<td>
						Mot de passe :
					</td>
					<td>
						<input type="password" name="ProfilMDP" value="" id="ProfilMDP" required>
					</td>
				</tr>
				<tr>
					<td>
						Confirmation mot de passe :
					</td>
					<td>
						<input type="password" name="ProfilMDPComfirm" id="ProfilMDPComfirm" value="" required>
					</td>
				</tr>
				<tr>
					<td>
						Mail :
					</td>
					<td>
						<input type="text" name="ProfilMAIL" value="'. $donnees_membre['MAIL'] .'">
					</td>
				</tr>
				<tr>
					<td>
						Numéro interne :
					</td>
					<td>
						<input type="text" name="ProfilInternalNumber" value="'. $donnees_membre['NUMERO_INTERNE'] .'">
					</td>
				</tr>
				<tr>
					<td>
						Numéro personnel :
					</td>
					<td>
						<input type="text" name="ProfilPersonnalNumber" value="'. $donnees_membre['NUMERO_PERSO'] .'" >
					</td>
				</tr>
				<tr>
					<td colspan=2">Photo de profil :</td>
				</tr>
				<tr>
					<td colspan=2" ><input type="file" name="PhotoProfil" /></td>
				</tr>
				<tr>
					<td colspan=2">
						<img src="'. $donnees_membre['IMAGE_PROFIL'] .'" title="Photo profil" alt="Photo" />
					</td>
				</tr>
				<tr>
					<td colspan="2" >
						<br/>
						<input type="submit" class="input-moyen" value="Mettre à jour" /> <br/>
						<br/>
					</td>
				</tr>';
	}
	
	$contenu .='
				</tbody>
			</table>
		</form>';
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
<?php
	//include interface
	require_once 'include/include_header.php';

?>

<script>
var password = document.getElementById("ProfilMDP")
  , confirm_password = document.getElementById("ProfilMDPComfirm");

function validatePassword(){
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Les mots de passes ne correspondent pas");
  } else {
    confirm_password.setCustomValidity('');
  }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;
</script>
</head>
<body>
    
<?php

		//include interface
	require_once 'include/include_interface.php';
?>
	<div class="tab">
		<button class="tablinks" onclick="openDiv(event, 'div1')" id="defaultOpen">Modification du profil</button>
		<button class="tablinks" onclick="openDiv(event, 'div2')" id="defaultOpen">Page d'acceuil</button>
		<button class="tablinks" onclick="window.location.href = 'http://localhost/erp/connexion.php?action=deconnexion';">Déconnexion</button>
		
	</div>
	<div id="div1" class="tabcontent" >
<?php
	echo $contenu;
?>
	</div>
	<div id="div2" class="tabcontent" >

	</div>
</body>
</html>