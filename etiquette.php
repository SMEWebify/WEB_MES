<?php
	//phpinfo();

	//include pour la connection à la base SQL 
	require_once 'include/include_connection_sql.php';
	//include pour les fonctions
	require_once 'include/include_fonctions.php';
	//include pour les constantes
	require_once 'include/include_recup_config.php';
	
	$content = '';  
	
	$selected_checkbox = implode(",",$_POST['id_ligne']);

	$res = $bdd->query('select count(*) as nb  FROM `'. TABLE_ERP_PLANNING .'` WHERE id IN ('. $selected_checkbox . ')  AND sup!=1');
	$data = $res->fetch();
	$nb = $data['nb'];
		
	if($nb == 0){
			$content = '
						<p class="message">
							
								Aucune commande à afficher
							
						
							<input type="button" value="Retour" onClick="window.history.back()">
						</p>';
	}
	else{
		
		$content = '
		<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
			<title>Etiquette</title>
		</head>
		<body>
			<table style="width: 96%; border: 1px solid black; border-collapse: collapse; margin: auto; text-align:center;">';

		$tr = 0;
			
		$req = $bdd->prepare('SELECT * FROM `'. TABLE_ERP_PLANNING .'` WHERE id IN ('. $selected_checkbox . ')  AND sup!=1');
		$req->execute(array($selected_checkbox));
		while($donnees = $req->fetch())
		{
			if(isset($_POST['planning']) AND $_POST['planning'] == "etiquette_petite")
			{
				
				$content = $content.'
				<tr>
					<td style="width: 16%; text-align:center;">
						'. $donnees['COMMANDE'] .'
					</td>
					<td style="width: 30%; text-align:center;">
						'. $donnees['CLIENT'] .'
					</td>
					<td style="width: 16%; text-align:center;">
						'. $donnees['PLAN'] .'
					</td>
					<td style="width: 10%; text-align:center;">
						Qt '. $donnees['QT'] .'
					</td>
					<td style="width: 16%; text-align:center;">
						<barcode type="C39" value="'.strtoupper($donnees['id']) .'" style="color: #770000" ></barcode>
					</td>
				</tr>';
			}
			elseif(isset($_POST['planning']) AND $_POST['planning'] == "etiquette_grande")
			{
				if($tr == 0){
					$content = $content.'<tr>';
				}

				if($donnees['SUP'] == 3){
					$content = $content.'
						<td style="width: 50%;">
							<h2>
								<br/>
								<br/>
								<br/>
								'. $donnees['CLIENT'] .'<br/>
								<br/>
								N° Stock : '. $donnees['COMMANDE'] .'<br/>
								<br/>
								Ref : '. $donnees['PLAN'] .'<br/>
								<br/>
								Qt '. $donnees['QT_EXPEDIER'] .'<br/>
								<br/>
							</h2>
							<barcode type="C39" value="'.strtoupper($donnees['id']) .'" style="color: #770000" ></barcode><br/>
							<br/>
							<br/>
							<br/>
							<br/>
						</td>';
				}
				else{
					$content = $content.'
						<td style="width: 50%;">
							<h2>
								<br/>
								<br/>
								<br/>
								'. $donnees['CLIENT'] .'<br/>
								<br/>
								N° commande : '. $donnees['COMMANDE'] .'<br/>
								<br/>
								N° commande client : '. $donnees['CO_CLIENT'] .'<br/>
								<br/>
								Ref : '. $donnees['PLAN'] .'<br/>
								<br/>
								Qt '. $donnees['QT'] .'<br/>
								<br/>
							</h2>
							<barcode type="C39" value="'.strtoupper($donnees['id']) .'" style="color: #770000" ></barcode><br/>
							<br/>
							<br/>
							<br/>
							<br/>
						</td>';
					
				}
					
				$tr++;
				
				if($tr == 2){
					$content = $content.'</tr>';
					$tr = 0;
				}
				
				
			}
		}
		
		if($tr < 2 AND $tr>0) $content = $content.'<td style="width: 50%;"></td></tr>';
		
		$content = $content.'</table>
				 </body>
		</html>';
	}
	
	
		

	require_once('\librairie\html2pdf_v4.03\html2pdf.class.php');
	try
	{
		$html2pdf = new HTML2PDF('P', 'A4', 'fr','UTF-8');
		$html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output('etiquette.pdf');
		exit;
	}
	catch(HTML2PDF_exception $e) {
		echo $e;
		exit;
	}

?>