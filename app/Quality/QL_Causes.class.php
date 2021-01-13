<?php

namespace App\Quality;
use \App\SQL;

class QL_Causes Extends SQL  {

    Public $id;
    Public $CODE;
    Public $LABEL;

    Public $QL_CausesList;

    public function GETQL_Causes($id_GET){

        $Causes = $this->GetQuery('SELECT '. TABLE_ERP_QL_CAUSES .'.id,
                                                '. TABLE_ERP_QL_CAUSES .'.CODE,
                                                '. TABLE_ERP_QL_CAUSES .'.LABEL
                                             FROM `'. TABLE_ERP_QL_CAUSES .'`
								              WHERE id=\''. $id_GET .'\'', true, 'App\Quality\QL_Causes');
        return $Causes;
    }

    public function GETQL_CausesList($IdData=0,  $Select = true){

        $this->QL_CausesList ='';
        $query='SELECT '. TABLE_ERP_QL_CAUSES .'.id,
                        '. TABLE_ERP_QL_CAUSES .'.CODE,
                        '. TABLE_ERP_QL_CAUSES .'.LABEL
                        FROM `'. TABLE_ERP_QL_CAUSES .'`
                        ORDER BY CODE';
        if($Select){

            foreach ($this->GetQuery($query) as $data){
            
                $this->QL_CausesList .='<option value="'. $data->id .'" '. selected($IdData, $data->id) .'>'. $data->LABEL .'</option>';
            }
            
            return  $this->QL_CausesList;
        }else {

            return  $this->GetQuery($query);
        }  
    }
}
