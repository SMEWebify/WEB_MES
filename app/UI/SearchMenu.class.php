<?php
namespace App\UI;
use \App\SQL;

class SearchMenu Extends SQL  {

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
				else $id = $data->id;
				
				if($data->ORDER_ID) $id = $data->ORDER_ID;
				else $id = $data->id;
				
				echo '<li><a class='. $class .'  href="'. $LinkPrefix .'='. $id .''. $LinkSuffix .'">'. $CODE .' - '. $Label .'</a></li>';
		endforeach;
		
		echo '</ul>';

    }

}