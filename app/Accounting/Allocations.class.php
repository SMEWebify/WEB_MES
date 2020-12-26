<?php

namespace App\Accounting;
use \App\SQL;


class Allocations Extends SQL  {

    Public  $AllocationsList;

    public function GETAllocationsList($IdData=0){

        $this->AllocationsList ='<option value="0">Aucune</option>';
        $query='SELECT '. TABLE_ERP_IMPUT_COMPTA .'.Id,
                        '. TABLE_ERP_IMPUT_COMPTA .'.CODE,
                        '. TABLE_ERP_IMPUT_COMPTA .'.LABEL
                        FROM `'. TABLE_ERP_IMPUT_COMPTA .'`
                        ORDER BY Id';
        foreach ( $this->GetQuery($query) as $data){
            $this->AllocationsList .='<option value="'. $data->Id .'" '. selected($IdData, $data->Id) .'>'. $data->CODE .' - '. $data->LABEL .'</option>';
        }
        
        return  $this->AllocationsList;
    }
}