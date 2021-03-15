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

    public function GetSectionList($IdData=0, $Select = true){
        $this->SectionList ='';
        $query='SELECT Id, LABEL   FROM '. TABLE_ERP_SECTION .' ORDER BY ORDRE';

        if($Select){
            foreach ($this->GetQuery($query) as $data){
                $this->SectionList .='<option value="'. $data->Id .'" '. selected($IdData, $data->Id) .'>'. $data->LABEL .'</option>';
            }
            
            return  $this->SectionList;
        }else {
            return  $this->GetQuery($query);
        }
    }
}
