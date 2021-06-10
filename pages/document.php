<?php 
	//phpinfo();
	use \App\Autoloader;
	use \App\UI\Form;
	use \App\COMPANY\Company;
	use \App\Quote\Quote;
	use \App\Quote\QuoteLines;

	//auto load class
	require_once '../app/Autoload.class.php';
	Autoloader::register();
	
	session_start();
	header( 'content-type: text/html; charset=utf-8' );
	//init form class
	$Form = new Form($_POST);
	$Company = new Company();
	$Quote = new Quote();
	$QuoteLines = new QuoteLines();

	$DataCompany= $Company->GETCompany();

		$CompanyName = $DataCompany->NAME;
		$CompanyAddress =$DataCompany->ADDRESS;
		$CompanyCity =$DataCompany->CITY;
		$CompanyZipCode=$DataCompany->ZIPCODE;
		$CompanyCountry =$DataCompany->COUNTRY;
		$CompanyRegion =$DataCompany->REGION;
		$CompanyPhone =$DataCompany->PHONE_NUMBER;
		$CompanyMail =$DataCompany->MAIL;
		$CompanyWebSite =$DataCompany->WEB_SITE;
		$CompanyFbSite =$DataCompany->FACEBOOK_SITE;
		$CompanyTwitter =$DataCompany->TWITTER_SITE;
		$CompanyLkd =$DataCompany->LKD_SITE;
		$CompanyLogo =$DataCompany->PICTURE_COMPANY;
		$CompanySIREN =$DataCompany->SIREN;
		$CompanyAPE =$DataCompany->APE;
		$CompanyTVAINTRA =$DataCompany->TVA_INTRA;
		$CompanyTAUXTVA =$DataCompany->TAUX_TVA;
		$CompanyCAPITAL =$DataCompany->CAPITAL;
		$CompanyRCS =$DataCompany->RCS;
	
	if(isset($_GET['id'])){$Id = addslashes($_GET['id']);}
		

			//Load data
			$Maindata= $Quote->GETQuote($Id);
			
			$IDDevisSQL = $Maindata->id;
			$CommentaireDevis = $Maindata->COMENT;
			$DevisCLIENT_ID = $Maindata->CLIENT_ID;
			$DevisCLIENT_NAME = $Maindata->NAME;
			
			$DevisCONTACT_ID = $Maindata->CONTACT_ID;
			$DevisCONTACT_CIVILITE = $Maindata->CIVILITE;
			$DevisCONTACT_PRENOM = $Maindata->PRENOM_CONTACT;
			$DevisCONTACT_NOM = $Maindata->NOM_CONTACT;
			$DevisCONTACT_NUMBER = $Maindata->NUMBER_CONTACT;
			$DevisCONTACT_MAIL = $Maindata->MAIL_CONTACT;
			
			$DevisNomName = $Maindata->NOM;
			$DevisNomPrenom = $Maindata->PRENOM;
			$DevisADRESSE_ID = $Maindata->ADRESSE_ID;
			$DevisFACTURATION_ID = $Maindata->FACTURATION_ID;
			$DevisRESP_COM_ID = $Maindata->RESP_COM_ID;
			$DevisRESP_TECH_ID = $Maindata->RESP_TECH_ID;
			
			$DevisCONDI_REG_ID = $Maindata->COND_REG_CLIENT_ID;
			$DevisCONDI_REG_LABEL = $Maindata->COND_REG_LABEL;
			
			
			$DevisMODE_REG_ID = $Maindata->MODE_REG_CLIENT_ID;
			$DevisMODE_REG_LABEL = $Maindata->MODE_REG_LABEL;
			
			$DevisMODE_DE_TRANSPORT = $Maindata->TRANSPORT_LABEL;
			$DevisECHEANCIER_LABEL = $Maindata->ECHEANCIER_LABEL;
			
			
			$DevisEcheancier_ID = $Maindata->ECHEANCIER_ID;
			$DevisTransport_ID = $Maindata->TRANSPORT_ID;
			
			$DevisCODE = $Maindata->CODE;
			$DevisINDICE = $Maindata->INDICE;
			$DevisLABEL = $Maindata->LABEL;
			$DevisLABEL_INDICE =$Maindata->LABEL_INDICE;
			
			$DevisDATE = $Maindata->DATE;
			$DevisDATE_VALIDITE = $Maindata->DATE_VALIDITE;
			$DevisETAT = $Maindata->ETAT;
			$DevisREFERENCE = $Maindata->REFERENCE;
			
			$reqLines= $QuoteLines->GETQuoteLineList('', false,  $Id);
			$tableauTVA = array();
			foreach ($reqLines as $data){
							
							$TotalLigneHTEnCours = ($data->QT*$data->PRIX_U)-($data->QT*$data->PRIX_U)*($data->REMISE/100); 
							$TotalLigneTVAEnCours =  $TotalLigneHTEnCours*($data->TAUX/100) ;
							$TotalLigneTTCEnCours = $TotalLigneTVAEnCours+$TotalLigneHTEnCours;
							
							$TotalLigneDevisHT += $TotalLigneHTEnCours;
							$TotalLigneDevisTTC += $TotalLigneTVAEnCours+$TotalLigneHTEnCours;
							
							if(array_key_exists($data->TVA_ID, $tableauTVA)){
								$tableauTVA[$data->TVA_ID][0] += $TotalLigneHTEnCours;
								$tableauTVA[$data->TVA_ID][2] += $TotalLigneTVAEnCours;
								$tableauTVA[$data->TVA_ID][3] += $TotalLigneTTCEnCours;
							}
							else{
								$tableauTVA[$data->TVA_ID] = array($TotalLigneHTEnCours, $data->TAUX, $TotalLigneTVAEnCours, $TotalLigneTTCEnCours);
							}
							
							$DetailLigneDuDevis .='
							<tr>
								<td>'. $data->LABEL .'</td>
								<td>'. $data->QT .'</td>
								<td>'. $data->PRIX_U .'</td>
								<td>'. $data->LABEL_UNIT .'</td>
								<td>'. $data->REMISE .' %</td>
								<td>'. $TotalLigne .' €</td>
								<td>'. $data->DELAIS .'</td>
							</tr>';
							$i++; 
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
				<table class="content-table">
					<thead>
						<tr>
							<td colspan="3" class="Picture">
									 <img src="<?= "http://" . $_SERVER['HTTP_HOST'] . "/erp/public/images/Clients/" . $CompanyLogo   ?>" title="LOGO entreprise" alt="Logo" style="width:100px"/>
							</td>
							<td colspan="7" class="TitreDevis">
									 <h1>DEVIS</h1> 
									 <h2  style="text-decoration: underline;">N° <?=$DevisCODE ?></h2>
									 <h2><?=date("m-d-Y");  ?></h2>
							</td>
						</tr>
						<tr>
							<td colspan="5" class="CompanyContact">
									<table>
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
									<table>
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
						<tr>
							<td colspan="10" class="CompanyContact">
								Votre référence : <?= $DevisREFERENCE?>
							</td>
						</tr>
				</thead>
				<tbody>
					<tr>
							<th>Désignation</th>
							<th>Quantité</th>
							<th>Prix U H.T.</th>
							<th>Unité</th>
							<th>Remise</th>
							<th>Total H.T.</th>
							<th>Délais</th>
					</tr>
					<?=$DetailLigneDuDevis ?>
				</tbody>
				<tfoot>
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
				</foot>
			</table>
		</page>
	</div>
</body>
</html>
