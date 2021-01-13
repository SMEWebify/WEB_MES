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

    public function GETQL_DefautList($IdData=0, $Select = true){

        $this->QL_DefautList ='';
        $query='SELECT '. TABLE_ERP_DEFAUT .'.id,
                        '. TABLE_ERP_DEFAUT .'.CODE,
                        '. TABLE_ERP_DEFAUT .'.LABEL
                        FROM `'. TABLE_ERP_DEFAUT .'`
                        ORDER BY id';
        if($Select){
            foreach ($this->GetQuery($query) as $data){
            
                $this->QL_DefautList .='<option value="'. $data->id .'" '. selected($IdData, $data->id) .'>'. $data->LABEL .'</option>';
            }
        
          return  $this->QL_DefautList;
        }else {
            return  $this->GetQuery($query);
        } 
    }
}
