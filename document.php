<?php session_start();

	header( 'content-type: text/html; charset=utf-8' );

	//phpinfo();

	// include for the constants
	require_once 'include/include_recup_config.php';
	//include for the connection to the SQL database
	require_once 'class/sql.class.php';
	$bdd = SQL::getInstance();
	// include for functions
	require_once 'include/include_fonctions.php';
	//session checking  user
	require_once 'include/include_checking_session.php';
	//load info company
	require_once 'include/include_recup_config_company.php';
	// load language class
	require_once 'class/language.class.php';
	$langue = new Langues('lang', 'profil', $UserLanguage);

	$req = $bdd -> query('SELECT NAME,
							ADDRESS,
							CITY,
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
		$CompanyCity = $donnees['CITY'];
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
	
	if(isset($_GET['id'])){$IDdevis = addslashes($_GET['id']);}
		
				
		$req = $bdd->query("SELECT COUNT(id) as nb FROM ". TABLE_ERP_DEVIS ." WHERE CODE = '". $IDdevis."'");
		$data = $req->fetch();
		$req->closeCursor();
		$nb = $data['nb'];
			
		if($nb=1){

				$req = $bdd -> query('SELECT '. TABLE_ERP_DEVIS .'.Id,
									'. TABLE_ERP_DEVIS .'.CODE,
									'. TABLE_ERP_DEVIS .'.INDICE,
									'. TABLE_ERP_DEVIS .'.LABEL,
									'. TABLE_ERP_DEVIS .'.LABEL_INDICE,
									'. TABLE_ERP_DEVIS .'.CLIENT_ID,
									'. TABLE_ERP_DEVIS .'.CONTACT_ID,
									'. TABLE_ERP_DEVIS .'.ADRESSE_ID,
									'. TABLE_ERP_DEVIS .'.FACTURATION_ID,
									DATE_FORMAT('. TABLE_ERP_DEVIS .'.DATE, "%d/%m/%Y"),
									'. TABLE_ERP_DEVIS .'.DATE_VALIDITE,
									'. TABLE_ERP_DEVIS .'.ETAT,
									'. TABLE_ERP_DEVIS .'.CREATEUR_ID,
									'. TABLE_ERP_DEVIS .'.RESP_COM_ID,
									'. TABLE_ERP_DEVIS .'.RESP_TECH_ID,
									'. TABLE_ERP_DEVIS .'.REFERENCE,
									'. TABLE_ERP_DEVIS .'.COND_REG_CLIENT_ID,
									'. TABLE_ERP_DEVIS .'.MODE_REG_CLIENT_ID,
									'. TABLE_ERP_DEVIS .'.ECHEANCIER_ID,
									'. TABLE_ERP_DEVIS .'.TRANSPORT_ID,
									'. TABLE_ERP_DEVIS .'.COMENT,
									'. TABLE_ERP_CLIENT_FOUR .'.NAME,
									'. TABLE_ERP_EMPLOYEES .'.NOM,
									'. TABLE_ERP_EMPLOYEES .'.PRENOM,
									'. TABLE_ERP_CONTACT .'.CIVILITE,
									'. TABLE_ERP_CONTACT .'.PRENOM AS PRENOM_CONTACT,
									'. TABLE_ERP_CONTACT .'.NOM AS NOM_CONTACT,
									'. TABLE_ERP_CONTACT .'.NUMBER AS NUMBER_CONTACT ,
									'. TABLE_ERP_CONTACT .'.MAIL AS MAIL_CONTACT,
									'. TABLE_ERP_CONDI_REG .'.LABEL AS CONDI_REG_LABEL,
									'. TABLE_ERP_MODE_REG .'.LABEL AS CONDI_MODE_LABEL,
									'. TABLE_ERP_TRANSPORT .'.LABEL AS TRANSPORT_LABEL,
									'. TABLE_ERP_ECHEANCIER_TYPE .'.LABEL AS ECHEANCIER_LABEL
									FROM `'. TABLE_ERP_DEVIS .'`
										LEFT JOIN `'. TABLE_ERP_CLIENT_FOUR .'` ON `'. TABLE_ERP_DEVIS .'`.`CLIENT_ID` = `'. TABLE_ERP_CLIENT_FOUR .'`.`id`
										LEFT JOIN `'. TABLE_ERP_EMPLOYEES .'` ON `'. TABLE_ERP_DEVIS .'`.`CREATEUR_ID` = `'. TABLE_ERP_EMPLOYEES .'`.`idUSER`
										LEFT JOIN `'. TABLE_ERP_CONTACT .'` ON `'. TABLE_ERP_DEVIS .'`.`CONTACT_ID` = `'. TABLE_ERP_CONTACT .'`.`id`
										LEFT JOIN `'. TABLE_ERP_CONDI_REG .'` ON `'. TABLE_ERP_DEVIS .'`.`COND_REG_CLIENT_ID` = `'. TABLE_ERP_CONDI_REG .'`.`id`
										LEFT JOIN `'. TABLE_ERP_MODE_REG .'` ON `'. TABLE_ERP_DEVIS .'`.`MODE_REG_CLIENT_ID` = `'. TABLE_ERP_MODE_REG .'`.`id`
										LEFT JOIN `'. TABLE_ERP_TRANSPORT .'` ON `'. TABLE_ERP_DEVIS .'`.`TRANSPORT_ID` = `'. TABLE_ERP_TRANSPORT .'`.`id`
										LEFT JOIN `'. TABLE_ERP_ECHEANCIER_TYPE .'` ON `'. TABLE_ERP_DEVIS .'`.`ECHEANCIER_ID` = `'. TABLE_ERP_ECHEANCIER_TYPE .'`.`id`
									WHERE '. TABLE_ERP_DEVIS .'.CODE = \''. $IDdevis.'\' ');
			$DonneesDevis = $req->fetch();
			$req->closeCursor();
			
			$titleOnglet1 = "Mettre à jours";
			
			$IDDevisSQL = $DonneesDevis['Id'];
			$CommentaireDevis = $DonneesDevis['COMENT'];
			$DevisCLIENT_ID = $DonneesDevis['CLIENT_ID'];
			$DevisCLIENT_NAME = $DonneesDevis['NAME'];
			
			$DevisCONTACT_ID = $DonneesDevis['CONTACT_ID'];
			$DevisCONTACT_CIVILITE = $DonneesDevis['CIVILITE'];
			$DevisCONTACT_PRENOM = $DonneesDevis['PRENOM_CONTACT'];
			$DevisCONTACT_NOM = $DonneesDevis['NOM_CONTACT'];
			$DevisCONTACT_NUMBER = $DonneesDevis['NUMBER_CONTACT'];
			$DevisCONTACT_MAIL = $DonneesDevis['MAIL_CONTACT'];
			
			$DevisNomName = $DonneesDevis['NOM'];
			$DevisNomPrenom = $DonneesDevis['PRENOM'];
			$DevisADRESSE_ID = $DonneesDevis['ADRESSE_ID'];
			$DevisFACTURATION_ID = $DonneesDevis['FACTURATION_ID'];
			$DevisRESP_COM_ID = $DonneesDevis['RESP_COM_ID'];
			$DevisRESP_TECH_ID = $DonneesDevis['RESP_TECH_ID'];
			$DevisCONDI_REG_ID = $DonneesDevis['COND_REG_CLIENT_ID'];
			$DevisCONDI_REG_LABEL = $DonneesDevis['CONDI_REG_LABEL'];
			
			
			$DevisMODE_REG_ID = $DonneesDevis['MODE_REG_CLIENT_ID'];
			$DevisMODE_REG_LABEL = $DonneesDevis['CONDI_MODE_LABEL'];
			
			$DevisMODE_DE_TRANSPORT = $DonneesDevis['TRANSPORT_LABEL'];
			$DevisECHEANCIER_LABEL = $DonneesDevis['ECHEANCIER_LABEL'];
			
			
			$DevisEcheancier_ID = $DonneesDevis['ECHEANCIER_ID'];
			$DevisTransport_ID = $DonneesDevis['TRANSPORT_ID'];
			
			$DevisCODE = $DonneesDevis['CODE'];
			$DevisINDICE = $DonneesDevis['INDICE'];
			$DevisLABEL = $DonneesDevis['LABEL'];
			$DevisLABEL_INDICE = $DonneesDevis['LABEL_INDICE'];
			
			$DevisDATE = $DonneesDevis['DATE'];
			$DevisDATE_VALIDITE = $DonneesDevis['DATE_VALIDITE'];
			$DevisETAT = $DonneesDevis['ETAT'];
			$DevisREFERENCE = $DonneesDevis['REFERENCE'];
			
			$req = $bdd -> query('SELECT  '. TABLE_ERP_DEVIS_LIGNE .'.Id, 
														'. TABLE_ERP_DEVIS_LIGNE .'.ORDRE,
														'. TABLE_ERP_DEVIS_LIGNE .'.ARTICLE_CODE,
														'. TABLE_ERP_DEVIS_LIGNE .'.LABEL,
														'. TABLE_ERP_DEVIS_LIGNE .'.QT,
														'. TABLE_ERP_DEVIS_LIGNE .'.UNIT_ID,
														'. TABLE_ERP_DEVIS_LIGNE .'.PRIX_U,
														'. TABLE_ERP_DEVIS_LIGNE .'.REMISE,
														'. TABLE_ERP_DEVIS_LIGNE .'.TVA_ID,
														DATE_FORMAT('. TABLE_ERP_DEVIS_LIGNE .'.DELAIS, "%d/%m/%Y"),
														'. TABLE_ERP_DEVIS_LIGNE .'.ETAT,
														'. TABLE_ERP_TVA .'.TAUX,
														'. TABLE_ERP_TVA .'.LABEL AS LABEL_TVA,
														'. TABLE_ERP_UNIT .'.LABEL AS LABEL_UNIT
														FROM '. TABLE_ERP_DEVIS_LIGNE .'
															LEFT JOIN `'. TABLE_ERP_TVA .'` ON `'. TABLE_ERP_DEVIS_LIGNE .'`.`TVA_ID` = `'. TABLE_ERP_TVA .'`.`id`
															LEFT JOIN `'. TABLE_ERP_UNIT .'` ON `'. TABLE_ERP_DEVIS_LIGNE .'`.`UNIT_ID` = `'. TABLE_ERP_UNIT .'`.`id`
															WHERE '. TABLE_ERP_DEVIS_LIGNE .'.DEVIS_ID = \''. $IDDevisSQL.'\' 
														ORDER BY '. TABLE_ERP_DEVIS_LIGNE .'.ORDRE ');
						$tableauTVA = array();
						
			while ($DonneesListeLigneDuDevis = $req->fetch()){
							
							$TotalLigneHTEnCours = ($DonneesListeLigneDuDevis['QT']*$DonneesListeLigneDuDevis['PRIX_U'])-($DonneesListeLigneDuDevis['QT']*$DonneesListeLigneDuDevis['PRIX_U'])*($DonneesListeLigneDuDevis['REMISE']/100); 
							$TotalLigneTVAEnCours =  $TotalLigneHTEnCours*($DonneesListeLigneDuDevis['TAUX']/100) ;
							$TotalLigneTTCEnCours = $TotalLigneTVAEnCours+$TotalLigneHTEnCours;
							
							$TotalLigneDevisHT += $TotalLigneHTEnCours;
							$TotalLigneDevisTTC += $TotalLigneTVAEnCours+$TotalLigneHTEnCours;
							
							if(array_key_exists($DonneesListeLigneDuDevis['TVA_ID'], $tableauTVA)){
								$tableauTVA[$DonneesListeLigneDuDevis['TVA_ID']][0] += $TotalLigneHTEnCours;
								$tableauTVA[$DonneesListeLigneDuDevis['TVA_ID']][2] += $TotalLigneTVAEnCours;
								$tableauTVA[$DonneesListeLigneDuDevis['TVA_ID']][3] += $TotalLigneTTCEnCours;
							}
							else{
								$tableauTVA[$DonneesListeLigneDuDevis['TVA_ID']] = array($TotalLigneHTEnCours, $DonneesListeLigneDuDevis['TAUX'], $TotalLigneTVAEnCours, $TotalLigneTTCEnCours);
							}
							
							$DetailLigneDuDevis .='
							<tr>
								<td>'. $DonneesListeLigneDuDevis['LABEL'] .'</td>
								<td>'. $DonneesListeLigneDuDevis['QT'] .'</td>
								<td>'. $DonneesListeLigneDuDevis['PRIX_U'] .'</td>
								<td>'. $DonneesListeLigneDuDevis['LABEL_UNIT'] .'</td>
								<td>'. $DonneesListeLigneDuDevis['REMISE'] .' %</td>
								<td>'. $TotalLigne .' €</td>
								<td>'. $DonneesListeLigneDuDevis['DELAIS'] .'</td>
							</tr>';
						}
						
				asort($tableauTVA);
				 foreach($tableauTVA as $key => $value){
					
					$DetailLigneTVA .='
						<tr>
							<th>'. $tableauTVA[$key][0] . ' €</th>
							<th>'. $tableauTVA[$key][1] . ' %</th>
							<th>'. $tableauTVA[$key][2] . ' €</th>
							<th>'. $tableauTVA[$key][3] . ' €</th>
						</tr>';
				}
		}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'>
<head>
	<link rel="stylesheet" media="screen" type="text/css" title="deco" href="css/ScreenDocument.css" />
	<link rel="stylesheet" media="print" type="text/css" title="deco" href="css/PrintDocument.css" />
</head>
<body>
<script type="text/javascript">
    function Export2Doc(element, filename = ''){
        var html = "<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'><head><meta charset='utf-8'><title>Export HTML To Doc</title></head><body>";
        var footer = "</body></html>";
        var html = html+document.getElementById(element).innerHTML+footer;
    
        
        //link url
        var url = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(html);
        
        //file name
        filename = filename?filename+'.doc':'document.doc';
        
        // Creates the  download link element dynamically
        var downloadLink = document.createElement("a");
    
        document.body.appendChild(downloadLink);
        
        //Link to the file
        downloadLink.href = url;
            
        //Setting up file name
        downloadLink.download = filename;
            
        //triggering the function
        downloadLink.click();
        //Remove the a tag after donwload starts.
        document.body.removeChild(downloadLink);
    }
</script>

<script type="text/javascript">
printPdf = function (url) {
  var iframe = this._printIframe;
  if (!this._printIframe) {
    iframe = this._printIframe = document.createElement('iframe');
    document.body.appendChild(iframe);

    iframe.style.display = 'none';
    iframe.onload = function() {
      setTimeout(function() {
        iframe.focus();
        iframe.contentWindow.print();
      }, 1);
    };
  }

  iframe.src = url;
}
</script>
<button onclick="Export2Doc('content-to-pdf');" class="bouton">Export en .doc</button>
<button onclick="printPdf('<?="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>');" class="bouton">Export en .pdf</button>
	<div id="content-to-pdf">
		<page size="A4">
			<table class="content-table-entete">
					<tr>
						<td colspan="5">
									 <img src="<?= "http://" . $_SERVER['HTTP_HOST'] . "/erp/" . $CompanyLogo   ?>" title="LOGO entreprise" alt="Logo" style="width:100px"/>
						</td>
						<td colspan="5" class="TitreDevis">
									 <h1>DEVIS</h1> 
									 <h2  style="text-decoration: underline;">N° <?=$DevisCODE ?></h2>
									 <h2><?=date("m-d-Y");  ?></h2>
						</td>
					</tr>
					<tr>
						<td colspan="5" class="CompanyContact">
									<table >
										<tr>
											<td>
												<h3>Contact :</h3>
											</td>
										</tr>
										<tr>
											<td>
											<?= $DevisNomName .' '. $DevisNomPrenom ?>
											</td>
										</tr>
										<tr>
											<td>
											<?= $CompanyPhone?>
											</td>
										</tr>
										<tr>
											<td>
											<?= $CompanyMail ?>
											</td>
										</tr>
									</table>
						</td>
						<td colspan="5" class="CustomersContact">
							<table style="float: right">
										<tr>
											<td>
												<h3>A l'attention de  :</h3>
											</td>
										</tr>
										<tr>
											<td>
											<?= $DevisCLIENT_NAME .' - '. $DevisCONTACT_CIVILITE .' '. $DevisCONTACT_NAME .' - '. $DevisCONTACT_PRENOM ?>
											</td>
										</tr>
										<tr>
											<td>
											<?= $CompanyAddress?>
											</td>
										</tr>
										<tr>
											<td>
											<?= $CompanyZipCode. ' '. $CompanyCity?>
											</td>
										</tr>
										<tr>
											<td>
											<?= $DevisCONTACT_NUMBER ?>
											</td>
										</tr>
										<tr>
											<td>
											<?= $DevisCONTACT_MAIL ?>
											</td>
										</tr>
							</table>
						</td>
					</tr>
				</table>
				<table class="content-table"
					<tr>
						<td colspan="10" class="CompanyContact">
							Votre référence : <?= $DevisREFERENCE?>
						</td>
					</tr>
				</table>
				<table class="content-table">
					<thead>
						<tr>
								<th>Désignation</th>
								<th>Quantité</th>
								<th>Prix U H.T.</th>
								<th>Unité</th>
								<th>Remise</th>
								<th>Total H.T.</th>
								<th>Délais</th>
						</tr>
					</thead>
					<tbody>
						<?=$DetailLigneDuDevis ?>
						<tr>
							<td colspan="3">
									<table style="float: left">
										<tr>
											<td>
												 <B>Condition de réglement :  </B>
											</td>
											<td>
												<?= $DevisCONDI_REG_LABEL?>
											</td>
										</tr>
										<tr>
											<td>
												 <B>Mode de réglement :</B>
											</td>
											<td>
												<?= $DevisMODE_REG_LABEL?>
											</td>
										</tr>
										<tr>
											<td>
												 <B>Mode de transport :</B>
											</td>
											<td>
													<?= $DevisMODE_DE_TRANSPORT ?>
											</td>
										</tr>
										<tr>
											<td>
												 <B>Echéancier :</B>
											</td>
											<td>
													<?= $DevisECHEANCIER_LABEL ?>
											</td>
										</tr>
										
								</table>
							</td>
							<td colspan="7">
								<table style="float: right">
										<?=$DetailLigneTVA; ?>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
		</page>
	</div>
</body>
</html>