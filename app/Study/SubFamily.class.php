<?php

namespace App\Study;
use \App\SQL;

class SubFamily Extends SQL  {

    Public $id;
    Public $CODE;
    Public $LABEL;
    Public $PRESTATION_ID;
    Public $LABEL_PRESTATION;

    Public $SubFamilyList;

    public function GETSubFamily($id_GET){

        $SubFamily = $this->GetQuery('SELECT '. TABLE_ERP_UNIT .'.id,
                                                '. TABLE_ERP_UNIT .'.CODE,
                                                '. TABLE_ERP_UNIT .'.LABEL,
                                                '. TABLE_ERP_UNIT .'.TYPE
                                             FROM `'. TABLE_ERP_PRESTATION .'`
								              WHERE id=\''. $id_GET .'\'', true, 'App\Study\SubFamily');
        return $SubFamily;
    }

    public function GetSubFamilyList($IdData=0, $Select = true){
        $this->SubFamilyList = '';
        $query='SELECT '. TABLE_ERP_SOUS_FAMILLE .'.id,
                        '. TABLE_ERP_SOUS_FAMILLE .'.CODE,
                        '. TABLE_ERP_SOUS_FAMILLE .'.LABEL,
                        '. TABLE_ERP_SOUS_FAMILLE .'.PRESTATION_ID,
                        '. TABLE_ERP_PRESTATION .'.CODE AS CODE_PRESTATION,
                        '. TABLE_ERP_PRESTATION .'.LABEL AS LABEL_PRESTATION
                        FROM `'. TABLE_ERP_SOUS_FAMILLE .'`
                        LEFT JOIN `'. TABLE_ERP_PRESTATION .'` ON `'. TABLE_ERP_SOUS_FAMILLE .'`.`PRESTATION_ID` = `'. TABLE_ERP_PRESTATION .'`.`id`
                        ORDER BY Id';
         if($Select){
		     foreach ($this->GetQuery($query) as $data){
                 $this->SubFamilyList .='<option value="'. $data->id .'" '. selected($IdData, $data->id) .'>'. $data->LABEL .'</option>';
             }
              return  $this->SubFamilyList;
        }else {
            return  $this->GetQuery($query);
        }
    }
}
