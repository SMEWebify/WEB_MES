<?php

	$selected_checkbox = implode(",",$_POST['id_ligne']);
	$contenu ="";
	
	require_once 'include/include_connection_sql.php';
	require_once 'include/include_fonctions.php';
	require_once 'include/include_recup_config.php';

	$res = $bdd->query('select count(*) as nb  FROM `'. TABLE_ERP_PLANNING .'` WHERE id IN ('. $selected_checkbox . ')  AND sup!=1');
	$data = $res->fetch();
	$nb = $data['nb'];
		
	if($nb == 0){
			$contenu = '
						<p class="message">
							
								Aucune commande à afficher
							
						
							<input type="button" value="Retour" onClick="window.history.back()">
						</p>';
	}
	else{
		
	// construction du tableau HTML
		$contenu = $contenu . EN_TETE_TABLEAU_COL_01
							.';'.EN_TETE_TABLEAU_COL_02
							.';'.EN_TETE_TABLEAU_COL_03
							.';'.EN_TETE_TABLEAU_COL_04
							.';'.EN_TETE_TABLEAU_COL_05
							.';'.EN_TETE_TABLEAU_COL_06
							.';'.EN_TETE_TABLEAU_COL_07
							.';'.EN_TETE_TABLEAU_COL_09
							.';'.EN_TETE_TABLEAU_COL_10
							.';'.EN_TETE_TABLEAU_COL_11
							.';'.EN_TETE_TABLEAU_COL_12
							.';'.EN_TETE_TABLEAU_COL_13
							.';'.EN_TETE_TABLEAU_COL_14
							.';'.EN_TETE_TABLEAU_COL_15
							.';'.EN_TETE_TABLEAU_COL_16
							.';'.EN_TETE_TABLEAU_COL_17
							.';'.EN_TETE_TABLEAU_COL_18
							.';'.EN_TETE_TABLEAU_COL_19
							.';'.EN_TETE_TABLEAU_COL_20
							.';'.EN_TETE_TABLEAU_COL_21
							.';'.EN_TETE_TABLEAU_COL_22
							.';'.EN_TETE_TABLEAU_COL_23
							.';'.EN_TETE_TABLEAU_COL_24
							.';'.EN_TETE_TABLEAU_COL_25
							.';'.EN_TETE_TABLEAU_COL_26
							.';'.EN_TETE_TABLEAU_COL_27
							.';'.EN_TETE_TABLEAU_COL_28
							.';'.EN_TETE_TABLEAU_COL_29
							.';'.EN_TETE_TABLEAU_COL_30
							.';'.EN_TETE_TABLEAU_COL_31
							.';'.EN_TETE_TABLEAU_COL_32
							.';'.EN_TETE_TABLEAU_COL_33
							.';'.EN_TETE_TABLEAU_COL_34
							.';'.EN_TETE_TABLEAU_COL_35
							.';'.EN_TETE_TABLEAU_COL_36
							.';'.EN_TETE_TABLEAU_COL_37
							.';'.EN_TETE_TABLEAU_COL_38
							.';'.EN_TETE_TABLEAU_COL_39
							.';'.EN_TETE_TABLEAU_COL_40
							.';'.EN_TETE_TABLEAU_COL_41
							.';'.EN_TETE_TABLEAU_COL_42
							.';'.EN_TETE_TABLEAU_COL_43
							.';'.EN_TETE_TABLEAU_COL_44
							.';'.EN_TETE_TABLEAU_COL_45
							.';'.EN_TETE_TABLEAU_COL_46
							.';'.EN_TETE_TABLEAU_COL_47
							.';'.EN_TETE_TABLEAU_COL_48
							.';'.EN_TETE_TABLEAU_COL_49
							.';'.EN_TETE_TABLEAU_COL_50
							.';'.EN_TETE_TABLEAU_COL_51
							.';'.EN_TETE_TABLEAU_COL_52
							.';'.EN_TETE_TABLEAU_COL_53
							.';'.EN_TETE_TABLEAU_COL_54
							.';'.EN_TETE_TABLEAU_COL_55
							.';'.EN_TETE_TABLEAU_COL_56
							.';'.EN_TETE_TABLEAU_COL_57
							.';'.EN_TETE_TABLEAU_COL_58
							.';'.EN_TETE_TABLEAU_COL_59
							.';'.EN_TETE_TABLEAU_COL_60
							.';'.EN_TETE_TABLEAU_COL_61
							.';'.EN_TETE_TABLEAU_COL_62
							.';'.EN_TETE_TABLEAU_COL_63
							.';'.EN_TETE_TABLEAU_COL_64
							.';'.EN_TETE_TABLEAU_COL_65
							.';'.EN_TETE_TABLEAU_COL_66
							.';'.EN_TETE_TABLEAU_COL_67.'
							';

		$req = $bdd->prepare('SELECT * FROM `'. TABLE_ERP_PLANNING .'` WHERE id IN ('. $selected_checkbox . ')  AND sup!=1');
		$req->execute(array($selected_checkbox));
		while($donnees = $req->fetch())
		{
				for ($colonne = 3; $colonne < 69; $colonne++) {
					
					$contenu = $contenu .''. $donnees[$colonne] .';';
				}
				
				$contenu = $contenu .'
				';
		}
	}
	
	header("Content-type: application/vnd.ms-excel");
	header("Content-disposition: attachment; filename=exportation.csv");
	
	print $contenu;
	
	exit;
?>