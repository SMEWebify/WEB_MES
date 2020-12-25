<?php 
	//phpinfo();
	use \App\Autoloader;
	use \App\Form;

	//auto load class
	require_once '../app/Autoload.class.php';
	Autoloader::register();
	
	session_start();
	header( 'content-type: text/html; charset=utf-8' );
	//init form class
	$Form = new Form($_POST);

	//Check if the user is authorized to view the page
	if($_SESSION['page_10'] != '1'){
		stop($langue->show_text('SystemInfoAccessDenied'), 161, 'login.php');
	}

	///////////////////////////////
	//// COMMMENT ////
	///////////////////////////////
	//if update comment article
	if(isset($_POST['Comment']) AND !empty($_POST['Comment'])){
		$bdd->GetUpdate("UPDATE  ". TABLE_ERP_ARTICLE ." SET 	COMMENT='". addslashes($_POST['Comment']) ."'
																		WHERE Id='". addslashes($_POST['IDArticle'])."'");
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateCommentNotification')));			
	}

	////////////////////
	////  ARTICLES  ////
	////////////////////

	$titleOnglet1 = $langue->show_text('TableAddArticleButton');
	$actionForm = 'admin.php?page=manage-study&id='. $_POST['id'];

	//if add or update Article
	if(isset($_POST['CODEArticle']) AND isset($_POST['LABELAtricle']) AND !empty($_POST['CODEArticle']) AND !empty($_POST['LABELAtricle']) OR  isset($_GET['id']) AND !empty($_GET['id'])){
		
		//if is a POST
		if(isset($_POST['CODEArticle'])){

			//Check if is existe
			$data=$bdd->GetQuery("SELECT COUNT(ID) as nb FROM ". TABLE_ERP_ARTICLE ." WHERE id = '". addslashes($_POST['IDArticle'])."'", true);
			$nb = $data->nb;

			//if exist
			if($nb>=1){

				$titleOnglet1 = $langue->show_text('TableUpdateButton');

				//if update image
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

				//update article value
				$bdd->GetUpdate("UPDATE  ". TABLE_ERP_ARTICLE ." SET 	LABEL='". addslashes($_POST['LABELAtricle']) ."',
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

				$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateArticleNotification')));

				//select new values													
				$query='SELECT '. TABLE_ERP_ARTICLE .'.ID,
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
									WHERE '. TABLE_ERP_ARTICLE .'.id = '. addslashes($_POST['IDArticle']).'';
			}
			else{

				//if is not exist, we add new entry

				$titleOnglet1 = $langue->show_text('TableUpdateButton');


				$dossier = 'images/ArticlesImage/';
				$fichier = basename($_FILES['FichierImageArticle']['name']);
				move_uploaded_file($_FILES['FichierImageArticle']['tmp_name'], $dossier . $fichier);
				$InsertImage = $dossier.$fichier;

				//insert in db
				$req = $bdd->GetInsert("INSERT INTO ". TABLE_ERP_ARTICLE ." VALUE ('0',
																				'". addslashes($_POST['CODEArticle']) ."',
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

				$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddArticleNotification')));

				//select new values	
				$query='SELECT '. TABLE_ERP_ARTICLE .'.ID,
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
									ORDER BY '. TABLE_ERP_ARTICLE .'.id DESC LIMIT 0, 1';
			}
		}
		else{

			//if is get value article
			$Name = preg_replace('#-+#',' ', addslashes($_GET['id']));

			$titleOnglet1 =  $langue->show_text('TableUpdateButton');

			//select  values	
			$query='SELECT '. TABLE_ERP_ARTICLE .'.ID,
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
									WHERE '. TABLE_ERP_ARTICLE .'.id = \''. $Name.'\'';
		}

		//Assign  values	
		$data = $bdd->GetQuery($query, true);

		$ArticleId = $data->ID;
		$ArticleCODE = $data->CODE;
		$ArticleLabel = $data->LABEL;
		$ArticleInd = $data->IND;
		$ArticlePrestaId = $data->PRESTATION_ID;
		$ArticlePrestaLab = $data->PRESTATION_LABEL;
		$ArticleTYPEPresta = $data->TYPE;
		$ArticleFamilleId = $data->FAMILLE_ID;
		$ArticleFamilleLab = $data->FAMILLE_LABEL;
		$ArticleAcheter = $data->ACHETER;
		$ArticlePrixAch = $data->PRIX_ACHETER;
		$ArticleVendu = $data->VENDU;
		$ArticlePrixVendu = $data->PRIX_VENDU;
		$ArticleUNIT_ID = $data->UNITE_ID;
		$ArticleUNIT = $data->UNIT_LABEL;
		$ArticleMatiere = $data->MATIERE;
		$ArticleEP = $data->EP;
		$ArticleDimX = $data->DIM_X;
		$ArticleDimY = $data->DIM_Y;
		$ArticleDimZ = $data->DIM_Z;
		$ArticlePoids = $data->POIDS;
		$ArticleSurX = $data->SUR_X;
		$ArticleSurY = $data->SUR_Y;
		$ArticleSurZ = $data->SUR_Z;
		$ArticleComment = $data->COMMENT;
		$ArticleImage = $data->IMAGE;

		$actionForm = 'admin.php?page=manage-study&id='. $ArticleId .'';
	}

	//create service list select
	$PrestaListe ='<option value="0">Aucune</option>';
	$query='SELECT Id, LABEL   FROM '. TABLE_ERP_PRESTATION .'';
	foreach ($bdd->GetQuery($query) as $data){
		$PrestaListe .='<option value="'. $data->Id .'" '. selected($ArticlePrestaId, $data->Id) .' >'. $data->LABEL .'</option>';
	}

	//create familly list select
	$FamilleListe ='<option value="0">Aucune</option>';
	$query='SELECT Id, LABEL   FROM '. TABLE_ERP_SOUS_FAMILLE .'';
	foreach ($bdd->GetQuery($query) as $data){
		$FamilleListe .='<option value="'. $data->Id .'" '. selected($ArticleFamilleId, $data->Id) .'>'. $data->LABEL .'</option>';
	}

	//create unit list select
	$UnitListe ='<option value="0">Aucune</option>';
	$UnitListeInit  ='<option value="0">Aucune</option>';
	$query='SELECT Id, LABEL   FROM '. TABLE_ERP_UNIT .'';
	foreach ($bdd->GetQuery($query) as $data){
		$UnitListe .='<option value="'. $data->Id .'" '. selected($ArticleUNIT_ID, $data->Id) .'>'. $data->LABEL .'</option>';
		$UnitListeInit .='<option value="'. $data->Id .'>'. $data->LABEL .'</option>';
	}

	if(!empty($ArticleCODE)){$DisplayCode = '<input type="hidden" name="CODEArticle" value="'. $ArticleCODE .'">' .$ArticleCODE;}
	else{ $DisplayCode ='<input type="text" name="CODEArticle" required="required">'; }

	//create data list article
	$query='SELECT * FROM '. TABLE_ERP_ARTICLE .' ORDER BY LABEL';
	foreach ($bdd->GetQuery($query) as $data){
		$ListeArticle .= '<option  value="'. $data->LABEL .'" >';
		$FormListeArticle .= '<option value="'. $data->id .'" >'. $data->LABEL .'</option>';
	}

	///////////////////////////////
	//// TECHNICAL CUT  ////
	///////////////////////////////

	//if add new technical cut
	if(isset($_POST['AddORDREDecoupTech']) AND !empty($_POST['AddORDREDecoupTech'])){

		$req = $bdd->GetInsert("INSERT INTO ". TABLE_ERP_DEC_TECH ." VALUE ('0',
																		'". addslashes($ArticleId) ."',
																		'". addslashes($_POST['AddORDREDecoupTech']) ."',
																		'". addslashes($_POST['AddPRESTADecoupTech']) ."',
																		'". addslashes($_POST['AddLABELDecoupTech']) ."',
																		'". addslashes($_POST['AddTPSPREPDecoupTech']) ."',
																		'". addslashes($_POST['AddTPSPRODDecoupTech']) ."',
																		'". addslashes($_POST['AddCOUTDecoupTech']) ."',
																		'". addslashes($_POST['AddPRIXDecoupTech']) ."')");
		$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddTechnicalCutNotification')));
	}

	//if update technical cut list
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

			$bdd->GetUpdate('UPDATE `'. TABLE_ERP_DEC_TECH .'` SET  ORDRE = \''. addslashes($UpdateORDREDecoupTech[$i]) .'\',
																PRESTA_ID = \''. addslashes($UpdatePRESTADecoupTech[$i]) .'\',
																LABEL = \''. addslashes($UpdateLABELDecoupTech[$i]) .'\',
																TPS_PREP = \''. addslashes($UpdateTPSPREPDecoupTech[$i]) .'\',
																TPS_PRO = \''. addslashes($UpdateTPSPRODDecoupTech[$i]) .'\',
																COUT = \''. addslashes($UpdateCOUTDecoupTech[$i]) .'\',
																PRIX = \''. addslashes($UpdatePRIXDecoupTech[$i]) .'\'
																WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateTechnicalCutNotification')));
	}

	///////////////////////////////
	//// NOMENCLATURE ////
	///////////////////////////////

	if(isset($_POST['AddORDRENomencl']) AND !empty($_POST['AddORDRENomencl'])){

		$req = $bdd->GetInsert("INSERT INTO ". TABLE_ERP_NOMENCLATURE ." VALUE ('0',
																		'". addslashes($_POST['AddORDRENomencl']) ."',
																		'". addslashes($ArticleId) ."',
																		'". addslashes($_POST['AddARTICLENomencl']) ."',
																		'". addslashes($_POST['AddLABELNomencl']) ."',
																		'". addslashes($_POST['AddQTNomencl']) ."',
																		'". addslashes($_POST['AddTUNITNomencl']) ."',
																		'". addslashes($_POST['AddPRIXUNomencl']) ."',
																		'". addslashes($_POST['AddPRIXACHATNomencl']) ."')");
		$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddNomenclatureNotification')));
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

			$bdd->GetUpdate('UPDATE `'. TABLE_ERP_NOMENCLATURE .'` SET  ORDRE = \''. addslashes($UpdateORDRENomencl[$i]) .'\',
																LABEL = \''. addslashes($UpdateLABELNomencl[$i]) .'\',
																QT = \''. addslashes($UpdateQTNomencl[$i]) .'\',
																UNIT_ID = \''. addslashes($UpdateUNITNomencl[$i]) .'\',
																PRIX_U = \''. addslashes($UpdatePRIXUNomencl[$i]) .'\',
																PRIX_ACHAT = \''. addslashes($UpdatePRIXACHATNomencl[$i]) .'\'
																WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateNomenclatureNotification')));
	}

	///////////////////////////////
	//// SOUS-ENSEMBLE ////
	///////////////////////////////

	if(isset($_POST['AddORDRESousEns']) AND !empty($_POST['AddORDRESousEns'])){

		$req = $bdd->GetInsert("INSERT INTO ". TABLE_ERP_SOUS_ENSEMBLE ." VALUE ('0',
																		'". addslashes($ArticleId) ."',
																		'". addslashes($_POST['AddORDRESousEns']) ."',
																		'". addslashes($_POST['AddARTICLESousEns']) ."',
																		'". addslashes($_POST['AddQTSousEns']) ."')");
		$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddSubFamillyNotification')));
	}

	if(isset($_POST['UpdateIdSousEns']) AND !empty($_POST['UpdateIdSousEns'])){

		$UpdateIdSousEns = $_POST['UpdateIdSousEns'];
		$UpdateORDRESousEns = $_POST['UpdateORDRESousEns'];
		$UpdateARTICLESousEns = $_POST['UpdateARTICLESousEns'];
		$UpdateQTSousEns = $_POST['UpdateQTSousEns'];

		$i = 0;
		foreach ($UpdateIdSousEns as $id_generation) {

			$bdd->GetUpdate('UPDATE `'. TABLE_ERP_SOUS_ENSEMBLE .'` SET  ORDRE = \''. addslashes($UpdateORDRESousEns[$i]) .'\',
																	ARTICLE_ID = \''. addslashes($UpdateARTICLESousEns[$i]) .'\',
																	QT = \''. addslashes($UpdateQTSousEns[$i]) .'\'
																	WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateSubFamillyNotification')));
	}

	///////////////////////////////
	//// IMPUTATION ////
	///////////////////////////////
	$query='SELECT '. TABLE_ERP_IMPUT_COMPTA .'.Id,
									'. TABLE_ERP_IMPUT_COMPTA .'.CODE,
									'. TABLE_ERP_IMPUT_COMPTA .'.LABEL
									FROM `'. TABLE_ERP_IMPUT_COMPTA .'`
									ORDER BY Id';

	foreach ($bdd->GetQuery($query) as $data){
		$ListeImput .='<option value="'. $data->Id .'">'. $data->CODE .' - '. $data->LABEL .'</option>';
	}

	if(isset($_POST['AddORDREImputation']) AND !empty($_POST['AddORDREImputation'])){

		$req = $bdd->GetInsert("INSERT INTO ". TABLE_ERP_IMPUT_COMPTA_LIGNE ." VALUE ('0',
																		'". addslashes($_POST['IDArticle']) ."',
																		'". addslashes($_POST['AddORDREImputation']) ."',
																		'". addslashes($_POST['AddIdImpuration']) ."')");
		$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddAllocationNotification')));
	}

	if(isset($_POST['UpdateIdImputationLigne']) AND !empty($_POST['UpdateIdImputationLigne'])){

		$UpdateIdImputationLigne = $_POST['UpdateIdImputationLigne'];
		$UpdateORDREImputation = $_POST['UpdateORDREImputation'];
		$UpdateIdImpuration = $_POST['UpdateIdImpuration'];

		$i = 0;
		foreach ($UpdateIdImputationLigne as $id_generation) {

			$bdd->GetUpdate('UPDATE `'. TABLE_ERP_IMPUT_COMPTA_LIGNE .'` SET  ORDRE = \''. addslashes($UpdateORDREImputation[$i]) .'\',
																IMPUTATION_ID = \''. addslashes($UpdateIdImpuration[$i]) .'\'
																WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateAllocationNotification')));
	}

	///////////////
	//// UNITS ////
	///////////////

	if(isset($_POST['AddCODEUnit']) AND !empty($_POST['AddCODEUnit'])){
		$req = $bdd->GetInsert("INSERT INTO ". TABLE_ERP_UNIT ." VALUE ('0',
																		'". addslashes($_POST['AddCODEUnit']) ."',
																		'". addslashes($_POST['AddLABELUnit']) ."',
																		'". addslashes($_POST['AddTYPEUnit']) ."')");
		$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddUnitNotification')));
	}

	if(isset($_POST['id_unit']) AND !empty($_POST['id_unit'])){

		$UpdateIdUnit = $_POST['id_unit'];
		$UpdateCODEUnit = $_POST['UpdateCODEUnit'];
		$UpdateLABELUnit = $_POST['UpdateLABELUnit'];
		$UpdateTYPEUnit = $_POST['UpdateTYPEUnit'];

		$i = 0;
		foreach ($UpdateIdUnit as $id_generation) {

			$bdd->GetUpdate('UPDATE `'. TABLE_ERP_UNIT .'` SET  CODE = \''. addslashes($UpdateCODEUnit[$i]) .'\',
																LABEL = \''. addslashes($UpdateLABELUnit[$i]) .'\',
																TYPE = \''. addslashes($UpdateTYPEUnit[$i]) .'\'
																WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateUnitNotification')));
	}

	////////////////////////
	////  SOUS-FAMILLE  ////
	///////////////////////

	$i = 1;
	$query='SELECT '. TABLE_ERP_PRESTATION .'.Id,
									'. TABLE_ERP_PRESTATION .'.CODE,
									'. TABLE_ERP_PRESTATION .'.LABEL
									FROM `'. TABLE_ERP_PRESTATION .'`
									ORDER BY ORDRE';


	foreach ($bdd->GetQuery($query) as $data){
		$SectionListe .='<option value="'. $data->Id .'">'. $data->CODE .' - '. $data->LABEL .'</option>';
	}

	if(isset($_POST['AddCODESousFamille']) AND !empty($_POST['AddCODESousFamille'])){
		$req = $bdd->GetInsert("INSERT INTO ". TABLE_ERP_SOUS_FAMILLE ." VALUE ('0',
																		'". addslashes($_POST['AddCODESousFamille']) ."',
																		'". addslashes($_POST['AddLABELSousFamille']) ."',
																		'". addslashes($_POST['AddRESSOURCESousFamille']) ."')");
		$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddFamillyNotification')));
	}

	if(isset($_POST['id_sous_famille']) AND !empty($_POST['id_sous_famille'])){
		$UpdateIdSousFamille = $_POST['id_sous_famille'];
		$UpdateCODESousFamille = $_POST['UpdateCODESousFamille'];
		$UpdateLABELSousFamille = $_POST['UpdateLABELSousFamille'];
		$AddTRESSOURCESousFamille = $_POST['AddTRESSOURCESousFamille'];

		$i = 0;
		foreach ($UpdateIdSousFamille as $id_generation) {

			$bdd->GetUpdate('UPDATE `'. TABLE_ERP_SOUS_FAMILLE .'` SET  CODE = \''. addslashes($UpdateCODESousFamille[$i]) .'\',
																LABEL = \''. addslashes($UpdateLABELSousFamille[$i]) .'\',
																PRESTATION_ID = \''. addslashes($AddTRESSOURCESousFamille[$i]) .'\'
																WHERE Id IN ('. $id_generation . ')');
			$i++;
		}
		$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateFamillyNotification')));
	}


?>
	<div class="tab">
		<button class="tablinks" onclick="openDiv(event, 'div1')" id="defaultOpen"><?=$titleOnglet1; ?></button>
<?php
	if(isset($_POST['CODEArticle']) AND isset($_POST['LABELAtricle']) AND !empty($_POST['CODEArticle']) AND !empty($_POST['LABELAtricle']) OR  isset($_GET['id']) AND !empty($_GET['id'])){
	?>
		<button class="tablinks" onclick="openDiv(event, 'div2')"><?=$langue->show_text('Title2'); ?> <?=$iDecoupTech; ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div3')"><?=$langue->show_text('Title3'); ?> <?=$iNomencl; ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div4')"><?=$langue->show_text('Title4'); ?> <?=$iSousEns; ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div5')"><?=$langue->show_text('Title5'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div6')"><?=$langue->show_text('Title6'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div7')"><?=$langue->show_text('Title7'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div8')"><?=$langue->show_text('Title8'); ?></button>
	<?php
	}
	?>
		<button class="tablinks" onclick="openDiv(event, 'div9')" ><?= $langue->show_text('Title9'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div10')"><?= $langue->show_text('Title10'); ?></button>
	</div>
	<div id="div1" class="tabcontent" >
		<div class="column">
			<input type="text" id="myInput" onkeyup="myFunction()" placeholder="<?=$langue->show_text('FindArticle'); ?>">
			<ul id="myUL">
				<?php
				//generate list for datalist find input
				$query="SELECT id, CODE, LABEL FROM ". TABLE_ERP_ARTICLE ." ORDER BY LABEL";
				foreach ($bdd->GetQuery($query) as $data): ?>
				<li><a href="admin.php?page=manage-study&id=<?= $data->id ?>"><?= $data->CODE ?> - <?= $data->LABEL ?></a></li>
				<?php $i++; endforeach; ?>
			</ul>
		</div>
		<form method="post" name="Company" action="admin.php?page=manage-study" class="content-form" enctype="multipart/form-data" >
				<table class="content-table">
					<thead>
						<tr>
							<th colspan="6">
								  <br/>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><?= $langue->show_text('TableCODE') ?></td>
							<td><?= $langue->show_text('TableLabel') ?></td>
							<td><?= $langue->show_text('Tableindex') ?></td>
							<td><?= $langue->show_text('TableService') ?></td>
							<td><?= $langue->show_text('TableFamilly') ?></td>
							<td><?= $langue->show_text('TableType') ?></td>
						</tr>
						<tr>
							<td >
								<input type="hidden" name="IDArticle" value="<?= $ArticleId ?>">
								<?= $DisplayCode ?>
							</td>
							<td >
								<input type="text" name="LABELAtricle" value="<?= $ArticleLabel ?>" >
							</td>
							<td >
								<input type="text" name="INDArticle" value="<?= $ArticleInd ?>" size="10">
							</td>
							<td >
								<select name="PRESTA_IDAtricle">
									<?= $PrestaListe ?>
								</select>
							</td>
							<td >
								<select name="FAMILLE_IDArticle">
									<?= $FamilleListe ?>
								</select>
							</td>
							<td>
								<select name="">
									<option value="1" <?= selected($ArticleTYPEPresta, 1) ?> ><?= $langue->show_text('SelectProductive') ?></option>
									<option value="2" <?= selected($ArticleTYPEPresta, 2) ?> ><?= $langue->show_text('SelectRawMat') ?></option>
									<option value="3" <?= selected($ArticleTYPEPresta, 3) ?> ><?= $langue->show_text('SelectRawMatSheet') ?></option>
									<option value="4" <?= selected($ArticleTYPEPresta, 4) ?> ><?= $langue->show_text('SelectRawMatProfil') ?></option>
									<option value="5" <?= selected($ArticleTYPEPresta, 5) ?> ><?= $langue->show_text('SelectRawMatBlock') ?></option>
									<option value="6" <?= selected($ArticleTYPEPresta, 6) ?> ><?= $langue->show_text('SelectSupplies') ?></option>
									<option value="7" <?= selected($ArticleTYPEPresta, 7) ?> ><?= $langue->show_text('SelectSubcontracting') ?></option>
									<option value="8" <?= selected($ArticleTYPEPresta, 8) ?> ><?= $langue->show_text('SelectCompoundItem') ?></option>
								</select>
							</td>
						</tr>
						<tr>
							<td><?= $langue->show_text('TableBuy') ?></td>
							<td><?= $langue->show_text('TablePurchaseUnit') ?></td>
							<td><?= $langue->show_text('TableSold') ?></td>
							<td><?= $langue->show_text('TableSalePrice') ?></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td >
								<select name="ACHETERArticle">
									<option value="0" <?= selected($ArticleAcheter, 0) ?>><?= $langue->show_text('No') ?></option>
									<option value="1" <?= selected($ArticleAcheter, 1) ?>><?= $langue->show_text('Yes') ?></option>
								</select>
							</td>
							<td >
								<input type="number" name="PRIXACHArticle" value="<?= $ArticlePrixAch ?>" step=".001" required="required">
							</td>
							<td >
								<select name="VENDUArticle">
									<option value="0" <?= selected($ArticleVendu, 0) ?>><?= $langue->show_text('No') ?></option>
									<option value="1" <?= selected($ArticleVendu, 1) ?>><?= $langue->show_text('Yes') ?></option>
								</select>
							</td>
							</td>
							<td >
								<input type="number" name="PRIXVENArticle" value="<?= $ArticlePrixVendu ?>" step=".001" required="required">
							</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td><?= $langue->show_text('TableUnit') ?></td>
							<td><?= $langue->show_text('TableMaterial') ?></td>
							<td><?= $langue->show_text('TableThickness') ?></td>
							<td><?= $langue->show_text('TableWeight') ?></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td >
								<select name="UNITArticle">
									<?= $UnitListe ?>
								</select>
							</td>
							<td >
								<input type="text" name="MATIEREArticle" value="<?= $ArticleMatiere ?>" size="10">
							</td>
							<td >
								<input type="number" name="EPArticle" value="<?= $ArticleEP ?>" size="10" step=".001" required="required">
							</td>
							<td >
								<input type="number" name="POIRDSArticle" value="<?= $ArticlePoids ?>" size="10" step=".001" required="required">
							</td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td><?= $langue->show_text('TableDimX') ?></td>
							<td><?= $langue->show_text('TableDimY') ?></td>
							<td><?= $langue->show_text('TableDimZ') ?></td>
							<td><?= $langue->show_text('TableSurDimX') ?></td>
							<td><?= $langue->show_text('TableSurDimY') ?></td>
							<td><?= $langue->show_text('TableSurDimZ') ?></td>
						</tr>
						<tr>
							<td >
								<input type="number" name="DIMXArticle" value="<?= $ArticleDimX ?>" required="required">
							</td>
							<td >
								<input type="number" name="DIMYArticle" value="<?= $ArticleDimY ?>" size="10" required="required">
							</td>
							<td >
								<input type="number" name="DIMZArticle" value="<?= $ArticleDimZ ?>" required="required">
							</td>
							<td >
								<input type="number" name="SURDIMXArticle" value="<?= $ArticleSurX ?>" size="10" required="required">
							</td>
							<td>
								<input type="number" name="SURDIMYArticle" value="<?= $ArticleSurY ?>" required="required">
							</td>
							<td>
								<input type="number" name="SURDIMZArticle" value="<?= $ArticleSurZ ?>" size="10" required="required">
							</td>
						</tr>
						<tr>
							<td colspan=6"><?= $langue->show_text('TablePicture') ?></td>
						</tr>
						<tr>
							<td colspan=6" ><input type="file" name="FichierImageArticle" /></td>
						</tr>
						<tr>
							<td colspan=6"><img src="<?= $ArticleImage ?>" title="Image article" alt="Article" style="width: 400px;"/></td>
						</tr>
						<tr>
							<td colspan="6" >
								<br/>
								<?= $Form->submit($langue->show_text('TableUpdateButton')) ?> <br/>
								<br/>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
	</div>
<?php
	if(isset($_POST['CODEArticle']) AND isset($_POST['LABELAtricle']) AND !empty($_POST['CODEArticle']) AND !empty($_POST['LABELAtricle']) OR  isset($_GET['id']) AND !empty($_GET['id']))
	{
		?>
		<div id="div2" class="tabcontent" >
			<form method="post" name="DecoupageTechnique" action="<?=$actionForm; ?>" class="content-form" >
					<table class="content-table">
						<thead>
							<tr>
								<th></th>
								<th><?=$langue->show_text('TableOrder'); ?></th>
								<th><?=$langue->show_text('TableService'); ?></th>
								<th><?=$langue->show_text('TableLabel'); ?></th>
								<th><?=$langue->show_text('TableSettingTime'); ?></th>
								<th><?=$langue->show_text('TableProductTime'); ?></th>
								<th><?=$langue->show_text('TableProductCost'); ?></th>
								<th><?=$langue->show_text('TableSalePrice'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$iDecoupTech = 0;
								$TtTpsPrepa = 0;
								$TtTpsProd = 0;
								$TtCout = 0;
								$TtPrix = 0;
	
								$query='SELECT '. TABLE_ERP_DEC_TECH .'.Id,
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
																	ORDER BY '. TABLE_ERP_DEC_TECH .'.ORDRE ';
	
								foreach ($bdd->GetQuery($query) as $data){
	
									$PrestaListe ='<option value="0">Aucune</option>';
									$query='SELECT Id, LABEL   FROM '. TABLE_ERP_PRESTATION .'';
									foreach ($bdd->GetQuery($query) as $dataPrest){
										$PrestaListe .='<option value="'. $dataPrest->Id .'" '. selected($dataPrest->Id,  $data->PRESTA_ID) .' >'. $dataPrest->LABEL .'</option>';
									}?>
											<tr>
												<td></td>
												<td>
													<input type="hidden" name="id_DecoupTech[]" id="id_DecoupTech" value="<?= $data->Id  ?>">
													<input type="number" name="UpdateORDREDecoupTech[]" value="<?=  $data->ORDRE  ?>" required="required">
												</td>
												<td>
													<select name="UpdatePRESTADecoupTech[]">
														<?= $PrestaListe  ?>
													</select>
												</td>
												<td><input type="text"  name="UpdateLABELDecoupTech[]" value="<?=  $data->LABEL ?>" required="required"></td>
												<td><input type="number"  name="UpdateTPSPREPDecoupTech[]" value="<?=  $data->TPS_PREP  ?>" step=".001" required="required"></td>
												<td><input type="number"  name="UpdateTPSPRODDecoupTech[]" value="<?=  $data->TPS_PRO  ?>" step=".001" required="required"></td>
												<td><input type="number"  name="UpdateCOUTDecoupTech[]" value="<?=  $data->COUT  ?>" step=".001" required="required"></td>
												<td><input type="number"  name="UpdatePRIXDecoupTech[]" value="<?=  $data->PRIX  ?>" step=".001" required="required"></td>
											</tr>
								<?php
									$iDecoupTech++;
									$TtTpsPrepa +=  $data->TPS_PREP;
									$TtTpsProd +=  $data->TPS_PRO;
									$TtCout +=  $data->COUT;
									$TtPrix +=  $data->PRIX;
								}
	
								if($iDecoupTech>=1){
									echo'
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
								?>
								<tr>
									<td><?=$langue->show_text('Addtext'); ?></td>
									<td><input type="number" name="AddORDREDecoupTech" ></td>
									<td>
										<select name="AddPRESTADecoupTech">
											<?=$PrestaListe; ?>
										</select>
									</td>
									<td><input type="text"  name="AddLABELDecoupTech" ></td>
									<td><input type="number"  name="AddTPSPREPDecoupTech" step=".001" ></td>
									<td><input type="number"  name="AddTPSPRODDecoupTech" step=".001" ></td>
									<td><input type="number"  name="AddCOUTDecoupTech" step=".001" ></td>
									<td><input type="number"  name="AddPRIXDecoupTech" step=".001" ></td>
								</tr>
								<tr>
									<td colspan="8" >
										<br/>
										<?= $Form->submit($langue->show_text('TableUpdateButton')) ?> <br/>
										<br/>
									</td>
								</tr>
							</tbody>
						</table>
					</form>
			</div>
			<div id="div3" class="tabcontent" >
				<form method="post" name="Nomenclature" action="<?=$actionForm; ?>" class="content-form" >
						<table class="content-table">
							<thead>
								<tr>
									<th></th>
									<th><?=$langue->show_text('TableOrder'); ?></th>
									<th><?=$langue->show_text('TableArticle'); ?></th>
									<th><?=$langue->show_text('TableLabel'); ?></th>
									<th><?=$langue->show_text('TableQty'); ?></th>
									<th><?=$langue->show_text('TableUnit'); ?></th>
									<th><?=$langue->show_text('TableUnitPrice'); ?></th>
									<th><?=$langue->show_text('TablePurchaseUnit'); ?></th>
								</tr>
							</thead>
							<tbody>
							<?php
								$query='SELECT '. TABLE_ERP_NOMENCLATURE .'.Id,
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
																	ORDER BY '. TABLE_ERP_NOMENCLATURE .'.ORDRE';
								$i = 0;
								foreach ($bdd->GetQuery($query) as $data): ?>
									<tr>
										<td></td>
										<td>
											<input type="hidden" name="UpdateIdNomencl[]" id="UpdateIdNomencl" value="<?= $data->Id ?>">
											<input type="number" name="UpdateORDRENomencl[]" value="<?= $data->ORDRE ?>" required="required">
										</td>
										<td>
											<input type="hidden" name="UpdateARTICLENomencl[]" value="<?= $data->ARTICLE_ID ?>">
											<?= $data->ARTICLE_LABEL  ?>
										</td>
										<td><input type="text"  name="UpdateLABELNomencl[]" value="<?= $data->LABEL ?>" required="required"></td>
										<td><input type="number"  name="UpdateQTNomencl[]" value="<?= $data->QT  ?>" step=".001" required="required"></td>
										<td>
										<select name="UpdateUNITNomencl[]">
												<option value="<?= $data->UNIT_ID  ?>" <?= selected($data->UNIT_ID, $data->UNIT_ID)  ?>><?= $data->UNIT_LABEL  ?></option>
												<?= $UnitListeInit ?>
											</select>
										</td>
										<td><input type="number"  name="UpdatePRIXUNomencl[]" value="<?= $data->PRIX_U  ?>" step=".001" required="required"></td>
										<td><input type="number"  name="UpdatePRIXACHATNomencl[]" value="<?= $data->PRIX_ACHAT  ?>" step=".001" required="required"></td>
									</tr>
								<?php $i++; endforeach; ?>
								<tr>
									<td><?=$langue->show_text('Addtext'); ?></td>
									<td><input type="number" name="AddORDRENomencl" ></td>
									<td>
										<select name="AddARTICLENomencl">
											<?=$FormListeArticle; ?>
										</select>
									</td>
									<td><input type="text"  name="AddLABELNomencl" ></td>
									<td><input type="number"  name="AddQTNomencl" step=".001" ></td>
									<td>
										<select name="AddTUNITNomencl">
											<?=$UnitListe; ?>
										</select>
									</td>
									<td><input type="number"  name="AddPRIXUNomencl" step=".001" ></td>
									<td><input type="number"  name="AddPRIXACHATNomencl" step=".001" ></td>
								</tr>
								<tr>
									<td colspan="8" >
										<br/>
										<?= $Form->submit($langue->show_text('TableUpdateButton')) ?> <br/>
										<br/>
									</td>
								</tr>
							</tbody>
						</table>
					</form>
			</div>
			<div id="div4" class="tabcontent" >
				<form method="post" name="SousEnsemble" action="<?=$actionForm; ?>" class="content-form" >
						<table class="content-table">
							<thead>
								<tr>
									<th></th>
									<th><?=$langue->show_text('TableOrder'); ?></th>
									<th><?=$langue->show_text('TableArticle'); ?></th>
									<th><?=$langue->show_text('TableQty'); ?></th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php
								$query='SELECT '. TABLE_ERP_SOUS_ENSEMBLE .'.Id,
																			'. TABLE_ERP_SOUS_ENSEMBLE .'.PARENT_ID,
																			'. TABLE_ERP_SOUS_ENSEMBLE .'.ORDRE,
																			'. TABLE_ERP_SOUS_ENSEMBLE .'.ARTICLE_ID,
																			'. TABLE_ERP_SOUS_ENSEMBLE .'.QT,
																			'. TABLE_ERP_ARTICLE .'.LABEL AS LABEL_ARTICLE
																			FROM `'. TABLE_ERP_SOUS_ENSEMBLE .'`
																				LEFT JOIN `'. TABLE_ERP_ARTICLE .'` ON `'. TABLE_ERP_SOUS_ENSEMBLE .'`.`ARTICLE_ID` = `'. TABLE_ERP_ARTICLE .'`.`id`
																			WHERE '. TABLE_ERP_SOUS_ENSEMBLE .'.PARENT_ID = '. $ArticleId .'
																				ORDER BY '. TABLE_ERP_SOUS_ENSEMBLE .'.ORDRE';
									
								$i = 1;
								foreach ($bdd->GetQuery($query) as $data):?>
								<tr>
									<td><input type="hidden" name="UpdateIdSousEns[]" id="UpdateIdSousEns" value="<?= $data->Id ?>"></td>
									<td><input type="number" name="UpdateORDRESousEns[]" value="<?= $data->ORDRE ?>"></td>
									<td>
										<select name="UpdateARTICLESousEns[]">
											<option value="<?= $data->ARTICLE_ID ?>" <?= selected($data->ARTICLE_ID, $data->ARTICLE_ID) ?>><?= $data->LABEL_ARTICLE ?></option>
											<?= $FormListeArticle ?>
										</select>
									</td>
									<td><input type="number"  name="UpdateQTSousEns[]" value="<?= $data->QT ?>" step=".001"></td>
									<td><a href="admin.php?page=manage-study&id=<?= $data->ARTICLE_ID ?>">--></a></td>
								</tr>
								<?php $i++; endforeach; ?>
								<tr>
									<td><?=$langue->show_text('Addtext'); ?></td>
									<td><input type="number" name="AddORDRESousEns" ></td>
									<td>
										<select name="AddARTICLESousEns">
											<?=$FormListeArticle; ?>
										</select>
									</td>
									<td><input type="number"  name="AddQTSousEns" step=".001"></td>
									<td></td>
								</tr>
								<tr>
									<td colspan="5" >
										<br/>
										<?= $Form->submit($langue->show_text('TableUpdateButton')) ?> <br/>
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
				<form method="post" name="Imputations" action="<?=$actionForm; ?>" class="content-form" >
					<table class="content-table" style="width: 50%;">
						<thead>
							<tr>
								<th></th>
								<th><?=$langue->show_text('TableOrder'); ?></th>
								<th><?=$langue->show_text('TableImputationType'); ?></th>
								<th><?=$langue->show_text('TableTVAType'); ?></th>
								<th></th>
							</tr>
						</thead>
						<?php
						$query='SELECT '. TABLE_ERP_IMPUT_COMPTA_LIGNE .'.Id,
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
													ORDER BY '. TABLE_ERP_IMPUT_COMPTA_LIGNE .'.ORDRE';
		
						$i = 1;
						foreach ($bdd->GetQuery($query) as $data):
						if($data->TYPE_IMPUTATION == 1) $TypeImputation = "Achat";
						if($data->TYPE_IMPUTATION == 2) $TypeImputation = "Achat (stock)";
						if($data->TYPE_IMPUTATION == 3) $TypeImputation = "Acompte";
						if($data->TYPE_IMPUTATION == 4) $TypeImputation = "Acompte (avec TVA)";
						if($data->TYPE_IMPUTATION == 5) $TypeImputation = "Autre";
						if($data->TYPE_IMPUTATION == 6) $TypeImputation = "TVA";?>
		
							<tr>
								<td>
									<input type="hidden" name="UpdateIdImputationLigne[]" id="UpdateIdImputationLigne" value="<?= $data->Id ?>">
								</td>
								<td>
		
									<input type="number" name="UpdateORDREImputation[]" value="<?= $data->ORDRE ?>">
								</td>
								<td>
									<select name="UpdateIdImpuration[]">
										<option value="<?= $data->IMPUTATION_ID ?>"  <?= selected( $data->IMPUTATION_ID , $data->IMPUTATION_ID) ?>><?= $data->CODE_IMPUTATION ?> - <?= $data->LABEL_IMPUTATION ?></option>
										<?= $ListeImput ?>
									</select>
								</td>
								<td><?= $data->LABEL_TVA ?></td>
								<td><?= $TypeImputation ?></td>
							</tr>
							<?php $i++; endforeach; ?>
							<tr>
								<td>
									<?=$langue->show_text('Addtext'); ?>
									<input type="hidden" name="IDArticle" value="<?=$ArticleId ?>">
								</td>
								<td><input type="number" name="AddORDREImputation" ></td>
								<td>
									<select name="AddIdImpuration">
										<?=$ListeImput; ?>
									</select>
								</td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td colspan="5" >
								<?= $Form->submit($langue->show_text('TableUpdateButton')) ?> <br/>
								</td>
							</tr>
						</tbody>
					</table>
				</form>
			</div>
			<div id="div8" class="tabcontent" >
				<form method="post" name="Coment" action="<?=$actionForm; ?>" class="content-form" >
					<table class="content-table" style="width: 50%;">
						<thead>
							<tr>
								<th><?=$langue->show_text('TableComment'); ?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<input type="hidden" name="IDArticle" value="<?=$ArticleId ?>">
									<textarea class="Comment" name="Comment" rows="40" ><?=$ArticleComment ?></textarea>
								</td>
							</tr>
							<tr>
								<td>
								<?= $Form->submit($langue->show_text('TableUpdateButton')) ?> <br/>
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
			<form method="post" name="Section" action="admin.php?page=manage-study" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th><?=$langue->show_text('TableCODE'); ?></th>
							<th><?=$langue->show_text('TableLabel'); ?></th>
							<th><?=$langue->show_text('TableType'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
							
						$query='SELECT '. TABLE_ERP_UNIT .'.Id,
										'. TABLE_ERP_UNIT .'.CODE,
										'. TABLE_ERP_UNIT .'.LABEL,
										'. TABLE_ERP_UNIT .'.TYPE
										FROM `'. TABLE_ERP_UNIT .'`
										ORDER BY TYPE';
						$i = 1;
						foreach ($bdd->GetQuery($query) as $data):?>
						<tr>
							<td><?= $i ?> <input type="hidden" name="id_unit[]" id="id_unit" value="<?= $data->Id ?>"></td>
							<td><input type="text" name="UpdateCODEUnit[]" value="<?= $data->CODE ?>" size="10"></td>
							<td><input type="text" name="UpdateLABELUnit[]" value="<?= $data->LABEL ?>" ></td>
							<td>
								<select name="UpdateTYPEUnit[]">
									<option value="1" <?= selected($data->TYPE, 1) ?>><?= $langue->show_text('SelectMass') ?></option>
									<option value="2" <?= selected($data->TYPE, 2) ?>><?= $langue->show_text('SelectLength') ?></option>
									<option value="3" <?= selected($data->TYPE, 3) ?>><?= $langue->show_text('SelectAera') ?></option>
									<option value="4" <?= selected($data->TYPE, 4) ?>><?= $langue->show_text('SelectVolume') ?></option>
									<option value="5" <?= selected($data->TYPE, 5) ?>><?= $langue->show_text('SelectOther') ?></option>
								</select>
							</td>
						</tr>
						<?php $i++; endforeach; ?>
						<tr>
							<td><?= $langue->show_text('Addtext'); ?></td>
							<td><input type="text" class="input-moyen-vide" name="AddCODEUnit" ></td>
							<td><input type="text" class="input-moyen-vide" name="AddLABELUnit" ></td>
							<td>
								<select name="AddTYPEUnit">
									<option value="1"><?=$langue->show_text('SelectMass'); ?></option>
									<option value="2"><?=$langue->show_text('SelectLength'); ?></option>
									<option value="3"><?=$langue->show_text('SelectAera'); ?></option>
									<option value="4"><?=$langue->show_text('SelectVolume'); ?></option>
									<option value="5"><?=$langue->show_text('SelectOther'); ?></option>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="4" >
								<br/>
								<?= $Form->submit($langue->show_text('TableUpdateButton')) ?> <br/>
								<br/>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
	</div>
	<div id="div10" class="tabcontent" >
			<form method="post" name="Section" action="admin.php?page=manage-study" class="content-form" >
				<table class="content-table">
					<thead>
						<tr>
							<th></th>
							<th><?=$langue->show_text('TableCODE'); ?></th>
							<th><?=$langue->show_text('TableLabel'); ?></th>
							<th><?=$langue->show_text('TableService'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$query='SELECT '. TABLE_ERP_SOUS_FAMILLE .'.Id,
														'. TABLE_ERP_SOUS_FAMILLE .'.CODE,
														'. TABLE_ERP_SOUS_FAMILLE .'.LABEL,
														'. TABLE_ERP_SOUS_FAMILLE .'.PRESTATION_ID,
														'. TABLE_ERP_PRESTATION .'.CODE AS CODE_PRESTATION,
														'. TABLE_ERP_PRESTATION .'.LABEL AS LABEL_PRESTATION
														FROM `'. TABLE_ERP_SOUS_FAMILLE .'`
														LEFT JOIN `'. TABLE_ERP_PRESTATION .'` ON `'. TABLE_ERP_SOUS_FAMILLE .'`.`PRESTATION_ID` = `'. TABLE_ERP_PRESTATION .'`.`id`
														ORDER BY Id';
					
						$i = 1;
						foreach ($bdd->GetQuery($query) as $data):?>
						<tr>
							<td><?= $i ?> <input type="hidden" name="id_sous_famille[]" id="id_sous_famille" value="<?= $data->Id ?>"></td>
							<td><input type="text" name="UpdateCODESousFamille[]" value="<?= $data->CODE ?>" size="10"></td>
							<td><input type="text" name="UpdateLABELSousFamille[]" value="<?= $data->LABEL ?>" ></td>
							<td>
								<select name="AddTRESSOURCESousFamille[]">
									<option value="<?= $data->PRESTATION_ID ?>"><?= $data->CODE_PRESTATION ?> - <?= $data->LABEL_PRESTATION ?></option>
									<?= $SectionListe ?>
								</select>
							</td>
						</tr>
						<?php $i++; endforeach; ?>
						<tr>
							<td><?=$langue->show_text('Addtext'); ?></td>
							<td><input type="text" class="input-moyen-vide" name="AddCODESousFamille" ></td>
							<td><input type="text" class="input-moyen-vide" name="AddLABELSousFamille"></td>
							<td>
								<select name="AddRESSOURCESousFamille">
									<?=$SectionListe ?>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="4" >
								<br/>
								<?= $Form->submit($langue->show_text('TableUpdateButton')) ?> <br/>
								<br/>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>
	</div>