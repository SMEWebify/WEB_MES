<?php

namespace App\Accounting;
use \App\SQL;

class PaymentMethod Extends SQL  {

    public  $PaymentMethodList;

    public function NewPaymentMethod($CODE, $LABEL, $AccounCode){
        $NewPaymentMethod = $this->GetInsert("INSERT INTO ". TABLE_ERP_MODE_REG ." VALUE ('0',
                                                                                        '". addslashes($CODE) ."',
                                                                                        '". addslashes($LABEL) ."',
                                                                                        '". addslashes($AccounCode) ."')");
        return $NewPaymentMethod;
    }

    public function GETPaymentMethodList($IdData=0, $Select = true){

        $this->PaymentMethodList ='';
        $query='SELECT id, CODE, LABEL,CODE_COMPTABLE FROM '. TABLE_ERP_MODE_REG .' ORDER BY id';
        if($Select){
            foreach ( $this->GetQuery($query) as $data){
                $this->PaymentMethodList .='<option value="'. $data->id .'" '. selected($IdData, $data->id) .'>'. $data->CODE .' - '. $data->LABEL .'</option>';
            }
            
            return  $this->PaymentMethodList;
        }else {
            return  $this->GetQuery($query);
        } 
    }
}