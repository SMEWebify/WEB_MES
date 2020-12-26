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
	
	<link rel="stylesheet" type="text/css" href="../public/css/component.css" />
	
	<link rel="shortcut icon" type="image/x-icon" href="../public/image/favicon.ico" />
	
	<script src="../public/js/divers.js"></script>
</head>
<body>

<?php 
	if(isset($_SESSION['mdp'])){
?>
	<div class="container">
		<ul id="gn-menu" class="gn-menu-main">
			<li><a  href="#" id="OpenNav" >&#9776; <?=$langue->show_text('MenuLinkPage') ; ?></a></li>
			<li><a class="codrops-icon codrops-icon-back" href="<?php $_SERVER['HTTP_REFERER'] ?>"><?=  $langue->show_text('ReturnLinkPage') ; ?></a></li>
			<li><a class="codrops-icon codrops-icon-home" href="index.php?page=home"><?=$Company->CompanyName() ?></a></li>
			<?php if(isset($_SESSION['mdp'])) echo '<li><a class="codrops-icon codrops-icon-profil" href="index.php?page=profil"><span> '. $User->NAME .' ('. $langue->show_text('ProfilLinkPage') .')</span></a></li>'; ?>
		</ul>
	</div>
	<div id="myNav" class="overlay">
		<a href="javascript:void(0)" class="closebtn" id="ClosenNav">&times;</a>
		<div class="overlay-content">
			<div style="float:left; margin-right:50px;">
<?php
			if($_SESSION['page_2'] == '1') echo '<a class="gn-icon gn-icon-table" href="index.php?page=quote" >'. $langue->show_text('QuoteLinkPage') .'</a> ';
			if($_SESSION['page_2'] == '1') echo '<a class="gn-icon gn-icon-table" href="index.php?page=order" >'. $langue->show_text('OrderLinkPage') .'</a> ';
			if($_SESSION['page_2'] == '1') echo '<a class="gn-icon gn-icon-table" href="index.php?page=planning" >'. $langue->show_text('PlanningLinkPage') .'</a> ';
			if($_SESSION['page_9'] == '1') echo '<a class="gn-icon gn-icon-calendar" href="index.php?page=calendar">'. $langue->show_text('CalendarLinkPage') .'</a>';
			if($_SESSION['page_3'] == '1') echo '<a class="gn-icon gn-icon-achat" href="index.php?page=purchase" >'. $langue->show_text('PurchaseLinkPage') .'</a>';
			if($_SESSION['page_5'] == '1') echo '<a class="gn-icon gn-icon-zoom-in" href="index.php?page=article" >'. $langue->show_text('ArticleLinkPage') .'</a>';
			if($_SESSION['page_6'] == '1') echo '<a class="gn-icon gn-icon-tags" href="index.php?page=quality" >'. $langue->show_text('QualityLinkPage') .'</a>';
			if($_SESSION['mdp']) echo '<a class="gn-icon gn-icon-logout" href="index.php?page=logout">'. $langue->show_text('LogOutLinkPage') .'</a>';
			if($_SESSION['page_10'] == '1') {
				echo '
			</div>
			<div style=" margin-left:300px; border-left:1px solid #ccc;">
				<a class="" href="admin.php?page=manage-company">'. $langue->show_text('GeneralSettingLinkPage') .'</a>
				<a class="" href="admin.php?page=manage-companies">'. $langue->show_text('CustoProvidLinkPage') .'</a>
				<a class="" href="admin.php?page=manage-time">'. $langue->show_text('SettingTimeLinkPage') .'</a>
				<a class="" href="admin.php?page=manage-users">'. $langue->show_text('EmployeesLinkPage') .'</a>
				<a class="" href="admin.php?page=manage-methodes">'. $langue->show_text('MethodLinkPage') .'</a>
				<a class="" href="admin.php?page=manage-study">'. $langue->show_text('StudyLinkPage') .'</a>
				<a class="" href="admin.php?page=manage-quality">'. $langue->show_text('QualitySettingLinkPage') .'</a>
				<a class="" href="admin.php?page=manage-accounting">'. $langue->show_text('AccountingLinkPage') .'</a>';
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