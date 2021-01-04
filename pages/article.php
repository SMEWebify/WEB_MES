<?php 
	//phpinfo();
	use \App\Autoloader;
	use \App\Form;
	use \App\Study\Article;

	//auto load class
	require_once '../app/Autoload.class.php';
	Autoloader::register();
	
	session_start();
	header( 'content-type: text/html; charset=utf-8' );
	//init form class
	$Form = new Form($_POST);
	$Article = new Article();

	//Check if the user is authorized to view the page
	if($_SESSION['page_5'] != '1'){
		stop($langue->show_text('SystemInfoAccessDenied'), 161, 'index.php?page=login');
	}
?>
<div class="tab">
	<button class="tablinks" onclick="openDiv(event, 'div1')" id="defaultOpen"><?=$langue->show_text('Title1'); ?></button>
	<button class="tablinks" onclick="openDiv(event, 'div2')" id="defaultOpen"><?=$langue->show_text('Title2'); ?></button>
	<button class="tablinks" onclick="openDiv(event, 'div3')" id="defaultOpen"><?=$langue->show_text('Title3'); ?></button>
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
			// FIRST RANK 1 PART
				$dataFirstRank= $Article->GETArticle($_GET['id']);?>
				<div class="column">
					<div class="tree">
						<ul>
							<li><span ><?= $dataFirstRank->CODE ?> - <?= $dataFirstRank->LABEL ?></span>
								<ul>
									<?php
									// FIRST RANK PART TECHNICAL CUT
									foreach ($Article->GETTechnicalCut($_GET['id']) as $data){
										$TpsTotal = $data->TPS_PREP + $data->TPS_PRO;?>
									<li><?= $TpsTotal ?> hrs - <?= $data->PRESTA_LABEL ?> </li>

									<?php }

									// FIRST RANK PART NOMENCLATURE
									foreach ($Article->GETNomenclature($_GET['id']) as $data){ ?>
									<li> <?= $data->QT ?> <?= $data->UNIT_LABEL ?> - <?= $data->ARTICLE_LABEL ?></li>
									<?php }
								
												//SECONDE LOOP ARTICLE RANK 2

												foreach ($Article->GETSubAssembly($_GET['id']) as $dataPartRank2){  
												?>
															<li><span><a href="index.php?page=article&id=<?= $dataPartRank2->ARTICLE_ID ?>"><?= $dataPartRank2->LABEL_ARTICLE ?> </a></span>
																<ul>
												<?php
												// SECOND RANK PART TECHNICAL CUT
													foreach ($Article->GETTechnicalCut($dataPartRank2->ARTICLE_ID) as $dataTechnicalCutRank2){
														$TpsTotal = $dataTechnicalCutRank2->TPS_PREP + $dataTechnicalCutRank2->TPS_PRO;  ?>
																	<li><?= $TpsTotal ?> hrs - <?= $dataTechnicalCutRank2->PRESTA_LABEL ?></li>
													<?php }

												// SECONDE RANK PART NOMENCLATURE
							
												foreach ($Article->GETNomenclature($dataPartRank2->ARTICLE_ID) as $dataNomenclatureRank2){  ?>
																	<li> <?= $dataNomenclatureRank2->QT  ?> <?= $dataNomenclatureRank2->UNIT_LABEL  ?> - <?= $dataNomenclatureRank2->ARTICLE_LABEL ?></li>
												<?php }

								echo '</li></ul></li>';
								}?>
								</li>
							</ul>
					 	 
				  </div>
				</div>
				<div class="column">
					<div class="card">
						<h3><?= $dataFirstRank->CODE ?></h3>
						<h2><?= $dataFirstRank->LABEL ?></h2>
						<p><?= $dataFirstRank->PRESTATION_LABEL ?></p>
						<p><?= $dataFirstRank->FAMILLE_LABEL ?></p>
						<img src="<?= PICTURE_FOLDER.STUDY_ARTICLE_FOLDER.$dataFirstRank->IMAGE ?>" title="Image Article" alt="Logo" Class="Image-Aricle"/>
						<p><?= $dadataFirstRankta->COMMENT ?></p>
					</div>
				</div>
			</div>
	<?php
	}
	?>
	<div id="div2" class="tabcontent" >
	</div>	
	<div id="div3" class="tabcontent" >
	</div>	