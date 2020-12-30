<?php

namespace App\Accounting;
use \App\SQL;


class PaymentMethod Extends SQL  {

    public  $PaymentMethodList;

    public function GETPaymentMethodList($IdData=0){

        $query='SELECT Id, CODE, LABEL FROM '. TABLE_ERP_MODE_REG .' ORDER BY Id';
        foreach ( $this->GetQuery($query) as $data){
            $this->PaymentMethodList .='<option value="'. $data->Id .'" '. selected($IdData, $data->Id) .'>'. $data->CODE .' - '. $data->LABEL .'</option>';
        }
        
        return  $this->PaymentMethodList;
    }
}