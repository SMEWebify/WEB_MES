<?php 
	//phpinfo();
	use \App\Autoloader;
	use \App\SQL;
	use \App\Language;
	use \App\COMPANY\Company;
	use \App\COMPANY\CompanyManager;
	use \App\CallOutBox;

	// include for the constants
	require_once '../include/include_recup_config.php';
	//auto load class
	require_once '../app/Autoload.class.php';
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
	require_once '../include/include_fonctions.php';
	//session checking  user
	require_once '../include/include_checking_session.php';
	//init xml for user language
	$langue = new Language('lang', 'article', $UserLanguage);
	//init call out box for notification
	$CallOutBox = new CallOutBox();

	//Check if the user is authorized to view the page
	if($_SESSION['page_5'] != '1'){
		stop($langue->show_text('SystemInfoAccessDenied'), 161, 'index.php?page=login');
	}

	//generate list for datalist find input
	$req = $bdd->query("SELECT id, CODE, LABEL FROM ". TABLE_ERP_ARTICLE ." ORDER BY LABEL");
	while ($donnees_Article = $req->fetch()){
		$ListeArticle  .= '<li><a href="index.php?page=article&id='. $donnees_Article['id'] .'">'. $donnees_Article['CODE'] .' - '. $donnees_Article['LABEL'] .' </a></li>';
	}

	if(isset($_GET['id'])){
	// FIRST RANK 1 PART LOOP
		$reqDetailArticle = $bdd->query('SELECT '. TABLE_ERP_ARTICLE .'.ID,
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
									WHERE '. TABLE_ERP_ARTICLE .'.ID = \''. 	addslashes($_GET['id']).'\'');
		$donnees_DetailArticle = $reqDetailArticle->fetch();

		$DetailArticle  .= '
		<div class="column">
			<div class="tree ">
					<ul >
						<li><span >'. $donnees_DetailArticle['CODE'] .' - '. $donnees_DetailArticle['LABEL'] .'</span>
							<ul>';

			// FIRST RANK PART TECHNICAL CUT
				$reqDecoupTech = $bdd -> query('SELECT '. TABLE_ERP_DEC_TECH .'.Id,
												'. TABLE_ERP_DEC_TECH .'.ORDRE,
												'. TABLE_ERP_DEC_TECH .'.PRESTA_ID,
												'. TABLE_ERP_DEC_TECH .'.LABEL,
												'. TABLE_ERP_DEC_TECH .'.TPS_PREP,
												'. TABLE_ERP_DEC_TECH .'.TPS_PRO,
												'. TABLE_ERP_PRESTATION .'.LABEL AS PRESTA_LABEL
												FROM `'. TABLE_ERP_DEC_TECH .'`
													LEFT JOIN `'. TABLE_ERP_PRESTATION .'` ON `'. TABLE_ERP_DEC_TECH .'`.`PRESTA_ID` = `'. TABLE_ERP_PRESTATION .'`.`id`
												WHERE '. TABLE_ERP_DEC_TECH .'.ARTICLE_ID = \''. $donnees_DetailArticle['ID'] .'\'
													ORDER BY '. TABLE_ERP_DEC_TECH .'.ORDRE');

				while ($donnees_DecoupTech = $reqDecoupTech->fetch()){
					$TpsTotal = $donnees_DecoupTech['TPS_PREP'] + $donnees_DecoupTech['TPS_PRO'];
					$DetailArticle  .= ' <li>'. $TpsTotal .' hrs - '. $donnees_DecoupTech['PRESTA_LABEL'] .' </li>';
				}
			// FIRST RANK PART NOMENCLATURE
				$reqNomencl = $bdd -> query('SELECT '. TABLE_ERP_NOMENCLATURE .'.Id,
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
												WHERE '. TABLE_ERP_NOMENCLATURE .'.PARENT_ID = \''. $donnees_DetailArticle['ID'] .'\'
													ORDER BY '. TABLE_ERP_NOMENCLATURE .'.ORDRE');

				while ($donnees_Nomencl = $reqNomencl->fetch()){
					$DetailArticle  .= ' <li> '. $donnees_Nomencl['QT'] .' '. $donnees_Nomencl['UNIT_LABEL'] .' - '. $donnees_Nomencl['ARTICLE_LABEL'] .'</li>';
				}

			//SECONDE LOOP ARTICLE RANK 2
				$reqSSEns = $bdd -> query('SELECT '. TABLE_ERP_SOUS_ENSEMBLE .'.ID,
										'. TABLE_ERP_SOUS_ENSEMBLE .'.PARENT_ID,
										'. TABLE_ERP_SOUS_ENSEMBLE .'.ORDRE,
										'. TABLE_ERP_SOUS_ENSEMBLE .'.ARTICLE_ID,
										'. TABLE_ERP_SOUS_ENSEMBLE .'.QT,
										'. TABLE_ERP_ARTICLE .'.LABEL AS LABEL_ARTICLE
										FROM `'. TABLE_ERP_SOUS_ENSEMBLE .'`
											LEFT JOIN `'. TABLE_ERP_ARTICLE .'` ON `'. TABLE_ERP_SOUS_ENSEMBLE .'`.`ARTICLE_ID` = `'. TABLE_ERP_ARTICLE .'`.`id`
										WHERE '. TABLE_ERP_SOUS_ENSEMBLE .'.PARENT_ID = \''. $donnees_DetailArticle['ID'] .'\'
											ORDER BY '. TABLE_ERP_SOUS_ENSEMBLE .'.ORDRE');
			// SECOND RANK PART TECHNICAL CUT
				while ($donnees_SousEns = $reqSSEns->fetch()){
					$DetailArticle  .= '
					<li><span><a href="index.php?page=article&id='. $donnees_SousEns['ARTICLE_ID'] .'">'. $donnees_SousEns['LABEL_ARTICLE'] .' </a></span>
						<ul >';

					$reqDecoupTech = $bdd -> query('SELECT '. TABLE_ERP_DEC_TECH .'.Id,
												'. TABLE_ERP_DEC_TECH .'.ORDRE,
												'. TABLE_ERP_DEC_TECH .'.PRESTA_ID,
												'. TABLE_ERP_DEC_TECH .'.LABEL,
												'. TABLE_ERP_DEC_TECH .'.TPS_PREP,
												'. TABLE_ERP_DEC_TECH .'.TPS_PRO,
												'. TABLE_ERP_PRESTATION .'.LABEL AS PRESTA_LABEL
												FROM `'. TABLE_ERP_DEC_TECH .'`
													LEFT JOIN `'. TABLE_ERP_PRESTATION .'` ON `'. TABLE_ERP_DEC_TECH .'`.`PRESTA_ID` = `'. TABLE_ERP_PRESTATION .'`.`id`
												WHERE '. TABLE_ERP_DEC_TECH .'.ARTICLE_ID = \''. $donnees_SousEns['ARTICLE_ID'] .'\'
													ORDER BY '. TABLE_ERP_DEC_TECH .'.ORDRE');

											while ($donnees_DecoupTech = $reqDecoupTech->fetch()){
												$TpsTotal = $donnees_DecoupTech['TPS_PREP'] + $donnees_DecoupTech['TPS_PRO'];
												$DetailArticle  .= ' <li>'. $TpsTotal .' hrs - '. $donnees_DecoupTech['PRESTA_LABEL'] .' </li>';
											}
			// SECONDE RANK PART NOMENCLATURE
					$reqNomencl = $bdd -> query('SELECT '. TABLE_ERP_NOMENCLATURE .'.Id,
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
																			WHERE '. TABLE_ERP_NOMENCLATURE .'.PARENT_ID = \''. $donnees_SousEns['ARTICLE_ID'] .'\'
																				ORDER BY '. TABLE_ERP_NOMENCLATURE .'.ORDRE');

					while ($donnees_Nomencl = $reqNomencl->fetch()){
						$DetailArticle  .= ' <li> '. $donnees_Nomencl['QT'] .' '. $donnees_Nomencl['UNIT_LABEL'] .' - '. $donnees_Nomencl['ARTICLE_LABEL'] .'</li>';
					}
				}
						$DetailArticle  .= '
						</ul>
					  </li>
					</ul>
				  </li>
			  </div>
			</div>
			<div class="column">
				<div class="card">
					<h3>'. $donnees_DetailArticle['CODE'] .'</h3>
					<h2>'. $donnees_DetailArticle['LABEL'] .'</h2>
					<p>'. $donnees_DetailArticle['PRESTATION_LABEL'] .'</p>
					<p>'. $donnees_DetailArticle['FAMILLE_LABEL'] .'</p>
					<img src="'. $donnees_DetailArticle['IMAGE']  .'" title="Image Article" alt="Logo" Class="Image-Aricle"/>
					<p>'. $donnees_DetailArticle['COMMENT'] .'</p>
				</div>
			</div>';
	}
?>

<div class="tab">
	<button class="tablinks" onclick="openDiv(event, 'div1')" id="defaultOpen"><?=$langue->show_text('Title1'); ?></button>
</div>
<div id="div1" class="tabcontent" >
	<div class="column">
		<input type="text" id="myInput" onkeyup="myFunction()" placeholder="<?=$langue->show_text('FindArticle'); ?>">
		<ul id="myUL">
<?php
		Echo $ListeArticle;
?>
		</ul>
	</div>
<?php
		Echo $DetailArticle;
?>
</div>
