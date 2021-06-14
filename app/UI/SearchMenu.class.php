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

				echo '<li><a class='. $class .'  href="'. $LinkPrefix .'='. $data->id .''. $LinkSuffix .'">'. $data->CODE .' - '. $data->LABEL .'</a></li>';
		endforeach;
		
		echo '</ul>';

    }

}