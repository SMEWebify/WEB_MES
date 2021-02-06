<?php

namespace App\Accounting;
use \App\SQL;


class Delevery Extends SQL  {

    Public  $DeleveryList;

    public function NewDelevery($CODE, $LABEL){
        $NewDelevery = $this->GetInsert("INSERT INTO ". TABLE_ERP_TRANSPORT ." VALUE ('0',
                                                                                '". addslashes($CODE) ."',
                                                                                '". addslashes($LABEL) ."')");
        return $NewDelevery;
    }

    public function GETDeleveryList($IdData=0, $Select = true){

        $this->DeleveryList ='';
        $query='SELECT '. TABLE_ERP_TRANSPORT .'.id,
                        '. TABLE_ERP_TRANSPORT .'.CODE,
                        '. TABLE_ERP_TRANSPORT .'.LABEL
                        FROM `'. TABLE_ERP_TRANSPORT .'`
                        ORDER BY CODE';
        if($Select){
            foreach ( $this->GetQuery($query) as $data){
                $this->DeleveryList .='<option value="'. $data->id .'" '. selected($IdData, $data->id) .'>'. $data->CODE .' - '. $data->LABEL .'</option>';
            }
        
            return  $this->DeleveryList;
        }else {
            return  $this->GetQuery($query);
        } 
    }
}