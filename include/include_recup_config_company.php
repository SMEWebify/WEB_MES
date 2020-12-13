<?php
$req = $bdd -> query('SELECT NAME,
							ADDRESS,
							ZIPCODE,
							REGION,
							COUNTRY,
							PHONE_NUMBER,
							MAIL,
							WEB_SITE,
							FACEBOOK_SITE,
							TWITTER_SITE,
							LKD_SITE,
							LOGO,
							SIREN,
							APE,
							TVA_INTRA,
							TAUX_TVA,
							CAPITAL,
							RCS
							FROM '. TABLE_ERP_COMPANY .'');
$donnees = $req->fetch();

$CompanyName = $donnees['NAME'];
$CompanyAddress = $donnees['ADDRESS'];
$CompanyZipCode= $donnees['ZIPCODE'];
$CompanyCountry = $donnees['COUNTRY'];
$CompanyRegion = $donnees['REGION'];
$CompanyPhone = $donnees['PHONE_NUMBER'];
$CompanyMail = $donnees['MAIL'];
$CompanyWebSite = $donnees['WEB_SITE'];
$CompanyFbSite = $donnees['FACEBOOK_SITE'];
$CompanyTwitter = $donnees['TWITTER_SITE'];
$CompanyLkd = $donnees['LKD_SITE'];
$CompanyLogo = $donnees['LOGO'];
$CompanySIREN = $donnees['SIREN'];
$CompanyAPE = $donnees['APE'];
$CompanyTVAINTRA = $donnees['TVA_INTRA'];
$CompanyTAUXTVA = $donnees['TAUX_TVA'];
$CompanyCAPITAL = $donnees['CAPITAL'];
$CompanyRCS = $donnees['RCS'];
?>
