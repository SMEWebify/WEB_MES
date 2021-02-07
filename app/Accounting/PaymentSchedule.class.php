<?php

namespace App\Accounting;
use \App\SQL;

class PaymentSchedule Extends SQL  {

    Public $PaymentScheduleList;

    public function NewPaymentSchedule($CODE, $LABEL){
        $NewPaymentSchedule = $this->GetInsert("INSERT INTO ". TABLE_ERP_ECHEANCIER_TYPE ." VALUE ('0',
                                                                                                '". addslashes($CODE) ."',
                                                                                                '". addslashes($LABEL) ."')");
        return $NewPaymentSchedule;
    }

    public function GETPaymentScheduleList($IdData=0, $Select = true){
        $this->PaymentScheduleList = '';
        $query='SELECT id, CODE, LABEL FROM '. TABLE_ERP_ECHEANCIER_TYPE .'';
        
        if($Select){
            foreach ( $this->GetQuery($query) as $data){
                $this->PaymentScheduleList .='<option value="'. $data->id .'" '. selected($IdData, $data->id) .'>'. $data->LABEL .'</option>';
            }
        
            return  $this->PaymentScheduleList;
        }else {
            return  $this->GetQuery($query);
        } 
    }
}

class PaymentScheduleLine Extends PaymentSchedule  {

    Public $PaymentScheduleLineList;

    public function NewPaymentScheduleLine($PaymentScheduleID, $LABEL, $Percent, $VATRate, $PaymentConditionID,$PaymentMethodID, $Delay){
        $NewPaymentScheduleLine = $this->GetInsert("INSERT INTO ". TABLE_ERP_ECHEANCIER_TYPE_LIGNE ." VALUE ('0',
                                                                                                    '". addslashes($PaymentScheduleID) ."',
                                                                                                    '". addslashes($LABEL) ."',
                                                                                                    '". addslashes($Percent) ."',
                                                                                                    '". addslashes($VATRate) ."',
                                                                                                    '". addslashes($PaymentConditionID) ."',
                                                                                                    '". addslashes($PaymentMethodID) ."',
                                                                                                    '". addslashes($Delay) ."')");
        return $NewPaymentScheduleLine;
    }

    public function GETPaymentScheduleLineList($IdData=0, $Select = true){
        $this->PaymentScheduleLineList = '';
        $query='SELECT '. TABLE_ERP_ECHEANCIER_TYPE_LIGNE .'.id,
                        '. TABLE_ERP_ECHEANCIER_TYPE_LIGNE .'.ECHEANCIER_ID,
                        '. TABLE_ERP_ECHEANCIER_TYPE_LIGNE .'.LABEL,
                        '. TABLE_ERP_ECHEANCIER_TYPE_LIGNE .'.POURC_MONTANT,
                        '. TABLE_ERP_ECHEANCIER_TYPE_LIGNE .'.POURC_TVA,
                        '. TABLE_ERP_ECHEANCIER_TYPE_LIGNE .'.CONDI_REG_ID,
                        '. TABLE_ERP_ECHEANCIER_TYPE_LIGNE .'.MODE_REG_ID,
                        '. TABLE_ERP_ECHEANCIER_TYPE_LIGNE .'.DELAI
                        FROM `'. TABLE_ERP_ECHEANCIER_TYPE_LIGNE .'`
                            WHERE '. TABLE_ERP_ECHEANCIER_TYPE_LIGNE .'.ECHEANCIER_ID = \''. 	addslashes($IdData).'\'
                        ORDER BY id';
        
        if($Select){
            foreach ( $this->GetQuery($query) as $data){
                $this->PaymentScheduleLineList .='<option value="'. $data->id .'" '. selected($IdData, $data->id) .'>'. $data->LABEL .'</option>';
            }
        
            return  $this->PaymentScheduleLineList;
        }else {
            return  $this->GetQuery($query);
        } 
    }
}