		<div class="container">
			<ul id="gn-menu" class="gn-menu-main">
				<li><a  href="#" id="OpenNav" >&#9776; <?=$langue->show_text('MenuLinkPage') ; ?></a></li>
				<li><a class="codrops-icon codrops-icon-back" href="<?php $_SERVER['HTTP_REFERER'] ?>"><?=$langue->show_text('ReturnLinkPage') ; ?></a></li>
				<?php if($_SESSION['page_1'] == '1') echo  '<li><a class="codrops-icon codrops-icon-home" href="index.php">'. $Company->CompanyName().'</a></li>' ?>
				<?php if(isset($_SESSION['mdp'])) echo '<li><a class="codrops-icon codrops-icon-profil" href="profil.php"><span>'. $langue->show_text('ProfilLinkPage') .'</span></a></li>'; ?>
			</ul>
		</div>

		<div id="myNav" class="overlay">
		  <a href="javascript:void(0)" class="closebtn" id="ClosenNav">&times;</a>
		  <div class="overlay-content">
<?php

		if($_SESSION['page_2'] == '1') echo '<a class="gn-icon gn-icon-table" href="quote.php" >'. $langue->show_text('QuoteLinkPage') .'</a> ';
		if($_SESSION['page_2'] == '1') echo '<a class="gn-icon gn-icon-table" href="order.php" >'. $langue->show_text('OrderLinkPage') .'</a> ';
		if($_SESSION['page_2'] == '1') echo '<a class="gn-icon gn-icon-table" href="planning.php" >'. $langue->show_text('PlanningLinkPage') .'</a> ';
		if($_SESSION['page_9'] == '1') echo '<a class="gn-icon gn-icon-calendar" href="calendar.php">'. $langue->show_text('CalendarLinkPage') .'</a>';
		if($_SESSION['page_3'] == '1') echo '<a class="gn-icon gn-icon-achat" href="purchase.php" >'. $langue->show_text('PurchaseLinkPage') .'</a>';
		if($_SESSION['page_5'] == '1') echo '<a class="gn-icon gn-icon-zoom-in" href="article.php" >'. $langue->show_text('ArticleLinkPage') .'</a>';
		if($_SESSION['page_6'] == '1') echo '<a class="gn-icon gn-icon-tags" href="quality.php" >'. $langue->show_text('QualityLinkPage') .'</a>';
		if($_SESSION['mdp']) echo '<a class="gn-icon gn-icon-logout" href="login.php?action=deconnexion">'. $langue->show_text('LogOutLinkPage') .'</a>';
?>
		  </div>
		</div>
<?php
	if($_SESSION['page_10'] == '1') echo '
		<div class="DivButtonAdmin">
			<button onclick="openDivMenu()">'. $langue->show_text('DisplaySettingAdmin') .'</button>
		</div>
		<div id="DivAdminListe" class="DivAdminListe">
			<ul class="admin-menu">
				<li><a class="" href="manage-company.php">'. $langue->show_text('GeneralSettingLinkPage') .'</a></li>
				<li><a class="" href="manage-companies.php">'. $langue->show_text('CustoProvidLinkPage') .'</a></li>
				<li><a class="" href="manage-time.php">'. $langue->show_text('SettingTimeLinkPage') .'</a></li>
				<li><a class="" href="manage-users.php">'. $langue->show_text('EmployeesLinkPage') .'</a></li>
				<li><a class="" href="manage-methodes.php">'. $langue->show_text('MethodLinkPage') .'</a></li>
				<li><a class="" href="manage-study.php">'. $langue->show_text('StudyLinkPage') .'</a></li>
				<li><a class="" href="manage-quality.php">'. $langue->show_text('QualitySettingLinkPage') .'</a></li>
				<li><a class="" href="manage-accounting.php">'. $langue->show_text('AccountingLinkPage') .'</a></li>
			</ul>
		</div>';
?>
