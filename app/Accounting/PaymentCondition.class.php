<?php

namespace App\Accounting;
use \App\SQL;

class PaymentCondition Extends SQL  {

    public  $PaymentConditionList;

    public function NewPaymentCondition($CODE, $LABEL, $MonthNumber, $DayNumber,$EndMonth){
        $NewPaymentCondition = $this->GetInsert("INSERT INTO ". TABLE_ERP_CONDI_REG ." VALUE ('0',
                                                                                            '". addslashes($CODE) ."',
                                                                                            '". addslashes($LABEL) ."',
                                                                                            '". addslashes($MonthNumber) ."',
                                                                                            '". addslashes($DayNumber) ."',
                                                                                            '". addslashes($EndMonth) ."')");
        return $NewPaymentCondition;
    }

    public function GETPaymentConditionList($IdData=0, $Select = true){

        $this->PaymentConditionList ='';
        $query='SELECT id, CODE, LABEL, NBR_MOIS, NBR_JOURS, FIN_MOIS FROM '. TABLE_ERP_CONDI_REG .' ORDER BY id';
        if($Select){
            foreach ( $this->GetQuery($query) as $data){
                $this->PaymentConditionList .='<option value="'. $data->id .'" '. selected($IdData, $data->id) .'>'. $data->CODE .' - '. $data->LABEL .'</option>';
            }
            
            return  $this->PaymentConditionList;
        }else {
            return  $this->GetQuery($query);
        } 
    }
}