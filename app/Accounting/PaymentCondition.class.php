<?php

namespace App\Accounting;
use \App\SQL;


class PaymentCondition Extends SQL  {

    public  $PaymentConditionList;

    public function GETPaymentConditionList($IdData=0){

        $query='SELECT Id, CODE, LABEL FROM '. TABLE_ERP_CONDI_REG .' ORDER BY Id';
        foreach ( $this->GetQuery($query) as $data){
            $this->PaymentConditionList .='<option value="'. $data->Id .'" '. selected($IdData, $data->Id) .'>'. $data->CODE .' - '. $data->LABEL .'</option>';
        }
        
        return  $this->PaymentConditionList;
    }
}