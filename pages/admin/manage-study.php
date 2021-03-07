<?php 
	//phpinfo();
	use \App\Autoloader;
	use \App\Form;
	use \App\Methods\Prestation;
	use \App\Methods\Section;
	use \App\Accounting\Allocations;
	use \App\Study\Article;
	use \App\Study\Unit;
	use \App\Study\SubFamily;

	//auto load class
	require_once '../app/Autoload.class.php';
	Autoloader::register();
	
	session_start();
	header( 'content-type: text/html; charset=utf-8' );
	//init form class
	$Form = new Form($_POST);
	$Prestation = new Prestation();
	$Section = new Section();
	$Allocations = new Allocations();
	$Article = new Article();
	$Unit = new Unit();
	$SubFamily = new SubFamily();

	//Check if the user is authorized to view the page
	if($_SESSION['page_10'] != '1'){
		stop($langue->show_text('SystemInfoAccessDenied'), 161, 'index.php?page=login');
	}

	////  ARTICLES  ////
	$ArticleId = preg_replace('#-+#',' ', addslashes($_GET['id']));

	//if add or update Article
	if(isset($_GET['id']) AND !empty($_GET['id'])  or isset($_POST['CODEArticle']) AND !empty($_POST['CODEArticle'])){

		if(isset($_GET['type']) AND $_GET['type'] === 'quote'){
			$ArticleTable = '';
			$TechnicalCutTable = TABLE_ERP_QUOTE_TECH_CUT;
			$NomenclatureTable = TABLE_ERP_QUOTE_NOMENCLATURE;
			$SubAssemblesTable = TABLE_ERP_QUOTE_SUB_ASSEMBLY;

		}elseif(isset($_GET['type']) AND $_GET['type'] === 'order'){
			$ArticleTable = '';
			$TechnicalCutTable = TABLE_ERP_ORDER_TECH_CUT;
			$NomenclatureTable = TABLE_ERP_ORDER_NOMENCLATURE;
			$SubAssemblesTable = TABLE_ERP_ORDER_SUB_ASSEMBLY;
		}
		elseif(isset($_GET['type']) AND $_GET['type'] === 'study'){
			$ArticleTable = '';
			$TechnicalCutTable = TABLE_ERP_STANDARD_TECH_CUT;
			$NomenclatureTable = TABLE_ERP_STANDARD_NOMENCLATURE;
			$SubAssemblesTable = TABLE_ERP_STANDARD_SUB_ASSEMBLY;
		}else{
			header('Location: admin.php?page=manage-study');
		}



		//if is update standart article  
		if(isset($_POST['CODE']) AND !empty($_POST['CODE'])){

			//if update image
			$dossier = PICTURE_FOLDER.STUDY_ARTICLE_FOLDER;
			$fichier = basename($_FILES['FichierImageArticle']['name']);
			move_uploaded_file($_FILES['FichierImageArticle']['tmp_name'], $dossier . $fichier);
					
			If(empty($fichier)){
				$AddSQL = '';
			}
			else{
				$AddSQL = ', IMAGE = \''. addslashes($fichier) .'\'';
			}

			//update article value
			$bdd->GetUpdate("UPDATE  ". TABLE_ERP_STANDARD_ARTICLE ." SET 	LABEL='". addslashes($_POST['LABELAtricle']) ."',
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
																		WHERE id='". $articleid ."'");

			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateArticleNotification')));
		}
		elseif(isset($_POST['CODEArticle']) AND !empty($_POST['CODEArticle'])){
			//if is not exist, we add new entry
			$dossier = PICTURE_FOLDER.STUDY_ARTICLE_FOLDER;
			$fichier = basename($_FILES['FichierImageArticle']['name']);
			move_uploaded_file($_FILES['FichierImageArticle']['tmp_name'], $dossier . $fichier);

			//insert in db
			$articleid = $bdd->GetInsert("INSERT INTO ". TABLE_ERP_STANDARD_ARTICLE ." VALUE ('0',
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
																				'". addslashes($fichier) ."')");

			$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddArticleNotification')));
		}

		if(isset($_POST['AddORDREDecoupTech']) AND !empty($_POST['AddORDREDecoupTech'])){
			//// TECHNICAL CUT  ////
			$req = $bdd->GetInsert("INSERT INTO ". $TechnicalCutTable ." VALUE ('0',
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
		elseif(isset($_POST['AddORDRENomencl']) AND !empty($_POST['AddORDRENomencl'])){
			//// NOMENCLATURE ////
			$req = $bdd->GetInsert("INSERT INTO ". $NomenclatureTable ." VALUE ('0',
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
		elseif(isset($_POST['AddORDRESousEns']) AND !empty($_POST['AddORDRESousEns'])){
			//// SUB-ASSEMBLY ////
			$req = $bdd->GetInsert("INSERT INTO ". $SubAssemblesTable ." VALUE ('0',
																			'". addslashes($ArticleId) ."',
																			'". addslashes($_POST['AddORDRESousEns']) ."',
																			'". addslashes($_POST['AddARTICLESousEns']) ."',
																			'". addslashes($_POST['AddQTSousEns']) ."')");
			$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddSubFamillyNotification')));
		}
		elseif(isset($_POST['AddORDREImputation']) AND !empty($_POST['AddORDREImputation'])){
			//// IMPUTATION ////
			$req = $bdd->GetInsert("INSERT INTO ". TABLE_ERP_IMPUT_COMPTA_LIGNE ." VALUE ('0',
																			'". addslashes($_POST['IDArticle']) ."',
																			'". addslashes($_POST['AddORDREImputation']) ."',
																			'". addslashes($_POST['AddIdImpuration']) ."')");
			$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddAllocationNotification')));
		}
		elseif(isset($_POST['AddCODEUnit']) AND !empty($_POST['AddCODEUnit'])){
			//// UNITS ////
			$req = $bdd->GetInsert("INSERT INTO ". TABLE_ERP_UNIT ." VALUE ('0',
																			'". addslashes($_POST['AddCODEUnit']) ."',
																			'". addslashes($_POST['AddLABELUnit']) ."',
																			'". addslashes($_POST['AddTYPEUnit']) ."')");
			$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddUnitNotification')));
		}
		elseif(isset($_POST['AddCODESousFamille']) AND !empty($_POST['AddCODESousFamille'])){
			//// SUB FAMILLY ////
			$req = $bdd->GetInsert("INSERT INTO ". TABLE_ERP_SOUS_FAMILLE ." VALUE ('0',
																			'". addslashes($_POST['AddCODESousFamille']) ."',
																			'". addslashes($_POST['AddLABELSousFamille']) ."',
																			'". addslashes($_POST['AddRESSOURCESousFamille']) ."')");
			$CallOutBox->add_notification(array('2', $i . $langue->show_text('AddFamillyNotification')));
		}

		if(isset($_POST['id_DecoupTech']) AND !empty($_POST['id_DecoupTech'])){
			//if update technical cut list
			$i = 0;
			foreach ($_POST['id_DecoupTech'] as $id_generation) {

				$bdd->GetUpdate('UPDATE '. $TechnicalCutTable .' SET  ORDRE = \''. addslashes($_POST['UpdateORDREDecoupTech'][$i]) .'\',
																	PRESTA_ID = \''. addslashes($_POST['UpdatePRESTADecoupTech'][$i]) .'\',
																	LABEL = \''. addslashes($_POST['UpdateLABELDecoupTech'][$i]) .'\',
																	TPS_PREP = \''. addslashes($_POST['UpdateTPSPREPDecoupTech'][$i]) .'\',
																	TPS_PRO = \''. addslashes($_POST['UpdateTPSPRODDecoupTech'][$i]) .'\',
																	COUT = \''. addslashes($_POST['UpdateCOUTDecoupTech'][$i]) .'\',
																	PRIX = \''. addslashes($_POST['UpdatePRIXDecoupTech'][$i]) .'\'
																	WHERE Id IN ('. $id_generation . ')');
				$i++;
			}
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateTechnicalCutNotification')));
		}
		elseif(isset($_POST['UpdateIdNomencl']) AND !empty($_POST['UpdateIdNomencl'])){
			//if update NOMENCLATURE
			$i = 0;
			foreach ($_POST['UpdateIdNomencl'] as $id_generation) {

				$bdd->GetUpdate('UPDATE '. $NomenclatureTable .' SET  ORDRE = \''. addslashes($_POST['UpdateORDRENomencl'][$i]) .'\',
																	LABEL = \''. addslashes($_POST['UpdateLABELNomencl'][$i]) .'\',
																	QT = \''. addslashes($_POST['UpdateQTNomencl'][$i]) .'\',
																	UNIT_ID = \''. addslashes($_POST['UpdateUNITNomencl'][$i]) .'\',
																	PRIX_U = \''. addslashes($_POST['UpdatePRIXUNomencl'][$i]) .'\',
																	PRIX_ACHAT = \''. addslashes($_POST['UpdatePRIXACHATNomencl'][$i]) .'\'
																	WHERE Id IN ('. $id_generation . ')');
				$i++;
			}
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateNomenclatureNotification')));
		}
		elseif(isset($_POST['UpdateIdSousEns']) AND !empty($_POST['UpdateIdSousEns'])){
			//if update sub assembly
			$i = 0;
			foreach ($_POST['UpdateIdSousEns'] as $id_generation) {

				$bdd->GetUpdate('UPDATE '. $SubAssemblesTable .' SET  ORDRE = \''. addslashes($_POST['UpdateORDRESousEns'][$i]) .'\',
																		ARTICLE_ID = \''. addslashes($_POST['UpdateARTICLESousEns'][$i]) .'\',
																		QT = \''. addslashes($_POST['UpdateQTSousEns'][$i]) .'\'
																		WHERE Id IN ('. $id_generation . ')');
				$i++;
			}
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateSubFamillyNotification')));
		}
		elseif(isset($_POST['UpdateIdImputationLigne']) AND !empty($_POST['UpdateIdImputationLigne'])){
			//if update Imputation
			$i = 0;
			foreach ($_POST['UpdateIdImputationLigne'] as $id_generation) {

				$bdd->GetUpdate('UPDATE `'. TABLE_ERP_IMPUT_COMPTA_LIGNE .'` SET  ORDRE = \''. addslashes($_POST['UpdateORDREImputation'][$i]) .'\',
																	IMPUTATION_ID = \''. addslashes($_POST['UpdateIdImpuration'][$i]) .'\'
																	WHERE Id IN ('. $id_generation . ')');
				$i++;
			}
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateAllocationNotification')));
		}
		elseif(isset($_POST['id_unit']) AND !empty($_POST['id_unit'])){
			//if update unit
			$i = 0;
			foreach ($_POST['id_unit'] as $id_generation) {

				$bdd->GetUpdate('UPDATE '. TABLE_ERP_UNIT .' SET  CODE = \''. addslashes($_POST['UpdateCODEUnit'][$i]) .'\',
																	LABEL = \''. addslashes($_POST['UpdateLABELUnit'][$i]) .'\',
																	TYPE = \''. addslashes($_POST['UpdateTYPEUnit'][$i]) .'\'
																	WHERE Id IN ('. $id_generation . ')');
				$i++;
			}
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateUnitNotification')));
		}
		elseif(isset($_POST['id_sous_famille']) AND !empty($_POST['id_sous_famille'])){
			// if update familly
			$i = 0;
			foreach ($_POST['id_sous_famille'] as $id_generation) {

				$bdd->GetUpdate('UPDATE `'. TABLE_ERP_SOUS_FAMILLE .'` SET  CODE = \''. addslashes($_POST['UpdateCODESousFamille'][$i]) .'\',
																	LABEL = \''. addslashes($_POST['UpdateLABELSousFamille'][$i]) .'\',
																	PRESTATION_ID = \''. addslashes($_POST['AddTRESSOURCESousFamille'][$i]) .'\'
																	WHERE Id IN ('. $id_generation . ')');
				$i++;
			}
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateFamillyNotification')));
		}
		elseif(isset($_POST['COMMENT']) AND !empty($_POST['COMMENT'])){
			//if update comment article
			$bdd->GetUpdate("UPDATE  ". TABLE_ERP_STANDARD_ARTICLE ." SET 	COMMENT='". addslashes($_POST['COMMENT']) ."'
																			WHERE Id='". addslashes($_POST['IDArticle'])."'");
			$CallOutBox->add_notification(array('3', $i . $langue->show_text('UpdateCommentNotification')));			
		}

		//Assign  values	
		$Articledata = $Article->GETArticle($ArticleId);

		$ArticleCODE = $Articledata->CODE;
		$ArticleLabel = $Articledata->LABEL;
		$ArticleInd = $Articledata->IND;
		$ArticlePrestaId = $Articledata->PRESTATION_ID;
		$ArticlePrestaLab = $Articledata->PRESTATION_LABEL;
		$ArticleTYPEPresta = $Articledata->TYPE;
		$ArticleFamilleId = $Articledata->FAMILLE_ID;
		$ArticleFamilleLab = $Articledata->FAMILLE_LABEL;
		$ArticleAcheter = $Articledata->ACHETER;
		$ArticlePrixAch = $Articledata->PRIX_ACHETER;
		$ArticleVendu = $Articledata->VENDU;
		$ArticlePrixVendu = $Articledata->PRIX_VENDU;
		$ArticleUNIT_ID = $Articledata->UNITE_ID;
		$ArticleUNIT = $Articledata->UNIT_LABEL;
		$ArticleMatiere = $Articledata->MATIERE;
		$ArticleEP = $Articledata->EP;
		$ArticleDimX = $Articledata->DIM_X;
		$ArticleDimY = $Articledata->DIM_Y;
		$ArticleDimZ = $Articledata->DIM_Z;
		$ArticlePoids = $Articledata->POIDS;
		$ArticleSurX = $Articledata->SUR_X;
		$ArticleSurY = $Articledata->SUR_Y;
		$ArticleSurZ = $Articledata->SUR_Z;
		$ArticleComment = $Articledata->COMMENT;
		$ArticleImage = $Articledata->IMAGE;
	}

	if(isset($_GET['type']) AND $_GET['type'] === 'quote'){
		$titleOnglet1 = '<button class="tablinks" onclick="window.location.href = \'http://localhost/erp/public/index.php?page=quote&quote='. $_GET['quoteId'] .'\';">'. $langue->show_text('TitreQuoteReturn') .'</button>';
		$ParDefautDiv2 = 'id="defaultOpen"';
	}
	elseif(isset($_GET['type']) AND $_GET['type'] === 'order'){
		$titleOnglet1 = '<button class="tablinks" onclick="window.location.href = \'http://localhost/erp/public/index.php?page=order&order='. $_GET['orderId'] .'\';">'. $langue->show_text('TitreOrderReturn') .'</button>';
		$ParDefautDiv2 = 'id="defaultOpen"';
	}
	elseif(isset($_GET['id']) AND !empty($_GET['id'])  or isset($_POST['CODEArticle']) AND !empty($_POST['CODEArticle'])){
		$titleOnglet1 = '<button class="tablinks" onclick="openDiv(event, \'div1\')" id="defaultOpen">'. $langue->show_text('TableUpdateButton') .'</button>';
		$actionForm = 'admin.php?page=manage-study&id='. $_GET['id'] .'&type='. $_GET['type'];
		$DisplayCode = '<input type="hidden" name="CODE" value="'. $ArticleCODE .'">' .$ArticleCODE;
	}
	else{
		$titleOnglet1 = '<button class="tablinks" onclick="openDiv(event, \'div1\')" id="defaultOpen">'. $langue->show_text('TableAddArticleButton') .'</button>';
		$actionForm = 'admin.php?page=manage-study$id=new&type=study';
		$DisplayCode ='<input type="text" name="CODEArticle" required="required">';
	}

?>
	<div class="tab">
		<?=$titleOnglet1; ?>
	<?php
	if(isset($_GET['id']) AND !empty($_GET['id'])  or isset($_POST['CODEArticle']) AND !empty($_POST['CODEArticle'])){
	?>
		<button class="tablinks" onclick="openDiv(event, 'div2')" <?=$ParDefautDiv2; ?> ><?=$langue->show_text('Title2'); ?> <?=$iDecoupTech; ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div3')"><?=$langue->show_text('Title3'); ?> <?=$iNomencl; ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div4')"><?=$langue->show_text('Title4'); ?> <?=$iSousEns; ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div5')"><?=$langue->show_text('Title5'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div6')"><?=$langue->show_text('Title6'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div7')"><?=$langue->show_text('Title7'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div8')"><?=$langue->show_text('Title8'); ?></button>
	<?php
	}
	else{
	?>
		<button class="tablinks" onclick="openDiv(event, 'div9')" ><?= $langue->show_text('Title9'); ?></button>
		<button class="tablinks" onclick="openDiv(event, 'div10')"><?= $langue->show_text('Title10'); ?></button>
	<?php
	}
	?>
	</div>
	<div id="div1" class="tabcontent" >
		<div class="column">
			<input type="text" id="myInput" onkeyup="myFunction()" placeholder="<?=$langue->show_text('FindArticle'); ?>">
			<ul id="myUL">
				<?php
				//generate list for datalist find input
				foreach ($Article->GETArticleList('',false) as $data): ?>
				<li><a href="admin.php?page=manage-study&id=<?= $data->id ?>&type=study"><?= $data->CODE ?> - <?= $data->LABEL ?></a></li>
				<?php $i++; endforeach; ?>
			</ul>
		</div>
		<form method="post" name="Company" action="<?= $actionForm ?>" class="content-form" enctype="multipart/form-data" >
				<table class="content-table">
					<thead>
						<tr>
							<th colspan="6"> <br/></th>
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
									<?= $Prestation ->GetPrestationList($ArticlePrestaId) ?>
								</select>
							</td>
							<td >
								<select name="FAMILLE_IDArticle">
								<?= $SubFamily->GetSubFamilyList($ArticleFamilleId, true) ?>
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
									<?= $Unit->GetUnitList($ArticleUNIT_ID, true) ?>
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
							<td colspan=6"><img src="<?= PICTURE_FOLDER.STUDY_ARTICLE_FOLDER.$ArticleImage ?>" title="Image article" alt="Article" style="width: 400px;"/></td>
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
	if(isset($_GET['id']) AND !empty($_GET['id'])  or isset($_POST['CODEArticle']) AND !empty($_POST['CODEArticle'])){
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
	
								foreach ($Article->GETTechnicalCut($ArticleId, $TechnicalCutTable) as $data){?>
											<tr>
												<td></td>
												<td>
													<input type="hidden" name="id_DecoupTech[]" id="id_DecoupTech" value="<?= $data->id  ?>">
													<input type="number" name="UpdateORDREDecoupTech[]" value="<?=  $data->ORDRE  ?>" required="required">
												</td>
												<td>
													<select name="UpdatePRESTADecoupTech[]">
														<?= $Prestation->GetPrestationList($data->PRESTA_ID) ?>
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
											<?=$Prestation ->GetPrestationList() ?>
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
								$i = 0;
								foreach ($Article->GETNomenclature($ArticleId, $NomenclatureTable) as $data): ?>
									<tr>
										<td></td>
										<td>
											<input type="hidden" name="UpdateIdNomencl[]" id="UpdateIdNomencl" value="<?= $data->Id ?>">
											<input type="number" name="UpdateORDRENomencl[]" value="<?= $data->ORDRE ?>" required="required">
										</td>
										<td><?= $data->ARTICLE_LABEL  ?></td>
										<td><input type="text"  name="UpdateLABELNomencl[]" value="<?= $data->LABEL ?>" required="required"></td>
										<td><input type="number"  name="UpdateQTNomencl[]" value="<?= $data->QT  ?>" step=".001" required="required"></td>
										<td>
										<select name="UpdateUNITNomencl[]">
												<?= $Unit->GetUnitList($data->UNIT_ID, true) ?>
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
											<?= $Article->GETArticleList() ?>
										</select>
									</td>
									<td><input type="text"  name="AddLABELNomencl" ></td>
									<td><input type="number"  name="AddQTNomencl" step=".001" ></td>
									<td>
										<select name="AddTUNITNomencl">
										<?= $Unit->GetUnitList('', true) ?>
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
							
								$i = 1;
								foreach ($Article->GETSubAssembly($ArticleId, $SubAssemblesTable) as $data):?>
								<tr>
									<td><input type="hidden" name="UpdateIdSousEns[]" id="UpdateIdSousEns" value="<?= $data->id ?>"></td>
									<td><input type="number" name="UpdateORDRESousEns[]" value="<?= $data->ORDRE ?>"></td>
									<td>
										<select name="UpdateARTICLESousEns[]">
											<option value="<?= $data->ARTICLE_ID ?>" <?= selected($data->ARTICLE_ID, $data->ARTICLE_ID) ?>><?= $data->LABEL_ARTICLE ?></option>
											<?= $Article->GETArticleList() ?>
										</select>
									</td>
									<td><input type="number"  name="UpdateQTSousEns[]" value="<?= $data->QT ?>" step=".001"></td>
									<td><a href="admin.php?page=manage-study&id=<?= $data->ARTICLE_ID ?>&type=<?= $_GET['type']?>">--></a></td>
								</tr>
								<?php $i++; endforeach; ?>
								<tr>
									<td><?=$langue->show_text('Addtext'); ?></td>
									<td><input type="number" name="AddORDRESousEns" ></td>
									<td>
										<select name="AddARTICLESousEns">
											<?= $Article->GETArticleList() ?>
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
						if($data->TYPE_IMPUTATION == 1) $TypeImputation = $langue->show_text('TableSelect1');
						if($data->TYPE_IMPUTATION == 2) $TypeImputation = $langue->show_text('TableSelect2');
						if($data->TYPE_IMPUTATION == 3) $TypeImputation = $langue->show_text('TableSelect3');
						if($data->TYPE_IMPUTATION == 4) $TypeImputation = $langue->show_text('TableSelect4');
						if($data->TYPE_IMPUTATION == 5) $TypeImputation = $langue->show_text('TableSelect5');
						if($data->TYPE_IMPUTATION == 6) $TypeImputation = $langue->show_text('TableSelect6');?>
		
							<tr>
								<td>
									<input type="hidden" name="UpdateIdImputationLigne[]" id="UpdateIdImputationLigne" value="<?= $data->Id ?>">
								</td>
								<td>
		
									<input type="number" name="UpdateORDREImputation[]" value="<?= $data->ORDRE ?>">
								</td>
								<td>
									<select name="UpdateIdImpuration[]">
										<?= $Allocations->GETAllocationsList($data->IMPUTATION_ID) ?>
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
										<?= $Allocations->GETAllocationsList() ?>
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
									<textarea class="Comment" name="COMMENT" rows="40" ><?=$ArticleComment ?></textarea>
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
	else{ 
?>
	<div id="div9" class="tabcontent" >
			<form method="post" name="Unit" action="admin.php?page=manage-study" class="content-form" >
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
						$i = 1;
						foreach ($Unit->GetUnitList('', false) as $data):?>
						<tr>
							<td><?= $i ?> <input type="hidden" name="id_unit[]" id="id_unit" value="<?= $data->id ?>"></td>
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
			<form method="post" name="SubFamily" action="admin.php?page=manage-study" class="content-form" >
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
						$i = 1;
						foreach ($SubFamily->GetSubFamilyList('', false) as $data):?>
						<tr>
							<td><?= $i ?> <input type="hidden" name="id_sous_famille[]" id="id_sous_famille" value="<?= $data->id ?>"></td>
							<td><input type="text" name="UpdateCODESousFamille[]" value="<?= $data->CODE ?>" size="10"></td>
							<td><input type="text" name="UpdateLABELSousFamille[]" value="<?= $data->LABEL ?>" ></td>
							<td>
								<select name="AddTRESSOURCESousFamille[]">
									<?= $Prestation->GetPrestationList($data->PRESTATION_ID) ?>
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
									<?=$Prestation->GetPrestationList() ?>
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
	<?php
	}