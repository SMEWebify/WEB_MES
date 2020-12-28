<?php

namespace App\Quality;
use \App\SQL;

class QL_Defaut Extends SQL  {

    Public $id;
    Public $CODE;
    Public $LABEL;

    Public $QL_DefautList;

    public function GETQL_Defaut($id_GET){

        $Defaut = $this->GetQuery('SELECT '. TABLE_ERP_DEFAUT .'.id,
                                                '. TABLE_ERP_DEFAUT .'.CODE,
                                                '. TABLE_ERP_DEFAUT .'.LABEL
                                             FROM `'. TABLE_ERP_DEFAUT .'`
								              WHERE id=\''. $id_GET .'\'', true, 'App\Quality\QL_Defaut');
        return $Defaut;
    }

    public function GETQL_DefautList($IdData=0){

        $this->QL_DefautList ='<option value="0">Aucune</option>';
        $query='SELECT Id, CODE, LABEL   FROM '. TABLE_ERP_DEFAUT .'';
		foreach ($this->GetQuery($query) as $data){
           
			$this->QL_DefautList .='<option value="'. $data->Id .'" '. selected($IdData, $data->Id) .'>'. $data->LABEL .'</option>';
		}
        
        return  $this->QL_DefautList;
    }
}
