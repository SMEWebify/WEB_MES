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

	//Check if the user is authorized to view the page
	if($_SESSION['page_10'] != '1'){

		stop('L\'accès vous est interdit.', 161, 'connexion.php');
	}

	///////////////////////////////
	//// COMMMENT ////
	///////////////////////////////
	if(isset($_POST['Comment']) AND !empty($_POST['Comment'])){

		$req = $bdd->exec("UPDATE  ". TABLE_ERP_ARTICLE ." SET 	COMMENT='". addslashes($_POST['Comment']) ."'
																		WHERE Id='". addslashes($_POST['IDArticle'])."'");
	}

	////////////////////
	////  ARTICLES  ////
	////////////////////

	$titleOnglet1 = "Ajouter un Aricle";
	$actionForm = 'etudes.php';

	if(isset($_POST['CODEAtricle']) AND isset($_POST['LABELAtricle']) AND !empty($_POST['CODEAtricle']) AND !empty($_POST['LABELAtricle']) OR  isset($_GET['id']) AND !empty($_GET['id'])){
		if(isset($_POST['CODEAtricle'])){


			$req = $bdd->query("SELECT COUNT(ID) as nb FROM ". TABLE_ERP_ARTICLE ." WHERE id = '". addslashes($_POST['IDArticle'])."'");

			$data = $req->fetch();
			$req->closeCursor();
			$nb = $data['nb'];


			if($nb>=1){


				$titleOnglet1 = "Mettre à jours";

				$dossier = 'images/ArticlesImage/';
				$fichier = basename($_FILES['FichierImageArticle']['name']);

				move_uploaded_file($_FILES['FichierImageArticle']['tmp_name'], $dossier . $fichier);

				$InsertImage = $dossier.$fichier;

				If(empty($fichier)){
					$AddSQL = '';
				}
				else{
					$AddSQL = ', IMAGE = \''. addslashes($InsertImage) .'\'';
				}

				$req = $bdd->exec("UPDATE  ". TABLE_ERP_ARTICLE ." SET 	LABEL='". addslashes($_POST['LABELAtricle']) ."',
																			IND='". addslashes($_POST['INDArticle']) ."',
																			PRESTATION_ID='". addslashes($_POST['PRESTA_IDAtricle']) ."',
																			FAMILLE_ID='". addslashes($_POST['FAMILLE_IDArticle']) ."',
																			ACHETER='". addslashes($_POST['ACHETERArticle']) ."',
																			PRIX_ACHETER='". addslashes($_POST['PRIXACHArticle']) ."',
																			VENDU='". addslashes($_POST['VENDUArticle']) ."',
																			PRIX_VENDU='". addslashes($_POST['PRIXVENArticle']) ."',
																			UNITE_ID='". addslashes($_POST['UNITArticle']) ."',
																			MATIERE='". addslashes($_POST['MATIEREArticle']) ."',
																			EP='". addslashes($_POST['EPArticle']) ."',
																			DIM_X='". addslashes($_POST['DIMXArticle']) ."',
																			DIM_Y='". addslashes($_POST['DIMYArticle']) ."',
																			DIM_Z='". addslashes($_POST['DIMZArticle']) ."',
																			POIDS='". addslashes($_POST['POIRDSArticle']) ."',
																			SUR_X='". addslashes($_POST['SURDIMXArticle']) ."',
																			SUR_Y='". addslashes($_POST['SURDIMYArticle']) ."',
																			SUR_Z='". addslashes($_POST['SURDIMZArticle']) ."'
																			". $AddSQL ."
																		WHERE Id='". addslashes($_POST['IDArticle'])."'");

				$req = $bdd->query('SELECT '. TABLE_ERP_ARTICLE .'.ID,
									'. TABLE_ERP_ARTICLE .'.CODE,
									'. TABLE_ERP_ARTICLE .'.LABEL,
									'. TABLE_ERP_ARTICLE .'.IND,
									'. TABLE_ERP_ARTICLE .'.PRESTATION_ID,
									'. TABLE_ERP_ARTICLE .'.FAMILLE_ID,
									'. TABLE_ERP_ARTICLE .'.ACHETER,
									'. TABLE_ERP_ARTICLE .'.PRIX_ACHETER,
									'. TABLE_ERP_ARTICLE .'.VENDU,
									'. TABLE_ERP_ARTICLE .'.PRIX_VENDU,
									'. TABLE_ERP_ARTICLE .'.UNITE_ID,
									'. TABLE_ERP_ARTICLE .'.MATIERE,
									'. TABLE_ERP_ARTICLE .'.EP,
									'. TABLE_ERP_ARTICLE .'.DIM_X,
									'. TABLE_ERP_ARTICLE .'.DIM_Y,
									'. TABLE_ERP_ARTICLE .'.DIM_Z,
									'. TABLE_ERP_ARTICLE .'.POIDS,
									'. TABLE_ERP_ARTICLE .'.SUR_X,
									'. TABLE_ERP_ARTICLE .'.SUR_Y,
									'. TABLE_ERP_ARTICLE .'.SUR_Z,
									'. TABLE_ERP_ARTICLE .'.COMMENT,
									'. TABLE_ERP_ARTICLE .'.IMAGE,
									'. TABLE_ERP_UNIT .'.LABEL AS UNIT_LABEL,
									'. TABLE_ERP_PRESTATION .'.LABEL AS PRESTATION_LABEL,
									'. TABLE_ERP_SOUS_FAMILLE .'.LABEL AS FAMILLE_LABEL
									FROM '. TABLE_ERP_ARTICLE .'
										LEFT JOIN `'. TABLE_ERP_UNIT .'` ON `'. TABLE_ERP_ARTICLE .'`.`UNITE_ID` = `'. TABLE_ERP_UNIT .'`.`id`
										LEFT JOIN `'. TABLE_ERP_PRESTATION .'` ON `'. TABLE_ERP_ARTICLE .'`.`PRESTATION_ID` = `'. TABLE_ERP_PRESTATION .'`.`id`
										LEFT JOIN `'. TABLE_ERP_SOUS_FAMILLE .'` ON `'. TABLE_ERP_ARTICLE .'`.`FAMILLE_ID` = `'. TABLE_ERP_SOUS_FAMILLE .'`.`id`
									WHERE '. TABLE_ERP_ARTICLE .'.id = '. addslashes($_POST['IDArticle']).'');
			}
			else{

				$titleOnglet1 = "Mettre à jours";


				$dossier = 'images/ArticlesImage/';
				$fichier = basename($_FILES['FichierImageArticle']['name']);

				move_uploaded_file($_FILES['FichierImageArticle']['tmp_name'], $dossier . $fichier);

				$InsertImage = $dossier.$fichier;

				$req = $bdd->exec("INSERT INTO ". TABLE_ERP_ARTICLE ." VALUE ('0',
																				'". addslashes($_POST['CODEAtricle']) ."',
																				'". addslashes($_POST['LABELAtricle']) ."',
																				'". addslashes($_POST['INDArticle']) ."',
																				'". addslashes($_POST['PRESTA_IDAtricle']) ."',
																				'". addslashes($_POST['FAMILLE_IDArticle']) ."',
																				'". addslashes($_POST['ACHETERArticle']) ."',
																				'". addslashes($_POST['PRIXACHArticle']) ."',
																				'". addslashes($_POST['VENDUArticle']) ."',
																				'". addslashes($_POST['PRIXVENArticle']) ."',
																				'". addslashes($_POST['UNITArticle']) ."',
																				'". addslashes($_POST['MATIEREArticle']) ."',
																				'". addslashes($_POST['EPArticle']) ."',
																				'". addslashes($_POST['DIMXArticle']) ."',
																				'". addslashes($_POST['DIMYArticle']) ."',
																				'". addslashes($_POST['DIMZArticle']) ."',
																				'". addslashes($_POST['POIRDSArticle']) ."',
																				'". addslashes($_POST['SURDIMXArticle']) ."',
																				'". addslashes($_POST['SURDIMYArticle']) ."',
																				'". addslashes($_POST['SURDIMZArticle']) ."',
																				'',
																				'". addslashes($InsertImage) ."')");


				$req = $bdd->query('SELECT '. TABLE_ERP_ARTICLE .'.ID,
									'. TABLE_ERP_ARTICLE .'.CODE,
									'. TABLE_ERP_ARTICLE .'.LABEL,
									'. TABLE_ERP_ARTICLE .'.IND,
									'. TABLE_ERP_ARTICLE .'.PRESTATION_ID,
									'. TABLE_ERP_ARTICLE .'.FAMILLE_ID,
									'. TABLE_ERP_ARTICLE .'.ACHETER,
									'. TABLE_ERP_ARTICLE .'.PRIX_ACHETER,
									'. TABLE_ERP_ARTICLE .'.VENDU,
									'. TABLE_ERP_ARTICLE .'.PRIX_VENDU,
									'. TABLE_ERP_ARTICLE .'.UNITE_ID,
									'. TABLE_ERP_ARTICLE .'.MATIERE,
									'. TABLE_ERP_ARTICLE .'.EP,
									'. TABLE_ERP_ARTICLE .'.DIM_X,
									'. TABLE_ERP_ARTICLE .'.DIM_Y,
									'. TABLE_ERP_ARTICLE .'.DIM_Z,
									'. TABLE_ERP_ARTICLE .'.POIDS,
									'. TABLE_ERP_ARTICLE .'.SUR_X,
									'. TABLE_ERP_ARTICLE .'.SUR_Y,
									'. TABLE_ERP_ARTICLE .'.SUR_Z,
									'. TABLE_ERP_ARTICLE .'.COMMENT,
									'. TABLE_ERP_ARTICLE .'.IMAGE,
									'. TABLE_ERP_UNIT .'.LABEL AS UNIT_LABEL,
									'. TABLE_ERP_PRESTATION .'.LABEL AS PRESTATION_LABEL,
									'. TABLE_ERP_SOUS_FAMILLE .'.LABEL AS FAMILLE_LABEL
									FROM '. TABLE_ERP_ARTICLE .'
										LEFT JOIN `'. TABLE_ERP_UNIT .'` ON `'. TABLE_ERP_ARTICLE .'`.`UNITE_ID` = `'. TABLE_ERP_UNIT .'`.`id`
										LEFT JOIN `'. TABLE_ERP_PRESTATION .'` ON `'. TABLE_ERP_ARTICLE .'`.`PRESTATION_ID` = `'. TABLE_ERP_PRESTATION .'`.`id`
										LEFT JOIN `'. TABLE_ERP_SOUS_FAMILLE .'` ON `'. TABLE_ERP_ARTICLE .'`.`FAMILLE_ID` = `'. TABLE_ERP_SOUS_FAMILLE .'`.`id`
									ORDER BY '. TABLE_ERP_ARTICLE .'.id DESC LIMIT 0, 1');
			}
		}
		else{

			$Name = preg_replace('#-+#',' ', addslashes($_GET['id']));

			$titleOnglet1 = "Mettre à jours";

			$req = $bdd -> query('SELECT '. TABLE_ERP_ARTICLE .'.ID,
									'. TABLE_ERP_ARTICLE .'.CODE,
									'. TABLE_ERP_ARTICLE .'.LABEL,
									'. TABLE_ERP_ARTICLE .'.IND,
									'. TABLE_ERP_ARTICLE .'.PRESTATION_ID,
									'. TABLE_ERP_ARTICLE .'.FAMILLE_ID,
									'. TABLE_ERP_ARTICLE .'.ACHETER,
									'. TABLE_ERP_ARTICLE .'.PRIX_ACHETER,
									'. TABLE_ERP_ARTICLE .'.VENDU,
									'. TABLE_ERP_ARTICLE .'.PRIX_VENDU,
									'. TABLE_ERP_ARTICLE .'.UNITE_ID,
									'. TABLE_ERP_ARTICLE .'.MATIERE,
									'. TABLE_ERP_ARTICLE .'.EP,
									'. TABLE_ERP_ARTICLE .'.DIM_X,
									'. TABLE_ERP_ARTICLE .'.DIM_Y,
									'. TABLE_ERP_ARTICLE .'.DIM_Z,
									'. TABLE_ERP_ARTICLE .'.POIDS,
									'. TABLE_ERP_ARTICLE .'.SUR_X,
									'. TABLE_ERP_ARTICLE .'.SUR_Y,
									'. TABLE_ERP_ARTICLE .'.SUR_Z,
									'. TABLE_ERP_ARTICLE .'.COMMENT,
									'. TABLE_ERP_ARTICLE .'.IMAGE,
									'. TABLE_ERP_UNIT .'.LABEL AS UNIT_LABEL,
									'. TABLE_ERP_PRESTATION .'.LABEL AS PRESTATION_LABEL,
									'. TABLE_ERP_PRESTATION .'.TYPE,
									'. TABLE_ERP_SOUS_FAMILLE .'.LABEL AS FAMILLE_LABEL
									FROM '. TABLE_ERP_ARTICLE .'
										LEFT JOIN `'. TABLE_ERP_UNIT .'` ON `'. TABLE_ERP_ARTICLE .'`.`UNITE_ID` = `'. TABLE_ERP_UNIT .'`.`id`
										LEFT JOIN `'. TABLE_ERP_PRESTATION .'` ON `'. TABLE_ERP_ARTICLE .'`.`PRESTATION_ID` = `'. TABLE_ERP_PRESTATION .'`.`id`
										LEFT JOIN `'. TABLE_ERP_SOUS_FAMILLE .'` ON `'. TABLE_ERP_ARTICLE .'`.`FAMILLE_ID` = `'. TABLE_ERP_SOUS_FAMILLE .'`.`id`
									WHERE '. TABLE_ERP_ARTICLE .'.LABEL = \''. $Name.'\'');
		}

		$DonneesArticle = $req->fetch();
		$req->closeCursor();

		$ArticleId = $DonneesArticle['ID'];
		$ArticleCODE = $DonneesArticle['CODE'];
		$ArticleLabel = $DonneesArticle['LABEL'];
		$ArticleInd = $DonneesArticle['IND'];
		$ArticlePrestaId = $DonneesArticle['PRESTATION_ID'];
		$ArticlePrestaLab = $DonneesArticle['PRESTATION_LABEL'];
		$ArticleTYPEPresta = $DonneesArticle['TYPE'];
		$ArticleFamilleId = $DonneesArticle['FAMILLE_ID'];
		$ArticleFamilleLab = $DonneesArticle['FAMILLE_LABEL'];
		$ArticleAcheter = $DonneesArticle['ACHETER'];
		$ArticlePrixAch = $DonneesArticle['PRIX_ACHETER'];
		$ArticleVendu = $DonneesArticle['VENDU'];
		$ArticlePrixVendu = $DonneesArticle['PRIX_VENDU'];
		$ArticleUNIT_ID = $DonneesArticle['UNITE_ID'];
		$ArticleUNIT = $DonneesArticle['UNIT_LABEL'];
		$ArticleMatiere = $DonneesArticle['MATIERE'];
		$ArticleEP = $DonneesArticle['EP'];
		$ArticleDimX = $DonneesArticle['DIM_X'];
		$ArticleDimY = $DonneesArticle['DIM_Y'];
		$ArticleDimZ = $DonneesArticle['DIM_Z'];
		$ArticlePoids = $DonneesArticle['POIDS'];
		$ArticleSurX = $DonneesArticle['SUR_X'];
		$ArticleSurY = $DonneesArticle['SUR_Y'];
		$ArticleSurZ = $DonneesArticle['SUR_Z'];
		$ArticleComment = $DonneesArticle['COMMENT'];
		$ArticleImage = $DonneesArticle['IMAGE'];

		$actionForm = 'etudes.php?id='. $ArticleLabel .'';
	}

	$PrestaListe ='<option value="0">Aucune</option>';
	$req = $bdd -> query('SELECT Id, LABEL   FROM '. TABLE_ERP_PRESTATION .'');
	while ($DonneesPresta = $req->fetch()){
		$PrestaListe .='<option value="'. $DonneesPresta['Id'] .'" '. selected($ArticlePrestaId, $DonneesPresta['Id']) .' >'. $DonneesPresta['LABEL'] .'</option>';
	}
	$req->closeCursor();

	$FamilleListe ='<option value="0">Aucune</option>';
	$req = $bdd -> query('SELECT Id, LABEL   FROM '. TABLE_ERP_SOUS_FAMILLE .'');
	while ($DonneesFamille = $req->fetch()){
		$FamilleListe .='<option value="'. $DonneesFamille['Id'] .'" '. selected($ArticleFamilleId, $DonneesFamille['Id']) .'>'. $DonneesFamille['LABEL'] .'</option>';
	}
	$req->closeCursor();

	$UnitListe ='<option value="0">Aucune</option>';
	$UnitListeInit  ='<option value="0">Aucune</option>';
	$req = $bdd -> query('SELECT Id, LABEL   FROM '. TABLE_ERP_UNIT .'');
	while ($DonneesUnit = $req->fetch()){
		$UnitListe .='<option value="'. $DonneesUnit['Id'] .'" '. selected($ArticleUNIT_ID, $DonneesUnit['Id']) .'>'. $DonneesUnit['LABEL'] .'</option>';
		$UnitListeInit .='<option value="'. $DonneesUnit['Id'] .'>'. $DonneesUnit['LABEL'] .'</option>';
	}
	$req->closeCursor();

	if(!empty($ArticleCODE)){$DisplayCode = '<input type="hidden" name="CODEAtricle" value="'. $ArticleCODE .'">' .$ArticleCODE;}
	else{ $DisplayCode ='<input type="text" name="CODEAtricle" required="required">'; }

	$contenu1 = '
				<tr>
					<td>CODE</td>
					<td>Label</td>
					<td>Indice</td>
					<td>Prestation</td>
					<td>Famille</td>
					<td>Type</td>
				</tr>
				<tr>
					<td >
						<input type="hidden" name="IDArticle" value="'. $ArticleId .'">
						'. $DisplayCode .'
					</td>
					<td >
						<input type="text" name="LABELAtricle" value="'. $ArticleLabel .'" >
					</td>
					<td >
						<input type="text" name="INDArticle" value="'. $ArticleInd .'" size="10">
					</td>
					<td >
						<select name="PRESTA_IDAtricle">
							'. $PrestaListe .'
						</select>
					</td>
					<td >
						<select name="FAMILLE_IDArticle">
							'. $FamilleListe .'
						</select>
					</td>
					<td>
						<select name="">
							<option value="1" '. selected($ArticleTYPEPresta, 1) .' >Productive</option>
							<option value="2" '. selected($ArticleTYPEPresta, 2) .' >Matière première</option>
							<option value="3" '. selected($ArticleTYPEPresta, 3) .' >Matière première (tôle)</option>
							<option value="4" '. selected($ArticleTYPEPresta, 4) .' >Matière première (profilé)</option>
							<option value="5" '. selected($ArticleTYPEPresta, 5) .' >Matière première (bloc)</option>
							<option value="6" '. selected($ArticleTYPEPresta, 6) .' >Fourniture</option>
							<option value="7" '. selected($ArticleTYPEPresta, 7) .' >Sous-traitance</option>
							<option value="8" '. selected($ArticleTYPEPresta, 8) .' >Article composés</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Acheter</td>
					<td>Prix acheté</td>
					<td>Vendu</td>
					<td>Prix vendue</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td >
						<select name="ACHETERArticle">
							<option value="0" '. selected($ArticleAcheter, 0) .'>Non</option>
							<option value="1" '. selected($ArticleAcheter, 1) .'>Oui</option>
						</select>
					</td>
					<td >
						<input type="number" name="PRIXACHArticle" value="'. $ArticlePrixAch .'" step=".001" required="required">
					</td>
					<td >
						<select name="VENDUArticle">
							<option value="0" '. selected($ArticleVendu, 0) .'>Non</option>
							<option value="1" '. selected($ArticleVendu, 1) .'>Oui</option>
						</select>
					</td>
					</td>
					<td >
						<input type="number" name="PRIXVENArticle" value="'. $ArticlePrixVendu .'" step=".001" required="required">
					</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>Unité</td>
					<td>Matière</td>
					<td>EP</td>
					<td>Poids</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td >
						<select name="UNITArticle">
							'. $UnitListe .'
						</select>
					</td>
					<td >
						<input type="text" name="MATIEREArticle" value="'. $ArticleMatiere .'" size="10">
					</td>
					<td >
						<input type="number" name="EPArticle" value="'. $ArticleEP .'" size="10" step=".001" required="required">
					</td>
					<td >
						<input type="number" name="POIRDSArticle" value="'. $ArticlePoids .'" size="10" step=".001" required="required">
					</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>Dimention X</td>
					<td>Dimention Y</td>
					<td>Dimention Z</td>
					<td>Sur dimention X</td>
					<td>Sur dimention Y</td>
					<td>Sur dimention Z</td>
				</tr>
				<tr>
					<td >
						<input type="number" name="DIMXArticle" value="'. $ArticleDimX .'" required="required">
					</td>
					<td >
						<input type="number" name="DIMYArticle" value="'. $ArticleDimY .'" size="10" required="required">
					</td>
					<td >
						<input type="number" name="DIMZArticle" value="'. $ArticleDimZ .'" required="required">
					</td>
					<td >
						<input type="number" name="SURDIMXArticle" value="'. $ArticleSurX .'" size="10" required="required">
					</td>
					<td>
						<input type="number" name="SURDIMYArticle" value="'. $ArticleSurY .'" required="required">
					</td>
					<td>
						<input type="number" name="SURDIMZArticle" value="'. $ArticleSurZ .'" size="10" required="required">
					</td>
				</tr>
				<tr>
					<td colspan=6">Image</td>
				</tr>
				<tr>
					<td colspan=6" ><input type="file" name="FichierImageArticle" /></td>
				</tr>
				<tr>
					<td colspan=6"><img src="'. $ArticleImage .'" title="Image article" alt="Article" /></td>
				</tr>
				';

	$req = $bdd->query("SELECT * FROM ". TABLE_ERP_ARTICLE ." ORDER BY LABEL");
	while ($donnees_Article = $req->fetch())
	{
		$ListeArticle .= '<option  value="'. $donnees_Article['LABEL'] .'" >';
		$FormListeArticle .= '<option value="'. $donnees_Article['id'] .'" >'. $donnees_Article['LABEL'] .'</option>';
	}

	$req->closeCursor();

	///////////////////////////////
	//// DECOUPAGE TECHNIQUE ////
	///////////////////////////////

	if(isset($_POST['AddORDREDecoupTech']) AND !empty($_POST['AddORDREDecoupTech'])){

		$req = $bdd->exec("INSERT INTO ". TABLE_ERP_DEC_TECH ." VALUE ('0',
																		'". addslashes($ArticleId) ."',
																		'". addslashes($_POST['AddORDREDecoupTech']) ."',
																		'". addslashes($_POST['AddPRESTADecoupTech']) ."',
																		'". addslashes($_POST['AddLABELDecoupTech']) ."',
																		'". addslashes($_POST['AddTPSPREPDecoupTech']) ."',
																		'". addslashes($_POST['AddTPSPRODDecoupTech']) ."',
																		'". addslashes($_POST['AddCOUTDecoupTech']) ."',
																		'". addslashes($_POST['AddPRIXDecoupTech']) ."')");

	}

	if(isset($_POST['id_DecoupTech']) AND !empty($_POST['id_DecoupTech'])){

		$UpdateIdDecoupTech = $_POST['id_DecoupTech'];
		$UpdateORDREDecoupTech = $_POST['UpdateORDREDecoupTech'];
		$UpdatePRESTADecoupTech = $_POST['UpdatePRESTADecoupTech'];
		$UpdateLABELDecoupTech = $_POST['UpdateLABELDecoupTech'];
		$UpdateTPSPREPDecoupTech = $_POST['UpdateTPSPREPDecoupTech'];
		$UpdateTPSPRODDecoupTech = $_POST['UpdateTPSPRODDecoupTech'];
		$UpdateCOUTDecoupTech = $_POST['UpdateCOUTDecoupTech'];
		$UpdatePRIXDecoupTech = $_POST['UpdatePRIXDecoupTech'];

		$i = 0;
		foreach ($UpdateIdDecoupTech as $id_generation) {

			$bdd->exec('UPDATE `'. TABLE_ERP_DEC_TECH .'` SET  ORDRE = \''. addslashes($UpdateORDREDecoupTech[$i]) .'\',
																PRESTA_ID = \''. addslashes($UpdatePRESTADecoupTech[$i]) .'\',
																LABEL = \''. addslashes($UpdateLABELDecoupTech[$i]) .'\',
																TPS_PREP = \''. addslashes($UpdateTPSPREPDecoupTech[$i]) .'\',
																TPS_PRO = \''. addslashes($UpdateTPSPRODDecoupTech[$i]) .'\',
																COUT = \''. addslashes($UpdateCOUTDecoupTech[$i]) .'\',
																PRIX = \''. addslashes($UpdatePRIXDecoupTech[$i]) .'\'
																WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
	}

	if(isset($_POST['CODEAtricle']) AND isset($_POST['LABELAtricle']) AND !empty($_POST['CODEAtricle']) AND !empty($_POST['LABELAtricle']) OR  isset($_GET['id']) AND !empty($_GET['id'])){
		$iDecoupTech = 0;
		$TtTpsPrepa = 0;
		$TtTpsProd = 0;
		$TtCout = 0;
		$TtPrix = 0;

		$req = $bdd -> query('SELECT '. TABLE_ERP_DEC_TECH .'.Id,
										'. TABLE_ERP_DEC_TECH .'.ORDRE,
										'. TABLE_ERP_DEC_TECH .'.PRESTA_ID,
										'. TABLE_ERP_DEC_TECH .'.LABEL,
										'. TABLE_ERP_DEC_TECH .'.TPS_PREP,
										'. TABLE_ERP_DEC_TECH .'.TPS_PRO,
										'. TABLE_ERP_DEC_TECH .'.COUT,
										'. TABLE_ERP_DEC_TECH .'.PRIX,
										'. TABLE_ERP_PRESTATION .'.LABEL AS PRESTA_LABEL
										FROM `'. TABLE_ERP_DEC_TECH .'`
											LEFT JOIN `'. TABLE_ERP_PRESTATION .'` ON `'. TABLE_ERP_DEC_TECH .'`.`PRESTA_ID` = `'. TABLE_ERP_PRESTATION .'`.`id`
										WHERE '. TABLE_ERP_DEC_TECH .'.ARTICLE_ID = '. $ArticleId .'
											ORDER BY '. TABLE_ERP_DEC_TECH .'.ORDRE');

		while ($donnees_DecoupTech = $req->fetch()){

			$PrestaListe ='<option value="0">Aucune</option>';
			$Subreq = $bdd -> query('SELECT Id, LABEL   FROM '. TABLE_ERP_PRESTATION .'');
			while ($DonneesPresta = $Subreq->fetch())
			{
				$PrestaListe .='<option value="'. $DonneesPresta['Id'] .'" '. selected($DonneesPresta['Id'], $donnees_DecoupTech['PRESTA_ID']) .' >'. $DonneesPresta['LABEL'] .'</option>';
			}

			 $DecoupageTechnique .= '

					<tr>
						<td></td>
						<td>
							<input type="hidden" name="id_DecoupTech[]" id="id_DecoupTech" value="'. $donnees_DecoupTech['Id'] .'">
							<input type="number" name="UpdateORDREDecoupTech[]" value="'. $donnees_DecoupTech['ORDRE'] .'" required="required">
						</td>
						<td>
							<select name="UpdatePRESTADecoupTech[]">
								'. $PrestaListe .'
							</select>
						</td>
						<td><input type="text"  name="UpdateLABELDecoupTech[]" value="'. $donnees_DecoupTech['LABEL'] .'" required="required"></td>
						<td><input type="number"  name="UpdateTPSPREPDecoupTech[]" value="'. $donnees_DecoupTech['TPS_PREP'] .'" step=".001" required="required"></td>
						<td><input type="number"  name="UpdateTPSPRODDecoupTech[]" value="'. $donnees_DecoupTech['TPS_PRO'] .'" step=".001" required="required"></td>
						<td><input type="number"  name="UpdateCOUTDecoupTech[]" value="'. $donnees_DecoupTech['COUT'] .'" step=".001" required="required"></td>
						<td><input type="number"  name="UpdatePRIXDecoupTech[]" value="'. $donnees_DecoupTech['PRIX'] .'" step=".001" required="required"></td>
					</tr>';

			$iDecoupTech++;
			$TtTpsPrepa += $donnees_DecoupTech['TPS_PREP'];
			$TtTpsProd += $donnees_DecoupTech['TPS_PRO'];
			$TtCout += $donnees_DecoupTech['COUT'];
			$TtPrix += $donnees_DecoupTech['PRIX'];
		}

		if($iDecoupTech>=1){
			$DecoupageTechnique .='
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td>Total :</td>
						<td>'. $TtTpsPrepa .'</td>
						<td>'. $TtTpsProd .'</td>
						<td>'. $TtCout .'</td>
						<td>'. $TtPrix .'</td>
					</tr>';
			$iDecoupTech = "(". $iDecoupTech .")";

		}
		else{
			$iDecoupTech= "";
		}
	}

	///////////////////////////////
	//// NOMENCLATURE ////
	///////////////////////////////

	if(isset($_POST['AddORDRENomencl']) AND !empty($_POST['AddORDRENomencl'])){

		$req = $bdd->exec("INSERT INTO ". TABLE_ERP_NOMENCLATURE ." VALUE ('0',
																		'". addslashes($_POST['AddORDRENomencl']) ."',
																		'". addslashes($ArticleId) ."',
																		'". addslashes($_POST['AddARTICLENomencl']) ."',
																		'". addslashes($_POST['AddLABELNomencl']) ."',
																		'". addslashes($_POST['AddQTNomencl']) ."',
																		'". addslashes($_POST['AddTUNITNomencl']) ."',
																		'". addslashes($_POST['AddPRIXUNomencl']) ."',
																		'". addslashes($_POST['AddPRIXACHATNomencl']) ."')");

	}

	if(isset($_POST['UpdateIdNomencl']) AND !empty($_POST['UpdateIdNomencl'])){

		$UpdateIdNomencl = $_POST['UpdateIdNomencl'];
		$UpdateORDRENomencl = $_POST['UpdateORDRENomencl'];
		$UpdateARTICLENomencl = $_POST['UpdateARTICLENomencl'];
		$UpdateLABELNomencl = $_POST['UpdateLABELNomencl'];
		$UpdateQTNomencl = $_POST['UpdateQTNomencl'];
		$UpdateUNITNomencl = $_POST['UpdateUNITNomencl'];
		$UpdatePRIXUNomencl = $_POST['UpdatePRIXUNomencl'];
		$UpdatePRIXACHATNomencl = $_POST['UpdatePRIXACHATNomencl'];

		$i = 0;
		foreach ($UpdateIdNomencl as $id_generation) {

			$bdd->exec('UPDATE `'. TABLE_ERP_NOMENCLATURE .'` SET  ORDRE = \''. addslashes($UpdateORDRENomencl[$i]) .'\',
																LABEL = \''. addslashes($UpdateLABELNomencl[$i]) .'\',
																QT = \''. addslashes($UpdateQTNomencl[$i]) .'\',
																UNIT_ID = \''. addslashes($UpdateUNITNomencl[$i]) .'\',
																PRIX_U = \''. addslashes($UpdatePRIXUNomencl[$i]) .'\',
																PRIX_ACHAT = \''. addslashes($UpdatePRIXACHATNomencl[$i]) .'\'
																WHERE Id IN ('. $id_generation . ')');
			$i++;
		}

	}

	if(isset($_POST['CODEAtricle']) AND isset($_POST['LABELAtricle']) AND !empty($_POST['CODEAtricle']) AND !empty($_POST['LABELAtricle']) OR  isset($_GET['id']) AND !empty($_GET['id'])){
		$iNomencl = 0;

		$req = $bdd -> query('SELECT '. TABLE_ERP_NOMENCLATURE .'.Id,
										'. TABLE_ERP_NOMENCLATURE .'.ORDRE,
										'. TABLE_ERP_NOMENCLATURE .'.PARENT_ID,
										'. TABLE_ERP_NOMENCLATURE .'.ARTICLE_ID,
										'. TABLE_ERP_NOMENCLATURE .'.LABEL,
										'. TABLE_ERP_NOMENCLATURE .'.QT,
										'. TABLE_ERP_NOMENCLATURE .'.UNIT_ID,
										'. TABLE_ERP_NOMENCLATURE .'.PRIX_U,
										'. TABLE_ERP_NOMENCLATURE .'.PRIX_ACHAT	,
										'. TABLE_ERP_ARTICLE .'.LABEL AS ARTICLE_LABEL,
										'. TABLE_ERP_UNIT .'.LABEL AS UNIT_LABEL
										FROM `'. TABLE_ERP_NOMENCLATURE .'`
											LEFT JOIN `'. TABLE_ERP_ARTICLE .'` ON `'. TABLE_ERP_NOMENCLATURE .'`.`ARTICLE_ID` = `'. TABLE_ERP_ARTICLE .'`.`id`
											LEFT JOIN `'. TABLE_ERP_UNIT .'` ON `'. TABLE_ERP_NOMENCLATURE .'`.`UNIT_ID` = `'. TABLE_ERP_UNIT .'`.`id`
										WHERE '. TABLE_ERP_NOMENCLATURE .'.PARENT_ID = '. $ArticleId .'
											ORDER BY '. TABLE_ERP_NOMENCLATURE .'.ORDRE');

		while ($donnees_Nomencl = $req->fetch())
		{
			 $Nomenclature .= '

					<tr>
						<td></td>
						<td>
							<input type="hidden" name="UpdateIdNomencl[]" id="UpdateIdNomencl" value="'. $donnees_Nomencl['Id'] .'">
							<input type="number" name="UpdateORDRENomencl[]" value="'. $donnees_Nomencl['ORDRE'] .'" required="required">
						</td>
						<td>
							<input type="hidden" name="UpdateARTICLENomencl[]" value="'. $donnees_Nomencl['ARTICLE_ID'] .'">
							'. $donnees_Nomencl['ARTICLE_LABEL'] .'
						</td>
						<td><input type="text"  name="UpdateLABELNomencl[]" value="'. $donnees_Nomencl['LABEL'] .'" required="required"></td>
						<td><input type="number"  name="UpdateQTNomencl[]" value="'. $donnees_Nomencl['QT'] .'" step=".001" required="required"></td>
						<td>
							<select name="UpdateUNITNomencl[]">
								<option value="'. $donnees_Nomencl['UNIT_ID'] .'" '. selected($donnees_Nomencl['UNIT_ID'], $donnees_Nomencl['UNIT_ID']) .'>'. $donnees_Nomencl['UNIT_LABEL'] .'</option>
								'. $UnitListeInit .'
							</select>
						</td>
						<td><input type="number"  name="UpdatePRIXUNomencl[]" value="'. $donnees_Nomencl['PRIX_U'] .'" step=".001" required="required"></td>
						<td><input type="number"  name="UpdatePRIXACHATNomencl[]" value="'. $donnees_Nomencl['PRIX_ACHAT'] .'" step=".001" required="required"></td>
					</tr>';

			$iNomencl++;
		}

		if($iNomencl>=1){
			$iNomencl = "(". $iNomencl .")";
		}
		else{
			$iNomencl= "";
		}
	}

	///////////////////////////////
	//// SOUS-ENSEMBLE ////
	///////////////////////////////

	if(isset($_POST['AddORDRESousEns']) AND !empty($_POST['AddORDRESousEns'])){

		$req = $bdd->exec("INSERT INTO ". TABLE_ERP_SOUS_ENSEMBLE ." VALUE ('0',
																		'". addslashes($ArticleId) ."',
																		'". addslashes($_POST['AddORDRESousEns']) ."',
																		'". addslashes($_POST['AddARTICLESousEns']) ."',
																		'". addslashes($_POST['AddQTSousEns']) ."')");

	}

	if(isset($_POST['UpdateIdSousEns']) AND !empty($_POST['UpdateIdSousEns'])){

		$UpdateIdSousEns = $_POST['UpdateIdSousEns'];
		$UpdateORDRESousEns = $_POST['UpdateORDRESousEns'];
		$UpdateARTICLESousEns = $_POST['UpdateARTICLESousEns'];
		$UpdateQTSousEns = $_POST['UpdateQTSousEns'];

		$i = 0;
		foreach ($UpdateIdSousEns as $id_generation) {

			$bdd->exec('UPDATE `'. TABLE_ERP_SOUS_ENSEMBLE .'` SET  ORDRE = \''. addslashes($UpdateORDRESousEns[$i]) .'\',
																	ARTICLE_ID = \''. addslashes($UpdateARTICLESousEns[$i]) .'\',
																	QT = \''. addslashes($UpdateQTSousEns[$i]) .'\'
																	WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
	}

	if(isset($_POST['CODEAtricle']) AND isset($_POST['LABELAtricle']) AND !empty($_POST['CODEAtricle']) AND !empty($_POST['LABELAtricle']) OR  isset($_GET['id']) AND !empty($_GET['id'])){
		$iSousEns = 0;

		$req = $bdd -> query('SELECT '. TABLE_ERP_SOUS_ENSEMBLE .'.Id,
										'. TABLE_ERP_SOUS_ENSEMBLE .'.PARENT_ID,
										'. TABLE_ERP_SOUS_ENSEMBLE .'.ORDRE,
										'. TABLE_ERP_SOUS_ENSEMBLE .'.ARTICLE_ID,
										'. TABLE_ERP_SOUS_ENSEMBLE .'.QT,
										'. TABLE_ERP_ARTICLE .'.LABEL AS LABEL_ARTICLE
										FROM `'. TABLE_ERP_SOUS_ENSEMBLE .'`
											LEFT JOIN `'. TABLE_ERP_ARTICLE .'` ON `'. TABLE_ERP_SOUS_ENSEMBLE .'`.`ARTICLE_ID` = `'. TABLE_ERP_ARTICLE .'`.`id`
										WHERE '. TABLE_ERP_SOUS_ENSEMBLE .'.PARENT_ID = '. $ArticleId .'
											ORDER BY '. TABLE_ERP_SOUS_ENSEMBLE .'.ORDRE');

		while ($donnees_SousEns = $req->fetch())
		{
			 $SousEnsemble .= '
					<tr>
						<td><input type="hidden" name="UpdateIdSousEns[]" id="UpdateIdSousEns" value="'. $donnees_SousEns['Id'] .'"></td>
						<td><input type="number" name="UpdateORDRESousEns[]" value="'. $donnees_SousEns['ORDRE'] .'"></td>
						<td>
							<select name="UpdateARTICLESousEns[]">
								<option value="'. $donnees_SousEns['ARTICLE_ID'] .'" '. selected($donnees_SousEns['ARTICLE_ID'], $donnees_SousEns['ARTICLE_ID']) .'>'. $donnees_SousEns['LABEL_ARTICLE'] .'</option>
								'. $FormListeArticle .'
							</select>
						</td>
						<td><input type="number"  name="UpdateQTSousEns[]" value="'. $donnees_SousEns['QT'] .'" step=".001"></td>
						<td><a href="etudes.php?id='. $donnees_SousEns['LABEL_ARTICLE'] .'">--></a></td>
					</tr>';

			$iSousEns++;
		}

		if($iSousEns>=1){
			$iSousEns = "(". $iSousEns .")";
		}
		else{
			$iSousEns= "";
		}
	}

	///////////////////////////////
	//// IMPUTATION ////
	///////////////////////////////
	$req = $bdd -> query('SELECT '. TABLE_ERP_IMPUT_COMPTA .'.Id,
									'. TABLE_ERP_IMPUT_COMPTA .'.CODE,
									'. TABLE_ERP_IMPUT_COMPTA .'.LABEL
									FROM `'. TABLE_ERP_IMPUT_COMPTA .'`
									ORDER BY Id');

	while ($donnees_IMPUT = $req->fetch())
	{
		$ListeImput .='<option value="'. $donnees_IMPUT['Id'] .'">'. $donnees_IMPUT['CODE'] .' - '. $donnees_IMPUT['LABEL'] .'</option>';
	}

	if(isset($_POST['AddORDREImputation']) AND !empty($_POST['AddORDREImputation'])){

		$req = $bdd->exec("INSERT INTO ". TABLE_ERP_IMPUT_COMPTA_LIGNE ." VALUE ('0',
																		'". addslashes($_POST['IDArticle']) ."',
																		'". addslashes($_POST['AddORDREImputation']) ."',
																		'". addslashes($_POST['AddIdImpuration']) ."')");

	}

	if(isset($_POST['UpdateIdImputationLigne']) AND !empty($_POST['UpdateIdImputationLigne'])){

		$UpdateIdImputationLigne = $_POST['UpdateIdImputationLigne'];
		$UpdateORDREImputation = $_POST['UpdateORDREImputation'];
		$UpdateIdImpuration = $_POST['UpdateIdImpuration'];

		$i = 0;
		foreach ($UpdateIdImputationLigne as $id_generation) {

			$bdd->exec('UPDATE `'. TABLE_ERP_IMPUT_COMPTA_LIGNE .'` SET  ORDRE = \''. addslashes($UpdateORDREImputation[$i]) .'\',
																IMPUTATION_ID = \''. addslashes($UpdateIdImpuration[$i]) .'\'
																WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
	}

	if(isset($_GET['id']) AND !empty($_GET['id'])){

		$req = $bdd -> query('SELECT '. TABLE_ERP_IMPUT_COMPTA_LIGNE .'.Id,
										'. TABLE_ERP_IMPUT_COMPTA_LIGNE .'.ORDRE,
										'. TABLE_ERP_IMPUT_COMPTA_LIGNE .'.IMPUTATION_ID,
										'. TABLE_ERP_IMPUT_COMPTA .'.CODE AS CODE_IMPUTATION,
										'. TABLE_ERP_IMPUT_COMPTA .'.LABEL AS LABEL_IMPUTATION,
										'. TABLE_ERP_IMPUT_COMPTA .'.TYPE_IMPUTATION,
										'. TABLE_ERP_TVA .'.LABEL AS LABEL_TVA
										FROM `'. TABLE_ERP_IMPUT_COMPTA_LIGNE .'`
											LEFT JOIN `'. TABLE_ERP_IMPUT_COMPTA .'` ON `'. TABLE_ERP_IMPUT_COMPTA_LIGNE .'`.`IMPUTATION_ID` = `'. TABLE_ERP_IMPUT_COMPTA .'`.`ID`
											LEFT JOIN `'. TABLE_ERP_TVA .'` ON `'. TABLE_ERP_IMPUT_COMPTA .'`.`TVA` = `'. TABLE_ERP_TVA .'`.`ID`
										WHERE '. TABLE_ERP_IMPUT_COMPTA_LIGNE .'.ARTICLE_ID = '. $ArticleId .'
											ORDER BY '. TABLE_ERP_IMPUT_COMPTA_LIGNE .'.ORDRE');

		while ($donnees_Imput = $req->fetch())
		{
			if($donnees_Imput['TYPE_IMPUTATION'] == 1) $TypeImputation = "Achat";
			if($donnees_Imput['TYPE_IMPUTATION'] == 2) $TypeImputation = "Achat (stock)";
			if($donnees_Imput['TYPE_IMPUTATION'] == 3) $TypeImputation = "Acompte";
			if($donnees_Imput['TYPE_IMPUTATION'] == 4) $TypeImputation = "Acompte (avec TVA)";
			if($donnees_Imput['TYPE_IMPUTATION'] == 5) $TypeImputation = "Autre";
			if($donnees_Imput['TYPE_IMPUTATION'] == 6) $TypeImputation = "TVA";

			 $donnees_ImputCompta .= '

					<tr>
						<td>
							<input type="hidden" name="UpdateIdImputationLigne[]" id="UpdateIdImputationLigne" value="'. $donnees_Imput['Id'] .'">
						</td>
						<td>

							<input type="number" name="UpdateORDREImputation[]" value="'. $donnees_Imput['ORDRE'] .'">
						</td>
						<td>
							<select name="UpdateIdImpuration[]">
								<option value="'. $donnees_Imput['IMPUTATION_ID'] .'"  '. selected( $donnees_Imput['IMPUTATION_ID'] , $donnees_Imput['IMPUTATION_ID']) .'>'. $donnees_Imput['CODE_IMPUTATION'] .' - '. $donnees_Imput['LABEL_IMPUTATION'] .'</option>
								'. $ListeImput .'
							</select>
						</td>
						<td>'. $donnees_Imput['LABEL_TVA'] .'</td>
						<td>'. $TypeImputation .'</td>
					</tr>';

		}
	}

	///////////////
	//// UNITS ////
	///////////////

	if(isset($_POST['AddCODEUnit']) AND !empty($_POST['AddCODEUnit'])){

		$req = $bdd->exec("INSERT INTO ". TABLE_ERP_UNIT ." VALUE ('0',
																		'". addslashes($_POST['AddCODEUnit']) ."',
																		'". addslashes($_POST['AddLABELUnit']) ."',
																		'". addslashes($_POST['AddTYPEUnit']) ."')");

	}

	if(isset($_POST['id_unit']) AND !empty($_POST['id_unit'])){

		$UpdateIdUnit = $_POST['id_unit'];
		$UpdateCODEUnit = $_POST['UpdateCODEUnit'];
		$UpdateLABELUnit = $_POST['UpdateLABELUnit'];
		$UpdateTYPEUnit = $_POST['UpdateTYPEUnit'];

		$i = 0;
		foreach ($UpdateIdUnit as $id_generation) {

			$bdd->exec('UPDATE `'. TABLE_ERP_UNIT .'` SET  CODE = \''. addslashes($UpdateCODEUnit[$i]) .'\',
																LABEL = \''. addslashes($UpdateLABELUnit[$i]) .'\',
																TYPE = \''. addslashes($UpdateTYPEUnit[$i]) .'\'
																WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
	}

	$i = 1;
	$req = $bdd -> query('SELECT '. TABLE_ERP_UNIT .'.Id,
									'. TABLE_ERP_UNIT .'.CODE,
									'. TABLE_ERP_UNIT .'.LABEL,
									'. TABLE_ERP_UNIT .'.TYPE
									FROM `'. TABLE_ERP_UNIT .'`
									ORDER BY TYPE');

	while ($donnees_unit = $req->fetch()){
		 $contenu2 = $contenu2 .'
				<tr>
					<td>'. $i .' <input type="hidden" name="id_unit[]" id="id_unit" value="'. $donnees_unit['Id'] .'"></td>
					<td><input type="text" name="UpdateCODEUnit[]" value="'. $donnees_unit['CODE'] .'" size="10"></td>
					<td><input type="text" name="UpdateLABELUnit[]" value="'. $donnees_unit['LABEL'] .'" ></td>
					<td>
						<select name="UpdateTYPEUnit[]">
							<option value="1" '. selected($donnees_unit['TYPE'], 1) .'>Masse</option>
							<option value="2" '. selected($donnees_unit['TYPE'], 2) .'>Longueur</option>
							<option value="3" '. selected($donnees_unit['TYPE'], 3) .'>Surface</option>
							<option value="4" '. selected($donnees_unit['TYPE'], 4) .'>Volume</option>
							<option value="5" '. selected($donnees_unit['TYPE'], 5) .'>Autre</option>
						</select>
					</td>
				</tr>';
		$i++;
	}

	////////////////////////
	////  SOUS-FAMILLE  ////
	///////////////////////

	$i = 1;
	$req = $bdd -> query('SELECT '. TABLE_ERP_PRESTATION .'.Id,
									'. TABLE_ERP_PRESTATION .'.CODE,
									'. TABLE_ERP_PRESTATION .'.LABEL
									FROM `'. TABLE_ERP_PRESTATION .'`
									ORDER BY ORDRE');


	while ($donnees_presta = $req->fetch()){
		$SectionListe .='<option value="'. $donnees_presta['Id'] .'">'. $donnees_presta['CODE'] .' - '. $donnees_presta['LABEL'] .'</option>';
	}

	if(isset($_POST['AddCODESousFamille']) AND !empty($_POST['AddCODESousFamille'])){

		$req = $bdd->exec("INSERT INTO ". TABLE_ERP_SOUS_FAMILLE ." VALUE ('0',
																		'". addslashes($_POST['AddCODESousFamille']) ."',
																		'". addslashes($_POST['AddLABELSousFamille']) ."',
																		'". addslashes($_POST['AddRESSOURCESousFamille']) ."')");
	}

	if(isset($_POST['id_sous_famille']) AND !empty($_POST['id_sous_famille'])){

		$UpdateIdSousFamille = $_POST['id_sous_famille'];
		$UpdateCODESousFamille = $_POST['UpdateCODESousFamille'];
		$UpdateLABELSousFamille = $_POST['UpdateLABELSousFamille'];
		$AddTRESSOURCESousFamille = $_POST['AddTRESSOURCESousFamille'];

		$i = 0;
		foreach ($UpdateIdSousFamille as $id_generation) {

			$bdd->exec('UPDATE `'. TABLE_ERP_SOUS_FAMILLE .'` SET  CODE = \''. addslashes($UpdateCODESousFamille[$i]) .'\',
																LABEL = \''. addslashes($UpdateLABELSousFamille[$i]) .'\',
																PRESTATION_ID = \''. addslashes($AddTRESSOURCESousFamille[$i]) .'\'
																WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
	}

	$i = 1;
	$req = $bdd -> query('SELECT '. TABLE_ERP_SOUS_FAMILLE .'.Id,
									'. TABLE_ERP_SOUS_FAMILLE .'.CODE,
									'. TABLE_ERP_SOUS_FAMILLE .'.LABEL,
									'. TABLE_ERP_SOUS_FAMILLE .'.PRESTATION_ID,
									'. TABLE_ERP_PRESTATION .'.CODE AS CODE_PRESTATION,
									'. TABLE_ERP_PRESTATION .'.LABEL AS LABEL_PRESTATION
									FROM `'. TABLE_ERP_SOUS_FAMILLE .'`
									LEFT JOIN `'. TABLE_ERP_PRESTATION .'` ON `'. TABLE_ERP_SOUS_FAMILLE .'`.`PRESTATION_ID` = `'. TABLE_ERP_PRESTATION .'`.`id`
									ORDER BY Id');

	while ($donnees_id_sous_famille = $req->fetch()){
		 $contenu3 = $contenu3 .'
				<tr>
					<td>'. $i .' <input type="hidden" name="id_sous_famille[]" id="id_sous_famille" value="'. $donnees_id_sous_famille['Id'] .'"></td>
					<td><input type="text" name="UpdateCODESousFamille[]" value="'. $donnees_id_sous_famille['CODE'] .'" size="10"></td>
					<td><input type="text" name="UpdateLABELSousFamille[]" value="'. $donnees_id_sous_famille['LABEL'] .'" ></td>
					<td>
						<select name="AddTRESSOURCESousFamille[]">
							<option value="'. $donnees_id_sous_famille['PRESTATION_ID'] .'">'. $donnees_id_sous_famille['CODE_PRESTATION'] .' - '. $donnees_id_sous_famille['LABEL_PRESTATION'] .'</option>
							'. $SectionListe .'
						</select>
					</td>
				</tr>';
		$i++;
	}
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
		<button class="tablinks" onclick="openDiv(event, 'div1')" id="defaultOpen"><?php echo $titleOnglet1; ?></button>
<?php
	if(isset($_POST['CODEAtricle']) AND isset($_POST['LABELAtricle']) AND !empty($_POST['CODEAtricle']) AND !empty($_POST['LABELAtricle']) OR  isset($_GET['id']) AND !empty($_GET['id'])){
?>
		<button class="tablinks" onclick="openDiv(event, 'div2')" >Découpage technique <?php echo $iDecoupTech; ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div3')">Nomenclature  <?php echo $iNomencl; ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div4')">Sous-ensembles  <?php echo $iSousEns; ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div5')">Achat </button>
		<button class="tablinks" onclick="openDiv(event, 'div6')">Vente </button>
		<button class="tablinks" onclick="openDiv(event, 'div7')">Imputations comptables </button>
		<button class="tablinks" onclick="openDiv(event, 'div8')">Commentaire </button>
<?php
	}
	?>
		<button class="tablinks" onclick="openDiv(event, 'div9')" >Unités</button>
		<button class="tablinks" onclick="openDiv(event, 'div10')">Sous-Famille</button>
		<div class="DataListDroite">
			<form method="get" name="article" action="<?php echo $actionForm; ?>">
				Liste Article : <input list="article" name="id" id="id" placeholder="Ex: Platine" >
				<datalist id="article">
					<?php echo $ListeArticle; ?>
				</datalist>
				<input type="submit" class="input-moyen" value="Go !" />
			</form>
		</div>
	</div>
	<div id="div1" class="tabcontent" >
		<form method="post" name="Company" action="etudes.php" class="content-form" enctype="multipart/form-data" >
				<table class="content-table">
					<thead>
						<tr>
							<th colspan="5">
								  <br/>
							</th>
							<th>

							</th>
						</tr>
					</thead>
					<tbody>
<?php

								Echo $contenu1;
?>
						<tr>
							<td colspan="6" >
								<br/>
								<input type="submit" class="input-moyen" value="Mettre à jour" /> <br/>
								<br/>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
	</div>
<?php
	if(isset($_POST['CODEAtricle']) AND isset($_POST['LABELAtricle']) AND !empty($_POST['CODEAtricle']) AND !empty($_POST['LABELAtricle']) OR  isset($_GET['id']) AND !empty($_GET['id']))
	{
?>
	<div id="div2" class="tabcontent" >
		<form method="post" name="DecoupageTechnique" action="<?php echo $actionForm; ?>" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th>ORDRE</th>
							<th>Prestation</th>
							<th>Libellé</th>
							<th>Tps préaparation</th>
							<th>Tps de production</th>
							<th>Coût de production</th>
							<th>Prix de vente</th>
						</tr>
					</thead>
					<tbody>
							<?php

								Echo $DecoupageTechnique;
							?>
						<tr>
							<td>Ajout</td>
							<td><input type="number" name="AddORDREDecoupTech" ></td>
							<td>
								<select name="AddPRESTADecoupTech">
									<?php echo $PrestaListe; ?>
								</select>
							</td>
							<td><input type="text"  name="AddLABELDecoupTech" required="required"></td>
							<td><input type="number"  name="AddTPSPREPDecoupTech" step=".001" required="required"></td>
							<td><input type="number"  name="AddTPSPRODDecoupTech" step=".001" required="required"></td>
							<td><input type="number"  name="AddCOUTDecoupTech" step=".001" required="required"></td>
							<td><input type="number"  name="AddPRIXDecoupTech" step=".001" required="required"></td>
						</tr>
						<tr>
							<td colspan="8" >
								<br/>
								<input type="submit" class="input-moyen" value="Mettre à jour" /> <br/>
								<br/>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
	</div>
	<div id="div3" class="tabcontent" >
		<form method="post" name="Nomenclature" action="<?php echo $actionForm; ?>" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th>ORDRE</th>
							<th>Article</th>
							<th>Libellé</th>
							<th>Qté</th>
							<th>Unité</th>
							<th>Prix U</th>
							<th>Prix achat</th>
						</tr>
					</thead>
					<tbody>
							<?php

								Echo $Nomenclature;
							?>
						<tr>
							<td>Ajout</td>
							<td><input type="number" name="AddORDRENomencl" required="required"></td>
							<td>
								<select name="AddARTICLENomencl">
									<?php echo $FormListeArticle; ?>
								</select>
							</td>
							<td><input type="text"  name="AddLABELNomencl" required="required"></td>
							<td><input type="number"  name="AddQTNomencl" step=".001" required="required"></td>
							<td>
								<select name="AddTUNITNomencl">
									<?php echo $UnitListe; ?>
								</select>
							</td>
							<td><input type="number"  name="AddPRIXUNomencl" step=".001" required="required"></td>
							<td><input type="number"  name="AddPRIXACHATNomencl" step=".001" required="required"></td>
						</tr>
						<tr>
							<td colspan="8" >
								<br/>
								<input type="submit" class="input-moyen" value="Mettre à jour" /> <br/>
								<br/>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
	</div>
	<div id="div4" class="tabcontent" >
		<form method="post" name="SousEnsemble" action="<?php echo $actionForm; ?>" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th>ORDRE</th>
							<th>Article</th>
							<th>Qté</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
							<?php

								Echo $SousEnsemble;
							?>
						<tr>
							<td>Ajout</td>
							<td><input type="number" name="AddORDRESousEns" ></td>
							<td>
								<select name="AddARTICLESousEns">
									<?php echo $FormListeArticle; ?>
								</select>
							</td>
							<td><input type="number"  name="AddQTSousEns" step=".001"></td>
							<td></td>
						</tr>
						<tr>
							<td colspan="5" >
								<br/>
								<input type="submit" class="input-moyen" value="Mettre à jour" /> <br/>
								<br/>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
	</div>
	<div id="div5" class="tabcontent" >
	</div>
	<div id="div6" class="tabcontent" >
	</div>
	<div id="div7" class="tabcontent" >
		<form method="post" name="Imputations" action="<?php echo $actionForm; ?>" class="content-form" >
			<table class="content-table" style="width: 50%;">
				<thead>
					<tr>
						<th></th>
						<th>Ordre</th>
						<th>Imputation comptable</th>
						<th>T.V.A.</th>
						<th></th>
					</tr>
				</thead>
							<?php

								Echo $donnees_ImputCompta;
							?>
					<tr>
						<td>
							Ajout
							<input type="hidden" name="IDArticle" value="<?php echo $ArticleId ?>">
						</td>
						<td><input type="number" name="AddORDREImputation" ></td>
						<td>
							<select name="AddIdImpuration">
								<?php echo $ListeImput; ?>
							</select>
						</td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td colspan="5" >
							<input type="submit" class="input-moyen" value="Mettre à jour" />
						</td>
					</tr>
				</tbody>
			</table>
		</form>

	</div>
	<div id="div8" class="tabcontent" >
		<form method="post" name="Coment" action="<?php echo $actionForm; ?>" class="content-form" >
			<table class="content-table" style="width: 50%;">
				<thead>
					<tr>
						<th>Commentaire</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<input type="hidden" name="IDArticle" value="<?php echo $ArticleId ?>">
							<textarea class="Comment" name="Comment" rows="40" ><?php echo $ArticleComment ?></textarea>
						</td>
					</tr>
					<tr>
						<td>
							<input type="submit" class="input-moyen" value="Mettre à jour" />
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
<?php
	}
	?>
	<div id="div9" class="tabcontent" >
			<form method="post" name="Section" action="etudes.php" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th>CODE</th>
							<th>Libellé</th>
							<th>Type</th>
						</tr>
					</thead>
					<tbody>
							<?php

								Echo $contenu2;
							?>
						<tr>
							<td>Ajout</td>
							<td><input type="text" class="input-moyen-vide" name="AddCODEUnit" required="required"></td>
							<td><input type="text" class="input-moyen-vide" name="AddLABELUnit" required="required"></td>
							<td>
								<select name="AddTYPEUnit">
									<option value="1">Masse</option>
									<option value="2">Longueur</option>
									<option value="3">Surface</option>
									<option value="4">Volume</option>
									<option value="5">Autre</option>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="4" >
								<br/>
								<input type="submit" class="input-moyen" value="Mettre à jour" /> <br/>
								<br/>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
	</div>
	<div id="div10" class="tabcontent" >
			<form method="post" name="Section" action="etudes.php" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th>CODE</th>
							<th>Libellé</th>
							<th>Prestation</th>
						</tr>
					</thead>
					<tbody>
							<?php

								Echo $contenu3;
							?>
						<tr>
							<td>Ajout</td>
							<td><input type="text" class="input-moyen-vide" name="AddCODESousFamille" required="required"></td>
							<td><input type="text" class="input-moyen-vide" name="AddLABELSousFamille" required="required"></td>
							<td>
								<select name="AddRESSOURCESousFamille">
									<?php echo $SectionListe ?>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="4" >
								<br/>
								<input type="submit" class="input-moyen" value="Mettre à jour" /> <br/>
								<br/>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>
	</div>


</body>
</html>
