<?php
namespace App\UI;
use \App\SQL;

class UI Extends SQL  {

    Public $SearchMenu;

    Public Function GetSearchMenu($SQLData, $LinkPrefix , $PlaceholderValue, $LinkSuffix = ''){

        echo '<input type="text" id="myInput" onkeyup="myFunction()" placeholder="'. $PlaceholderValue.'">';
		echo '<ul id="myUL">';
						
		foreach ($SQLData as $data):
				
				if($data->ETAT == 1) $class="info";
				elseif($data->ETAT == 2) $class="warning";
				elseif($data->ETAT == 3) $class="success";
				elseif($data->ETAT == 6) $class="alert";
				else $class="normal";

				if($data->CUSTOMER_LABEL)$Label = $data->CUSTOMER_LABEL;
				else $Label = $data->LABEL;

				if($data->ORDER_CODE) $CODE = $data->ORDER_CODE;
				elseif($data->QUOTE_CODE)  $CODE = $data->QUOTE_CODE;
				else $CODE = $data->CODE;

				if($data->DEVIS_ID) $id = $data->DEVIS_ID;
				elseif($data->ORDER_ID) $id = $data->ORDER_ID;
				else $id = $data->id;
				
				

				
				echo '<li><a class='. $class .'  href="'. $LinkPrefix .'='. $id .''. $LinkSuffix .'">'. $CODE .' - '. $Label .'</a></li>';
		endforeach;
		
		echo '</ul>';

    }

	Public Function GetNewDocument($TableNew, $TableNumber , $CompaniesList = null, $Form, $submit){

			if($CompaniesList != null) {
				$ContentTableCompanies='<tr>
										<td>'.$TableNew  .'</td>
										<td>
											<select name="COMPANY_ID">
											'. $CompaniesList .'
											</select>
										</td>
									</tr>';


			}
					echo'<table class="content-table">
						<thead>
							<tr>
								<th colspan="2"><br/></th>
							</tr>
						</thead>
						<tbody>
							'. $ContentTableCompanies .'
							<tr>
								<td>'. $TableNumber .'</td>
								<td>'. $Form .'</td>
							</tr>
							<tr>
								<td></td>
								<td >'.  $submit .'</td>
							</tr>
						</tbody>
					</table>';
	}
}