<?php

namespace App\Quality;
use \App\SQL;

class QL_Corrections Extends SQL  {

    Public $id;
    Public $CODE;
    Public $LABEL;

    Public $QL_CorrectionsList;

    public function GETQL_Corrections($id_GET){

        $Corrections = $this->GetQuery('SELECT '. TABLE_ERP_QL_CORRECTIONS .'.id,
                                                '. TABLE_ERP_QL_CORRECTIONS .'.CODE,
                                                '. TABLE_ERP_QL_CORRECTIONS .'.LABEL
                                             FROM `'. TABLE_ERP_QL_CORRECTIONS .'`
								              WHERE id=\''. $id_GET .'\'', true, 'App\Quality\QL_Corrections');
        return $Corrections;
    }

    public function GETQL_CorrectionsList($IdData=0, $Select = true){

        $this->QL_CorrectionsList ='';
        $query='SELECT '. TABLE_ERP_QL_CORRECTIONS .'.id,
                        '. TABLE_ERP_QL_CORRECTIONS .'.CODE,
                        '. TABLE_ERP_QL_CORRECTIONS .'.LABEL
                        FROM `'. TABLE_ERP_QL_CORRECTIONS .'`
                        ORDER BY CODE';

        if($Select){
            foreach ($this->GetQuery($query) as $data){
            
                $this->QL_CorrectionsList .='<option value="'. $data->id .'" '. selected($IdData, $data->id) .'>'. $data->LABEL .'</option>';
            }
            return  $this->QL_CorrectionsList;

        }else {
            return  $this->GetQuery($query);
        }  
    }
}
