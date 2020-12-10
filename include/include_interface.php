		<div class="container">
			<ul id="gn-menu" class="gn-menu-main">
				<li><a  href="#" onclick="openNav()">&#9776; Menu</a></li>
				<li><a class="codrops-icon codrops-icon-back" href="<?php $_SERVER['HTTP_REFERER'] ?>">Retour</a></li>
				<?php if($_SESSION['page_1'] == '1') echo  '<li><a class="codrops-icon codrops-icon-home" href="index.php">'. $CompanyName .'</a></li>' ?>
				<?php if(isset($_SESSION['mdp'])) echo '<li><a class="codrops-icon codrops-icon-profil" href="profil.php"><span>Profil</span></a></li>'; ?>
			</ul>
		</div>

		<div id="myNav" class="overlay">
		  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
		  <div class="overlay-content">
<?php

		if($_SESSION['page_2'] == '1') echo '<a class="gn-icon gn-icon-table" href="devis.php" >Devis</a> ';
		if($_SESSION['page_2'] == '1') echo '<a class="gn-icon gn-icon-table" href="order.php" >Commandes</a> ';
		if($_SESSION['page_2'] == '1') echo '<a class="gn-icon gn-icon-table" href="planning.php" >Planning</a> ';
		if($_SESSION['page_9'] == '1') echo '<a class="gn-icon gn-icon-calendar" href="calendrier.php">Calendrier </a>';
		if($_SESSION['page_3'] == '1') echo '<a class="gn-icon gn-icon-achat" href="soustraitance.php" >Achats</a>';
		if($_SESSION['page_5'] == '1') echo '<a class="gn-icon gn-icon-zoom-in" href="article.php" >Articles</a>';
		if($_SESSION['page_6'] == '1') echo '<a class="gn-icon gn-icon-tags" href="qualite.php" >Qualité</a>';
		if($_SESSION['mdp']) echo '<a class="gn-icon gn-icon-logout" href="connexion.php?action=deconnexion"> Déconnexion</a>';
?>
		  </div>
		</div>
<script>
function openNav() {
  document.getElementById("myNav").style.width = "100%";
}

function closeNav() {
  document.getElementById("myNav").style.width = "0%";
}

</script>


<?php
	if($_SESSION['page_10'] == '1') echo '
		<div class="DivButtonAdmin">
			<button onclick="openDivMenu()">Réduire la gestion</button>
		</div>
		<div id="DivAdminListe" class="DivAdminListe">
			<ul class="admin-menu">
				<li>
					<a class="" href="gestion.php">Paramètres généraux</a>
				</li>
				<li>
					<a class="" href="clientfourni.php">Client et Fournisseur</a>
				</li>
				<li>
					<a class="" href="temps.php">Gestion du temps</a>
				</li>
				<li>
					<a class="" href="users.php">Employés et utilisateurs</a>
				</li>
				<li>
					<a class="" href="methodes.php">Méthodes</a>
				</li>
				<li>
					<a class="" href="etudes.php">Etudes</a>
				</li>
				<li>
					<a class="" href="admqualite.php">Qualité</a>
				</li>
				<li>
					<a class="" href="compta.php">Comptabilité</a>
				</li>
			</ul>
		</div>';
?>
