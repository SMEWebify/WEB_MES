<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
	<title><?=$Company->CompanyName() ?> - <?=$langue->show_text('TiltePage') ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" media="screen" type="text/css" title="deco" href="../public/css/ui.css" />
	<link rel="stylesheet" media="screen" type="text/css" title="deco" href="../public/css/content.css" />
	<link rel="stylesheet" media="print" type="text/css"  href="../public/css/print.css" />
	<link rel="stylesheet" media="screen" type="text/css" title="deco" href="../public/css/tableaux.css" />
	<link rel="stylesheet" media="screen" type="text/css" title="deco" href="../public/css/forms.css" />
	
	<link rel="shortcut icon" type="image/x-icon" href="../public/image/favicon.ico" />
	
	<script src="../public/js/divers.js"></script>
</head>
<body>

<?php 
	if(isset($_SESSION['mdp'])){
?>
	<div class="navbar">
		<a href="#" id="OpenNav" >&#9783; <?=$langue->show_text('MenuLinkPage') ; ?></a>
		<a href="<?=$_SERVER['HTTP_REFERER'] ?>">&#8634; <?=  $langue->show_text('ReturnLinkPage') ; ?></a>
		<a href="index.php?page=home">Home</a>
		<span class="profil-nav"><a  href="index.php?page=profil"><?=$User->NAME ?>  <img src="<?= PICTURE_FOLDER.PROFIL_FOLDER.$User->IMAGE_PROFIL ?>" title="Photo profil" alt="Photo" style="border-radius: 50%; width: 30px; vertical-align: middle;" /></a></span>
	</div>
	<div id="myNav" class="overlay">
		<a href="javascript:void(0)" class="closebtn" id="ClosenNav">&times;</a>
		<div class="overlay-content">
			<div style="float:left; margin-right:50px;">
<?php
			if($_SESSION['page_9'] == '1') echo '<a  href="index.php?page=companies">'. $langue->show_text('CompaniesLinkPage') .'</a><br/>
			<i>'. $langue->show_text('SubCompaniesLinkPage') .'</i>';
			if($_SESSION['page_2'] == '1') echo '<a  href="index.php?page=quote" >'. $langue->show_text('QuoteLinkPage') .'</a><br/>
			<i>'. $langue->show_text('SubQuoteLinkPage') .'</i>';
			if($_SESSION['page_2'] == '1') echo '<a  href="index.php?page=order" >'. $langue->show_text('OrderLinkPage') .'</a><br/>
			<i>'. $langue->show_text('SubOrderLinkPage') .'</i>';
			if($_SESSION['page_3'] == '1') echo '<a  href="index.php?page=purchase" >'. $langue->show_text('PurchaseLinkPage') .'</a><br/>
			<i>'. $langue->show_text('SubPurchaseLinkPage') .'</i>';
			if($_SESSION['page_2'] == '1') echo '<a  href="index.php?page=planning" >'. $langue->show_text('PlanningLinkPage') .'</a><br/>
			<i>'. $langue->show_text('SubPlanningLinkPage') .'</i>';
			if($_SESSION['page_5'] == '1') echo '<a  href="index.php?page=article" >'. $langue->show_text('ArticleLinkPage') .'</a><br/>
			<i>'. $langue->show_text('SubArticleLinkPage') .'</i>';
			if($_SESSION['page_6'] == '1') echo '<a  href="index.php?page=quality" >'. $langue->show_text('QualityLinkPage') .'</a><br/>
			<i>'. $langue->show_text('SubQualityLinkPage') .'</i>';
			echo '<a  href="index.php?page=logout">'. $langue->show_text('LogOutLinkPage') .'</a><br/>
			<i>'. $langue->show_text('SubLogOutLinkPage') .'</i>';

			if($_SESSION['page_10'] == '1') {
				echo '
			</div>
			<div style=" margin-left:400px; border-left:1px solid #ccc;">
				<a class="" href="admin.php?page=manage-company">'. $langue->show_text('GeneralSettingLinkPage') .'</a><br/>
				<i>'. $langue->show_text('SubGeneralSettingLinkPage') .'</i>
				<a class="" href="admin.php?page=manage-companies">'. $langue->show_text('CustoProvidLinkPage') .'</a><br/>
				<i>'. $langue->show_text('SubCustoProvidLinkPage') .'</i>
				<a class="" href="admin.php?page=manage-time">'. $langue->show_text('SettingTimeLinkPage') .'</a><br/>
				<i>'. $langue->show_text('SubSettingTimeLinkPage') .'</i>
				<a class="" href="admin.php?page=manage-users">'. $langue->show_text('EmployeesLinkPage') .'</a><br/>
				<i>'. $langue->show_text('SubEmployeesLinkPage') .'</i>
				<a class="" href="admin.php?page=manage-methodes">'. $langue->show_text('MethodLinkPage') .'</a><br/>
				<i>'. $langue->show_text('SubMethodLinkPage') .'</i>
				<a class="" href="admin.php?page=manage-study">'. $langue->show_text('StudyLinkPage') .'</a><br/>
				<i>'. $langue->show_text('SubStudyLinkPage') .'</i>
				<a class="" href="admin.php?page=manage-quality">'. $langue->show_text('QualitySettingLinkPage') .'</a><br/>
				<i>'. $langue->show_text('SubQualitySettingLinkPage') .'</i>
				<a class="" href="admin.php?page=manage-accounting">'. $langue->show_text('AccountingLinkPage') .'</a><br/>
				<i>'. $langue->show_text('SubAccountingLinkPage') .'</i>';
			}
		}
?>
			</div>
		</div>
	</div>
<?php
	echo $content;
	$CallOutBox->display_notification();
?>
</body>
</html>