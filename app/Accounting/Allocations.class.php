<?php

namespace App\Accounting;
use \App\SQL;


class Allocations Extends SQL  {

    Public  $AllocationsList;

    public function GETAllocationsList($IdData=0, $Select = true){

        $this->AllocationsList ='';
        $query='SELECT '. TABLE_ERP_IMPUT_COMPTA .'.id,
                        '. TABLE_ERP_IMPUT_COMPTA .'.CODE,
                        '. TABLE_ERP_IMPUT_COMPTA .'.LABEL,
                        '. TABLE_ERP_IMPUT_COMPTA .'.TVA,
                        '. TABLE_ERP_IMPUT_COMPTA .'.COMPTE_TVA,
                        '. TABLE_ERP_IMPUT_COMPTA .'.CODE_COMPTA,
                        '. TABLE_ERP_IMPUT_COMPTA .'.TYPE_IMPUTATION,
                        '. TABLE_ERP_TVA .'.TAUX,
                        '. TABLE_ERP_TVA .'.LABEL AS LABEL_TVA
                        FROM `'. TABLE_ERP_IMPUT_COMPTA .'`
                            LEFT JOIN `'. TABLE_ERP_TVA .'` ON `'. TABLE_ERP_IMPUT_COMPTA .'`.`TVA` = `'. TABLE_ERP_TVA .'`.`id`
                        ORDER BY CODE';

        if($Select){
            foreach ( $this->GetQuery($query) as $data){
                $this->AllocationsList .='<option value="'. $data->id .'" '. selected($IdData, $data->id) .'>'. $data->CODE .' - '. $data->LABEL .'</option>';
            }
    
            return  $this->AllocationsList;
        }else {
            return  $this->GetQuery($query);
        } 
    }
}