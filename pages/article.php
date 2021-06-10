<?php 
	//phpinfo();
	use \App\Autoloader;
	use \App\UI\Form;
	use \App\Study\Article;
	use \App\Study\ArticleTreeStructure;
	use \App\Planning\Task;

	//auto load class
	require_once '../app/Autoload.class.php';
	Autoloader::register();
	
	session_start();
	header( 'content-type: text/html; charset=utf-8' );
	//init form class
	$Form = new Form($_POST);
	$Article = new Article();
	$Task = new Task();
	$ArticleTreeStructure = new ArticleTreeStructure();

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
			foreach ($Article->GETArticleList('',false) as $data): ?>
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
							<li><span ><?= $dataFirstRank->CODE ?> - <?= $dataFirstRank->LABEL ?> </span>
								<ul>
								<?php
									// FIRST RANK PART TECHNICAL CUT
									foreach ($Task->GETTechnicalCut($_GET['id'], 'component') as $data){
										$TpsTotal = $data->SETING_TIME + $data->	UNIT_TIME;?>
									<li><?= $TpsTotal ?> hrs - <?= $data->LABEL_SERVICE ?> </li>

								<?php }
									// FIRST RANK PART NOMENCLATURE
									foreach ($Task->GETNomenclature($_GET['id'], 'component') as $data){ ?>
									<li> <?= $data->QTY ?> <?= $data->UNIT_LABEL ?> - <?= $data->ARTICLE_LABEL ?></li>
									<?php }

									//LOOP ARTICLE
									$ArticleTreeStructure->GetTreeStructure($_GET['id']);
								?>
								</ul>
							</li>
						</ul>
				  </div>
				</div>
				<div class="column">
					<div class="card">
						<h3><?= $dataFirstRank->CODE ?></h3>
						<h2><?= $dataFirstRank->LABEL ?></h2>
						<p><?= $dataFirstRank->LABEL_SERVICE ?></p>
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