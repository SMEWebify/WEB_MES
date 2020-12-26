<?php

namespace App\Methods;
use \App\SQL;

class Section Extends SQL  {

    Public $id;
    Public $ORDRE;
    Public $CODE;
    Public $LABEL;
    Public $COUT_H;
    Public $RESPONSABLE;
    Public $COLOR;

    Public $SectionList;

    public function GETSection($id_GET_SECTION){


    }

    public function GetSectionList($IdData=0){

        $this->SectionList ='<option value="0">Aucune</option>';
        $query='SELECT Id, LABEL   FROM '. TABLE_ERP_SECTION .'';
		foreach ($this->GetQuery($query) as $data){
			$this->SectionList .='<option value="'. $data->Id .'" '. selected($IdData, $data->Id) .'>'. $data->LABEL .'</option>';
		}
        
        return  $this->SectionList;
    }
}
