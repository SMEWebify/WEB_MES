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
	if($_SESSION['page_5'] != '1'){
		stop($langue->show_text('SystemInfoAccessDenied'), 161, 'index.php?page=login');
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
			//generate list for datalist find input
			$query="SELECT id, CODE, LABEL FROM ". TABLE_ERP_ARTICLE ." ORDER BY LABEL";
			foreach ($bdd->GetQuery($query) as $data): ?>
			<li><a href="index.php?page=article&id=<?= $data->id ?>"><?= $data->CODE ?> - <?= $data->LABEL ?></a></li>
			<?php $i++; endforeach; ?>
		</ul>
	</div>
	<?php
		if(isset($_GET['id'])){
			// FIRST RANK 1 PART LOOP
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
											WHERE '. TABLE_ERP_ARTICLE .'.ID = \''. 	addslashes($_GET['id']).'\'';
				$dataFirstRank = $bdd->GetQuery($query, true)?>
				<div class="column">
					<div class="tree">
							<ul >
								<li><span ><?= $dataFirstRank->CODE ?> - <?= $dataFirstRank->LABEL ?></span>
									<ul>
									<?php
									// FIRST RANK PART TECHNICAL CUT
										$query='SELECT '. TABLE_ERP_DEC_TECH .'.Id,
													'. TABLE_ERP_DEC_TECH .'.ORDRE,
													'. TABLE_ERP_DEC_TECH .'.PRESTA_ID,
													'. TABLE_ERP_DEC_TECH .'.LABEL,
													'. TABLE_ERP_DEC_TECH .'.TPS_PREP,
													'. TABLE_ERP_DEC_TECH .'.TPS_PRO,
													'. TABLE_ERP_PRESTATION .'.LABEL AS PRESTA_LABEL
													FROM `'. TABLE_ERP_DEC_TECH .'`
														LEFT JOIN `'. TABLE_ERP_PRESTATION .'` ON `'. TABLE_ERP_DEC_TECH .'`.`PRESTA_ID` = `'. TABLE_ERP_PRESTATION .'`.`id`
													WHERE '. TABLE_ERP_DEC_TECH .'.ARTICLE_ID = \''. $dataFirstRank->ID .'\'
														ORDER BY '. TABLE_ERP_DEC_TECH .'.ORDRE';
	
									foreach ($bdd->GetQuery($query) as $data){
										$TpsTotal = $data->TPS_PREP + $data->TPS_PRO;?>
										<li><?= $TpsTotal ?> hrs - <?= $data->PRESTA_LABEL ?> </li>
									<?php }

									// FIRST RANK PART NOMENCLATURE
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
													WHERE '. TABLE_ERP_NOMENCLATURE .'.PARENT_ID = \''. $dataFirstRank->ID .'\'
														ORDER BY '. TABLE_ERP_NOMENCLATURE .'.ORDRE';
	
									foreach ($bdd->GetQuery($query) as $data){ ?>
										<li> <?= $data->QT ?> <?= $data->UNIT_LABEL ?> - <?= $data->ARTICLE_LABEL ?></li>
									<?php }
						
						//SECONDE LOOP ARTICLE RANK 2
						$query='SELECT '. TABLE_ERP_SOUS_ENSEMBLE .'.ID,
																'. TABLE_ERP_SOUS_ENSEMBLE .'.PARENT_ID,
																'. TABLE_ERP_SOUS_ENSEMBLE .'.ORDRE,
																'. TABLE_ERP_SOUS_ENSEMBLE .'.ARTICLE_ID,
																'. TABLE_ERP_SOUS_ENSEMBLE .'.QT,
																'. TABLE_ERP_ARTICLE .'.LABEL AS LABEL_ARTICLE
																FROM `'. TABLE_ERP_SOUS_ENSEMBLE .'`
																	LEFT JOIN `'. TABLE_ERP_ARTICLE .'` ON `'. TABLE_ERP_SOUS_ENSEMBLE .'`.`ARTICLE_ID` = `'. TABLE_ERP_ARTICLE .'`.`id`
																WHERE '. TABLE_ERP_SOUS_ENSEMBLE .'.PARENT_ID = \''. $dataFirstRank->ID .'\'
																	ORDER BY '. TABLE_ERP_SOUS_ENSEMBLE .'.ORDRE';
						// SECOND RANK PART TECHNICAL CUT
						foreach ($bdd->GetQuery($query) as $data){  ?>
						
						<li><span><a href="index.php?page=article&id=<?= $data->ARTICLE_ID ?>"><?= $data->LABEL_ARTICLE ?> </a></span>
							<ul >
						<?php
							$query='SELECT '. TABLE_ERP_DEC_TECH .'.Id,
													'. TABLE_ERP_DEC_TECH .'.ORDRE,
													'. TABLE_ERP_DEC_TECH .'.PRESTA_ID,
													'. TABLE_ERP_DEC_TECH .'.LABEL,
													'. TABLE_ERP_DEC_TECH .'.TPS_PREP,
													'. TABLE_ERP_DEC_TECH .'.TPS_PRO,
													'. TABLE_ERP_PRESTATION .'.LABEL AS PRESTA_LABEL
													FROM `'. TABLE_ERP_DEC_TECH .'`
														LEFT JOIN `'. TABLE_ERP_PRESTATION .'` ON `'. TABLE_ERP_DEC_TECH .'`.`PRESTA_ID` = `'. TABLE_ERP_PRESTATION .'`.`id`
													WHERE '. TABLE_ERP_DEC_TECH .'.ARTICLE_ID = \''. $data->ARTICLE_ID .'\'
														ORDER BY '. TABLE_ERP_DEC_TECH .'.ORDRE';
	
							foreach ($bdd->GetQuery($query) as $data){
								$TpsTotal = $data->TPS_PREP + $data->TPS_PRO;  ?>
								<li><?= $TpsTotal ?> hrs - <?= $data->PRESTA_LABEL ?></li>
							<?php }
							// SECONDE RANK PART NOMENCLATURE
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
																				WHERE '. TABLE_ERP_NOMENCLATURE .'.PARENT_ID = \''. $donnees_SousEns['ARTICLE_ID'] .'\'
																					ORDER BY '. TABLE_ERP_NOMENCLATURE .'.ORDRE';
	
						foreach ($bdd->GetQuery($query) as $data){ ?>
							<li> <?= $data->QT  ?> <?= $data->UNIT_LABEL  ?> - <?= $data->ARTICLE_LABEL ?></li>
						<?php }
					}?>
							</ul>
						  </li>
						</ul>
					  </li>
				  </div>
				</div>
				<div class="column">
					<div class="card">
						<h3><?= $dataFirstRank->CODE ?></h3>
						<h2><?= $dataFirstRank->LABEL ?></h2>
						<p><?= $dataFirstRank->PRESTATION_LABEL ?></p>
						<p><?= $dataFirstRank->FAMILLE_LABEL ?></p>
						<img src="<?= $dataFirstRank->IMAGE  ?>" title="Image Article" alt="Logo" Class="Image-Aricle"/>
						<p><?= $dadataFirstRankta->COMMENT ?></p>
					</div>
				</div>
			</div>
		<?php
		}
		?>